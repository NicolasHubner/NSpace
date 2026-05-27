<?php
    include("../lib/Config.php");

    try {

        $objCliente          	=  Doctrine_Core::getTable('Cliente')->find($_POST['id']);

      	if ($objCliente->senha == md5($_POST['senha_atual'])) {
        	$objCliente->senha 	= md5($_POST['nova_senha']);
        	$objCliente->save();


        	$retorno = array('status'=>'1');
      	} else {
      		$retorno = array('status'=>'2');
      	}

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>