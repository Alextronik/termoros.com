<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
if($USER->IsAuthorized()){
	echo "OK";
}else{?>
	<?if (count($arResult["ERRORS"]) > 0):
	foreach ($arResult["ERRORS"] as $key => $error){
		?>

		<?
	}
		ShowError(implode("<br />", $arResult["ERRORS"]));


	?>
<?endif?>

		<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data"  id="top_reg_form">
			<?if($arResult["BACKURL"] <> ''):
				?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?
			endif;
			?>
			<p class="pop_ttl">Регистрация
			<?if (count($arResult["ERRORS"]) > 0):
				foreach ($arResult["ERRORS"] as $key => $error){
					?>
					<span class='err_txt'><?=$error?></span>
					<?
				}
				?>
			<?endif?>
			<a style="display: block;width: 310px;padding: 17px 0;border-radius: 3px;text-align: center;font-size: 14px;line-height: 16px;color: #ffffff;text-decoration: none;text-transform: uppercase;font-weight: 600;cursor: pointer;background: #b54526;margin: 20px 0 0 0;" href="/partners">Заявка на личный кабинет партнера</a>
			</p>
			
			<div class="inpt">
				<p class="inp_name">E-mail</p>
				<input type="text" name="REGISTER[LOGIN]" class="inp_self" value="<?=$arResult["VALUES"]["LOGIN"]?>" placeholder="">
			</div>

			<div class="inpt">
				<p class="inp_name">Пароль</p>
				<input type="password" name="REGISTER[PASSWORD]" class="inp_self" value="" placeholder="">
			</div>

			<div class="inpt">
				<p class="inp_name">Повторите пароль</p>
				<input type="password" name="REGISTER[CONFIRM_PASSWORD]" class="inp_self" value="" placeholder="">
			</div>
			<?if ($arResult["USE_CAPTCHA"] == "Y")
			{
			?>
			<div class="inpt">
				<span class="b"><?=GetMessage("REGISTER_CAPTCHA_TITLE")?></span>
			</div>
			<div class="inpt">
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<div class="inn fst" >
					<?=GetMessage("REGISTER_CAPTCHA_PROMT")?>:<span class="starrequired">*</span>
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
				</div>
				<div class="inn" >
					<input type="text" class="inp_self"  name="captcha_word" maxlength="50" value="" />
				</div>
			</div>
			<?
			}?>
			<input class="pop_btn" type="submit" onclick="yaCounter26951046.reachGoal('register_finish'); ga('send', 'pageview','/virtual/register_finish'); return true;" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />
			<div class="clear"></div>

		</form>
	<?}?>
