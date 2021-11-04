<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Технические семинары и вебинары международной группы компаний «Терморос». Предлагаем купить промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetPageProperty("title", "Обучение | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "обучение инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetTitle("Обучение");
?>
<p>
<a href="/technical_support/training/seminars/" class="grapf p-2">График семинаров</a> <a href="/technical_support/training/seminars_regions/" class="grapf p-2">График семинаров в регионах</a> <a href="/technical_support/training/webinars/" class="grapf grapf_blue p-2">График вебинаров</a> <a href="/technical_support/training/webinars/#webinars" class="grapf grapf_orange p-2">Записи вебинаров</a>

<p>
	 Для проектных, монтажных и торговых организаций компания «Терморос» регулярно проводит семинары по эксплуатации, проектированию и монтажу оборудования.
</p>
<h2>
Семинары в главном офисе </h2>
<p>
	 Компания «Терморос» регулярно проводит обучающие семинары по эксплуатации, проектированию и монтажу оборудования для проектных, монтажных и торговых организаций. Особое внимание на семинарах уделяется не только теоретическим и практическим основам, но и особенностям подбора и настройки оборудования.
</p>
<p>
	 В испытательной лаборатории ГК «Терморос» производится настройка и запуск оборудования, а также моделируются форс-мажорные ситуации и способы их устранения. График проведения семинаров обновляется 2 раза в год.
</p>
<p>
	 Приглашаем всех желающих принять участие в данных мероприятиях.
</p>
<p>
	 Участие в семинарах бесплатное. Регистрация обязательна.
</p>
<h2>
Обучение в регионах </h2>
<p>
	 Мы также проводим обучение в регионах. Информация о планируемых семинарах <a href="/technical_support/training/seminars_regions/">доступна по ссылке</a>.
</p>
<h2>
Выезды на производство </h2>
<p>
	 Несколько раз в год «Терморос» организует поездки на заводы производителей отопительного оборудования: в Италию, Бельгию, Германию.
</p>
<p>
	 В зарубежных поездках приняли участие уже более 1 000 представителей торговых и монтажных компаний - партнеров из разных уголков России. Это важный опыт, который дает специалистам возможность напрямую ознакомиться с производственным процессом, увидеть лабораторные испытания продукции на прочность, обсудить вопросы внедрения и эксплуатации оборудования в существующих объектах.
</p>
<p>
	 Одним из ключевых моментов коллективных туров на заводы является возможность личного общения с инженерами и сотрудниками предприятия, которые предоставляют максимально полную информацию о продукции и производстве.
</p>
<p>
</p>
<?$APPLICATION->IncludeComponent(
	"bitrix:news",
	"news-tpl",
	Array(
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COLOR_NEW" => "3E74E6",
		"COLOR_OLD" => "C0C0C0",
		"COMPONENT_TEMPLATE" => "news-tpl",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(0=>"",1=>"",),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "arrows",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array(0=>"",1=>"MORE_PICTURE",2=>"",),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_AS_RATING" => "rating",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PANEL" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FONT_MAX" => "50",
		"FONT_MIN" => "10",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "21",
		"IBLOCK_TYPE" => "news",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(0=>"",1=>"",),
		"LIST_PROPERTY_CODE" => array(0=>"",1=>"",),
		"MEDIA_PROPERTY" => "",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "6",
		"NUM_DAYS" => "180",
		"NUM_NEWS" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Семинары",
		"PERIOD_NEW_TAGS" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/technical_support/training/",
		"SEF_MODE" => "Y",
		//"SEF_URL_TEMPLATES" => array("news"=>"","section"=>"","detail"=>"#ELEMENT_CODE#/","rss"=>"rss/","rss_section"=>"#SECTION_ID#/rss/",),
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SLIDER_PROPERTY" => "",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"TAGS_CLOUD_ELEMENTS" => "150",
		"TAGS_CLOUD_WIDTH" => "100%",
		"TEMPLATE_THEME" => "site",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "Y",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"YANDEX" => "N"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>