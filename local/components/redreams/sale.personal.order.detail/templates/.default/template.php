<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$isCurator = \Redreams\Partners\partner::isCurator()?>
<?$isPartner = \Redreams\Partners\partner::isPartner()?>
<?
if ($isCurator && !empty($arResult['ERRORS']['FATAL']))
{
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
	 Array("USER_ID" => $operatorsIds, "ID" => $arParams["ID"]),
	 false,
	 false,
	 array('*'),
	 array()
	);
	$order = $orderRes->GetNext();
	//v($order);
	$arResult = $order;
	if($isPartner)
	{
		$bill = \Redreams\Partners\order::getBillByOrderID($order);
	}
	$status = CSaleStatus::GetByID($order["STATUS_ID"]);
	$delivery = CSaleDelivery::GetByID($order["DELIVERY_ID"]);
	
	$dbBasketItems = CSaleBasket::GetList(
		array(
				"NAME" => "ASC",
				"ID" => "ASC"
			),
		array(
				"ORDER_ID" => $arResult["ID"]
			),
		false,
		false,
		array("ID", "NAME", "CALLBACK_FUNC", "MODULE", 
			  "PRODUCT_ID", "QUANTITY", "DELAY", 
			  "CAN_BUY", "PRICE", "WEIGHT")
	);
	while ($arItem = $dbBasketItems->Fetch())
	{
		$basketItems[] = $arItem;
	}
	
	?>
	<div class="profilepage <?if($isPartner):?>partner_page<?endif?>">
		<div class='ph_detail <?if($isPartner):?>right_sidebar<?endif?>'>
			<?if($isPartner && $bill):?><a target="_blank" href="<?=$bill?>" class="download_bill">Скачать счет</a><?endif?>
			
			<div class='history_detail'>
				<p class='order_i'>Заказ №<?=$arResult['ID']?> от <?=$arResult["DATE_INSERT"]?></p>
				<? if ($arResult['ID_1C']) { ?><p class='order_i'>1С №: <?=$arResult['ID_1C']?></p><? } ?>
				<div class='ph_section'>
					<p class='val'>Текущий статус заказа:<span><?=$status["NAME"]?></span></p>
					<? if ($arResult["PRICE_DELIVERY"]) { ?><p class='val'>Доставка:<span><?=number_format($arResult["PRICE_DELIVERY"], 2, ".", " ")?> руб.</span></p><? } ?>
					<p class='val'>Сумма заказа:<span><?=$arResult["PRICE"]?></span></p>
				</div>
				
				<div class='ph_section'>
					<p class='val'>Служба доставки:<span><?=$delivery["NAME"]?></span></p>
				</div>

				<?foreach($basketItems as $prod):?>
					<?
					$allquan += $prod["QUANTITY"];
					$itemIds[] = $prod["PRODUCT_ID"];
					?>
				<?endforeach?>
				
				<?
				$elRes = \CIblockElement::GetList(array(), array("ID"=>$itemIds), false, false, array('*', 'PROPERTY_CML2_ARTICLE'));
				while($ar = $elRes->GetNext())
				{
					$elements[$ar["ID"]] = $ar;
				}
				?>
				

				<p class='main_ttl'>Состав заказа</p>
				<p class='summ'>Товаров  <?=$allquan?> шт.  |   <?=number_format($arResult["PRICE"], 2, ".", " ")?></p>

				<? if ($order["EXTERNAL_ORDER"] != "Y") { ?>
				
				<div class="basket_area">
					<p class='sec_b_tll'>Параметры заказа</p>
					<table class="hist_table">

						<tr>

							<th colspan="2">
								Товар
							</th>

							<th>
								Количество
							</th><!---->

							<th>
								Стоимость
							</th>

						</tr>
						<?$allsumm = 0?>
						
						<?foreach($basketItems as $prod):?>
							<?$allsumm += intval($prod['PRICE'])*$prod["QUANTITY"];?>
							<tr>

								<td class="im_area">
									<img src="<?=CFile::GetPath($elements[$prod["PRODUCT_ID"]]["DETAIL_PICTURE"]);?>">
								</td>

								<td class="item_td">
									<a href="#" class="name"><?=htmlspecialcharsEx($prod["NAME"])?></a>
									<span class="i">Код: <?=$elements[$prod["PRODUCT_ID"]]["PROPERTY_CML2_ARTICLE_VALUE"]?></span>
									
									<?if(intval($prod['DISCOUNT_PRICE'])):?>
										<span class="oldprice"><?=intval($prod["PRICE"]+$prod['DISCOUNT_PRICE'])?><span>руб.</span></span>
									<?endif;?>
									<p class="price"><?=intval($prod["PRICE"])?><span>руб.</span></p>
								</td>


								<td class="col">
									<!--<input type="text" class="inp_self" value="">-->
									<?=$prod["QUANTITY"]?>
									<span><?=$arResult['PROPERTIES'][$prod['PRODUCT_ID']]['CML2_BASE_UNIT']['VALUE']?></span>
								</td>

								<td class="fullprice">
									<?if(intval($prod['DISCOUNT_PRICE'])):?>
										<p class="old_price oldprice" style="text-decoration: line-through; color: #9a9fab;"><?=intval($prod["PRICE"]+$prod['DISCOUNT_PRICE'])*$prod["QUANTITY"]?> руб.</p>
									<?endif;?>
									<p class="price"><?=intval($prod["PRICE"])*$prod["QUANTITY"]?><span>руб.</span></p>
								</td>

							</tr>

						<?endforeach?>
					</table>

					<div class='fin_block'>

						<div class='fin_summ'><span class='value'>Итого</span><p class="price"><?=number_format($arResult["PRICE"], 2, ".", " ")?><span>руб.</span></p></div>
						<?if($isPartner && $bill):?>
							<a href="<?=$bill?>" target="_blank" class="download_bill">Скачать счет</a>
						<?endif?>
					</div>


					<div class="clear"></div>
				</div>
				<? } ?>

			</div>
		</div>
		<?include($_SERVER['DOCUMENT_ROOT']."/include/partner_right.php")?>
	</div>
	
	
	
	
<?
}
else
{
?>
<?
if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach ($arResult['ERRORS']['FATAL'] as $error)
	{
		ShowError($error);
	}

	echo 'Пожалуйста <a href="/auth/">авторизайтесь</a> для просмотра заказа.';
}
else
{
?>

<?if($isPartner)
{
	$bill = \Redreams\Partners\order::getBillByOrderID($arResult);
}

//Отгрузки
$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/1c-services/data/shipments.xml');
$shipments = array();
foreach($xml->A as $doc)
{
	$shipment = array();
	foreach($doc->Attributes() as $k => $v)
	{
		$v = trim($v);
		if ($k == "Id") $shipment["ID_1C"] = str_replace("SITE_", "", $v);
		if ($k == "R") $shipment["GUID"] = $v;
		if ($k == "NR") $shipment["N_TRANS"] = $v;
		if ($k == "Q") $shipment["N_SHIPMENT"] = $v;
		if ($k == "D") $shipment["DATE"] = $v;
		if ($k == "DO") $shipment["DATE_O"] = $v;
		if ($k == "PE") $shipment["TRANS_NAME"] = $v;
	}
	
	if ($arResult['ID_1C'] && $arResult['ID_1C'] == $shipment["ID_1C"])
	{
		foreach($doc->Noms as $n)
		{
			$item = array();
			foreach($n->Attributes() as $k => $v)
			{
				$v = trim($v);
				if ($k == "It") $item["GUID"] = $v;
				if ($k == "Art") $item["ARTICLE"] = $v;
				if ($k == "Num") $item["QUANTITY"] = $v;
			}
			$shipment["ITEMS"][] = $item;
		}
		$shipments[] = $shipment;
	}
}
if ($shipments)
{
	//var_dump($shipments);
}
?>
<div class="profilepage <?if($isPartner):?>partner_page<?endif?>">
	<div class='ph_detail <?if($isPartner):?>right_sidebar<?endif?>'>
		<?if($isPartner && $bill):?><a target="_blank" href="<?=$bill?>" class="download_bill">Скачать счет</a><?endif?>
		
		<div class='history_detail'>
			<p class='order_i'>Заказ №<?=$arResult['ID']?> от <?=$arResult["DATE_INSERT_FORMATED"]?></p>
			<? if ($arResult['ID_1C']) { ?><p class='order_i'>1С №: <?=$arResult['ID_1C']?></p><? } ?>
			<?/*
			<?if(!$isPartner && $arResult['STATUS_ID'] != 'N' && $arResult['CANCELED'] != 'Y') { ?>
				<?if($arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y"):?>
					<a class="pay_button" href="<?=$arResult["PAY_SYSTEM"]["PSA_ACTION_FILE"]?>" target="_blank">Оплатить</a>
				<?endif?>
			<? } ?>
			*/?>
			
			<div class='ph_section'>
				<p class='val'>Текущий статус заказа:<span><?=$arResult["STATUS"]["NAME"]?></span></p>
				<p class='val'>Сумма заказа:<span><?=$arResult["PRODUCT_SUM_FORMATTED"]?></span></p>
				<?/* if ($arResult["TAX_VALUE"]) { ?><p class='val'>Налог:<span><?=number_format($arResult["TAX_VALUE"], 2, ".", " ")?> руб.</span></p><? } */?>
				<? if ($arResult["PRICE_DELIVERY"]) { ?><p class='val'>Доставка:<span><?=number_format($arResult["PRICE_DELIVERY"], 2, ".", " ")?> руб.</span></p><? } ?>
				<? if ($arResult["PRICE_DELIVERY"]) { ?><p class='val'><b>Общая сумма:</b><span><?=number_format($arResult["PRICE"], 2, ".", " ")?> руб.</span></p><? } ?>
			</div>

<?/*
			<div class='ph_section'>

				<p class='ph_name'>Данные учетной записи</p>
				<p class='val'>Учетная запись:<span><?=$arResult["USER"]["LOGIN"]?></span></p>
				<p class='val'>E-mail:<span><?=$arResult["USER"]["EMAIL"]?></span></p>

			</div>
*/?>		
			<div class='ph_section'>
				<p class='ph_name'>Оплата и доставка</p>

				<? if ($arResult["PAY_SYSTEM"]["ID"] != 1) { ?><p class='val'>Платежная система:<span><?=$arResult["PAY_SYSTEM"]["NAME"]?></span></p><? } ?>
				<p class='val'>Оплачен: 
						<span>
						<?if($arResult["PAYED"] == "Y"):?>
							<?=GetMessage('SPOD_YES')?>
							<?if(strlen($arResult["DATE_PAYED_FORMATED"])):?>
								(<?=GetMessage('SPOD_FROM')?> <?=$arResult["DATE_PAYED_FORMATED"]?>)
							<?endif?>
						<?else:?>
							<?=GetMessage('SPOD_NO')?>
							<? if (1) { ?>
							<?if((!$isPartner || $USER->GetID() == 3535) && $arResult['STATUS_ID'] != 'N' && $arResult['CANCELED'] != 'Y' && ($arResult["PAY_SYSTEM"]["ID"] == 14 || $arResult["PAY_SYSTEM"]["ID"] == 15) && $arResult["PAY_SYSTEM"]["ACTIVE"] == 'Y') { ?>
								<?if($arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y"):?>
									<a href="<?=$arResult["PAY_SYSTEM"]["PSA_ACTION_FILE"]?>" target="_blank" style="margin-left: 20px;" class="pay_button">Оплатить</a>
								<?endif?>
							<? } ?>
							<? } ?>
						<?endif?>
						</span>
				</p>
				<p class='val'>Служба доставки:<span><?=$arResult["DELIVERY"]["NAME"]?></span></p>
			</div>
			
			<? if ($shipments) { ?>
				<div class='ph_section'>
					<p class='ph_name'>Отгрузки по заказу</p>
					<?foreach($shipments as $shipment) { ?>
						<p class='val'><b><?=$shipment["N_SHIPMENT"]?></b></p>
						<p class='val'>Дата отгрузки: <b><?=substr($shipment["DATE_O"], 0, 10)?></b></p>
						<? if ($shipment["TRANS_NAME"]) {?><p class='val'>Транспортная компания: <b><?=$shipment["TRANS_NAME"]?></b></p><? } ?>
						<? if ($shipment["N_TRANS"]) { ?><p class='val'> Номер транспортной накладной: <b><?=$shipment["N_TRANS"]?></b></p><? } ?>
							<table>
								<tr>
									<td style="width: 300px; padding: 0;"><b>Артикул</b></td>
									<td style="width: 50px; padding: 0;"><b>Количество</b></td>
								</tr>
								
								<?foreach($shipment["ITEMS"] as $k => $item) { ?>
									<tr>
										<td style="padding: 0;"><?=$item["ARTICLE"]?></td>
										<td style="padding: 0;"><?=$item["QUANTITY"]?></td>
									</tr>
								<? } ?>
							</table>
							<br><br>
					<? } ?>
				</div>
			<? } ?>
			
			<div class='ph_section'>
				<p class='ph_ttl'>Параметры заказа</p>

				<?foreach($arResult["ORDER_PROPS"] as $prop):?>
					<?if($prop['CODE'] == 'CITY') continue;?>
					<?if($prop["GROUP_NAME"] == 'Данные для доставки 2') continue;?>
					<?if($prop["GROUP_NAME"] == 'Данные компании 2') continue;?>
					<?if($prop["GROUP_NAME"] == 'Данные компании') continue;?>

					<?if($prop["SHOW_GROUP_NAME"] == "Y"):?>

						<p class='ph_name'><?=$prop["GROUP_NAME"]?></p>

					<?endif?>



					<p class='val'><?=$prop['NAME']?>

						<?if($prop["TYPE"] == "CHECKBOX"):?>
							<span><?=GetMessage('SPOD_'.($prop["VALUE"] == "Y" ? 'YES' : 'NO'))?></span>
						<?else:?>
							<span><?=$prop["VALUE"]?></span>
						<?endif?>
					</p>
				<?endforeach?>
			</div>

			

			<div class='ph_section'>
				<?if($arResult['USER_DESCRIPTION']):?>
					<p class='ph_name'>Комментарий пользователя</p>
					<p class='val'><?=$arResult['USER_DESCRIPTION']?></p>
				<?endif?>
			</div>

			<?foreach($arResult["BASKET"] as $prod):?>
				<?$allquan += $prod["QUANTITY"];?>
			<?endforeach?>

			<p class='main_ttl'>Состав заказа</p>
			<p class='summ'>Товаров  <?=$allquan?> шт.  |   <?=number_format($arResult["PRICE"], 2, ".", " ")?></p>

			<?//var_dump($arResult["ORDER_PROPS"]["EXTERNAL_ORDER"])?>
			<?
			$arOrder = CSaleOrder::GetByID($arResult["ID"]);
			?>
			<? if ($arOrder["EXTERNAL_ORDER"] != "Y") { ?>
			
			<div class="basket_area">
				<p class='sec_b_tll'>Параметры заказа</p>
				<table class="hist_table">

					<tr>

						<th colspan="2">
							Товар
						</th>

						<th>
							Количество
						</th><!---->

						<th>
							Наличие
						</th>

						<th>
							Стоимость
						</th>

					</tr>
					<?$allsumm = 0?>
					<?$alldiscount = 0?>
					<?foreach($arResult["BASKET"] as $prod):?>
						<?$allsumm += intval($prod['PRICE'])*$prod["QUANTITY"];?>
						<?$alldiscount += intval($prod['DISCOUNT_PRICE'])*$prod["QUANTITY"];?>

						<tr>

							<td class="im_area">
								<img src="<?=$prod['PICTURE']['SRC']?>">
							</td>

							<td class="item_td">
								<a href="<?=$arResult['FIELDS'][$prod['PRODUCT_ID']]["DETAIL_PAGE_URL"]?>" class="name"><?=htmlspecialcharsEx($prod["NAME"])?></a>
								<span class="i">Код: <?=$arResult['PROPERTIES'][$prod['PRODUCT_ID']]['CML2_ARTICLE']['VALUE']?></span>
								<!--<span class="i">Бренд: <?=$arResult['PRODUCT_PROPS'][$prod['PRODUCT_ID']]['IZGOTOVITEL_POZITSIYA_NOMENKLATURY']['VALUE']?></span>-->
								<?if(intval($prod['DISCOUNT_PRICE'])):?>
									<span class="oldprice"><?=intval($prod["PRICE"]+$prod['DISCOUNT_PRICE'])?><span>руб.</span></span>
								<?endif;?>
								<p class="price"><?=intval($prod["PRICE"])?><span>руб.</span></p>
							</td>


							<td class="col">
								<!--<input type="text" class="inp_self" value="">-->
								<?=$prod["QUANTITY"]?>
								<span><?=$arResult['PROPERTIES'][$prod['PRODUCT_ID']]['CML2_BASE_UNIT']['VALUE']?></span>
							</td>


							<td class="nal">
								<p>В наличии: <?=$arResult['QUANTS'][$prod['PRODUCT_ID']]?$arResult['QUANTS'][$prod['PRODUCT_ID']]:'0'?> шт.</p>
							</td>

							<td class="fullprice">
								<?if(intval($prod['DISCOUNT_PRICE'])):?>
									<p class="old_price oldprice" style="text-decoration: line-through; color: #9a9fab;"><?=intval($prod["PRICE"]+$prod['DISCOUNT_PRICE'])*$prod["QUANTITY"]?> руб.</p>
								<?endif;?>
								<p class="price"><?=intval($prod["PRICE"])*$prod["QUANTITY"]?><span>руб.</span></p>
							</td>

						</tr>

					<?endforeach?>

					<?/*
								<tr class="last">
									<td colspan="4">
										<div class="cart_fin">
											<?if($alldiscount):?>
											<p class="discount">Ваша скидка: <?=$alldiscount?> руб.</p>
											<?endif;?>
											<?if($arResult["PRICE_DELIVERY_FORMATED"]):?>
											<p class="discount">Стоимость доставки: <?=$arResult["PRICE_DELIVERY_FORMATED"]?></p>
											<?endif;?>
											<p class="fin_summ">Сумма к оплате: <?=$allsumm?> руб.</p>
										</div>
									</td>
								</tr>*/?>

				</table>

				<div class='fin_block'>

					<div class='fin_summ'><span class='value'>Итого</span><p class="price"><?=number_format($arResult["PRICE"], 2, ".", " ")?><span>руб.</span></p></div>
					<?if($isPartner && $bill):?>
						<a href="<?=$bill?>" target="_blank" class="download_bill">Скачать счет</a>
					<?endif?>
					<? if (!$bill) { ?>
					<a href='/personal/order/cancel/<?=$arResult['ID']?>/?CANCEL=Y' class='delete_order'>Отменить заказ</a>
					<? } ?>
					<a href='' class='close_order'>закрыть</a>
					<a href='/personal/order/index.php?ID=<?=$arResult['ID']?>&amp;COPY_ORDER=Y' class='submit_order'>Повторить заказ</a>

				</div>


				<div class="clear"></div>
			</div>
			<? } ?>

		</div>
	</div>
	<?include($_SERVER['DOCUMENT_ROOT']."/include/partner_right.php")?>
</div>
<? } ?>
<? } ?>