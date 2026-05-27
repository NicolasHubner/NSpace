$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
                'aaSorting' :[[0, "DESC"]],
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=depoimento&action=listar",
        "aoColumns": [
                { "mDataProp": "data_cadastro", "sName": "d.data_cadastro" },
                { "mDataProp": "nome", "sName": "d.nome" },
                { "mDataProp": "status", "sName": "d.status" },
                { "mDataProp": "destaque", "sName": "d.destaque" },
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