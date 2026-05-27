<?php



defined('_ACTION') or exit('Direct access to the script is not allowed!');



try {



	$objUsuario 				= Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);
	$objUsuario->nome 			= $_POST['nome'];
	$objUsuario->email			= $_POST['email'];
	$objUsuario->nome_exibicao	= $_POST['nome_exibicao'];
	$objUsuario->save();

	

	// Tratamento de retorno

	$_SESSION['return_type'] 	= 'success';

	$_SESSION['return_message']	= 'Executado com sucesso!';



} catch(Exception $e){

	echo $e;

	// Tratamento de retorno

	$_SESSION['return_type'] 	= 'error';

	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';

	

}



// Redirecionamento para a página principal do módulo

header('Location: '.URL_ADMIN);