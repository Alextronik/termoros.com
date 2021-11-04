<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//

use Bitrix\Highloadblock as HL;

global $APPLICATION;

$HighloadBlockId = 3;


$aMenuLinksExt = array();

if(CModule::IncludeModule('iblock') && CModule::IncludeModule("highloadblock"))
{
	global $USER;
	$arFilter = array(
		"TYPE" => "1c_catalog",
		"SITE_ID" => SITE_ID,
	);

	$dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), $arFilter);
	$dbIBlock = new CIBlockResult($dbIBlock);

	if ($arIBlock = $dbIBlock->GetNext())
	{
		//print_r($arIBlock );
		if(defined("BX_COMP_MANAGED_CACHE"))
			$GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_".$arIBlock["ID"]);

		if($arIBlock["ACTIVE"] == "Y")
		{
			$code = explode('/', $APPLICATION->GetCurDir())[2];

			$hlblock = HL\HighloadBlockTable::getById($HighloadBlockId)->fetch();
			
			$entity = HL\HighloadBlockTable::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();

			$res = $entity_data_class::getList(array(
				"select" => array("UF_XML_ID"), "filter" => array("UF_LINK" => $code),
			));
			
			$rsData = $res->fetch();
			
			$brandCodes = getBrandXmlIdArrayByCode($code);
			
			$rs = CIBlockElement::GetList(
			 Array("SORT"=>"ASC"),
			 Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "PROPERTY_BREND" => $brandCodes),
			 //Array("IBLOCK_ID"=>4, "ACTIVE"=>1),
			 false,
			 array('nTopCount' => 1),
			 Array('*', 'PROPERTY_BREND')
			);
			$el = $rs->GetNext();
			
			
			//v($rsData);
			$aMenuLinksExt = $APPLICATION->IncludeComponent("redreams:menu.sections", "", array(
				"IS_SEF" => "Y",
				"SEF_BASE_URL" => "/catalog/",
				"SECTION_PAGE_URL" => '#SECTION_CODE_PATH#/filter/brend-is-' . $el["PROPERTY_BREND_VALUE"] . '/apply/',
				"DETAIL_PAGE_URL" => $arIBlock['DETAIL_PAGE_URL'],
				"IBLOCK_TYPE" => $arIBlock['IBLOCK_TYPE_ID'],
				"IBLOCK_ID" => $arIBlock['ID'],
				"DEPTH_LEVEL" => "4",
				"CACHE_TYPE" => "Y",
			), false, Array('HIDE_ICONS' => 'Y'));

			/*
			$aMenuLinksExtFull = [];
			while($rsData = $entity_data_class::getList(array(
				"select" => array("UF_XML_ID"), "filter" => array("UF_LINK" => $code),
			))->fetch())
			{

				$aMenuLinksExt = $APPLICATION->IncludeComponent("redreams:menu.sections", "", array(
					"IS_SEF" => "Y",
					"SEF_BASE_URL" => "/catalog/",
					"SECTION_PAGE_URL" => '#SECTION_CODE_PATH#/filter/brend-is-' . $rsData["UF_XML_ID"] . '/apply/',
					"DETAIL_PAGE_URL" => $arIBlock['DETAIL_PAGE_URL'],
					"IBLOCK_TYPE" => $arIBlock['IBLOCK_TYPE_ID'],
					"IBLOCK_ID" => $arIBlock['ID'],
					"DEPTH_LEVEL" => "4",
					"CACHE_TYPE" => "N",
				), false, Array('HIDE_ICONS' => 'Y'));
				
				$aMenuLinksExtFull = array_merge($aMenuLinksExtFull, $aMenuLinksExt);
			}
			*/

		}
	}

	if(defined("BX_COMP_MANAGED_CACHE"))
		$GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_new");
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

//p($aMenuLinks);
?>