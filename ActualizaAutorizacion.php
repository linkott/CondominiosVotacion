<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
include_once("class/ManejadorBD.class");

$cedula=$_POST['Cedula'];
$nombre=$_POST['Nombre'];
$apellidos=$_POST['Apellidos'];
$direccion=$_POST['Direccion'];
//$idsede=$_SESSION['idsede'];   
$idsede=1;
$estatus=1; // 1:Activo
$tipopersona="08";  // Invitado
$fechaingreso=date("Y-m-d"); //Captura Fecha Actual

$Persona = new AdministradorBd();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}
//if($tipogestion=="Ingresar"){
  $Consulta=$Persona->ejecutaQuery("insert into persona (cedula, nombre, apellidos, fechaingreso, direccion, tipopersona, idsede, estatus) values($cedula,'$nombre', '$apellidos','$fechaingreso','$direccion','$tipopersona', $idsede, $estatus)");
/*}else{  
  $Consulta=$Menu->ejecutaQuery("update menu set descripcion='$descripcion' where idmenu=$idmenu and fecha='$fecha'");
} */ 
if ($Consulta){
   ?> 
   <script language='javascript'>
          $("#mensaje").text(" Datos actualizados correctamente ! ");
		  $("#dialog-message").dialog( "option", "title", "Gestionar Autorizaci\363n" );
          $("#dialog-message").dialog('open');          		  
   </script>
   <?php   
}  
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
