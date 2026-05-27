<?php

/**
 * Configurações e definições para o funcionamento do sistema
 */

@session_start();

// Título Padrão




// Configura o nível de report e display dos erros
error_reporting(E_ERROR);
ini_set('display_errors', 'On');

// Definição de língua em datas
setlocale(LC_ALL, 'pt_BR.UTF8', 'ptb');

// Define o time zone
date_default_timezone_set('Brazil/East');

// Status
$_STATUS = array(
	0 => 'Inativo',
	1 => 'Ativo'
	// 2 => 'Pendente',
	// 3 => 'Suspenso'
);

// Definição de PATH, URL, Acesso a Banco de Dados e SMTP (De acordo com o Servidor)
if(@is_dir('/home/nspaceco/public_html/') && getenv('NSPACE_LOCAL_DEV')){

	define('PATH', '/home/nspaceco/public_html/');
	define('URL', 'http://localhost:8080/');
	define('CHARSET', 'utf-8');

	define('DB_SGBD', 'mysql');
	define('DB_HOST', '127.0.0.1');
	define('DB_USER', 'nspaceco_usuario');
	define('DB_PSWD', 'usuario02320br');
	define('DB_NAME', 'nspaceco_banco');
	define('DB_CHAR', 'utf8');

	define('SMTP_HOST', 'localhost');
	define('SMTP_PORT', '587');
	define('SMTP_USER', '');
	define('SMTP_PSWD', '');
	define('SMTP_FROM', 'dev@localhost');
	define('SMTP_FNAME','DEV');

} else if(@is_dir('C:/xampp/htdocs/Clientes/nspace/Site/')){

	// PATH, URL e CHARSET
	define('PATH', 'C:/xampp/htdocs/Clientes/nspace/Site/');
	define('URL', 'http://localhost:8080/Clientes/nspace/Site/');
	define('CHARSET', 'utf-8');

	// Banco de Dados
	define('DB_SGBD', 'mysql');
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PSWD', '');
	define('DB_NAME', 'nspace');
	define('DB_CHAR', 'utf8');

	// SMTP
	define('SMTP_HOST', 'mail.acessoweb.com');
	define('SMTP_PORT', '587');
	define('SMTP_USER', 'envio@acessoweb.com');
	define('SMTP_PSWD', 'env02320');
	define('SMTP_FROM', 'envio@acessoweb.com.br');
	define('SMTP_FNAME','QMI');

} else if(@is_dir('/home/nspaceco/public_html/')){

	// echo	substr($_SERVER['SERVER_NAME'],0,3);


	if (substr($_SERVER['SERVER_NAME'],0,3)!='www') {
		header("HTTP/1.0 301 Moved Permanently");
		header("Location: https://www.".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		header("Connection: close");
		exit();
	}

	// PATH, URL e CHARSET
	define('PATH', '/home/nspaceco/public_html/');
	define('URL', 'https://www.nspace.com.br/');
	define('CHARSET', 'utf-8');

	// Banco de Dados
	define('DB_SGBD', 'mysql');
	define('DB_HOST', 'localhost');
	define('DB_USER', 'nspaceco_usuario');
	define('DB_PSWD', 'usuario02320br');
	define('DB_NAME', 'nspaceco_banco');
	define('DB_CHAR', 'utf8');


	// SMTP
	define('SMTP_HOST', 'mail.acessoweb.com');
	define('SMTP_PORT', '587');
	define('SMTP_USER', 'envio@acessoweb.com');
	define('SMTP_PSWD', 'env02320');
	define('SMTP_FROM', 'envio@acessoweb.com.br');
	define('SMTP_FNAME','QMI');

} else {
	
	exit('Sistema indisponível!');

}

// session_destroy();
// Requisição do arquivo de PATH's e URL's
require(PATH.'lib/Path.php');

// Wide Image
require(PATH.'lib/WideImage/WideImage.php');

// Bootstrap Doctrine
require(PATH.'bootstrap.php');

// Cálculo de Frete
require(PATH.'lib/RsCorreios.php');

// Funções Úteis
require(PATH.'lib/Util.php');

// PHPMailer
require(PATH.'lib/PHPMailer/class.phpmailer.php');

// Autoload do Facebook
require(PATH.'lib/Facebook/autoload.php');

// Autoload do composer
require(PATH.'vendor/autoload.php');


$FBObject = new \Facebook\Facebook([
	'app_id' => '1043030239801861',
	'app_secret' => 'a7538b753cfc53e75b845e0e21e4f2ee',
	'default_graph_version' => 'v12.0'
]);

$handler = $FBObject -> getRedirectLoginHelper();


$objConfiguracao = Doctrine_Core::getTable('Configuracao')->find(1);
$objRedeSocial = Doctrine_Core::getTable('RedeSocial')->find(1);
define('TITLE_DEFAULT', $objConfiguracao->nome);

if ($objConfiguracao->possui_unidade == 0) {
	$contato_localizacao = $objConfiguracao->Cidade->nome.'/'.$objConfiguracao->Estado->sigla;
	$contato_whatsapp = $objConfiguracao->whatsapp;
	$contato_telefone = $objConfiguracao->telefone;
} else {
	$objUnidadeMatriz = Doctrine_Core::getTable('Unidade')->findOneByTipo('Matriz');
	if ($objUnidadeMatriz->count()>0) {
		$contato_localizacao = $objUnidadeMatriz->Cidade->nome.'/'.$objUnidadeMatriz->Estado->sigla;
		$contato_whatsapp = $objUnidadeMatriz->whatsapp;
		$contato_telefone = $objUnidadeMatriz->telefone;
	}
}


$pagseguroAmbiente = "producao";

if($pagseguroAmbiente=='producao'){

	define('EMAIL_PAGSEGURO', 'fabianojunioor@hotmail.com');
	define('TOKEN__PAGSEGURO', 'b8e7da2b-9bfc-4317-a5c0-06d38b097fc6b7fb917143e89e987af054ef4e31cb99358f-f8e9-441b-9644-d0683f67103d');
	
	define('API_PAGSEGURO', 'nspacepagamento');
	define('KEY_PAGSEGURO', '68B8032BA6A6D28CC4705FBB1EDDF9CF');
}else{
	define('EMAIL_PAGSEGURO', 'fabianojunioor@hotmail.com');
	define('TOKEN__PAGSEGURO', '0FD01DAF802D4770A4036BEC039DE629');
	
	define('API_PAGSEGURO', 'app2076211170');
	define('KEY_PAGSEGURO', 'EBD69E699D9DB7A114F97FB9CBC4CCA6');
}

\PagSeguro\Configuration\Configure::setEnvironment('production');//production or sandbox
\PagSeguro\Configuration\Configure::setAccountCredentials(
	EMAIL_PAGSEGURO,
	TOKEN__PAGSEGURO // Sandbox
);

// Sandbox
\PagSeguro\Configuration\Configure::setApplicationCredentials(
	API_PAGSEGURO,
	KEY_PAGSEGURO
);

//For example, to configure the library dynamically:
\PagSeguro\Configuration\Configure::setCharset('ISO-8859-1');// UTF-8 or ISO-8859-1
\PagSeguro\Configuration\Configure::setLog(true, 'action/pagseguro/logs/logPagseguro.log');

