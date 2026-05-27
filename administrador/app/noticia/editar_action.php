<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {

		
	$_POST['dns'] 					= Util::getCleanUrl($_POST['titulo']);
	$_POST['titulo']				= isset($_POST['titulo'])&&$_POST['titulo']!=''?$_POST['titulo']:null;
	$_POST['resumo']				= isset($_POST['resumo'])&&$_POST['resumo']!=''?$_POST['resumo']:null;
	$_POST['descricao']				= isset($_POST['descricao'])&&$_POST['descricao']!=''?$_POST['descricao']:null;
					
	// Update
	$objNoticia								= Doctrine_Core::getTable('Noticia')->find($_POST['id']);
	$objNoticia->titulo 					= $_POST['titulo'];
	$objNoticia->resumo 					= $_POST['resumo'];
	$objNoticia->dns 						= $_POST['dns'];
	$objNoticia->descricao 					= $_POST['descricao'];
	$objNoticia->status 					= $_POST['status'];
	$objNoticia->destaque 					= $_POST['destaque'];
	$objNoticia->noticia_categoria_id 		= $_POST['noticia_categoria_id'];
	$objNoticia->save();

	if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
		$fileType = Util::checkImageType($_FILES['imagem']['type']);
		if ($fileType){
			$fileName = $objNoticia->dns.'-'.$objNoticia->id;

			$imgPath = PATH_NOTICIA.$fileName.'.'.$fileType;
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
				$objNoticia->imagem = $fileName.'.'.$fileType;
				$objNoticia->save();
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