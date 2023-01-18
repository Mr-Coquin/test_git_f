<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$new_url = explode("/", $url);
if (($new_url[4] > 0) && (is_int(intval($new_url[4])))):
    if (($new_url[5] === '4534534cx543')):
        if (($new_url[6] === 'get.username.vowels')):
            if (CModule::IncludeModule("test.baradzin")) {
                global $USER;
                echo MagicBaradzin\Main::getUserNameVowels($new_url[4]);
            }
        endif;
    endif;
endif;
//делал без БД и конфигов в модуле на проверку API . ЧТо бы показать принцип обработки 
?>
