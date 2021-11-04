<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$elemArticle = urldecode($_GET['a']);
CModule::IncludeModule('iblock');
if ($elemArticle)
{
	//https://www.termoros.com/catalog/baxi.php?a=5702450
	
	$res = CIblockElement::GetList(
		array(),
		array("IBLOCK_ID" => 4, "PROPERTY_ARTIKUL_NOMENKLATURY_POSTAVSHCHIKA" => '%'.$elemArticle.'%'),
		false,
		false,
		array("ID", "DETAIL_PAGE_URL", "PROPERTY_CML2_ARTICLE")
	);
	
	$ar = $res->GetNext();

	if ($ar)
	{
		$_REQUEST['id'] = $ar["ID"];
		$_REQUEST['ID'] = $ar["ID"];
		$_REQUEST['action'] = "ADD2BASKET";

		require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/.default/ajax/scripts/add_to_cart.php');
		
		header("Location: /personal/cart/");
		die();
	}
	else{
		header("Location: /");
	}
}
header("Location: /");
die();
?>