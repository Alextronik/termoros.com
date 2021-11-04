<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "Терморос");
$APPLICATION->SetPageProperty("keywords", "Терморос Приглашение на встречу партнеров");
$APPLICATION->SetPageProperty("description", "Приглашение на встречу партнеров_Терморос_апрель_2015");
$APPLICATION->SetTitle("Приглашение на встречу партнеров_Терморос_апрель_2015");
?><p>
	 Уважаемые клиенты!<br>
	 23 октября 2015 года в Академии Упонор Рус совместно с "Терморос"&nbsp;состоится семинар по оборудованию UPONOR для партнеров из Москвы и ЦФО. Для участия в семинаре необходимо заполнить регистрационную форму.
</p>
<form action="" method="post">
	<p style="text-align: center;">
 <br>
	</p>
</form>
<p>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	".default",
	Array(
		"WEB_FORM_ID" => "10",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "N",
		"SEF_MODE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SHOW_ERROR_LIST" => "Y",
		"LIST_URL" => "",
		"EDIT_URL" => "",
		"SUCCESS_URL" => "/podderzhka/obuchenie-i-seminary/vasha-zayavka-prinyata.php",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",)
	)
);?>
</p>
<p>
 <br>
</p>
<p>
	 За дополнительной информацией обращайтесь, пожалуйста, в компанию «Терморос» по тел.: <a href="skype:+74957855500?call">8 (495) 785-55-00</a><br>
	 Контактное лицо: Александр Регер (доб. 1398), <a href="mailto:reger@termoros.com">reger@termoros.com</a>
</p>
<p>
 <b>Место проведения семинара</b><br>
	 Москва, ул. 2-я Хуторская, 38А, стр. 8
</p>
 <br>
<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=5yBft5OtetsXiLtMbnn3DLtG9I-YzXAi&width=1000&height=349&lang=ru_RU&sourceType=constructor"></script><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>