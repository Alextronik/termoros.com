<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
			<div class="profilepage">
				<div class='ph_detail'>
					<div class='history_detail'>
						<p class='order_i'>Заказ №<?=$_REQUEST['ID']?> от <?=$arResult["ORDERS"][$_REQUEST['ID']]['DATE']?></p>
						
						<div class='ph_section'>
							<p class='val'>Текущий статус заказа:<span>Отложен<?//=$arResult["STATUS"]["NAME"]?></span></p>
							<p class='val'>Сумма заказа:<span><?=CurrencyFormat(intval($arResult["ORDERS"][$_REQUEST['ID']]["PRICE"]), 'RUB');?></span></p>
						</div>
						
						<?foreach($arResult["ORDERS"][$_REQUEST['ID']]['ITEMS'] as $prod):?>
						<?$allquan += $prod;?>
						<?endforeach?>
						
						<p class='main_ttl'>Состав заказа</p>
						<p class='summ'>Товаров  <?=$allquan?> шт.  |   <?=CurrencyFormat(intval($arResult["ORDERS"][$_REQUEST['ID']]["PRICE"]), 'RUB');?></p>
						
						<div class="basket_area">
							<p class='sec_b_tll'>Параметры заказа</p>
							<table class="hist_table">
								
								<tr>
									
									<th colspan="2">
										Товар
									</th>
									
									<th>
										Количество
									</th>
									
									<th>
										Наличие
									</th>
									
									<th>
										Стоимость
									</th>
									
								</tr>
								<?$allsumm = 0?>
								<?$alldiscount = 0?>
								<?foreach($arResult["ORDERS"][$_REQUEST['ID']]['ITEMS'] as $id => $quan):?>
								<?$allsumm += intval($prod['PRICE'])*$prod["QUANTITY"];?>
								<?$alldiscount += intval($prod['DISCOUNT_PRICE'])*$prod["QUANTITY"];?>
								
								<tr>
							
									<td class="im_area">
										<?$img = resize($arResult['FIELDS'][$id]['DETAIL_PICTURE'], 200, 200, 2);?>
										<img src="<?=$img?>" alt="" />
									</td>
									
									<td class="item_td">
										<a href="<?=$arResult['FIELDS'][$id]["DETAIL_PAGE_URL"]?>" class="name"><?=substr($arResult['FIELDS'][$id]["NAME"], 0, 60)?></a>
										<span class="i">Код: <?=$arResult['PROPERTIES'][$id]['CML2_ARTICLE']['VALUE']?></span>
										<!--<span class="i">Бренд: <?=$arResult['PRODUCT_PROPS'][$id]['IZGOTOVITEL_POZITSIYA_NOMENKLATURY']['VALUE']?></span>-->
										
										<p class="price"><?=CurrencyFormat($arResult['PRICES'][$id], 'RUB');?></p>
									</td>
									
									
									<td class="col">
										<!--<input type="text" class="inp_self" value="">-->
										<?=$quan?>
										<span><?=$arResult['PROPERTIES'][$id]['CML2_BASE_UNIT']['VALUE']?></span>
									</td>
									
									
									<td class="nal">
										<!--
										<p>В наличии: 10 шт.</p>
										<p>15 шт.   доставка 15.01.2016</p>
										<p>15 шт.   доставка 25.01.2016</p>
										-->
									</td>
									
									<td class="fullprice">										
										<p class="price"><?=intval($arResult['PRICES'][$id])*$quan?><span>руб.</span></p>
									</td>
									
								</tr>
								
								<?endforeach?>
								
								<!--
								<tr class="last">
									<td colspan="4">
										<div class="cart_fin">
											<?if($alldiscount):?>
											<p class="discount">Ваша скидка: <?=$alldiscount?> руб.</p>
											<?endif;?>
											<?/*if($arResult["PRICE_DELIVERY_FORMATED"]):?>
											<p class="discount">Стоимость доставки: <?=$arResult["PRICE_DELIVERY_FORMATED"]?></p>
											<?endif;*/?>
											<p class="fin_summ">Сумма к оплате: <?=$allsumm?> руб.</p>
										</div>
									</td>
								</tr>-->
								
							</table>
							
							<div class='fin_block'>
					
								<div class='fin_summ'>
									<span class='value'>Итого</span>
									<p class="price"><?=CurrencyFormat(intval($arResult["ORDERS"][$_REQUEST['ID']]["PRICE"]), 'RUB');?></p>
								</div>
								
								<a href='/personal/delayorder?ID=<?echo $_REQUEST[' class='delete_order'>Удалить заказ</a>
								<a href='/personal/delayorder' class='close_order'>закрыть</a>
								<a href='/personal/delayorder?ID=<?echo $_REQUEST[' class='submit_order'>Оформить заказ</a>
								
							</div>
							
							
							<div class="clear"></div>
						</div>
						
						
					</div>
				</div>
			</div>		