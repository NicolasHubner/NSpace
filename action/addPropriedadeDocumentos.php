<?php
    include("../lib/Config.php");

    try {

        $objAnuncio                         =  Doctrine_Core::getTable('Anuncio')->find($_POST['anuncio_id']);    
        $objAnuncio->local_proprio          =  isset($_POST['local_proprio'])&&$_POST['local_proprio']==1?$_POST['local_proprio']:0;
        $objAnuncio->save();

        $_POST['dns']                       = Util::getCleanUrl($objAnuncio->titulo);
        if (isset($_FILES['comprovante_endereco']) && $_FILES['comprovante_endereco']['error'] == 0){
        
            $fileType = Util::checkFileType($_FILES['comprovante_endereco']['type']);
            // Verifica se é um tipo de comprovante_endereco permitido
            if ($fileType){
        
                // Gera o nome do comprovante_endereco
                $fileName = $_POST['dns'].'-'.rand(5, 15).$objAnuncio->id;
                    
                // Realiza o upload e gera o nome
                $comprovante_endereco = Util::uploadFile($_FILES['comprovante_endereco']['tmp_name'], PATH_ANUNCIO_DOCUMENTOS, $fileType, $fileName);
                    
                // Verifica se o comprovante_endereco foi gravado
                if ($comprovante_endereco){
                        
                    // Update
                    $objAnuncio->comprovante_endereco = $comprovante_endereco.'.'.$fileType;
                    $objAnuncio->save();
                        
                }
        
            }
        
        }

        if (isset($_FILES['comprovante_identidade']) && $_FILES['comprovante_identidade']['error'] == 0){
        
            $fileType = Util::checkFileType($_FILES['comprovante_identidade']['type']);
            // Verifica se é um tipo de comprovante_identidade permitido
            if ($fileType){
        
                // Gera o nome do comprovante_identidade
                $fileName = $_POST['dns'].'-ide-'.rand(5, 15).$objAnuncio->id;
                    
                // Realiza o upload e gera o nome
                $comprovante_identidade = Util::uploadFile($_FILES['comprovante_identidade']['tmp_name'], PATH_ANUNCIO_DOCUMENTOS, $fileType, $fileName);
                    
                // Verifica se o comprovante_identidade foi gravado
                if ($comprovante_identidade){
                        
                    // Update
                    $objAnuncio->comprovante_identidade = $comprovante_identidade.'.'.$fileType;
                    $objAnuncio->save();
                        
                }
        
            }
        
        }

        $retorno = array('status'=>'1', 'anuncio_id'=>$_POST['anuncio_id']);

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>