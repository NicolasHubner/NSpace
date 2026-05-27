<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	$_POST['dns'] 						= Util::getCleanUrl($_POST['nome']);
	$_POST['nome']						= isset($_POST['nome'])&&$_POST['nome']!=''?$_POST['nome']:null;

	// Insert
	$objCategoria						= new Categoria();
	$objCategoria->data_cadastro		= date('Y-m-d H:i:s');
	$objCategoria->nome 				= $_POST['nome'];
	$objCategoria->dns 					= $_POST['dns'];
	$objCategoria->status 				= $_POST['status'];
	$objCategoria->save();
	
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