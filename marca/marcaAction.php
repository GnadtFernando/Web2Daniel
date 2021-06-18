<?php 
	include('../conexao.php');
	
	//Identifica a Ação a ser executada
	$acao = $_REQUEST[acao];

    //-- INSERIR --
	if ($acao == "inserir"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $nomeMarca = $_REQUEST[nomeMarca];
	
   	   //VALIDAÇÃO DE DADOS
	   if ($nomeMarca == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Nome da marca obrigat&oacuterio!</b></font>' ));
		  exit;
 	   }
	
	   //MONTAGEM DO COMANDO SQL 	
  	   $sql = "insert into marca(nomeMarca)
               values('$nomeMarca')";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Cadastro com sucesso!</font>'));
	}
	
	//-- EDITAR --
	if ($acao == "editar"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $idMarca = $_REQUEST[idMarca];
	   $nomeMarca = $_REQUEST[nomeMarca];
	
   	   //VALIDAÇÃO DE DADOS
	   if ($nomeMarca == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Nome da Marca obrigat&oacuterio!</b></font>' ));
		  exit;
 	   }
	
	   //MONTAGEM DO COMANDO SQL 	
  	   $sql = "update marca set nomeMarca = '$nomeMarca'
	           where idMarca = $idMarca";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Altera&ccedil;&atilde;o com sucesso!</font>'));
	}
	
	//-- EXCLUIR --
	if ($acao == "excluir"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $idMarca = $_REQUEST[idMarca];
	
	   //MONTAGEM DO COMANDO SQL 	
  	   $sql = "delete from marca where idMarca = $idMarca";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Marca exclu&iacute;da com sucesso!</font>'));
	}
?>


