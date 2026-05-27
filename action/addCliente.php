<?php
    include("../lib/Config.php");

    try {

        $validacaoEmail                          =  Doctrine_Core::getTable('Cliente')->findOneByEmail($_POST['email']);
        $validacaoCPF                          =  Doctrine_Core::getTable('Cliente')->findOneByCpf($_POST['cpf']);

        if (isset($validacaoEmail->id) || isset($validacaoCPF->id)) {
            $retorno = array('status'=>'2', 'mensagem'=>'E-mail ou CPF já cadastrado na NSPACE!');
        } else {
            $objCliente                         = new Cliente();
            $objCliente->data_cadastro          = date('Y-m-d H:i:s');
            $objCliente->email                  = $_POST['email']; 
            $objCliente->apelido                = $_POST['apelido']; 
            $objCliente->telefone               = $_POST['telefone']; 
            $objCliente->senha                  = md5($_POST['senha']); 
            $objCliente->tipo_pessoa_id         = $_POST['tipo_pessoa_id']; 

            if (isset($_POST['tipo_pessoa_id'])&&$_POST['tipo_pessoa_id']==1) {
                $objCliente->nome                   = $_POST['nome']; 
                $objCliente->cpf         = $_POST['cpf']; 
            } else if ($_POST['tipo_pessoa_id'] == 2) {
                $objCliente->nome                   = $_POST['razao_social']; 
                $objCliente->cnpj                   = $_POST['cnpj']; 
            }

            $objCliente->status                 = 1; 
            $objCliente->verificado             = 0; 
            $objCliente->termo                  = isset($_POST['termo'])&&$_POST['termo']==1?$_POST['termo']:0; 
            $objCliente->tipo_cliente_id        = 1; 
            $objCliente->email_confirmado       = 0; 
            $objCliente->afiliado_id            = isset($_POST['afiliado_id'])&&$_POST['afiliado_id']!=''?$_POST['afiliado_id']:null; 
            $objCliente->save();

            $codigoAfiliado = substr($objCliente->nome, 0, 3); 
            $codigoAfiliado = strtoupper($codigoAfiliado.$objCliente->id.date('Y'));

            $strCorrigido = strtolower(preg_replace("[^a-zA-Z0-9-]", "", strtr(utf8_decode(trim($codigoAfiliado)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

            $objCliente->codigo_afiliado        = $strCorrigido; 
            $objCliente->save();

            include('emails/email_boas_vindas.php');
            include('emails/email_confirmacao.php');

            
            $_SESSION['sess_cliente_id']        = $objCliente->id;
            $_SESSION['sess_cliente_nome']      = $objCliente->nome;


            if (isset($_POST['url'])&&$_POST['url']!='') {
              $resAnuncio = Doctrine_Core::getTable('Anuncio')->find($_POST['url']);

              $retorno = array('status'=>'1', 'url'=>URL.'anuncio/'.$resAnuncio->dns.'/'.$resAnuncio->id.'/');
            } else {
              $retorno = array('status'=>'1');
            }
        }
    	

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>