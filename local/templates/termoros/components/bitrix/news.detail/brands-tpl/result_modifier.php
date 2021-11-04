<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;
use Bitrix\Iblock;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

//p($arResult['NAME']);
/*
$main_query = new Entity\Query($entity);
$main_query->setSelect(array('*'));
$main_query->setOrder(array($sort_id => $sort_type));
$result = $main_query->exec();
$result = new CDBResult($result);

// build results
$rows = array();

$tableColumns = array();

while ($row = $result->Fetch())
{
//	p($row);
}
*/
global $BRAND_XMLID;
global $BRAND_NAME;

$BRAND_NAME = $arResult['NAME'];
$hlblock = HL\HighloadBlockTable::getById(3)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
$entity_table_name = $hlblock['TABLE_NAME'];

$arFilter = array("UF_NAME" => $arResult['NAME']); //задаете фильтр по вашим полям

$sTableID = 'tbl_'.$entity_table_name;
$rsData = $entity_data_class::getList(array(
"select" => array('*'), //выбираем все поля
"filter" => $arFilter,
"order" => array("UF_SORT"=>"ASC") // сортировка по полю UF_SORT, будет работать только, если вы завели такое поле в hl'блоке
));
$rsData = new CDBResult($rsData, $sTableID);
while($arRes = $rsData->Fetch()){
	//p($arRes);
	$BRAND_XMLID = $arRes['UF_XML_ID'];
}

?>