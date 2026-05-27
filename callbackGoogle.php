<?php
    require_once("lib/Config.php");

    if (isset($_POST['userID'])&&$_POST['userID']!='') {
        $objCliente     = Doctrine_Core::getTable('Cliente')->findOneByEmailAndGoogleUserId($_POST['userEmail'], $_POST['userID']);
        
        $objValidacaoEmail     = Doctrine_Core::getTable('Cliente')->findOneByEmail($_POST['userEmail']);

        
        if (isset($objCliente->id)) {
            $_SESSION['sess_cliente_id']        = $objCliente->id;
            $_SESSION['sess_cliente_nome']      = $objCliente->apelido;
            
            $retorno = array('status'=>'1');
        } else if (isset($objValidacaoEmail->id)) {
            $_SESSION['sess_cliente_id']        = $objValidacaoEmail->id;
            $_SESSION['sess_cliente_nome']      = $objValidacaoEmail->apelido;

            $objValidacaoEmail->google_user_id                 = $_POST['userID']; 
            $objValidacaoEmail->save();
            
            $retorno = array('status'=>'1');
        } else {

            $numerVerificador = rand(45668446, 3146546496);

            $objCliente                                 = new Cliente();
            $objCliente->data_cadastro                  = date('Y-m-d H:i:s');
            $objCliente->nome                           = $_POST['userName']; 
            $objCliente->apelido                        = $_POST['userName']; 
            $objCliente->email                          = $_POST['userEmail']; 
            $objCliente->google_user_id                 = $_POST['userID']; 
            $objCliente->senha                          = md5($numerVerificador); 
            $objCliente->tipo_pessoa_id                 = 1; 
            $objCliente->tipo_cliente_id                = 1; 
            $objCliente->status                         = 1; 
            $objCliente->email_confirmado               = 1; 
            $objCliente->save();

            $codigoAfiliado = substr($objCliente->nome, 0, 3); 
            $codigoAfiliado = strtoupper($codigoAfiliado.$objCliente->id.date('Y'));
            $strCorrigido = strtolower(preg_replace("[^a-zA-Z0-9-]", "", strtr(utf8_decode(trim($codigoAfiliado)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

            $objCliente->codigo_afiliado        = $strCorrigido; 
            $objCliente->save();

            $_SESSION['sess_cliente_id']        = $objCliente->id;
            $_SESSION['sess_cliente_nome']      = $objCliente->apelido;

            $retorno = array('status'=>'1');
        }

    }

    echo json_encode($retorno);
?>