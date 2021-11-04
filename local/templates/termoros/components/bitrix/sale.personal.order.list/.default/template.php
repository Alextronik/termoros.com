<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$isPartner = \Redreams\Partners\partner::isPartner()?>
<?if(!empty($arResult['ERRORS']['FATAL'])):?>

	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?=ShowError($error)?>
	<?endforeach?>

<?else:?>

	<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

		<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?endif?>
	<?//p($arResult)?>
	<?if(empty($arResult['ORDERS'])):?>
		<?=GetMessage('SPOL_NO_ORDERS')?>
	<?endif?>
	<?if($isPartner):?>	<div class="partner_page profilepage agent_block orders"><?endif?>

	<div class="bx_my_order_switch">

		<?$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);?>

		<?if($nothing || isset($_REQUEST["filter_history"])):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?show_all=Y"><?=GetMessage('SPOL_ORDERS_ALL')?></a>
		<?endif?>

		<?if($_REQUEST["filter_history"] == 'Y' || $_REQUEST["show_all"] == 'Y'):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N"><?=GetMessage('SPOL_CUR_ORDERS')?></a>
		<?endif?>

		<?if($nothing || $_REQUEST["filter_history"] == 'N' || $_REQUEST["show_all"] == 'Y'):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y"><?=GetMessage('SPOL_ORDERS_HISTORY')?></a>
		<?endif?>

	</div>

	<div class="profilepage <?if($isPartner):?>right_sidebar<?endif?>">
				<div class='prof_history'>


					<div class='prof_line th'>
						<?if($isPartner):?>
							<div class='order_i'><span>Контрагент</span></div>
							<div class='date'><span>Заказ</span></div>
						<?endif?>

						<?if(!$isPartner):?>
							<div class='order_i'><span>Заказ</span></div>
							<div class='date'><span>Размещение<a href='' class='down'></a><a href='' class='up'></a></span></div>
						<?endif;?>
						<div class='summ'><span>Изменение</span></div>
						<div class='price_wp'><span>Стоимость</span></div>
						<div class='stat'><span>Статус<a href='' class='down'></a><a href='' class='up'></a></span></div>
						<div class='actions'></div>
					</div>


						<?foreach($arResult["ORDERS"] as $val):?>
						<?$discountSumm = 0;?>
						<?$quan = 0;?>
						<?foreach($val["BASKET_ITEMS"] as $vval){
							$quan += $vval["QUANTITY"];

						}?>
						<?//p($arResult);?>
						<div class='prof_line'>
							<?if($isPartner):?>
								<div class="order_i">
									<?=$arResult['PROFILES'][$arResult['EMAILS'][$val["ORDER"]['ID']]]?>
								</div>
								<div class='date'><a href='<?=$val["ORDER"]["URL_TO_DETAIL"]?>'>Заказ №<?=$val["ORDER"]["ACCOUNT_NUMBER"]?></a> от <?=$val['ORDER']['DATE_INSERT_FORMATED']?></div>
							<?else:?>
								<div class='order_i'><a href='<?=$val["ORDER"]["URL_TO_DETAIL"]?>'>Заказ №<?=$val["ORDER"]["ACCOUNT_NUMBER"]?></a></div>
								<div class='date'><span><?=$val['ORDER']['DATE_INSERT_FORMATED']?></span></div>
							<?endif?>
							<div class='summ'><span><?=$val['ORDER']['DATE_STATUS_FORMATED']//DATE_STATUS_FORMATED=$quan?></span></div>
							<div class='price_wp'><p class='price'><?=CurrencyFormat(intval($val["ORDER"]["PRICE"]-$val["ORDER"]['PRICE_DELIVERY']), 'RUB');?></p></div>
							<div class='stat'><span>
							<? if ($val['CANCELED'] == 'Y') { ?>
								Отменен
							<? } else { ?>
							<?=$arResult["INFO"]["STATUS"][$val["ORDER"]["STATUS_ID"]]["NAME"]?>
							<? } ?>
							</span></div>
							<div class='actions'>
								<a href="<?=$val["ORDER"]["URL_TO_DETAIL"]?>" class="quick_b"><span class="it_ttl">просмотреть заказ</span></a>
								<a href="<?=$val["ORDER"]["URL_TO_COPY"]?>" class="repeat_btn"><span class="it_ttl">повторить заказ</span></a>
								<?if($isPartner):?><a href="" class="dwnld"><span class="it_ttl">скачать счет</span></a><?endif?>
								<a href="<?=$val["ORDER"]["URL_TO_CANCEL"]?>" class="delete_item"><span class="it_ttl">удалить заказ</span></a>
							</div>
						</div>

						<?endforeach;?>

					<?if(strlen($arResult['NAV_STRING'])):?>
						<?=$arResult['NAV_STRING']?>
					<?endif?>

				</div>
	</div>
	<? include($_SERVER['DOCUMENT_ROOT'] . "/include/partner_right.php") ?>
	<?if($isPartner):?>	</div><?endif?>
<?endif?>