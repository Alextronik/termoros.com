<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Фото менеджеров.");

$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/euros", "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {

		$articles[] = trim($buffer);
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
	array("ID", "DETAIL_TEXT", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PROPERTY_CML2_ARTICLE")
);

while($ar = $res->GetNext())
{
	$elements[$ar["PROPERTY_CML2_ARTICLE_VALUE"]] = $ar;
}//echo $ar["PROPERTY_CML2_ARTICLE_VALUE"];

foreach($articles as $article)	
{
	if ($elements[$article])
	{
		
		/*$img = CFile::GetPath($ar["DETAIL_PICTURE"]);
		
		$extArr = explode(".", $img);
		$ext = $extArr[count($extArr)-1];
		
		//echo $_SERVER['DOCUMENT_ROOT'].$img;
		//echo '<br>';
		//echo $_SERVER['DOCUMENT_ROOT'].'/store/ozon_photo/'.$ar["PROPERTY_CML2_ARTICLE_VALUE"].'.'.$ext;
		
		$photoMerge[$photoName] = $newPhotoName;
		copy($_SERVER['DOCUMENT_ROOT'].$img, $_SERVER['DOCUMENT_ROOT'].'/store/ozon_pictures/'.$ar["PROPERTY_CML2_ARTICLE_VALUE"].'.'.$ext);
		//break;
		*/
		echo $elements[$article]["DETAIL_TEXT"].'<br>';
	}
	else
	{
		echo '<br>';
	}

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

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>