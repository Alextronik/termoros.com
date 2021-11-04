<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//p($arResult);?>
			<div class='account_page'>
				<div class='type_pers'>
						<span class='fiz<?if($_REQUEST['fltr'] != 'F'):?> active<?endif;?>'><a href="?fltr=">Текущие заказы</a></span>
						<div class='type_range'>
							<div class='type_circle' <?if($_REQUEST['fltr'] == 'F'):?>style="left: 51px;"<?endif;?> ></div>
						</div>
						<span class='ur<?if($_REQUEST['fltr'] == 'F'):?> active<?endif;?>'><a href="?fltr=F">завершенные заказы</a></span>
				</div>
					<!--<form class="status_ord_form">
					<input type='checkbox' <?if($_REQUEST['current']):?>checked<?endif;?> class='checkbx' onchange="$('.status_ord_form').submit();" name="current" value="1"  id='chk3'/><label for='chk3'>Текущие</label>
					<input type='checkbox' <?if($_REQUEST['complate']):?>checked<?endif;?> class='checkbx' onchange="$('.status_ord_form').submit();" name="complate" value="1"  id='chk2'/><label for='chk2'>Завершенные</label>
					</form>-->

				<table class='history_orders'>
					<tr>
						<th>Номер заказа</th>
						<th>Дата заказа</th>
						<th>Цена</th>
						<th>Кол-во <br/>позиций</th>
						<th>Статус</th>
						<!--<th>ID почтового <br/>отправления</th>-->
						<th>Действия</th>
					</tr>
					<?foreach($arResult["ORDERS"] as $val):?>
					<?//p($val);?>
					<?$discountSumm = 0;?>
					<?$quan = 0;?>
					<?foreach($val["BASKET_ITEMS"] as $vval){
						$quan += $vval["QUANTITY"];

					}?>
					<tr>
						<td style="text-align: center;" ><a class='item_shower' href=''><?=$val["ORDER"]["ACCOUNT_NUMBER"]?></a>
							<!--<div class='item_preview'>
								<div class="im_area">
									<img src="<?=SITE_TEMPLATE_PATH;?>img/cat1.png">
								</div>
								<a href="" class="name">Футболка X-Bionic T-Shirt Extra Warm LS жен.</a>
							</div>-->
						</td>
						<td><?=substr($val["ORDER"]["DATE_INSERT_FORMAT"], 0, 10);?></td>
						<td><?=$val["ORDER"]["FORMATED_PRICE"]?></td>
						<td><?=$quan?></td>
						<td><a href='' onclick="return false;" class='watch_adr'><?=$arResult["INFO"]["STATUS"][$val["ORDER"]["STATUS_ID"]]["NAME"]?></a>
							<?if($val["ORDER"]["STATUS_ID"]["NAME"] != 'O' && $val["ORDER"]["STATUS_ID"]["NAME"] != 'F'):?>
							<div class='adr_popup'>
								<p class='name'><?=$arResult["INFO"]["DELIVERY"][$val["ORDER"]["DELIVERY_ID"]]['NAME']?></p>
								<p class='adr'><?=$arResult["INFO"]["DELIVERY"][$val["ORDER"]["DELIVERY_ID"]]['DESCRIPTION']?></p>
							</div>
							<?endif;?>
						</td>
						<!--<td>Us34525524</td>-->
						<td class='last'><a href='<?=$val["ORDER"]["URL_TO_COPY"]?>'>повторить</a><a class="delete cancel-order" href='?CANCELORDER=Y&CANCELID=<?=$val["ORDER"]["ACCOUNT_NUMBER"]?>' ></a></td>
					</tr>

					<tr style="display: none;" class='hidden_tr <?=$val["ORDER"]['STATUS_ID'];?>_status'>
						<td colspan="7" style="padding: 3px;">
						<div class='hack_div'>
							<!--table in tablle-->
							<table class="cart_table">

								<?$allsum = 0;?>
								<?$discountPrice = 0;?>
								<?foreach($val["BASKET_ITEMS"] as $vval){
									$discountSumm += $vval['DISCOUNT_PRICE']*$vval["QUANTITY"];

									unset($basePrice);
									unset($arFields);
									$Offerparent = CCatalogSku::GetProductInfo($vval['PRODUCT_ID']);
									$basePrice = CPrice::GetBasePrice($vval["PRODUCT_ID"]);
									$res = CIBlockElement::GetByID($Offerparent['ID']);
									while($ob = $res->GetNextElement())
									{
									 $arFields = $ob->GetFields();
										//p($arFields);
									}

									$img = resize($arFields['DETAIL_PICTURE'], 135, 105, 2);
									?>
								<?//p($arFields);?>
								<tr>
									<td style="background: white; border: none;" >
										<div class="cart_im" style="text-align: center;">
										<?if($img):?>
										<img src="<?=$img;?>" alt="<?=$vval["NAME"];?>"/>
										<?else:?>
										<img width="135" height="105" src="/bitrix/templates/sport/img/nophoto.png" alt="<?=$vval["NAME"];?>"/>
										<?endif;?>
										</div>
									</td>
									<td style="background: white; border: none;" >
										<?if($arFields["DETAIL_PAGE_URL"]):?>
										<a class="it_ttl" href="<?=$arFields["DETAIL_PAGE_URL"];?>"><?=$vval["NAME"];?></a>
										<?else:?>
										<?=$vval["NAME"];?><br/>
										(данный товар в каталоге отсутсвует)
										<?endif;?>
									</td>
									<td style="background: white; border: none;" >
										<div class="h_pos">
											<?=$vval["QUANTITY"];?> шт.
										</div>
									</td>
									<td style="background: white; border: none;" >
										<div class="summ">
											<?=CurrencyFormat(($vval["PRICE"]+$vval["DISCOUNT_PRICE"])*$vval["QUANTITY"], "RUB")?>
										</div>
									</td>
									<!--<td>
										<div class="actions">
											<input type='submit' value='в корзину' class="add_to_bask ajax">
											<div class='del_pos'></div>
											<form name="addtobasket" class="form">
											<input type="hidden" name="iblock_id" value="<?=$arFields['IBLOCK_ID'];?>" />
											<input type="hidden" name="id" value="<?=$arFields['ID'];?>" />
											</form>

										</div>
									</td>-->
								</tr>

								<?
								$allsum += ($vval["PRICE"]+$vval["DISCOUNT_PRICE"])*$vval["QUANTITY"];
								$discountPrice += $vval["DISCOUNT_PRICE"]*$vval["QUANTITY"];
								}?>

							</table>
							<!--table in tablle-->
						</div>
						</td>
					</tr>
					<?endforeach;?>



				</table>

			<?if(strlen($arResult["NAV_STRING"]) > 0):?>
			<?=$arResult["NAV_STRING"]?>
			<?endif?>

			</div>