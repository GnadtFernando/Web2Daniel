<html>
<head>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>
	<script>
		function adicionaCliente(){
			$.ajax({
				type:"POST",
				url:"clientesAction.php",
				dataType:"json",
				data:{acao:'inserir',
				  	  nomeCliente:$("#txtNomeCliente").val(),
					  cpf:$("#txtCpf").val(),
					  telefone:$("#txtTelefone").val()},
				success: function(data, textStatus, request){
					$("#retorno").html(data['retorno']);
				}	
			});
		}
	
		function limpaForm(){
				$("#retorno").html('');
				$("#txtNomeCliente").val('');
				$("#txtNomeCliente").focus();
		}	
	
	</script>
	
</head>
<body>
	<center><h3>Cadastro do Motorista</h3></center>
	<hr>
	
	<form>
		<center>
		<table>
			<tr><td>Nome do Motorista</td>
				<td><input type='text' name='txtNomeCliente' id='txtNomeCliente'></td>

			<tr><td>CPF</td>
				<td><input type='text' name='txtCpf' id='txtCpf'></td>
			
			<tr><td>Telefone</td>
				<td><input type='text' name='txtTelefone' id='txtTelefone'></td>

				
			<tr><td><input type="button" name="btnSalvar" id="btnSalvar" 
			               value="Salvar" onClick="adicionaCliente()"></td>
						   
				<td><input type="button" name="btnLimpar" id="btnLimpar"
						   value="Limpar" onClick="limpaForm()"></td>
			</tr>	
		</table>
		<div name="retorno" id="retorno"></div>
	</form>
</body>
</html>