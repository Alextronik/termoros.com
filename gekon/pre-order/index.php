<?
header("Location: /gekon/order/");
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Предзаказ на продукцию Gekon");
$APPLICATION->SetPageProperty("description", "Предзаказ на продукцию Gekon");
$APPLICATION->SetTitle("Предзаказ на продукцию Gekon");
?><p>
</p>
<table cellpadding="1" cellspacing="1">
<tbody>
<tr>
	<td style="vertical-align:middle;">
 <a target="_blank" href="/buklet/gekon_buklet.pdf"><img width="52" alt="pdf-icon.png" src="/upload/medialibrary/2df/2df0e404ed707a3266e5efbd412e5d38.png" height="68" title="pdf-icon.png" align="left"></a>
	</td>
	<td style="vertical-align:middle;">
 <a target="_blank" href="/buklet/gekon_buklet.pdf">Скачать буклет о GEKON</a><br>
 <span style="color: #959595;">(PDF, 3.9 Мб)</span>
	</td>
</tr>
</tbody>
</table>
<p>
	 Внутрипольные и напольные конвекторы российского производства Gekon поступят на склад во втором квартале 2016 года. У вас есть возможность оформить предзаказ на продукцию, оставив заявку нашим специалистам:
</p>
<div class="anketa pop_up">
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
		"WEB_FORM_ID" => "6"
	)
);?> <?endif;?>
	
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>