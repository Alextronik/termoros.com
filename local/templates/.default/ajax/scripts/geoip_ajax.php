<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
session_start();
?>
<?
if (CModule::IncludeModule("sale"))
{
	CModule::IncludeModule("main");
	
	global $USER;
	
    if (($_REQUEST['action'] == "SETGEO") && IntVal($_REQUEST['id'])>0)
    {
		CModule::IncludeModule("sale");
		$res = \Bitrix\Sale\Location\LocationTable::getList(array(
			'filter' => array("!CITY_ID" => false, "ID" => $_REQUEST['id']),
			'select' => array('*', 'NAME_RU' => 'NAME.NAME')
		));
		while($item = $res->fetch())
		{
			//p($item);			
			//$arCityIds[$item['NAME_RU']] = $item['ID'];
			$_REQUEST['id'] = $item['ID'];
			$_REQUEST['city'] = $item['NAME_RU'];
		}
		
		$_SESSION['GEOIP']['curr_city_id'] = $_REQUEST['id'];
		$_SESSION['GEOIP']['curr_city_name'] = $_REQUEST['city'];
	
		CModule::IncludeModule("iblock");
		
		$arSelect = Array('IBLOCK_ID','NAME','ID');
		$arFilter = Array("IBLOCK_ID"=>23, "ACTIVE"=>"Y", "NAME" => $_SESSION['GEOIP']['curr_city_name']);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageCount"=>1), $arSelect);
		while($ob = $res->GetNextElement())
		{
			//p($ob->GetProperty('PHONE'));
			$arPhones = $ob->GetProperty('PHONE');
			
		}
		
		if($arPhones['VALUE'])
			$_SESSION['GEOIP']['curr_phones'] = $arPhones['VALUE'];
		else
			$_SESSION['GEOIP']['curr_phones'] = array();
	
		echo 'true';
    }
	elseif (($_REQUEST['action'] == "SETGEO") && IntVal($_REQUEST['id']) == 0 && $_REQUEST['city'])
    {
		//p($_REQUEST);
		CModule::IncludeModule("sale");
		$res = \Bitrix\Sale\Location\LocationTable::getList(array(
			'filter' => array("!CITY_ID" => false, "%NAME_RU" => $_REQUEST['city']),
			'select' => array('*', 'NAME_RU' => 'NAME.NAME')
		));
		while($item = $res->fetch())
		{
			//p($item);			
			//$arCityIds[$item['NAME_RU']] = $item['ID'];
			$_REQUEST['id'] = $item['ID'];
			$_REQUEST['city'] = $item['NAME_RU'];
		}
		
		$_SESSION['GEOIP']['curr_city_id'] = $_REQUEST['id'];
		$_SESSION['GEOIP']['curr_city_name'] = $_REQUEST['city'];
	
		CModule::IncludeModule("iblock");
		
		$arSelect = Array('IBLOCK_ID','NAME','ID');
		$arFilter = Array("IBLOCK_ID"=>23, "ACTIVE"=>"Y", "NAME" => $_SESSION['GEOIP']['curr_city_name']);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageCount"=>1), $arSelect);
		while($ob = $res->GetNextElement())
		{
			//p($ob->GetProperty('PHONE'));
			$arPhones = $ob->GetProperty('PHONE');
			
		}
		
		if($arPhones['VALUE'])
			$_SESSION['GEOIP']['curr_phones'] = $arPhones['VALUE'];
		else
			$_SESSION['GEOIP']['curr_phones'] = array();
	
		echo 'true';
		
	}
	
	if ($_SESSION['GEOIP']['curr_city_id'] && $USER->GetID())
	{
		$u = new CUser;
		$fields = array('UF_GEO'=>$_SESSION['GEOIP']['curr_city_id']);
		$u->Update($USER->GetID(), $fields);
	}
	
}
?>