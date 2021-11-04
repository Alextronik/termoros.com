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

function ShowNews($arItem,$k,$arResult,$titl)
{
	//p($arItem);
?>
	<?				
	$class = "news";
	if($k == 0) $class = "study green";					
	if($k == 3||$k == 7) $class = "study light_green";	
	$section_name = $arResult['SECTION_NAMES'][$arItem['IBLOCK_SECTION_ID']];
	if($titl == 'Акция') /// $arItem['IBLOCK_SECTION_ID'] == 338
	{
		$class = "action";	
		$section_name = 'акция';
	}
	
	//p($arResult['SECTION_NAMES']);
	?>	

	
	<div class='ma_block <?=$class?>'>
		<?if($titl):?>
			<span class='label'><?=$titl?></span>
		<?else:?>
			<span class='label'>новости</span>
		<?endif?>
		<?if($arItem['PROPERTIES']['MTITLE']['VALUE']):?>
			<span class="ttls"><?=$arItem['PROPERTIES']['MTITLE']['VALUE'];?></span>
		<?endif;?>
		<?if($class!='action'):?>
			<?if($k == 0 || $k == 3):?>
				<p class='date'><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
			<?endif?>
			<p class='ttl'><?=$arItem['NAME']?></p><br>
			<p class='txt'><?=$arItem['PREVIEW_TEXT']?></p>
			<?if($k != 0 && $k != 0 && $k != 3):?>
				<p class='date'><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
			<?endif?>
		<?endif?>
		<?$img = $class == 'action' ? $arItem['PREVIEW_PICTURE'] : ''?>
		<?if($img):?>
			<img src='<?=$img?>' class='act_im'  alt=''>
		<?endif?>
		<a href='<?=$arItem['DETAIL_PAGE_URL']?>' class='more_lnk'><span><img src='<?=SITE_TEMPLATE_PATH.'/img/more_lnk.png'?>'  alt='' class='ico'>подробнее</span></a>
	</div>
<?
}
?>
<div class='main_articles'>
	<div class='container'>
		
		<div class='ma_left'>
			<?ShowNews($arResult['SEMI'][0],0,$arResult,'Семинар')?>
			<?foreach($arResult["ITEMS"] as $k => $arItem):?>
				<?//p($arItem)?> 
				
				<?ShowNews($arItem,2,$arResult)?>		
				<?unset($arResult["ITEMS"][$k]);?>				
				
				<?if($k==1):?>
				<?ShowNews($arResult['ARTICLE'][0],3,$arResult,'Статьи')?>
				<?endif;?>
				
				<?if($k==1) break;?>
			<?endforeach?>			
		</div>
		
		<div class='ma_mid'>
			<?ShowNews($arResult['BIG_ACTION'],10,$arResult,'Акция')?>
		</div>

		<div class='ma_rightttt'>
			<?foreach($arResult["ITEMS"] as $k => $arItem):?>
				<?ShowNews($arItem,$k,$arResult)?>		
				<?unset($arResult["ITEMS"][$k]);?>		
				<?if($k==2) break;?>
			<?endforeach?>	
			<?ShowNews($arResult['SMALL_ACTION'],10,$arResult,'Акция')?>	
		</div>
		
		<div class='clear'></div>
		
	</div>
	</div>
