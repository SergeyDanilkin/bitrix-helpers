<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;


Loc::loadMessages(__FILE__);


class DsiHelpers extends CModule {
    public string $MODULE_ID = 'dsi.helpers';
    public string $MODULE_VERSION;
    public string $MODULE_VERSION_DATE;
    public string $MODULE_NAME;
    public string $MODULE_DESCRIPTION;
    public string $PARTNER_NAME;
    public string $PARTNER_URI;


    public function __construct() {
        $this->MODULE_NAME = 'Дополнительные инструменты';
        $this->MODULE_DESCRIPTION = '';
        $this->PARTNER_NAME = 'dsi';
        $this->PARTNER_URI = '';
        $this->MODULE_PATH = $this->getModulePath();
        $arModuleVersion = [];
        include $this->MODULE_PATH . '/install/version.php';
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
    }

    public function doInstall() : void {
        $this->InstallFiles();
        $this->InstallDB();
        $this->InstallEvents();
        RegisterModule($this->MODULE_ID);
    }

    public function InstallFiles() : void {

    }

    public function UnInstallFiles() : void {

    }

    public function installDB() : void {

    }

    public function UnInstallDB() : void{

    }

    public function InstallEvents() : void {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible("iblock", "OnIBlockPropertyBuildList",self::MODULE_ID,"\\Dsi\\Helpers\\Iblock\\CustomProperties\\Json", "GetUserTypeDescription");
    }

    public function UnInstallEvents() : void {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandlerCompatible("iblock", "OnIBlockPropertyBuildList",self::MODULE_ID,"\\Dsi\\Helpers\\Iblock\\CustomProperties\\Json", "GetUserTypeDescription");
    }

    public function doUninstall() : void {
        $this->UnInstallDB();
        $this->UnInstallFiles();
        $this->UnInstallEvents();
        UnRegisterModule($this->MODULE_ID);
    }
}
