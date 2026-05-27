<div class="dashboard-wraper modelSolicitacao">
    <div class="form-submit">
    	<?php 
    		$retClienteMigracao = Doctrine_Query::create()->select()->from('ClienteMigracao')->where('cliente_id = '.$objCliente->id)->orderBy('data_cadastro DESC')->limit(1)->execute();
    		if ($retClienteMigracao->count()>0) {
    			if ($retClienteMigracao[0]->status == 1) {
    				?>
	    				<div class="retornoNotif success text-center mt-20" style="display: block;">
			          		<i class="fas fa-check"></i>
			          		<h4>Recebemos seus documentos com sucesso.</h4>
			          		<p>Já estamos analisando e em breve retornaremos.</p>          		
			          	</div>
    				<?php
    			} 
    		} else {
				?>
					<h4>Vimos que você ainda não é um Space Host :(</h4>
			        <p>Preencha o formulário abaixo com seus dados e em breve entraremos em contato.</p>
			        <div class="submit-section mt-20">
			        	<form class="formSolicitacao" id="formulario-solicitacao" enctype='multipart/form-data'>
				            <div class="form-row">
				                <div class="form-group col-md-12">
								    <label>Identidade ou CNH</label>
								    <input type="file" name="comprovante_identidade" class="form-control validate[required]">
								</div>

								<div class="form-group col-md-12">
								    <label>Comprovante de endereço</label>
								    <input type="file" name="comprovante_endereco" class="form-control validate[required]">
								</div>
							</div>

							<div class="form-row">
				                <div class="form-group col-md-12">
								    <label><input type="checkbox" name="termo" class="validate[required]" value="1"> Aceito os <a href="<?php echo URL ?>termos-de-uso/">Termos de Uso</a> e <a href="<?php echo URL ?>politica-de-privacidade/">Política de Privacidade</a> do Portal NSPACE</label>
								</div>
							</div>

							<div class="form-group col-lg-12 col-md-12">
								<input type="hidden" name="cliente_id" value="<?php echo $objCliente->id ?>">
							    <button class="btn btn-theme" type="submit">Salvar mudanças</button>
							</div>
			           	</form>

			           	<div class="loadingadmins text-center">
				            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
				              viewBox="25 25 50 50">
				              <circle cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke="#fd5000" stroke-linecap="round"
				                stroke-dashoffset="0" stroke-dasharray="100, 200">
				                <animateTransform attributeName="transform" attributeType="XML" type="rotate" from="0 50 50" to="360 50 50"
				                  dur="2.5s" repeatCount="indefinite" />
				                <animate attributeName="stroke-dashoffset" values="0;-30;-124" dur="1.25s" repeatCount="indefinite" />
				                <animate attributeName="stroke-dasharray" values="0,200;110,200;110,200" dur="1.25s"
				                  repeatCount="indefinite" />
				              </circle>
				            </svg>
				            <h4>Realizando solicitação</h4>
			          	</div>

			          	<div class="retornoNotif success text-center mt-20">
			          		<i class="fas fa-check"></i>
			          		<h4>Recebemos seus documentos com sucesso.</h4>
			          		<p>Já estamos analisando e em breve retornaremos.</p>          		
			          	</div>
			        </div>
				<?php
			}
    	?>  
    </div>
</div>