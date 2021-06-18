<?php 
	include('../conexao.php');
	
	//Identifica a Ação a ser executada
	$acao = $_REQUEST[acao];

    //-- INSERIR --
	if ($acao == "inserir"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $nomeCarro = $_REQUEST[nomeCarro];
	   $idMarca = $_REQUEST[idMarca];
	   $preco       = $_REQUEST[preco];
	   $garagem     = $_REQUEST[garagem];
	
   	   //VALIDAÇÃO DE DADOS
	   if ($nomeCarro == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Nome do carro obrigat&oacuterio!</b></font>' ));
		  exit;
 	   }
	
	   if ($idMarca == '-1'){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Marca obrigat&oacuteria!</b></font>' ));
		  exit;
 	   }

	   if ($preco == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Pre&ccedil;o obrigat&oacuterio!</b></font>' ));
		  exit;
 	   }

	   if ($garagem == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Quantidade na garagem obrigat&oacuterio!</b></font>' ));
		  exit;
 	   }

	   //MONTAGEM DO COMANDO SQL 	
  	   $sql = "insert into carro(nomeCarro, idMarca, preco, garagem)
               values('$nomeCarro', $idMarca, $preco, $garagem)";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Cadastro com sucesso!</font>'));
	}
	
	//-- EDITAR --
	if ($acao == "editar"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $idCarro  	= $_REQUEST[idCarro];
	   $nomeCarro 	= $_REQUEST[nomeCarro];
	   $idMarca 	= $_REQUEST[idMarca];
	   $preco       = $_REQUEST[preco];
	   $garagem     = $_REQUEST[garagem];
	
   	   //VALIDAÇÃO DE DADOS
	   if ($nomeCarro == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Nome do carro obrigat&oacuterio!</b></font>' ));
		  exit;
 	   }
	
	   if ($idMarca == '-1'){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Marca obrigat&oacuteria!</b></font>' ));
		  exit;
 	   }

	   if ($preco == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Pre&ccedil;o obrigat&oacuterio!</b></font>' ));
		  exit;
 	   }

	   if ($garagem == ''){
	      echo json_encode(array( 'retorno' => '<font color=red><b>Quantidade na garagem obrigat&oacuterio!</b></font>' ));
		  exit;
 	   }
	
	   //MONTAGEM DO COMANDO SQL 	
  	   $sql = "update carro set nomeCarro = '$nomeCarro',
	                              idMarca = $idMarca,
								  preco       = $preco,
	                              garagem     = $garagem 
	           where idCarro = $idCarro";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Altera&ccedil;&atilde;o com sucesso!</font>'));
	}
	
	//-- EXCLUIR --
	if ($acao == "excluir"){
	   //CAPTURA OS DADOS DO FORMULÁRIO
	   $idCarro = $_REQUEST[idCarro];
	
	   //MONTAGEM DO COMANDO SQL 	
  	   $sql = "delete from carro where idCarro = $idCarro";

   	   mysql_query($sql) or die();
       echo json_encode(array( 'retorno' => '<font color=blue>Carro exclu&iacute;da com sucesso!</font>'));
	}
?>


