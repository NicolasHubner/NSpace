<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

<?php 
  if (isset($_GET['status_saque_id'])&&$_GET['status_saque_id']=='2') {

    $objSolicitacaoSaque                         = Doctrine_Core::getTable('SolicitacaoSaque')->find($_GET['id']);
    $objSolicitacaoSaque->data_transacao         = date('Y-m-d H:i:s');
    $objSolicitacaoSaque->status_saque_id        = $_GET['status_saque_id'];
    $objSolicitacaoSaque->save();


  }
?>
<div class="row no-margin-top detalheAdmin">
  <div class="col-md-12">
    <div class="block-flat">
      <div class="header">
        <a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>	
        <h3>Soliciação de Saque - Editar</h3>
      </div>
      <?php 
        $resSolicitacaoSaque = Doctrine_Core::getTable('SolicitacaoSaque')->find($_GET['id']);
      ?>

      <div class="blocoInfo mt-40">
        <h4>Dados do cliente:</h4>

          <?php if (isset($resSolicitacaoSaque->cliente_id)&&$resSolicitacaoSaque->cliente_id!='') { ?>
            <div class="singleItem">
              <label>Cliente:</label>
              <span class="text"><?php echo $resSolicitacaoSaque->Cliente->nome ?></span>
            </div>
          <?php } ?>

          <div class="singleItem">
            <label>CPF:</label>
            <span class="text"><?php echo $resSolicitacaoSaque->Cliente->cpf ?></span>
          </div>

          <div class="singleItem">
            <label>Tipo de Transação:</label>
            <span class="text"><?php echo $resSolicitacaoSaque->TipoTransacao->nome ?></span>
          </div>

          <?php if (isset($resSolicitacaoSaque->tipo_transacao_id)&&$resSolicitacaoSaque->tipo_transacao_id==1) { ?>
            <div class="singleItem">
              <label>Agência:</label>
              <span class="text"><?php echo $resSolicitacaoSaque->agencia ?></span>
            </div>

             <div class="singleItem">
              <label>Conta:</label>
              <span class="text"><?php echo $resSolicitacaoSaque->conta ?></span>
            </div>

            <div class="singleItem">
              <label>Dígito/Operação:</label>
              <span class="text"><?php echo $resSolicitacaoSaque->digito ?></span>
            </div>
          <?php } ?> 

          <div class="singleItem">
            <label>Valor:</label>
            <span class="text"><?php echo 'R$'.number_format($resSolicitacaoSaque->valor, 2, ',', '.') ?></span>
          </div> 


          <?php if (isset($resSolicitacaoSaque->data_transacao)&&$resSolicitacaoSaque->data_transacao!='') { ?>
            <div class="singleItem">
              <label>Data da transação:</label>
              <span class="text"><?php echo date('d/m/Y H:i', strtotime($objSolicitacaoSaque->data_transacao)) ?></span>
            </div>
          <?php } ?>

          <div class="singleItem">
            <label>Status:</label>
            <span class="text"><?php echo $resSolicitacaoSaque->StatusSaque->nome ?></span>
          </div>

          <?php if (isset($resSolicitacaoSaque->status_saque_id)&&$resSolicitacaoSaque->status_saque_id!=2) { ?>
            <a class="btn btn-success solicitar-saque" href="">Transação efetuada</a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // 'solicitacao-saque/detalhes/'.$resSolicitacaoSaque->id.'/?status_saque_id=2'
  $('.solicitar-saque').click(function (e) { 
    e.preventDefault();
    Lobibox.confirm({
      title: 'Ação',
      msg: '<center>Confirma que a transferência/depósito foi realizada com suceso?<center>',
      callback: function(lobibox, type){
        if(type == "yes"){
          window.location.href = URL_SITE+'solicitacao-saque/detalhes/<?php echo $resSolicitacaoSaque->id ?>/?status_saque_id=2'; 
        } 
      }
    });
  });
</script>
