<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(!empty($_REQUEST["partner"]))
{
    $a = new Termoros\MakeCSV($_REQUEST['partner']);

    if($_REQUEST['file'] == "Y"){
        $a->downloadCSV();
    } elseif($_REQUEST['json'] == "Y") {
        $a->getJson();
    }
}
