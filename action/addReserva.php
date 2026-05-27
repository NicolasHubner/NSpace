<?php
    include("../lib/Config.php");

    try {
        // print_r($_POST);
        // die();
        $valorTotal                              = Util::formata_valor($_POST['valor_total']);
        $data_saida                              = Util::dateConvert($_POST['data_saida']);
        $data_entrada                            = Util::dateConvert($_POST['data_entrada']);
        $horaEntrada                             = $_POST['horario_entrada'];
        $horaSaida                               = $_POST['horario_saida'];

        $objAnuncio                             = Doctrine_Core::getTable('Anuncio')->find($_POST['anuncio_id']);

        if (isset($_POST['tipo_cobranca_id'])&&$_POST['tipo_cobranca_id']==2) {
            $quantidadeDias               = $_POST['qtd_dias'];
        } else {
            $quantidadeDias                 = $_POST['hora_diferenca'];
        }

        if (isset($objAnuncio->periodo_minimo)&&$objAnuncio->periodo_minimo>0) {
            if ($quantidadeDias >= $objAnuncio->periodo_minimo) {
                if (isset($_POST['data_entrada'])&&$_POST['data_entrada']!='') {
                    if (isset($_POST['cliente_id'])&&$_POST['cliente_id']!='') {


                        $where = 'anuncio_id = '.$_POST['anuncio_id'];

                        if($_POST['tipo_cobranca_id']==2){
                            $where .= ' and data_entrada BETWEEN "'.$data_entrada.'" and "'.$data_saida.'" or data_saida BETWEEN "'.$data_entrada.'" and "'.$data_saida.'"';
                        } else if($_POST['tipo_cobranca_id']==1){
                            $where .= ' and data_entrada = "'.$data_entrada.'" and (horario_entrada BETWEEN "'.$horaEntrada.'" and "'.$horaSaida.'" or horario_saida BETWEEN "'.$horaEntrada.'" and "'.$horaSaida.'" and horario_saida <> "'.$horaEntrada.'" and data_entrada = "'.$data_entrada.'")';
                        }
                        $retReserva = Doctrine_Query::create()->select()->from('Reserva')->where($where)->orderBy('data_cadastro DESC')->execute();

                        if ($retReserva->count()>0) {

                            foreach ($retReserva as $attReserva) {
                                $objReserva                             = Doctrine_Core::getTable('Reserva')->find($attReserva->id);
                                if ($attReserva->status != 1) {
                                    $objReserva->status = 2;
                                    $objReserva->save();

                                    include('emails/email_cancelamento_reserva.php');
                                }
                            }

                            if ($retReserva[0]->status == 1) {
                                $retorno = array('status'=>'4');
                            } else {
                                $objReserva                         = new Reserva();
                                $objReserva->data_cadastro          = date('Y-m-d H:i:s');
                                $objReserva->data_entrada           = date('Y-m-d', strtotime($data_entrada));
                                $objReserva->data_saida             = date('Y-m-d', strtotime($data_saida));
                                if (isset($_POST['tipo_cobranca_id'])&&$_POST['tipo_cobranca_id']==2) {
                                    $objReserva->qtd_dias               = $_POST['qtd_dias'];
                                } else {
                                    $objReserva->hora_diferenca                 = $_POST['hora_diferenca'];
                                    $objReserva->horario_entrada                = $_POST['horario_entrada'];
                                    $objReserva->horario_saida                  = $_POST['horario_saida'];

                                }

                                $objReserva->anuncio_id             = $_POST['anuncio_id'];
                                $objReserva->cliente_id             = $_POST['cliente_id'];
                                $objReserva->valor_total            = (float)$valorTotal;
                                $objReserva->status                 = 0;

                                $objClienteAfiliado = Doctrine_Core::getTable('Cliente')->find($objReserva->Anuncio->cliente_id);

                                // Calculando o valor para o Cliente
                                $valor_cliente = $valorTotal * ($objConfiguracao->cent_cliente / 100);
                                $objReserva->valor_cliente            = (float)$valor_cliente;

                                if (isset($objClienteAfiliado->afiliado_id)&&$objClienteAfiliado->afiliado_id!='') {
                                    // Calculando o valor para o NSpace
                                    $valor_nspace = $valorTotal * ($objConfiguracao->cent_nspace / 100);
                                    $objReserva->valor_nspace            = (float)$valor_nspace;
                                } else {
                                    // Calculando o valor para o NSpace
                                    $valor_nspace = $valorTotal * (10 / 100);
                                    $objReserva->valor_nspace            = (float)$valor_nspace;
                                }

                                $objReserva->save();

                                 if (isset($objClienteAfiliado->afiliado_id)&&$objClienteAfiliado->afiliado_id!='') {
                                    if ($objReserva->Anuncio->cliente_id != $objClienteAfiliado->afiliado_id) {
                                        # Nessa parte estou salvando o afiliado que indicou o cliente.
                                        $objReserva->afiliado_id            = $objClienteAfiliado->afiliado_id;
                                        
                                        // Calculando o valor para o Afiliado
                                        $valor_afiliado = $valorTotal * ($objConfiguracao->cent_afiliado / 100);
                                        $objReserva->valor_afiliado            = (float)$valor_afiliado;
                                        $objReserva->save();
                                    }
                                } 

                                $CodigoReserva = date('md').$objReserva->id;
                                $objReserva->codigo                      = $CodigoReserva;
                                $objReserva->validacaoCodigo            = 0;
                                $objReserva->save();


                                unset($_SESSION['reserva']);

                                $retorno = array('status'=>'1', 'reserva_id'=>$objReserva->id);
                            }

                        } else {

                            $objReserva                         = new Reserva();
                            $objReserva->data_cadastro          = date('Y-m-d H:i:s');
                            $objReserva->data_entrada           = date('Y-m-d', strtotime($data_entrada));
                            $objReserva->data_saida             = date('Y-m-d', strtotime($data_saida));

                            if (isset($_POST['tipo_cobranca_id'])&&$_POST['tipo_cobranca_id']==2) {
                                $objReserva->qtd_dias               = $_POST['qtd_dias'];
                            } else {
                                $objReserva->hora_diferenca                 = $_POST['hora_diferenca'];
                                $objReserva->horario_entrada                = $_POST['horario_entrada'];
                                $objReserva->horario_saida                  = $_POST['horario_saida'];

                            }

                            $objReserva->anuncio_id             = $_POST['anuncio_id'];
                            $objReserva->cliente_id             = $_POST['cliente_id'];
                            $objReserva->valor_total            = (float)$valorTotal;
                            $objReserva->status                 = 0;

                            $objClienteAfiliado = Doctrine_Core::getTable('Cliente')->find($objReserva->Anuncio->cliente_id);

                            // Calculando o valor para o Cliente
                            $valor_cliente = $valorTotal * ($objConfiguracao->cent_cliente / 100);
                            $objReserva->valor_cliente            = (float)$valor_cliente;

                            if (isset($objClienteAfiliado->afiliado_id)&&$objClienteAfiliado->afiliado_id!='') {
                                // Calculando o valor para o NSpace
                                $valor_nspace = $valorTotal * ($objConfiguracao->cent_nspace / 100);
                                $objReserva->valor_nspace            = (float)$valor_nspace;
                            } else {
                                // Calculando o valor para o NSpace
                                $valor_nspace = $valorTotal * (10 / 100);
                                $objReserva->valor_nspace            = (float)$valor_nspace;
                            }

                            $objReserva->save();

                             if (isset($objClienteAfiliado->afiliado_id)&&$objClienteAfiliado->afiliado_id!='') {
                                if ($objReserva->Anuncio->cliente_id != $objClienteAfiliado->afiliado_id) {
                                    # Nessa parte estou salvando o afiliado que indicou o cliente.
                                    $objReserva->afiliado_id            = $objClienteAfiliado->afiliado_id;
                                    
                                    // Calculando o valor para o Afiliado
                                    $valor_afiliado = $valorTotal * ($objConfiguracao->cent_afiliado / 100);
                                    $objReserva->valor_afiliado            = (float)$valor_afiliado;
                                    $objReserva->save();
                                }
                            } 

                            $CodigoReserva = date('md').$objReserva->id;
                            $objReserva->codigo                      = $CodigoReserva;
                            $objReserva->validacaoCodigo            = 0;
                            $objReserva->save();


                            unset($_SESSION['reserva']);

                            $retorno = array('status'=>'1', 'reserva_id'=>$objReserva->id);

                        }
                       
                    } else {
                        $retorno = array('status'=>'2' , 'anuncio_id'=>$_POST['anuncio_id']);
                    }       
                } else {
                    $retorno = array('status'=>'3');
                }  
            } else {
                $retorno = array('status'=>'5', 'minimo_diaria'=>$objAnuncio->periodo_minimo);
            }
        } else {
           if (isset($_POST['data_entrada'])&&$_POST['data_entrada']!='') {
                if (isset($_POST['cliente_id'])&&$_POST['cliente_id']!='') {


                    $where = 'anuncio_id = '.$_POST['anuncio_id'];

                    if($_POST['tipo_cobranca_id']==2){
                        $where .= ' and data_entrada BETWEEN "'.$data_entrada.'" and "'.$data_saida.'" or data_saida BETWEEN "'.$data_entrada.'" and "'.$data_saida.'"';
                    } else if($_POST['tipo_cobranca_id']==1){
                        $where .= ' and data_entrada = "'.$data_entrada.'" and (horario_entrada BETWEEN "'.$horaEntrada.'" and "'.$horaSaida.'" or horario_saida BETWEEN "'.$horaEntrada.'" and "'.$horaSaida.'" and horario_saida <> "'.$horaEntrada.'" and data_entrada = "'.$data_entrada.'")';
                    }
                    $retReserva = Doctrine_Query::create()->select()->from('Reserva')->where($where)->orderBy('data_cadastro DESC')->execute();

                    if ($retReserva->count()>0) {

                        foreach ($retReserva as $attReserva) {
                            $objReserva                             = Doctrine_Core::getTable('Reserva')->find($attReserva->id);
                            if ($attReserva->status != 1) {
                                $objReserva->status = 2;
                                $objReserva->save();

                                include('emails/email_cancelamento_reserva.php');
                            }
                        }

                        if ($retReserva[0]->status == 1) {
                            $retorno = array('status'=>'4');
                        } else {
                            $objReserva                         = new Reserva();
                            $objReserva->data_cadastro          = date('Y-m-d H:i:s');
                            $objReserva->data_entrada           = date('Y-m-d', strtotime($data_entrada));
                            $objReserva->data_saida             = date('Y-m-d', strtotime($data_saida));
                            if (isset($_POST['tipo_cobranca_id'])&&$_POST['tipo_cobranca_id']==2) {
                                $objReserva->qtd_dias               = $_POST['qtd_dias'];
                            } else {
                                $objReserva->hora_diferenca                 = $_POST['hora_diferenca'];
                                $objReserva->horario_entrada                = $_POST['horario_entrada'];
                                $objReserva->horario_saida                  = $_POST['horario_saida'];

                            }

                            $objReserva->anuncio_id             = $_POST['anuncio_id'];
                            $objReserva->cliente_id             = $_POST['cliente_id'];
                            $objReserva->valor_total            = (float)$valorTotal;
                            $objReserva->status                 = 0;

                            $objClienteAfiliado = Doctrine_Core::getTable('Cliente')->find($objReserva->Anuncio->cliente_id);

                            if (isset($objClienteAfiliado->afiliado_id)&&$objClienteAfiliado->afiliado_id!='') {
                                // Calculando o valor para o Cliente
                                $valor_cliente = $valorTotal * (90 / 100);
                                $objReserva->valor_cliente            = (float)$valor_cliente;
                            } else {
                                // Calculando o valor para o Cliente
                                $valor_cliente = $valorTotal * (91 / 100);
                                $objReserva->valor_cliente            = (float)$valor_cliente;
                            }

                            // Calculando o valor para o NSpace
                            $valor_nspace = $valorTotal * (9 / 100);
                            $objReserva->valor_nspace            = (float)$valor_nspace;
                            
                            $objReserva->save();

                             if (isset($objClienteAfiliado->afiliado_id)&&$objClienteAfiliado->afiliado_id!='') {
                                if ($objReserva->Anuncio->cliente_id != $objClienteAfiliado->afiliado_id) {
                                    # Nessa parte estou salvando o afiliado que indicou o cliente.
                                    $objReserva->afiliado_id            = $objClienteAfiliado->afiliado_id;
                                    
                                    // Calculando o valor para o Afiliado
                                    $valor_afiliado = $valorTotal * (1 / 100);
                                    $objReserva->valor_afiliado            = (float)$valor_afiliado;
                                    $objReserva->save();
                                }
                            } 

                            $CodigoReserva = date('md').$objReserva->id;
                            $objReserva->codigo                      = $CodigoReserva;
                            $objReserva->validacaoCodigo            = 0;
                            $objReserva->save();


                            unset($_SESSION['reserva']);

                            $retorno = array('status'=>'1', 'reserva_id'=>$objReserva->id);
                        }

                    } else {

                        $objReserva                         = new Reserva();
                        $objReserva->data_cadastro          = date('Y-m-d H:i:s');
                        $objReserva->data_entrada           = date('Y-m-d', strtotime($data_entrada));
                        $objReserva->data_saida             = date('Y-m-d', strtotime($data_saida));
                        if (isset($_POST['tipo_cobranca_id'])&&$_POST['tipo_cobranca_id']==2) {
                            $objReserva->qtd_dias               = $_POST['qtd_dias'];
                        } else {
                            $objReserva->hora_diferenca                 = $_POST['hora_diferenca'];
                            $objReserva->horario_entrada                = $_POST['horario_entrada'];
                            $objReserva->horario_saida                  = $_POST['horario_saida'];

                        }

                        $objReserva->anuncio_id             = $_POST['anuncio_id'];
                        $objReserva->cliente_id             = $_POST['cliente_id'];
                        $objReserva->valor_total            = (float)$valorTotal;
                        $objReserva->status                 = 0;

                        $objClienteAfiliado = Doctrine_Core::getTable('Cliente')->find($objReserva->Anuncio->cliente_id);

                        if (isset($objClienteAfiliado->afiliado_id)&&$objClienteAfiliado->afiliado_id!='') {
                            // Calculando o valor para o Cliente
                            $valor_cliente = $valorTotal * (90 / 100);
                            $objReserva->valor_cliente            = (float)$valor_cliente;
                        } else {
                            // Calculando o valor para o Cliente
                            $valor_cliente = $valorTotal * (91 / 100);
                            $objReserva->valor_cliente            = (float)$valor_cliente;
                        }

                        // Calculando o valor para o NSpace
                        $valor_nspace = $valorTotal * (9 / 100);
                        $objReserva->valor_nspace            = (float)$valor_nspace;
                        
                        $objReserva->save();

                         if (isset($objClienteAfiliado->afiliado_id)&&$objClienteAfiliado->afiliado_id!='') {
                            if ($objReserva->Anuncio->cliente_id != $objClienteAfiliado->afiliado_id) {
                                # Nessa parte estou salvando o afiliado que indicou o cliente.
                                $objReserva->afiliado_id            = $objClienteAfiliado->afiliado_id;
                                
                                // Calculando o valor para o Afiliado
                                $valor_afiliado = $valorTotal * (1 / 100);
                                $objReserva->valor_afiliado            = (float)$valor_afiliado;
                                $objReserva->save();
                            }
                        } 

                        $CodigoReserva = date('md').$objReserva->id;
                        $objReserva->codigo                      = $CodigoReserva;
                        $objReserva->validacaoCodigo            = 0;
                        $objReserva->save();

                        unset($_SESSION['reserva']);

                        $retorno = array('status'=>'1', 'reserva_id'=>$objReserva->id);

                    }
                   
                } else {
                    $retorno = array('status'=>'2' , 'anuncio_id'=>$_POST['anuncio_id']);
                }       
            } else {
                $retorno = array('status'=>'3');
            }   

        }

     

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>