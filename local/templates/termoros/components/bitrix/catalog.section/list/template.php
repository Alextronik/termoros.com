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
if (!empty($arResult['ITEMS']))
{

	$NAV=array(
		"NavPageCount"=>$arResult["NAV_RESULT"]->NavPageCount,
		"NavPageNomer"=>$arResult["NAV_RESULT"]->NavPageNomer,
		"NavPageNomerNext"=>$arResult["NAV_RESULT"]->NavPageNomer+1,
		"NavNum"=>$arResult["NAV_RESULT"]->NavNum,
	);
	$templateData["NAV"]=$NAV;
	?>
	
	<!--RestartBuffer_<?=$NAV["NavNum"]?>-->
	<?if($_GET["LAZI_".$NAV["NavNum"]]=="Y"){?>
	<div>
	<?}?>
	
	<?if($arParams['WATCHED'] == 'Y'):?>
		
		<div class='watched_slider_wp col-12'>

			<div class='watch_ttl_wp'>
				<div class='obj_ttl'>
					<p class='ttl'>Вы <br>смотрели</p>
					<!--<a href='' class='lnk'>Все товары</a>-->
				</div>
			</div>

			<ul class='watched_slider'>
				<?foreach($arResult['ITEMS'] as $arItem){
			
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				$count++;
		
				if($arItem["DETAIL_PICTURE"]!=""){
					$foto=CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>260, 'height'=>260), BX_RESIZE_IMAGE_PROPORTIONAL , true);
				}elseif($arItem["PREVIEW_PICTURE"]!=""){
					$foto=CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>260, 'height'=>260), BX_RESIZE_IMAGE_PROPORTIONAL , true);
				}
		
				if(!$foto['src']){
					$foto['src']=SITE_TEMPLATE_PATH."/img/no-foto-small.jpg";
				}
				//p($arItem);?>
				<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
					<div class='im_area'>
						<img class="lozad" data-src="<?=$foto["src"]?>" src='<?=$foto["src"]?>' alt="" />
					</div>
					<a href='<?=$arItem["DETAIL_PAGE_URL"]?>' class='name'><?=resize_str($arItem["NAME"],60,true)?></a>
				</li>
				<?}?>
			</ul>
			
			<a href='' class='ws_prev'></a>
			<a href='' class='ws_next'></a>
		</div>
		
	
	<?else:?>
	
	<div class="cat_list_block">
		<div class='cat_list list_view'>
		<?$count=0?>
		<?foreach($arResult['ITEMS'] as $arItem){
		
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
			$count++;
	
			if($arItem["DETAIL_PICTURE"]!=""){
				$foto=CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>260, 'height'=>260), BX_RESIZE_IMAGE_PROPORTIONAL , true);
			}elseif($arItem["PREVIEW_PICTURE"]!=""){
				$foto=CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>260, 'height'=>260), BX_RESIZE_IMAGE_PROPORTIONAL , true);
			}
	
			if(!$foto['src']){
				$foto['src']=SITE_TEMPLATE_PATH."/img/no-foto-small.jpg";
			}
			//p($arItem);?>

			<div class='cat_item' id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class='im_area'>
					<!--<a href='' class='quick_btn'>Быстрый просмотр</a>-->
					<?if($arItem["PROPERTIES"]["NEW_TOV"]["VALUE"]=="Y"){?>
					<div class="new_label"></div>
					<?}elseif($arItem["PROPERTIES"]["TOP_TOV"]["VALUE"]=="Y"){
					?><div class="hit_label"></div><?
					}?>
					<img class="lozad" data-src="<?=$foto["src"]?>" src='<?=$foto["src"]?>'>
				</div>
				
				<div class='item_i'>
					<a href='<?=$arItem["DETAIL_PAGE_URL"]?>' class='name'><?=resize_str($arItem["NAME"],60,true)?></a>
					<p class='brand'>Артикул: <?=$arItem["PROPERTIES"]['CML2_ARTICLE']['VALUE']?></p>
						<?/*<p class='brand'>Бренд:<a><?=$arItem["PROPERTIES"]['CML2_ARTICLE']['VALUE']?></a></p>*/?>
				</div>				
				
				<div class='price_block'>
					<p class='price'><?=number_format ($arItem["MIN_PRICE"]["VALUE"], 2, '.', ' ' )?><span>руб.</span></p>
				</div>
				
				<div class='col_block'>
					<input type='text' class='inp_self' value='1'>
					<span>шт.</span>
				</div>
				
				<div class='actions'>
					<a onclick="yaCounter26951046.reachGoal('click_korzina'); ga('send', 'pageview','/virtual/click_korzina'); return true;" class='to_basket ajax list'>в корзину</a>
					<a class='quick_btn'><span class='it_ttl'>быстрый просмотр</span></a>
					<a data-id="<?=$arItem["ID"]?>" class='fav_btn<?if(in_array($arItem["ID"], $arResult['FAV'])):?> active<?endif?>'><span class='it_ttl'>добавить в избранное</span></a>
					<a data-id="<?=$arItem["ID"]?>" class='compare_btn<?if(in_array($arItem["ID"], $arResult['COMPARE'])):?> active<?endif?>'><span class='it_ttl'>добавить к сравнению</span></a>
					<form name="fastfind" style="display: none;" >
						<input type="hidden" name="ID" value="<?=$arItem["ID"]?>" />
						<input type="hidden" name="id" value="<?=$arItem["ID"]?>" />
						<input type="hidden" name="IBLOCK_ID" value="<?=$arItem["IBLOCK_ID"]?>" />
					</form>
				</div>				
			</div>

			<?}?>
			<div class='clear'></div>
			</div>
	</div>
		
	<?if($NAV["NavPageCount"]>$NAV["NavPageNomer"]){
	$page= $APPLICATION->GetCurPageParam("PAGEN_".$NAV["NavNum"]."=".$NAV["NavPageNomerNext"]."&LAZI_".$NAV["NavNum"]."=Y", array("PAGEN_".$NAV["NavNum"], "LAZI_".$NAV["NavNum"]));
	?>
	<div class="show"><a href='<?=$page?>' class='show_more'></a></div>
	<?}?>

	<?
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?>
	<?
	}?>
	
	<?endif;?>
	
	
	<?}?>
	<?if($_GET["LAZI_".$NAV["NavNum"]]=="Y"){?>
	</div>
	<?}?>
<!--RestartBuffer_<?=$NAV["NavNum"]?>-->