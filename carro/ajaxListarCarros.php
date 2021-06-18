<?php

	include('../conexao.php');
	
	$page  = $_GET['page']; 
	$limit = $_GET['rows']; 
	$sidx  = $_GET['sidx']; 
	$sord  = $_GET['sord']; 		
	
	
	$where = " WHERE 1 = 1 ";
	
	if( $_GET['txtNomeCarro'] != "" ){	 	
		$where .= " AND nomeCarro like '%".$_GET['txtNomeCarro']."%' ";		
	}
	
	$queryCount = "SELECT COUNT(idCarro) as count
			  	   FROM carro
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
	$start = $limit*$page - $limit;
	            
    $query = "SELECT idCarro,
					 nomeCarro,
					 nomeMarca,
					 preco,
					 garagem
			  FROM carro INNER JOIN marca ON carro.idMarca = marca.idMarca
			  $where
			  ORDER BY $sidx $sord 
			  LIMIT $start , $limit";				 
					
    $resultSet = mysql_query($query);
	
	$response->page = $page;
	$response->total = $total_pages;
	$response->records = $count;
	$i=0;
	
	while ( $row = mysql_fetch_array($resultSet) ){
						
			$response->rows[$i]['idCarro']=$row['idCarro'];
			$response->rows[$i]['nomeCarro']=$row['nomeCarro'];
			$response->rows[$i]['nomeMarca']=$row['nomeMarca'];
			$response->rows[$i]['preco']=$row['preco'];
			$response->rows[$i]['garagem']=$row['garagem'];
			
			$i++;
				
	}

	echo json_encode($response);

?>