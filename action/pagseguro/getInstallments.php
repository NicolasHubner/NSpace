<?php

include('../../lib/Config.php');

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("NSPACE")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("NSPACE")->setRelease("1.0.0");

$options = [
    'amount' => $_GET['valor'], //Required
    'card_brand' => $_GET['bandeira'], //Optional
    // 'max_installment_no_interest' => 2 //Optional
];

try {
    $result = \PagSeguro\Services\Installment::create(
        \PagSeguro\Configuration\Configure::getAccountCredentials(),
        $options
    );

    $installments = [];
    foreach ($result->getInstallments() as $key => $value) {
        $installments[] = [
            'quantity'=>$value->getQuantity(),
            'amount'=>$value->getAmount(),
            'totalAmount'=>$value->getTotalAmount(),
            'interestFree'=>$value->getInterestFree()
        ];
    }

    echo json_encode($installments);

} catch (Exception $e) {
    die($e->getMessage());
}
