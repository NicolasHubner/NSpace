<section class="theme-bg call-to-act-wrap">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				
				<div class="call-to-act">
					<div class="call-to-act-head">
						<h3>Tem um espaço para alugar?</h3>
						<span>Vem com a gente, nosso time vai te ajudar a divulgar seu espaço</span>
					</div>

					<?php if (isset($_SESSION['sess_cliente_id'])&&$_SESSION['sess_cliente_id']!='') { ?>
						<a href="<?php echo URL ?>criar-propriedade/" class="btn btn-call-to-act"> Adicionar um local</a>
					<?php } else { ?>
						<a href="#" class="btn btn-call-to-act" data-toggle="modal" data-target="#cadastro">Cadastre-se agora</a>
					<?php } ?>
				</div>
				
			</div>
		</div>
	</div>
</section>