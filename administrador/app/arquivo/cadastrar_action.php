<?php
defined('_ACTION') or exit('Direct access to the script is not allowed!');
try {
	
	// Tratamento de dados
	$usuario_id 			= $_SESSION['sess_usuario_id']!=''?$_SESSION['sess_usuario_id']:null;
	$_POST['dns'] 			= Util::getCleanUrl($_POST['nome']);
	
	// Insert
	$objArquivo					= new Arquivo();
	$objArquivo->nome 			= $_POST['nome'];
	$objArquivo->data_cadastro 	= date('Y-m-d H:i:s');
	$objArquivo->save();
	// Verifica se a IMAGEM PRINCIPAL foi enviada
	if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0){
	
		$fileType = Util::checkFileType($_FILES['arquivo']['type']);
		// Verifica se é um tipo de arquivo permitido
		if ($fileType){
	
			// Gera o nome do arquivo
			$fileName = $_POST['dns'].'-'.rand(0, 99999);
				
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
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}
// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');