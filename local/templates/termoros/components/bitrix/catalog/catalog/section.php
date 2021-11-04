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
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Page\Asset;

$this->setFrameMode(true);

$isSales = $arResult["VARIABLES"]["SECTION_CODE"] == 'sales';
/*
if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
*/
$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');

if ($isFilter)
{
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);
	
	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
	{
		$arCurSection = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		$arCurSection = array();
		if (Loader::includeModule("iblock"))
		{
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurSection = $dbRes->Fetch())
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurSection = $dbRes->Fetch())
					$arCurSection = array();
			}
		}
		$obCache->EndDataCache($arCurSection);
	}
	if (!isset($arCurSection))
		$arCurSection = array();
}

// sales & filter
if ($isSales) $_SESSION['arrFilter']['GLOBAL_SALES'] = 'Y';
if(strpos($APPLICATION->GetCurUri(""),"/filter/clear/apply/") !== false) unset($_SESSION['arrFilter']);
if ($_SESSION['arrFilter']['GLOBAL_SALES'] == 'Y') $_SESSION['arrFilter'][$arCurSection['ID']]['arrFilter_729_2212294583'] = "Y";


//Gekon внутрипольные
if ($APPLICATION->GetCurPage() == '/catalog/pribory_otopleniya/konvektor/medno_alyuminievyy_vnutripolnyy/filter/brend-is-524dfe7d-ce74-11e5-80d6-0cc47a1d8513/apply/')
{
	require_once($_SERVER['DOCUMENT_ROOT'] . '/catalog/gekon_convectors/index.php');
	die();
}

if ($arCurSection['ID'] && !($_GET['PAGEN_1'] || $_GET['PAGEN_2']))
{
	$rsSection = CIBlockSection::GetList(array(), array("IBLOCK_ID"=>4, "ID"=>$arCurSection['ID']),false, array("ID","IBLOCK_ID","CODE","IBLOCK_SECTION_ID","NAME","DESCRIPTION","UF_*"), false);
	$s = $rsSection->GetNext();

	
	$urlRawArr = explode("/", trim($APPLICATION->GetCurPage(), "/"));
	if ($s["CODE"] == $urlRawArr[count($urlRawArr)-1])
	{
		$textBefore = $s["~UF_CATALOG_TEXT_B"];
		$textEnd = $s["~UF_CATALOG_TEXT_E"];
	}
	
}

$pathArr = explode("/",$arResult["VARIABLES"]["SMART_FILTER_PATH"]);


//SEO for section+brand

if (!$_REQUEST['set_filter'] && $arCurSection['ID'] && substr($pathArr[0], 0, 9) == 'brend-is-' && strlen($pathArr[0])==45 && !($_GET['PAGEN_1'] || $_GET['PAGEN_2']))
{
	$brandXML_ID = substr($pathArr[0], 9);

	$hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
	\Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData);
	
	$propertyBrandName = BrendTable::getList([
		'select' => ['UF_NAME'],
		'filter' => ['UF_XML_ID' => $brandXML_ID]
	])->fetch()['UF_NAME'];
	
	//v($propertyBrandName);
	if (substr($propertyBrandName, 0, 5) == 'Gekon') $propertyBrandName = 'Gekon';
	
	$res = CIblockElement::GetList(
		array(),
		array("IBLOCK_ID" => 17, "ACTIVE" => "Y", "NAME" => $propertyBrandName),
		false,
		false,
		array()
	);
	$brand = $res->GetNext();
		
	if ($brand["ID"])
	{
		$res = CIblockElement::GetList(
			array(),
			array("IBLOCK_ID" => 30, "ACTIVE" => "Y", "PROPERTY_BRAND_ID" => $brand["ID"], "PROPERTY_SECTION_ID" => $arCurSection['ID']),
			false,
			false,
			array('*', 'PROPERTY_H1', 'PROPERTY_DESCRIPTION', 'PROPERTY_KEYWORDS', 'PROPERTY_TEXT_BEFORE', 'PROPERTY_TEXT_AFTER')
		);
		$seoBrandSection = $res->GetNext();
		//v($seoBrandSection);
		if ($seoBrandSection['PROPERTY_H1_VALUE']) $newH1 = $seoBrandSection["PROPERTY_H1_VALUE"];
		if ($seoBrandSection['NAME']) $newTitle = $seoBrandSection["NAME"];
		if ($seoBrandSection["PROPERTY_DESCRIPTION_VALUE"]) $newDescription = $seoBrandSection["PROPERTY_DESCRIPTION_VALUE"];
		if ($seoBrandSection["PROPERTY_KEYWORDS_VALUE"]) $newKeyWords = $seoBrandSection["PROPERTY_KEYWORDS_VALUE"];
		if ($seoBrandSection["~PROPERTY_TEXT_BEFORE_VALUE"]) $textBefore = $seoBrandSection["~PROPERTY_TEXT_BEFORE_VALUE"];
		if ($seoBrandSection["~PROPERTY_TEXT_AFTER_VALUE"]) $textEndSeo = $seoBrandSection["~PROPERTY_TEXT_AFTER_VALUE"];
		
	}
}

//var_dump(\Bitrix\Iblock\Iblock::wakeUp(37)->getEntityDataClass());
$uri = $APPLICATION->GetCurPage();
$SEOFORPAGES = \Bitrix\Iblock\Elements\ElementSEOFORPAGESTable::getList([
    'filter' => ['=ACTIVE' => 'Y',"NAME" => $uri],
    'select' => ['ID','NAME','TITLE_' => 'TITLE','KEYWORDS_' => 'KEYWORDS','DESCRIPTION_' => 'DESCRIPTION','H1_' => 'H1',
        'TEXT_BEFORE_' => 'TEXT_BEFORE','TEXT_AFTER_' => 'TEXT_AFTER',
        ],
    'cache' => array('ttl' => 2592000,'cache_joins' => true)
])->fetchAll();
if($SEOFORPAGES[0]) $SEOFORPAGES = $SEOFORPAGES[0];

if ($SEOFORPAGES) {
	if ($SEOFORPAGES["H1_VALUE"]) $APPLICATION->SetTitle($SEOFORPAGES["H1_VALUE"]);
	if ($SEOFORPAGES["TITLE_VALUE"]) $APPLICATION->SetPageProperty("title", $SEOFORPAGES["TITLE_VALUE"]);
	if ($SEOFORPAGES["KEYWORDS_VALUE"]) $APPLICATION->SetPageProperty("keywords", $SEOFORPAGES["KEYWORDS_VALUE"]);
	if ($SEOFORPAGES["DESCRIPTION_VALUE"]) $APPLICATION->SetPageProperty("description", $SEOFORPAGES["DESCRIPTION_VALUE"]);
	if ($SEOFORPAGES["TEXT_BEFORE_VALUE"]) $textBefore = $SEOFORPAGES["TEXT_BEFORE_VALUE"];
	if ($SEOFORPAGES["TEXT_AFTER_VALUE"]) $textEndSeo = $SEOFORPAGES["TEXT_AFTER_VALUE"];
}
//var_dump($_SESSION['arrFilter']);
?>
<div class="container">
    <div class="list_page row">
        <div class="nav_block col-12 mx-2">
            <?$APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "nav",
                Array(
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0"
                )
            );?>
        </div>
        <div class="left_sidebar col-12 col-md-3">
             <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "catalog_left_menu",
                Array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "top",
                    "COMPONENT_TEMPLATE" => "catalog_left_menu",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "4",
                    "MENU_CACHE_GET_VARS" => array(),
                    "MENU_CACHE_TIME" => "3600000000",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "catalog",
                    "USE_EXT" => "Y",
                    "IS_SALE" => $isSales
                )
            );?>
        <?//v($arResult["VARIABLES"]);?>


        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            "",// .default,.default_old,left_filter,visual_vertical,bootstrap_v4
            Array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "SECTION_ID" => $arCurSection['ID'],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "PRICE_CODE" => $arParams["FILTER_PRICE_CODE"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SAVE_IN_SESSION" => "Y",
                "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                "XML_EXPORT" => "N",
                "SECTION_TITLE" => "NAME",
                "SECTION_DESCRIPTION" => "DESCRIPTION",
                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                "TEMPLATE_THEME" => "blue",
                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                "SEF_MODE" => $arParams["SEF_MODE"],
                "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                "POPUP_POSITION" => "right",
            ),
        $component
        );?>

        </div>
        <div class="right_sidebar col-12 col-md-9">
            <div class="col-12">
                <h1><?$APPLICATION->ShowTitle(false)?></h1>
            </div>
            <? if ($textBefore) { ?>
                <div style="text-align: justify;"><?=$textBefore?></div><br>
            <? } ?>
            <?
            if($_GET["sort"]<>"") {
                $_SESSION["SHOW_PARAM"]["SORT"] = $_GET["sort"];
                $sort=$_GET["sort"];
            }elseif($_SESSION["SHOW_PARAM"]["SORT"]=="")
            {
                //$sort="name";
                //$sort = "PROPERTY_TOP_TOV";
                //$sort = "PROPERTY_TMR_SALE";
                //$sort = "PROPERTY_NOZ";
                $sort = "PROPERTY_ABCXYZ_KLASSIFIKATSIYA_NOMENKLATURY";

            }else{
                $sort=$_SESSION["SHOW_PARAM"]["SORT"];
            }

             if($_GET["order"]<>"") {
                 $_SESSION["SHOW_PARAM"]["ORDER"] = $_GET["order"];
                 $order=$_GET["order"];
             }elseif($_SESSION["SHOW_PARAM"]["ORDER"]=="")
             {

                 //$order= "ASC";
                 //$order= "DESC";
                 $order= 'asc,nulls';
             }else{
                 $order=$_SESSION["SHOW_PARAM"]["ORDER"];
             }

            if($_GET["view"]<>""){
                $_SESSION["SHOW_PARAM"]["COL"]=$_GET["view"];
            }
            elseif($_SESSION["SHOW_PARAM"]["COL"]=="")
            {
                $view="18";
                $_SESSION["SHOW_PARAM"]["COL"] = $view;
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

        if($_SESSION["SHOW_PARAM"]["COL"]=="180") {
            $view = "180"; //9999
        }elseif($_SESSION["SHOW_PARAM"]["COL"]<>""){
            $view = $_SESSION["SHOW_PARAM"]["COL"];
        }

        ?>
        <?
            $storeId = $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'];
            if (!$storeId) $storeId = 208;
            $arSort = array(
            "цене" => array(
                'sort' => 'catalog_PRICE_2',
                'order' => 'asc,nulls'
            ),
            "распродажа" => array(
                'sort' => 'property_NOZ',
                'order' => 'asc,nulls'
            ),
            "популярности" => array(
                //'sort' => 'PROPERTY_TOP_TOV',
                //'sort' => 'SHOWS',

                //'sort' => 'SORT',
                //'order' => 'DESC'

                'sort' => 'PROPERTY_ABCXYZ_KLASSIFIKATSIYA_NOMENKLATURY',
                'order' => 'asc,nulls'
            ),
            /*"новизне" => array(
                'sort' => 'PROPERTY_NEW_TOV',
                'order' => 'DESC'
            ),*/
            /*
            "названию" => array(
                'sort' => 'NAME',
                'order' => 'ASC'
            ),
            */
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
            $sort2 = "PROPERTY_ABCXYZ_KLASSIFIKATSIYA_NOMENKLATURY";
            $order2 = 'asc,nulls';

            if(\Redreams\Partners\partner::isPartner()) $partnerID = $USER->GetID();

            $intSectionID = $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "tile",
                array(
                    "MODE" => $mode,
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "ELEMENT_SORT_FIELD" => $sort,
                    "ELEMENT_SORT_ORDER" => $order,
                    "ELEMENT_SORT_FIELD2" => $sort2,
                    //"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                    "ELEMENT_SORT_ORDER2" => $order2,
                    //"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                    "BASKET_URL" => $arParams["BASKET_URL"],
                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "MESSAGE_404" => $arParams["MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                    "PAGE_ELEMENT_COUNT" => $view,
                    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

                    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                    "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                    "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

                    'LABEL_PROP' => $arParams['LABEL_PROP'],
                    'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

                    'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                    'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
                    'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
                    'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
                    'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
                    'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

                    'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                    "ADD_SECTIONS_CHAIN" => "Y",
                    'ADD_TO_BASKET_ACTION' => $basketAction,
                    'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                    'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
                    'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                    'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
                    'PARTNER' => $partnerID,
                    "SHOW_ALL_WO_SECTION" => $arParams["SHOW_ALL_WO_SECTION"]
                ),
                $component
            );?>

            <? if ($textEndSeo) { ?>
                <div class="catalog_text_end">
                <?=$textEndSeo?><br>
                </div>
            <? } elseif ($textEnd) { ?>
                <?
                $h1 = $APPLICATION->GetTitle();
                $textEnd = str_replace('#H1#', $h1, $s["~UF_CATALOG_TEXT_E"]);
                ?>
                <div class="catalog_text_end">
                <?=$textEnd?><br>
                </div>
            <? } ?>
        </div>
    </div>
</div>
<?
if ($newH1)
{
	$APPLICATION->SetTitle($newH1);
}

if ($newTitle) 
{
	$APPLICATION->SetPageProperty("title", $newTitle);
	
}

if ($newDescription)
{
	$APPLICATION->SetPageProperty("description", $newDescription);
}
?>