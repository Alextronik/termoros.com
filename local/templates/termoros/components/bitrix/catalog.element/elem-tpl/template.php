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

\Bitrix\Main\Loader::includeModule('redreams.partners');
$isPartner = FALSE;
if(\Redreams\Partners\partner::isPartner()) $isPartner = TRUE;
global $USER;
if ($USER->IsAdmin()) $isPartner = TRUE;
//p($arResult["PROPERTIES"]["MORE_PHOTO"]);
//v($arResult["PROPERTIES"]["CML2_TRAITS"]);
$showExtraText = FALSE;
global $extraTextItemArr, $extraTextInItem;
if (in_array($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"], $extraTextItemArr))
{
	$showExtraText = TRUE;
}

$displayTraitsArr = array('Ширина, м' => 'Ширина упаковки, м', 'Высота, м' => 'Высота упаковки, м', 'Глубина, м' => 'Глубина упаковки, м', 'Вес, кг' => 'Вес брутто, кг');

$hideTraits = false;
/*
$eurosArr = array(
	"EU.ST3092860 114x12x8",
	"EU.ST3092840 34x12x8",
	"EU.ST3092740 34x12x7",
	"EU.ST3092660 114x12x6",
	"EU.ST3092650 1x12x6",
	"EU.ST3092640 34x12x6",
	"EU.ST3092560 114x12x5",
	"EU.ST3092540 34x12x5",
	"EU.ST3092460 114x12x4",
	"EU.ST3092450 1x12x4",
	"EU.ST3092440 34x12x4",
	"EU.ST3092360 114x12x3",
);
if ($arResult['BREND']['NAME'] == 'Euros' && !in_array($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"], $eurosArr))
{
	$hideTraits = true;
}
*/


if ($arResult["PROPERTIES"]["CML2_TRAITS"]["DESCRIPTION"] && !$hideTraits)
{
	foreach($arResult["PROPERTIES"]["CML2_TRAITS"]["DESCRIPTION"] as $k => $v)
	{
		if ($displayTraitsArr[$v] && $arResult["PROPERTIES"]["CML2_TRAITS"]["VALUE"][$k])
		{
			$displayTraitsValue[$displayTraitsArr[$v]] = $arResult["PROPERTIES"]["CML2_TRAITS"]["VALUE"][$k];
			$traitsCDEK[$displayTraitsArr[$v]] = $arResult["PROPERTIES"]["CML2_TRAITS"]["VALUE"][$k];
		}
	}
}

if (!$arResult["DETAIL_TEXT"] || strlen($arResult["DETAIL_TEXT"]) < 50)
{
    $cache = Bitrix\Main\Data\Cache::createInstance();
    if ($cache->initCache(2592000, "sec_el_desk", "sec_el_desk"))
    {
        $sections = $cache->getVars();
    }
    elseif ($cache->startDataCache())
    {
        $sections = array();

        $res = CIBlockSection::GetList(
            Array("SORT"=>"ASC"),
            Array("IBLOCK_ID" => 4, "ACTIVE" => "Y"),
            false,
            Array("*", "UF_ELEMENT_TEXT"),
            false
        );
        while($ar = $res->GetNext())
        {
            $sections[$ar["ID"]] = $ar;
        }

        $cache->endDataCache($sections);
    }

	$elementText = '';
	$i = $arResult["IBLOCK_SECTION_ID"];
	while($i)
	{
		if ($sections[$i]["UF_ELEMENT_TEXT"])
		{
			$elementText = $sections[$i]["~UF_ELEMENT_TEXT"];
			break;
		}
		$i = $sections[$i]["IBLOCK_SECTION_ID"];
	}
	$elementText = str_replace("#ELEMENT_H1#", $arResult["NAME"], $elementText);
	$arResult["DETAIL_TEXT"] = $elementText;
}


//Вывод решеток для конвекторов
if (substr($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"], -7) == '/FNA/NV') $gekonConvectorArticle = $arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"];
if ($gekonConvectorArticle)
{
	$w = intval(substr($gekonConvectorArticle, 12, 2)) - 1;
	$l = intval(substr($gekonConvectorArticle, 9, 3)) - 1;
	$l = str_pad($l, 3, '0', STR_PAD_LEFT);
	
	$grilArray = array("RNA", "DMN", "DON", "RBL", "RDB", "RLB", "RBR");
	foreach($grilArray as $gril)
	{
		$grilArticles[] = "GRIL0.".$w.".0".$gril.$l.".0/TE";
	}
	
	if ($grilArticles)
	{
		$r = CIblockElement::GetList(
			Array("SORT"=>"ASC"),
			Array("IBLOCK_ID"=>4, "ACTIVE" => "Y", "PROPERTY_CML2_ARTICLE" => $grilArticles),
			false,
			false,
			Array("*", "PROPERTY_CML2_ARTICLE", "PROPERTY_TMR_SALE", 'PROPERTY_NOZ')
		);
		
		while($el = $r->GetNext())
		{
			$grils[$el["ID"]] = $el;
			$grilsIds[] = $el["ID"];
		}
		
		if ($grilsIds && count($grilsIds) < 10)
		{
			foreach($grils as $element)
			{
				$elementProduct = CCatalogProduct::GetByID($element['ID']);
			
				$res = CPrice::GetList(
					array(),
					array(
							"PRODUCT_ID" => $elementProduct["ID"],
							"CATALOG_GROUP_ID" => 2
						)
				);
				if ($ar = $res->Fetch())
				{
					$grils[$element['ID']]['PRICE'] = $ar["PRICE"];
					$grilsIds[] = $element['ID'];
				}
			}
		}
	}
}


//v($displayTraitsValue);
/*
v($arResult["CATALOG_WEIGHT"]);
v($arResult["CATALOG_WIDTH"]);
v($arResult["CATALOG_LENGTH"]);
v($arResult["CATALOG_HEIGHT"]);
*/
?>

<?if($arParams['DETAIL_PAGE']):?>
<div itemscope itemtype="http://schema.org/Product" class='container'>
<?endif;?>

    <div class="container">
        <div class='nav_block row'>
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "nav", Array(
                "COMPONENT_TEMPLATE" => ".default",
                "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                "SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
            ),
                false
            );?>

        </div>
    </div>


	<?if($arParams['DETAIL_PAGE']):?>
	<div class='detail_page row'>
	<?endif;?>

		<div class='det_left col-12 col-md-4'>
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
					<?$reject = (substr($arResult["PROPERTIES"]['CML2_ARTICLE']['VALUE'], 0,1) == "@") ? true : false;
                    if($reject){?>
                        <div class="reject_label"></div>
                    <?}elseif($arResult["PROPERTIES"]['NOZ']['VALUE']){
						?><div class="sale_label"></div>
					<?}elseif($arResult["PROPERTIES"]["NEW_TOV"]["VALUE"]=="Y"){?>
						<div class="new_label"></div>
					<?}elseif($arResult["PROPERTIES"]["TOP_TOV"]["VALUE"]=="Y"){
						?><div class="hit_label"></div><?
					}?>

					<?foreach($foto as $key=>$arFoto){?>
					<div class="fullimgitem" id="big_detailimg<?=$key?>" <?=$key==0?'style="display:block;"':''?>>
						<img itemprop="image" alt="<?=$arResult["NAME"]?>" src="<?=$arFoto["BIG"]["src"]?>">
					</div>

					<?}?>
					<? if ($isPartner) { ?>
						<? if ($arResult["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Складская") { ?>
							<img src='/images/stock.png' title="Складская" alt="Складская" style="position: absolute; top: 5px; bottom: initial; right: 5px; left: inherit; width: 32px; height: 32px; z-index: 10;">
						<? } elseif ($arResult["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Заказная") { ?>
							<img src='/images/order.png' title="Заказная" alt="Заказная" style="position: absolute; top: 5px; bottom: initial; right: 5px; left: inherit; width: 32px; height: 32px; z-index: 10;">
						<? } elseif ($arResult["PROPERTIES"]["TIP_SKLADSKOGO_ZAPASA"]["VALUE"] == "Не заказывать") { ?>
							<img src='/images/sale.png' title="Распродажа остатков" alt="Распродажа остатков" style="position: absolute; top: 5px; bottom: initial; right: 5px; left: inherit; width: 32px; height: 32px; z-index: 10;">
						<? } ?>
					<? } ?>
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

			<div class='det_share'>
				<p class='name'>Поделиться</p>
				<span class="soc-blk">
				<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
				<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
				<div class="ya-share2" data-services="vkontakte,facebook,gplus" data-counter=""></div>
				</span>
			</div>
		</div>

		<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class='det_right col-12 col-md-8'>
			<a target="_blank" href='?print=y' class='print'></a>
			<h1 itemprop="name"><?=$arResult["NAME"]?></h1>
			<?if ($showExtraText) { ?><p style="margin: 0 0 5px 0; color: red;"><b><?=$extraTextInItem?></b></p><? } ?>
			<p class='code'>Артикул: <?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></p>
			<noindex><?if(strlen($arResult["DETAIL_TEXT"])>50) { ?><p class="element_preview_text" style="margin-bottom:10px;">
				<?
				$detailTmp = str_replace("</li>", "<br>", $arResult["DETAIL_TEXT"]);
				$detailTmp = strip_tags($detailTmp, '<br>');
				?>
				<? if (strlen($detailTmp) > 500) {
					$wrapped = wordwrap($detailTmp, 500, "<br>", false);
					$wrappedArr = explode('<br>', $wrapped);
					?>
					<?=$wrappedArr[0]?>... <a href="#detail_text" onclick="$('#detail_text > a').trigger('click');">Подробнее</a>
					<?
				} else {
					echo $detailTmp;
				} ?>
				
			</p><? } ?></noindex>
			<?//p($arResult["PROPERTIES"]['CML2_TRAITS']);?>
			<div class='chars hm'>
				<?if($arResult["DISPLAY_PROPERTIES"]) { ?><p class='ttl'>Технические характеристики <a <?if($arParams['FASTFIND']):?>href="<?=$arResult["DETAIL_PAGE_URL"]?>"<?else:?>href="#tech"<?endif;?>class='more'>Подробнее</a></p><? } else { ?>
					<p class='ttl'>&nbsp;</p>
					<div class='char_line'>
						<p class='name'>&nbsp;</p>
						<p class='value'>&nbsp;</p>
					</div>
				<? } ?>
				<?
				//p($arResult["DISPLAY_PROPERTIES"]);
				$colvo=0;
				$upBrend = true;
				?>
				<?foreach($arResult["DISPLAY_PROPERTIES"] as $prop) { ?>
					<? if ($prop["VALUE"] <> "") {
						if (!($prop["PROPERTY_TYPE"] == "N" && $prop["VALUE"] == 0)) {
							$upBrend = false;
							?>
							<div class='char_line'>
								<p class='name'><span><?= $prop["NAME"] ?></span></p>
								<p class='value'>
								<?
								$tmpUrlArr = explode("/", trim($arResult["DETAIL_PAGE_URL"], '/'));
								unset($tmpUrlArr[count($tmpUrlArr)-1]);
								$url = '/'.implode('/', $tmpUrlArr).'/';
								$filterUrl = '';
								if ($prop['PROPERTY_TYPE'] == 'L')
								{
									$filterUrl = 'filter/'.strtolower($prop['CODE']).'-is-'.$prop['VALUE_XML_ID'].'/apply/';
								}
								elseif ($prop['PROPERTY_TYPE'] == 'N') {
									$filterUrl = 'filter/'.strtolower($prop['CODE']).'-from-'.$prop['VALUE'].'-to-'.$prop['VALUE'].'/apply/';
									
								}
								
								if ($filterUrl)
								{
								?>
									<a target="_blank" href="<?=$url.$filterUrl?>"><?= $prop["VALUE"] ?></a>
								<? } else { ?>
									<?= $prop["VALUE"] ?>
								<? } ?>
								</p>
							</div>
							<?$colvo++;?>
						<? } 
					}
					if($colvo==5){
						break;
					}
				}?>
				<?//v($arResult['BREND']);?>
				<?if($arResult['BREND']):?>
					<a href='<?=$arResult['BREND']['LINK']?>'>
						<img src='<?=$arResult['BREND']['PIC']['src']?>' class='item_logo' alt="<?=$arResult['BREND']['NAME']?>" <?=$upBrend ? "style='bottom: 0;top: initial;'" : ""?>>
					</a>
				<?endif;?>
			</div>

<?/* if ($USER->IsAdmin()) { ?>
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
<? } */?>
			<div class='clear'></div>
			<div class='det_delivery'>
				<div class='dd_left'>
					<p class='ttl'>Наличие</p>
					<p class='loc'>г. <?=$_SESSION['GEOIP']['curr_city_name'] ? $_SESSION['GEOIP']['curr_city_name'] : $_SESSION['GEOIP']['city']?><a href=''>изменить</a><?if ($arResult["STORE_ADDRESS"]) { ?><br><span style="font-size:13px;">(склад <b><?=$arResult["STORE_ADDRESS"]?></b>)</span><? } ?></p>
					
					<?if($arResult['QUANTS'][$arResult['ID']]){
						?>
						<p itemprop="availability" class='nal'>В наличии: <?=abs($arResult['QUANTS'][$arResult['ID']])?> <?=$arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>.</p>
						<?
					}else{
						?>
						<p itemprop="availability" class='nal'>Наличие уточняйте у менеджеров</p>
						<?
					}?>
					<? if (0 && $USER->GetID() == 191) { ?>
						<p class='i'>+ <span class="sypply_qa">123</span> шт.   доставка 20.02.2019</p>
						<p class='i'>+ <span class="sypply_qa">234</span> шт.   доставка 25.02.2019</p>
					<? } ?>
					<?
					if($arResult["SUPPLY"])
					{
						foreach ($arResult["SUPPLY"] as $supply)
						{
							?><p class='i'>+ <span class="sypply_qa"><?=$supply["UF_QUANTITY"]?></span> <?=$arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>.   доставка <?=$supply["UF_DATE"] -> format('d.m.Y')?></p><?
						}
					}
					?>
					<? if ($isPartner && !empty($arResult['OTHER_STORES'])) { ?>
						<p>
						<a onclick="$('#more_stores').slideDown('fast'); $(this).hide(); return false;" href="#">Посмотреть остатки на других складах</a>
						<ul id="more_stores" style="display:none;">
							<?foreach($arResult['OTHER_STORES'] as $arStore) { ?>
								<li><b><?=$arStore['STORE_ADDR']?></b> - <?=abs($arStore['AMOUNT'])?> <?=$arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>.</li>
							<? } ?>
						</ul>
						</p>
					<? } ?>
				</div>

				<div class='dd_right'>
					<p class='txt'>Подробную информацию о наличии можно получить у оператора:</p>
					<?if($_SESSION['GEOIP']['curr_phones']):?>
					<p class='phone'><?=$_SESSION['GEOIP']['curr_phones'][0];?><?if($_SESSION['GEOIP']['curr_phones'][1]):?>  |  <?=$_SESSION['GEOIP']['curr_phones'][1];?><?endif;?></p>
					<?else:?>
					<p class='phone'>+7 (495) 785 55 00  |  +7 (499) 500 00 01 </p>
					<?endif;?>

					<a href='' class='del_time vibor_sklada'>Выбрать склад</a>
					<!--<a href='' class='del_time'>Условия и сроки поставки</a>-->
					
					
				</div>
				<div class='clear'></div>
			</div>
			<?//v($arResult)?>
			<?if(\Redreams\Partners\partner::isPartner() && ($arResult["MIN_PRICE"]["VALUE"] < $arResult["MAX_PRICE"]["VALUE"]) && $arResult["MAX_PRICE"]["VALUE"]):?>
				<p class="partner_price">Розничная цена: <?=number_format ($arResult["MAX_PRICE"]["VALUE"], 2, '.', ' ' )?>  руб.</p>
			<?endif?>
			<div class='price_wp'>
				<p class='price'>
					<?//p($arResult["MAX_PRICE"]["VALUE"])?>
					<?if(!\Redreams\Partners\partner::isPartner() && ($arResult["MIN_PRICE"]["VALUE"] < $arResult["MAX_PRICE"]["VALUE"]) && $arResult["MAX_PRICE"]["VALUE"]):?>
						<span class='oldprice'><?=number_format ($arResult["MAX_PRICE"]["VALUE"], 2, '.', ' ' )?> руб.</span>
					<?endif?>
					
					<span itemprop="price" content="<?=$arResult["MIN_PRICE"]["VALUE"]?>"><?=number_format ($arResult["MIN_PRICE"]["VALUE"], 2, '.', ' ' )?></span><span itemprop="priceCurrency" content="RUB" class='vl'>руб.</span>
					<?//p($arResult["MIN_PRICE"])?>
				</p>

				<? //v($arResult['QUANTS'][$arResult['ID']]);
                if ($arResult['QUANTS'][$arResult['ID']] > 0) { ?>
                    <?
					$weight = $traitsCDEK["Вес брутто, кг"];
					$width = round($traitsCDEK["Ширина упаковки, м"]*100, 0);
					$height = round($traitsCDEK["Высота упаковки, м"]*100, 0);
					$length = round($traitsCDEK["Глубина упаковки, м"]*100, 0);
					
					?>
						<form class="ADD2BASKET" action="ADD2BASKET" method="POST" style="display: inline-block;">
							<input type='hidden' name="action" value='ADD2BASKET' />
							<input type='hidden' name="id" value='<?=$arResult['ID']?>' />
							<div class='num_wp' style="margin-right: 20px;">
								<input type='text' name="quantity" class='inp_self' value='1'>
								<span><?=$arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?></span>
							</div>
							<?
							//v($traitsCDEK["Вес брутто, кг"]);
							//v($width);
							//v($height);
							//v($length);
							
							if ($weight && $width && $height && $length && $weight <= 30)
							{
								?>
								<? require($_SERVER["DOCUMENT_ROOT"] . "/include/cdek/cdek.php");?>
								<?
							}
							?>
							<a href='<?//=$arResult['ADD_URL']?>' onclick="yaCounter26951046.reachGoal('click_korzina'); ga('send', 'pageview','/virtual/click_korzina'); return true;" itemscope="" itemtype="http://schema.org/BuyAction" class='to_basket ajax' style="font-size:16px;padding: 9px 0; width: 100px; margin-right: 30px;">в корзину</a>
						</form>
						
						<form name="fastfind" >
							<input type='hidden' name="id" value='<?=$arResult['ID']?>' />
						</form>

						<a href='' data-id="<?=$arResult['ID']?>" class='to_fav fav_btn'></a>
						<a href='' data-id="<?=$arResult['ID']?>" class='to_compare compare_btn'></a>
						
						<div id="cdekBlockResult" style="display:none;">
							<br>
							<p style="color:red;font-weight:bold;">Стоимость доставки расчитана для одного товара</p>
							<p>Выбранный способ доставки: <b id="cdekProfile"></b></p>
							<p>Выбранный город: <b id="cdekCity"></b></p>
							<p>Стоимость доставки: <b id="cdekPrice"></b></p>
							<p>Срок доставки: <b id="cdekTerm"></b></p>
						</div>
						
					
					
					
				<? } else { ?>
					<form class="ADD2BASKET" action="ADD2BASKET" method="POST" style="display: inline-block;">
						<input type='hidden' name="action" value='ADD2BASKET' />
						<input type='hidden' name="id" value='<?=$arResult['ID']?>' />
						<div class='num_wp'>
							<input type='text' name="quantity" class='inp_self' value='1'>
							<span><?=$arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?></span>
						</div>
						<a href='<?//=$arResult['ADD_URL']?>' onclick="yaCounter26951046.reachGoal('click_korzina'); ga('send', 'pageview','/virtual/click_korzina'); return true;" itemscope="" itemtype="http://schema.org/BuyAction" class='to_basket ajax'>в корзину</a>
					</form>
					
					<form name="fastfind" >
						<input type='hidden' name="id" value='<?=$arResult['ID']?>' />
					</form>

					<a href='' data-id="<?=$arResult['ID']?>" class='to_fav fav_btn'></a>
					<a href='' data-id="<?=$arResult['ID']?>" class='to_compare compare_btn'></a>
				<? } ?>
				
				
				<p class='tech_i'>Технические характеристики и внешний вид товара могут отличаться, просьба уточнять у менеджера</p>
                <p class='tech_i clr6'>Нашли ошибку в описании товара? Выделите ее и нажмите CTRL + ENTER</p>
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

		<?if($arParams['DETAIL_PAGE']):?>
		<?
		$factive = false;
		//v($arResult["PROPERTIES"]["VIDEO"]['VALUE']);
		?>
		<div id="tech" class='det_chars_wp col-12 py-3'>
			<ul class='chars_links'>
				<?if(($arResult["DISPLAY_PROPERTIES"] && $colvo) || $displayTraitsValue):?>
					<li class='active'><a href=''>Характеристики</a></li>
					<?$factive = true;?>
				<?endif;?>
				<?if(strlen($arResult["DETAIL_TEXT"])>100) { ?>
					<? if (!$factive) { $detailActive = true; } ?>
					<li id="detail_text" <? if ($detailActive) { ?>class='active'<? } ?>><a href=''>Описание</a></li>
				<? } ?>
				<? if ($arResult['BREND']['NAME']) { ?> 
					
					<?
					$res = CIBlockElement::GetList(
						 Array("NAME"=>"ASC"),
						 Array("IBLOCK_ID"=>19, "ACTIVE"=>"Y", "PROPERTY_PRODUCTER_VALUE" => $arResult['BREND']['NAME']),
						 false,
						 false,
						 Array('*', 'PROPERTY_FILE', 'PROPERTY_FILE_PATH')
					);
					while($ar = $res->GetNext())
					{
						$techDocs[] = $ar;
					}
					?>
					
					<?
					$res = CIBlockElement::GetList(
						 Array("NAME"=>"ASC"),
						 Array("IBLOCK_ID"=>31, "ACTIVE"=>"Y", "PROPERTY_PRODUCTER_VALUE" => $arResult['BREND']['NAME']),
						 false,
						 false,
						 Array('*', 'PROPERTY_FILE', 'PROPERTY_FILE_PATH')
					);
					while($ar = $res->GetNext())
					{
						$rekDocs[] = $ar;
					}
					?>
					
					<? if ($techDocs) { ?>
					<?if (!$factive && !$detailActive) $dactive = true;?>
					<li <?if ($dactive) { ?>class="active"<? } ?>><a href=''>Документация</a></li>
					<? } ?>
					
					<? if ($rekDocs) { ?>
						<li><a href=''>Рекламные материалы</a></li>
					<? } ?>
                    <? if ($arResult["PROPERTIES"]["VIDEO"]['VALUE']) { ?>
                        <li><a href=''>Видео</a></li>
                    <? } ?>
				<? } ?>
				
				<?/*<li <?if(!$factive):?>class='active'<?endif;?>><a href=''>С данным товаром покупают</a></li>*/?>
				<?
				if($arResult["PROPERTIES"]["AKSESSUARY"]["VALUE"])
				{
					?>
					<li><a href=''>Комплектующие</a></li>
					<?
				}
				if($arResult["PROPERTIES"]["BUY_TOGETHER"]["VALUE"])
				{
					?>
					<li><a href=''>Аксессуары</a></li>
					<?
				}
				if($arResult["PROPERTIES"]["ANALOGIC"]["VALUE"])
				{
				?>
					<li><a href=''>Аналоги</a></li>
				<?
				}
				?>
				<?
				if($grils)
				{
				?>
					<li><a href=''>Решетки</a></li>
				<?
				}
				?>
			</ul>
			<div class="clear"></div>
			<ul class='chars_thumbs'>
				<?if(($arResult["DISPLAY_PROPERTIES"] && $colvo) || $displayTraitsValue):?>
				<li class='active'>

					<div class='chars_th'>
						<p class='ttl'>Технические характеристики</p>
						<? if(($arResult["DISPLAY_PROPERTIES"] && $colvo) || $displayTraitsValue) { ?>
						<table class='char_table'>
							<?foreach($arResult["DISPLAY_PROPERTIES"] as $prop) { ?>
								<? if ($prop["VALUE"] <> "") { ?>
									<? if (!($prop["PROPERTY_TYPE"] == "N" && $prop["VALUE"] == 0)) { ?>
									<tr>
										<td><?= $prop["NAME"] ?></td>
										<td>
											<?
											$tmpUrlArr = explode("/", trim($arResult["DETAIL_PAGE_URL"], '/'));
											unset($tmpUrlArr[count($tmpUrlArr)-1]);
											$url = '/'.implode('/', $tmpUrlArr).'/';
											$filterUrl = '';
											if ($prop['PROPERTY_TYPE'] == 'L')
											{
												$filterUrl = 'filter/'.strtolower($prop['CODE']).'-is-'.$prop['VALUE_XML_ID'].'/apply/';
											}
											elseif ($prop['PROPERTY_TYPE'] == 'N') {
												$filterUrl = 'filter/'.strtolower($prop['CODE']).'-from-'.$prop['VALUE'].'-to-'.$prop['VALUE'].'/apply/';
												
											}
											//filter/tip_prisoedineniya-is-ee59e489-b890-11e5-80cf-0cc47a1d8513/apply/	//filter/maksimalnaya_podacha_m3_ch-from-0-to-158/tip_prisoedineniya-is-3ec4bf0c-b899-11e5-80cf-0cc47a1d8513/maksimalnyy_napor_m-from-0-to-150/moshchnost_dvigatelya_kvt-from-0-to-15/montazhnaya_dlina_mm-from-0-to-1455/apply/
											if ($filterUrl)
											{
											?>
												<a target="_blank" href="<?=$url.$filterUrl?>"><?= $prop["VALUE"] ?></a>
											<? } else { ?>
												<?= $prop["VALUE"] ?>
											<? } ?>
										</td>
									</tr>
									<? } ?>
									<?}
							}?>
							
							
							<? foreach($displayTraitsValue as $k => $v) { ?>
								<tr>
									<td><?= $k ?></td>
									<td><?= $v ?></td>
								</tr>
							<? } ?>
						</table>
						<? } ?>
						<?/* if (strlen($arResult['DETAIL_TEXT']) > 100) { ?>
						<p class='txt'><?=$arResult['DETAIL_TEXT']?></p>
						<? } */?>

					</div>

				</li>
				<?endif;?>
				
				<? if(strlen($arResult["DETAIL_TEXT"])>100) { ?>
					<li <?if ($detailActive) { ?>class="active"<? } ?>>
						<div class='tech_documentation detail_text'>
							<p class='txt'><?=$arResult['DETAIL_TEXT']?></p>
						</div>
					</li>
				<? } ?>
				<? if ($techDocs) { ?>
				
				<li <?if ($dactive) { ?>class="active"<? } ?>>

					<div class='tech_documentation'>

						<table class='tech_table table table-responsive'>
							<? foreach($techDocs as $arItem) { ?>
							
							<?
							if($arItem['PROPERTY_FILE_VALUE']){
								$path = CFile::GetPath($arItem['PROPERTY_FILE_VALUE']);
								$file = CFile::GetByID($arItem['PROPERTY_FILE_VALUE'])->fetch();
								$filesize = substr($file['FILE_SIZE']/1000000, 0, 4);
								$fileformat = substr($file['ORIGINAL_NAME'], -4, 4);					
							}
							elseif ($arItem['PROPERTY_FILE_PATH_VALUE']) 
							{
								
								$path = '/upload/manuals/'.$arItem['PROPERTY_FILE_PATH_VALUE'].'?'.rand(10000, 99999).'';
								$filesize = substr((filesize($_SERVER['DOCUMENT_ROOT'].'/upload/manuals/'.$arItem['PROPERTY_FILE_PATH_VALUE'])/1024)/1024, 0, 4);
								$fileformat = substr('/upload/manuals/'.$arItem['PROPERTY_FILE_PATH_VALUE'], -4, 4);				
							}
							?>
							<tr>
								<td class="inp">
									<input id="name<?=$arItem['ID']?>" type="checkbox" class="customCheckbox">
									<label for="name<?=$arItem['ID']?>" ><?=$arItem['NAME']?></label>
								</td>

								<td class="type">
									<?if($fileformat):?><?=$fileformat?><?else:?> - <?endif;?>
								</td>
								<?if($filearray):?>
								<td class="type">
									<?if($filearray):?><?=$filearray?><?else:?> - <?endif;?>
								</td>
								<?endif;?>						
								<td class="size">
									<?if($filesize):?><?=$filesize?> Мб<?else:?> - <?endif;?>
								</td>
								
								<td class="action">
									<a title="Скачать этот файл" href="<?=$path;?>" target="_blank" class="download"></a>
								</td>
							</tr>
							<? } ?>
						</table>

						<?/*
						<div class='inp_wrap'>
							<input type='checkbox' class='customCheckbox'>
							<label>Выбрать все</label>
						</div>
						<a href='' class='down_selected'>скачать выбранные</a>
						*/?>
						<div class='clear'></div>
					</div>

				</li><? } ?>
				<? if ($rekDocs) { ?>
				
				<li>

					<div class='tech_documentation'>

						<table class='tech_table'>
							<? foreach($rekDocs as $arItem) { ?>
							
							<?
							if($arItem['PROPERTY_FILE_VALUE']){
								$path = CFile::GetPath($arItem['PROPERTY_FILE_VALUE']);
								$file = CFile::GetByID($arItem['PROPERTY_FILE_VALUE'])->fetch();
								$filesize = substr($file['FILE_SIZE']/1000000, 0, 4);
								$fileformat = substr($file['ORIGINAL_NAME'], -4, 4);					
							}
							elseif ($arItem['PROPERTY_FILE_PATH_VALUE']) 
							{
								
								$path = '/upload/manuals/'.$arItem['PROPERTY_FILE_PATH_VALUE'].'?'.rand(10000, 99999).'';
								$filesize = substr((filesize($_SERVER['DOCUMENT_ROOT'].'/upload/manuals/'.$arItem['PROPERTY_FILE_PATH_VALUE'])/1024)/1024, 0, 4);
								$fileformat = substr('/upload/manuals/'.$arItem['PROPERTY_FILE_PATH_VALUE'], -4, 4);				
							}
							?>
							<tr>
								<td class="inp">
									<input id="name<?=$arItem['ID']?>" type="checkbox" class="customCheckbox">
									<label for="name<?=$arItem['ID']?>" ><?=$arItem['NAME']?></label>
								</td>

								<td class="type">
									<?if($fileformat):?><?=$fileformat?><?else:?> - <?endif;?>
								</td>
								<?if($filearray):?>
								<td class="type">
									<?if($filearray):?><?=$filearray?><?else:?> - <?endif;?>
								</td>
								<?endif;?>						
								<td class="size">
									<?if($filesize):?><?=$filesize?> Мб<?else:?> - <?endif;?>
								</td>
								
								<td class="action">
									<a title="Скачать этот файл" href="<?=$path;?>" target="_blank" class="download"></a>
								</td>
							</tr>
							<? } ?>
						</table>
						<div class='clear'></div>
					</div>

				</li><? } ?>
                <? if ($arResult["PROPERTIES"]["VIDEO"]['VALUE']) {
                    echo "<li>";
                        foreach($arResult["PROPERTIES"]["VIDEO"]["~VALUE"] as $v){
                            echo $v['TEXT'];
                        }
                    echo "</li>";
                }?>
				<?
				if($arResult["PROPERTIES"]["AKSESSUARY"]["VALUE"])
				{
					?>
					<li class="analogs">

						<?global $TopFilter;
						$TopFilter=array("XML_ID"=>$arResult["PROPERTIES"]["AKSESSUARY"]["VALUE"])
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
				<?
				if($arResult["PROPERTIES"]["BUY_TOGETHER"]["VALUE"])
				{
					?>
					<li class="analogs">

						<?global $TopFilter;
						$TopFilter=array("ID"=>$arResult["PROPERTIES"]["BUY_TOGETHER"]["VALUE"])
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
				<?
				if($grils)
				{
				?>
				<li class="analogs">

					<?global $TopFilter;
					$TopFilter=array("ID"=>$grilsIds)
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
								"LINE_ELEMENT_COUNT" => "7",
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
								"PAGE_ELEMENT_COUNT" => "7",
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
		<?endif;?>


	<?if($arParams['DETAIL_PAGE']):?>

		<?if($_SESSION['IBLOCK_COUNTER']):?>
		<?global $arFiltr;?>
		<?$arFiltr = array('ID' => $_SESSION['IBLOCK_COUNTER']);?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"list",
			array(
				"WATCHED" => 'Y',
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
				"FILTER_NAME" => "arFiltr",
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
				"PAGE_ELEMENT_COUNT" => "12",
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
		<?endif;?>


	<?endif;?>

	<?if($arParams['DETAIL_PAGE']):?>
	</div><!-- .detai; -->
	<?endif;?>



<?if($arParams['DETAIL_PAGE']):?>
</div><!-- .content -->
<?endif;?>

