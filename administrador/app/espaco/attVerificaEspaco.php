<?php
require_once('../../../lib/Config.php');


try {
	
	$objAnuncio  					= Doctrine_Core::getTable('Anuncio')->find($_POST['id']);
	$objAnuncio->status_id 			= $_POST['status_id'];
	$objAnuncio ->save();
	
	if (isset($_POST['resposta_automatica_id'])&&$_POST['resposta_automatica_id']!='') {
		$objRespostaAutomatica 		= Doctrine_Core::getTable('RespostaAutomatica')->find($_POST['resposta_automatica_id']);
		$objAnuncio->aviso 				= isset($_POST['aviso'])&&$_POST['aviso']!=''?$_POST['aviso'].' '.$objRespostaAutomatica->texto:$objRespostaAutomatica->texto;
	} else {
		$objAnuncio->aviso 				= $_POST['aviso'];
	}
	$objAnuncio ->save();

	if (isset($_POST['status_id'])&&$_POST['status_id']==2) {
		include('email_espaco_aprovado.php');
	}

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.'espaco'.'/');