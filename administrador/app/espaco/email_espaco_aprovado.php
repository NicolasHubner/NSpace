<?php
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
                                style="background-size:cover; background-position:top;padding: 60px 0px;">
                                <img style="display:block; line-height:0px; font-size:0px; border:0px;width: 300px;"
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
                                            style="color: #fe5000;"><?php echo $objAnuncio->Cliente->nome ?></span>,</h4>
                                    <p style="margin: 0px 0px 10px;">Seu espaço foi aprovado com sucesso em nossa plataforma. Segue abaixo os dados:</p>

                                    <div style="margin-top: 30px;">
                                        <div style="display: block;text-align: left;margin: 10px 0;">
                                            <strong>Título: </strong> <?php echo $objAnuncio->titulo ?>
                                        </div> 

                                        <div style="display: block;text-align: left;margin: 10px 0;">
                                            <strong>Categoria: </strong> <?php echo $objAnuncio->Categoria->nome ?>
                                        </div> 

                                        <div style="display: block;text-align: left;margin: 10px 0;">
                                            <strong>Tipo de cobrança: </strong> <?php echo $objAnuncio->TipoCobranca->nome ?>
                                        </div>   

                                        <div style="display: block;text-align: left;margin: 10px 0;">
                                            <strong>Espaço: </strong> <?php echo $objAnuncio->espaco.'m²' ?>
                                        </div>  

                                        <div style="display: block;text-align: left;margin: 10px 0;">
                                            <strong>Limite de pessoas: </strong> <?php echo $objAnuncio->limite_pessoas ?>
                                        </div>  

                                        <?php if (isset($objAnuncio->codigo)&&$objAnuncio->codigo!='') { ?>
                                            <div style="display: block;text-align: left;margin: 10px 0;">
                                                <strong>Código: </strong> <?php echo $objAnuncio->codigo ?>
                                            </div>    
                                        <?php } ?>  

                                        <?php if (isset($objAnuncio->garagem)&&$objAnuncio->garagem!='') { ?>
                                            <div style="display: block;text-align: left;margin: 10px 0;">
                                                <strong>Garagem: </strong> <?php echo $objAnuncio->garagem ?>
                                            </div>    
                                        <?php } ?>     

                                        <?php if (isset($objAnuncio->quarto)&&$objAnuncio->quarto!='') { ?>
                                            <div style="display: block;text-align: left;margin: 10px 0;">
                                                <strong>Quarto: </strong> <?php echo $objAnuncio->quarto ?>
                                            </div>    
                                        <?php } ?> 

                                        <?php if (isset($objAnuncio->banheiro)&&$objAnuncio->banheiro!='') { ?>
                                            <div style="display: block;text-align: left;margin: 10px 0;">
                                                <strong>Banheiro: </strong> <?php echo $objAnuncio->banheiro ?>
                                            </div>    
                                        <?php } ?>   

                                        <?php if (isset($objAnuncio->valor)&&$objAnuncio->valor>0) { ?>
                                            <div style="display: block;text-align: left;margin: 10px 0;">
                                                <strong>Valor: </strong> <?php echo 'R$'.number_format($objAnuncio->valor, 2, ',', '.'); ?>
                                            </div>    
                                        <?php } ?>                           
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
        $mail->FromName = 'NSPace';
        $mail->IsHTML(true);
    
        $mail->AddAddress($objAnuncio->Cliente->email);
        // $mail->AddAddress('phaael.paulo@gmail.com');
    
        $mail->Subject = 'Espaço aprovado';
        $mail->Body = $obContent;
        $mail->CharSet = 'utf-8';
        $mail->send();

    } catch (\Throwable $th) {
        echo $th;
    }
?>
