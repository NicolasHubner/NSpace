<?php
defined('_ACTION') or exit('Direct access to the script is not allowed!');

	try {
		
		$objArquivo = Doctrine_Core::getTable('Arquivo')->find($_GET['id']);
		$arquivo	= $objArquivo->arquivo;
		
		$objArquivo->delete();

		// Remove a imagem
		if ($arquivo != ''){
			@unlink(PATH_ARQUIVO.$arquivo);
		}

		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';

	} catch(Exception $e){
		
		$_SESSION['return_type'] 	= 'error';
		$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
		
	}

header('Location: '.URL_ADMIN.$_GET['model'].'/');