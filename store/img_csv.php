<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "");

$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/img.csv", "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
		
		$lineArr = explode(";", $buffer);
		
		$articles[trim($lineArr[0])][] = trim($lineArr[1]);
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}


foreach($articles as $article => $arr)
{
	echo $article.';';
	foreach($arr as $v)
	{
		echo $v.';';
	}
	echo '<br>';
	
}