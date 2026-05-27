<section>
	<div class="container">
		<div class="row">
			<div class="col text-center">
				<div class="sec-heading center">
					<h2>Últimos artigos</h2>
					<p>Nós da equipe NSpace postamos artigos regularmente para você não perder nenhuma novidade.</p>
				</div>
			</div>
		</div>
		
		<div class="row">
			<?php 
				$retNoticia = Doctrine_Query::create()->select()->from('Noticia')->where('status = 1 and destaque = 1')->orderBy('data_cadastro DESC')->execute();
				foreach ($retNoticia as $objNoticia) {
					?>
						<div class="col-lg-4 col-md-6">
							<div class="blog-wrap-grid">
								<div class="blog-thumb">
									<a href="<?php echo URL.'artigo/'.$objNoticia->dns ?>"><img src="<?php echo URL_NOTICIA.$objNoticia->imagem ?>" class="img-fluid" alt="" /></a>
								</div>
								
								<div class="blog-info">
									<span class="post-date"><i class="ti-calendar"></i>Criado em <?php echo date('d/m/Y', strtotime($objNoticia->data_cadastro)) ?></span>
								</div>
								
								<div class="blog-body">
									<h4 class="bl-title"><a href="<?php echo URL.'artigo/'.$objNoticia->dns ?>"><?php echo $objNoticia->titulo ?></a></h4>
									<p><?php echo $objNoticia->resumo ?></p>
									<a href="<?php echo URL.'artigo/'.$objNoticia->dns ?>" class="bl-continue">Continuar</a>
								</div>
							</div>
						</div>
					<?php 
				}	
			?>
		</div>
	</div>		
</section>