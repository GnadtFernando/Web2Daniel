<?php

	include('../conexao.php');
	
	$page  = $_GET['page']; 
	$limit = $_GET['rows']; 
	$sidx  = $_GET['sidx']; 
	$sord  = $_GET['sord']; 		
	
	
	$where = " WHERE 1 = 1 ";
	
	if( $_GET['txtNomeFuncionario'] != "" ){	 	
		$where .= " AND NomeFuncionario like '%".$_GET['txtNomeFuncionario']."%' ";		
	}
	
	$queryCount = "SELECT COUNT(idFuncionario) as count
			  	   FROM funcionario 
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
	            
    $query = "SELECT idFuncionario,
					 nomeFuncionario,
					 comissao
					
			  FROM funcionario
			  $where
			  ORDER BY $sidx $sord 
			  LIMIT $start , $limit";				 
					
    $resultSet = mysql_query($query);
	
	$response->page = $page;
	$response->total = $total_pages;
	$response->records = $count;
	$i=0;
	
	while ( $row = mysql_fetch_array($resultSet) ){
						
			$response->rows[$i]['idFuncionario']=$row['idFuncionario'];
			$response->rows[$i]['nomeFuncionario']=$row['nomeFuncionario'];
			$response->rows[$i]['comissao']=$row['comissao'];
			
			$i++;
				
	}

	echo json_encode($response);

?>