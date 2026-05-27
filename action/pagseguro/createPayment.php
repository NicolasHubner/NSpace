<?php

  include('../../lib/Config.php');

  \PagSeguro\Library::initialize();
  \PagSeguro\Library::cmsVersion()->setName("NSPACE")->setRelease("1.0.0");
  \PagSeguro\Library::moduleVersion()->setName("NSPACE")->setRelease("1.0.0");

  //Instantiate a new direct payment request, using Credit Card
  $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
    
  $objReserva = Doctrine_Core::getTable('Reserva')->find($_POST['id']);
  $valor = number_format($objReserva->valor_total, 2, '.', '');

  $objCliente = Doctrine_Core::getTable('Cliente')->find($_SESSION['sess_cliente_id']);
  $objCidade = Doctrine_Core::getTable('Cidade')->findOneById($_POST['endereco']['cidade_id']);
  $objEstado = Doctrine_Core::getTable('Estado')->findOneById($_POST['endereco']['estado_id']);

  $creditCard->setReference("R-".$_SESSION['sess_cliente_id']."-".$objReserva->id);

  // Set the currency
  $creditCard->setCurrency("BRL");

  // Add an item for this payment request
  $creditCard->addItems()->withParameters(
      '0001',
      'Reserva',
      1,
      $valor
  );

  $creditCard->setSender()->setName($_POST['cartao']['nome']);//assinante
  
  if($pagseguroAmbiente=='sandbox')
    $creditCard->setSender()->setEmail('email@sandbox.pagseguro.com.br');//assinante
  else
    $creditCard->setSender()->setEmail($objCliente->email);//assinante

  $creditCard->setSender()->setDocument()->withParameters(
      'CPF',
      $_POST['cpf']
  );


   $creditCard->setSender()->setPhone()->withParameters(
        substr(Util::getNumbers($_POST['telefone']), 0, 2),
        substr(Util::getNumbers($_POST['telefone']), 2, 9)
    );

  $creditCard->setSender()->setHash($_POST['hash']);

  $creditCard->setSender()->setIp('127.0.0.0');
  
  // Set shipping information for this payment request
  $creditCard->setShipping()->setAddress()->withParameters(
      $_POST['endereco']['logradouro'],
      $_POST['endereco']['numero'],
      $_POST['endereco']['bairro'],
      $_POST['endereco']['cep'],
      $objCidade->nome,
      $objEstado->sigla,
      'BRA',
      ''
  );

  //Set billing information for credit card
  $creditCard->setBilling()->setAddress()->withParameters(
      $_POST['endereco']['logradouro'],
      $_POST['endereco']['numero'],
      $_POST['endereco']['bairro'],
      $_POST['endereco']['cep'],
      $objCidade->nome,
      $objEstado->sigla,
      'BRA',
      ''
  );

  // Set credit card token
  $creditCard->setToken($_POST['cartao']['tokenCartao']);

  // Set the installment quantity and value (could be obtained using the Installments
  // service, that have an example here in \public\getInstallments.php)
  $creditCard->setInstallment()->withParameters($_POST['installments'][$_POST['selectedInstallment']]['quantity'], number_format($_POST['installments'][$_POST['selectedInstallment']]['amount'], 2, '.', ''));

  // Set the credit card holder information
  $creditCard->setHolder()->setBirthdate($_POST['data_nascimento']);
  $creditCard->setHolder()->setName($_POST['cartao']['nome']); // Equals in Credit Card


  $creditCard->setHolder()->setPhone()->withParameters(
        substr(Util::getNumbers($_POST['telefone']), 0, 2),
        substr(Util::getNumbers($_POST['telefone']), 2, 9)
    );

  $creditCard->setHolder()->setDocument()->withParameters(
      'CPF',
      $_POST['cpf']
  );

  // Set the Payment Mode for this payment request
  $creditCard->setMode('DEFAULT');

  // Set a reference code for this payment request. It is useful to identify this payment
  // in future notifications.

  try {
      //Get the crendentials and register the boleto payment
      $result = $creditCard->register(
          \PagSeguro\Configuration\Configure::getAccountCredentials()
      );

      $objReserva->codigo_transacao = $result->getCode();
      $objReserva->save();
      
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
