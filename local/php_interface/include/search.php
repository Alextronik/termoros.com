<?php
$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler('search', 'BeforeIndex', function(array $fields) {
    if ($fields['MODULE_ID'] == 'iblock' && $fields["PARAM2"] == 4)
    {
        $res= CIBlockElement::GetList(array(),array('ID'=>$fields["ITEM_ID"],'IBLOCK_ID'=>$fields["PARAM2"]),false,array('nTopCount'=>1),array('PROPERTY_CML2_ARTICLE','PROPERTY_CLEAR_ARTICLE','PROPERTY_BREND','NAME','IBLOCK_SECTION_ID', 'PROPERTY_ARTIKUL_NOMENKLATURY_POSTAVSHCHIKA'));

        $element = $res->GetNext();

        if($element['IBLOCK_SECTION_ID'])
        {
            $section = CIBlockSection::GetByID($element['IBLOCK_SECTION_ID'])->GetNext();
        }

        $index[] = $element['NAME'];
        $index[] = implode(' ',array_keys(stemming($element['NAME'],'ru')));
        $index[] = $element['PROPERTY_CML2_ARTICLE_VALUE'];
        $index[] = str_replace("-", " ", $element['PROPERTY_CML2_ARTICLE_VALUE']);
        $index[] = str_replace(".", " ", $element['PROPERTY_CML2_ARTICLE_VALUE']);
        
		$articleArr = explode(" ", $element['PROPERTY_CML2_ARTICLE_VALUE']);
		foreach($articleArr as $v)
		{
			$index[] = $v;
		}
		if (count($articleArr) > 1) 
		{
			unset($articleArr[0]);
			$withoutPreffix = implode(" ", $articleArr);
			$withoutPreffixClear = implode("", $articleArr);
			
			$index[] = $withoutPreffix;
			$index[] = $withoutPreffixClear;
		}
		if (count($articleArr) > 1) 
		{
			unset($articleArr[1]);
			$withoutPreffix = implode(" ", $articleArr);
			$withoutPreffixClear = implode("", $articleArr);
			
			$index[] = $withoutPreffix;
			$index[] = $withoutPreffixClear;
		}
		if (count($articleArr) > 1) 
		{
			unset($articleArr[2]);
			$withoutPreffix = implode(" ", $articleArr);
			$withoutPreffixClear = implode("", $articleArr);
			
			$index[] = $withoutPreffix;
			$index[] = $withoutPreffixClear;
		}
		
		$index[] = $element['PROPERTY_CLEAR_ARTICLE_VALUE'];
        
		$brandName = '';
		if ($element['PROPERTY_BREND_VALUE'])
		{
			$hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
			\Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData);
			$brand = BrendTable::getList(['filter'=>['UF_XML_ID' => $element['PROPERTY_BREND_VALUE']]])->fetch();
			$brandName = $brand["UF_NAME"];
			$index[] = $brandName;
			
			$index[] = $brandName.' '.$element['PROPERTY_CML2_ARTICLE_VALUE'];
			$index[] = $brandName.' '.str_replace("-", " ", $element['PROPERTY_CML2_ARTICLE_VALUE']);
			$index[] = $brandName.' '.str_replace(".", " ", $element['PROPERTY_CML2_ARTICLE_VALUE']);
			
		}
		
		$index[] = $element['PROPERTY_ARTIKUL_NOMENKLATURY_POSTAVSHCHIKA_VALUE'];

        //$index[] = CSearchLanguage::ConvertKeyboardLayout($element['PROPERTY_CML2_MANUFACTURER_VALUE'], 'en', 'ru');
        $index[] = CSearchLanguage::ConvertKeyboardLayout($element['NAME'], 'en', 'ru');
        $index[] = CSearchLanguage::ConvertKeyboardLayout($brandName, 'en', 'ru');
		

        //$index[] = $element['PROPERTY_CML2_MANUFACTURER_VALUE'];
        $index[] = $section['NAME'];

        $section = implode(' ',array_keys(stemming($section['NAME'],'ru')));

        $index[] = $section;


        $fields['BODY'] = implode("\n",$index);
        $fields['TITLE'] = implode("\n",$index);

        return $fields;
    }
}); 
?>