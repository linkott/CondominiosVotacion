<?php
session_start();
if (isset($_SESSION['idusuario'])){ 
   $idusuario=$_SESSION['idusuario'];   
}
include_once("class/ManejadorBD.class");

$idmenu=$_POST['IdMenu'];
$fecha=$_POST['FechaMenu'];
$descripcion=$_POST['Descripcion'];
$tipogestion=$_POST['TipoGestion'];
//$idsede=$_SESSION['idsede'];   
$idsede=$_POST['Sede'];

if ($idmenu == '-- Seleccione --' or $idmenu == ''){ // Si no seleciona nada muestra todos
   ?>
   <script language='javascript'>
          $("#mensaje").text("Debe seleccionar el Tipo de Men\372 !");
		  $("#dialog-message").dialog( "option", "title", "Gestionar Men\372s del Comedor" );
          $("#dialog-message").dialog('open');          		  
   </script>
   <?php 
   exit();     
}
if ($idsede == '-- Seleccione --' or $idsede == ''){ // Si no seleciona nada muestra todos
   ?>
   <script language='javascript'>
          $("#mensaje").text("Debe seleccionar la Sede !");
		  $("#dialog-message").dialog( "option", "title", "Gestionar Men\372s del Comedor" );
          $("#dialog-message").dialog('open');          		  
   </script>
   <?php 
   exit();     
}

$Menu = new AdministradorBd();

$cnn=$Menu->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Menu->controlError(1);
   exit();
}
if($tipogestion=="Ingresar"){
  $Consulta=$Menu->ejecutaQuery("insert into menu (idmenu, fecha, descripcion, idsede) values($idmenu,'$fecha','$descripcion', $idsede)"); 
}else{  
  $Consulta=$Menu->ejecutaQuery("update menu set descripcion='$descripcion' where idmenu=$idmenu and fecha='$fecha'");
}  
if ($Consulta){
   ?> 
   <script language='javascript'>
          $("#mensaje").text(" Datos actualizados correctamente ! ");
		  $("#dialog-message").dialog( "option", "title", "Gestionar Men\372s del Comedor" );
          $("#dialog-message").dialog('open');          		  
   </script>
   <?php   
}  
$Menu->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
