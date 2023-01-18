<?
define("STOP_STATISTICS", true);
define("NO_KEEP_STATISTIC", 'Y');
define("NO_AGENT_STATISTIC",'Y');
define("NO_AGENT_CHECK", true);
define("DisableEventsCheck", true);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>

<?php

if (CModule::IncludeModule("test.baradzin"))
{
    global $USER;
   echo MagicBaradzin\Main::getUserNameVowels($USER->GetID());  
}


?>
<style>
    body{
        background-color: <?=COption::GetOptionString("test.baradzin", "color");?>;
    }
</style>
<?

require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_after.php");