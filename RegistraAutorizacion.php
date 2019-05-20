<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
if (isset($_SESSION['xcedula'])){
   $cedula=$_SESSION['xcedula'];
}
include_once("class/ManejadorBD.class");
$nombre=$_POST["xnombre"];
$apellidos=$_POST["xapellidos"];
$direccion=$_POST["xprocedencia"];
$tipopersona="08";  // Invitado
$fechaingreso=date("Y-m-d"); //Captura Fecha Actual
//$idsede=$_SESSION['idsede']; 
$idsede=1; // Edificio Sucre por Default

$Persona = new AdministradorBd();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}
$Consulta=$Persona->ejecutaQuery("insert into persona (cedula, nombre, fechaingreso, apellidos, direccion, tipopersona, idsede) values('$cedula','$nombre','$fechaingreso','$apellidos','$direccion','$tipopersona','$idsede')");
if ($Consulta){
    echo "Registro Exitoso"; 
} else {
    echo "Error en el Query";   
}  
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
