<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");
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
	<div class="<?=$_REQUEST['STEP']!=1&&$_REQUEST['STEP'] ? "order_details_wp":"pers_info"?>">
		<p class="name">Личные данные</p>

		<div id="sale_order_props" >
			<?
				PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"],array("1","3"));
				//PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"],1);
			?>
		</div>
		<div class="clear"></div>
	</div>
	<?if($_REQUEST['STEP'] == 1 || !$_REQUEST['STEP']):?>
		<?if($rez["COU"][1]>0||($rez["COU"][1]==0&&$rez["COU"][2]>0)){?>
		<a onclick="setStep(2,true,this)" class="continue_order">продолжить</a>
			<?}else{?>
		<a onclick="setStep(3,true,this)" class="continue_order">продолжить</a>
	<?}
	endif?>
</div>



