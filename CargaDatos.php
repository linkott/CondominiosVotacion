<?php
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
$Tipo=$_POST["Tipo"]; 
$Opcion=$_POST["Opcion"]; 
$Sede=$_POST["Sede"]; 
$Valor=$_POST["Valor"];

$Persona = new AdministradorBd();

$Formatear = new Formato();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}	             
switch($Tipo){  
		case "Hora":      
			$Consulta= $Persona->ejecutaQuery("select horainicio, horafin from hora where idhora='$Opcion'"); //Ejecuta el Query en la Base de Datos	
			break;	
        case "Sede":      
			$Consulta= $Persona->ejecutaQuery("select * from sede order by idsede"); //Ejecuta el Query en la Base de Datos	
			break;	
        case "Menu":      
			$Consulta= $Persona->ejecutaQuery("select descripcion from menu where idmenu=$Opcion and fecha = '$Valor'"); //Ejecuta el Query en la Base de Datos	
			break;	        
		case "MesDesde": 
        case "MesHasta":		
			$Consulta= $Persona->ejecutaQuery("select distinct mes from aporte order by mes"); //Ejecuta el Query en la Base de Datos		
			break;
		case "AnnoDesde":   
        case "AnnoHasta":   		
			$Consulta= $Persona->ejecutaQuery("select distinct anno from aporte order by anno"); //Ejecuta el Query en la Base de Datos		
			break;
        case "TipoPersona":	
            $Consulta= $Persona->ejecutaQuery("select * from tipopersona order by idtipo"); //Ejecuta el Query en la Base de Datos		
			break;		
		default:
			$Consulta= $Persona->ejecutaQuery("select * from parentesco order by idparentesco"); //Ejecuta el Query en la Base de Datos
}	
if (!$Consulta) {
   $Persona->controlError(2);
   exit();
}

if ($Persona->cuentaRegistro($Consulta) > 0){ 
    $cadena="<option> -- Seleccione -- </option>";    
	while($Fila = $Persona->obtieneRegistro($Consulta)){  
        switch($Tipo){  
			case "Hora":
			     $cadena=$Fila['horainicio'].$Fila['horafin'];
			     break;
			case "Menu":
			     $cadena=$Fila['descripcion'];
			     break;	 
			case "Sede":
			   if ($Fila['idsede']==$Valor){
			      $cadena= $cadena."<option selected value='".$Fila['idsede']."'>".$Fila['nombre']."</option>";
			   }else{
			      $cadena= $cadena."<option value='".$Fila['idsede']."'>".$Fila['nombre']."</option>";
			   }	  
			   break;         
            case "MesDesde": 
            case "MesHasta":	 			   
			      $cadena= $cadena."<option value='".$Fila['mes']."'>".$Formatear->muestraMes($Fila['mes'])."</option>";
				  break;
			case "AnnoDesde":   
            case "AnnoHasta":  
                  $cadena= $cadena."<option value='".$Fila['anno']."'>".$Fila['anno']."</option>";
				  break; 
            case "TipoPersona":
			   if ($Fila['idtipo']==$Valor){
			      $cadena= $cadena."<option selected value='".$Fila['idtipo']."'>".$Fila['descripcion']."</option>";
			   }else{
                  $cadena= $cadena."<option value='".$Fila['idtipo']."'>".$Fila['descripcion']."</option>";
               }				  
			   break; 				  
		    default:
		       $cadena= $cadena.$Fila['idparentesco'].":".$Fila['nombre'].";";
		}	
	}
	//if ($Tipo=="Hora" or $Tipo=="Sede" or $Tipo=="Ubicacion" or $Tipo=="Unidad" or $Tipo=="MesDesde" or $Tipo=="MesHasta" or $Tipo=="AnnoDesde" or $Tipo=="AnnoHasta" or $Tipo=="TipoPersona"){  
	    echo $cadena; 		
	//}else{
	    //echo $cadena=substr($cadena,0,strlen($cadena)-1); // Remueve el ; final de la cadena;
	//}	
}	
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos		   
?>