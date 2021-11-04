<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поддержка");
?><h1>Поддержка</h1>

<div class="stext col2">
	<div>
    <p>В данном разделе сайта собрана информация, которая может понадобиться вам для изучения или продажи нашего оборудования.</p>
    </div>
    <div>
		<p>Если по каким-то причинам вы не нашли то, что искали, обратитесь, пожалуйста, в отдел рекламы ГК «Терморос» с соответствующим запросом по адресу: reklama@termoros.com</p>
    </div>
</div>
<div class="hr"></div>
<?$APPLICATION->IncludeComponent("bitrix:menu", "submenu", Array(
	"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
		"MENU_CACHE_TYPE" => "N",	// Тип кеширования
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_USE_GROUPS" => "N",	// Учитывать права доступа
		"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
		"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>