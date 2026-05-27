<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
        $valorTotal                              = Util::formata_valor($_POST['valor_total']);
		
		// Insert
		$objPlano						= new Plano();
		$objPlano->nome 				= $_POST['nome'];
		$objPlano->subtitulo 			= $_POST['subtitulo'];
		$objPlano->status 				= $_POST['status'];
		$objPlano->destaque 			= $_POST['destaque'];
		$objPlano->valor 					= (float)$valorTotal;
		$objPlano->save();

		
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