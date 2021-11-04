<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Склады");

require($_SERVER["DOCUMENT_ROOT"]."/include/cdek/cdek.php");
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<?
/*
die();
?>
<div class="detail_page">
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.recommended.products", 
	"recommended_products", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADDITIONAL_PICT_PROP_4" => "MORE_PHOTO",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CART_PROPERTIES_4" => array(
			0 => "",
			1 => "",
		),
		"CODE" => $_REQUEST["PRODUCT_CODE"],
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "1c_catalog",
		"ID" => $_REQUEST["PRODUCT_ID"],
		"LABEL_PROP_4" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MIN_BUYES" => "2",
		"PAGE_ELEMENT_COUNT" => "10",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "СлужебноеДляСайта (розничные цены)",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE_4" => array(
			0 => "",
			1 => "",
		),
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_IMAGE" => "Y",
		"SHOW_NAME" => "Y",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "recommended_products",
		"WATCHED" => "Y"
	),
	false
);?>
</div>
*/ ?>