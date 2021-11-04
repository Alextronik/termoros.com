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
?>
<?
		if($arResult["PREVIEW_PICTURE"]['ID'])
			$imgid = resize($arResult["PREVIEW_PICTURE"]['ID'], 500, 300, 2);
		elseif($arResult["DETAIL_PICTURE"]['ID'])
			$imgid = resize($arResult["DETAIL_PICTURE"]['ID'], 500, 300, 2);
		else
			$imgid = '';
		?>
<div class='brand_detail_wp'>
	<div  class='br_ico'>
	<?if($imgid):?>
	<img src="<?=$imgid;?>" alt="" />
	<?endif;?>
	</div>
	<div class='brand_detail'>
	<p><?if(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?></p>
	<?if($arResult['PROPERTIES']['SITE_URL']['VALUE']):?>
	<a href='http://<?=str_replace('http://', '', $arResult['PROPERTIES']['SITE_URL']['VALUE']);?>' class='br_link'><?=$arResult['PROPERTIES']['SITE_URL']['VALUE'];?></a>
	<?endif?>
	</div>
	<div class='clear'></div>
</div>