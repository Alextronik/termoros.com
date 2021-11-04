<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('main');
CModule::IncludeModule('iblock');

$res = CIBlockElement::GetList(
 Array("SORT"=>"ASC"),
 Array("IBLOCK_ID"=>4,"PROPERTY_CML2_ARTICLE" => $_GET['article']),
 false,
 false,
 Array("ID","IBLOCK_ID","DETAIL_PICTURE")
);

$ar = $res->GetNext();
if ($ar && $ar["DETAIL_PICTURE"])
{
	echo '<img src="'.CFile::GetPath($ar["DETAIL_PICTURE"]).'">';
}
else
{
	echo 'Нет изображения';
}
/*
$res = CIBlockElement::GetList(
 Array("SORT"=>"ASC"),
 Array("IBLOCK_ID"=>4, "!DETAIL_PICTURE" => FALSE),
 false,
 false,
 Array("ID","IBLOCK_ID","DETAIL_PICTURE","PROPERTY_CML2_ARTICLE")
);

while($ar = $res->GetNext())
{
	echo $ar["PROPERTY_CML2_ARTICLE_VALUE"].'<br>';
}
*/