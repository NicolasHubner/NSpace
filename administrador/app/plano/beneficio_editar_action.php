<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];

	// Update
    $objBeneficio			    = Doctrine_Core::getTable('Beneficio')->find($_POST['id']);
    $objBeneficio->nome			= $_POST['nome'];
    $objBeneficio->save();

	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso.';
	
} catch(Exception $e){
	echo $e;
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$_POST['plano_id'].'/');