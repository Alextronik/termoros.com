<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

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
	
	<?if(empty($arResult['ORDERS'])):?>
		<?=GetMessage('SPOL_NO_ORDERS')?>
	<?else:?>
	
	<div class="profilepage">
				<div class='prof_history'>
					
					
					<div class='prof_line th'>
						<div class='order_i'><span>Заказ</span></div>
						<div class='date'><span>Размещение<a href='' class='down'></a><a href='' class='up'></a></span></div>
						<div class='summ'><span>Изменение</span></div>
						<div class='price_wp'><span>Стоимость</span></div>
						<div class='stat'><span>Статус<a href='' class='down'></a><a href='' class='up'></a></span></div>
						<div class='actions'></div>
					</div>
					
						<?//p($arResult["ORDERS"]);?>
						<?foreach($arResult["ORDERS"] as $index => $val):?>
						<?$discountSumm = 0;?>
						<?$quan = 0;?>
						<?foreach($val['ITEMS'] as $vval){
							$quan += $vval;
							
						}?>
						<?//p($arResult);?>
						<div class='prof_line'>
							<div class='order_i'><a href='?ID=<?=$index?>'>Заказ №<?=$index+1?></a></div>
							<div class='date'><span><?=$val['DATE']?></span></div>
							<div class='summ'><span><?=$val['DATE']?></span></div>
							<div class='price_wp'><p class='price'><?=CurrencyFormat(intval($val["PRICE"]), 'RUB');?></p></div>
							<div class='stat'><span>Отложен</span></div>
							<div class='actions'>
								<a href="?ID=<?=$index?>" class="quick_b"><span class="it_ttl">просмотреть заказ</span></a>
								<a href="?ID=<?=$index?>&action=copy" class="repeat_btn"><span class="it_ttl">повторить заказ</span></a>
								<a href="?ID=<?=$index?>&action=cancel" class="delete_item"><span class="it_ttl">удалить заказ</span></a>
							</div>
						</div>
						
						<?endforeach;?>

					<?if(strlen($arResult['NAV_STRING'])):?>
						<?=$arResult['NAV_STRING']?>
					<?endif?>
					
				</div>
	</div>	
	<?endif?>	
<?endif?>