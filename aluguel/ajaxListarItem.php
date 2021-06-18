<?php

	include_once('..\conexao.php');
	
	$page  = $_GET['page']; 
	$limit = isset($_GET['rows']) ? $_GET['rows'] : 1; 
	$sidx  = isset($_GET['sidx']) ? $_GET['sidx'] : 'idCarroAlugado'; 
	$sord  = $_GET['sord']; 		
	
	$idAluguel = $_GET['idAluguel'];
	
	if( $idAluguel > 0 ){	 	
		$where .= " WHERE idAluguel = $idAluguel ";	
	}else{
		$where .= " 1 = 0 ";
	}
		
	//Quantidade de registros a serem paginados na grid
	$queryCount = "SELECT COUNT(idCarroAlugado) as count
			  	   FROM carroAlugado INNER JOIN carro
				        ON carro.idCarro = carroAlugado.idCarro
 			       $where";
				 
	$resultSetCount = mysql_query($queryCount);	
	$rowCount = mysql_fetch_array($resultSetCount);
	$count = $rowCount['count'];
	
	if( $count>0 ){
		$total_pages = ceil($count/$limit);	
	}else{
		$total_pages = 0;
	}
	
	if ($page > $total_pages) $page=$total_pages;
	$start = ($limit*$page) - $limit;
	if($start < 0){
		$start = 0;
	}
	
    $query = "SELECT idCarroAlugado,nomeCarro,quant,precoAluguel,desconto,
				(precoAluguel * quant - desconto) total
			  FROM carroAlugado INNER JOIN carro 
               ON carro.idCarro = carroAlugado.idCarro
			  
			  $where
			  ORDER BY $sidx 
			  LIMIT $start , $limit";				 
					
    $resultSet = mysql_query($query);
	
	$response->page = $page;
	$response->total = $total_pages;
	$response->records = $count;
	$i=0;
	while( $row = mysql_fetch_array($resultSet) ){
						
		$response->rows[$i]['idCarroAlugado']=$row['idCarroAlugado'];
		$response->rows[$i]['nomeCarro']=$row['nomeCarro'];
		$response->rows[$i]['quant']=$row['quant'];
		$response->rows[$i]['precoAluguel']=$row['precoAluguel'];
		$response->rows[$i]['desconto']=$row['desconto'];
		$response->rows[$i]['total']=$row['total'];
		$i++;
			
	}
	
	echo json_encode($response);

?>