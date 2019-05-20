<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
if (isset($_SESSION['xcedula'])){
   $cedula=$_SESSION['xcedula'];
}
include_once("class/ManejadorBD.class");

$Comentario=$_POST["xComentario"];
$Cedula=$_POST["xsCedula"];
$Email=$_POST["xEmail"];
$Tipo=$_POST["xTipo"];
$FechaRegistro=date("Y-m-d"); //Captura Fecha Actual
//$idsede=$_SESSION['idsede']; 
$idsede=1; // Edificio Sucre por Default

$Persona = new AdministradorBd();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1, $cnn);
   exit();
}
$Consulta=$Persona->ejecutaQuery("Select cedula from Persona Where cedula=$Cedula");
if ($Persona->cuentaRegistro($Consulta)== 0){ // Si no hay registros   
    $Persona->controlError(2, $cnn);
	echo "Error Persona";
    exit();
}	
$Consulta=$Persona->ejecutaQuery("insert into sugerencia (cedula, email, comentario, tipo, fecharegistro, idsede) values('$Cedula','$Email','$Comentario','$Tipo','$FechaRegistro','$idsede')");
if ($Consulta){
    echo "Exito"; 
} else {
    echo "Error Inserta";   
}  
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
