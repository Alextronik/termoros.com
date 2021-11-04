<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Семинар Группы компаний «Терморос» 1-2 июня 2018 года");
?>
<? if (!$_GET['WEB_FORM_ID']) { ?>
<p>Уважаемые коллеги!
<br>Для участия в обучающем семинаре Группы компаний «Терморос» 1-2 июня 2018 года необходимо заполнить регистрационную форму ниже. 
<br>Обращаем ваше внимание, что форма заполняется индивидуально на каждого гостя.
 </p>
 <p>
<table cellpadding="1" cellspacing="1">
<tbody>
<tr>
	<td>
 <a href="https://www.termoros.com/public_events/06-2018/Программа семинара Терморос 1-2.06.2018.pdf">Программа семинара</a><br>
 <span style="color: #959595;">(PDF, 508 Кб)</span><br>
	</td>
</tr>
<tr>
	<td>
 <a href="https://www.termoros.com/mail_attachments/2018-05/schem.pdf">Схема проезда</a> <br>
 <span style="color: #959595;">(PDF, 266 Кб)</span><br>
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
		"WEB_FORM_ID" => "38"
	)
);?> <?endif;?>
	
</div>
<? if ($_GET['WEB_FORM_ID'] && $_GET['RESULT_ID']) { ?>
	<script>
		$('.pop_inn > .pop_ttl').hide();
	</script>
<? } ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>