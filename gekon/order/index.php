<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Заказ продукции Gekon");
$APPLICATION->SetPageProperty("description", "Заказ продукции Gekon");
$APPLICATION->SetTitle("Заказ продукции Gekon");
?><p>
</p>
<table cellpadding="1" cellspacing="1">
<tbody>
<tr>
	<td colspan="2" align="left">
		<h3>Медно-алюминиевые конвекторы</h3>
	</td>
	<td colspan="2" align="left">
		<h3>Алюминиевые секционные радиаторы</h3>
	</td>
</tr>
<tr>
	<td style="vertical-align:middle;">
 <a target="_blank" href="/buklet/gekon_buklet.pdf"><img width="35" alt="pdf-icon.png" src="/upload/medialibrary/2df/2df0e404ed707a3266e5efbd412e5d38.png" height="45" title="pdf-icon.png" align="left"></a>
	</td>
	<td style="vertical-align:middle;">
 <a target="_blank" href="/buklet/gekon_buklet.pdf">Скачать буклет</a><br>
 <span style="color: #959595;">(PDF, 3.9 Мб)</span>
	</td>
	<td style="vertical-align:middle;">
 <a target="_blank" href="/buklet/presentation_gekon_alum.pdf"><img width="35" alt="pdf-icon.png" src="/upload/medialibrary/2df/2df0e404ed707a3266e5efbd412e5d38.png" height="45" title="pdf-icon.png" align="left"></a>
	</td>
	<td style="vertical-align:middle;">
 <a target="_blank" href="/buklet/presentation_gekon_alum.pdf">Скачать презентацию</a><br>
 <span style="color: #959595;">(PDF, 612 Кб)</span>
	</td>
</tr>
<tr>
	<td style="vertical-align:middle;">
 <a href="/buklet/price_gekon_vnutripol.xlsx"><img width="51" alt="xlsx-win-icon.png" src="/upload/medialibrary/1e4/xlsx_win_icon.png" height="51" title="xlsx-win-icon.png"></a><br>
	</td>
	<td style="vertical-align:middle;">
 <a target="_blank" href="/buklet/price_gekon_vnutripol.xlsx">Скачать прайс-лист</a><br>
 <span style="color: #959595;">(XLSX, 1.5 Мб)</span>
	</td>
	<td style="vertical-align:middle;">
 <a href="/buklet/price_gekon_alum.xlsx"><img width="51" alt="xlsx-win-icon.png" src="/upload/medialibrary/1e4/xlsx_win_icon.png" height="51" title="xlsx-win-icon.png"></a><br>
	</td>
	<td style="vertical-align:middle;">
 <a target="_blank" href="/buklet/price_gekon_alum.xlsx">Скачать прайс-лист</a><br>
 <span style="color: #959595;">(XLSX, 448 Кб)</span>
	</td>
</tr>
</tbody>
</table>
<p>
</p>
<p>
	 Внутрипольные и напольные конвекторы российского производства Gekon уже на складе. У вас есть возможность оформить заказ на продукцию, оставив заявку нашим специалистам:
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