$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
                'aaSorting' :[[0, "desc"]],
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=espaco&action=listar",
        "aoColumns": [
                { "mDataProp": "data_cadastro", "sName": "a.data_cadastro" },
                { "mDataProp": "titulo", "sName": "a.titulo" },
                { "mDataProp": "Categoria.nome", "sName": "a.categoria_id" },
                { "mDataProp": "Estado.nome", "sName": "a.estado_id" },
                { "mDataProp": "Status.nome", "sName": "a.status_id" },
                { "mDataProp": "pagamento", "sName": "a.pagamento" },
                { "mDataProp": "valor", "sName": "a.valor" },
                { "mDataProp": "imagem", "sName": "a.imagem" },
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