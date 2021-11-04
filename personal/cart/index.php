<?
define('NOINNER', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?><?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "basket_big", array(
	"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
	"COLUMNS_LIST" => array(
		0 => "NAME",
		1 => "DISCOUNT",
		2 => "PRICE",
		3 => "QUANTITY",
		4 => "SUM",
		5 => "PROPS",
		6 => "DELETE",
		7 => "DELAY",
	),
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"PATH_TO_ORDER" => "/personal/order/make/",
	"HIDE_COUPON" => "N",
	"QUANTITY_FLOAT" => "N",
	"PRICE_VAT_SHOW_VALUE" => "Y",
	"TEMPLATE_THEME" => "site",
	"ACTION_VARIABLE" => "action",
	"SET_TITLE" => "Y",
	"AJAX_OPTION_ADDITIONAL" => "",
	"USE_GIFTS" => "N",
	
	),
	false
);?>
<br>
<div class="gift">
<p>«Окончательный состав и стоимость заказа, сроки поставки будут отражаться в отправляемом в ответ на заявку счете. Предложение не является офертой. Цены на сайте и в розничной сети могут отличаться. Информация на сайте о товаре носит рекламный характер и расценивается как приглашение делать оферты на основании п. 1 ст. 437 Гражданского кодекса РФ.»</p><br>&nbsp;</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>