<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	

	// Update
	$objConfiguracao						= Doctrine_Core::getTable('Configuracao')->find(1);
	$objConfiguracao->nome 					= $_POST['nome'];
	$objConfiguracao->google_descricao 		= $_POST['google_descricao'];
	$objConfiguracao->google_keywords 		= $_POST['google_keywords'];
	$objConfiguracao->google_analytics 		= $_POST['google_analytics'];
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