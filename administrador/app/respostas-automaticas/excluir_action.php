<?php
defined('_ACTION') or exit('Direct access to the script is not allowed!');

	try {
		
		$objRespostaAutomatica = Doctrine_Core::getTable('RespostaAutomatica')->find($_GET['id']);
		$objRespostaAutomatica->delete();


		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';

	} catch(Exception $e){
		
		$_SESSION['return_type'] 	= 'error';
		$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
		
	}

header('Location: '.URL_ADMIN.$_GET['model'].'/');