<?php

/**
 * Autenticação de Usuário
 */

require('../lib/Config.php');

try {

	// Checa se o usuário está logado
	if (Util::checkLoginAdmin()){
		header('Location: '.URL_ADMIN);
		exit;
	}
	
	// Verifica dados de login
	if (isset($_POST['email']) && isset($_POST['senha'])){
		
		// Realiza a autenticação
		$res = Doctrine_Core::getTable('Usuario')->findOneByEmailAndSenhaAndStatus($_POST['email'],md5($_POST['senha']),1);
		
		// Verifica se o grupo está ativo autenticação
		if ($res && $res->UsuarioGrupo->status){
			
			// Seta seção
			$_SESSION['sess_usuario_id']			= $res->id;
			$_SESSION['sess_usuario_grupo_id']		= $res->usuario_grupo_id;
			// $_SESSION['sess_usuario_food_truck_id']	= $res->food_truck_id;
			
			// Seta seções de retorno
			$_SESSION['return_type']	= false;
			$_SESSION['return_message']	= false;
			
			// Encaminhamento para a página principal
			header('Location: '.URL_ADMIN);
			
		} else {
			
			// Tratamento de retorno
			$_SESSION['return_type']	= 'warning';
			$_SESSION['return_message'] = 'Acesso negado!';
			include_once(PATH_ADMIN.'login.php');
			
		}
		
	} else {
		
		// Tratamento de retorno
		$_SESSION['return_type']	= 'warning';
		$_SESSION['return_message'] = 'Preencha com o email e a senha!';
		include_once(PATH_ADMIN.'login.php');
		
	}
	
} catch (Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type']	= 'warning';
	$_SESSION['return_message'] = 'Ocorreu um erro, tente novamente!';
	include_once(PATH_ADMIN.'login.php');
	
}