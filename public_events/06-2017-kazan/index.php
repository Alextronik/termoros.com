<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Семинар по оборудованию FAR и Gekon 9 июня 2017 года");
?>
<? if (!$_GET['WEB_FORM_ID']) { ?>
<p>Уважаемые коллеги!
<br>Для участия в семинаре по оборудованию FAR и Gekon 9 июня 2017 года необходимо заполнить регистрационную форму ниже. 
 </p>
 <p>
<table cellpadding="1" cellspacing="1">
<tbody>
<tr>
	<td>
 <a href="https://www.termoros.com/mail_attachments/2017_06/priglashenie_na_seminar_kazan.pdf"><img alt="pdf.png" src="/upload/medialibrary/1bf/pdf.png" title="pdf.png"></a>
	</td>
	<td>
 <a href="https://www.termoros.com/mail_attachments/2017_06/priglashenie_na_seminar_kazan.pdf">Программа семинара</a><br>
 <span style="color: #959595;">(PDF, 124 Кб)</span><br>
	</td>
</tr>
</tbody>
</table>
</p>
<? } ?>
<div class="anketa pop_up" style="width: auto; ">
	<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"inzhiniring_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
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
		"WEB_FORM_ID" => "30"
	)
);?> <?endif;?>
	
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>