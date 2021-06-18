<?php
	include('../conexao.php');
		
	//Captura do "id"	
	$idCarro = $_REQUEST[id];
	
	//Pesquisar o Produto referente ao "id" passado pela JqGrid
	$rs = mysql_query("select * from carro where idCarro=$idCarro");
	$reg = mysql_fetch_object($rs);
	
	//Recordset para armazenar as categorias existentes
	$sql = "select -1 idMarca,
	               '--Escolha a Marca--' nomeMarca
            union
            select idMarca, nomeMarca from marca";
	
	$rsCat = mysql_query($sql);
?>

<html>
<head>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>
	<script>
		function editaCarro(){
		$.ajax({
			type:"POST",
			url:"carroAction.php",
			dataType:"json",
			data:{acao:'editar',
			      idCarro:$("#idCarro").val(),
			      nomeCarro:$("#txtNomeCarro").val(),
				  idMarca:$("#cboMarca").val(),
				  preco:$("#txtPreco").val(),
			  	  garagem:$("#txtGaragem").val()
				  },
			success: function(data, textStatus, request){
				$("#retorno").html(data['retorno']);
			}	
		  });
	    }
		
		function limpaForm(){
				$("#retorno").html('');
				$("#txtNomeCarro").val('');
				$("#cboMarca").val('-1');
				$("#txtPreco").val('');
				$("#txtGaragem").val('');
				$("#txtNomeCarro").focus();
		}	
	</script>
	
</head>
<body>
	<center><h3>Altera&ccedil;&atilde;o de nome do Carro</h3></center>
	<hr>
	<form>
		<center>
		<input hidden type="text" name="idCarro" id="idCarro" value="<?=$idCarro?>">
		<table>
			<tr><td>Nome do Carro</td>
				<td><input type='text' name='txtNomeCarro' id='txtNomeCarro'
						   value='<?=$reg->nomeCarro?>'></td>
			</tr>
			
			<tr><td>Marca</td>
				<td>
					<select name='cboMarca' id='cboMarca'>
					    <!-- <option value=-1>--Escolha a Marca--</option> -->
					<?
						while ($regCat = mysql_fetch_object($rsCat)){
						    $selecionado = ($regCat->idMarca == $reg->idMarca)?"selected":"";
							
							echo "<option value=".$regCat->idMarca." $selecionado>".
							                      $regCat->nomeMarca."</option>";
						}
					?>
					</select>
				</td>
			</tr>	
			
			<tr><td>Preço</td>
				<td><input type='text' name='txtPreco' id='txtPreco' value='<?=$reg->preco?>'></td>
			</tr>
			
			<tr><td>Garagem</td>
				<td><input type='text' name='txtGaragem' id='txtGaragem' value='<?=$reg->garagem?>'></td>
			</tr>	
			
			<tr><td><input type="button" name="btnSalvar" id="btnSalvar" 
			               value="Salvar" onClick="editaProduto()"></td>
						   
				<td><input type="button" value="Limpar" id="btnLimpar" 
				           onClick="limpaForm()"></td>
			</tr>	
 		</table>
		<div name="retorno" id="retorno"></div>
		</center>
	</form>
</body>
</html>