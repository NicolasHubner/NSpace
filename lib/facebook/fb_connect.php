<?php
    //primeiro você chama o sdk do facebook
    require ('facebook-php-sdk-master/src/facebook.php');

    //aqui você instancia com as informações do seu app (tem que criar um app em developers.facebook.com)
    $facebook = new Facebook(array(
        'appId'     =>  'YOUR_APP_ID',
        'secret'    =>  'YOUR_APP_SECRET'
    ));
?>