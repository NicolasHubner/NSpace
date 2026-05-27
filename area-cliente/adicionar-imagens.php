<div class="dashboard-wraper modelImagens-add">
    <div class="form-submit form-row">
      <div class="form-group col-lg-12 col-md-12">
        <h4>Adicionar mais imagens ao seu espaço</h4>
    	</div>

      <?php 
        $retAnuncioFoto  = Doctrine_Query::create()->select()->from('AnuncioFoto')->where('anuncio_id = '.$_GET['refAn'])->execute();
        if ($retAnuncioFoto->count()>0) {
          ?>
            <div class="form-group col-lg-12 col-md-12">
              <div class="FotosAnuncios mb-20">
                <div class="form-row">
                  <?php 
                  foreach ($retAnuncioFoto as $objAnuncioFoto) {
                    ?>
                    <div class="form-group col-md-2">
                      <div class="img">
                        <img src="<?php echo URL_ANUNCIO.$objAnuncioFoto->imagem ?>">
                      </div>
                    </div>
                    <?php 
                  }
                  ?>
                </div>
              </div>
            <?php 
          }
        ?>

        <form class="dropzone modelUploadFoto wdt100" id="dropzoneFotos"  enctype='multipart/form-data'>
          <input type="hidden" name="anuncio_id" class="anuncio_id" value="<?php echo $_GET['refAn'] ?>">
        </form>

        <div class="actionsButtons mt-20">
          <a class="botao-padrao bg-roxo" href="<?php echo URL.'painel/' ?>minhas-propriedades/">Minhas propriedades</a>
          <a class="botao-padrao bg-laranja" href="<?php echo URL.'editar-propriedade/'.$_GET['refAn'] ?>">Editar propriedade</a>
        </div>
      </div>
    </div>
</div>