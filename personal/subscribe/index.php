<?
define('LEFTBAR3','Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Почтовая рассылка");
?><p>Подписаться на почтовую рассылку</p>

<?/*$APPLICATION->IncludeComponent(
	"bitrix:subscribe.edit",
	"",
	Array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"ALLOW_ANONYMOUS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"SET_TITLE" => "N",
		"SHOW_AUTH_LINKS" => "Y",
		"SHOW_HIDDEN" => "N"
	)
);*/?><?
		if(CModule::IncludeModule("sender"))
		{
			$sender = false;
			global $USER;
			//p($_COOKIE['BITRIX_SM_SENDER_SUBSCR_EMAIL']);
			$contactDb = \Bitrix\Sender\ContactTable::getList(array('filter' => array('=EMAIL' => strtolower($_COOKIE['BITRIX_SM_SENDER_SUBSCR_EMAIL']))));
			if($contact = $contactDb->fetch()){
				//p($contact);
				$sender = true;
			}
			
			if($sender){
				
			echo '<p><b>Вы уже подписаны на рассылку, отписаться можно при повторном письме.</b></p>';
			}
		}

$APPLICATION->IncludeComponent(
	"infodaymedia:sender.subscribe",
	"",
	Array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"CONFIRMATION" => "N",
		"SET_TITLE" => "N",
		"SHOW_HIDDEN" => "N",
		"USE_PERSONALIZATION" => "Y"
	)
);?><br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>