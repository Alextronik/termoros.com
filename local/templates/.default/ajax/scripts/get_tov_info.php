<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");



\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('iblock');
global $USER;
if(!empty($_REQUEST['ATR']))
{
	$elem = CIBlockElement::GetList(array(), array(
		"=PROPERTY_CML2_ARTICLE" => trim($_REQUEST['ATR']), "CATALOG_AVAILABLE" => "Y", "ACTIVE" => "Y"
	), false, false, array("ID"))->Fetch();
	if ($elem["ID"])
	{
		$arResult["ID"] = $elem["ID"];
		$arPrice = CCatalogProduct::GetOptimalPrice($elem["ID"], 1, $USER->GetUserGroupArray());
		$arResult["PRICE"] = $arPrice["DISCOUNT_PRICE"];
		
		$price_res = CPrice::GetList(
			array(),
			array(
				"PRODUCT_ID" => $arResult["ID"],
				"CATALOG_GROUP_ID" => 2
			)
		);
		$price = $price_res->Fetch();
		$arResult["PRICE"] = $price["PRICE"];
		
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($arResult);
		die();
	}
	
	$clearArticle = preg_replace("/[^A-Za-z0-9]/","",trim($_REQUEST['ATR']));
	$elem = CIBlockElement::GetList(array(), array(
		"=PROPERTY_CLEAR_ARTICLE" => $clearArticle, "CATALOG_AVAILABLE" => "Y", "ACTIVE" => "Y"
	), false, false, array("ID"))->Fetch();
	if ($elem["ID"])
	{
		$arResult["ID"] = $elem["ID"];
		$arPrice = CCatalogProduct::GetOptimalPrice($elem["ID"], 1, $USER->GetUserGroupArray());
		$arResult["PRICE"] = $arPrice["DISCOUNT_PRICE"];
		
		$price_res = CPrice::GetList(
			array(),
			array(
				"PRODUCT_ID" => $arResult["ID"],
				"CATALOG_GROUP_ID" => 2
			)
		);
		$price = $price_res->Fetch();
		$arResult["PRICE"] = $price["PRICE"];
		
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($arResult);
		die();
	}
	
	$elem = CIBlockElement::GetList(array(), array(
		"NAME" => trim($_REQUEST['ATR']).'%', "CATALOG_AVAILABLE" => "Y", "ACTIVE" => "Y"
	), false, false, array("ID"))->Fetch();
	if ($elem["ID"])
	{
		$arResult["ID"] = $elem["ID"];
		$arPrice = CCatalogProduct::GetOptimalPrice($elem["ID"], 1, $USER->GetUserGroupArray());
		$arResult["PRICE"] = $arPrice["DISCOUNT_PRICE"];
		
		$price_res = CPrice::GetList(
			array(),
			array(
				"PRODUCT_ID" => $arResult["ID"],
				"CATALOG_GROUP_ID" => 2
			)
		);
		$price = $price_res->Fetch();
		$arResult["PRICE"] = $price["PRICE"];
		
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($arResult);
		die();
	}
	
	
	
}
