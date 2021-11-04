<?
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';

$rBrands = $_GET['brands'];
$rTypes = $_GET['types'];
$rStores = $_GET['stores'];

if (!$rBrands && !$rTypes && !$rStores)
{
	header("Location: /buyers/prices/pricelists/pricelist_all.xlsx");
	die();
}


/*
CModule::IncludeModule('main');
CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');
CModule::IncludeModule('highloadblock');
*/

$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/1c-services/pricelists/pricelist_all.xml');

foreach($xml->Dat as $o)
{
	foreach($o->Attributes() as $k => $v)
	{
		$v = trim($v);
		
		
		if ($k == "A") $brand = $v;
		if ($k == "E") $type = $v;
		$brandLower = strtolower($brand);
		
		if ($k == "A") $item['brand'] = $v;
		if ($k == "B") $item['article'] = $v;
		if ($k == "C") $item['name'] = $v;
		if ($k == "D") $item['sklad'] = $v;
		if ($k == "E") $item['type'] = $v;
		if ($k == "F") $item['measure'] = $v;
		if ($k == "G") $item['currency'] = $v;
		if ($k == "P") $item['price'] = str_replace(" ", "", $v);

		$item['link'] = 'https://www.termoros.com/catalog/element.php?a='.$item['article'];
		
		
		
		
		
	}
	
	if ($rTypes && !in_array($item['type'], $rTypes))
	{
		continue;
	}
	if ($rStores && !in_array($item['sklad'], $rStores))
	{
		continue;
	}
	
	$items[$brandLower][] = $item;
	$brandNames[$brand] = $brand;
	$types[$type] = $type;
}

ksort($brandNames);
ksort($types);


/*
$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'].'/include/PHPExcel_1.8.0_doc/price_all_site.xlsx');




$objPHPExcel->setActiveSheetIndex(0);

$sheet = $objPHPExcel->getActiveSheet();

$rowIterator = $sheet->getRowIterator();
foreach ($rowIterator as $key => $row) {
	$maxRow++;
}

for($i=2;$i<=$maxRow;$i++)
{
	$brand = $sheet->getCellByColumnAndRow(2, $i)->getValue();
	$type = $sheet->getCellByColumnAndRow(3, $i)->getValue();
	$brandLower = strtolower($brand);
	
	$item['article'] = $sheet->getCellByColumnAndRow(0, $i)->getValue();
	$item['name'] = $sheet->getCellByColumnAndRow(1, $i)->getValue();
	$item['brand'] = $sheet->getCellByColumnAndRow(2, $i)->getValue();
	$item['type'] = $sheet->getCellByColumnAndRow(3, $i)->getValue();
	$item['price'] = $sheet->getCellByColumnAndRow(4, $i)->getValue();
	$item['weight'] = $sheet->getCellByColumnAndRow(5, $i)->getValue();
	$item['measure'] = $sheet->getCellByColumnAndRow(6, $i)->getValue();
	$item['sklad'] = $sheet->getCellByColumnAndRow(7, $i)->getValue();
	$item['quantity'] = $sheet->getCellByColumnAndRow(8, $i)->getValue();
	
	$item['link'] = 'https://www.termoros.com/catalog/element.php?a='.$item['article'];
	
	$items[$brandLower][] = $item;
	
	$brandNames[$brand] = $brand;
	$types[$type] = $type;
}
*/



$storeTypes = array(
	"Склад." => "Складская",
	"Заказ." => "Заказная",
	"Не за." => "Распродажа",
);


ksort($brandNames);
ksort($types);

if (!empty($rBrands)) $brandNames = $rBrands;


$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'].'/include/PHPExcel_1.8.0_doc/pricelist.xlsx');

$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();
$sheet->SetCellValue('A2', 'Цены действительны на '.date('d.m.Y'));

$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
    ),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => '4F81BD')
	),
);
$styleBOLD = array(
    'font'  => array(
        'bold'  => true,
    )
);
$aligmentRight = array(
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	)
);
$aligmentLeft = array(
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	)
);

$l=0;
foreach($brandNames as $brand)
{
	if ($items[strtolower($brand)])
	{
		$sheet->SetCellValue('B'.($l+9), $brand);
		
		$objWorkSheet = $objPHPExcel->createSheet($l+1);
		$objWorkSheet->setTitle($brand);
		
		//$sheet->SetCellValue('A1', 'Код продукта')->getColor()->setRGB('4F81BD')->getStyle('A1')->applyFromArray($styleArray);;
		$objWorkSheet->SetCellValue('A1', 'Оглавление')->getStyle('A1')->applyFromArray($styleBOLD);
		$objWorkSheet->getCell('A1')
		  ->getHyperlink()
		  ->setUrl("sheet://'Бренды'!A1");
		
		$objWorkSheet->SetCellValue('D1', 'Скидка')->getStyle('D1')->applyFromArray($styleBOLD);
		$objWorkSheet->SetCellValue('E1', 0)->getStyle('E1')->applyFromArray($styleBOLD);
		$objWorkSheet->SetCellValue('F1', '%')->getStyle('F1')->applyFromArray($styleBOLD);
		
		$objWorkSheet->SetCellValue('A3', 'Код продукта')->getStyle('A3')->applyFromArray($styleArray);
		$objWorkSheet->getColumnDimension('A')->setWidth('20');
		$objWorkSheet->SetCellValue('B3', 'Наименование')->getStyle('B3')->applyFromArray($styleArray);
		$objWorkSheet->getColumnDimension('B')->setWidth('50');
		//$objWorkSheet->SetCellValue('C1', 'Бренд')->getStyle('C1')->applyFromArray($styleArray);
		//$objWorkSheet->getColumnDimension('C')->setWidth('15');
		$objWorkSheet->SetCellValue('C3', 'Тип продукта')->getStyle('C3')->applyFromArray($styleArray);
		$objWorkSheet->getColumnDimension('C')->setWidth('10');
		$objWorkSheet->SetCellValue('D3', 'Цена')->getStyle('D3')->applyFromArray($styleArray);
		$objWorkSheet->getColumnDimension('D')->setWidth('15');
		$objWorkSheet->SetCellValue('E3', 'Цена со скидкой')->getStyle('E3')->applyFromArray($styleArray);
		$objWorkSheet->getColumnDimension('E')->setWidth('15');
		$objWorkSheet->SetCellValue('F3', 'Валюта')->getStyle('F3')->applyFromArray($styleArray);
		$objWorkSheet->getColumnDimension('F')->setWidth('10');
		$objWorkSheet->SetCellValue('G3', 'ЕИ')->getStyle('G3')->applyFromArray($styleArray);
		$objWorkSheet->getColumnDimension('G')->setWidth('10');
		$objWorkSheet->SetCellValue('H3', 'Тип')->getStyle('H3')->applyFromArray($styleArray);
		$objWorkSheet->getColumnDimension('H')->setWidth('10');
		//$objWorkSheet->SetCellValue('I1', 'Нал.')->getStyle('I1')->applyFromArray($styleArray);
		//$objWorkSheet->getColumnDimension('I')->setWidth('10');
		$objWorkSheet->SetCellValue('I3', 'Ссылка')->getStyle('I3')->applyFromArray($styleArray);
		$objWorkSheet->getColumnDimension('I')->setWidth('10');
		
		$sheet->getCell('B'.($l+9))
		  ->getHyperlink()
		  ->setUrl("sheet://'".$brand."'!A1");
		
		$l++;
	}
}

foreach ($objPHPExcel->getAllSheets() as $k => $sheet) {
	if ($k)
	{
		$maxRow = 4;
		$brandName = $sheet->getTitle();
		$brandNameLower = strtolower($sheet->getTitle());
		
		//$objPHPExcel->setActiveSheetIndex($k);
		//$sheet = $objPHPExcel->getActiveSheet();
		
		foreach($items[$brandNameLower] as $item)
		{
			
			$sheet->setCellValueExplicit('A'.$maxRow, $item["article"], PHPExcel_Cell_DataType::TYPE_STRING)->getStyle('A'.$maxRow)->applyFromArray($aligmentLeft);
			$sheet->SetCellValue('B'.$maxRow, $item["name"])->getStyle('B'.$maxRow)->applyFromArray($aligmentLeft);
			//$sheet->SetCellValue('C'.$maxRow, $item["brand"])->getStyle('C'.$maxRow)->applyFromArray($aligmentRight);
			$sheet->SetCellValue('C'.$maxRow, $item["type"])->getStyle('C'.$maxRow)->applyFromArray($aligmentRight);
			$sheet->SetCellValue('D'.$maxRow, $item["price"])->getStyle('D'.$maxRow)->applyFromArray($aligmentRight);
			$sheet->SetCellValue('E'.$maxRow, "=D".$maxRow."*(1-E$1/100)")->getStyle('E'.$maxRow)->applyFromArray($aligmentRight);
			
			$sheet->getStyle('E'.$maxRow)
			->getNumberFormat()
			->setFormatCode(
				PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
			);
			
			$sheet->SetCellValue('F'.$maxRow, $item["currency"])->getStyle('F'.$maxRow)->applyFromArray($aligmentRight);
			$sheet->SetCellValue('G'.$maxRow, $item["measure"])->getStyle('G'.$maxRow)->applyFromArray($aligmentRight);
			$sheet->SetCellValue('H'.$maxRow, $storeTypes[$item["sklad"]])->getStyle('H'.$maxRow)->applyFromArray($aligmentRight);
			//$sheet->SetCellValue('G'.$maxRow, $item["quantity"])->getStyle('G'.$maxRow)->applyFromArray($aligmentRight);
			
			$sheet->SetCellValue('I'.$maxRow, 'На сайт')->getStyle('I'.$maxRow)->applyFromArray($aligmentRight);
			$sheet->getCell('I'.$maxRow)
			  ->getHyperlink()
			  ->setUrl($item["link"]);
			
			$maxRow++;
		}
		$sheet->setAutoFilter('A3:H' . $maxRow);
	}
}
$objPHPExcel->setActiveSheetIndex(0);
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

if (!$rBrands && !$rTypes && !$rStores)
{
	$objWriter->save($_SERVER['DOCUMENT_ROOT'].'/buyers/prices/pricelists/tmp.xlsx');
	rename($_SERVER['DOCUMENT_ROOT'].'/buyers/prices/pricelists/tmp.xlsx', $_SERVER['DOCUMENT_ROOT'].'/buyers/prices/pricelists/pricelist_all.xlsx');
}
else
{
	$str = implode(";", $rBrands).';'.implode(";", $rTypes).';'.implode(";", $rTypes);
	$md5 = md5($str);
	$objWriter->save($_SERVER['DOCUMENT_ROOT'].'/buyers/prices/pricelists/'.$md5.'.xlsx');
	
	
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.$md5.'.xlsx"');
	$objWriter->save('php://output');
}
?>