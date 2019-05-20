<?php
session_start();
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
if (isset($_SESSION['persona'])){
   $Personal=$_SESSION['persona'];
   $Cedula=$_SESSION['xcedula'];
} else {
  /* $Persona="An&oacute;nimo";
   $Cedula="";
?>
   <script language='javascript'>
          $("#mensaje").text(' Debe haber un personal activo, antes de consultar saldo !');
		  $("#dialog-message").dialog( "option", "title", 'Consulta de Saldo' );
          $("#dialog-message").dialog('open');
          $('#tabs').tabs('select', 0);  //Se coloca en el 1er tab		  	 
   </script>
<?php 
   exit();  */
}
$TipoConsulta=$_GET["Tipo"]; //1:Detalle de Registros, 2:Autorizaciones
if($TipoConsulta ==1){
   $descripcion="Registros";
}else{
   $descripcion="Autorizaciones";
}
?>
<script type="text/javascript" src="js/Validar.js"></script>
<script type="text/javascript">
function LlenaOpcionCombo3(xTipo){ 
	$.post("LlenaCombo.php", { Tipo:xTipo }, function(data){          
		  $('#'+xTipo).html(data);				 
	});
}	
</script>

<div id="marco">
<form id="ConsultaSugerencias" name="ConsultaSugerencias" method="Post" action="ConsultarDetalleSugerencias.php">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Datos para la Consulta de Sugerencias y Reclamos</legend>
	<table width='80%' align="center">
	<tr>
    <td align="left"><label for="FechaDesdeR">Fecha Desde</label>
	<input id="FechaDesdeR" name="FechaDesdeR" value="<?php echo '01'.substr(date('d/m/Y'),2,8); ?>"></td>	
	<td align="left"><label for="FechaHastaR">Fecha Hasta</label>
	<input id="FechaHastaR" name="FechaHastaR" value="<?php echo date('d/m/Y'); ?>"></td>
	<td align="center" rowspan="2"><button id="Mostrar" type="submit"> Mostrar </button></td> 	
	</tr>
	<tr>
	<td align="left"><label for="Menu">Tipo de Comentario</label>
	    <select name="Tipo" id="Tipo"> 
		    <option value=''> -- Seleccione -- </option>
			<option value='1'>Sitio Web</option> 
			<option value='2'>Atenci&oacute;n</option> 
			<option value='3'>Servicio</option> 
			<option value='4'>Horario</option> 				
		</select> 
	</td>    
	<td align="left">
	<label for="OrdenarPor">Ordenar Por</label>
	    <select id="OrdenarPor" name="OrdenarPor" title="Seleccione una Opci&oacute;n">			       			
		        <option value=''> -- Seleccione -- </option>
		        <option value='cedula'>C&eacute;dula</option>
				<option value='apellidos'>Email</option>				
				<option value='fecharegistro'>Fecha</option>				
		</select>
	</td>	
	</tr>	
	</table>
	</fieldset>    	
</form>
</div>
<script language='javascript'>
$(document).ready(function() {
  LlenaOpcionCombo3("Menu");   
}); 
</script>
<div id="loading"></div>
<div id="result"></div>