<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

<style type="text/css">
	.displayJuridica {
		display: none;
	}
</style>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
                <a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Cliente - Cadastrar</h3>
			</div>

		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form" enctype="multipart/form-data">
				
			   	<div class="row">
                    <div class="col-md-3">
                        <label>Nome:</label>
                        <input type="text" class="form-style" name="nome" id="nome">
                    </div>  

					<div class="col-md-3 displayFisica">
						<label>CPF:</label>
						<input type="text" class="form-style" name="cpf" id="cpf" data-mask='999.999.999-99'>
					</div>			

                     <div class="col-md-3">
                        <label>Status:</label><br>
                        <?php foreach ($_STATUS as $k=>$v){ ?>
                            <label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="status" value='<?php echo $k ?>' <?php echo $k==1?"checked":""; ?>> <?php echo $v; ?></label> 
                        <?php } ?> 
                    </div>		
				</div>

                <div class="row">
                    <div class="col-md-3">
                        <label>E-mail:</label>
                        <input type="email" class="form-style" name="email" id="email">
                    </div>

                    <div class="col-md-3">
                        <label>Telefone:</label>
                        <input type="text" name="telefone" id="telefone" class="form-style" data-mask="(99) 9999-9999" />
                    </div>
                </div>

				<div class="row">
                    <div class="col-sm-2">
                        <label>CEP:</label>
                        <input name="cep" id="cep" data-mask='99999-999' class="form-style"  type="text">
                        
                    </div>    
                    
                    <div class="col-sm-5">
                        <label>Endereço:</label>
                        <input name="logradouro" id="logradouro" class="form-style"  type="text">
                    </div>    
                    
                    <div class="col-sm-2">
                        <label>Número:</label>
                        <input name="numero" id="numero" class="form-style" type="text">
                    </div>  
                    
                    <div class="col-sm-3">
                        <label>Complemento:</label>
                        <input name="complemento" id="complemento" class="form-style" type="text">
                    </div>   
                </div>    
                
                <div class="row">
                    <div class="col-sm-4">
                        <label>Bairro:</label>
                        <input name="bairro" id="bairro" class="form-style" type="text">
                    </div>    

                    <div class="col-sm-4">
                        <label>Estado:</label>
                        <select name="estado_id" id="estado_id" data-live-search="true" data-width="100%"
                                data-toggle="tooltip" class="form-style">
                            <option value="">Estado</option>
                            <?php
                            try {

                                $resAtiv = Doctrine_Query::create()->select()->from('Estado')->execute();

                                if ($resAtiv->count() > 0) {
                                    $resAtiv->toArray();

                                    foreach ($resAtiv as $value) {
                                        echo '<option value="' . $value['id'] . '">' . $value['sigla'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Nenhum registro encontrado</option>';
                                }
                            } catch (Exception $e) {
                                echo '<option value="">Ocorreu um erro de sistema</option>';
                            }
                            ?>
                        </select>
                    </div>
                   
                    <div class="col-sm-4">
                        <label>Cidade:</label>
                        <select class='form-style' data-live-search="true" data-width="100%"
                                data-toggle="tooltip" name="cidade_id" id='cidade_id'>
                            <option value="">Selecione o estado</option>
                            <?php
                            try {

                                $resAtiv = Doctrine_Query::create()->select()->from('Cidade')->where('estado_id = "'.$res->estado_id.'"')->execute();

                                if ($resAtiv->count() > 0) {
                                    $resAtiv->toArray();

                                    foreach ($resAtiv as $value) {
                                        echo '<option value="' . $value['id'] . '">' . $value['nome'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Nenhum registro encontrado</option>';
                                }
                            } catch (Exception $e) {
                                echo '<option value="">Ocorreu um erro de sistema</option>';
                            }
                            ?>
                        </select>
                    </div>  
                </div>

                <div class="row">
                    <?php
                        $imagem = URL_IMAGES.'camera.png';
                    ?>
                    <div class="col-md-8">
                        <label>Imagem (400 de largura x 400 de altura):</label><br>
                        <input type="hidden" name="y" id="y" />
                        <input type="hidden" name="x" id="x" />
                        <input type="hidden" name="w" id="w" />
                        <input type="hidden" name="h" id="h" />
                        <label for="caminho-imagem">
                            <button type="button" class="btn btn-warning abrirImagem">Selecionar Imagem</button>
                            <div class="photo-upload">
                                <div class="photo-edit">
                                    <input type='file' name="imagem" class="caminho-imagem" target='caminho-imagem' id="caminho-imagem" accept=".png, .jpg, .jpeg" />
                                </div>
                            </div>
                        </label>
                        <div id="image-container" class="image-cropped"  style="height: 500px; display: none"></div>
                    </div>
                </div>
								
              	<div class="row">
					<div class="col-md-12"><button type="submit" class="btn btn-primary">Salvar</button></div>
				</div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.maskMoney.js"></script>
<script type="text/javascript">
  $(".valores-input").maskMoney({showSymbol: false, decimal: ".", thousands:"", precision: 2, allowZero: true});
    $(document).ready(function() {
        var $imageContainer = $('#image-container');
        var timeout
        $('#caminho-imagem').change(function () {

            var src = window.URL.createObjectURL(this.files[0]);

            var $image = $('<img/>');
            $('.img-resultado').css('display','none');

            $image.attr({src: src}).load(function () {

                $imageContainer.html($image);    
                $imageContainer.css('display', 'block')         

                $image.cropper({
                    aspectRatio: 400/200,
                    zoomOnWheel: true,
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

        $('.abrirImagem').click(function(event) {
            $('.caminho-imagem').trigger('click')
        });
        
		$('.tipo-pessoa input').on('ifChecked', function(event){
           var value_contrato = event.target.value;
		    if (value_contrato == 0) {
		    	$('.displayFisica').css('display','block');
		    	$('.displayJuridica').css('display','none');
		    } else {
		    	$('.displayFisica').css('display','none');
		    	$('.displayJuridica').css('display','block');
		    }
	   	});
	});

    $("#cep").change(function(){
    if($.trim($("#cep").val()) != ""){
      /* 
          Para conectar no serviço e executar o json, precisamos usar a função
          getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
          dataTypes não possibilitam esta interação entre domínios diferentes
          Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
          http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val()
      */
      
      $.get("https://viacep.com.br/ws/"+$("#cep").val()+"/json/", function(data){
            console.log(data);
          // o getScript dá um eval no script, então é só ler!
          //Se o resultado for igual a 1
            if(!data["erro"]){
 
                $("#carregando").css('display', '');

                var uf = data["uf"];
                uf = uf.replace(' ', '');

                var cidade = unescape(data["localidade"]);
                console.log(cidade);
              // troca o valor dos elementos
              // ID do campo da rua
              $("#logradouro").val(unescape(unescape(data["logradouro"])));
              // ID do campo do bairro
              $("#bairro").val(unescape(data["bairro"]));
              // ID do campo do estado
              // $('#estado').find('option[text="'+uf+'"]').attr('selected', 'selected');
              // console.log("'"+uf+"'");
                $('#estado_id option:contains(' + uf + ')').each(function(){
                    if ($(this).text() == uf) {
                        $(this).attr('selected', 'selected');
                        estado_id = $(this).val();
                        // return false;
                    }
                    // return true;
                    $("#estado_id").val(estado_id);
                });
                $("#estado_id");

                $("select[name=cidade_id]").html('<option value="">Carregando...</option>');

                $.when( $.getJSON("<?php echo URL_ADMIN ?>getCidades.php",{estado_id: estado_id}, function(j){
                    $("select[name=cidade_id]").html('<option value="">Carregando...</option>');
                    var options = '<option value="">Selecione</option>';    
                    for (var i = 0; i < j.length; i++){

                        options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
                        
                    }   
                   $("#cidade_id").html(options);
                })).done(function() {
                    $('#cidade_id option:contains(' + cidade + ')').each(function(){
                        if ($(this).text() == cidade) {
                            $(this).attr('selected', 'selected');
                            cidade_id = $(this).val();
                            // return false;
                        }
                        // return true;
                    });
                    $("#cidade_id");

                    

                    $("#carregando").css('display', 'none');
                });
                
                // alert("ae");
                

                $('#numero').focus();
                
              // ID do campo da Cidade
              // $("#cidade").val(unescape(data["cidade"]));
          }else{
              alert("Endereço não encontrado");
          }
      });                
    }
    }); 

     $("#estado_id").change(function(){
        // alert("ae");
        if($(this).val()){
            $("#cidade_id").html('<option value="">Carregando...</option>');
            $.getJSON("<?php echo URL_ADMIN ?>getCidades.php",{estado_id: jQuery(this).val()}, function(j){
                var options = '<option value="">Selecione</option>';
                for (var i = 0; i < j.length; i++){
                    options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';

                }
                $("#cidade_id").html(options);

            });
        } else {
            $("#cidade_id").html('<option value="">Selecione um estado</option>');
        }
    });

     $("#cidade_id").change(function(){
        // alert("ae");
        if($(this).val()){
            $("#regiao_id").html('<option value="">Carregando...</option>');
            $.getJSON("<?php echo URL_ADMIN ?>getRegiao.php",{cidade_id: jQuery(this).val()}, function(j){
                var options = '<option value="">Selecione</option>';
                for (var i = 0; i < j.length; i++){
                    options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';

                }
                $("#regiao_id").html(options);

            });
        } else {
            $("#regiao_id").html('<option value="">Selecione um cidade</option>');
        }
    });
</script>