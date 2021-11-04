<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
	$(document).ready(function(){
		$('.log_btn').click();
	});
</script>
<p>Отсутсвуют права доступа для просмотра этого раздела.</p>
<?/*?><div class="order_summary reg-pages">				
					<div class='step_log logs'>
						<?$APPLICATION->IncludeComponent(
							"bitrix:system.auth.form",
							"form_auth_regs",
							Array(
								"REGISTER_URL" => "",
								"FORGOT_PASSWORD_URL" => "",
								"PROFILE_URL" => "",
								"SHOW_ERRORS" => "Y"
							),
						false
						);?>
					</div>
					<div class="clear"></div>
					<div class="step_log regs">
						<?$APPLICATION->IncludeComponent(
							"infodaymedia:main.register",
							".default",
							array("SHOW_FIELDS" => array(),
								"REQUIRED_FIELDS" => array(),
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => "36000000",
								"CACHE_GROUPS" => "Y",
								"AUTH" => "Y",
								"LOGIN_AS_EMAIL" => "Y",
								"SHOW_SUBSCRIBE" => "N",
								"SHOW_SOCSERV" => "N",
								"LIGHT_ERROR_FIELDS" => "Y",
								"RELOAD_PAGE" => "Y",
								"USE_BACKURL" => "Y",
								"SUCCESS_PAGE" => "",
								"SET_TITLE" => "N",
								"REG_DESCRIPTION" => "",
								"USER_PROPERTY" => array(0 => "",	)
							),
							false
						);?>
					</div>
					
</div>
<?*/?>
<?/*
<div class="profile">
            <div class="order_title active"><p>Войти<span></span></p><b>Для оформления заказа, пожалуйста, авторизуйтесь или зарегистрируйтесь</b></div>
            <div class="clearfix"></div>
            <div class="profile_item" style="display: block">
			<div class="authform">		
				<?$APPLICATION->IncludeComponent(
					"bitrix:system.auth.form",
					"order",
					Array(
						"REGISTER_URL" => "",
						"FORGOT_PASSWORD_URL" => "",
						"PROFILE_URL" => "",
						"SHOW_ERRORS" => "Y"
					),
				false
				);?>
			</div> 
			
			<div class="regform">
				<?$APPLICATION->IncludeComponent("infoday:main.register", "order", array(
					"SHOW_FIELDS" => array(
					),
					"REQUIRED_FIELDS" => array(
					),
					"AUTH" => "Y",
					"LOGIN_AS_EMAIL" => "Y",
					"SHOW_SUBSCRIBE" => "N",
					"SHOW_SOCSERV" => "N",
					"LIGHT_ERROR_FIELDS" => "Y",
					"RELOAD_PAGE" => "Y",
					"USE_BACKURL" => "Y",
					"SUCCESS_PAGE" => "",
					"SET_TITLE" => "Y",
					"REG_DESCRIPTION" => "",
					"USER_PROPERTY" => array(
					)
					),
					false
				);?>		
			</div>
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
		</div>
		<div class="clear"></div>
	</div>	
<script>
$(document).ready(function()
{
	if(!$('#leftmodule').length)
	{
		$('.content.inside').css('width','auto');
	}
	else
	{
		$('.socauthform').css('margin-left','70px');
	}
});
</script>
*/?>