<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
//p($_REQUEST);

if($_REQUEST['ID']||$_REQUEST['ELEMENT_CODE']){
	
	if($_REQUEST['ELEMENT_CODE']){
		
		$arSelect = Array('ID', "IBLOCK_ID");
		$arFilter = Array("IBLOCK_ID" => 14, "ACTIVE" => "Y", "CODE" => $_REQUEST['ELEMENT_CODE']);
		$res = CIBlockElement::GetList(Array("NAME" => "ASC"), $arFilter, false, array("nTopCount" => 1), $arSelect);
		while($data = $res->GetNext()){
			
			if($data['ID']){
				$res = CIblockElement::GetByID($data['ID']);
				if($result = $res->GetNextElement()){
					
					
					$arFields = $result->GetFields();
					$arProps = $result->GetProperties();
					
					
					$arResult['PAGE_ELEMENT'] = $arFields;
					$arResult['PAGE_ELEMENT']['PROPERTIES'] = $arProps;
					
				}
				
			}
		}
		
	}else{
	
		$res = CIblockElement::GetByID($_REQUEST['ID']);
		if($result = $res->GetNextElement()){
			
			
			$arFields = $result->GetFields();
			$arProps = $result->GetProperties();
			
			
			$arResult['PAGE_ELEMENT'] = $arFields;
			$arResult['PAGE_ELEMENT']['PROPERTIES'] = $arProps;
			//p($arResult['PAGE_ELEMENT']);
		}
	
	
	}
}
//p($_REQUEST);
?>