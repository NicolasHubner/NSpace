<?php 
  if (isset($_GET['termo_afiliado'])&&$_GET['termo_afiliado']==1) {
    $objCliente->termo_afiliado = 1;
    $objCliente->save();

    header('Location: '.URL.'painel/afiliado/');
  }
?>

<div class="dashboard-wraper">
  <h4 class="mb-20">Afiliado</h4>

  <?php if (isset($objCliente->termo_afiliado)&&$objCliente->termo_afiliado!=1) { ?>
    <form method="get">
      <div class="row">
        <div class="col-md-12">
          <label class="clickTermos"><input type="checkbox" name="termo_afiliado" value="1" required> Eu concordo com os <a href="<?php echo URL ?>termos-de-uso-para-afiliados/" target="in_blank">Termos de Uso para Afiliados</a></label>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12">
          <input type="submit" class="btn btn-primary" value="Concordar e liberar link">
        </div>
      </div>
    </form>
  <?php } ?>

  <?php if (isset($objCliente->termo_afiliado)&&$objCliente->termo_afiliado==1) { ?>
    <div class="form-submit">
    	<?php 
          if (isset($objCliente->verificado)&&$objCliente->verificado==2) {
            if (isset($objCliente->tipo_cliente_id)&&$objCliente->tipo_cliente_id==2) {
              ?>
                <div class="linkAfiliado mb-20">
                  <h5>Link de afiliado:</h5>
                  <p id="linkAfiliado">
                    <?php 
                      echo URL.'?ref=cadastro&codigoAfiliado='.$objCliente->codigo_afiliado;
                    ?>
                    <button class="buttonCoppy" title="Copiar link de afiliado" onclick="copyToClipboard('#linkAfiliado')"><i class="fal fa-copy"></i></button>
                  </p>
                </div>
              <?php 
            }
          }
        ?>
    </div>
  <?php } ?>

  <div style="margin-top: 50px;">
    <p>Saiba mais sobre o termo de <a href="<?php echo URL ?>afiliados/">Afiliados</a>.</p>
    

    <?php 
      $objPagina = Doctrine_Core::getTable('Pagina')->find(12);
      if (isset($objPagina->descricao)&&$objPagina->descricao!='') {
    ?>
      <div class="mt-40">
          <?php echo $objPagina->descricao ?>
      </div>
    <?php } ?>

  </div>
</div>