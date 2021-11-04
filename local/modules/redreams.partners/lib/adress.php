<?php
/**
 * Created by PhpStorm.
 * User: bearl
 * Date: 05.07.2016
 * Time: 20:21
 */

namespace Redreams\Partners;


use Bitrix\Main\Loader;

class adress
{
    private $addressIBlockID = 5;
    private $entity;
    private $strEntityDataClass;

    function __construct()
    {
        Loader::includeModule('highloadblock');

        $hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->addressIBlockID)->fetch();
        $this->entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
        $this->strEntityDataClass = $this->entity->getDataClass();
    }

    function import($fileName)
    {
        $import = new import($fileName);
        $adresses = $import->parseNode('адрес_доставки');
        $adressesImport = [];

        foreach($adresses as $addr)
        {
            $resultAdresses = [];
            $add = [];

            foreach($addr->attributes() as $k => $v)
            {
                $resultAdress[$k] = (string)$v;
            }

            $add['UF_ADRESS'] = $resultAdress['adress'];
            $add['UF_PARTNER'] = partner::getByXMLID($resultAdress['client_id']);

            if($add['UF_PARTNER'])
            {
				$adressesImport[$add['UF_PARTNER']][] = $add;

            }
        }


		if ($adressesImport)
		{
			$hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->addressIBlockID)->fetch();
			if($hldata["TABLE_NAME"] !="")
			{
				\Bitrix\Main\Application::getConnection()->queryExecute('TRUNCATE TABLE ' . $hldata["TABLE_NAME"]);
			}
		}
		
        foreach($adressesImport as $partner => $addrs) {
            $adressDB = self::getlist(['UF_PARTNER' => $partner]);
            //p($adressDB);
            foreach ($addrs as $k => $addr)
            {
                if($adressDB[$k]){
                    $addr['ID'] = $adressDB[$k]['ID'];

                }
                $this->add($addr);
            }
        }

        //$adressDB = self::getlist(['UF_PARTNER' => ])
    }

    function getlist($params)
    {
        $query = new \Bitrix\Main\Entity\Query($this->entity);
        $query->setFilter($params);
        $query->setSelect(['ID','UF_ADRESS','UF_PARTNER']);
        $result = $query->exec();
        return $result->fetchAll();
    }

    function add($params)
    {
        //p($params);
        $strEntityDataClass = $this->strEntityDataClass;
        //$adress = $this->getlist(['ID' => $params['ID']]);
        //p($adress);
        if($params['ID'])
        {
            $strEntityDataClass::update($params['ID'],$params);
        }
        else
        {
            $strEntityDataClass::add($params);
        }
    }

    function delete($id)
    {
        $strEntityDataClass = $this->strEntityDataClass;
        $strEntityDataClass::delete($id);
    }
}