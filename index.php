<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Всё для систем отопления и водоснабжения — купить в интернет-магазине «Терморос» | Проектирование, монтаж и обслуживание инженерного оборудования");
$APPLICATION->SetPageProperty("description", "Компания «Терморос» предлагает купить всё необходимое для систем отопления и водоснабжения. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetPageProperty("keywords", "все для отопления магазин");
$APPLICATION->SetTitle("Терморос");
?>
<?$APPLICATION->IncludeComponent(
	"infoday:advertising.banner",
	"main_baner",
	Array(
		"CACHE_TIME" => "3600000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "main_baner",
		"NOINDEX" => "N",
		"QUANTITY" => "10",
		"TYPE" => "MAIN"
	)
);?>

<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"midle_menu",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "support",
		"COMPONENT_TEMPLATE" => "midle_menu",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(),
		"MENU_CACHE_TIME" => "3600000000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "N",
		"ROOT_MENU_TYPE" => "services",
		"USE_EXT" => "Y"
	)
);?>

<?
global $portfolioFilter;
$portfolioFilter["PROPERTY_SHOW_MP_VALUE"] = 'Y';
?>
<?if(!isMob()){$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "portfolio-tpl",
    Array(
        "ACTION_VARIABLE" => "action",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BASKET_URL" => "/personal/basket.php",
        "BROWSER_TITLE" => "-",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => "sect-tpl",
        "CONVERT_CURRENCY" => "N",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_COMPARE" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_SORT_FIELD" => "SORT",
        "ELEMENT_SORT_FIELD2" => "",
        "ELEMENT_SORT_ORDER" => "DESC",
        "ELEMENT_SORT_ORDER2" => "",
        "FILTER_NAME" => "portfolioFilter",
        "HIDE_NOT_AVAILABLE" => "N",
        "IBLOCK_ID" => "14",
        "IBLOCK_TYPE" => "services",
        "INCLUDE_SUBSECTIONS" => "Y",
        "LINE_ELEMENT_COUNT" => "1",
        "MAIN" => "Y",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "META_DESCRIPTION" => "",
        "META_KEYWORDS" => "",
        "OFFERS_CART_PROPERTIES" => array(),
        "OFFERS_FIELD_CODE" => array(),
        "OFFERS_LIMIT" => "0",
        "OFFERS_PROPERTY_CODE" => array(),
        "OFFERS_SORT_FIELD" => "shows",
        "OFFERS_SORT_FIELD2" => "shows",
        "OFFERS_SORT_ORDER" => "asc",
        "OFFERS_SORT_ORDER2" => "asc",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "",
        "PAGER_TITLE" => "Товары",
        "PAGE_ELEMENT_COUNT" => "9",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRICE_CODE" => array(),
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPERTIES" => array(),
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "",
        "PRODUCT_SUBSCRIPTION" => "N",
        "PROPERTY_CODE" => array('FILES'),
        "SECTION_CODE" => "",
        "SECTION_ID" => "0",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SECTION_URL" => "",
        "SECTION_USER_FIELDS" => array(),
        "SET_BROWSER_TITLE" => "Y",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_ALL_WO_SECTION" => "Y",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "TEMPLATE_THEME" => "",
        "USE_PRICE_COUNT" => "N",
        "USE_PRODUCT_QUANTITY" => "N"
    )
);}?>

<?if(!isMob()){?>
<div class="main_articles">
	<div class="container">
        <div class="row">
            <a class="col-12" href="/promotion_materials/video/"><h3 class="h4">Терморос Media</h3></a>
            <div class="ma_left col-6 p-0">
                <div>
                    <?
                    $cache = Bitrix\Main\Data\Cache::createInstance();
                    if ($cache->initCache("30000000", "main_iframe", "main_iframe"))
                    {
                        $resIframe = $cache->getVars();
                    }
                    elseif ($cache->startDataCache())
                    {
                        $resIframe = \Bitrix\Iblock\ElementTable::getList(array(
                            'order' => array('ID' => 'DESC'),
                            'filter' => array("IBLOCK_ID" => 32, "ACTIVE" => "Y"),
                            'select' => array('PREVIEW_TEXT'),
                            'limit' => 5,
                        ))->fetchAll();

                        $cache->endDataCache($resIframe);
                    }

                    $newWidth = 620;
                    $newHeight = 320;

                    foreach($resIframe as $k => $video)
                    {
                        if (!$k) $active = 'active';
                        else $active = 'hidden';

                        $content = preg_replace(
                            array('/<iframe/i','/src=/i','/width="\d+"/i', '/height="\d+"/i'),
                            array('<iframe class="lozad"','data-src=',sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),
                            $video["PREVIEW_TEXT"]);

                        echo '<div data-id="'.($k+1).'" class="video-slider-content '.$active.'">'.$content.'</div>';
                    }
                    ?>
                </div>
                <div style="width: 100%; text-align: center;">
                    <a class="video-slider-link active" data-id="1" href="#"><img src="/local/templates/termoros/img/num_bg2.png" class="video-slider-img"></a> <a class="video-slider-link" data-id="2" href="#"><img src="/local/templates/termoros/img/num_bg.png" class="video-slider-img"></a> <a class="video-slider-link" data-id="3" href="#"><img src="/local/templates/termoros/img/num_bg.png" class="video-slider-img"></a> <a class="video-slider-link" data-id="4" href="#"><img src="/local/templates/termoros/img/num_bg.png" class="video-slider-img"></a> <a class="video-slider-link" data-id="5" href="#"><img src="/local/templates/termoros/img/num_bg.png" class="video-slider-img"></a>
                </div>
            </div>
            <div class="ma_right col-6 p-0">
                <?
                $news = \Bitrix\Iblock\ElementTable::getList(array(
                    'order' => array('ACTIVE_FROM' => 'DESC'),
                    'select' => array("NAME","PREVIEW_TEXT","ACTIVE_FROM"),
                    'filter' => array('IBLOCK_ID' => 12, "ACTIVE"=>"Y"),
                    'cache' => array('ttl' => 86400,'cache_joins' => true),
                    'limit' => 1
                ))->fetchAll();?>
                <div class="ma_block news col-6">
                    <a class="termoros-media-btn-link" href="/news/"><span class="label">новости</span></a> <a href="/news/">
                        <p class="ttl"><?=$news[0]["NAME"]?></p>
                    </a><br>
                    <p class="txt hm"><?=$news[0]["PREVIEW_TEXT"]?></p>
                    <p class="date hm"><?=CIBlockFormatProperties::DateFormat("j F Y", MakeTimeStamp($news[0]["ACTIVE_FROM"], CSite::GetDateFormat()));?></p>
                </div>
                <?
                $promo = \Bitrix\Iblock\ElementTable::getList(array(
                    'order' => array('ACTIVE_FROM' => 'DESC'),
                    'select' => array("NAME","PREVIEW_TEXT","ACTIVE_FROM"),
                    'filter' => array('IBLOCK_ID' => 5, "ACTIVE"=>"Y"),
                    'cache' => array('ttl' => 86400,'cache_joins' => true),
                    'limit' => 1
                ))->fetchAll();
                ?>
                <div class="ma_block news col-6">
                    <a class="termoros-media-btn-link" href="/buyers/promotions/"><span class="label">акции</span></a> <a href="/buyers/promotions/">
                        <p class="ttl"><?=$promo[0]["NAME"]?></p>
                    </a><br>
                    <p class="txt hm"><?=$promo[0]["PREVIEW_TEXT"]?></p>
                    <p class="date hm"><?=CIBlockFormatProperties::DateFormat("j F Y", MakeTimeStamp($promo[0]["ACTIVE_FROM"], CSite::GetDateFormat()));?></p>
                </div>
            </div>
        </div>
	</div>
</div>
<?}?>

<div class="about_maintxt container my-3">
	<div class="row">
		<h1 class="h4 col-12 text-center">Всё для систем отопления и водоснабжения в интернет-магазине «Терморос»</h1>
        <div class="col-6">
            <p>
                Группа компаний «Терморос» более 25 лет реализует на рынке России и Армении широкий спектр инженерного оборудования и комплектующих для систем и трубопроводов с различными техническими характеристиками. Нашими поставщиками являются более 50 мировых производителей, среди которых известные бренды: Jaga, FAR, BAXI, Danfoss, Purmo, Gekon, Reflex и другие. Офисы и склады группы компании расположены в 9 крупнейших городах России, а сеть сервисных центров охватывает более 220 населенных пунктов РФ. Это делает нас доступными для клиентов и дает возможность выполнять заказы в сжатые сроки.
            </p>
            <p>
                Кроме того, мы имеем лицензии и разрешения на проведение широкого спектра проектных, строительных и монтажных работ. Наша цель заключается в содействии реализации программ по энергосбережению, внедрении и развитии технологических инноваций, создании эффективных и безопасных инженерных систем.
            </p>
        </div>
        <div class="col-6">
            <p>Ассортимент оборудования:</p>
            <ul id="main_page_descr_ul">
                <li>Приборы отопления: радиаторы, конвекторы, полотенцесушители.</li>
                <li>Котельное оборудование: газовые, твердотопливные, электрические, дизельные и другие котлы, водонагреватели проточного и накопительного типа, мембранные баки, горелки, дымоходы.</li>
                <li>Насосы для бытовых и промышленных систем водоснабжения и канализации.</li>
                <li>Приборы учета и КИП: тепловые и водяные счетчики, термометры, манометры.</li>
                <li>Арматура, комплектующие для трубопроводов, запасные части для приборов отопления и других устройств.</li>
            </ul>
            <p>Вся продукция сертифицирована, поставляется с заводской гарантией.</p>
        </div>
	</div>
</div>
	<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"brands",
	Array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "brands",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"DETAIL_PICTURE",1=>"",),
		"FILTER_NAME" => "arrNews",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "17",
		"IBLOCK_TYPE" => "references",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "16",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_BOTTOM" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"",1=>"TYPE",2=>"",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC"
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>