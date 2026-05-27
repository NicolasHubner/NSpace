<?php

require('../lib/Config.php');

if (isset($_GET['termo'])){

	try {

		// Array de retorno
		$returnArray = array();

		$where = "nome like '%".$_GET['termo']."%'";

		// Busca
		$ret =	Doctrine_Query::create()->select()->from('Cidade')
				->where($where)->orderBy('nome ASC')->execute();

		// Tratamento dos dados
		if ($ret->count() > 0){
			$res = $ret->toArray();
			
			foreach ($res as $value){
				$objEstado = Doctrine_Core::getTable('Estado')->find($value['estado_id']);

				$resultado[] = array(
					'cidade'=>$value['nome'],
					'cidade_id'=>$value['id'],
					'estado_sigla'=>$objEstado->sigla,
					'estado_id'=>$value['estado_id']
				);
			}
		}

		echo json_encode($resultado);

	} catch(Exception $e){

		echo json_encode($resultado);

	}

}