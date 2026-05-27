<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
			<?php
				$res	= Doctrine_Core::getTable('Empresa')->find(1);
			?>

			<form class="formAdmin" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil"  enctype="multipart/form-data">
               	<div class="header">    
                    <h3>A Empresa:</h3>
                </div>
                <div class="row">
					<div class="col-md-6">
						<label>Título:</label>
						<input type="text" name="titulo" id="titulo" class="form-style validate[required,maxSize[120]]" value="<?php echo $res->titulo?>" />
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
					$imagem = URL_EMPRESA.$res->imagem;
				} else {
					$imagem = URL_EMPRESA.'camera.png';
				}
				?>
				<div class="row">
					<div class="col-md-6">
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

				<?php
					if (isset($res->imagem)&&$res->imagem!='') {
						?>
							<div class="row" style="margin-top: 0px;">
								<div class="col-md-3">
												<label><input type="checkbox" name="remover_imagem" value="1"> Remover Imagem</label><br>
									<div class="img-resultado">
										<img src="<?php echo $imagem ?>">
									</div>
								</div>
							</div>
						<?php
					}
				?>
				
				<div class="row">
					<div class="col-md-12">
                        <input type="hidden" name="id" value="<?php echo $res->id ?>">
						<input type="submit" class="button button-primary" value="Salvar">
					</div>
				</div>
			</form>
		</div>
	</div><!-- Block End -->
</div>

<script type="text/javascript">
	function readURL(input, target) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              $('.'+target).css('background-image', 'url('+e.target.result +')');
              $('.'+target).hide();
              $('.'+target).fadeIn(650);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
 
  var $imageContainer = $('#image-container');
  var timeout
    $('#image-file').change(function () {
    	$('.img-resultado').css('display','none');

        var src = window.URL.createObjectURL(this.files[0]);

        console.log(window.URL)


        $('.image-cropped').css('display','block');
        var $image = $('<img/>');

        $image.attr({src: src}).load(function () {

            $imageContainer.html($image);       

            $image.cropper({
              aspectRatio: 543/483,
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

