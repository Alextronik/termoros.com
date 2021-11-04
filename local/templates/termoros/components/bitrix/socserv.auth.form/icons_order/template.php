<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?><?//print_r($arParams["~AUTH_SERVICES"])?><?//$arServ1 = changeAuthService($arParams["~AUTH_SERVICES"], false)?><?//$arServ2 = changeAuthService($arParams["~AUTH_SERVICES"], true)?><?//print_r($arParams["~AUTH_SERVICES"])?><div class="bw">
	<span>Войти через:</span>
	<div class="soclinks_order">
		<?foreach($arParams["~AUTH_SERVICES"] as $serv):?>
			<div class="soclink_order_item"><?=$serv['FORM_HTML']?></div>
		<?endforeach?>
	</div>
</div>