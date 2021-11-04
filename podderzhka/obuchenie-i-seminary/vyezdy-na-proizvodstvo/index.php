<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Выезды на производство");
?><h2>Выезды на производство</h2>
<p>
	 ​Несколько раз в год "Терморос" организовывает поездки на заводы производителей отопительного оборудования: в Италию, Бельгию, Германию.
</p>
<p>
	 В зарубежных поездках приняли участие уже более 400 представителей торговых и монтажных компаний - партнеров из разных уголков России.
</p>
<p>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"",
	Array(
		"WEB_FORM_ID" => "4",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "N",
		"SEF_MODE" => "N",
		"VARIABLE_ALIASES" => Array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID"),
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"LIST_URL" => "result_list.php",
		"EDIT_URL" => "result_edit.php",
		"SUCCESS_URL" => "",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => ""
	)
);?><br>
</p>
<p>
 <br>
</p>
<p>
	 Это важный опыт, который дает специалистам возможность напрямую ознакомиться с производственным процессом, увидеть лабораторные испытания продукции на прочность, обсудить вопросы внедрения и эксплуатации оборудования в существующих объектах.
</p>
<p>
	 &nbsp;Одним из ключевых моментов коллективных туров на заводы является возможность личного общения с инженерами и сотрудниками предприятия, которые предоставляют максимально полную информацию о продукции и производстве.
</p>
 <br>
<h3>Отчёты с проведённых мероприятий</h3>
27.06.2014 <a href="/novosti/aktsii/oplata-bankovskimi-kartami.php">Семинар "Газовые и дизельные горелки Lamborghini"</a><br>
30.04.2014 <a href="/novosti/aktsii/oplata-bankovskimi-kartami.php">Учебный семинар для партнеров компании "Терморос Инжиниринг"</a> <br>
27.06.2014 <a href="/novosti/aktsii/oplata-bankovskimi-kartami.php">Семинар "Газовые и дизельные горелки Lamborghini"</a><br>
30.04.2014 <a href="/novosti/aktsii/oplata-bankovskimi-kartami.php">Учебный семинар для партнеров компании "Терморос Инжиниринг"</a>
<p>
 <br>
</p>
<p>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	".default",
	Array(
		"WEB_FORM_ID" => "2",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "Y",
		"SEF_MODE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"LIST_URL" => "",
		"EDIT_URL" => "",
		"SUCCESS_URL" => "",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"SHOW_ERROR_LIST" => "Y",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",)
	)
);?>
</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>