<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$elemArticle = urldecode($_GET['a']);
CModule::IncludeModule('iblock');
if ($elemArticle)
{
	$res = CIblockElement::GetList(
		array(),
		array("IBLOCK_ID" => 4, "PROPERTY_CML2_ARTICLE" => $elemArticle),
		false,
		false,
		array("ID", "DETAIL_PAGE_URL", "PROPERTY_CML2_ARTICLE")
	);

	$ar = $res->GetNext();
	if ($ar && $ar["DETAIL_PAGE_URL"])
	{
		header("Location: ".$ar["DETAIL_PAGE_URL"].'?utm_source=file&utm_medium=price_list&utm_campaign='.$_GET['utm_campaign']);
		die();
	}
	else{
		echo 'Товар не найден';		
	}
}

?>