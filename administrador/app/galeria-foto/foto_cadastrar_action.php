<?php

ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
ini_set('memory_limit', '-1');

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {

	$_POST['nome']		= isset($_POST['nome'])&&$_POST['nome']!=''?$_POST['nome']:null;
	$_POST['link']		= isset($_POST['link'])&&$_POST['link']!=''?$_POST['link']:null;
	$_POST['ordem']		= isset($_POST['ordem'])&&$_POST['ordem']!=''?$_POST['ordem']:0;
	$_POST['titulo']		= isset($_POST['titulo'])&&$_POST['titulo']!=''?$_POST['titulo']:null;
	$_POST['resumo']		= isset($_POST['resumo'])&&$_POST['resumo']!=''?$_POST['resumo']:null;
	$_POST['nome'] = rand(0, 99999999999999);
	$_POST['dns'] 					= Util::getCleanUrl($_POST['nome']);
	
	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];
		

	echo "<pre>";
	print_r($_FILES);
	echo "</pre>";

	// Realiza o upload da IMAGEM PRINCIPAL caso tenha sido enviada
	if (isset($_FILES['file']) && $_FILES['file']['error'] == 0 ){
		echo "entrou";
								
		// Pega o Tipo do Arquivo
		$fileType = Util::checkImageType($_FILES['file']['type']);
			
		// Verifica se é um tipo de arquivo permitido
		if ($fileType){
			
			echo "abriu";
				
			// Insert
			$objGaleriaFoto					= new GaleriaFoto();
			$objGaleriaFoto->nome			= $_POST['nome'];
			$objGaleriaFoto->ordem			= 1;
			$objGaleriaFoto->galeria_id		= $_SESSION['sess_galeria_id'];
			$objGaleriaFoto->save();

			echo "salvou";

			// Gera o nome do arquivo
			$fileName = $_POST['dns'].'-p-'.$objGaleriaFoto->id;
	
			// Realiza o upload do arquivo (substitui o atual)
			echo $file = Util::uploadImage($_FILES['file']['tmp_name'], PATH_GALERIA, $fileType, $fileName, 800, 800);
				
			// Verifica se o arquivo foi enviado
			if ($file){
					
				echo "enviou";

				// Grava a imagem principal no registro
				$objGaleriaFoto->imagem = $file.'.'.$fileType;
				$objGaleriaFoto->save();
	
			
	
			}
	
		}
	
	}
	
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso.';

	
} catch(Exception $e){
	
	// Remove o contato em caso de erro
	if (!is_null($objGaleriaFoto->id))
		$objGaleriaFoto->delete();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente.'.$e;
	
}

// Redirecionamento para a página principal do módulo
// header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$_POST['galeria_id'].'/');