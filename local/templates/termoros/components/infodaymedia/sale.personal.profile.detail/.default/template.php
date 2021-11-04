<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$isPartner = \Redreams\Partners\partner::isPartner()?>
<?$curentProfile = \Redreams\Partners\contractor::getCurentContractor()?>
<div class='<?if($isPartner):?>partner_detail<?endif?> prof_item <?if($_REQUEST['added'] == $arResult["ID"]):?>opened<?endif;?>'>

	<div class='prof_opener_wp'>
		<?if(strlen($arResult["ID"])>0):?>
			<?=ShowError($arResult["ERROR_MESSAGE"])?>
		<?endif?>
<?//var_dump($arResult["XML_ID"])?>

		<a href='' class='prof_opener'><?echo $arResult["NAME"];?></a>


		<div class='prof_summary_wp'>
			<div class='ps_inner'>
			<?
				$ind = 1;
				foreach($arResult["ORDER_PROPS"] as $key => $val)
			{


				if(!empty($val["PROPS"]))
				{
					?>

					<?
					foreach($val["PROPS"] as $vval)
					{
						if($ind == 5){
						?>
							</div>
						</div>
						<div class='prof_summary_wp ps2'>
							<div class='ps_inner'>
						<?
						}

						if($ind > 8 && !$isPartner) continue;
						if($ind > 3 && $isPartner) continue;

						$currentValue = $arResult["ORDER_PROPS_VALUES"]["ORDER_PROP_".$vval["ID"]];
						$name = "ORDER_PROP_".$vval["ID"];
						?>
						<p><?=$currentValue?></p>
					<?
					$ind++;
					}
				}?>
			<?
			//p($ind);

			}
			?>
			</div>
		</div>
		<?if($isPartner):?>
			<label><input name='profile' <?if($curentProfile==$arResult['ID']):?>checked<?endif?> value="<?=$arResult["ID"]?>" type='radio' class='customRadio profile_radio'>Использовать для выставления счета</label>
		<?endif?>
		<?if(!\Redreams\Partners\partner::isPartner()):?>
			<a href='' class='edit'></a>
			<a href='?delete=<?echo $arResult["ID"];?>' class='del_prof'></a>
		<?endif?>
	</div>

	<?//p($arResult["ORDER_PROPS"])?>

	<?if($isPartner):?>
		<div class="partner_prof">
			<?foreach($arResult["ORDER_PROPS"] as $key => $val):?>
				<div class="pp_section">
					<?foreach($val["PROPS"] as $vval):?>
						<?$currentValue = $arResult["ORDER_PROPS_VALUES"]["ORDER_PROP_".$vval["ID"]];?>
						<?if($currentValue):?>
							<p class="pp_i"><span><?=$vval["NAME"]?>:&nbsp;</span><?=$currentValue?></p>
						<?endif?>
					<?endforeach?>
				</div>
			<?endforeach;?>
			<a href="" class="change_i">сменить информацию</a>
		</div>
	<?endif?>
	<div class='prof_inner'>
		<form method="post" action="<?=POST_FORM_ACTION_URI?>" class="validate <?if($isPartner):?>send_edit<?endif;?>">
		<div class="fieldset" style="display:none;">
			<input value="<?echo $arResult["NAME"];?>"type="text" name="NAME" title="Название" class="inp_self" placeholder="Название">
		</div>


		<?if(strlen($arResult["ID"])>0):?>
		<?=bitrix_sessid_post()?>
		<input type="hidden" name="ID" value="<?=$arResult["ID"]?>">

		<?//p($arResult['PERSON_TYPE']);?>
		<div class='choose_profile'>
			<p class='name'>Вы выступаете как</p>
			<input type='radio' checked class='customRadio'>
			<label><?=$arResult['PERSON_TYPE']['NAME'];?></label>
			<!--<input type='radio' class='customRadio'>
			<label>частное лицо</label>
			<input type='radio' class='customRadio'>
			<label>индивидуальный предприниматель</label>
			<input type='radio' checked class='customRadio'>
			<label>юридическое лицо</label>-->
		</div>

		<div class='prof_side'>

			<?
			//p($arResult["ORDER_PROPS"]);
			ksort($arResult["ORDER_PROPS"]);
			foreach($arResult["ORDER_PROPS"] as $key => $val)
			{
				//p($key);
				if($key == 8 || $key == 9){
				?>
				</div>
				<div class='prof_side right'>
				<?
				}

				if(!empty($val["PROPS"]))
				{
					?>

					<?
					foreach($val["PROPS"] as $vval)
					{
						$currentValue = $arResult["ORDER_PROPS_VALUES"]["ORDER_PROP_".$vval["ID"]];
						$name = "ORDER_PROP_".$vval["ID"];
						?>

				<?if ($vval["TYPE"]=="TEXT"):?>
					<?//p($vval)?>
					<div class="inpt <?=$vval["CODE"]?>">
						<p class="inp_name"><?=$vval["NAME"]?><?if ($vval["REQUIED"]=="Y"):?>*<?endif;?></p>

						<input <?if ($vval["REQUIED"]=="Y"):?>data-req='1'<?endif?> value="<?echo (isset($currentValue)) ? $currentValue : $vval["DEFAULT_VALUE"];?>"type="text" name="<?=$name?>" title="<?=$vval["NAME"]?>" class="inp_self" onfocus="if (this.value=='<?=$vval["NAME"]?>') this.value='';" onblur="if (this.value=='') this.value='<?=$vval["NAME"]?>';" >
					</div>

				<?elseif($vval["TYPE"]=="LOCATION"):?>
					<div class="inpt <?=$vval["CODE"]?>">
						<?//p($vval);?>
						<div class='del_block'>
						<p class='name'>Выберите город</p>
						<?$city = array_search($vval['VALUE']?$vval['VALUE']:$vval['DEFAULT_VALUE'], $_SESSION['GEOIP']['city_list'])?>
						<p class="locer">г.<?=$city;?> <?//=$vval['VALUE']?$vval['VALUE']:$vval['DEFAULT_VALUE'];?><a href="" onClick="$(this).parent().parent().next().show(); $(this).parent().hide(); return false;">изменить</a></p>
						</div>
						<div class="city" style="display: none;">
						<?
						$APPLICATION->IncludeComponent('bitrix:sale.ajax.locations', 'popuphead', array( //popup
								"AJAX_CALL" => "N",
								'CITY_OUT_LOCATION' => 'Y',
								'COUNTRY_INPUT_NAME' => $name.'_COUNTRY',
								'CITY_INPUT_NAME' => $name,
								'LOCATION_VALUE' => isset($currentValue) ? $currentValue : $vval["DEFAULT_VALUE"],
							),
							null,
							array('HIDE_ICONS' => 'Y')
						);
						?>
						</div>
					</div>
				<?elseif($vval["TYPE"]=="TEXTAREA"):?>
					<div class="inpt <?=$vval["CODE"]?>">
						<p class="inp_name"><?=$vval["NAME"]?><?if ($vval["REQUIED"]=="Y"):?>*<?endif;?></p>
						<textarea <?if ($vval["REQUIED"]=="Y"):?>data-req='1'<?endif?> type="text" name="<?=$name?>" title="<?=$vval["NAME"]?>" class="inp_self"><?echo (isset($currentValue)) ? $currentValue : $vval["DEFAULT_VALUE"];?></textarea>
					</div>
				<?endif?>
				<?
				}
			}?>

			<div class="clear"></div>
			<?
			}
			?>
			<?else:?>
				<?=ShowError($arResult["ERROR_MESSAGE"]);?>
			<?endif;?>

		</div>

		<div class='clear'></div>

				<div class='prof_btns'>
					<input type="reset" class='add_adres cancel' value="<?echo GetMessage("SALE_RESET")?>">
					<input type="submit" class="saves" name="apply" value="<?=GetMessage("SALE_APPLY")?>">
				</div>


		</form>
	</div>
</div>
