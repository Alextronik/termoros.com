<?
define('LEFTBAR', 'Y');
define('FILTER_PHOTO', 'Y');
define('NOMENU', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Фотографии. Международная группа компаний «Терморос» предлагает заказать промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetPageProperty("title", "Фотографии | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "фотографии инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetTitle("Фотографии");
?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"promo-photo-tpl", 
	array(		
	"IBLOCK_TYPE" => "promotion_materials",
	"IBLOCK_ID" => "33",
	"SECTION_ID" => "",
	"SECTION_CODE" => "",
	"SECTION_USER_FIELDS" => array(),
	"ELEMENT_SORT_FIELD" => $_GET['sort'] ? $_GET['sort'] : "SORT",
	"ELEMENT_SORT_ORDER" => $_GET['order'] ? $_GET['order'] : "DESC",
	"ELEMENT_SORT_FIELD2" => "",
	"ELEMENT_SORT_ORDER2" => "",
	"FILTER_NAME" => "arrFilter",			
	"INCLUDE_SUBSECTIONS" => "Y",
	"SHOW_ALL_WO_SECTION" => "Y",
	"HIDE_NOT_AVAILABLE" => "N",
	"PAGE_ELEMENT_COUNT" => $_GET['view'] ? $_GET['view'] : "15",
	"LINE_ELEMENT_COUNT" => "1",
	"PROPERTY_CODE" => array('FILES'),
	"OFFERS_LIMIT" => "0",
	"TEMPLATE_THEME" => "",
	"PRODUCT_SUBSCRIPTION" => "N",
	"SHOW_DISCOUNT_PERCENT" => "N",
	"SHOW_OLD_PRICE" => "N",
	"MESS_BTN_BUY" => "Купить",
	"MESS_BTN_ADD_TO_BASKET" => "В корзину",
	"MESS_BTN_SUBSCRIBE" => "Подписаться",
	"MESS_BTN_DETAIL" => "Подробнее",
	"MESS_NOT_AVAILABLE" => "Нет в наличии",
	"SECTION_URL" => "",
	"DETAIL_URL" => "",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"SET_META_KEYWORDS" => "N",
	"META_KEYWORDS" => "",
	"SET_META_DESCRIPTION" => "N",
	"META_DESCRIPTION" => "",
	"BROWSER_TITLE" => "-",
	"ADD_SECTIONS_CHAIN" => "N",
	"DISPLAY_COMPARE" => "N",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"CACHE_FILTER" => "Y",
	"PRICE_CODE" => array(
	),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"CONVERT_CURRENCY" => "N",
	"BASKET_URL" => "/personal/basket.php",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"USE_PRODUCT_QUANTITY" => "N",
	"ADD_PROPERTIES_TO_BASKET" => "Y",
	"PRODUCT_PROPS_VARIABLE" => "prop",
	"PARTIAL_PRODUCT_PROPERTIES" => "N",
	"PRODUCT_PROPERTIES" => array(),
	"PAGER_TEMPLATE" => "",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Товары",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"OFFERS_FIELD_CODE" => array(),
	"OFFERS_PROPERTY_CODE" => array(),
	"OFFERS_SORT_FIELD" => "shows",
	"OFFERS_SORT_ORDER" => "asc",
	"OFFERS_SORT_FIELD2" => "shows",
	"OFFERS_SORT_ORDER2" => "asc",
	"COMPONENT_TEMPLATE" => "sect-tpl",
	"AJAX_OPTION_ADDITIONAL" => "",
	"SET_BROWSER_TITLE" => "Y",
	"PRODUCT_QUANTITY_VARIABLE" => "",
	"OFFERS_CART_PROPERTIES" => array()
	),
	false
	);	
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>