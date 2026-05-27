<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
		<div class="block-flat">
			<?php 
			try {
				$obj = Doctrine_Core::getTable('Plano')->find($_GET['id']);
				$res = $obj->nome.' - Arquivo'; 	
			} catch (Exception $e){
				$res = 'Ocorreu um erro de sistema!';
				echo '<h1>Ocorreu um erro de sistema!</h1>';
			}
			?>
			<div class="header">
				<h3><?php echo $res; ?></h3>
				<input type="hidden" name="plano_id" value="<?php echo $obj->id; ?>" />
			</div>
			<?php 
			$objPermissao = new UsuarioPermissao();
			$objPermissao->printActions($_GET['model'], 4, $_GET['id'], $_GET['action']);
			?>
			<table class="data-table">
				<thead>
					<tr>
						<th>Nome</th>
						<th width="130">Ordem</th>
						<th width="100">Ações</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>