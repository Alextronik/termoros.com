<?php
/**
 * Created by Notepad++.
 * User: LizoCom
 * Date: 07.02.2016
 * Time: 15:30
 */

namespace Redreams\Partners;


use Bitrix\Main\Loader;

class manager
{
    private $managerIBlockID = 8;
    private $entity;
    private $strEntityDataClass;
	private $managers;

    function __construct()
    {
        Loader::includeModule('highloadblock');

        $hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->managerIBlockID)->fetch();
        $this->entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
        $this->strEntityDataClass = $this->entity->getDataClass();
    }

    function import($fileName)
    {
		$import = new import($fileName);
        
		$managers = $import->parseNode('Менеджер');
		$managersImport = [];
		
		$hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->managerIBlockID)->fetch();
		$hlentity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
		$hl_class = $hlentity->getDataClass();
		
		$r = $hl_class::getList(['select'=>['*']]);

		while($res = $r->fetch())
		{
			$this->managers[$res['UF_XML_ID']] = $res;
		}
		
		
		
        foreach($managers as $manager)
        {
            $resultManagers = [];
            $add = [];

            foreach($manager->attributes() as $k => $v)
            {
                $resultManagers[$k] = (string)$v;
            }

            
            $add['UF_XML_ID'] = $resultManagers['managerId'];
			$add['UF_FIO'] = $resultManagers['FIO'];
			$add['UF_EMAIL'] = $resultManagers['email'];
			$add['UF_PHONE'] = $resultManagers['phone'];
			$add['UF_WORKPHONE'] = $resultManagers['workPhone'];

			$managersImport[] = $add;

        }
		
		/*
		if ($managersImport)
		{
			$hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->managerIBlockID)->fetch();
			if($hldata["TABLE_NAME"] != "")
			{
				\Bitrix\Main\Application::getConnection()->queryExecute('TRUNCATE TABLE ' . $hldata["TABLE_NAME"]);
			}
		}
		*/
		
		
        foreach($managersImport as $k => $manager) {
            
			if ($this->managers[$manager["UF_XML_ID"]])
			{
				$this->update($this->managers[$manager["UF_XML_ID"]]["ID"], $manager);
			}
			else
			{
				$this->add($manager);
			}
        }
    }

    function add($params)
    {
		$strEntityDataClass = $this->strEntityDataClass;
		$strEntityDataClass::add($params);
    }
	
	function update($id, $params)
    {
		$strEntityDataClass = $this->strEntityDataClass;
		$strEntityDataClass::update($id, $params);
    }
	

    function delete($id)
    {
        $strEntityDataClass = $this->strEntityDataClass;
        $strEntityDataClass::delete($id);
    }
	
	function getlist($params)
    {
		$query = new \Bitrix\Main\Entity\Query($this->entity);
        $query->setFilter($params);
        $query->setSelect(['ID','UF_XML_ID','UF_FIO','UF_EMAIL','UF_PHONE','UF_PHOTO','UF_WORKPHONE']);
        $result = $query->exec();
        return $result->fetchAll();
    }
	
}