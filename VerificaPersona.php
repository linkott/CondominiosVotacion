<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
include_once("class/ManejadorBD.class");

$cedula=$_POST['cedula'];

$Persona = new AdministradorBd();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}
$Consulta=$Persona->ejecutaQuery("Select cedula from persona WHERE cedula=$cedula");
if ($Persona->cuentaRegistro($Consulta) > 0) {
   echo $cedula." ya se encuentra registrada!";
}else{
   echo "Disponible";
}  
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
