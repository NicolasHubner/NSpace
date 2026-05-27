<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {

		
	$_POST['dns'] 					= Util::getCleanUrl($_POST['nome']);
					
	// Update
	$objEquipe							= Doctrine_Core::getTable('Equipe')->find($_POST['id']);
	$objEquipe->nome 					= $_POST['nome'];
	$objEquipe->cargo 					= $_POST['cargo'];
	$objEquipe->dns 					= $_POST['dns'];
	$objEquipe->resumo 					= $_POST['resumo'];
	$objEquipe->facebook 				= $_POST['facebook'];
	$objEquipe->instagram 				= $_POST['instagram'];
	$objEquipe->linkedin 				= $_POST['linkedin'];
	$objEquipe->email 					= $_POST['email'];
	$objEquipe->telefone 				= $_POST['telefone'];
	$objEquipe->whatsapp 				= $_POST['whatsapp'];
	$objEquipe->save();

	if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
		$fileType = Util::checkImageType($_FILES['imagem']['type']);
		if ($fileType){
			$fileName = $_POST['dns'].'-'.$objEquipe->id;

			$imgPath = PATH_EQUIPE.$fileName.'.'.$fileType;
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
				$objEquipe->imagem = $fileName.'.'.$fileType;
				$objEquipe->save();
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