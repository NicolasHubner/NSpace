<?php

require_once('../../../lib/Config.php');


try {
	if (isset($_POST['usuario_permissao_id'])&&$_POST['usuario_permissao_id']!='') {
		$retModuloPermissao = Doctrine_Core::getTable('ModuloPermissao')->findAll();
		$retModuloPermissao->delete();
       

		foreach ($_POST['usuario_permissao_id'] as $key => $value) {
			$objModuloPermissao                             = new ModuloPermissao();
            $objModuloPermissao->usuario_permissao_id       = $value;
            $objModuloPermissao->save();
		}
	}

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	


} catch(Exception $e){

	echo $e;
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.'modulo-permissao/');