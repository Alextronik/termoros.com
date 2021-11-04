<select style="padding: 5px;" name="RefContractor">
	<?foreach ($arResult['PROFILES'] as $profile):?>
		<? if ($profile['XML_ID'] && strtotime($profile["DATE_UPDATE"]) > (time() - 60*60*24*5)) { ?>
			<option <?if($profile['SELECTED']):?>selected<?endif?> value="<?=$profile['XML_ID']?>"><?=$profile['NAME']?></option>
		<? } ?>
	<?endforeach;?>
</select>
