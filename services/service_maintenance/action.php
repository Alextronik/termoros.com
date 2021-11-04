<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Скидка на техническое обслуживание отопительного оборудования для Москвы и Московской области");
$APPLICATION->SetPageProperty("description", "Скидка на техническое обслуживание отопительного оборудования для Москвы и Московской области");
$APPLICATION->SetTitle("Скидка на техническое обслуживание отопительного оборудования для Москвы и Московской области");
?><p>Покупая на сайте termoros.com любое отопительное оборудование, вы получаете скидку на техническое обслуживание котла (газового, дизельного или электрического), находящегося в эксплуатации от 1 до 8 лет.</p>
<p>Скидка 5% на техническое обслуживание котла (пенсионерам и малоимущим предоставляется скидка 10%)</p>
<p>Условия акции:</p>
<p>
<ul>
<li>Выезд для осмотра оборудования котельной, системы отопления и ГВС/ХВС (бесплатно при заключении договора Технического обслуживания).</li>
<li>Заключение договора технического обслуживания на 3 года с ежегодной оплатой по факту проведения работ.</li>
<li>Проведение работ по техническому обслуживанию.
<li>Для получения скидки, пожалуйста, позвоните по телефону: +7 (499) 128 92 40 и назовите кодовую фразу "СКИДКА НА САЙТЕ" - или заполните заявку ниже:</li>
</p>
<?/*<p>Для того, чтобы мы могли рассчитать стоимость работ со скидкой, пожалуйста, заявку:</p>*/?>
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
		"WEB_FORM_ID" => "24"
	)
);?><?endif;?>
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
</style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>