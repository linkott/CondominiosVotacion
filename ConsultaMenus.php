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
<form name="ConsultaMenus" id="ConsultaMenus" method="Post" action="#">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Consulta Men&uacute; del Comedor</legend>
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
	<td width="20%"><label for="MenuFecha">Fecha del Men&uacute;</td>
	<td width="80%"><input type='text' id="MenuFecha" name="MenuFecha" maxlength="15" OnFocus="Selecciona(this);"></td>
	</tr>
	<tr>
	<td width="20%"><label for="DescripcionMenu">Descripci&oacute;n del Men&uacute;</label></td>
	<td width="80%"><textarea rows=10 cols=60 id="DescripcionMenu" name="DescripcionMenu" OnFocus="Selecciona(this);">
	</textarea></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>	
	</table>
	</fieldset>
</form>
</div>
<script language='javascript'>
$(document).ready(function() {
  LlenaOpcionCombo3("Menu");    
}); 
</script>
