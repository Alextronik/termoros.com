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

$NAV = array(
	"NavPageCount" => $arResult["NAV_RESULT"]->NavPageCount, "NavPageNomer" => $arResult["NAV_RESULT"]->NavPageNomer,
	"NavPageNomerNext" => $arResult["NAV_RESULT"]->NavPageNomer + 1, "NavNum" => $arResult["NAV_RESULT"]->NavNum,
);
$templateData["NAV"] = $NAV;

$arItems = array_chunk($arResult["ITEMS"], 4);

?>
<div class="brands_page">
	<div class="brands_page_list">
		<? foreach ($arItems as $row): ?>
			<div class='brands_line row'>
				<? foreach ($row as $indx => $arItem): ?>
					<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
					<?
					if ($arItem["PREVIEW_PICTURE"]['ID'])
					{
						$imgid = resize($arItem["PREVIEW_PICTURE"]['ID'], 200, 100, 2);
					}
					elseif ($arItem["DETAIL_PICTURE"]['ID'])
					{
						$imgid = resize($arItem["DETAIL_PICTURE"]['ID'], 200, 100, 2);
					}
					else
					{
						$imgid = '';
					}
					//p($arItem);
					?>
					<div class="brand_item_wrapper col">
						<a href='<?= $arItem['DETAIL_PAGE_URL'] ?>' class='brand_item'>
							<div class="brand_image">
								<img src='<?= $imgid ?>' alt=""/>
							</div>
							<div class="brand_short_info">
								<span class="brand_name"><?= $arItem['NAME']; ?></span><br>
								<span class="brand_country"><?= $arItem['PROPERTIES']['COUNTRY']['VALUE']; ?></span>
							</div>
						</a>
					</div>
				<? endforeach; ?>
				<div class='clear'></div>
			</div>
		<? endforeach; ?>
	</div>

	<? if ($NAV["NavPageCount"] > $NAV["NavPageNomer"])
	{
		$page = $APPLICATION->GetCurPageParam("PAGEN_" . $NAV["NavNum"] . "=" . $NAV["NavPageNomerNext"] . "&LAZI_"
			. $NAV["NavNum"] . "=Y", array("PAGEN_" . $NAV["NavNum"], "LAZI_" . $NAV["NavNum"]));
		?>
		<a href='<?= $page ?>' class='show_more news brands'></a>
	<? } ?>

	<div class='pager'>
		<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
			<?= $arResult["NAV_STRING"] ?>
		<? endif; ?>
	</div>
</div>