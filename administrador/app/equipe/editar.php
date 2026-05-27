<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">
          		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>	
				<h3>Equipe - Editar</h3>
			</div>
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Equipe')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-4">
						<label>Nome:</label>
						<input type="text" name="nome" id="nome" class="form-style validate[required]" value="<?php echo $res->nome; ?>" />
					</div>

					<div class="col-md-4">
						<label>Cargo:</label>
						<input type="text" name="cargo" id="cargo" class="form-style" value="<?php echo $res->cargo; ?>" />
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Resumo:</label>
						<input type="text" name="resumo" id="resumo" class="form-style" value="<?php echo $res->resumo; ?>"/>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label>E-mail:</label>
						<input type="email" name="email" id="email" class="form-style" value="<?php echo $res->email; ?>"/>
					</div>

					<div class="col-md-4">
						<label>Telefone:</label>
						<input type="text" name="telefone" id="telefone" class="form-style" value="<?php echo $res->telefone; ?>"/>
					</div>

					<div class="col-md-4">
						<label>Whatsapp:</label>
						<input type="text" name="whatsapp" id="whatsapp" class="form-style" value="<?php echo $res->whatsapp; ?>"/>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label>Facebook:</label>
						<input type="text" name="facebook" id="facebook" class="form-style" value="<?php echo $res->facebook; ?>"/>
					</div>

					<div class="col-md-4">
						<label>Instagram:</label>
						<input type="text" name="instagram" id="instagram" class="form-style" value="<?php echo $res->instagram; ?>"/>
					</div>

					<div class="col-md-4">
						<label>Linkedin:</label>
						<input type="text" name="linkedin" id="linkedin" class="form-style" value="<?php echo $res->linkedin; ?>"/>
					</div>
				</div>

				<?php
				if (isset($res->imagem)&&$res->imagem!='') {
					$imagem = URL_EQUIPE.$res->imagem;
				} else {
					$imagem = URL_IMAGES.'camera.png';
				}
				?>
				<div class="row">
					<div class="col-md-6">
						<label>Tamanho recomendável: 500px x 500px</label><br>
						<input type="hidden" name="y" id="y" />
						<input type="hidden" name="x" id="x" />
						<input type="hidden" name="w" id="w" />
						<input type="hidden" name="h" id="h" />
						<label for="image-file">
							<button type="button" class="btn btn-warning abrirFoto">Selecionar foto</button>
							<div class="photo-upload">
								<div class="photo-edit">
									<input type='file' name="imagem" class="image-file" target='image-file' id="image-file" accept=".png, .jpg, .jpeg" />
								</div>
							</div>
						</label>
						<div id="image-container" class="image-cropped"></div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<div class="img-resultado">
							<img src="<?php echo $imagem ?>">
						</div>
					</div>
				</div>
				
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
				<div class="row">
					<div class="col-md-12"><input type="submit" class="btn btn-primary pull-right" value="Salvar" /></div>
				</div>
				
			</form>
			<?php 
			
			} catch (Exception $e){
				echo 'Ocorreu um erro!';
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->

<script type="text/javascript">
	$('#resumo').keyup(function()  {
	    var caracteresRestantes = 140;
	    var caracteresDigitados = parseInt($(this).val().length);
	    var caracteresRestantes = caracteresRestantes - caracteresDigitados;

	    $(".contadorCaracter").text(caracteresRestantes);

	    if (caracteresRestantes == 0) {
	    	$(".contadorCaracter").removeClass('limit-green');
	    	$(".contadorCaracter").addClass('limit-resumo');
	    } else {
	    	$(".contadorCaracter").addClass('limit-green');
	    	$(".contadorCaracter").removeClass('limit-resumo');
	    }
	});

	 var $imageContainer = $('#image-container');
  var timeout
    $('#image-file').change(function () {
    	$('.img-resultado').css('display','none');

        var src = window.URL.createObjectURL(this.files[0]);

    	$('.image-cropped').css('display','block');
        var $image = $('<img/>');

        $image.attr({src: src}).load(function () {

            $imageContainer.html($image);       

            $image.cropper({
              aspectRatio: 500/500,
              zoonOnWheel: false,
              crop: function (e) {
              	// console.log(e)
                $('#x').val(e.detail.x);
                $('#y').val(e.detail.y);
                $('#w').val(e.detail.width);
                $('#h').val(e.detail.height);
              }
            });
        })
    });

    $('.abrirFoto').click(function(event) {
    	$('.image-file').trigger('click')
    });
</script>