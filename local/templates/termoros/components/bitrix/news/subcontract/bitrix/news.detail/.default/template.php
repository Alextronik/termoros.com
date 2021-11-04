<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$dateStr = substr($arResult["PROPERTIES"]["END_DATE"]["VALUE"], 0, 10);
$dateArr = explode(".", $dateStr);
$endDateUnix = mktime(23, 59, 59, $dateArr[1], $dateArr[0], $dateArr[2]);
?>
<div class="subcontract-detail">
	<?foreach($arResult["DISPLAY_PROPERTIES"]["MAIN_DOCUMENT"]["VALUE"] as $k => $fileId) {?>
		<?
		$filePath = CFile::GetPath($fileId);
		$fileName = $arResult["DISPLAY_PROPERTIES"]["MAIN_DOCUMENT"]["DESCRIPTION"][$k];
		$finfo = pathinfo($_SERVER['DOCUMENT_ROOT'].$filePath);
		if ($endDateUnix < time()) 
		{
		?>
		<span class="red"><?=($fileName)?$fileName:'Документ №'.($k+1);?></span><br /><br />
		<? } else { ?>
		<a target="_blank" href="<?=$filePath?>"><?=($fileName)?$fileName:'Документ №'.($k+1);?></a><br /><br />
		<? } ?>
	<? } ?>
	
	<br />
	<?=$arResult["DETAIL_TEXT"]?>
</div>