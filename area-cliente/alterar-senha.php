<div class="dashboard-wraper">
    <div class="form-submit">
        <h4 class="mb-20">Meu perfil</h4>
        <div class="submit-section">
        	<form class="formAlterarSenha" id="formulario-alterar-senha" enctype='multipart/form-data'>
	            <div class="form-row">
	                <div class="form-group col-md-12">
					    <label>Senha atual</label>
					    <input type="password" name="senha_atual" class="form-control validate[required]" >
					</div>

					<div class="form-group col-md-12">
					    <label>Nova senha</label>
					    <input type="password" name="nova_senha" id="novaSenha" class="form-control validate[required]" >
					</div>

					<div class="form-group col-md-12">
					    <label>Confirmar senha</label>
					    <input type="password" name="confirmar_senha" class="form-control validate[required, equals[novaSenha]]" >
					</div>

					<div class="form-group col-lg-12 col-md-12">
					<input type="hidden" name="id" value="<?php echo $objCliente->id ?>">
				    <button class="btn btn-theme" type="submit">Alterar senha</button>
				</div>
           	</form>
        </div>
    </div>
</div>