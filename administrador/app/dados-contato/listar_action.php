<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	$_POST['cidade_id']       = isset($_POST['cidade_id'])&&$_POST['cidade_id']!=''?$_POST['cidade_id']:null;
	$_POST['estado_id']       = isset($_POST['estado_id'])&&$_POST['estado_id']!=''?$_POST['estado_id']:null;

	// Update
	$objConfiguracao						= Doctrine_Core::getTable('Configuracao')->find(1);
	$objConfiguracao->email 				= $_POST['email'];
	$objConfiguracao->telefone 				= $_POST['telefone'];
	$objConfiguracao->whatsapp 				= $_POST['whatsapp'];
	$objConfiguracao->cep 					= $_POST['cep'];
	$objConfiguracao->logradouro 			= $_POST['logradouro'];
	$objConfiguracao->numero 				= $_POST['numero'];
	$objConfiguracao->complemento 			= $_POST['complemento'];
	$objConfiguracao->bairro 				= $_POST['bairro'];
	$objConfiguracao->estado_id 			= $_POST['estado_id'];
	$objConfiguracao->cidade_id 			= $_POST['cidade_id'];
	$objConfiguracao->save();


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