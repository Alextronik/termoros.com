<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Сотрудничество со СМИ. Предлагаем купить промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetPageProperty("title", "СМИ | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "сми инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetTitle("СМИ");
?><p>
	 Международная группа торгово-инжиниринговых компаний «Терморос» успешно работает в России и Армении более 20 лет. За это время нам удалось наладить сотрудничество с ведущими отраслевыми изданиями и ассоциациями.
</p>
<h2>
Сфера деятельности </h2>
<p>
	 К основным сферам деятельности «Терморос» относятся производство в России встраиваемых в пол конвекторов по бельгийской технологии, оптовая торговля российским, европейским и азиатским инженерным оборудованием и полный комплекс инжиниринговых услуг – от проектирования до постгарантийного обслуживания.
</p>
<h2>
Продукция </h2>
<p>
	 Группа компаний «Терморос» предлагает своим партнерам широкий спектр оборудования: промышленное и бытовое котельное оборудование, системы отопления, водоснабжения, водоподготовки и другие инженерные системы.
</p>
<h2>
Услуги </h2>
<p>
	 «Терморос» обладает опытом успешной реализации знаковых объектов – от коттеджей до небоскребов:
</p>
<p>
</p>
<ol class="custom_ol">
	<li><span class="num">1</span>Проектирование</li>
	<li><span class="num">2</span>Поставка</li>
	<li><span class="num">3</span>Монтаж</li>
	<li><span class="num">4</span>Пусконаладка</li>
	<li><span class="num">5</span>Сервисное обслуживание </li>
</ol>
<p>
</p>
<div>
 <b>
	Приглашаем представителей СМИ к сотрудничеству, в рамках которого мы обеспечиваем: </b>
</div>
<p>
</p>
<ol class="custom_ol">
	<li><span class="num">1</span>Оперативное предоставление комментариев наших сотрудников и технических экспертов;</li>
	<li><span class="num">2</span>Оказание содействия в подготовке тематических статей;</li>
	<li><span class="num">3</span>Организацию интервью, фото- и видеосъемки с представителями нашей компании;</li>
	<li><span class="num">4</span>Предоставление технических, графических, фото- и видеоматериалов.<br>
 </li>
</ol>
<p>
</p>
<p>
	 По вопросам сотрудничества с нами обращайтесь в пресс-службу «Терморос» по тел.: (499) 500-00-01 (доб. 1144, 1173) или по электронной почте: <a href="mailto:reklama@termoros.com">reklama@termoros.com</a><br>
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
		"WEB_FORM_ID" => "8"
	)
);?> <?endif;?>
	<div style="height: 50px;" class="clear">
	</div>
</div>
<h3>
Рекламно-информационные материалы «Терморос» </h3>
<ul>
	<li><a href="/technical_support/articles/">Статьи;</a></li>
	<li><a href="/technical_support/training/">Обучение: вебинары и семинары;</a></li>
	<li><a href="/news/gruppa-kompaniy-termoros-na-vystavke-aqua-therm-moscow-2016-itogi/">Участие в выставках</a>;</li>
	<li><a href="/documents/press_release.pdf" target="_blank">Скачать пресс-релиз</a>&nbsp;<span style="color: #959595;">(PDF, 99 Кб)</span>;</li>
	<li><a href="/documents/presentations/termoros_presentation_rus.pdf">Скачать презентацию</a> <span style="color: #959595;">(PDF, 3.7 Мб)</span>;</li>
	<li><a href="/buklet/buklet_termoros.pdf">Скачать буклет</a> <span style="color: #959595;">(PDF, 294 Кб)</span>;</li>
	<li>Скачать логотип «Терморос» в <a href="/documents/logo/logo_termoros.ai">векторном (AI, 1.1 Мб)</a> или <a href="/documents/logo/logo_termoros.jpg">растровом (JPG, 144 Кб)</a> формате.</li>
</ul><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>