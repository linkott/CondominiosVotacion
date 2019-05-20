<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
?>
<script type="text/javascript" src="js/Validar.js"></script>
<script type="text/javascript">
function LlenaOpcionCombo(xTipo){ 
	$.post("LlenaCombo.php", { Tipo:xTipo }, function(data){          
		  $('#'+xTipo).html(data);				 
	});
}	
</script>
<div id="marcoAutorizacion">
<form name="GestionarAutorizacion" id="GestionarAutorizacion" method="Post" action="ActualizaAutorizacion.php">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Gestionar Autorizaciones</legend>
	<table width='100%'>
	<tr><td colspan="2">&nbsp;</td></tr>
    <tr>
	<td width="20%"><label for="Cedula">C&eacute;dula</label></td>
	<td width="20%"><input id="CedulaA" name="Cedula" maxlength="10">&nbsp;&nbsp;<span id="etiqueta"></span></td>
    </tr>	
	<tr>
	<td width="20%"><label for="Nombre">Nombre</label></td>
	<td width="20%"><input id="Nombre" name="Nombre" tabindex='2' size="40" OnKeyUp="Mayuscula(this);" value="<?php echo $Fila['nombre'] ?>"></td>
	</tr>
	<tr>
	<td><label for="Apellidos">Apellidos</label></td>
	<td><input id="Apellidos" name="Apellidos" tabindex='3' size="40" OnKeyUp="Mayuscula(this);" value="<?php echo $Fila['apellidos'] ?>"></td>
	</tr>
	<tr>	
	<td><label for="Direccion">Procedencia</label></td>
	<td><textarea id="Direccion" name="Direccion" cols="40" rows="2"></textarea></td>
    </tr>
	<tr>
	<td width="20%"><label for="Sede">Sede</label></td>
	<td width="80%">
	   <!-- <select id="Sede" name="Sede" title="Seleccione una Opci&oacute;n">			       			
		</select> -->
	</td>
    </tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
	<td align="right"><button id="Guardar" type="submit"> Guardar </button></td>
    <td><button id="CancelarA" type="reset"> Cancelar </button></td>
	</tr>	
	</table>
	</fieldset>
</form>
<script language='javascript'>
$("#CedulaA").ForceNumericOnly(); // Valida Solo Numeros
$(document).ready(function() {
  LlenaOpcionCombo("Sede");    
}); 
</script>
</div>