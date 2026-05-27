<?php
if (!isset($_SERVER['HTTP_REFERER'])){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$acess 		= str_replace('http://'.$_SERVER['SERVER_NAME'], '', $_SERVER['HTTP_REFERER']);
$request 	= str_replace('removeImage.php','', $_SERVER['REQUEST_URI']);
$tmpPath 	= $_POST['tmp_path_crop'];

if ($acess == $request) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

setlocale(LC_ALL, 'pt-BR');

// Path do Arquivo de log
$tmpCropImage = $tmpPath.'cropImage.log';

// Remove arquivos Temporários antigos
if (file_exists($tmpCropImage)){

	$handle 		= fopen($tmpCropImage, 'a+');
	$data 			= fread($handle,filesize($tmpCropImage)>=5?filesize($tmpCropImage):5);

	if ($data != ''){

		$dataLine = explode(';', $data);

		// Limpa informações dos logs
		$data = '';

		if (sizeof($dataLine)>0){

			for($i=0;$i<sizeof($dataLine);$i++){
				$dataItem = explode(',', $dataLine[$i]);

				// Remove imagens temporarias antigas
				if (date('Y-m-d H:i', strtotime($dataItem[1])) <= date('Y-m-d H:i', strtotime('-1 hour'))){

					// Remove imagem
					if (!@unlink($dataItem[0])){

						// Verifica se imagem existe e adiciona no log
						if (file_exists($dataItem[0])){
							$data .= $data!=''?';'.$dataItem[0].','.$dataItem[1]:$dataItem[0].','.$dataItem[1];
						}
					}

				} else {
					// Cria informações de log de imagens que não expirarão
					$data .= $data!=''?';'.$dataItem[0].','.$dataItem[1]:$dataItem[0].','.$dataItem[1];
				}
			}
		} else {
			$dataItem = explode(',', $dataLine[$i]);

			// Remove imagens temporarias antigas
			if (date('Y-m-d H:i', strtotime($dataItem[1])) <= date('Y-m-d H:i', strtotime('-1 hour'))){

				// Remove imagem
				if (!@unlink($dataItem[0])){

					// Verifica se imagem existe e adiciona no log
					if (file_exists($dataItem[0])){
						$data .= $data!=''?';'.$dataItem[0].','.$dataItem[1]:$dataItem[0].','.$dataItem[1];
					}
				}

			} else {
				// Cria informações de log de imagens que não expirarão
				$data .= $data!=''?';'.$dataItem[0].','.$dataItem[1]:$dataItem[0].','.$dataItem[1];
			}
		}

		rewind($handle); // Move ponteiro para inicio
		ftruncate($handle, 0); // Limpa todo o log
		fwrite($handle, $data); // Escreve no arquivo
		fclose($handle); // Fecha o arquivo

	}
}
exit;
?>