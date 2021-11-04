<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION; 
$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"pixelplus:menu.sections", 
	"", 
	array(
		"IS_SEF" => "Y",
		"SEF_BASE_URL" => "/catalog/",
		"SECTION_PAGE_URL" => "#SECTION_CODE#/",
		"DETAIL_PAGE_URL" => "#SITE_DIR#/catalog/#SECTION_CODE#/#CODE#.php",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "5",
		"DEPTH_LEVEL" => "1",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000"
	),
	false
);
$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);
?>