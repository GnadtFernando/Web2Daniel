<!DOCTYPE html>
<html lang="en">
<head>
<title>Motoristas</title>
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>  

<script type="text/javascript" src="../js/jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>

<link rel="stylesheet" href="../js/jquery-ui-1.8.17.custom/css/smoothness/jquery-ui-1.8.17.custom.css">
<script src="../js/jquery-ui-1.8.17.custom/development-bundle/ui/jquery.ui.core.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.8.17.custom/development-bundle/ui/jquery.ui.widget.js" type="text/javascript"></script> 
<script src="../js/jquery-ui-1.8.17.custom/development-bundle/ui/jquery.ui.button.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.8.17.custom/development-bundle/ui/jquery.ui.datepicker.js" type="text/javascript"></script> 

<script type="text/javascript" src="../js/jquery.form.js"></script>

<script src="../js/jquery.jqGrid-3.8.2/js/i18n/grid.locale-pt-br.js" type="text/javascript"></script>
<script src="../js/jquery.jqGrid-3.8.2/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<link href="../js/jquery.jqGrid-3.8.2/css/ui.jqgrid.css" rel="stylesheet" type="text/css"/>


<script>
$(function() {
	jQuery("#clientesGrid").jqGrid({
			url:'ajaxListarCliente.php',
			editurl:'clientesAction.php',
            datatype:'json',
            mtype:'GET',
            jsonReader:
				{'repeatitems':false},
            pager:'#clientesPagerGrid',
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
            sortname:'nomeCliente',
            sortorder:'asc',
			caption: "Clientes",
            colModel:[
                {label:'ID',width:60,align:'center',name:'idCliente'},
				{label:'Nome do Motorista',width:200,align:'center',name:'nomeCliente'},
				{label:'CPF',width:80,align:'center',name:'cpf'},
				{label:'TEL',width:80,align:'center',name:'telefone'}
            ] 
        });
	jQuery("#funcionariosGrid").jqGrid('navGrid', '#funcionariosPagerGrid', {del:false,add:false,edit:false,search:false,refresh:true} );
	
	//cadastro de func
	$("#btnCadastrar").click(function(){
		window.location = "clienteCad.php";				   
	})
	
	//edi????o de func
	$("#btnEditar").click(function(){
	    //Captura a linha selecionada na Grid
		var linhaSelecionada = jQuery("#clientesGrid").getGridParam('selrow');
			
		if(linhaSelecionada != null){
		    //Captura o ID na linha selecionada (c??lula da coluna 0 - zero)
		    var id = jQuery("#clientesGrid").getCell(linhaSelecionada,0);
			window.location = "clienteEdit.php?id="+id;				
		}else{
		    alert("Selecione um registro");
		}	   
	})
	
	//exclus??o de categoria
	$("#btnDeletar").click(function(){
	    //Captura a linha selecionada na Grid
		var linhaSelecionada = jQuery("#clientesGrid").getGridParam('selrow');

		if(linhaSelecionada != null){
		
			//Captura o ID na linha selecionada (c??lula da coluna 0 - zero)
		    var id = jQuery("#clientesGrid").getCell(linhaSelecionada,0);
				
			if (confirm("Confirma a exclus??o?") == true){
			
				$('#objetoQualquer').load('clientesAction.php?acao=excluir&idCliente='+id);

   			    jQuery("#clientesGrid").jqGrid('setGridParam',{url:'ajaxListarCliente.php?txtNomeCliente=',page:1}).trigger('reloadGrid');
			}	
		}else{
			alert("Selecione um Registro");
		}			   
	})
	
	jQuery("#btnPesquisar").click(function(){
		var txtNome = $('#txtNomeCliente').val();	
		
		jQuery("#clientesGrid").jqGrid('setGridParam',{url:'ajaxListarCliente.php?txtNomeCliente='+txtNome ,page:1}).trigger('reloadGrid');
		
	})
	
	jQuery("#btnLimpar").click(function(){	
		$('#txtNomeCliente').val('');			
		jQuery("#clientesGrid").jqGrid('setGridParam',{url:'ajaxListarCliente.php' ,page:1}).trigger('reloadGrid');		
	})
});
</script>
</head>
<body>
<div id="botoes" style="padding:4px 4px 4px 4px; color:#666; font-size:12px; font-weight:bold;">
    <input type="button" id="btnCadastrar" value="Cadastrar"/>
    <input type="button" id="btnEditar" value="Editar"/>
    <input type="button" id="btnDeletar" value="Deletar"/>
    <input type="text" id="txtNomeCliente" name="txtNomeCliente"/> 
    <input type="button" id="btnPesquisar" value="Pesquisar"/>  
    <input type="button" id="btnLimpar" value="Limpar"/>       
</div> 
<table id="clientesGrid" ></table>
<div id="clientesPagerGrid"></div>
<div id="objetoQualquer"></div>
</body>
</html>





