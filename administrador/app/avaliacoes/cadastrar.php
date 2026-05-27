<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
				<h3>Banner - Cadastrar</h3>
			</div>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
						<label>Nome:</label>
						<input type="text" name="nome" id="nome" class="form-style validate[required,maxSize[60]]" />
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<label>Título:</label>
						<input type="text" name="titulo" id="titulo" class="form-style" />
					</div>

					<div class="col-md-6">
						<label>Link:</label>
						<input type="text" name="link" id="link" class="form-style" />
					</div>
				</div>

				<div class="row">
					<div class="col-md-9">
						<label>Breve texto:</label>
						<input type="text" name="texto" id="texto" class="form-style validate[maxSize[200]]" />
					</div>

					<div class="col-md-3">
						<label>Ordem:</label>
						<input type="text" name="ordem" id="ordem" class="form-style validate[required,maxSize[60]]" />
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<label>Imagem icon:</label><br>
						<input type='file' name="icone_img" accept=".png, .jpg, .jpeg" />
					</div>
				</div>
					
				<div class="row">
					<div class="col-md-6">
						<label>Tamanho recomendável: 1903x800 pixels</label><br>
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
						<div id="image-container" style="width: 500px; max-height: 500px; background-image: url('<?php echo $imagem ?>');    background-position: center; background-repeat: no-repeat;">
						</div>
					</div>
				</div>
					
				<div class="row">
					<div class="col-md-12"><input type="submit" class="btn btn-primary" value="Salvar" /></div>
				</div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->

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

        var src = window.URL.createObjectURL(this.files[0]);

        console.log(window.URL)


        var $image = $('<img/>');

        $image.attr({src: src}).load(function () {

            $imageContainer.html($image);       

            $image.cropper({
              aspectRatio: 1903/800,
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
