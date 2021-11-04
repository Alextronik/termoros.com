<?php
/**
 * Created by Notepad++.
 * User: LizoCom
 * Date: 03.02.2016
 * Time: 12:00
 */

namespace Redreams\Partners;


use Bitrix\Main\Loader;

class credit
{
    private $creditIBlockID = 7;
    private $entity;
    private $strEntityDataClass;

    function __construct()
    {
        Loader::includeModule('highloadblock');

        $hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->creditIBlockID)->fetch();
        $this->entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
        $this->strEntityDataClass = $this->entity->getDataClass();
    }

    function import($fileName)
    {
        $import = new import($fileName);
        
		$credits = $import->parseNode('Кредит');
		$creditsImport = [];

        foreach($credits as $credit)
        {
            $resultCredits = [];
            $add = [];

            foreach($credit->attributes() as $k => $v)
            {
                $resultCredits[$k] = (string)$v;
            }

            
            $add['UF_PARTNER'] = partner::getByXMLID($resultCredits['clientId']);
			$add['UF_CREDIT_OVERALL'] = $resultCredits['creditOverall'];
			$add['UF_LIMIT_OVERALL'] = $resultCredits['limitOverall'];
			$add['UF_PAYMENT_DATE'] = str_replace("T", " ", $resultCredits['paymentDate']);
			$add['UF_CREDIT_SUM'] = $resultCredits['сredit'];
			
			if (!$add['UF_LIMIT_OVERALL']) $add['UF_LIMIT_OVERALL'] = $add['UF_CREDIT_OVERALL'];
			
            if($add['UF_PARTNER'] && $add['UF_CREDIT_SUM'] > 100 )
            {
				$creditsImport[] = $add;

            }
        }

		
		if ($creditsImport)
		{
			$hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->creditIBlockID)->fetch();
			if($hldata["TABLE_NAME"] !="")
			{
				\Bitrix\Main\Application::getConnection()->queryExecute('TRUNCATE TABLE ' . $hldata["TABLE_NAME"]);
			}
		}
		
		
        foreach($creditsImport as $k => $credit) {
            $this->add($credit);
        }
		

        
    }

    function getlist($params)
    {
		$query = new \Bitrix\Main\Entity\Query($this->entity);
        $query->setFilter($params);
        $query->setSelect(['ID','UF_PARTNER','UF_CREDIT_OVERALL','UF_LIMIT_OVERALL','UF_PAYMENT_DATE','UF_CREDIT_SUM']);
        $result = $query->exec();
        return $result->fetchAll();
    }

    function add($params)
    {
		$strEntityDataClass = $this->strEntityDataClass;
		$strEntityDataClass::add($params);
    }

    function delete($id)
    {
        $strEntityDataClass = $this->strEntityDataClass;
        $strEntityDataClass::delete($id);
    }
	
	
}