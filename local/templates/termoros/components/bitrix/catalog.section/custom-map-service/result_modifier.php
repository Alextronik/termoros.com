<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

$isServiceCentersMode = isset($arParams['SERVICE_CENTERS_MODE']) && $arParams['SERVICE_CENTERS_MODE'];
//$metro = [];

if ($isServiceCentersMode)
{
	$typeOfProducts = [];
}

$properties = [];
$propertyCodes = ['BRANDS', 'TYPE_OF_PRODUCTS'];


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
$propertyValuesFilter = ['ACTIVE' => 'Y', 'SECTION_ID' => $arParams['SECTION_ID']];
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
					
					if ($item[0])
					{
						$enumPropertyValues = [];
						$enumPropertyValuesResult = CIBlockPropertyEnum::GetList([], ['ID' => $item]);
						
						$item = [];
						
						while ($enumPropertyValue = $enumPropertyValuesResult->GetNext())
						{
							$item[] = $enumPropertyValue['VALUE'];
						}
					}
				}
				
				if (isset($propertyValues[$propertyCode]))
				{
					if (!empty($item))
					{
						$propertyValues[$propertyCode] = array_merge($propertyValues[$propertyCode], $item);
					}
				}
				else
				{
					if (!empty($item))
					{
						$propertyValues[$propertyCode] = $item;
					}
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


$arResult['TYPE_OF_PRODUCTS'] = array_unique($propertyValues['TYPE_OF_PRODUCTS']);
$arResult['BRANDS'] = array_unique($propertyValues['BRANDS']);
asort($arResult['BRANDS']);
//asort($arResult['METRO']);


$arNewSort = array();

if ($_REQUEST['types'] && $arResult['TYPE_OF_PRODUCTS'])
{
	foreach ($arResult["ITEMS"] as $cell => $arElement)
	{
		if (!in_array($_REQUEST['types'], $arElement['PROPERTIES']['TYPE_OF_PRODUCTS']['VALUE']))
		{
			continue;
		}

		$arNewSort[$arElement["ID"]] = $arElement;
	}

	$arResult["ITEMS"] = $arNewSort;
}

if ($_REQUEST['brands'] && $arResult['BRANDS'])
{
	foreach ($arResult["ITEMS"] as $cell => $arElement)
	{
		
		$elemPropValues = array();
		$res = CIBlockElement::GetProperty(27, $arElement["ID"], array("sort", "asc"), array("CODE" => "BRANDS"));
		while ($ob = $res->GetNext())
		{
			$elemPropValues[] = $ob['VALUE_ENUM'];
		}
		
		if (empty($elemPropValues))
		{
			continue;
		}
		
		if (!in_array($_REQUEST['brands'], $elemPropValues)) continue;
		
		$arNewSort[$arElement["ID"]] = $arElement;
	}

	$arResult["ITEMS"] = $arNewSort;
}

if ($_REQUEST['brands'])
{
	$r = CIBlockElement::GetList(
	 Array("SORT"=>"ASC"),
	 Array("IBLOCK_ID" => 27, "ACTIVE" => "Y", "PROPERTY_BRANDS_VALUE" => $_REQUEST['brands']),
	 false,
	 false,
	 Array()
	);

	while($ar = $r->GetNext())
	{
		if ($ar["IBLOCK_SECTION_ID"])
		{
			$brandSects[] = $ar["IBLOCK_SECTION_ID"];
		}
	}
	$brandSects = array_unique($brandSects);
	
	foreach($arParams['SECTS'] as $name => $id)
	{
		if (in_array($id, $brandSects))
		{
			$resSects[$name] = $id;
		}
	}
	$arParams['SECTS'] = $resSects;
	
}
/*
foreach($arResult["ITEMS"] as $arItem)
{
	$newSects[] = $arItem['IBLOCK_SECTION_ID'];
	
}

$arResult['SECTS'] = array_unique($newSects);
foreach($arParams['SECTS'] as $name => $id)
{
	if (in_array($id, $newSects))
	{
		$resSects[$name] = $id;
	}
}
$arParams['SECTS'] = $resSects;
*/

$arFilter = Array('IBLOCK_ID' => $arResult['IBLOCK_ID']);
$db_list = CIBlockSection::GetList(Array('sort' => 'asc'), $arFilter, true);
while ($item = $db_list->fetch())
{
	$arResult['SORTSECT'][$item['ID']] = array();
	$arResult["ALL_SECTIONS"][$item["NAME"]] = $item['ID'];
}


//p($arResult['IBLOCK_ID'])
//p($arResult['SORTSECT']);
//p($metro);
?>