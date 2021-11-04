<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';

$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'].'/termoros_test/test_results.xls');

$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();

$arResult = array();
$rowIterator = $sheet->getRowIterator();
foreach ($rowIterator as $key => $row) {
	$maxRow = $key;
}
$maxRow++;

$sheet->SetCellValue('A'.$maxRow, date('d.m.Y'));
$sheet->SetCellValue('B'.$maxRow, $_GET['FIO']);
$sheet->SetCellValue('C'.$maxRow, $_GET['time']);
$sheet->SetCellValue('D'.$maxRow, $_GET['all']);
$sheet->SetCellValue('E'.$maxRow, $_GET['true']);
$sheet->SetCellValue('F'.$maxRow, $_GET['false']);
$sheet->SetCellValue('G'.$maxRow, $_GET['bonus']);
$sheet->SetCellValue('H'.$maxRow, $_GET['percents']);
$sheet->SetCellValue('I'.$maxRow, $_GET['need']);
$sheet->SetCellValue('J'.$maxRow, $_GET['result']);
$sheet->SetCellValue('K'.$maxRow, $_GET['level']);

$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->save($_SERVER['DOCUMENT_ROOT'].'/termoros_test/test_results.xls');
?>