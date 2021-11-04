<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="section">
	<script type="text/javascript">
		function changePaySystem(param)
		{
			if (BX("account_only") && BX("account_only").value == 'Y') // PAY_CURRENT_ACCOUNT checkbox should act as radio
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
			}

			submitForm();
		}
	</script>
	<div class="bx_section order_details_wp">
		<div class='delivery_section'>
			
			<p class='name'>Выберите способ оплаты</p>
			<div class="inp_side">
		<?
		/*if ($arResult["PAY_FROM_ACCOUNT"] == "Y")
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
							<span style="background-image:url(<?=$templateFolder?>/images/logo-default-ps.gif);"></span>
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
			<?
		}*/

		uasort($arResult["PAY_SYSTEM"], "cmpBySort"); // resort arrays according to SORT value
		$col=0;
		\Bitrix\Main\Loader::includeModule('redreams.partners');
		$isPartner = \Redreams\Partners\partner::isPartner();
		foreach($arResult["PAY_SYSTEM"] as $arPaySystem)
		{
			$col++;
			//Для партнеров только выставление счета
			if ($isPartner && $arPaySystem["ID"] != 1) continue;
			
			//Для яндекс кассы, все кроме Питера
			if ($arPaySystem["ID"] == 11 && $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'] == 213) continue;
			
			//Для Сбербанка, только Москва
			//if ($arPaySystem["ID"] == 14 && $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'] != 208) continue;
			
			//Для Питерской кассы - только Питер
			if ($arPaySystem["ID"] == 13 && $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'] != 213) 
			{
				continue;
			}
			
			//if ($arPaySystem["ID"] == 15) continue;
			
			/*if($col == intval(count($arResult["PAY_SYSTEM"])/2)+1)
			{
				?>
			</div>

			<div class="inp_side right">
				<?
			}*/
				//var_dump($isPartner);
				/*
				if (count($arResult["PAY_SYSTEM"]) == 1)
				{
					?>
						<div class="bx_element radio_wp">
							<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
							<input type="radio"
								class='customRadio'
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								onclick="changePaySystem();"
								/>
							<label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
							<?=$arPaySystem["PSA_NAME"];?>
							
							</label>
						</div>
				<?
				}
				else // more than one
				{
				*/
				
				?>
					<div class="bx_element radio_wp">
						<input type="radio" class='customRadio'
							id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
							name="PAY_SYSTEM_ID"
							value="<?=$arPaySystem["ID"]?>"
							<? if (($isPartner && $arPaySystem["ID"] == 1) || ($arPaySystem["ID"] == 1 && $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'] == 213)) { ?>checked="checked"<? } ?>
							<? if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
							onclick="changePaySystem();" />

						<label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
							<?/*
							if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
								$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
							else:
								$imgUrl = $templateFolder."/images/logo-default-ps.gif";
							endif;
							?>
							<div class="bx_logotype">
								<img src="<?=$imgUrl?>">
							</div>
							<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
								<div class="bx_description">
									<div class="clear"></div>
									<strong>
										<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
											<?=$arPaySystem["PSA_NAME"];?>
										<?else:?>
											<?="&nbsp;"?>
										<?endif;?>
									</strong>
									<p><?=$arPaySystem["DESCRIPTION"]?></p>
								</div>
							<?endif;*/?>
							<?=$arPaySystem["PSA_NAME"];?>
						</label>
					</div>

				<?
				/*
				}
				*/
		}
		?>
				</div>
			<?/*?>
			<div class="clear"></div>
				<a onclick="setStep(1,false)" class="continue_order back">назад</a>

		<?if($rez["COU"][2]>0&&$rez["COU"][1]<>0){?>
		<a onclick="setStep(3,true,this)" class="continue_order">продолжить</a>
		<?}*/?>
		<div class="clear"></div>	
	</div>

	</div>

</div>