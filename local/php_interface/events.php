<?
use Bitrix\Main\Loader,Bitrix\Sale,Bitrix\Highloadblock,Bitrix\Main\EventManager;

$handler = EventManager::getInstance();

Loader::includeModule("highloadblock");
$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(11)->fetch();
$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);

$handler->AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("CCustomEventHandlerClass","OnAfterIBlockElementAddHandler"));
$handler->AddEventHandler('form', 'onBeforeResultAdd', array("CCustomEventHandlerClass","onFormBeforeResultAddHandler"));
$handler->AddEventHandler('main', 'OnBeforeEventSend', array("CCustomEventHandlerClass","OnBeforeEventSendHandler"));
$handler->AddEventHandler("iblock", "OnIBlockElementAdd", array("CCustomEventHandlerClass", "OnIBlockElementAddHandler"));
$handler->AddEventHandler("sale", 'OnSaleComponentOrderCreated', array("CCustomEventHandlerClass", "onSalePaySystemRestrictionsHandler"));
$handler->AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("CCustomEventHandlerClass", "OnBeforeIBlockElementUpdateHandler"));
$handler->AddEventHandler("", $entity->getName().'OnUpdate', array("CCustomEventHandlerClass", "OnUpdatePropsHL"));

class CCustomEventHandlerClass{
	
	function onFormBeforeResultAddHandler($WEB_FORM_ID, &$arFields, &$arrVALUES)
	{
		global $APPLICATION, $USER;
		  
		if ($WEB_FORM_ID == 5) 
		{
			$FIO = $arrVALUES['form_text_37'];
			$vacancy = $arrVALUES['form_text_36'];
			
			require_once($_SERVER['DOCUMENT_ROOT'] . '/include/htmltodocx/phpword/PHPWord.php');

			$phpword_object = new PHPWord();
			$section = $phpword_object->createSection();

			$phpword_object->addTitleStyle(1, array('size'=>20, 'color'=>'000000', 'bold'=>true));
			/*
			$phpword_object->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>16));
			*/
			$phpword_object->addParagraphStyle('pStyle', array('align'=>'left', 'spaceAfter'=>100));
			//$phpword_object->addParagraphStyle('pBigStyle', array('align'=>'left', 'spaceAfter'=>100));
			
			$section->addTitle($FIO, 1);
			$section->addText('На вакансию: '.$vacancy, 'pStyle');
			$section->addText('Дата рождения: '.$arrVALUES['form_text_38'], 'pStyle');
			$section->addText('Email: '.$arrVALUES['form_text_40'], 'pStyle');
			$section->addText('Телефон: '.$arrVALUES['form_text_39'], 'pStyle');
			$section->addText('Место проживания: '.$arrVALUES['form_text_51'], 'pStyle');
			$section->addText('Ближайшая станция метро: '.$arrVALUES['form_text_52'], 'pStyle');
			
			$section->addTextBreak(1);
			
			$section->addText('Образование: ', 'pStyle');
			$section->addText($arrVALUES['form_textarea_42'], 'pStyle');
			$section->addTextBreak(1);
			
			if ($arrVALUES['form_textarea_43'])
			{
				$section->addText('Дополнительное образование: ', 'pStyle');
				$section->addText($arrVALUES['form_textarea_43'], 'pStyle');
				$section->addTextBreak(1);
			}
			
			$section->addText('Опыт работы: ', 'pStyle');
			$section->addText($arrVALUES['form_textarea_44'], 'pStyle');
			$section->addTextBreak(1);
			
			
			if ($arrVALUES['form_textarea_45'])
			{
				$section->addText('Профессиональные навыки: ', 'pStyle');
				$section->addText($arrVALUES['form_textarea_45'], 'pStyle');
				$section->addTextBreak(1);
			}
			if ($arrVALUES['form_textarea_46'])
			{
				$section->addText('Знание иностранных языков: ', 'pStyle');
				$section->addText($arrVALUES['form_textarea_46'], 'pStyle');
				$section->addTextBreak(1);
			}

			$section->addText('Знание ПК: ', 'pStyle');
			$section->addText($arrVALUES['form_textarea_47'], 'pStyle');
			$section->addTextBreak(1);
			
			
			$section->addText('График работы: '.$arrVALUES['form_text_48'], 'pStyle');
			$section->addText('Командировки: '.$arrVALUES['form_text_66'], 'pStyle');
			
			$section->addText('Ожидаемый уровень дохода: '.$arrVALUES['form_text_41'], 'pStyle');
			
			$section->addText('Гражданство: '.$arrVALUES['form_text_50'], 'pStyle');

			$section->addText('Семейное положение: '.$arrVALUES['form_text_53'], 'pStyle');
			$section->addText('Наличие автомобиля: '.$arrVALUES['form_text_54'], 'pStyle');
			$section->addText('Водительские права, категория: '.$arrVALUES['form_text_55'], 'pStyle');
			$section->addTextBreak(1);
			
			
			$section->addText('Рекомендации: ', 'pStyle');
			$section->addText($arrVALUES['form_textarea_49'], 'pStyle');
			//ToDo Resume in email

			// Save File
			$h2d_file_uri = $_SERVER['DOCUMENT_ROOT'].'/upload/resume '.date('d.m.Y').'.docx';
			$objWriter = PHPWord_IOFactory::createWriter($phpword_object, 'Word2007');
			$objWriter->save($h2d_file_uri);
			
			$files[] = $h2d_file_uri;
			
			if ($arrVALUES["form_file_56"]["tmp_name"])
			{
				$filePath = $arrVALUES["form_file_56"]["tmp_name"];
				$fileName = $arrVALUES["form_file_56"] ["name"];
				$files[] = $filePath;
			}
			
			$arSend = array(
				"SUBJ" => 'Резюме с сайта termoros.com. '.$FIO,
				"TEXT" => '<p>Заполнена онлайн анкета резюме на сайте termoros.com. Резюме во вложении.</p>'
			);
			CEvent::Send("RESUME_FILE_SEND", 's1', $arSend, "Y", "", $files);
		}
	}

    // Заявка на субподряд
	function OnAfterIBlockElementAddHandler(&$arFields)
	{
		if ($arFields["IBLOCK_ID"] == 26)
		{
			//Письмо администрации сайта
			$subj = 'Заявка на субподряд. '.SITE_SERVER_NAME;
			$email = $arFields["PROPERTY_VALUES"]["643"];
			$emailTo = '';
			$emailFrom = $arFields["PROPERTY_VALUES"]["643"];
			
			$projectId = $arFields["PROPERTY_VALUES"]["646"];
			if ($projectId)
			{
				CModule::IncludeModule('iblock');
				$res = CIblockElement::GetList(
					array(),
					array("IBLOCK_ID"=>25, "ID" => $projectId),
					false,
					false,
					array("*", "PROPERTY_EMAIL")
				);
				$project = $res->GetNext();
				if ($project["PROPERTY_EMAIL_VALUE"])
				{
					$emailTo .= ', '.$project["PROPERTY_EMAIL_VALUE"];
				}
			}
			
			if ($arFields["ID"])
			{
				$attachedFiles = array();
				CModule::IncludeModule('iblock');
				$db_props = CIBlockElement::GetProperty(26, $arFields["ID"], array("sort" => "asc"), Array("CODE"=>"DOCUMENTS"));
				while ($ob = $db_props->GetNext())
				{
					if ($ob['VALUE'])
					{
						$attachedFiles[] = CFile::GetPath($ob['VALUE']);
					}
				}
				foreach($attachedFiles as $k => $filePath)
				{
					$filesHTML .= '<a href="http://'.SITE_SERVER_NAME.$filePath.'">Документ '.($k+1).'</a><br>';					
				}
			}
			
			
			$arSend = array(
				"SUBJ" => $subj,
				"EMAIL" => $email,
				"EMAIL_TO" => $emailTo,
				"EMAIL_FROM" => $emailFrom,
				"NAME" => $arFields["NAME"],
				"PHONE" => $arFields["PROPERTY_VALUES"]["642"],
				"INN" => $arFields["PROPERTY_VALUES"]["639"],
				"UR_ADDRESS" => $arFields["PROPERTY_VALUES"]["640"],
				"COMPANY_DESCRIPTION" => nl2br($arFields["PROPERTY_VALUES"]["641"]),
				"WORK_NAME" => $arFields["PROPERTY_VALUES"]["645"],
				//"ADMIN_LINK" => '<a href="http://'.SITE_SERVER_NAME.'/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=26&type=requests&ID='.$arFields["ID"].'&lang=ru&find_section_section=-1&WF=Y">Ссылка в административный интерфейс</a>',
				"FILES_LIST" => $filesHTML,
				
			);
			CEvent::Send("MESSAGE_FROM_SITE", 's1', $arSend);
			

			//Письмо отправителю заявки
			$subj = 'Ваша заявка получена. '.SITE_SERVER_NAME;
			$email = $arFields["PROPERTY_VALUES"]["643"];
			$emailTo = $arFields["PROPERTY_VALUES"]["643"];
			$emailFrom = COption::GetOptionString('main', 'email_from', 'default@admin.email');
			
			$arSend = array(
				"SUBJ" => $subj,
				"EMAIL" => $email,
				"EMAIL_TO" => $emailTo,
				"EMAIL_FROM" => $emailFrom,
				"NAME" => $arFields["NAME"],
				"PHONE" => $arFields["PROPERTY_VALUES"]["642"],
				"INN" => $arFields["PROPERTY_VALUES"]["639"],
				"UR_ADDRESS" => $arFields["PROPERTY_VALUES"]["640"],
				"COMPANY_DESCRIPTION" => nl2br($arFields["PROPERTY_VALUES"]["641"]),
				"WORK_NAME" => $arFields["PROPERTY_VALUES"]["645"],
				
			);
			
			CEvent::Send("MESSAGE_FROM_SITE_TO_CLIENT", 's1', $arSend);
		}
	}

    // auto add coupon to MOSOBLGAZ
	function OnIBlockElementAddHandler(&$arFields)
    {
        if ($arFields["IBLOCK_ID"] == 38)
        {
            Loader::includeModule('sale');
            $exist = \Bitrix\Sale\DiscountCouponsManager::isExist($arFields['NAME']);
            //\Bitrix\Main\Diag\Debug::writeToFile($exist,"exist_val");
            if(!$exist){
                $arCouponFields = array(
                    "DISCOUNT_ID" => "332",
                    "ACTIVE" => "Y",
                    "ONE_TIME" => "N",
                    "COUPON" => $arFields['NAME'],
                    "TYPE" => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_MULTI_ORDER,
                    "DATE_APPLY" => false
                );

                $result = \Bitrix\Sale\Internals\DiscountCouponTable::add($arCouponFields);
                if (!$result->isSuccess())
                {
                    $res =  $result->getErrorMessages();
                } else {
                    $res = $result->getId();
                }
                //\Bitrix\Main\Diag\Debug::writeToFile($res,"res");

            } else {
                //\Bitrix\Main\Diag\Debug::writeToFile($exist,"exist");
            }
        }
    }

	function OnBeforeEventSendHandler(&$arFields, &$arFieldsMail)
    {
        if($arFieldsMail['ID'] == 101 || $arFieldsMail['ID'] == 73 || $arFieldsMail['ID'] == 74 ||$arFieldsMail['ID'] == 75 || $arFieldsMail['ID'] == 89 || $arFieldsMail['ID'] == 90 || $arFieldsMail['ID'] == 93){
            // 74-заявка на тендерную документацию - отключена в коде
            // 89 - def - rossohina@termoros.com Россохина Юлия Викторовна
            // 90 - def - irina@termoros.com Ромаченко Ирина Михайловна
            // 93 - def - Lilia@termoros.com Серопова Лилия Нодаровна
            /*
             * $arFieldsMail['ID'] == 73 || $arFieldsMail['ID'] == 74 || $arFieldsMail['ID'] == 75 || $arFieldsMail['ID'] == 82 ||
            $arFieldsMail['ID'] == 89 || $arFieldsMail['ID'] == 90 || $arFieldsMail['ID'] == 93
             *
             * */
            // form => question fields City
            $arFieldsCity = [
                73=>'SIMPLE_QUESTION_954',
                74=>'SIMPLE_QUESTION_307_x4xWF',
                75=>'SIMPLE_QUESTION_424',
                89=>'SIMPLE_QUESTION_546',
                90=>'SIMPLE_QUESTION_546',
                93=>'SIMPLE_QUESTION_546',
                101=>'SIMPLE_QUESTION_528_56HR5'
            ];

            // arr fields to found
            $arFoundPoint = [
                0 => $arFields[$arFieldsCity[$arFieldsMail['ID']]],// step1 - user field city in form
                1 => $_SESSION['GEOIP']['curr_city_name'],              // step2 -
                2 => $_SESSION['GEOIP']['city'],                        // step3 -
                3 => $_SESSION['GEOIP']['region'],
                4 => $_SESSION['GEOIP']['district']
            ];

            // get hl data
            $cache = Bitrix\Main\Data\Cache::createInstance();
            if ($cache->initCache(86400, "mail_manager_forms", "mmf"))
            {
                $res = $cache->getVars();
            }
            elseif ($cache->startDataCache())
            {
                Loader::includeModule("highloadblock");
                $hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById(10)->fetch();
                $dataClass = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata)->getDataClass();
                $res = $dataClass::getList(['select'=>['*']])->fetchAll();

                $cache->endDataCache($res);
            }

            $manager_email = $arFieldsMail['EMAIL_TO'];

            $findRegion = false;
            //check regions
            foreach ($arFoundPoint as $k=>$v){
                $result0 = array_filter($res, function($kkk) use ($k,$v) {
                    if($k == 3){
                        return $kkk['UF_REGION'] == $v;
                    }elseif ($k == 4){
                        $firstworld = explode(' ',$v)[0];
                        return $kkk['UF_OKRUG'] == $firstworld;
                    } else
                        return $kkk['UF_CITY'] == $v;
                });

                if(!empty($result0)){
                    //Bitrix\Main\Diag\Debug::writeToFile($result0,'$result0');
                    $findRegion = true;
                    $manager_email = array_shift($result0)['UF_EMAIL'];
                    break;
                }
            }

            // check countries
            function checkAbroad($addr){
                $result = false;
                $arC = ['Беларусь','Казахстан','Узбекистан','Азербайджан'];
                foreach ($arC as $k=>$v){
                    if(stristr($addr, $v)  && !$result) {
                        $result = "ivan@termoros.com";
                        break;
                    }
                }
                if(stristr($addr, 'Армения')  && !$result) $result = 'yavruyan@termoros.am';

                return $result;
            }
            if(checkAbroad($arFoundPoint[0])) $manager_email = checkAbroad($arFoundPoint[0]);

            //$arFields["EMAIL_TO"] = $manager_email;
            $arFieldsMail["EMAIL_TO"] = $manager_email;
            $arFieldsMail["REPLY_TO"] = $manager_email;

            //Bitrix\Main\Diag\Debug::writeToFile($findRegion,'$findRegion');
            //Bitrix\Main\Diag\Debug::writeToFile($manager_email,'$manager_email');
            //Bitrix\Main\Diag\Debug::writeToFile($arFields,'$arFields');
            //Bitrix\Main\Diag\Debug::writeToFile($arFieldsMail,'$arFieldsMail');
        }

        if($arFieldsMail['ID'] == 82) {
            $manager_email = "Nikitin@termoros.com";
            if($arFields['SIMPLE_QUESTION_528_56HR5_RAW'] == "Котельное оборудование" ||
                $arFields['SIMPLE_QUESTION_528_56HR5_RAW'] == "Насосное оборудование" || $arFields['SIMPLE_QUESTION_528_56HR5_RAW'] == "Запасные части"
            ){//Котельное,насосное,запчасти - Стратонов
                $manager_email = "Stratonov@termoros.com";
            }elseif($arFields['SIMPLE_QUESTION_528_56HR5_RAW'] == "Арматура и трубопроводы" || $arFields['SIMPLE_QUESTION_528_56HR5_RAW'] == "Приборы учёта и КИП"){//Баженова
                $manager_email = "Bazhenova@termoros.com";
            }elseif ($arFields['SIMPLE_QUESTION_528_56HR5_RAW'] == "Приборы отопления"){//Качайло Денис
                $manager_email = "Kachaylo@termoros.com";//
            }

            //$arFields["EMAIL_TO"] = $manager_email;
            $arFieldsMail["EMAIL_TO"] = $manager_email;
            $arFieldsMail["REPLY_TO"] = $manager_email;
            //Bitrix\Main\Diag\Debug::writeToFile($arFields,'$arFields');
            //Bitrix\Main\Diag\Debug::writeToFile($arFieldsMail,'$arFieldsMail');
        }
    }

    // restrict online payments on stock availability for physical
    // UPD - don't restrict. always allow
    function onSalePaySystemRestrictionsHandler($order,&$arUserResult,$request,&$arParams,&$arResult,&$arDeliveryServiceAll,&$arPaySystemServiceAll)
    {
        if($order->getPersonTypeId() == 1){
            $restrict_pay = false;
            $storeId = $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'];// current store = $arPaySystemServiceAll['BUYER_STORE']
            //$basket = $order->getBasket();
            if($storeId == 213) $restrict_pay = true;

            // get quantity & check // отключаем проверку на наличие на складе
            /*foreach ($basket as $basketItem) {
                $rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
                    'filter' => array('=PRODUCT_ID'=>$basketItem->getProductId(),'=STORE_ID'=>$storeId),
                    'limit' => 1,
                    'select' => array('AMOUNT'),
                ))->fetchAll();
                if($rsStoreProduct[0]['AMOUNT'] < 1) {
                    //$restrict_pay = true; break;
                }
            }*/

            // add message
            if($restrict_pay){
                unset($arPaySystemServiceAll[15]);
                //$arResult['ZERO_QUANT'] = true;
            }
        }
    }

    // fix images from import 1c
    function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        //Проверяем, нужно ли обновлять картинку.
        //Это необходимо, что бы при обмене с 1С картинки товаров, которые ранее уже были загружены, не загружались заново.
        //Иначе при повторной загрузке у картинок поменяется имя и старые картинки будут недоступны в поисковике.
        if(is_array($arFields) && isset($arFields['IBLOCK_ID']) && (int)$arFields['IBLOCK_ID'] ==4)
        {
            $PRODUCT_ID = (int)$arFields['ID'];

            $res = CIBlockElement::GetByID($PRODUCT_ID);
            if($ar_res = $res->GetNext())
            {
                //Анонсная картинка
                if(isset($arFields['PREVIEW_PICTURE']) && is_array($arFields['PREVIEW_PICTURE']) && $arFields['PREVIEW_PICTURE']['name']!='' && isset($ar_res['PREVIEW_PICTURE']) && (int)$ar_res['PREVIEW_PICTURE']>0)
                {
                    $rsFile = CFile::GetByID((int)$ar_res['PREVIEW_PICTURE']);
                    if($arFile = $rsFile->Fetch())
                    {
                        $new_file_name = $arFields['PREVIEW_PICTURE']['name'];
                        //Если имя старого файла совпадает с именем нового файла, тогда файл не обновляем
                        if($new_file_name==$arFile['ORIGINAL_NAME'])
                        {
                            unset($arFields['PREVIEW_PICTURE']);
                        }
                    }
                }

                //Детальная картинка
                if(isset($arFields['DETAIL_PICTURE']) && is_array($arFields['DETAIL_PICTURE']) && $arFields['DETAIL_PICTURE']['name']!='' && isset($ar_res['DETAIL_PICTURE']) && (int)$ar_res['DETAIL_PICTURE']>0)
                {
                    $rsFile = CFile::GetByID((int)$ar_res['DETAIL_PICTURE']);
                    if($arFile = $rsFile->Fetch())
                    {
                        $new_file_name = $arFields['DETAIL_PICTURE']['name'];
                        //Если имя старого файла совпадает с именем нового файла, тогда файл не обновляем
                        if($new_file_name==$arFile['ORIGINAL_NAME'])
                        {
                            unset($arFields['DETAIL_PICTURE']);
                        }
                    }
                }
            }
        }
    }

    // set prop - show in smartfilter = need reindex faset search
    function OnUpdatePropsHL(\Bitrix\Main\Entity\Event $event)
    {
        $arParameters = $event->getParameters();
        $oldVal = $arParameters['object']->collectValues(\Bitrix\Main\ORM\Objectify\Values::ACTUAL);
        $newVal = $arParameters['object']->collectValues(\Bitrix\Main\ORM\Objectify\Values::CURRENT);

        if($oldVal['UF_STATUS'] != $newVal['UF_STATUS']){ // set proprs - show in filter
            $val = ($newVal['UF_STATUS'] == 1) ? 'Y' : 'N';
            $arFields = Array('SMART_FILTER' => $val, 'IBLOCK_ID' => 4);
            $ibp = new CIBlockProperty();
            if(!$ibp->Update($oldVal['UF_PROP_ID'], $arFields))
                echo $ibp->LAST_ERROR;
        }
    }
}


