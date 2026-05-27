<?php
  	include('lib/Config.php');
  	ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $objConfiguracao->nome ?></title>
    <link rel="shortcut icon" href="<?php echo URL_IMAGES ?>favicon.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,500;0,600;0,700;0,800;1,200;1,300;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    	    <h1>Ops algo deu errado <span>:(</span></h1>
			<p>Página não encontrada.</p>

            <a style="color: #fff;" href="<?php echo URL ?>">Voltar para o site</a>
		</div>

        <style>
            h1, i {
                color: #fff;
                font-size: 50px;
            }
            p {
        	  color: #fff;
                font-size: 30px;
            }
            body, html {
    		font-family: 'Montserrat',serif;
				overflow:hidden;
				height:100%;
				width:100%;
				background:#fd5000;
				color:#333;
				font-size:18px;
				-webkit-user-select: none;
			}
			video {
				position:absolute;
				opacity:0.25;
			}
			.container {
				position: absolute;
				top:50%;
				left:50%;
				margin:-250px 0 0 -250px;
				height:500px;
				text-align: center;
				width:500px;
			
			}
			i {
				font-style: normal;
				font-size:200px;
			}
        </style>
</body>
</html>