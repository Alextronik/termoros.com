<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Карта сайта. Предлагаем купить промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetPageProperty("title", "Карта сайта | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "карта сайта инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetTitle("Карта сайта");
?>
<div id="sitemap">
<a class='ttl' href="/about_company/" >О компании</a>
<?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
	"ROOT_MENU_TYPE" => "about",	// Тип меню для первого уровня
	"MAX_LEVEL" => "1",	// Уровень вложенности меню
	"CHILD_MENU_TYPE" => "about",	// Тип меню для остальных уровней
	"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	"DELAY" => "N",	// Откладывать выполнение шаблона меню
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	"MENU_CACHE_TYPE" => "N",	// Тип кеширования
	"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
	"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
	"COMPONENT_TEMPLATE" => ".default"
),
	false
);?>


<a class='ttl' href="/cooperation/" >Сотрудничество</a>
<?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
	"ROOT_MENU_TYPE" => "cooperation",	// Тип меню для первого уровня
	"MAX_LEVEL" => "1",	// Уровень вложенности меню
	"CHILD_MENU_TYPE" => "cooperation",	// Тип меню для остальных уровней
	"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	"DELAY" => "N",	// Откладывать выполнение шаблона меню
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	"MENU_CACHE_TYPE" => "N",	// Тип кеширования
	"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
	"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
	"COMPONENT_TEMPLATE" => ".default"
),
	false
);?>

<a class='ttl' href="/catalog/" >Каталог продукции</a>
<?$APPLICATION->IncludeComponent(
"bitrix:menu", 
"footer_menu_catalog", 
array(
	"ROOT_MENU_TYPE" => "catalog",
	"MAX_LEVEL" => "1",
	"CHILD_MENU_TYPE" => "top",
	"USE_EXT" => "Y",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N",
	"MENU_CACHE_TYPE" => "N",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "Y",
	"MENU_CACHE_GET_VARS" => array(
	),
	"COMPONENT_TEMPLATE" => "footer_menu_catalog"
),
false
);?>
<a class='ttl' href="/brands/" >Бренды</a>
<ul class="foot_menu">
	<li><a href="/brands/gekon/">Gekon</a></li>
	<li><a href="/brands/euros/">Euros</a></li>
	<li><a href="/brands/germanium/">Germanium</a></li>
	<li><a href="/brands/atlant/">Atlant</a></li>
	<li><a href="/brands/jagarus/">JagaRus</a></li>
	<li><a href="/brands/jaga/">Jaga</a></li>
	<li><a href="/brands/far/">FAR</a></li>
</ul>

<a class='ttl' href="/technical_support/tech_documentation/">Поддержка</a>
<?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
	"ROOT_MENU_TYPE" => "support",	// Тип меню для первого уровня
	"MAX_LEVEL" => "1",	// Уровень вложенности меню
	"CHILD_MENU_TYPE" => "support",	// Тип меню для остальных уровней
	"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	"DELAY" => "N",	// Откладывать выполнение шаблона меню
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	"MENU_CACHE_TYPE" => "N",	// Тип кеширования
	"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
	"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
	"COMPONENT_TEMPLATE" => ".default"
),
	false
);?>


<a class='ttl' href="/services/" >Услуги</a>
<?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
	"ROOT_MENU_TYPE" => "services",	// Тип меню для первого уровня
	"MAX_LEVEL" => "1",	// Уровень вложенности меню
	"CHILD_MENU_TYPE" => "services",	// Тип меню для остальных уровней
	"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	"DELAY" => "N",	// Откладывать выполнение шаблона меню
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	"MENU_CACHE_TYPE" => "N",	// Тип кеширования
	"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
	"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
	"COMPONENT_TEMPLATE" => ".default"
),
	false
);?>

<a class='ttl' href="/buyers/prices/">Покупателям</a>
<?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
	"ROOT_MENU_TYPE" => "buyers",	// Тип меню для первого уровня
	"MAX_LEVEL" => "1",	// Уровень вложенности меню
	"CHILD_MENU_TYPE" => "buyers",	// Тип меню для остальных уровней
	"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	"DELAY" => "N",	// Откладывать выполнение шаблона меню
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	"MENU_CACHE_TYPE" => "N",	// Тип кеширования
	"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
	"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
	"COMPONENT_TEMPLATE" => ".default"
),
	false
);?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>