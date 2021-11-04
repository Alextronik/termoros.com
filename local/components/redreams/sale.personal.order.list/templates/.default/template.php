<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$isPartner = \Redreams\Partners\partner::isPartner()?>
<?$isCurator = \Redreams\Partners\partner::isCurator()?>
<?if(!empty($arResult['ERRORS']['FATAL'])):?>

	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?=ShowError($error)?>
	<?endforeach?>

<?else:?>

	<? if (!$_GET['operators']) { ?>
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

			<? if ($isCurator) { ?>
				<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?operators=Y">Заказы операторов</a>
			<? } ?>
			
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
					<?
					
					//if ($USER->GetID() == 1761)
					//{
						
						$r = CSaleOrderPropsValue::GetOrderProps($val["ORDER"]['ID']);
						while($ar = $r->GetNext())
						{
							if ($ar["CODE"] == "COMPANY" && $ar["VALUE"])
							{
								$trueContractor = $ar["VALUE"];
							}
						}
					//}
					?>
					<?if($isPartner)
					{
						$bill = \Redreams\Partners\order::getBillByOrderID($val['ORDER']);
					}
					?>
					<?$discountSumm = 0;?>
					<?$quan = 0;?>
					<?foreach($val["BASKET_ITEMS"] as $vval){
						$quan += $vval["QUANTITY"];

					}?>
					<?//p($arResult);?>
					<div class='prof_line'>
						<?if($isPartner):?>
							<div class="order_i">
								<?=($trueContractor)?$trueContractor:$arResult['PROFILES'][$arResult['EMAILS'][$val["ORDER"]['ID']]]?>
							</div>
							<?// if ($USER->GetID() == 1761) { var_dump($val["ORDER"]["ID_1C"]); } ?>
							<div class='date'><a href='<?=$val["ORDER"]["URL_TO_DETAIL"]?>'><? if ($val["ORDER"]["ID_1C"]) { ?><?=$val["ORDER"]["ID_1C"]?><? } else { ?><?=$val["ORDER"]["ACCOUNT_NUMBER"]?><? } ?></a> от <?=$val['ORDER']['DATE_INSERT_FORMATED']?></div>
						<?else:?>
							<div class='order_i'><a href='<?=$val["ORDER"]["URL_TO_DETAIL"]?>'>Заказ №<?=$val["ORDER"]["ACCOUNT_NUMBER"]?></a></div>
							<div class='date'><span><?=$val['ORDER']['DATE_INSERT_FORMATED']?></span></div>
						<?endif?>
						<div class='summ'><span><?=$val['ORDER']['DATE_STATUS_FORMATED']//DATE_STATUS_FORMATED=$quan?></span></div>
						<?/*<div class='price_wp'><p class='price'><?=CurrencyFormat(intval($val["ORDER"]["PRICE"]-$val["ORDER"]['PRICE_DELIVERY']), 'RUB');?></p></div>*/?>
						<div class='price_wp'><p class='price'><?=CurrencyFormat(intval($val["ORDER"]["PRICE"]), 'RUB');?></p></div>
						<div class='stat'>
						<span>
						<? if ($val['ORDER']['CANCELED'] == 'Y') { ?>
							Отменен
						<? } else { ?>
						<?=str_replace("/", " / ", $arResult["INFO"]["STATUS"][$val["ORDER"]["STATUS_ID"]]["NAME"])?>
						<? } ?>
						</span></div>
						<div class='actions'>
							<a href="<?=$val["ORDER"]["URL_TO_DETAIL"]?>" class="quick_b"><span class="it_ttl">просмотреть заказ</span></a>
							<a href="<?=$val["ORDER"]["URL_TO_COPY"]?>" class="repeat_btn"><span class="it_ttl">повторить заказ</span></a>
							<?if($isPartner && $bill):?><a target="_blank" href="<?=$bill?>" class="dwnld"><span class="it_ttl">скачать счет</span></a><?endif?>
							<? if (!$bill) { ?>
							<a href="<?=$val["ORDER"]["URL_TO_CANCEL"]?>" class="delete_item"><span class="it_ttl">удалить заказ</span></a>
							<? } ?>
						</div>
					</div>

				<?endforeach;?>

				<?if(strlen($arResult['NAV_STRING'])):?>
					<?=$arResult['NAV_STRING']?>
				<?endif?>

			</div>
		</div>
	
	<? } else { ?>
		
		<?
		unset($arResult["ORDERS"]);
		
		$by = "id";
		$order = "asc";
		$filter = array(
			'ACTIVE' => "Y",
			'GROUPS_ID' => array(13),
			'UF_CURATOR_ID' => $USER->GetID()
		);
		$dbUser = \CUser::GetList($by, $order, $filter, array('*', "SELECT" => array('UF_*')));
		while($bxUser = $dbUser->GetNext())
		{
			$operators[$bxUser["ID"]] = $bxUser["ID"];
			$operatorsIds[] = $bxUser["ID"];
		}
				
		$orderRes = CSaleOrder::GetList(
		 Array("ID"=>"DESC"),
		 Array("USER_ID" => $operatorsIds),
		 false,
		 false,
		 array('*'),
		 array()
		);
		while($ar = $orderRes->GetNext())
		{
			$orders[] = $ar;
			//v($ar);
		}
		
		?>
		<?if(empty($orders)):?>
			<?=GetMessage('SPOL_NO_ORDERS')?>
		<?endif?>
		
		<?if($isPartner):?>	<div class="partner_page profilepage agent_block orders"><?endif?>

		<div class="bx_my_order_switch">

			<?$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);?>

			<? if ($isCurator) { ?>
				<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?operators=Y">Заказы операторов</a>
			<? } ?>
			
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


				<?foreach($orders as $val):?>
					<?
					
					//if ($USER->GetID() == 1761)
					//{
						
						$r = CSaleOrderPropsValue::GetOrderProps($val['ID']);
						while($ar = $r->GetNext())
						{
							if ($ar["CODE"] == "COMPANY" && $ar["VALUE"])
							{
								$trueContractor = $ar["VALUE"];
							}
						}
					//}
					?>
					<?if($isPartner)
					{
						$bill = \Redreams\Partners\order::getBillByOrderID($val);
					}
					?>
					<?$discountSumm = 0;?>
					<?$quan = 0;?>
					<?/*foreach($val["BASKET_ITEMS"] as $vval){
						$quan += $vval["QUANTITY"];

					}*/
					?>
					
					<div class='prof_line'>
						<?if($isPartner):?>
							<div class="order_i">
								<?=($trueContractor)?$trueContractor:$arResult['PROFILES'][$arResult['EMAILS'][$val["ORDER"]['ID']]]?>
							</div>
							<?// if ($USER->GetID() == 1761) { var_dump($val["ORDER"]["ID_1C"]); } ?>
							<div class='date'><a href='/personal/order/detail/<?=$val["ID"]?>/'><? if ($val["ID_1C"]) { ?><?=$val["ID_1C"]?><? } else { ?><?=$val["ID"]?><? } ?></a> от <?=substr($val['DATE_INSERT'],0,10)?></div>
						<?else:?>
							<div class='order_i'><a href='/personal/order/detail/<?=$val["ID"]?>/'>Заказ №<?=$val["ID"]?></a></div>
							<div class='date'><span><?=substr($val["DATE_INSERT"],0,10)?></span></div>
						<?endif?>
						<div class='summ'><span><?=substr($val["DATE_UPDATE"],0,10)?></span></div>
						<?/*<div class='price_wp'><p class='price'><?=CurrencyFormat(intval($val["ORDER"]["PRICE"]-$val["ORDER"]['PRICE_DELIVERY']), 'RUB');?></p></div>*/?>
						<div class='price_wp'><p class='price'><?=CurrencyFormat(intval($val["PRICE"]), 'RUB');?></p></div>
						<div class='stat'>
						<span>
						<? if ($val['CANCELED'] == 'Y') { ?>
							Отменен
						<? } else { ?>
						<?$status = CSaleStatus::GetByID($val["STATUS_ID"]);
						?>
						<?=str_replace("/", " / ", $status["NAME"])?>
						<? } ?>
						</span></div>
						<div class='actions'>
							<a href="/personal/order/detail/<?=$val["ID"]?>/" class="quick_b"><span class="it_ttl">просмотреть заказ</span></a>
							<?if($isPartner && $bill):?><a target="_blank" href="<?=$bill?>" class="dwnld"><span class="it_ttl">скачать счет</span></a><?endif?>
						</div>
					</div>

				<?endforeach;?>

				<?if(strlen($arResult['NAV_STRING'])):?>
					<?=$arResult['NAV_STRING']?>
				<?endif?>

			</div>
		</div>

	<? } ?>
	<?include($_SERVER['DOCUMENT_ROOT']."/include/partner_right.php")?>
	<?if($isPartner):?>	</div><?endif?>
<?endif?>