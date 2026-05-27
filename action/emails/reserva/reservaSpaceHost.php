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
                                            style="color: #fe5000;"><?php echo $objReserva->Anuncio->Cliente->apelido ?></span>,</h4>
                                    <p style="margin: 0px 0px 10px;">Espaço reservado com sucesso, segue abaixo os dados:</p>

                                    <div style="margin-top: 30px; text-align: left;">
                                        <label style="margin-bottom: 15px; display: block;">Dados da reserva:</label>

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Data da reserva:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_cadastro)) ?>
                                        </div>  

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Data de entrada:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_entrada)) ?>
                                        </div>  

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Data de saída:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_saida)) ?>
                                        </div>  
                                        
                                        <?php if (isset($objReserva->Anuncio->tipo_cobranca_id)&&$objReserva->Anuncio->tipo_cobranca_id==2) { ?>
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

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Valor da reserva:</label> <?php echo 'R$'.number_format($objReserva->valor_total, 2, ',', '.') ?>
                                        </div>                                      
                                    </div>

                                    <div style="margin-top: 30px; text-align: left;">
                                        <label style="margin-bottom: 15px; display: block;">Dados do anúncio:</label>

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Espaço:</label> <?php echo $objReserva->Anuncio->titulo ?>
                                        </div>  

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Espaço:</label> <?php echo $objReserva->Anuncio->espaco.' m²' ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <?php 
                                                $limite_pessoas = isset($objReserva->Anuncio->limite_pessoas)&&$objReserva->Anuncio->limite_pessoas>1?' pessoas':'pessoa';
                                            ?>
                                            <label style="font-weight: 600;color: #000;">Limite de pessoas:</label> <?php echo $objReserva->Anuncio->limite_pessoas.' '.$limite_pessoas ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <?php 
                                                $garagem = isset($objReserva->Anuncio->garagem)&&$objReserva->Anuncio->garagem>1?' garagens':'garagen';
                                            ?>
                                            <label style="font-weight: 600;color: #000;">Garagem:</label> <?php echo $objReserva->Anuncio->garagem.' '.$garagem ?>
                                        </div>

                                        <div style="display: block; margin-bottom: 10px;">
                                            <?php 
                                                $quarto = isset($objReserva->Anuncio->quarto)&&$objReserva->Anuncio->quarto>1?' quartos':'quarto';
                                            ?>
                                            <label style="font-weight: 600;color: #000;">Quartos:</label> <?php echo $objReserva->Anuncio->quarto.' '.$quarto ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <?php 
                                                $banheiro = isset($objReserva->Anuncio->banheiro)&&$objReserva->Anuncio->banheiro>1?' banheiros':'banheiro';
                                            ?>
                                            <label style="font-weight: 600;color: #000;">Banheiros:</label> <?php echo $objReserva->Anuncio->banheiro.' '.$banheiro ?>
                                        </div>  

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Código:</label> <?php echo $objReserva->Anuncio->codigo ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Cep:</label> <?php echo $objReserva->Anuncio->cep ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Rua/Av:</label> <?php echo $objReserva->Anuncio->logradouro ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Nº:</label> <?php echo $objReserva->Anuncio->numero ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Complemento:</label> <?php echo $objReserva->Anuncio->complemento ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Bairro:</label> <?php echo $objReserva->Anuncio->bairro ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Bairro:</label> <?php echo $objReserva->Anuncio->bairro ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Cidade/Estado:</label> <?php echo $objReserva->Anuncio->Cidade->nome.'/'.$objReserva->Anuncio->Estado->sigla ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Valor da reserva:</label> <?php echo 'R$'.number_format($objReserva->Anuncio->valor, 2, ',', '.').' /'.$objReserva->Anuncio->TipoCobranca->nome ?>
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Opcionais:</label> 
                                            <?php 
                                                $retAnuncioOpcional = Doctrine_Query::create()->select()->from('AnuncioOpcional')->where('anuncio_id = '.$objReserva->anuncio_id)->execute();
                                                foreach ($retAnuncioOpcional as $objAnuncioOpcional) {
                                                    echo $objAnuncioOpcional->Opcional->nome.', ';
                                                }
                                            ?>      
                                        </div> 

                                        <div style="display: block; margin-bottom: 10px;">
                                            <label style="font-weight: 600;color: #000;">Descrição:</label> <?php echo $objReserva->Anuncio->descricao ?>
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
    
        $mail->Subject = 'Nova reserva';
        $mail->Body = $obContent;
        $mail->CharSet = 'utf-8';
        $mail->send();

    } catch (\Throwable $th) {
        echo $th;
    }
?>
