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

		<div class='cat_list_wp'>

			<div class='cat_list'>
				<?foreach($arResult['ITEMS'] as $item){

					if($arItem["DETAIL_PICTURE"]!=""){
						$foto=CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>260, 'height'=>260), BX_RESIZE_IMAGE_PROPORTIONAL , true);
					}elseif($arItem["PREVIEW_PICTURE"]!=""){
						$foto=CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>260, 'height'=>260), BX_RESIZE_IMAGE_PROPORTIONAL , true);
					}
					
					if(!$foto['src']){
						$foto['src']=SITE_TEMPLATE_PATH."/img/no-foto-small.jpg";
					}
					?>
					<div class='cat_item' id="<?=$this->GetEditAreaId($item['ID']);?>">
						<?$this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
						<div class='im_area'>
							<!--<a href='' class='quick_btn'>Быстрый просмотр</a>-->
							<img src='<?=$foto["src"]?>'>
						</div>
						<a href='<?=$item["DETAIL_PAGE_URL"]?>' class='name'><?=resize_str($item["NAME"],57,true)?></a>
						<?/*<p class='brand'>Бренд:<a href=''></a></p>*/?>
						<div class='price_block'>
							<p class='oldprice'></p>
							<p class='price'><?=number_format ($item["MIN_PRICE"]["VALUE"], 2, '.', ' ' )?><span>руб.</span></p>

							<a href='' onclick="yaCounter26951046.reachGoal('click_korzina'); ga('send', 'pageview','/virtual/click_korzina'); return true;" class='to_basket'>в корзину</a>
						</div>
					</div>
					<?
				}?>


				<div class='clear'></div>

			</div>

		</div>
	<?


	if($NAV["NavPageCount"]>$NAV["NavPageNomer"]){

		$page= $APPLICATION->GetCurPageParam("PAGEN_".$NAV["NavNum"]."=".$NAV["NavPageNomerNext"]."&LAZI_".$NAV["NavNum"]."=Y", array("PAGEN_".$NAV["NavNum"], "LAZI_".$NAV["NavNum"]));
	?>
		<div class="show"><a href='<?=$page?>' class='show_more'></a></div>
	<?}?>
	<!--RestartBuffer_<?=$NAV["NavNum"]?>-->

	<?


}