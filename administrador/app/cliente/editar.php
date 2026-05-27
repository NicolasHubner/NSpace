<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
                <a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Cliente - Editar</h3>
			</div>

		<div class="block_cont">
			<?php 

			try {
				$res = Doctrine_Core::getTable('Cliente')->find($_GET['id']);
				if($_SESSION['sess_usuario_grupo_id'] != 2 || ($_SESSION['sess_usuario_grupo_id'] == 2 && $res->usuario_id == $_SESSION['sess_usuario_id'])){
			?>

			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="form" enctype="multipart/form-data">
				
              	<div class="row">
                	<div class="col-md-3">
                        <label>Nome:</label>
						<input type="text" class="form-style validate[required]" name="nome" id="nome" value="<?php echo $res->nome ?>">
					</div>	

                    <div class="col-md-3">
                        <label>E-mail:</label>
                        <input type="email" class="form-style validate[required] valores-input" name="email" id="email" value="<?php echo $res->email ?>">
                    </div> 

                    <div class="col-md-3">
                        <label>Senha: (Para alterar preencha)</label>
                        <input type="password" class="form-style" name="senha" id="senha">
                    </div> 

                    <div class="col-md-3">
                        <label>Telefone:</label>
                        <input type="text" name="telefone" id="telefone" class="form-style" data-mask="(99) 9999-9999" value="<?php echo $res->telefone ?>"/>
                    </div>
                </div>

				<div class="row">
                    <div class="col-sm-2">
                        <label>CEP:</label>
                        <input name="cep"  value='<?php echo $res->cep ?>' id="cep" data-mask='99999-999' class="form-style"  type="text">
                    </div>    
                    
                    <div class="col-sm-5">
                        <label>Endereço:</label>
                        <input name="logradouro"  value='<?php echo $res->logradouro ?>' id="logradouro" class="form-style"  type="text">
                    </div>    
                    
                    <div class="col-sm-2">
                        <label>Número:</label>
                        <input name="numero"  value='<?php echo $res->numero ?>' id="numero" class="form-style" type="text">
                    </div>  
                    
                    <div class="col-sm-3">
                        <label>Complemento:</label>
                        <input name="complemento"  value='<?php echo $res->complemento ?>' id="complemento" class="form-style" type="text">
                    </div>   
                </div>    
                
                <div class="row">
                    <div class="col-sm-4">
                        <label>Bairro:</label>
                        <input name="bairro"  value='<?php echo $res->bairro ?>' id="bairro" class="form-style" type="text">
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
                                        $selected = $value['id']==$res->estado_id?"selected":"";
                                        echo '<option value="' . $value['id'] . '" '.$selected.'>' . $value['sigla'] . '</option>';
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
                                        $selected = $value['id']==$res->cidade_id?"selected":"";
                                        echo '<option value="' . $value['id'] . '" '.$selected.'>' . $value['nome'] . '</option>';
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
                    <div class="col-md-3">
                        <label>Status:</label>
                        <select class="form-style" name="status" id="status">
                            <option value="">Selecione</option>
                            <option value="0" <?php echo isset($res->status)&&$res->status==0?'selected':'' ?>>Inativa</option>
                            <option value="1" <?php echo isset($res->status)&&$res->status==1?'selected':'' ?>>Ativa</option>
                            <option value="3" <?php echo isset($res->status)&&$res->status==3?'selected':'' ?>>Desativada</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Status do e-mail:</label>
                        <select class="form-style" name="email_confirmado" id="email_confirmado">
                            <option value="">Selecione</option>
                            <option value="0" <?php echo isset($res->email_confirmado)&&$res->email_confirmado==0?'selected':'' ?>>Não confirmado</option>
                            <option value="1" <?php echo isset($res->email_confirmado)&&$res->email_confirmado==1?'selected':'' ?>>Confirmado</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Tipo de Cliente:</label>
                        <select class="form-style" name="tipo_cliente_id" id="tipo_cliente_id">
                            <option value="">Selecione</option>
                            <?php
                            try {

                                $resTipoCliente = Doctrine_Query::create()->select()->from('TipoCliente')->execute();

                                if ($resTipoCliente->count() > 0) {
                                    $resTipoCliente->toArray();

                                    foreach ($resTipoCliente as $value) {
                                        $selected = $value['id']==$res->tipo_cliente_id?"selected":"";
                                        echo '<option value="' . $value['id'] . '" '.$selected.'>' . $value['nome'] . '</option>';
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

                    <div class="col-md-3">
                        <label>Status verificação:</label>
                        <select class="form-style" name="verificado" id="verificado">
                            <option value="">Selecione</option>
                            <option value="0" <?php echo isset($res->verificado)&&$res->verificado==0?'selected':'' ?>>Não verificada</option>
                            <option value="1" <?php echo isset($res->verificado)&&$res->verificado==1?'selected':'' ?>>Analisando os documentos</option>
                            <option value="2" <?php echo isset($res->verificado)&&$res->verificado==2?'selected':'' ?>>Tudo certo! Aprovado.</option>
                        </select>
                    </div>
                </div>	
				
              	<div class="row">
				
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
				<div class="col-md-12"><input type="submit" class="btn btn-primary" value="Salvar" /></div>
			</form>
			<?php 
			
				} else {

					echo '<h4>Você não tem permissão para editar esse registro.</h4>';

				}
			
			} catch (Exception $e){
				echo 'Ocorreu um erro!';
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.maskMoney.js"></script>

<script type="text/javascript">
        $(".valores-input").maskMoney({showSymbol: false, decimal: ".", thousands:"", precision: 2, allowZero: true});
	 $(document).ready(function() {
		$('.tipo-pessoa input').on('ifChecked', function(event){
           var value_contrato = event.target.value;
		    if (value_contrato == 0) {
		    	$('.displayFisica').css('display','block');
		    	$('.displayFisica').find('input').val("");
		    	$('.displayJuridica').css('display','none');
		    } else {
		    	$('.displayJuridica').css('display','block');
		    	$('.displayJuridica').find('input').val("");
		    	$('.displayFisica').css('display','none');
		    }
	   	});

        var $imageContainer = $('#image-container');
        var timeout
        $('#caminho-imagem').change(function () {

            var src = window.URL.createObjectURL(this.files[0]);

            $('.image-cropped').css('display','block');
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
	});
</script>
		