<?php

if (!isset($_SERVER['HTTP_REFERER'])){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$acess = str_replace('http://'.$_SERVER['SERVER_NAME'], '', $_SERVER['HTTP_REFERER']);
$request = str_replace('getInfo.php','', $_SERVER['REQUEST_URI']);

if ($acess == $request) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

setlocale(LC_TIME, ini_get('date.timezone'));

if (isset($_FILES[$_POST['inputName']])){
	if($_FILES[$_POST['inputName']]['error'] == 0){

		try {

			$json = array();
			$resolution = getimagesize($_FILES[$_POST['inputName']]['tmp_name']);

			if ($resolution[0]<=$_POST['maxWidth'] && $resolution[0]<=$_POST['maxHeight']){

				$json['status']		= 1;
				$json['type']		= $_FILES[$_POST['inputName']]['type'];
				$json['ext']		= '.'.substr(strrchr($_FILES[$_POST['inputName']]['name'],'.'),1);
				$json['size']		= $_FILES[$_POST['inputName']]['size'];
				$json['error']		= $_FILES[$_POST['inputName']]['error'];
				$json['width']		= $resolution[0];
				$json['height']		= $resolution[1];

				$tmpPath = $_POST['tmp_path_crop'];
				$tmpURL = $_POST['tmp_url_crop'];

				$charsCode = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

				$name = '';

				// Gera nome randomico
				do {
					for ($i=0;$i<3;$i++){
						$name .= $charsCode[rand(0, strlen($charsCode)-1)].date('hmi');
					}
				} while (file_exists($tmpPath.$name.$json['ext']) && date("Y-m-d H", filemtime($tmpPath.$name.$json['ext']))<=date('Y-m-d H', strtotime('-1 hour')));

				$tmpName = $tmpPath.$name.$json['ext'];

				// Move arquivo para pasta temporária
				if ($_POST['msie']!=1){
					$urlImage = 'data:'.$_FILES[$_POST['inputName']]['type'].';base64,'.base64_encode(fread(fopen($_FILES[$_POST['inputName']]['tmp_name'], "r"), filesize($_FILES[$_POST['inputName']]['tmp_name'])));
					move_uploaded_file($_FILES[$_POST['inputName']]['tmp_name'], $tmpName);
					$json['msie'] 	= 0;
				} else {
					$urlImage = $tmpURL.$name.$json['ext'];
					move_uploaded_file($_FILES[$_POST['inputName']]['tmp_name'], $tmpName);
					$json['msie'] 	= 1;
				}

				// Path do Arquivo de log
				$tmpCropImage = $tmpPath.'cropImage.log';

				// Insere informação da imagem no log
				$handle 		= fopen($tmpCropImage, 'a+');
				$insertData 	= filesize($tmpCropImage)!=0?';'.$tmpName.','.date('Y-m-d H:i', filemtime($tmpName)):$tmpName.','.date('Y-m-d H:i', filemtime($tmpName));

				fwrite($handle, $insertData); // Escreve no arquivo
				fclose($handle); // Fecha o arquivo

				$json['tmp_name'] 	= $tmpName;
				$json['urlImage']	= $urlImage;
				$json['name']		= $name;
			} else {
				$json['status'] = 5;
			}

		} catch (Exception $e){
			$json['status'] = 4;
		}
	} else {
		$json['status'] = 3;
	}
} else {
	$json['status'] = 2;
}

echo json_encode($json);
?>