<form method="post" class="head_contr">
    <div class='my_agent d-flex'><a href="/personal/profs/">Мои контрагенты</a>
        <select name="contractor" class='customSelect agent_sel' onchange="$('.head_contr').submit()">
			<?foreach ($arResult['PROFILES'] as $profile):?>
				<? if ($profile['XML_ID'] && strtotime($profile["DATE_UPDATE"]) > (time() - 60*60*24*5)) { ?>
					<option <?if($profile['SELECTED']):?>selected<?endif?> value="<?=$profile['ID']?>"><?=$profile['NAME']?></option>
				<? } ?>
            <?endforeach;?>
        </select>
    </div>
</form>