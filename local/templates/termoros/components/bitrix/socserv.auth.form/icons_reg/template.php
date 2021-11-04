<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?><?//print_r($arParams["~AUTH_SERVICES"])?><?$arServ = changeAuthService($arParams["~AUTH_SERVICES"], false)?><?$arServ2 = changeAuthService($arParams["~AUTH_SERVICES"],true)?><div class="socauthform">
	<p>Войти через социальные сервисы:</p>
	<div class="socauthwrap">
		<?foreach($arServ as $new_html):?>
			<div><?=$new_html?></div>		
		<?endforeach?>
	</div>
	<div class="clear"></div>
</div>
