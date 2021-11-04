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
						
		<div class='sorting_block'>
			<p class='shown'>Город</p>
			
			<form method="get" style="display: inline-block;" >
			<select class='customSelect vac_sel sort_sel' name="city" >
				<option value="" >Все</option>
				<?foreach($arResult["CITY"] as $indx => $names):?>
				<option <?=$_REQUEST['city']==$names?"selected='selected'":""?> value="<?=$names?>" ><?=$names?></option>
				<?endforeach;?>
			</select>
			</form>
			
			<p class='shown'>Профессиональная область</p>
			
			<form method="get" style="display: inline-block;" >
			<select class='customSelect vac_sel sort_sel pr' name="grp" >
				<option value="" >Все</option>
				<?foreach($arResult["GROUPS"] as $indx => $names):?>
				<option <?=$_REQUEST['grp']==$names?"selected='selected'":""?> value="<?=$names?>" ><?=$names?></option>
				<?endforeach;?>
			</select>
			</form>
			
			<div class='clear'></div>
		</div>
		
				
					<table class='vac_table'>
					
							<?if($arResult["ITEMS"]):?>
							<?foreach($arResult["ITEMS"] as $indx => $arItem):?>
								<?
								$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
								?>
								<?//p($arItem);?>
								<tr>
									<td id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
										<a href='<?=$arItem["DETAIL_PAGE_URL"]?>'><?echo $arItem["NAME"]?></a>
									</td>
									<td><?=$arItem["PROPERTIES"]["CITY"]["VALUE"]?></td>
								</tr>
							<?endforeach;?>
							<?endif;?>
					</table>	
					
					<!--<a href="" class="show_more"></a>-->
					<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
						<?=$arResult["NAV_STRING"]?>
					<?endif;?>