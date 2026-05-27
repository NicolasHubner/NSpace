<?php
require_once('../../../lib/Config.php');


try {
	
	$objClienteMigracao  					= Doctrine_Core::getTable('ClienteMigracao')->find($_POST['id']);
	$objClienteMigracao->status 			= $_POST['status'];
	$objClienteMigracao ->save();

	
	if (isset($_POST['resposta_automatica_id'])&&$_POST['resposta_automatica_id']!='') {
		$objRespostaAutomatica 		= Doctrine_Core::getTable('RespostaAutomatica')->find($_POST['resposta_automatica_id']);
		$objClienteMigracao->aviso 				= isset($_POST['aviso'])&&$_POST['aviso']!=''?$_POST['aviso'].' '.$objRespostaAutomatica->texto:$objRespostaAutomatica->texto;
	} else {
		$objClienteMigracao->aviso 				= $_POST['aviso'];
	}
	$objClienteMigracao ->save();

	if (isset($_POST['status_id'])&&$_POST['status_id']==2) {
		include('email_espaco_aprovado.php');
	}

	$objCliente  							= Doctrine_Core::getTable('Cliente')->find($objClienteMigracao->cliente_id);
	if (isset($_POST['status'])&&$_POST['status']==2) {
		$objCliente->tipo_cliente_id 			= $objClienteMigracao->tipo_cliente_id;
	}
	$objCliente->verificado 				= $_POST['status'];
	$objCliente ->save();



	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.'cliente/detalhes/'.$objCliente->id.'/');