<?php

$api = true;
include "../../lib/Config.php";

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("NSPACE")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("NSPACE")->setRelease("1.0.0");

header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
header("access-control-allow-origin: https://ws.pagseguro.uol.com.br");

// $_POST['notificationType'] = 'transaction';
// $_POST['notificationCode'] = '4F45D7-5947F247F26D-A8844D3FABBB-B5C4E1';


$email = EMAIL_PAGSEGURO;
$token = TOKEN__PAGSEGURO;

//Something to write to txt log
$log  = date("F j, Y, g:i a").' - notificacao do pedido '.json_encode($_POST).PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents(PATH.'api/log_retornoPagseguro.log', $log, FILE_APPEND);

try {

    $headers = [];

    if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'preApproval'){
        if($pagseguroAmbiente == 'sandbox'){
            $url = 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;
        }else{
            $url = 'https://ws.pagseguro.uol.com.br/pre-approvals/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;
        }
        $headers = [
            "Accept: application/vnd.pagseguro.com.br.v3+xml;charset=ISO-8859-1"
        ];
    }else{
        if($pagseguroAmbiente == 'sandbox'){
            $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;
        }else{
            $url = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;
        }
    }

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $transaction= curl_exec($curl);
    curl_close($curl);

    if($transaction == 'Unauthorized'){
        //Insira seu código avisando que o sistema está com problemas, sugiro enviar um e-mail avisando para alguém fazer a manutenção

        exit;//Mantenha essa linha
    }
    $transaction = simplexml_load_string($transaction);

    $referencia = $transaction->reference;

    $ref = explode('-', $referencia);


    if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'preApproval'){
        $objAnuncioPlano = Doctrine_Core::getTable('AnuncioPlano')->find($ref[2]);
        $objAnuncioPlano->codigo = (string) $transaction->code;
        $objAnuncioPlano->tracker = (string) $transaction->tracker;
        $objAnuncioPlano->status = (string) $transaction->status=='ACTIVE'?1:0;
        $objAnuncioPlano->save();
    }

    if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){

        $situacaoPagamento = $transaction->status;

        if($situacaoPagamento == 3 || $situacaoPagamento == 4 || $situacaoPagamento == 6){
            $status_id = 1;
        }
        if($situacaoPagamento == 7){
            $status_id = 2;
        }
        
        $log  = date("F j, Y, g:i a").' transaction: '.json_encode($transaction).PHP_EOL."-------------------------".PHP_EOL;
        file_put_contents(PATH.'api/log_retornoPagseguro.log', $log, FILE_APPEND);

        $objCliente = Doctrine_Core::getTable("Cliente")->find($ref[1]);

        if($ref[0]=="P"){ // Assinatura
            $objAnuncioPlano = Doctrine_Core::getTable('AnuncioPlano')->find($ref[2]);

            $objAnuncioPlanoPagamento = Doctrine_Core::getTable('AnuncioPlanoPagamento')->findOneByCodigo($transaction->code);

            if(!$objAnuncioPlanoPagamento->id){
                $objAnuncioPlanoPagamento = new AnuncioPlanoPagamento();
                $objAnuncioPlanoPagamento->cliente_id = $_POST['cliente_id'];
                $objAnuncioPlanoPagamento->data_pagamento = date('Y-m-d H:i:s');
                $objAnuncioPlanoPagamento->anuncio_id = $objAnuncioPlano->anuncio_id;
                $objAnuncioPlanoPagamento->anuncio_plano_id = $ref[2];
                $objAnuncioPlanoPagamento->cliente_id = $ref[1];
                $objAnuncioPlanoPagamento->status = $status_id;
                $objAnuncioPlanoPagamento->codigo = (string) $transaction->code;
                $objAnuncioPlanoPagamento->data_cadastro = date('Y-m-d H:i:s');
                $objAnuncioPlanoPagamento->save();
            }else{
                $objAnuncioPlanoPagamento->status = $status_id;
                $objAnuncioPlanoPagamento->save();
            }

            // Se a assinatura for feita com sucesso eu libero o anuncio nos comandos abaixo:
            if (isset($status_id)&&$status_id==1) {
                $objAnuncio                     = Doctrine_Core::getTable('Anuncio')->find($objAnuncioPlano->anuncio_id);
                $objAnuncio->pagamento          = $status_id;
                $objAnuncio->save();
            }
        }else{ 
            // Pagamento da reserva
            $objReserva = Doctrine_Core::getTable('Reserva')->find($ref[2]);

            if($objReserva->codigo_transacao == null){
                $objReserva->codigo_transacao = $transaction->code;
            }
            if($status_id == 1){
                $objReserva->data_pagamento = date('Y-m-d H:i:s');
            }

            $objReserva->status = $status_id;
            $objReserva->save();

            if($status_id == 1){
                include('../emails/reserva/emailCodigoReserva.php');
                include('../emails/reserva/reservaCliente.php');
                include('../emails/reserva/reservaSpaceHost.php');
                include('../emails/reserva/reserva-nspace.php');
            }
        }
    }

} catch (Exception $e) {
    echo $e;
    //Something to write to txt log
    $log  = date("F j, Y, g:i a").' - erro: '.$e->getMessage().PHP_EOL.
            date("F j, Y, g:i a").' - erro: '.$e.PHP_EOL.
            "-------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents(PATH.'api/log_retornoPagseguro.log', $log, FILE_APPEND);
    // die($e->getMessage());
}

