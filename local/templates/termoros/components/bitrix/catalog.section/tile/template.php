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

\Bitrix\Main\Loader::includeModule('redreams.partners');
$isPartner = FALSE;
if(\Redreams\Partners\partner::isPartner()) $isPartner = TRUE;
global $USER;
if ($USER->IsAdmin()) $isPartner = TRUE;
global $extraTextItemArr, $extraTextInItem;
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
<?/*if($_GET["LAZI_".$NAV["NavNum"]]=="Y"){?>
	<div>
		<?}*/?>
		<div class="cat_list_block cat_list_wp">
		<?//p($arParams['MODE']);?>


	<?//if($arParams['MODE'] != 'list' && $arParams['MODE'] != 'list2'):?>
	<div class='row cat_list <?if(\Redreams\Partners\partner::isPartner()):?>partner<?endif?> <?if($arParams['MODE'] == 'list'):?> list_view<?elseif($arParams['MODE'] == 'list2'):?> list_view lv2<?endif;?>'>
	<?//endif;?>

		<?$count=0?>
	<?foreach($arResult['ITEMS'] as $arItem){
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
	$count++;
	if($arItem["DETAIL_PICTURE"]!=""){
		$foto=CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>260, 'height'=>260), BX_RESIZE_IMAGE_PROPORTIONAL , true);
	}elseif($arItem["PREVIEW_PICTURE"]!=""){
		$foto=CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>260, 'height'=>260), BX_RESIZE_IMAGE_PROPORTIONAL , true);
	}

	if(!$foto['src']){
		$foto['src']=SITE_TEMPLATE_PATH."/img/no-foto-small.jpg";
	}
	?>
		<?//p($arItem);?>
			<?if($arParams['MODE'] == 'list' || $arParams['MODE'] == 'list2'):?>

					<div class='cat_item row' id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
						<div class='im_area col'>
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                                <img class="img img-fluid lozad" data-src="<?=$foto["src"]?>" src='<?=$foto["src"]?>'>
                                <? if ($isPartner) { ?>
                                    <? if ($arItem["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Складская") { ?>
                                        <img class="img lozad" data-src='/images/stock.png' src='/images/stock.png' title="Складская" alt="Складская" style="position: absolute; top: 5px; bottom: initial; right: 5px; left: inherit; width: 24px; height: 24px;">
                                    <? } elseif ($arItem["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Заказная") { ?>
                                        <img class="img lozad" data-src='/images/order.png' src='/images/order.png' title="Заказная" alt="Заказная" style="position: absolute; top: 5px; bottom: initial; right: 5px; left: inherit; width: 24px; height: 24px;">
                                    <? } elseif ($arItem["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Не заказывать") { ?>
                                        <img class="img lozad" data-src='/images/sale.png' src='/images/sale.png' title="Распродажа остатков" alt="Распродажа остатков" style="position: absolute; top: 5px; bottom: initial; right: 5px; left: inherit; width: 24px; height: 24px;">
                                    <? } ?>
                                <? } ?>
                            </a>
						</div>

						<div class='item_i col'>
							<? if ($isPartner && $arParams['MODE'] == 'list2') { ?>
								<? if ($arItem["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Складская") { ?>
									<img class="lozad" data-src='/images/stock.png' src='/images/stock.png' title="Складская" alt="Складская" style="position: absolute; bottom: initial; top: 5px; left: 2px; right: inherit; width: 24px; height: 24px;">
								<? } elseif ($arItem["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Заказная") { ?>
									<img class="lozad" data-src='/images/order.png' src='/images/order.png' title="Заказная" alt="Заказная" style="position: absolute; bottom: initial; top: 5px; left: 2px; right: inherit; width: 24px; height: 24px;">
								<? } elseif ($arItem["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Не заказывать") { ?>
									<img class="lozad" data-src='/images/sale.png' src='/images/sale.png' title="Распродажа остатков" alt="Распродажа остатков" style="position: absolute; bottom: initial; top: 5px; left: 2px; right: inherit; width: 24px; height: 24px;">
								<? } ?>
							<? } ?>
							<a href='<?=$arItem["DETAIL_PAGE_URL"]?>' class='name'><?=$arItem["NAME"]?></a>
							<p class='brand'>Артикул: <?=$arItem["PROPERTIES"]['CML2_ARTICLE']['VALUE']?></p>
							<?if($arItem["PROPERTIES"]['BREND']['VALUE']):?>
							<p class='brand'>Бренд:<a href="<?=$arResult['BRANDSBYNAME'][strtolower($arResult['BRANDS'][$arItem["PROPERTIES"]['BREND']['VALUE']])];?>" ><?=$arResult['BRANDS'][$arItem["PROPERTIES"]['BREND']['VALUE']]?></a></p>
							<? if (in_array($arItem["PROPERTIES"]['CML2_ARTICLE']['VALUE'], $extraTextItemArr)) { ?><p class='brand' style="color: red; margin-right: 50px; font-size: 13px; line-height: 14px;
"><b><?=$extraTextInItem?></b></p><? } ?>
							<?endif?>
							<?
                            $reject = (substr($arItem["PROPERTIES"]['CML2_ARTICLE']['VALUE'], 0,1) == "@") ? true : false;
                            //v($reject);
                            if($reject){?>
                                <div class="reject_label"></div>
                            <?}elseif($arItem["PROPERTIES"]['NOZ']['VALUE']){?>
							    <div class="sale_label"></div>
							<?}elseif($arItem["PROPERTIES"]["TOP_TOV"]["VALUE"]=="Y"){?>
							<div class="hit_label"></div>
							<?}elseif($arItem["PROPERTIES"]["NEW_TOV"]["VALUE"]=="Y"){?>
							<div class="new_label"></div>
							<?}?>
                            <p class="partner_price">
                                <?if(\Redreams\Partners\partner::isPartner() && ($arItem["MIN_PRICE"]["VALUE"] < $arItem["MAX_PRICE"]["VALUE"]) && $arItem["MAX_PRICE"]["VALUE"]):?>
                                    Розничная цена: <?=number_format ($arItem["MAX_PRICE"]["VALUE"], 2, '.', ' ' )?>  руб.
                                <?endif?>
                            </p>
							<?
							//p($arItem["ID"]);
							//p($arItem["MAX_PRICE"]["VALUE"]);
							
							?>
							
						</div>

						<div class='price_block col'>
							<p class='price'>
							<?if(!\Redreams\Partners\partner::isPartner() && ($arItem["MIN_PRICE"]["VALUE"] < $arItem["MAX_PRICE"]["VALUE"]) && $arItem["MAX_PRICE"]["VALUE"]):?>
								<span class="oldprice"><?=number_format ($arItem["MAX_PRICE"]["VALUE"], 2, '.', ' ' )?>  руб.</span>
							<?endif?>
							<?=number_format ($arItem["MIN_PRICE"]["VALUE"], 2, '.', ' ' )?><span>руб.</span></p>
						</div>

						<div class='col_block col'>
							<?
							if ($isPartner && $arItem[$_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID']]["QUANTS"]) { ?>
							<div style="text-align:center;vertical-align:top;margin-top: -10px; margin-bottom:10px; font-size:12px; color: #749a4a;">В наличии: <b><?=number_format($arItem[$_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID']]["QUANTS"], 0, '.', ' ')?></b> <?=($arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"])?$arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]:'шт'?>.</div>
							<? } elseif ($isPartner) { ?>
								<? if ($arParams['MODE'] == 'list') { ?>
								<div style="text-align:center;vertical-align:top;margin-top: -10px; margin-bottom:10px; font-size:12px;">Наличие уточняйте у менеджеров</div>
								<? } else { ?>
									<div style="text-align:center;vertical-align:top;margin-top: -5px; margin-bottom:-1px; font-size:12px;">Наличие уточняйте у менеджеров</div>
								<? } ?>
							<? } elseif ($arItem[$_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID']]["QUANTS"]) { ?>
								<div style="text-align:center;vertical-align:top;margin-top: -10px; margin-bottom:10px; font-size:12px; color: #749a4a;">В наличии</div>
							<? } else { ?>
								<div style="text-align:center;vertical-align:top;margin-top: -10px; margin-bottom:10px; font-size:12px;">Нет в наличии</div>
							<? } ?>
							<input type='text' class='inp_self' value='1'>
							<span><?=($arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"])?$arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]:'шт'?>.</span>
						</div>
						<div class='actions col'>
							<a href='' onclick="yaCounter26951046.reachGoal('click_korzina'); ga('send', 'pageview','/virtual/click_korzina'); return true;" itemscope="" itemtype="http://schema.org/BuyAction" class='to_basket ajax list col-12'>в корзину</a>
							
							<? if (checkCDEKallow($arItem)) { ?>
								<? if ($arParams['MODE'] == 'list') { ?>
									<img class="lozad col" data-src="/images/sdek_small.png" src="/images/sdek_small.png" style="width: 24px;height: 24px; display: inline-block; vertical-align: middle; margin: 0 8px 0 0 ; padding: 0; position: relative; top: 0; left: 0; text-transform: none;
    font-weight: 400;" title="Возможна срочная доставка">
								<? } else { ?>
								<img class="lozad col" data-src="/images/sdek_small.png" src="/images/sdek_small.png" style="width: 24px;height: 24px; display: inline-block;" title="Возможна срочная доставка">
								<? } ?>
							<? } ?>
							
							<a href='' class='quick_btn col'><span class='it_ttl'>быстрый просмотр</span></a>
							<a href='' data-id="<?=$arItem["ID"]?>" style="margin: 0 7px" class='col fav_btn<?if(in_array($arItem["ID"], $arResult['FAV'])):?> active<?endif?>'><span class='it_ttl'>добавить в избранное</span></a>
							<a href='' data-id="<?=$arItem["ID"]?>" class='col compare_btn<?if(in_array($arItem["ID"], $arResult['COMPARE'])):?> active<?endif?>'><span class='it_ttl'>добавить к сравнению</span></a>
							<form name="fastfind" style="display: none;" >
								<input type="hidden" name="ID" value="<?=$arItem["ID"]?>" />
								<input type="hidden" name="id" value="<?=$arItem["ID"]?>" />
								<input type="hidden" name="IBLOCK_ID" value="<?=$arItem["IBLOCK_ID"]?>" />
							</form>
						</div>
					</div>

			<?else:?>

				<div class='cat_item' id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<?if($arParams['FAV']):?>
					<a href='' data-id="<?=$arItem["ID"]?>" class='fav_btn del'></a>
					<?endif;?>
					<div class='im_area'>
						<a href='' class='quick_btn'>Быстрый просмотр</a>
						<form name="fastfind" >
							<input type="hidden" name="ID" value="<?=$arItem["ID"]?>" />
							<input type="hidden" name="IBLOCK_ID" value="<?=$arItem["IBLOCK_ID"]?>" />
						</form>
						
						<?if($arItem["PROPERTIES"]['NOZ']['VALUE']){?>
						<div class="sale_label"></div>
						<?}elseif($arItem["PROPERTIES"]["TOP_TOV"]["VALUE"]=="Y"){
						?><div class="hit_label"></div><?
						}elseif($arItem["PROPERTIES"]["NEW_TOV"]["VALUE"]=="Y"){
						?><div class="new_label"></div><?
						}?>
						
						
						<img class="lozad" data-src='<?=$foto["src"]?>' src='<?=$foto["src"]?>'>
						<? if ($isPartner) { ?>
							<? if ($arItem["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Складская") { ?>
								<img class="lozad" data-src='/images/stock.png' src='/images/stock.png' title="Складская" alt="Складская" style="position: absolute; top: 5px; bottom: initial; right: -25px; left: inherit; width: 32px; height: 32px;">
							<? } elseif ($arItem["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Заказная") { ?>
								<img class="lozad" data-src='/images/order.png' src='/images/order.png' title="Заказная" alt="Заказная" style="position: absolute; top: 5px; bottom: initial; right: -25px; left: inherit; width: 32px; height: 32px;">
							<? } elseif ($arItem["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Не заказывать") { ?>
								<img class="lozad" data-src='/images/sale.png' src='/images/sale.png' title="Распродажа остатков" alt="Распродажа остатков" style="position: absolute; top: 5px; bottom: initial; right: -25px; left: inherit; width: 32px; height: 32px;">
							<? } ?>
						<? } ?>
					</div>
					<a href='<?=$arItem["DETAIL_PAGE_URL"]?>' class='name'><?=$arItem["NAME"]?></a>
					<?if($arItem["PROPERTIES"]['BREND']['VALUE']):?>
					<p class='brand'>Бренд:<a href="<?=$arResult['BRANDSBYNAME'][strtolower($arResult['BRANDS'][$arItem["PROPERTIES"]['BREND']['VALUE']])];?>" ><?=$arResult['BRANDS'][$arItem["PROPERTIES"]['BREND']['VALUE']]?></a></p>
					<?endif?>
					<p class='brand'>Артикул: <span><?=$arItem["PROPERTIES"]['CML2_ARTICLE']['VALUE']?></span></p>
                    <p class="partner_price">
                        <?if(\Redreams\Partners\partner::isPartner() && ($arItem["MIN_PRICE"]["VALUE"] < $arItem["MAX_PRICE"]["VALUE"]) && $arItem["MAX_PRICE"]["VALUE"]):?>
                            Розничная цена: <?=number_format ($arItem["MAX_PRICE"]["VALUE"], 2, '.', ' ' )?>  руб.
                        <?endif?>
                    </p>
					<div class='price_block '>
						<?if(!\Redreams\Partners\partner::isPartner() && ($arItem["MIN_PRICE"]["VALUE"] < $arItem["MAX_PRICE"]["VALUE"]) && $arItem["MAX_PRICE"]["VALUE"]):?>
							<p class="oldprice"><?=number_format ($arItem["MAX_PRICE"]["VALUE"], 2, '.', ' ' )?>  руб.</p>
						<?endif?>
						<p class='price'><?=number_format ($arItem["MIN_PRICE"]["VALUE"], 2, '.', ' ' )?><span>руб.</span></p>
						<?//p($arItem["MIN_PRICE"]["VALUE"]);?>
						
						<? if (checkCDEKallow($arItem)) { ?>
						<img class="lozad" data-src="/images/sdek_small.png" src="/images/sdek_small.png" style="width: 32px; position: absolute; top: 0px; right: 106px;" title="Возможна срочная доставка">
						<? } ?>
						
						<a href='' onclick="yaCounter26951046.reachGoal('click_korzina'); ga('send', 'pageview','/virtual/click_korzina'); return true;" itemscope="" itemtype="http://schema.org/BuyAction" class='to_basket ajax list'>в корзину</a>
						<form name="fastfind" style="display: none;" >
							<input type="hidden" name="ID" value="<?=$arItem["ID"]?>" />
							<input type="hidden" name="id" value="<?=$arItem["ID"]?>" />
							<input type="hidden" name="IBLOCK_ID" value="<?=$arItem["IBLOCK_ID"]?>" />
						</form>
					</div>
				</div>

			<?endif;?>

	<?if($count==$arParams["LINE_ELEMENT_COUNT"]){
		$count=0;
		?>

		<?if($arParams['MODE'] != 'list' && $arParams['MODE'] != 'list2'):?>
		<div class='clear'></div>
		</div>
		<div class='cat_list  <?if(\Redreams\Partners\partner::isPartner()):?>partner<?endif?> <?if($arParams['MODE'] == 'list'):?> list_view<?elseif($arParams['MODE'] == 'list2'):?> list_view lv2<?endif;?>'>
		<?endif;?>

		<?
	}?>



	<?}?>
	<div class='clear'></div>
	</div>
		</div>
	<?if($NAV["NavPageCount"]>$NAV["NavPageNomer"]){
	$page= $APPLICATION->GetCurPageParam("PAGEN_".$NAV["NavNum"]."=".$NAV["NavPageNomerNext"], array("PAGEN_".$NAV["NavNum"], "LAZI_".$NAV["NavNum"]));
	//$page= $APPLICATION->GetCurPageParam("PAGEN_".$NAV["NavNum"]."=".$NAV["NavPageNomerNext"]."&LAZI_".$NAV["NavNum"]."=Y", array("PAGEN_".$NAV["NavNum"], "LAZI_".$NAV["NavNum"]));
	?>
	<div class="show"><a href='<?=$page?>' class='show_more'></a></div>
		<?}?>

<?
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}
}else{?>

	<?if($arParams['FAV']=='Y') {
		echo "<p>Нет добавленных товаров</p>";
	}else echo "<p class='h3 text-center text-danger'>По заданным параметрам ничего не найдено.<br>Попробуйте изменить настройки поиска.</p>"?>
	<?//Скрываем блок сортировки, если нет товаров?>
	<script>
		if ($('.sorting_block').length > 0) $('.sorting_block').hide();
	</script>

<?}?>
		<?/*if($_GET["LAZI_".$NAV["NavNum"]]=="Y"){?>
		</div>
		<?}*/?>

<!--RestartBuffer_<?=$NAV["NavNum"]?>-->