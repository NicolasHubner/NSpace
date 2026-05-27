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
          		
				<h3>Clientes</h3>
			</div>

			<div class='filtros'>
				<form method="get">
					<div class="row">
						<div class="col-md-3">
							<label>Verificação:</label>
							<select  class="form-style" name="verificado" id="verificado">
								<option value="" <?php echo isset($_GET['verificado'])&&$_GET['verificado']=='0'?'selected':'' ?>>Todos</option>
								<option value="0" <?php echo isset($_GET['verificado'])&&$_GET['verificado']=='0'?'selected':'' ?>>Não verificado</option>
								<option value="1" <?php echo isset($_GET['verificado'])&&$_GET['verificado']=='1'?'selected':'' ?>>Analisando Documentos</option>
                                <option value="2" <?php echo isset($_GET['verificado'])&&$_GET['verificado']=='2'?'selected':'' ?>>Aprovado</option>
                                <option value="3" <?php echo isset($_GET['verificado'])&&$_GET['verificado']=='3'?'selected':'' ?>>Reprovado</option>
							</select>
						</div>

						<div class="col-md-3">
							<button type="submit" class="btn btn-primary" style="margin-top: 27px;">Buscar</button>
						</div>
					</div>
				</form>
			</div> 
			
			<table class="data-table"><!-- Table Wrapper Begin -->
				<thead>
					<tr>
						<th width="160">Data de Cadastro</th>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Celular</th>
						<th width="180">Tipo de Cliente</th>
						<th width="180">Estado/Cidade</th>
						<th width="100">Status</th>
						<th width="150">Ações</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->