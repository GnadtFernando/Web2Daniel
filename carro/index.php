<!DOCTYPE html>
<html lang="en">
<head>
<title>Carros</title>
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
	jQuery("#carrosGrid").jqGrid({
			url:'ajaxListarCarros.php',
			editurl:'modeloAction.php',
            datatype:'json',
            mtype:'GET',
            jsonReader:
				{'repeatitems':false},
            pager:'#carrosPagerGrid',
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
            sortname:'NomeCarro',
            sortorder:'asc',
			caption: "Carros",
            colModel:[
                {label:'Cód.',width:60,align:'center',name:'idCarro'},
				{label:'Nome do Carro',width:200,align:'center',name:'nomeCarro'},
				{label:'Marca',width:200,align:'center',name:'nomeMarca'},
				{label:'Preço',width:200,align:'center',name:'preco'},
				{label:'Garagem',width:200,align:'center',name:'garagem'}
            ] 
        });
	jQuery("#carrosGrid").jqGrid('navGrid', '#carrosPagerGrid', {del:false,add:false,edit:false,search:false,refresh:true} );


	//cadastro de carros
	$("#btnCadastrar").click(function(){
		window.location = "carroCad.php";				   
	})
	
	//edição de produto
	$("#btnEditar").click(function(){
	    //Captura a linha selecionada na Grid
		var linhaSelecionada = jQuery("#carrosGrid").getGridParam('selrow');
			
		if(linhaSelecionada != null){
		    //Captura o ID na linha selecionada (célula da coluna 0 - zero)
		    var id = jQuery("#carrosGrid").getCell(linhaSelecionada,0);
			window.location = "carroEdit.php?id="+id;				
		}else{
		    alert("Selecione um registro");
		}	   
	})
	
	//exclusão de produto
	$("#btnDeletar").click(function(){
	    //Captura a linha selecionada na Grid
		var linhaSelecionada = jQuery("#carrosGrid").getGridParam('selrow');

		if(linhaSelecionada != null){
		
			//Captura o ID na linha selecionada (célula da coluna 0 - zero)
		    var id = jQuery("#carrosGrid").getCell(linhaSelecionada,0);
				
			if (confirm("Confirma a exclusão?") == true){
			
				$('#objetoQualquer').load('carroAction.php?acao=excluir&idCarro='+id);

   			    jQuery("#carrosGrid").jqGrid('setGridParam',{url:'ajaxListarCarros.php?txtNomeCarro=',page:1}).trigger('reloadGrid');
			}	
		}else{
			alert("Selecione um Registro");
		}			   
	})
	
	jQuery("#btnPesquisar").click(function(){
		var txtNome = $('#txtNomeCarro').val();	
		
		jQuery("#carrosGrid").jqGrid('setGridParam',{url:'ajaxListarCarros.php?txtNomeCarro='+txtNome ,page:1}).trigger('reloadGrid');
		
	})
	
	jQuery("#btnLimpar").click(function(){	
		$('#txtNomeCarro').val('');			
		jQuery("#carrosGrid").jqGrid('setGridParam',{url:'ajaxListarCarros.php' ,page:1}).trigger('reloadGrid');		
	})
});
</script>
</head>
<body>
<div id="botoes" style="padding:4px 4px 4px 4px; color:#666; font-size:12px; font-weight:bold;">
    <input type="button" id="btnCadastrar" value="Cadastrar"/>
    <input type="button" id="btnEditar" value="Editar"/>
    <input type="button" id="btnDeletar" value="Deletar"/>
    <input type="text" id="txtNomeCarro" name="txtNomeCarro"/> 
    <input type="button" id="btnPesquisar" value="Pesquisar"/>  
    <input type="button" id="btnLimpar" value="Limpar"/>       
</div> 
<table id="carrosGrid" ></table>
<div id="carrosPagerGrid"></div>
<div id="objetoQualquer"></div>
</body>
</html>





