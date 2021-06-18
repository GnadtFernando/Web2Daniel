<?php

	include_once('..\conexao.php');
	
	$page  = $_GET ['page']; 
	$limit = $_GET ['rows'];
	$sidx  = $_GET ['sidx']; 
	$sord  = $_GET ['sord'];
	
	date_default_timezone_set('America/Sao_Paulo');
	$inicioDoMes	= date("Y-m")."-01";
	$diaDataAtual	= date("Y-m-d");

	$dtInicio 	= isset($_GET['dtInicio']) ? dateEmMysql($_GET['dtInicio']) : $inicioDoMes;
	$dtFim 		= isset($_GET['dtFim']) ? dateEmMysql($_GET['dtFim']) : $diaDataAtual;
	
	$where = " where 
	      dataAluguel between concat('$dtInicio',' 00:00:00')
                        and concat('$dtFim',' 23:59:59') ";
	
	if( $_GET['txtNomeCliente'] != "" ){	 	
		$where .= " AND nomeCliente like '%".$_GET['txtNomeCliente']."%' ";		
	}

	if( $_GET['txtNomeFuncionario'] != "" ){	 	
		$where .= " AND nomeFuncionario like '%".$_GET['txtNomeFuncionario']."%' ";		
	}	
	//Quantidade de registros a serem paginados na grid
	$queryCount = "SELECT COUNT(idAluguel) as count
			  	   FROM aluguel 
						INNER JOIN cliente ON cliente.idCliente = aluguel.idCliente
						INNER JOIN funcionario ON funcionario.idFuncionario = aluguel.idFuncionario
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
	if($page == 0) $page = 1;
	$start = $limit*$page - $limit;
	
    $query = "SELECT idAluguel,
					 dataAluguel,
					 nomeCliente,
					 nomeFuncionario,
					(select SUM(precoAluguel*quant-desconto)
					 from carroalugado
					 where carroalugado.idCarroAlugado=aluguel.idAluguel) total
			  FROM 
				cliente INNER JOIN 
					(funcionario INNER JOIN aluguel
					ON funcionario.idFuncionario=aluguel.idFuncionario)
				ON cliente.idCliente=aluguel.idCliente
			  
			  $where
			  ORDER BY $sidx
			  LIMIT $start , $limit";
	
					
    $resultSet = mysql_query($query);
	
	$response->page = $page;
	$response->total = $total_pages;
	$response->records = $count;
	$i=0;
	
	while( $row = mysql_fetch_array($resultSet) ){
						
		$response->rows[$i]['idAluguel']=$row['idAluguel'];
		$response->rows[$i]['dataAluguel']=$row['dataAluguel'];
		$response->rows[$i]['nomeCliente']=$row['nomeCliente'];
		$response->rows[$i]['nomeFuncionario']=$row['nomeFuncionario'];
		$response->rows[$i]['total']=$row['total'];
		$i++;
			
	}
	
	echo json_encode($response);

?>