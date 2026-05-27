class Payment{
  realizando = false
  valor = 0
  form = {
    cpf: null,
    data_nascimento: null,
    session: null,
    hash: null,
    plano: null,
    installments: [],
    selectedInstallment: null,
    cartao: {
      nome: null,
      numero: null,
      bandeira: null,
      cvv: null,
      vencimento: null,
      token: null
    },
    endereco: {
      cep: null,
      logradouro: null,
      numero: null,
      complemento: null,
      bairro: null,
      cidade_id: null,
      estado_id: null
    }
  }

  installmentsElement

  getInstallments = () => {
    this.getRequest('action/pagseguro/getInstallments.php', {valor: this.form.valor, bandeira: this.form.cartao.bandeira}).done((response)=>{
      this.form.installments = response
      this.printInstallments()
    })
  }

  printInstallments = () => {
    var html = "";

    this.form.installments.forEach((value, key) => {
      html += "<option value='"+key+"'>"+value.quantity+"x de R$"+value.amount+"</option>";
    });
    console.log(html)
    this.installmentsElement.html(html)
  }


  generateSession = () => {
    this.getRequest('action/pagseguro/createSession.php', {}).done((response)=>{
      this.form.session = response.session
      PagSeguroDirectPayment.setSessionId(this.form.session);
      console.log("Session", this.form.session)
      
      this.generateHash()
    })
  }

  generateHash = () => {
    this.form.hash = PagSeguroDirectPayment.getSenderHash();
    console.log("Hash", this.form.hash)
  }

  subscribePlan = () => {
    this.postRequest('action/pagseguro/subscribePlan.php', this.form).done((response)=>{
      console.log(response)
      location.href = URL_SITE+"assinatura-sucesso/"
    }).catch(e=> console.log('error', e))
  }
  
  createPayment = () => {
    this.postRequest('action/pagseguro/createPayment.php', this.form).done((response)=>{
      console.log(response)
      location.href = URL_SITE+"pagamento-sucesso/"
    }).catch(e=> console.log('error', e))
  }

  brandTimeout
  brandDelay = 800
  getBrand = () => {
    console.log(this.form.cartao.numero)
    if(this.form.cartao.numero && this.form.cartao.numero.length >= 9){
      clearTimeout(this.brandTimeout)
      this.brandTimeout = setTimeout(()=>{
        let splitCartao = this.form.cartao.numero.split(' ');
        // Pegar a bandeira do cartão
        PagSeguroDirectPayment.getBrand({
          cardBin: splitCartao[0]+splitCartao[1],
          success: response => {
            console.log('success', response)
            this.form.cartao.bandeira = response.brand.name

            if(this.form.tipo=='reserva'){
              console.log('é reserva')
              this.getInstallments()
            }
          },
          error: (response) => {
            this.presentAlert('Atenção', 'Cartão Inválido.')
          },
          complete: function(response){
            console.log('complete', response)
          }
        });
      }, this.brandDelay)
    }
  }

  validateCard = () => {
    console.log(this.form)
    if(this.form.cartao.nome==''){
      this.realizando = false
      this.presentAlert('Atenção', 'Por favor preencha com o nome completo do titular do cartão.')
      
      return false
    }else if(this.form.cartao.nome == null || this.form.cartao.nome.indexOf(" ")==-1 || this.form.cartao.nome.split(" ")[1] == ''){
      this.realizando = false
      this.presentAlert('Atenção', 'Por favor preencha com o nome completo do titular do cartão.')
      
      return false
    }else if(this.form.cartao.numero.length != 19){
      this.presentAlert('Cartão incompleto', 'Por favor preencha com todos os números do cartão de crédito.')
      this.realizando = false
      return false
    }else if(this.form.cartao.vencimento.length != 7){
      this.presentAlert('Vencimento', 'Por favor preencha o vencimento do cartão de crédito.')
      this.realizando = false
      return false
    }else if(this.form.cartao.cvv.length < 3){
      this.presentAlert('Código de segurança', 'Por favor preencha com o código de segurança do cartão de crédito.')
      this.realizando = false
      return false
    }else{
      let cartao = this.form.cartao.numero
      console.log(cartao)
      return cartao
    }
  }

  generateCardToken = () => {
    // Pegar token cartão de crédito
    let numeroCartao = this.form.cartao.numero.replace(/\s/g, '')
    let vencimentoSplit = this.form.cartao.vencimento.split('/')

    var param = {
      cardNumber: numeroCartao,
      cvv: this.form.cartao.cvv,
      expirationMonth: vencimentoSplit[0],
      expirationYear: vencimentoSplit[1],
      brand: this.form.bandeira,
      success: (response) => {
        this.form.cartao.tokenCartao = response.card.token ;
        console.log(this.form.cartao)
        if(response.card.token != ''){
          if(this.form.plano)
            this.subscribePlan();
          else
            this.createPayment();
        }
      },
      error: (response) => {
        this.presentAlert('Atenção','Informe um cartão válido');
      },
      complete: (response) => {
        console.log('complete', response)
      },
    }

    PagSeguroDirectPayment.createCardToken(param);
  }

  validAddress = () => {
    let isValid = true
    
    if(this.form.endereco.cep.length != 9){
      this.presentAlert('Atenção', 'Por favor preencha com o CEP.')
      isValid = false
    } else if(this.form.endereco.logradouro == ''){
      this.presentAlert('Atenção', 'Por favor preencha com o logradouro.')
      isValid = false
    } else if(this.form.endereco.numero == ''){
      this.presentAlert('Atenção', 'Por favor preencha com o numero.')
      isValid = false
    } else if(this.form.endereco.bairro == ''){
      this.presentAlert('Atenção', 'Por favor preencha com o bairro.')
      isValid = false
    } else if(this.form.endereco.estado == ''){
      this.presentAlert('Atenção', 'Por favor preencha com o estado.')
      isValid = false
    } else if(this.form.endereco.cidade == ''){
      this.presentAlert('Atenção', 'Por favor preencha com o cidade.')
      isValid = false
    }

    return isValid
  }

  cpfIsValid = () => {
    let strCPF = this.form.cpf
    let isValid = true

    let i
    var Soma
    var Resto
    let valido = true
    Soma = 0;
    strCPF = ""+strCPF.replace(/[^0-9]/g,'')
    if (strCPF == "00000000000" || strCPF == "11111111111" || strCPF == "22222222222" || strCPF == "33333333333" || strCPF == "44444444444" || strCPF == "55555555555" || strCPF == "66666666666" || strCPF == "77777777777" || strCPF == "88888888888" || strCPF == "99999999999") {
      isValid = false
    }

    for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i)
    Resto = (Soma * 10) % 11
    
    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) {
      isValid = false
    }
    
    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i)
    Resto = (Soma * 10) % 11
    
    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) 
      isValid = false
    
    return isValid
  }

  presentAlert = (title, message)=>{
    alert(title+"\n\n"+message)
  }

  getRequest = (url, body) => {
    return $.ajax({
      type: "GET",
      url: URL_SITE+url,
      data: body,
      dataType: "json"
    });
  }

  postRequest = (url, body) => {
    return $.ajax({
      type: "POST",
      url: URL_SITE+url,
      data: body,
      dataType: "json"
    });
  }
  
}
