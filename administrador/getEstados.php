<?php

require('../lib/Config.php');

if (isset($_GET['ids'])){

    die(print_r($_GET['ids']));

	try {

		// Array de retorno
		$returnArray = array();

		// Busca
		$ret =	Doctrine_Query::create()->select()->from('Estado')
				->whereIn('pais_id', $_GET['pais_id'])->orderBy('nome ASC')->execute();

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

}