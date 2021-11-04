<?
$_SERVER['DOCUMENT_ROOT'] = '/home/bitrix/www';
if($_SERVER['HOME'] == '/home/tmrsite') {$_SERVER["DOCUMENT_ROOT"] = "/var/www/termoros";}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
//ini_set("memory_limit",1024);
use Bitrix\Main\Loader;
Loader::includeModule('main');
Loader::includeModule('iblock');
Loader::includeModule('highloadblock');
Loader::includeModule('catalog');

$hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
\Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData);
$res = BrendTable::getList()->fetchAll();
foreach($res as $k=>$propertyBrandValueId)
{
    $brandArr[$propertyBrandValueId['UF_XML_ID']] = $propertyBrandValueId["UF_NAME"];
}

// get props
$props_arr = [];
$props_used = \Termoros\Main::getPropsTableHL(false);
$arProps = \Bitrix\Iblock\PropertyTable::getList(array(
    'order' => array('ID' => "asc"),
    'select' => array('*'),
    'filter' => array('IBLOCK_ID' => 4,'ACTIVE' => 'Y','=PROPERTY_TYPE'=>[\Bitrix\Iblock\PropertyTable::TYPE_LIST,\Bitrix\Iblock\PropertyTable::TYPE_STRING,\Bitrix\Iblock\PropertyTable::TYPE_NUMBER]),
    'cache' => array('ttl' => 86400,'cache_joins' => true)
))->fetchAll();

foreach($arProps as $k=>$prop_fields)
{
    $prop_type = array("S","N","L");
    if(in_array($prop_fields["ID"],$props_used)){
        $props_arr[$prop_fields["NAME"]."(".$prop_fields["ID"].")"] = $prop_fields["ID"];
    }
}

$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/bitrix/catalog_export/export_partners_full.csv', 'w');
$str0 = ["XML_ID","NAME","DETAIL_PAGE_URL","DETAIL_PICTURE","BRAND","ARTICLE","RETAIL_PRICE","RECOMMENDED_PRICE","CATEGORY",'QUANTITY_CENTRAL_WAREHOUSE'];
$str0 = array_merge($str0,array_keys($props_arr));
fputcsv($fh, $str0,';');

$dbItem = \Bitrix\Iblock\ElementTable::getList(array(
    'select' => array('*','DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL'),
    'filter' => array('IBLOCK_ID' => 4, "ACTIVE"=>"Y"),
    'cache' => array('ttl' => 86400,'cache_joins' => true),
    //'limit' => 10
))->fetchAll();

// get props
$propsValAr = \Termoros\Main::getPropsTypeL();

foreach($dbItem as $k=>$el)
{
    // create page url
    $el['DETAIL_PAGE_URL'] = CIBlock::ReplaceDetailUrl($el['DETAIL_PAGE_URL'], $el, false, 'E');

    //var_dump($propsValAr);
    $array_props_val = [];
    $db_props = CIBlockElement::GetProperty(4, $el["ID"], array("ID"=>"asc"),array('ACTIVE' => 'Y'));
	while($ar_prop = $db_props->GetNext())
	{
		if (in_array($ar_prop["ID"], $props_arr))//   in_array($ar_prop["ID"], $props_arr)      $prop_fields["NAME"]."(".$prop_fields["ID"].")"
		{
            if($ar_prop["PROPERTY_TYPE"] == "S" || $ar_prop["PROPERTY_TYPE"] == "N"){
                $array_props_val[] = $ar_prop["VALUE"];
            }elseif($ar_prop["PROPERTY_TYPE"] == "L"){
                if(!preg_match('/^(?:\d\,)+$/', $propsValAr[$ar_prop["VALUE"]]['VALUE'])) {
                    $propsValAr[$ar_prop["VALUE"]]['VALUE'] = str_replace(',', '.', $propsValAr[$ar_prop["VALUE"]]['VALUE']);
                }
                $array_props_val[] = $propsValAr[$ar_prop["VALUE"]]['VALUE'];
            }
		}
	}
	//var_dump($array_props_val);

	if ($el["DETAIL_PICTURE"]){
		$el["DETAIL_PICTURE_PATH"] = 'https://www.termoros.com'.CFile::GetPath($el["DETAIL_PICTURE"]);
	}
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
        'cache' => array('ttl' => 3600,'cache_joins' => true)
    ))->fetchAll();
    //var_dump($rsStoreProduct);

    // category
    $nav = CIBlockSection::GetNavChain(4,$el["IBLOCK_SECTION_ID"]);
    $arSection = [];
    while($arSectionPath = $nav->GetNext()){
        $arSection[] = $arSectionPath['NAME'];
    }
    $category = implode(" > ",$arSection);

    $name = htmlspecialcharsBack($el["NAME"]);

    // PROPS BREND & CML2_ARTICLE
    $props = \Bitrix\Iblock\Elements\ElementCatalogTable::getByPrimary($el['ID'], ['select' => ['BREND','CML2_ARTICLE'],])->fetch();
    //var_dump($brandArr[$props['IBLOCK_ELEMENTS_ELEMENT_CATALOG_BREND_VALUE']],$props["IBLOCK_ELEMENTS_ELEMENT_CATALOG_CML2_ARTICLE_VALUE"]);

    $str = [$el["XML_ID"],$name,$el["DETAIL_PAGE_URL"],$el["DETAIL_PICTURE_PATH"],$brandArr[$props['IBLOCK_ELEMENTS_ELEMENT_CATALOG_BREND_VALUE']],$props["IBLOCK_ELEMENTS_ELEMENT_CATALOG_CML2_ARTICLE_VALUE"],$price_2,$price_3,$category,$rsStoreProduct[0]['AMOUNT']];
    $str = array_merge($str,$array_props_val);
    fputcsv($fh, $str,';');
}
fclose($fh);




