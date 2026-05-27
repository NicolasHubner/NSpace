<?php
    include("../lib/Config.php");

    try {

    $objReserva                          =  Doctrine_Core::getTable('Reserva')->findOneByClienteIdAndId($_POST['cliente_id'], $_POST['reserva_id']);

    if (isset($objReserva->id)&&$objReserva->id!='') {
        if ($objReserva->codigo == $_POST['codigo']) {
           
            $objReserva->validacaoCodigo     =   1;
            $objReserva->save();

            include('emails/reserva/valida-retorno-cliente.php');
            include('emails/reserva/valida-retorno-spacehost.php');


            $retorno = array('status'=>'1');

        } else {
            $retorno = array('status'=>'2');
        }
    }
    

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>