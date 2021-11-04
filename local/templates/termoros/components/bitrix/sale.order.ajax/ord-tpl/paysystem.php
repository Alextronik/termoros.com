<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

	<script type="text/javascript">
		function changePaySystem(param)
		{
			/*if (BX("account_only") && BX("account_only").value == 'Y') // PAY_CURRENT_ACCOUNT checkbox should act as radio
			{
				if (param == 'account')
				{
					if (BX("PAY_CURRENT_ACCOUNT"))
					{
						BX("PAY_CURRENT_ACCOUNT").checked = true;
						BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
						BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');

						// deselect all other
						var el = document.getElementsByName("PAY_SYSTEM_ID");
						for(var i=0; i<el.length; i++)
							el[i].checked = false;
					}
				}
				else
				{
					BX("PAY_CURRENT_ACCOUNT").checked = false;
					BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
					BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
				}
			}
			else if (BX("account_only") && BX("account_only").value == 'N')
			{
				if (param == 'account')
				{
					if (BX("PAY_CURRENT_ACCOUNT"))
					{
						BX("PAY_CURRENT_ACCOUNT").checked = !BX("PAY_CURRENT_ACCOUNT").checked;

						if (BX("PAY_CURRENT_ACCOUNT").checked)
						{
							BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
							BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
						}
						else
						{
							BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
							BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
						}
					}
				}
			}*/

			submitForm();
		}
	</script>
	<div class='bonus_wp'>
	<?
		if (!empty($arResult["PAY_SYSTEM"]) && is_array($arResult["PAY_SYSTEM"]) || $arResult["PAY_FROM_ACCOUNT"] == "Y")
		{
			
		}
		if ($arResult["PAY_FROM_ACCOUNT"] == "Y")
		{
			$accountOnly = ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y") ? "Y" : "N";
			?>
			<input type="hidden" id="account_only" value="<?=$accountOnly?>" />
			<div class="bx_block w100 vertical">
				<div class="bx_element">
					<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N">
					<label for="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT_LABEL" onclick="changePaySystem('account');" class="<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo "selected"?>">
						<input type="checkbox" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo " checked=\"checked\"";?>>
						<div class="bx_logotype">
							<span style="background-image:url(<?=$templateFolder?>/local/templates/termoros/components/bitrix/sale.order.ajax/ord-tpl/images/logo-default-ps.gif);"></span>
						</div>
						<div class="bx_description">
							<strong><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT")?></strong>
							<p>
								<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT1")." <b>".$arResult["CURRENT_BUDGET_FORMATED"]?></b></div>
								<? if ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y"):?>
									<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT3")?></div>
								<? else:?>
									<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT2")?></div>
								<? endif;?>
							</p>
						</div>
					</label>
					<div class="clear"></div>
				</div>
			</div>
		
					<p class='ttl'>На Вашем бонусном счете 12 345 руб.</p>
					<p class="sub">Оплатите покупку частично или полностью средствами бонусного счета</p>
					<input type="text" class="inp_self" value="" placeholder="0022-1234-6587">
					<a href="" class="btn">оплатить</a>
					
				
				
			<?
		}
		?>
			<div class="order_params">
						<p class="ttl">Параметры заказа</p>
						<?$quan = 0;?>
						<?foreach ($arResult["GRID"]["ROWS"] as $k => $arData):?>
						<?$quan += $arData['data']['QUANTITY'];?>
						<?endforeach;?>
						<div class="par_wp">
							<p class="name">Товаров</p>
							<p class="value"><span><?=$quan;?></span>шт.</p>
						</div>
						
						<div class="par_wp">
							<p class="name">Стоимость заказа</p>
							<p class="value"><span><?=$arResult["ORDER_PRICE"]?></span>руб. -</p>
						</div>
						
						<?if($arResult["DISCOUNT_PRICE"]):?>
						<div class="par_wp sale">
							<p class="name">Скидка</p>
							<p class="value"><span><?=$arResult["DISCOUNT_PRICE"]?></span>руб. -</p>
						</div>
						<?endif;?>
						
						<?if($arResult["DELIVERY_PRICE"]):?>
						<div class="par_wp ">
							<p class="name">Доставка</p>
							<p class="value"><span><?//=$arResult['DELIVERY'][$arResult['USER_VALS']['DELIVERY_ID']]['PRICE'];?><?=$arResult["DELIVERY_PRICE"]?></span>руб. -</p>
						</div>
						<?endif;?>
						
						<div class="par_wp fin">
							<p class="name">Итого</p>							
							<p class="value"><span><?=$arResult["ORDER_PRICE"]+$arResult["DELIVERY_PRICE"]?></span>руб. -</p>
						</div>
						<?//p($arResult['DELIVERY'][$arResult['USER_VALS']['DELIVERY_ID']]['PRICE']);?>
					</div>
				</div>
	
	<div class='pay_block'>
		<p class='ttl'>Выберите способ оплаты</p>
		<?
		uasort($arResult["PAY_SYSTEM"], "cmpBySort"); // resort arrays according to SORT value

		foreach($arResult["PAY_SYSTEM"] as $arPaySystem)
		{
			if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) > 0 || intval($arPaySystem["PRICE"]) > 0)
			{
				if (count($arResult["PAY_SYSTEM"]) == 1)
				{
					?>
					<div class='order_type_wp <?if($arPaySystem["CHECKED"]=="Y") :?>active<?endif;?>'>
						<div class='radio_wp'>
							<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
							<input type="radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								class='customRadio'
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();"
								/>
							<label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" >
								<?=$arPaySystem["PSA_NAME"];?>
							</label>
						</div>
						<div class='pay_wp pt<?=$arPaySystem["ID"]?>'>
							<span><?
								if (intval($arPaySystem["PRICE"]) > 0)
									echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
								else
									echo $arPaySystem["DESCRIPTION"];
								?>
							</span>
						</div>
					</div>
					<?
				}
				else // more than one
				{
				?>
					<div class='order_type_wp <?if($arPaySystem["CHECKED"]=="Y") :?>active<?endif;?>'>
						<div class='radio_wp'>
							<input type="radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								class='customRadio'
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();" />
							<label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" >
								<?=$arPaySystem["PSA_NAME"];?>
							</label>
						</div>
						<div class='pay_wp pt<?=$arPaySystem["ID"]?>'>
							<span><?
								if (intval($arPaySystem["PRICE"]) > 0)
									echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
								else
									echo $arPaySystem["DESCRIPTION"];
								?>
							</span>
						</div>
					</div>
							
				<?
				}
			}

			if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) == 0 && intval($arPaySystem["PRICE"]) == 0)
			{
				if (count($arResult["PAY_SYSTEM"]) == 1)
				{
					?>
					<div class='order_type_wp <?if($arPaySystem["CHECKED"]=="Y") :?>active<?endif;?>'>
						<div class='radio_wp'>
							<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
							<input type="radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								class='customRadio'
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();"
								/>
							<label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" >
								<?=$arPaySystem["PSA_NAME"];?>
							</label>
						</div>
						<div class='pay_wp pt<?=$arPaySystem["ID"]?>'>
							<span><?
								if (intval($arPaySystem["PRICE"]) > 0)
									echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
								else
									echo $arPaySystem["DESCRIPTION"];
								?>
							</span>
						</div>
					</div>
				<?
				}
				else // more than one
				{
				?>
					<div class='order_type_wp <?if($arPaySystem["CHECKED"]=="Y") :?>active<?endif;?>'>
						<div class='radio_wp'>
							<!--<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">-->
							<input type="radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								class='customRadio'
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();"
								/>
							<label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" >
								<?=$arPaySystem["PSA_NAME"];?>
							</label>
						</div>
						<div class='pay_wp pt<?=$arPaySystem["ID"]?>'>
							<span><?
								if (intval($arPaySystem["PRICE"]) > 0)
									echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
								else
									echo $arPaySystem["DESCRIPTION"];
								?>
							</span>
						</div>
					</div>
				<?
				}
			}
		}
		?>
		<div style="clear: both;"></div>
	</div>
