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


include '../Config.php';
require_once "PagSeguroLibrary.php";

/**
 * Class with a main method to illustrate the usage of the domain class PagSeguroPaymentRequest
 */
class CreatePaymentRequest
{

    public static function main($id)
    {
        // Inicializa a requisição
        $paymentRequest = new PagSeguroPaymentRequest();

        // Pega a venda
        $res = Doctrine_Core::getTable('Venda')->find($id);

        // Seta a moeda
        $paymentRequest->setCurrency("BRL");

        $x = 1;

        //Busca todos os produtos da venda
        foreach ($res->VendaProduto as $objVendaProduto) { 
            // Adiciona o item a requisição
            $paymentRequest->addItem(str_pad($x, 4, '0', STR_PAD_LEFT), $objVendaProduto->Produto->nome, $objVendaProduto->quantidade, $objVendaProduto->valor_total);
            $x++;
        }

        // Seta o código
        $paymentRequest->setReference($id);

        // Set shipping information for this payment request
        $sedexCode = PagSeguroShippingType::getCodeByType('SEDEX');
        $paymentRequest->setShippingType($sedexCode);
        $paymentRequest->setShippingAddress(
            $res->Endereco->cep,
            $res->Endereco->logradouro,
            $res->Endereco->numero,
            $res->Endereco->complemento,
            $res->Endereco->bairro,
            $res->Endereco->Cidade->nome,
            $res->Endereco->Estado->sigla,
            'BRA'
        );

        // Set your customer information.
        $paymentRequest->setSender(
            $res->nome,
            $res->email,
            $res->ddd,
            $res->telefone,
            'CPF',
            $res->cpf
        );

        // Set the url used by PagSeguro to redirect user after checkout process ends
        $paymentRequest->setRedirectUrl("http://www.lojamodelo.com.br");

        try {

            /*
             * #### Credentials #####
             * Replace the parameters below with your credentials
             * You can also get your credentials from a config file. See an example:
             * $credentials = PagSeguroConfig::getAccountCredentials();
            //  */

            // seller authentication
            $credentials = new PagSeguroAccountCredentials("vendedor@lojamodelo.com.br",
                "E231B2C9BCC8474DA2E260B6C8CF60D3");

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
            echo "<h2>Criando requisi&ccedil;&atilde;o de pagamento</h2>";
            echo "<p>URL do pagamento: <strong>$url</strong></p>";
            echo "<p><a title=\"URL do pagamento\" href=\"$url\">Ir para URL do pagamento.</a></p>";
        }
    }
}

CreatePaymentRequest::main();
