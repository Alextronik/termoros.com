<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Опрос участника семинара 16-17 июня 2017");
?>
<p>Благодарим Вас за участие в семинаре по оборудованию «Терморос», который состоялся 16-17 июня 2017 года в отеле «Атлас Парк отеле».
</p>
<p>Ваше мнение очень важно для нас, пожалуйста, заполните анкету и мы учтем Ваши пожелания при организации следующего мероприятия.</p>

<div class="anketa pop_up" style="width: auto; ">
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
		"WEB_FORM_ID" => "32"
	)
);?> <?endif;?>
	<p>Спасибо за Ваше мнение и уделённое время.</p>
	<p>До встречи на следующих мероприятиях Группы компаний «Терморос»!</p>
</div>

<style>
input[type='radio'] {
	 -webkit-appearance: radio !important; 
}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$('input[name^="form_checkbox_SIMPLE_QUESTION_535"]').trigger('click');
		
	});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>