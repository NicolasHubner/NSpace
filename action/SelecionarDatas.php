<?php 
	include("../lib/Config.php");
	
	try {

		unset($_SESSION['reserva']);

		$data_entrada = $_POST['data_entrada'];

		if(isset($_POST['tipo_cobranca_id'])&&$_POST['tipo_cobranca_id']==2) {
			// Validação para cobrança por Dia

			$data_saida = $_POST['data_saida'];
	 
			if (strtotime($data_saida) > strtotime($data_entrada)) {
				$_SESSION['reserva']['data_entrada'] 			= date("d/m/Y", strtotime($_POST['data_entrada']));
				$_SESSION['reserva']['data_saida'] 			= date("d/m/Y", strtotime($_POST['data_saida']));;
				$_SESSION['reserva']['tipo_cobranca_id'] 			= $_POST['tipo_cobranca_id'];
				

			 	$dataEntrada = str_replace("/", "-", $_SESSION['reserva']['data_entrada']);
	            $dataSaida = str_replace("/", "-", $_SESSION['reserva']['data_saida']);
	            $TotalDias = Util::diasDatas(date('Y-m-d', strtotime($dataEntrada)), date('Y-m-d', strtotime($dataSaida)));

				$retorno = array(
					'status'=>'1',
					'tipo_cobranca_id'=>$_POST['tipo_cobranca_id'],
					'data_entrada'=>$_SESSION['reserva']['data_entrada'],
					'data_saida'=>$_SESSION['reserva']['data_saida'],
					'totalDiarias'=>$TotalDias
				);
			} else {
				$retorno = array('status'=>'2', 'mensagem'=>'A data de saída tem que maior que a de entrada.');
			}
		} else {


			$_POST['tipo_cobranca_id'] = 1;
			// Validação para cobrança por Hora

			$_SESSION['reserva']['data_entrada'] 				= date("d/m/Y", strtotime($_POST['data_entrada']));
			$_SESSION['reserva']['data_saida'] 					= date("d/m/Y", strtotime($_POST['data_saida']));
			$_SESSION['reserva']['horario_entrada'] 			= $_POST['horario_entrada'];
	        $_SESSION['reserva']['horario_saida'] 				= $_POST['horario_saida'];
			$_SESSION['reserva']['tipo_cobranca_id'] 			= $_POST['tipo_cobranca_id'];
	        $horaEntrada = str_replace(':00', '', $_POST['horario_entrada']);
	        $horaSaida = str_replace(':00', '', $_POST['horario_saida']);

	        $date1 = new DateTime(date("Y-m-d", strtotime($_POST['data_entrada'])).'T'.$horaEntrada.':00:00');
			$date2 = new DateTime(date("Y-m-d", strtotime($_POST['data_saida'])).'T'.$horaSaida.':00:00');

			$diff = $date2->diff($date1);

			$diferencaHora = $diff->h;
			$diferencaHora = $diferencaHora + ($diff->days*24);

	        $_SESSION['reserva']['horario_diferenca'] 				= $diferencaHora;

			$retorno = array(
				'status'=>'1',
				'tipo_cobranca_id'=>$_POST['tipo_cobranca_id'],
				'data_entrada'=>$_SESSION['reserva']['data_entrada'],
				'data_saida'=>$_SESSION['reserva']['data_saida'],
				'horario_entrada'=>$_SESSION['reserva']['horario_entrada'],
				'horario_saida'=>$_SESSION['reserva']['horario_saida'],
				'horas_diferenca'=>$diferencaHora
			);
		}

	} catch (\Throwable $th) {
		$retorno = array('status'=>$th);
	}

	echo json_encode($retorno);
?>