<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('main');
CModule::IncludeModule('iblock');
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:search.title",
	"search",
	array(
		"NUM_CATEGORIES" => "7",
		"TOP_COUNT" => "7",
		"CHECK_DATES" => "N",
		"SHOW_OTHERS" => "N",
		"PAGE" => "/catalog/",
		"CATEGORY_1_TITLE" => "Каталог продукции",
		"CATEGORY_1" => array(
			0 => "iblock_1c_catalog",
		),
		"CATEGORY_1_iblock_catalog" => array(
			0 => "all",
		),
		"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "search",
		"SHOW_PREVIEW" => "Y",
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"CONVERT_CURRENCY" => "Y",
		"COMPONENT_TEMPLATE" => "search",
		"ORDER" => "rank",
		"USE_LANGUAGE_GUESS" => "N",
		"PRICE_VAT_INCLUDE" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"CURRENCY_ID" => "RUB",
		"CATEGORY_0_TITLE" => "Бренды",
		"CATEGORY_0" => array(
			0 => "iblock_references",
		),
		"CATEGORY_0_iblock_references" => array(
			0 => "17",
		),
		"CATEGORY_1_iblock_1c_catalog" => array(
			0 => "all",
		),
		/*
		"CATEGORY_2_TITLE" => "Магазины",
		"CATEGORY_2" => array(
			0 => "iblock_services",
		),
		"CATEGORY_2_iblock_services" => array(
			0 => "18",
		),
		*/
		"CATEGORY_3_TITLE" => "Портфолио",
		"CATEGORY_3" => array(
			0 => "iblock_services",
		),
		"CATEGORY_3_iblock_services" => array(
			0 => "14",
		),
		"CATEGORY_4_TITLE" => "Видео",
		"CATEGORY_4" => array(
			0 => "iblock_services",
		),
		"CATEGORY_4_iblock_services" => array(
			0 => "24",
		),
		/*
		"CATEGORY_5_TITLE" => "Контакты",
		"CATEGORY_5" => array(
			0 => "iblock_services",
		),
		"CATEGORY_5_iblock_services" => array(
			0 => "22",
		),
		*/
		"CATEGORY_6_TITLE" => "События",
		"CATEGORY_6" => array(
			0 => "iblock_news",
		),
		"CATEGORY_6_iblock_news" => array(
			0 => "12",
			1 => "16",
			2 => "21",
		),
	),
	false
);?>