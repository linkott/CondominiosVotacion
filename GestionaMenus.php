<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
$FechaActual = date("d/m/Y");
?>
<script type="text/javascript" src="js/Validar.js"></script>
<script type="text/javascript">
function LlenaOpcionCombo3(xTipo){ 
	$.post("LlenaCombo.php", { Tipo:xTipo }, function(data){          
		  $('#'+xTipo).html(data);				 
	});
}	
</script>
<div id="marcoMenus">
<form name="GestionarMenus" id="GestionarMenus" method="Post" action="ActualizaMenus.php">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Actualizar Men&uacute; del Comedor</legend>
	<table width='100%'>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
	<td width="20%"><label for="IdMenu">Tipo de Men&uacute;</label></td>
	<td width="80%">
	    <select id="Menu" name="IdMenu" title="Seleccione una Opci&oacute;n">			       			
		</select>
	</td>
    </tr>
	<tr>
	<td width="20%"><label for="FechaMenu">Fecha del Men&uacute;</td>
	<td width="80%"><input type='text' id="FechaMenu" name="FechaMenu" maxlength="15" OnFocus="Selecciona(this);"></td>
	<input type="hidden" name="TipoGestion" value="Ingresar">
	</tr>
	<tr>
	<td width="20%"><label for="Descripcion">Descripci&oacute;n del Men&uacute;</label></td>
	<td width="80%"><textarea rows="10" cols="60" id="Descripcion" name="Descripcion" OnFocus="Selecciona(this);">Detalle el Men&uacute; por contenido ...
	1.xxxxxxx
	2.xxxxxxx
	</textarea></td>
	</tr>
	<tr>
	<td width="20%"><label for="Sede">Sede</label></td>
	<td width="80%">
	    <select id="Sede" name="Sede" title="Seleccione una Opci&oacute;n">			       			
		</select>
	</td>
    </tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
	<td align="right"><button id="GuardarM" type="submit"> Guardar </button></td>
    <td><button id="CancelarM" type="reset"> Cancelar </button></td>
	</tr>
	</table>
	</fieldset>
</form>
</div>
<script language='javascript'>
$(document).ready(function() {
  LlenaOpcionCombo3("Menu"); 
  LlenaOpcionCombo3("Sede");  
}); 
</script>
