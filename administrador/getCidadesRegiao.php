<?php

require('../lib/Config.php');

if (isset($_GET['estado_id'])){

	try {

		// Array de retorno
		$returnArray = array();

		// Busca
		$ret =	Doctrine_Query::create()->select()->from('Cidade')
				->whereIn('estado_id', $_GET['estado_id'])->orderBy('
				CASE WHEN 
						nome = "Belo Horizonte" || nome = "Rio Branco" || nome = "Maceió"
						|| nome = "Macapá" || nome = "Manaus" || nome = "Salvador" || nome = "Fortaleza"
						|| nome = "Brasília" || nome = "Vitória" || nome = "Goiânia"
						|| nome = "São Luís" || nome = "Cuiabá" || nome = "Campo Grande"
						|| nome = "João Pessoa" || nome = "Belém"  || nome = "Curitiba" || nome = "Recife"
						|| nome = "Teresina" || nome = "Rio de Janeiro" || nome = "Natal"
						|| nome = "Porto Alegre" || nome = "Porto Velho" || nome = "Boa Vista"
						|| nome = "Florianópolis" || nome = "São Paulo" || nome = "Aracaju" || nome = "Palmas"
				THEN 1 ELSE 2 END, nome ASC')->execute();

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