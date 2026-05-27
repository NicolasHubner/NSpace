<?php
defined('_ACTION') or exit('Direct access to the script is not allowed!');
try {
	
	// Insert
	$objRespostaAutomatica						= new RespostaAutomatica();
	$objRespostaAutomatica->data_cadastro 		= date('Y-m-d H:i:s');
	$objRespostaAutomatica->texto 				= $_POST['texto'];
	$objRespostaAutomatica->save();

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}
// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');