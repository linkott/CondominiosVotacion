<?php
// Crea Sesion
session_start();
include_once("class/ManejadorBD.class");

// Limpia la cadena de caracteres para evitar inyeccion sql
$banArray = array("\x00", "\\", "\0", "\n", "\r", "'", '"', "\x1a");
$username =str_replace($banArray,' ',$_POST["username"]);

//$idusuario=$_POST["IdUsuario"]; 

$idusuario=str_replace($banArray,' ',$_POST["IdUsuario"]);
$password=md5($_POST["Password"]); 

$Usuario = new AdministradorBd();

$cnn=$Usuario->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Usuario->controlError(1);
   exit();
}	             

$Consulta= $Usuario->ejecutaQuery("Select idusuario, nombreusuario, tipousuario from usuario Where idusuario='$idusuario' and password='$password'"); //Ejecuta el Query en la Base de Datos
if (!$Consulta) {
   $Usuario->controlError(2);
   exit();
}

if ($Usuario->cuentaRegistro($Consulta) > 0){ 
    $Fila = $Usuario->obtieneRegistro($Consulta);
	
	// Crea variables de sesion con la consulta o reasigna segun consulta    
	$_SESSION['idusuario']=$Fila['idusuario'];
    $_SESSION['usuario']=$Fila['nombreusuario'];
    
	$cadena= "Valido".$Fila['tipousuario'].$_SESSION['usuario'];
	
	echo $cadena;		
} else {
    echo "<p class='user etiqueta'>Nombre de Usuario o Contrase&ntilde;a Errados, vuelva a intentarlo</p>";
}	
$Usuario->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos		   
?>
