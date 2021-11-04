<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arResult["FORM_TYPE"] == "login"):?>
<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" id="top_auth_form">
<?if($arResult["BACKURL"] <> ''):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
<?foreach ($arResult["POST"] as $key => $value):?>
	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
<?endforeach?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" /><!--span class='err_txt'>Некорректная комбинация Логин / Пароль</span-->
	<p class='pop_ttl'>Авторизация
		<?if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']){
            echo "<span class='err_txt'>".$arResult['ERROR_MESSAGE']['MESSAGE']."</span>";
		}?>
	</p>

	<div class='inpt'>
		<p class='inp_name'>Логин</p>
		<input type="text" class='inp_self' name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" size="17" />

	</div>

	<div class='inpt'>
		<p class='inp_name'>Пароль</p>
		<input type="password" class='inp_self' name="USER_PASSWORD" maxlength="50" size="17" autocomplete="off" />
		<a href='/auth?forgot_password=yes' class='forget_pass'>забыли пароль?</a>
	</div>
	<?if ($arResult["CAPTCHA_CODE"]):?>
		<div>
				<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:<br />
				<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br /><br />
				<input type="text" name="captcha_word" maxlength="50" value="" />
		</div>
	<?endif?>

	<div class='inpt lbl'>
		<input type="checkbox" class='customCheckbox' id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" />
		<label for="USER_REMEMBER_frm">запомнить</label>
	</div>


	<input class='pop_btn' type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" />
	<div class='clear'></div>


</form>



<?
else:
	echo "Вы успешно авторизовались.";
	?>
	<?if(\Redreams\Partners\partner::isPartner() && !$_SESSION['go']):?>
		<script>
			window.location.href="/personal/";
		</script>
		<?$_SESSION['go'] = true?>
	<?else:?>
		<script>
			window.location.href="/personal/";
		</script>
		<?$_SESSION['go'] = true?>
	<?endif?>
	<?
endif?>
<?if(!$USER->IsAuthorized())
{
	unset($_SESSION['go']);
}
?>
