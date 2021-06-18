<?php
	include('../conexao.php');
		
	//Captura do "id"	
	$idMarca = $_REQUEST[id];
	
	//Pesquisar a Marca referente ao "id" passado pela JqGrid
	$rs = mysql_query("select * from marca where idMarca=$idMarca");
	$reg = mysql_fetch_object($rs);
?>
<html>
<head>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>
	<script>
		function editaMarca(){
		$.ajax({
			type:"POST",
			url:"marcaAction.php",
			dataType:"json",
			data:{acao:'editar',
			      idMarca:$("#idMarca").val(),
				  nomeMarca:$("#txtNomeMarca").val()},
			success: function(data, textStatus, request){
				$("#retorno").html(data['retorno']);
			}	
		  });
	    }
		
		function limpaDados(){
			$("#txtNomeMarca").val("");
			$("#retorno").html("");
			$("#txtNomeMarca").focus();
	    }
	</script>
	
</head>
<body>
	<form>
		<input hidden type="text" name="idMarca" id="idMarca" value="<?=$idMarca?>">
		<table>
			<tr><td>Nome da Marca<td>
				<td><input type='text' name='txtNomeMarca' id='txtNomeMarca'
						   value='<?=$reg->nomeMarca?>'></td>
			</tr>
			<tr><td><input type="button" name="btnSalvar" id="btnSalvar" 
			               value="Salvar" onClick="editaMarca()"></td>
						   
				<td><input type="button" value="Limpar" id="btnLimpar" 
				           onClick="limpaDados()"></td>
			</tr>	
 		</table>
		<div name="retorno" id="retorno"></div>
	</form>
</body>
</html>