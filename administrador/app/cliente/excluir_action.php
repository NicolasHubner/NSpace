<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Load
	$objCliente = Doctrine_Core::getTable('Cliente')->find($_GET['id']);
	
	// Verifica se o usuário possui permissão para excluir o registro
	if ($_SESSION['sess_usuario_grupo_id'] != 2 || ($_SESSION['sess_usuario_grupo_id'] == 2 && $objCliente->usuario_id == $_SESSION['sess_usuario_id'])){
		
		// Seleciona a imagem
		$objCliente->delete();
	
		
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';
		
	} else {
		
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'warning';
		$_SESSION['return_message']	= 'Você não possui permissão para excluir esse registro.';
		
	}

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');