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
<div id="marcoUsuario">
<form name="GestionarUsuarios" id="GestionarUsuarios" method="Post" action="ActualizaUsuarios.php">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Gestionar Usuarios</legend>
	<table width='100%'>
	<tr><td colspan="2">&nbsp;</td></tr>	
	<tr>
	<td width="20%"><label for="usuarioid">Nombre de Usuario</label></td>
	<td width="80%"><input type='text' id="usuarioid" name="usuarioid" size="30" maxlength="30" OnFocus="Selecciona(this);"></td>
	</tr>
	<tr>
	<td width="20%"><label for="password">Contrase&ntilde;a</label></td>
	<td width="80%"><input type='password' id="password" name="password" size="30" maxlength="30" OnFocus="Selecciona(this);"></td>
	</tr>
	<tr>
	<td width="20%"><label for="nombreusuario">Nombre y Apellidos</label></td>
	<td width="80%"><input type='text' id="nombreusuario" name="nombreusuario" size="30" maxlength="30" OnFocus="Selecciona(this);"></td>
	</tr>
	<tr>
	<td width="20%"><label for="preguntasecreta">Pregunta Secreta</label></td>
	<td width="80%"><input type='text' id="preguntasecreta" name="preguntasecreta" size="30" maxlength="30" OnFocus="Selecciona(this);"></td>
	</tr>
	<tr>
	<td width="20%"><label for="respuestasecreta">Respuesta</label></td>
	<td width="80%"><input type='text' id="respuestasecreta" name="respuestasecreta" size="30" maxlength="30" OnFocus="Selecciona(this);"></td>
	</tr>
	<tr>
	<td width="20%"><label for="TipoUsuario">Tipo de Usuario</label></td>
	<td width="80%">
	    <select id="TipoUsuario" name="TipoUsuario" title="Seleccione una Opci&oacute;n">			       			
		</select>
	</td>
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
  LlenaOpcionCombo3("TipoUsuario");    
}); 
</script>
</div>