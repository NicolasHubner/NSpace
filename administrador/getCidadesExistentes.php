<?php

require('../lib/Config.php');

if (isset($_GET['estado_id'])){

	try {

		// Array de retorno
		$returnArray = array();

		$where = 'estado_id = '.$_GET['estado_id'].' and c.id in (select cidade_id from imovel group by cidade_id)';

		// Busca
		$ret =	Doctrine_Query::create()->select()->from('Cidade c')
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

}