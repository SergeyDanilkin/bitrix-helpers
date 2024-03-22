<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;


Loc::loadMessages(__FILE__);


class dsi_helpers extends CModule {
    public $MODULE_ID = 'dsi.helpers';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME;
    public $PARTNER_URI;


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

    protected function getModulePath() : string {
        $modulePath = explode('/', __FILE__);
        $modulePath = array_slice($modulePath, 0, array_search($this->MODULE_ID, $modulePath) + 1);
        return join('/', $modulePath);
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
        $eventManager->registerEventHandlerCompatible("iblock", "OnIBlockPropertyBuildList", $this->MODULE_ID, "\\Dsi\\Helpers\\Iblock\\CustomProperties\\Json", "GetUserTypeDescription");
    }

    public function UnInstallEvents() : void {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler("iblock", "OnIBlockPropertyBuildList", $this->MODULE_ID, "\\Dsi\\Helpers\\Iblock\\CustomProperties\\Json", "GetUserTypeDescription");
    }

    public function doUninstall() : void {
        $this->UnInstallDB();
        $this->UnInstallFiles();
        $this->UnInstallEvents();
        UnRegisterModule($this->MODULE_ID);
    }
}
