<?php
require('../../../lib/Config.php');

// echo "a";
// ini_set('display_errors', 'On');
ini_set('memory_limit',-1);
#ini_set('execution_time',-1);
ini_set('max_execution_time', 300);

try {

	// Abre o arquivo CSV

	$name = 'newsletter.csv';

	$file = fopen($name, 'w');	

	// Monta o cabeçalho

	$line[] = 'Nome';
	$line[] = 'E-mail';
	

	// Seleciona as características para concluir o cabeçalho

	$ret = Doctrine_Core::getTable('Newsletter')->findAll();
	

	// Gera o cabeçalho

	fputcsv($file, $line, ';');
	

		$res = $ret->toArray();

		foreach ($res as $value){			
			$line = array();

			// Monta a linha de dados

			$line[]	= $value['nome']!=''?$value['nome']:'-';	
			$line[]	= $value['email']!=''?$value['email']:'-';	

			fputcsv($file, $line, ';');

		}	

	// Fecha o arquivo
	fclose($file);	

	// Força o download

	header ("Content-Disposition: attachment; filename=".$name."");

	header ("Content-Type: application/csv");

	header ("Content-Length: ".filesize($name));

	readfile($name);


} catch(Exception $e){

	echo $e;

	// Tratamento de retorno

	$_SESSION['return_type'] 	= 'error';

	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';



	// Redirecionamento para a página principal do módulo

	header('Location: '.URL_ADMIN.$_GET['model'].'/');

}



?>