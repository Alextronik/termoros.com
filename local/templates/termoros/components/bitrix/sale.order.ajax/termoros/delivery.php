<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<script type="text/javascript">
	function fShowStore(id, showImages, formWidth, siteId)
	{
		var strUrl = '<?=$templateFolder?>' + '/map.php';
		var strUrlPost = 'delivery=' + id + '&showImages=' + showImages + '&siteId=' + siteId;

		var storeForm = new BX.CDialog({
					'title': '<?=GetMessage('SOA_ORDER_GIVE')?>',
					head: '',
					'content_url': strUrl,
					'content_post': strUrlPost,
					'width': formWidth,
					'height':450,
					'resizable':false,
					'draggable':false
				});

		var button = [
				{
					title: '<?=GetMessage('SOA_POPUP_SAVE')?>',
					id: 'crmOk',
					'action': function ()
					{
						GetBuyerStore();
						BX.WindowManager.Get().Close();
					}
				},
				BX.CDialog.btnCancel
			];
		storeForm.ClearButtons();
		storeForm.SetButtons(button);
		storeForm.Show();
	}

	function GetBuyerStore()
	{
		BX('BUYER_STORE').value = BX('POPUP_STORE_ID').value;
		//BX('ORDER_DESCRIPTION').value = '<?=GetMessage("SOA_ORDER_GIVE_TITLE")?>: '+BX('POPUP_STORE_NAME').value;
		BX('store_desc').innerHTML = BX('POPUP_STORE_NAME').value;
		BX.show(BX('select_store'));
	}

	function showExtraParamsDialog(deliveryId)
	{
		var strUrl = '<?=$templateFolder?>' + '/delivery_extra_params.php';
		var formName = 'extra_params_form';
		var strUrlPost = 'deliveryId=' + deliveryId + '&formName=' + formName;

		if(window.BX.SaleDeliveryExtraParams)
		{
			for(var i in window.BX.SaleDeliveryExtraParams)
			{
				strUrlPost += '&'+encodeURI(i)+'='+encodeURI(window.BX.SaleDeliveryExtraParams[i]);
			}
		}

		var paramsDialog = new BX.CDialog({
			'title': '<?=GetMessage('SOA_ORDER_DELIVERY_EXTRA_PARAMS')?>',
			head: '',
			'content_url': strUrl,
			'content_post': strUrlPost,
			'width': 500,
			'height':200,
			'resizable':true,
			'draggable':false
		});

		var button = [
			{
				title: '<?=GetMessage('SOA_POPUP_SAVE')?>',
				id: 'saleDeliveryExtraParamsOk',
				'action': function ()
				{
					insertParamsToForm(deliveryId, formName);
					BX.WindowManager.Get().Close();
				}
			},
			BX.CDialog.btnCancel
		];

		paramsDialog.ClearButtons();
		paramsDialog.SetButtons(button);
		//paramsDialog.adjustSizeEx();
		paramsDialog.Show();
	}

	function insertParamsToForm(deliveryId, paramsFormName)
	{
		var orderForm = BX("ORDER_FORM"),
			paramsForm = BX(paramsFormName);
			wrapDivId = deliveryId + "_extra_params";

		var wrapDiv = BX(wrapDivId);
		window.BX.SaleDeliveryExtraParams = {};

		if(wrapDiv)
			wrapDiv.parentNode.removeChild(wrapDiv);

		wrapDiv = BX.create('div', {props: { id: wrapDivId}});

		for(var i = paramsForm.elements.length-1; i >= 0; i--)
		{
			var input = BX.create('input', {
				props: {
					type: 'hidden',
					name: 'DELIVERY_EXTRA['+deliveryId+']['+paramsForm.elements[i].name+']',
					value: paramsForm.elements[i].value
					}
				}
			);

			window.BX.SaleDeliveryExtraParams[paramsForm.elements[i].name] = paramsForm.elements[i].value;

			wrapDiv.appendChild(input);
		}

		orderForm.appendChild(wrapDiv);

		BX.onCustomEvent('onSaleDeliveryGetExtraParams',[window.BX.SaleDeliveryExtraParams]);
	}
</script>



<div>

</div>

<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult["BUYER_STORE"]?>" />
<div class='delivery_section'>

	<p class='name'>Способ доставки</p>
	<p class="loc">г. <?=$_SESSION['GEOIP']['curr_city_name'] ? $_SESSION['GEOIP']['curr_city_name'] : $_SESSION['GEOIP']['city']?><a href="">изменить</a></p>
	<?
	if(!empty($arResult["DELIVERY"]))
	{
		$width = ($arParams["SHOW_STORES_IMAGES"] == "Y") ? 850 : 700;
		?>

			<div class='delivery_table'>
		<?
		$col=0;
		foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery)
		{
		$col++;
		/*if($col == intval(count($arResult["DELIVERY"])/2)+2)
		{
		?>
				</div>

				<div class="inp_side right">
					<?
					}
			?>
			<div class="clear"></div>
			<?*/
			if ($delivery_id !== 0 && intval($delivery_id) <= 0)
			{
				foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile)
				{
					?>
					<div class='dt_list'>
						<div class='dt_item lbl'>
							<input
								type="radio" class='customRadio'
								id="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>"
								name="<?=htmlspecialcharsbx($arProfile["FIELD_NAME"])?>"
								value="<?=$delivery_id.":".$profile_id;?>"
								<?=$arProfile["CHECKED"] == "Y" ? "checked=\"checked\"" : "";?>
								onchange="submitForm();"
								/>
							<label for="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>">
									<?=htmlspecialcharsbx($arDelivery["TITLE"]);?>
							</label>
						</div>

						<div class='dt_item'>
							<?if (strlen($arProfile["DESCRIPTION"]) > 0):?>
								<?=nl2br($arProfile["DESCRIPTION"])?>
							<?else:?>
								<?=nl2br($arDelivery["DESCRIPTION"])?>
							<?endif;?>
						</div>

						<div class='dt_item'>
							<span class="bx_result_price"><!-- click on this should not cause form submit -->
								<?
								if($arProfile["CHECKED"] == "Y" && doubleval($arResult["DELIVERY_PRICE"]) > 0):
								?>
									<div><?=GetMessage("SALE_DELIV_PRICE")?>:&nbsp;<b><?=$arResult["DELIVERY_PRICE_FORMATED"]?></b></div>
								<?
									if ((isset($arResult["PACKS_COUNT"]) && $arResult["PACKS_COUNT"]) > 1):
										echo GetMessage('SALE_PACKS_COUNT').': <b>'.$arResult["PACKS_COUNT"].'</b>';
									endif;

								else:
									$APPLICATION->IncludeComponent('bitrix:sale.ajax.delivery.calculator', '', array(
										"NO_AJAX" => $arParams["DELIVERY_NO_AJAX"],
										"DELIVERY" => $delivery_id,
										"PROFILE" => $profile_id,
										"ORDER_WEIGHT" => $arResult["ORDER_WEIGHT"],
										"ORDER_PRICE" => $arResult["ORDER_PRICE"],
										"LOCATION_TO" => $arResult["USER_VALS"]["DELIVERY_LOCATION"],
										"LOCATION_ZIP" => $arResult["USER_VALS"]["DELIVERY_LOCATION_ZIP"],
										"CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
										"ITEMS" => $arResult["BASKET_ITEMS"],
										"EXTRA_PARAMS_CALLBACK" => $extraParams
									), null, array('HIDE_ICONS' => 'Y'));
								endif;
								?>
							 руб.</span>
						</div>

						<div class='dt_item'>
							<a href='' class='lnk'>пункты самовывоза</a>
						</div>
					</div>
					<?
				} // endforeach
			}
			else // stores and courier
			{
				if (count($arDelivery["STORE"]) > 0)
					$clickHandler = "onClick = \"fShowStore('".$arDelivery["ID"]."','".$arParams["SHOW_STORES_IMAGES"]."','".$width."','".SITE_ID."')\";";
				else
					$clickHandler = "onClick = \"BX('ID_DELIVERY_ID_".$arDelivery["ID"]."').checked=true;submitForm();\"";
				?>
					<div class='dt_list'>
						<div class='dt_item lbl'>
							<input type="radio" class="customRadio"
								id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>"
								name="<?=htmlspecialcharsbx($arDelivery["FIELD_NAME"])?>"
								value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>
								   onchange="submitForm();"
								/>
							<label for="ID_DELIVERY_ID_<?=$arDelivery["ID"]?>" <?=$clickHandler?>>
								<?= htmlspecialcharsbx($arDelivery["NAME"])?>
							</label>
						</div>

						<div class='dt_item'>
							<?
							if (strlen($arDelivery["DESCRIPTION"])>0)
								echo $arDelivery["DESCRIPTION"];
							?>
						</div>

						<div class='dt_item'>
							<?if($arResult["DELIVERY_PRICE"]):?><?=$arDelivery["PRICE_FORMATED"]?><?endif;?>
						</div>

						<div class='dt_item'>
							<?
							if (count($arDelivery["STORE"]) > 0):
							?>
								<span style="display: none;" id="select_store"<?if(strlen($arResult["STORE_LIST"][$arResult["BUYER_STORE"]]["TITLE"]) <= 0) echo " style=\"display:none;\"";?>>
									<span class="select_store"><?=GetMessage('SOA_ORDER_GIVE_TITLE');?>: </span>
									<span class="ora-store" id="store_desc"><?=htmlspecialcharsbx($arResult["STORE_LIST"][$arResult["BUYER_STORE"]]["TITLE"])?></span>
								</span>
								<a href='' onclick="fShowStore('2','N','700','s1'); return false;" class='lnk'>пункты самовывоза</a>
							<?
							endif;
							?>

						</div>
					</div>


				<?
			}
		}
		?>

		<div class='delivery_adr' <?if(!$arResult["ORDER_PROP"]["RELATED"]):?>style="display: none;"<?endif?> >

			<p class='name'>Укажите адрес доставки</p>
			<div class='del_line'>
				<?/*?>
				<div class="inpt">
					<p class="inp_name">Улица</p>
					<input type="text" class="inp_self " value="" placeholder="Профсоюзная">
				</div>

				<div class="inpt short">
					<p class="inp_name">Дом</p>
					<input type="text" class="inp_self " value="" placeholder="15">
				</div>

				<div class="inpt short">
					<p class="inp_name">Корпус</p>
					<input type="text" class="inp_self " value="" placeholder="1">
				</div>

				<div class="inpt short">
					<p class="inp_name">Офис</p>
					<input type="text" class="inp_self " value="" placeholder="1234">
				</div>
				<?*/?>
				<?//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");?>
				<div class='clear'></div>
			</div>
			<?/*?>
			<div class="inpt">
				<p class="inp_name">Комментарий</p>
				<textarea class="inp_self " placeholder=""></textarea>
			</div>
			<?*/?>
			<a href='' class='next_step'>Продолжить</a>
			<div class='clear'></div>
		</div>


		</div>
		<div class="clear"></div>
		<?
	}
?>


<div class="clear"></div>
</div>

