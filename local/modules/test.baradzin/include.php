<?php


use \Bitrix\Main\Loader;


Loader::registerAutoloadClasses(
         'test.baradzin', 
        array(
            "MagicBaradzin\\Main"=>'lib/main.php',
            "MagicBaradzin\\operation_line"=>'lib/operation_line.php',

));

