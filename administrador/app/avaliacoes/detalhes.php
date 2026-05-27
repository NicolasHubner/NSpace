<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top detalheAdmin">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">
				<h3>Avaliação - Detalhes</h3>
			</div>
			<?php 
		        $resReservaAvaliacao = Doctrine_Core::getTable('ReservaAvaliacao')->find($_GET['id']);

		        if (isset($_GET['status'])&&$_GET['status']==1) {

		        	$resReservaAvaliacao->status 		= 1;
		        	$resReservaAvaliacao->save();

		        }

		      ?>

		    <div class="blocoInfo mt-40">
	            <div class="singleItem">
	                <label>Data de cadastro:</label>
	                <span class="text"><?php echo date('d/m/Y', strtotime($resReservaAvaliacao->data_cadastro)) ?></span>
	            </div>

	          	<?php if (isset($resReservaAvaliacao->cliente_id)&&$resReservaAvaliacao->cliente_id!='') { ?>
		       		<div class="singleItem">
		                <label>Cliente:</label>
		                <span class="text"><?php echo $resReservaAvaliacao->Cliente->nome ?></span>
	              </div>
	          	<?php } ?>

	            <div class="singleItem">
	                <label>Anuncio:</label>
	                <span class="text"><?php echo $resReservaAvaliacao->Anuncio->titulo ?></span>
	            </div>

	            <div class="singleItem">
	                <label>Status:</label>
	                <span class="text"><?php echo $resReservaAvaliacao->status==1?'<span style="font-weight: 600;color: green;">Ativo</span>':'<span style="font-weight: 600;color: red;">Inativo</span>' ?></span>
	            </div>

	            <div class="singleItem listaAvaliacao">
	            	<div class="avaliadosEstrela">
                        <?php if (isset($resReservaAvaliacao->avaliacao)&&$resReservaAvaliacao->avaliacao==1) { ?>
                            <i class="fas fa-star"></i>
                            <i class="fal fa-star"></i>
                            <i class="fal fa-star"></i>
                            <i class="fal fa-star"></i>
                            <i class="fal fa-star"></i>
                        <?php } else if ($resReservaAvaliacao->avaliacao==2) { ?>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fal fa-star"></i>
                            <i class="fal fa-star"></i>
                            <i class="fal fa-star"></i>
                        <?php } else if ($resReservaAvaliacao->avaliacao==3) { ?>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fal fa-star"></i>
                            <i class="fal fa-star"></i>
                        <?php } else if ($resReservaAvaliacao->avaliacao==4) { ?>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fal fa-star"></i>
                        <?php } else if ($resReservaAvaliacao->avaliacao==5) { ?>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        <?php }  ?>
                    </div>
	            </div>

	            <div class="singleItem">
	                <label>Texto:</label>
	                <span class="text"><?php echo $resReservaAvaliacao->texto ?></span>
	            </div>

	            <div class="clearfix"></div><br>

	            <div class="singleItem">
	                <a class="btn btn-primary" href="<?php echo URL_ADMIN.'avaliacoes/detalhes/'.$resReservaAvaliacao->id.'?status=1' ?>">Aprovar avaliação</a>
	            </div>
	        </div>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->

