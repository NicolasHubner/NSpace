<?php
	defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {

	foreach ($_POST as $key => $value) {
		$_POST[$key] 		= isset($_POST[$key])&&$_POST[$key]!=''?$_POST[$key]:null;
	}

	$_POST['estado_id'] 				= isset($_POST['estado_id'])&&$_POST['estado_id']!=''?$_POST['estado_id']:null;
	$_POST['cidade_id'] 				= isset($_POST['cidade_id'])&&$_POST['cidade_id']!=''?$_POST['cidade_id']:null;
	$_POST['usuario_grupo_id'] 			= isset($_POST['usuario_grupo_id'])&&$_POST['usuario_grupo_id']!=''?$_POST['usuario_grupo_id']:null;

	$objCliente 						= new Cliente();
	$objCliente->data_cadastro			= date('Y-m-d H:i:s');
	$objCliente->nome					= $_POST['nome'];
	$objCliente->email					= $_POST['email'];
	$objCliente->cpf					= $_POST['cpf'];
	$objCliente->telefone				= $_POST['telefone'];
	$objCliente->cep					= $_POST['cep'];
	$objCliente->logradouro				= $_POST['logradouro'];
	$objCliente->numero					= $_POST['numero'];
	$objCliente->complemento			= $_POST['complemento'];
	$objCliente->bairro					= $_POST['bairro'];
	$objCliente->estado_id				= $_POST['estado_id'];
	$objCliente->cidade_id				= $_POST['cidade_id'];
	$objCliente->status					= $_POST['status'];
	$objCliente->save();

	if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
		$fileType = Util::checkImageType($_FILES['imagem']['type']);
		if ($fileType){
			$fileName = rand(0, 99999).'-ID-'.$objCliente->id;

			$imgPath = PATH_CLIENTE.$fileName.'.'.$fileType;
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
				$objCliente->imagem = $fileName.'.'.$fileType;
				$objCliente->save();
			}
		}
	}
	
	$_SESSION['return_type']	= 'success';
	$_SESSION['return_message'] = 'Executado com sucesso.';

} catch(Exception $e){
	echo  $e;

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente.';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');