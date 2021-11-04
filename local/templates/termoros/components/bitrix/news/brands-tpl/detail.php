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

<div class="container">
		
			<?if(defined('LEFTBAR')):?>
			<div class='left_sidebar brands'>
				 <?/*$APPLICATION->IncludeComponent(
					"bitrix:menu",
					"catalog_left_menu_brands",
					Array(
						"ALLOW_MULTI_SELECT" => "N",
						"CHILD_MENU_TYPE" => "top",
						"COMPONENT_TEMPLATE" => "catalog_left_menu",
						"DELAY" => "N",
						"MAX_LEVEL" => "4",
						"MENU_CACHE_GET_VARS" => array(),
						"MENU_CACHE_TIME" => "3600",
						"MENU_CACHE_TYPE" => "N",
						"MENU_CACHE_USE_GROUPS" => "Y",
						"ROOT_MENU_TYPE" => "catalog",
						"USE_EXT" => "Y"
					)
				);*/?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:menu",
					"catalog_left_menu_brands",
					Array(
						"OPEN" => 'Y',
						"ALLOW_MULTI_SELECT" => "N",
						"CHILD_MENU_TYPE" => "top",
						"COMPONENT_TEMPLATE" => "catalog_left_menu",
						"DELAY" => "N",
						"MAX_LEVEL" => "4",
						"MENU_CACHE_GET_VARS" => array(),
						"MENU_CACHE_TIME" => "3600000000",
						"MENU_CACHE_TYPE" => "A",
						"MENU_CACHE_USE_GROUPS" => "Y",
						"ROOT_MENU_TYPE" => "catalog_brands",
						"USE_EXT" => "Y"
					)
				);?>
				<?

				if (strrpos($APPLICATION->GetCurDir(), '/filter/') !== false)
				{
					$pathsWithFilter = explode('/filter/', $APPLICATION->GetCurDir());
					$filterPath = $pathsWithFilter[1];
					$explodedPathsWithFilter = explode('/', $pathsWithFilter[0]);
					$sectionCode = array_pop($explodedPathsWithFilter);
				}
				else
				{
					$sectionCode = $paths[count($paths) - 2];
				}

				if ($sectionCode == null)
				{
					$paths = explode('/', $APPLICATION->GetCurDir());
					$url = $arResult["FOLDER"] . $paths[2] . '/'
						. getFirstSectionPathCodeByBrand(getBrandXmlIdByCode($paths[2]));
					//LocalRedirect($url);
				}
				
				//p($paths);
				?>
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
						"IBLOCK_ID" => '4',
						"IBLOCK_TYPE" => '1c_catalog',
						"INSTANT_RELOAD" => "Y",
						"PAGER_PARAMS_NAME" => '',
						"PRICE_CODE" => array("СлужебноеДляСайта (розничные цены)"),
						//"PRICE_CODE" => array("siteprice"),
						"SAVE_IN_SESSION" => "N",
						"SECTION_CODE" => $sectionCode,
						"SECTION_CODE_PATH" => "",
						"SECTION_DESCRIPTION" => "DESCRIPTION",
						"SECTION_TITLE" => "NAME",
						"SECTION_ID" => getSectionIdByCode($sectionCode),
						"TEMPLATE_THEME" => 'site',
						"XML_EXPORT" => "Y",
						"SEF_MODE" => "Y",
						"SEF_RULE" => $arResult["FOLDER"] . $paths[2] . '/'
							. '#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/',
						"SMART_FILTER_PATH" => $filterPath,
						"BRAND_CODE" => getBrandXmlIdByCode($paths[2]),
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
								"MENU_CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
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
			<div class='right_sidebar brands tech_page <?if(defined('FILTER')||defined('FILTERPRICE')):?>margin<?endif;?>'>
			
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

<?$ElementID = $APPLICATION->IncludeComponent(
	"bitrix:news.detail",
	"",
	Array(
		"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
		"DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
		"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
		"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"META_KEYWORDS" => $arParams["META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
		"SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
		"ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
		"DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
		"PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
		"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
		"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
		"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
		"USE_SHARE" => $arParams["USE_SHARE"],
		"SHARE_HIDE" => $arParams["SHARE_HIDE"],
		"SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
		"SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
		"SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
		"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
		"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : '')
	),
	$component
);?>
 <?
		if($_GET["sort"]<>"") {
			$_SESSION["SHOW_PARAM"]["SORT"] = $_GET["sort"];
			$sort=$_GET["sort"];
		}elseif($_SESSION["SHOW_PARAM"]["SORT"]=="")
		{
			//$sort="name";
			$sort = "PROPERTY_ABCXYZ_KLASSIFIKATSIYA_NOMENKLATURY";
			//$sort = "SORT";

		}else{
			$sort=$_SESSION["SHOW_PARAM"]["SORT"];
		}

			 if($_GET["order"]<>"") {
				 $_SESSION["SHOW_PARAM"]["ORDER"] = $_GET["order"];
				 $order=$_GET["order"];
			 }elseif($_SESSION["SHOW_PARAM"]["ORDER"]=="")
			 {

				 //$order= "ASC";
				 $order= 'asc,nulls';
			 }else{
				 $order=$_SESSION["SHOW_PARAM"]["ORDER"];
			 }

		if($_GET["view"]<>""){
			$_SESSION["SHOW_PARAM"]["COL"]=$_GET["view"];
		}
		elseif($_SESSION["SHOW_PARAM"]["COL"]=="")
		{
			$view="9";
		}
		
		if($_GET["mode"]<>""){
			$_SESSION["SHOW_PARAM"]["MODE"]=$_GET["mode"];
			$mode=$_SESSION["SHOW_PARAM"]["MODE"];
		}
		elseif($_SESSION["SHOW_PARAM"]["MODE"]!="")
		{
			$mode=$_SESSION["SHOW_PARAM"]["MODE"];
		}
		elseif($_SESSION["SHOW_PARAM"]["MODE"]=="")
		{
			$mode='list';
		}
		//var_dump($sort);
		//var_dump($order);
	if($_SESSION["SHOW_PARAM"]["COL"]=="180") {
		$view = "180"; //9999
	}elseif($_SESSION["SHOW_PARAM"]["COL"]<>""){
		$view = $_SESSION["SHOW_PARAM"]["COL"];
	}?>
	<?	
	$storeId = $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'];
	if (!$storeId) $storeId = 208;
	
	$arSort = array(
		"цене" => array(
			'sort' => 'CATALOG_PRICE_2',
			'order' => 'asc,nulls'
		),
		"распродажа" => array(
			'sort' => 'property_TMR_SALE',
			'order' => 'DESC'
		),
		"популярности" => array(
			'sort' => 'PROPERTY_ABCXYZ_KLASSIFIKATSIYA_NOMENKLATURY',
			'order' => 'asc,nulls'
		),
		/*"новизне" => array(
			'sort' => 'PROPERTY_NEW_TOV',
			'order' => 'DESC'
		),*/
		"артикулу" => array(
			'sort' => 'property_CML2_ARTICLE',
			'order' => 'asc,nulls'
		),
		"наличию" => array(
			'sort' => 'CATALOG_STORE_AMOUNT_'.$storeId,
			'order' => 'DESC'
		),
	);

		//p($sort);
		//p($order);

		$class2="asc";
		?>
		<div class='sorting_block'>
		<div class='sorting_wp'>
			<p class='name'>Сортировать по</p>
			<?foreach($arSort as $key=>$arsort){
			?>
				<?$class="";
				$ord="asc,nulls"?>
				<?if($_SESSION["SHOW_PARAM"]["SORT"]==$arsort["sort"])
					$class="active"?>
				<?if($_SESSION["SHOW_PARAM"]["ORDER"]=="asc,nulls"){
					$ord="desc";
					$class2="desc";
				}
	
			?>
				<a href='<?=$APPLICATION->GetCurPageParam("sort=".$arsort["sort"]."&order=".$ord,array("sort","order"));?>' class='<?=$class?> <?=$class2?>'><?=$key?></a>
				<?
			}?>
		</div>


		<div class='sorting_view'>
			<form method="get">
				<span class='name'>Выводить по</span>

				<select class='customSelect sort_sel' name="view">
					<option <?=$_SESSION["SHOW_PARAM"]["COL"]=="9"?"selected='selected'":""?>>9</option>
					<option <?=$_SESSION["SHOW_PARAM"]["COL"]=="18"?"selected='selected'":""?>>18</option>
					<option <?=$_SESSION["SHOW_PARAM"]["COL"]=="27"?"selected='selected'":""?>>27</option>
					<option <?=$_SESSION["SHOW_PARAM"]["COL"]=="180"?"selected='selected'":""?>>180</option>
				</select>
				<a href='<?=$APPLICATION->GetCurPageParam("mode=tile",array("mode"));?>' class='sv sv1 <?if($mode == 'tile'):?>active<?endif;?>'></a>
				<a href='<?=$APPLICATION->GetCurPageParam("mode=list",array("mode"));?>' class='sv sv2 <?if($mode == 'list'):?>active<?endif;?>'></a>
				<a href='<?=$APPLICATION->GetCurPageParam("mode=list2",array("mode"));?>' class='sv sv3 <?if($mode == 'list2'):?>active<?endif;?>'></a>
			</form>
		</div>
		<div class='clear'></div>
	</div>
<?
	global $BRAND_XMLID;
	global $BRAND_NAME;
	global $arrFilter;


	//p($BRAND_XMLID);
	//p($BRAND_NAME);
	//p($sectionCode);
	$SECTID = getSectionIdByCode($sectionCode);
	if(!$sectionCode) $SECTID = 0;
	
	
	//p($BRAND_XMLID);
	//$arFiltr['!DETAIL_PICTURE'] = false;
	global $arrFilter;
	$arrFilter['PROPERTY_BREND'] = getBrandXmlIdArrayByCode($paths[2]);
	//p($paths[2]);
	$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"tile", 
	array(
		//'BY_LINK' => 'Y',
		"MODE" => $mode,
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "list",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => $sort,
		"ELEMENT_SORT_ORDER" => $order,
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "1c_catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => $view,
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "СлужебноеДляСайта (розничные цены)",
			1 => "siteprice",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "CML2_ARTICLE",
			1 => "",
		),
		//"SECTION_CODE" => $sectionCode,
		"SECTION_ID" => $SECTID,
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N"
	),
	false
);?>

</div>
</div>
<div class='clear'></div>
</div>