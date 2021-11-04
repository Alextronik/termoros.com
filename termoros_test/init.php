<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$testId = generateRandomString();
echo 'Уникальная ссылка для теста:<br>';
echo 'https://www.termoros.com/termoros_test/?id='.$testId;
$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/termoros_test/test_acc/'.$testId, 'w+');
fwrite ($fh, $testId);
fclose($fh);

echo '<br><br><a target="_blank" href="/termoros_test/test_results.xls">Скачать файл с результатами тестов</a>';


?>