<?php
	include('lib/Config.php');
	ob_start();

	$tipoHeader = 'light';
	if (!isset($_SESSION['sess_cliente_id'])) {
		header('Location: '.URL.'?ref=login');
	}

  $objCliente = Doctrine_Core::getTable('Cliente')->find($_SESSION['sess_cliente_id']);

  $resAnuncio = Doctrine_Core::getTable('Anuncio')->find($_GET['id']);
?>

<div class="page-title bg-laranja">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h2 class="ipt-title">Editar espaço</h2>
                <span style="font-family: Montserrat; font-size: 20px;">Preencha os campos para adicionar seu espaço</span>
            </div>
        </div>
    </div>
</div>

<section class="modelCriacaoPropriedade">
      <div class="container">
          <?php if (isset($resAnuncio->aviso)&&$resAnuncio->aviso!='' && isset($resAnuncio->status_id)&&$resAnuncio->status_id==3) { ?>
              <div class="AvisoReprovado">
                <div><i class="fal fa-exclamation"></i> <?php echo $resAnuncio->Status->nome ?>: <?php echo $resAnuncio->aviso ?></div>
              </div>
          <?php } ?>
          <div class="row">
              <div class="col-lg-12 col-md-12">
                  <div class="passo-01">
                    <form method="post" class="formEditar" id="formulario-editar-propriedade">
                        <div class="submit-page">
                            <div class="form-submit">
                                <h3>Informações do Espaço</h3>
                                <div class="submit-section">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Título do espaço<a href="#" class="tip-topdata" data-tip="Dê um título chamativo para sua propriedade"><i class="ti-help"></i></a></label>
                                            <input type="text" class="sc-eCApnc btdohk form-control validate[required]" name="titulo" value="<?php echo $resAnuncio->titulo ?>">
                                        </div>

                                        <div class="form-group col-md-6">
                                          <label>Tipo do local</label>
                                          <select class="form-control validate[required]" name="categoria_id">
                                              <option value="">Selecione</option>
                                              <?php 
                                                $retCategoria = Doctrine_Query::create()->select()->from('Categoria')->orderBy('ordem ASC')->execute();
                                                foreach ($retCategoria as $objCategoria) {
                                                  $selected = isset($resAnuncio->categoria_id)&&$resAnuncio->categoria_id==$objCategoria->id?'selected':'';
                                                  ?>
                                                    <option value="<?php echo $objCategoria->id ?>" <?php echo $selected ?>><?php echo $objCategoria->nome ?></option>
                                                  <?php 
                                              }
                                          ?>
                                          </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Preço</label>
                                            <input type="text" class="sc-eCApnc btdohk form-control validate[required] valor-input" placeholder="R$" name="valor" value="<?php echo number_format($resAnuncio->valor, 2, ',', '.') ?>">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Tipo de cobrança</label>
                                            <select class="form-control" name="tipo_cobranca_id" id="tipo_cobranca_id"> 
                                                <option value="">Selecione</option>
                                                <option value="1" <?php echo isset($resAnuncio->tipo_cobranca_id)&&$resAnuncio->tipo_cobranca_id==1?'selected':'' ?>>Hora</option>
                                                <option value="2" <?php echo isset($resAnuncio->tipo_cobranca_id)&&$resAnuncio->tipo_cobranca_id==2?'selected':'' ?>>Dia</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Minimo de Diária/Horas para reserva: </label>
                                            <input type="number" class="sc-eCApnc btdohk form-control validate[required]" placeholder="Informe somente a quantidade" name="periodo_minimo" value="<?php echo $resAnuncio->periodo_minimo ?>">
                                        </div>
                
                                        <div class="form-group col-md-4">
                                            <label>Espaço</label>
                                            <input type="text" placeholder="Em m²" class="sc-eCApnc btdohk form-control" name="espaco" value="<?php echo $resAnuncio->espaco ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Limite de pessoas</label>
                                            <input type="text" class="sc-eCApnc btdohk form-control validate[required]" placeholder="Digite número máximo de pessoas" name="limite_pessoas" value="<?php echo $resAnuncio->limite_pessoas ?>">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                      <div class="form-group col-md-12">
                                            <label>Tags: (separadas por vírgula) <a href="#" class="tip-topdata" data-tip="As tags são palavras chaves utilizadas para localizar seu espaço."><i class="ti-help"></i></a></label>
                                            <ul class="no-ul-list third-row">
                                              <?php 
                                                $retTags = Doctrine_Query::create()->select()->create()->from('Tags')->orderBy('nome ASC')->execute();
                                                foreach ($retTags as $objTags) {
                                                  ?>
                                                    <li>
                                                          <input id="tags-<?php echo $objTags->id ?>" value="<?php echo $objTags->id ?>" class="checkbox-custom" name="tags_id[]" type="checkbox">
                                                          <label for="tags-<?php echo $objTags->id ?>" class="checkbox-custom-label"><?php echo $objTags->nome ?></label>
                                                      </li>
                                                  <?php
                                                }
                                              ?>
                                            </ul>
                                            <input type="text" class="sc-eCApnc btdohk form-control" name="tags" value="<?php echo $resAnuncio->tags ?>">
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
                                          <input type="text" class="form-control" name="cep" id="cep" data-mask='99999-999' value="<?php echo $resAnuncio->cep ?>">
                                      </div>
                                    </div>

                                    <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <label>Logradouro</label>
                                          <input type="text" class="form-control" name="logradouro" id="logradouro" value="<?php echo $resAnuncio->logradouro ?>">
                                      </div>

                                      <div class="form-group col-md-3">
                                          <label>Número</label>
                                          <input type="text" class="form-control" name="numero" id="numero" value="<?php echo $resAnuncio->numero ?>">
                                      </div>

                                      <div class="form-group col-md-3">
                                          <label>Complemento</label>
                                          <input type="text" class="form-control" name="complemento" id="complemento" value="<?php echo $resAnuncio->complemento ?>">
                                      </div>
                                    </div>

                                    <div class="form-row">
                                      <div class="form-group col-md-4">
                                          <label>Bairro</label>
                                          <input type="text" class="form-control" name="bairro" id="bairro"  value="<?php echo $resAnuncio->bairro ?>">
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
                                                        $selected = $value['id']==$resAnuncio->estado_id?"selected":"";
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
                                            <?php
                                            try {

                                                $resCidade = Doctrine_Query::create()->select()->from('Cidade')->where('estado_id = '.$resAnuncio->estado_id)->execute();

                                                if ($resCidade->count() > 0) {
                                                    $resCidade->toArray();

                                                    foreach ($resCidade as $value) {
                                                        $selected = $value['id']==$resAnuncio->cidade_id?"selected":"";
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
                                </div>
                            </div>
                            <div class="form-submit">
                                <h3>Informações detalhadas</h3>
                                <div class="submit-section">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Descrição(Max 301 caracteres)</label>
                                            <textarea data-toggle="tooltip" data-placement="top" class="sc-jSFjdj kzdrMp form-control h-120" name="descricao"><?php echo $resAnuncio->descricao ?></textarea>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>Vagas a garagem?</label>
                                            <input type="text" name="garagem" class="form-control validate[required]" data-mask="99" value="<?php echo $resAnuncio->garagem ?>" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Quartos?</label>
                                            <input type="text" name="quarto" class="form-control validate[required]" data-mask="99" value="<?php echo $resAnuncio->quarto ?>" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Banheiros?</label>
                                            <input type="text" name="banheiro" class="form-control validate[required]" data-mask="99" value="<?php echo $resAnuncio->banheiro ?>" />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Comodidades</label>
                                            <div class="o-features">
                                              <div class="row no-ul-list">
                                                <?php 
                                                  $colunas = 0;
                                                  $resAnuncioOpcional = Doctrine_Query::create()->select()->from('AnuncioOpcional')->where('anuncio_id = '.$resAnuncio->id)->execute();

                                                   $opcional_id = array();
                                                   foreach ($resAnuncioOpcional as $key => $objAnuncioOpcional) {
                                                     $opcional_id[] = $objAnuncioOpcional->opcional_id;
                                                   }

                                                  $retOpcional = Doctrine_Query::create()->select()->create()->from('Opcional')->orderBy('nome ASC')->execute();
                                                  foreach ($retOpcional as $objOpcional) {
                                                  $selected = in_array($objOpcional->id, $opcional_id)?"checked":"";
                                                    ?>
                                                      <div class="col-md-4">
                                                        <li>
                                                          <input id="ref-<?php echo $objOpcional->id ?>" value="<?php echo $objOpcional->id ?>" class="checkbox-custom" name="opcional_id[]" type="checkbox" <?php echo $selected ?>>
                                                          <label for="ref-<?php echo $objOpcional->id ?>" class="checkbox-custom-label"><?php echo $objOpcional->nome ?></label>
                                                        </li>
                                                      </div>
                                                    <?php
                                                    $colunas++;
                                                    // echo $colunas%10==0?'</div><div class="col-md-4">':'';
                                                  }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <!-- <div class="row">
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
                            </div> -->

                            <?php 
                              if (isset($resAnuncio->imagem)&&$resAnuncio->imagem!='') {
                                $imagem = URL_ANUNCIO.$resAnuncio->imagem;
                              }
                            ?>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>Tamanho recomendável: 800 pixel x 600 pixel</label><br>
                                <input type="hidden" name="y" id="y" />
                                <input type="hidden" name="x" id="x" />
                                <input type="hidden" name="w" id="w" />
                                <input type="hidden" name="h" id="h" />
                                <label for="image-file">
                                  <button type="button" class="btn btn-warning abrirFoto">Selecionar capa</button>
                                  <a class="btn btn-primary" href="<?php echo URL.'painel/adicionar-imagens/?refAn='.$resAnuncio->id ?>">Adicionar mais fotos</a>
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


                            <div class="FotosAnuncios">
                              <div class="form-row">
                                <?php 
                                $retAnuncioFoto  = Doctrine_Query::create()->select()->from('AnuncioFoto')->where('anuncio_id = '.$resAnuncio->id)->execute();
                                foreach ($retAnuncioFoto as $objAnuncioFoto) {
                                  ?>
                                  <div class="form-group col-md-2">
                                    <label><input type="checkbox" name="remover_imagem[]" value="<?php echo $objAnuncioFoto->id ?>"> Remover</label>
                                    <div class="img">
                                      <img src="<?php echo URL_ANUNCIO.$objAnuncioFoto->imagem ?>">
                                    </div>
                                  </div>
                                  <?php 
                                }
                                ?>
                              </div>
                            </div>

                           <div class="quadReferencia">
                              <div class="form-group col-lg-12 col-md-12">
                              <label>Adicione pontos de referência próximos ao seu espaço:</label>
                              
                              <div class="block-body">
                                <div class="nearby-wrap">
                                  <div class="neary_section_list">
                                    <?php 
                                      $retAnuncioReferencia = Doctrine_Query::create()->select()->from('AnuncioReferencia')->where('anuncio_id = '.$resAnuncio->id)->execute();
                                      foreach ($retAnuncioReferencia as $objAnuncioReferencia) {
                                        ?>
                                          <div class="neary_section">
                                            <div class="neary_section_first">
                                              <label style="font-size: 12px;font-weight: 600;"><input type="checkbox" name="remover_iten[]" value="<?php echo $objAnuncioReferencia->id ?>"> Remover</label>
                                              <h4 class="nearby_place_title"><?php echo $objAnuncioReferencia->nome ?></h4>
                                            </div>
                                            <div class="neary_section_last">
                                              <div class="nearby_place_rate good" style="background-color: <?php echo $objAnuncioReferencia->background ?>"><?php echo $objAnuncioReferencia->km.' km' ?></div>
                                            </div>
                                          </div>
                                        <?php 
                                      }
                                    ?>                                    
                                  </div>
                                </div>
                              </div>

                              <div id="form_input_modele">
                                <label>Nome: <input type="text" class="form-control" name="referencia_nome[]" style="width: 330px;"></label>
                                <label>KM: <input type="number" class="form-control" name="referencia_km[]"></label>
                              </div>
                              <div id="form_input_adds"></div>
                              <button type="button" class="btn btn-primary" id="btn_add_input" data-nbre="0" data-max="5">+</button>
                            </div>
                           </div>

                        <div class="form-row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label>Termos de uso *</label>
                                <ul class="no-ul-list">
                                    <li>
                                        <input id="termo-01" class="checkbox-custom validate[required]" name="termo" value="1" <?php echo isset($resAnuncio->termo)&&$resAnuncio->termo==1?'checked':'' ?> type="checkbox">
                                        <label for="termo-01" class="checkbox-custom-label">Consinto que este site armazene minhas informações enviadas para que possam responder à minha consulta.</label>
                                    </li>
                                </ul>
                            </div>

                            <div class="form-group col-lg-12 col-md-12">
                              <input type="hidden" name="anuncio_id" value="<?php echo $resAnuncio->id ?>">
                              <input type="hidden" name="cliente_id" value="<?php echo $objCliente->id ?>">
                              <button class="btn btn-theme top-scroll" type="submit">Salvar dados</button>
                            </div>
                        </div>
                    </form>
                  </div>
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

  $('.formEditar').validationEngine({
        scroll: false
    });
  $('.formEditar').submit(function(e) {
      e.preventDefault();
      if ($(this).validationEngine('validate')) {
          var formulario = document.getElementById('formulario-editar-propriedade');
          var formData = new FormData(formulario);

          $.ajax({
              url: URL_SITE + 'action/editPropriedade.php',
              processData: false,
              contentType: false,
              type: 'POST',
              dataType: 'json',
              data: formData,
              success: function(response) {
                if (response.status ==1) {
                  Lobibox.notify('success', {
                    delay: 1900,
                    position: "top right", 
                    title: 'Sucesso',
                    dataType: "json",
                    icon: true,
                    msg: 'Dados editados com sucesso!'
                  });

                  setTimeout(() => {
                   window.location.href = URL_SITE+'painel/dashboard/';
                  }, 2000);
                }
              }
          });
      }
  });


  function readURL(input, target) {
      $('.formEditar #image-container').css('display', 'block');

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

   "use strict";
const btn_add_input = document.getElementById("btn_add_input");
const form_input_modele = document.getElementById("form_input_modele");
const form_input_adds = document.getElementById("form_input_adds");

btn_add_input.addEventListener( 'click', function() {
  let nbre_add = Number(btn_add_input.dataset.nbre);
  let nbre_max = Number(btn_add_input.dataset.max);
  if( nbre_add < nbre_max )
  {
    btn_add_input.dataset.nbre = Number(btn_add_input.dataset.nbre)+1;
    // -----------
    // on clone le div modele
    let form_input_clone = form_input_modele.cloneNode(true);
    form_input_clone.removeAttribute('id'); // on supprime l attribut id du clone (car un id est unique)
    // -----------
    // bouton de suppression de la ligne
    let button = document.createElement("button");
    button.type = "button";
    button.classList.add("minus");
    button.classList.add("btn");
    button.classList.add("btn-primary");
    button.textContent = "-";
    button.addEventListener ( // le bouton "-" supprime tout le div
      "click",function(e){
        form_input_adds.removeChild(e.target.parentElement);
        e.preventDefault();
        btn_add_input.dataset.nbre = Number(btn_add_input.dataset.nbre)-1;
        btn_add_input.style.display = 'block';
      }
    );
    // -----------
    form_input_clone.appendChild(button);
    form_input_adds.appendChild(form_input_clone);
    // -----------
    // nombre maxi atteint
    if( nbre_add == nbre_max-1 )
    {
      btn_add_input.style.display = 'none';
    }
    // -----------
  }
});
</script>