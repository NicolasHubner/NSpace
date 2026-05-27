$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
                'aaSorting' :[[0, "asc"]],
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=blog&action=listar",
        "aoColumns": [
                { "mDataProp": "data_cadastro", "sName": "b.data_cadastro" },
                { "mDataProp": "titulo", "sName": "b.titulo" },
                { "mDataProp": "status", "sName": "b.status" },
                { "mDataProp": "destaque", "sName": "b.destaque" },
                { "mDataProp": "imagem", "sName": "b.imagem" },
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