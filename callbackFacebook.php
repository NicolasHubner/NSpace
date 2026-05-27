<?php
require_once("lib/Config.php");

try {
    $accessToken = $handler->getAccessToken();
}catch(\Facebook\Exceptions\FacebookResponseException $e){
    echo "Response Exception: " . $e->getMessage();
    exit();
}catch(\Facebook\Exceptions\FacebookSDKException $e){
    echo "SDK Exception: " . $e->getMessage();
    exit();
}

if(!$accessToken){
    header('Location: '.URL);
    exit();
}

$oAuth2Client = $FBObject->getOAuth2Client();
if(!$accessToken->isLongLived())
    $accessToken = $oAuth2Client->getLongLivedAccesToken($accessToken);

        $response 							= $FBObject->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
        $userData 							= $response->getGraphNode()->asArray();
        $_SESSION['userData'] 				= $userData;
        $_SESSION['access_token'] 			= (string) $accessToken;

if (isset($_SESSION['userData']['id'])&&$_SESSION['userData']['id']!='') {
    // print_r($_SESSION);
    // die();
    
    $objCliente 	               = Doctrine_Core::getTable('Cliente')->findOneByEmailAndFacebookUserId($_SESSION['userData']['email'], $_SESSION['userData']['id']);
    $objValidacaoEmail          = Doctrine_Core::getTable('Cliente')->findOneByEmail($_SESSION['userData']['email']);


    if (isset($objCliente->id)) {
        $_SESSION['sess_cliente_id']        = $objCliente->id;
        $_SESSION['sess_cliente_nome']      = $objCliente->apelido;

        header('Location: '.URL);
    } else if (isset($objValidacaoEmail->id)) {
        $_SESSION['sess_cliente_id']        = $objValidacaoEmail->id;
        $_SESSION['sess_cliente_nome']      = $objValidacaoEmail->apelido;

        $objValidacaoEmail->facebook_access_token          = $_SESSION['access_token']; 
        $objValidacaoEmail->facebook_user_id               = $_SESSION['userData']['id'];  
        $objValidacaoEmail->save();
        
        $retorno = array('status'=>'1');
    } else {

        $numerVerificador = rand(45668446, 3146546496);

        $objCliente                         		= new Cliente();
        $objCliente->data_cadastro          		= date('Y-m-d H:i:s');
        $objCliente->nome                 			= $_SESSION['userData']['first_name']; 
        $objCliente->apelido                		= $_SESSION['userData']['first_name']; 
        $objCliente->email                			= $_SESSION['userData']['email']; 
        $objCliente->facebook_access_token          = $_SESSION['access_token']; 
        $objCliente->facebook_user_id          		= $_SESSION['userData']['id']; 
        $objCliente->senha          				= md5($numerVerificador); 
        $objCliente->tipo_cliente_id                = 1; 
        $objCliente->tipo_pessoa_id                 = 1; 
        $objCliente->status                         = 1; 
        $objCliente->email_confirmado               = 1; 
        $objCliente->save();

        $_SESSION['sess_cliente_id']        = $objCliente->id;
        $_SESSION['sess_cliente_nome']      = $objCliente->apelido;

        header('Location: '.URL);
    }
}

?>