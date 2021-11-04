<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';

$inputFileName = $_SERVER["DOCUMENT_ROOT"].'/termoros_test/ad.xlsx';
$hlbl = 10;

use Bitrix\Main\Loader;
Loader::includeModule("highloadblock");
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
if($entity_data_class){
    clear_hl($entity_data_class);
} else die("HL ERROR");


//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();
//  Loop through each row of the worksheet in turn
for ($row = 1; $row <= $highestRow; $row++){
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
    var_dump($rowData);
    // add row to highload
    /*$data = array(
        "UF_TYPE"=>'33',
        "UF_COUNT"=>'1',
        "UF_DATA"=>date("d.m.Y")
    );

    $result = $entity_data_class::add($data);*/
}

function clear_hl($entity_data_class)
{
    $rsData = $entity_data_class::getList(array(
        "select" => array("*"),
        "order" => array("ID" => "ASC")
    ));

    while($arData = $rsData->Fetch()){
        $entity_data_class::Delete($arData['ID']);
    }
}


/* import from csv
 $inputFileName = $_SERVER["DOCUMENT_ROOT"].'/termoros_test/ad.csv';

$row = 1;
if (($handle = fopen("$inputFileName", "r")) != FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num полей в строке $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
} else echo "fack";
 */