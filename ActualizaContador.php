<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
include_once("class/ManejadorBD.class");

$Persona = new AdministradorBd();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}

$fechatransaccion=date("Y-m-d"); //Captura Fecha Actual
$horatransaccion=date("H:i:s"); // Captura Hora Actual

$Consulta=$Persona->ejecutaQuery("select count(*) as total from transaccion inner join hora on transaccion.idhora = hora.idhora where fechatransaccion ='$fechatransaccion' and '$horatransaccion' between horainicio and horafin");
$Fila = $Persona->obtieneRegistro($Consulta);
if ($Persona->cuentaRegistro($Consulta) > 0){
    $TotalRegistros = $Fila['total'];
}else{
     $TotalRegistros = 0;
}	
echo "<table><tr><td><span class='ui-widget-header labelContador bordeForm'>&nbsp; Total Registros Procesados: ".$TotalRegistros."&nbsp;</span></td></tr></table>";
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
