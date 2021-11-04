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
<div class="stext col2" >
	<div style="float:left; width: 460px;">
		<p>
			Группа компаний «Терморос» является подрядчиком на выполнение строительно-монтажных работ по инженерным коммуникациям, а также комплектует объекты промышленного, жилого или социального секторов строительства. 
		</p>
		<p>
			Для выполнения монтажных работ «Терморос» ищет партнёров субподрядчиков. Если вы представляете монтажную организацию, обладаете профессиональным опытом и способны качественно и в установленные сроки выполнить заявленные виды работ, будем рады видеть вас в числе наших партнёров.
		</p>
		<p>
			Ознакомьтесь с перечнем актуальных конкурсов. 
		</p>
	</div>
	<div style="float:right; width: 460px;">
		<img alt="Субподряд «Терморос»" src="/img/subcontract.jpg">
	</div>
</div>
<div style="clear:both;"></div>
<div class="hr"></div>

<div class="stati animate_all_childs">
<? foreach($arResult["ITEMS"] as $arItem) { ?>
<?
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
	<?
	$dateStr = substr($arItem["PROPERTIES"]["END_DATE"]["VALUE"], 0, 10);
	$dateArr = explode(".", $dateStr);
	$endDateUnix = mktime(23, 59, 59, $dateArr[1], $dateArr[0], $dateArr[2]);
	
	?>
	<div style="margin-bottom:10px;" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    	<div class="s_icon"></div>
    	<div class="a_date" style="line-height:1.5; color: rgb(137, 137, 137);"><?=substr($arItem["ACTIVE_FROM"], 0, 10);?> - <?=substr($arItem["PROPERTIES"]["END_DATE"]["VALUE"], 0, 10);?> <? if ($endDateUnix < time()) { ?><b style="color: #000;font-size: 15px;">Конкурс закрыт</b><? } ?></div>
		<div class="s_name"><a style="font-size: 17px;" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
        <?=$arItem["PREVIEW_TEXT"]?>
    </div>
<? } ?>
</div>
<div class="hr_mid"></div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
