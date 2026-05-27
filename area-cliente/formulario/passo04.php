<form  method="post" class="formPasso04" id="formulario-04">
    <div class="form-submit">
        <form class="formAnuncioDoc" id="formulario-documento">
           <div class="form-row">
              <div class="form-group col-lg-12 col-md-12">
                <h3 style="margin-left: 0px;">Documentações necessárias:</h3>
              </div>

              <div class="form-group col-lg-12 col-md-12">
                <label><input type="checkbox" name="local_proprio" id="local_proprio" value="1"> Eu sou o proprietário do espaço</label>
                <div class="mb-10"><span style="color: red; font-weight: 600; font-size: 14px;">OBS: A identidade do proprietário precisa combinar com a identidade do dono da conta.</span></div>
              </div>

              <div class="form-group col-md-12 displayIdentidade">
                <label>Identidade do proprietário :</label>
                <input type="file" name="comprovante_identidade" class="form-control validate[required]">
              </div>

              <div class="form-group col-md-12 displayDocumento">
                <label>Comprovante de endereço:</label>
                <input type="file" name="comprovante_endereco" class="form-control validate[required]">
              </div>
          </div>

           <div class="form-row">
                <div class="form-group col-md-12">
                    <input type="hidden" name="etapa" value="4">
                    <input type="hidden" name="cliente_id" value="<?php echo $objCliente->id ?>">
                    <input type="hidden" class="anuncio_id" name="anuncio_id">
                    <button class="btn btn-theme top-scroll" type="submit">Continuar</button>
                </div>
            </div>
        </form>
    </div>  
</form>