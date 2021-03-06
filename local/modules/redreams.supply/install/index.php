<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

class redreams_supply extends CModule
{

    public function __construct()
    {
        $arModuleVersion = array();
        
        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        
        $this->MODULE_ID = 'redreams.supply';
        $this->MODULE_NAME = Loc::getMessage('R_SUPPLY_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('R_SUPPLY_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('R_SUPPLY_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = "http://redreams.ru";
    }

    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function doUninstall()
    {
        ModuleManager::unregisterModule($this->MODULE_ID);
    }

}
