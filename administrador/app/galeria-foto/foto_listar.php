<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
		<?php 
		
		try {
			
			// Seleciona o registro
			$obj = Doctrine_Core::getTable('Galeria')->find($_GET['id']);
			$res = $obj->nome.' - Foto'; 	
						
		} catch (Exception $e){
			
			$res = 'Ocorreu um erro de sistema!';
			echo '<h1>Ocorreu um erro de sistema!</h1>';
		}
		
		?>
	      	<div class="header">	
	      		<div class="pull-right btnActionCadastrar">
          			<?php 
			
						// Seta as permissões de nível 1
						$objPermissao = new UsuarioPermissao();
						$objPermissao->printActions($_GET['model'], 4, $_GET['id'], $_GET['action']);
						
					?>
          		</div>
          		
				<h3><?php echo $res; ?></h3>
				<input type="hidden" name="galeria_id" value="<?php echo $obj->id; ?>" />
			</div>
			
			<table class="data-table"><!-- Table Wrapper Begin -->
				<thead>
					<tr>
						<th width="100">Foto</th>
						<th>Nome</th>
						<th width="60">Ordem</th>
						<th width="100">Ações</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->