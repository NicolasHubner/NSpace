<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top detalheAdmin">
  <div class="col-md-12">
    <div class="block-flat">
      <div class="header">
        <a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>	
        <h3>Espaço - Editar</h3>
      </div>
      <?php 
        $resEspaco = Doctrine_Core::getTable('Anuncio')->find($_GET['id']);
      ?>

      <div class="blocoInfo mt-40">
        <h4>Dados do cliente:</h4>

        <div class="row">
          <?php if (isset($resEspaco->cliente_id)&&$resEspaco->cliente_id!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Cliente:</label>
                <span class="text"><?php echo $resEspaco->Cliente->nome ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->cliente_id)&&$resEspaco->cliente_id!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>E-mail:</label>
                <span class="text"><?php echo $resEspaco->Cliente->email ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->cliente_id)&&$resEspaco->cliente_id!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Telefone:</label>
                <span class="text"><?php echo $resEspaco->Cliente->telefone ?></span>
              </div>
            </div>
          <?php } ?>

          <?php if (isset($resEspaco->cliente_id)&&$resEspaco->cliente_id!='') { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Apelido:</label>
                <span class="text"><?php echo $resEspaco->Cliente->apelido ?></span>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

      <div class="blocoInfo">
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
              <label>Tags:</label>
              <span class="text"><?php echo $resEspaco->tags ?></span>
            </div>
          </div>
        </div>

        <div class="row mt-0">
          <div class="col-md-12">
            <div class="singleItem">
              <label>Descrição:</label>
              <span class="text"><?php echo $resEspaco->descricao ?></span>
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
                  <a href="<?php echo URL_ANUNCIO.$resEspaco->imagem ?>" data-fancybox="group">
                    <img src="<?php echo URL_ANUNCIO.$resEspaco->imagem ?>">
                  </a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>

        <div class="row mt-0">
          <?php 
            $retAnuncioFoto = Doctrine_Query::create()->select()->from('AnuncioFoto')->where('anuncio_id = '.$resEspaco->id)->execute();
            $x = 1;
            foreach ($retAnuncioFoto as $objAnuncioFoto) {
              ?>
                <div class="col-md-2">
                  <div class="singleItem">
                    <label>Imagem <?php echo $x ?>:</label>
                    <div class="imagem">
                      <a href="<?php echo URL_ANUNCIO.$objAnuncioFoto->imagem ?>" data-fancybox="group">
                        <img src="<?php echo URL_ANUNCIO.$objAnuncioFoto->imagem ?>">
                      </a>
                    </div>
                  </div>
                </div>
              <?php 
            $x++;
            } 
          ?>
        </div>
      </div>

      <div class="blocoInfo">
        <h4>Fotos da documentação:</h4>
        <div class="row FotosComprovantes mt-0">
          <?php if (isset($resEspaco->local_proprio)&&$resEspaco->local_proprio==1) { 
            $retClienteMigracao = Doctrine_Query::create()->select()->from('ClienteMigracao')->where('cliente_id = '.$resEspaco->cliente_id)->limit(1)->orderBy('data_cadastro DESC')->execute();
            $objClienteMigracao = $retClienteMigracao[0];
            ?>
            <?php if (isset($objClienteMigracao->comprovante_identidade)&&$objClienteMigracao->comprovante_identidade!='') { ?>
              <div class="col-md-3">
                <div class="singleItem">
                  <label>Comprovante de Identidade:</label>
                  <div class="icone-doc">
                    <a class="btn btn-success" href="<?php echo URL_CLIENTE.$objClienteMigracao->comprovante_identidade  ?>" data-fancybox="group">
                      <i class="fal fa-file"></i> Visualizar
                    </a>
                  </div>
                </div>
              </div>
            <?php } else if (isset($resEspaco->comprovante_identidade)&&$resEspaco->comprovante_identidade!='') { ?>
              <div class="col-md-3">
                <div class="singleItem">
                  <label>Comprovante de Identidade:</label>
                  <div class="icone-doc">
                    <a class="btn btn-success" href="<?php echo URL_ANUNCIO_DOCUMENTOS.$resEspaco->comprovante_identidade  ?>" data-fancybox="group">
                      <i class="fal fa-file"></i> Visualizar
                    </a>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } else { ?>
            <div class="col-md-3">
              <div class="singleItem">
                <label>Comprovante de Identidade:</label>
                <div class="icone-doc">
                  <a class="btn btn-success" href="<?php echo URL_ANUNCIO_DOCUMENTOS.$resEspaco->comprovante_identidade  ?>" data-fancybox="group">
                    <i class="fal fa-file"></i> Visualizar
                  </a>
                </div>
              </div>
            </div>
          <?php } ?>

           <div class="col-md-3">
              <div class="singleItem">
                <label>Comprovante de Endereço:</label>
                <div class="icone-doc">
                  <a class="btn btn-success" href="<?php echo URL_ANUNCIO_DOCUMENTOS.$resEspaco->comprovante_endereco  ?>" data-fancybox="group">
                    <i class="fal fa-file"></i> Visualizar
                  </a>
                </div>
              </div>
            </div>
        </div>
      </div>


      <div class="blocoInfo">
        <h4>Liberação do espaço:</h4>
        <form method="post" action="<?php echo URL_ADMIN.'app/'.$_GET['model'].'/attVerificaEspaco.php' ?>">
          <div class="row mt-0 mb-20">
            <div class="col-md-12">
              <label>Status:</label><br>
              <label><input type="radio" name="status_id" value="1" <?php echo isset($resEspaco->status_id)&&$resEspaco->status_id==1?'checked':'' ?>> Analisando</label>
              <label><input class="ml-10" type="radio" name="status_id" value="2" <?php echo isset($resEspaco->status_id)&&$resEspaco->status_id==2?'checked':'' ?>> Aprovar</label>
              <label><input class="ml-10" type="radio" name="status_id" value="3" <?php echo isset($resEspaco->status_id)&&$resEspaco->status_id==3?'checked':'' ?>> Reprovar</label>
            </div>
          </div>

          <div class="displayNegar" <?php echo isset($resEspaco->status_id)&&$resEspaco->status_id==3?'style="display: block;"':'style="display: none;"' ?>>
            <div class="row mt-0">
              <div class="col-md-12">
                <label>Resposta automática:</label><br>
                <?php
                  $retRespostaAutomatica = Doctrine_Query::create()->select()->from('RespostaAutomatica')->execute();
                  foreach ($retRespostaAutomatica as $objRespostaAutomatica) {
                    ?>
                      <label class="resposdentes"><input type="radio" name="resposta_automatica_id" id="resposta_automatica" value="<?php echo $objRespostaAutomatica->id ?>"> <?php echo $objRespostaAutomatica->texto ?></label>
                    <?php 
                  }
                ?>
              </div> 
            </div>

            <div class="row">
              <div class="col-md-12">
                <label>Aviso:</label><br>
                <textarea class="form-style" name="aviso" id="aviso"><?php echo $resEspaco->aviso ?></textarea>
              </div> 
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="id" value="<?php echo $resEspaco->id ?>">
              <input type="submit" class="btn btn-primary" value="Salvar dados">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function() {
    $('input[name="status_id"]:radio').change(function () {
        var status_id = $("input[name='status_id']:checked").val();

        if (status_id == 3) {
          $('.displayNegar').css('display', 'block');
        } else {
          $('.displayNegar').css('display', 'none');
          $('#aviso').val("");
        }
    });
  });
</script>