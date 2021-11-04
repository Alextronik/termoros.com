<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");
//var_dump($_REQUEST);
//var_dump($arResult["ORDER_PROP"]["USER_PROFILES"]);

?>
<div class="inpt">
	<?if(Redreams\Partners\partner::isPartner()):?>
		<?if(empty($arResult["ORDER_PROP"]["USER_PROFILES"])):?>
			<p><b>У вас нет доступных контрагентов на этом типе плательшика. Чтобы загрузить контрагентов на сайт обратитесь к Вашему менеджеру.</b></p>
			<?$hideNext = true;?>
		<?endif?>
	<?endif;?>
	<?
	$bHideProps = true;

	
	foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $k => $arUserProfiles)
	{
		$arUserProfileExt = \CSaleOrderUserProps::GetByID($arUserProfiles["ID"]);
		$arResult["ORDER_PROP"]["USER_PROFILES"][$k]["XML_ID"] = $arUserProfileExt["XML_ID"];
		
		//v($arUserProfileExt);
		
		if ($arResult["ORDER_PROP"]["USER_PROFILES"][$k]["CHECKED"])
		{
			$selectedArUserProfileXmlId = $arResult["ORDER_PROP"]["USER_PROFILES"][$k]["XML_ID"];
		}
	}
	
	if (count($arResult["ORDER_PROP"]["USER_PROFILES"]) == 1)
	{
		foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $k => $arUserProfiles)
		{
			$selectedArUserProfileXmlId = $arResult["ORDER_PROP"]["USER_PROFILES"][$k]["XML_ID"];
		}
	}
		
	if (is_array($arResult["ORDER_PROP"]["USER_PROFILES"]) && !empty($arResult["ORDER_PROP"]["USER_PROFILES"])):
		if ($arParams["ALLOW_NEW_PROFILE"] == "Y"):
		?>
			<div class="bx_block r3x1">
				<select class='customSelect prof_select' name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
					<option value="0"><?=GetMessage("SOA_TEMPL_PROP_NEW_PROFILE")?></option>
					<?
					foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
					{
						//v($arUserProfiles["CHECKED"]);
						?>
						<option value="<?= $arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected";?>><?=$arUserProfiles["NAME"]?></option>
						<?
						
					}
					?>
				</select>

				<div style="clear: both;"></div>
			</div>
			<?/*if($arResult['adresses']):?>
			<h3>Адрес доставки</h3>
				<div class="bx_block r3x1">
					<select class='customSelect prof_select' name="ADRESS_ID" id="ADRESS_ID" onChange="SetAdress(this)">
						<option value="NEW">Другой адрес</option>
						<?
						foreach($arResult["adresses"] as $adress)
						{
							?>
							<option value="<?=$adress["UF_ADRESS"]?>"<?if ($_REQUEST["ADRESS_ID"]==$adress['UF_ADRESS']) echo " selected";?>><?=$adress["UF_ADRESS"]?></option>
							<?
						}
						?>
					</select>
					<div style="clear: both;"></div>
				</div>
			<?endif*/?>
		<?
		else:
		?>
			<h3>Контрагент</h3>
			<div class="bx_block r3x1">
				<select class='customSelect prof_select' name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this)">
					<?if ($arResult["USER_VALS"]["PERSON_TYPE_ID"] != $arResult["USER_VALS"]["PERSON_TYPE_OLD"] && $arResult["USER_VALS"]["PERSON_TYPE_OLD"]) {?><option selected="selected" value="">Выберите контрагента</option><? } ?>
					<?
					foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
					{
						if ($arUserProfiles["XML_ID"] && strtotime($arUserProfiles["DATE_UPDATE"]) > (time() - 60*60*24*5)) { 
						?>
							<option value="<?= $arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected";?>  ><?=$arUserProfiles["NAME"]?></option>
							<? if ($arUserProfiles["CHECKED"]=="Y") { ?>
								<?$arUserProfile = \CSaleOrderUserProps::GetByID($arUserProfiles["ID"]);?>
							<? } ?>
						<? } ?>
						<?
					}
					?>
				</select>
				<div style="clear: both;"></div>
			</div>
			<?//if($arResult['adresses']):?>
				<h3>Адрес доставки</h3>
				<div class="bx_block r3x1">
					<select class='customSelect prof_select' name="ADRESS_ID" id="ADRESS_ID" onChange="SetAdress(this)">
						<option value="NEW">Другой адрес</option>
						<?
						foreach($arResult["adresses"] as $adress)
						{
							?>
							<option  value="<?=$adress["UF_ADRESS"]?>"<?if ($_REQUEST["ADRESS_ID"]==$adress['UF_ADRESS']) echo " selected";?>><?=$adress["UF_ADRESS"]?></option>
							<?
						}
						?>
					</select>
					<div style="clear: both;"></div>
					<br>
					<?if(!$arResult['adresses'] || $_REQUEST['ADRESS_ID']=='NEW' || !$_REQUEST['ADRESS_ID']):?>
						<div class="inpt" data-property-id-row="9">
							<input onkeyup="SetAdress(this,true)" type="text" class=" inp_self  " <?/*data-req="1"*/?> value="<?=$_REQUEST['MY_ADDR']?>" maxlength="250" size="" name="MY_ADDR" id="MY_ADDR">
						</div>
					<?endif;?>
				</div>
			<?//endif?>
		<?
		endif;
	else:
		$bHideProps = false;
	endif;/**/
	?>
</div>

<?//echo"<pre>";print_r($arResult["ORDER_PROP"]);echo"</pre>";?>
	<div class="<?=$_REQUEST['STEP']!=1&&$_REQUEST['STEP'] ? "order_details_wp":"pers_info"?>">

		<div id="sale_order_props row" >
			<div class="order_side col-12 col-md-6">
			<?
				PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"],array("1","3","6"));
				//PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"],array("5"));
			?>
			</div>
			<div class="order_side right col-12 col-md-6">
			<?
				PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"],array("8","9","5","4"));
			?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?if(Redreams\Partners\partner::isOperator()) { ?>
		<h3>Адрес доставки</h3>
		<div class="bx_block r3x1">
			<div class="inpt">
				<input onkeyup="SetAdressOperator(this,true)" type="text" class=" inp_self  " <?/*data-req="1"*/?> value="<?=$_REQUEST['ORDER_PROP_19']?>" maxlength="250" size="" name="ORDER_PROP_19" id="MY_ADDR">
			</div>
		</div>
	<? } ?>
	<?if(($_REQUEST['STEP'] == 1 || !$_REQUEST['STEP']) && !$hideNext):?>
		<?if($rez["COU"][1]>0||($rez["COU"][1]==0&&$rez["COU"][2]>0))
		{?>
		<a onclick="setStep(2,true,this); yaCounter26951046.reachGoal('next_korzina'); ga('send', 'pageview','/virtual/next_korzina'); return false;" class="continue_order next_step">продолжить</a>
		<?}else{?>
		<a onclick="setStep(3,true,this); yaCounter26951046.reachGoal('next_korzina'); ga('send', 'pageview','/virtual/next_korzina'); return false;" class="continue_order next_step">продолжить</a>
		<?}
	endif?>
	<div class='clear'></div>

<?if ($selectedArUserProfileXmlId) { ?><input type="hidden" class="inp_self" id="ORDER_PROP_40" name="ORDER_PROP_40" value="<?=$selectedArUserProfileXmlId?>"><? } ?>
<?if ($selectedArUserProfileXmlId) { ?><input type="hidden" class="inp_self" id="ORDER_PROP_41" name="ORDER_PROP_41" value="<?=$selectedArUserProfileXmlId?>"><? } ?>
<?if ($selectedArUserProfileXmlId) { ?><input type="hidden" class="inp_self" id="ORDER_PROP_42" name="ORDER_PROP_42" value="<?=$selectedArUserProfileXmlId?>"><? } ?>