$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        'aaSorting' :[[0, "desc"]],
        "sAjaxSource": URL_ADMIN+"action.php?model=cliente&action=listar",
        "aoColumns": [
        	{ "mDataProp": "data_cadastro", "sName": "cl.data_cadastro" },
                { "mDataProp": "nome", "sName": "cl.nome" },
                { "mDataProp": "email", "sName": "cl.email", "bSearchable": false },
                { "mDataProp": "telefone", "sName": "cl.telefone", "bSearchable": false },
                { "mDataProp": "TipoCliente.nome", "sName": "cl.tipo_cliente_id", "bSearchable": false },
        	{ "mDataProp": "Estado.nome", "sName": "cl.estado_id", "bSearchable": false },
                { "mDataProp": "status", "sName": "cl.status", "bSearchable": false },
        	{ "mDataProp": "action", "bSortable": false, "bSearchable": false }
        ],
        "fnDrawCallback": function(oSettings, json) {
        	$('.action3').click(function(){
        		// Seleciona a ação
        		var acao = $(this).parent().attr('data-original-title');
        		// Solicitação de confirmação
        		if (confirm('Deseja '+acao+'?')){
        			return true;
        		} else {
        			return false;
        		}
        	});
                $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
        },
          "fnServerData": function(sSource, aoData, fnCallback) {
            aoData.push({ "name": "verificado", "value": $("#verificado").val() });
            $.getJSON(sSource, aoData, function(json) {
              fnCallback(json);
            });
          }
	});
	

});