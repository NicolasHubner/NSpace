<?php
    // include("../../lib/Config.php");
    ob_start();

    $objCliente  = Doctrine_Core::getTable('Cliente')->find($_GET['id']);

?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody style="font-family: 'Montserrat', sans-serif;">
        <tr>
            <td align="center">
                <table class="col-900" width="900" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td align="center" valign="top" background="<?php echo URL_IMAGES ?>bg_email.jpg"
                                bgcolor="#66809b"
                                style="background-size: 100%; background-position:top;padding: 60px 0px;">
                                <img style="display:block; line-height:0px; font-size:0px; border:0px;width: 225px;"
                                    src="<?php echo URL_IMAGES ?>logo.png" alt="logo">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center">
                <table class="col-900" width="900" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody style="font-family: 'Montserrat', sans-serif;font-size: 21px;font-weight: 100;">
                        <tr>
                            <td>
                                <div style="text-align: center; padding: 40px 0px;">
                                    <h4 style="color: #000;font-size: 28px;margin: 0px 0px 20px;">Olá <span
                                            style="color: #fe5000;"><?php echo $objCliente->apelido ?></span>,</h4>
                                    <p style="margin: 0px 0px 10px;">Confirme seu email para finalizar seu cadastro.</p>

                                    <div style="margin-top: 40px; text-align: left;">
                                        <div style="display: block; margin-bottom: 10px; text-align: center;">
                                            <a style="background: #fe5000;
                                            border: 1px solid #fc4f00;
                                            color: #fff;
                                            text-decoration: none;
                                            padding: 10px 32px;
                                            border-radius: 6px;" href="<?php echo URL.'confirmar-email/'.$objCliente->id.'/' ?>">Confirmar agora</a>
                                        </div>  
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>



<?php
    $obContent = ob_get_contents();
    ob_end_clean();

    try {
        $mail = new PHPMailer();
        $mail->From = 'no-reply@nspace.com.br';
        $mail->FromName = 'Nspace';
        $mail->IsHTML(true);
    
        $mail->AddAddress($objCliente->email);
    
        $mail->Subject = 'Confirme seu email!';
        $mail->Body = $obContent;
        $mail->CharSet = 'utf-8';
        $mail->send();

        $_SESSION['return_type']	= 'success';
		$_SESSION['return_message'] = 'E-mail de confirmação foi enviado com sucesso para o cliente.';

		header('Location: '.URL_ADMIN.$_GET['model'].'/');


    } catch (\Throwable $th) {
        echo $th;
    }
?>
