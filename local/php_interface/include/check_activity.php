<?php
/**
 * Created by PhpStorm.
 * User: Jager
 * Date: 29.09.2020
 * Time: 12:28
 */
$_SERVER["DOCUMENT_ROOT"] = "/home/bitrix/www";
if($_SERVER['HOME'] == '/home/tmrsite') $_SERVER["DOCUMENT_ROOT"] = "/var/www/termoros";
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader, Termoros\Main;
Loader::includeModule('main');
Loader::includeModule('iblock');
Loader::includeModule('catalog');

// get all products(ID, XML_ID)
$allProducts = \Bitrix\Iblock\ElementTable::getList(array(
    'select' => array('ID','XML_ID','ACTIVE'),
    'filter' => array('IBLOCK_ID' => 4),
    'cache' => array(
        'ttl' => 0,
        'cache_joins' => true
    ),
))->fetchAll();
//var_dump(array_shift($allProducts));

// get all elements from price.xml
$objXmlDocument = simplexml_load_file($_SERVER["DOCUMENT_ROOT"].'/1c-services/data/prices.xml');

if ($objXmlDocument === FALSE) {
    echo "There were errors parsing the XML file.\n";
    foreach(libxml_get_errors() as $error) {
        echo $error->message;
    }
    exit;
}

$objJsonDocument = json_encode($objXmlDocument);
$arrOutput = json_decode($objJsonDocument, TRUE);
$arPrices = [];
foreach ($arrOutput['A'] as $atr){
    $arPrices[$atr['@attributes']['Id']] = $atr['@attributes'];
}

// foreach $allProducts & set active
$el = new CIBlockElement;
foreach($allProducts as $k=>$v)
{
    // if product not found in $arPrices - deactivate
    if(!array_key_exists($v['XML_ID'], $arPrices) && $v['ACTIVE'] == 'Y'){
        //echo $v['ID'] . " - to deactivate<br>";
        $el->Update($v['ID'],['ACTIVE'=>'N']);
    // if product found in $arPrices - activate
    }elseif(array_key_exists($v['XML_ID'], $arPrices) && $v['ACTIVE'] == 'N'){
        //echo $v['ID'] . " - need set active<br>";
        $el->Update($v['ID'],['ACTIVE'=>'Y']);
    }else{
        if($v['ACTIVE'] == 'Y'){
            $allProductPrices = \Bitrix\Catalog\PriceTable::getList([
                "select" => ["*"],
                "filter" => ["=PRODUCT_ID" => $v['ID']],
                "order" => ["CATALOG_GROUP_ID" => "ASC"],
                'cache' => array('ttl' => 3600,'cache_joins' => true)
            ])->fetchAll();

            $price_base = false;
            $price_rrc = false;
            foreach ($allProductPrices as $kk=>$vv){
                if($vv['CATALOG_GROUP_ID'] == "2"){
                    $price_base = $vv['PRICE'];
                }elseif($vv['CATALOG_GROUP_ID'] == "3"){
                    $price_rrc = $vv['PRICE'];
                }
            }

            if($price_base < 0.01) {
                //echo $v['ID']. "<br>";
                $el->Update($v['ID'],['ACTIVE'=>'N']);
            }
        }
    }
}

// UPD APPROVED PROPS TO HL
Main::updPropsTable();


// AFTER UPDATE FASET INDEX
Main::reindexCatalogFaset(4);





