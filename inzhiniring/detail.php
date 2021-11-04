<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?><?$elId = $APPLICATION->IncludeComponent(
	"bitrix:catalog.element", 
	"inzhiniring", 
	array(
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "11",
		"ELEMENT_ID" => $_REQUEST["ID"],
		"ELEMENT_CODE" => $_REQUEST["CODE"],
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
		"HIDE_NOT_AVAILABLE" => "N",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "SLIDER_PIC",
		),
		"OFFERS_LIMIT" => "0",
		"TEMPLATE_THEME" => "blue",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"DISPLAY_NAME" => "Y",
		"DETAIL_PICTURE_MODE" => "IMG",
		"ADD_DETAIL_TO_SLIDER" => "N",
		"DISPLAY_PREVIEW_TEXT_MODE" => "E",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"DISPLAY_COMPARE" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_BTN_COMPARE" => "Сравнение",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"USE_VOTE_RATING" => "N",
		"USE_COMMENTS" => "N",
		"BRAND_USE" => "N",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "N",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"SET_TITLE" => "Y",
		"SET_STATUS_404" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"USE_ELEMENT_COUNTER" => "Y",
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"LINK_IBLOCK_TYPE" => "",
		"LINK_IBLOCK_ID" => "",
		"LINK_PROPERTY_SID" => "",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity"
	),
	false
);?>
<? // для частных клиентов ?>
<? if ($elId == 19849) { ?>
	<div id="zayavkanaproektirovanie">
	<?$APPLICATION->IncludeComponent(
		"bitrix:form.result.new",
		".default",
		Array(
			"WEB_FORM_ID" => "11",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"USE_EXTENDED_ERRORS" => "N",
			"SEF_MODE" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"SHOW_ERROR_LIST" => "Y",
			"LIST_URL" => "",
			"EDIT_URL" => "",
			"SUCCESS_URL" => "/inzhiniring/vasha-zayavka-otpravlena.php",
			"CHAIN_ITEM_TEXT" => "",
			"CHAIN_ITEM_LINK" => "",
			"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",)
		)
	);?>
	</div>
<? } ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>