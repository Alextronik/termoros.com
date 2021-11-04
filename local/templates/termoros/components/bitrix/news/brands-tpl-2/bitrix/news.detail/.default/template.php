<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
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
<?
if ($arResult["PREVIEW_PICTURE"]['ID'])
{
	$imgid = resize($arResult["PREVIEW_PICTURE"]['ID'], 500, 300, 2);
}
elseif ($arResult["DETAIL_PICTURE"]['ID'])
{
	$imgid = resize($arResult["DETAIL_PICTURE"]['ID'], 500, 300, 2);
}
else
{
	$imgid = '';
}
//p($arResult["NAME"]);
$db_enum_list = CIBlockProperty::GetPropertyEnum("BRANDS", Array(), Array("IBLOCK_ID"=>18));
while($ar_enum_list = $db_enum_list->GetNext())
{
  $brands[] = $ar_enum_list["VALUE"];
}

function BITGetDeclNum($value=1, $status= array('','а','ов'))
{
 $array =array(2,0,1,1,1,2);
 return $status[($value%100>4 && $value%100<20)? 2 : $array[($value%10<5)?$value%10:5]];
}

$res = CIblockElement::GetList(array(), array("IBLOCK_ID"=>18, "ACTIVE"=>"Y", "=PROPERTY_BRANDS_VALUE"=>$arResult["NAME"]), array("IBLOCK_ID"), false, array("*"));
$countName = "";
if ($ar = $res->GetNext())
{
	
	$count = $ar["CNT"];
	$countName = " (".$ar["CNT"]." магазин".BITGetDeclNum($ar["CNT"]).")";
}

$res = CIblockElement::GetList(
	array(),
	array('IBLOCK_ID' => "15", "ACTIVE" => "Y", "PROPERTY_PRODUCTER_VALUE" => $arResult["NAME"]),
	false,
	false,
	array('*', 'PROPERTY_PRODUCTER')
);
while($ar = $res->GetNext())
{
	$priceList = $ar;
	break;
	
}
$res = CIblockElement::GetList(
	array(),
	array('IBLOCK_ID' => "15", "ACTIVE" => "Y", "PROPERTY_PRODUCTER_VALUE" => $arResult["CODE"]),
	false,
	false,
	array('*', 'PROPERTY_PRODUCTER')
);
while($ar = $res->GetNext())
{
	$priceList = $ar;
	break;
	
}

if ($priceList) $priceLink = '/buyers/prices/?sort=name&order=asc&arrFilter_ff%5BNAME%5D=&arrFilter_pf%5BPRODUCTER%5D='.$priceList["PROPERTY_PRODUCTER_ENUM_ID"].'&set_filter=Y';

$actions = false;
$res = CIblockElement::GetList(
	array(),
	array('IBLOCK_ID' => "5", "ACTIVE" => "Y", "PROPERTY_BRAND" => $arResult["ID"]),
	false,
	false,
	array('*')
);
while($ar = $res->GetNext())
{
	$actions = true;
	break;
}

$res = CIblockElement::GetList(
	array(),
	array('IBLOCK_ID' => "19", "ACTIVE" => "Y", "PROPERTY_PRODUCTER_VALUE" => $arResult["NAME"]),
	false,
	false,
	array('*', 'PROPERTY_PRODUCTER')
);
while($ar = $res->GetNext())
{
	$doc = $ar;
	break;
	
}

if ($arResult["NAME"] == 'ROLS ISOMARKET')
{
	$doc["PROPERTY_PRODUCTER_ENUM_ID"] = 8368;
}



if ($doc) $docLink = '/technical_support/tech_documentation/?sort=name&order=asc&arrFilter_ff%5BNAME%5D=&arrFilter_pf%5BPRODUCTER%5D='.$doc["PROPERTY_PRODUCTER_ENUM_ID"].'&set_filter=Y';

$res = CIblockElement::GetList(
	array(),
	array('IBLOCK_ID' => "31", "ACTIVE" => "Y", "PROPERTY_PRODUCTER_VALUE" => $arResult["NAME"]),
	false,
	false,
	array('*', 'PROPERTY_PRODUCTER')
);
while($ar = $res->GetNext())
{
	$promo = $ar;
	break;
	
}
if ($promo) $promoLink = '/promotion_materials/materials_for_printing/?sort=name&order=asc&arrFilter_ff%5BNAME%5D=&arrFilter_pf%5BPRODUCTER%5D='.$promo["PROPERTY_PRODUCTER_ENUM_ID"].'&set_filter=Y';

?>
<div class='brand_detail_wp'>
	<div class='br_ico'>
		<? if ($imgid): ?>
			<img src="<?= $imgid; ?>" alt=""/>
		<? endif; ?>
		
	</div>
	<div class='brand_detail'>
		<div class="det_chars_wp">
			<ul class="chars_links">
				<li style="height: 48px;" class="active"><a href="">Описание</a></li>
				<? if ($arResult["PROPERTIES"]["ADVANTAGES"]["~VALUE"]["TEXT"]) { ?><li style="height: 48px;"><a href=""><?=($arResult["PROPERTIES"]["ADVANTAGES"]["DESCRIPTION"])?$arResult["PROPERTIES"]["ADVANTAGES"]["DESCRIPTION"]:'Преимущества'?></a></li><? } ?>
				<? if ($arResult["PROPERTIES"]["TECHNOLOGY"]["~VALUE"]["TEXT"]) { ?><li style="height: 48px;"><a href=""><?=($arResult["PROPERTIES"]["TECHNOLOGY"]["DESCRIPTION"])?$arResult["PROPERTIES"]["TECHNOLOGY"]["DESCRIPTION"]:'Производство'?></a></li><? } ?>
			</ul>
			<ul class="chars_thumbs">
				<li class="active">
				<? if (strlen($arResult["DETAIL_TEXT"]) > 0): ?>
					<? echo $arResult["DETAIL_TEXT"]; ?>
				<? else: ?>
					<? echo $arResult["PREVIEW_TEXT"]; ?>
				<? endif ?>
				</li>
				<? if ($arResult["PROPERTIES"]["ADVANTAGES"]["~VALUE"]["TEXT"]) { ?>
				<li>
					<?=$arResult["PROPERTIES"]["ADVANTAGES"]["~VALUE"]["TEXT"]?>
				</li>
				<? } ?>
				<? if ($arResult["PROPERTIES"]["TECHNOLOGY"]["~VALUE"]["TEXT"]) { ?>
				<li>
					<?=$arResult["PROPERTIES"]["TECHNOLOGY"]["~VALUE"]["TEXT"]?>
				</li>
				<? } ?>
			</ul>
		</div>
		<? 
		if ($priceLink) $brandButtons[] = array("LINK" => $priceLink, "NAME" => "Прайс-листы", "COLOR" => '#b54526');
		if ($docLink) $brandButtons[] = array("LINK" => $docLink, "NAME" => "Документация", "COLOR" => '#696daf');
		if ($promoLink) $brandButtons[] = array("LINK" => $promoLink, "NAME" => "Рекламные материалы", "COLOR" => '#749a4a');
		if ($actions) $brandButtons[] = array("LINK" => '/buyers/promotions/?brand='.$arResult["ID"], "NAME" => "Акции", "COLOR" => '#609b42');
		if (in_array($arResult["NAME"], $brands)) $brandButtons[] = array("LINK" => '/where_to_buy_brand/?brands='.$arResult["NAME"], "NAME" => "Где купить (".$count.")", "COLOR" => '#ffca28');
		$podborNew = '';
		if ($arResult["NAME"] == 'Gekon') 
		{
			$brandButtons[] = array("LINK" => '/catalog/gekon_convectors/', "NAME" => 'Подбор конвектора', "COLOR" => '#252277');
			//$podborNew = '<img class="brand-button-new-label" src="/brands/new_blank.png" style="margin-top: 15px; left: -200px; position: relative;">';
			$podborNumber = count($brandButtons);
		}
		if ($arResult["NAME"] == 'Lamborghini') 
		{
			$brandButtons[] = array("LINK" => '/technical_support/service_centers/?brands=Lamborghini', "NAME" => 'Сервисные центры', "COLOR" => '#252277');
			//$podborNew = '<img class="brand-button-new-label" src="/brands/new_blank.png" style="margin-top: 15px; left: -200px; position: relative;">';
			$podborNumber = count($brandButtons);
		}
		if ($arResult["NAME"] == 'FAR') 
		{
			$brandButtons[] = array("LINK" => '/buyers/download_catalog_far/', "NAME" => 'Электронный Каталог', "COLOR" => '#252277');
			//$podborNew = '<img class="brand-button-new-label" src="/brands/new_blank.png" style="margin-top: 15px; left: -200px; position: relative;">';
			$podborNumber = count($brandButtons);
		}
		if ($arResult["NAME"] == 'Jaga') 
		{
			$brandButtons[] = array("LINK" => '/buyers/download_catalog_jaga/', "NAME" => 'Электронный Каталог', "COLOR" => '#252277');
			//$podborNew = '<img class="brand-button-new-label" src="/brands/new_blank.png" style="margin-top: 15px; left: -200px; position: relative;">';
			$podborNumber = count($brandButtons);
		}
		?>
		<? // ToDo to styles + optimize?>
        <div id="button_row" class="row d-flex justify-content-between">
            <? if ($brandButtons[0]) { ?>
            <a href="<?=$brandButtons[0]["LINK"]?>" class="brand-price-button col-3" style="background: <?=$brandButtons[0]["COLOR"]?>;"><?=$brandButtons[0]["NAME"]?></a>
            <? } ?>
            <? if ($brandButtons[1]) { ?>
            <a href="<?=$brandButtons[1]["LINK"]?>" class="col-3" style="background: <?=$brandButtons[1]["COLOR"]?>;"><?=$brandButtons[1]["NAME"]?></a>
            <? } ?>
            <? if ($brandButtons[2]) { ?>
            <a href="<?=$brandButtons[2]["LINK"]?>" class="col-3" style="background: <?=$brandButtons[2]["COLOR"]?>;"><?=$brandButtons[2]["NAME"]?></a>
            <? } ?>
            <? if ($brandButtons[3]) { ?>
            <? if ($podborNumber == 4) echo $podborNew?>
            <a href="<?=$brandButtons[3]["LINK"]?>" class="brand-price-button col-3" style="background: <?=$brandButtons[3]["COLOR"]?>;"><?=$brandButtons[3]["NAME"]?></a>
            <? } ?>
            <? if ($brandButtons[4]) { ?>
            <? if ($podborNumber == 5) echo $podborNew?>
            <a href="<?=$brandButtons[4]["LINK"]?>" class="col-3" style="background: <?=$brandButtons[4]["COLOR"]?>;"><?=$brandButtons[4]["NAME"]?></a>
            <? } ?>
            <? if ($brandButtons[5]) { ?>
            <? if ($podborNumber == 6) echo $podborNew?>
            <a href="<?=$brandButtons[5]["LINK"]?>" class="col-3" style="background: <?=$brandButtons[5]["COLOR"]?>;"><?=$brandButtons[5]["NAME"]?></a>
            <? } ?>
        </div>
		<style>
            #button_row > a{display: inline-flex;justify-content: center;align-items: center;border-radius: 3px;color: #ffffff;text-decoration: none;text-transform: uppercase;
                cursor: pointer;height:2.5rem;font-weight: 600;text-align: center;margin:1rem;padding: 10px 0;}
			@media screen and (max-width:565px) {
				.brand_detail > a {
					margin: 20px 0 0 17px !important;
				}
				.brand-button-new-label {
					display: none;
				}
			}
		</style>
		<div class="clear"></div>

			<?/* global $USER?>
			<? if ($USER->IsAdmin()) { ?>
				<br>
				<a href="/partners/get_pricelist/get.php?brand=<?=$arResult["NAME"]?>" style="display: block;
		width: 175px;
		padding: 10px 0;
		border-radius: 3px;
		text-align: center;
		font-size: 14px;
		line-height: 16px;
		color: #ffffff;
		text-decoration: none;
		text-transform: uppercase;
		font-weight: 600;
		cursor: pointer;
		background: #b54526;
		margin: 0 0 10px 0;">Скачать прайс-лист</a>
				
			<? } */?>
			
			
			
			<? if (in_array($arResult["NAME"], $brands)) { ?>
				<?/*<p><a style="font-size:16px;font-weight:bold;" href="/where_to_buy_brand/?brands=<?=$arResult["NAME"]?>">Где купить<?=$countName?></a></p>*/?>
			<? } ?>
				
			<? if ($arResult['PROPERTIES']['CERT']['VALUE']) { ?>
				<p>
				<? foreach($arResult['PROPERTIES']['CERT']['VALUE'] as $fileId) { ?>
					<?
					$fileRes = CFile::GetByID($fileId);
					$file = $fileRes->GetNext();
					?>
					<img style="width:24px; margin:5px; position:relative; top: 15px;" src="/img/pdf-icon.png"><a target="_blank" href="<?=CFile::GetPath($fileId)?>"><?=$file['ORIGINAL_NAME']?></a><br/>
				<? } ?>
				</p>
			<? } ?>
			

	</div>
	<div class='clear'></div>
<div class='det_share'>
			<div style="float: left; text-align: left; padding: 6px 16px;">

				<? if ($arResult['PROPERTIES']['COUNTRY']['VALUE']): ?>
				<p class="brand_country"><span class='name'>Страна:</span> <?= $arResult['PROPERTIES']['COUNTRY']['VALUE']; ?></p>
				<? endif; ?>
<? if ($arResult['PROPERTIES']['SITE_URL']['VALUE']): ?>
				<p class='share_w'><span class='name'>Сайт производителя:</span>
				<?
				$sitesArr = explode(" ", $arResult['PROPERTIES']['SITE_URL']['VALUE']);
				foreach($sitesArr as $site) { 
				?>
				<a target="_blank" href='http://<?= str_replace('http://', '', $site); ?>'
class='br_link'><?= $site; ?></a>&nbsp;&nbsp;&nbsp;
				<? } ?>
				</p>
				<? endif ?>
			</div>
			<p class='name'>Поделиться</p>
			<span class="soc-blk">
			<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"
					charset="utf-8"></script>
			<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
			<div class="ya-share2" data-services="vkontakte,facebook,gplus" data-counter=""></div>
			</span>
		</div>
</div>