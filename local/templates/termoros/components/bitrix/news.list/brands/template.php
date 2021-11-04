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

$arSort = array_chunk($arResult["ITEMS"], 8);

	$NAV=array(
		"NavPageCount"=>$arResult["NAV_RESULT"]->NavPageCount,
		"NavPageNomer"=>$arResult["NAV_RESULT"]->NavPageNomer,
		"NavPageNomerNext"=>$arResult["NAV_RESULT"]->NavPageNomer+1,
		"NavNum"=>$arResult["NAV_RESULT"]->NavNum,
	);
	$templateData["NAV"]=$NAV;
?>
<div class='brands_block'>
	<div class='container'>
	<?foreach($arSort as $rw):?>
		<div class="brands_list">
	<?foreach($rw as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<?
		if($arItem['DETAIL_PICTURE']!=""){
			$foto=CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], array('width'=>160, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL , true);
		}elseif($arItem['PROPERTIES']['LOGO_COLOR']['VALUE']!=""){
			$foto=CFile::ResizeImageGet($arItem['PROPERTIES']['LOGO_COLOR']['VALUE'], array('width'=>160, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL , true);
		}elseif($arItem['PROPERTIES']['LOGO_COLOR']['VALUE']!=""){
			$foto=CFile::ResizeImageGet($arItem['PROPERTIES']['LOGO_COLOR']['VALUE'], array('width'=>160, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL , true);
		}
		
		if(!$foto['src']){
			$foto['src']=SITE_TEMPLATE_PATH."/img/no-foto-small.jpg";
		}
		?>
		<div class='brand_item' id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
			<a href="<?=$arItem['DETAIL_PAGE_URL']?>" >
                <!--img src='<?=$foto['src']?>'  alt=''/-->
			<img class="lozad" data-src='<?=$foto['src']?>' src='<?=$foto['src']?>' alt=''/>
			</a>
		</div>
	<?endforeach;?>
		</div>
	<?endforeach;?>
		<?if($NAV["NavPageCount"]>$NAV["NavPageNomer"]){
		$page= $APPLICATION->GetCurPageParam("PAGEN_".$NAV["NavNum"]."=".$NAV["NavPageNomerNext"], array("PAGEN_".$NAV["NavNum"], "LAZI_".$NAV["NavNum"]));
		//$page= $APPLICATION->GetCurPageParam("PAGEN_".$NAV["NavNum"]."=".$NAV["NavPageNomerNext"]."&LAZI_".$NAV["NavNum"]."=Y", array("PAGEN_".$NAV["NavNum"], "LAZI_".$NAV["NavNum"]));
		?>
		<div class="show"><a href='<?=$page?>' class='show_more'></a></div>
		<?}?>
		
	</div>
</div>