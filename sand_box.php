<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


\Bitrix\Main\Loader::includeModule('search');
\Bitrix\Main\Loader::includeModule('iblock');

$search = new \CSearchTitle();
$search->setMinWordLength(1);
$filter[0] = [
	"=MODULE_ID" => "iblock",
	"PARAM1" => '1c_catalog',
	"PARAM2" => '4',
];

if ($search->Search($_REQUEST["atr"], 10, $filter,false,'date'))
{
	while ($item = $search -> Fetch())
	$idList[] = $item["ITEM_ID"];
}
if(!empty($idList))
{
	$rsElement = CIBlockElement::GetList(
		array(),
		array(
			"=ID" => $idList,
			"IBLOCK_ID" => 4,
		),
		false,
		false,
		array(
			"ID",
			"NAME",
			"PROPERTY_CML2_ARTICLE",
		)
	);
	?>

	<div class="atr_autocomplete" style="display: none">
		<?
		while ($arElement = $rsElement->Fetch())
		{
			?>
			<p class="atr_rez_rou" data-id="<?=$arElement["ID"]?>" data-atr="<?=$arElement["PROPERTY_CML2_ARTICLE_VALUE"]?>">[<?=$arElement["PROPERTY_CML2_ARTICLE_VALUE"]?>] <?=$arElement["NAME"]?></p>
			<?
		}
		?>
	</div>


	<?
}

