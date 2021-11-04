<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetTitle("Заявка на добавление компании на карту партнеров");
?>
<? if (!$_GET['RESULT_ID']) { ?>
<h3>
	Для того, чтобы ваша компания была добавлена в раздел "Где купить" в том или ином бренде, заполните, пожалуйста, заявку.
</h3>
<? } ?>
<div class="anketa pop_up">
	 <?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"inzhiniring_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "inzhiniring_form",
		"EDIT_URL" => "index.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "index.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
		"WEB_FORM_ID" => "34"
	)
);?> <?endif;?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>