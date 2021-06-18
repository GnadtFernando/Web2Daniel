<?
	include("..\conexao.php");
	
	//Captura do par�metro de a��o
	$acao = $_REQUEST['acao'];
	
	//Action para gravar o aluguel
	if ($acao == 'gravaAluguel'){
		$idCliente = $_REQUEST['idCliente'];
		$idFuncionario = $_REQUEST['idFuncionario'];
		$sql="insert into aluguel(idCliente,idFuncionario,dataAluguel)
			  values('$idCliente','$idFuncionario',now())";
		mysql_query($sql) or die(mysql_errno($conexao)); 
		echo json_encode(array('idAluguel'=>mysql_insert_id()));	
	}

	
	//Action para idCarro retornar o pre�o de aluguel
	if ($acao == 'buscarPreco'){ 	
		$idCarro = $_REQUEST['idCarro'];
		$sql = "select preco from carro
		        where idCarro = $idCarro";
		$rs = mysql_query($sql);
		$reg = mysql_fetch_array($rs);
		echo json_encode(array( 'preco'=>$reg['preco'] ));
	}
	
	//Action para gravar o carro alugado
	if ($acao == 'gravaItem'){
		$idAluguel = $_REQUEST['idAluguel'];
		$idCarro = $_REQUEST['idCarro'];
		$quant = $_REQUEST['quant'];
		$precoAluguel = $_REQUEST['precoAluguel'];
		$desconto = $_REQUEST['desconto'];
		$sql="insert into carroalugado(idAluguel,idCarro,quant,precoAluguel,desconto)
		      values($idAluguel,$idCarro,$quant,$precoAluguel,$desconto)";
		mysql_query($sql) or die(mysql_errno($conexao)); 
		echo json_encode(array('idCarroAlugado'=>mysql_insert_id()));	
	}
	
	//Action para calcular o total da Venda
	if ($acao == 'totalAluguel'){ 	
		$idAluguel = $_REQUEST['idAluguel'];
		$sql = "select sum(quant*precoAluguel-desconto) total 
		        from carroalugado where idAluguel=$idAluguel";
		$rs = mysql_query($sql);
		$reg = mysql_fetch_array($rs);
		echo json_encode(array( 'total' => '<font color=red><b>' . $reg['total'] . '</b></font>'));
	}
	
	//Action para deletar o carro alugado
	if ($acao == 'deletaItem'){
		
		$idItemAluguel = $_REQUEST['idCarroAlugado'];
		$idAluguel = $_REQUEST['idAluguel'];
		
		$sql="delete from carroAlugado where idCarroAlugado = $idCarroAlugado";
		mysql_query($sql,$conexao);	  

		$queryCount = "SELECT COUNT(idCarroAlugado) as count
						FROM carroAlugado
						WHERE idAluguel = $idAluguel";
				 
		$resultSetCount = mysql_query($queryCount);			 
				 
		$rowCount = mysql_fetch_array($resultSetCount);
		$count = $rowCount['count'];
		
		echo json_encode(array('retorno'=>$count));	
	}
	
	//Action para deletar o aluguel completo
	if ($acao == 'deletaAluguel'){
		
		$idAluguel = $_REQUEST['idAluguel'];
			
		$sql="delete from carroalugado where idCarroAlugado = $idCarroAlugado";
		mysql_query($sql);		  

		$sql="delete from aluguel where idAluguel = $idAluguel";
		mysql_query($sql);	  

		$retorno = 1;	
		echo json_encode(array('retorno'=>$retorno));	
	}
	
?>