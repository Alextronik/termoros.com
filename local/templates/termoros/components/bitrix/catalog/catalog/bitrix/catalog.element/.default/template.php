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
$templateLibrary = array('popup');
$currencyList = '';

//p($arResult["PROPERTIES"]["MORE_PHOTO"]);
?>

<div class='container'>

	<div class='nav_block'>
		<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "nav", Array(
			"COMPONENT_TEMPLATE" => ".default",
			"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
			"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
			"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
		),
			false
		);?>

	</div>

	<div class='detail_page'>
		<div class='det_left'>

			<div class='detpage_im'>
<?

	if($arResult["DETAIL_PICTURE"]['ID']){
		$foto[]=array(
			"BIG"=>CFile::ResizeImageGet($arResult["DETAIL_PICTURE"]["ID"], array('width'=>445, 'height'=>445), BX_RESIZE_IMAGE_PROPORTIONAL  , true),
			"PREV"=>CFile::ResizeImageGet($arResult["DETAIL_PICTURE"]["ID"], array('width'=>137, 'height'=>137), BX_RESIZE_IMAGE_PROPORTIONAL  , true)
		);
	}else if($arResult["PREVIEW_PICTURE"]['ID']){
		$foto[]=array(
			"BIG"=>CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"]["ID"], array('width'=>445, 'height'=>445), BX_RESIZE_IMAGE_PROPORTIONAL  , true),
			"PREV"=>CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"]["ID"], array('width'=>137, 'height'=>137), BX_RESIZE_IMAGE_PROPORTIONAL  , true)
		);
	}
	else
	{
		$foto[]=array("BIG"=>array('src'=>SITE_TEMPLATE_PATH."/img/no-foto-big.jpg"));
	}

	foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $fotoID){
		$foto[]=array(
			"BIG"=>CFile::ResizeImageGet($fotoID, array('width'=>445, 'height'=>445), BX_RESIZE_IMAGE_PROPORTIONAL  , true),
			"PREV"=>CFile::ResizeImageGet($fotoID, array('width'=>137, 'height'=>137), BX_RESIZE_IMAGE_PROPORTIONAL  , true)
		);
	}


?>
				<div class="im_area">
					<?if($arResult["PROPERTIES"]["NEW_TOV"]["VALUE"]=="Y"){?>
						<div class="new_label"></div>
					<?}elseif($arResult["PROPERTIES"]["TOP_TOV"]["VALUE"]=="Y"){
						?><div class="hit_label"></div><?
					}?>

					<?foreach($foto as $key=>$arFoto){?>
					<div class="fullimgitem" id="big_detailimg<?=$key?>" <?=$key==0?'style="display:block;"':''?>>
						<img src="<?=$arFoto["BIG"]["src"]?>">
					</div>

					<?}?>

				</div>
				<?if(count($foto)>1){?>
				<div class='thumb_wp'>
					<ul class="im_thumbs ">
						<?foreach($foto as $key=>$arFoto){?>
							<li data-id="<?=$key?>" class="previtem <?=$key==0?'style="active"':''?>">
								<img src="<?=$arFoto["PREV"]["src"]?>">
							</li>
						<?}?>
					</ul>
					<a href='' class='dt_prev'></a>
					<a href='' class='dt_next'></a>
				</div>
	<?}?>

			</div>

			<!--<div class='det_share'>
				<p class='name'>Поделиться</p>
				<img src='img/det_share.png'>
			</div>-->

		</div>

		<div class='det_right'>
			<a href='' class='print'></a>
			<h1><?=$arResult["NAME"]?></h1>

			<p class='code'>Артикул: <?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></p>

			<div class='chars'>
				<p class='ttl'>Технические характеристики <a href="#tech" class='more'>Подробнее</a></p>
				<?
				$colvo=0;
				$upBrend = true;
				?>
<?foreach($arResult["DISPLAY_PROPERTIES"] as $prop) { ?>
	<? if ($prop["VALUE"] != "") {
		$upBrend = false;
		?>
		<div class='char_line'>
			<p class='name'><span><?= $prop["NAME"] ?></span></p>
			<p class='value'><?= $prop["VALUE"] ?></p>
		</div>
	<?$colvo++;
	}
	if($colvo==5){
		break;
	}
}?>
				<!--<a href=''><img src='img/br_logo.png' class='item_logo'></a>-->
			</div>

<!--
			<select class='customSelect det_select size'>
				<option>Выберите размер</option>
				<option>Выберите размер 2</option>
				<option>Выберите размер 3</option>
			</select>

			<select class='customSelect det_select prop'>
				<option>Пропускная способность</option>
				<option>Пропускная способность 2</option>
				<option>Пропускная способность 3</option>
			</select>
			-->
			<div class='clear'></div>
			<div class='det_delivery'>
				<div class='dd_left'>
					<p class='ttl'>Наличие</p>
					<!--<p class='loc'>г. Москва и Московская обл.<a href=''>изменить</a></p>-->
					<?if($arResult["CATALOG_QUANTITY"]>0){
						?>
							<p class='nal'>В наличии: <?=$arResult["CATALOG_QUANTITY"]?> <?=$arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?></p>
						<?
					}else{
						?>
						<p class='nal'>Нет в наличии</p>
						<?
					}?>
					<!--<p class='i'>15 шт.   доставка 15.01.2016</p>
					<p class='i'>15 шт.   доставка 25.01.2016</p>-->
				</div>

				<div class='dd_right'>
					<p class='txt'>Подробную информацию о наличии можно получить у оператора:</p>
					<p class='phone'>+7 (495) 785 55 00  |  +7 (499) 500 00 01 </p>
					<!--<a href='' class='del_time'>Условия и сроки поставки</a>-->
				</div>
				<div class='clear'></div>
			</div>

			<div class='price_wp'>
				<p class='price'>

					<?=$arResult["MIN_PRICE"]["VALUE"]?><span class='vl'>руб.</span>
					<!--<span class='oldprice'>23 234</span>-->
				</p>
				<form class="ADD2BASKET" action="ADD2BASKET" method="POST" style="display: inline-block;">

						<input type='hidden' name="action" value='ADD2BASKET' />
						<input type='hidden' name="id" value='<?=$arResult['ID']?>' />

						<div class='num_wp'>
							<input type='text' name="quantity" class='inp_self' value='1'>
							<span><?=$arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?></span>
						</div>

						<a href='<?=$arResult['ADD_URL']?>' class='to_basket'>в корзину</a>

				</form>

				<!--<a href='' class='to_fav'></a>
				<a href='' class='to_compare'></a>-->

				<p class='tech_i'>Технические характеристики и внешний вид товара могут отличаться, просьба уточнять у менеджера</p>
			</div>

			<!--<div class='pay_del'>
				<p class='ttl'>Оплата и доставка</p>
				<select class='customSelect det_select city'>
					<option>Москва</option>
					<option>Москва 2</option>
					<option>Москва 3</option>
				</select>

				<p class='i'>Ориентировочный срок и стоимость доставки   товаров в наличии:</p>
				<p class='days'>15 дней  |  350 руб.</p>

			</div>-->

		</div>

		<div class='clear'></div>
		<div class='det_chars_wp'>
			<ul class='chars_links'>
				<li class='active'><a href=''>Характеристики</a></li>
				<?/*<li><a href=''>Документация</a></li>*/?>
				<li><a href=''>С данным товаром покупают</a></li>
				<?
				if($arResult["PROPERTIES"]["ANALOGIC"]["VALUE"])
				{
					?><li><a href=''>Аналоги</a></li><?
				}
				?>

			</ul>

			<ul class='chars_thumbs'>
				<li class='active'>

					<div class='chars_th'>
						<a name="tech"></a>
						<p class='ttl'>Технические характеристики</p>
						<table class='char_table'>
							<?foreach($arResult["DISPLAY_PROPERTIES"] as $prop) { ?>
								<? if ($prop["VALUE"] <> "") { ?>
									<tr>
										<td><?= $prop["NAME"] ?></td>
										<td><?= $prop["VALUE"] ?></td>
									</tr>
									<?}
							}?>

						</table>
						<p class='txt'><?=$arResult['DETAIL_TEXT']?></p>

					</div>

				</li>

				<?/*<li>

					<div class='tech_documentation'>

						<table class='tech_table'>
							<tr>
								<td class='inp'>
									<input type='checkbox' class='customCheckbox'>
									<label>Инструкция на редуктор давления</label>
								</td>

								<td class='type'>
									.pdf
								</td>

								<td class='size'>
									3.1 Мб
								</td>

								<td class='action'>
									<a href='' class='download'></a>
								</td>
							</tr>
							<tr>
								<td class='inp'>
									<input type='checkbox' class='customCheckbox'>
									<label>Буклет FAR</label>
								</td>

								<td class='type'>
									.pdf
								</td>

								<td class='size'>
									3.1 Мб
								</td>

								<td class='action'>
									<a href='' class='download'></a>
								</td>
							</tr>
							<tr>
								<td class='inp'>
									<input type='checkbox' class='customCheckbox'>
									<label>Таблица размеров модели</label>
								</td>

								<td class='type'>
									.pdf
								</td>

								<td class='size'>
									3.1 Мб
								</td>

								<td class='action'>
									<a href='' class='download'></a>
								</td>
							</tr>
							<tr>
								<td class='inp'>
									<input type='checkbox' class='customCheckbox'>
									<label>Каталог продукции FAR</label>
								</td>

								<td class='type'>
									.pdf
								</td>

								<td class='size'>
									3.1 Мб
								</td>

								<td class='action'>
									<a href='' class='download'></a>
								</td>
							</tr>
						</table>

						<div class='inp_wrap'>
							<input type='checkbox' class='customCheckbox'>
							<label>Выбрать все</label>
						</div>
						<a href='' class='down_selected'>скачать выбранные</a>
						<div class='clear'></div>
					</div>

				</li>*/?>

				<li class="with">

						<?global $TopFilter;
						
						?>
						<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"list", 
	array(
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
		"ELEMENT_SORT_FIELD" => "rand",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "TopFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "1c_catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "4",
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
		"PAGE_ELEMENT_COUNT" => "4",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "#СлужебноеДляСайта## (розничные цены)",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SECTION_CODE" => "",
		"SECTION_ID" => "",
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

				</li>
<?
if($arResult["PROPERTIES"]["ANALOGIC"]["VALUE"])
{
	?>
				<li class="analogs">
				
						<?global $TopFilter;
						$TopFilter=array("ID"=>$arResult["PROPERTIES"]["ANALOGIC"]["VALUE"])
						?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:catalog.section", 
							"list", 
							array(
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
								"ELEMENT_SORT_FIELD" => "sort",
								"ELEMENT_SORT_FIELD2" => "id",
								"ELEMENT_SORT_ORDER" => "asc",
								"ELEMENT_SORT_ORDER2" => "desc",
								"FILTER_NAME" => "TopFilter",
								"HIDE_NOT_AVAILABLE" => "N",
								"IBLOCK_ID" => "4",
								"IBLOCK_TYPE" => "1c_catalog",
								"INCLUDE_SUBSECTIONS" => "Y",
								"LABEL_PROP" => "-",
								"LINE_ELEMENT_COUNT" => "4",
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
								"PAGE_ELEMENT_COUNT" => "4",
								"PARTIAL_PRODUCT_PROPERTIES" => "N",
								"PRICE_CODE" => array(
									0 => "#СлужебноеДляСайта## (розничные цены)",
								),
								"PRICE_VAT_INCLUDE" => "Y",
								"PRODUCT_ID_VARIABLE" => "id",
								"PRODUCT_PROPERTIES" => array(
								),
								"PRODUCT_PROPS_VARIABLE" => "prop",
								"PRODUCT_QUANTITY_VARIABLE" => "",
								"PRODUCT_SUBSCRIPTION" => "N",
								"PROPERTY_CODE" => array(
									0 => "",
									1 => "",
								),
								"SECTION_CODE" => "",
								"SECTION_ID" => "",
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
				</li>
				<?}?>
			</ul>
		</div>



</div>




</div><!-- .content -->
