<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {

		
	$_POST['dns'] 						= Util::getCleanUrl($_POST['nome']);
					
	// Update
	$objGaleriaVideo					= Doctrine_Core::getTable('GaleriaVideo')->find($_POST['id']);
	$objGaleriaVideo->nome 				= $_POST['nome'];
	$objGaleriaVideo->codigo 			= $_POST['codigo'];
	$objGaleriaVideo->status 			= $_POST['status'];
	$objGaleriaVideo->destaque 			= $_POST['destaque'];
	$objGaleriaVideo->save();

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