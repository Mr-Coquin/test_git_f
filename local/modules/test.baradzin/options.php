<?php
/*
 * Файл local/modules/test.baradzin/options.php
 */

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

// получаем идентификатор модуля
$request = HttpApplication::getInstance()->getContext()->getRequest();
$module_id = htmlspecialchars($request['mid'] != '' ? $request['mid'] : $request['id']);
// подключаем наш модуль
Loader::includeModule($module_id);

/*
 * Параметры модуля со значениями по умолчанию
 */
$aTabs = array(
    array(
        /*
         * Первая вкладка «Основные настройки»
         */
        'DIV'     => 'edit1',
        'TAB'     => Loc::getMessage('MYMODUL_OPTIONS_TAB_GENERAL'),
        'TITLE'   => Loc::getMessage('MYMODUL_OPTIONS_TAB_GENERAL'),
        'OPTIONS' => array(
            array(
                'switch_on',                                   // имя элемента формы
                Loc::getMessage('MYMODUL_OPTIONS_SWITCH_ON'), // поясняющий текст — «Включить модуль»
                'Y',                                           // значение по умолчанию «да»
                array('checkbox')                              // тип элемента формы — checkbox
            ),
        )
    ),
    array(
        /*
         * Вторая вкладка «Дополнительные настройки»
         */
        'DIV'     => 'edit2',
        'TAB'     => Loc::getMessage('MYMODUL_OPTIONS_TAB_ADDITIONAL'),
        'TITLE'   => Loc::getMessage('MYMODUL_OPTIONS_TAB_ADDITIONAL'),
        'OPTIONS' => array(
            /*
             * секция «Внешний вид»
             */
            Loc::getMessage('MYMODUL_OPTIONS_SECTION_VIEW'),
            array(
                'color',                                    // имя элемента формы
                Loc::getMessage('MYMODUL_OPTIONS_COLOR'),  // поясняющий текст — «Цвет фона»
                '#fff',                                  // значение по умолчанию #fff
                array('text', 5)                            // тип элемента формы — input type="text", ширина 5 симв.
            ),
        )
    )
);

/*
 * Создаем форму для редактирвания параметров модуля
 */
$tabControl = new CAdminTabControl(
    'tabControl',
    $aTabs
);

$tabControl->Begin();
?>

<form action="<?= $APPLICATION->GetCurPage(); ?>?mid=<?=$module_id; ?>&lang=<?= LANGUAGE_ID; ?>" method="post">
    <?= bitrix_sessid_post(); ?>
    <?php
    foreach ($aTabs as $aTab) { // цикл по вкладкам
        if ($aTab['OPTIONS']) {
            $tabControl->BeginNextTab();
            __AdmSettingsDrawList($module_id, $aTab['OPTIONS']);
        }
    }
    $tabControl->Buttons();
    ?>
    <input type="submit" name="apply"
           value="<?= Loc::GetMessage('MYMODUL_OPTIONS_INPUT_APPLY'); ?>" class="adm-btn-save" />
    <input type="submit" name="default"
           value="<?= Loc::GetMessage('MYMODUL_OPTIONS_INPUT_DEFAULT'); ?>" />
</form>

<?php
$tabControl->End();

/*
 * Обрабатываем данные после отправки формы
 */
if ($request->isPost() && check_bitrix_sessid()) {

    foreach ($aTabs as $aTab) { // цикл по вкладкам
        foreach ($aTab['OPTIONS'] as $arOption) {
            if (!is_array($arOption)) { // если это название секции
                continue;
            }
            if ($arOption['note']) { // если это примечание
                continue;
            }
            if ($request['apply']) { // сохраняем введенные настройки
                $optionValue = $request->getPost($arOption[0]);
                if ($arOption[0] == 'switch_on') {
                    if ($optionValue == '') {
                        $optionValue = 'N';
                    }
                }
                Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(',', $optionValue) : $optionValue);
            } elseif ($request['default']) { // устанавливаем по умолчанию
                Option::set($module_id, $arOption[0], $arOption[2]);
            }
        }
    }

    LocalRedirect($APPLICATION->GetCurPage().'?mid='.$module_id.'&lang='.LANGUAGE_ID);

}