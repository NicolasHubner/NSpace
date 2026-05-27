<?php
  	include('lib/Config.php');
  	ob_start();

  	$tipoHeader = 'light';
?>

	<div class="page-title bg-laranja">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<h2 class="ipt-title">Esqueci minha senha</h2>
				</div>
			</div>
		</div>
	</div>

	<section class="modelEsqueciSenha">
		<div class="container">
			<div class="dadosForm">
				<form class="formEsqueciSenha" id="formulario-esqueci-senha">  
					<div class="mb-20">
						<h4>Informe o email da sua conta:</h4>
						<p>Logo após o preenchimento enviaremos para seu e-mail uma nova senha.</p>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>E-mail</label>
								<div class="input-with-icon">
									<input type="email"  name="email" class="form-control validate[required]" placeholder="E-mail">
									<i class="ti-email"></i>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<input type="hidden" name="tipo" value="gerar-code">
						<input type="submit" class="btnPadrao mt-20" style="cursor: pointer;" value="Recuperar senha">
					</div>
				</form>
			</div>
		</div>
	</section>

<?php
  	$obContent = ob_get_contents();
  	ob_end_clean();
  	include('base.php');
?>

<script type="text/javascript">
	$('.formEsqueciSenha').validationEngine({
        scroll: false
    });
	$('.formEsqueciSenha').submit(function(e) {
	    e.preventDefault();
    	let form =  $(this);
	    
	    if ($(this).validationEngine('validate')) {
	        var formulario = document.getElementById('formulario-esqueci-senha');
	        var formData = new FormData(formulario);

	        $.ajax({
	            url: URL_SITE + 'action/esqueciSenha.php',
	            processData: false,
	            contentType: false,
	            type: 'POST',
	            dataType: 'json',
	            data: formData,
	            success: function(response) {
	            	if (response.status ==1) {
	            		Lobibox.notify('success', {
	                        delay: 6000,
	                    	position: "top right", 
	                        title: 'Senha resetada com sucesso',
	                        dataType: "json",
	                        icon: true,
	                        msg: 'Nova senha enviada por email.'
	                    });
	                    $(form)[0].reset();
	            	} else if (response.status ==2) {
						Lobibox.notify('error', {
	                        delay: 6000,
	                    	position: "top right", 
	                        title: 'Algo deu errado',
	                        dataType: "json",
	                        icon: true,
	                        msg: 'Dados não encontrados.'
	                    });
	            	}
	            }
	        });
	    }
	});
</script>