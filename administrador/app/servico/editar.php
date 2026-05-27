<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
          		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Serviço - Editar</h3>
			</div>
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Servico')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<label>Título:</label>
						<input type="text" name="titulo" id="titulo" class="form-style validate[required,maxSize[60]]" value="<?php echo $res->titulo; ?>" />
					</div>

					<div class="col-md-3">
						<label>Status:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="status" <?php echo ($res->status==$k?'checked="checked"':''); ?> value='<?php echo $k ?>'> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>

					<div class="col-md-3">
						<label>Destaque:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="destaque" <?php echo ($res->destaque==$k?'checked="checked"':''); ?> value='<?php echo $k ?>'> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Resumo:</label> Caracteres disponíveis: <span class="contadorCaracter limit-green">140</span>
						<textarea type="text" name="resumo" id="resumo" maxlength="140" class="form-style validate[required]"/><?php echo $res->resumo ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Descrição:</label>
						<textarea type="text" name="descricao" id="descricao" class="form-style ckeditor"><?php echo $res->descricao ?></textarea>
					</div>
				</div>

				<?php
				if (isset($res->imagem)&&$res->imagem!='') {
					$imagem = URL_SERVICO.$res->imagem;
				} else {
					$imagem = URL_IMAGES.'camera.png';
				}
				?>
				<div class="row">
					<div class="col-md-6">
						<label>Tamanho recomendável: 800 pixel x 500 pixel</label><br>
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
              aspectRatio: 800/500,
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