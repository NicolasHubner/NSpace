<div class="dashboard-wraper modelReservas">
    <div class="form-submit form-row">
      	<div class="form-group col-lg-12 col-md-12">
        	<h4>Gerenciar reservas</h4>
    	</div>      
    </div>

    <div class="listasReservas">
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Cód.</th>
                  <th scope="col">Cliente</th>
                  <th scope="col">Espaço reservado</th>
                  <th scope="col">Data entrada</th>
                  <th scope="col">Valor</th>
                  <th scope="col">Status</th>
                  <th scope="col">Açôes</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                    $where = 'status <> 0 and status <> 2 and a.cliente_id = '.$objCliente->id;
                    $retReserva = Doctrine_Query::create()->select()->from('Reserva r')->leftJoin('r.Anuncio a')->where($where)->orderBy('data_entrada ASC')->execute();
                    foreach ($retReserva as $objReserva) {
                        $reservaValidada = isset($objReserva->validacaoCodigo)&&$objReserva->validacaoCodigo==1?'<span class="UserValidate" title="Reserva validada!"><i class="fas fa-check-circle"></i></span>':'';
                        ?>
                            <tr>
                                <th><?php echo '#'.$objReserva->id?></th>
                                <th><?php echo $objReserva->Cliente->nome ?></th>
                                <th><a href="<?php echo URL.'painel/gr-reserva/?id='.$objReserva->id ?>" title="<?php echo $objReserva->Anuncio->titulo ?>"><?php echo substr($objReserva->Anuncio->titulo, 0, '25').'...' ?></a></th>
                                <th><?php echo date('d/m/Y', strtotime($objReserva->data_entrada)); ?></th>
                                <th><?php echo 'R$'.number_format($objReserva->valor_total, 2, ',', '.') ?></th>
                                <th>
                                    <?php if ($objReserva->status==0) { ?>
                                        Aguardando pagamento
                                    <?php } else if ($objReserva->status==1) { ?>
                                        Pagamento aprovado
                                    <?php } else if ($objReserva->status==2) { ?>
                                        Cancelado
                                    <?php } else  if ($objReserva->status==10) { ?>
                                        Reserva finalizada
                                    <?php }  ?>
                                </th>
                                <th>
                                    <div style="display: flex;">
                                        <?php echo $reservaValidada ?>

                                        <?php if (isset($objReserva->status)&&$objReserva->status==1) { ?>
                                            <?php if (isset($objReserva->validacaoCodigo)&&$objReserva->validacaoCodigo!=1) { ?>
                                                <a href="javascript:void(0);" class="validar-reserva" reserva-id='<?php echo $objReserva->id ?>' cliente-id='<?php echo $objReserva->cliente_id ?>' title="Validar reserva"><i class="fas fa-key"></i></a>
                                            <?php } ?>
                                        <?php } ?>

                                        <a class="button-actions mrg-10" href="<?php echo URL.'painel/gr-reserva/?id='.$objReserva->id ?>"><i class="fal fa-search"></i></a>
                                    </div>
                                </th>
                            </tr>
                        <?php 
                    }
                ?>
              </tbody>
            </table>
        </div>
    </div>

    <div class="modal modalValidarReserva" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Validação da reserva</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="formValidarReserva" id="form-validar-reserva">
                <div class="row">
                    <div class="col-md-12">
                        <label>Informe o código:</label>
                        <p>O código é enviado para o cliente após a confirmação da reserva no espaço.</p>
                        <input type="number" name="codigo" class="form-control validate[required]">
                    </div>                    
                </div><br>

                <input type="hidden" class="valReserva" name="reserva_id">
                <input type="hidden" class="valCliente" name="cliente_id">
                <input type="submit" class="btn btn-primary" value="Confirma">
            </form>
          </div>
        </div>
      </div>
    </div>
</div>