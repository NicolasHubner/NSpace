<?php
    // include("../../../lib/Config.php");
    // $objReserva                             = Doctrine_Core::getTable('Reserva')->find(119);
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
                                            style="color: #fe5000;"><?php echo $objReserva->Anuncio->Cliente->apelido ?></span>,</h4>
                                    <p style="margin: 0px 0px 10px;">Você validou com sucesso a reserva abaixo:</p>

                                    <div style="margin-top: 30px; text-align: left;">
                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Data da reserva:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_cadastro)) ?>
                                        </div>  

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Espaço:</label> <?php echo $objReserva->Anuncio->titulo ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Data de entrada:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_entrada)) ?>
                                        </div>  

                                        <?php if (isset($objReserva->Anuncio->tipo_cobranca_id)&&$objReserva->Anuncio->tipo_cobranca_id==2) { ?>
                                            <div style="display: block; margin-bottom: 10px;">
                                                <label style="font-weight: 600;color: #000;">Data de saída:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_saida)) ?>
                                            </div>  

                                            <div style="display: block; margin-bottom: 10px;">
                                                <label style="font-weight: 600;color: #000;">Quantidade de diárias:</label> <?php echo $objReserva->qtd_dias ?>
                                            </div>
                                        <?php } else if ($objReserva->Anuncio->tipo_cobranca_id==1) { ?>
                                            <div style="display: block; margin-bottom: 10px;">
                                                <label style="font-weight: 600;color: #000;">Horário de entrada:</label> <?php echo $objReserva->horario_entrada ?>
                                            </div>  

                                            <div style="display: block; margin-bottom: 10px;">
                                                <label style="font-weight: 600;color: #000;">Horário de saída:</label> <?php echo $objReserva->horario_saida ?>
                                            </div> 

                                            <div style="display: block; margin-bottom: 10px;">
                                                <label style="font-weight: 600;color: #000;">Horas alugada:</label> <?php echo $objReserva->hora_diferenca ?>
                                            </div>  
                                        <?php } ?>                                  
                                    </div>

                                    <div style="margin-top: 30px; text-align: left;">
                                        <h4 style="margin-bottom: 10px;">Dados do cliente:</h4>

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Cadastrado desde:</label> <?php echo date('d/m/Y', strtotime($objReserva->Cliente->data_cadastro)) ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Cliente:</label> <?php echo $objReserva->Cliente->nome ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Telefone:</label> <?php echo $objReserva->Cliente->telefone ?>
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
    
        $mail->AddAddress($objReserva->Anuncio->Cliente->email);
        // $mail->AddAddress('phaael.paulo@gmail.com');
    
        $mail->Subject = 'Você validou a reserva de nº #'.$objReserva->id;
        $mail->Body = $obContent;
        $mail->CharSet = 'utf-8';
        $mail->send();

    } catch (\Throwable $th) {
        echo $th;
    }
?>
