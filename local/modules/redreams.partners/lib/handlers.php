<?php
/**
 * Created by PhpStorm.
 * User: bearl
 * Date: 05.07.2016
 * Time: 2:47
 */

namespace Redreams\Partners;


class handlers
{
    public $userID;

    function OnBeforeBasketUpdateAfterCheck($ID, &$arFields)
    {
        if($arFields['CAN_BUY'] == 'Y')
        {
            $params['ID'] = $ID;
            $params['fields'] = $arFields;
            $discount = \Redreams\Partners\discounts::getInstance($params);
            $discount->getBasket();
            $arFields = $discount->processDiscount();

        }
    }

    function OnSaleComponentOrderOneStepPersonType(&$arResult, &$arUserResult, &$arParams)
    {
        if(\Redreams\Partners\partner::isPartner())
        {
            global $USER;
            $userID = $USER->GetID();
            $arResult["ORDER_PROP1"]=$arUserResult;
            $contractorId = \Redreams\Partners\contractor::getCurentContractor();
            if($contractorId == "")
            {
                $db_sales = \CSaleOrderUserProps::GetList(array("DATE_UPDATE" => "DESC"), array("USER_ID" => $USER->GetID()));

                if ($ar_sales = $db_sales->Fetch())
                {
                    $contractorId = $ar_sales["ID"];
                    \Redreams\Partners\contractor::setContractor($ar_sales["ID"]);

                }
            }

            $curentContractor = \CSaleOrderUserProps::GetByID($contractorId);
			
			
			//v($curentContractor['PERSON_TYPE_ID']);
			
			if ($arResult["ORDER_PROP1"]["PERSON_TYPE_ID"] != $arResult["ORDER_PROP1"]["PERSON_TYPE_OLD"] && $arResult["ORDER_PROP1"]["PERSON_TYPE_OLD"])
			{
				$_REQUEST['profile_change'] = 'Y';
			}
  		
			
			//if ($arResult["PERSON_TYPE"][1]["CHECKED"] == "Y")
		
			
			/*
			if ($arResult["PERSON_TYPE"][$curentContractor['PERSON_TYPE_ID']]["CHECKED"] == 'Y')
			{
				
			}
			else
			{
				$arUserResult['PROFILE_CHANGE'] = 'Y';
			}
			*/
			
            if($curentContractor && !$arUserResult['PROFILE_CHANGE'] && $_REQUEST['profile_change'] != 'Y' && !$_REQUEST['PERSON_TYPE'])
            {
                //p($ar);
                $arUserResult['PERSON_TYPE_ID'] = $curentContractor['PERSON_TYPE_ID'];
                $arUserResult['PROFILE_ID'] = $curentContractor['ID'];
                $arUserResult['PROFILE_CHANGE'] = "Y";
                foreach($arResult["PERSON_TYPE"] as $k => &$v)
                {
                    if($k==$curentContractor['PERSON_TYPE_ID'])
                    {
                        $v['CHECKED'] = "Y";
                    }
                    else
                    {
                        $v['CHECKED'] = "";
                    }
                }
                $arResult["CHANGE_PERSON_TYPE_ID"] =  'Y';
                $arResult["ORDER_PROP2"]=$arUserResult;
            }
        }
    }
    function OnSaleComponentOrderOneStepOrderProps(&$arResult, &$arPropertyResult, &$arParams)
    {
        if($arResult["CHANGE_PERSON_TYPE_ID"] == "Y")
        {

        }
    }
}