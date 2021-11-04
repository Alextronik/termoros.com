<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="reg_wrap" <?if($_POST['TYPE']=='REGISTRATION'):?>style="display: block;"<?endif?>>
	<?if (count($arResult["ERRORS"]) > 0):?>
		<p><span class="rules errortext">
			<?
				foreach ($arResult["ERRORS"] as $key => $error)
					if ((intval($key) === 0 || intval($key) > 0)||(intval($key)==0&&GetMessage("REGISTER_FIELD_".$key))) 
					echo str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error)."<br />";
			?></span>
		</p>
	<?endif;?>
	
	<?if(!$arResult['VALUES']["CONFIRM_CODE"]):?>
	<a href="javascript:void(0);" class="toreg">Авторизоваться</a>
	 <div class="auth reg_order" <?if($_POST['TYPE']=='REGISTRATION'):?>style="display: block;"<?endif?>>
		<div class="authform reg">
			<span class="title">Регистрация</span>
			<form method="post" action="<?= $arParams["PATH_TO_ORDER"] ?>" name="order_auth_form">
			<?=bitrix_sessid_post()?>
			<label for="login">Email</label>
			<input autocomplete="off" name="REGISTER[LOGIN]" type="text" id="login" class="textfield <?if (is_array($arResult["ERRORS"]) && array_key_exists('LOGIN', $arResult['ERRORS'])):?>error<?endif?>">
			
			<input type="hidden" name="USER_NAME" value=" " />
			<input type="hidden" name="USER_LAST_NAME" value=" " /> 	
			
			<input id="mail_hidden_inner" type="hidden" name="REGISTER[EMAIL]" value="<?=trim($arResult["VALUES"]["LOGIN"])?>" class="inputbox" size="18">
			<label for="pass">Пароль</label>
			<input autocomplete="off" name="REGISTER[PASSWORD]" type="password" id="pass" class="textfield <?if (is_array($arResult["ERRORS"]) && array_key_exists('LOGIN', $arResult['ERRORS'])):?>error<?endif?>">
			<label for="pass">Повторить пароль</label>
			<input autocomplete="off" name="REGISTER[CONFIRM_PASSWORD]" type="password" id="pass" class="textfield <?if (is_array($arResult["ERRORS"]) && array_key_exists('LOGIN', $arResult['ERRORS'])):?>error<?endif?>">		
			<input type="submit" name="register_submit_button" value="Регистрация" class="button reg">
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="REGISTRATION" />
			</form>
		</div>
	</div>	
	<?else:?>
		<p>
		<span class="rules">
			<br>
			Спасибо!<br>
			Вы успешно зарегистровались! 
			<br>
			<br>
			Дальнейшие инструкции высланы на указанный Email.
		</span>
		<br /> <br />
		</p>
	<?endif?>
</div>
