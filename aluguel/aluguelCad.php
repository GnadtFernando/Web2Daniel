<!DOCTYE html>
<html lang="en">
<head>
<title>Cadastro de Alugueis</title>
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>  

<script type="text/javascript" src="../js/jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>

<link rel="stylesheet" href="../js/jquery-ui-1.8.17.custom/css/smoothness/jquery-ui-1.8.17.custom.css">

<script type="text/javascript" src="../js/jquery.form.js"></script>

<script src="../js/jquery.jqGrid-3.8.2/js/i18n/grid.locale-pt-br.js" type="text/javascript"></script>
<script src="../js/jquery.jqGrid-3.8.2/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<link href="../js/jquery.jqGrid-3.8.2/css/ui.jqgrid.css" rel="stylesheet" type="text/css"/>


<script>
$(function() {

	jQuery("#itemGrid").jqGrid({
			url:'ajaxListarItem.php',
			editurl:'modeloAction.php',
            datatype:'json',
            mtype:'GET',
            jsonReader:
				{'repeatitems':false},
            pager:'#itemPagerGrid',
            rowNum:10,
            rowList:
				[10,20,30,40,50,60,70,80,90,100],
            sortable:true,
            viewrecords:true,
            gridview:true,
            autowidth:true,
            height:370,
            shrinkToFit:true,
            forceFit:true,
            hidegrid:false,
            sortname:'nomeCarro',
            sortorder:'asc',
			caption: "Carro",
            colModel:[
                {label:'Cód.',width:60,align:'center',name:'idCarroAlugado'},
				{label:'Nome do Carro',width:200,align:'left',name:'nomeCarro'},
				{label:'Quant.',width:300,align:'right',name:'quant'},
				{label:'Preço Unit.',width:200,align:'right',name:'precoAluguel'},
				{label:'Desconto',width:200,align:'right',name:'desconto'},
				{label:'Total',width:200,align:'right',name:'total'}
            ] 
        });
		
	jQuery("#itemGrid").jqGrid('navGrid', '#itemPagerGrid', {del:false,add:false,edit:false,search:false,refresh:true} );
	
	jQuery("#btnAdicionar").click(async () => {
	
		//Captura os dados do fomulário
		var idAluguel = $("#idAluguel").val();
		var idCarro = $("#cboCarro").val();
		var quant = $("#txtQuant").val();
		var precoAluguel = $("#txtPrecoAluguel").val();
		var desconto = $("#txtDesconto").val();
		// Primeiro chama o gravaAluguel e depois o gravaItem... faz ai rapidinho kkk
		//Gravação do Item	
		await gravaItem(idAluguel,idCarro,quant,precoAluguel,desconto);
	
		//Limpa Item
		limpaItem();
		
		//Atualiza o display do Total
		atualizaTotal(idAluguel);
		
	})

	function atualizaTotal(idAluguel){ 
		$.ajax({
			type:"POST",
			url:"aluguelAction.php?acao=totalAluguel&idAluguel="+idAluguel,
			dataType:"json",
			data:{},
			success: function(data, textStatus, request){
				$("#Total").html(data['total']);	
			}	
		});
	}
	
	async function gravaItem(idAluguel,idCarro,quant,precoAluguel,desconto){
		await $.ajax({
			type:"POST",
			url:"aluguelAction.php?acao=gravaItem&idAluguel="+idAluguel+"&idCarro="+idCarro+"&quant="+quant+"&precoAluguel="+precoAluguel+"&desconto="+desconto,
			dataType:"json",
			data:{}
		}).done((msg) => {
			console.log(msg);
			var idAluguel = $('#idAluguel').val();	
			console.log(idAluguel);
			jQuery("#itemGrid").jqGrid('setGridParam',{url:'ajaxListarItem.php?idAluguel='+idAluguel ,page:1}).trigger('reloadGrid');
		});
	}

	function limpaItem(){
		$("#cboCarro").val(0);  
		$("#txtQuant").val(1);
		$("#txtPrecoAluguel").val(0);
		$("#txtDesconto").val(0);
		$("#txtTotal").val(0);
		$("#cboCarro").focus();
	}


	
	function deletaItem(idAluguel,idCarroAlugado){
		$.ajax({
			type:"POST",
			url:"aluguelAction.php?acao=deletaItem&idAluguel="+idAluguel+"&idCarroAlugado="+idCarroAlugado,
			dataType:"json",
			data:{},
			success: function(data, textStatus, request){
			    var retorno = data['retorno'];
				refreshGrid(retorno);
			}	
		});
	}
	
	function refreshGrid(retorno){
		if (retorno > 0){
			var idAluguel = $('#idAluguel').val();	
			jQuery("#itemGrid").jqGrid('setGridParam',{url:'ajaxListarItem.php?idAluguel='+idAluguel ,page:1}).trigger('reloadGrid');
		}else{
			jQuery("#itemGrid").jqGrid('setGridParam',{url:'ajaxListarItemVazio.php' ,page:1}).trigger('reloadGrid');
		}
	}	
	
		
	$("#btnRemover").click(function(){
	
		var linhaSelecionada = jQuery("#itemGrid").getGridParam('selrow');
		
		var idCarroAlugado = jQuery("#itemGrid").getCell(linhaSelecionada,0);
		
		var idAluguel = $("#idAluguel").val();
		
		if(linhaSelecionada != null){
			
			if (confirm("Confirma a exclusão?") == true){
			
				deletaItem(idAluguel,idCarroAlugado);
				
				atualizaTotal(idAluguel);
			}
			
		}else{
			alert("Selecione um Registro");
		}			   
	})
	
	
	jQuery("#btnPesquisar").click(function(){
		var txtNome = $('#txtNomeCliente').val();	
		
		jQuery("#alugueisGrid").jqGrid('setGridParam',{url:'ajaxListarAluguel.php?txtNomeCliente='+txtNome ,page:1}).trigger('reloadGrid');
		
	})
	
	jQuery('#cboCarro').change(function(){
		//Captura o ID no combo
		var id = $('#cboCarro').val();
		//Chama a função que irá retornar o Preço do produto
		buscaPreco(id);
	})
	
	function buscaPreco(idCarro){
		$.ajax({
			type:"GET",
			url:"aluguelAction.php?acao=buscarPreco&idCarro="+idCarro, 
			dataType:"json",
			data:{},
			success: function(data, textStatus, request){
				$("#txtPrecoAluguel").val(data['preco']);	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
	
	function CalcTotal(){
		quant = $("#txtQuant").val();
		preco = $("#txtPrecoAluguel").val();
		desconto = $("#txtDesconto").val();
		
		total = quant * preco - desconto;
		
		$("#txtTotal").val(total);
	}
	
	jQuery("#txtQuant").blur(function(){
		CalcTotal();
	})
	
	jQuery("#txtDesconto").blur(function(){
		CalcTotal();
	})
	
	jQuery("#btnLimpar").click(function(){	
		$('#txtNomeCarro').val('');			
		jQuery("#carrosGrid").jqGrid('setGridParam',{url:'ajaxListarCarros.php' ,page:1}).trigger('reloadGrid');		
	})
	
	jQuery("#btnSalvar").click(function(){
		//Captura do idCliente e idVendedor selecionados nos combos
		var idCliente = $("#cboCliente").val();
		var idFuncionario = $("#cboFuncionario").val();
		//Validação de dados
		if (idCliente == '0'){
			alert("Cliente não foi selecionado");
			$("#cboCliente").focus();
			exit;
		}
		if (idFuncionario == '0'){
			alert("Funcionario não foi selecionado");
			$("#cboFuncionario").focus();
			exit;
		}
		//Gravação da aluguel
		GravaAluguel(idCliente,idFuncionario);
			
		//Desabilitar o botão btnSalvar
		$("#btnSalvar").attr("disabled","disabled");
		
		//Habilitar o botão btnCancelar
		$("#btnCancelar").removeAttr("disabled");

		//Colocar o foco no cboCarro
		$("#cboCarro").focus();
		
	})
	
	function GravaAluguel(idCliente,idFuncionario){
		$.ajax({
			type:"POST",
			url:"aluguelAction.php?acao=gravaAluguel&idCliente="+idCliente+"&idFuncionario="+idFuncionario,
			dataType:"json",
			data:{},
			success: function(data, textStatus, request){
				$("#idAluguel").val(data['idAluguel']);	
			}	
		});
	}
	
	$("#btnCancelar").click(function(){
		if(confirm("Confirma cancelamento deste aluguel?")){
			$.ajax({
				type:"POST",
				url:"aluguelAction.php?acao=deletaAluguel&idAluguel="+$("#idAluguel").val(),
				dataType:"json",
				data:{},
				success: function(data, textStatus, request){
						refreshAluguel(data['retorno']);
				}	
			}); //Fim do Ajax
		} //Fim do If
	})//Fim do evento click

	function refreshAluguel(retorno){
		if (retorno == 1){
			alert("Aluguel cancelado com sucesso!");
			limpaItem();
			refreshGrid();
			$("#cboCliente").val(0);
			$("#cboFuncionario").val(0);
			$("#cboCliente").focus();
			$("#btnSalvar").removeAttr("disabled");
			$("#btnCancelar").attr("disabled","disabled");
			$("#Total").html("");
		}else{
			alert("Não foi possível cancelar este aluguel!");
		}
	}
	
});
</script>

<?php
include_once("../conexao.php");
?>

</head>
<body>
<table id="aluguel">
	<tr><td><input type="hidden" id="idAluguel"></td></tr>
	
	<tr><td>Nome do Motorista</td>
		<td>Nome do Funcionário</td>
		<td><input type="button" id="btnSalvar" value="Salvar"></td>
		<td><div id="Total"></td>
	</tr>
	
	<tr><td><select id="cboCliente">
				<option value="0"><-Selecione o cliente-></option>
				<?
					$sql="select idCliente,nomeCliente 
					      from cliente
						  order by nomeCliente";
					$rs=mysql_query($sql);
					while ($reg = mysql_fetch_object($rs)){
						echo "<option value=".$reg->idCliente.">".
						                      $reg->nomeCliente."</option>";
					}
				?>
			</select></td>
		<td><select id="cboFuncionario">
				<option value="0"><-Selecione o Funcionário-></option>
				<?
					$sql="select idFuncionario,nomeFuncionario
					      from funcionario
						  order by nomeFuncionario";
					$rs=mysql_query($sql);
					while ($reg = mysql_fetch_object($rs)){
						echo "<option value=".$reg->idFuncionario.">".
						                      $reg->nomeFuncionario."</option>";
					}
				?>
			</select></td>
		<td><input type="button" id="btnCancelar" value="Cancelar" disabled></td>
	</tr>	
</table>

<hr>

<table id="CarroAlugado" border="1">
	<tr><td>Nome do Carro</td>
		<td>Quant.</td>
		<td>Preço Aluguel</td>
		<td>Desconto</td>
		<td>Total</td>
	</tr>
	<tr><td><select id="cboCarro">
				<option value="0"><-Selecione o carro-></option>
				<?
					$sql="select idCarro,nomeCarro
					      from carro
						  order by nomeCarro";
					$rs=mysql_query($sql);
					while ($reg = mysql_fetch_object($rs)){
						echo "<option value=".$reg->idCarro.">".
						                      $reg->nomeCarro."</option>";
					}
				?>
			</select></td>
		<td><input type="text" id="txtQuant" value="1">
		<td><input type="text" id="txtPrecoAluguel" value="0.00">
		<td><input type="text" id="txtDesconto" value="0.00">
		<td><input type="text" id="txtTotal" value="0.00">
		
		<td><input type="button" id="btnAdicionar" value="+">
		<td><input type="button" id="btnRemover" value="-">
	</tr>	
</table>

<hr>

<table id="itemGrid" ></table>
<div id="itemPagerGrid"></div>
<div id="objetoQualquer"></div>
</body>
</html>





