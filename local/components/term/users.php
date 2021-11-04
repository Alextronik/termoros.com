<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
/** @var TYPE_NAME $APPLICATION */
$APPLICATION->SetPageProperty("title", "USERS");
/*
реализовать публичный компонент с применением технологий ядра D7, который выводит список зарегистрированных пользователей с постраничной навигацией.

Постраничная навигация должна осуществляться Ajax-ом

Компонент должен работать на любом сайте с битриксом.

Сделать возможность выгрузки пользователей в csv, xml формат

Компонент должен корректно работать с базой пользователей 100 000 + (при выгрузках в xml и csv не должно быть падений по памяти и по таймауту)
*/
?>

<?$APPLICATION->IncludeComponent(
	"test:uc_users", 
	".default", 
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"USERS_ADD" => "Y",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>