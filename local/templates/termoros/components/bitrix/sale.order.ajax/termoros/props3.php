<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");
//p($arResult['curentContractor']);
//p($arResult["ORDER_PROP"]["USER_PROFILES"]);

?>
<div class="inpt">
	<?if(Redreams\Partners\partner::isPartner()):?>
		<?if(empty($arResult["ORDER_PROP"]["USER_PROFILES"])):?>
			<p>У вас нет доступных контрагентов на этом типе плательшика.</p>
			<?$hideNext = true;?>
		<?endif?>
	<?endif;?>
	<?
	$bHideProps = true;

	if (is_array($arResult["ORDER_PROP"]["USER_PROFILES"]) && !empty($arResult["ORDER_PROP"]["USER_PROFILES"])):
		if ($arParams["ALLOW_NEW_PROFILE"] == "Y"):
		?>
			<div class="bx_block r3x1">
				<select class='customSelect prof_select' name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
					<option value="0"><?=GetMessage("SOA_TEMPL_PROP_NEW_PROFILE")?></option>
					<?
					foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
					{

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
					<?
					foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
					{
						?>
						<option value="<?= $arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected";?>><?=$arUserProfiles["NAME"]?></option>
						<?
					}
					?>
				</select>
				<div style="clear: both;"></div>
			</div>
			<?//if($arResult['adresses']):?>
				<h3>Адрес доставки *</h3>
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
					<?if(!$arResult['adresses'] || $_REQUEST['ADRESS_ID']=='NEW'):?>
						<div class="inpt" data-property-id-row="9">
							<input onkeyup="SetAdress(this,true)" type="text" class=" inp_self  " data-req="1" value="<?=$_REQUEST['MY_ADDR']?>" maxlength="250" size="" name="MY_ADDR" id="MY_ADDR">
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

		<div id="sale_order_props" >
			<div class="order_side">
			<?
				PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"],array("1","3","6"));
				//PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"],array("5"));
			?>
			</div>
			<div class="order_side right">
			<?
				PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"],array("8","9","5","4"));
			?>
			</div>
		</div>
		<div class="clear"></div>
	</div>


	<?if(($_REQUEST['STEP'] == 1 || !$_REQUEST['STEP']) && !$hideNext):?>
		<?if($rez["COU"][1]>0||($rez["COU"][1]==0&&$rez["COU"][2]>0))
		{?>
		<a onclick="setStep(2,true,this); return false;" class="continue_order next_step">продолжить</a>
		<?}else{?>
		<a onclick="setStep(3,true,this) return false;" class="continue_order next_step">продолжить</a>
		<?}
	endif?>
	<div class='clear'></div>

