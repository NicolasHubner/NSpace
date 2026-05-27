<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Array de retorno
	$returnArray = array();
	
	// Campos
	$fields = explode(',', $_GET['sColumns']);
	
	// Parâmetro de ordenação
	$orderby = $fields[$_GET['iSortCol_0']].' '.strtoupper($_GET['sSortDir_0']);
	
	// Parâmetro de Busca
	$where = '';
	if ($_GET['sSearch'] != ''){
		foreach ($fields as $key=>$value){
			if ($_GET['bSearchable_'.$key] == 'true'){
				if (isset($_GET[$value]) && $_GET[$value] == 'date'){
					$where .= 	$where==''?'DATE_FORMAT('.$value.',"%d/%m/%Y") LIKE "%'.$_GET['sSearch'].'%"':
					' OR DATE_FORMAT('.$value.',"%d/%m/%Y") LIKE "%'.$_GET['sSearch'].'%"';
				} else {
					$where .= 	$where==''?$value.' LIKE "%'.$_GET['sSearch'].'%"':
					' OR '.$value.' LIKE "%'.$_GET['sSearch'].'%"';
				}
			}
		}
	}
	$where = $where==''?'1 = 1':$where;
	
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('LogAnuncio a')->leftJoin('a.Estado e')->leftJoin('a.Cidade ci')->leftJoin('a.Categoria c')
					->where($where);
	$retLimit	= 	Doctrine_Query::create()->select()->from('LogAnuncio a')->leftJoin('a.Estado e')->leftJoin('a.Cidade ci')->leftJoin('a.Categoria c')
					->where($where)->offset($_GET['iDisplayStart'])->orderby($orderby)
					->limit($_GET['iDisplayLength'])->execute();
	
	// Tratamento dos dados
	if ($retLimit->count() > 0){
		// Transforma os dados em Array
		$resLimit = $retLimit->toArray();
		
		foreach ($resLimit as $value){
			// Trata as permissões
			$objPermissao = new UsuarioPermissao();
			$retPermissao = $objPermissao->getPermissao($_GET['model'],array(2,3));
			
			// Seleção de permissões nível 2
			if ($retPermissao){
				$action = '<div class="actionbar">';
				foreach ($retPermissao as $resPermissao){
					$tipo	= $resPermissao['tipo']==3?'action/':'';
					$acao	= $resPermissao['tipo']==3?'action3':'';
					if ($resPermissao['action']=='aprovar' && $value['status_id']!=2) {
						$action .= '<a href="'.URL_ADMIN.$tipo.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$value['id'].'/" data-toggle="tooltip" data-original-title="'.$resPermissao['titulo'].'"><i class="fa fa-'.$resPermissao['icone'].' '.$acao.'"></i></a>';
					} else if($resPermissao['action']!='aprovar') {
						$action .= '<a href="'.URL_ADMIN.$tipo.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$value['id'].'/" data-toggle="tooltip" data-original-title="'.$resPermissao['titulo'].'"><i class="fa fa-'.$resPermissao['icone'].' '.$acao.'"></i></a>';
					}
				}
				$action .= '</div>';
			} else {
				$action = '';
			}
			
			// Tratamento de dados
			$value['action'] =	'<div style="height: 3px;">&nbsp;</div>';
			$value['action'] .= $action;
			
			$value['valor'] = 'R$'.number_format($value['valor'], 2, ',', '.');
			$value['data_cadastro']	=	date('d/m/Y H:i', strtotime($value['data_cadastro']));
 			
			if (!isset($value['Estado']['nome'])) {
				$value['Estado']['nome'] = '-';
			} else {
				$value['Estado']['nome'] = $value['Cidade']['nome'].'/'.$value['Estado']['sigla'];
			}

			if (isset($value['imagem'])&&$value['imagem']!='') {
				$value['imagem'] = '<center><img class="img-admin-resp" src="'.$value['imagem'].'"></center>';
			}

			// Retorno
			$returnArray[] = $value;
		}
	}
	
	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> $retAll->count(),
		'iTotalDisplayRecords'	=> $retAll->count(),
		'aaData'				=> $returnArray
	);
	
	echo json_encode($returnJson);

} catch(Exception $e){


	
	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> 0,
		'iTotalDisplayRecords'	=> 0,
		'aaData'				=> array()
	);
	
	echo json_encode($returnJson);
	
}