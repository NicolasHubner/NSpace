$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
                'aaSorting' :[[1, "DESC"]],
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=financeiro&action=listar",
        "aoColumns": [
			{ "mDataProp": "data_cadastro", "sName": "r.data_cadastro" },
			{ "mDataProp": "codigo", "sName": "r.codigo" },
			{ "mDataProp": "valor_cliente", "sName": "r.valor_cliente" },
			{ "mDataProp": "valor_afiliado", "sName": "r.valor_afiliado" },
			{ "mDataProp": "valor_nspace", "sName": "r.valor_nspace" },
			{ "mDataProp": "status", "sName": "r.status" }
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