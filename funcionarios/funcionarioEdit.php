<?php
	include('../conexao.php');
		
	//Captura do "id"	
	$idFuncionario = $_REQUEST[id];
	
	//Pesquisar a Marca referente ao "id" passado pela JqGrid
	$rs = mysql_query("select * from funcionario where idFuncionario=$idFuncionario");
	$reg = mysql_fetch_object($rs);
?>
<html>
<head>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>
	<script>
		function editaFuncionario(){
		$.ajax({
			type:"POST",
			url:"funcionariosAction.php",
			dataType:"json",
			data:{acao:'editar',
			      idFuncionario:$("#idFuncionario").val(),
				  nomeFuncionario:$("#txtNomeFuncionario").val(),
				  comissao:$("#txtComissao").val()},
			success: function(data, textStatus, request){
				$("#retorno").html(data['retorno']);
			}	
		  });
	    }
		
		function limpaDados(){
			$("#nomeFuncionario").val("");
			$("#retorno").html("");
			$("#nomeFuncionario").focus();
	    }
	</script>
	
</head>
<body>
	<form>
		<input hidden type="text" name="idFuncionario" id="idFuncionario" value="<?=$idFuncionario?>">
		<table>
			<tr><td>Nome do funcion&aacuterio<td>
				<td><input type='text' name='txtNomeFuncionario' id='txtNomeFuncionario'
						   value='<?=$reg->nomeFuncionario?>'></td>
			</tr>
			<tr><td>Comiss&atildeo<td>
				<td><input type='text' name='txtComissao' id='txtComissao'
						   value='<?=$reg->comissao?>'></td>
			</tr>

			<tr><td><input type="button" name="btnSalvar" id="btnSalvar" 
			               value="Salvar" onClick="editaFuncionario()"></td>
						   
				<td><input type="button" value="Limpar" id="btnLimpar" 
				           onClick="limpaDados()"></td>
			</tr>	
 		</table>
		<div name="retorno" id="retorno"></div>
	</form>
</body>
</html>