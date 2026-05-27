<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	

	// Update
	$objSobreNos							= Doctrine_Core::getTable('SobreNos')->find(1);
	$objSobreNos->titulo   				= $_POST['titulo'];
	$objSobreNos->descricao 				= $_POST['descricao'];
	$objSobreNos->dns						= Util::getCleanUrl($objSobreNos->titulo);
	
	if (isset($_POST['remover_imagem'])&&$_POST['remover_imagem']==1) {
		@unlink(PATH_EMPRESA.$objSobreNos->imagem);
		$objSobreNos->imagem 				= null;
	}

	$objSobreNos->save();


	if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
		$fileType = Util::checkImageType($_FILES['imagem']['type']);
		if ($fileType){
			$fileName = $objSobreNos->dns.'-'.$objSobreNos->id;

			$imgPath = PATH_EMPRESA.$fileName.'.'.$fileType;
			// echo URL_CURSO.$fileName.'.'.$fileType;

			// Grava o arquivo
			$img = WideImage::load($_FILES['imagem']['tmp_name']);
			// $cropped = $img->crop($_POST['x'], $_POST['y'], 100, 100);
			$cropped = $img->crop($_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']);
			if ($fileType == 'jpg'){
				$cropped->saveToFile($imgPath, 100);
			} else {
				$cropped->saveToFile($imgPath);
			}

			if ($fileName){
				$objSobreNos->imagem = $fileName.'.'.$fileType;
				$objSobreNos->save();
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