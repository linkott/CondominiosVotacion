<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
$tipomenu=$_GET['tipomenu'];
$titulo = "Reporte estad&iacute;stico del comedor desde el ".$_GET['desde']." hasta el ".$_GET['hasta'];
$tipoconsulta=$_GET['tipoconsulta'];
$sede=$_GET['sede'];
$desde=$_GET['desde'];
$hasta=$_GET['hasta'];
?>
<script type="text/javascript" src="js/Validar.js"></script>
<div id="marcoImpresion">
<form name="OpcionesImpresion" id="OpcionesI" method="Post" action="Reporte.php" target="_blank">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Opciones de Impresi&oacute;n</legend>
	<table border="0" align="center">	
	<tr>
	<td width="20%"><label for="Titulo">T&iacute;tulo del Reporte</label></td>
	<td width="80%"><input type='text' id="Titulo" name="Titulo" size="80" maxlength="80" value="<?php echo $titulo; ?>" OnFocus="Selecciona(this);"></td>
    </tr>
	<tr>
	<td width="20%"><label for="Observaciones">Observaciones</label></td>
	<td width="80%"><textarea id="Observaciones" name="Observaciones" rows="5" cols="80" OnFocus="Selecciona(this);"></textarea></td>
	</tr>	
	<input type='hidden' name="tipomenu" value="<?php echo $tipomenu; ?>">
	<input type='hidden' name="tipoconsulta" value="<?php echo $tipoconsulta; ?>">
	<input type='hidden' name="desde" value="'<?php echo $desde; ?>'">
	<input type='hidden' name="hasta" value="'<?php echo $hasta; ?>'">
	<input type='hidden' name="sede" value="'<?php echo $sede; ?>'">
	<tr>	
    <td colspan="2" align="center"><button id="Imprimir" type="submit"> Imprimir </button> <button id="CancelarI" type="reset"> Cancelar </button></td>
	</tr>
	</table>
	</fieldset>
</form>
</div>