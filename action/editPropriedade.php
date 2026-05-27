<?php
    include("../lib/Config.php");

     function corAleatoria()
      {
          $hexcolor = dechex(mt_rand(0,16777215));

          while (strlen($hexcolor) < 6) {
              $hexcolor = $hexcolor."0";
          }
          return $hexcolor;
      }

    try {

        // Com esse trecho validamos todas as entradas de campos que vem do formulário, utilizando essa forma o risco de erros diminui em 90%
        foreach ($_POST as $key => $value) {
            $_POST[$key]        = isset($_POST[$key])&&$_POST[$key]!=''?$_POST[$key]:null;
        }

        $_POST['cidade_id']                 = isset($_POST['cidade_id'])&&$_POST['cidade_id']!=''?$_POST['cidade_id']:null;
        $_POST['estado_id']                 = isset($_POST['estado_id'])&&$_POST['estado_id']!=''?$_POST['estado_id']:null;
        $_POST['cliente_id']                = isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?$_POST['cliente_id']:null;
        $valor                              = Util::formata_valor($_POST['valor']);
        $_POST['dns']                       = Util::getCleanUrl($_POST['titulo']);

        $objAnuncio                         = Doctrine_Core::getTable('Anuncio')->find($_POST['anuncio_id']);
        $objAnuncio->titulo                 = $_POST['titulo']; 
        $objAnuncio->categoria_id           = $_POST['categoria_id']; 
        $objAnuncio->tipo_cobranca_id       = $_POST['tipo_cobranca_id']; 
        $objAnuncio->espaco                 = $_POST['espaco']; 
        $objAnuncio->limite_pessoas         = $_POST['limite_pessoas']; 
        $objAnuncio->cep                    = $_POST['cep']; 
        $objAnuncio->logradouro             = $_POST['logradouro']; 
        $objAnuncio->numero                 = $_POST['numero']; 
        $objAnuncio->complemento            = $_POST['complemento']; 
        $objAnuncio->bairro                 = $_POST['bairro']; 
        $objAnuncio->estado_id              = $_POST['estado_id']; 
        $objAnuncio->cidade_id              = $_POST['cidade_id']; 
        $objAnuncio->cliente_id             = $_POST['cliente_id']; 
        $objAnuncio->dns                    = $_POST['dns']; 
        $objAnuncio->garagem                = $_POST['garagem']; 
        $objAnuncio->quarto                 = $_POST['quarto']; 
        $objAnuncio->banheiro               = $_POST['banheiro']; 
        $objAnuncio->valor                  = (float)$valor;
        $objAnuncio->termo                  = $_POST['termo']!=''?$_POST['termo']:0; 
        $objAnuncio->descricao              = $_POST['descricao']; 
        $objAnuncio->periodo_minimo         = $_POST['periodo_minimo']; 
        $objAnuncio->save();

        // Adicionamos todos os pontos de referencia perto do espaço
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

        # Removemos as fotos de anúncios conforme selecionados 
        if (isset($_POST['remover_imagem'])&&$_POST['remover_imagem']!='') {
            foreach ($_POST['remover_imagem'] as $key => $value) {
                $objAnuncioFotoDel               = Doctrine_Core::getTable('AnuncioFoto')->find($value);
                $objAnuncioFotoDel->delete();
            }
        }

        # Removemos os pontos de referencia conforme selecionados para remoção
        if (isset($_POST['remover_iten'])&&$_POST['remover_iten']!='') {
            foreach ($_POST['remover_iten'] as $key => $value) {
                $objAnuncioReferenciaDel               = Doctrine_Core::getTable('AnuncioReferencia')->find($value);
                $objAnuncioReferenciaDel->delete();
            }
        }

        $tasgName = $_POST['tags'];
        if (isset($_POST['tags_id'])&&$_POST['tags_id']!='') {
            foreach ($_POST['tags_id'] as $key => $value) {
                $objTags = Doctrine_Core::getTable('Tags')->find($value['id']);
                $tasgName .= $objTags->nome.', '; 
            }
            $objAnuncio->tags                   = $tasgName; 
            $objAnuncio->save();
        }

        // Nesse bloco adicionamos as comodidades(opcionais) da propriedade
        if (isset($_POST['opcional_id'])&&$_POST['opcional_id']!='') {
            $where = 'anuncio_id = '.$objAnuncio->id;
            $retAnuncioOpcionalDel                 = Doctrine_Query::create()->select()->from('AnuncioOpcional')->where($where)->execute();
            if ($retAnuncioOpcionalDel->count()>0) {
                foreach ($retAnuncioOpcionalDel as $objAnuncioOpcionalDel) {
                    $objAnuncioOpcionalDel->delete();
                }
            }

            foreach ($_POST['opcional_id'] as $key => $value) {
                $objAnuncioOpcional                            = new AnuncioOpcional();
                $objAnuncioOpcional->data_cadastro             = date('Y-m-d H:i:s');
                $objAnuncioOpcional->opcional_id               = $value;
                $objAnuncioOpcional->anuncio_id                = $objAnuncio->id;
                $objAnuncioOpcional->save();
            }
        }

        // Aqui salvamos a imagem de capa do anuncio
        if (isset($_FILES['imagem']) && $_FILES['imagem']!=''){
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
                $fileType = Util::checkImageType($_FILES['imagem']['type']);
                if ($fileType){
                    $fileName = $_POST['dns'].'-'.$objAnuncio->id;

                    $imgPath = PATH_ANUNCIO.$fileName.'.'.$fileType;

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
                        $objAnuncio->imagem = $fileName.'.'.$fileType;
                        $objAnuncio->save();
                    }
                }
            }
        }
        

        $retorno = array('status'=>'1');

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>