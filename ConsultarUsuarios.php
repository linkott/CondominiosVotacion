<?php
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
session_start();
if (isset($_SESSION['afiliado'])){
   $Personal=$_SESSION['afiliado'];
   $Cedula=$_SESSION['xcedula'];
}

$Persona = new AdministradorBd();

$Formatear = new Formato();

$cnn=$Persona->conectaBd();

if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}
$Sql="SELECT idusuario, nombreusuario, descripcion from usuario inner join tipopersona on usuario.tipousuario=tipopersona.idtipo;";
	  
$Consulta= $Persona->ejecutaQuery($Sql); //Ejecuta el Query en la Base de Datos	 	 
if (!$Consulta) {
   $Persona->controlError(2);   
   exit();
}
$tabla ="<fieldset class='ui-corner-all bordeForm'>
         <legend>Consulta de Usuarios</legend>
		 <table id='TablaDatos' width='85%' align='center' cellpadding='4' cellspacing='0'>
		 <tr class='encabezado'>
		    <td style='color:#B53706;'>N&#186;</td>	
			<td style='color:#B53706;'>Nombre y Apellidos</td>			
			<td style='color:#B53706;'>Nombre de Usuario</td>
			<td style='color:#B53706;'>Tipo de Usuario</td>
		 </tr>";    		
	$TotalGeneral=0;
    $Cont=1;    
    while($Fila = $Persona->obtieneRegistro($Consulta)) { //Ciclo Repetitivo mientras no sea fin de Archivo, cuando se acaban los datos devuelve Falso   
		if ($Cont % 2 == 0){ // Es Par
			   $tabla = $tabla."<tr class='par'>";
        }else{
		   $tabla = $tabla."<tr class='impar'>";
		}		
        $tabla = $tabla."<td>".$Cont."</td>	
                 <td>".$Fila['nombreusuario']."</td>		
		         <td>".$Fila['idusuario']."</td>				 
				 <td>".($Fila['descripcion'])."</td></tr>"; 			
       	$Cont++;	        
   }	
   $tabla=$tabla."</table></fieldset>";   
   echo $tabla;
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos	
?>