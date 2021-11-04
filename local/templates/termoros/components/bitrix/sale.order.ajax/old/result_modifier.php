<?
if($USER->GetID())
{
	$arSelect = Array("ID","IBLOCK_ID","PROPERTY_*");
	$arFilter = Array("IBLOCK_ID"=>7, "PROPERTY_USER_ID"=>$USER->GetID());
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();
        $arLocs = CSaleLocation::GetByID($arProps["CITY"]["VALUE"], LANGUAGE_ID);
        $adrName=$arLocs["CITY_NAME"].", ".$arProps["STREET"]["VALUE"].", ".$arProps["HOUSE"]["VALUE"];
        $arResult['ADR'][]=array("ID"=>$arFields["ID"],"NAME"=>$adrName);
	}
}

if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
{
    if(strlen($arResult["REDIRECT_URL"]) == 0) {
        $arResult['DELIVERY']= CSaleDelivery::GetByID($arResult['ORDER']['DELIVERY_ID']);
        $db_props = CSaleOrderPropsValue::GetOrderProps($arResult["ORDER_ID"]);
        while ($arProps = $db_props->Fetch())
        {
            if($arProps["ORDER_PROPS_ID"]=="37"&&$arProps["VALUE"]<>"") {
				//p($arProps);
                $arResult["ORDER_ID2"] = $arProps["VALUE"];
                break;
            }
        }
        if(!empty($arResult["ORDER_ID2"])){
            $Order = CSaleOrder::GetByID($arResult["ORDER_ID2"]);
			//p($Order);
            $Order['DELIVERY'] = CSaleDelivery::GetByID($Order['DELIVERY_ID']);
			$res = CSalePaySystemAction::GetList(
			 array(),
			 array('PAY_SYSTEM_ID'=>$Order['PAY_SYSTEM_ID'])
			);
			
			$arPay = $res->Fetch();
			
            $Order['PAY_SYSTEM'] = $arPay;
            $arResult['ORDER2'] = $Order;
        }
    }
}

//p($arResult['ORDER2']);
?>