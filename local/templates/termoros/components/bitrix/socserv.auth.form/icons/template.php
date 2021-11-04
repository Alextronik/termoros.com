<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?//print_r($arParams["~AUTH_SERVICES"])?>
<?//$arServ1 = changeAuthService($arParams["~AUTH_SERVICES"], false)?>
<?//$arServ2 = changeAuthService($arParams["~AUTH_SERVICES"], true)?>
<?//print_r($arParams["~AUTH_SERVICES"])?>			

<div class='pop_soc'>
		<p class='pop_ttl'>Войти через внешние сервисы666</p>
		<?foreach($arParams["~AUTH_SERVICES"] as $title => $serv):?>
				<?if($title == "GooglePlusOAuth"):?>
					<div class="enter_gl" ><?=$serv['FORM_HTML']?><span class="title-soc">google</span></div>
				<?elseif($title == "VKontakte"):?>
					<div class="enter_vk" ><?=$serv['FORM_HTML']?><span class="title-soc">Vkontakte</span></div>
				<?elseif($title == "Facebook"):?>
					<div class="enter_fb" ><?=$serv['FORM_HTML']?><span class="title-soc" >Facebook</span></div>
				<?elseif($title == "YandexOAuth"):?>
					<div class="enter_yn" ><?=$serv['FORM_HTML']?><span class="title-soc" >yandex</span></div>
				<?elseif($title == "MyMailRu"):?>
					<div class="enter_ml" ><?=$serv['FORM_HTML']?><span class="title-soc" >mail</span></div>
				<?endif;?>
		<?endforeach?>
	
</div>