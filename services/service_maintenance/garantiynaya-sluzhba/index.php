<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Гарантийное и постагарантийное обслуживание сложного инженерного оборудования");
$APPLICATION->SetPageProperty("description", "Гарантийное и постагарантийное обслуживание сложного инженерного оборудования");
$APPLICATION->SetTitle("Гарантийная служба");
?>
<p>Гарантийно-сервисный центр Группы компаний «Терморос» осуществляет гарантийное и постгарантийное обслуживание оборудования. Профессионально обученные и аттестованные специалисты, поддержание требуемого перечня запасных частей на собственном складе, наличие дежурной горячей линии - все это позволяет гарантировать быстрое решение всех возможных аварийных ситуаций, связанных с эксплуатацией, ремонтом и заменой устаревшего оборудования.</p>

<h2>Компания Терморос является сервисным центром таких производителей, как:</h2>
<ul>
	<li><a href="/brands/baxi/">Котельное оборудование Baxi;</a></li>
	<li><a href="/brands/dedietrich/">Котельное оборудование De Dietrich;</a></li>
	<li><a href="/brands/lamborghini/">Котельное оборудование Lamborghini;</a></li>
	<li><a href="/catalog/nasosnoe_oborudovanie/nasos/filter/brend-is-45c610e7-b893-11e5-80cf-0cc47a1d8513/apply/">Насосы DAB;</a></li>
	<li><a href="/catalog/pribory_otopleniya/filter/brend-is-45c610df-b893-11e5-80cf-0cc47a1d8513/apply/">Конвекторов и дизайн-радиаторов Jaga;</a></li>
	<li><a href="/catalog/pribory_otopleniya/filter/brend-is-524dfe7d-ce74-11e5-80d6-0cc47a1d8513/apply/">Конвекторов и дизайн-радиаторов Gekon.</a></li>
</ul>

<p>Мы принимаем рекламации от покупателей оборудования этих производителей и осуществляем гарантийный  и не гарантийный ремонт оборудования. Со своими вопросами Вы можете позвонить в гарантийно-сервисную службу компании Терморос или оставить заявку на нашем сайте.</p>

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
		"WEB_FORM_ID" => "26"
	)
);?><?endif;?>
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