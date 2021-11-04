<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Sale\DiscountCouponsManager;
use Redreams\Supply as SU;
use Bitrix\Main\Localization\Loc;

if (!empty($arResult["ERROR_MESSAGE"]))
	ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

//p($arResult);
if ($normalCount > 0):
?>

<?
function showCartItem($arItem,$tovprop,$quannull = false,$quants, $storeID)
{

	//p($tovprop['FOR_ORDER']['VALUE']);
	//p($arResult["Tov"][$arItem["PRODUCT_ID"]]);

	foreach($arItem['PROPS'] as $arProp)
	{
		$arPropsItem[$arProp['CODE']] = $arProp;
	}
	//p($arItem);
	//p($arPropsItem);
	$res = CIBlockElement::GetByID($arItem["PRODUCT_ID"]);
	if($ar_res = $res->GetNext())
		if($ar_res['IBLOCK_ID']=="5")
			$freet=true;
		else
			$freet=false;
?>
	<?//p($arItem['PRODUCT_ID']);?>
	<tr>
		<td class="im_area">
			<img src="<?=$arItem["PREVIEW_PICTURE_SRC"] ? $arItem["PREVIEW_PICTURE_SRC"] : SITE_TEMPLATE_PATH."/img/no-foto-small.jpg"?>">
		</td>
		<td class='item_td'>
			<a href='<?=$tovprop['FIELDS']['DETAIL_PAGE_URL']?>' class='name'><?=$arItem['NAME']?></a>
			<span class='i'>Артикул: <?=$arPropsItem['CML2_ARTICLE']['VALUE']?></span>
			<!--<span class='i'>Бренд: FAR</span>-->
			<p class='price'><?=$arItem["PRICE_FORMATED"]?></p>
		</td>
		<td class='col'>
			<input type='text' onchange="updateBigBasket()" onkeyup="updateBigBasket()" name="QUANTITY_<?=$arItem['ID']?>" class='inp_val inp_self' value='<?=$arItem["QUANTITY"]?>' <?=$freet?"readonly":""?>>
			<span><?=$tovprop['CML2_BASE_UNIT']['VALUE']?></span>
		</td>
		<td class='nal'>
			<? if ($arItem['PRODUCT_ID'] == 53174) { ?>
			<p>В наличии</p>
			<? } elseif ($quants[$arItem['PRODUCT_ID']]) { ?>
			<p>В наличии: <?=$quants[$arItem['PRODUCT_ID']];?> шт.</p>
			<?} else { ?>
			<p>Наличие уточняйте у менеджеров</p>
			<? } ?>
			<?

			if($storeID)
			{
				$arSupplys = SU\SupplyInfo::GetSupply($arItem["PRODUCT_ID"], $storeID);
				foreach ($arSupplys as $supply)
				{
					?><p class='i'>+ <span class="sypply_qa"><?=$supply["UF_QUANTITY"]?></span> шт. доставка <?=$supply["UF_DATE"] -> format('d.m.Y')?></p><?
				}
			}

			?>
			<!--<p>15 шт.   доставка 15.01.2016</p>
			<p>15 шт.   доставка 25.01.2016</p>-->
		</td>
		<td class='fullprice'>
			<p class='price'><?=CurrencyFormat($arItem["QUANTITY"]*$arItem["PRICE"],'RUB')?></p>
			<a href='/personal/cart?action=delete&id=<?=$arItem["ID"]?>' class='delete_item'></a>
		</td>
	</tr>
<?
}
?>

<?	//p($arResult['QUANTS']);
	foreach ($arResult["GRID"]["ROWS"] as $k => $arItem)
	{
		$arPropsItem = array();
		
		//p($arItem);
		//p($arResult["Tov"][$arItem["PRODUCT_ID"]]);
		$arItem['PROPS'] = $arResult["Tov"][$arItem["PRODUCT_ID"]];

		if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y")
		{
			foreach($arItem['PROPS'] as $arProp)
			{
				$arPropsItem[$arProp['CODE']] = $arProp;
			}
			//p($arItem);
			/*
			if($arPropsItem['FOR_ORDER']['VALUE']=='Да')
			{
				*/
				$arItemsSklad[] = $arItem;
				$priceForSklad += $arItem['PRICE']*$arItem['QUANTITY'];
				$quantityForSklad += $arItem['QUANTITY'];
				if ($arItem["DISCOUNT_PRICE"])
				{
					$discountForSklad += $arItem["DISCOUNT_PRICE"]*$arItem['QUANTITY'];
				} 
				elseif ($arItem["BASE_PRICE"]) 
				{
					$arItem["DISCOUNT_PRICE"] = $arItem["BASE_PRICE"] - $arItem["PRICE"];
					$discountForSklad += $arItem["DISCOUNT_PRICE"]*$arItem['QUANTITY'];
				}
			/*
			}
			else
			{
				$arItemsSklad[] = $arItem;
				$priceForSklad += $arItem['PRICE']*$arItem['QUANTITY'];
				$quantityForSklad += $arItem['QUANTITY'];
				$discountForSklad += $arItem["DISCOUNT_PRICE"]*$arItem['QUANTITY'];
			}
			*/
			$quantity += $arItem['QUANTITY'];
		}
	}
?>


<div class='cart_page row'>
    <div class="col-8">
        <p class='cart_summary'>Товаров  <?=$quantity?> шт.  |   <?=$arResult["allSum_FORMATED"]?>
            <?/*<span class='del_var'>В заказе присутствуют товары в наличии  и товары под заказ </span>*/?>
        </p>
    </div>
    <div class="col-2">
        <a href='' class='del_terms pops'>Условия доставки</a>
    </div>
    <div class="col-1">
        <a href='?print=y' target="_blank" class='print col-2'><span class='it_ttl'>печать</span></a>
    </div>





<div style="display: none;" class="cart-delivery-text pop_up pops-text" >
<a href="" class="popclose"></a>
<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/include/deliverys.php"), false);?>
</div>

<div class='clear'></div>

<p class='section_ttl col-12'>Товары в корзине</p>

<div class='cart_left col-12 col-md-9'>

	<div class='add_by_art'>

		<p class='ttl col-12'>Добавить товары по артикулу</p>
		<div class='dwnld_block col-12 col-md-4'>
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				Array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => SITE_DIR."include/file_multi_load_text.php",
					"AREA_FILE_RECURSIVE" => "N",
					"EDIT_MODE" => "html",
				),
				false,
				Array('HIDE_ICONS' => 'Y')
			);?>
			<a href='' class='insert_file'>загрузить файл</a>
			<input type="file" name="XLS" style="display: none" id="xls_input">

		</div>

		<div class='inp_line_wp col-12 col-md-8'>
			<div class='inp_line row' data-price="0">
				<div class="inp_block code col-5">
					<input type="hidden" class="h_id_inp" name="ID[]">
					<input type='text' class='inp_self item_atr' value='' placeholder='Введите артикул'>
					<p class='inp_val price'>0<span>руб.</span></p>
				</div>
				<div class="inp_block quantity col-5">
					<input type='text' name="quantity[]" class='inp_self short' value='1'>
					<span class='col'>шт.</span>
					<p class='inp_val sum'>0<span>руб.</span></p>
				</div>
				<a href='' class='delete_line col-2'></a>
			</div>

			<a href='' class='add_line col-6'>Добавить поля</a>
			<a href='' class='to_basket col-6'>в корзину</a>

		</div>
		<div class='clear'></div>
	</div>

	<?/*?>
	<div class='bon_block'>
		<?if($USER->isAuthorized()):?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.personal.account",
			"accb",
			array(
				"0" => "SET_TI",
				"SET_TITLE" => "N"
			),
			false
		);?>
		<?endif?>

		<div class='clear'></div>
	</div>
	<?*/?>

	<?if($arItemsForOrder&&$arItemsSklad):?>
		<!--<p class='items_info'>Вами добавлены товары, готовые к доставке, и товары под заказ</p>-->
	<?endif?>
	<?if($arItemsSklad):?>
		<div class='order_section'>
            
		<table class='cart_table'>
			<tr>
				<th colspan='2'>Товар</th>
				<th>Количество</th>
				<th>Наличие</th>
				<th>Стоимость</th>
			</tr>

			<?foreach($arItemsSklad as $arItem):?>
				<?showCartItem($arItem,$arResult["Tov"][$arResult["arTov"][$arItem["PRODUCT_ID"]]],true,$arResult['QUANTS'],$arResult["SUPPLY"])?>
				<?//p($arResult["Tov"][$arItem["PRODUCT_ID"]]);?>
			<?endforeach?>
			</table>
		</div>
	<?endif?>
	<?if($arItemsForOrder):?>
		<div class='order_section'>
		<p class='section_ttl'>товары под заказ</p>

		<table class='cart_table'>
			<tr>
				<th colspan='2'>Товар</th>
				<th>Количество</th>
				<th>Наличие</th>
				<th>Стоимость</th>
			</tr>

			<?foreach($arItemsForOrder as $arItem):?>
				<?showCartItem($arItem,$arResult["Tov"][$arResult["arTov"][$arItem["PRODUCT_ID"]]],false,false,$arResult["SUPPLY"])?>
			<?endforeach?>

			</table>
		</div>
	<?endif?>

	<div class='clear'></div>
</div>

<div class='cart_right col-12 col-md-3' >
	<?if($quantityForSklad>0){?>
        <input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
        <input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
        <input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
        <input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
        <input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
        <input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
        <input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
        <input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
        <div class="bx_ordercart_order_pay_left col-12" id="coupons_block">
            <?
            if ($arParams["HIDE_COUPON"] != "Y" && !\Redreams\Partners\partner::isPartner())
            {
                ?>
                <div class="bx_ordercart_coupon">
                <p style="color:red;font-weight: bolder;margin-top: 0.4em;">Введите промокод: </p><input type="text" id="coupon" name="COUPON" value="" onchange="checkCoupon(this);">
                </div><?
                if (!empty($arResult['COUPON_LIST']))
                {
                    foreach ($arResult['COUPON_LIST'] as $oneCoupon)
                    {
                        $couponClass = 'disabled';
                        switch ($oneCoupon['STATUS'])
                        {
                            case DiscountCouponsManager::STATUS_NOT_FOUND:
                            case DiscountCouponsManager::STATUS_FREEZE:
                                $couponClass = 'bad';
                                break;
                            case DiscountCouponsManager::STATUS_APPLYED:
                                $couponClass = 'good';
                                break;
                        }
                        ?><div class="bx_ordercart_coupon"><input disabled readonly type="text" name="OLD_COUPON[]" value="<?=htmlspecialcharsbx($oneCoupon['COUPON']);?>" class="<? echo $couponClass; ?>"><span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span><div class="bx_ordercart_coupon_notes"><?
                            if (isset($oneCoupon['CHECK_CODE_TEXT']))
                            {
                                echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
                            }
                            ?></div></div><?
                    }
                    unset($couponClass, $oneCoupon);
                }
            }?>
        </div>
	<div class='order_pars col-12'>
		<p class='ttl'>товары в наличии</p>

		<table class='par_table'>
			<tr>
				<td>
					Стоимость заказа
				</td>
				<td class='val'>
					<?=CurrencyFormat($priceForSklad + $discountForSklad,'RUB')?>
				</td>
			</tr>
			<tr>
				<td>
					Скидка
				</td>
				<td class='val'>
					<?=CurrencyFormat($discountForSklad ,'RUB')?>
				</td>
			</tr>
		</table>
	</div>
	<?}?>
	<?if($quantityForOrder>0){?>
	<div class='order_pars col-12'>
		<p class='ttl'>товары под заказ</p>
		<table class='par_table'>
			<tr>
				<td>
					Стоимость заказа
				</td>
				<td class='val'>
					<?=CurrencyFormat($priceForOrder + $discountForOrder,'RUB')?>
				</td>
			</tr>
			<tr>
				<td>
					Скидка
				</td>
				<td class='val'>
					<?=CurrencyFormat($discountForOrder ,'RUB')?>
				</td>
			</tr>
		</table>
	</div>
	<?}?>

	<?/*?>
	<div class='account_block'>
		<p class='ttl'>Ваш кредитный счет</p>
		<p class='price'>121 234<span>руб.</span></p>
		<p class='i'>Вы можете частично или <br/>полностью оплатить свой заказ</p>
		<a href='' class='opener'></a>
		<div class='inp_wp'>
			<input type='text' class='inp_self' value='' >
			<input type='submit' class='btn' value=''>
			<div class='clear'></div>
		</div>
	</div>
	<?*/?>
	<?if(0 && !\Redreams\Partners\partner::isPartner()):?>
		<div class='account_block promo'>
			<p class='ttl'>Есть промо-код?</p>
			<p class='i'>Введите промо-код <br/>для получения скидки</p>
			<a href='' class='opener'></a>
			<div class='inp_wp'>
				<input type='text' id="coupon" name="coupon" onchange="checkCoupon(this)" class='inp_self promo_input' value='<?=$arResult["COUPON"]?>'>
				<input type='submit' class='btn' value=''>
				<div class='clear'></div>
			</div>
		</div>
	<?endif?>
	<div class='cart_summ col-12'>
		<table class='par_table'>
			<?/*?>
			<tr>
				<td>
					Оплата с кредитного счета
				</td>
				<td class='val'>
					1 500 руб.
				</td>
			</tr>
			<tr>
				<td>
					Оплата с бонусного счета
				</td>
				<td class='val'>
					<?=CurrencyFormat($_SESSION["pay_bonus"],'RUB')?>
				</td>
			</tr>
			<?*/?>
			<?if(0 && !\Redreams\Partners\partner::isPartner()):?>
				<tr>
					<td>
						Скидка по промо-коду
					</td>
					<td class='val'>
						<?=CurrencyFormat($arResult["DISCOUNT_PRICE_ALL"],'RUB')?>
					</td>
			</tr>
			<?endif?>
			<tr class='fin'>
				<td>
					Стоимость с НДС
				</td>
				<td class='val'>
					<p class='price'><?=$arResult["allSum_FORMATED"]?></p>
				</td>
			</tr>
		</table>
	</div>
	<? if(\Redreams\Partners\partner::isPartner()) { ?>
	<!--a href="/personal/cart/?action=ADD2BASKET&id=53174" class="order_catalog">Заказать каталог Терморос 2017</a-->
	<? } ?>
	<a href='/personal/order/make' onclick="yaCounter26951046.reachGoal('oformit_korzina'); ga('send', 'pageview','/virtual/oformit_korzina'); return true;" class='submit_order'>Оформить заказ</a>
	<?
	global $USER;
	if($USER->isAdmin()):?>
	<a href="" class="delay-order-cart" >Отложить заказ</a>
	<?endif;?>
</div>
<div class='clear'></div>
</div>


<?/*

<div class='basket_page'>
			<div class='container'>
				<div class='left_side'>

					<div class='breadcrumbs'><a href=''>Главная</a><span class='del'>/</span><span>Корзина</span></div>

					<h1>Корзина</h1>
					<?if($arItemsForOrder&&$arItemsSklad):?>
						<p class='items_info'>Вами добавлены товары, готовые к доставке, и товары под заказ</p>
					<?endif?>
					<?if($arItemsSklad):?>
						<p class='bask_opener opened'><span>Товары, готовые к доставке</span></p>
						<table class='hist_detail'>
							<?foreach($arItemsSklad as $arItem):?>
								<?showCartItem($arItem,$arResult["Tov"][$arResult["arTov"][$arItem["PRODUCT_ID"]]])?>
							<?endforeach?>
						</table>
					<?endif?>
					<?if($arItemsForOrder):?>
						<p class='bask_opener opened'><span>Товары под заказ</span></p>
						<table class='hist_detail'>
							<?foreach($arItemsForOrder as $arItem):?>
								<?showCartItem($arItem,$arResult["Tov"][$arResult["arTov"][$arItem["PRODUCT_ID"]]])?>
							<?endforeach?>
						</table>
					<?endif?>
					<a href='<?=$_SESSION['last_tov']<>""?$_SESSION['last_tov']:"/catalog/"?>' class='back_shopping'>продолжить покупки</a>
					<div class='clear'></div>
				</div>

				<div class='right_side'>
					<p class='main_ttl'>параметры заказа</p>
					<?p($arResult["allSum"])?>
					<?$arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_*");
					$arFilter = Array("IBLOCK_ID"=>"8", "ACTIVE"=>"Y");
					$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
					while($ob = $res->GetNextElement())
					{
						$arProps = $ob->GetProperties();
						$sum=$arProps["SUM"]["VALUE"];
					}?>

					<?if($arResult["allSum"]<$sum&&$arResult["allSum"]<>"0"){?>
						<div class='section'>
							<p class='yell'>закажите еще на</p>
							<p class='yell_price'><?=CurrencyFormat($sum-$arResult["allSum"] ,'RUB')?><span>руб</span></p>
							<p class='yell'>и Ваша доставка будет БЕСПЛАТНОЙ</p>
						</div>
					<?}?>

					<div class='section promo'>
						<p class='name'>Введите код на скидку</p>
						<div class='inp_wp'>
							<input type='text' id="coupon" name="coupon" onchange="checkCoupon(this)" class='inp_self promo_input' value='<?=$arResult["COUPON"]?>'>
							<a class='inp_btn'></a>
						</div>
					</div>
					<?if($quantityForSklad>0){?>
					<div class='section summ'>
						<p class='name'>Товары, готовые к доставке</p>
						<p class='text'>Товаров<span class='val'><?=$quantityForSklad?><span>шт</span></span></p>
						<p class='text'>Скидка<span class='val'><?=CurrencyFormat($discountForSklad ,'RUB')?><span>руб</span></span></p>
						<p class='text'>Стоимость<span class='val'><?=CurrencyFormat($priceForSklad,'RUB')?><span>руб</span></span></p>
					</div>
					<?}?>

					<?if($quantityForOrder>0){?>
					<div class='section summ'>
						<p class='name'>Товары под заказ</p>
						<p class='text'>Товаров<span class='val'><?=$quantityForOrder?><span>шт</span></span></p>
						<p class='text'>Скидка<span class='val'><?=CurrencyFormat($discountForOrder ,'RUB')?><span>руб</span></span></p>
						<p class='text'>Стоимость<span class='val'><?=CurrencyFormat($priceForOrder,'RUB')?><span>руб</span></span></p>
					</div>
					<?}?>
					<?if($USER->isAuthorized()):?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:sale.personal.account",
						"acc",
						array(
							"0" => "SET_TI",
							"SET_TITLE" => "N"
						),
						false
					);?>
					<?endif?>


					<div class='section summ fin'>
						<p class='name'>Итого</p>
						<p class='text'>Товаров<span class='val'><?=$quantity?><span>шт</span></span></p>
						<p class='text'>Скидка<span class='val'><?=CurrencyFormat($arResult["DISCOUNT_PRICE_ALL"],'RUB')?><span>руб</span></span></p>
						<p class='text bon' <?=$_SESSION["pay_bonus"]==""?'style="display: none;"':""?>>Будет оплачено бонусами<span class='val'><?=CurrencyFormat($_SESSION["pay_bonus"],'RUB')?><span>руб</span></span></p>
						<p class='text'>Стоимость<span class='val'><?=$arResult["allSum_FORMATED"]?><span>руб</span></span></p>
						<a  onclick="checkOut();" class='submit_order'>Оформить заказ</a>
					</div>
				</div>

				<div class='clear'></div>
			</div><!-- .container -->


		</div>


<div id="basket_items_list">
	<div class="bx_ordercart_order_table_container">
		<table id="basket_items">
			<thead>
				<tr>
					<td class="margin"></td>
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
						$arHeader["name"] = (isset($arHeader["name"]) ? (string)$arHeader["name"] : '');
						if ($arHeader["name"] == '')
							$arHeader["name"] = GetMessage("SALE_".$arHeader["id"]);
						$arHeaders[] = $arHeader["id"];

						// remember which values should be shown not in the separate columns, but inside other columns
						if (in_array($arHeader["id"], array("TYPE")))
						{
							$bPriceType = true;
							continue;
						}
						elseif ($arHeader["id"] == "PROPS")
						{
							$bPropsColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELAY")
						{
							$bDelayColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELETE")
						{
							$bDeleteColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "WEIGHT")
						{
							$bWeightColumn = true;
						}

						if ($arHeader["id"] == "NAME"):
						?>
							<td class="item" colspan="2" id="col_<?=$arHeader["id"];?>">
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<td class="price" id="col_<?=$arHeader["id"];?>">
						<?
						else:
						?>
							<td class="custom" id="col_<?=$arHeader["id"];?>">
						<?
						endif;
						?>
							<?=$arHeader["name"]; ?>
							</td>
					<?
					endforeach;

					if ($bDeleteColumn || $bDelayColumn):
					?>
						<td class="custom"></td>
					<?
					endif;
					?>
						<td class="margin"></td>
				</tr>
			</thead>

			<tbody>
				<?
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
				?>
					<tr id="<?=$arItem["ID"]?>">
						<td class="margin"></td>
						<?
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

							if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in the columns in this template
								continue;

							if ($arHeader["id"] == "NAME"):
							?>
								<td class="itemphoto">
									<div class="bx_ordercart_photo_container">
										<?
										if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
											$url = $arItem["PREVIEW_PICTURE_SRC"];
										elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
											$url = $arItem["DETAIL_PICTURE_SRC"];
										else:
											$url = $templateFolder."/images/no_photo.png";
										endif;
										?>

										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</div>
									<?
									if (!empty($arItem["BRAND"])):
									?>
									<div class="bx_ordercart_brand">
										<img alt="" src="<?=$arItem["BRAND"]?>" />
									</div>
									<?
									endif;
									?>
								</td>
								<td class="item">
									<h2 class="bx_ordercart_itemtitle">
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<?=$arItem["NAME"]?>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</h2>
									<div class="bx_ordercart_itemart">
										<?
										if ($bPropsColumn):
											foreach ($arItem["PROPS"] as $val):

												if (is_array($arItem["SKU_DATA"]))
												{
													$bSkip = false;
													foreach ($arItem["SKU_DATA"] as $propId => $arProp)
													{
														if ($arProp["CODE"] == $val["CODE"])
														{
															$bSkip = true;
															break;
														}
													}
													if ($bSkip)
														continue;
												}

												echo $val["NAME"].": <span>".$val["VALUE"]."<span><br/>";
											endforeach;
										endif;
										?>
									</div>
									<?
									if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
										foreach ($arItem["SKU_DATA"] as $propId => $arProp):

											// if property contains images or values
											$isImgProperty = false;
											if (!empty($arProp["VALUES"]) && is_array($arProp["VALUES"]))
											{
												foreach ($arProp["VALUES"] as $id => $arVal)
												{
													if (!empty($arVal["PICT"]) && is_array($arVal["PICT"])
														&& !empty($arVal["PICT"]['SRC']))
													{
														$isImgProperty = true;
														break;
													}
												}
											}
											$countValues = count($arProp["VALUES"]);
											$full = ($countValues > 5) ? "full" : "";

											if ($isImgProperty): // iblock element relation property
											?>
												<div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_scu_scroller_container">

														<div class="bx_scu">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left:0%;"
																class="sku_prop_list"
																>
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
																				$selected = "bx_active";
																		}
																	endforeach;
																?>
																	<li style="width:10%;"
																		class="sku_prop <?=$selected?>"
																		data-value-id="<?=$arSkuValue["XML_ID"]?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																		>
																		<a href="javascript:void(0);">
																			<span style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"></span>
																		</a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>

														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
													</div>

												</div>
											<?
											else:
											?>
												<div class="bx_item_detail_size_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_size_scroller_container">
														<div class="bx_size">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left:0%;"
																class="sku_prop_list"
																>
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
																				$selected = "bx_active";
																		}
																	endforeach;
																?>
																	<li style="width:10%;"
																		class="sku_prop <?=$selected?>"
																		data-value-id="<?=($arProp['TYPE'] == 'S' && $arProp['USER_TYPE'] == 'directory' ? $arSkuValue['XML_ID'] : $arSkuValue['NAME']); ?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																		>
																		<a href="javascript:void(0);"><?=$arSkuValue["NAME"]?></a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>
														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
													</div>

												</div>
											<?
											endif;
										endforeach;
									endif;
									?>
								</td>
							<?
							elseif ($arHeader["id"] == "QUANTITY"):
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<div class="centered">
										<table cellspacing="0" cellpadding="0" class="counter">
											<tr>
												<td>
													<?
													$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
													$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
													$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
													$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
													?>
													<input
														type="text"
														size="3"
														id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														size="2"
														maxlength="18"
														min="0"
														<?=$max?>
														step="<?=$ratio?>"
														style="max-width: 50px"
														value="<?=$arItem["QUANTITY"]?>"
														onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)"
													>
												</td>
												<?
												if (!isset($arItem["MEASURE_RATIO"]))
												{
													$arItem["MEASURE_RATIO"] = 1;
												}

												if (
													floatval($arItem["MEASURE_RATIO"]) != 0
												):
												?>
													<td id="basket_quantity_control">
														<div class="basket_quantity_control">
															<a href="javascript:void(0);" class="plus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);"></a>
															<a href="javascript:void(0);" class="minus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"></a>
														</div>
													</td>
												<?
												endif;
												if (isset($arItem["MEASURE_TEXT"]))
												{
													?>
														<td style="text-align: left"><?=$arItem["MEASURE_TEXT"]?></td>
													<?
												}
												?>
											</tr>
										</table>
									</div>
									<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
								</td>
							<?
							elseif ($arHeader["id"] == "PRICE"):
							?>
								<td class="price">
										<div class="current_price" id="current_price_<?=$arItem["ID"]?>">
											<?=$arItem["PRICE_FORMATED"]?>
										</div>
										<div class="old_price" id="old_price_<?=$arItem["ID"]?>">
											<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
												<?=$arItem["FULL_PRICE_FORMATED"]?>
											<?endif;?>
										</div>

									<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
										<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
										<div class="type_price_value"><?=$arItem["NOTES"]?></div>
									<?endif;?>
								</td>
							<?
							elseif ($arHeader["id"] == "DISCOUNT"):
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<div id="discount_value_<?=$arItem["ID"]?>"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></div>
								</td>
							<?
							elseif ($arHeader["id"] == "WEIGHT"):
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<?=$arItem["WEIGHT_FORMATED"]?>
								</td>
							<?
							else:
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<?
									if ($arHeader["id"] == "SUM"):
									?>
										<div id="sum_<?=$arItem["ID"]?>">
									<?
									endif;

									echo $arItem[$arHeader["id"]];

									if ($arHeader["id"] == "SUM"):
									?>
										</div>
									<?
									endif;
									?>
								</td>
							<?
							endif;
						endforeach;

						if ($bDelayColumn || $bDeleteColumn):
						?>
							<td class="control">
								<?
								if ($bDeleteColumn):
								?>
									<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><?=GetMessage("SALE_DELETE")?></a><br />
								<?
								endif;
								if ($bDelayColumn):
								?>
									<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><?=GetMessage("SALE_DELAY")?></a>
								<?
								endif;
								?>
							</td>
						<?
						endif;
						?>
							<td class="margin"></td>
					</tr>
					<?
					endif;
				endforeach;
				?>
			</tbody>
		</table>
	</div>
	<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
	<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
	<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
	<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
	<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />

	<div class="bx_ordercart_order_pay">

		<div class="bx_ordercart_order_pay_left" id="coupons_block">
		<?
		if ($arParams["HIDE_COUPON"] != "Y")
		{
		?>
			<div class="bx_ordercart_coupon">
				<span><?=GetMessage("STB_COUPON_PROMT")?></span><input type="text" id="coupon" name="COUPON" value="" onchange="checkCoupon(this);">
			</div><?
				if (!empty($arResult['COUPON_LIST']))
				{
					foreach ($arResult['COUPON_LIST'] as $oneCoupon)
					{
						$couponClass = 'disabled';
						switch ($oneCoupon['STATUS'])
						{
							case DiscountCouponsManager::STATUS_NOT_FOUND:
							case DiscountCouponsManager::STATUS_FREEZE:
								$couponClass = 'bad';
								break;
							case DiscountCouponsManager::STATUS_APPLYED:
								$couponClass = 'good';
								break;
						}
						?><div class="bx_ordercart_coupon"><input disabled readonly type="text" name="OLD_COUPON[]" value="<?=htmlspecialcharsbx($oneCoupon['COUPON']);?>" class="<? echo $couponClass; ?>"><span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span><div class="bx_ordercart_coupon_notes"><?
						if (isset($oneCoupon['CHECK_CODE_TEXT']))
						{
							echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
						}
						?></div></div><?
					}
					unset($couponClass, $oneCoupon);
				}
		}
		else
		{
			?> <?
		}
?>
		</div>
		<div class="bx_ordercart_order_pay_right">
			<table class="bx_ordercart_order_sum">
				<?if ($bWeightColumn):?>
					<tr>
						<td class="custom_t1"><?=GetMessage("SALE_TOTAL_WEIGHT")?></td>
						<td class="custom_t2" id="allWeight_FORMATED"><?=$arResult["allWeight_FORMATED"]?></td>
					</tr>
				<?endif;?>
				<?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
					<tr>
						<td><?echo GetMessage('SALE_VAT_EXCLUDED')?></td>
						<td id="allSum_wVAT_FORMATED"><?=$arResult["allSum_wVAT_FORMATED"]?></td>
					</tr>
					<tr>
						<td><?echo GetMessage('SALE_VAT_INCLUDED')?></td>
						<td id="allVATSum_FORMATED"><?=$arResult["allVATSum_FORMATED"]?></td>
					</tr>
				<?endif;?>

					<tr>
						<td class="fwb"><?=GetMessage("SALE_TOTAL")?></td>
						<td class="fwb" id="allSum_FORMATED"><?=str_replace(" ", " ", $arResult["allSum_FORMATED"])?></td>
					</tr>
					<tr>
						<td class="custom_t1"></td>
						<td class="custom_t2" style="text-decoration:line-through; color:#828282;" id="PRICE_WITHOUT_DISCOUNT">
							<?if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
								<?=$arResult["PRICE_WITHOUT_DISCOUNT"]?>
							<?endif;?>
						</td>
					</tr>

			</table>
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>
		<div class="bx_ordercart_order_pay_center">

			<?if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
				<?=$arResult["PREPAY_BUTTON"]?>
				<span><?=GetMessage("SALE_OR")?></span>
			<?endif;?>

			<a href="javascript:void(0)" onclick="checkOut();" class="checkout"><?=GetMessage("SALE_ORDER")?></a>
		</div>
	</div>
</div>
*/?>
<?
else:
?>
<div id="basket_items_list">
		<div class="cart_left col-12 col-md-9">
			<div class='add_by_art'>

				<p class='ttl'>Добавить товары по артикулу</p>
				<div class='dwnld_block'>
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_DIR."include/file_multi_load_text.php",
							"AREA_FILE_RECURSIVE" => "N",
							"EDIT_MODE" => "html",
						),
						false,
						Array('HIDE_ICONS' => 'Y')
					);?>
					<a href='' class='insert_file'>загрузить файл</a>
					<input type="file" name="XLS" style="display: none" id="xls_input">

				</div>

				<div class='inp_line_wp'>
					<div class='inp_line' data-price="0">
						<div class="inp_block code">
							<input type="hidden" class="h_id_inp" name="ID[]">
							<input type='text' class='inp_self item_atr' value='' placeholder='Введите артикул'>
							<p class='inp_val price'>0<span>руб.</span></p>
						</div>
						<div class="inp_block quantity">
							<input type='text' name="quantity[]" class='inp_self short' value='1'>
							<span class='col'>шт.</span>
							<p class='inp_val sum'>0<span>руб.</span></p>
						</div>
						<a href='' class='delete_line'></a>
					</div>

					<a href='' class='add_line'>Добавить поля</a>
					<a href='' class='to_basket'>в корзину</a>

				</div>
				<div class='clear'></div>
			</div>
		</div>
	<table>
		<tbody>
			<tr>
				<td colspan="<?=$numCells?>" style="text-align:center">
					<div class=""><?=GetMessage("SALE_NO_ITEMS");?></div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?
endif;
?>