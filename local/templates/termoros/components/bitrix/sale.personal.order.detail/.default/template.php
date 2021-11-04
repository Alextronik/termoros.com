<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$isPartner = \Redreams\Partners\partner::isPartner()?>
<?if($isPartner)
{
	$xmlID = \Redreams\Partners\partner::getXMLID();
}
?>
<?$bill = "http://termoros.pro/exchange/?RefPartner=$xmlID&RefOrder=d2caf9a4-5a45-11e6-80e7-0cc47a1d8513";?>

			<div class="profilepage <?if($isPartner):?>partner_page<?endif?>">
				<div class='ph_detail <?if($isPartner):?>right_sidebar<?endif?>'>
					<?if($isPartner):?><a href="" class="download_bill">Скачать счет</a><?endif?>
					<div class='history_detail'>
						<p class='order_i'>Заказ №<?=$arResult['ID']?> от <?=$arResult["DATE_INSERT_FORMATED"]?></p>

						<div class='ph_section'>
							<p class='val'>Текущий статус заказа:<span><?=$arResult["STATUS"]["NAME"]?></span></p>
							<p class='val'>Сумма заказа:<span><?=$arResult["PRODUCT_SUM_FORMATTED"]?></span></p>
						</div>

						<div class='ph_section'>

						<p class='ph_name'>Данные учетной записи</p>
						<p class='val'>Учетная запись:<span><?=$arResult["USER"]["LOGIN"]?></span></p>
						<p class='val'>E-mail:<span><?=$arResult["USER"]["EMAIL"]?></span></p>

						</div>

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
						<p class='ph_name'>Оплата и доставка</p>

						<p class='val'>Платежная система:<span><?=$arResult["PAY_SYSTEM"]["NAME"]?></span></p>
						<p class='val'>Оплачен:
						<span>
						<?if($arResult["PAYED"] == "Y"):?>
							<?=GetMessage('SPOD_YES')?>
							<?if(strlen($arResult["DATE_PAYED_FORMATED"])):?>
								(<?=GetMessage('SPOD_FROM')?> <?=$arResult["DATE_PAYED_FORMATED"]?>)
							<?endif?>
						<?else:?>
							<?/*
							<?=GetMessage('SPOD_NO')?>
							<?if($arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y"):?>
								&nbsp;&nbsp;&nbsp;[<a href="<?=$arResult["PAY_SYSTEM"]["PSA_ACTION_FILE"]?>" target="_blank"><?=GetMessage("SPOD_REPEAT_PAY")?></a>]
							<?endif?>
							*/?>
						<?endif?>
						</span>
						</p>
						<p class='val'>Служба доставки:<span><?=$arResult["DELIVERY"]["NAME"]?></span></p>

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
						<p class='summ'>Товаров  <?=$allquan?> шт.  |   <?=$arResult["PRODUCT_SUM_FORMATTED"]?></p>

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
										<p class="old_price" style="text-decoration: line-through; color: #9a9fab;"><?=intval($prod["PRICE"]+$prod['DISCOUNT_PRICE'])*$prod["QUANTITY"]?> руб.</p>
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

								<div class='fin_summ'><span class='value'>Итого</span><p class="price"><?=$allsumm?><span>руб.</span></p></div>
								<?if($isPartner):?>
									<a href="" class="download_bill">Скачать счет</a>
								<?endif?>
								<a href='/personal/order/cancel/<?=$arResult['ID']?>/?CANCEL=Y' class='delete_order'>Отменить заказ</a>
								<a href='' class='close_order'>закрыть</a>
								<a href='/personal/order/index.php?ID=<?=$arResult[' class='submit_order'>Повторить заказ</a>

							</div>


							<div class="clear"></div>
						</div>


					</div>
				</div>
				<?include($_SERVER['DOCUMENT_ROOT']."/include/partner_right.php")?>
			</div>