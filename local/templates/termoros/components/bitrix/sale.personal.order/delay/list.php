<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $USER;

	if($_REQUEST['action']=='cancel'&&$_REQUEST['ID']!=''){
		$orders = getDelayOrders();	
		
		if(is_array($orders)){
			
			unset($orders[$_REQUEST['ID']]);
			
			$user = new CUser;	
			$fields = Array( 
				"UF_ORDS" =>serialize($orders), 
			); 
			$user->Update($USER->GetID(), $fields);		
		}	
		
		
		localredirect('/personal/delayorder/');
	}
	elseif($_REQUEST['action']=='copy'&&$_REQUEST['ID']!=''){
		CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
		$orders = getDelayOrders();	
		
		//p($orders[$_REQUEST['ID']]['ITEMS']);
		foreach($orders[$_REQUEST['ID']]['ITEMS'] as $id => $quan){
			
			Add2BasketByProductID($id, $quan);
			
		}
		localredirect('/personal/cart/');
	}
	


if($_REQUEST['ID']!=''&&!$_REQUEST['action']){
$arDetParams = array(
		"PATH_TO_LIST" => $arResult["PATH_TO_LIST"],
		"PATH_TO_CANCEL" => $arResult["PATH_TO_CANCEL"],
		"PATH_TO_PAYMENT" => $arParams["PATH_TO_PAYMENT"],
		"SET_TITLE" =>$arParams["SET_TITLE"],
		"ID" => $arResult["VARIABLES"]["ID"],
		"ACTIVE_DATE_FORMAT" => $arParams["ACTIVE_DATE_FORMAT"],

		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

		"CUSTOM_SELECT_PROPS" => $arParams["CUSTOM_SELECT_PROPS"]
	);

foreach($arParams as $key => $val)
{
	if(strpos($key, "PROP_") !== false)
		$arDetParams[$key] = $val;
}

$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.detail",
	"delaydetail",
	$arDetParams,
	$component
);
	
}
else
{
	
	

$arChildParams = array(
	"PATH_TO_DETAIL" => $arResult["PATH_TO_DETAIL"],
	"PATH_TO_CANCEL" => $arResult["PATH_TO_CANCEL"],
	"PATH_TO_COPY" => $arResult["PATH_TO_LIST"].'?ID=#ID#',
	"PATH_TO_BASKET" => $arParams["PATH_TO_BASKET"],
	"SAVE_IN_SESSION" => $arParams["SAVE_IN_SESSION"],
	"ORDERS_PER_PAGE" => $arParams["ORDERS_PER_PAGE"],
	"SET_TITLE" =>$arParams["SET_TITLE"],
	"ID" => $arResult["VARIABLES"]["ID"],
	"NAV_TEMPLATE" => $arParams["NAV_TEMPLATE"],
	"ACTIVE_DATE_FORMAT" => $arParams["ACTIVE_DATE_FORMAT"],
	"HISTORIC_STATUSES" => $arParams["HISTORIC_STATUSES"],

	"CACHE_TYPE" => $arParams["CACHE_TYPE"],
	"CACHE_TIME" => $arParams["CACHE_TIME"],
	"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
);

foreach ($arParams as $key => $val)
	if(strpos($key, "STATUS_COLOR_") !== false && strpos($key, "~") !== 0)
		$arChildParams[$key] = $val;

	
$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.list",
	"delaylist",
	$arChildParams,
	$component
);
}
?>