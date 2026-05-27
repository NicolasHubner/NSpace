<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {

	foreach ($_POST as $key => $value) {
		$_POST[$key] 		= isset($_POST[$key])&&$_POST[$key]!=''?$_POST[$key]:null;
	}

	$_POST['estado_id'] 				= isset($_POST['estado_id'])&&$_POST['estado_id']!=''?$_POST['estado_id']:null;
	$_POST['cidade_id'] 				= isset($_POST['cidade_id'])&&$_POST['cidade_id']!=''?$_POST['cidade_id']:null;
	$_POST['dns'] 						= Util::getCleanUrl($_POST['nome']);
		
	// Load
	$objUnidade 						= Doctrine_Core::getTable('Unidade')->find($_POST['id']);
	$objUnidade->data_cadastro			= date('Y-m-d H:i:s');
	$objUnidade->nome					= $_POST['nome'];
	$objUnidade->nome_responsavel		= $_POST['nome_responsavel'];
	$objUnidade->email					= $_POST['email'];
	$objUnidade->telefone				= $_POST['telefone'];
	$objUnidade->whatsapp				= $_POST['whatsapp'];
	$objUnidade->cep					= $_POST['cep'];
	$objUnidade->logradouro				= $_POST['logradouro'];
	$objUnidade->numero					= $_POST['numero'];
	$objUnidade->complemento			= $_POST['complemento'];
	$objUnidade->bairro					= $_POST['bairro'];
	$objUnidade->estado_id				= $_POST['estado_id'];
	$objUnidade->cidade_id				= $_POST['cidade_id'];
	$objUnidade->dns					= $_POST['dns'];
	$objUnidade->save();

	if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
		$fileType = Util::checkImageType($_FILES['imagem']['type']);
		if ($fileType){
			$fileName = $objUnidade->Estado->sigla.'-'.$objUnidade->id;

			$imgPath = PATH_UNIDADE.$fileName.'.'.$fileType;
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
				$objUnidade->imagem = $fileName.'.'.$fileType;
				$objUnidade->save();
			}
		}
	}

	$objUnidadeMatriz 					= Doctrine_Core::getTable('Unidade')->findOneByTipo('Matriz');


	if (isset($objUnidadeMatriz->tipo)&&$objUnidadeMatriz->tipo!=$objUnidade->tipo) {
		if (isset($objUnidadeMatriz->tipo)&&$objUnidadeMatriz->tipo==$_POST['tipo']) {
			$_SESSION['return_type']	= 'danger';
			$_SESSION['return_message'] = 'Não pode ter mais de uma Matriz!';
		} else {
			$objUnidade->tipo					= $_POST['tipo'];
			$objUnidade->save();

			// Tratamento de retorno
			$_SESSION['return_type']	= 'success';
			$_SESSION['return_message'] = 'Executado com sucesso.';
		}
	} else {
		// Tratamento de retorno
		$_SESSION['return_type']	= 'success';
		$_SESSION['return_message'] = 'Executado com sucesso.';
	}


	

} catch(Exception $e){

	echo $e;
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente.';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');