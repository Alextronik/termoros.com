<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "Терморос");
$APPLICATION->SetPageProperty("keywords", "Терморос Приглашение на встречу партнеров");
$APPLICATION->SetPageProperty("description", "Приглашение на встречу партнеров_Терморос_апрель_2015");
$APPLICATION->SetTitle("Приглашение на встречу партнеров_Терморос_апрель_2015");
?><p>Уважаемые клиенты!<br>
Для участия в семинаре по оборудованию ГК «Терморос» для ключевых партнеров из Москвы и ЦФО, который состоится в подмосковном отеле «Авантель Клаб Истра» 16-17 апреля 2015 года, Вам необходимо заполнить приведенную ниже регистрационную форму.
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
	array(
		"WEB_FORM_ID" => "8",
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
		"SEF_FOLDER" => "/podderzhka/obuchenie-i-seminary/",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>
</p>
<p>
 <br>
</p>
<p>
За дополнительной информацией обращайтесь, пожалуйста, в компанию «Терморос» по тел.: <a href="skype:+74957855500?call">(495) 785-55-00</a><br>
Контактное лицо: Анна Дмитриева (доб. 173), <a href="mailto:dmitrieva@termoros.com">dmitrieva@termoros.com</a>
</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>