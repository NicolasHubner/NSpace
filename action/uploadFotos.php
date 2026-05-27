<?php
    include("../lib/Config.php");

    try {

        $objAnuncio                         = Doctrine_Core::getTable('Anuncio')->find($_POST['anuncio_id']);
        $_POST['dns']                       = Util::getCleanUrl($objAnuncio->titulo);

    	$objAnuncioFoto                         = new AnuncioFoto();
        $objAnuncioFoto->data_cadastro          = date('Y-m-d H:i:s');
        $objAnuncioFoto->anuncio_id          	= $_POST['anuncio_id'];
        $objAnuncioFoto->save();
        
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
        
            $fileType = Util::checkFileType($_FILES['imagem']['type']);
            // Verifica se é um tipo de imagem permitido
            if ($fileType){
        
                // Gera o nome do imagem
                $fileName = $_POST['dns'].'-'.rand(5, 15).$objAnuncioFoto->id;
                    
                // Realiza o upload e gera o nome
                $imagem = Util::uploadFile($_FILES['imagem']['tmp_name'], PATH_ANUNCIO, $fileType, $fileName);
                    
                // Verifica se o imagem foi gravado
                if ($imagem){
                        
                    // Update
                    $objAnuncioFoto->imagem = $imagem.'.'.$fileType;
                    $objAnuncioFoto->save();
                        
                }
        
            }
        
        }

        $retorno = array('status'=>'1');

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>