<?php
	include('../conexao.php');
		
	//Captura do "id"	
	$idCliente = $_REQUEST[id];
	
	//Pesquisar a Marca referente ao "id" passado pela JqGrid
	$rs = mysql_query("select * from cliente where idCliente=$idCliente");
	$reg = mysql_fetch_object($rs);
?>
<html>
<head>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>
	<script>
		function editaCliente(){
		$.ajax({
			type:"POST",
			url:"ClientesAction.php",
			dataType:"json",
			data:{acao:'editar',
			      idCliente:$("#idCliente").val(),
				  nomeCliente:$("#txtNomeCliente").val(),
				  cpf:$("#txtCpf").val(),
				  telefone:$("#txtTelefone").val()},
			success: function(data, textStatus, request){
				$("#retorno").html(data['retorno']);
			}	
		  });
	    }
		
		function limpaDados(){
			$("#nomeCliente").val("");
			$("#retorno").html("");
			$("#nomeCliente").focus();
	    }
	</script>
	
</head>
<body>
	<form>
		<input hidden type="text" name="idCliente" id="idCliente" value="<?=$idCliente?>">
		<table>
			<tr><td>Nome do Motorista<td>
				<td><input type='text' name='txtNomeCliente' id='txtNomeCliente'
						   value='<?=$reg->nomeCliente?>'></td>
			</tr>
			<tr><td>CPF<td>
				<td><input type='text' name='txtCpf' id='txtCpf'
						   value='<?=$reg->cpf?>'></td>
			
			<tr><td>Telefone<td>
				<td><input type='text' name='txtTelefone' id='txtTelefone'
						   value='<?=$reg->telefone?>'></td>

			</tr>

			<tr><td><input type="button" name="btnSalvar" id="btnSalvar" 
			               value="Salvar" onClick="editaCliente()"></td>
						   
				<td><input type="button" value="Limpar" id="btnLimpar" 
				           onClick="limpaDados()"></td>
			</tr>	
 		</table>
		<div name="retorno" id="retorno"></div>
	</form>
</body>
</html>