<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
          		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Último artigo - Cadastrar</h3>
			</div>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<label>Título:</label>
						<input type="text" name="titulo" id="titulo" class="form-style validate[required,maxSize[120]]" />
					</div>

					<div class="col-md-3">
						<label>Status:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="status" value='<?php echo $k ?>' <?php echo $k==1?"checked":""; ?>> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>

					<div class="col-md-3">
						<label>Destaque:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="destaque" value='<?php echo $k ?>' <?php echo $k==0?"checked":""; ?>> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Resumo:</label> Caracteres disponíveis: <span class="contadorCaracter">140</span>
						<input type="text" name="resumo" id="resumo" maxlength="140" class="form-style validate[required]" />
					</div>
				</div>


				<div class="row">
					<div class="col-md-12">
						<label>Descrição:</label>
						<textarea type="text" name="descricao" id="descricao" class="form-style ckeditor"></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<label>Tamanho recomendável: 730 pixel x 450 pixel</label><br>
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

        var src = window.URL.createObjectURL(this.files[0]);

        console.log(window.URL)


        var $image = $('<img/>');

        $image.attr({src: src}).load(function () {

            $imageContainer.html($image);       

            $image.cropper({
              aspectRatio: 730/450,
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
