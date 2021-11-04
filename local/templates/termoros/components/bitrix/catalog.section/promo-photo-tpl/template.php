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

if (!empty($arResult['ITEMS']))
{
	$NAV=array(
		"NavPageCount"=>$arResult["NAV_RESULT"]->NavPageCount,
		"NavPageNomer"=>$arResult["NAV_RESULT"]->NavPageNomer,
		"NavPageNomerNext"=>$arResult["NAV_RESULT"]->NavPageNomer+1,
		"NavNum"=>$arResult["NAV_RESULT"]->NavNum,
	);
	$templateData["NAV"]=$NAV;
	$arItems = array_chunk($arResult['ITEMS'], 2);
?>	
	<div class="tech_docs">
	<div class="video-blk">
			<table class="video-table" align="center" width="90%">
			<tbody>
				<?
				foreach ($arItems as $row)
				{
				?>
				<tr>
				<?
				foreach ($row as $key => $arItem)
				{
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
					$strMainID = $this->GetEditAreaId($arItem['ID']);
					?>
					<td width="50%" id="<? echo $strMainID; ?>" border="0" >
					<p class="ttl"><b><?=$arItem['NAME']?></b> <? if ($arItem['PROPERTIES']['MORE_PHOTO']["VALUE"]) { ?>(<?=count($arItem['PROPERTIES']['MORE_PHOTO']["VALUE"])+1?> фото)<? } ?></p>
					<?$img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>400, 'height'=>300), BX_RESIZE_IMAGE_EXACT, true);?>
					<a class="fancy" title="<?=$arItem['NAME']?> <? if ($arItem['PROPERTIES']['MORE_PHOTO']["VALUE"]) { ?>(<?=count($arItem['PROPERTIES']['MORE_PHOTO']["VALUE"])+1?> фото)<? } ?>" rel="gallery_<?=$arItem['ID']?>" href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"><img src="<?=$img['src'];?>" /></a>
					<? if ($arItem['PROPERTIES']['MORE_PHOTO']) { ?>
						<div style="display:none;">
							<? foreach($arItem['PROPERTIES']['MORE_PHOTO']["VALUE"] as $fileId) { ?>
								
								<a class="fancy" title="<?=$arItem['NAME']?> <? if ($arItem['PROPERTIES']['MORE_PHOTO']["VALUE"]) { ?>(<?=count($arItem['PROPERTIES']['MORE_PHOTO']["VALUE"])+1?> фото)<? } ?>" href="<?=CFile::GetPath($fileId);?>" rel="gallery_<?=$arItem['ID']?>"></a>
							<? } ?>
						</div>
					<? } ?>
					</td>
				<?
				}
				?>
				<tr>
				<?
				}
				?>
			</tbody>
			</table>
					
			
			<?if($NAV["NavPageCount"]>$NAV["NavPageNomer"]){
			$page= $APPLICATION->GetCurPageParam("PAGEN_".$NAV["NavNum"]."=".$NAV["NavPageNomerNext"]."&LAZI_".$NAV["NavNum"]."=Y", array("PAGEN_".$NAV["NavNum"], "LAZI_".$NAV["NavNum"]));
			?>
			<div class="show"></div><a href='<?=$page?>' class='show_more'></a>
			<?}?>
				
			<?
			if ($arParams["DISPLAY_BOTTOM_PAGER"])
			{
			?><? echo $arResult["NAV_STRING"]; ?><?
			}
			?>
	</div>	
	</div>	
	<?
}else{
?>
	<?if($arParams['WATCHED'] != 'Y' && $arParams['NON_OUTTEXT'] != 'Y'):?>
	<p class="no-items">К сожалению, по Вашему запросу сегодня ничего не найдено.</p>
	<?endif;?>
<?}?>