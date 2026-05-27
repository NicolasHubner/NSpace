<div class="row no-margin-top detalheAdmin">
  <div class="col-md-12">
    <div class="block-flat">
      <div class="header">
        <a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>	
        <h3>Solicitação de Cancelamento - Editar</h3>
      </div>
      <?php 
        $resCancelamento = Doctrine_Core::getTable('Cancelamento')->find($_GET['id']);
      ?>

      <div class="blocoInfo mt-40">
        <h4>Dados do cliente:</h4>

          <?php if (isset($resCancelamento->cliente_id)&&$resCancelamento->cliente_id!='') { ?>
            <div class="singleItem">
              <label>Cliente:</label>
              <span class="text"><?php echo $resCancelamento->Cliente->nome ?></span>
            </div>
          <?php } ?>

          <div class="singleItem">
            <label>Anuncio:</label>
            <span class="text"><a href="<?php echo URL_ADMIN.'espaco/editar/'.$resCancelamento->anuncio_id.'/' ?>"><?php echo $resCancelamento->Anuncio->titulo ?></a></span>
          </div>

          <div class="singleItem">
            <label>Plano:</label>
            <span class="text"><?php echo $resCancelamento->Plano->nome ?></span>
          </div>


        </div>
      </div>
    </div>
  </div>
</div>

