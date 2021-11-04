<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$bDefaultColumns = $arResult["GRID"]["DEFAULT_COLUMNS"];
$colspan = ($bDefaultColumns) ? count($arResult["GRID"]["HEADERS"]) : count($arResult["GRID"]["HEADERS"]) - 1;
$bPropsColumn = false;
$bUseDiscount = false;
$bPriceType = false;
$bShowNameWithPicture = ($bDefaultColumns) ? true : false; // flat to show name and picture column in one column
?>
<?
	$quantityForOrder = 0;
	$priceForOrder = 0;
	$discountForOrder = 0;

	$arItemsSklad = 0;
	$priceForSklad = 0;
	$quantityForSklad = 0;
?>
<?foreach($arResult["GRID"]["ROWS"] as $arItem):?>
	<?
	$arItem = $arItem['data'];
	foreach($arItem['PROPS'] as $arProp)
	{
		$arPropsItem[$arProp['CODE']] = $arProp;
	}

	if(\Redreams\Partners\partner::isPartner())
	{
		$arItem['DISCOUNT_PRICE'] = $arItem["BASE_PRICE"]-$arItem['PRICE'];
	}

	//print_r($arItem);

	if($arItem["PROPERTY_FOR_ORDER_VALUE"]=="Да")
	{
		$arItemsForOrder[] = $arItem;
		if(\Redreams\Partners\partner::isPartner())
		{
			$priceForOrder += $arItem['BASE_PRICE']*$arItem['QUANTITY'];
		}
		else
		{
			$priceForOrder += $arItem['PRICE']*$arItem['QUANTITY'];
		}

		$quantityForOrder += $arItem['QUANTITY'];
		$discountForOrder += $arItem["DISCOUNT_PRICE"]*$arItem['QUANTITY'];
	}
	else
	{
		$arItemsSklad[] = $arItem;

		if(\Redreams\Partners\partner::isPartner())
		{
			$priceForSklad += $arItem['BASE_PRICE']*$arItem['QUANTITY'];
		}
		else
		{
			$priceForSklad += $arItem['PRICE']*$arItem['QUANTITY'];
		}

		$quantityForSklad += $arItem['QUANTITY'];
		$discountForSklad += $arItem["DISCOUNT_PRICE"]*$arItem['QUANTITY'];
	}
	$quantity += $arItem['QUANTITY'];
	?>
<?endforeach?>
<div class="bx_ordercart">

	<?/*if($_REQUEST['STEP']==2&&$rez["COU"][1]!=0&&$rez["COU"][2]>0){?>
		<p class="items_info">В Вашем заказе присутствуют товары, имеющиеся в наличии, а также товары "под заказ", доставка которых осуществляется отдельным отправлением.<br>
			Для оформления заказа сначала необходимо заполнить данные для доставки и оплаты товаров в наличии.<br>
			На следующей странице Вам будет предложено заполнить данные для доставки и оплаты товаров "под заказ".</p>
	<?}*/?>
	<?if($_REQUEST['STEP']==3||($_REQUEST['STEP']==2&&$rez["COU"][1]==0&&$rez["COU"][2]>0)):?>
		<?
		$price = $priceForOrder;
		$count = $quantityForOrder;
		$discount = $discountForOrder;
		$delivery=$deliver_price_2;
		?>
		<?/*?>
		<span>Товары под заказ</span>
		<?*/?>
	<?else:?>

		<?/*?><span>Товары, готовые к доставке</span><?*/?>
		<?
		$price = $priceForSklad;
		$count = $quantityForSklad;
		$discount = $discountForSklad;
		$delivery=$deliver_price_1;
		?>
	<?endif?>


	<?/*?><?*/?>
	<table class="order_table">
		<tr>
			<td>
				Стоимость
			</td>
			<td class="val">
				<?=CurrencyFormat($price,"RUB")?>
			</td>
		</tr>
		<tr>
			<td>
				Скидка
			</td>
			<td class="val">
				<?=CurrencyFormat($discount,"RUB")?>
			</td>
		</tr>
		<tr>
			<td>
				Итого
			</td>
			<td class="val">
				<?=CurrencyFormat($delivery+$price-$discount,"RUB")?>
			</td>
		</tr>
	</table>
	<?/*?>
	<div class="order_details_wp">
		<div class="summs_info">
			<p class="text">Товаров<span class="val"><?=$count?><span>шт</span></span></p>
			<p class="text">Стоимость заказа<span class="val"><?=CurrencyFormat($price,"RUB")?><span>руб</span></span></p>
			<?if (doubleval($arResult["DISCOUNT_PRICE"]) > 0) {?>
				<p class="text">Скидка<span class="val"><?=CurrencyFormat($discount,"RUB")?><span>руб</span></span></p>
			<?}
			if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
			{
				?>
				<p class="text">Доставка<span class="val"><?=CurrencyFormat($delivery,"RUB")?><span>руб</span></span></p>
				<?
			}?>
			<p class="text">Итого<span class="val"><?=CurrencyFormat($delivery+$price,"RUB")?><span>руб</span></span></p>
		</div>
	</div>
	<?*/?>
</div>
