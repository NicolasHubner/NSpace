<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top detalheAdmin">
  <div class="col-md-12">
    <div class="block-flat">
      <div class="header">
        <a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>	
        <h3>Log do espaço</h3>
      </div>
      <?php 
        $resEspaco = Doctrine_Core::getTable('LogAnuncio')->find($_GET['id']);
      ?>
      <div class="blocoInfo mt-20">
        <h4>Dados do espaço:</h4>

        <div class="row mt-0">
          <div class="col-md-3">
            <div class="singleItem">
              <label>Data de cadastro:</label>
              <span class="text"><?php echo date('d/m/Y H:i', strtotime($resEspaco->data_cadastro)) ?></span>
            </div>
          </div>

          <?php if (isset($resEspaco->titulo)&&$resEspaco->titulo!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Título:</label>
                <span class="text"><?php echo $resEspaco->titulo ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->categoria_id)&&$resEspaco->categoria_id!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Categoria:</label>
                <span class="text"><?php echo $resEspaco->Categoria->nome ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->tipo_cobranca_id)&&$resEspaco->tipo_cobranca_id!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Tipo de Cobrança:</label>
                <span class="text"><?php echo $resEspaco->TipoCobranca->nome ?></span>
              </div>
            </div>
          <?php } ?>
        </div>

        <div class="row mt-0">
          <?php if (isset($resEspaco->espaco)&&$resEspaco->espaco!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Área m²:</label>
                <span class="text"><?php echo $resEspaco->espaco ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->limite_pessoas)&&$resEspaco->limite_pessoas!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Limite de pessoas:</label>
                <span class="text"><?php echo $resEspaco->limite_pessoas ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->codigo)&&$resEspaco->codigo!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Código:</label>
                <span class="text"><?php echo $resEspaco->codigo ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->valor)&&$resEspaco->valor!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Valor:</label>
                <span class="text"><?php echo 'R$'.number_format($resEspaco->valor, 2, ',', '.') ?></span>
              </div>
            </div>
          <?php } ?>
        </div>

        <div class="row mt-0">
          <?php if (isset($resEspaco->garagem)&&$resEspaco->garagem!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Garagem:</label>
                <span class="text"><?php echo $resEspaco->garagem ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->quarto)&&$resEspaco->quarto!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Quarto:</label>
                <span class="text"><?php echo $resEspaco->quarto ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->banheiro)&&$resEspaco->banheiro!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Banheiro:</label>
                <span class="text"><?php echo $resEspaco->banheiro ?></span>
              </div>
            </div>
          <?php } ?>
        </div>

        <div class="row mt-0">
          <div class="col-md-12">
            <div class="singleItem">
              <label>Descrição:</label>
              <span class="text"><?php echo $resEspaco->descricao ?></span>
            </div>
          </div>

          <div class="col-md-12">
            <div class="singleItem">
              <label>Opcionais:</label>
              <span class="text">
              <?php 
                  $retAnuncioOpcional = Doctrine_Query::create()->select()->from('AnuncioOpcional')->where('anuncio_id = '.$resEspaco->anuncio_id)->execute();
                  foreach ($retAnuncioOpcional as $objAnuncioOpcional) {
                    echo $objAnuncioOpcional->Opcional->nome.', ';
                  }
                ?>  
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="blocoInfo">
        <h4>Endereço completo:</h4>

        <div class="row mt-0">
          <?php if (isset($resEspaco->cep)&&$resEspaco->cep!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>CEP:</label>
                <span class="text"><?php echo $resEspaco->cep ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->logradouro)&&$resEspaco->logradouro!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Rua/Av:</label>
                <span class="text"><?php echo $resEspaco->logradouro ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->numero)&&$resEspaco->numero!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Nº:</label>
                <span class="text"><?php echo $resEspaco->numero ?></span>
              </div>
            </div>
          <?php } ?>

          <div class="col-md-3">
            <div class="singleItem">
              <label>Complemento:</label>
              <span class="text"><?php echo $resEspaco->complemento ?></span>
            </div>
          </div>
          
          <?php if (isset($resEspaco->bairro)&&$resEspaco->bairro!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Bairro:</label>
                <span class="text"><?php echo $resEspaco->bairro ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->cidade_id)&&$resEspaco->cidade_id!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Cidade:</label>
                <span class="text"><?php echo $resEspaco->Cidade->nome ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->estado_id)&&$resEspaco->estado_id!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Estado:</label>
                <span class="text"><?php echo $resEspaco->Estado->nome ?></span>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

      <div class="blocoInfo">
        <h4>Fotos do espaço:</h4>

        <div class="row mt-0">
          <?php if (isset($resEspaco->imagem)&&$resEspaco->imagem!='') { ?>
            <div class="col-md-2">
              <div class="singleItem">
                <label>Imagem de capa:</label>
                <div class="imagem">
                  <a href="<?php echo $resEspaco->imagem ?>" data-fancybox="group">
                    <img src="<?php echo $resEspaco->imagem ?>">
                  </a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>

        <h4>Fotos da documentação:</h4>
        <div class="row FotosComprovantes mt-0">
          <?php if (isset($resEspaco->local_proprio)&&$resEspaco->local_proprio==1) { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Comprovante de identidade:</label>
                <div class="imagem02">
                  <a href="<?php echo URL_CLIENTE.$resEspaco->Cliente->identidade ?>" data-fancybox="group">
                    <img src="<?php echo URL_CLIENTE.$resEspaco->Cliente->identidade ?>" style="width: 100%;">
                  </a>
                </div>
              </div>
            </div>
          <?php } else { ?>
             <?php if (isset($resEspaco->comprovante_identidade)&&$resEspaco->comprovante_identidade!='') { ?>
              <div class="col-md-3">
                <div class="singleItem">
                  <label>Comprovante de identidade:</label>
                  <div class="imagem02">
                    <a href="<?php echo $resEspaco->comprovante_identidade ?>" data-fancybox="group">
                      <img src="<?php echo $resEspaco->comprovante_identidade ?>" style="width: 100%;">
                    </a>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } ?>

          <?php if (isset($resEspaco->comprovante_endereco)&&$resEspaco->comprovante_endereco!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Comprovante de endereço:</label>
                <div class="imagem02">
                  <a href="<?php echo $resEspaco->comprovante_endereco ?>" data-fancybox="group">
                    <img src="<?php echo $resEspaco->comprovante_endereco ?>" style="width: 100%;">
                  </a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
