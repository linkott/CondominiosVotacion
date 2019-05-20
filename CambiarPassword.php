<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
?>
<script type="text/javascript" src="js/Validar.js"></script>
<div id="marcoPassword">
<form name="ActualizarPassword" id="ActualizarPassword" method="Post" action="ActualizaPassword.php">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Cambiar Contrase&ntilde;a de Usuario</legend>
	<table width='100%'>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
	<td width="20%"><label for="Password">Contrase&ntilde;a Actual</label></td>
	<td width="80%"><input type='password' id="Password" name="Password" maxlength="15" OnFocus="Selecciona(this);"></td>
    </tr>
	<tr>
	<td width="20%"><label for="PasswordNew">Contrase&ntilde;a Nueva</label></td>
	<td width="80%"><input type='password' id="PasswordNew" name="PasswordNew" maxlength="15" OnFocus="Selecciona(this);"></td>
	</tr>
	<tr>
	<td width="20%"><label for="PasswordConf">Repetir Contrase&ntilde;a</label></td>
	<td width="80%"><input type='password' id="PasswordConf" name="PasswordConf" maxlength="15" OnFocus="Selecciona(this);"></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
	<td align="right"><button id="Guardar" type="submit"> Guardar </button></td>
    <td><button id="Cancelar" type="reset"> Cancelar </button></td>
	</tr>
	</table>
	</fieldset>
</form>
</div>