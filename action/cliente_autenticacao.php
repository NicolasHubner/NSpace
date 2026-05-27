<?php
  include("../lib/Config.php");
  // Realiza a autenticação pad:123456789
    // Tipos de acesso:
    // 1 = email
    // 2 = cpf
  if (isset($_POST['tipo_acesso'])&&$_POST['tipo_acesso']==1) {
    $resCliente = Doctrine_Core::getTable('Cliente')->findOneByEmailAndSenha($_POST['email'],md5($_POST['senha']));
  } else if ($_POST['tipo_acesso']==2) {
    $resCliente = Doctrine_Core::getTable('Cliente')->findOneByCpfAndSenha($_POST['cpf'],md5($_POST['senha']));
  }

    if (isset($resCliente->id)&&$resCliente->id!='' && isset($resCliente->status)&&$resCliente->status!='') {

      if ($resCliente->email_confirmado==1) {
        if ($resCliente->status==1) {
          if (isset($_POST['manter_logado'])&&$_POST['manter_logado']==1) {
            $tempodevida = 2678400; // 1 ano de vida
            session_set_cookie_params($tempodevida);
            session_start();
            setcookie(session_name(), session_id(), time() + $tempodevida, '/');
          }

          $_SESSION['sess_cliente_id']              = $resCliente->id;
          $_SESSION['sess_tipo_cliente_id']        = $resCliente->tipo_cliente_id;
          $_SESSION['sess_cliente_nome']          = $resCliente->nome;

          if (isset($_POST['url'])&&$_POST['url']!='') {
            $resAnuncio = Doctrine_Core::getTable('Anuncio')->find($_POST['url']);

            $retorno = array('status'=>'1', 'url'=>URL.'anuncio/'.$resAnuncio->dns.'/'.$resAnuncio->id.'/');
          } else {
            $retorno = array('status'=>'1');
          }
        } else if ($resCliente->status==3) {
          $retorno = array('status'=>'3', 'mensagem'=>'Sua conta foi desativada, favor entrar em contato com a NSPACE!');
        }
      } else {
        $retorno = array('status'=>'3', 'mensagem'=>'Você precisa confirmar seu email para acessar a plataforma.');
      }

    } else {
      $retorno = array('status'=>'2', 'mensagem'=>'Acesso negado!');
    }
  echo json_encode($retorno);

?>