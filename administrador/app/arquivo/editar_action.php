<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['dns'] 			= Util::getCleanUrl($_POST['nome']);

	// Update
	$objArquivo					= Doctrine_Core::getTable('Arquivo')->find($_POST['id']);
	$objArquivo->nome 			= $_POST['nome'];
	$objArquivo->save();


	// Verifica se a IMAGEM PRINCIPAL foi enviada
	if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0){
	
		$fileType = Util::checkFileType($_FILES['arquivo']['type']);


		// Verifica se é um tipo de arquivo permitido
		if ($fileType){
			$nomearquivo = explode(".", $objArquivo->arquivo);
			// Gera o nome do arquivo
			$fileName = $nomearquivo[0];
				

			// Realiza o upload e gera o nome
			$arquivo = Util::uploadFile($_FILES['arquivo']['tmp_name'], PATH_ARQUIVO, $fileType, $fileName);
				
			// Verifica se o arquivo foi gravado
			if ($arquivo){
					
				// Update
				$objArquivo->arquivo = $arquivo.'.'.$fileType;
				$objArquivo->save();
					
			}
	
		}
	
	}


	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	
	

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');