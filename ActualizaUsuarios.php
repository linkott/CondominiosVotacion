<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
include_once("class/ManejadorBD.class");

$IdUsuario=$_POST['usuarioid'];
$nombreusuario=$_POST['nombreusuario'];
$password=md5($_POST['password']);
$tipousuario=$_POST['TipoUsuario'];
$preguntasecreta=$_POST['preguntasecreta'];
$respuestasecreta=$_POST['respuestasecreta'];

$Usuario = new AdministradorBd();

$cnn=$Usuario->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Usuario->controlError(1);
   exit();
}
$Consulta=$Usuario->ejecutaQuery("insert into usuario (idusuario, nombreusuario, password, tipousuario, preguntasecreta, respuestasecreta) values ('$IdUsuario','$nombreusuario','$password','$tipousuario','$preguntasecreta','$respuestasecreta')");
//$Consulta=$Hora->ejecutaQuery("update usuario set password='$password', nombreusuario='$nombreusuario', preguntasecreta='$preguntasecreta',respuestasecreta='$respuestasecreta' where idusuario='$idusuario'");
if ($Consulta){
   ?> 
   <script language='javascript'>
          $("#mensaje").text(" Datos actualizados correctamente ! ");
		  $("#dialog-message").dialog( "option", "title", "Gestionar Usuarios" );
          $("#dialog-message").dialog('open');          		  
   </script>
   <?php   
}  
$Usuario->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
