<?php
  	include('lib/Config.php');
  	ob_start();

  	$tipoHeader = 'light';
  	if (!isset($_SESSION['sess_cliente_id'])) {
  		header('Location: '.URL.'?ref=login');
  	}

	$objCliente = Doctrine_Core::getTable('Cliente')->find($_SESSION['sess_cliente_id']);

	if (isset($objCliente->tipo_cliente_id)&&$objCliente->tipo_cliente_id!=2) {
		header('Location: '.URL.'painel/solicitacao/');
	}
?>

<div class="page-title bg-laranja">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h2 class="ipt-title">Adicionar Espaço</h2>
                <span style="font-family: Montserrat; font-size: 20px;">Preencha os campos para adicionar seu espaço</span>
            </div>
        </div>
    </div>
</div>

<section class="modelCriacaoPropriedade">
      <div class="container">
          <div class="row">
              <div class="col-lg-12 col-md-12">
                  <div class="passo-01">
                    <form method="post" class="formAnunciar" id="formulario-propriedade">
                        <div class="submit-page">
                            <div class="form-submit">
                                <h3>Informações do Espaço</h3>
                                <div class="submit-section">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Título do espaço<a href="#" class="tip-topdata" data-tip="Dê um título chamativo para sua propriedade"><i class="ti-help"></i></a></label>
                                            <input type="text" class="sc-eCApnc btdohk form-control validate[required]" name="titulo">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Tipo do local</label>
                                            <select class="form-control validate[required]" name="categoria_id">
                                                <option value="">Selecione</option>
                                                <?php 
                                                  $retCategoria = Doctrine_Query::create()->select()->from('Categoria')->execute();
                                                  foreach ($retCategoria as $objCategoria) {
                                                    ?>
                                                      <option value="<?php echo $objCategoria->id ?>"><?php echo $objCategoria->nome ?></option>
                                                    <?php 
                                                }
                                            ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Preço</label>
                                            <input type="text" class="sc-eCApnc btdohk form-control validate[required] valor-input" placeholder="R$" name="valor">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Tipo de cobrança</label>
                                            <select class="form-control" name="tipo_cobranca_id">
                                                <option value="">Selecione</option>
                                                <option value="1">Hora</option>
                                                <option value="2">Dia</option>
                                                <option value="3">Quinzena</option>
                                                <option value="4">Mês</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Espaço</label>
                                            <input type="text" placeholder="Em m²" class="sc-eCApnc btdohk form-control" name="espaco">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Limite de pessoas</label>
                                            <input type="text" class="sc-eCApnc btdohk form-control validate[required]" placeholder="Digite número máximo de pessoas" name="limite_pessoas">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Código</label>
                                            <input type="text" class="sc-eCApnc btdohk form-control" placeholder="Código do espaço" name="codigo">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                      <div class="form-group col-md-12">
                                            <label>Tags: (separadas por vírgula) <a href="#" class="tip-topdata" data-tip="As tags são palavras chaves utilizadas para localizar seu espaço."><i class="ti-help"></i></a></label>
                                            <input type="text" class="sc-eCApnc btdohk form-control validate[required]" name="tags">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="form-submit">
                                <h3>Localização</h3>
                                <div class="submit-section">
                                    <div class="form-row">
                                      <div class="form-group col-md-3">
                                          <label>CEP</label>
                                          <input type="text" class="form-control" name="cep" id="cep" data-mask='99999-999' >
                                      </div>
                                    </div>

                                    <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <label>Logradouro</label>
                                          <input type="text" class="form-control" name="logradouro" id="logradouro">
                                      </div>

                                      <div class="form-group col-md-3">
                                          <label>Número</label>
                                          <input type="text" class="form-control" name="numero" id="numero">
                                      </div>

                                      <div class="form-group col-md-3">
                                          <label>Complemento</label>
                                          <input type="text" class="form-control" name="complemento" id="complemento">
                                      </div>
                                    </div>

                                    <div class="form-row">
                                      <div class="form-group col-md-4">
                                          <label>Bairro</label>
                                          <input type="text" class="form-control" name="bairro" id="bairro">
                                      </div>

                                      <div class="form-group col-md-4">
                                                    <label>Estado:</label>
                                                    <select name="estado_id" id="estado_id" data-live-search="true" data-width="100%"
                                                            data-toggle="tooltip" class="form-control">
                                                        <option value="">Estado</option>
                                                        <?php
                                                        try {

                                                            $resAtiv = Doctrine_Query::create()->select()->from('Estado')->execute();

                                                            if ($resAtiv->count() > 0) {
                                                                $resAtiv->toArray();

                                                                foreach ($resAtiv as $value) {
                                                                    $selected = $value['id']==$objCliente->estado_id?"selected":"";
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

                                      <div class="form-group col-md-4">
                                                    <label>Cidade:</label>
                                                    <select class='form-control' data-live-search="true" data-width="100%"
                                                            data-toggle="tooltip" name="cidade_id" id='cidade_id'>
                                                        <option value="">Selecione o estado</option>
                                                    </select>
                                                </div>  
                                    </div>  
                                </div>
                            </div>
                            <div class="form-submit">
                                <h3>Informações detalhadas</h3>
                                <div class="submit-section">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Descrição(Max 301 caracteres)</label>
                                            <textarea data-toggle="tooltip" data-placement="top" class="sc-jSFjdj kzdrMp form-control h-120"></textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Vagas de garagem</label>
                                            <select id="garage" class="form-control" name="garagem">
                                                <option value="">Selecione</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4+</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Quartos</label>
                                            <select id="bedrooms" class="form-control" name="quarto">
                                                <option value="">Selecione</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Banheiros</label>
                                            <select id="bathrooms" class="form-control" name="banheiro">
                                                <option value="">Selecione</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Comodidades</label>
                                            <div class="o-features">
                                                <ul class="no-ul-list third-row">
                                                  <?php 
                                                    $retOpcional = Doctrine_Query::create()->select()->create()->from('Opcional')->orderBy('nome ASC')->execute();
                                                    foreach ($retOpcional as $objOpcional) {
                                                      ?>
                                                        <li>
                                                              <input id="ref-<?php echo $objOpcional->id ?>" value="<?php echo $objOpcional->id ?>" class="checkbox-custom" name="opcional_id[]" type="checkbox">
                                                              <label for="ref-<?php echo $objOpcional->id ?>" class="checkbox-custom-label"><?php echo $objOpcional->nome ?></label>
                                                          </li>
                                                      <?php
                                                    }
                                                  ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card-header" id="Packages">
                                        <h2 class="mb-0"><button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#extraPackages" aria-expanded="false" aria-controls="extraSer">Dê  uma olhada nos pacotes de impulsionamento disponíveis</button></h2></div>
                                    <div id="extraPackages" class="collapse" aria-labelledby="Packages" data-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 c-l-sm-12">
                                                <div class="package-box"><span class="theme-cl">Plano Padrão(Gratuito)</span>
                                                    <h4 class="packages-features-title">R$0,00</h4>
                                                    <ul class="packages-lists-list">
                                                        <li>Impulsionamento padrão</li>
                                                    </ul>
                                                    <div class="buypackage">
                                                        <div class="switchbtn paying">
                                                            <input id="gold" class="switchbtn-checkbox" type="radio" name="plano_id" value="1" checked="">
                                                            <label class="switchbtn-label" for="gold"></label>
                                                        </div><span>Mudar de plano</span></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 c-l-sm-12">
                                                <div class="package-box"><span class="theme-cl">Plano Avião</span>
                                                    <h4 class="packages-features-title">R$19,90</h4>
                                                    <ul class="packages-lists-list">
                                                        <li>Maior Visibilidade</li>
                                                    </ul>
                                                    <div class="buypackage">
                                                        <div class="switchbtn paying">
                                                            <input id="premium" class="switchbtn-checkbox" type="radio" name="plano_id" value="2">
                                                            <label class="switchbtn-label" for="premium"></label>
                                                        </div><span>Mudar de plano</span></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 c-l-sm-12">
                                                <div class="package-box"><span class="theme-cl">Plano Foguete</span>
                                                    <h4 class="packages-features-title">R$40,00</h4>
                                                    <ul class="packages-lists-list">
                                                        <li>Seja visto por milhares de pessoas!</li>
                                                    </ul>
                                                    <div class="buypackage">
                                                        <div class="switchbtn paying">
                                                            <input id="standard" class="switchbtn-checkbox" type="radio" name="plano_id" value="3">
                                                            <label class="switchbtn-label" for="standard"></label>
                                                        </div><span>Mudar de plano</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>Tamanho recomendável: 800 pixel x 600 pixel</label><br>
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
                                  <img id="imageInputUpl" src="<?php echo $imagem ?>">
                                </div>
                              </div>
                            </div>

                            <div class="form-group col-lg-12 col-md-12">
                                <label>Termos de uso *</label>
                                <ul class="no-ul-list">
                                    <li>
                                        <input id="termo-01" class="checkbox-custom" name="termo" type="checkbox">
                                        <label for="termo-01" class="checkbox-custom-label">Consinto que este site armazene minhas informações enviadas para que possam responder à minha consulta.</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group col-lg-12 col-md-12">
                              <input type="hidden" name="cliente_id" value="<?php echo $objCliente->id ?>">
                                <button class="btn btn-theme top-scroll" type="submit">Continuar</button>
                            </div>
                        </div>
                    </form>
                  </div>

                  <div class="passo-02">
                    <form class="formAnuncioDoc" id="formulario-documento">
                      <div class="form-group col-lg-12 col-md-12">
                        <h3>Documentações necessárias:</h3>
                      </div>

                      <div class="form-group col-lg-12 col-md-12">
                        <label><input type="checkbox" name="local_proprio" id="local_proprio" value="1"> O local está em meu nome</label>
                      </div>

                      <div class="form-group col-md-12 displayDocumento">
                        <label>Comprovante de endereço</label>
                        <input type="file" name="comprovante_endereco" class="form-control validate[required]">
                      </div>

                      <div class="form-group col-lg-12 col-md-12">
                        <input type="hidden" name="anuncio_id" class="anuncio_id">
                        <button class="btn btn-theme top-scroll" type="submit">Cadastrar</button>
                      </div>
                    </form>
                  </div>

                  <div class="loadingadmins text-center">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="25 25 50 50">
                    <circle cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke="#fd5000" stroke-linecap="round"
                      stroke-dashoffset="0" stroke-dasharray="100, 200">
                      <animateTransform attributeName="transform" attributeType="XML" type="rotate" from="0 50 50" to="360 50 50"
                        dur="2.5s" repeatCount="indefinite" />
                      <animate attributeName="stroke-dashoffset" values="0;-30;-124" dur="1.25s" repeatCount="indefinite" />
                      <animate attributeName="stroke-dasharray" values="0,200;110,200;110,200" dur="1.25s"
                        repeatCount="indefinite" />
                    </circle>
                  </svg>
                  <h4>Cadastrando seu espaço</h4>
                </div>

                <div class="retornoNotif success text-center mt-20">
                  <i class="fas fa-check"></i>
                  <h4>Sua propriedade foi enviada com sucesso</h4>
                  <p>Estamos analisando os dados da sua propriedade. Após a aprovação será publicada!</p>             
                  <a class="btn btn-success" href="<?php echo URL.'painel/' ?>minhas-propriedades/">Ir para minha propriedades</a>
                </div>
              </div>
          </div>
      </div>
  </section>



<?php
  	$obContent = ob_get_contents();
  	ob_end_clean();
  	include('base.php');
?>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.maskMoney.js"></script>

<script type="text/javascript">
    $(".valor-input").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

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

  $('.formAnunciar').validationEngine({
        scroll: false
    });
  $('.formAnunciar').submit(function(e) {
      e.preventDefault();
      if ($(this).validationEngine('validate')) {

        $('.modelCriacaoPropriedade .passo-01').css('display','none');
        $('.modelCriacaoPropriedade .loadingadmins').css('display','block');

          var formulario = document.getElementById('formulario-propriedade');
          var formData = new FormData(formulario);

          $.ajax({
              url: URL_SITE + 'action/addPropriedade.php',
              processData: false,
              contentType: false,
              type: 'POST',
              dataType: 'json',
              data: formData,
              success: function(response) {
                if (response.status ==1) {
                  setTimeout(() => {
                    $('.modelCriacaoPropriedade .loadingadmins').css('display','none');
                    $('.modelCriacaoPropriedade .passo-02').css('display','block');
                    if (response.anuncio != '') {
                        $('.modelCriacaoPropriedade .passo-02 .anuncio_id').val(response.anuncio_id);
                    }
                  }, 2500);
                }
              }
          });
      }
  });

   $('.formAnuncioDoc').validationEngine({
        scroll: false
    });
  $('.formAnuncioDoc').submit(function(e) {
      e.preventDefault();
      if ($(this).validationEngine('validate')) {

        $('.modelCriacaoPropriedade .passo-02').css('display','none');
        $('.modelCriacaoPropriedade .loadingadmins').css('display','block');

          var formulario = document.getElementById('formulario-documento');
          var formData = new FormData(formulario);

          $.ajax({
              url: URL_SITE + 'action/addPropriedadeDocumentos.php',
              processData: false,
              contentType: false,
              type: 'POST',
              dataType: 'json',
              data: formData,
              success: function(response) {
                if (response.status ==1) {
                  setTimeout(() => {
                    $('.modelCriacaoPropriedade .loadingadmins').css('display','none');
                    $('.modelCriacaoPropriedade .retornoNotif').css('display','block');
                    
                  }, 2500);
                }
              }
          });
      }
  });

  function readURL(input, target) {
      $('.formDados #image-container').css('display', 'block');

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
              aspectRatio: 800/600,
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

    $('.formSolicitacao').validationEngine({
        scroll: false
    });
    $('.formSolicitacao').submit(function(e) {
        e.preventDefault();
        if ($(this).validationEngine('validate')) {

            var formulario = document.getElementById('formulario-solicitacao');
            var formData = new FormData(formulario);

          $('.modelSolicitacao .formSolicitacao').css('display', 'none');
          $('.modelSolicitacao .loadingadmins').css('display', 'block');

            $.ajax({
                url: URL_SITE + 'action/addSolicitacaoParaLocatario.php',
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                  if (response.status ==1) {
                    setTimeout(() => {
                      $('.modelSolicitacao .loadingadmins').css('display', 'none');
                      $('.modelSolicitacao .retornoNotif').css('display', 'block');
                    }, 2000);
                  } 
                }
            });
        }
    });

    $("#local_proprio").change(function() {
      if($(this).is(':checked')){
        $('.modelCriacaoPropriedade .passo-02 .displayDocumento').css('display', 'none');
      } else {
        $('.modelCriacaoPropriedade .passo-02 .displayDocumento').css('display', 'block');
      }
    });
   
</script>