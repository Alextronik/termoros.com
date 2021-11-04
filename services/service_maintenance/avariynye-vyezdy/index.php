<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Аварийные выезды | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("description", "Аварийные выезды. Предлагаем купить промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetPageProperty("keywords", "аварийные выезды инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetTitle("Аварийные выезды");
?><?/*
<h2>
	 Компания Терморос осуществляет сервисное обслуживание и ремонт котельного оборудования следующих марок:
</h2>
<ul>
	<li><a href="/services/service_maintenance/baxi/">BAXI</a></li>
	<li><a href="/services/service_maintenance/de_dietrich/">De Dietrich</a></li>
	<li><a href="/services/service_maintenance/lamborghini/">Lamborghini</a></li>
	<li><a href="/services/service_maintenance/buderus/">Buderus</a></li>
	<li><a href="/services/service_maintenance/kiturami/">Kiturami</a></li>
	<li><a href="/services/service_maintenance/rapido/">Rapido</a></li>
</ul>
*/?>
<p>
	 Сервисный центр Группы компаний «Терморос» осуществляет оперативные выезды для устранения аварийных ситуаций с котельным оборудованием. В случае возникновения аварийной ситуации вам необходимо связаться с нами по телефону +7 (499) 128-92-40 или в ночное время оставить заявку ниже. Аварийные выезды обладают максимальным приоритетом в нашей работе и мы сделаем все для скорейшего устранения вашей проблемы.
</p>
<p>
	 Для клиентов, заключивших с нами <a href="/services/service_maintenance/godovoe-servisnoe-obsluzhivanie/">годовой сервисный договор</a>, аварийные выезды бесплатны, так как входят в стоимость договора. Для клиентов без сервисных договоров с «Терморос» стоимость выезда определяется согласно прайс-листу.
</p>
<div class="anketa pop_up" style="margin:0;">
	 <?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"inzhiniring_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "inzhiniring_form",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
		"WEB_FORM_ID" => "25"
	)
);?><?endif;?>
</div>
<div class="servpage">
	<div>
 <a href="/upload/pricelists/uslug_gss.zip" class="serv_btn">Скачать прайс-лист</a>
	</div>
</div>
<div style="clear:both;">
</div>
<style>
	.pop_up .inpt .inp_self {
		padding: 5px 30px;
	}
	.pop_up .inpt {
        margin: 0 0 10px 0;
	}
	.pop_up .errorreport {
		top: 33px;
	}
</style><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>