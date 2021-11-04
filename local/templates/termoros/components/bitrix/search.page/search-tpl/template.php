<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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

$elCount = 0;
if ($arResult['SEARCH']) $elCount += $arResult["NAV_RESULT"]->SelectedRowsCount();
//v($arResult['SEARCH']);
if ($arResult['SEARCH'] && $arParams['ARTICLE_ELEMENTS'])
{
	foreach($arResult['SEARCH'] as $k => $v)
	{
		$resArr[] = $v["ITEM_ID"];
	}
	$resArr = array_merge($resArr, $arParams['ARTICLE_ELEMENTS']);
	$resArr = array_unique($resArr);
	
	$elCount = count($resArr);
}
if (!$arResult['SEARCH'] && $arParams['ARTICLE_ELEMENTS'])
{
	$elCount = count($arParams['ARTICLE_ELEMENTS']);
}

//p($arResult);
?>

	<div class='search_no_res'>
	<div class="search-catalog-block">
	<?if($arResult['SEARCH'] || $arParams['ARTICLE_ELEMENTS']):?>
	
	<p class='search_res'>По запросу: «<?=$arResult['REQUEST']['QUERY'];?>»  найдено: <span><?echo $elCount?> результатов</span></p>
	<?else:?>
	<p class='search_res'>К сожалению, по вашему запросу «<?=$arResult['REQUEST']['QUERY'];?>» ничего не найдено.</p>
	<br>
	
	<? 
	\Bitrix\Main\Loader::includeModule('redreams.partners');
	$isPartner = FALSE;
	if(\Redreams\Partners\partner::isPartner()) $isPartner = TRUE;
	if ($isPartner) {
	?>
	<p class='search_res'>Пришлите, пожалуйста, недостающие артикулы и мы постараемся в ближайшее время добавить их на сайт:</p>
		<div class="anketa pop_up" style="margin:0;">
		<?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
				"bitrix:form.result.new",
				"articles_form",
				Array(
					"CACHE_TIME" => "3600",
					"CACHE_TYPE" => "N",
					"CHAIN_ITEM_LINK" => "",
					"CHAIN_ITEM_TEXT" => "",
					"COMPONENT_TEMPLATE" => "articles_form",
					"EDIT_URL" => "result_edit.php",
					"IGNORE_CUSTOM_TEMPLATE" => "N",
					"LIST_URL" => "",
					"SEF_MODE" => "N",
					"SUCCESS_URL" => "",
					"USE_EXTENDED_ERRORS" => "Y",
					"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
					"WEB_FORM_ID" => "27"
				)
			);?>
		<?endif;?>
			
		</div>
		<div class="clear"></div>
		<style>
			.pop_up .inpt .inp_self {
				padding: 5px 30px;
			}
			.pop_up .inpt {
				margin: 0 0 10px 0;
			}
		</style>
	<?  } ?>
	<?endif;?>
	</div>
	</div>
	
	<?
	foreach($arResult['SEARCH'] as $key => $vals){
		if($vals['ITEM_ID']{0} == 'S') continue;
		
		$arrSort[$vals['PARAM2']][] = $vals['ITEM_ID'];
	
	}
	global $arSearchIds;
	$arSearchIds = $arrSort;
	?>