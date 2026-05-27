<?php
    include("../lib/Config.php");

    try {

        if (isset($_POST['etapa'])&&$_POST['etapa']==1) {
            function corAleatoria() {
                $hexcolor = dechex(mt_rand(0,16777215));

                while (strlen($hexcolor) < 6) {
                    $hexcolor = $hexcolor."0";
                }
                return $hexcolor;
            }

            foreach ($_POST as $key => $value) {
                $_POST[$key]        = isset($_POST[$key])&&$_POST[$key]!=''?$_POST[$key]:null;
            }

            $_POST['cidade_id']                 = isset($_POST['cidade_id'])&&$_POST['cidade_id']!=''?$_POST['cidade_id']:null;
            $_POST['estado_id']                 = isset($_POST['estado_id'])&&$_POST['estado_id']!=''?$_POST['estado_id']:null;
            $_POST['plano_id']                  = isset($_POST['plano_id'])&&$_POST['plano_id']!=''?$_POST['plano_id']:null;
            $_POST['cliente_id']                = isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?$_POST['cliente_id']:null;
            $valor                              = Util::formata_valor($_POST['valor']);
            $_POST['dns']                       = Util::getCleanUrl($_POST['titulo']);

            $objAnuncio                         = new Anuncio();
            $objAnuncio->data_cadastro          = date('Y-m-d H:i:s');
            $objAnuncio->titulo                 = $_POST['titulo']; 
            $objAnuncio->categoria_id           = $_POST['categoria_id']; 
            $objAnuncio->tipo_cobranca_id       = $_POST['tipo_cobranca_id']; 
            $objAnuncio->espaco                 = $_POST['espaco']; 
            $objAnuncio->limite_pessoas         = $_POST['limite_pessoas']; 
            $objAnuncio->cliente_id             = $_POST['cliente_id']; 
            $objAnuncio->dns                    = $_POST['dns']; 
            $objAnuncio->garagem                = $_POST['garagem']; 
            $objAnuncio->quarto                 = $_POST['quarto']; 
            $objAnuncio->banheiro               = $_POST['banheiro']; 
            $objAnuncio->valor                   = (float)$valor;
            $objAnuncio->status_id              = 1; 
            $objAnuncio->pagamento              = 0; 
            $objAnuncio->termo                  = $_POST['termo']; 
            $objAnuncio->descricao              = $_POST['descricao']; 
            $objAnuncio->periodo_minimo         = $_POST['periodo_minimo']; 
            $objAnuncio->save();

            $objAnuncio->codigo                 = date('Ymd').$objAnuncio->id; 
            $objAnuncio->save();

            include('emails/email_cliente_propriedade.php');
            include('emails/email_nspace_propriedade.php');

            if (isset($_POST['referencia_nome'])&&$_POST['referencia_nome']!='') {
                foreach ($_POST['referencia_nome'] as $key => $value) {
                    if (isset($value)&&$value!='') {
                        if (isset($_POST['referencia_km'][$key])&&$_POST['referencia_km'][$key]!='') {
                            $objAnuncioReferencia                            = new AnuncioReferencia();
                            $objAnuncioReferencia->data_cadastro             = date('Y-m-d H:i:s');
                            $objAnuncioReferencia->nome                      = $value;
                            $objAnuncioReferencia->km                        = $_POST['referencia_km'][$key];
                            $objAnuncioReferencia->anuncio_id                = $objAnuncio->id;
                            $objAnuncioReferencia->background                = '#'.corAleatoria();
                            $objAnuncioReferencia->save();
                        }
                    }
                }
            }
              
            $tasgName = $_POST['tags'];
            if (isset($_POST['tags_id'])&&$_POST['tags_id']!='') {
                if (isset($_POST['tags'])&&$_POST['tags']!='') {
                    $tasgName .= ', ';
                }
                foreach ($_POST['tags_id'] as $key => $value) {
                    $objTags = Doctrine_Core::getTable('Tags')->find($value['id']);
                    $tasgName .= $objTags->nome.', '; 
                }
                $objAnuncio->tags                   = $tasgName; 
                $objAnuncio->save();
            }
      
            if (isset($_POST['opcional_id'])&&$_POST['opcional_id']!='') {
                foreach ($_POST['opcional_id'] as $key => $value) {
                    $objAnuncioOpcional                            = new AnuncioOpcional();
                    $objAnuncioOpcional->data_cadastro             = date('Y-m-d H:i:s');
                    $objAnuncioOpcional->opcional_id               = $value;
                    $objAnuncioOpcional->anuncio_id                = $objAnuncio->id;
                    $objAnuncioOpcional->save();
                }
            }

            // if (isset($_FILES['imagem']) && $_FILES['imagem']!=''){
            //     if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
            //         $fileType = Util::checkImageType($_FILES['imagem']['type']);
            //         if ($fileType){
            //             $fileName = $_POST['dns'].'-'.$objAnuncio->id;

            //             $imgPath = PATH_ANUNCIO.$fileName.'.'.$fileType;

            //             // Grava o arquivo
            //             $img = WideImage::load($_FILES['imagem']['tmp_name']);
            //             // $cropped = $img->crop($_POST['x'], $_POST['y'], 100, 100);
            //             $cropped = $img->crop($_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']);
            //             if ($fileType == 'jpg'){
            //                 $cropped->saveToFile($imgPath, 100);
            //             } else {
            //                 $cropped->saveToFile($imgPath);
            //             }

            //             if ($fileName){
            //                 $objAnuncio->imagem = $fileName.'.'.$fileType;
            //                 $objAnuncio->save();
            //             }
            //         }
            //     }
            // }

            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
        
                $fileType = Util::checkFileType($_FILES['imagem']['type']);


                    // Verifica se é um tipo de arquivo permitido
                if ($fileType){

                        // Gera o nome do arquivo
                    $fileName = $_POST['dns'].'-'.$objAnuncio->id;


                        // Realiza o upload e gera o nome
                    $imagem = Util::uploadFile($_FILES['imagem']['tmp_name'], PATH_ANUNCIO, $fileType, $fileName);

                        // Verifica se o arquivo foi gravado
                    if ($imagem){

                            // Update
                        $objAnuncio->imagem = $imagem.'.'.$fileType;
                        $objAnuncio->save();

                    }

                }

                
                
            }
        
            
            $retorno = array('status'=>'1', 'anuncio_id'=>$objAnuncio->id);

        } else if (isset($_POST['etapa'])&&$_POST['etapa']==2) {

            $objAnuncio                         = Doctrine_Core::getTable('Anuncio')->find($_POST['anuncio_id']);
            $objAnuncio->cep                    = $_POST['cep'];
            $objAnuncio->logradouro             = $_POST['logradouro'];
            $objAnuncio->numero                 = $_POST['numero'];
            $objAnuncio->complemento            = $_POST['complemento'];
            $objAnuncio->bairro                 = $_POST['bairro'];
            $objAnuncio->estado_id              = $_POST['estado_id'];
            $objAnuncio->cidade_id              = $_POST['cidade_id'];
            $objAnuncio->save();

            $retorno = array('status'=>'1', 'anuncio_id'=>$objAnuncio->id);


        } else if (isset($_POST['etapa'])&&$_POST['etapa']==3) {

            $retorno = array('status'=>'1', 'anuncio_id'=>$objAnuncio->id);


        } else if (isset($_POST['etapa'])&&$_POST['etapa']==4) {

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

            $retorno = array('status'=>'1', 'anuncio_id'=>$objAnuncio->id);


        }



    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>