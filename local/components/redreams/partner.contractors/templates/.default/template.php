<form method="post">
    <p class='ttl'>Мой контрагент</p>
    <select name="contractor" class='customSelect part_select'>
        <?foreach ($arResult['PROFILES'] as $profile):?>
		<? if ($profile['XML_ID'] && strtotime($profile["DATE_UPDATE"]) > (time() - 60*60*24*5)) { ?>
            <? if ($profile["XML_ID"]) { ?>
				<option <?if($profile['SELECTED']):?>selected<?endif?> value="<?=$profile['ID']?>"><?=$profile['NAME']?></option>
			<? } ?>
        <? } ?>
		<?endforeach;?>
    </select>
    <?if(count($arResult['PROFILES'])>1):?>
     <a href='' onclick="$(this).parent().submit(); return false;" class='btn'>сменить</a>
    <?endif?>
</form>