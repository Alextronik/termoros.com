<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('main');
CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');

$brand = strtolower($_REQUEST['brand']);
//$brand = $_REQUEST['brand'];
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
	$priceXml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/1c-services/data/prices_full.xml');
	foreach($priceXml->A as $price)
	{
		foreach($price->Attributes() as $k => $v)
		{
			$v = trim($v);
			if ($k == "Id") $ID = $v;
			if ($k == "M") $brandXML = $v;
			if ($k == "AR") $article = $v;
			if ($k == "N") $name = $v;
			if ($k == "P") $price = $v;
			if ($k == "B") $noz = $v;
		}
		
		/*
		<A Id="15778115-12bc-11e7-80c6-005056011e39" PG="7c1bbcb8-c996-11e5-80d6-0cc47a1d8513" AR="065Z0152" M="Danfoss" N="Клапан регулирующий VRB3 15/1,0 нар. резьба" P="30826.76" EUD="407.92"/>
		*/
		$brandXML = strtolower((string)$brandXML);
		$pos = stripos($brandXML, $brand);
		
		if ($brandXML == $brand || $pos === 0)
		{
			$resElems[$ID] = array(
				"ARTICLE" => (string)$article, 
				"NAME" => $name, 
				"PRICE" => $price,
				"QUANTITY" => "0",
				"SALE" => $noz,
			);
		}
	}
	
	$storeXml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/1c-services/data/stores_full.xml');
	foreach($storeXml->A as $store)
	{
		foreach($store->Attributes() as $k => $v)
		{
			$v = trim($v);
			if ($k == "Id") $ID = $v;
			if ($k == "Ids") $storeXML = $v;
			if ($k == "C") $quantity = $v;
			if ($k == "M") $brandXML = $v;
		}
		
		$brandXML = strtolower((string)$brandXML);
		$pos = stripos($brandXML, $brand);
		
		if (($brand == $brandXML || $pos === 0) && $resElems[$ID] && $storeXML == '22856f9a-d990-11e7-80d1-00155d080a01')
		{
			$resElems[$ID]["QUANTITY"] = $quantity;
		}
		
	}
	
	foreach($resElems as $k => $v)
	{
		if ($storage)
		{
			if ($v["QUANTITY"]) $returnArray[] = $v;
		}
		else
		{
			$returnArray[] = $v;
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