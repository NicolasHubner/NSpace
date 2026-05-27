<?php
    include('lib/Config.php');
  	ob_start();
  	
    $tipoHeader = 'light';

    if  (!isset($_GET['dns'])) {
        header('Location: '.URL);
    }

    $objNoticia = Doctrine_Core::getTable('Noticia')->findOneByDns($_GET['dns']);
?>

    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title">Artigo</h2>

                    <div class="breadcumb">
                        <ul class="menuAcompanhador">
                            <li><a href="<?php echo URL ?>"><i class="fal fa-chevron-double-right"></i> Inicio</a></li>
                            <li><a class="active" href="javascript:void(0);"><i class="fal fa-chevron-double-right"></i> <?php echo $objNoticia->titulo ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                    <div class="blog-details single-post-item format-standard">
                        <div class="post-details">                        
                            <div class="post-featured-img">
                                <img class="img-fluid" src="<?php echo URL_NOTICIA.$objNoticia->imagem ?>" alt="">
                            </div>
                            <p><?php echo date('d/m/Y H:i', strtotime($objNoticia->data_cadastro)) ?></p>
                            <h2 class="post-title"><?php echo $objNoticia->titulo ?></h2>
                         
                            <p><?php echo $objNoticia->descricao ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Single blog Grid -->
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="single-widgets widget_thumb_post">
                        <h4 class="title mb-30">Outros artigos</h4>
                        <ul>
                            <?php 
                                $where = 'status = 1 and id <> '.$objNoticia->id;
                                $retNoticia = Doctrine_Query::create()->select()->from('Noticia')->where($where)->orderBy('data_cadastro DESC')->execute();
                                foreach ($retNoticia as $objNoticia) {
                                    ?>
                                        <li style="margin-bottom: 30px;">
                                            <a href="<?php echo URL.'artigo/'.$objNoticia->dns ?>">
                                                <div class="imagem">
                                                    <img src="<?php echo URL_NOTICIA.$objNoticia->imagem ?>" alt="" class="">
                                                </div>
                                            </a>
                                            <a class="feed-title" href="<?php echo URL.'artigo/'.$objNoticia->dns ?>">
                                                <h4><?php echo $objNoticia->titulo ?></h4>
                                            </a> 
                                            <p><?php echo $objNoticia->resumo ?></p>
                                            <span class="post-date"><i class="ti-calendar"></i> <?php echo date('d/m/Y', strtotime($objNoticia->data_cadastro)) ?></span>
                                        </li>
                                    <?php 
                                }	
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
    $obContent = ob_get_contents();
    ob_end_clean();
    include('base.php');
?>