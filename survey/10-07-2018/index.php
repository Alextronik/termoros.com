<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ассортимент вашей компании");
?>
<p><b>Уважаемые партнёры! Просим вас пройти короткий опрос на тему ассортимента вашей компании. Опрос займёт не более 2 минут.</b></p>
<div class="anketa pop_up" style="width: auto; ">
	 <?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"inzhiniring_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
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
		"WEB_FORM_ID" => "40"
	)
);?> <?endif;?>
	<p>Благодарим Вас за уделённое время.</p>
</div>

<style>
input[type='radio'] {
	 -webkit-appearance: radio !important; 
}
.pop_up .inpt .inp_self {
	padding: 5px 10px;
}
.pop_up .inpt {
	margin: 0 0 10px 0;
}

.pop_up .checkboxArea, .pop_up .checkboxAreaChecked {
	margin-top: -6px;
}

.inner_contentblock .anketa.pop_up .pop_left .inpt {
    width: 980px;
}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$('input[name^="form_checkbox_SIMPLE_QUESTION_535"]').trigger('click');
		
	});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>