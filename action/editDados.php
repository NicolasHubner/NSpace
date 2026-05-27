<?php
    include("../lib/Config.php");

    try {
        foreach ($_POST as $key => $value) {
            $_POST[$key]        = isset($_POST[$key])&&$_POST[$key]!=''?$_POST[$key]:null;
        }

        $_POST['estado_id']                     = isset($_POST['estado_id'])&&$_POST['estado_id']!=''?$_POST['estado_id']:null;
        $_POST['cidade_id']                     = isset($_POST['cidade_id'])&&$_POST['cidade_id']!=''?$_POST['cidade_id']:null;
        $_POST['dns']                           = Util::getCleanUrl($_POST['nome']);

    	$objCliente                             = Doctrine_Core::getTable('Cliente')->find($_POST['id']);
    	$objCliente->apelido 				    = $_POST['apelido']; 
        $objCliente->telefone                   = $_POST['telefone']; 
        $objCliente->cep                        = $_POST['cep']; 
        $objCliente->logradouro                 = $_POST['logradouro']; 
        $objCliente->numero                     = $_POST['numero']; 
        $objCliente->complemento                = $_POST['complemento']; 
        $objCliente->bairro                     = $_POST['bairro']; 
        $objCliente->estado_id                  = $_POST['estado_id']; 
        $objCliente->cidade_id                  = $_POST['cidade_id']; 
        $objCliente->sobremin                   = $_POST['sobremin']; 
        $objCliente->data_nascimento 			= isset($objCliente->data_nascimento)&&$objCliente->data_nascimento!=''?$objCliente->data_nascimento:$_POST['data_nascimento']; 
    	$objCliente->save();

        $imagem = '';
        if (isset($_FILES['imagem']) && $_FILES['imagem']!=''){
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
                $imagem = 1;
                $fileType = Util::checkImageType($_FILES['imagem']['type']);
                if ($fileType){
                    $fileName = $_POST['dns'].'-'.rand(5, 15).$objCliente->id;

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
        }

        $actionError = null;

        if (isset($_POST['cpf'])&&$_POST['cpf']!='') {
            $validacaoCPF = Doctrine_Core::getTable('Cliente')->findOneByCpf($_POST['cpf']);

            if (isset($validacaoCPF->id)&&$validacaoCPF->id!='') {
                $actionError = 1;
            } else {
                $objCliente->cpf                   = $_POST['cpf']; 
                $objCliente->save();
                
                $actionError = 0;
            }
        }

        if (isset($actionError)&&$actionError==null) {
            if (isset($imagem)&&$imagem==1) {
                $urlIMG = URL_CLIENTE.$objCliente->imagem;
                $retorno = array('status'=>'1', 'imagem'=>$urlIMG);
            } else {
                $retorno = array('status'=>'1');
            }
        } else {
            if ($actionError==1) {
                $retorno = array('status'=>'2', 'mensagem'=>'CPF já cadastrado.');
            } else {
               if (isset($imagem)&&$imagem==1) {
                    $urlIMG = URL_CLIENTE.$objCliente->imagem;
                    $retorno = array('status'=>'1', 'imagem'=>$urlIMG);
                } else {
                    $retorno = array('status'=>'1');
                }
            }
        }

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>