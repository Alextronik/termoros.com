<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class='oc_left'>

	<?
	$bHideProps = true;

	if (is_array($arResult["ORDER_PROP"]["USER_PROFILES"]) && !empty($arResult["ORDER_PROP"]["USER_PROFILES"])):
		if ($arParams["ALLOW_NEW_PROFILE"] == "Y"):
		?>
				<select class='customSelect order_prof' name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
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
			
		<?
		else:
		?>
			
			
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
						<select class='customSelect order_prof' name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
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
			
		<?
		endif;
	else:
		$bHideProps = false;
	endif;
	?>

<?
if(count($arResult["PERSON_TYPE"]) > 1)
{
	?>
	<div class='choose_prof'>
		<p class='name'>Вы выступаете как</p>
		<?foreach($arResult["PERSON_TYPE"] as $v):?>
			<input class='customRadio' type="radio" id="PERSON_TYPE_<?=$v["ID"]?>" name="PERSON_TYPE" value="<?=$v["ID"]?>"<?if ($v["CHECKED"]=="Y") echo " checked=\"checked\"";?> onClick="submitForm()"> 
			<label for="PERSON_TYPE_<?=$v["ID"]?>"><?=$v["NAME"]?></label>
			
			<?endforeach;?>
		<div class="clear"></div>
		<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>" />

	<?
}
else
{
	if(IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0)
	{
		//for IE 8, problems with input hidden after ajax
		?>
		<span style="display:none;">
		<input type="text" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
		<input type="text" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
		</span>
		<?
	}
	else
	{
		foreach($arResult["PERSON_TYPE"] as $v)
		{
			?>
			<input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>" />
			<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>" />
			<?
		}
	}
}
?>
	</div>
	
</div>