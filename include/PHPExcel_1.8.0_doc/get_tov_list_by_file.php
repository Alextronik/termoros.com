<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//p($_FILES);

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
//date_default_timezone_set('Europe/London');

//define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

//date_default_timezone_set('Europe/London');

/** Include PHPExcel_IOFactory */
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';






$objPHPExcel = PHPExcel_IOFactory::load($_FILES['img']['tmp_name']);

$objPHPExcel->setActiveSheetIndex(0);
// Получаем активный лист
$sheet = $objPHPExcel->getActiveSheet();

$arResult = array();
$rowIterator = $sheet->getRowIterator();
foreach ($rowIterator as $key => $row) {
	// Получили ячейки текущей строки и обойдем их в цикле
	$cellIterator = $row->getCellIterator();


	foreach ($cellIterator as $cell) {
		$val = trim($cell->getValue());
		if(!empty($val))
		{
			if(!empty($arResult[$key]["ATR"]))
			{
				$arResult[$key]['QA'] = $val;
				break;
			}
			if(empty($arResult[$key]["ATR"]))
			{
				$arResult[$key]['ATR'] = $val;
			}
		}

	}
}
foreach ($arResult as $arRow)
{
	?>
	<div class="inp_line" data-price="0">
		<div class="inp_block code">
			<input type="hidden" class="h_id_inp" name="ID[]">
			<input type="text" class="inp_self item_atr" value='<?=$arRow["ATR"]?>' placeholder="Введите артикул">
			<p class="inp_val price">0<span>руб.</span></p>
		</div>
		<div class="inp_block quantity">
			<input type="text" name="quantity[]" class="inp_self short" value="<?=$arRow["QA"] > 0 ? $arRow["QA"] : 1?>">
			<span class="col">шт.</span>
			<p class="inp_val sum">0<span>руб.</span></p>
		</div>
		<a href="" class="delete_line"></a>
	</div>
	<?
}
?>
<a href="" class="add_line">Добавить поля</a>
<a href="" class="to_basket">в корзину</a>