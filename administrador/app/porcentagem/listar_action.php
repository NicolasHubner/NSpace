<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {

	// Update
	$objConfiguracao							= Doctrine_Core::getTable('Configuracao')->find(1);
	$objConfiguracao->cent_nspace 				= $_POST['cent_nspace'];
	$objConfiguracao->cent_cliente 				= $_POST['cent_cliente'];
	$objConfiguracao->cent_afiliado 			= $_POST['cent_afiliado'];
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