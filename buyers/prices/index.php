<?
define('LEFTBAR', 'Y');
define('NOMENU', 'Y');
define('FILTERPRICE', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Прайс-листы | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "прайс листы инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetPageProperty("description", "Прайс-листы. Международная группа компаний «Терморос» предлагает купить промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetTitle("Прайс-листы");


global $USER;
\Bitrix\Main\Loader::includeModule('redreams.partners');
$isPartner = \Redreams\Partners\partner::isPartner();
//$isPartner = false;
?><!--<h2>
Каталог продукции «ТЕРМОРОС» </h2>
<p>
 <a href="/upload/termoros_catalog_2016.pdf" target="_blank">Скачать каталог Терморос 2016</a> (PDF, 14.1 МБ)
</p>-->
<?/*
<p>
 <b><a href="/buyers/prices/Распродажа оборудования по супервыгодным ценам.ZIP" target="_blank">Распродажа оборудования по супервыгодным ценам</a> (ZIP, 1.8 МБ)</b>
</p>
<p style="font-size:16px;"><b>Указанные в прайс-листах цены являются ориентировочными. Актуальную информацию о ценах и наличии товара на складе можно узнать в <a style="font-size:16px;" href="/catalog/">каталоге товаров</a> или уточнить у менеджеров Группы компаний «Терморос».</b></p>
*/?>
<p style="font-size:16px;"><b>Указанные в прайс-листах цены являются ориентировочными. Цены на сайте и в розничной сети могут отличаться. Информация на сайте о товаре носит рекламный характер и расценивается как приглашение делать оферты на основании п. 1 ст. 437 Гражданского кодекса РФ. Актуальную информацию о ценах и наличии товара можно узнать в <a style="font-size:16px;" href="/catalog/">каталоге товаров</a> или у менеджеров Группы компаний «Терморос» по тел.: <?if($_SESSION['GEOIP']['curr_phones']) { ?><?=$_SESSION['GEOIP']['curr_phones'][0]?><? } else { ?>+7 (499) 500 00 01, +7 (499) 394-33-45<? } ?></b></p>
<?/* if ($_GET['new_price']) {*/ ?>
<? if (file_exists($_SERVER['DOCUMENT_ROOT'].'/buyers/prices/pricelists/pricelist_all.xlsx')) { ?>
	<p ><b><a style="font-size:16px;" target="_blank" href="/buyers/prices/pricelists/pricelist_all.xlsx">Скачать полный прайс-лист Excel (2.2 Мб)</a></b></p>
	<p ><b><a style="font-size:16px;" target="_blank" href="/buyers/prices/custom/">Сформировать прайс-лист <? if ($isPartner) { ?><span style="color:red;">с персональными ценами и остатками</span><? } ?></a></b></p>
<?/* } */?>
<? } ?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"docs-tpl",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COMPONENT_TEMPLATE" => "sect-tpl",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => $_GET['sort']?$_GET['sort']:"SORT",
		"ELEMENT_SORT_FIELD2" => "",
		"ELEMENT_SORT_ORDER" => $_GET['order']?$_GET['order']:"ASC",
		"ELEMENT_SORT_ORDER2" => "",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "15",
		"IBLOCK_TYPE" => "services",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LINE_ELEMENT_COUNT" => "1",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "",
		"META_KEYWORDS" => "",
		"OFFERS_CART_PROPERTIES" => array(),
		"OFFERS_FIELD_CODE" => array(),
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array(),
		"OFFERS_SORT_FIELD" => "shows",
		"OFFERS_SORT_FIELD2" => "shows",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "asc",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => $_GET['view']?$_GET['view']:"15",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICES" => "Y",
		"PRICE_CODE" => array(),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array('FILES'),
		"SECTION_CODE" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(),
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>