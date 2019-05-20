<?php
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");

$Menu = new AdministradorBd();

$cnn=$Menu->conectaBd();

if (!$cnn) { // Si la Conexion  Falla
   $Menu->controlError(1);
   exit();
}	             

$FechaActual=date('d/m/Y'); // Captura Fecha Actual del Sistema

// Muestra el Menu del comedor si esta cargado.

$Consulta= $Menu->ejecutaQuery("select hora.descripcion as menu, menu.descripcion as detalle from menu inner join hora on menu.idmenu=hora.idhora where menu.fecha='$$FechaActual' order by menu.idmenu;"); //Ejecuta el Query en la Base de Datos
	
if (!$Consulta) {
   $Menu->controlError(2);
   exit();
}

if ($Menu->cuentaRegistro($Consulta) > 0){ 
    $cadena="<table border=0 cellspacing=10>";    
	while($Fila = $Menu->obtieneRegistro($Consulta)){  
        $cadena=$cadena."<tr><td><span class='tituloScroll'>".$Fila['menu']."</span></td></tr>"."<tr><td><span class='leyenda'>".$Fila['detalle']."</span></td></tr>";					
	}
	$cadena = $cadena."</table>";
	echo $cadena;
}else{
    echo "<span class='leyenda'>Actualmente No hay Men&uacute; Cargado para la Fecha de Hoy ...</span>";	
}	
// Muestra el Horario del Comedor
$Consulta= $Menu->ejecutaQuery("select hora.descripcion as menu, horainicio, horafin from hora order by idhora;"); //Ejecuta el Query en la Base de Datos
if ($Menu->cuentaRegistro($Consulta) > 0){ 
    $cadena="<table border=0 cellspacing=10 width='90%'>"; 
    $cadena=$cadena."<tr><td align='center' class='tituloScroll'>Horario del Comedor</td></tr>";	
	while($Fila = $Menu->obtieneRegistro($Consulta)){ 
        $horainicio=substr($Fila['horainicio'],0,2);
		$horafin=substr($Fila['horafin'],0,2);
	    if ( $horainicio > 12){
		   $horainicio = $horainicio - 12; 
		   $ampmi ="pm";
		}else{   
		   $ampmi ="am";
        }
		if ( $horafin > 12){
		   $horafin = $horafin - 12; 
		   $ampmf="pm";
		}else{   
		   $ampmf ="am";   
        }
		$horainicio=$horainicio.substr($Fila['horainicio'],2,3)." $ampmi";
		$horafin=$horafin.substr($Fila['horafin'],2,3)." $ampmf";
        $cadena=$cadena."<tr><td><span class='tituloScroll'>".$Fila['menu']."</span></td></tr>"."<tr><td><span class='leyenda'>".$horainicio." a ".$horafin."</span></td></tr>";					
	}
	$cadena = $cadena."</table>";
	echo $cadena;
}

//Muestra la asociacion actualemnte activa.

$Consulta= $Menu->ejecutaQuery("select nombre, responsable, email from asociacion where estatus='A';"); //Ejecuta el Query en la Base de Datos
	
if (!$Consulta) {
   $Menu->controlError(2);
   exit();
}

if ($Menu->cuentaRegistro($Consulta) > 0){ 
    $cadena="<table border=0 cellspacing=10>"; 
    $cadena=$cadena."<tr><td align='center' class='tituloScroll'>Datos de Contacto de la Asociaci&oacute;n</td></tr>";	
	$Fila = $Menu->obtieneRegistro($Consulta); 
    $cadena=$cadena."<tr><td><span class='tituloScroll'>Nombre</span></td></tr>"
	               ."<tr><td><span class='leyenda'>".$Fila['nombre']."</span></td></tr>"
				   ."<tr><td><span class='tituloScroll'>Responsable</span></td></tr>"
	               ."<tr><td><span class='leyenda'>".$Fila['responsable']."</span></td></tr>"
				   ."<tr><td><span class='tituloScroll'>Email</span></td></tr>"
	               ."<tr><td><span class='leyenda'>".$Fila['email']."</span></td></tr>";					
	echo $cadena;
}else{
    //echo "<span class='leyenda'>Actualmente No hay Men&uacute; Cargado para la Fecha de Hoy ...</span>";	
}	

$Menu->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos		   
?>