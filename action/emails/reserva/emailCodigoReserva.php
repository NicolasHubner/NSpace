<?php
    // include("../../../lib/Config.php");
    ob_start();
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
                                <img style="display:block; line-height:0px; font-size:0px; border:0px;width: 160px;"
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
                                            style="color: #fe5000;"><?php echo $objReserva->Cliente->apelido ?></span>,</h4>
                                    <p style="margin: 0px 0px 10px;">Reservado com sucesso. Seguem abaixo os dados da sua reserva:</p>

                                                    
                                    <div style="margin-top: 30px; text-align: left;">
                                        <h4 style="font-size: 28px;color: #000; margin-bottom: 5px; text-align: center;">Código da reserva</h4>
                                        <div style="font-size: 50px;margin: 15px 0px 15px;text-align: center;letter-spacing: 17px;color: #fd5000;"><?php echo $objReserva->codigo ?></div>
                                        <p style="margin: 0px;">Instruções:</p>
                                        <p><span style="color: red; font-weight: 600;">Forneça o código ao <span style="font-weight: 600; font-style: italic;">proprietário</span> após verificar que o local condiz com o reservado. <span style="font-weight: 600;">Sua entrada será liberada assim que o proprietário receber o código!</span></p>
                                        <p>Leve sua identidade no local da reserva na data e hora agendada, e tenha em mãos o número do código da reserva!</p>
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
    
        $mail->AddAddress($objReserva->Cliente->email);
        // $mail->AddAddress('phaael.paulo@gmail.com');
    
        $mail->Subject = 'Código da reserva';
        $mail->Body = $obContent;
        $mail->CharSet = 'utf-8';
        $mail->send();

    } catch (\Throwable $th) {
        echo $th;
    }
?>
