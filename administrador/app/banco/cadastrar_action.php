<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Insert
	$objBanco							= new Banco();
	$objBanco->nome 				    = $_POST['nome'];
	$objBanco->codigo 				    = $_POST['codigo'];
	$objBanco->save();

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