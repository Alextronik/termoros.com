<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
?>
<?


foreach($arResult["ITEMS"] as $indx => $arItem):
	//p($arItem['PROPERTIES']['CITY']['VALUE']);
	//p($arItem['PROPERTIES']['GROUP']['VALUE']);
	$grps[] = trim($arItem['PROPERTIES']['GROUP']['VALUE']);
	$citys[] = trim($arItem['PROPERTIES']['CITY']['VALUE']);
	
endforeach;


$arResult['CITY'] = array_unique($citys);
$arResult['GROUPS'] = array_unique($grps);


foreach($arResult["ITEMS"] as $indx => $arItem):
	
	if($_REQUEST['city']&&$arItem['PROPERTIES']['CITY']['VALUE'] != $_REQUEST['city']) continue;
	if($_REQUEST['grp']&&$arItem['PROPERTIES']['GROUP']['VALUE'] != $_REQUEST['grp']) continue;
	$arNewSort[] = $arItem;

endforeach;

$arResult['ITEMS'] = $arNewSort;


?>