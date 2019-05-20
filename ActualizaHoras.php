<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
include_once("class/ManejadorBD.class");

$idhora=$_POST['Hora'];
$horainicio=$_POST['HoraInicio'];
$horafin=$_POST['HoraFin'];
//$idsede=$_POST['Sede'];

$Hora = new AdministradorBd();

$cnn=$Hora->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Hora->controlError(1);
   exit();
}
$Consulta=$Hora->ejecutaQuery("update hora set horainicio='$horainicio', horafin='$horafin' where idhora='$idhora'");
if ($Consulta){
   ?> 
   <script language='javascript'>
          $("#mensaje").text(" Datos actualizados correctamente ! ");
		  $("#dialog-message").dialog( "option", "title", "Gestionar Horas del Comedor" );
          $("#dialog-message").dialog('open');          		  
   </script>
   <?php   
}  
$Hora->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
