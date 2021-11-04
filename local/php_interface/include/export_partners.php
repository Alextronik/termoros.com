<?
$_SERVER["DOCUMENT_ROOT"] = "/home/bitrix/www";
if($_SERVER['HOME'] == '/home/tmrsite') $_SERVER["DOCUMENT_ROOT"] = "/var/www/termoros";
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
Loader::includeModule('main');
Loader::includeModule('iblock');
Loader::includeModule('highloadblock');
Loader::includeModule('catalog');

$hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
\Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData);
$res = BrendTable::getList()->fetchAll();
$brandArr = [];
foreach($res as $k=>$propertyBrandValueId)
{
	$brandArr[$propertyBrandValueId['UF_XML_ID']] = $propertyBrandValueId["UF_NAME"];
}

$file_csv = $_SERVER['DOCUMENT_ROOT'].'/bitrix/catalog_export/export_partners_prices.csv';
$fh = fopen($file_csv, 'w');
$str0 = ['XML_ID','NAME','DETAIL_PAGE_URL','DETAIL_PICTURE','BRAND','ARTICLE','CATEGORY','QUANTITY_CENTRAL_WAREHOUSE','RETAIL_PRICE','RECOMMENDED_PRICE'];
fputcsv($fh, $str0,';');

$dbItem = \Bitrix\Iblock\ElementTable::getList(array(
    'select' => array('*','DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL'),
    'filter' => array('IBLOCK_ID' => 4, "ACTIVE"=>"Y"),
    'cache' => array('ttl' => 86400,'cache_joins' => true,)
    //'limit' => 20,
))->fetchAll();

foreach ($dbItem as $k=>$el)
{
    // create page url
    $el['DETAIL_PAGE_URL'] = CIBlock::ReplaceDetailUrl($el['DETAIL_PAGE_URL'], $el, false, 'E');

    // DETAIL_PICTURE
    if ($el["DETAIL_PICTURE"]){
		$el["DETAIL_PICTURE_PATH"] = 'https://www.termoros.com'.CFile::GetPath($el["DETAIL_PICTURE"]);
	} else $el["DETAIL_PICTURE_PATH"] = "---";

    // DETAIL_PAGE_URL
    if ($el["DETAIL_PAGE_URL"]){
        $el["DETAIL_PAGE_URL"] = 'https://www.termoros.com'.$el["DETAIL_PAGE_URL"];
    } else $el["DETAIL_PAGE_URL"] = "---";

    // prices
    $price_2 = 0;
    $price_3 = 0;
    $allProductPrices = \Bitrix\Catalog\PriceTable::getList([
        "select" => ["*"],
        "filter" => ["=PRODUCT_ID" => $el['ID']],
        "order" => ["CATALOG_GROUP_ID" => "ASC"],
        'cache' => array('ttl' => 3600,'cache_joins' => true)
    ])->fetchAll();
    foreach ($allProductPrices as $k=>$v){
        if($v['CATALOG_GROUP_ID'] == "2"){
            $price_2 = $v['PRICE'];
        }elseif($v['CATALOG_GROUP_ID'] == "3"){
            $price_3 = $v['PRICE'];
        }
    }

    // quantity
    $rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
        'filter' => array('=PRODUCT_ID'=>$el['ID'],'=STORE_ID'=>208),
        'limit' => 1,
        'select' => array('AMOUNT'),
        'cache' => array('ttl' => 3600,'cache_joins' => true,)
    ))->fetchAll();

    // category
    $nav = CIBlockSection::GetNavChain(4,$el["IBLOCK_SECTION_ID"]);
    $arSection = [];
    while($arSectionPath = $nav->GetNext()){
        $arSection[] = $arSectionPath['NAME'];
    }
    $category = implode(" > ",$arSection);

    // NAME
    $name = htmlspecialcharsBack($el["NAME"]);

    // PROPS
    $props = \Bitrix\Iblock\Elements\ElementCatalogTable::getByPrimary($el['ID'], ['select' => ['BREND','CML2_ARTICLE'],])->fetch();

    $str = [$el["XML_ID"],$name,$el["DETAIL_PAGE_URL"],$el["DETAIL_PICTURE_PATH"],$brandArr[$props['IBLOCK_ELEMENTS_ELEMENT_CATALOG_BREND_VALUE']],$props["IBLOCK_ELEMENTS_ELEMENT_CATALOG_CML2_ARTICLE_VALUE"],$category,$rsStoreProduct[0]['AMOUNT'],$price_2,$price_3];
    fputcsv($fh, $str,';');
}
fclose($fh);
