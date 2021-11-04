<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Настройки пользователя");
?><?$APPLICATION->IncludeComponent("bitrix:main.profile", "eshop", Array(
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>