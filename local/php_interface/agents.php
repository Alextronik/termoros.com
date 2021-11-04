<?
class CTermorosAgent {
	
	// Простановка Clear Article
	public static function ClearArticleChanger()
	{
		CModule::IncludeModule('main');
		CModule::IncludeModule('iblock');
		
		$res = CIblockElement::GetList(array(), array("IBLOCK_ID"=>4, ), false, false,array('ID', 'IBLOCK_ID', 'PROPERTY_CML2_ARTICLE'));
		while($el = $res->GetNext())
		{
			$article = $el["PROPERTY_CML2_ARTICLE_VALUE"];
			$clearArticle = preg_replace("/[^A-Za-z0-9]/","",$article);
			if ($clearArticle) 
			{
				CIBlockElement::SetPropertyValueCode($el["ID"], "CLEAR_ARTICLE", $clearArticle);
			}
		}
		
		return "CTermorosAgent::ClearArticleChanger();";
	}
}

?>