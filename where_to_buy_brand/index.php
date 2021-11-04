<?
define('NOINNER', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Где купить │ Группа компаний Терморос");
$APPLICATION->SetPageProperty("description", "Где купить – адреса и телефоны представительств и партнёров Группы компаний Терморос.");
$APPLICATION->SetTitle("Где купить");
?><?
	$SECTION_ID = 0;
	$sects = getSections(18); 
	if($sects['CURRENTCITY_ID']) 
	{
		$SECTION_ID = $sects['CURRENTCITY_ID'];
		
	}
	if($_REQUEST['ID']) 
	{
		$SECTION_ID = $_REQUEST['ID'];
	}
	if($_REQUEST['city']) 
	{
		$SECTION_ID = $_REQUEST['city'];
	}
	
	if (!$SECTION_ID) $SECTION_ID = 351;
	
	$elCount = $APPLICATION->IncludeComponent("bitrix:catalog.section", "custom-map-brands", array(
	"SECTS" => $sects,
	"IBLOCK_TYPE" => "services",
	"IBLOCK_ID" => "18",
	"SECTION_ID" => $SECTION_ID,
	"SECTION_CODE" => "",
	"SECTION_USER_FIELDS" => array("UF_LONLAT"),
	"ELEMENT_SORT_FIELD" => "SORT",
	"ELEMENT_SORT_ORDER" => "asc",
	"ELEMENT_SORT_FIELD2" => "PROPERTY_CLEAR_NAME",
	"ELEMENT_SORT_ORDER2" => "asc",
	"FILTER_NAME" => "arrFilter",
	"INCLUDE_SUBSECTIONS" => "Y",
	"SHOW_ALL_WO_SECTION" => "N",
	"HIDE_NOT_AVAILABLE" => "N",
	"PAGE_ELEMENT_COUNT" => "199",
	"LINE_ELEMENT_COUNT" => "1",
	"PROPERTY_CODE" => array(
		0 => "ON_MAP",
		1 => "ADDRESS",
		2 => "PHONE",
		3 => "SITE",
		4 => "WORK_TIME",
		5 => "METRO",
		6 => "BRANDS",
		7 => "DETAIL_PICTURE"
	),
	"OFFERS_LIMIT" => "5",
	"SECTION_URL" => "",
	"DETAIL_URL" => "",
	"BASKET_URL" => "/personal/basket.php",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"PRODUCT_QUANTITY_VARIABLE" => "quantity",
	"PRODUCT_PROPS_VARIABLE" => "prop",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "N",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"META_KEYWORDS" => "-",
	"META_DESCRIPTION" => "-",
	"BROWSER_TITLE" => "-",
	"ADD_SECTIONS_CHAIN" => "N",
	"DISPLAY_COMPARE" => "N",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"CACHE_FILTER" => "N",
	"PRICE_CODE" => array(
	),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"PRODUCT_PROPERTIES" => array(
	),
	"USE_PRODUCT_QUANTITY" => "N",
	"CONVERT_CURRENCY" => "N",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Товары",
	"PAGER_SHOW_ALWAYS" => "Y",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "Y",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>