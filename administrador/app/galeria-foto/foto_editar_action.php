<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];
	
	// Tratamento de dados
	$_POST['nome']			= isset($_POST['nome'])&&$_POST['nome']!=''?$_POST['nome']:null;
	$_POST['link']			= isset($_POST['link'])&&$_POST['link']!=''?$_POST['link']:null;
	$_POST['nome']		= isset($_POST['nome'])&&$_POST['nome']!=''?$_POST['nome']:null;
	$_POST['resumo']		= isset($_POST['resumo'])&&$_POST['resumo']!=''?$_POST['resumo']:null;
	
	// Carrega os dados
	$objGaleriaFoto					= Doctrine_Core::getTable('GaleriaFoto')->find($_POST['id']);
	
	// Update
	$objGaleriaFoto->nome				= $_POST['nome'];
	$objGaleriaFoto->ordem			= $_POST['ordem'];
	$objGaleriaFoto->galeria_id		= $_POST['galeria_id'];
	$objGaleriaFoto->save();
	
	
	// Realiza o upload da IMAGEM PRINCIPAL caso tenha sido enviada
	if (isset($_FILES['imagem_principal']) && $_FILES['imagem_principal']['error'] == 0 ){
			
		// Pega o arquivo anterior
		$imagem_principalPrev = $objGaleriaFoto->imagem;
			
		// Pega o Tipo do Arquivo
		$fileType = Util::checkImageType($_FILES['imagem_principal']['type']);
			
		// Verifica se é um tipo de arquivo permitido
		if ($fileType){
				
			// Gera o nome do arquivo
			$fileName = $_POST['nome'].'-p-'.$objGaleriaFoto->id;
	
			// Realiza o upload do arquivo (substitui o atual)
			$imagem_principal = Util::uploadImage($_FILES['imagem_principal']['tmp_name'], PATH_GALERIA, $fileType, $fileName, 800, 800);
				
			// Verifica se o arquivo foi enviado
			if ($imagem_principal){
					
				// Grava a imagem principal no registro
				$objGaleriaFoto->imagem = $imagem_principal.'.'.$fileType;
				$objGaleriaFoto->save();
	
				// Remove o arquivo anterior caso o DNS tenho alterado
				if (isset($imagem_principalPrev) && $imagem_principalPrev != '' && $imagem_principalPrev != ($fileName.'.'.$fileType)){
					@unlink(PATH_GALERIA.$imagem_principalPrev);
				}
	
			}
	
		}
	
	} 
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso.';
	
		
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$_POST['galeria_id'].'/');