<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");

if($_REQUEST['ajax'] == 'y'){

	GLOBAL $USER;
	//p($_REQUEST);
	
	
	$arEventFields["ITEMS"] = "";
	
	if (IntVal($_REQUEST['id'])>0)
    {
		$arSelect = Array();
		$arFilter = Array("ID"=>IntVal($_REQUEST['id']));
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1), $arSelect);
		if($ob = $res->GetNextElement())
		{
			$arFields_el = $ob->GetFields();
			$arProps = $ob->GetProperties();		
			$url = $arFields_el['DETAIL_PAGE_URL'];			
		}
	
		//p($arFields_el);
		//p($arProps_el['CML2_BAR_CODE']['VALUE']);
    }
	
	
	$arEventFields = array(
    "ID"  => "TOEMAIL",
	"EMAIL" => $_REQUEST['email'],	
    );
	
	$arEventFields['TEXT'] = "";	
	
		
	$arEventFields['TEXT'] .= "	
		<table style='width:800px;border-collapse: separate;border-spacing: 0px 10px;border:0;background: #ffffff;margin:0 auto;font-family: Arial, Helvetica;'>
		<tr>
			<td >
				<h1>".$arFields_el['NAME']."</h1>";

	if($arProps['CITY']['VALUE']){
		$arEventFields['TEXT'] .= "<h2>г. ".$arProps['CITY']['VALUE']." / ";		
	}
		
	if($arProps['GROUP']['VALUE']){
		$arEventFields['TEXT'] .= "деятельность: ".$arProps['GROUP']['VALUE']."</h2>";		
	}

	$arEventFields['TEXT'] .= $arFields_el['DETAIL_TEXT']."
			</td>
		</tr>
		</table>";
		
	
	$event = new CEvent;
	$ar = $event->Send("TOEMAIL", SITE_ID, $arEventFields);
	//p($ar);
	//p($arEventFields);
	/*?>
	<a href='' class='close'></a>
	<p class='ttl'>Отправить на E-mail</p>
	<span class="rules">
	Ваше сообщение отправлено!
	</span>
	<?*/
	
	
}
	
	
?>