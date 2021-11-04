<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('main');
CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');

$article = $_REQUEST['article'];
$partnerCode = $_REQUEST['partner_code'];
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
$fp = fopen('/home/bitrix/www/api/logs_v0/get_element.log', 'a+');
fwrite($fp, $reqDump);
fwrite($fp, date("Y-m-d H:i:s")."\r\n");
fclose($fp);

if ($article)
{
	$res = CIblockElement::GetList(
		Array("SORT"=>"ASC"),
		Array("IBLOCK_ID"=>4, "ACTIVE" => "Y", "PROPERTY_CML2_ARTICLE"=>$article),
		false,
		array("nTopCount"=>1),
		Array("*", "PROPERTY_CML2_ARTICLE")
	);
	
	$element = $res->GetNext();
	if (!$element)
	{
		$returnArray['error'] = 'MISSING ARTICLE';
		echo json_encode($returnArray);
		die();
	}
	
	$returnArray['ARTICLE'] = $element["PROPERTY_CML2_ARTICLE_VALUE"];
	
	
	$quantity = 0;
	$rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $element['ID'], 'STORE_ID' => $storeId), false, false, array('PRODUCT_ID', 'STORE_ID', 'STORE_NAME', 'AMOUNT'));
	$arStore = $rsStore->Fetch();
	if ($arStore) $returnArray['QUANTITY'] = $arStore['AMOUNT'];
	
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
		$returnArray['PRICE'] = $ar["PRICE"];
	}
}

if (empty($returnArray))
{
	$returnArray['error'] = 'MISSING ARTICLE';
}

echo json_encode($returnArray);
?>