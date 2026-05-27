<form  method="post" class="formPasso01" id="formulario-01">
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
                        $retCategoria = Doctrine_Query::create()->select()->from('Categoria')->orderBy('ordem ASC')->execute();
                        foreach ($retCategoria as $objCategoria) {
                            ?>
                            <option value="<?php echo $objCategoria->id ?>"><?php echo $objCategoria->nome ?></option>
                            <?php 
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label>Preço<a href="#" class="tip-topdata" data-tip="A plataforma Nspace cobra uma taxa de 11% para anúncios, é recomendado já incluir essa porcentagem no preço estipulado."><i class="ti-help"></i></a></label>
                    <input type="text" class="sc-eCApnc btdohk form-control validate[required] valor-input" placeholder="R$" name="valor">
                </div>

                <div class="form-group col-md-3">
                    <label>Tipo de cobrança</label>
                    <select class="form-control" name="tipo_cobranca_id">
                        <option value="">Selecione</option>
                        <option value="1">Hora</option>
                        <option value="2">Dia</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Minimo de Diária/Horas para reserva: <a href="#" class="tip-topdata" data-tip="Mínimo de horas/Dias para alugar, preecha em Nº."><i class="ti-help"></i></a></label>
                    <input type="number" class="sc-eCApnc btdohk form-control validate[required]" placeholder="Informe somente a quantidade" name="periodo_minimo" value="0">
                </div>
                
                <div class="form-group col-md-4">
                    <label>Espaço</label>
                    <input type="number" placeholder="Em m²" class="sc-eCApnc btdohk form-control" name="espaco">
                </div>

                <div class="form-group col-md-4">
                    <label>Limite de pessoas</label>
                    <input type="number" class="sc-eCApnc btdohk form-control validate[required]" placeholder="Digite número máximo de pessoas" name="limite_pessoas">
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
                    <input type="text" class="sc-eCApnc btdohk form-control" name="tags">
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
                    <textarea name="descricao" data-toggle="tooltip" data-placement="top" class="sc-jSFjdj kzdrMp form-control h-120"></textarea>
                </div>

                <div class="form-group col-md-4">
                    <label>Vagas a garagem?</label>
                    <input type="text" name="garagem" class="form-control validate[required]" data-mask="99" value="<?php echo $_GET['garagem'] ?>" />
                </div>

                <div class="form-group col-md-4">
                    <label>Quartos?</label>
                    <input type="text" name="quarto" class="form-control validate[required]" data-mask="99" value="<?php echo $_GET['quarto'] ?>" />
                </div>

                <div class="form-group col-md-4">
                    <label>Banheiros?</label>
                    <input type="text" name="banheiro" class="form-control validate[required]" data-mask="99" value="<?php echo $_GET['banheiro'] ?>" />
                </div>

                <div class="form-group col-md-12">
                    <label>Comodidades</label>
                    <div class="o-features">
                        <div class="row no-ul-list">
                            <div class="col-md-4">
                                <?php 
                                    $opcionais = 0;
                                    $retOpcional = Doctrine_Query::create()->select()->create()->from('Opcional')->orderBy('nome ASC')->execute();
                                    foreach ($retOpcional as $objOpcional) {
                                        ?>
                                            <li>
                                                <input id="ref-<?php echo $objOpcional->id ?>" value="<?php echo $objOpcional->id ?>" class="checkbox-custom" name="opcional_id[]" type="checkbox">
                                                <label for="ref-<?php echo $objOpcional->id ?>" class="checkbox-custom-label"><?php echo $objOpcional->nome ?></label>
                                            </li>
                                        <?php
                                        $opcionais++;
                                        echo $opcionais%8==0?'</div><div class="col-md-4">':'';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row" style="margin: 40px 0px;">
      <div class="form-group col-md-6">
        <label style="font-size: 28px;color: #fd5000;">Selecione a imagem de capa</label><br>
        <label>Tamanho recomendável: 800 pixel x 600 pixel</label><br>
        <input type="file" name="imagem">
        <!-- <input type="hidden" name="y" id="y" />
        <input type="hidden" name="x" id="x" />
        <input type="hidden" name="w" id="w" />
        <input type="hidden" name="h" id="h" />
        <label for="image-file">
          <button type="button" class="btn btn-warning abrirFoto">Selecionar foto de capa</button>
          <div class="photo-upload">
            <div class="photo-edit">
              <input type='file' name="imagem" class="image-file" target='image-file' id="image-file" accept=".png, .jpg, .jpeg" />
            </div>
          </div>
        </label>
        <div id="image-container" class="image-cropped"></div> -->
      </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <input type="hidden" name="etapa" value="1">
            <input type="hidden" name="cliente_id" value="<?php echo $objCliente->id ?>">
            <a href="#ponto-inicial" class="passo-click" onclick="window.location.href='#ponto-inicial'" style="display: none;"></a>
            <button class="btn btn-theme top-scroll" type="submit">Continuar</button>
        </div>
    </div>
</form>