<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Анкета соискателя");
?>
<div class="anketa pop_up">
<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> 
<?else:?> 
	<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"anketa", 
	array(
		"COMPONENT_TEMPLATE" => "anketa",
		"WEB_FORM_ID" => "5",
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

	<div style="height: 50px;" class="clear"></div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>