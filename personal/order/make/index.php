<?
define('NOINNER', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
\Bitrix\Main\Loader::includeModule('redreams.partners');
?><?/*$APPLICATION->IncludeComponent("bitrix:sale.order.ajax", "", array(
	"PAY_FROM_ACCOUNT" => "Y",
	"COUNT_DELIVERY_TAX" => "N",
	"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
	"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
	"ALLOW_AUTO_REGISTER" => "Y",
	"SEND_NEW_USER_NOTIFY" => "Y",
	"DELIVERY_NO_AJAX" => "N",
	"TEMPLATE_LOCATION" => "popup",
	"PROP_1" => array(
	),
	"PATH_TO_BASKET" => "/personal/cart/",
	"PATH_TO_PERSONAL" => "/personal/order/",
	"PATH_TO_PAYMENT" => "/personal/order/payment/",
	"PATH_TO_ORDER" => "/personal/order/make/",
	"SET_TITLE" => "Y" ,
	"DELIVERY2PAY_SYSTEM" => Array(),
	"SHOW_ACCOUNT_NUMBER" => "Y",
	"DELIVERY_NO_SESSION" => "Y"
	),
	false
);*/?>

<?$APPLICATION->IncludeComponent(
	"redreams:sale.order.ajax",
	"termoros",
	array(
		"PAY_FROM_ACCOUNT" => "Y",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"ALLOW_AUTO_REGISTER" => "Y",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"DELIVERY_NO_AJAX" => "Y",
		"TEMPLATE_LOCATION" => "popup",
		"PROP_1" => array(
		),
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_PERSONAL" => "/personal/order/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PATH_TO_ORDER" => "/personal/order/make/",
		"SET_TITLE" => "Y",
		"DELIVERY2PAY_SYSTEM" => "",
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"DELIVERY_NO_SESSION" => "Y",
		"COMPONENT_TEMPLATE" => "termoros",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"USE_PREPAYMENT" => "N",
		"PROP_2" => array(
		),
		"ALLOW_NEW_PROFILE" => \Redreams\Partners\partner::isPartner() ? "N" : "Y",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "N",
		"PATH_TO_AUTH" => "/auth/",
		"DISABLE_BASKET_REDIRECT" => "N",
		"PRODUCT_COLUMNS" => array(
			0 => "PROPERTY_FOR_ORDER",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>