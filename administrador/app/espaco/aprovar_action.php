<?php
	defined('_ACTION') or exit('Direct access to the script is not allowed!');

	$objAnuncio 							= Doctrine_Core::getTable('Anuncio')->find($_GET['id']);
	$objAnuncio->status_id 					= 2;
	$objAnuncio->save();

    $valor                             		= Util::formata_valor($objAnuncio->valor);

    $opcionaisLista = '';
    $retAnuncioOpcional = Doctrine_Query::create()->select()->from('AnuncioOpcional')->where('anuncio_id = '.$objAnuncio->id)->execute();
	foreach ($retAnuncioOpcional as $objAnuncioOpcional) {
		$opcionaisLista .= $objAnuncioOpcional->Opcional->nome.', ';
	}

	$objLogAnuncio                         				= new LogAnuncio();
    $objLogAnuncio->data_cadastro          				= date('Y-m-d H:i:s');
    $objLogAnuncio->titulo                 				= $objAnuncio->titulo; 
    $objLogAnuncio->categoria_id           				= $objAnuncio->categoria_id; 
    $objLogAnuncio->tipo_cobranca_id       				= $objAnuncio->tipo_cobranca_id; 
    $objLogAnuncio->espaco                 				= $objAnuncio->espaco; 
    $objLogAnuncio->limite_pessoas         				= $objAnuncio->limite_pessoas; 
    $objLogAnuncio->plano_id               				= $objAnuncio->plano_id; 
    $objLogAnuncio->cliente_id             				= $objAnuncio->cliente_id; 
    $objLogAnuncio->garagem                				= $objAnuncio->garagem; 
    $objLogAnuncio->quarto                 				= $objAnuncio->quarto; 
    $objLogAnuncio->banheiro               				= $objAnuncio->banheiro; 
    $objLogAnuncio->valor                  				= (float)$valor;
    $objLogAnuncio->termo                  				= $objAnuncio->termo; 
    $objLogAnuncio->local_proprio                  		= $objAnuncio->local_proprio; 
    $objLogAnuncio->descricao              				= $objAnuncio->descricao; 
    $objLogAnuncio->periodo_minimo         				= $objAnuncio->periodo_minimo; 
    $objLogAnuncio->opcionais         					= $opcionaisLista; 
    $objLogAnuncio->comprovante_endereco    			= URL_ANUNCIO_DOCUMENTOS.$objAnuncio->comprovante_endereco; 
    $objLogAnuncio->comprovante_identidade              = URL_ANUNCIO_DOCUMENTOS.$objAnuncio->comprovante_identidade; 
    $objLogAnuncio->imagem    			                = URL_ANUNCIO.$objAnuncio->imagem; 
    $objLogAnuncio->cep                    				= $objAnuncio->cep;
    $objLogAnuncio->logradouro             				= $objAnuncio->logradouro;
    $objLogAnuncio->numero                 				= $objAnuncio->numero;
    $objLogAnuncio->complemento            				= $objAnuncio->complemento;
    $objLogAnuncio->bairro                 				= $objAnuncio->bairro;
    $objLogAnuncio->estado_id              				= $objAnuncio->estado_id;
    $objLogAnuncio->cidade_id              				= $objAnuncio->cidade_id;
    $objLogAnuncio->codigo                              = $objAnuncio->codigo;
    $objLogAnuncio->anuncio_id             				= $objAnuncio->id;
    $objLogAnuncio->save();

	// include('email_espaco_aprovado.php');

	$_SESSION['return_type']	= 'success';
	$_SESSION['return_message'] = 'Espaço foi aprovado com sucesso';

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');