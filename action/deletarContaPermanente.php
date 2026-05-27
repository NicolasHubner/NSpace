<?php
    include("../lib/Config.php");

    try {

        $objCliente                                 =  Doctrine_Core::getTable('Cliente')->find($_POST['id']);
        $objCliente->status                         = 3;
        $objCliente->save();

        // $objExclusaoConta                           = new ExclusaoConta();
        // $objExclusaoConta->data_exclusao            = date('Y-m-d H:i:s');
        // $objExclusaoConta->nome                     = $objCliente->nome;
        // $objExclusaoConta->email                    = $objCliente->email;
        // $objExclusaoConta->whatsapp                 = $objCliente->telefone;
        // $objExclusaoConta->save();

        $retAnuncio                                 = Doctrine_Query::create()->select()->from('Anuncio')->where('cliente_id = '.$objCliente->id)->execute();
        foreach ($retAnuncio as $objAnuncio) {
            $objAnuncio->status_id          = 4;
            $objAnuncio->save();
        }


        unset($_SESSION['sess_cliente_id']);


        $retorno = array('status'=>'1');

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>