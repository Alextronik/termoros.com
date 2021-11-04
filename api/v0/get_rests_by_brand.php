<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('main');
CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');

$brand = $_REQUEST['brand'];
$partnerCode = $_REQUEST['partner_code'];
$storage = $_REQUEST['storage'];
$storeId = 208;

if (!$partnerCode)
{
	$returnArray['error'] = 'MISSING PARTNER CODE';
	echo json_encode($returnArray);
	die();
} else {
	$by = "timestamp_x";
	$order = "desc";
	$res = CUser::GetList(
	 $by,
	 $order,
	 array("XML_ID" => $partnerCode),
	 array()
	);
	$u = $res->GetNext();
	
	if (!$u)
	{
		$returnArray['error'] = 'WRONG PARTNER CODE';
		echo json_encode($returnArray);
		die();
	}
}


if ((int)$_REQUEST['store'])
{
	$storeId = (int)$_REQUEST['store'];
}

$returnArray = [];

$reqDump = print_r($_REQUEST, TRUE);
$fp = fopen('/home/bitrix/www/api/logs_v0/get_rests_by_brand.log', 'a+');
fwrite($fp, $reqDump);
fwrite($fp, date("Y-m-d H:i:s")."\r\n");
fclose($fp);

if ($brand)
{
	$brandCodes = getBrandXmlIdArrayByCode($brand);
	
	$r = CIblockElement::GetList(
		Array("SORT"=>"ASC"),
		Array("IBLOCK_ID"=>4, "PROPERTY_BREND"=>$brandCodes, "ACTIVE" => "Y"),
		false,
		false,
		Array("*", "PROPERTY_CML2_ARTICLE", "PROPERTY_TMR_SALE", 'PROPERTY_NOZ')
	);
	
	while($el = $r->GetNext())
	{
		
		//$jsonEl['ARTICLE'] = $el["PROPERTY_CML2_ARTICLE_VALUE"];
		$elements[$el["ID"]] = $el;
		$elementIds[] = $el["ID"];
	}
	
	$quantity = 0;
	$rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $elementIds, 'STORE_ID' => $storeId), false, false, array('PRODUCT_ID', 'STORE_ID', 'STORE_NAME', 'AMOUNT'));
	while($arStore = $rsStore->Fetch())
	{
		$elements[$arStore["PRODUCT_ID"]]["QUANTITY"] = $arStore['AMOUNT'];
	}

	foreach($elements as $element)
	{
		$elementProduct = CCatalogProduct::GetByID($element['ID']);
		
		$res = CPrice::GetList(
			array(),
			array(
					"PRODUCT_ID" => $elementProduct["ID"],
					"CATALOG_GROUP_ID" => 2
				)
		);
		if ($ar = $res->Fetch())
		{
			$elements[$element['ID']]['PRICE'] = $ar["PRICE"];
		}
		
		$jsonEl = array();
		
		
		
		if ($storage)
		{
			if ($elements[$element['ID']]['QUANTITY'] > 0)
			{
				$jsonEl['ARTICLE'] = $element["PROPERTY_CML2_ARTICLE_VALUE"];
				$jsonEl['QUANTITY'] = $elements[$element['ID']]['QUANTITY'];
				$jsonEl['PRICE'] = $elements[$element['ID']]['PRICE'];
				$jsonEl['NAME'] = $element['NAME'];
				$jsonEl['SALE'] = 0;
				if ($element["PROPERTY_NOZ_VALUE"]) $jsonEl['SALE'] = 1;
				
			}
		}
		else
		{
			$jsonEl['ARTICLE'] = $element["PROPERTY_CML2_ARTICLE_VALUE"];
			$jsonEl['QUANTITY'] = $elements[$element['ID']]['QUANTITY'];
			$jsonEl['PRICE'] = $elements[$element['ID']]['PRICE'];
			$jsonEl['NAME'] = $element['NAME'];
			$jsonEl['SALE'] = 0;
			if ($element["PROPERTY_NOZ_VALUE"]) $jsonEl['SALE'] = 1;
		}
		
		if ($jsonEl)
		{
			$returnArray[] = $jsonEl;
		}
	}
	
	
	
	
	if (!$returnArray)
	{
		$returnArray['error'] = 'MISSING ELEMENTS';
		echo json_encode($returnArray);
		die();
	}
}

if (empty($returnArray))
{
	$returnArray['error'] = 'MISSING ARTICLE';
}

echo json_encode($returnArray);
?>