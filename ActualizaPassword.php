<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
include_once("class/ManejadorBD.class");

$newpassword=md5($_POST['PasswordNew']);

$Persona = new AdministradorBd();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}
$Consulta=$Persona->ejecutaQuery("update usuario set password='$newpassword' where idusuario='$idusuario'");
if ($Consulta){
   ?> 
   <script language='javascript'>
          $("#mensaje").text(" Su contrase\361a se ha actualizado correctamente ! ");
		  $("#dialog-message").dialog( "option", "title", "Cambiar Contrase\361a" );
          $("#dialog-message").dialog('open');          		  
   </script>
   <?php   
}  
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
