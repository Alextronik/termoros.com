<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "График семинаров международной группы компаний «Терморос» в регионах. Предлагаем купить промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetPageProperty("title", "График семинаров в регионах | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "график семинаров в регионах инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetTitle("График семинаров в регионах");
?><p>
 <a href="/technical_support/training/seminars/" class="grapf p-2">График семинаров</a> <a href="/technical_support/training/webinars" class="grapf grapf_blue p-2">График вебинаров</a> <a href="/technical_support/training/webinars/#webinars" class="grapf grapf_orange p-2">Записи вебинаров</a>
</p>
<p>
	 Уважаемые клиенты!
</p>
<p>
	 Для проектных, монтажных и торговых организаций Группа компаний «Терморос» регулярно проводит семинары по эксплуатации, проектированию и монтажу оборудования FAR, Jaga, Gekon, Lamborghini, ТермоСтайл и др. Участие в семинарах бесплатное.
</p>
<?/*<p>
	 Примерный график семинаров в регионах на 2019 г. представлен ниже.
</p>*/?>
<p>
	 Точную дату, тему и место проведения семинара в вашем регионе уточняйте у руководителя ближайшего к вам <a href="/contacts/">филиала</a>, а также в отделе технического обучения «Терморос» по тел.: +7 (499) 500-00-01, 8 (800) 550-33-45..
</p>
<?/*
<p>Также вы можете заполнить заявку на участие.</p>
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
		"WEB_FORM_ID" => "35"
	)
);?><?endif;?>
</div>
*/?>
<?/*
<table class="sem_table" style="width: 95%;" border="1" cellpadding="10" cellspacing="1">
<tbody>
<tr>
	<td style="width: 105px;" align="center">
 <b>Город</b>
	</td>
	<td style="width: 105px;" align="center">
 <b>Дата</b>
	</td>
	
</tr>
<tr>
	<td style="width: 105px;">
		 Обнинск
	</td>
	
	<td style="width: 105px;">
		 05.03.2018
		 [Семинар окончен]
	</td>
</tr>

</tbody>
</table>
*/?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>