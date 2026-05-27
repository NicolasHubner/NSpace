 $(".valor-input").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
   $(".buscaCep").change(function(){
    if($.trim($(".buscaCep").val()) != ""){
      /* 
          Para conectar no serviço e executar o json, precisamos usar a função
          getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
          dataTypes não possibilitam esta interação entre domínios diferentes
          Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
          http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$(".buscaCep").val()
      */
      
      $.get("https://viacep.com.br/ws/"+$(".buscaCep").val()+"/json/", function(data){
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
              $(".logradouro").val(unescape(unescape(data["logradouro"])));
              // ID do campo do bairro
              $(".bairro").val(unescape(data["bairro"]));
              // ID do campo do estado
              // $('#estado').find('option[text="'+uf+'"]').attr('selected', 'selected');
              // console.log("'"+uf+"'");
                $('.estado_id option:contains(' + uf + ')').each(function(){
                    if ($(this).text() == uf) {
                        $(this).attr('selected', 'selected');
                        estado_id = $(this).val();
                        // return false;
                    }
                    // return true;
                    $(".estado_id").val(estado_id);
                });
                $(".estado_id");

                $("select[name=cidade_id]").html('<option value="">Carregando...</option>');

                $.when( $.getJSON("<?php echo URL_ADMIN ?>getCidades.php",{estado_id: estado_id}, function(j){
                    $("select[name=cidade_id]").html('<option value="">Carregando...</option>');
                    var options = '<option value="">Selecione</option>';    
                    for (var i = 0; i < j.length; i++){

                        options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
                        
                    }   
                   $(".cidade_id").html(options);
                })).done(function() {
                    $('.cidade_id option:contains(' + cidade + ')').each(function(){
                        if ($(this).text() == cidade) {
                            $(this).attr('selected', 'selected');
                            cidade_id = $(this).val();
                            // return false;
                        }
                        // return true;
                    });
                    $(".cidade_id");

                    

                    $("#carregando").css('display', 'none');
                });
                
                // alert("ae");
                

                $('.numero').focus();
                
              // ID do campo da Cidade
              // $("#cidade").val(unescape(data["cidade"]));
          }else{
              alert("Endereço não encontrado");
          }
      });                
    }
    }); 

     $(".estado_id").change(function(){
        // alert("ae");
        if($(this).val()){
            $(".cidade_id").html('<option value="">Carregando...</option>');
            $.getJSON("<?php echo URL_ADMIN ?>getCidades.php",{estado_id: jQuery(this).val()}, function(j){
                var options = '<option value="">Selecione</option>';
                for (var i = 0; i < j.length; i++){
                    options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';

                }
                $(".cidade_id").html(options);

            });
        } else {
            $(".cidade_id").html('<option value="">Selecione um estado</option>');
        }
    });

     $(".cidade_id").change(function(){
        // alert("ae");
        if($(this).val()){
            $(".regiao_id").html('<option value="">Carregando...</option>');
            $.getJSON("<?php echo URL_ADMIN ?>getRegiao.php",{cidade_id: jQuery(this).val()}, function(j){
                var options = '<option value="">Selecione</option>';
                for (var i = 0; i < j.length; i++){
                    options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';

                }
                $(".regiao_id").html(options);

            });
        } else {
            $(".regiao_id").html('<option value="">Selecione um cidade</option>');
        }
    });

    $('.formDados').validationEngine({
        scroll: false
    });
  $('.formDados').submit(function(e) {
      e.preventDefault();
      if ($(this).validationEngine('validate')) {

          var formulario = document.getElementById('formulario-dados');
          var formData = new FormData(formulario);

          $.ajax({
              url: URL_SITE + 'action/editDados.php',
              processData: false,
              contentType: false,
              type: 'POST',
              dataType: 'json',
              data: formData,
              success: function(response) {
                if (response.status == 1 && response.imagem !='' && response.imagem != null) {
                    $('.formDados #image-container').css('display', 'none');
                    $('.formDados .img-resultado').css('display', 'block');

                    document.getElementById("imageInputUpl").src= response.imagem;
                    document.getElementById("sidebarImg").src= response.imagem;
                    document.getElementById("imgHeaderPerfil").src= response.imagem;
                    Lobibox.notify('success', {
                        delay: 6000,
                      position: "top right", 
                        title: 'Sucesso',
                        dataType: "json",
                        icon: true,
                        msg: 'Dados editados com sucesso!'
                    });
                } else if (response.status == 2) { 
                    if (response.imagem!= null) {
                      document.getElementById("imageInputUpl").src= response.imagem;
                      document.getElementById("sidebarImg").src= response.imagem;
                      document.getElementById("imgHeaderPerfil").src= response.imagem;
                    }
                    Lobibox.notify('error', {
                        delay: 6000,
                    position: "top right", 
                        title: 'Algo deu errado',
                        dataType: "json",
                        icon: true,
                        msg: 'CPF já cadastrado!'
                    });

                    $('#cpf').val('');
                } else {
                    Lobibox.notify('success', {
                        delay: 6000,
                    position: "top right", 
                        title: 'Sucesso',
                        dataType: "json",
                        icon: true,
                        msg: 'Dados editados com sucesso!'
                    });
                }
              
              }
          });
      }
  });

 function readURL(input, target) {
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

        var src = window.URL.createObjectURL(this.files[0]);

        console.log(window.URL)
        $('.img-resultado').css('display','none');


        var $image = $('<img/>');

        $image.attr({src: src}).load(function () {

            $imageContainer.html($image);       

            $image.cropper({
              aspectRatio: 400/400,
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

    $('.formVerificacao').validationEngine({
        scroll: false
    });
    $('.formVerificacao').submit(function(e) {
        e.preventDefault();
        if ($(this).validationEngine('validate')) {

            var formulario = document.getElementById('formulario-verificacao');
            var formData = new FormData(formulario);

          $('.modalVerificacaoConta .formVerificacao').css('display', 'none');
          $('.modalVerificacaoConta .loadingadmins').css('display', 'block');

            $.ajax({
                url: URL_SITE + 'action/addSolicitacaoVerificacao.php',
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                  if (response.status ==1) {
                    setTimeout(() => {
                      $('.modalVerificacaoConta .loadingadmins').css('display', 'none');
                      $('.modalVerificacaoConta .retornoNotif').css('display', 'block');
                    }, 2000);
                  } 
                }
            });
        }
    });

    $('.formAlterarSenha').validationEngine({
        scroll: false
    });
    $('.formAlterarSenha').submit(function(e) {
        e.preventDefault();
        let form =  $(this);
        if ($(this).validationEngine('validate')) {

            var formulario = document.getElementById('formulario-alterar-senha');
            var formData = new FormData(formulario);

            $.ajax({
                url: URL_SITE + 'action/atualizarSenha.php',
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
                      title: 'Alterar Senha',
                      dataType: "json",
                      icon: true,
                      msg: 'Senha alterada com sucesso.'
                    });

                    $(form)[0].reset();

                  }  else {
                    Lobibox.notify('error', {
                      delay: 6000,
                      position: "top right", 
                      title: 'Algo de errado',
                      dataType: "json",
                      icon: true,
                      msg: 'Senha atual inválida!'
                    });
                  }
                }
            });
        }
    });

    function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
    }

   

   

    $('.model-minhas-propriedades #deletarAnuncio').click(function(e) {
      e.preventDefault();

      let element = $(this);

      Lobibox.confirm({
        title: 'Ação',
        msg: '<center>Confirma a exclusão do registro?<center>',
        callback: function(lobibox, type){
          if(type == "yes"){
            $.ajax({
              url: URL_SITE + 'action/deletarAnuncio.php',
              type: 'POST',
              dataType: 'json',
              data: {id: $(element).attr('anuncio_id')},
              success: function(response) {
                if (response.status ==1) {
                  Lobibox.notify('success', {
                    delay: 1900,
                    position: "top right", 
                    title: 'Sucesso',
                    dataType: "json",
                    icon: true,
                    msg: 'Propriedade excluída com sucesso.'
                  });
                  setTimeout(() => {
                    location.reload();
                  }, 2000);
                }
              }
            });
          } 
        }
      });
    });

    $('.modelReservas #deletarDataPersonalizada').click(function(e) {
      e.preventDefault();

      let element = $(this);

      Lobibox.confirm({
        title: 'Ação',
        msg: '<center>Confirma a exclusão do registro?<center>',
        callback: function(lobibox, type){
          if(type == "yes"){
            $.ajax({
              url: URL_SITE + 'action/deletarDataPersonalizada.php',
              type: 'POST',
              dataType: 'json',
              data: {id: $(element).attr('anuncio_data_id')},
              success: function(response) {
                if (response.status ==1) {
                  Lobibox.notify('success', {
                    delay: 1900,
                    position: "top right", 
                    title: 'Sucesso',
                    dataType: "json",
                    icon: true,
                    msg: 'Data excluída com sucesso.'
                  });
                  setTimeout(() => {
                    location.reload();
                  }, 1000);
                }
              }
            });
          } 
        }
      });
    });

    $('.modelReservas #deletarDataBloqueada').click(function(e) {
      e.preventDefault();

      let element = $(this);

      Lobibox.confirm({
        title: 'Ação',
        msg: '<center>Confirma a exclusão do registro?<center>',
        callback: function(lobibox, type){
          if(type == "yes"){
            $.ajax({
              url: URL_SITE + 'action/deletarDataBloqueada.php',
              type: 'POST',
              dataType: 'json',
              data: {id: $(element).attr('anuncio_data_id')},
              success: function(response) {
                if (response.status ==1) {
                  Lobibox.notify('success', {
                    delay: 1900,
                    position: "top right", 
                    title: 'Sucesso',
                    dataType: "json",
                    icon: true,
                    msg: 'Data excluída com sucesso.'
                  });
                  setTimeout(() => {
                    location.reload();
                  }, 1000);
                }
              }
            });
          } 
        }
      });
    });

    $('.model-minhas-propriedades #deletarAnuncioFavorito').click(function(e) {
      e.preventDefault();

      let element = $(this);

      console.log($(element).attr('anuncio_favorito_id'));

      Lobibox.confirm({
        title: 'Ação',
        msg: '<center>Confirma a exclusão do espaço dos favoritos?<center>',
        callback: function(lobibox, type){
          if(type == "yes"){
            $.ajax({
              url: URL_SITE + 'action/deletarAnuncioFavorito.php',
              type: 'POST',
              dataType: 'json',
              data: {id: $(element).attr('anuncio_favorito_id')},
              success: function(response) {
                if (response.status ==1) {
                  Lobibox.notify('success', {
                    delay: 1900,
                    position: "top right", 
                    title: 'Sucesso',
                    dataType: "json",
                    icon: true,
                    msg: 'Propriedade excluída com sucesso.'
                  });
                  setTimeout(() => {
                    location.reload();
                  }, 2000);
                }
              }
            });
          } 
        }
      });
    });     


    $('.removerConta').click(function() {
    let contaId = $(this).attr('contaId');

    Lobibox.confirm({
        title: 'Ação',
        msg: '<center>Você confirma a desativação da sua conta?<center>',
        callback: function(lobibox, type){
          if(type == "yes"){
            $.ajax({
              url: URL_SITE + 'action/deletarContaPermanente.php',
              type: 'POST',
              dataType: 'json',
              data: {id: contaId},
              success: function(response) {
                if (response.status ==1) {
                  Lobibox.notify('success', {
                    delay: 1900,
                    position: "top right", 
                    title: 'Sucesso',
                    dataType: "json",
                    icon: true,
                    msg: 'Sua conta foi desativada com sucesso'
                  });
                  setTimeout(() => {
                    window.location.href  =  URL_SITE;
                  }, 2000);
                }
              }
            });
          } 
        }
      });
  });


  $('.validar-reserva').click(function() {
    $('.modalValidarReserva').modal();
    let reservaId = $(this).attr('reserva-id');
    let clienteId = $(this).attr('cliente-id');

    $('.valReserva').val(reservaId);
    $('.valCliente').val(clienteId);
  });

  $('.formValidarReserva').validationEngine({
        scroll: false
    });
    $('.formValidarReserva').submit(function(e) {
        e.preventDefault();
        let form =  $(this);
        if ($(this).validationEngine('validate')) {

            var formulario = document.getElementById('form-validar-reserva');
            var formData = new FormData(formulario);

            $.ajax({
                url: URL_SITE + 'action/validarReserva.php',
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
                      title: 'Sucesso',
                      dataType: "json",
                      icon: true,
                      msg: 'Reserva validada com sucesso.'
                    });

                    $(form)[0].reset();
                    setTimeout(() => {
                      window.location.href  =  URL_SITE+'painel/gerenciar-reservas/';
                    }, 2000);

                  } else {
                    Lobibox.notify('error', {
                      delay: 6000,
                      position: "top right", 
                      title: 'Algo de errado',
                      dataType: "json",
                      icon: true,
                      msg: 'Código informado inválido!'
                    });
                  }
                }
            });
        }
    });  

    $('.sacarAgora').click(function() {
      $('.modalSolicitacaoSaque').modal();
      let clienteId = $(this).attr('cliente-id');
      $('.meuFinanceiro .valCliente').val(clienteId);
    });

    $('.meuFinanceiro input[name=tipo_transacao_id]').change(function(){
      var TransacaoId = $( '.meuFinanceiro input[name=tipo_transacao_id]:checked' ).val();
      if (TransacaoId == 2) {
        $('.tipoTransferencia').css('display', 'none');
        $('.viaTransferencia').css('display', 'none');
        $('.viaPIX').css('display', 'block');
      } else {
        $('.tipoTransferencia').css('display', 'block');
        $('.viaPIX').css('display', 'none');
        $('.viaTransferencia').css('display', 'block');
      }
    });

     $('.formSaque').validationEngine({
        scroll: false
    });
    $('.formSaque').submit(function(e) {
        e.preventDefault();
        let form =  $(this);
        if ($(this).validationEngine('validate')) {

            var formulario = document.getElementById('formulario-saque');
            var formData = new FormData(formulario);
            $('.modalSolicitacaoSaque').hide();

            Lobibox.confirm({
              title: 'Ação',
              msg: '<center>Confirma efetuar o saque?<center>',
              callback: function(lobibox, type){
                if(type == "yes"){
                  $.ajax({
                      url: URL_SITE + 'action/addSolicitacaoSaque.php',
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
                            title: 'Sucesso',
                            dataType: "json",
                            icon: true,
                            msg: 'Saque efetuado com sucesso!'
                          });

                          $(form)[0].reset();
                          setTimeout(() => {
                            window.location.href  =  URL_SITE+'painel/financeiro/';
                          }, 1000);

                        } else if (response.status == 2) {
                          Lobibox.notify('error', {
                            delay: 6000,
                            position: "top right", 
                            title: 'Algo de errado',
                            dataType: "json",
                            icon: true,
                            msg: 'Valor indisponível para saque!'
                          });
                          $('.modalSolicitacaoSaque').show();
                        }  else if (response.status == 3) {
                          Lobibox.notify('error', {
                            delay: 6000,
                            position: "top right", 
                            title: 'Algo de errado',
                            dataType: "json",
                            icon: true,
                            msg: 'O valor mínimo para saque é de R$50!'
                          });
                          $('.modalSolicitacaoSaque').show();
                        }
                      }
                  });
                } else if(type == "no"){
                  $('.modalSolicitacaoSaque').show();
                }
            }
          });
        }
    }); 


  function listaMensagens() {
    $.ajax({
      url: URL_SITE+'action/listaMensagens.php',
      type: 'POST',
      data: {reserva_id: $('#reserva_id').val()},
      success: function (data) {
        $('#lista-mensagens').html(data);
        // listaMensagens();
      }
    });
  }

  // setTimeout(function() {
    listaMensagens();
  // }, 2000);