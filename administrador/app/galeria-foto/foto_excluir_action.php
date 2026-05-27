<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];
	
	// Carrega os dados
	$objGaleriaFoto = Doctrine_Core::getTable('GaleriaFoto')->find($_GET['id']);
	
	// Delete
	$objGaleriaFoto->delete();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';		

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$objGaleriaFoto->galeria_id.'/');