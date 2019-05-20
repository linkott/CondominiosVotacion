<?php
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
session_start();
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
?>
<script type="text/javascript" src="js/Validar.js"></script>
<script language="Javascript" type="text/javascript">
function LlenaOpcionCombo3(xTipo){ 
	$.post("LlenaCombo.php", { Tipo:xTipo }, function(data){          
		  $('#'+xTipo).html(data);				 
	});
}	
</script>

<div id="marcoTransaccion">
<form id="ConsultaTransaccion" name="ConsultaTransaccion" method="Post" action="ConsultarTransaccion.php">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Consulta de Transacciones</legend>
	<table width='85%' align="center" border=0>
	<tr>
    <td align="left" width='30%'><label for="FechaDesde">Fecha Desde</label>
	<input id="FechaDesde" name="FechaDesde" value="<?php echo '01'.substr(date('d/m/Y'),2,8); ?>"></td>	
	<td align="left" width='30%'><label for="FechaHasta">Fecha Hasta</label>
	<input id="FechaHasta" name="FechaHasta" value="<?php echo date('d/m/Y'); ?>"></td>
	<td width='20%'>&nbsp;</td>
	<td width='20%' align="right" rowspan="2"><button id="Mostrar" type="submit"> Mostrar </button></td> 
	</tr>
	<tr>
	<td align="left"><label for="MenuT">Tipo de Servicio</label>
	    <select id="MenuT" name="MenuT" title="Seleccione una Opci&oacute;n">			       			
		</select>
	</td>  
    <td align="left"><label for="TipoC">Tipo de Consulta</label>
	    <select id="TipoC" name="TipoC" title="Seleccione una Opci&oacute;n">			       			
		     <option value='Voto'>Por Voto</option>
		     <option value='Semana'>Por Condominio</option>
		</select>
	</td>   	
<!--	<td align="left"><label for="SedeT">Sede</label>
	    <select id="SedeT" name="SedeT" title="Seleccione una Opci&oacute;n">			       			
		</select>
	</td> -->
    
	</tr>	
	</table>
	</fieldset>    	
</form>
</div>
<div id="loading"></div>
<div id="grafica"></div>
<div id="result"></div>
<div id="impresion">
    <table align='left'>
	    <tr><td><button id='Imprimir' onClick=$('#impresion').load('OpcionesImpresion.php?desde='+document.ConsultaTransaccion.FechaDesde.value+'&hasta='+document.ConsultaTransaccion.FechaHasta.value+'&tipomenu='+document.ConsultaTransaccion.MenuT.value+'&tipoconsulta='+document.ConsultaTransaccion.TipoC.value);>Imprimir Resultados</button></td></tr>
    </table>
</div>
<script language='javascript'>
$(document).ready(function() {
  LlenaOpcionCombo3("MenuT"); 
  LlenaOpcionCombo3("SedeT"); 
  $('#impresion, #grafica').hide(); //Oculta el Div impresion    
}); 
</script>