<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Фото менеджеров.");

CModule::IncludeModule('iblock');
$res = CIblockElement::GetList(
	array(),
	array("IBLOCK_ID" => 4, "!DETAIL_PICTURE" => FALSE),
	false,
	false,
	array("ID", "DETAIL_PICTURE", "PROPERTY_CML2_ARTICLE")
);

while($ar = $res->GetNext())
{
	$img = CFile::GetPath($ar["DETAIL_PICTURE"]);
	
	$extArr = explode(".", $img);
	$ext = $extArr[count($extArr)-1];
	
	//echo $_SERVER['DOCUMENT_ROOT'].$img;
	//echo '<br>';
	//echo $_SERVER['DOCUMENT_ROOT'].'/export_images/'.$ar["PROPERTY_CML2_ARTICLE_VALUE"].'.'.$ext;
	$ar["PROPERTY_CML2_ARTICLE_VALUE"] = str_replace('/','_',$ar["PROPERTY_CML2_ARTICLE_VALUE"]);
	copy($_SERVER['DOCUMENT_ROOT'].$img, $_SERVER['DOCUMENT_ROOT'].'/export_images/'.$ar["PROPERTY_CML2_ARTICLE_VALUE"].'.'.$ext);

}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>