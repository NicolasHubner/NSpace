<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	

	// Update
	$objEmpresa							= Doctrine_Core::getTable('Empresa')->find(1);
	$objEmpresa->titulo   				= $_POST['titulo'];
	$objEmpresa->descricao 				= $_POST['descricao'];
	$objEmpresa->dns						= Util::getCleanUrl($objEmpresa->titulo);
	
	if (isset($_POST['remover_imagem'])&&$_POST['remover_imagem']==1) {
		@unlink(PATH_EMPRESA.$objEmpresa->imagem);
		$objEmpresa->imagem 				= null;
	}

	$objEmpresa->save();


	if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
		$fileType = Util::checkImageType($_FILES['imagem']['type']);
		if ($fileType){
			$fileName = $objEmpresa->dns.'-'.$objEmpresa->id;

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
				$objEmpresa->imagem = $fileName.'.'.$fileType;
				$objEmpresa->save();
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