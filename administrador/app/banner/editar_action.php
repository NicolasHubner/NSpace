<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	$_POST['dns']	= Util::getCleanUrl($_POST['nome']);
	
	// Verifica se existe outro registro com os dados informados
	$retBanner =	Doctrine_Query::create()->select()->from('Banner')
				->where('dns LIKE "'.$_POST['dns'].'" AND id <> "'.$_POST['id'].'"')
				->execute();
	
	if ($retBanner->count() > 0){

			// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
	
		// Update
		$objBanner							= Doctrine_Core::getTable('Banner')->find($_POST['id']);
		$objBanner->nome 					= $_POST['nome'];
		$objBanner->titulo 					= $_POST['titulo'];
		// $objBanner->subtitulo				= $_POST['subtitulo'];
		$objBanner->texto 					= $_POST['texto'];
		$objBanner->ordem 					= $_POST['ordem'];
		$objBanner->dns						= $_POST['dns'];
		$objBanner->link					= $_POST['link'];
		$objBanner->save();
	


		if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
			$fileType = Util::checkImageType($_FILES['imagem']['type']);
			if ($fileType){
				$fileName = $_POST['dns'].'-'.$objBanner->id;

				$imgPath = PATH_BANNER.$fileName.'.'.$fileType;
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
					$objBanner->imagem = $fileName.'.'.$fileType;
					$objBanner->save();
				}
			}
		}

		if (isset($_FILES['icone_img']) && $_FILES['icone_img']['error'] == 0){
	
			$fileType = Util::checkFileType($_FILES['icone_img']['type']);
			// Verifica se é um tipo de icone_img permitido
			if ($fileType){
		
				// Gera o nome do icone_img
				$fileName = $_POST['dns'].'-icon-'.$objBanner->id;
					
				// Realiza o upload e gera o nome
				$icone_img = Util::uploadFile($_FILES['icone_img']['tmp_name'], PATH_BANNER, $fileType, $fileName);
					
				// Verifica se o icone_img foi gravado
				if ($icone_img){
						
					// Update
					$objBanner->icone_img = $icone_img.'.'.$fileType;
					$objBanner->save();
						
				}
		
			}
		
		}

		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';
		
	}

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');