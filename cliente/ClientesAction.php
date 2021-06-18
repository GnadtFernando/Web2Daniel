<?php 
	include('../conexao.php');
	
	//Identifica a Ação a ser executada
	$acao = $_REQUEST[acao];

    //-- INSERIR --
	if ($acao == "inserir"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $idCliente= $_REQUEST[idCliente];
	   $nomeCliente = $_REQUEST[nomeCliente];
	   $cpf = $_REQUEST[cpf];
	   $telefone = $_REQUEST[telefone];
	
   	   //VALIDAÇÃO DE DADOS
	   if ($nomeCliente == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Nome do Cliente obrigat&oacuterio!</b></font>' ));
		  exit;
		}
		
		if ($cpf == ''){
			echo json_encode(array( 'retorno' => '<font color=red><b>cpf obrigat&oacuterio!</b></font>' ));
			exit;
		  }
		
		if ($telefone == ''){
			echo json_encode(array( 'retorno' => '<font color=red><b>telefone obrigat&oacuterio!</b></font>' ));
			exit;
		  }
	
	   //MONTAGEM DO COMANDO SQL 	
  	   $sql = "insert into cliente(nomeCliente,cpf,telefone)
               values('$nomeCliente', '$cpf', '$telefone')";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Cadastro com sucesso!</font>'));
	}
	
	//-- EDITAR --
	if ($acao == "editar"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $nomeCliente = $_REQUEST[nomeCliente];
	   $cpf = $_REQUEST[cpf];
	   $telefone = $_REQUEST[telefone];
	   
   	   //VALIDAÇÃO DE DADOS
	   if ($nomeCliente == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Nome do motorista obrigat&oacuterio!</b></font>' ));
		  exit;
		}
		
		if ($cpf == ''){
			echo json_encode(array( 'retorno' => '<font color=red><b>CPF obrigat&oacuterio!</b></font>' ));
			exit;
		  }

		if ($telefone == ''){
			echo json_encode(array( 'retorno' => '<font color=red><b>telefone obrigat&oacuterio!</b></font>' ));
			exit;
		}
	
	   //MONTAGEM DO COMANDO SQL 	
		 $sql = "update cliente
						  set nomeCliente = '$nomeCliente',
						  cpf = '$cpf',
						  telefone = '$telefone'

	           where idCliente = $idCliente";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Altera&ccedil;&atilde;o com sucesso!</font>'));
	}
	
	//-- EXCLUIR --
	if ($acao == "excluir"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $idCliente = $_REQUEST[idCliente];
	   
	
	   //MONTAGEM DO COMANDO SQL 	
  	   $sql = "delete from cliente where idCliente = $idCliente";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Motorista exclu&iacute;do com sucesso!</font>'));
	}
?>


