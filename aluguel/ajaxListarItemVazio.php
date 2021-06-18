<?php

	$response->page = 1;
	$response->total = 1;
	$response->records = 0;
					
	$response->rows[$i]['idCarroAlugado']=$row['idCarroAlugado'];
	$response->rows[$i]['nomeCarro']=$row['nomeCarro'];
	$response->rows[$i]['quant']=$row['quant'];
	$response->rows[$i]['precoAluguel']=$row['precoAluguel'];
	$response->rows[$i]['desconto']=$row['desconto'];
	$response->rows[$i]['total']=$row['total'];
	
	echo json_encode($response);

?>