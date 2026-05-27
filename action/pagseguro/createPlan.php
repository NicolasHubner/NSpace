<?php

include('../../lib/Config.php');

echo "OPA! Criando plano.";

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("NSPACE")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("NSPACE")->setRelease("1.0.0");

$plan = new \PagSeguro\Domains\Requests\DirectPreApproval\Plan();
$plan->setRedirectURL('https://nspace.com.br');
$plan->setReference('PLANO_AVIAO');
$plan->setPreApproval()->setName('PLANO AVIÃO');
$plan->setPreApproval()->setCharge('AUTO');
$plan->setPreApproval()->setPeriod('monthly');
$plan->setPreApproval()->setAmountPerPayment('19.90');
$plan->setPreApproval()->setDetails('');
$plan->setPreApproval()->setCancelURL("https://www.nspace.com.br/plano/cancelamento");
$plan->setReviewURL('https://www.nspace.com.br/plano/sucesso');

try {
    $response = $plan->register(
        \PagSeguro\Configuration\Configure::getAccountCredentials()
    );

    echo '<pre>';
    print_r($response);
} catch (Exception $e) {
    die($e->getMessage());
}




$plan = new \PagSeguro\Domains\Requests\DirectPreApproval\Plan();
$plan->setRedirectURL('https://nspace.com.br');
$plan->setReference('PLANO_FOGUETE');
$plan->setPreApproval()->setName('PLANO FOGUETE');
$plan->setPreApproval()->setCharge('AUTO');
$plan->setPreApproval()->setPeriod('monthly');
$plan->setPreApproval()->setAmountPerPayment('39.90');
$plan->setPreApproval()->setDetails('');
$plan->setPreApproval()->setCancelURL("https://www.nspace.com.br/plano/cancelamento");
$plan->setReviewURL('https://www.nspace.com.br/plano/sucesso');

try {
    $response = $plan->register(
        \PagSeguro\Configuration\Configure::getAccountCredentials()
    );

    echo '<pre>';
    print_r($response);
} catch (Exception $e) {
    die($e->getMessage());
}

