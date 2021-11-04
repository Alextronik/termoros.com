<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Cеминар «Jaga – доступное качество» 26 апреля 2018 года");
?>
<? if (!$_GET['WEB_FORM_ID']) { ?>
<p>Уважаемые коллеги, для участия в семинаре «Jaga – доступное качество» 26 апреля 2018 года, вам нужно заполнить регистрационную форму. Обращаем ваше внимание, что форма заполняется индивидуально на каждого гостя. </p>
<? } ?>
<div class="anketa pop_up" style="width: auto; ">
	<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"simple_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "simple_form",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
		"WEB_FORM_ID" => "36"
	)
);?> <?endif;?>
	
</div>
<div class="clear"></div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>