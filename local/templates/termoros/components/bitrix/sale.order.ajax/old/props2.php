<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format2.php");
?>
<div class="section">




	<?
	$bHideProps = true;

	/*if (is_array($arResult["ORDER_PROP"]["USER_PROFILES"]) && !empty($arResult["ORDER_PROP"]["USER_PROFILES"])):
		if ($arParams["ALLOW_NEW_PROFILE"] == "Y"):
		?>
			<div class="bx_block r1x3">
				<?=GetMessage("SOA_TEMPL_PROP_CHOOSE")?>
			</div>
			<div class="bx_block r3x1">
				<select  class="customSelect" name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
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
		<?
		else:
		?>
			<div class="bx_block r1x3">
				<?=GetMessage("SOA_TEMPL_EXISTING_PROFILE")?>
			</div>
			<div class="bx_block r3x1">
					<?
					if (count($arResult["ORDER_PROP"]["USER_PROFILES"]) == 1)
					{
						foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
						{
							echo "<strong>".$arUserProfiles["NAME"]."</strong>";
							?>
							<input type="hidden" name="PROFILE_ID" id="ID_PROFILE_ID" value="<?=$arUserProfiles["ID"]?>" />
							<?
						}
					}
					else
					{
						?>
						<select name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
							<?
							foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
							{
								?>
								<option value="<?= $arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected";?>><?=$arUserProfiles["NAME"]?></option>
								<?
							}
							?>
						</select>
						<?
					}
					?>
				<div style="clear: both;"></div>
			</div>
		<?
		endif;
	else:
		$bHideProps = false;
	endif;*/
	?>
</div>

<br/>
<div class="bx_section">

<?//echo"<pre>";print_r($arResult["ORDER_PROP"]);echo"</pre>";?>
	
	<div <?if($_REQUEST["DELIVERY_ID"]==2){?>style="display: none;"<?}?> class="<?=$_REQUEST['STEP']!=1&&$_REQUEST['STEP'] ? "order_details_wp":"pers_info"?>">
			<p class="name">Данные для доставки</p>
			<p class="n_i">Сначала введите адрес, а после выберите способ доставки</p>
			<p class="sub_t">Адрес доставки</p>
		<?if($arResult['ADR']){?>
		<select class='customSelect adr_select' name="ATR">
			<?
			foreach($arResult['ADR'] as $key => $val):
				?>
				<option data-id="<?=$val['ID']?>"><?=$val["NAME"]?></option>
			<?endforeach;?>

		</select>
		<?}?>
		<div id="sale_order_props" >
			<?
				PrintPropsForm2($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"],5);
				PrintPropsForm2($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"],5);
			?>
		</div>
		<div class="clear"></div>
	</div>
	
	<?if($_REQUEST['STEP'] == 1 || !$_REQUEST['STEP']):?>
	<a onclick="setStep(2,true,this)" class="continue_order">продолжить</a>
	<?endif?>
</div>



