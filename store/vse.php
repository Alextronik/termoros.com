<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/vse", "r");
if ($handle) {
	while (($buffer = fgets($handle, 4096)) !== false) {
		$articles[] = trim($buffer);
		$articleArr[trim($buffer)] = "";
	}
	fclose($handle);
}

CModule::IncludeModule('iblock');
if ($articles)
{
	foreach($articles as $art)
	{
		$res = CIblockElement::GetList(
			array(),
			array("IBLOCK_ID" => 4, "PROPERTY_CML2_ARTICLE" => $art),
			false,
			false,
			array("ID", "DETAIL_PICTURE", "DETAIL_PAGE_URL", "PROPERTY_CML2_ARTICLE")
		);

		$ar = $res->GetNext();
		/*
		if ($ar && $ar["DETAIL_PAGE_URL"])
		{
			$articleArr[$ar["PROPERTY_CML2_ARTICLE_VALUE"]] = 'https://www.termoros.com'.$ar["DETAIL_PAGE_URL"];
		}
		*/
		if ($ar && $ar["DETAIL_PICTURE"])
		{
			$img = CFile::GetPath($ar["DETAIL_PICTURE"]);
			$articleArr[$ar["PROPERTY_CML2_ARTICLE_VALUE"]] = 'https://www.termoros.com'.$img;
		}
	}
	
}

foreach($articleArr as $k => $a)
{
	echo $a.'<br>';
}