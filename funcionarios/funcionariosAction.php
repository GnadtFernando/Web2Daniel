<?php 
	include('../conexao.php');
	
	//Identifica a Ação a ser executada
	$acao = $_REQUEST[acao];

    //-- INSERIR --
	if ($acao == "inserir"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $idFuncionario= $_REQUEST[idFuncionario];
	   $nomeFuncionario = $_REQUEST[nomeFuncionario];
	   $comissao = $_REQUEST[comissao];
	
   	   //VALIDAÇÃO DE DADOS
	   if ($nomeFuncionario == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Nome do funcion&aacuterio obrigat&oacuterio!</b></font>' ));
		  exit;
		}
		
		if ($comissao == ''){
			echo json_encode(array( 'retorno' => '<font color=red><b>Comiss&atildeo obrigat&oacuterio!</b></font>' ));
			exit;
		  }
	
	   //MONTAGEM DO COMANDO SQL 	
  	   $sql = "insert into funcionario(nomeFuncionario,comissao)
               values('$nomeFuncionario', '$comissao')";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Cadastro com sucesso!</font>'));
	}
	
	//-- EDITAR --
	if ($acao == "editar"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $nomeFuncionario= $_REQUEST[nomeFuncionario];
	   $comissao = $_REQUEST[comissao];
	   
	
   	   //VALIDAÇÃO DE DADOS
	   if ($nomeFuncionario == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Nome do funcion&aacuterio obrigat&oacuterio!</b></font>' ));
		  exit;
		}
		
		if ($comissao == ''){
			echo json_encode(array( 'retorno' => '<font color=red><b>Comiss&atildeo obrigat&oacuterio!</b></font>' ));
			exit;
		  }
	
	   //MONTAGEM DO COMANDO SQL 	
		 $sql = "update funcionario
						  set nomeFuncionario = '$nomeFuncionario',
						  comissao = '$comissao'
	           where idFuncionario = $idFuncionario";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Altera&ccedil;&atilde;o com sucesso!</font>'));
	}
	
	//-- EXCLUIR --
	if ($acao == "excluir"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $idFuncionario = $_REQUEST[idFuncionario];
	   
	
	   //MONTAGEM DO COMANDO SQL 	
  	   $sql = "delete from funcionario where idFuncionario = $idFuncionario";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>funcion&aacuterio exclu&iacute;do com sucesso!</font>'));
	}
?>


