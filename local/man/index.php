<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
define("NO_KEEP_STATISTIC", true);
define('BX_NO_ACCELERATOR_RESET', true);
/** @var TYPE_NAME $APPLICATION */
$APPLICATION->SetTitle("Раздел администратора main");?>
<a class="link" href="/local/man/email_events.php">Шаблоны последних писем по событиям</a><br>

<?//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
