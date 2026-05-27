<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
          		<div class="pull-right btnActionCadastrar">
          			<?php
						$objPermissao = new UsuarioPermissao();
						$objPermissao->printActions($_GET['model'], 1);
	          		?>
          		</div>
				<h3>Log de espaços - Mudanças</h3>
          		
			</div>
			
			<table class="data-table">
				<thead>
					<tr>
						<th width="150">Data de Cadastro</th>
						<th>Título</th>
						<th>Categoria</th>
						<th width="160">Estado/Cidade</th>
						<th width="130">Valor</th>
						<th width="80">IMG</th>
						<th width="150">Ações</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->