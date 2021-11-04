<?php
namespace Termoros;

use Bitrix\Main\Loader, Termoros\Main;

class MakeCSV extends \CModule
{
    private $partner;
    protected $productsDiscountId;
    protected $allProductsDiscountPrice;

    function __construct($partner_code)
    {
        ini_set('memory_limit', '1024M');
        Loader::includeModule("iblock");
        Loader::includeModule("highloadblock");
        $this->checkPartner($partner_code);
        $this->productsDiscountId = $this->getProductsDiscountId();// discountId for all products
        $this->allProductsDiscountPrice = $this->getAllProductsDiscountPrice();// discount price for all products
    }

    function getJson()
    {
        $csv = $this->makeFile();
        $array = array_map("str_getcsv", explode("\n", $csv));
        $json = json_encode($array);
        print_r($json);
    }

    function downloadCSV()
    {
        if (ob_get_level()) {
            ob_end_clean();
        }
        $file = $this->makeFile();
        header ("Content-Type: application/octet-stream");
        header ("Content-disposition: attachment; filename=export_partners_prices_personal.csv");
        echo $file;
        exit();
    }

    function makeFile()
    {
        //var_dump($this->partner);
        //var_dump($this->productsDiscountId);
        //var_dump($this->allProductsDiscountPrice);

        $a = file($_SERVER['DOCUMENT_ROOT'].'/bitrix/catalog_export/export_partners_prices.csv');// get array of lines
        $file = '';
        $i = 0;
        foreach($a as $line){
            $line = trim($line);// remove end of line
            if($i === 0){
                $line .=";PERSONAL_PRICE";// append new column
            }else{
                $csvAr = str_getcsv($line,";");
                $line .=";".$this->getProductPrice($csvAr[0],$csvAr[8]);// append new column
            }
            $file .= $line.PHP_EOL;//append end of line
            $i++;
        }
        return $file;
    }

    function checkPartner($partnerCode)
    {
        global $USER;
        $find_user = \CUser::GetList($by,$order,['XML_ID'=>$partnerCode])->fetch();
        if($find_user['XML_ID'] == $partnerCode && in_array(11,\CUser::GetUserGroup($find_user['ID']))){
            $USER->Authorize($find_user['ID']);
            $this->partner = $find_user;
        }else exit("NEED AUTH PARTNER");
    }

    function getProductPrice($prod_xml_id,$base_price)
    {
        $discountPrice = $base_price;
        if($this->productsDiscountId[$prod_xml_id]) {
            $discount = $this->allProductsDiscountPrice[$this->productsDiscountId[$prod_xml_id]];
            $discountSum = round($base_price*($discount/100),2);
            $discountPrice = round(($base_price - $discountSum),2);
        }
        return $discountPrice;
    }

    function getProductsDiscountId()
    {
        $dbItem = \Termoros\Main::getAllProducts();
        $arProducts = [];
        foreach($dbItem as $k=>$v){
            $props = \Bitrix\Iblock\Elements\ElementCatalogTable::getByPrimary($v['ID'], ['select' => ["TSENOVAYA_GRUPPA"]])->fetch();
            $arProducts[$v['XML_ID']] = $props["IBLOCK_ELEMENTS_ELEMENT_CATALOG_TSENOVAYA_GRUPPA_VALUE"];
        }
        return $arProducts;
    }

    function getAllProductsDiscountPrice()
    {
        $result = \Termoros\Main::getPriceMatrix($this->partner['XML_ID']);

        $discounts = [];

        if (!empty($result)) {
            foreach($result as $k=>$discount)
            {
                $discounts[$discount['UF_PRICE_GROUP']] = $discount['UF_DISCOUNT_VALUE'];
            }
        }
        return $discounts;
    }
}