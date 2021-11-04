<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (empty($arResult))
	return;

if ($arParams["IS_SALE"])
{
	$res = CIBlockSection::GetList(
		Array("SORT"=>"ASC"),
		Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y", "PROPERTY" => array(">=TMR_SALE"=>1)),
		false,
		Array("ID", "SECTION_PAGE_URL"),
		false
	);
	while($ar = $res->GetNext())
	{
		$salesSectionsArr[] = $ar["SECTION_PAGE_URL"];
	}
	//v($salesSectionsArr);
}


$arMenuItemsIDs = array();
$arAllItems = array();
foreach($arResult as $arItem)
{
	if ($arParams["IS_SALE"] && !in_array($arItem["LINK"], $salesSectionsArr)) continue;
	$arItem["PARAMS"]["item_id"] = crc32($arItem["LINK"]);

	if ($arItem["DEPTH_LEVEL"] == "1")
	{
		$arMenuItemsIDs[$arItem["PARAMS"]["item_id"]] = array();
		if ($arItem["IS_PARENT"])
		{
			$curItemLevel_1 = $arItem["PARAMS"]["item_id"];
		}
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
	elseif($arItem["DEPTH_LEVEL"] == "2")
	{
		$arMenuItemsIDs[$curItemLevel_1][$arItem["PARAMS"]["item_id"]] = array();
		if ($arItem["IS_PARENT"])
		{
			$curItemLevel_2 = $arItem["PARAMS"]["item_id"];
		}
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
	elseif($arItem["DEPTH_LEVEL"] == "3")
	{
		$arMenuItemsIDs[$curItemLevel_1][$curItemLevel_2][$arItem["PARAMS"]["item_id"]] = array();
		if ($arItem["IS_PARENT"])
		{
			$curItemLevel_3 = $arItem["PARAMS"]["item_id"];
		}
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
	elseif($arItem["DEPTH_LEVEL"] == "4")
	{
		$arMenuItemsIDs[$curItemLevel_1][$curItemLevel_2][$curItemLevel_3][] = $arItem["PARAMS"]["item_id"];
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
}

$arResult = array();
$arResult["ALL_ITEMS"] = $arAllItems;
$arResult["ALL_ITEMS_ID"] = $arMenuItemsIDs;


?>

