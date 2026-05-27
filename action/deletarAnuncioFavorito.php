<?php
    include("../lib/Config.php");

    try {

        $objAnuncioFavorito                          =  Doctrine_Core::getTable('AnuncioFavorito')->find($_POST['id']);
        $objAnuncioFavorito->delete();

        $retorno = array('status'=>'1');

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>