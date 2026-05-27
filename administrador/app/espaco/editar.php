<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">
          		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>	
				<h3>Espaço - Editar</h3>
			</div>
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Anuncio')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil" enctype="multipart/form-data">
				<div class="row">
					<div class="col-sm-4">
	                    <label>Plano:</label>
	                    <select name="plano_id" id="plano_id" data-live-search="true" data-width="100%"
	                            data-toggle="tooltip" class="form-style">
	                        <option value="">Selecione</option>
	                        <?php
	                        try {

	                            $resPlano = Doctrine_Query::create()->select()->from('Plano')->execute();

	                            if ($resPlano->count() > 0) {
	                                $resPlano->toArray();

	                                foreach ($resPlano as $value) {
	                                    $selected = $value['id']==$res->plano_id?"selected":"";
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

                    <div class="col-md-3">
                        <label>Top anúncio:</label><br>
                        <label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="top_anuncio" value='0' <?php echo isset($res->top_anuncio)&&$res->top_anuncio==0?'checked':'' ?>> Inativo</label> 
                        <label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="top_anuncio" value='1' <?php echo isset($res->top_anuncio)&&$res->top_anuncio==1?'checked':'' ?>> Ativo</label> 
                    </div>

                    <div class="col-md-3">
                        <label>Pagamento:</label><br>
                        <label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="pagamento" value='0' <?php echo isset($res->pagamento)&&$res->pagamento==0?'checked':'' ?>> Aguardando</label> 
                        <label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="pagamento" value='1' <?php echo isset($res->pagamento)&&$res->pagamento==1?'checked':'' ?>> Aprovado</label> 
                    </div>
                </div>
					
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
				<div class="row">
					<div class="col-md-12"><input type="submit" class="btn btn-primary pull-right" value="Salvar" /></div>
				</div>
				
			</form>
			<?php 
			
			} catch (Exception $e){
				echo 'Ocorreu um erro!';
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->
