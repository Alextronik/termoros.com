<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "DIY. Предлагаем купить промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetPageProperty("title", "DIY | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "diy инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetTitle("DIY");
?><p>
	 Группа компаний «Терморос» – крупнейший поставщик инженерного оборудования. Благодаря высокому качеству предоставляемой продукции и безупречному сервису обслуживания компания наладила долгосрочное взаимовыгодное сотрудничество с торговыми сетями. «Терморос» предоставляет индивидуальные условия сотрудничества партнерам, имеющим одну и более розничных торговых точек, и сетевым магазинам.
</p>
<h3>Продукция </h3>
<p>
	 В ассортиментном портфеле «Терморос» <a href="/brands/">более 50 брендов</a>&nbsp;отечественной, европейской и азиатской продукции: лидирующие на рынке Danfoss, Purmo, Rifar, Grundfos, Baxi, Reflex, FAR, Jaga и собственная продукция Группы компаний «Терморос» – Gekon, Euros, Germanium, Atlant.
</p>
<h3>Услуги </h3>
<p>
</p>
<ol class="custom_ol">
	<li><span class="num">1</span>Наличие оборудования на <a href="/contacts/">складских комплексах компании</a> в 9 городах России: Москве, Санкт-Петербурге, Казани, Краснодаре, Уфе, Новосибирске, Екатеринбурге, Ростове-на-Дону и Пятигорске;</li>
	<li><span class="num">2</span>Договор взаимовыгодного сотрудничества, в который входят комплексные решения вопросов поставки отопительного оборудования и уникальные условия сотрудничества, защищающие интересы партнеров компании;</li>
	<li><span class="num">3</span>Предпродажная подготовка продукции, включающая штрих-кодирование по системе EAN-13 для удобства реализации продукции в сетях;</li>
	<li><span class="num">4</span>Выгодные условия и индивидуальные скидки;</li>
	<li><span class="num">5</span><a href="/technical_support/tech_documentation/">Сопровождение продаж</a> всей необходимой документацией, технической, рекламно-маркетинговой, информационной продукцией и полиграфией, а также помощь в оборудовании мест продаж;</li>
	<li><span class="num">6</span>Доставка по Москве, Московской области и до терминалов многих транспортных компаний для отгрузки в регионы;</li>
	<li><span class="num">7</span><a href="/technical_support/training/">Регулярное бесплатное обучение</a> навыкам продаж и техническим особенностям оборудования в нашем учебном центре или на территории партнера с участием специалистов компании «Терморос» и представителей поставщиков;</li>
	<li><span class="num">8</span>Участие в акциях и поездки на заводы-изготовители.<br>
 </li>
</ol>
<p>
</p>
<h3>
По вопросам сотрудничества обращайтесь в Департамент продаж «Терморос»: </h3>
<p>
 <b>Москва и Московская область:</b> <br>
	 Игнатьев Александр (499) 500 00 01 (доб. 1354), <a href="mailto:ignatyev@termoros.com">ignatyev@termoros.com</a> <br>
	 Тюшкевич Николай (499) 500 00 01 (доб. 1380), <a href="mailto:tyushkevich@termoros.com">tyushkevich@termoros.com</a>
</p>
<p>
 <b>Регионы Центрального федерального округа: </b> <br>
	 Барковский Андрей (499) 500 00 01 (доб. 1310), <a href="mailto:barkovskiy@termoros.com">barkovskiy@termoros.com</a>
</p>
<p>
 <b>Регионы Поволжья, Дальнего Востока, Уральский и Сибирский федеральные округа:</b> <br>
	 Раушкин Иван (499) 500 00 01 (доб. 1173), <a href="mailto:ivan@termoros.com">ivan@termoros.com</a>
</p>
<p>
 <b>Южный, Северо-Кавказский и Крымский федеральные округа:</b> <br>
	 Кандалинцев Максим (918) 467 31 16, <a href="mailto:kandalintsev@termoros.com">kandalintsev@termoros.com</a>
</p>
<p>
 <b>Северо-Западный федеральный округ:</b> <br>
	 Хроменкова Анастасия +7 (812) 703-00-02, <a href="mailto:hromenkova@spb.termoros.ru">hromenkova@spb.termoros.ru</a><br>
    Путилова Вероника +7 (812) 703-00-02 (доб. 1650), <a href="mailto:putilova@spb.termoros.ru">putilova@spb.termoros.ru</a><br>
</p>
 <br>
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
		"WEB_FORM_ID" => "11"
	)
);?> <?endif;?>
	<div style="height: 50px;" class="clear">
	</div>
</div>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>