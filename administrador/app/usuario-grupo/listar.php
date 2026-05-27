<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
				<h3>Grupos de Usuários</h3>
			</div>
			<?php 
			
			// Seta as permissões de nível 1
			$objPermissao = new UsuarioPermissao();
			$objPermissao->printActions($_GET['model'], 1);
			
			?>
			<table class="data-table"><!-- Table Wrapper Begin -->
				<thead>
					<tr>
						<th>Grupo</th>
						<th width="120">Status</th>
						<th width="120">Ações</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->