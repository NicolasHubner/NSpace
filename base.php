<?php
    $title = isset($title)&&$title!=''?$title:TITLE_DEFAULT;
    $keywords = isset($keywords)&&$keywords!=''?$keywords.','.$objConfiguracao->google_keywords:$objConfiguracao->google_keywords;
    $description = isset($description)&&$description!=''?$description:$objConfiguracao->google_descricao;
    $imagem = isset($imagem)&&$imagem!=''?$imagem:URL_IMAGES.'capa-dominio.jpg';
?>
<!DOCTYPE html>
<html lang="zxx">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="facebook-domain-verification" content="uktiswdt51i0nqt7lk7uytc0s7x646" />
        <meta name="keywords" content="<?php echo strip_tags($keywords) ?>">
        <meta name="description" content="<?php echo strip_tags($description) ?>">
        <meta name="distribution" content="Global">
        <meta name="rating" content="General">
        <meta name="author" content="ACESSOWEB DESIGN">
        <meta name="language" content="pt-br">
        <meta name="city" content="Contagem">
        <meta name="country" content="Brazil">
        <meta name="owner" content="<?php echo TITLE_DEFAULT ?>">

        <!-- Chave secreta r_OCYQbasIF6cRoo9jLMA8Hz -->
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="996299043165-eb2evf6i6kbumtkotkaajjuttutj9vol.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <title>NSPACE</title>

        <meta property="og:title" content="<?php echo strip_tags($title) ?>">
        <meta property="og:description" content="<?php echo strip_tags($description) ?>">
        <meta property="og:image" content="<?php echo $imagem ?>" />

        <link rel="stylesheet" href="<?php echo URL ?>css/fontawesome/fontawesome.min.css"/>
        <link rel="stylesheet" href="<?php echo URL ?>css/fontawesome/all.min.css"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,500;0,600;0,700;0,800;1,200;1,300;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <link href="<?php echo URL ?>assets/css/styles.min.css" rel="stylesheet">
		<link href="<?php echo URL ?>assets/css/colors.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo URL ?>assets/js/validation-engine/validationEngine.jquery.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>assets/js/lobibox/css/lobibox.min.css"/>
        <link rel="stylesheet" href="<?php echo URL ?>assets/js/select2/select2-bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>assets/js/dropzone/dropzone.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>assets/css/responsive.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/jquery.fancybox.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo URL ?>assets/js/jssocials-1.4.0/jssocials.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo URL ?>assets/js/jssocials-1.4.0/jssocials-theme-minima.min.css" />
        <link rel="shortcut icon" href="<?php echo URL_IMAGES ?>favicon.png" type="image/x-icon" />
        <?php echo isset($objConfiguracao->google_analytics)&&$objConfiguracao->google_analytics!=''?$objConfiguracao->google_analytics:'' ?>
    </head>
	
    <body class="goodred-skin">
        <div id="main-wrapper">
            <?php include('include/header.php') ?>

            <?php echo $obContent ?>

            <?php include('include/footer.php') ?>
            <?php include('include/popup_login.php') ?>
            <?php include('include/popup_cadastro.php') ?>
        </div>

        <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>

        <script>
            URL_SITE = "<?php echo URL ?>";
        </script>
        <script src="<?php echo URL ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo URL ?>assets/js/popper.min.js"></script>
        <script src="<?php echo URL ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo URL ?>assets/js/rangeslider.js"></script>
        <script src="<?php echo URL ?>assets/js/jquery.magnific-popup.min.js"></script>
        <script src="<?php echo URL ?>assets/js/slick.min.js"></script>
        <script src="<?php echo URL ?>assets/js/slider-bg.min.js"></script>
        <script src="<?php echo URL ?>assets/js/lightbox.min.js"></script> 
        <script src="<?php echo URL ?>assets/js/imagesloaded.min.js"></script>
        <script src="<?php echo URL ?>assets/js/custom.min.js"></script>
        <script src="<?php echo URL ?>assets/js/cl-switch.min.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>assets/js/validation-engine/jquery.validationEngine.min.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>assets/js/validation-engine/jquery.validationEngine-pt.min.js"></script>
        <script src="<?php echo URL ?>assets/js/jquery.mask.js"></script>
        <script src="<?php echo URL ?>assets/js/lobibox/js/lobibox.min.js"></script>
        
        <link rel="stylesheet" href="<?php echo URL_ADMIN_CSS ?>cropper.min.css" type="text/css" />
        <script src="<?php echo URL_ADMIN_JS ?>cropper.min.js"></script>
        <script src="<?php echo URL ?>assets/js/select2/select2.min.js"></script>
        <script src="<?php echo URL ?>assets/js/validaCpfCnpj.min.js"></script>
        <script src="<?php echo URL ?>assets/js/dropzone/dropzone.min.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>assets/js/jquery.fancybox.min.js"></script>
         <script src="<?php echo URL ?>assets/js/jssocials-1.4.0/jssocials.min.js"></script>
      
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $('.blocoLogin #acessoCPF').click(function(e) {
                    e.preventDefault();
                    $('.blocoLogin #acessoCPF').css('display', 'none');
                    $('.blocoLogin #acessoEmail').css('display', 'block');

                    $('.blocoLogin .displayEmail').css('display', 'none');
                    $('.blocoLogin .displayCPF').css('display', 'block');
                    $('.blocoLogin .tipo_acesso').val('2');
                });

                 $('.blocoLogin #acessoEmail').click(function(e) {
                    e.preventDefault();
                    $('.blocoLogin #acessoEmail').css('display', 'none');
                    $('.blocoLogin #acessoCPF').css('display', 'block');

                    $('.blocoLogin .displayCPF').css('display', 'none');
                    $('.blocoLogin .displayEmail').css('display', 'block');
                    $('.blocoLogin .tipo_acesso').val('1');
                });

                $('.formCadastro').validationEngine({
                    scroll: false
                });
                $('.formCadastro').submit(function(e) {
                    e.preventDefault();
                    if ($(this).validationEngine('validate')) {

                        var formulario = document.getElementById('formulario-cadastro');
                        var formData = new FormData(formulario);

                        $('.blocoCadastro .dadosCadastro').css('display', 'none');
                        $('.blocoCadastro .loadingadmins').css('display', 'block');

                        $.ajax({
                            url: URL_SITE + 'action/addCliente.php',
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            success: function(response) {
                                if (response.status ==1) {
                                     if (response.url != '' && response.url != null) {
                                        window.location.href=response.url;
                                    } else {
                                        setTimeout(() => {
                                            // location.reload();
                                            window.location.href=URL_SITE;
                                        }, 2000);
                                    }
                                } else if (response.status == 2) {
                                    $('.blocoCadastro .loadingadmins').css('display', 'none');
                                    $('.blocoCadastro .dadosCadastro').css('display', 'block');
                                    $('.blocoCadastro .alert.alert-danger').css('display', 'block');
                                    $('.blocoCadastro .alert.alert-danger p').html(response.mensagem);

                                }
                            }
                        });
                    }
                });

                 $('.validaCNPJ').blur(function(){
                    if($(this).val()!=''&&$(this).val()!=''){
                        if ( formata_cpf_cnpj( $(this).val() ) ) {
                            
                        } else {
                            Lobibox.notify('error', {
                                delay: 15000,
                                title: 'Erro',
                                icon: true,
                                msg: 'CNPJ inválido!'
                            });
                            $(this).val('');
                            $(this).focus();
                        }
                    }
                });

                $('.validaPerfCPF').blur(function(){
                    if($(this).val()!=''&&$(this).val()!=''){
                        if ( formata_cpf_cnpj( $(this).val() ) ) {
                            
                        } else {
                            Lobibox.notify('error', {
                                delay: 15000,
                                title: 'Erro',
                                icon: true,
                                msg: 'CPF inválido!'
                            });
                            $(this).val('');
                            $(this).focus();
                        }
                    }
                });

                $('.formLogin').validationEngine({
                    scroll: false
                });
                $('.formLogin').submit(function(e) {
                    e.preventDefault();
                    if ($(this).validationEngine('validate')) {

                        var formulario = document.getElementById('formulario-login');
                        var formData = new FormData(formulario);

                        $('.blocoLogin .dadosAcesso').css('display', 'none');
                        $('.blocoLogin .loadingadmins').css('display', 'block');

                        $.ajax({
                            url: URL_SITE + 'action/cliente_autenticacao.php',
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            success: function(response) {
                                if (response.status ==1) {
                                    if (response.url != '' && response.url != null) {
                                        window.location.href=response.url;
                                    } else {
                                        setTimeout(() => {
                                            window.location.href=URL_SITE;
                                        }, 2000);
                                    }
                                } else if (response.status ==2) {
                                    $('.blocoLogin .loadingadmins').css('display', 'none');
                                    $('.blocoLogin .dadosAcesso').css('display', 'block');

                                    Lobibox.notify('error', {
                                        delay: 6000,
                                        position: "top right", 
                                        title: 'Algo deu errado',
                                        dataType: "json",
                                        icon: true,
                                        msg: 'E-mail inválido ou senha incorreta!'
                                    });
                                } else if (response.status == 3) {
                                    $('.blocoLogin .loadingadmins').css('display', 'none');
                                    $('.blocoLogin .dadosAcesso').css('display', 'block');

                                    Lobibox.notify('error', {
                                        delay: 6000,
                                        position: "top right", 
                                        title: 'Algo deu errado',
                                        dataType: "json",
                                        icon: true,
                                        msg: response.mensagem
                                    });
                                }
                            }
                        });
                    }
                });

                $('.linkLogin').click(function() {
                    $('.blocoLogin').modal('toggle');
                    $('#cadastro').modal('toggle');
                });

                 $('.linkCadastro').click(function() {
                    $('.blocoCadastro').modal('toggle');
                    $('#login').modal('toggle');
                });

                <?php if (isset($_GET['ref'])&&$_GET['ref']=='login') { ?>
                    $('#login').modal();
                <?php } ?>

                <?php if (isset($_GET['ref'])&&$_GET['ref']=='cadastro') { ?>
                    $('#cadastro').modal();
                <?php } ?>

                $('.validaCPF').blur(function(){
                    if($(this).val()!=''&&$(this).val()!=''){
                        if ( formata_cpf_cnpj( $(this).val() ) ) {
                            
                        } else {
                            Lobibox.notify('error', {
                                delay: 15000,
                                title: 'Erro',
                                icon: true,
                                msg: 'CPF inválido!'
                            });
                            $(this).val('');
                            $(this).focus();
                        }
                    }
                });


                setTimeout(function() {
                    $('.blocoCadastro input[name=tipo_pessoa_id]').change(function(){
                      var TipoPessoa = $( '.blocoCadastro input[name=tipo_pessoa_id]:checked').val();
                      console.log(TipoPessoa);
                      if (TipoPessoa == 1) {
                        $('.blocoCadastro .display-fisica').css('display', 'block');
                        $('.blocoCadastro .display-juridica').css('display', 'none');
                      } else if (TipoPessoa == 2) {
                        $('.blocoCadastro .display-juridica').css('display', 'block');
                        $('.blocoCadastro .display-fisica').css('display', 'none');
                      }
                    });
                }, 1000);
            });
        </script>

        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
        <script src="<?php echo URL ?>assets/js/cookieconsent.min.js"></script>
        <script>
        window.addEventListener("load", function(){
        window.cookieconsent.initialise({
        "palette": {
        "popup": {
        "background": "#fd5000",
        "text": "#fff"
        },
        "button": {
        "background": "#fff"
        }
        },
        "content": {
        "message": "Este site usa cookies para garantir que você obtenha a melhor experiência em nosso site. Concordo com os <a href='"+URL_SITE+"termos-de-uso/'>Termos de Uso</a>.",
        "dismiss": "Aceito Cookies",
        "href": URL_SITE+"politica-cookies/"
        }
        })});

        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            var userID = profile.getId(); 
            var userName = profile.getName(); 
            var userPicture = profile.getImageUrl(); 
            var userEmail = profile.getEmail();              
            var userToken = googleUser.getAuthResponse().id_token; 
            googleUser.disconnect()
            
            //document.getElementById('msg').innerHTML = userEmail;
                                    
            if(userEmail !== ''){
                var dados = {
                    userID:userID,
                    userName:userName,
                    userPicture:userPicture,
                    userEmail:userEmail
                };
                
                $.ajax({
                    url: URL_SITE + 'callbackGoogle.php',
                    type: 'POST',
                    dataType: 'json',
                    data: dados,
                    success: function(response) {
                        $('.blocoLogin').modal('hide');
                        $('.blocoCadastro').modal('hide');
                      if (response.status ==1) {
                          window.location.href  =  URL_SITE;
                      } else if (response.status == 2) {
                        Lobibox.notify('error', {
                            delay: 15000,
                            title: 'Erro',
                            icon: true,
                            msg: 'E-mail já cadastrado na NSPACE!'
                        });
                      }
                    }
                });
                
            }
        }
        </script>


        <script src="https://apis.google.com/js/platform.js?onload=onLoadCallback" async defer></script>

        <script>
            function onLoadCallback() {
                $('span[id^="not_signed_"]').html('Google');
            }
        </script>
    </body>
</html>