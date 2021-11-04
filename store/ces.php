<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "");
$APPLICATION->SetPageProperty("description", "");
$APPLICATION->SetTitle("");
die();
$voted = FALSE;
$FORM_ID = 42;
$timestamp1 = date('d.m.Y', time()-60*60*24*30);
$arF = array(
    "USER_ID"              => $USER->GetID(),         // пользователь-автор
    "USER_ID_EXACT_MATCH"  => "Y",               // точное совпадение
	"TIMESTAMP_1"          => $timestamp1,
);
$rsResults = CFormResult::GetList(
	$FORM_ID, 
    ($by="s_timestamp"), 
    ($order="desc"), 
    $arF,
    $is_filtered,
    "N", 
    1);

while ($arResult = $rsResults->Fetch())
{
    if ($arResult["ID"]) $voted = TRUE;
}

?>
<? if (!$voted) { ?>
<div class="anketa pop_up">
	 <?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"simple_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "simple_form",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
		"WEB_FORM_ID" => "42"
	)
);?> <?endif;?>
</div>
<? } else { ?>
	<? if ($_REQUEST['RESULT_ID']) { ?>
	<h3>Спасибо за ваше мнение!</h3>
	<? } ?>
<? } ?>

 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>