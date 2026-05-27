<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

<script src="<?php echo URL_ADMIN_JS; ?>jquery.cookie/jquery.cookie.js"></script>

<script src="<?php echo URL_ADMIN_JS; ?>jquery.pushmenu/js/jPushMenu.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.nanoscroller/jquery.nanoscroller.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.sparkline/jquery.sparkline.min.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.ui/jquery-ui.js" ></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.gritter/js/jquery.gritter.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>behaviour/core.js"></script>


<!-- Bootstrap core JavaScript

================================================== -->

<!-- Placed at the end of the document so the pages load faster -->

<script src="<?php echo URL_ADMIN_JS; ?>bootstrap/dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.ui/jquery-ui.js"></script>

<script src="<?php echo URL_ADMIN_JS; ?>jquery.codemirror/lib/codemirror.js"></script>

<script src="<?php echo URL_ADMIN_JS; ?>jquery.codemirror/mode/xml/xml.js"></script>

<script src="<?php echo URL_ADMIN_JS; ?>jquery.codemirror/mode/css/css.js"></script>

<script src="<?php echo URL_ADMIN_JS; ?>jquery.codemirror/mode/htmlmixed/htmlmixed.js"></script>

<script src="<?php echo URL_ADMIN_JS; ?>jquery.codemirror/addon/edit/matchbrackets.js"></script>

<script src="<?php echo URL_ADMIN_JS; ?>jquery.vectormaps/jquery-jvectormap-1.2.2.min.js"></script>

<script src="<?php echo URL_ADMIN_JS; ?>jquery.vectormaps/maps/jquery-jvectormap-world-mill-en.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>validation/jquery.validationEngine.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>validation/languages/jquery.validationEngine-pt.js"></script>

<!--<script src="<?php echo URL_ADMIN_JS; ?>behaviour/dashboard.js"></script>-->

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.maskMoney.js?v2"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.icheck/icheck.min.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.jeditable/jquery.jeditable.mini.js"></script>


<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.datatables/jquery.datatables.min.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.datatables/bootstrap-adapter/js/datatables.js"></script>

<!-- <script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.datatables/extensions/js/dataTables.responsive.min.js"></script>-->

<!-- <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script> -->



<script type="text/javascript" src="<?php echo URL_ADMIN ?>js/bootstrap.multiselect/js/bootstrap-multiselect.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN ?>js/jquery.multiselect/js/jquery.multi-select.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN ?>js/jquery.quicksearch/jquery.quicksearch.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN ?>js/bootstrap.multiselect/css/bootstrap-multiselect.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN ?>js/jquery.multiselect/css/multi-select.css" />

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.maskedinput-1.3.min.js?v9"></script>


<script src="<?php echo URL_ADMIN ?>js/bootstrap-select/bootstrap-select.min.js"></script>

<link href="<?php echo URL_ADMIN ?>js/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">

<?php if (!isset($_GET['model'])||$_GET['model']=='inicio'||$_GET['model']=='dashboard'||$_GET['model']==''){ ?>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.flot/jquery.flot.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.flot/jquery.flot.pie.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.flot/jquery.flot.resize.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.flot/jquery.flot.labels.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.flot/jquery.flot.time.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.flot/jquery.flot.categories.js"></script>

<?php } ?>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS?>ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS?>ckeditor/adapters/jquery.js"></script>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>colpick.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS ?>dropzone/dropzone.js"></script>
<script type="text/javascript" src="<?php echo URL ?>assets/js/jquery.fancybox.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">


<script src="<?php echo URL_ADMIN_JS ?>jquery.mask.js"></script> 

<link rel="stylesheet" href="<?php echo URL_ADMIN_CSS ?>cropper.css" type="text/css" />
<script src="<?php echo URL_ADMIN_JS ?>cropper.js"></script>

<script src="<?php echo URL ?>assets/js/lobibox/js/lobibox.min.js"></script>


<?php 

	$js_file = '';

	// Verificação para abertura de um arquivo específico para o módulo

	if (isset($_GET['model']) && isset($_GET['action']) && $_GET['model']!='dashboard'){

		$js_file = URL_ADMIN.'app/'.$_GET['model'].'/js/'.$_GET['action'].'.js';

		$path_file = PATH_ADMIN.'app/'.$_GET['model'].'/js/'.$_GET['action'].'.js';

		if (file_exists($path_file)){

			echo '<script type="text/javascript" src="'.$js_file.'?time='.filemtime($path_file).'"></script>';

		}

	} else if (isset($_GET['model'])){

		$js_file = URL_ADMIN.'app/'.$_GET['model'].'/js/listar.js';

		$path_file = PATH_ADMIN.'app/'.$_GET['model'].'/js/listar.js';

		if (file_exists($path_file)){

			echo '<script type="text/javascript" src="'.$js_file.'?time='.filemtime($path_file).'"></script>';

		}

	} else {

		$js_file = URL_ADMIN.'app/perfil/js/editar.js';

		$path_file = PATH_ADMIN.'app/perfil/js/editar.js';

		if (file_exists($path_file)){

			echo '<script type="text/javascript" src="'.$js_file.'?time='.filemtime($path_file).'"></script>';

		}

	}

	unset($js_file);

?>

<script type="text/javascript">

	$(document).ready(function(){

	    $('.dataTables_length select').addClass('form-control').css('display', 'inline-block');   

	    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Buscar');

	    

        $('.icheck').iCheck({

          checkboxClass: 'icheckbox_flat-green',

          radioClass: 'iradio_flat-green'

        });

        $('.form').validationEngine();

       	$('.cl-toggle').click(function(){

       		console.log("ok");

       		console.log($('.cl-vnavigation').css('display'));

       		if($(this).hasClass('ativo')){

       			$(this).removeClass('ativo');

       			$('.cl-navblock').css('height', '0px');

       		}else{

       			$(this).addClass('ativo');

       			$('.cl-navblock').css('height', 'auto');

       		}

       	});

       	

	    // BootstrapSelect

	    // ---------------------------------------------------------------------------------------

	    if ($().selectpicker) {

	        $('.selectpicker').selectpicker({

	        	selectedTextFormat: 'count > 5',

		        noneSelectedText : 'Nenhum registro selecionado',

		        noneResultsText : 'Nenhum resultado encontrado',

		        countSelectedText: '{0} de {1} selecionados'

	        });

	    }



	    // Não expirar sessão

	    var refreshTime = 300000; // every 5 minutes in milliseconds

		window.setInterval( function() {

		    $.ajax({

		        cache: false,

		        type: "GET",

		        url: URL_ADMIN+"refreshSession.php",

		        success: function(data) {

		        }

		    });

		}, refreshTime );

	});
	

</script>

<script>
	URL_SITE = "<?php echo URL_ADMIN ?>";
</script>