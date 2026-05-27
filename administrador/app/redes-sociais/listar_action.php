<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	

	// Update
	$objRedeSocial							= Doctrine_Core::getTable('RedeSocial')->find(1);
	$objRedeSocial->instagram 				= $_POST['instagram'];
	$objRedeSocial->facebook 				= $_POST['facebook'];
	$objRedeSocial->youtube 				= $_POST['youtube'];
	$objRedeSocial->linkedin 				= $_POST['linkedin'];
	// $objRedeSocial->tiktok 					= $_POST['tiktok'];
	$objRedeSocial->save();


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