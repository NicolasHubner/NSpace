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
				<h3>Reservas</h3>
			</div>

			<div class='filtros'>
				<form method="get">
					<div class="row">
						<div class="col-md-3">
							<label>Status:</label>
							<select  class="form-style" name="status" id="status">
								<option value="" <?php echo isset($_GET['status'])&&$_GET['status']==''?'selected':'' ?>>Todos</option>
								<option value="0" <?php echo isset($_GET['status'])&&$_GET['status']=='0'?'selected':'' ?>>Aguardando pagamento</option>
								<option value="1" <?php echo isset($_GET['status'])&&$_GET['status']=='1'?'selected':'' ?>>Aprovado</option>
                                <option value="2" <?php echo isset($_GET['status'])&&$_GET['status']=='2'?'selected':'' ?>>Cancelado</option>
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
						<th width="170">Data de Cadastro</th>
						<th width="170">Data de Entrada</th>
						<th width="210">Cliente</th>
						<th>Anuncio</th>
						<th width="180">Localização</th>
						<th width="180">Status</th>
						<th width="180">Confirmada?</th>
						<th width="100">Ações</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->