<div class="submit-section">
    <form  method="post" class="formPasso02" id="formulario-02">
        <div class="form-row">
            <div class="form-group col-md-12">
                <h3>Localização</h3>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <label>CEP</label>
                <input type="text" class="form-control validate[required]" name="cep" id="cep" data-mask='99999-999' >
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Logradouro</label>
                <input type="text" class="form-control validate[required]" name="logradouro" id="logradouro">
            </div>

            <div class="form-group col-md-3">
                <label>Número</label>
                <input type="text" class="form-control validate[required]" name="numero" id="numero">
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
                    data-toggle="tooltip" class="form-control validate[required]">
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

        <div class="form-row">
            <div class="form-group col-md-12">
                <input type="hidden" name="etapa" value="2">
                <input type="hidden" name="cliente_id" value="<?php echo $objCliente->id ?>">
                <input type="hidden" class="anuncio_id" name="anuncio_id">
                <a href="#ponto-inicial" class="passo-click" onclick="window.location.href='#ponto-inicial'" style="display: none;"></a>
                <button class="btn btn-theme top-scroll" type="submit">Continuar</button>
            </div>
        </div>
    </form>
</div>  