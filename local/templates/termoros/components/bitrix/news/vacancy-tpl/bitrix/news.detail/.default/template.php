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
<div class='vacancy_page'>

<div class="vac_inner">
	
	<?
		if($arResult["PREVIEW_PICTURE"]['ID'])
			$imgid = resize($arResult["PREVIEW_PICTURE"]['ID'], 500, 300, 2);
		elseif($arResult["DETAIL_PICTURE"]['ID'])
			$imgid = resize($arResult["DETAIL_PICTURE"]['ID'], 500, 300, 2);
		else
			$imgid = '';
		?>
		
	<?if($imgid):?>
	<img src="<?=$imgid;?>" alt="" />
	<?endif;?>
	
	
	
	
	
	<?//p($arResult['PROPERTIES']['GROUP']['VALUE']);?>
	<div class="news_detail">
	<?if($arResult['PROPERTIES']['CITY']['VALUE']):?><h3>Город: <?=$arResult['PROPERTIES']['CITY']['VALUE'];?></h3><?endif;?>
	<?if($arResult['PROPERTIES']['GROUP']['VALUE']):?><h3>Профессиональная область: <?=$arResult['PROPERTIES']['GROUP']['VALUE'];?></h3><?endif;?>
	<p>
	<?if(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	</p>

	</div>
	<p>
	<noindex>
	<a target="_blank" rel="nofollow" href="https://www.superjob.ru/clients/termoros-25425.html?utm_source=PR2015&utm_medium=referral&utm_campaign=25425"><img src="https://img.superjob.ru/img/_redesign/landings/best_employer/best_employer2016_big.jpg" border="0" alt="Привлекательный работодатель" width="145" height="161"></a>
	</noindex>
	</p>
	<div class='links'>
		<a href='/about_company/career_v?vac=<?echo $arResult["NAME"];?>' class='to_vac'>Заполнить анкету</a>
		<a target="_blank" href='?print=y' class='print'><span class="it_ttl">распечатать</span></a>
		<a href='' data-id="<?=$arResult['ID']?>" class='send'><span class="it_ttl">отправить по e-mail</span></a>
		<a href='' class='share'><span class="it_ttl">отправить резюме</span></a>
	</div>
	
	<a href="<?=$arParams['IBLOCK_URL'];?>" class="back_link">Вернуться к списку</a>
	
	<div class='clear'></div>
</div>
</div>
