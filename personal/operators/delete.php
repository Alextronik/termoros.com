<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Редактирование оператора");
\Bitrix\Main\Loader::includeModule('redreams.partners');

$operatorID = $_REQUEST['oID'];

if(\Redreams\Partners\partner::isCurator() && $operatorID) {
	
	$by = "id";
	$order = "asc";
	$filter = array(
		'ID' => $operatorID,
	);
	$dbUser = \CUser::GetList($by, $order, $filter, array('*', "SELECT" => array('UF_*')));
	$u = $dbUser->GetNext();
	
	
	if (!in_array($USER->GetID(), $u["UF_CURATOR_ID"])) die('pnhdlb');
	
	$user = new CUser;

	$arFields = array(
		"ACTIVE" => "N",
	);
	
	$user->Update($operatorID, $arFields);
	
	echo '<p>Оператор удален</p>';
	
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>