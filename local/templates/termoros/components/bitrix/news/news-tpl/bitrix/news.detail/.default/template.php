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
<div class="news_detail_wp">
	
	
	<?
		if($arResult["PREVIEW_PICTURE"]['ID'])
			$imgid = resize($arResult["PREVIEW_PICTURE"]['ID'], 500, 300, 2);
		elseif($arResult["DETAIL_PICTURE"]['ID'])
			$imgid = resize($arResult["DETAIL_PICTURE"]['ID'], 800, 600, 2);
		else
			$imgid = '';
		?>
		
	<?if($imgid):?>
	<img src="<?=$imgid;?>" alt="" class="img img-fluid"/>
	<?endif;?>
	<? if ($arResult['DISPLAY_PROPERTIES']['END_DATE']['VALUE']) { 
		$endArr = explode(".", $arResult["DISPLAY_PROPERTIES"]["END_DATE"]["VALUE"]);
		$endFrom = mktime(0,0,0,$endArr[1],$endArr[0], $endArr[2]);
		if (time() > $endFrom) {
		?>
		<h2 style="color: #d04420;">Акция завершена</h2> 
		<? } ?>
	<? } ?>
	<div class="news_detail">
	<p>
	<?if(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	</p>
	
	<?if($arResult['PROPERTIES']['MORE_PICTURE']['VALUE']):?>
		<div class="news-gallery">
			<?$arItems = array_chunk($arResult['PROPERTIES']['MORE_PICTURE']['VALUE'], 4);?>
			<?
			//v($arResult['PROPERTIES']['MORE_PICTURE']);
			?>
			<?foreach($arItems as $row):?>
				<div class="news-gallery-row">
				<?foreach($row as $picid):?>
				<div class="gallery-img">
					<?$img = resize($picid, 230, 200, 3);?>
					<?$imgbig = resize($picid, 1200, 1200, 2);?>
					<?
					$imgRes = CFile::GetByID($picid);
					$imgF = $imgRes->GetNext();
					$imgName = str_replace(array('.jpg', '.png','.JPG','.jpeg','.JPEG'), '', $imgF["ORIGINAL_NAME"]);
					?>
					<a title="<?=$imgName?>" class="fancy" href="<?=$imgbig?>" rel="gallery" >
						<img src="<?=$img?>" alt="" />
					</a>
				</div>
				<?endforeach;?>
				</div>
			<?endforeach;?>
		</div>
	<?endif;?>
	</div>
	<div class="clear"></div>
	<div class='det_share'>
		<span class='name'>Поделиться</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="soc-blk">
			<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
			<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
			<div class="ya-share2" data-services="vkontakte,facebook,gplus" data-counter=""></div>
		</span>
	</div>
	<br>
	<div class="clear"></div>
	<a href="<?=$arParams['IBLOCK_URL'];?>" class="back_link">Вернуться к списку</a>
</div>
<script>
	$(document).ready(function() {
	if ($('.show-hidden').length)
	{
		$('.show-hidden').click(function(event) {
			$(this).hide();
			$(this).parent().next().slideDown();
			event.preventDefault();
			event.stopPropagation();
		});
		
	}
	
});
</script>