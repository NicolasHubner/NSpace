<?php
    include("../lib/Config.php");

    try {

        $objAnuncioDataPersonalizada                          =  Doctrine_Core::getTable('AnuncioDataPersonalizada')->find($_POST['id']);
        $objAnuncioDataPersonalizada->delete();

        $retorno = array('status'=>'1');

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>