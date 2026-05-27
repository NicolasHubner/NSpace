<?php

require('../lib/Config.php');



	try {

		// Array de retorno
		$returnArray = array();

		$where = 'cidade_id = '.$_GET['cidade_id'];
		
		// Busca
		$ret =	Doctrine_Query::create()->select()->from('Bairro')
				->where($where)->orderBy('nome ASC')->execute();

		// Tratamento dos dados
		if ($ret->count() > 0){
			// Transforma os dados em Array
			$res = $ret->toArray();

			foreach ($res as $value){
				// Retorno
				$returnArray[] = $value;
			}
		}

		echo json_encode($returnArray);

	} catch(Exception $e){

		echo json_encode($returnArray);

	}

