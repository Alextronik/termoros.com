<?
define('NOINNER', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Контакты | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "контакты инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetPageProperty("description", "Контакты международной группы компаний «Терморос». Предлагаем купить промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetTitle("Контакты");
?><?
	$SECTION_ID = 0;
	$sects = getSections(22, 'SORT'); 
		
	$BIGSCALE = "Y";
	if($sects['CURRENTCITY_ID']) 
	{
		$SECTION_ID = $sects['CURRENTCITY_ID'];
		$BIGSCALE = "";
	}
	
	if($_REQUEST['city']) 
	{
		$SECTION_ID = $_REQUEST['city'];
		$BIGSCALE = "";
	}
	
	if (isset($_REQUEST['city']) && $_REQUEST['city'] == "")
	{
		$SECTION_ID = 0;
		$BIGSCALE = "Y";
	}

	$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"custom-map", 
	array(
		"BIGSCALE" => $BIGSCALE,
		"SECTS" => $sects,
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "22",
		"SECTION_ID" => $SECTION_ID,
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_LONLAT",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => "SORT",
		"ELEMENT_SORT_ORDER" => "ASC",
		"ELEMENT_SORT_FIELD2" => "",
		"ELEMENT_SORT_ORDER2" => "",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"PAGE_ELEMENT_COUNT" => "199",
		"LINE_ELEMENT_COUNT" => "1",
		"PROPERTY_CODE" => array(
			0 => "ADDRESS",
			1 => "WORK_TIME",
			2 => "METRO",
			3 => "ON_MAP",
			4 => "SITE",
			5 => "PHONE",
			6 => "EMAIL",
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
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "custom-map",
		"BACKGROUND_IMAGE" => "-",
		"SEF_MODE" => "N",
		"SEF_RULE" => "#SECTION_ID#",
		"SECTION_CODE_PATH" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>