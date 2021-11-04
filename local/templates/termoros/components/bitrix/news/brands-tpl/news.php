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

$paths = explode('/', $APPLICATION->GetCurDir());
if (count($paths) > 3)
{
	$arResult['VARIABLES']['ELEMENT_CODE'] = $paths[2];
	require_once 'detail.php';
	return;
}
?>
<div class="container">
		
			<?if(defined('LEFTBAR')):?>
			<div class='left_sidebar brands brands_list'>

				<?$APPLICATION->IncludeComponent(
					"redreams:catalog.smart.filter",
					"left_filter",
					Array(
						"CACHE_GROUPS" => "N",
						"CACHE_TIME" => '36000000',
						"CACHE_TYPE" => "A",
						"COMPONENT_TEMPLATE" => "visual_vertical",
						"CONVERT_CURRENCY" => "N",
						"CURRENCY_ID" => 'RUB',
						"DISPLAY_ELEMENT_COUNT" => "Y",
						"FILTER_NAME" => 'arrFilter',
						"FILTER_VIEW_MODE" => 'VERTICAL',
						"HIDE_NOT_AVAILABLE" => "N",
						"IBLOCK_ID" => $arParams['IBLOCK_ID'],
						"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
						"INSTANT_RELOAD" => "Y",
						"PAGER_PARAMS_NAME" => '',
						"PRICE_CODE" => array("СлужебноеДляСайта (розничные цены)"),
						//"PRICE_CODE" => array("siteprice"),
						"SAVE_IN_SESSION" => "N",
						"SECTION_CODE_PATH" => "",
						"SECTION_DESCRIPTION" => "DESCRIPTION",
						"SECTION_TITLE" => "NAME",
						"SECTION_ID" => 0,
						"TEMPLATE_THEME" => 'site',
						"XML_EXPORT" => "Y",
						"SEF_MODE" => "Y",
						"SEF_RULE" => $arResult["FOLDER"] . $paths[2] . '/'
							. '#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/',
						"SMART_FILTER_PATH" => $filterPath,
					),
					false,
					Array(
						'HIDE_ICONS' => 'N'
					)
				);?>

				<?if(!defined('NOMENU')):?>
				<div class='leftside_menu'>					
					<div class='lm_section <?if($APPLICATION->GetCurDir() == '/about_company/'):?>opened<?endif;?>'>
						<a href='' class='section_btn'>О компании</a>
						<?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
							"ROOT_MENU_TYPE" => "about",	// Тип меню для первого уровня
							"MAX_LEVEL" => "1",	// Уровень вложенности меню
							"CHILD_MENU_TYPE" => "about",	// Тип меню для остальных уровней
							"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
							"DELAY" => "N",	// Откладывать выполнение шаблона меню
							"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
							"MENU_CACHE_TYPE" => "A",	// Тип кеширования
							"MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
							"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
							"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
							"COMPONENT_TEMPLATE" => ".default"
							),
							false
						);?>
					</div>					
					<div class='lm_section <?if($APPLICATION->GetCurDir() == '/cooperation/'):?>opened<?endif;?>'>
						<a href='' class='section_btn '>Сотрудничество</a>
						<?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
							"ROOT_MENU_TYPE" => "cooperation",	// Тип меню для первого уровня
							"MAX_LEVEL" => "1",	// Уровень вложенности меню
							"CHILD_MENU_TYPE" => "cooperation",	// Тип меню для остальных уровней
							"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
							"DELAY" => "N",	// Откладывать выполнение шаблона меню
							"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
							"MENU_CACHE_TYPE" => "A",	// Тип кеширования
							"MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
							"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
							"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
							"COMPONENT_TEMPLATE" => ".default"
							),
							false
						);?>
					</div>					
					<div class='lm_section <?if($APPLICATION->GetCurDir() == '/buyers/'):?>opened<?endif;?>'>
						<a href='' class='section_btn '>Покупателям</a>
						<?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
							"ROOT_MENU_TYPE" => "buyers",	// Тип меню для первого уровня
							"MAX_LEVEL" => "1",	// Уровень вложенности меню
							"CHILD_MENU_TYPE" => "buyers",	// Тип меню для остальных уровней
							"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
							"DELAY" => "N",	// Откладывать выполнение шаблона меню
							"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
							"MENU_CACHE_TYPE" => "A",	// Тип кеширования
							"MENU_CACHE_TIME" => "36000000000",	// Время кеширования (сек.)
							"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
							"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
							"COMPONENT_TEMPLATE" => ".default"
							),
							false
						);?>
					</div>					
					<div class='lm_section <?if($APPLICATION->GetCurDir() == '/about_company/'):?>opened<?endif;?>'>
						<a href='' class='section_btn '>Услуги</a>
						<?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
							"ROOT_MENU_TYPE" => "services",	// Тип меню для первого уровня
							"MAX_LEVEL" => "1",	// Уровень вложенности меню
							"CHILD_MENU_TYPE" => "services",	// Тип меню для остальных уровней
							"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
							"DELAY" => "N",	// Откладывать выполнение шаблона меню
							"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
							"MENU_CACHE_TYPE" => "A",	// Тип кеширования
							"MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
							"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
							"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
							"COMPONENT_TEMPLATE" => ".default"
							),
							false
						);?>
					</div>					
					<div class='lm_section <?if($APPLICATION->GetCurDir() == '/technical_support/'):?>opened<?endif;?>'>
						<a href='' class='section_btn '>Техническая поддержка</a>
						<?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
							"ROOT_MENU_TYPE" => "support",	// Тип меню для первого уровня
							"MAX_LEVEL" => "1",	// Уровень вложенности меню
							"CHILD_MENU_TYPE" => "support",	// Тип меню для остальных уровней
							"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
							"DELAY" => "N",	// Откладывать выполнение шаблона меню
							"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
							"MENU_CACHE_TYPE" => "A",	// Тип кеширования
							"MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
							"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
							"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
							"COMPONENT_TEMPLATE" => ".default"
							),
							false
						);?>
					</div>
				</div>
				<?endif;?>
			</div>			
			<div class='right_sidebar tech_page <?if(defined('FILTER')||defined('FILTERPRICE')):?>margin<?endif;?>'>			
			
			<?endif;?>
		
				<div class="nav_block">
					<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "nav", Array(
						"COMPONENT_TEMPLATE" => ".default",
						"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
						"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
						"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
					),
						false
					);?>

					<h1><?$APPLICATION->ShowTitle(false)?></h1>
				</div>
				<?if(!defined('NOINNER')):?>
				<div class="inner_contentblock ">
				<?endif;?>
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
		"SET_STATUS_404" => 'N',
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
</div>
<div class='clear'></div>
</div>
