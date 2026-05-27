$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
                'aaSorting' :[[0, "DESC"]],
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=solicitacao-cancelamento&action=listar",
        "aoColumns": [
                { "mDataProp": "data_cadastro", "sName": "c.data_cadastro" },
                { "mDataProp": "data_cancelamento", "sName": "c.data_cancelamento" },
                { "mDataProp": "Cliente.nome", "sName": "c.cliente_id" },
                { "mDataProp": "Anuncio.titulo", "sName": "c.anuncio_id" },
                { "mDataProp": "Plano.nome", "sName": "c.plano_id" },
                { "mDataProp": "status", "sName": "c.status" },
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
        }
	});
	

});