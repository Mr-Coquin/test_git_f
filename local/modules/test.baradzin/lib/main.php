<?php


namespace MagicBaradzin;
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use MagicBaradzin\operation_line;

class Main extends operation_line{


    public static function getUserNameVowels(int $id): string
    {

$res = \Bitrix\Main\UserTable::getList(Array(
   "filter"=>Array("ID"=>$id),
));
while ($arRes = $res->fetch()) {
   $result=$arRes['NAME'].$arRes['LAST_NAME'].$arRes['SECOND_NAME'];
   $result= self::mod($result);
}



        return $result;
    }
    
         public static function  mod(string $str): string{
        $ok_result_str=$str;
        $ok_result_str=self::down_str($ok_result_str);
        $ok_result_str=self::clear_len($ok_result_str);
        return $ok_result_str;
    }

    public static function down_str(string $str): string{
        $new_str = str_replace(" ", '', $str);
        return mb_strtolower($new_str);
    }
    public static function clear_len(string $str): string{
        $p = array('/(б|в|г|д|ж|з|й|к|л|м|н|п|р|с|т|ф|х|ц|ч|ш|щ)/ui');
        return preg_replace($p, '', $str);
    }
}


