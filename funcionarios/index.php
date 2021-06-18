<!DOCTYPE html>
<html lang="en">
<head>
<title>Funcionários</title>
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
	jQuery("#funcionariosGrid").jqGrid({
			url:'ajaxListarFuncionarios.php',
			editurl:'funcionariosAction.php',
            datatype:'json',
            mtype:'GET',
            jsonReader:
				{'repeatitems':false},
            pager:'#funcionariosPagerGrid',
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
            sortname:'NomeFuncionario',
            sortorder:'asc',
			caption: "Funcionários",
            colModel:[
                {label:'Matricula',width:60,align:'center',name:'idFuncionario'},
				{label:'Nome do Funcionário',width:200,align:'center',name:'nomeFuncionario'},
				{label:'Taxa de Comissão',width:80,align:'center',name:'comissao'}
				
            ] 
        });
	jQuery("#funcionariosGrid").jqGrid('navGrid', '#funcionariosPagerGrid', {del:false,add:false,edit:false,search:false,refresh:true} );
	
	//cadastro de func
	$("#btnCadastrar").click(function(){
		window.location = "funcionarioCad.php";				   
	})
	
	//edição de func
	$("#btnEditar").click(function(){
	    //Captura a linha selecionada na Grid
		var linhaSelecionada = jQuery("#funcionariosGrid").getGridParam('selrow');
			
		if(linhaSelecionada != null){
		    //Captura o ID na linha selecionada (célula da coluna 0 - zero)
		    var id = jQuery("#funcionariosGrid").getCell(linhaSelecionada,0);
			window.location = "funcionarioEdit.php?id="+id;				
		}else{
		    alert("Selecione um registro");
		}	   
	})
	
	//exclusão de categoria
	$("#btnDeletar").click(function(){
	    //Captura a linha selecionada na Grid
		var linhaSelecionada = jQuery("#funcionariosGrid").getGridParam('selrow');

		if(linhaSelecionada != null){
		
			//Captura o ID na linha selecionada (célula da coluna 0 - zero)
		    var id = jQuery("#funcionariosGrid").getCell(linhaSelecionada,0);
				
			if (confirm("Confirma a exclusão?") == true){
			
				$('#objetoQualquer').load('funcionariosAction.php?acao=excluir&idFuncionario='+id);

   			    jQuery("#funcionariosGrid").jqGrid('setGridParam',{url:'ajaxListarFuncionarios.php?txtNomeFuncionario=',page:1}).trigger('reloadGrid');
			}	
		}else{
			alert("Selecione um Registro");
		}			   
	})
	
	jQuery("#btnPesquisar").click(function(){
		var txtNome = $('#txtNomeFuncionario').val();	
		
		jQuery("#funcionariosGrid").jqGrid('setGridParam',{url:'ajaxListarFuncionarios.php?txtNomeFuncionario='+txtNome ,page:1}).trigger('reloadGrid');
		
	})
	
	jQuery("#btnLimpar").click(function(){	
		$('#txtNomeFuncionario').val('');			
		jQuery("#funcionariosGrid").jqGrid('setGridParam',{url:'ajaxListarFuncionarios.php' ,page:1}).trigger('reloadGrid');		
	})
});
</script>
</head>
<body>
<div id="botoes" style="padding:4px 4px 4px 4px; color:#666; font-size:12px; font-weight:bold;">
    <input type="button" id="btnCadastrar" value="Cadastrar"/>
    <input type="button" id="btnEditar" value="Editar"/>
    <input type="button" id="btnDeletar" value="Deletar"/>
    <input type="text" id="txtNomeFuncionario" name="txtNomeFuncionario"/> 
    <input type="button" id="btnPesquisar" value="Pesquisar"/>  
    <input type="button" id="btnLimpar" value="Limpar"/>       
</div> 
<table id="funcionariosGrid" ></table>
<div id="funcionariosPagerGrid"></div>
<div id="objetoQualquer"></div>
</body>
</html>





