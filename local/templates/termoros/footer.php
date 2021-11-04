<? /** @var TYPE_NAME $APPLICATION */
$page = $APPLICATION->GetCurPage();
if($page!="/"){?>
	<?if(strripos($page,"/catalog/")===false&&strripos($page,"/brands/")===false){?>
			
			<?if(!defined('NOINNER')):?>
			</div>
			<?endif;?>
			
			
			<?if(defined('LEFTBAR')||defined('LEFTBAR2')||defined('LEFTBAR3')):?>
			</div> <!-- right blk --> 
			<div class='clear'></div>
			
			<?endif;?>
			
		</div>
	<?}?>
<?}?>

    </div><!-- row -->
</div><!-- .content -->

<!--/div--><!-- .wrapper -->


<footer class="footer">
    <div class="border"></div>
	<div class='foot_subscribe container'>
        <div class="row">
            <p class='name col-12 col-md-6'>Узнавайте первым о новостях, акциях и семинарах</p>
            <div class="col-12 col-md-6">
                <form method="POST" action="https://cp.unisender.com/ru/subscribe?hash=65kde463odmt7htwiys9km8naywc1pcmey7u61yhfwwy7wbuz941y" name="subscribtion_form" target="_blank">
                    <div class="subs_wp">
                        <input class="required email inp_self" type="text" name="email" value="" placeholder="ВАШ E-MAIL">
                        <input class="btn" type="submit" value="ПОДПИСАТЬСЯ" onclick="yaCounter26951046.reachGoal('podpiska_success'); ga('send', 'pageview','/virtual/podpiska_success'); return true;">

                        <input type="hidden" name="charset" value="UTF-8">
                        <input type="hidden" name="default_list_id" value="20386147">
                        <input type="hidden" name="overwrite" value="2">
                        <input type="hidden" name="is_v5" value="1">
                        <a style="margin: 5px;color: red; display:  block;" target="_blank" href="/copy.php">Нажимая на кнопку «Подписаться», вы соглашаетесь <br>с условиями обработки персональных данных </a>
                    </div>
                </form>
            </div>
        </div>
	</div>

	<div class='foot_mid container'>
		<div class='row'>
			<div class='side col-12 col-md-3'>

				<a class='ttl' href="/about_company" >О компании</a>
				<?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
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

            <div class='side col-12 col-md-3'>
                <a class='ttl' href="/catalog" >Каталог продукции</a>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "footer_menu_catalog",
                    array(
                        "ROOT_MENU_TYPE" => "catalog",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "top",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "360000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                        "COMPONENT_TEMPLATE" => "footer_menu_catalog"
                    ),
                    false
                );?>
            </div>

            <div class='side col-12 col-md-3'>
                <a class='ttl' href="/technical_support/tech_documentation">Поддержка</a>
                <?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
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

            <div class='side col-12 col-md-3'>
                <a class='ttl' href="/buyers/prices">Покупателям</a>
                <?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
                    "ROOT_MENU_TYPE" => "buyers",	// Тип меню для первого уровня
                    "MAX_LEVEL" => "1",	// Уровень вложенности меню
                    "CHILD_MENU_TYPE" => "buyers",	// Тип меню для остальных уровней
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

            <div class='side col-12 col-md-3'>
				<a class='ttl' href="/cooperation" >Сотрудничество</a>
				<?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
					"ROOT_MENU_TYPE" => "cooperation",	// Тип меню для первого уровня
					"MAX_LEVEL" => "1",	// Уровень вложенности меню
					"CHILD_MENU_TYPE" => "cooperation",	// Тип меню для остальных уровней
					"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
					"DELAY" => "N",	// Откладывать выполнение шаблона меню
					"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
					"MENU_CACHE_TYPE" => "A",	// Тип кеширования
					"MENU_CACHE_TIME" => "360000000",	// Время кеширования (сек.)
					"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
					"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
					"COMPONENT_TEMPLATE" => ".default"
				),
					false
				);?>
			</div>

            <div class='side col-12 col-md-3'>
				<a class='ttl' href="/brands" >Бренды</a>
				<ul class="foot_menu">
					<li><a href="/brands/gekon/">Gekon</a></li>
					<li><a href="/brands/euros/">Euros</a></li>
					<li><a href="/brands/germanium/">Germanium</a></li>
					<li><a href="/brands/atlant/">Atlant</a></li>
					<li><a href="/brands/jagarus/">JagaRus</a></li>
					<li><a href="/brands/jaga/">Jaga</a></li>
					<li><a href="/brands/far/">FAR</a></li>
					<li><a href="/brands">Все бренды</a></li>
				</ul>
			</div>

            <div class='side col-12 col-md-3'>
				<a class='ttl' href="/services" >Услуги</a>
				<?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
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
                <div class='foot_soc lozad'>
                    <p class='ttl'>Присоединяйтесь к нам</p>
                    <a href='https://vk.com/termoros' target="_blank" ><img alt='' style="margin-left: 0px;" class='lozad' data-src='<?=SITE_TEMPLATE_PATH?>/img/vk.png'></a>
                    <a href='https://www.facebook.com/Termoros/' target="_blank" ><img alt='' class='lozad' data-src='<?=SITE_TEMPLATE_PATH?>/img/fb.png'></a>
                    <a href='https://www.youtube.com/user/termorosmsk' target="_blank" ><img alt='' class='lozad' data-src='<?=SITE_TEMPLATE_PATH?>/img/utube.png'></a>
                    <a href='https://www.instagram.com/termoros_official/ ' target="_blank" ><img alt='' class='lozad' data-src='<?=SITE_TEMPLATE_PATH?>/img/insta.png'></a>
                </div>
            </div>

            <div class='side col-12 col-md-3'>
				<a class='ttl' href="/search/map">Карта сайта</a>

				<div class='ph_wrap'>
					<?if($_SESSION['GEOIP']['curr_phones']):?>					
					<p class='ttl <?if ($_SESSION['GEOIP']['curr_city_name'] == 'Москва') { ?>roi_phone<? } ?>'><a style="font-weight:bold; color: black;" href="tel:<?=$_SESSION['GEOIP']['curr_phones'][0];?>"><?=$_SESSION['GEOIP']['curr_phones'][0];?></a></p>
					<p class='ttl <?if ($_SESSION['GEOIP']['curr_city_name'] == 'Москва') { ?>roi_phone_2<? } ?>'><a style="font-weight:bold; color: black;" href="tel:<?=$_SESSION['GEOIP']['curr_phones'][1];?>"><?=$_SESSION['GEOIP']['curr_phones'][1];?></a></p>
					<?else:?>
					<p class='ttl <?if ($_SESSION['GEOIP']['curr_city_name'] == 'Москва') { ?>roi_phone<? } ?>'><a style="font-weight:bold; color: black;" href="tel:+7 (499) 500 00 01">+7 (499) 500 00 01</a></p>
					<p class='ttl <?if ($_SESSION['GEOIP']['curr_city_name'] == 'Москва') { ?>roi_phone_2<? } ?>'><a style="font-weight:bold; color: black;" href="tel:8 (800) 550 33 45">8 (800) 550 33 45</a></p>
					<?endif;?>
					<!--<a href='' class='call_from_site'><span class='it_ttl'>позвонить с сайта</span></a>-->
				</div>
				<!--div class="ph_wrap_mobile" >
					<?if($_SESSION['GEOIP']['curr_phones']):?>					
					<p style="margin: 10px 0 0 10px; text-align:center;"><span class="b"><span <?if ($_SESSION['GEOIP']['curr_city_name'] == 'Москва') { ?>class="roi_phone"<? } ?>><a target="_blank" data-rel="external" style="font-weight:bold; color: black;" href="tel:<?=$_SESSION['GEOIP']['curr_phones'][0];?>"><?=$_SESSION['GEOIP']['curr_phones'][0];?></a></span>&nbsp;&nbsp;<span <?if ($_SESSION['GEOIP']['curr_city_name'] == 'Москва') { ?>class="roi_phone_2"<? } ?>><a target="_blank" data-rel="external" style="font-weight:bold; color: black;" href="tel:<?=$_SESSION['GEOIP']['curr_phones'][1];?>"><?=$_SESSION['GEOIP']['curr_phones'][1];?></a></span></span></p>
					<?else:?>
					<p style="margin: 10px 0 0 10px; text-align:center;"><b><span <?if ($_SESSION['GEOIP']['curr_city_name'] == 'Москва') { ?>class="roi_phone"<? } ?>><a data-rel="external" target="_blank" style="font-weight:bold; color: black;" href="tel:+7 (499) 500 00 01">+7 (499) 500 00 01</a></span>&nbsp;&nbsp;&nbsp;<span <?if ($_SESSION['GEOIP']['curr_city_name'] == 'Москва') { ?>class="roi_phone_2"<? } ?>><a data-rel="external" target="_blank" style="font-weight:bold; color: black;" href="tel:8 (800) 550 33 45">8 (800) 550 33 45</a></span></b></p>
					<?endif;?>
				</div-->

				<a href='' class='foot_clbk bk'>обратная связь</a>
				<a href='' class='foot_clbk ask'>Задать вопрос</a>
                <p class='tech_i clr6 d-none d-sm-block'>Нашли ошибку в тексте? Выделите ее и нажмите
                    <a id="send_site_error" href="#">CTRL + ENTER</a>
                </p>

                <div class="col text-center">
                    <a href='#' onclick="setCookie('fullscreen', 'Y', 30); document.location.reload(true);" class='foot_clbk mobile_fullscreen'><span class='mobile_fullscreen'>Полная версия сайта</span></a>
                    <? if ($_COOKIE['fullscreen']) { ?>
                        <a href='#' onclick="setCookie('fullscreen', '', -1); document.location.reload(true);" class='foot_clbk'><span>Мобильная версия сайта</span></a>
                    <? } ?>
                </div>

			</div>
		</div>
	</div>
	
	<div style="display:none;" class="vcard">
	  <div>
		<a class="fn org url" href="https://www.termoros.com">АО ТД «Терморос»</a>
	  </div>
	  <div class="adr">
		<span class="locality">г. Москва</span>,
		<span class="street-address">ул. Архитектора Власова 55</span>
	  </div>
	  <div class="tel">Телефон: 
		<abbr class="value" title="+7 (499) 500 00 01">+7 (499) 500 00 01</abbr>
	  </div>
	</div>
	
	<div class='foot_copy'>
        <div class="container">
            <div class="row">
                <p class='col text-center'><a class="col" href='/copy.php'>Правовая информация.</a> © <?=date("Y")?> АО ТД «Терморос»</p>
            </div>
        </div>
	</div>

    <a id="stt" onClick="window.scroll({ top: 0,left: 0,behavior: 'smooth' });"><i class="fas fa-angle-double-up"></i></a>
</footer><!-- .footer -->
<? 

global $USER;
$tmp = explode("/", trim($APPLICATION->GetCurDir(), '/'));

//Подменяем SEO для пагинации
if ($_GET['PAGEN_1'] && $_GET['PAGEN_1'] > 1)
{
	$title = $APPLICATION->GetPageProperty("title");
	$descr = $APPLICATION->GetPageProperty("description");
	$APPLICATION->SetPageProperty("title", $title." | Страница ".$_GET['PAGEN_1']); 
	$APPLICATION->SetPageProperty("description", $descr." Страница ".$_GET['PAGEN_1']."."); 
}
//Подменяем SEO для пагинации 2
if ($_GET['PAGEN_2'] && $_GET['PAGEN_2'] > 1 && !$_GET['PAGEN_1'])
{
	$title = $APPLICATION->GetPageProperty("title");
	$descr = $APPLICATION->GetPageProperty("description");
	$APPLICATION->SetPageProperty("title", $title." | Страница ".$_GET['PAGEN_2']); 
	$APPLICATION->SetPageProperty("description", $descr." Страница ".$_GET['PAGEN_2']."."); 
}

//SEO block
$uri = $APPLICATION->GetCurPage();
$res = CIBlockElement::GetList(
 Array("ACTIVE_FROM"=>"DESC"),
 Array("IBLOCK_ID" => 37, "ACTIVE" => "Y", "NAME" => $uri),
 false,
 array("nTopCount" => 1),
 Array("*", "PROPERTY_TITLE", "PROPERTY_KEYWORDS", "PROPERTY_DESCRIPTION", "PROPERTY_H1")
);
$newSEO = $res->GetNext();
if ($newSEO) {
	//v($newSEO);
	if ($newSEO["PROPERTY_H1_VALUE"]) $APPLICATION->SetTitle($newSEO["PROPERTY_H1_VALUE"]); 
	if ($newSEO["PROPERTY_TITLE_VALUE"]) $APPLICATION->SetPageProperty("title", $newSEO["PROPERTY_TITLE_VALUE"]); 
	if ($newSEO["PROPERTY_KEYWORDS_VALUE"]) $APPLICATION->SetPageProperty("keywords", $newSEO["PROPERTY_KEYWORDS_VALUE"]); 
	if ($newSEO["PROPERTY_DESCRIPTION_VALUE"]) $APPLICATION->SetPageProperty("description", $newSEO["PROPERTY_DESCRIPTION_VALUE"]); 

}
?>
</body>
</html>