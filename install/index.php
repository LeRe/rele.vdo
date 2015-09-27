<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Rele\Vdo\OrderTable;
use Rele\Vdo\UsedPartsTable;

Loc::loadMessages(__FILE__);

if (class_exists('rele_vdo')) {
    return;
}

class rele_vdo extends CModule
{
    public $MODULE_ID;
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_GROUP_RIGHTS;
    public $PARTNER_NAME;
    public $PARTNER_URI;

    public function __construct()
    {
        $this->MODULE_ID = 'rele.vdo';
        $this->MODULE_VERSION = '0.0.2';
        $this->MODULE_VERSION_DATE = '2015-09-26 19:09:00';
        $this->MODULE_NAME = Loc::getMessage('VDO_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('VDO_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = "ReLe";
        $this->PARTNER_URI = "http://ijava.ru";
    }

    function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION, $step;

        $step = IntVal($step);
        if($step < 2) 
        {
            $APPLICATION->IncludeAdminFile(GetMessage('VDO_INSTALL_TITLE'), $DOCUMENT_ROOT."/bitrix/modules/rele.vdo/install/step1.php");
        }
        elseif($step == 2)
        {
            ModuleManager::registerModule($this->MODULE_ID);

            $installSampleData = isset($_REQUEST['sampledata']) && $_REQUEST['sampledata'] == 'Y';
            $this->InstallDB($installSampleData);            
            $this->InstallFiles();
            CAgent::AddAgent(
                'Rele\Vdo\ImportCSV::loadData();', 
                $this->MODULE_ID, 
                "N", 
                300 
            );
            $APPLICATION->IncludeAdminFile(GetMessage("VDO_INSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/rele.vdo/install/step2.php");
        }
    }

    function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION, $step;

        $step = IntVal($step);
        if($step < 2)
        {
            $APPLICATION->IncludeAdminFile(GetMessage('VDO_UNINSTALL_TITLE'), $DOCUMENT_ROOT."/bitrix/modules/rele.vdo/install/unstep1.php");
        }
        elseif($step == 2)
        {
            if(!isset($_REQUEST['savedata']) || $_REQUEST['savedata'] != 'Y')
            {
                $this->UnInstallDB();
            }

            $this->UnInstallFiles();

            CAgent::RemoveAgent(
                'Rele\Vdo\ImportCSV::loadData();', 
                $this->MODULE_ID
                );
            
            COption::RemoveOption($this->MODULE_ID);
            UnRegisterModuleDependences("catalog", "OnProductAdd", $this->MODULE_ID, "Rele\Vdo\Utils", "vatEnable");

            ModuleManager::unregisterModule($this->MODULE_ID);          
            $APPLICATION->IncludeAdminFile(GetMessage('VDO_UNINSTALL_TITLE'), $DOCUMENT_ROOT."/bitrix/modules/rele.vdo/install/unstep2.php");
        }        
    }

    function InstallDB($installSample)
    {
        if(Loader::includeModule($this->MODULE_ID))
        {
            if(!OrderTable::isTableExists())
            {
                OrderTable::createTable();
            }
            if(!UsedPartsTable::isTableExists())
            {
                UsedPartsTable::createTable();
            }

            if($installSample)
            {
                if(OrderTable::getCount() == 0 and UsedPartsTable::getCount() == 0)
                {
                    OrderTable::addSampleData();
                    UsedPartsTable::addSampleData();
                }
            }
        }
        return true;        
    }

    function UnInstallDB()
    {
        if(Loader::includeModule($this->MODULE_ID))
        {
            OrderTable::dropTable();
            UsedPartsTable::dropTable();
        }
        return true;        
    }

    function InstallFiles()
    {
        global $DOCUMENT_ROOT;
        CopyDirFiles($DOCUMENT_ROOT."/bitrix/modules/rele.vdo/install/components",
            $DOCUMENT_ROOT."/bitrix/components", true, true);
        CopyDirFiles($DOCUMENT_ROOT."/bitrix/modules/rele.vdo/install/admin", 
            $DOCUMENT_ROOT."/bitrix/admin", true);
        return true;
    }

    function UnInstallFiles()
    {
        global $DOCUMENT_ROOT;
        DeleteDirFilesEx("/bitrix/components/rele.vdo");
        DeleteDirFiles($DOCUMENT_ROOT."/bitrix/modules/rele.vdo/install/admin", $DOCUMENT_ROOT."/bitrix/admin");
        return true;
    }
}
