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

$NAV=array(
	"NavPageCount"=>$arResult["NAV_RESULT"]->NavPageCount,
	"NavPageNomer"=>$arResult["NAV_RESULT"]->NavPageNomer,
	"NavPageNomerNext"=>$arResult["NAV_RESULT"]->NavPageNomer+1,
	"NavNum"=>$arResult["NAV_RESULT"]->NavNum,
);
$templateData["NAV"]=$NAV;

?>
					<?if(!$arParams['NOFILTER']):?>
					<div class='sorting_block np'>
						
						<div class='sorting_view'>
							<span class='name'>Показать <?=$arParams['PAGER_TITLE']?>:</span>
							<form method="get" style="display: inline-block;" action="<?//=$APPLICATION->GetCurPageParam("",array());?>" >
							<select class='customSelect sort_year sort_sel' name="year" >
								<option value="" >все</option>
								<option value="2019" <?if($_REQUEST['year'] == 2019):?>selected<?endif;?> >2019</option>
								<option value="2018" <?if($_REQUEST['year'] == 2018):?>selected<?endif;?> >2018</option>
								<option value="2017" <?if($_REQUEST['year'] == 2017):?>selected<?endif;?> >2017</option>
								<option value="2016" <?if($_REQUEST['year'] == 2016):?>selected<?endif;?> >2016</option>
								<option value="2015" <?if($_REQUEST['year'] == 2015):?>selected<?endif;?> >2015</option>
								<option value="2014" <?if($_REQUEST['year'] == 2014):?>selected<?endif;?> >2014</option>
								<option value="2013" <?if($_REQUEST['year'] == 2013):?>selected<?endif;?> >2013</option>
								<option value="2012" <?if($_REQUEST['year'] == 2012):?>selected<?endif;?> >2012</option>
								<option value="2011" <?if($_REQUEST['year'] == 2011):?>selected<?endif;?> >2011</option>
							</select>
							</form>
						</div>
						<? if ($arParams['IS_ACTION']) { ?>
						<?
						$res = CIblockElement::GetList(
							array("NAME" => "ASC"),
							array("IBLOCK_ID" => 5, "ACTIVE" => "Y"),
							false,
							false,
							array("*", "PROPERTY_BRAND")
						);
						while($ar = $res->GetNext())
						{
							if ($ar["PROPERTY_BRAND_VALUE"]) $brands[$ar["PROPERTY_BRAND_VALUE"]] = $ar["PROPERTY_BRAND_VALUE"];
							
						}
						$res = CIblockElement::GetList(
							array("NAME" => "ASC"),
							array("IBLOCK_ID" => 17, "ACTIVE" => "Y", "ID" => $brands),
							false,
							false,
							array()
						);
						
						?>
						<div class='sorting_view' style="margin-right: 50px;">
							<span class='name'>Бренд:</span>
							<form method="get" style="display: inline-block;text-align:left;" action="<?//=$APPLICATION->GetCurPageParam("",array());?>" >
							<select class='customSelect brand_sel  sort_sel' name="brand" style="width:150px;">
								<option value="" >все бренды</option>
								<? while($ar = $res->GetNext()) { ?>
									<option value="<?=$ar["ID"]?>" <?if($_REQUEST['brand'] == $ar["ID"]):?>selected<?endif;?> ><?=$ar["NAME"]?></option>
								<? } ?>
							</select>
							</form>
						</div>
						<? } ?>
						<div class='clear'></div>
					</div>
					<?endif;?>
					<div class="news_page" >
					<div class='main_articles'>
							
							<?if($arResult["ITEMS"]):?>
							<?/*foreach($arResult["ITEMS"] as $indx => $arItem):?>
								<?
								$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
								?>
								<?*/
							/*	if($arItem["PREVIEW_PICTURE"]['ID'])
									$imgid = resize($arItem["PREVIEW_PICTURE"]['ID'], 960, 365, 3);
								elseif($arItem["DETAIL_PICTURE"]['ID'])
									$imgid = resize($arItem["DETAIL_PICTURE"]['ID'], 960, 365, 3);
								else
									$imgid = '';	*/
								/*?>
								<div class='ma_block news purp' id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
									<span class='label'>новости</span>
									<p class='ttl'><?echo $arItem["NAME"]?></p>
									<p class='txt'><?echo $arItem["PREVIEW_TEXT"];?></p>
									<p class='date'><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
									<a href='<?=$arItem["DETAIL_PAGE_URL"]?>' class='more_lnk'><span><img src='<?=SITE_TEMPLATE_PATH?>/img/more_lnk.png' class='ico'>подробнее</span></a>
								</div>
							<?endforeach;*/?>
							<? 
							
							if ($arResult["ID"] == 5) {
								foreach($arResult["ITEMS"] as $k => $arItem) {
									if ($arItem["DISPLAY_PROPERTIES"]["END_DATE"]["VALUE"])
									{
										$endArr = explode(".", $arItem["DISPLAY_PROPERTIES"]["END_DATE"]["VALUE"]);
										$endFrom = mktime(0,0,0,$endArr[1],$endArr[0], $endArr[2]);
										if (time() > $endFrom) $arResult["ITEMS"][$k]["END"] = TRUE;
									}
								}
							} 
							?>
							<div class='ma_left fixed row'>
								<?if($arResult["ITEMS"][0]):?>
								<div class='ma_block news purp col-12 col-md-4' id="<?//=$this->GetEditAreaId($arItem['ID']);?>" >
									<span class='label'><?=$arParams['PAGER_TITLE']?></span>
									<p class='ttl'><?echo $arResult["ITEMS"][0]["NAME"]?></p><br>
									<?if ($arResult["ITEMS"][0]["END"]) { ?><p class='txt'><b style="color: #d04420;">Акция завершена</b><br><br></p><? } ?>
									<p class='txt'><?echo TruncateText($arResult["ITEMS"][0]["PREVIEW_TEXT"], 150);?></p>
									<p class='date'><?echo $arResult["ITEMS"][0]["DISPLAY_ACTIVE_FROM"]?></p>
									<a href='<?=$arResult["ITEMS"][0]["DETAIL_PAGE_URL"]?>' class='more_lnk'><span><img src='<?=SITE_TEMPLATE_PATH?>/img/more_lnk.png' class='ico'><?if ($arResult["ITEMS"][0]["END"]) { ?><br>Акция завершена<? } else { ?>подробнее<? } ?></span></a>
								</div>
								<?endif;?>
								<?if($arResult["ITEMS"][1]):?>
								<div class='ma_block news col-12 col-md-4'>
									<span class='label'><?=$arParams['PAGER_TITLE']?></span>
									<p class='ttl'><?echo $arResult["ITEMS"][1]["NAME"]?></p><br>
									<?if ($arResult["ITEMS"][1]["END"]) { ?><p class='txt'><b style="color: #d04420;">Акция завершена</b><br><br></p><? } ?>
									<p class='txt'><?echo TruncateText($arResult["ITEMS"][1]["PREVIEW_TEXT"], 150);?></p>
									<p class='date'><?echo $arResult["ITEMS"][1]["DISPLAY_ACTIVE_FROM"]?></p>
									<a href='<?=$arResult["ITEMS"][1]["DETAIL_PAGE_URL"]?>' class='more_lnk'><span><img src='<?=SITE_TEMPLATE_PATH?>/img/more_lnk.png' class='ico'><?if ($arResult["ITEMS"][1]["END"]) { ?><br>Акция завершена<? } else { ?>подробнее<? } ?></span></a>
								</div>
								<?endif;?>
								<?if($arResult["ITEMS"][2]):?>
								<div class='ma_block news green col-12 col-md-4'>
									<span class='label'><?=$arParams['PAGER_TITLE']?></span>
									<p class='ttl'><?echo $arResult["ITEMS"][2]["NAME"]?></p><br>
									<?if ($arResult["ITEMS"][2]["END"]) { ?><p class='txt'><b style="color: #d04420;">Акция завершена</b><br><br></p><? } ?>
									<p class='txt'><?echo TruncateText($arResult["ITEMS"][2]["PREVIEW_TEXT"], 150);?></p>
									<p class='date'><?echo $arResult["ITEMS"][2]["DISPLAY_ACTIVE_FROM"]?></p>
									<a href='<?=$arResult["ITEMS"][2]["DETAIL_PAGE_URL"]?>' class='more_lnk'><span><img src='<?=SITE_TEMPLATE_PATH?>/img/more_lnk.png' class='ico'><?if ($arResult["ITEMS"][2]["END"]) { ?><br>Акция завершена<? } else { ?>подробнее<? } ?></span></a>
								</div>
								<?endif;?>
								<?if($arResult["ITEMS"][3]):?>
								<div class='ma_block news col-12 col-md-4'>
									<span class='label'><?=$arParams['PAGER_TITLE']?></span>
									<p class='ttl'><?echo $arResult["ITEMS"][3]["NAME"]?></p><br>
									<?if ($arResult["ITEMS"][3]["END"]) { ?><p class='txt'><b style="color: #d04420;">Акция завершена</b><br><br></p><? } ?>
									<p class='txt'><?echo TruncateText($arResult["ITEMS"][3]["PREVIEW_TEXT"], 150);?></p>
									<p class='date'><?echo $arResult["ITEMS"][3]["DISPLAY_ACTIVE_FROM"]?></p>
									<a href='<?=$arResult["ITEMS"][3]["DETAIL_PAGE_URL"]?>' class='more_lnk'><span><img src='<?=SITE_TEMPLATE_PATH?>/img/more_lnk.png' class='ico'><?if ($arResult["ITEMS"][3]["END"]) { ?><br>Акция завершена<? } else { ?>подробнее<? } ?></span></a>
								</div>
								<?endif;?>
								
							<!--</div>
							
							<div class='ma_right'>-->
								<?if($arResult["ITEMS"][4]):?>
								<div class='ma_block news light_green col-12 col-md-4'>
									<span class='label'><?=$arParams['PAGER_TITLE']?></span>
									<p class='ttl'><?echo $arResult["ITEMS"][4]["NAME"]?></p><br>
									<?if ($arResult["ITEMS"][4]["END"]) { ?><p class='txt'><b style="color: #d04420;">Акция завершена</b><br><br></p><? } ?>
									<p class='txt'><?echo TruncateText($arResult["ITEMS"][4]["PREVIEW_TEXT"], 150);?></p>
									<p class='date'><?echo $arResult["ITEMS"][4]["DISPLAY_ACTIVE_FROM"]?></p>
									<a href='<?=$arResult["ITEMS"][4]["DETAIL_PAGE_URL"]?>' class='more_lnk'><span><img src='<?=SITE_TEMPLATE_PATH?>/img/more_lnk.png' class='ico'><?if ($arResult["ITEMS"][4]["END"]) { ?><br>Акция завершена<? } else { ?>подробнее<? } ?></span></a>
								</div>
								<?endif;?>
								<?if($arResult["ITEMS"][5]):?>
								<div class='ma_block news col-12 col-md-4'>
									<span class='label'><?=$arParams['PAGER_TITLE']?></span>
									<p class='ttl'><?echo $arResult["ITEMS"][5]["NAME"]?></p><br>
									<?if ($arResult["ITEMS"][5]["END"]) { ?><p class='txt'><b style="color: #d04420;">Акция завершена</b><br><br></p><? } ?>
									<p class='txt'><?echo TruncateText($arResult["ITEMS"][5]["PREVIEW_TEXT"], 150);?></p>
									<p class='date'><?echo $arResult["ITEMS"][5]["DISPLAY_ACTIVE_FROM"]?></p>
									<a href='<?=$arResult["ITEMS"][5]["DETAIL_PAGE_URL"]?>' class='more_lnk'><span><img src='<?=SITE_TEMPLATE_PATH?>/img/more_lnk.png' class='ico'><?if ($arResult["ITEMS"][5]["END"]) { ?><br>Акция завершена<? } else { ?>подробнее<? } ?></span></a>
								</div>
								<?endif;?>
							</div>
							<?else:?>
							<p>не найдено элементов.</p>
							<?endif;?>
							
							<div class='clear'></div>							
					</div>
					
					
					<?if($NAV["NavPageCount"]>$NAV["NavPageNomer"]){
					$page= $APPLICATION->GetCurPageParam("PAGEN_".$NAV["NavNum"]."=".$NAV["NavPageNomerNext"]."&LAZI_".$NAV["NavNum"]."=Y", array("PAGEN_".$NAV["NavNum"], "LAZI_".$NAV["NavNum"]));
					?>
					<a href='<?=$page?>' class='show_more news'></a>
					<?}?>
					
					
					<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
						<?=$arResult["NAV_STRING"]?>
					<?endif;?>
					</div>