<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("AJAX");


?>
<script>
var request = BX.ajax.runAction('custom:ajax', {
    data: {
        url: '/index.php',
        method: 'POST',
        dataType: 'json',

    },
});
request.then(function(response){
    console.log(response);
});
</script>
<?php

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');