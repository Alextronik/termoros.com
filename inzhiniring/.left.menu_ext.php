<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"pixelplus:menu.elements", 
	"", 
	array(
		"ID" => "",
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "11",
		"SECTION_URL" => "/inzhiniring/",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600"
	),
	false
);
$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);
?>