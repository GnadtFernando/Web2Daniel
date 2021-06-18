<!DOCTYPE html>
<html lang="en">
<head>
<title>Aluguéis</title>
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
	jQuery("#aluguelGrid").jqGrid({
			url:'ajaxListarAluguel.php',
			datatype:'json',
            mtype:'GET',
            jsonReader:
				{'repeatitems':false},
            pager:'#aluguelPagerGrid',
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
            sortname:'dataAluguel',
            sortorder:'desc',
			caption: "Aluguel",
            colModel:[
                {label:'Cód.',width:60,align:'center',name:'idAluguel'},
				{label:'Data Aluguel',width:200,align:'center',name:'dataAluguel'},
				{label:'Nome do Motorista',width:300,align:'left',name:'nomeCliente'},
				{label:'Nome do Funcionário',width:200,align:'left',name:'nomeFuncionario'},
				{label:'Preço do Aluguel',width:200,align:'right',name:'total'}
            ] 
        });
	jQuery("#aluguelGrid").jqGrid('navGrid', '#aluguelPagerGrid', {del:false,add:false,edit:false,search:false,refresh:true} );
	
	//cadastro de Aluguel
	$("#btnCadastrar").click(function(){
		window.location = "aluguelCad.php";				   
	})

	
	$("#btnDeletar").click(function(){
	
		var linhaSelecionada = jQuery("#aluguelGrid").getGridParam('selrow');

		var id = jQuery("#aluguelGrid").getCell(linhaSelecionada,0);
		
		if(linhaSelecionada != null){
			
			if (confirm("Confirma a exclusão?") == true){
			
				$('#objetoQualquer').load('aluguelAction.php?acao=deletaAluguel&idAluguel='+id);

				jQuery("#aluguelGrid").jqGrid('setGridParam',{url:'ajaxListarAluguel.php',page:1}).trigger('reloadGrid');
				
				alert("Registro excluído com sucesso!");
			}	
		}else{
			alert("Selecione um Registro");
		}			   
	})
	
	jQuery("#btnPesquisar").click(function(){
		var txtCliente = $('#txtNomeCliente').val();	
		var txtFuncionario = $('#txtNomeFuncionario').val();	
		
		jQuery("#aluguelGrid").jqGrid('setGridParam',{url:'ajaxListarAluguel.php?txtNomeCliente='+txtCliente+'&txtNomeFuncionario='+txtFuncionario ,page:1}).trigger('reloadGrid');
		
	})
	
	jQuery("#btnLimpar").click(function(){	
		$('#txtNomeCarro').val('');			
		jQuery("#CarrosGrid").jqGrid('setGridParam',{url:'ajaxListarCarros.php' ,page:1}).trigger('reloadGrid');		
	})
});
</script>
</head>
<body>
<? 

?>
<div id="botoes" style="padding:4px 4px 4px 4px; color:#666; font-size:12px; font-weight:bold;">
    <input type="button" id="btnCadastrar" value="Cadastrar"/>
    <input type="button" id="btnDeletar" value="Deletar"/>
</div> 
<hr>
<div id="filtros">
  <table>
	<tr>
	  <td> Período: </td>
	  <td><input type="date" id="txtInicio"></td>
	  <td> até </td>
	  <td><input type="date" id="txtFim"></td>
	  <td> Motorista: </td>
	  <td><input type="text" id="txtNomeCliente"></td>
 	  <td> Funcionário: </td>
   	  <td><input type="text" id="txtNomeFuncionario"></td>
	  <td><input type="button" id="btnPesquisar" value="Pesquisar"/></td>  
      <td><input type="button" id="btnLimpar" value="Limpar"/></td>
	</tr>
  </table>
</div>
<hr>
<table id="aluguelGrid" ></table>
<div id="aluguelPagerGrid"></div>
<div id="objetoQualquer"></div>
</body>
</html>





