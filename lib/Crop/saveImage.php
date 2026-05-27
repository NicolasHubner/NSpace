<?php

header('Content-type: text/json');

if (!isset($_SERVER['HTTP_REFERER'])){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$acess = str_replace('http://'.$_SERVER['SERVER_NAME'], '', $_SERVER['HTTP_REFERER']);
$request = str_replace('saveImage.php','', $_SERVER['REQUEST_URI']);

if ($acess == $request) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}
require_once($_POST['wide_image']);

switch ($_POST['type']){
	case '0':

		// Gera caminho para gravar a imagem
		$tmpPath = $_POST['tmp_path'];
		$imgPath = $tmpPath.$_POST['name'];

		// Grava imagem
		$img = WideImage::load($_POST['file']);
		$img = $img->crop($_POST['x'],$_POST['y'],$_POST['w'],$_POST['h']);
		$img->saveToFile($imgPath);
		$img->destroy();

		// Path do Arquivo de log
		$tmpCropImage = $tmpPath.'cropImage.log';

		// Insere informação da imagem no log
		$handle 		= fopen($tmpCropImage, 'a+');
		$insertData 	= filesize($tmpCropImage)!=0?';'.$imgPath.','.date('Y-m-d H:i', filemtime($imgPath)):$imgPath.','.date('Y-m-d H:i', filemtime($imgPath));

		fwrite($handle, $insertData); // Escreve no arquivo
		fclose($handle); // Fecha o arquivo

		if ($_POST['msie']!=1){
			$img = 'data:'.$_POST['type_file'].';base64,'.base64_encode(fread(fopen($imgPath, "r"), filesize($imgPath)));
		} else {
			$img = $_POST['tmp_url'].$_POST['name'];
		}

		echo json_encode($img);

		exit;
	case '1':

		$_POST['images_settings']['imgCropPath'] = $_POST['images_settings']['imgCropPath'];

		// Verifica alguns dados enviados
		$_POST['images_settings']['border'] = isset($_POST['images_settings']['border'])&&is_array($_POST['images_settings']['border'])?$_POST['images_settings']['border']:array();
		$_POST['images_settings']['borderTopLeft'] = isset($_POST['images_settings']['borderTopLeft'])&&is_array($_POST['images_settings']['borderTopLeft'])?$_POST['images_settings']['borderTopLeft']:array();
		$_POST['images_settings']['borderTopRight'] = isset($_POST['images_settings']['borderTopRight'])&&is_array($_POST['images_settings']['borderTopRight'])?$_POST['images_settings']['borderTopRight']:array();
		$_POST['images_settings']['borderBottomLeft'] = isset($_POST['images_settings']['borderBottomLeft'])&&is_array($_POST['images_settings']['borderBottomLeft'])?$_POST['images_settings']['borderBottomLeft']:array();
		$_POST['images_settings']['borderBottomRight'] = isset($_POST['images_settings']['borderBottomRight'])&&is_array($_POST['images_settings']['borderBottomRight'])?$_POST['images_settings']['borderBottomRight']:array();
		$_POST['images_settings']['colorBorder'] = isset($_POST['images_settings']['colorBorder'])&&is_array($_POST['images_settings']['colorBorder'])?$_POST['images_settings']['colorBorder']:null;

		$status['save'] = false;
		$status['msie'] = $_POST['image']['msie'];

		try {

			// Gera o nome do arquivo
			$name = md5($_POST['image']['name'].date('Y-m-d H'));

			// Define a extensão do arquivo
			switch($_POST['images_settings']['type']){
				case 'image/jpeg':
					$type = '.jpg';
					break;
				case 'image/jpg':
					$type = '.jpg';
					break;
				case 'image/png':
					$type = '.png';
					break;
				case 'image/x-png':
					$type = '.png';
					break;
				case 'image/gif':
					$type = '.gif';
					break;
				case 'image/bmp':
					$type = '.bmp';
					break;
				default:
					$type = '.jpg';
			}

			for ($i=0;$i<sizeof($_POST['images_info']);$i++){

				// Inicializa variáveis
				$border = array();

				// Salva imagens proporcionais
				if ($_POST['images_info'][$i]['crop']==0){

					try {

						$images = explode("," ,$_POST['proportion']['proportion'][$i]['bond']);

						for ($j=0;$j<sizeof($images);$j++){

							// Gera caminho para gravar a imagem
							$imgPath = $_POST['images_settings']['path'][$images[$j]].$name.$type;

							$width = $_POST['images_settings']['width'][$images[$j]]!=''&&$_POST['images_settings']['width'][$images[$j]]!=null?$_POST['images_settings']['width'][$images[$j]]:null;
							$height = $_POST['images_settings']['height'][$images[$j]]!=''&&$_POST['images_settings']['height'][$images[$j]]!=null?$_POST['images_settings']['height'][$images[$j]]:null;

							// Grava imagem
							$img = WideImage::load($_POST['image']['tmp_name']);
							$img = $img->resize($width,$height,'inside');

							// Bordas das imagens
							if (sizeof($_POST['images_settings']['border'])>0 && (sizeof($_POST['images_settings']['border'])==1 || $_POST['images_settings']['border'][$images[$j]]!=null)){

								$borderAll 		= sizeof($_POST['images_settings']['border'])>1?$_POST['images_settings']['border'][$images[$j]]:$_POST['images_settings']['border'][0];
								$borderColor	= sizeof($_POST['images_settings']['colorBorder'])>1?$_POST['images_settings']['colorBorder'][$images[$j]]:$_POST['images_settings']['colorBorder'][0];
								$img 			= $img->roundCorners($borderAll, $borderColor, 4, WideImage::SIDE_ALL);

							}

							if (sizeof($_POST['images_settings']['border'])!=1 && (sizeof($_POST['images_settings']['border']) == 0 || $_POST['images_settings']['border'][$images[$j]]==null)) {

								// Borda Superior esquerda
								if (sizeof($_POST['images_settings']['borderTopLeft'])>0 && (sizeof($_POST['images_settings']['borderTopLeft'])==1 || $_POST['images_settings']['borderTopLeft'][$images[$j]]!=null)){

									$img = $img->roundCorners(	sizeof($_POST['images_settings']['borderTopLeft'])>1
																?$_POST['images_settings']['borderTopLeft'][$images[$j]]
																:$_POST['images_settings']['borderTopLeft'][0], $borderColor
																, 4, WideImage::SIDE_TOP_LEFT
															);
								}

								// Borda Superior direita
								if (sizeof($_POST['images_settings']['borderTopRight'])>0 && (sizeof($_POST['images_settings']['borderTopRight'])==1 || $_POST['images_settings']['borderTopRight'][$images[$j]]!=null)){

									$img = $img->roundCorners(	sizeof($_POST['images_settings']['borderTopRight'])>1
																?$_POST['images_settings']['borderTopRight'][$images[$j]]
																:$_POST['images_settings']['borderTopRight'][0], $borderColor
																, 4, WideImage::SIDE_TOP_RIGHT
															);
								}

								// Borda Inferior esquerda
								if (sizeof($_POST['images_settings']['borderBottomLeft'])>0 && (sizeof($_POST['images_settings']['borderBottomLeft'])==1 || $_POST['images_settings']['borderBottomLeft'][$images[$j]]!=null)){

									$img = $img->roundCorners(	sizeof($_POST['images_settings']['borderBottomLeft'])>1
																?$_POST['images_settings']['borderBottomLeft'][$images[$j]]
																:$_POST['images_settings']['borderBottomLeft'][0], $borderColor
																, 4, WideImage::SIDE_BOTTOM_LEFT
															);
								}

								// Borda Inferior direita
								if (sizeof($_POST['images_settings']['borderBottomRight'])>0 && (sizeof($_POST['images_settings']['borderBottomRight'])==1 || $_POST['images_settings']['borderBottomRight'][$images[$j]]!=null)){

									$img = $img->roundCorners(	sizeof($_POST['images_settings']['borderBottomRight'])>1
											?$_POST['images_settings']['borderBottomRight'][$images[$j]]
											:$_POST['images_settings']['borderBottomRight'][0], $borderColor
											, 4, WideImage::SIDE_BOTTOM_RIGHT
									);
								}
							}

							if ($_POST['images_settings']['type']=='image/jpeg' || $_POST['images_settings']['type']=='image/jpg'){
								$img->saveToFile($imgPath,$_POST['images_settings']['quality']);
							} else if ($_POST['images_settings']['type']=='image/png' || $_POST['images_settings']['type']=='image/xpng'){
								$img->saveToFile($imgPath,$_POST['images_settings']['compression']);
							} else {
								$img->saveToFile($imgPath);
							}

							$img->destroy();
						}
					} catch (Exception $e){
						$status['save'] = false;
						$status['error'] = 'proportional_error_save';
						echo json_encode($status);
						exit;
					}
				} else {

					try {

						$images = explode("," ,$_POST['proportion']['proportion'][$i]['bond']);

						// Gera caminho para gravar a imagem
						$imgPathTmp = $_POST['images_settings']['imgCropPath'].'tmp/'.$name.$type;

						// Grava imagem
						$img = WideImage::load($_POST['image']['tmp_name']);
						$img = $img->crop(	$_POST['images_info'][$i]['coords']['x'],$_POST['images_info'][$i]['coords']['y'],
											$_POST['images_info'][$i]['coords']['w'],$_POST['images_info'][$i]['coords']['h']);

						if ($_POST['images_settings']['type']=='image/jpeg' || $_POST['images_settings']['type']=='image/jpg'){
							$img->saveToFile($imgPathTmp, $_POST['images_settings']['quality']);
						} else if ($_POST['images_settings']['type']=='image/png' || $_POST['images_settings']['type']=='image/xpng'){
							$img->saveToFile($imgPathTmp, $_POST['images_settings']['compression']);
						} else {
							$img->saveToFile($imgPathTmp);
						}

						$img->destroy();

					} catch (Exception $e){

						// Remove imagem temporária
						if (isset($imgPathTmp)){
							unlink($imgPathTmp);
						}

						$status['save'] = false;
						$status['error'] = 'tmp_error_save';
						echo json_encode($status);
						exit;
					}

					try {

						// Salva as imagens com proporção ao recorte
						for ($j=0;$j<sizeof($images);$j++){

							// Gera caminho para gravar a imagem
							$imgPath = $_POST['images_settings']['path'][$images[$j]].$name.$type;

							// Grava imagem
							$img = WideImage::load($imgPathTmp);
							$img = $img->resize($_POST['images_settings']['width'][$images[$j]],$_POST['images_settings']['height'][$images[$j]],'inside');

							$borderColor = sizeof($_POST['images_settings']['colorBorder'])>1?$_POST['images_settings']['colorBorder'][$images[$j]]:$_POST['images_settings']['colorBorder'][0];

							// Bordas das imagens
							if (sizeof($_POST['images_settings']['border'])>0 && (sizeof($_POST['images_settings']['border'])==1 || $_POST['images_settings']['border'][$images[$j]]!=null)){

								$borderAll 		= sizeof($_POST['images_settings']['border'])>1?$_POST['images_settings']['border'][$images[$j]]:$_POST['images_settings']['border'][0];
								$borderColor	= sizeof($_POST['images_settings']['colorBorder'])>1?$_POST['images_settings']['colorBorder'][$images[$j]]:$_POST['images_settings']['colorBorder'][0];
								$img 			= $img->roundCorners($borderAll, $borderColor, 4, WideImage::SIDE_ALL);

							}

							if (sizeof($_POST['images_settings']['border'])!=1 && (sizeof($_POST['images_settings']['border']) == 0 || $_POST['images_settings']['border'][$images[$j]]==null)) {

								// Borda Superior esquerda
								if (sizeof($_POST['images_settings']['borderTopLeft'])>0 && (sizeof($_POST['images_settings']['borderTopLeft'])==1 || $_POST['images_settings']['borderTopLeft'][$images[$j]]!=null)){

									$img = $img->roundCorners(	sizeof($_POST['images_settings']['borderTopLeft'])>1
																?$_POST['images_settings']['borderTopLeft'][$images[$j]]
																:$_POST['images_settings']['borderTopLeft'][0], $borderColor
																, 4, WideImage::SIDE_TOP_LEFT
															);
								}

								// Borda Superior direita
								if (sizeof($_POST['images_settings']['borderTopRight'])>0 && (sizeof($_POST['images_settings']['borderTopRight'])==1 || $_POST['images_settings']['borderTopRight'][$images[$j]]!=null)){

									$img = $img->roundCorners(	sizeof($_POST['images_settings']['borderTopRight'])>1
																?$_POST['images_settings']['borderTopRight'][$images[$j]]
																:$_POST['images_settings']['borderTopRight'][0], $borderColor
																, 4, WideImage::SIDE_TOP_RIGHT
															);
								}

								// Borda Inferior esquerda
								if (sizeof($_POST['images_settings']['borderBottomLeft'])>0 && (sizeof($_POST['images_settings']['borderBottomLeft'])==1 || $_POST['images_settings']['borderBottomLeft'][$images[$j]]!=null)){

									$img = $img->roundCorners(	sizeof($_POST['images_settings']['borderBottomLeft'])>1
																?$_POST['images_settings']['borderBottomLeft'][$images[$j]]
																:$_POST['images_settings']['borderBottomLeft'][0], $borderColor
																, 4, WideImage::SIDE_BOTTOM_LEFT
															);
								}

								// Borda Inferior direita
								if (sizeof($_POST['images_settings']['borderBottomRight'])>0 && (sizeof($_POST['images_settings']['borderBottomRight'])==1 || $_POST['images_settings']['borderBottomRight'][$images[$j]]!=null)){

									$img = $img->roundCorners(	sizeof($_POST['images_settings']['borderBottomRight'])>1
											?$_POST['images_settings']['borderBottomRight'][$images[$j]]
											:$_POST['images_settings']['borderBottomRight'][0], $borderColor
											, 4, WideImage::SIDE_BOTTOM_RIGHT
									);
								}
							}

							$img->saveToFile($imgPath);
							$img->destroy();

						}

					} catch (Exception $e){

						// Remove imagem temporária
						if (isset($imgPathTmp)){
							unlink($imgPathTmp);
						}

						$status['save'] = false;
						$status['error'] = 'proportional_crop_error_save';
						echo json_encode($status);
						exit;
					}
				}
			}
		} catch (Exception $e){

			// Remove imagem temporária
			if (isset($imgPathTmp)){
				unlink($imgPathTmp);
			}

			$status['save'] = false;
			$status['error'] = 'ilegal_operation';
			echo json_encode($status);
			exit;
		}

		// Remove imagem temporária
		@unlink($imgPathTmp);

		$status['save'] = true;
		$status['name'] = $name.$type;

		echo json_encode($status);
		exit;
}
?>