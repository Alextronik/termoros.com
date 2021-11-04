<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->IncludeComponent(
	"infoday:sale.personal.profile.list",
	"template",
	array(
		"PATH_TO_DETAIL" => $arResult["PATH_TO_DETAIL"],
		"PER_PAGE" => $arParams["PER_PAGE"],
		"SET_TITLE" =>$arParams["SET_TITLE"],
		"PERSON_TYPE_ID" =>$arParams["USER_TYPE"]
	),
	$component
);
?>
