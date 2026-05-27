<?php
  include("../lib/Config.php");


    $numerVerificador = rand(45668446, 3146546496);
    
    $objCliente          	                  =  Doctrine_Core::getTable('Cliente')->findOneByEmail($_POST['email']);
    if (isset($objCliente->id)&&$objCliente->id!='') {
      $objCliente->senha                      = md5($numerVerificador);
      $objCliente->save();

      include('emails/email_verificacao_senha.php');
      
      $retorno = array('status'=>'1');
    } else {
      $retorno = array('status'=>'2');
    }
     

  
  echo json_encode($retorno);
?>