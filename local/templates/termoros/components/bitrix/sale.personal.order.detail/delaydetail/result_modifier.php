<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("catalog");

$cp = $this->__component;
if (is_object($cp))
{
	CModule::IncludeModule('iblock');

	if(empty($arResult['ERRORS']['FATAL']))
	{

		$hasDiscount = false;
		$hasProps = false;
		$productSum = 0;
		$basketRefs = array();

		$noPict = array(
			'SRC' => $this->GetFolder().'/images/no_photo.png'
		);

		if(is_readable($nPictFile = $_SERVER['DOCUMENT_ROOT'].$noPict['SRC']))
		{
			$noPictSize = getimagesize($nPictFile);
			$noPict['WIDTH'] = $noPictSize[0];
			$noPict['HEIGHT'] = $noPictSize[1];
		}

		foreach($arResult["BASKET"] as $k => &$prod)
		{
			if(floatval($prod['DISCOUNT_PRICE']))
				$hasDiscount = true;

			// move iblock props (if any) to basket props to have some kind of consistency
			if(isset($prod['IBLOCK_ID']))
			{
				$iblock = $prod['IBLOCK_ID'];
				if(isset($prod['PARENT']))
					$parentIblock = $prod['PARENT']['IBLOCK_ID'];

				foreach($arParams['CUSTOM_SELECT_PROPS'] as $prop)
				{
					$key = $prop.'_VALUE';
					if(isset($prod[$key]))
					{
						// in the different iblocks we can have different properties under the same code
						if(isset($arResult['PROPERTY_DESCRIPTION'][$iblock][$prop]))
							$realProp = $arResult['PROPERTY_DESCRIPTION'][$iblock][$prop];
						elseif(isset($arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop]))
							$realProp = $arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop];
						
						if(!empty($realProp))
							$prod['PROPS'][] = array(
								'NAME' => $realProp['NAME'], 
								'VALUE' => htmlspecialcharsEx($prod[$key])
							);
					}
				}
			}

			// if we have props, show "properties" column
			if(!empty($prod['PROPS']))
				$hasProps = true;

			$productSum += $prod['PRICE'] * $prod['QUANTITY'];

			$basketRefs[$prod['PRODUCT_ID']][] =& $arResult["BASKET"][$k];

			if(!isset($prod['PICTURE']))
				$prod['PICTURE'] = $noPict;
		}

		$arResult['HAS_DISCOUNT'] = $hasDiscount;
		$arResult['HAS_PROPS'] = $hasProps;

		$arResult['PRODUCT_SUM_FORMATTED'] = SaleFormatCurrency($productSum, $arResult['CURRENCY']);

		if($img = intval($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE_ID']))
		{

			$pict = CFile::ResizeImageGet($img, array(
				'width' => 150,
				'height' => 90
			), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);

			if(strlen($pict['src']))
				$pict = array_change_key_case($pict, CASE_UPPER);

			$arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'] = $pict;
		}

	}
}
	$arResult["ORDERS"] = getDelayOrders();
	krsort($arResult["ORDERS"]);
	
	$arProductsIndex = $arResult["ORDERS"][$_REQUEST['ID']]['ITEMS'];

	foreach ($arProductsIndex as $k => $arItem)
		{
			$arProducts[] = $k;
		}

	//$arPackages = getPackage($w=60,$h=60);
	//p($arPackages);
	$measures = array(
			1 => "м",
			2 => "л.",
			3 => "г",
			4 => "кг",
			5 => "шт",
		);
	
	//p($arProducts);
	
	if($arProducts)
	{
		$arSelect = Array("NAME","ID","PROPERTY_CML2_ATTRIBUTES","IBLOCK_ID","DETAIL_PICTURE","DETAIL_PAGE_URL");
		$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "ID"=>$arProducts);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($obRes = $res->GetNextElement())
		{	
			//p($arRes);
			//p($arRes['PROPERTY_VID_UPAKOVKI_VALUE']);
			$arFields = $obRes->getFields();
			$arProps = $obRes->getProperties();
			//p($arProps);
			
			
			$price = CCatalogProduct::GetOptimalPrice($arFields['ID'], 1);
			$arResult['PRICES'][$arFields['ID']] = $price['PRICE']['PRICE'];
			//p($arResult['PRICES'][$arFields['ID']]);
			
			$arcat = CCatalogProduct::GetByID($arFields['ID']);
			//p($arcat['MEASURE']);
			if($arcat['MEASURE']&&!$arProps["CML2_BASE_UNIT"]["VALUE"]) $arProps["CML2_BASE_UNIT"]["VALUE"] = $measures[$arcat['MEASURE']];
			
			$arResult['FIELDS'][$arFields['ID']] = $arFields;		
			$arResult['PROPERTIES'][$arFields['ID']] = $arProps;			
			$arLink[$arFields['ID']] = $arProps['CML2_LINK']['VALUE'];	
			$arLink2[$arProps['CML2_LINK']['VALUE']][] = $arFields['ID'];				
		}		
	}
	
	if($arLink)
	{
		$arSelect = Array("NAME", "PREVIEW_PICTURE","ID","PROPERTY_CML2_ATTRIBUTES","IBLOCK_ID","DETAIL_PAGE_URL");
		$arFilter = Array("IBLOCK_ID"=>5, "ACTIVE"=>"Y","ID"=>$arLink);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($obRes = $res->GetNextElement())
		{	
			$arFields = $obRes->getFields();
			$arProps = $obRes->getProperties();		
			//p($arProps);
			foreach($arLink2[$arFields['ID']] as $offer_id)
			{
				$arResult['FIELDS'][$offer_id] = $arFields;	
				$arResult['PRODUCT_PROPS'][$offer_id] = $arProps;
			}			
		}		
	}	/**/
?>