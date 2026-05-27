<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
          		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Equipe - Cadastrar</h3>
			</div>

			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-4">
						<label>Nome:</label>
						<input type="text" name="nome" id="nome" class="form-style validate[required]" />
					</div>

					<div class="col-md-4">
						<label>Cargo:</label>
						<input type="text" name="cargo" id="cargo" class="form-style" />
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Resumo:</label>
						<input type="text" name="resumo" id="resumo" class="form-style" />
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label>E-mail:</label>
						<input type="email" name="email" id="email" class="form-style" />
					</div>

					<div class="col-md-4">
						<label>Telefone:</label>
						<input type="text" name="telefone" id="telefone" class="form-style" />
					</div>

					<div class="col-md-4">
						<label>Whatsapp:</label>
						<input type="text" name="whatsapp" id="whatsapp" class="form-style" />
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label>Facebook:</label>
						<input type="text" name="facebook" id="facebook" class="form-style" />
					</div>

					<div class="col-md-4">
						<label>Instagram:</label>
						<input type="text" name="instagram" id="instagram" class="form-style" />
					</div>

					<div class="col-md-4">
						<label>Linkedin:</label>
						<input type="text" name="linkedin" id="linkedin" class="form-style" />
					</div>
				</div>

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
					<div class="col-md-12">
						<input type="submit" class="btn btn-primary pull-right" value="Salvar" />
					</div>
				</div>
			</form>
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
