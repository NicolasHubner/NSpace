<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {

	$_POST['estado_id']					= isset($_POST['estado_id'])&&$_POST['estado_id']!=''?$_POST['estado_id']:null;
	$_POST['cidade_id']					= isset($_POST['cidade_id'])&&$_POST['cidade_id']!=''?$_POST['cidade_id']:null;
	
	// Load
	$objCliente 						= Doctrine_Core::getTable('Cliente')->find($_POST['id']);
	$objCliente->nome					= $_POST['nome'];
	$objCliente->email					= $_POST['email'];
	$objCliente->telefone				= $_POST['telefone'];

	if (isset($_POST['senha'])&&$_POST['senha']!='') {
		$objCliente->senha				= $_POST['senha'];
	}
	
	$objCliente->cep					= $_POST['cep'];
	$objCliente->logradouro				= $_POST['logradouro'];
	$objCliente->numero					= $_POST['numero'];
	$objCliente->complemento			= $_POST['complemento'];
	$objCliente->bairro					= $_POST['bairro'];
	$objCliente->estado_id				= $_POST['estado_id'];
	$objCliente->cidade_id				= $_POST['cidade_id'];
	$objCliente->status					= $_POST['status'];
	$objCliente->email_confirmado		= $_POST['email_confirmado'];
	$objCliente->tipo_cliente_id		= $_POST['tipo_cliente_id'];
	$objCliente->verificado				= $_POST['verificado'];
	$objCliente->save();
	
	// Tratamento de retorno
	$_SESSION['return_type']	= 'success';
	$_SESSION['return_message'] = 'Executado com sucesso.';

	

} catch(Exception $e){

	echo $e;
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente.';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');