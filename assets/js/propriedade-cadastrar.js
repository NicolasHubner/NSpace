    $(".valor-input").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
   
    Dropzone.autoDiscover = false;
     var myDropzone = new Dropzone("#dropzoneFotos", {
      url: "<?php echo URL ?>action/uploadFotos.php",
      paramName: "imagem",
      createImageThumbnails: true,
      dictDefaultMessage: "Arraste suas fotos para aqui",
      thumbnailWidth: 120,
      thumbnailHeight: 120
    });  

       $("#local_proprio").change(function() {
      if($(this).is(':checked')){
        $('.modelCriacaoPropriedade .passo-04 .displayIdentidade').css('display', 'none');
      } else {
        $('.modelCriacaoPropriedade .passo-04 .displayIdentidade').css('display', 'block');
      }
    });

  $("#cep").change(function(){
    if($.trim($("#cep").val()) != ""){
      /* 
          Para conectar no serviço e executar o json, precisamos usar a função
          getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
          dataTypes não possibilitam esta interação entre domínios diferentes
          Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
          http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val()
      */
      
      $.get("https://viacep.com.br/ws/"+$("#cep").val()+"/json/", function(data){
            console.log(data);
          // o getScript dá um eval no script, então é só ler!
          //Se o resultado for igual a 1
            if(!data["erro"]){
 
                $("#carregando").css('display', '');

                var uf = data["uf"];
                uf = uf.replace(' ', '');

                var cidade = unescape(data["localidade"]);
                console.log(cidade);
              // troca o valor dos elementos
              // ID do campo da rua
              $("#logradouro").val(unescape(unescape(data["logradouro"])));
              // ID do campo do bairro
              $("#bairro").val(unescape(data["bairro"]));
              // ID do campo do estado
              // $('#estado').find('option[text="'+uf+'"]').attr('selected', 'selected');
              // console.log("'"+uf+"'");
                $('#estado_id option:contains(' + uf + ')').each(function(){
                    if ($(this).text() == uf) {
                        $(this).attr('selected', 'selected');
                        estado_id = $(this).val();
                        // return false;
                    }
                    // return true;
                    $("#estado_id").val(estado_id);
                });
                $("#estado_id");

                $("select[name=cidade_id]").html('<option value="">Carregando...</option>');

                $.when( $.getJSON("<?php echo URL_ADMIN ?>getCidades.php",{estado_id: estado_id}, function(j){
                    $("select[name=cidade_id]").html('<option value="">Carregando...</option>');
                    var options = '<option value="">Selecione</option>';    
                    for (var i = 0; i < j.length; i++){

                        options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
                        
                    }   
                   $("#cidade_id").html(options);
                })).done(function() {
                    $('#cidade_id option:contains(' + cidade + ')').each(function(){
                        if ($(this).text() == cidade) {
                            $(this).attr('selected', 'selected');
                            cidade_id = $(this).val();
                            // return false;
                        }
                        // return true;
                    });
                    $("#cidade_id");

                    

                    $("#carregando").css('display', 'none');
                });
                
                // alert("ae");
                

                $('#numero').focus();
                
              // ID do campo da Cidade
              // $("#cidade").val(unescape(data["cidade"]));
          }else{
              alert("Endereço não encontrado");
          }
      });                
    }
    }); 

     $("#estado_id").change(function(){
        // alert("ae");
        if($(this).val()){
            $("#cidade_id").html('<option value="">Carregando...</option>');
            $.getJSON("<?php echo URL_ADMIN ?>getCidades.php",{estado_id: jQuery(this).val()}, function(j){
                var options = '<option value="">Selecione</option>';
                for (var i = 0; i < j.length; i++){
                    options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';

                }
                $("#cidade_id").html(options);

            });
        } else {
            $("#cidade_id").html('<option value="">Selecione um estado</option>');
        }
    });

     $("#cidade_id").change(function(){
        // alert("ae");
        if($(this).val()){
            $("#regiao_id").html('<option value="">Carregando...</option>');
            $.getJSON("<?php echo URL_ADMIN ?>getRegiao.php",{cidade_id: jQuery(this).val()}, function(j){
                var options = '<option value="">Selecione</option>';
                for (var i = 0; i < j.length; i++){
                    options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';

                }
                $("#regiao_id").html(options);

            });
        } else {
            $("#regiao_id").html('<option value="">Selecione um cidade</option>');
        }
    });

     $('.formPasso01').validationEngine({
     	scroll: false
     });
     $('.formPasso01').submit(function(e) {
     	e.preventDefault();
     	if ($(this).validationEngine('validate')) {

     		$('.modelCriacaoPropriedade .formPasso01').css('display','none');
     		$('.modelCriacaoPropriedade .loadingadmins').css('display','block');


     		var formulario = document.getElementById('formulario-01');
     		var formData = new FormData(formulario);

     		$.ajax({
     			url: URL_SITE + 'action/addPropriedade.php',
     			processData: false,
     			contentType: false,
     			type: 'POST',
     			dataType: 'json',
     			data: formData,
     			success: function(response) {
     				if (response.status ==1) {
     					setTimeout(() => {
     						$('.modelCriacaoPropriedade #passo-01').removeClass('ative');
     						$('.modelCriacaoPropriedade #passo-01').addClass('finalizado');
     						$('.modelCriacaoPropriedade .loadingadmins').css('display','none');
     						$('.modelCriacaoPropriedade .formPasso02').css('display','block');
                            $('.modelCriacaoPropriedade .passo-click').click()
     						if (response.anuncio_id != '') {
                                $('.modelCriacaoPropriedade #passo-02').removeClass('inativo');
                                $('.modelCriacaoPropriedade #passo-02').addClass('ative');
     							$('.modelCriacaoPropriedade .formPasso02 .anuncio_id').val(response.anuncio_id);
     						}


     					}, 2500);
     				}
     			}
     		});
     	}
    });

     $('.formPasso02').validationEngine({
        scroll: false
     });
     $('.formPasso02').submit(function(e) {
        e.preventDefault();
        if ($(this).validationEngine('validate')) {

            $('.modelCriacaoPropriedade .formPasso02').css('display','none');
            $('.modelCriacaoPropriedade .loadingadmins').css('display','block');

            $('.modelCriacaoPropriedade .loadingadmins #TitleEspaço').css('display','none');
            $('.modelCriacaoPropriedade .loadingadmins #TitleLoc').css('display','block');
            $('.modelCriacaoPropriedade .loadingadmins #TitleFotos').css('display','none');
            $('.modelCriacaoPropriedade .loadingadmins #TitleDoc').css('display','none');



            var formulario = document.getElementById('formulario-02');
            var formData = new FormData(formulario);

            $.ajax({
                url: URL_SITE + 'action/addPropriedade.php',
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.status ==1) {
                        setTimeout(() => {
                            $('.modelCriacaoPropriedade .passo-click').click()
                            $('.modelCriacaoPropriedade #passo-02').removeClass('ative');
                            $('.modelCriacaoPropriedade #passo-02').addClass('finalizado');
                            $('.modelCriacaoPropriedade #passo-02').addClass('finalizado');
                            $('.modelCriacaoPropriedade .loadingadmins').css('display','none');
                            $('.modelCriacaoPropriedade .formPasso03').css('display','block');
                            if (response.anuncio_id != '') {
                                $('.modelCriacaoPropriedade #passo-03').removeClass('inativo');
                                $('.modelCriacaoPropriedade #passo-03').addClass('ative');
                                $('.modelCriacaoPropriedade .formPasso03 .anuncio_id').val(response.anuncio_id);
                            }
                        }, 2500);
                    }
                }
            });
        }
    });

    $('#proximoFoto').click(function(e) {
        e.preventDefault();

        $('.modelCriacaoPropriedade .formPasso03').css('display','none');
        $('.modelCriacaoPropriedade .loadingadmins').css('display','block');

         $('.modelCriacaoPropriedade .loadingadmins #TitleEspaço').css('display','none');
            $('.modelCriacaoPropriedade .loadingadmins #TitleLoc').css('display','none');
            $('.modelCriacaoPropriedade .loadingadmins #TitleFotos').css('display','block');
            $('.modelCriacaoPropriedade .loadingadmins #TitleDoc').css('display','none');

        setTimeout(() => {
            $('.modelCriacaoPropriedade .passo-click').click()
            $('.modelCriacaoPropriedade #passo-04').removeClass('inativo');
            $('.modelCriacaoPropriedade #passo-04').addClass('ative');
            $('.modelCriacaoPropriedade #passo-03').addClass('finalizado');
            $('.modelCriacaoPropriedade .loadingadmins').css('display','none');
            $('.modelCriacaoPropriedade .formPasso04').css('display','block');
            $('.modelCriacaoPropriedade .formPasso04 .anuncio_id').val($('.modelCriacaoPropriedade .formPasso03 .anuncio_id').val());

        }, 2500);
    });


     $('.formPasso04').validationEngine({
        scroll: false
     });
     $('.formPasso04').submit(function(e) {
        e.preventDefault();
        if ($(this).validationEngine('validate')) {

            $('.modelCriacaoPropriedade .formPasso04').css('display','none');
            $('.modelCriacaoPropriedade .loadingadmins').css('display','block');

            $('.modelCriacaoPropriedade .loadingadmins #TitleEspaço').css('display','none');
            $('.modelCriacaoPropriedade .loadingadmins #TitleLoc').css('display','none');
            $('.modelCriacaoPropriedade .loadingadmins #TitleFotos').css('display','none');
            $('.modelCriacaoPropriedade .loadingadmins #TitleDoc').css('display','block');

            var formulario = document.getElementById('formulario-04');
            var formData = new FormData(formulario);

            $.ajax({
                url: URL_SITE + 'action/addPropriedade.php',
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.status ==1) {
                        setTimeout(() => {
                            $('.modelCriacaoPropriedade #passo-04').removeClass('ative');
                            $('.modelCriacaoPropriedade #passo-04').addClass('finalizado');
                            if (response.anuncio_id != '') {
                                // $('.modelCriacaoPropriedade .guiaForm').css('display','none');
                                // $('.modelCriacaoPropriedade .loadingadmins').css('display','none');
                                // $('.modelCriacaoPropriedade .retornoNotif').css('display','block');
                                window.location.href = URL_SITE+"planos/"+response.anuncio_id;
                            }
                        }, 2500);
                    }
                }
            });
        }
    });


  function readURL(input, target) {
      $('.formDados #image-container').css('display', 'block');

      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              $('.'+target).css('background-image', 'url('+e.target.result +')');
              $('.'+target).hide();
              $('.'+target).fadeIn(650);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }

   var $imageContainer = $('#image-container');
  var timeout
    $('#image-file').change(function () {
      $('.img-resultado').css('display','none');

        var src = window.URL.createObjectURL(this.files[0]);

      $('.image-cropped').css('display','block');
        var $image = $('<img/>');

        $image.attr({src: src}).load(function () {

            $imageContainer.html($image);       

            $image.cropper({
              aspectRatio: 800/600,
              zoonOnWheel: false,
              crop: function (e) {
                // console.log(e)
                $('#x').val(e.detail.x);
                $('#y').val(e.detail.y);
                $('#w').val(e.detail.width);
                $('#h').val(e.detail.height);
              }
            });
        })
    });

    $('.abrirFoto').click(function(event) {
      $('.image-file').trigger('click')
    });

    $('.formSolicitacao').validationEngine({
        scroll: false
    });
    $('.formSolicitacao').submit(function(e) {
        e.preventDefault();
        if ($(this).validationEngine('validate')) {

            var formulario = document.getElementById('formulario-solicitacao');
            var formData = new FormData(formulario);

          $('.modelSolicitacao .formSolicitacao').css('display', 'none');
          $('.modelSolicitacao .loadingadmins').css('display', 'block');

            $.ajax({
                url: URL_SITE + 'action/addSolicitacaoParaLocatario.php',
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                  if (response.status ==1) {
                    setTimeout(() => {
                      $('.modelSolicitacao .loadingadmins').css('display', 'none');
                      $('.modelSolicitacao .retornoNotif').css('display', 'block');
                    }, 2000);
                  } 
                }
            });
        }
    });

      "use strict";
const btn_add_input = document.getElementById("btn_add_input");
const form_input_modele = document.getElementById("form_input_modele");
const form_input_adds = document.getElementById("form_input_adds");

btn_add_input.addEventListener( 'click', function() {
  let nbre_add = Number(btn_add_input.dataset.nbre);
  let nbre_max = Number(btn_add_input.dataset.max);
  if( nbre_add < nbre_max )
  {
    btn_add_input.dataset.nbre = Number(btn_add_input.dataset.nbre)+1;
    // -----------
    // on clone le div modele
    let form_input_clone = form_input_modele.cloneNode(true);
    form_input_clone.removeAttribute('id'); // on supprime l attribut id du clone (car un id est unique)
    // -----------
    // bouton de suppression de la ligne
    let button = document.createElement("button");
    button.type = "button";
    button.classList.add("minus");
    button.classList.add("btn");
    button.classList.add("btn-primary");
    button.textContent = "-";
    button.addEventListener ( // le bouton "-" supprime tout le div
      "click",function(e){
        form_input_adds.removeChild(e.target.parentElement);
        e.preventDefault();
        btn_add_input.dataset.nbre = Number(btn_add_input.dataset.nbre)-1;
        btn_add_input.style.display = 'block';
      }
    );
    // -----------
    form_input_clone.appendChild(button);
    form_input_adds.appendChild(form_input_clone);
    // -----------
    // nombre maxi atteint
    if( nbre_add == nbre_max-1 )
    {
      btn_add_input.style.display = 'none';
    }
    // -----------
  }
});