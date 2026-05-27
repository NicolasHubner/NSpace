<?php //

/*
 * ***********************************************************************
 Copyright [2011] [PagSeguro Internet Ltda.]

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 * ***********************************************************************
 */

include '../lib/Config.php';
require_once PATH."lib/PagSeguroLibrary/PagSeguroLibrary.php";
/**
 * Class with a main method to illustrate the usage of the domain class PagSeguroPaymentRequest
 */
class CreatePaymentRequest
{

    public static function main()
    {
        $id = $_GET['id'];

        // Inicializa a requisição
        $paymentRequest = new PagSeguroPaymentRequest();

        // Pega a venda
        $res = Doctrine_Core::getTable('Reserva')->find($id);

       
        // Seta a moeda
        $paymentRequest->setCurrency("BRL");

        $x = 1;
        
      
        // Adiciona o item a requisição
         $paymentRequest->addItem(str_pad($x, 4, '0', STR_PAD_LEFT), 'Reserva - '.$res->Anuncio->titulo, 1, number_format($res->valor_total, 2, '.', ''), 0, 0);


        // Seta o código
        $paymentRequest->setReference('C'.$id);

        // Set shipping information for this payment request
        $sedexCode = PagSeguroShippingType::getCodeByType('PAC');
        $paymentRequest->setShippingType($sedexCode);
        $paymentRequest->setShippingCost(number_format(0, 2, '.', ''));
        $paymentRequest->setShippingAddress(
            $res->Cliente->cep,
            $res->Cliente->logradouro,
            $res->Cliente->numero,
            $res->Cliente->complemento,
            $res->Cliente->bairro,
            $res->Cliente->Cidade->nome,
            $res->Cliente->Estado->sigla,
            'BRA'
        );

        $type = "CPF";
        $type_value = Util::getNumbers($res->Cliente->cpf);
        

        // Set your customer information.
        $paymentRequest->setSender(
            $res->Cliente->nome,
            $res->Cliente->email,
            '',
            '',
            '',
            ''
            
        );

        // $paymentRequest->addSenderDocument(
        //     $type,
        //     $type_value
        // );


        // Set the url used by PagSeguro to redirect user after checkout process ends
        $paymentRequest->setRedirectUrl(URL);

        try {

            /*
             * #### Credentials #####
             * Replace the parameters below with your credentials
             * You can also get your credentials from a config file. See an example:
             * $credentials = PagSeguroConfig::getAccountCredentials();
            //  */

            // seller authentication
            $credentials = new PagSeguroAccountCredentials(EMAIL_PAGSEGURO,TOKEN_PAGSEGURO);
            // $credentials = new PagSeguroAccountCredentials('raphaelpaulopereira@outlook.com','0712CCE59F8C4B74BD2F67358FBB9EA7');

            // application authentication
            //$credentials = PagSeguroConfig::getApplicationCredentials();

            //$credentials->setAuthorizationCode("E231B2C9BCC8474DA2E260B6C8CF60D3");

            // Register this payment request in PagSeguro to obtain the payment URL to redirect your customer.
            $url = $paymentRequest->register($credentials);

            self::printPaymentUrl($url);

        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }
    }

    public static function printPaymentUrl($url)
    {
        if ($url) {
             $pieces = explode("=", $url);
            echo json_encode($pieces[1]);
            //header("Location: ".$url);
        }
    }
}

CreatePaymentRequest::main();