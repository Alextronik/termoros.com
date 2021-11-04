<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?if(is_ajax()&&$_REQUEST['TYPE']=='ORDER_REGISTRATION'):?>
	<?ajax_start();?>
<?endif?>

<?


?>


<?//p($_REQUEST)?>

<p class="sftitle">Регистрация</p>

<?if($arResult['REGISTER_DONE'] == 'Y'):?>
	<?if($arParams['RELOAD_PAGE'] == 'Y'):?>
		<p>Вы успешно зарегистрировались!</p>
		<script>location.reload();</script>
	<?else:?>
		<p>Вы успешно зарегистрировались! Перейти в <a href="/personal/profile">Личный кабинет</a></p>
	<?endif?>
<?else:?>

	<?if (count($arResult["ERRORS"]) > 0 && $arParams['LIGHT_ERROR_FIELDS'] == 'N'):?>
		<span class="rules">
		<?
			foreach ($arResult["ERRORS"] as $key => $error)
				if ((intval($key) === 0 || intval($key) > 0)||(intval($key)==0&&GetMessage("REGISTER_FIELD_".$key))) 
					echo str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error)."<br />";
		?>
		</span>
	<?endif;?>	

	<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">

		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="REGISTRATION" />

		<?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
			<?$arFields = array (
				"EDIT_FORM_LABEL" => GetMessage("REGISTER_FIELD_".$FIELD),
				"NAME" => "REGISTER[".$FIELD."]",
				'USER_TYPE' => "TEXT",
				'PLACEHOLDER' => GetMessage("REGISTER_FIELD_".$FIELD),
				'VALUE' => trim($arResult["VALUES"][$FIELD]),
				"ERROR" =>  $arParams['LIGHT_ERROR_FIELDS'] == 'Y' ? str_replace("#FIELD_NAME#", "\"".GetMessage("REGISTER_FIELD_".$FIELD)."\"", $arResult["ERRORS"][$FIELD]) : '',
				"REQUIRED" => "Y",
				"IMAGE_PATH" =>"/img/web/email.png"
			);
			?>	

		<?switch ($FIELD)
		{
			case "PASSWORD":
		?>		
			<?$arFields['TYPE']='password'?>
			<?$arFields["IMAGE_PATH"] ="/img/web/parol.png"?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.field.edit",
				"text",
				array("arUserField" => $arFields, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>
		<?break;
			case "CONFIRM_PASSWORD":?>
			<?$arFields['TYPE']='password'?>
			<?$arFields["IMAGE_PATH"] ="/img/web/parol.png"?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.field.edit",
				"text",
				array("arUserField" => $arFields, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>			
		<?break;
		default:?>
			<?if($arParams['LOGIN_AS_EMAIL'] == "Y" && $FIELD == "EMAIL"):?>
				<?break;?>
			<?elseif($arParams['LOGIN_AS_EMAIL'] == "Y" && $FIELD == "LOGIN"):?>
				<?$arFields["EDIT_FORM_LABEL"] = GetMessage("REGISTER_FIELD_EMAIL");?>
				<?$arFields["ERROR"] =  $arParams['LIGHT_ERROR_FIELDS'] == 'Y' ? str_replace("#FIELD_NAME#", "\"".GetMessage("REGISTER_FIELD_EMAIL")."\"", $arResult["ERRORS"][$FIELD]) : '';?>
				<?$arFields["PLACEHOLDER"] =  'E-mail';?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:system.field.edit",
					"text",
					array("arUserField" => $arFields, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>			
			<?else:?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:system.field.edit",
					"text",
					array("arUserField" => $arFields, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>		
			<?endif?>
		<?}?>	
		<?endforeach?>	
			
		<div class="clear"></div>
		
		<?if($arParams['SHOW_SOCSERV']=="Y"):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.auth.form",
				"form_auth_reg",
				Array(
					"REGISTER_URL" => "",
					"FORGOT_PASSWORD_URL" => "",
					"PROFILE_URL" => "",
					"SHOW_ERRORS" => "N"
				),
			false
			);?>		
		<?endif?>
		
		<?if(strlen($arParams['REG_DESCRIPTION'])>0):?>
		<div class="formdescr">
			<span><?=$arParams['REG_DESCRIPTION']?></span>
		</div>
		<?endif?>
		<div class="clear"></div>
		<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
			<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>					
					<?$APPLICATION->IncludeComponent(
						"bitrix:system.field.edit",
						$arUserField["USER_TYPE"]["USER_TYPE_ID"],
						array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>					
			<?endforeach;?>
		<?endif;?>	
		
		<?if($arParams['SHOW_SUBSCRIBE']=="Y"):?>
			<div class="cileft">                                
				<label for="regrss">Подписка на рассылку новостей</label>
				<input id="regrss" class="customCheckbox" name="ADD_SUBSCRIPTION" value="Y" type="checkbox" />
			</div>    
		<?endif?>
		
		<input type="submit" name="register_submit_button" value="отправить" class="button_buy" />

	</form>

<?endif?>

<?if(is_ajax()&&$_REQUEST['TYPE']=='ORDER_REGISTRATION'):?>
	<?ajax_end()?>
<?endif?>