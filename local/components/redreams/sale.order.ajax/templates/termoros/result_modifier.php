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
\Bitrix\Main\Loader::includeModule('redreams.partners');
?>

<?
if(Redreams\Partners\partner::isPartner())
{
    $ob_adress = new Redreams\Partners\adress();
    $arResult['adresses'] = $ob_adress->getlist(['UF_PARTNER' => $USER->GetID()]);
    //p($adresses);
   /* $arResult['curentContractor'] = \Redreams\Partners\contractor::getCurentContractor();
    //p($arResult['curentContractor']);

    if($_REQUEST['profile_change'] != 'Y')
    {
        if($arResult['curentContractor'])
        {
            //p($arResult["ORDER_PROP"]["USER_PROFILES"]);
            foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as &$arUserProfiles)
            {
                if($arUserProfiles['ID'] == $arResult['curentContractor'])
                {
                    $arUserProfiles['CHECKED'] = 'Y';
                }
                else
                {
                    unset($arUserProfiles['CHECKED']);
                }
            }
        }
    }*/
}
if(Redreams\Partners\partner::isOperator())
{
	
	$rsUser = CUser::GetByID($USER->GetID());
	$arUser = $rsUser->Fetch();

	if ($arUser["UF_OPERATOR_CONTRACTOR_XML_ID"][0])
	{
		$contractorID = $arUser["UF_OPERATOR_CONTRACTOR_XML_ID"][0];
	}
	
	if ($contractorID)
	{
		$prop = \CSaleOrderUserProps::GetList(array(),[
				'ID'=> $contractorID,
			],false,false,array('*')
		)->Fetch();
		
		$contractor = $prop;
		$arResult["PERSON_TYPE_ID"] = $prop["PERSON_TYPE_ID"];
		$arResult["PERSON_NAME"] = $contractor["NAME"];

		if($prop['ID'])
		{
			unset($arResult["ORDER_PROP"]["USER_PROPS_Y"]);
			
			$fieldsFilter = [
				"USER_PROPS_ID" => $prop['ID'],
			];

			$r = \CSaleOrderUserPropsValue::GetList([],$fieldsFilter);
			
			
			
			while($property = $r->Fetch())
			{
				if ($property["PROP_TYPE"] == "STRING") $property["TYPE"] = 'TEXT';
				elseif ($property["PROP_TYPE"] == "LOCATION") $property["TYPE"] = 'LOCATION';
				
				$property["PROPS_GROUP_ID"] = $property["PROP_PROPS_GROUP_ID"];
				$property["CODE"] = $property["PROP_CODE"];
				$property["REQUIED_FORMATED"] = $property["PROP_REQUIED"];
				
				$property["FIELD_NAME"] = 'ORDER_PROP_'.$property["ORDER_PROPS_ID"];
				$property["ID"] = $property["ORDER_PROPS_ID"];
				
				$arResult["ORDER_PROP"]["USER_PROPS_Y"][] = $property;
			}
		}
	}
	
}