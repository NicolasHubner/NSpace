$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=plano&action=beneficio_listar",
        'aaSorting' :[[0, "desc"]],
        "aoColumns": [
            { "mDataProp": "nome", "sName": "b.nome" },
            { "mDataProp": "ordem", "sName": "b.ordem", "bSearchable": false },
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
                    data: { id : $(this).attr('codigo'), ordem : $(this).val(), tabela: 'Beneficio' },
                    dataType: "html"
                });
            });
            $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
        },
        "fnServerData": function(sSource, aoData, fnCallback){
        	aoData.push({ "name": "plano_id", "value": $("input[name=plano_id]").val() });
        	$.getJSON( sSource, aoData, function(json){
        		fnCallback(json);
            });
        }
	});
});