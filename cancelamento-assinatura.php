<?php
    include('lib/Config.php');
  	ob_start();

    $tipoHeader = 'light';

    $objAnuncio                     = Doctrine_Core::getTable('Anuncio')->find($_GET['anuncio_id']);

?>

    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title">Cancelamento</h2>

                    <div class="breadcumb">
                        <ul class="menuAcompanhador">
                            <li><a href="<?php echo URL ?>"><i class="fal fa-chevron-double-right"></i> Início</a></li>
                            <li><a class="active" href="javascript:void(0);"><i class="fal fa-chevron-double-right"></i> Cancelamento</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="container text-center">
            <form class="formCancelamento" id="formulario-cancelamento">
                <h3><?php echo $objAnuncio->titulo ?></h3>

                <div class="imagem" style="width: 600px;
                margin: 0px auto;
                border-radius: 5px;
                overflow: hidden;
                margin-bottom: 15px;">
                    <img src="<?php echo URL_ANUNCIO.$objAnuncio->imagem ?>" style="width: 100%;">
                </div>
                <h3><?php echo $objAnuncio->Plano->nome ?></h3>

                <input type="submit" class="btn btn-primary" value="Solicitar cancelamento">
            </form>
        </div>
    </div>

<?php
    $obContent = ob_get_contents();
    ob_end_clean();
    include('base.php');
?>

<script type="text/javascript">
    $('.formCancelamento').click(function(e) {
      e.preventDefault();

         let element = $(this);

      Lobibox.confirm({
        title: 'Ação',
        msg: '<center>Deseja solicitar o cancelamento da sua assinatura?<center>',
        callback: function(lobibox, type){
          if(type == "yes"){
            $.ajax({
              url: URL_SITE + 'action/cancelarAssinatura.php',
              type: 'POST',
              dataType: 'json',
              data: {anuncio_id: '<?php echo $objAnuncio->id ?>', plano_id: '<?php echo $objAnuncio->plano_id ?>', cliente_id: '<?php echo $_GET['cliente_id'] ?>',},
              success: function(response) {
                if (response.status ==1) {
                  Lobibox.notify('success', {
                    delay: 1900,
                    position: "top right", 
                    title: 'Sucesso',
                    dataType: "json",
                    icon: true,
                    msg: 'Solicitação de cancelamento efetuada!'
                  });
                  setTimeout(() => {
                    window.location.href = URL_SITE+'painel/minhas-propriedades/';
                  }, 2000);
                }
              }
            });
          } 
        }
      });
    });
</script>