<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;

isMob();// check for mobile

CJSCore::Init(array("jquery2","fx"));
\Bitrix\Main\Localization\Loc::loadMessages(SITE_TEMPLATE_PATH."/header.php");
SetGeoIp();
global $APPLICATION;
$curDir = trim($APPLICATION->GetCurDir(), '/');
$curDirArr = explode('/', $curDir);

$servicePage = FALSE;
if (in_array('services', $curDirArr)) $servicePage = TRUE;

// what the fuck?
$yandexDirect = FALSE;
/*
if ($_REQUEST['roistat'] && $_REQUEST['yclid']) 
{
	$_SESSION['yandexDirect'] = TRUE;
	$yandexDirect = TRUE;
}
if ($_SESSION['yandexDirect'])
{
	$yandexDirect = TRUE;
}*/
//v($_SESSION['GEOIP']['curr_phones']);
$roistatID = $storeId = $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'];
/*
if ($storeId == 214) $roistatID = $storeId;
if ($storeId == 210) $roistatID = $storeId;
if ($storeId == 212) $roistatID = $storeId;
if ($storeId == 209) $roistatID = $storeId;
if ($storeId == 215) $roistatID = $storeId;
if ($storeId == 211) $roistatID = $storeId;
*/
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<meta content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" name="SKYPE_TOOLBAR"/>
	<meta content="telephone=no" name="format-detection"/>
	<meta name="yandex-verification" content="ba243a37f5fe4d60" />
	<meta name="yandex-verification" content="69761c4fd8a7a581" />
	<meta name="yandex-verification" content="9d502ebdc89754b8" />
	<meta name="yandex-verification" content="fd5a630bf17b8a26" />
	<meta name="yandex-verification" content="7b68768e5f6494d0" />

	<!--<link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,500,700&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>-->
	<!--link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'-->
	<?
    //Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/reset.css");
    //Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/style.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/bootstrap.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/fancy/jquery.fancybox.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/fontawesome-5.13.all.min.css");//fontawesome-5.13.all.min.css


	//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.js");
    //Asset::getInstance()->addJs
    //Asset::getInstance()->addJs("/bitrix/js/ui/bootstrap4/js/bootstrap.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/lozad.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/slider.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/radio.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery-ui-1.10.4.custom.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/fancy/jquery.fancybox.pack.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/mousewheel.js");

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jScrollPane.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery.carouFredSel-6.2.1.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery.touchSwipe.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/ui_slider.js");

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/main.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/scriptjava.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/script.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/validate.form.js");

	?>
	<?$APPLICATION->ShowHead();?>
	<?/*<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">*/?>
	<? if ($_COOKIE['fullscreen']) { ?>
		<meta name="viewport" content="width=1280, initial-scale=0.25, minimum-scale=0.25, maximum-scale=1, user-scalable=yes" />
	<? } else { ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no" />
	<? } ?>
	<title><?$APPLICATION->ShowTitle()?></title>
    <!-- external scripts -->
    <?if(SITE_PROD){?>
        <!-- Yandex.Metrika counter -->
        <script async type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter26951046 = new Ya.Metrika({
                            id:26951046,
                            clickmap:true,
                            trackLinks:true,
                            accurateTrackBounce:true,
                            webvisor:true
                        });
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/26951046" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
        <!-- Google Anal -->
        <script async>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-6448986-1', 'auto');
            ga('send', 'pageview');
        </script>
        <!-- /Google Anal -->
        <!-- Facebook Pixel Code -->
        <script async>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1478791548990728');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1478791548990728&ev=PageView&noscript=1" /></noscript>
        <!-- End Facebook Pixel Code -->
        <!-- VK -->
        <!--script async type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?162",t.onload=function(){VK.Retargeting.Init("VK-RTRG-436427-aZKLv"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-436427-aZKLv" style="position:fixed; left:-999px;" alt=""/></noscript-->
        <!-- /VK -->
    <?}?>

</head>

<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<div id="top" class='global_overflow'></div>
<?
global $USER;
if (!$USER->IsAuthorized()){
?>
<!--LOGIN-->
<div class='loginform pop_up'>

	<a href='' class='popclose'></a>

	<div class='pop_inn'>
        <div class='pop_left'>

            <?$APPLICATION->IncludeComponent(
                "bitrix:system.auth.form",
                "auth",
                array(
                    "REGISTER_URL" => "",
                    "FORGOT_PASSWORD_URL" => "",
                    "PROFILE_URL" => "profile.php",
                    "SHOW_ERRORS" => "Y",
                    "COMPONENT_TEMPLATE" => "auth"
                ),
                false
            );?>

            <a class="text-center" style="display: block;padding: 1rem 0;border-radius: 3px;color: #ffffff;text-transform: uppercase;background: #b54526;margin: 1rem;" href="/partners/">Заявка на личный кабинет оптового партнера</a>
        </div>
	</div>
</div>
<?}?>
<!--LOGIN-->

<!--reg_ok-->
<div class='reg_ok pop_up'>

	<a href='' class='popclose'></a>

	<div class='pop_inn'>



		<p class='pop_ttl'>Регистрация</p>

		<p class='txt'>Вы успешно зарегистрированы на сайте.<br/>
			Чтобы воспользоваться всеми привилегиями компании Терморос, пожалуйста, укажите подробные данные в Личном кабинете</p>

		<a href='' class='pop_btn'>В личный кабинет</a>


	</div>

</div>

<!--reg_ok-->
<?//p($_SESSION['GEOIP']);?>
<div class='locationform pop_up'>
	<a href='' class='popclose'></a>
	<div class='pop_inn'>
		<div class='pop_left'>
			<p class='pop_ttl'>Выбрать город</p>
			<div class='current_loc'>
				<p>Ваш город<span>г. <?=$_SESSION['GEOIP']['curr_city_name'] ? $_SESSION['GEOIP']['curr_city_name'] : $_SESSION['GEOIP']['city']?></span></p>
				<?/*if(!$_SESSION['GEOIP']['curr_city_id']):?>
				<a href='' data-id="<?=$_SESSION['GEOIP']['city_list'][$_SESSION['GEOIP']['city']]?>" class='pop_btn accept_geo'>да</a>
				<?endif;*/?>
			</div>
			<p class='txt'>От Вашего выбора зависит ассортимент и стоимость товаров, условия оплаты и доставки заказа</p>
			<div class='inpt'>
				<p class='name'>Изменить город</p>
				<?$APPLICATION->IncludeComponent(
					"bitrix:sale.ajax.locations",
					"popuphead",
					array(
						"AJAX_CALL" => "N",
						"COUNTRY_INPUT_NAME" => "COUNTRY_tmp",
						"REGION_INPUT_NAME" => "REGION_tmp",
						"CITY_INPUT_NAME" => "tmp",
						"CITY_OUT_LOCATION" => "Y",
						"LOCATION_VALUE" => "",
						"ONCITYCHANGE" => "submitForm()",
					),
					null,
					array('HIDE_ICONS' => 'Y')
				);?>
				<input type='submit' value='Выбрать' class='btn set_geo'>
				<div class='clear'></div>
			</div>
		</div>

		<div class='pop_right'>
			<? if ($USER->IsAdmin()) { ?>
				<p class='pop_ttl'>Выбрать склад</p>
			<? } ?>
			<?if($_SESSION['STORES']):?>
			<ul class='loc_list'>
				<?foreach($_SESSION['STORES'] as $cname => $carr):?>
					<?if (!$carr['SKIP']) { ?>
						<li><input id="id_<?=$carr['ID'];?>" type='radio' name="city_ost" value="<?=$carr['CITY_ID'];?>" class='citystorechange customRadio'><label for="id_<?=$carr['ID'];?>"><?=$cname;?></label></li>
					<? } ?>
				<?endforeach;?>
			</ul>
			<?endif;?>

			<div class='clear'></div>
		</div>
		<div class='clear'></div>
	</div>
</div>

<!--TENDER-->
<?/*
<div class='tenderform pop_up'>
<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?>
<?else:?>
	<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"lovemetender",
	array(
		"COMPONENT_TEMPLATE" => "lovemetender",
		"WEB_FORM_ID" => "1",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "N",
		"SEF_MODE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"LIST_URL" => "result_list.php",
		"EDIT_URL" => "result_edit.php",
		"SUCCESS_URL" => "",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>
<?endif;?>
</div>
*/?>
<div class='vacancy pop_up'>
<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?>
<?else:?>
	<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"lovemetender",
	array(
		"COMPONENT_TEMPLATE" => "lovemetender",
		"WEB_FORM_ID" => "7",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "N",
		"SEF_MODE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"LIST_URL" => "result_list.php",
		"EDIT_URL" => "result_edit.php",
		"SUCCESS_URL" => "",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>
<?endif;?>
</div>

<div class='callback pop_up'>
<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?>
<?else:?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:form.result.new",
		"lovemetender",
		array(
			"COMPONENT_TEMPLATE" => "lovemetender",
			"WEB_FORM_ID" => "2",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"USE_EXTENDED_ERRORS" => "N",
			"SEF_MODE" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"LIST_URL" => "result_list.php",
			"EDIT_URL" => "result_edit.php",
			"SUCCESS_URL" => "",
			"CHAIN_ITEM_TEXT" => "",
			"CHAIN_ITEM_LINK" => "",
			"VARIABLE_ALIASES" => array(
				"WEB_FORM_ID" => "WEB_FORM_ID",
				"RESULT_ID" => "RESULT_ID",
			)
		),
		false
	);?>
<?endif;?>
</div>

<div class='feedback pop_up'>
<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?>
<?else:?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:form.result.new",
		"lovemetender",
		array(
			"COMPONENT_TEMPLATE" => "lovemetender",
			"WEB_FORM_ID" => "3",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"USE_EXTENDED_ERRORS" => "N",
			"SEF_MODE" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"LIST_URL" => "result_list.php",
			"EDIT_URL" => "result_edit.php",
			"SUCCESS_URL" => "",
			"CHAIN_ITEM_TEXT" => "",
			"CHAIN_ITEM_LINK" => "",
			"VARIABLE_ALIASES" => array(
				"WEB_FORM_ID" => "WEB_FORM_ID",
				"RESULT_ID" => "RESULT_ID",
			)
		),
		false
	);?>
<?endif;?>
</div>

<div class='site_error pop_up'>
<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?>
<?else:?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:form.result.new",
		"lovemetender",
		array(
			"COMPONENT_TEMPLATE" => "lovemetender",
			"WEB_FORM_ID" => "28",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"USE_EXTENDED_ERRORS" => "N",
			"SEF_MODE" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"LIST_URL" => "",
			"EDIT_URL" => "",
			"SUCCESS_URL" => "",
			"CHAIN_ITEM_TEXT" => "",
			"CHAIN_ITEM_LINK" => "",
			"VARIABLE_ALIASES" => array(
				"WEB_FORM_ID" => "WEB_FORM_ID",
				"RESULT_ID" => "RESULT_ID",
			)
		),
		false
	);?>
<?endif;?>
</div>

<div class='seminar pop_up'>
<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?>
<?else:?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:form.result.new",
		"lovemetender",
		array(
			"COMPONENT_TEMPLATE" => "lovemetender",
			"WEB_FORM_ID" => "4",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"USE_EXTENDED_ERRORS" => "N",
			"SEF_MODE" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"LIST_URL" => "result_list.php",
			"EDIT_URL" => "result_edit.php",
			"SUCCESS_URL" => "",
			"CHAIN_ITEM_TEXT" => "",
			"CHAIN_ITEM_LINK" => "",
			"VARIABLE_ALIASES" => array(
				"WEB_FORM_ID" => "WEB_FORM_ID",
				"RESULT_ID" => "RESULT_ID",
			)
		),
		false
	);?>
<?endif;?>
</div>

<div class='seminar_region pop_up'>
<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?>
<?else:?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:form.result.new",
		"lovemetender",
		array(
			"COMPONENT_TEMPLATE" => "lovemetender",
			"WEB_FORM_ID" => "31",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"USE_EXTENDED_ERRORS" => "N",
			"SEF_MODE" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"LIST_URL" => "result_list.php",
			"EDIT_URL" => "result_edit.php",
			"SUCCESS_URL" => "",
			"CHAIN_ITEM_TEXT" => "",
			"CHAIN_ITEM_LINK" => "",
			"VARIABLE_ALIASES" => array(
				"WEB_FORM_ID" => "WEB_FORM_ID",
				"RESULT_ID" => "RESULT_ID",
			)
		),
		false
	);?>
<?endif;?>
</div>

<!--TENDER-->
	<?
	$compare = count($_SESSION['CATALOG_COMPARE_LIST'][4]['ITEMS']);
	$fav = count(getFav());
	//p($fav);
	?>

	<div class='slide_panel <?if(!$compare&&!$fav):?>hide<?endif;?>'>
	<div class='container'>
		<a href='/personal/fav' class='fav_link'>Избранное<span class='val'><?=$fav?></span></a>
		<a href='/personal/compare' class='comp_link'>Сравнение товаров<span class='val'><?=$compare?></span></a>
	</div>
	</div>



<header class="header <?if(\Redreams\Partners\partner::isPartner()):?>partner<?endif?>">

    <div class='head_top'>
        <div class='container'>
            <div class="row toprow">
                <div class="col-2 col-md-2 pl-0">
                    <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "top_menu",
                    array(
                        "ROOT_MENU_TYPE" => "about",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "top",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                        "COMPONENT_TEMPLATE" => "top_menu"
                    ),
                    false
                );?>
                </div>

                <div class='location col-4 col-md-2 mx-auto text-center'>
                    <a href='' class='location_lnk'><span class="">г. <?=$_SESSION['GEOIP']['curr_city_name'] ? $_SESSION['GEOIP']['curr_city_name'] : $_SESSION['GEOIP']['city']?></span></a>
                </div>

                <div id="top_phone_block" class='top_phone col-2 order-4 col-md-3 order-md-3 px-0'>
                    <div id="top_phone_block_wrap">

                        <?if($_SESSION['GEOIP']['curr_phones'][0]) {?>
                            <p class="roi_phone<?if ($roistatID) { ?>_<?=$roistatID?><? } ?>"><a href="tel:<?=$_SESSION['GEOIP']['curr_phones'][0];?>"><?=$_SESSION['GEOIP']['curr_phones'][0];?></a></p>
                        <?}else{?>
                            <p class="roi_phone<?if ($roistatID) { ?>_<?=$roistatID?><? } ?>"><a href="tel:+7 (499) 500 00 01">+7 (499) 500 00 01</a></p>
                        <?}?>
                        <p class="roi_phone_2"><span class="px-2 hm">|</span><a href="tel:8 800 550 33 45">8 800 550 33 45</a></p>
                        <? if($_SESSION['GEOIP']["curr_city_name"] == "Москва" || $_SESSION['GEOIP']["region"] == "Московская область"){?>
                            <p><span class="px-2 hm">|</span><a class="gss" title="Сервисная служба" href="tel:+7 (499) 128 92 40"><i class="fas fa-tools"></i> +7 (499) 128 92 40</a></p>
                        <?}?>

                    </div>
                </div>

                <div class='tc_wp col-2 col-md-2 py-3 hm order-4'><a href='' class='top_clbk'>Обратная связь</a>
                    <ul class='submenu_list'>
                        <li><a href='' onclick="yaCounter26951046.reachGoal('SIMPLE_FORM_3_CLICK'); yaCounter26951046.reachGoal('zakazat_zvonok'); ga('send', 'pageview','/virtual/zakazat_zvonok'); return true;" class='call'>Обратный звонок</a></li>
                        <li><a href='' onclick="yaCounter26951046.reachGoal('SIMPLE_FORM_2_CLICK'); yaCounter26951046.reachGoal('zadal_vopros'); ga('send', 'pageview','/virtual/zadal_vopros'); return true;" class='ask'>Задать вопрос</a></li>
                        <!--<li><a href=''>Позвонить с сайта <img class='skype_ico'  alt='' src='<?=SITE_TEMPLATE_PATH?>/img/skype.png'></a></li>-->
                        <?/*<li><a href='' onclick="yaCounter26951046.reachGoal('SIMPLE_FORM_1_CLICK'); yaCounter26951046.reachGoal('zakaz_tender'); ga('send', 'pageview','/virtual/zakaz_tender'); return true;" class='tend'>Заказать тендерную информацию </a></li>*/?>
                    </ul>
                </div>

                <div class="col-2 col-md-2 order-3 order-md-5 px-0">
                    <?if ($USER->IsAuthorized()){?>
                    <?$url = $APPLICATION->GetCurDir();?>

                    <?if(\Redreams\Partners\partner::isPartner()) {?>
                            <div class="lk_wp logged">
                                <a href='/personal/' class='lk_wrap'>
                                    <span class='lk_link'>Кабинет партнера</span>
                                </a>
                            </div>
                    <?}else{?>
                        <div class='lk_wp logged'>
                            <a href='/personal/profile' class='lk_wrap <?if($url == '/personal/profile/'):?>active<?endif;?>'>
                                <span class='lk_link'>Личный кабинет</span>
                            </a>
                            <ul class='submenu_list'>
                                <li><a href='/personal/profile' class="<?if($url == '/personal/profile/'):?>active<?endif;?>" >Настройки пользователя</a></li>
                                <li><a href='/personal/profs' class="<?if($url == '/personal/profs/'):?>active<?endif;?>" ><?if(\Redreams\Partners\partner::isPartner()):?>Контрагенты<?else:?>Профили пользователя<?endif?></a></li>
                                <li><a href='/personal/order' class="<?if($url == '/personal/order/'):?>active<?endif;?>" >История заказов</a></li>
                                <li><a href='/personal/delayorder' class="<?if($url == '/personal/delayorder/'):?>active<?endif;?>" >Отложенные заказы</a></li>
                                <?/*
                                <li><a href='/personal/subscribe/' class="<?if($url == '/personal/subscribe/'):?>active<?endif;?>" >Подписка</a></li>
                                <!--<li><a href='/personal/fav/'  class="<?if($url == '/personal/fav/'):?>active<?endif;?>" >Отложенные товары</a></li>
                        <li><a href='/personal/sale/' class="<?if($url == '/personal/sale/'):?>active<?endif;?>" >Бонусная система </a></li>
                        <li><a href='/technical_support/?support=y' class="<?if($url == '/technical_support/'):?>active<?endif;?>" >Техническая поддержка</a></li>-->*/?>
                                <li><a href='?logout=yes'><b>Выход</b></a></li>
                            </ul>

                        </div>
                    <?}?>

                    <?}else{?>
                    <div class='lk_wp'>
                        <a href='' onclick="yaCounter26951046.reachGoal('register_site'); ga('send', 'pageview','/virtual/register_site'); return true;" class='lk_wrap'>
                            <span class='lk_link'>Личный кабинет</span>
                        </a>
                    </div>
                    <?}?>
                </div>

                <div class='lang_block col-2 col-md-1 px-0 hm order-6'>
                    <a target="_blank" href='/eng'>Eng</a>
                    <a class='active'>Рус</a>
                </div>
            </div>
        </div>
    </div>
    <? include_once $_SERVER['DOCUMENT_ROOT'] . '/include/head_partner.php' ?>

</header>

<div id="stickyHeader" class="header sticky-top">
    <div class='head_mid container'>
        <div class='row py-1 align-items-center'>

            <!--a class='col-3' href='/'><img src='<?=SITE_TEMPLATE_PATH?>/img/logo.png' class='logo img-fluid' width="200" height="56" alt='logo'></a-->
            <a class='col-3' href='/'><img src='<?=SITE_TEMPLATE_PATH?>/img/logo_ng.png' class='logo img-fluid' width="200" height="56" alt='logo'></a>

            <div class="col-6">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:search.title",
                    "search",
                    array(
                        "NUM_CATEGORIES" => "7",
                        "TOP_COUNT" => "7",
                        "CHECK_DATES" => "N",
                        "SHOW_OTHERS" => "N",
                        "PAGE" => "/catalog/",
                        "CATEGORY_1_TITLE" => "Каталог продукции",
                        "CATEGORY_1" => array(
                            0 => "iblock_1c_catalog",
                        ),
                        "CATEGORY_1_iblock_catalog" => array(
                            0 => "all",
                        ),
                        "CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
                        "SHOW_INPUT" => "Y",
                        "INPUT_ID" => "title-search-input",
                        "CONTAINER_ID" => "search",
                        "PRICE_CODE" => array(
                            0 => "BASE",
                        ),
                        "SHOW_PREVIEW" => "Y",
                        "PREVIEW_WIDTH" => "75",
                        "PREVIEW_HEIGHT" => "75",
                        "CONVERT_CURRENCY" => "Y",
                        "COMPONENT_TEMPLATE" => "search",
                        "ORDER" => "rank",
                        "USE_LANGUAGE_GUESS" => "N",
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "CURRENCY_ID" => "RUB",
                        "CATEGORY_0_TITLE" => "Бренды",
                        "CATEGORY_0" => array(
                            0 => "iblock_references",
                        ),
                        "CATEGORY_0_iblock_references" => array(
                            0 => "17",
                        ),
                        "CATEGORY_1_iblock_1c_catalog" => array(
                            0 => "all",
                        ),
                        /*
                        "CATEGORY_2_TITLE" => "Магазины",
                        "CATEGORY_2" => array(
                            0 => "iblock_services",
                        ),
                        "CATEGORY_2_iblock_services" => array(
                            0 => "18",
                        ),
                        */
                        "CATEGORY_3_TITLE" => "Портфолио",
                        "CATEGORY_3" => array(
                            0 => "iblock_services",
                        ),
                        "CATEGORY_3_iblock_services" => array(
                            0 => "14",
                        ),
                        "CATEGORY_4_TITLE" => "Видео",
                        "CATEGORY_4" => array(
                            0 => "iblock_services",
                        ),
                        "CATEGORY_4_iblock_services" => array(
                            0 => "24",
                        ),
                        /*
                        "CATEGORY_5_TITLE" => "Контакты",
                        "CATEGORY_5" => array(
                            0 => "iblock_services",
                        ),
                        "CATEGORY_5_iblock_services" => array(
                            0 => "22",
                        ),
                        */
                        "CATEGORY_6_TITLE" => "События",
                        "CATEGORY_6" => array(
                            0 => "iblock_news",
                        ),
                        "CATEGORY_6_iblock_news" => array(
                            0 => "12",
                            1 => "16",
                            2 => "21",
                        ),
                    ),
                    false
                );?>
            </div>

            <div class='col-3 text-right basket-line'>
                <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line","main",Array(
                        "HIDE_ON_BASKET_PAGES" => "Y",
                        "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                        "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                        "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                        "PATH_TO_PROFILE" => SITE_DIR."personal/",
                        "PATH_TO_REGISTER" => SITE_DIR."login/",
                        "POSITION_FIXED" => "N",
                        "POSITION_HORIZONTAL" => "right",
                        "POSITION_VERTICAL" => "top",
                        "SHOW_AUTHOR" => "N",
                        "SHOW_DELAY" => "N",
                        "SHOW_EMPTY_VALUES" => "Y",
                        "SHOW_IMAGE" => "Y",
                        "SHOW_NOTAVAIL" => "N",
                        "SHOW_NUM_PRODUCTS" => "Y",
                        "SHOW_PERSONAL_LINK" => "N",
                        "SHOW_PRICE" => "Y",
                        "SHOW_PRODUCTS" => "Y",
                        "SHOW_SUMMARY" => "Y",
                        "SHOW_TOTAL_PRICE" => "Y"
                    )
                );?>
            </div>
        </div>
    </div>
</div>

<header class="header <?if(\Redreams\Partners\partner::isPartner()):?>partner<?endif?>">

    <div class='head_bott'>
        <div class='container'>
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "catalog_menu",
                array(
                    "ROOT_MENU_TYPE" => "catalog",
                    "MAX_LEVEL" => "3",
                    "CHILD_MENU_TYPE" => "top",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "COMPONENT_TEMPLATE" => "catalog_menu"
                ),
                false
            );?>

            <?$APPLICATION->IncludeComponent("bitrix:menu", "main_menu", Array(
                "ROOT_MENU_TYPE" => "main",	// Тип меню для первого уровня
                "MAX_LEVEL" => "2",	// Уровень вложенности меню
                "CHILD_MENU_TYPE" => "child",	// Тип меню для остальных уровней
                "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                "MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
            ),
                false
            );?>

        </div><!-- .container-->
    </div>

</header>


<?$page = $APPLICATION->GetCurPage();?>
<div class="content">
    <?if($page!="/"){?>

    <?if(strripos($page,"/catalog/")===false && strripos($page,"/brands/")===false){?>
    <div class="container">
        <div class="row">

            <?if(defined('LEFTBAR')):?>
            <div class='left_sidebar col-12 col-md-3'>
                <?if(!defined('NOMENU')):?>
                <div class='leftside_menu'>
                    <div class='lm_section <?if($APPLICATION->GetCurDir() == '/about_company/'):?>opened<?endif;?>'>
                        <a href='' class='section_btn'>О компании</a>
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
                            "ROOT_MENU_TYPE" => "about",	// Тип меню для первого уровня
                            "MAX_LEVEL" => "1",	// Уровень вложенности меню
                            "CHILD_MENU_TYPE" => "about",	// Тип меню для остальных уровней
                            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                            "DELAY" => "N",	// Откладывать выполнение шаблона меню
                            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                            "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                            "MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                            "COMPONENT_TEMPLATE" => ".default"
                            ),
                            false
                        );?>
                    </div>
                    <div class='lm_section <?if($APPLICATION->GetCurDir() == '/cooperation/'):?>opened<?endif;?>'>
                        <a href='' class='section_btn '>Сотрудничество</a>
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
                            "ROOT_MENU_TYPE" => "cooperation",	// Тип меню для первого уровня
                            "MAX_LEVEL" => "1",	// Уровень вложенности меню
                            "CHILD_MENU_TYPE" => "cooperation",	// Тип меню для остальных уровней
                            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                            "DELAY" => "N",	// Откладывать выполнение шаблона меню
                            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                            "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                            "MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                            "COMPONENT_TEMPLATE" => ".default"
                            ),
                            false
                        );?>
                    </div>
                    <div class='lm_section <?if($APPLICATION->GetCurDir() == '/buyers/'):?>opened<?endif;?>'>
                        <a href='' class='section_btn '>Покупателям</a>
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
                            "ROOT_MENU_TYPE" => "buyers",	// Тип меню для первого уровня
                            "MAX_LEVEL" => "1",	// Уровень вложенности меню
                            "CHILD_MENU_TYPE" => "buyers",	// Тип меню для остальных уровней
                            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                            "DELAY" => "N",	// Откладывать выполнение шаблона меню
                            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                            "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                            "MENU_CACHE_TIME" => "36000000000",	// Время кеширования (сек.)
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                            "COMPONENT_TEMPLATE" => ".default"
                            ),
                            false
                        );?>
                    </div>
                    <div class='lm_section <?if($APPLICATION->GetCurDir() == '/about_company/'):?>opened<?endif;?>'>
                        <a href='' class='section_btn '>Услуги</a>
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
                            "ROOT_MENU_TYPE" => "services",	// Тип меню для первого уровня
                            "MAX_LEVEL" => "1",	// Уровень вложенности меню
                            "CHILD_MENU_TYPE" => "services",	// Тип меню для остальных уровней
                            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                            "DELAY" => "N",	// Откладывать выполнение шаблона меню
                            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                            "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                            "MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                            "COMPONENT_TEMPLATE" => ".default"
                            ),
                            false
                        );?>
                    </div>
                    <div class='lm_section <?if($APPLICATION->GetCurDir() == '/technical_support/'):?>opened<?endif;?>'>
                        <a href='' class='section_btn '>Техническая поддержка</a>
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
                            "ROOT_MENU_TYPE" => "support",	// Тип меню для первого уровня
                            "MAX_LEVEL" => "1",	// Уровень вложенности меню
                            "CHILD_MENU_TYPE" => "support",	// Тип меню для остальных уровней
                            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                            "DELAY" => "N",	// Откладывать выполнение шаблона меню
                            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                            "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                            "MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                            "COMPONENT_TEMPLATE" => ".default"
                            ),
                            false
                        );?>
                    </div>
                </div>
                <?endif;?>
                <?if(defined('FILTER')):?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.filter",
                    "fltr-tpl",
                    array(
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "N",
                        "COMPONENT_TEMPLATE" => "fltr-tpl",
                        "FIELD_CODE" => array(
                            0 => "NAME",
                        ),
                        "FILTER_NAME" => "arrFilter",
                        "IBLOCK_ID" => "19",
                        "IBLOCK_TYPE" => "references",
                        "LIST_HEIGHT" => "5",
                        "NUMBER_WIDTH" => "5",
                        "PAGER_PARAMS_NAME" => "arrPager",
                        "PRICE_CODE" => array(),
                        "PROPERTY_CODE" => array(
                            0 => "PRODUCTER",
                            1 => "DOC_TYPE",
                            2 => "PROD_TYPE",
                            //3 => "NAME",
                        ),
                        "SAVE_IN_SESSION" => "N",
                        "TEXT_WIDTH" => "20"
                    ),
                    false
                );?>
                <?endif;?>
                <?if(defined('FILTER_MATERIAL')):?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.filter",
                    "fltr-tpl",
                    array(
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "N",
                        "COMPONENT_TEMPLATE" => "fltr-tpl",
                        "FIELD_CODE" => array(
                            0 => "NAME",
                        ),
                        "FILTER_NAME" => "arrFilter",
                        "IBLOCK_ID" => "31",
                        "IBLOCK_TYPE" => "references",
                        "LIST_HEIGHT" => "5",
                        "NUMBER_WIDTH" => "5",
                        "PAGER_PARAMS_NAME" => "arrPager",
                        "PRICE_CODE" => array(),
                        "PROPERTY_CODE" => array(
                            0 => "PRODUCTER",
                            1 => "DOC_TYPE",
                            2 => "PROD_TYPE",
                        ),
                        "SAVE_IN_SESSION" => "N",
                        "TEXT_WIDTH" => "20"
                    ),
                    false
                );?>
                <?endif;?>
                <?if(defined('FILTER_VIDEO')):?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.filter",
                    "fltr-tpl",
                    array(
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COMPONENT_TEMPLATE" => "fltr-tpl",
                        "FIELD_CODE" => array(
                            0 => "NAME",
                        ),
                        "FILTER_NAME" => "arrFilter",
                        "IBLOCK_ID" => "32",
                        "IBLOCK_TYPE" => "references",
                        "LIST_HEIGHT" => "5",
                        "NUMBER_WIDTH" => "5",
                        "PAGER_PARAMS_NAME" => "arrPager",
                        "PRICE_CODE" => array(),
                        "PROPERTY_CODE" => array(
                            0 => "PRODUCTER",
                        ),
                        "SAVE_IN_SESSION" => "N",
                        "TEXT_WIDTH" => "20"
                    ),
                    false
                );?>
                <?endif;?>
                <?if(defined('FILTER_PHOTO')):?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.filter",
                    "fltr-tpl",
                    array(
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COMPONENT_TEMPLATE" => "fltr-tpl",
                        "FIELD_CODE" => array(
                            0 => "NAME",
                        ),
                        "FILTER_NAME" => "arrFilter",
                        "IBLOCK_ID" => "33",
                        "IBLOCK_TYPE" => "references",
                        "LIST_HEIGHT" => "5",
                        "NUMBER_WIDTH" => "5",
                        "PAGER_PARAMS_NAME" => "arrPager",
                        "PRICE_CODE" => array(),
                        "PROPERTY_CODE" => array(
                            0 => "BRAND",
                            1 => "TYPE",
                        ),
                        "SAVE_IN_SESSION" => "N",
                        "TEXT_WIDTH" => "20"
                    ),
                    false
                );?>
                <?endif;?>
                <?if(defined('FILTERPRICE')):?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.filter",
                    "fltr-tpl",
                    array(
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "N",
                        "COMPONENT_TEMPLATE" => "fltr-tpl",
                        "FIELD_CODE" => array(
                            0 => "NAME",
                        ),
                        "FILTER_NAME" => "arrFilter",
                        "IBLOCK_ID" => "15",
                        "IBLOCK_TYPE" => "services",
                        "LIST_HEIGHT" => "5",
                        "NUMBER_WIDTH" => "5",
                        "PAGER_PARAMS_NAME" => "arrPager",
                        "PRICE_CODE" => array(),
                        "PROPERTY_CODE" => array(
                            0 => "PRODUCTER",
                            1 => "PROD_TYPE",
                        ),
                        "SAVE_IN_SESSION" => "N",
                        "TEXT_WIDTH" => "20"
                    ),
                    false
                );?>
                <?endif;?>
            </div>
            <div class='right_sidebar tech_page  col-12 col-md-9 <?if(defined('FILTER')||defined('FILTERPRICE')||defined('FILTER_MATERIAL')||defined('FILTER_VIDEO')||defined('FILTER_PHOTO')):?>margin<?endif;?>'>
            <?elseif(defined('LEFTBAR2')):?>
            <div class='left_sidebar col-12 col-md-3'>
                <div class='leftside_menu'>
                    <div class='lm_section <?if($APPLICATION->GetCurDir() == '/engineering_systems/'):?>opened<?endif;?>'>
                        <a href='' class='section_btn'>Инженерные системы</a>
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
                            "ROOT_MENU_TYPE" => "engeen",	// Тип меню для первого уровня
                            "MAX_LEVEL" => "1",	// Уровень вложенности меню
                            "CHILD_MENU_TYPE" => "about",	// Тип меню для остальных уровней
                            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                            "DELAY" => "N",	// Откладывать выполнение шаблона меню
                            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                            "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                            "MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                            "COMPONENT_TEMPLATE" => ".default"
                            ),
                            false
                        );?>
                    </div>
                </div>
            </div>
            <div class='right_sidebar tech_page col-12 col-md-9 <?if(defined('FILTER')||defined('FILTERPRICE')):?>margin<?endif;?>'>
            <?elseif(defined('LEFTBAR3')):?>
                <?if($USER->isAuthorized() && !Redreams\Partners\partner::isPartner()):?>
            <div class='left_sidebar col-12 col-md-3'>
                <div class='leftside_menu'>
                    <div class='lm_section <?if($APPLICATION->GetCurDir() == '/personal/'):?>opened<?endif;?>'>
                        <a href='' class='section_btn'>Личный кабинет</a>
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
                            "ROOT_MENU_TYPE" => "personal",	// Тип меню для первого уровня
                            "MAX_LEVEL" => "1",	// Уровень вложенности меню
                            "CHILD_MENU_TYPE" => "personal",	// Тип меню для остальных уровней
                            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                            "DELAY" => "N",	// Откладывать выполнение шаблона меню
                            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                            "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                            "MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                            "COMPONENT_TEMPLATE" => ".default"
                            ),
                            false
                        );?>
                    </div>
                </div>
                <div class="clear"></div>
                <a class="btn techs" href="/personal/techsupport" >Техническая поддержка</a>
                <div class="clear mrg"></div>
            </div>
            <div class='right_sidebar tech_page col-12 col-md-9 <?if(defined('FILTER')||defined('FILTERPRICE')):?>margin<?endif;?>'>
                <?endif;?>
            <?endif;?>

                <div class="nav_block col-12">
                    <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "nav", Array(
                        "COMPONENT_TEMPLATE" => ".default",
                        "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                        "SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                        "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
                    ),
                        false
                    );?>

                    <h1><?$APPLICATION->ShowTitle(false)?></h1>
                </div>
                <?if(!defined('NOINNER')):?>
                <div class="inner_contentblock col-12">
                <?endif;?>
            <?}
        }?>