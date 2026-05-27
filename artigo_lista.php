<?php
    include('lib/Config.php');
  	ob_start();
  	
      $tipoHeader = 'light';
?>

    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title">Artigos</h2>

                    <div class="breadcumb">
                        <ul class="menuAcompanhador">
                            <li><a href="<?php echo URL ?>"><i class="fal fa-chevron-double-right"></i> Início</a></li>
                            <li><a class="active" href="javascript:void(0);"><i class="fal fa-chevron-double-right"></i> Artigos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section style="padding: 120px 0;">
        <div class="container">
            <div class="row">
                <?php 
                    $retNoticia = Doctrine_Query::create()->select()->from('Noticia')->where('status = 1')->orderBy('data_cadastro DESC')->execute();
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
    </div>

<?php
    $obContent = ob_get_contents();
    ob_end_clean();
    include('base.php');
?>