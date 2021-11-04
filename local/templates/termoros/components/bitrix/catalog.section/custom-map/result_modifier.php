<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
//p($arResult['ITEMS']);
$isServiceCentersMode = isset($arParams['SERVICE_CENTERS_MODE']) && $arParams['SERVICE_CENTERS_MODE'];
$metro = [];

if ($isServiceCentersMode)
{
	$typeOfProducts = [];
}

$properties = [];
$propertyCodes = ['METRO'];

if ($isServiceCentersMode)
{
	$propertyCodes[] = 'TYPE_OF_PRODUCTS';
}

foreach ($propertyCodes as $propertyCode)
{
	$propertiesResult = CIBlock::GetProperties($arParams['IBLOCK_ID'], [], ['CODE' => $propertyCode]);

	if ($property = $propertiesResult->Fetch())
	{
		$properties[$property['ID']] = [
			'code' => $property['CODE'],
			'isList' => $property['PROPERTY_TYPE'] == 'L'
		];
	}
}

$propertyValues = [];
$propertyValuesFilter = ['ACTIVE' => 'Y', 'SECTION_ID' => $arParams['SECTION_ID'], 'PROPERTY_SHOW_WHERE_BUY' => TRUE];
$propertyValuesResult = CIBlockElement::GetPropertyValues($arParams['IBLOCK_ID'], $propertyValuesFilter);

while ($propertyValue = $propertyValuesResult->GetNext())
{
	foreach ($propertyValue as $k => $item)
	{
		if (is_numeric($k) && isset($properties[$k]))
		{
			$propertyCode = $properties[$k]['code'];
			$isList = $properties[$k]['isList'];

			if (is_array($item))
			{
				if ($isList)
				{
					$enumPropertyValues = [];
					$enumPropertyValuesResult = CIBlockPropertyEnum::GetList([], ['ID' => $item]);
					$item = [];

					while ($enumPropertyValue = $enumPropertyValuesResult->GetNext())
					{
						$item[] = $enumPropertyValue['VALUE'];
					}
				}
				
				if (isset($propertyValues[$propertyCode]))
				{
					$propertyValues[$propertyCode] = array_merge($propertyValues[$propertyCode], $item);
				}
				else
				{
					$propertyValues[$propertyCode] = $item;
				}
			}
			else
			{
				if ($isList)
				{
					$item = CIBlockPropertyEnum::GetByID($item)['VALUE'];
				}

				if ($item)
				{
					$propertyValues[$propertyCode][] = $item;
				}
			}
		}
	}
}

if ($isServiceCentersMode)
{
	$arResult['TYPE_OF_PRODUCTS'] = array_unique($propertyValues['TYPE_OF_PRODUCTS']);
}

$arResult['METRO'] = array_unique($propertyValues['METRO']);
asort($arResult['METRO']);

if ($_REQUEST['metro'] && $arResult['METRO'])
{
	foreach ($arResult["ITEMS"] as $cell => $arElement)
	{
		if ($arElement['PROPERTIES']['METRO']['VALUE'] != $_REQUEST['metro'])
		{
			continue;
		}

		$arNewSort[] = $arElement;
	}

	$arResult["ITEMS"] = $arNewSort;
}
//p($arResult["ITEMS"]);
$arFilter = Array('IBLOCK_ID' => $arResult['IBLOCK_ID'], 'GLOBAL_ACTIVE' => 'Y',);
$db_list = CIBlockSection::GetList(Array('sort' => 'asc'), $arFilter, true);
while ($item = $db_list->fetch())
{
	//p($item);
	$arResult['SORTSECT'][$item['ID']] = array();
}


//p($arResult['IBLOCK_ID'])
//p($arResult['SORTSECT']);
//p($metro);
?>