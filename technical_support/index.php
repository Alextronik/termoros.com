<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
LocalRedirect('/technical_support/tech_documentation/');
$APPLICATION->SetPageProperty("description", "В технической поддержке собрана вся информация, которая может понадобиться вам для изучения или продажи нашего оборудования.");
$APPLICATION->SetPageProperty("title", "Техническая поддержка │ Группа компаний Терморос");
$APPLICATION->SetTitle("Техническая поддержка");
?>
<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/include/techsupp.php"), false);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>