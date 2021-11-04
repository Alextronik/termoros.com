<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Получить доступ в Личный кабинет партнера");
?>
<p><a href="/partners/">Узнать о возможностях личного кабинета</a></p>

<div class="anketa pop_up" style="width: auto; ">
	<div style="width:450px; padding: 10px; background-color: #eee;">
	 <?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"simple_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "simple_form",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
		"WEB_FORM_ID" => "17"
	)
);?> <?endif;?>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>