<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $USER;?>
<?if (!empty($arResult)):
	$page = $APPLICATION->GetCurPage();
	?>
	<?//p($arResult);?>
	<div class='catlink_wp<?=$page=="/"?" opened noclose":""?>'>
		<a href='/catalog' class='name'>Каталог продукции</a>
		<a href='/catalog' class='catlink'></a>

		<ul class='catlink_menu <?=$page=="/"?" noshad":""?>'>
			<?foreach($arResult["ALL_ITEMS_ID"] as $itemIdLevel_1=>$arItemsLevel_2):?> <!-- first level-->
				<li>
                    <a class="<?if($arResult["ALL_ITEMS"][$itemIdLevel_1]["SELECTED"]=='Y'):?>selected<?endif?>" href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_1]["LINK"]?>"><?=$arResult["ALL_ITEMS"][$itemIdLevel_1]["TEXT"]?>
                        <?if ($arResult["ALL_ITEMS"][$itemIdLevel_1]["LINK"] == '/catalog/sales/') { ?>
                            <div class="menu_sales_icon" src="<?=SITE_TEMPLATE_PATH?>/img/sale_label_small.png"></div>
                        <?} elseif ($arResult["ALL_ITEMS"][$itemIdLevel_1]["LINK"] == '/catalog/utsenka/'){?>
                            <div class="menu_reject_icon" src="<?=SITE_TEMPLATE_PATH?>/img/reject.png"></div>
                        <?}?>
                    </a>
					<?if (is_array($arItemsLevel_2) && !empty($arItemsLevel_2)):?>
					<div class='cat_submenu'>
						<ul>
							<?foreach($arItemsLevel_2 as $itemIdLevel_2=>$arItemsLevel_3):?> <!-- second level-->
								<li>
									<a <?if($arResult["ALL_ITEMS"][$itemIdLevel_2]["SELECTED"]=='Y'):?>class="selected"<?endif?> href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>" class="ttl"><?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"]?></a>
									
									<? if (is_array($arItemsLevel_3) && !empty($arItemsLevel_3)) { ?>
										<ul class='left_list'>
											<? foreach ($arItemsLevel_3 as $itemIdLevel_3) { ?>
												<li><a class="t3l" href='<?= $arResult["ALL_ITEMS"][$itemIdLevel_3]["LINK"] ?>'
													   <? if ($arResult["ALL_ITEMS"][$itemIdLevel_3]["SELECTED"] == 'Y'): ?>class="active"<? endif ?>><?= $arResult["ALL_ITEMS"][$itemIdLevel_3]["TEXT"] ?></a>
												</li>
												<?
											} ?>
										</ul>
										<?
									}?>
									
								</li>
							<?endforeach?>
						</ul>
						<div class="clear"></div>
					</div>
					<?endif?>
				</li>
			<?endforeach?>
		</ul>
	</div>
<?endif?>