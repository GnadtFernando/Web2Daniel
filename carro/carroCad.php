<?php
    //Recordset para armazenar as categorias existentes
	include('../conexao.php');
	$sql = "select -1 idMarca,
	               '--Escolha a marca--' nomeMarca
            union all
            select idMarca, nomeMarca from marca";
	
	$rs = mysql_query($sql);
	
?>
<html>
<head>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>
	<script>
		function adicionaCarro(){
			$.ajax({
				type:"POST",
				url:"carroAction.php",
				dataType:"json",
				data:{acao:'inserir',
				  	  nomeCarro:$("#txtNomeCarro").val(),
					  idMarca:$("#cboIdMarca").val(),
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
				$("#cboIdMarca").val('-1');
				$("#txtPreco").val('');
				$("#txtGaragem").val('');
				$("#txtNomeCarro").focus();
		}	
	
	</script>
	
</head>
<body>
	<center><h3>Cadastro de Carros</h3></center>
	<hr>
	
	<form>
		<center>
		<table>
			<tr><td>Nome do carro</td>
				<td><input type='text' name='txtNomeCarro' id='txtNomeCarro'></td>
				
			<tr><td>Marca</td>
				<td><select id="cboIdMarca">
					<?
						while ($reg = mysql_fetch_object($rs)){
							echo "<option value=".$reg->idMarca.">".
							                      $reg->nomeMarca."</option>";
						}
					?>
				    </select></td>
				
			<tr><td>Pre&ccedil;o Unit&aacute;rio</td>
				<td><input type='text' name='txtPreco' id='txtPreco'></td>
				
			<tr><td>Unidades na Garagem</td>
				<td><input type='text' name='txtGaragem' id='txtGaragem'></td>
				
			<tr><td><input type="button" name="btnSalvar" id="btnSalvar" 
			               value="Salvar" onClick="adicionaCarro()"></td>
						   
				<td><input type="button" name="btnLimpar" id="btnLimpar"
						   value="Limpar" onClick="limpaForm()"></td>
			</tr>	
		</table>
		<div name="retorno" id="retorno"></div>
	</form>
</body>
</html>