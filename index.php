<?php
  	include('lib/Config.php');
  	ob_start();

	if (isset($_GET['codigoAfiliado'])&&$_GET['codigoAfiliado']!='') {
		$_SESSION['codigoAfiliado'] = $_GET['codigoAfiliado'];
	}

	// Notificações de status pagamento Pagseguro
	// 0 Aguardando pagamento
	// 1 Pagamento aprovado
	// 2 Cancelado
	// 10 Finalizado
	// echo $_SESSION['userData']['id'].'<br>';
	// echo $_SESSION['userData']['first_name'].'<br>';
	// echo $_SESSION['userData']['last_name'].'<br>';
	// echo $_SESSION['userData']['email'].'<br>';
?>
	
	<?php include('include/slider.php') ?>
	<?php include('inicio/top_anuncios.php') ?>
	<?php include('inicio/locais_em_alta.php') ?>
	<?php include('inicio/anuncios_recentes.php') ?>
	<?php include('inicio/depoimento.php') ?>
	<?php include('inicio/ultimos_artigos.php') ?>
	<?php include('inicio/chamada.php') ?>


	 <div class="modal fade ModalDateSelect" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="tituloModal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                  <span aria-hidden="true">&times;</span>
                </button>
                <?php 
                    $dataEntrada = str_replace("/", "-", $_SESSION['reserva']['data_entrada']);
                    $dataSaida = str_replace("/", "-", $_SESSION['reserva']['data_saida']);
                ?>
                <h5 class="modal-title" id="exampleModalLabel">Selecione as datas</h5>
            </div>

            <form class="formDates" id="formulario-data">
            	<div class="row mb-10">
            		<div class="col-md-12">
            			<label style="color: #000; margin-right: 15px;"><input type="radio" name="tipo_cobranca_id" value="2" checked> Dia</label>
            			<label style="color: #000;"><input type="radio" name="tipo_cobranca_id" value="1"> Hora</label>
            		</div>
            	</div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Data de entrada:</label>
                            <div class="input-with-icon b-l">
                                <input type="date" class="form-control validate[required] plf-padrao" placeholder="Data" name="data_entrada" value="<?php echo isset($_SESSION['reserva']['data_entrada'])&&$_SESSION['reserva']['data_entrada']!=''?date('Y-m-d', strtotime($dataEntrada)):'' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 ds001">
                    	<div class="form-group">
                    		<label>Horário de entrada:</label>
                    		<div class="input-with-icon b-l">
                    			<select class="form-control" name="horario_entrada" id="horario_entrada">
                    				<?php 
                    				for ($horaEntrada=1; $horaEntrada <=23 ; $horaEntrada++) { 
                    					?>
                    					<option value="<?php echo str_pad($horaEntrada, 2, '0', STR_PAD_LEFT).':00' ?>" <?php echo isset($_SESSION['reserva']['horario_entrada'])&&$_SESSION['reserva']['horario_entrada']==str_pad($horaEntrada, 2, '0', STR_PAD_LEFT).':00'?'selected':'' ?>><?php echo str_pad($horaEntrada, 2, '0', STR_PAD_LEFT).':00' ?></option>
                    					<?php
                    				}
                    				?>
                    			</select>
                    		</div>
                    	</div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Data de saída:</label>
                            <div class="input-with-icon b-l">
                                <input type="date" class="form-control validate[required] plf-padrao" placeholder="Data" name="data_saida" value="<?php echo isset($_SESSION['reserva']['data_saida'])&&$_SESSION['reserva']['data_saida']!=''?date('Y-m-d', strtotime($dataSaida)):'' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 ds001">
                    	<div class="form-group">
                    		<label>Horário de saída:</label>
                    		<div class="input-with-icon b-l">
                    			<select class="form-control" name="horario_saida" id="horario_saida">
                    				<option value="">Selecione</option>
                    				<?php 
                    				for ($horaSaida=1; $horaSaida <=23 ; $horaSaida++) { 
                    					?>
                    					<option value="<?php echo str_pad($horaSaida, 2, '0', STR_PAD_LEFT).':00' ?>" <?php echo isset($_SESSION['reserva']['horario_saida'])&&$_SESSION['reserva']['horario_saida']==str_pad($horaSaida, 2, '0', STR_PAD_LEFT).':00'?'selected':'' ?>><?php echo str_pad($horaSaida, 2, '0', STR_PAD_LEFT).':00' ?></option>
                    					<?php
                    				}
                    				?>
                    			</select>
                    		</div>
                    	</div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" class="selecionarDatas" value="Selecionar datas">
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
	
<?php
  	$obContent = ob_get_contents();
  	ob_end_clean();
  	include('base.php');
?>
<script type="text/javascript" src="<?php echo URL ?>assets/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>

<script type="text/javascript">
	$('#selecionar-data').click(function() {
		$('.ModalDateSelect').modal();
	});

	$('.dataJaSelecionada').click(function() {
		$('.ModalDateSelect').modal();
	});

	$('.formDates').validationEngine({
        scroll: false
    });
    $('.formDates').submit(function(e) {
        e.preventDefault();
        if ($(this).validationEngine('validate')) {

            var formulario = document.getElementById('formulario-data');
            var formData = new FormData(formulario);


            $.ajax({
                url: URL_SITE + 'action/SelecionarDatas.php',
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.status == 1) {
                    	$('.ModalDateSelect').modal('hide');
                    	$('.hero-search-content .SelecDate').css('display','none');
                    	$('.hero-search-content .dataJaSelecionada').css('display','block');
                    	
                    	function dataAtualFormatada(){
						    let data = new Date(),
						        dia  = data.getDate().toString().padStart(2, '0'),
						        mes  = (data.getMonth()+1).toString().padStart(2, '0'),
						        ano  = data.getFullYear();
						    return `${dia}/${mes}/${ano}`;
						}

                    	if (response.tipo_cobranca_id == 2) {
	                    	$('.hero-search-content #dataEntrada').html(response.data_entrada);
	                    	$('.hero-search-content #dataSaida').html(response.data_saida);
	                    	$('.hero-search-content #TotalDias').html(response.totalDiarias);


                    	} else if (response.tipo_cobranca_id == 1) {
                    		$('.hero-search-content #dataEntrada').html(response.data_entrada);
                    		$('.hero-search-content .horario_entrada').html(response.horario_entrada);
                    		$('.hero-search-content .horario_saida').html(response.horario_saida);
                    	}
                    	// $('.hero-search-content #dataEntradaHorario').html(response.data_entrada_horario);

                    	// $('.hero-search-content #dataSaidaHorario').html(response.data_saida_horario);
						location.reload();

                    } else if (response.status == 2 && response.mensagem !='') {
                    	Lobibox.notify('error', {
	                      delay: 6000,
	                      position: "top right", 
	                      title: 'Algo de errado',
	                      dataType: "json",
	                      icon: true,
	                      msg: response.mensagem
	                    });
                    }
                }
            });
        }
    });

    $('#cidade-search').autocomplete({
		minLength: 1,
		autoFocus: true,
		delay: 300,
		position: {
			my: 'left top',
			at: 'right top'
		},
		appendTo: '#form',
		source: function(request, response){
			$.ajax({
				url: URL_SITE+'action/autocompleteCidade.php',
				type: 'get',
				dataType: 'html',
				data: {
					'termo': request.term
				}
			}).done(function(data){
				$('.hero-search-radius .AutoComplete').css('display', 'block');

				var resultados = JSON.parse(data);
				var options = '';    
                for (var i = 0; i < resultados.length; i++){
                    options += '<div class="singleItem selecionarlocalizacao" estado_id="'+resultados[i].estado_id+'" estado_sigla="'+resultados[i].estado_sigla+'"  cidade="'+resultados[i].cidade+'"  cidade_id="'+resultados[i].cidade_id+'"><i class="fal fa-map-marker"></i> ' + resultados[i].cidade + '/'+resultados[i].estado_sigla+ '</div>';
                }   

                $('#listaCidades').html(options);

                $('.selecionarlocalizacao').click(function(e) {
					$('.hero-search-radius .AutoComplete').css('display', 'none');

					$('.hero-search-radius #cidade_id').val($(this).attr('cidade_id'));
					$('.hero-search-radius #estado_id').val($(this).attr('estado_id'));

					$('.hero-search-radius #cidade-search').val($(this).attr('cidade')+'/'+$(this).attr('estado_sigla'));
				});
			});
		}
	});

	$("input[name='tipo_cobranca_id']").change(function() {
		tipoCobranca = $(this).val();

		if (tipoCobranca == 2) {
			$('.formDates .ds002').css('display', 'block')
			$('.formDates .ds001').css('display', 'none')
		} else {
			$('.formDates .ds001').css('display', 'block')
			$('.formDates .ds002').css('display', 'none')
		}

		$('#tipo_cobranca_id').val(tipoCobranca);
	});

</script>
