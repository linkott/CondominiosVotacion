<?php
session_start();
if (isset($_SESSION['afiliado'])){
   $Afiliado=$_SESSION['afiliado'];
   $Cedula=$_SESSION['xcedula'];
} else {
   $Afiliado="An&oacute;nimo";
   $Cedula="";
}
?>
<table id="grilla"></table>
<div id="paginador"></div> 
<script type="text/javascript">
$(document).ready(function(){ 
 
        //Obtiene los datos tabla sede para llenar select
            var wsede = $.ajax({
                      url: 'LlenaCombo.php', 
			          async: false,
			          success: function(data, result){
					           if (!result) 
							      alert('Fallo en Llenar Combo Sede');
							   }							   
			}).responseText;  
            
         // Define la Grilla 		 
		 		 
        $("#grilla").jqGrid({ 
        url:'ConsultaAsociacion.php',		
        datatype: 'json',
		mtype: 'POST',		
        colNames:['IdAsociacion','Rif','Nombre','Responsable','Email','Tel&eacute;fono','Sede', 'Estatus', 'Fecha Inicio', 'Fecha Fin'],
        colModel:[
		{name:'idasociacion', edittype: 'text',  width:0, hidden: true, editable: false}, 
		{name:'rif', align:'center', index:'rif',  width:0, hidden: true, editable: true, edittype: 'text', editoptions: {size: 10, maxlength: 10}, editrules: {edithidden:true}},
        {name:'nombre', index:'nombre', width:0, editable: true, edittype: 'text', editoptions: {size:100, maxlength: 100}, editrules: {required: true}},
        {name:'responsable', index:'responsable', width:0, editable: true, edittype: 'text', editoptions: {size:100, maxlength: 100}, editrules: {required: true}},
        {name:'email', align:'center', index:'email', width:0, editable: true, edittype: 'text', editoptions: {size:50, maxlength: 50}},
        {name:'telefono', align:'center', index:'telefono', width:0, editable:true, edittype: 'text', editoptions: {size:15, maxlength: 15}},
		{name:'idsede', align:'center', index:'idsede', width:0, editable: true, edittype: 'select', editrules: {required: true}},
		{name:'estatus', align:'center', index:'estatus', width:0, editable: true, edittype:"select", editoptions: {value:"A:Activa;I:Inactiva"}},
		{name:'fechainicio', align:'center', index:'fechainicio',  width:0, hidden: true, editable: true, sorttype:"date", editoptions: {size:15, maxlength: 15}, editrules: {edithidden:true}},
        {name:'fechafin', align:'center', index:'fechafin',  width:0, hidden: true, editable: true, sorttype:"date", editoptions: {size:15, maxlength: 15}, editrules: {edithidden:true}}
		], 
        scrollOffset: 0, // elimina el spacio del scroll      	
		loadui: 'block',
        width: 750,
		height: 100,
        rowNum:7,
        //rowList:[7,14,21], Muestra un combo para saltar entre paginas
        pager: '#paginador',		
        sortname: 'idasociacion',
		viewrecords: true,
        sortorder: 'desc',
        caption: '<span style=color:#B53706;>Gestionar Asociaci&oacute;n</span>',
		//caption: 'Actualizaci&oacute;n de Datos de Beneficiarios Montepío'
		//caption: 'Actualizaci&oacute;n de Datos de Familiares Mutuo Auxilio'
		editurl:"ProcesaAsociacion.php",		
        loadComplete: function(){		   
  		    $("#grilla").setColProp('idsede', {editoptions:{value:wsede}});	           		
			/*$("#grilla").setGridState('hidden'); // Para ocultar el grid - visible para mostrarlo
            var totalPorc=$("#grilla").getGridParam('userData'); // Captura el Total con userdata
            if (totalPorc > 100){
			   $("#mensaje").text(" El Porcentaje Total No Puede ser Superior a 100, Corregir !");
		       $("#dialog-message").dialog( "option", "title", 'Beneficiarios' );
               $("#dialog-message").dialog('open');
 	        }*/ 		
  	    },
        loadError: function(xhr, status, error){
		    //alert(error); Captura errores en la carga de la grilla
        }        
		});			    
		$("#grilla").jqGrid('navGrid','#paginador',{edit:true, add:true, del:true, search:false, refresh:true},
                {height:300, closeAfterEdit:true,
 				afterShowForm: function(eparams) {
				        //$('#cedula').attr('disabled', true); //Deshabilta la Cedula para Edicion
						$('#nombre, #responsable, #rif').css('text-transform','uppercase');
						$('#fechainicio, #fechafin').datepicker({}); //Añade DatePicker a la Edicion con opciones por defecto 
				},onclickSubmit:EnviaParametro 				
				}, // edit options ,  [ Devuelve el error o exito del envio de data al servidor -- afterSubmit: function(response, postdata){ alert(response.responseText)} ]                
				{height:300,				
				beforeShowForm: function(eparams) {
				        //$('#cedula').attr('disabled', false); //Habilita la Cedula para Edicion, si esta deshabilitada
						$('#fechainicio, #fechafin').datepicker({}); //Añade DatePicker a la Edicion con opciones por defecto
				}
				}, // add options
                {width:320, onclickSubmit:EnviaParametro}, // del options
                {} // search options
        );		
		function EnviaParametro(){ //Crea parametro nuevo que se pasa con la data json
                var Parametro = {}; 
				var Fila = $("#grilla").getGridParam('selrow');
				DataFila = $("#grilla").getRowData(Fila);
				Parametro = {idasociacion:DataFila.idasociacion}; // Paso el idasociacion Como Parametro para ejecutar Eliminar				
				return Parametro;
		}	
		
        // Obtiene el Año actual del Sistema	
	    var fecha=new Date();
	    var annoActual=fecha.getFullYear();
 	    // fin  
        $.datepicker.setDefaults({ // Setea Valores por Defecto para DatePicker        
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy',
			yearRange: '2012:'+annoActual,
			currentText: 'Hoy', currentStatus: '',
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
			'Jul','Ago','Sep','Oct','Nov','Dic'],
			monthStatus: '', yearStatus: '',
			weekHeader: 'Sm', weekStatus: '',
			dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;dabo'],
			dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
			dayStatus: 'DD', dateStatus: 'D, M d'
		});		
});	
</script>

<!--
<table align="right">
<tr><td><img src="images/pdf.gif"></td><td><span class="links"><a href="Reporte.php" target="_blank">Reporte de Beneficiarios</a></span></td></tr>
<tr><td><img src="images/pdf.gif"></td><td><span class="links"><a href="ReporteAfiliados.php" target="_blank">Reporte de Asociados</a></span></td></tr>

<tr><td><img src="images/pdf.gif"></td><td><span class="links"><a href="Descarga.php?archivo=PlanillaAfiliacion.pdf&tipo=2" target="_blank">Reporte de Beneficiarios</a></span></td></tr>
<tr><td><img src="images/pdf-down.gif"></td><td><span class="links"><a href="Descarga.php?archivo=PlanillaAfiliacion.pdf&tipo=1">Reporte de Beneficiarios</a></span></td></tr>

</table>
-->
<table>
<tr>
<td><span class="ui-icon ui-icon-plus"></span></td>
<td class="leyenda">Agregar nuevo registro</td>
</tr>
<tr>
<td><span class="ui-icon ui-icon-pencil"></span></td>
<td class="leyenda">Modificar fila seleccionada</td>
</tr>
<tr>
<td><span class="ui-icon ui-icon-trash"></span></td>
<td class="leyenda">Eliminar fila seleccionada</td>
</tr>
<tr>
<td><span class="ui-icon ui-icon-refresh"></span></td>
<td class="leyenda">Recargar datos</td>
</tr>
</table>
