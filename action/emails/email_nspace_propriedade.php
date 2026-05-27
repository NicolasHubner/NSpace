<?php
    // include("../../lib/Config.php");
    ob_start();

    // $objAnuncio     = Doctrine_Core::getTable('Anuncio')->find(115);
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
                                            style="color: #fe5000;">NSPACE</span>,</h4>
                                    <p style="margin: 0px 0px 10px;">Você recebeu um novo cadastro de propriedade no portal, segue abaixo os dados:</p>

                                    <div style="margin-top: 30px; text-align: left;">
                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Data de cadastro:</label> <?php echo date('d/m/Y', strtotime($objAnuncio->data_cadastro)) ?>
                                        </div>  

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Espaço:</label> <?php echo $objAnuncio->titulo ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Local próprio?</label> <?php echo isset($objAnuncio->local_proprio)&&$objAnuncio->local_proprio==1?'Sim':'Não' ?>
                                        </div>

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Categoria:</label> <?php echo $objAnuncio->Categoria->nome ?>
                                        </div>   
                                        
                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Tipo de cobrança:</label> <?php echo $objAnuncio->TipoCobranca->nome ?>
                                        </div>   

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Espaço:</label> <?php echo $objAnuncio->espaco ?>
                                        </div> 
                                        
                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Limite de pessoas:</label> <?php echo $objAnuncio->limite_pessoas ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Código:</label> <?php echo $objAnuncio->codigo ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Garagem:</label> <?php echo $objAnuncio->garagem ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Quarto:</label> <?php echo $objAnuncio->quarto ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Banheiro:</label> <?php echo $objAnuncio->banheiro ?>
                                        </div>
                                        
                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Descrição:</label> <?php echo $objAnuncio->descricao ?>
                                        </div>
                                        
                                    </div> 

                                    <div style="margin-top: 30px; text-align: left;">
                                        <h4 style="margin-bottom: 10px;">Endereço</h4>

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">CEP:</label> <?php echo $objAnuncio->cep ?>
                                        </div>
                                        
                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Rua/Av:</label> <?php echo $objAnuncio->logradouro ?>
                                        </div>

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Nº:</label> <?php echo $objAnuncio->numero ?>
                                        </div>

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Complemento:</label> <?php echo $objAnuncio->complemento ?>
                                        </div>

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Bairro:</label> <?php echo $objAnuncio->bairro ?>
                                        </div>

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Estado:</label> <?php echo $objAnuncio->Cidade->nome.'/'.$objAnuncio->Estado->sigla ?>
                                        </div>
                                    </div>

                                    <?php if (isset($objAnuncio->plano_id)&&$objAnuncio->plano_id!='') { ?>
                                        <div style="margin-top: 30px; text-align: left;">
                                            <h4 style="margin-bottom: 10px;">Plano</h4>

                                            <div style="display: block; margin-bottom: 10px;">
                                                <label style="font-weight: 600;color: #000;">Nome do plano:</label> <?php echo $objAnuncio->Plano->nome ?>
                                            </div>

                                            <div style="display: block; margin-bottom: 10px;">
                                                <label style="font-weight: 600;color: #000;">Valor:</label> <?php echo 'R$'.number_format($objAnuncio->Plano->valor, 2, ',', '.') ?>
                                            </div>
                                        </div>
                                    <?php } ?>
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
    
        $mail->AddAddress('administrativo@nspace.com.br');
        // $mail->AddAddress('phaael.paulo@gmail.com');
    
        $mail->Subject = 'Novo espaço - Via portal';
        $mail->Body = $obContent;
        $mail->CharSet = 'utf-8';
        $mail->send();

    } catch (\Throwable $th) {
        echo $th;
    }
?>
