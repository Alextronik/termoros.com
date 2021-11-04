<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Фото менеджеров.");

$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/photos.csv", "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        $lineArr = explode(";", $buffer);
		foreach($lineArr as $k => $v)
		{
			$lineArr[$k] = rtrim(ltrim(trim($v),'"'), '"');
			$lineArr[$k] = str_replace('"', '', $lineArr[$k]);
			$lineArr[$k] = str_replace("\\", ' корп. ', $lineArr[$k]);
		}
		
		$photos1C[$lineArr[1]][] = $lineArr[0];
		$photosArticles[] = $lineArr[0];
		$articlePhoto[$lineArr[0]] = $lineArr[1];
		
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

CModule::IncludeModule('iblock');
$res = CIblockElement::GetList(
	array(),
	array("IBLOCK_ID" => 4, "!DETAIL_PICTURE" => FALSE),
	false,
	false,
	array("ID", "DETAIL_PICTURE", "PROPERTY_CML2_ARTICLE")
);

while($ar = $res->GetNext())
{
	$elements[$ar["PROPERTY_CML2_ARTICLE_VALUE"]] = $ar;
	
	
	//$elements[] = 
	
	//var_dump($ar);
	
	/*
	$img = CFile::ResizeImageGet($ar["DETAIL_PICTURE"], array('width'=>445, 'height'=>445), BX_RESIZE_IMAGE_PROPORTIONAL  , true);
	$imgs[$img['size'].$img['width'].$img['height']] = $img['src'];
	$l++;
	if ($l > 1000) 
	{
		foreach($imgs as $src)
		{
			echo '<img src="'.$src.'"><br>';
		}
		die();
		
	}
	*/
}
foreach($photos1C as $photoName => $artArray)
{
	foreach($artArray as $art)
	{
		if ($elements[$art])
		{
			//$img = CFile::ResizeImageGet($elements[$art]["DETAIL_PICTURE"], array('width'=>445, 'height'=>445), BX_RESIZE_IMAGE_PROPORTIONAL  , true);
			$img = CFile::GetPath($elements[$art]["DETAIL_PICTURE"]);
			$extArr = explode(".", $img);
			$ext = $extArr[count($extArr)-1];
			$newPhotoName = $photoName.'.'.$ext;
			
			$photoMerge[$photoName] = $newPhotoName;
			copy($_SERVER['DOCUMENT_ROOT'].$img, $_SERVER['DOCUMENT_ROOT'].'/store/photosORI/'.$newPhotoName);
			
			break;
		}
	}
}
/*
foreach($articlePhoto as $art => $photo)
{
	echo $art.';'.$photoMerge[$photo].'<br>';
}
*/


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>