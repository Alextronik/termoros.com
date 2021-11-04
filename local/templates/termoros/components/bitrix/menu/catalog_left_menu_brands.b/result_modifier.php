<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;
use Bitrix\Iblock;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;


if (empty($arResult))
	return;


$hlblock = HL\HighloadBlockTable::getById(3)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
$entity_table_name = $hlblock['TABLE_NAME'];

$url = explode('/', $APPLICATION->GetCurDir());

//p($url);

if($url[2]){

	$arFilter = array("UF_NAME" => $url[2]); //задаете фильтр по вашим полям

	$sTableID = 'tbl_'.$entity_table_name;
	$rsData = $entity_data_class::getList(array(
	"select" => array('*'), //выбираем все поля
	"filter" => $arFilter,
	"order" => array("UF_SORT"=>"ASC") // сортировка по полю UF_SORT, будет работать только, если вы завели такое поле в hl'блоке
	));
	$rsData = new CDBResult($rsData, $sTableID);
	if($arRes = $rsData->Fetch()){
		//p($arRes);
		$BRAND_XMLID = $arRes['UF_XML_ID'];
		$arResult['BRAND_XMLID'] = $BRAND_XMLID;
	}

	if($BRAND_XMLID){
		$arSelect = Array('IBLOCK_ID', "ID", 'NAME','IBLOCK_SECTION_ID');
		$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "PROPERTY_BREND" => $BRAND_XMLID,);
		//$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>70), $arSelect);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNext())
		{
			//p($ob['IBLOCK_SECTION_ID']);
			$arSectsId[] = $ob['IBLOCK_SECTION_ID'];
		//p($ob->GetProperty('PHONE'));
		//$arBrends = $ob->GetFields();

		}
		$arSectsId = array_unique($arSectsId);
	}

}
	//p($arSectsId);
if($arSectsId){
	
	$arFilter = array('IBLOCK_ID' => 4, 'ACTIVE' => 'Y', "ID" => $arSectsId); 
	$arSelect = array('ID', 'NAME', "CODE");
	$rsSection = CIBlockSection::GetTreeList($arFilter, $arSelect); 
	while($arSection = $rsSection->Fetch()) {
	   //p($arSection);
	   $Sections[] = $arSection;
	}
	
}

if($Sections){

foreach($Sections as $sect){
	
	foreach($arResult as $arItem){
		if(strripos($arItem['LINK'], $sect['CODE'])){
			$arResult['BRANDS'][] = $arItem;
		}
		
	}
}

}
//p($arResult['BRANDS']);

$arMenuItemsIDs = array();
$arAllItems = array();
/*
foreach($arResult as $arItem)
{
	$arItem["PARAMS"]["item_id"] = crc32($arItem["LINK"]);

	if ($arItem["DEPTH_LEVEL"] == "1")
	{
		$arMenuItemsIDs[$arItem["PARAMS"]["item_id"]] = array();
		if ($arItem["IS_PARENT"])
		{
			$curItemLevel_1 = $arItem["PARAMS"]["item_id"];
		}
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
	elseif($arItem["DEPTH_LEVEL"] == "2")
	{
		$arMenuItemsIDs[$curItemLevel_1][$arItem["PARAMS"]["item_id"]] = array();
		if ($arItem["IS_PARENT"])
		{
			$curItemLevel_2 = $arItem["PARAMS"]["item_id"];
		}
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
	elseif($arItem["DEPTH_LEVEL"] == "3")
	{
		$arMenuItemsIDs[$curItemLevel_1][$curItemLevel_2][$arItem["PARAMS"]["item_id"]] = array();
		if ($arItem["IS_PARENT"])
		{
			$curItemLevel_3 = $arItem["PARAMS"]["item_id"];
		}
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
	elseif($arItem["DEPTH_LEVEL"] == "4")
	{
		$arMenuItemsIDs[$curItemLevel_1][$curItemLevel_2][$curItemLevel_3][] = $arItem["PARAMS"]["item_id"];
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
}*/

//$arResult = array();
$arResult["ALL_ITEMS"] = $arAllItems;
$arResult["ALL_ITEMS_ID"] = $arMenuItemsIDs;
?>

