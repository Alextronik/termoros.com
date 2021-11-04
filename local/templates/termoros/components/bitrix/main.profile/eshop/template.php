<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$this->setFrameMode(true);
//p($_REQUEST);
?>
<div class="profilepage">
		<div class='profile_area prof_settings' style="float: left;width: 352px;margin: 0px;" >

				<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" class="personal-form" enctype="multipart/form-data">

					<?=$arResult["BX_SESSION_CHECK"]?>
					<input type="hidden" name="personal_form" value="1" />
					<input type="hidden" name="lang" value="<?=LANG?>" />
					<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
					<input type="hidden" name="LOGIN" value=<?=$arResult["arUser"]["LOGIN"]?> />
					<input type="hidden" name="EMAIL" value=<?=$arResult["arUser"]["EMAIL"]?> />
					<input type="hidden" name="PERSONAL_PHONE" value=<?=$arResult["arUser"]["PERSONAL_PHONE"]?> />
					<div class='acc_f' style="margin-bottom: 5px;" >
						<?=ShowError($arResult["strProfileError"]);?>
						<?
						if ($arResult['DATA_SAVED'] == 'Y')
							echo ShowNote(GetMessage('PROFILE_DATA_SAVED'));
						?>
					</div>


					<!--<div class="inpt">
						<input class='inp_self' value="<?=$arResult["arUser"]["NAME"]?>" type="text" name="NAME" placeholder="ФИО" />
					</div>-->
					<?if(!\Redreams\Partners\partner::isPartner()):?>
						<div class="inpt">
							<p class="inp_name">E-mail</p>
							<input class='inp_self' value="<?=$arResult["arUser"]["EMAIL"]?>" type="text" name="EMAIL" placeholder="E-mail" />
						</div>
					<?endif?>
					<!--<div class="inpt">
						<input class='inp_self' value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" type="text" name="PERSONAL_PHONE" placeholder="Телефон" />
					</div>-->

					<p class='name'>Изменить пароль</p>

					<div class="inpt">
						<p class="inp_name">Новый пароль</p>
						<input id="authpass1" class='inp_self' type="password" name="NEW_PASSWORD" value="" placeholder="Пароль" />
					</div>
					<div class="inpt">
						<p class="inp_name">Повторить пароль</p>
						<input id="authpass" class='inp_self' type="password" autocomplete="off" name="NEW_PASSWORD_CONFIRM" value="" placeholder="Повторить пароль" />
					</div>
					<input type='submit' name="save" class='save_pers btn' value='сохранить'>

					<!--<input type='submit' class='cancel' value='отменить'>-->


				</form>

				<?/*
				$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", "", Array(
					"SHOW_PROFILES" => "Y",	// Показывать объединенные профили
						"ALLOW_DELETE" => "Y",	// Разрешить удалять объединенные профили
					),
					false
				);*/
				?>

				<div class="clear"></div>
				<?$APPLICATION->IncludeComponent(
					"bitrix:socserv.auth.split",
					"",
					Array(
						"ALLOW_DELETE" => "Y",
						"COMPONENT_TEMPLATE" => ".default",
						"SHOW_PROFILES" => "Y"
					)
				);?>
		</div>

		<!--
		<div class='prof_bonus'>

			<p class='ttl'>Ваши бонусы и скидки</p>

			<div class='pb_section'>
				<p class='name'>Ваш бонусный счет<a href=''>Узнать больше</a></p>

				<p class="price">121 234<span>руб.</span></p>
			</div>

			<div class='pb_section'>
				<p class='name'>Ваш кредитный счет<a href=''>Узнать больше</a></p>

				<p class="price">121 234<span>руб.</span></p>
			</div>

			<div class='pb_section sale'>
				<p class='name'>Ваша скидка<a href=''>Узнать больше</a></p>

				<div class='sale_label'>10 %</div>
			</div>

		</div>
		-->

	<div class='clear'></div>
</div>