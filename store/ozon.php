<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

//Радиаторы
if (0)
{
	$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/ozon", "r");
	if ($handle) {
		while (($buffer = fgets($handle, 4096)) !== false) {
			$articles[] = trim($buffer);
		}
		fclose($handle);
	}

	$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/radiator_prices.csv", "r");
	if ($handle) {
		while (($buffer = fgets($handle, 4096)) !== false) {
			
			$lineArr = explode(";",$buffer);
			if ($lineArr[2] == 'EUR') $lineArr[1] = $lineArr[1] * 67.9333;
			if ($lineArr[2] == 'USD') $lineArr[1] = $lineArr[1] * 57.5706;
			
			$ozon[$lineArr[0]] = $lineArr;
		}
		fclose($handle);
	}

	$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/post_code.csv", "r");
	if ($handle) {
		while (($buffer = fgets($handle, 4096)) !== false) {
			
			$lineArr = explode(";",$buffer);
						
			$postavshik[$lineArr[0]] = $lineArr[1];
		}
		fclose($handle);
	}
	
	$brandCodes = getBrandXmlIdArrayByCode($brand);
	CModule::IncludeModule('iblock');
	CModule::IncludeModule('sale');
	CModule::IncludeModule('catalog');
	$res = CIblockElement::GetList(array(), array("IBLOCK_ID"=>4, "PROPERTY_CML2_ARTICLE" => $articles, "ACTIVE" => "Y"), false, false,array('ID', 'IBLOCK_ID', 'NAME', 'PROPERTY_CML2_ARTICLE', 'PROPERTY_BREND', 'PROPERTY_GARANTIYA_LET', 'PROPERTY_KOL_VO_SEKTSIY_SHT', 'PROPERTY_MATERIAL', 'PROPERTY_MOSHCHNOST_KVT', 'PROPERTY_TEPLOOTDACHA_VT', 'PROPERTY_RABOCHEE_DAVLENIE_ATM', 'PROPERTY_MEZHOSEVOE_RASSTOYANIE_MM', 'PROPERTY_VYSOTA_SM', 'PROPERTY_VYSOTA_SM_1', 'PROPERTY_SHIRINA_MM', 'PROPERTY_DLINA_SM', 'PROPERTY_DLINA_SM_1', 'PROPERTY_GLUBINA_MM', 'PROPERTY_ARTIKUL_NOMENKLATURY_POSTAVSHCHIKA'));
	while($el = $res->GetNext())
	{
		$els[$el["PROPERTY_CML2_ARTICLE_VALUE"]] = $el;
	}

	CModule::IncludeModule('highloadblock');

	$hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
	\Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData);
	$res = BrendTable::getList();

	while($propertyBrandValueId = $res->fetch())
	{
		$brandArr[$propertyBrandValueId['UF_XML_ID']] = $propertyBrandValueId["UF_NAME"];
	}


	foreach($articles as $v)
	{
		
		
		//echo $els[$v]["NAME"].'<br>';
		/*
		$elementProduct = CCatalogProduct::GetByID($els[$v]['ID']);
		//var_dump($elementProduct);
		$res = CPrice::GetList(
			array(),
			array(
					"PRODUCT_ID" => $elementProduct["ID"],
					"CATALOG_GROUP_ID" => 2
				)
		);
		$ar = $res->Fetch();
		echo $ar["PRICE"].'<br>';
		*/
		
		//echo $brandArr[$els[$v]["PROPERTY_BREND_VALUE"]].'<br>';
		
		/*
		$res = CIBlockElement::GetProperty(4, $els[$v]["ID"], array("sort" => "asc"), Array("CODE"=>"CML2_TRAITS"));
		$w = 0;
		$h = 0;
		$g = 0;
		$weight = 0;
		while ($ob = $res->GetNext())
		{
			
			
			if ($ob["DESCRIPTION"] == 'Ширина, м') $w = $ob["VALUE"]*1000;
			if ($ob["DESCRIPTION"] == 'Высота, м') $h = $ob["VALUE"]*1000;
			if ($ob["DESCRIPTION"] == 'Глубина, м') $g = $ob["VALUE"]*1000;
			if ($ob["DESCRIPTION"] == 'Вес, кг') $weight = $ob["VALUE"]*1000;
			
			
		}
		*/
		//echo $weight.'<br>';
		
		/*
		if ($w && $h && $g)
		{
			echo $w.'x'.$h.'x'.$g.'<br>';
		}
		else
		{
			echo '<br>';
		}
		*/
		
		//echo $els[$v]["PROPERTY_GARANTIYA_LET_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_KOL_VO_SEKTSIY_SHT_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_MATERIAL_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_MOSHCHNOST_KVT_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_TEPLOOTDACHA_VT_VALUE"].'<br>';
		//echo ((int)$els[$v]["PROPERTY_MEZHOSEVOE_RASSTOYANIE_MM_VALUE"]/10).' см'.'<br>';
		//echo ($els[$v]["PROPERTY_VYSOTA_SM_VALUE"])?($els[$v]["PROPERTY_VYSOTA_SM_VALUE"]*10).'<br>':($els[$v]["PROPERTY_VYSOTA_SM_1_VALUE"]*10).'<br>';
		//echo ($els[$v]["PROPERTY_DLINA_SM_VALUE"])?($els[$v]["PROPERTY_DLINA_SM_VALUE"]*10).'<br>':($els[$v]["PROPERTY_DLINA_SM_1_VALUE"]*10).'<br>';
		//echo $els[$v]["PROPERTY_SHIRINA_MM_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_GLUBINA_MM_VALUE"].'<br>';
		//echo $ozon[$v][1].'<br>';
		//echo $postavshik[$v].'<br>';
		
		
	//if (!in_array($v, $els)) var_dump($v);
	}
}

//Фурнитура
if (1)
{
	$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/ozon", "r");
	if ($handle) {
		while (($buffer = fgets($handle, 4096)) !== false) {
			$articles[] = trim($buffer);
		}
		fclose($handle);
	}
	
	$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/armatura_prices.csv", "r");
	if ($handle) {
		while (($buffer = fgets($handle, 4096)) !== false) {
			
			$lineArr = explode(";",$buffer);
			$lineArr[1] = str_replace(" ", "", $lineArr[1]);
			$lineArr[1] = str_replace(",", ".", $lineArr[1]);
			
			if (trim($lineArr[2]) == "EUR") {
				$lineArr[1] = $lineArr[1] * 67.7713;
				
			}
			if (trim($lineArr[2]) == 'USD') {$lineArr[1] = $lineArr[1] * 57.614;}
			
			$ozon[$lineArr[0]] = $lineArr;
		}
		fclose($handle);
	}
	
	/*
	$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/post_code.csv", "r");
	if ($handle) {
		while (($buffer = fgets($handle, 4096)) !== false) {
			
			$lineArr = explode(";",$buffer);
						
			$postavshik[$lineArr[0]] = $lineArr[1];
		}
		fclose($handle);
	}
	*/
	
	$brandCodes = getBrandXmlIdArrayByCode($brand);
	CModule::IncludeModule('iblock');
	CModule::IncludeModule('sale');
	CModule::IncludeModule('catalog');
	$res = CIblockElement::GetList(array(), array("IBLOCK_ID"=>4, "PROPERTY_CML2_ARTICLE" => $articles, "ACTIVE" => "Y"), false, false,array('ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PICTURE', 'PROPERTY_CML2_ARTICLE', 'PROPERTY_BREND', 'PROPERTY_GARANTIYA_LET', 'PROPERTY_KOL_VO_SEKTSIY_SHT', 'PROPERTY_MATERIAL', 'PROPERTY_MOSHCHNOST_KVT', 'PROPERTY_TEPLOOTDACHA_VT', 'PROPERTY_RABOCHEE_DAVLENIE_ATM', 'PROPERTY_MEZHOSEVOE_RASSTOYANIE_MM', 'PROPERTY_VYSOTA_SM', 'PROPERTY_VYSOTA_SM_1', 'PROPERTY_SHIRINA_MM', 'PROPERTY_DLINA_SM', 'PROPERTY_DLINA_SM_1', 'PROPERTY_GLUBINA_MM', 'PROPERTY_ARTIKUL_NOMENKLATURY_POSTAVSHCHIKA', 'PROPERTY_MODEL'));
	while($el = $res->GetNext())
	{
		$els[$el["PROPERTY_CML2_ARTICLE_VALUE"]] = $el;
	}

	CModule::IncludeModule('highloadblock');

	$hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
	\Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData);
	$res = BrendTable::getList();

	while($propertyBrandValueId = $res->fetch())
	{
		$brandArr[$propertyBrandValueId['UF_XML_ID']] = $propertyBrandValueId["UF_NAME"];
	}


	foreach($articles as $v)
	{
		/*
		if (!$els[$v]["NAME"]) 
		{	
			$kk++;
			echo $v.'<br>';
		}
		*/
		//echo $els[$v]["NAME"].'<br>';
		/*
		$elementProduct = CCatalogProduct::GetByID($els[$v]['ID']);
		//var_dump($elementProduct);
		$res = CPrice::GetList(
			array(),
			array(
					"PRODUCT_ID" => $elementProduct["ID"],
					"CATALOG_GROUP_ID" => 2
				)
		);
		$ar = $res->Fetch();
		echo $ar["PRICE"].'<br>';
		*/
		
		//echo $brandArr[$els[$v]["PROPERTY_BREND_VALUE"]].'<br>';
		
		
		$res = CIBlockElement::GetProperty(4, $els[$v]["ID"], array("sort" => "asc"), Array("CODE"=>"CML2_TRAITS"));
		$w = 0;
		$h = 0;
		$g = 0;
		$weight = 0;
		while ($ob = $res->GetNext())
		{
			
			
			if ($ob["DESCRIPTION"] == 'Ширина, м') $w = $ob["VALUE"]*1000;
			if ($ob["DESCRIPTION"] == 'Высота, м') $h = $ob["VALUE"]*1000;
			if ($ob["DESCRIPTION"] == 'Глубина, м') $g = $ob["VALUE"]*1000;
			if ($ob["DESCRIPTION"] == 'Вес, кг') $weight = $ob["VALUE"]*1000;
			
			
		}
		
		//echo $weight.'<br>';
		
		/*
		if ($w && $h && $g)
		{
			echo $w.' x '.$h.' x '.$g.'<br>';
		}
		else
		{
			echo '<br>';
		}
		*/
		$picture = CFile::GetPath($els[$v]["DETAIL_PICTURE"]);
		if ($picture)
			echo 'https://www.termoros.com/api/v0/get_img_by_article.php?article='.$v.'<br>';
		else echo '<br>';
		//echo $els[$v]["PROPERTY_ARTIKUL_NOMENKLATURY_POSTAVSHCHIKA_VALUE"].'<br>';
		
		//echo $els[$v]["PROPERTY_GARANTIYA_LET_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_KOL_VO_SEKTSIY_SHT_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_MATERIAL_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_MOSHCHNOST_KVT_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_TEPLOOTDACHA_VT_VALUE"].'<br>';
		//echo ((int)$els[$v]["PROPERTY_MEZHOSEVOE_RASSTOYANIE_MM_VALUE"]/10).' см'.'<br>';
		//echo ($els[$v]["PROPERTY_VYSOTA_SM_VALUE"])?($els[$v]["PROPERTY_VYSOTA_SM_VALUE"]*10).'<br>':($els[$v]["PROPERTY_VYSOTA_SM_1_VALUE"]*10).'<br>';
		//echo ($els[$v]["PROPERTY_DLINA_SM_VALUE"])?($els[$v]["PROPERTY_DLINA_SM_VALUE"]*10).'<br>':($els[$v]["PROPERTY_DLINA_SM_1_VALUE"]*10).'<br>';
		//echo $els[$v]["PROPERTY_SHIRINA_MM_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_GLUBINA_MM_VALUE"].'<br>';
		//echo $els[$v]["PROPERTY_MODEL_VALUE"].'<br>';
		//echo round($ozon[$v][1], 2).'<br>';
		//echo $postavshik[$v].'<br>';
		
		//if (!in_array($v, $els)) var_dump($v);
	}
}
//var_dump($kk);
?>