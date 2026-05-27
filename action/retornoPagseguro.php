
<?php
include('../lib/Config.php');

if(isset($_POST['notificationCode']) && $_POST['notificationCode'] != ''){
	$email =  $objConfiguracao->email_pagamento;
    $token = $objConfiguracao->token_pagamento;

    $sandbox = true;

    if (isset($sandbox)&&$sandbox==false) {
        $url = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;
    }

    if (isset($sandbox)&&$sandbox==true) {
        $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;
    }

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $transaction= curl_exec($curl);
    curl_close($curl);

    if($transaction == 'Unauthorized'){
        exit;
    }
    $transaction = simplexml_load_string($transaction);

    try {
        $status = $transaction->status;
        $codigo_transacao = $transaction->code;

    	$objReserva                             = Doctrine_Core::getTable('Reserva')->find($transaction->reference);
		$objReserva->data_pagamento             = date('Y-m-d H:i:s');
        $objReserva->status                     = intval($status);
        $objReserva->codigo_transacao           = utf8_encode($codigo_transacao);
		$objReserva->save();

    } catch (Exception $e) {
    	echo $e;
    }
}
