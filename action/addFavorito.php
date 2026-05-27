<?php
    include("../lib/Config.php");

    try {

        if (isset($_SESSION['sess_cliente_id'])&&$_SESSION['sess_cliente_id']!='') {


            $objVerifica = Doctrine_Core::getTable('AnuncioFavorito')->findOneByAnuncioIdAndClienteId($_POST['anuncio_id'], $_SESSION['sess_cliente_id']);

            if (!isset($objVerifica->id)) {
                $objAnuncioFavorito                         = new AnuncioFavorito();
                $objAnuncioFavorito->data_cadastro          = date('Y-m-d H:i:s');
                $objAnuncioFavorito->anuncio_id             = $_POST['anuncio_id']; 
                $objAnuncioFavorito->cliente_id             = $_SESSION['sess_cliente_id']; 
                $objAnuncioFavorito->save();

                $retorno = array('status'=>'1');
            } else {
                $objVerifica->delete();

                $retorno = array('status'=>'2');
            }
            

        } else {
            $retorno = array('status'=>'3');
        }
    	

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>