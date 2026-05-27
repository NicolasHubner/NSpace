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
				<h3>Respostas automáticas</h3>
			</div>
			
			<table class="data-table"><!-- Table Wrapper Begin -->
				<thead>
					<tr>
						<th width="200">Cadastro</th>
						<th>Texto</th>
						<th width="100">Ações</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->