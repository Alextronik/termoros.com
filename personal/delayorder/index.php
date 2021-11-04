<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отложенные заказы");
?><?$APPLICATION->IncludeComponent("bitrix:sale.personal.order", "delay", array(
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "/personal/delayorder/",
	"ORDERS_PER_PAGE" => "10",
	"PATH_TO_PAYMENT" => "",
	"PATH_TO_BASKET" => "",
	"SET_TITLE" => "N",
	"SAVE_IN_SESSION" => "N",
	"NAV_TEMPLATE" => "modern",
	"SEF_URL_TEMPLATES" => array(
		"list" => "index.php",
		"detail" => "?ID=#ID#",
		"cancel" => "?ID=#ID#&action=cancel",
	),
	"SHOW_ACCOUNT_NUMBER" => "Y"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>