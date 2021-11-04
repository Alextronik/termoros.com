<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Встреча партнеров");
?>
<p>Регистрация закрыта</p>
<?/* if (!$_GET['WEB_FORM_ID']) { ?>
<p>Уважаемые коллеги!
<br>Для участия во встрече партнёров Группы компаний «Терморос» 18 октября 2019 года необходимо заполнить регистрационную форму ниже. 
<br>Обращаем ваше внимание, что форма заполняется индивидуально на каждого гостя.
 </p>
 <p>
<table cellpadding="1" cellspacing="1">
<tbody>

<tr>
	<td>
 <a href="https://www.termoros.com/public_events/10-2019/scheme.pdf">Схема проезда</a> <br>
 <span style="color: #959595;">(PDF, 227 Кб)</span><br>
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
		"WEB_FORM_ID" => "44"
	)
);?> <?endif;?>
	
</div>
<? if ($_GET['WEB_FORM_ID'] && $_GET['RESULT_ID']) { ?>
	<script>
		$('.pop_inn > .pop_ttl').hide();
	</script>
<? } */?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>