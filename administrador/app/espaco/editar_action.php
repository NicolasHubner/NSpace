<?php
defined('_ACTION') or exit('Direct access to the script is not allowed!');
try {
	
	$objAnuncio							= Doctrine_Core::getTable('Anuncio')->find($_POST['id']);
	$objAnuncio->top_anuncio 			= $_POST['top_anuncio'];
	$objAnuncio->plano_id 				= $_POST['plano_id'];
	if (isset($_POST['plano_id'])&&$_POST['plano_id']==1) {
		$objAnuncio->pagamento 				= 1;
	} else {
		$objAnuncio->pagamento 				= $_POST['pagamento'];
	}
	$objAnuncio->save();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	
	
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}
// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');