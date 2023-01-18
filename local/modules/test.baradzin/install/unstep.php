<?php
/*
 * Файл local/modules/test.baradzin/install/unstep.php
 */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (!check_bitrix_sessid()){
    return;
}

if ($errorException = $APPLICATION->GetException()) {
    // ошибки вывод при удаление
    CAdminMessage::ShowMessage(
        Loc::getMessage('MYMODUL_UNINSTALL_FAILED').': '.$errorException->GetString()
    );
} else {
    // снесли модуль удачно
    CAdminMessage::ShowNote(
        Loc::getMessage('MYMODUL_UNINSTALL_SUCCESS')
    );
}
?>

<form action="<?= $APPLICATION->GetCurPage(); ?>"> <!-- Кнопка возврата -->
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>" />
    <input type="submit" value="<?= Loc::getMessage('MYMODUL_RETURN_MODULES'); ?>">
</form>