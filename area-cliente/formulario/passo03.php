<div class="form-row">
    <div class="col-md-12">
        <div><strong>Recomendamos sempre que cadastre no mínimo 6 fotos do seu espaço.</strong></div>
        <form class="dropzone modelUploadFoto wdt100" id="dropzoneFotos"  enctype='multipart/form-data'>
            <input type="hidden" name="etapa" value="3">
            <input type="hidden" name="cliente_id" value="<?php echo $objCliente->id ?>">
            <input type="hidden" class="anuncio_id" name="anuncio_id">
        </form><br>
    </div>
</div>

<div class="form-row">
    <div class="col-md-12">
        <a href="#ponto-inicial" class="passo-click" onclick="window.location.href='#ponto-inicial'" style="display: none;"></a>
        <a class="btn btn-theme top-scroll" id="proximoFoto" style="color: #fff;">Continuar</a>
    </div>
</div>
