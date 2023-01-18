<?php
/*
 * Файл local/modules/test.baradzin/install/step.php
 */
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (!check_bitrix_sessid()) {
    return;
}

if ($errorException = $APPLICATION->GetException()) {
    // выведем ошибки если они будут при установке
    CAdminMessage::ShowMessage(
        Loc::getMessage('MYMODUL_INSTALL_FAILED').': '.$errorException->GetString()
    );
} else {
    // А тут я выведу что успешно установлен
    CAdminMessage::ShowNote(
        Loc::getMessage('MYMODUL_INSTALL_SUCCESS')
    );
}
?>

<form action="<?= $APPLICATION->GetCurPage(); ?>"> <!-- Возврат -->
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>" />
    <input type="submit" value="<?= Loc::getMessage('MYMODUL_RETURN_MODULES'); ?>">
</form>