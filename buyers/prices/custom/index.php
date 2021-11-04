<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Прайс-листы – Скачать прайсы на инженерное оборудование │ Группа компаний Терморос");
$APPLICATION->SetPageProperty("description", "Прайс-листы на инженерное оборудование можно скачать в формате PDF на сайте Терморос. Актуальные цены. Фильтр по производителям и виду продукции.");
$APPLICATION->SetTitle("Прайс-листы");
?>
<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/PHPExcel_1.8.0_doc/custom_price.php');
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>