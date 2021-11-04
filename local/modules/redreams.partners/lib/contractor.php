<?php
/**
 * Created by PhpStorm.
 * User: bearl
 * Date: 11.07.2016
 * Time: 17:54
 */

namespace Redreams\Partners;

use Bitrix\Main\Loader;
use Bitrix\Main\Page;

Loader::includeModule('sale');

class contractor
{
    function __construct()
    {

    }

    public function import($fileName)
    {
        $import = new import($fileName);
        $contractors = $import->parseNode('Контрагент');
       // p($contractors);
		
        foreach($contractors as $contractor)
        {
            $resultContractor = [];

            foreach($contractor->attributes() as $k => $v)
            {
                $resultContractor[$k] = trim((string)$v);
            }
            $this->add($resultContractor);
        }
    }

    public function add($addFields)
    {

		if ($addFields['firstName'] || $addFields['middleName'] || $addFields['lastName'])
		{
			$addFields['contactPerson'] = sprintf('%s %s %s',$addFields['firstName'],$addFields['middleName'],$addFields['lastName']);
		}
		elseif ($addFields['profileName'])
		{
			$addFields['contactPerson'] = $addFields['profileName'];
		}

        $change = [1=>[
            "contactPerson" => "FIO",
            //"KPP" => "KPP",
            //"BIK" => "BIK",
            //"bankName" => "BANK_NAME",
            //"korrAccount" => "KSCHET",
            //"accountNumber" => "RSCHET",
            //"legalAddress" => "COMPANY_ADR",
            "phone" =>"PHONE",
            "email" => "EMAIL",
        ],
		2=>[
            "INN" => "INN",
            //"KPP" => "KPP",
            //"BIK" => "BIK",
            //"bankName" => "BANK_NAME",
            //"korrAccount" => "KSCHET",
            //"accountNumber" => "RSCHET",
            //"legalAddress" => "COMPANY_ADR",
            "phone" =>"PHONE",
            "email" => "EMAIL",
            "companyName"=>"COMPANY",
            "position" => "DOLJ",
            "contactPerson" => "CONTACT_PERSON"
        ],
        3=>[
            "INN" => "INN",
            //"KPP" => "KPP",
            //"BIK" => "BIK",
            //"bankName" => "BANK_NAME",
            //"korrAccount" => "KSCHET",
            //"accountNumber" => "RSCHET",
            //"legalAddress" => "ADDRESS",
            "phone" =>"PHONE",
            "email" => "EMAIL",
            "companyName"=>"COMPANY",
            "position" => "DOLJ",
            "contactPerson" => "CONTACT_PERSON"
        ]];

        //p($addFields);
		
		if (!$addFields['INN']) $addFields['INN'] = '111111111111';
		if (!$addFields['phone'] || $addFields['phone'] == 'Не указан') $addFields['phone'] = '111111111';
		
        if(!$userID = $this->getPartnerByID($addFields['client_id']))
        {
            return;
        }
		
        $fields = [
            "NAME" => $addFields['profileName'],
            "USER_ID" => $userID,
            "PERSON_TYPE_ID" => $addFields['payerType'],
            "XML_ID" => $addFields['contractor_id'],
            "VERSION_1C" => $addFields['version_1c']
         ];

        //p($fields);

        $fieldsFilter['XML_ID'] = $fields['XML_ID'];

        $result = \CSaleOrderUserProps::GetList([],$fieldsFilter)->GetNext();

        //p($result);

        if($result['ID'])
        {
            \CSaleOrderUserProps::Update($result['ID'],$fields);
            $id = $result['ID'];
        }
        else
        {
            $id = \CSaleOrderUserProps::Add($fields);
        }

        if($id)
        {
            $this->userPropID = $id;
        }

        $this->errors = [];
        $this->delete = false;

        foreach ($addFields as $k => $v)
        {
            //p($userPropID);

            $prop = \CSaleOrderProps::GetList([],[
                    'CODE'=>$change[$addFields['payerType']][$k],
                    'PERSON_TYPE_ID' => $addFields['payerType']
                ]
            )->Fetch();

            if($prop['ID'])
            {
                $fields = [
                    "USER_PROPS_ID" => $this->userPropID,
                    "ORDER_PROPS_ID" => $prop['ID'],
                    "NAME" => $prop['NAME'],
                    "VALUE" => $v
                ];

                //p($fields);

                $fieldsFilter = $fields;
                unset($fieldsFilter["NAME"]);
                unset($fieldsFilter["VALUE"]);

                $propValue = \CSaleOrderUserPropsValue::GetList([],$fieldsFilter)->Fetch();

                if(!$v)
                {
                    if($propValue['VALUE'])
                    {
                        
						$part = \CUser::GetList($by,$order,['XML_ID'=>$addFields['client_id']])->GetNext();
						$this->errors[] = $part["NAME"]." ; ".$addFields['profileName']." ; не заполнено следующее поле: ".$prop['NAME'].'. Поле было взято из предыдущей записи.';
                        continue;
                    }
                    else
                    {
                        $part = \CUser::GetList($by,$order,['XML_ID'=>$addFields['client_id']])->GetNext();
						$this->errors[] = $part["NAME"]." ; ".$addFields['profileName']." ; не заполнено следующее поле: ".$prop['NAME'];
                        $this->delete = true;
                        continue;
                    }

                }

                if($propValue['ID'])
                {
                    \CSaleOrderUserPropsValue::Update($propValue['ID'],$fields);
                }
                else
                {
                    \CSaleOrderUserPropsValue::Add($fields);
                }
            }

        }
        $this->showError();

        if($this->delete){
            \CSaleOrderUserProps::Delete($id);
        }
    }

    public function getPartnerByID($id)
    {
        $by = "ID";
		$order = "DESC";
		return \CUser::GetList($by,$order,['XML_ID'=>$id, 'ACTIVE' => 'Y'])->GetNext()['ID'];
    }

    public function showError()
    {
        if($this->errors)
        {
            echo implode("\n\r<br>",$this->errors).'<br>'."\n\r";
        }
    }

    public static function getCurentContractor()
    {
        global $USER;
        $user = \CUser::GetList($by,$order,['ID'=>$USER->GetID()],["SELECT"=>['UF_CONTRACTOR']])->GetNext();
        return $user['UF_CONTRACTOR'];
    }

    public static function setContractor($id)
    {
        global $USER;
        $user = new \CUser();
        $user->Update($USER->GetID(),['UF_CONTRACTOR' => $id]);
    }

    public static function sendEditRequest()
    {
        foreach($_REQUEST as $k=>$v)
        {
            if(strpos($k,'ORDER_PROP')!==false)
            {
                $k = str_replace('ORDER_PROP_','',$k);
                $props[str_replace('ORDER_PROP_','',$k)] = $v;
            }
        }

        if($props)
        {
            $res = \CSaleOrderProps::GetList([],['ID'=>array_keys($props)]);
            while($ar = $res->Fetch())
            {
                $propData[$ar['ID']] = $ar;
            }

            foreach($props as $id => $v)
            {
                if(strpos($id,'val')!==false)
                {
                    $result[] = 'Город: '.$v;
                }
                else
                {
                    $result[] = $propData[$id]['NAME'].': '.$v;
                }
            }

           if($result)
           {
               $fields['TEXT'] = implode("\n",$result);
               $fields['XML_ID'] = partner::getXMLID();
               $fields['CONTRACTOR'] = \CUser::GetList($by,$order,['ID'=>$_REQUEST['ID']])->GetNext()['XML_ID'];
           }
        }


        \CEvent::Send('PARTNER_EDIT_CONTRACTOR','s1',$fields);

    }

}