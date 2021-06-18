<html>
<head>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>
	<script>
		function adicionaMarca(){
			$.ajax({
				type:"POST",
				url:"marcaAction.php",
				dataType:"json",
				data:{acao:'inserir',
				  	  nomeMarca:$("#txtNomeMarca").val() },
				success: function(data, textStatus, request){
					$("#retorno").html(data['retorno']);
				}	
			});
		}
	
		function limpaForm(){
				$("#retorno").html('');
				$("#txtNomeMarca").val('');
				$("#txtNomeMarca").focus();
		}	
	
	</script>
	
</head>
<body>
	<center><h3>Cadastro da Marca</h3></center>
	<hr>
	
	<form>
		<center>
		<table>
			<tr><td>Nome da Marca</td>
				<td><input type='text' name='txtNomeMarca' id='txtNomeMarca'></td>
				
			<tr><td><input type="button" name="btnSalvar" id="btnSalvar" 
			               value="Salvar" onClick="adicionaMarca()"></td>
						   
				<td><input type="button" name="btnLimpar" id="btnLimpar"
						   value="Limpar" onClick="limpaForm()"></td>
			</tr>	
		</table>
		<div name="retorno" id="retorno"></div>
	</form>
</body>
</html>