$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
                'aaSorting' :[[1, "DESC"]],
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=reserva&action=listar",
        "aoColumns": [
			{ "mDataProp": "data_cadastro", "sName": "r.data_cadastro" },
			{ "mDataProp": "data_entrada", "sName": "r.data_entrada" },
			{ "mDataProp": "Cliente.apelido", "sName": "c.apelido" },
			{ "mDataProp": "Anuncio.titulo", "sName": "a.titulo" },
			{ "mDataProp": "Anuncio.cidade_id", "sName": "a.cidade_id" },
			{ "mDataProp": "status", "sName": "r.status" },
			{ "mDataProp": "validacaoCodigo", "sName": "r.validacaoCodigo" },
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
                
                $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
        },
        "fnServerData": function(sSource, aoData, fnCallback) {
            aoData.push({ "name": "status", "value": $("#status").val() });
            $.getJSON(sSource, aoData, function(json) {
              fnCallback(json);
            });
          }
	});
	

});