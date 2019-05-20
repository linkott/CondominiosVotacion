<?php
session_start();
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
$cedula=$_POST['Cedula'];
if (isset($_SESSION['xcedula']) and ($cedula==NULL or $cedula=="")){ // Si no se envia por buscar toma la cedula de la variable de sesion
   $cedula=$_SESSION['xcedula']; 
}

$Persona = new AdministradorBd();

$Formatear = new Formato();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}	                   
$Consulta= $Persona->ejecutaQuery("select * from persona where cedula=$cedula  order by apellidos"); //Ejecuta el Query en la Base de Datos	 old: and estatus=1	 
if (!$Consulta) {
   $Persona->controlError(2);
   exit();
}
$Fila = $Persona->obtieneRegistro($Consulta);
if ($Persona->cuentaRegistro($Consulta) > 0) {

// Crea variables de sesion con la consulta o reasigna segun consulta
/*$_SESSION['xcedula']=$Fila['cedula'];
$_SESSION['persona']=$Fila['nombre']." ".$Fila['apellidos'];*/
?>
<script type="text/javascript" src="js/Validar.js"></script>
<script type="text/javascript">
function SeleccionaOpcCombo(xTipo, xValor, xUbicacion, xSede){ 
	$.post("LlenaCombo.php", { Tipo:xTipo, Valor:xValor }, function(data){		  
		  $('#'+xTipo).html(data);	         	  
	});
}
</script>
<form name="FActualizar" id="Actualizar" method="Post" action="ActualizaTransaccion.php">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Consulta de Datos Personales</legend>
	<table width='750'>
	<tr><td colspan="5">&nbsp;</td></tr>
	<tr>
	<td width="20%"><label for="Cedula">C&eacute;dula</label></td>
	<td width="20%"><input id="Cedula" name="Cedula" tabindex='1' maxlength="10" value="<?php echo $cedula ?>" disabled>
	<input type="hidden" value="<?php echo $cedula ?>" name="xCedula">
	<input type="hidden" value="Actualizar" name="Tipo">
	</td>
	<td rowspan="8">&nbsp;</td>
	<?php
	$filename = "images/fotos/".$cedula.".jpg";
	if ( !file_exists($filename) ) {	   
       $filename = "images/fotos/SinFoto.jpg";
    }
	?>
	<td width="30%" rowspan="8" class="ui-corner-all bordeForm"><img src="<?php echo $filename ?>" width="250" height="250"></td>
	<td rowspan="8">&nbsp;</td> 
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
	<td>
	<label for="Genero">G&eacute;nero</label>
	</td>
	<td>
		<select id="Sexo" name="Sexo" title="Seleccione una Opci&oacute;n">
			<option value=""></option>
			<option value='F'>Femenino</option>
			<option value='M'>Masculino</option>						
		</select>
	</td>
    </tr>		
	<tr>
	<td><label for="FechaIngreso">Fecha de Ingreso</label></td>
	<td><input id="FechaIngreso" name="FechaIng" tabindex='4' value="<?php echo $Formatear->cambiaFecha($Fila['fechaingreso']) ?>"></td>
	</tr>	
	<tr>
    <?php
	  if ($Fila['tipopersona'] =='08') { // si es invitado cambia el label a procedencia
	      echo "<td><label for='DirHab'>Lugar de Procedencia</label></td>";
      }else{
	      echo "<td><label for='DirHab'>Direcci&oacute;n de Habitaci&oacute;n</label></td>";
      }	
	?>  
	<td><textarea id="DirHab" name="DirHab" size="40" cols="40" rows="2"><?php echo $Fila['direccion'] ?></textarea></td>
    </tr>
	<tr>
	<td><label for="Email">E-mail</label></td>
	<td><input id="Email" name="Email" tabindex='5' size="40" value="<?php echo $Fila['email'] ?>"></td>
	</tr>	
	
	<tr>
	<td>
		<label id="Eleccion">Elección</label>
	</td>
	<td align="right">
		<button id="botonSI" name="xEleccionSI"  tabindex='6' name="GuardarI" type="submit"  value="SI" style='width:70px; height:40px'>SI</button>
	</td>
	<td align="right">
		<button id="botonNO" name="xEleccionNO" tabindex='7' name="GuardarO" type="submit" value="NO" style='width:70px; height:40px'> NO </button>
		
	</td>	
    </tr>	
	<tr><td colspan="5">&nbsp;</td></tr>
	<td align="right"><button id="GuardarI" tabindex='6' name="GuardarI" type="submit"> Asistir </button></td>
    <td><button id="Cancelar" name="Cancelar" tabindex='7' type="reset"> Cancelar </button></td>
	</table>
	</fieldset>
</form>
<?php	  
} else {
    //$_SESSION['xcedula']=$cedula; // Crea variable de sesion para capturar en el formulario de registro nuevo*/
    ?>
	<script language='javascript'>	             		  
		  $("#mensaje").text("El usuario no est\u00e1 Activo en Sistema,  !");
		  $("#dialog-message").dialog( "option", "title", "Ingreso" );
		  $("#dialog-message").dialog('open'); 
    </script>	 
	<?php
}
$Consulta= $Persona->ejecutaQuery("SELECT * FROM transaccion WHERE cedula=$cedula"); //Ejecuta el Query en la Base de Datos old: and estatus=1
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
	if (!$Consulta) {
   	$Persona->controlError(2);
   	exit();
}else{
	$fecha=date("Y-m-d");
	$Fila = $Persona->obtieneRegistro($Consulta);
	$totalConsulta = $Persona->cuentaRegistro($Consulta);
	if($totalConsulta  == 0 || $fecha != $Fila['fechatransaccion2'] ){
?>
		<script type="text/javascript">
		$(document).ready(function(){ 	
		//setTimeout(function(){$('#GuardarI').submit()},900)});
		</script>
<?php
}}		   
?>

