<?php
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
session_start();
if (isset($_SESSION['xcedula'])) {
   $xcedula=$_SESSION['xcedula'];
}else {
   $xcedula="";	
}
$operacion=$_POST["oper"]; //Recibe parametro de la grilla con edit, del, add
$id=$_POST["id"];
$idasociacion=$_POST["idasociacion"];

$Formatear = new Formato();

$email=$_POST['email'];
$nombre=$Formatear->cambiaMayuscula($_POST['nombre']);
$responsable=$Formatear->cambiaMayuscula($_POST['responsable']);
$fechainicio=$_POST['fechainicio'];
$fechafin=$_POST['fechafin'];
$rif=$_POST['rif'];
$telefono=$_POST['telefono'];
$estatus=$_POST['estatus'];
$idsede=$_POST['idsede'];


$Persona = new AdministradorBd();

$cnn = $Persona->conectaBd();
if(gettype($cnn)=="string") {
    $error=$cnn;
    die(json_encode(array("error"=>$error)));
}          
if ($operacion == "add"){   //Agregar Registros
   $result= $Persona->ejecutaQuery("insert into asociacion (nombre, rif, responsable, email, telefono, fechainicio, fechafin, estatus, idsede) values('$nombre','$rif','$responsable','$email', '$telefono', '$fechainicio', '$fechafin', '$estatus', '$idsede')"); //Ejecuta el Query en la Base de Datos	 	 
   if(gettype($result)=="string") {
        $error=$result;
        die(json_encode(array("error"=>$error)));
    }else {
        $exito="Se ingresaron correctamente los datos !.";
        die(json_encode(array("exito"=>$exito)));
    } 
}
if ($operacion == "edit"){   //Modificar Registros
   $result= $Persona->ejecutaQuery("update asociacion set nombre='$nombre', rif='$rif', responsable='$responsable', email='$email', telefono='$telefono', fechainicio='$fechainicio', fechafin='$fechafin', estatus='$estatus', idsede='$idsede' where idasociacion='$idasociacion'"); //Ejecuta el Query en la Base de Datos	 	 
   if(gettype($result)=="string") {
        $error=$result;
        die(json_encode(array("error"=>$error)));
    }else {
        $exito="Se actualizaron correctamente los datos ! Fila:".$id;
        die(json_encode(array("exito"=>$exito)));
    }
} 
if ($operacion == "del"){   //Elimina Registros
   $Consulta= $Persona->ejecutaQuery("delete from asociacion where idasociacion='$idasociacion'"); //Ejecuta el Query en la Base de Datos	 	 
   if(gettype($result)=="string") {
        $error=$result;
        die(json_encode(array("error"=>$error)));
    }else {
        $exito="Se elimino el registro satisfactoriamente ! Fila:".$id. " Nombre:".$nombre;
        die(json_encode(array("exito"=>$exito)));
    }
} 
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos		
?>
