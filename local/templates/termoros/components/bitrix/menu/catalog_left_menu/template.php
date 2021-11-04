<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

if (empty($arResult))
	return;

$extSaleLink = '';
if ($arParams['IS_SALE']) $extSaleLink = '?sort=property_TMR_SALE&order=desc';

?>
<div class='left_menu'>
	<?foreach($arResult["ALL_ITEMS_ID"] as $itemIdLevel_1=>$arItemsLevel_2){?>
		<?if($arResult["ALL_ITEMS"][$itemIdLevel_1]["SELECTED"]=='Y' || $arParams['IS_SALE']) { ?>
			<? foreach ($arItemsLevel_2 as $itemIdLevel_2 => $arItemsLevel_3) { ?>
				<a href='<?= $arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"].$extSaleLink ?>'
				   class='ttl<?= $arResult["ALL_ITEMS"][$itemIdLevel_2]["SELECTED"] == 'Y' ? " active" : "" ?>'><?= $arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"] ?></a>
				<? if ($arResult["ALL_ITEMS"][$itemIdLevel_2]["SELECTED"] == 'Y' || $arParams['IS_SALE']) { ?>
					<? if (is_array($arItemsLevel_3) && !empty($arItemsLevel_3)) { ?>
						<ul class='left_list'>
							<? foreach ($arItemsLevel_3 as $itemIdLevel_3 => $itemIdLevel_4) { ?>
								<li><a href='<?= $arResult["ALL_ITEMS"][$itemIdLevel_3]["LINK"].$extSaleLink ?>'
									   <? if ($arResult["ALL_ITEMS"][$itemIdLevel_3]["SELECTED"] == 'Y'): ?>class="active"<? endif ?>><?= $arResult["ALL_ITEMS"][$itemIdLevel_3]["TEXT"] ?></a>
									   
									   <? if (is_array($itemIdLevel_4) && !empty($itemIdLevel_4)) { ?>
											<ul class='left_list sublvlmenu'>
												<? foreach ($itemIdLevel_4 as $arItemsLevel_4) { ?>
													<li><a href='<?= $arResult["ALL_ITEMS"][$arItemsLevel_4]["LINK"].$extSaleLink ?>'
														   <? if ($arResult["ALL_ITEMS"][$arItemsLevel_4]["SELECTED"] == 'Y'): ?>class="active"<? endif ?>><?=$arResult["ALL_ITEMS"][$arItemsLevel_4]["TEXT"] ?></a>
													</li>
													
													<?
												} ?>
											</ul>
										<?
										}
										?>
								</li>
								
								
								<?
							} ?>
						</ul>
						<?
					}
				}
			}
		}
	}?>
</div>


