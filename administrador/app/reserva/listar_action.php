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
	
	$where .= isset($_GET['status'])&&$_GET['status']!=''?" and status = ".$_GET['status']:'';
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('Reserva r')->leftJoin('r.Cliente c')->leftJoin('r.Anuncio a')->leftJoin('a.Estado es')->leftJoin('a.Cidade ci')
					->where($where);
	$retLimit	= 	Doctrine_Query::create()->select()->from('Reserva r')->leftJoin('r.Cliente c')->leftJoin('r.Anuncio a')->leftJoin('a.Estado es')->leftJoin('a.Cidade ci')
					->where($where)->offset($_GET['iDisplayStart'])
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
					$action .= '<a href="'.URL_ADMIN.$tipo.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$value['id'].'/" data-toggle="tooltip" data-original-title="'.$resPermissao['titulo'].'"><i class="fal fa-'.$resPermissao['icone'].' '.$acao.'"></i></a>';
				}
				$action .= '</div>';
			} else {
				$action = '';
			}
			
			// Tratamento de dados
			$value['action'] =	'<div style="height: 3px;">&nbsp;</div>';
			$value['action'] .= $action;

            if (!isset($value['Cliente']['apelido'])) {
                $value['Cliente']['apelido'] = 'NÃO INFORMADO!';
            } else {
                $value['Cliente']['apelido'] = '<span data-toggle="tooltip" data-original-title="'.$value['Cliente']['nome'].'">'.$value['Cliente']['apelido'].'</span>';
            }

			$value['data_cadastro']	=	date('d/m/Y H:i', strtotime($value['data_cadastro']));
			$value['data_entrada']	=	date('d/m/Y', strtotime($value['data_entrada']));
            
            $value['Anuncio']['cidade_id'] = $value['Anuncio']['Cidade']['nome'].'/'.$value['Anuncio']['Estado']['sigla'];

            $value['Anuncio']['titulo'] = '<span data-toggle="tooltip" data-original-title="'.$value['Anuncio']['titulo'].'">'.substr($value['Anuncio']['titulo'], 0, 25).'...</span>';

			if (isset($value['status'])&&$value['status']!='') {
				switch ($value['status']) {
					case '0':
						$status = '<div class="status-pagamento"><span class="aguardando"><i class="fas fa-circle"></i></span> Aguardando</div>';
						break;
					
					case '1':
						$status = '<div class="status-pagamento"><span class="aprovado"><i class="fas fa-circle"></i></span> Aprovado</div>';
						break;

					case '2':
						$status = '<div class="status-pagamento"><span class="cancelado"><i class="fas fa-circle"></i></span> Cancelado</div>';
						break;

					case '10':
						$status = '<div class="status-pagamento"><span class="finalizado"><i class="fas fa-circle"></i></span> Finalizado</div>';
						break;
				}

				$value['status'] = $status;
			}

			if (isset($value['validacaoCodigo'])&&$value['validacaoCodigo']==1) {
				$value['validacaoCodigo'] = '<div class="status-validacao"><span class="validada"><i class="fas fa-key"></i></span> Confirmada</div>';
			} else {
				$value['validacaoCodigo'] = '<div class="status-validacao"><span class="nao-validada"><i class="far fa-key"></i></span> N/Confirmada</div>';
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