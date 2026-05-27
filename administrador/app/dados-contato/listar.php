<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
			<?php
				$res	= Doctrine_Core::getTable('Configuracao')->find(1);
			?>

            <?php if (isset($res->possui_unidade)&&$res->possui_unidade==1) { ?>
                <style type="text/css">
                    .display-unidade {
                        display: none;
                    }
                </style>
            <?php } ?>

			<form class="formAdmin" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil"  enctype="multipart/form-data">
                <div class="header">    
                    <h3>Contato:</h3>
                </div>

                <div class="row">
                    <!-- <div class="col-md-3 tipo-unidade">
                        <label>Possui Unidades?</label><br>
                         <label class="radio-inline"> <input class="icheck" type="radio" checked="" name="possui_unidade" value="0" <?php echo isset($res->possui_unidade)&&$res->possui_unidade==0?'checked':'' ?>> Não</label> 
                         <label class="radio-inline"> <input class="icheck" type="radio" name="possui_unidade" value="1" <?php echo isset($res->possui_unidade)&&$res->possui_unidade==1?'checked':'' ?>> Sim</label> 
                    </div> -->

                    <div class="col-md-3">
                        <label>E-mail:</label>
                        <input type="text" class="form-style" name="email" id="email" value='<?php echo $res->email ?>'>
                    </div>

                    <div class="col-md-3 display-unidade">
                        <label>Telefone:</label>
                        <input type="text" class="form-style" data-mask='(99) 9999-9999' name="telefone" id="telefone" value='<?php echo $res->telefone ?>'>
                    </div>

                    <div class="col-md-3 display-unidade">
                        <label>Whatsapp:</label>
                        <input type="text" class="form-style" data-mask='(99) 99999-9999' name="whatsapp" id="whatsapp" value='<?php echo $res->whatsapp ?>'>
                    </div>
                </div>

                <div class="row display-unidade">
                    <div class="col-sm-2">
                        <label>CEP:</label>
                        <input name="cep"  value='<?php echo $res->cep ?>' id="cep" data-mask='99999-999' placeholder="00000-000" class="form-style"  type="text">
                    </div>   

                    <div class="col-sm-5">
                        <label>Endereço:</label>
                        <input name="logradouro"  value='<?php echo $res->logradouro ?>' id="logradouro" placeholder="Rua, Avenida ..." class="form-style"  type="text">
                    </div>   

                    <div class="col-sm-2">
                        <label>Número:</label>
                        <input name="numero"  value='<?php echo $res->numero ?>' id="numero" placeholder="00000" class="form-style" type="text">
                    </div>  

                    <div class="col-sm-3">
                        <label>Complemento:</label>
                        <input name="complemento"  value='<?php echo $res->complemento ?>' id="complemento" class="form-style" type="text">
                    </div>   
                </div>    
                
                <div class="row display-unidade">
                    <div class="col-sm-4">
                        <label>Bairro:</label>
                        <input name="bairro"  value='<?php echo $res->bairro ?>' id="bairro" placeholder="Bairro" class="form-style" type="text">
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

                <!-- <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-warning" href="<?php echo URL_ADMIN.'unidade/' ?>">+ Adicionar unidades</a>
                    </div>
                </div>           -->

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
    $('.tipo-unidade input').on('ifChecked', function(event){
       var value_contrato = event.target.value;
        if (value_contrato == 0) {
            $('.display-unidade').css('display','block');
        } else {
            $('.display-unidade').css('display','none');
        }
    });

    $(document).ready(function(){
        $("#cep").change(function(){
          // Se o campo CEP não estiver vazio
            if($.trim($("#cep").val()) != ""){
              /* 
                  Para conectar no serviço e executar o json, precisamos usar a função
                  getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
                  dataTypes não possibilitam esta interação entre domínios diferentes
                  Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
                  http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val()
              */
              $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
                  // o getScript dá um eval no script, então é só ler!
                  //Se o resultado for igual a 1
                    if(resultadoCEP["resultado"]){

                        $("#carregando").css('display', '');

                        var uf = resultadoCEP["uf"];
                        uf = uf.replace(' ', '');

                        var cidade = unescape(resultadoCEP["cidade"]);
                        console.log(cidade);
                      // troca o valor dos elementos
                      // ID do campo da rua
                      $("#logradouro").val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
                      // ID do campo do bairro
                      $("#bairro").val(unescape(resultadoCEP["bairro"]));
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
                      // $("#cidade").val(unescape(resultadoCEP["cidade"]));
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

$("#cep").change(function () {
    // Se o campo CEP não estiver vazio
    if ($.trim($("#cep").val()) != "") {
        /*
        Para conectar no serviço e executar o json, precisamos usar a função
        getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
        dataTypes não possibilitam esta interação entre domínios diferentes
        Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
        http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val()
         */

        $.get("https://viacep.com.br/ws/" + $("#cep").val() + "/json/", function (data) {
            console.log(data);
            // o getScript dá um eval no script, então é só ler!
            //Se o resultado for igual a 1
            if (!data["erro"]) {

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
                $('#estado_id option:contains(' + uf + ')').each(function () {
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

                $.when($.getJSON("<?php echo URL ?>action/getCidades.php", {
                        estado_id: estado_id
                    }, function (j) {
                        $("select[name=cidade_id]").html('<option value="">Carregando...</option>');
                        var options = '<option value="">Selecione</option>';
                        for (var i = 0; i < j.length; i++) {

                            options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';

                        }
                        $("#cidade_id").html(options);
                    })).done(function () {
                    $('#cidade_id option').each(function () {
                        let cidadeEncontrada = cidade.normalize('NFD').replace(/([\u0300-\u036f]|[^0-9a-zA-Z])/g, '');
                        let cidadeOption = $(this).text() + '';
                        cidadeOption = cidadeOption.normalize('NFD').replace(/([\u0300-\u036f]|[^0-9a-zA-Z])/g, '');

                        if (cidadeOption == cidadeEncontrada) {
                            $(this).attr('selected', 'selected');
                            cidade_id = $(this).val();
                            // return false;
                        }
                        // return true;
                    });
                    $("#cidade_id");

                    $("#carregando").css('display', 'none');
                });

                $('#numero').focus();

                // ID do campo da Cidade
                // $("#cidade").val(unescape(data["cidade"]));
            } else {
                alert("Endereço não encontrado");
            }
        });
    }
});

</script>