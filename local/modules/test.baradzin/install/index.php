<?php
/*
 * Файл local/modules/test.baradzin/install/index.php
 */

defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
//подключаем нужные библиотеки bitrix
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);


if (class_exists('test_baradzin')) {
    return;
}


class test_baradzin extends CModule {

    public function __construct() {
        if (is_file(__DIR__.'/version.php')){
            include_once(__DIR__.'/version.php');
            $this->MODULE_ID           = 'test.baradzin';
            $this->MODULE_VERSION      = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
            $this->MODULE_NAME         = Loc::getMessage('MYMODUL_NAME');
            $this->MODULE_DESCRIPTION  = Loc::getMessage('MYMODUL_DESCRIPTION');
            $this->PARTNER_NAME = "Baradzin";
        } else {
            CAdminMessage::ShowMessage(
                Loc::getMessage('MYMODUL_FILE_NOT_FOUND').' version.php'
            );
        }
    }
    
    public function DoInstall() {
//метод установки
        global $APPLICATION;

        // Проверяем ядро
        if (CheckVersion(ModuleManager::getVersion('main'), '14.00.00')) {
            // метод копировния файлов
            $this->InstallFiles();

            // а тут регистрация модуля
            ModuleManager::registerModule($this->MODULE_ID);
                       // метод создания таблиц 
            //$this->InstallDB();
        } else {
            //вывод ошибки
            CAdminMessage::ShowMessage(
                Loc::getMessage('MYMODUL_INSTALL_ERROR')
            );
            return;
        }

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('MYMODUL_INSTALL_TITLE').' «'.Loc::getMessage('MYMODUL_NAME').'»',
            __DIR__.'/step.php'
        );
    }
    
    public function InstallFiles() {
        // тут файлы закинем для работы js и css они не нужны нам но я покажу возможность 
        CopyDirFiles(
            __DIR__.'/assets/scripts',
            Application::getDocumentRoot().'/bitrix/js/'.$this->MODULE_ID.'/',
            true,
            true
        );

        CopyDirFiles(
            __DIR__.'/assets/styles',
            Application::getDocumentRoot().'/bitrix/css/'.$this->MODULE_ID.'/',
            true,
            true
        );
    }
    
    public function InstallDB() {
        return;
    }



    public function DoUninstall() {
//а это уже сносим все 
        global $APPLICATION;

        $this->UnInstallFiles();
       // $this->UnInstallDB();

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('MYMODUL_UNINSTALL_TITLE').' «'.Loc::getMessage('MYMODUL_NAME').'»',
            __DIR__.'/unstep.php'
        );

    }

    public function UnInstallFiles() {
        // сносим файлы если установили
        Directory::deleteDirectory(
            Application::getDocumentRoot().'/bitrix/js/'.$this->MODULE_ID
        );

        Directory::deleteDirectory(
            Application::getDocumentRoot().'/bitrix/css/'.$this->MODULE_ID
        );
        // удаляем настройки
        Option::delete($this->MODULE_ID);
    }
    
    public function UnInstallDB() {
        return;
    }
    

}