<html>
<head>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>
	<script>
		function adicionaFuncionario(){
			$.ajax({
				type:"POST",
				url:"funcionariosAction.php",
				dataType:"json",
				data:{acao:'inserir',
				  	  nomeFuncionario:$("#txtNomeFuncionario").val(),
					  comissao:$("#txtComissao").val()},
				success: function(data, textStatus, request){
					$("#retorno").html(data['retorno']);
				}	
			});
		}
	
		function limpaForm(){
				$("#retorno").html('');
				$("#txtNomeFuncionario").val('');
				$("#txtNomeFuncionario").focus();
		}	
	
	</script>
	
</head>
<body>
	<center><h3>Cadastro do Funcion&aacuterio</h3></center>
	<hr>
	
	<form>
		<center>
		<table>
			<tr><td>Nome do Funcion&aacuterio</td>
				<td><input type='text' name='txtNomeFuncionario' id='txtNomeFuncionario'></td>

			<tr><td>Comissao</td>
				<td><input type='text' name='txtComissao' id='txtComissao'></td>
				
			<tr><td><input type="button" name="btnSalvar" id="btnSalvar" 
			               value="Salvar" onClick="adicionaFuncionario()"></td>
						   
				<td><input type="button" name="btnLimpar" id="btnLimpar"
						   value="Limpar" onClick="limpaForm()"></td>
			</tr>	
		</table>
		<div name="retorno" id="retorno"></div>
	</form>
</body>
</html>