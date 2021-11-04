<?
foreach($arResult["ITEMS"] as $arItem)
{
	$arSections[] = $arItem['IBLOCK_SECTION_ID'];
}

$arSections = array_unique($arSections);

$arFilter = array('ID' => $arSections); // выберет потомков без учета активности
$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
while ($arSect = $rsSect->GetNext())
{
   $arResult['SECTION_NAMES'][$arSect['ID']] = $arSect['NAME'];
}


$arSelect = Array('IBLOCK_ID', 'NAME', 'ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 'PREVIEW_TEXT', "PROPERTY_MTITLE");
$arFilter = Array("IBLOCK_ID"=>5, "ACTIVE"=>"Y","!PROPERTY_BIG"=>false,'!PROPERTY_SHOW_ON_MAIN'=>false);
$res = CIBlockElement::GetList(Array("ACTIVE_FROM"=>"DESC"), $arFilter, false, Array("nPageCount"=>1), $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	$arResult['BIG_ACTION']  = $arFields;
	$arResult['BIG_ACTION']['PROPERTIES']  = $ob->GetProperties();
	$arResult['BIG_ACTION']['PREVIEW_PICTURE'] = CFile::GetPath($arResult['BIG_ACTION']['PREVIEW_PICTURE']);
	//p($arResult['BIG_ACTION']);
}

$arSelect = Array('IBLOCK_ID', 'NAME', 'ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 'PREVIEW_TEXT');
//$arFilter = Array("IBLOCK_ID"=>21, "ACTIVE"=>"Y","PROPERTY_BIG"=>false,'!PROPERTY_SHOW_ON_MAIN'=>false);
$arFilter = Array("IBLOCK_ID"=>21, "ACTIVE"=>"Y",);
$res = CIBlockElement::GetList(Array("ACTIVE_FROM"=>"DESC"), $arFilter, false, Array("nPageSize"=>2), $arSelect);
while($ob = $res->GetNextElement())
{
	unset($arResult['SMALL_ACTION']);
	
	$arFields = $ob->GetFields();
	$arResult['SMALL_ACTION'] = $arFields;
	$arResult['SMALL_ACTION']['PROPERTIES']  = $ob->GetProperties();
	$arResult['SMALL_ACTION']['PREVIEW_PICTURE'] = CFile::GetPath($arResult['SMALL_ACTION']['PREVIEW_PICTURE']);
	
	$arResult['SEMI'][] = $arResult['SMALL_ACTION'];
	
}

$arSelect = Array('IBLOCK_ID', 'NAME', 'ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 'PREVIEW_TEXT');
//$arFilter = Array("IBLOCK_ID"=>21, "ACTIVE"=>"Y","PROPERTY_BIG"=>false,'!PROPERTY_SHOW_ON_MAIN'=>false);
$arFilter = Array("IBLOCK_ID"=>16, "ACTIVE"=>"Y",);
$res = CIBlockElement::GetList(Array("ACTIVE_FROM"=>"DESC"), $arFilter, false, Array("nPageSize"=>1), $arSelect);
while($ob = $res->GetNextElement())
{
	unset($arResult['SMALL_ACTION']);
	
	$arFields = $ob->GetFields();
	$arResult['SMALL_ACTION'] = $arFields;
	$arResult['SMALL_ACTION']['PROPERTIES']  = $ob->GetProperties();
	$arResult['SMALL_ACTION']['PREVIEW_PICTURE'] = CFile::GetPath($arResult['SMALL_ACTION']['PREVIEW_PICTURE']);
	
	$arResult['ARTICLE'][] = $arResult['SMALL_ACTION'];
	
}

unset($arResult['SMALL_ACTION']);

$arSelect = Array('IBLOCK_ID', 'NAME', 'ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 'PREVIEW_TEXT');
//$arFilter = Array("IBLOCK_ID"=>21, "ACTIVE"=>"Y","PROPERTY_BIG"=>false,'!PROPERTY_SHOW_ON_MAIN'=>false);
$arFilter = Array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "PROPERTY_BIG"=>false, "!PROPERTY_SHOW_ON_MAIN" => false);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
while($ob = $res->GetNextElement())
{
	unset($arResult['SMALL_ACTION']);
	unset($arFields);
	
	$arFields = $ob->GetFields();
	$arResult['SMALL_ACTION'] = $arFields;
	$arResult['SMALL_ACTION']['PROPERTIES']  = $ob->GetProperties();
	$arResult['SMALL_ACTION']['PREVIEW_PICTURE'] = CFile::GetPath($arResult['SMALL_ACTION']['PREVIEW_PICTURE']);
	
}
//p($arResult['SEMI']);
//p($arResult['BIG_ACTION']);
//p($arResult['SMALL_ACTION']);