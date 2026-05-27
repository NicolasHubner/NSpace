<?php
    include("../lib/Config.php");

    try {

    	$objCliente                             = Doctrine_Core::getTable('Cliente')->find($_POST['id']);
    	$objCliente->data_nascimento 			= $_POST['data_nascimento'];
    	$objCliente->sexo_id 					= $_POST['sexo_id'];
    	$objCliente->cep						= $_POST['cep'];
		$objCliente->logradouro					= $_POST['logradouro'];
		$objCliente->numero						= $_POST['numero'];
		$objCliente->complemento				= $_POST['complemento'];
		$objCliente->bairro						= $_POST['bairro'];
		$objCliente->estado_id					= $_POST['estado_id'];
		$objCliente->cidade_id					= $_POST['cidade_id'];
		$objCliente->verificado					= 1;
    	$objCliente->save();

    	if (isset($objCliente->tipo_pessoa_id)&&$objCliente->tipo_pessoa_id==1) {
    		if (isset($objCliente->cpf)&&$objCliente->cpf!='') {
				$objCliente->cpf					= $_POST['cpf'];
    			$objCliente->save();
    		}
    	} else if ($objCliente->tipo_pessoa_id == 2) {
			if (isset($objCliente->cnpj)&&$objCliente->cnpj!='') {
				$objCliente->cnpj					= $_POST['cnpj'];
    			$objCliente->save();
    		}
    	}

    	$objClienteMigracao                             = new ClienteMigracao();
    	$objClienteMigracao->data_cadastro				= date('Y-m-d H:i:s');
    	$objClienteMigracao->termo 						= $_POST['termo'];
    	$objClienteMigracao->cliente_id 				= $objCliente->id;
    	$objClienteMigracao->tipo_cliente_id			= $_POST['tipo_cliente_id'];
    	$objClienteMigracao->status 					= 1;
    	$objClienteMigracao->save();

    	$objClienteMigracao->identificador 				= date('YmdHi').$objClienteMigracao->id;
    	$objClienteMigracao->save();   	

        $_POST['dns']                           = Util::getCleanUrl($objCliente->nome);

    	// Verifica se a IMAGEM PRINCIPAL foi enviada
		if (isset($_FILES['comprovante_identidade']) && $_FILES['comprovante_identidade']['error'] == 0){
		
			$fileType = Util::checkFileType($_FILES['comprovante_identidade']['type']);
			// Verifica se é um tipo de comprovante_identidade permitido
			if ($fileType){
		
				// Gera o nome do comprovante_identidade
				$fileName = $_POST['dns'].'-'.rand(5, 15).$objClienteMigracao->id;
					
				// Realiza o upload e gera o nome
				$comprovante_identidade = Util::uploadFile($_FILES['comprovante_identidade']['tmp_name'], PATH_CLIENTE, $fileType, $fileName);
					
				// Verifica se o comprovante_identidade foi gravado
				if ($comprovante_identidade){
						
					// Update
					$objClienteMigracao->comprovante_identidade = $comprovante_identidade.'.'.$fileType;
					$objClienteMigracao->save();
						
				}
		
			}
		
		}

		// Verifica se a IMAGEM PRINCIPAL foi enviada
		if (isset($_FILES['comprovante_identidade']) && $_FILES['comprovante_identidade']['error'] == 0){
		
			$fileType = Util::checkFileType($_FILES['comprovante_identidade']['type']);
			// Verifica se é um tipo de comprovante_identidade permitido
			if ($fileType){
		
				// Gera o nome do comprovante_identidade
				$fileName = $_POST['dns'].'-'.rand(5, 15).$objCliente->id;
					
				// Realiza o upload e gera o nome
				$comprovante_identidade = Util::uploadFile($_FILES['comprovante_identidade']['tmp_name'], PATH_CLIENTE, $fileType, $fileName);
					
				// Verifica se o comprovante_identidade foi gravado
				if ($comprovante_identidade){
						
					// Update
					$objCliente->identidade = $comprovante_identidade.'.'.$fileType;
					$objCliente->save();
						
				}
		
			}
		
		}

		// Verifica se a IMAGEM PRINCIPAL foi enviada
		if (isset($_FILES['comprovante_endereco']) && $_FILES['comprovante_endereco']['error'] == 0){
		
			$fileType = Util::checkFileType($_FILES['comprovante_endereco']['type']);
			// Verifica se é um tipo de comprovante_endereco permitido
			if ($fileType){
		
				// Gera o nome do comprovante_endereco
				$fileName = $_POST['dns'].'-'.rand(5, 15).$objClienteMigracao->id;
					
				// Realiza o upload e gera o nome
				$comprovante_endereco = Util::uploadFile($_FILES['comprovante_endereco']['tmp_name'], PATH_CLIENTE, $fileType, $fileName);
					
				// Verifica se o comprovante_endereco foi gravado
				if ($comprovante_endereco){
						
					// Update
					$objClienteMigracao->comprovante_endereco = $comprovante_endereco.'.'.$fileType;
					$objClienteMigracao->save();
						
				}
		
			}
		
		}


        $retorno = array('status'=>'1');

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>