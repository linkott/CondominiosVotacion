<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
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
<div id="marcoHoras">
<form name="GestionarHoras" id="GestionarHoras" method="Post" action="ActualizaHoras.php">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Actualizar Horarios</legend>
	<table width='100%'>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
	<td width="20%"><label for="Hora">Horario</label></td>
	<td width="80%">
	    <select id="Hora" name="Hora" title="Seleccione una Opci&oacute;n">			       			
		</select>
	</td>
    </tr>
	<tr>
	<td width="20%"><label for="HoraInicio">Hora de Inicio</label></td>
	<td width="80%"><input type='text' id="HoraInicio" name="HoraInicio" maxlength="15" OnFocus="Selecciona(this);"></td>
	</tr>
	<tr>
	<td width="20%"><label for="HoraFin">Hora de Cierre</label></td>
	<td width="80%"><input type='text' id="HoraFin" name="HoraFin" maxlength="15" OnFocus="Selecciona(this);"></td>
	</tr>
	<tr>
	<!-- <td width="20%"><label for="Sede">Sede</label></td>
	<td width="80%">
	    <select id="Sede" name="Sede" title="Seleccione una Opci&oacute;n">			       			
		</select>
	</td> -->
    </tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
	<td align="right"><button id="Guardar" type="submit"> Guardar </button></td>
    <td><button id="Cancelar" type="reset"> Cancelar </button></td>
	</tr>
	</table>
	</fieldset>
</form>
<script language='javascript'>
$(document).ready(function() {
  LlenaOpcionCombo3("Hora"); 
  LlenaOpcionCombo3("Sede");    
}); 
</script>
</div>
