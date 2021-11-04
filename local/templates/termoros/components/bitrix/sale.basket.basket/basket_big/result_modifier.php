<?


foreach($arResult['GRID']['ROWS'] as $Item)
{
        $mxResult = CCatalogSku::GetProductInfo($Item["PRODUCT_ID"]);
        if (is_array($mxResult)&&!in_array($Item["PRODUCT_ID"],$tov))
        {
            $tov[$Item["PRODUCT_ID"]] = $mxResult["ID"];
        }
        else if(!in_array($Item["PRODUCT_ID"],$tov))
        {
            $tov[$Item["PRODUCT_ID"]] = $Item["PRODUCT_ID"];
        }

}
//p($tov);
//print_r($tov);
//die();
//$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");

	
$measures = array(
			1 => "м",
			2 => "л.",
			3 => "г",
			4 => "кг",
			5 => "шт",
		);

if($tov){
$arFilter = Array("IBLOCK_ID"=>array(4, 35), "ID"=>$tov );
$res = CIBlockElement::GetList(Array(), $arFilter, false,false, Array());
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
    $arProps = $ob->GetProperties();
		
	$arcat = CCatalogProduct::GetByID($arFields['ID']);
	//p($arcat['MEASURE']);
	if($arcat['MEASURE']&&!$arProps["CML2_BASE_UNIT"]["VALUE"]) $arProps["CML2_BASE_UNIT"]["VALUE"] = $measures[$arcat['MEASURE']];
	//p($arProps["CML2_BASE_UNIT"]["VALUE"]);
	
	$arResult["Tov"][$arFields['ID']] = $arProps;
	$arResult["Tov"][$arFields['ID']]['FIELDS'] = $arFields;
}
$arResult["arTov"]=$tov;
}

if($_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID']){

//p($_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID']);	
	
$rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $tov, 'STORE_ID' => $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID']), false, false, array('PRODUCT_ID', 'STORE_ID', 'STORE_NAME', 'AMOUNT')); 
while($arStore = $rsStore->Fetch()){
	//p($arStore);
	//preg_match('/\((.+)\)/', $arStore['STORE_NAME'], $rpl);
	//p($rpl[1]);
	//$cityName = $rpl[1];
	$arResult['QUANTS'][$arStore['PRODUCT_ID']] = $arStore['AMOUNT'];
	
	
}

}

\Bitrix\Main\Loader::includeModule("redreams.supply");

$curCityId = $_SESSION['GEOIP']['curr_city_id'] ? $_SESSION['GEOIP']['curr_city_id'] : $_SESSION['GEOIP']["city_list"][$_SESSION['GEOIP']['city']];
foreach ($_SESSION['STORES'] as $store)
{
	if($store["CITY_ID"] == $curCityId)
	{
		$arResult["SUPPLY"] = $store["ID"];
	}
}
//p($_SESSION['STORES']);
?>