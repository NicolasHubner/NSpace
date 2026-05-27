<?php
    include("../lib/Config.php");

    try {


        $valor                              			= Util::formata_valor($_POST['valor']);
        $valorMax                           			= Util::formata_valor($_POST['valorMax']);
        $taxaSaque                           			= Util::formata_valor($_POST['taxa_saque']);

        $_POST['banco_id'] 								= isset($_POST['banco_id'])&&$_POST['banco_id']!=''?$_POST['banco_id']:null;
        $_POST['tipo_transacao_id'] 					= isset($_POST['tipo_transacao_id'])&&$_POST['tipo_transacao_id']!=''?$_POST['tipo_transacao_id']:null;
        $_POST['cliente_id'] 							= isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?$_POST['cliente_id']:null;
    	// $_POST['valorMax']

        if ($valor >= '50.00') {
	        if ($valor > $valorMax) {
	        	$retorno = array('status'=>'2');
	        } else {

	        	$objSolicitacaoSaque                             	= new SolicitacaoSaque();
		    	$objSolicitacaoSaque->data_cadastro 				= date('Y-m-d H:i:s');
		    	$objSolicitacaoSaque->tipo_transacao_id 			= $_POST['tipo_transacao_id'];
		    	$objSolicitacaoSaque->banco_id 						= $_POST['banco_id'];
		    	$objSolicitacaoSaque->agencia 						= $_POST['agencia'];
		    	$objSolicitacaoSaque->conta 						= $_POST['conta'];
		    	$objSolicitacaoSaque->digito 						= $_POST['digito'];
		    	$objSolicitacaoSaque->cliente_id 					= $_POST['cliente_id'];
		    	$objSolicitacaoSaque->taxa_saque 					= (float)$taxaSaque;
		    	$objSolicitacaoSaque->status_saque_id				= 1;
	    		$objSolicitacaoSaque->valor 						= (float)$valor-$taxaSaque;
	    		$objSolicitacaoSaque->save();  
		    	$objSolicitacaoSaque->save();  


		        $retorno = array('status'=>'1');

	        }
        } else {
        	$retorno = array('status'=>'3');
        }


    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>