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



?>
<div class='brand_detail_wp'>
	<div class='br_ico'>
		<? if ($imgid): ?>
			<img src="<?= $imgid; ?>" alt=""/>
		<? endif; ?>
		
	</div>
	<div class='brand_detail'>
		<p><? if (strlen($arResult["DETAIL_TEXT"]) > 0): ?>
				<? echo $arResult["DETAIL_TEXT"]; ?>
			<? else: ?>
				<? echo $arResult["PREVIEW_TEXT"]; ?>
			<? endif ?></p>

			<? global $USER?>
			<? if ($USER->IsAdmin()) { ?>
				<br>
				<a href="/partners/get_pricelist/get.php?brand=<?=$arResult[" style="display: block;
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
				
			<? } ?>
			
			<? if (in_array($arResult["NAME"], $brands)) { ?>
				<p><a style="font-size:16px;font-weight:bold;" href="/where_to_buy_brand?brands=<?=$arResult[">Где купить<?=$countName?></a></p>
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