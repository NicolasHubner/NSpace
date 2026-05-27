<?php

    include('../../lib/Config.php');

    \PagSeguro\Library::initialize();
    \PagSeguro\Library::cmsVersion()->setName("NSPACE")->setRelease("1.0.0");
    \PagSeguro\Library::moduleVersion()->setName("NSPACE")->setRelease("1.0.0");

    $document = new \PagSeguro\Domains\DirectPreApproval\Document();
    $document->withParameters('CPF', Util::getNumbers($_POST['cpf'])); //assinante
    
    $objCliente = Doctrine_Core::getTable('Cliente')->find($_SESSION['sess_cliente_id']);
    $objCidade = Doctrine_Core::getTable('Cidade')->findOneById($_POST['endereco']['cidade_id']);
    $objEstado = Doctrine_Core::getTable('Estado')->findOneById($_POST['endereco']['estado_id']);

    if($pagseguroAmbiente == 'sandbox')
        $objPlano = Doctrine_Core::getTable('Plano')->findOneByPagseguroSandbox($_POST['plano']);
    else
        $objPlano = Doctrine_Core::getTable('Plano')->findOneByPagseguroProduction($_POST['plano']);

    try {

        $objAnuncioPlano = new AnuncioPlano();
        $objAnuncioPlano->anuncio_id = $_POST['id'];
        $objAnuncioPlano->cliente_id = $_SESSION['sess_cliente_id'];
        $objAnuncioPlano->plano_id = $objPlano->id;
        $objAnuncioPlano->data_cadastro = date('Y-m-d H:i:s');
        $objAnuncioPlano->save();

        $preApproval = new \PagSeguro\Domains\Requests\DirectPreApproval\Accession();
        $preApproval->setPlan($_POST['plano']);
        $preApproval->setReference("P-".$_SESSION['sess_cliente_id']."-".$objAnuncioPlano->id);
        $preApproval->setSender()->setName($_POST['cartao']['nome']);//assinante
        
        if($pagseguroAmbiente=='sandbox')
            $preApproval->setSender()->setEmail('email@sandbox.pagseguro.com.br');//assinante
        else
            $preApproval->setSender()->setEmail($objCliente->email);//assinante

        $preApproval->setSender()->setIp('192.168.10.1');//assinante
        $preApproval->setSender()->setAddress()->withParameters($_POST['endereco']['logradouro'], $_POST['endereco']['numero'], $_POST['endereco']['bairro'], $_POST['endereco']['cep'],  $objCidade->nome, $objEstado->sigla, 'BRA');//assinante

        $preApproval->setSender()->setDocuments($document);
        $preApproval->setSender()->setPhone()->withParameters(substr(Util::getNumbers($_POST['telefone']), 0, 2), substr(Util::getNumbers($_POST['telefone']), 2)); //assinante
        $preApproval->setPaymentMethod()->setCreditCard()->setToken($_POST['cartao']['tokenCartao']); //token do cartão de crédito gerado via javascript
        $preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setName($_POST['cartao']['nome']); //nome do titular do cartão de crédito
        $preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setBirthDate($_POST['data_nascimento']); //data de nascimento do titular do cartão de crédito
        $preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setDocuments($document);
        $preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setPhone()->withParameters(substr(Util::getNumbers($_POST['telefone']), 0, 2), substr(Util::getNumbers($_POST['telefone']), 2)); //telefone do titular do cartão de crédito
        $preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setBillingAddress()->withParameters($_POST['endereco']['logradouro'], $_POST['endereco']['numero'], $_POST['endereco']['bairro'], $_POST['endereco']['cep'], $objCidade->nome, $objEstado->sigla, 'BRA');//endereço do titular do cartão de crédito

        $retorno = $preApproval->register(
            \PagSeguro\Configuration\Configure::getAccountCredentials()
        );

        $objAnuncioPlano->codigo = $retorno->code;
        $objAnuncioPlano->save();

        $data['vinculo'] = $retorno;

        $response['status'] = true;
        $response['error'] = null;
        $response['data'] = $data;

        echo json_encode($response);
    } catch (Exception $e) {
        $txt = date('d/m/Y H:i:s')." - Cliente: ".$_POST['cliente_id'].", Erro: ".$e->getMessage().PHP_EOL;
        $myfile = file_put_contents(PATH.'action/pagseguro/logs/logsErr.txt', $txt , FILE_APPEND);

        $response['status'] = false;
        $response['error'] = $e->getMessage();
        $response['data'] = null;
        echo json_encode($response);
    } 


