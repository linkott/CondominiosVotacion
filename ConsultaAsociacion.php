<?php
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
session_start();
if (isset($_SESSION['xcedula'])) {
   $xcedula=$_SESSION['xcedula'];
   //$idsede=$_SESSION['xcedula'];
}else {
   $xcedula="";	
}
$page = $_POST['page'];  // get the requested page
$limit = $_POST['rows']; // get how many rows we want to have into the grid
$sidx = $_POST['sidx']; // get index row - i.e. user click to sort, propiedad index del campo a ordenar
$sord = $_POST['sord']; // get the direction if(!$sidx) $sidx =1; 
$idsede=1;

$Persona = new AdministradorBd();

$cnn = $Persona->conectaBd();
if(gettype($cnn)=="string") {
    $error=$cnn;
    die(json_encode(array("error"=>$error)));
} 

$result = $Persona->ejecutaQuery("SELECT COUNT(1) AS count FROM asociacion where idsede=".$idsede);
$row = $Persona->obtieneRegistro($result);

$count = $row['count'];

if( $count > 0 ){
   $total_pages = ceil($count/$limit);
} else { 
   $total_pages = 0;
} 
if ($page > $total_pages) $page=$total_pages;

$start = $limit*$page - $limit; // do not put $limit*($page - 1) 

if ($start < 0) $start=0; // Si no hay registros establece en 0 el inicio

$SQL = "select * from asociacion where idsede=".$idsede." LIMIT $limit OFFSET $start";                   

$result=$Persona->ejecutaQuery($SQL); //Ejecuta el Query en la Base de Datos	

if(gettype($result)=="string") {
    $error=$result;
    die(json_encode(array("error"=>$error)));    
} 
	
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$i=0;
$Totalp=0;
$Formato = new Formato();

while($row = $Persona->obtieneRegistro($result)) {
   $fechainicio=$Formato->cambiaFecha($row['fechainicio']);
   $fechafin=$Formato->cambiaFecha($row['fechafin']);
   if ($row['estatus'] == 'A'){
      $estatus="Activa";
   }else{	
      $estatus="Inactiva";   
   }
   if ($row['idsede'] == 1){
      $sede="Edificio Sucre";
   }else{	
      $sede="Los Cedros";   
   }
   $responce->rows[$i]['cell']=array($row['idasociacion'],$row['rif'],$row['nombre'],$row['responsable'],$row['email'], $row['telefono'], $sede, $estatus, $fechainicio, $fechafin); 
   $i++;
} 
$responce->userdata = $Totalp;
echo json_encode($responce);  	

$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos		   
?>