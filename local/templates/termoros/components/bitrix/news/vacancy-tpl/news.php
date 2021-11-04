<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>


<div class="vacancy_page" />
<div class='vac_i'>
	<img src="<?=SITE_TEMPLATE_PATH?>/img/ashot.png" alt="" />					
	
	<p>
		 Уверен, что если Вы - профессионал, или стремитесь стать таковым, если Вы амбициозны и инициативны, если Вы считаете, что в состоянии сделать этот мир хоть немного лучше, в нашей компании Вы найдете возможности для собственного роста и развития и сможете наилучшим образом применить свои знания, навыки и опыт.
	</p>
	<p>
		 У нас открываются широкие возможности для людей, понимающих значимость, вес и глубину всех взятых на себя обязательств и готовых обеспечить их выполнение.
	</p>
	<p>
		 Один из важнейших принципов политики Компании – инвестировать в людей. Мы заинтересованы в том, чтобы люди, которые пришли в нашу Компанию постоянно развивались и совершенствовались.
	</p>
	<p>
		 Кадры действительно решают все.
	</p>
	<br>
	<p align="right" style="font-weight:bold;">Президент Группы компаний «Терморос»<br/>Даниелян Ашот Агбалович</p>
	<div class='clear'></div>
	
</div>

<h2>Карьера в Группе компаний «Терморос»</h2>
<noindex>
<div style="position:relative;">
<a target="_blank" rel="nofollow" style="position: absolute; left: -200px;" href="https://www.superjob.ru/clients/termoros-25425.html?utm_source=PR2015&utm_medium=referral&utm_campaign=25425"><img src="https://img.superjob.ru/img/_redesign/landings/best_employer/best_employer2016_big.jpg" border="0" alt="Привлекательный работодатель" width="145" height="161"></a>
</div>
</noindex>

<p>
	 Группа компаний «Терморос» не могла бы стать тем, чем она является на сегодняшний день, без людей, которые в ней работают. Более 600 сотрудников, работающих в России и странах СНГ, несут полную ответственность за разработку проектов и оказание услуг клиентам.
</p>
<p>
	 В&nbsp;числе наших ценностей – инновационность, лидерство, нацеленность на результат, надежность и порядочность, компетентность, экологичность. Мы не только стремимся к познанию окружающей действительности, но и формируем ее, развивая дело, которому служим.
</p>
<p>
	 Наши ценности образуют фундамент нашей компании и формируют культуру «Терморос». Помимо профессионального развития сотрудников, много внимания уделяется корпоративной культуре и человеческим ценностям. Наша задача - постоянно добиваться максимальных результатов в любом направлении нашей деятельности.
</p>
<br/>
<p>
	<b> Наши приоритеты работы с персоналом:</b>
</p>
<ol class='custom_ol'>
	<li><span class="num">1</span>Повышение вовлеченности сотрудников в оптимизацию бизнес-процессов;</li>
	<li><span class="num">2</span>Повышение профессиональных навыков сотрудников путем постоянного обучения и делегирования ответственности;</li>
	<li><span class="num">3</span>Раскрытие возможностей для личного и профессионального роста и развития;</li>
	<li><span class="num">4</span>Создание безопасных, комфортных и надежных условий труда.</li>
	<li><span class="num">5</span>Все вместе мы составляем сильную и преуспевающую команду. Мы заинтересованы и увлечены как своей работой, так и всем, что происходит вокруг нас.</li>
</ol>

<b><p>
	 Если Вам нравится наш подход, если Вы амбициозны, инициативны, динамичны и готовы разделить с нами наши ценности и избранный нами путь создания нового представления о комфорте и эстетике пространства, мы будем рады видеть Вас в нашей дружной команде.
</p>
<p>
	 Однажды придя работать в «Терморос», люди остаются в нем на долгие годы.
</p>
<p>
	 Вы можете ознакомиться со списком актуальных вакансий и откликнуться на заинтересовавшую, заполнив <a href="/about_company/career_v">on-line анкету</a> или направив свое резюме на адрес <a href="mailto:hr@termoros.com">hr@termoros.com</a>.
</p>	</b>



<h2>Актуальные вакансии</h2>

<?/*
global $arrFilter;
if($_REQUEST['city']){
	//$curryear = $_REQUEST['year'];
	$arrFilter[] = array("PROPERTY_CITY" => $_REQUEST['city']);
	//p($EventFilter);
}

if($_REQUEST['grp']){
	//$curryear = $_REQUEST['year'];
	$arrFilter[] = array("PROPERTY_GROUP" => $_REQUEST['grp']);
	//p($EventFilter);
}
*/
?>
<?

$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"NEWS_COUNT" => $arParams["NEWS_COUNT"],
		"SORT_BY1" => $arParams["SORT_BY1"],
		"SORT_ORDER1" => $arParams["SORT_ORDER1"],
		"SORT_BY2" => $arParams["SORT_BY2"],
		"SORT_ORDER2" => $arParams["SORT_ORDER2"],
		"FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
		"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_FILTER" => $arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["PAGER_TITLE"],
		"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
		"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
		"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
		"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
		"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
		"ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
		"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
		"FILTER_NAME" => "arrFilter",//$arParams["FILTER_NAME"],
		"HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
	),
	$component
);?>





</div>

<p><a href="Сводная_ведомость_результатов_СОУТ_Терморос_Инжиниринг.PDF">Сводная ведомость результатов СОУТ Терморос Инжиниринг</a></p>
<p><a href="Сводная_ведомость_результатов_СОУТ_ЯГАРУС.pdf">Сводная ведомость результатов СОУТ ЯГАРУС</a></p>
