<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Verifica se existe outro registro com os dados informados
	$retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')
					->where('email LIKE ?', $_POST['email'])->execute();
	
	if ($retUsuario->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
	
		$objUsuario						= new Usuario();
		$objUsuario->nome 				= $_POST['nome'];
		$objUsuario->nome_exibicao		= $_POST['nome'];
		$objUsuario->email 				= $_POST['email'];
		$objUsuario->senha				= md5($_POST['senha']);
		$objUsuario->status				= $_POST['status'];
		$objUsuario->usuario_grupo_id	= $_POST['usuario_grupo_id'];
		$objUsuario->save();
	
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';
		
	}

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');