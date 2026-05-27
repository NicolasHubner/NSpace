$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=respostas-automaticas&action=listar",
        "aoColumns": [
            { "mDataProp": "data_cadastro", "sName": "data_cadastro" },
        	{ "mDataProp": "texto", "sName": "texto" },
        	{ "mDataProp": "action", "bSortable": false, "bSearchable": false }
        ],
        "fnDrawCallback": function(oSettings, json) {
        	$('.action3').click(function(){
        		// Seleciona a ação
                        var acao = $(this).parent().attr('data-original-title');
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