<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	$_POST['dns'] 					= Util::getCleanUrl($_POST['titulo']);
	$_POST['titulo']				= isset($_POST['titulo'])&&$_POST['titulo']!=''?$_POST['titulo']:null;
	$_POST['resumo']				= isset($_POST['resumo'])&&$_POST['resumo']!=''?$_POST['resumo']:null;
	$_POST['descricao']				= isset($_POST['descricao'])&&$_POST['descricao']!=''?$_POST['descricao']:null;

	// Insert
	$objBlog							= new Blog();
	$objBlog->data_cadastro			= date('Y-m-d H:i:s');
	$objBlog->titulo 				= $_POST['titulo'];
	$objBlog->resumo 				= $_POST['resumo'];
	$objBlog->dns 					= $_POST['dns'];
	$objBlog->descricao 				= $_POST['descricao'];
	$objBlog->status 				= $_POST['status'];
	$objBlog->destaque 				= $_POST['destaque'];
	$objBlog->save();

	if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
		$fileType = Util::checkImageType($_FILES['imagem']['type']);
		if ($fileType){
			$fileName = $_POST['dns'].'-'.$objBlog->id;

			$imgPath = PATH_BLOG.$fileName.'.'.$fileType;
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
				$objBlog->imagem = $fileName.'.'.$fileType;
				$objBlog->save();
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