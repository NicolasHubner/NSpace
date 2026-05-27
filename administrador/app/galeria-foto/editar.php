<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
				<h3>Galeria - Editar</h3>
			</div>
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Galeria')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil"  enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
						<label>Nome:</label>
						<input type="text" name="nome" id="nome" class="form-control validate[required]" value="<?php echo $res->nome; ?>" />
					</div>
				</div>

                <?php
                if (isset($res->imagem)&&$res->imagem!='') {
                    $imagem = URL_GALERIA_CAPA.$res->imagem;
                } else {
                    $imagem = URL_IMAGES.'camera.png';
                }
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <label>Tamanho recomendável: 600 pixel x 450 pixel</label><br>
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

				
				<div class="row">
					<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
					<div class="col-md-12"><input type="submit" class="btn btn-primary" value="Salvar" /></div>
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
              aspectRatio: 600/450,
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