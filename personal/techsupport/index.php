<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Техническая поддержка");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:support.ticket", 
	"tech", 
	array(
		"COMPONENT_TEMPLATE" => "tech",
		"MESSAGES_PER_PAGE" => "20",
		"MESSAGE_MAX_LENGTH" => "70",
		"MESSAGE_SORT_ORDER" => "asc",
		"SEF_FOLDER" => "/personal/techsupport/",
		"SEF_MODE" => "N",
		"SET_PAGE_TITLE" => "N",
		"SET_SHOW_USER_FIELD" => array(
		),
		"SHOW_COUPON_FIELD" => "N",
		"TICKETS_PER_PAGE" => "50",
		"VARIABLE_ALIASES" => array(
			"ID" => "ID",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>