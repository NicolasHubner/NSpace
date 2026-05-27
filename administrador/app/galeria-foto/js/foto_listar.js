$(document).ready(function(){
    
    $('.data-table').dataTable({
        "sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search">><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
        "bJQueryUI": true,
        "bProcessing": true,
        "bServerSide": true,
        "aaSorting": [[ 2, "ASC" ]],
        "sAjaxSource": URL_ADMIN+"action.php?model=galeria-foto&action=foto_listar",
        "aoColumns": [
          { "mDataProp": "imagem", "sName": "imagem" },
          { "mDataProp": "nome", "sName": "ub.nome" },
          { "mDataProp": "ordem", "sName": "ordem", "bSortable": false },
          { "mDataProp": "action", "bSortable": false, "bSearchable": false }
        ],
        "fnDrawCallback": function(oSettings, json) {
            $('.action3').click(function(){
                // Seleciona a ação
                var acao = $(this).children('span').html();
                // Solicitação de confirmação
                if (confirm('Deseja '+acao+' este registro?')){
                    return true;
                } else {
                    return false;
                }
            });
            $('.ordem').change(function(){
                    var request = $.ajax({
                        url: URL_ADMIN+"changeOrdem.php",
                        type: "POST",
                        data: { id : $(this).attr('codigo'), ordem : $(this).val(), tabela: 'GaleriaFoto' },
                        dataType: "html"
                    });
            });
        },
        "fnServerData": function(sSource, aoData, fnCallback){
            aoData.push({ "name": "galeria_id", "value": $("input[name=galeria_id]").val() });
            $.getJSON( sSource, aoData, function(json){
                fnCallback(json);
            });
        }
    });

});