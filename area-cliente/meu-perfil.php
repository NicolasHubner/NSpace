<div class="dashboard-wraper mb-20">
    <div class="form-submit">
        <h4 class="mb-20">Meu perfil</h4>
        <div class="submit-section">
        	<form class="formDados" id="formulario-dados" enctype='multipart/form-data'>
	            <div class="form-row">
	                <div class="form-group col-md-3">
					    <label>Seu Nome</label>
					    <input type="text" name="nome" class="form-control" <?php echo isset($objCliente->nome)&&$objCliente->nome!=''?'disabled':'' ?> value="<?php echo isset($objCliente->nome)&&$objCliente->nome!=''?$objCliente->nome:'' ?>" />
					</div>

					<div class="form-group col-md-3">
					    <label>Apelido</label>
					    <input type="text" name="apelido" class="form-control" value="<?php echo isset($objCliente->apelido)&&$objCliente->apelido!=''?$objCliente->apelido:'' ?>" />
					</div>

					<div class="form-group col-md-3">
					    <label>Data de nascimento</label>
					    <input type="text" name="data_nascimento" class="form-control" data-mask="99/99/9999" <?php echo isset($objCliente->data_nascimento)&&$objCliente->data_nascimento!=''?'disabled':'' ?> value="<?php echo isset($objCliente->data_nascimento)&&$objCliente->data_nascimento!=''?$objCliente->data_nascimento:'' ?>" />
					</div>

					<div class="form-group col-md-3">
					    <label>Email</label>
					    <input type="email" name="email" class="form-control" <?php echo isset($objCliente->email)&&$objCliente->email!=''?'disabled':'' ?> value="<?php echo isset($objCliente->email)&&$objCliente->email!=''?$objCliente->email:'' ?>"/>
					</div>

					<div class="form-group col-md-6">
					    <label>Telefone</label>
					    <input type="text" name="telefone" class="form-control" data-mask="(99) 99999-9999" value="<?php echo isset($objCliente->telefone)&&$objCliente->telefone!=''?$objCliente->telefone:'' ?>" />
					</div>

					<?php if (isset($objCliente->tipo_pessoa_id)&&$objCliente->tipo_pessoa_id==1) { ?>
						<div class="form-group col-md-6">
						    <label>CPF (Apenas digítos)</label>
						    <input type="text" class="form-control validaPerfCPF" name="cpf" id="cpf" <?php echo isset($objCliente->cpf)&&$objCliente->cpf!=''?'disabled':'' ?> data-mask="999.999.999-99" value="<?php echo isset($objCliente->cpf)&&$objCliente->cpf!=''?$objCliente->cpf:'' ?>"/>
						</div>
					<?php } else if ($objCliente->tipo_pessoa_id==2) { ?>
						<div class="form-group col-md-6">
						    <label>CNPJ (Apenas digítos)</label>
						    <input type="text" class="form-control validaCNPJ" name="cnpj" id="cnpj" <?php echo isset($objCliente->cnpj)&&$objCliente->cnpj!=''?'disabled':'' ?> data-mask="99.999.999/9999-99" value="<?php echo isset($objCliente->cnpj)&&$objCliente->cnpj!=''?$objCliente->cnpj:'' ?>"/>
						</div>
					<?php } ?>
				</div>

				<div class="form-row">
					<div class="form-group col-md-3">
					    <label>CEP</label>
					    <input type="text" class="form-control buscaCep" name="cep" data-mask='99999-999' value="<?php echo isset($objCliente->cep)&&$objCliente->cep!=''?$objCliente->cep:'' ?>">
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6">
					    <label>Logradouro</label>
					    <input type="text" class="form-control logradouro" name="logradouro" value="<?php echo isset($objCliente->logradouro)&&$objCliente->logradouro!=''?$objCliente->logradouro:'' ?>">
					</div>

					<div class="form-group col-md-3">
					    <label>Número</label>
					    <input type="text" class="form-control numero" name="numero" value="<?php echo isset($objCliente->numero)&&$objCliente->numero!=''?$objCliente->numero:'' ?>">
					</div>

					<div class="form-group col-md-3">
					    <label>Complemento</label>
					    <input type="text" class="form-control complemento" name="complemento" value="<?php echo isset($objCliente->complemento)&&$objCliente->complemento!=''?$objCliente->complemento:'' ?>">
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-4">
					    <label>Bairro</label>
					    <input type="text" class="form-control bairro" name="bairro" value="<?php echo isset($objCliente->bairro)&&$objCliente->bairro!=''?$objCliente->bairro:'' ?>">
					</div>

					<div class="form-group col-md-4">
                        <label>Estado:</label>
                        <select name="estado_id" data-live-search="true" data-width="100%"
                                data-toggle="tooltip" class="form-control estado_id">
                            <option value="">Estado</option>
                            <?php
                            try {

                                $resAtiv = Doctrine_Query::create()->select()->from('Estado')->execute();

                                if ($resAtiv->count() > 0) {
                                    $resAtiv->toArray();

                                    foreach ($resAtiv as $value) {
                                        $selected = $value['id']==$objCliente->estado_id?"selected":"";
                                        echo '<option value="' . $value['id'] . '" '.$selected.'>' . $value['sigla'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Nenhum registro encontrado</option>';
                                }
                            } catch (Exception $e) {
                                echo '<option value="">Ocorreu um erro de sistema</option>';
                            }
                            ?>
                        </select>
                    </div>

					<div class="form-group col-md-4">
                        <label>Cidade:</label>
                        <select class='form-control cidade_id' data-live-search="true" data-width="100%"
                                data-toggle="tooltip" name="cidade_id">
                            <option value="">Selecione o estado</option>
                            <?php
                            try {

                                $resAtiv = Doctrine_Query::create()->select()->from('Cidade')->where('estado_id = "'.$objCliente->estado_id.'"')->execute();

                                if ($resAtiv->count() > 0) {
                                    $resAtiv->toArray();

                                    foreach ($resAtiv as $value) {
                                        $selected = $value['id']==$objCliente->cidade_id?"selected":"";
                                        echo '<option value="' . $value['id'] . '" '.$selected.'>' . $value['nome'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Nenhum registro encontrado</option>';
                                }
                            } catch (Exception $e) {
                                echo '<option value="">Ocorreu um erro de sistema</option>';
                            }
                            ?>
                        </select>
                    </div>  
				</div>					

				<div class="form-row">
					<div class="form-group col-md-12">
					    <label>Sobre você(Max 301 caracteres)</label>
					    <textarea class="form-control" name="sobremin"><?php echo $objCliente->sobremin ?></textarea>
					</div>
				</div>

				<?php
					if (isset($objCliente->imagem)&&$objCliente->imagem!='') {
						$imagem = URL_CLIENTE.$objCliente->imagem;
					} else {
						$imagem = URL_IMAGES.'no-photo.png';
					}
				?>

				<div class="form-row">
					<div class="col-md-6">
						<label>Tamanho recomendável: 400x400 pixels</label><br>
						<input type="hidden" name="y" id="y" />
						<input type="hidden" name="x" id="x" />
						<input type="hidden" name="w" id="w" />
						<input type="hidden" name="h" id="h" />
						<label for="image-file">
							<button type="button" class="btn btn-warning abrirFoto">Selecionar foto</button>
							<div class="photo-upload">
								<div class="photo-edit">
									<input type='file' name="imagem" class="image-file" target='image-file' id="image-file" accept=".png, .jpg, .jpeg" />
								</div>
							</div>
						</label>
						<div id="image-container" style="width: 500px; max-height: 500px; background-image: url('<?php echo $imagem ?>');    background-position: center; background-repeat: no-repeat;">
						</div>

						<div class="img-resultado">
							<img id="imageInputUpl" src="<?php echo $imagem ?>">
						</div>
					</div>
				</div>

				<div class="form-row mt-10">
					<div class="form-group col-lg-12 col-md-12">
						<input type="hidden" name="id" value="<?php echo $objCliente->id ?>">
					    <button class="btn btn-theme btn-large" type="submit">Salvar mudanças</button>
					</div>
				</div>
           	</form>
        </div>
    </div>

</div>
<a class="btnRemove removerConta" href="javascript:void(0);" contaId='<?php echo $objCliente->id ?>'>Quero desativar minha conta</a>
