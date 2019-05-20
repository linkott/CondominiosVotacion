<?php
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
$Tipo=$_POST["Tipo"]; 
$Opcion=$_POST["Opcion"]; 
//$Sede=$_POST["Sede"]; 
$Valor=$_POST["Valor"];
$sw=0;  // switch para comprobar si es un valor para la grilla o no.
$Persona = new AdministradorBd();

$Formatear = new Formato();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}	             
switch($Tipo){  
		case "Hora": 
		  case "Menu":	
		  $Consulta= $Persona->ejecutaQuery("select idhora, descripcion from hora order by idhora"); //Ejecuta el Query en la Base de Datos	
		  break;
        case "MenuT":			
			$Consulta= $Persona->ejecutaQuery("select idservicio, descripcion from tiposervicio order by idservicio"); //Ejecuta el Query en la Base de Datos	
			break;	
		case "TipoUsuario":      
			$Consulta= $Persona->ejecutaQuery("select idtipo, descripcion from tipopersona order by idtipo limit 3"); //Toma solo los 3 primeros valores de la tabla
			break;	
       	//case "Sede":  
        	//case "SedeT":  		
			//$Consulta= $Persona->ejecutaQuery("select * from sede order by idsede"); //Ejecuta el Query en la Base de Datos	
			//break;	
        case "Ubicacion":      
			$Consulta= $Persona->ejecutaQuery("select idubicacion, descripcion from ubicacion where idsede='$Opcion' order by idubicacion"); //Ejecuta el Query en la Base de Datos	
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
            $Consulta= $Persona->ejecutaQuery("select * from tipopersona where idtipo > '03' order by idtipo"); // Para el tipo de persona excluye los usuarios del sistema		
			break;		
		default:
			$Consulta= $Persona->ejecutaQuery("select * from sede order by idsede"); //Ejecuta el Query en la Base de Datos	
			$sw=1;
}	
if (!$Consulta) {
   $Persona->controlError(2);
   exit();
}

if ($Persona->cuentaRegistro($Consulta) > 0){ 
    if ($sw==0){ // Si no es un valor para la grilla
       $cadena="<option> -- Seleccione -- </option>";    
	}else{
       $cadena="0:-- Seleccione --;";
	}      
	while($Fila = $Persona->obtieneRegistro($Consulta)){  
        switch($Tipo){  
			case "Hora":
			case "Menu":
			if ($Fila['idhora']==$Valor){
				$cadena= $cadena."<option selected value='".$Fila['idhora']."'>".$Fila['descripcion']."</option>";
			}else{
					$cadena= $cadena."<option value='".$Fila['idhora']."'>".$Fila['descripcion']."</option>";			   
			}  
			break;
			case "MenuT":
			if ($Fila['idservicio']==$Valor){
				$cadena= $cadena."<option selected value='".$Fila['idservicio']."'>".$Fila['descripcion']."</option>";
			}else{
					$cadena= $cadena."<option value='".$Fila['idservicio']."'>".$Fila['descripcion']."</option>";			   
			}  
			break;
			case "TipoUsuario":
			   if ($Fila['idtipo']==$Valor){
			      $cadena= $cadena."<option selected value='".$Fila['idtipo']."'>".$Fila['descripcion']."</option>";
			   }else{
                  $cadena= $cadena."<option value='".$Fila['idtipo']."'>".$Fila['descripcion']."</option>";
               }				  
			   break;    
			case "Sede":
			case "SedeT":
			   if ($Fila['idsede']==$Valor){
			      $cadena= $cadena."<option selected value='".$Fila['idsede']."'>".$Fila['nombre']."</option>";
			   }else{
			      $cadena= $cadena."<option value='".$Fila['idsede']."'>".$Fila['nombre']."</option>";
			   }	  
			   break;   
			case "Ubicacion":
			   if ($Fila['idubicacion']==$Valor){
			      $cadena= $cadena."<option selected value='".$Fila['idubicacion']."'>".$Fila['descripcion']."</option>";
			   }else{
                  $cadena= $cadena."<option value='".$Fila['idubicacion']."'>".$Fila['descripcion']."</option>";
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
		       $cadena= $cadena.$Fila['idsede'].":".$Fila['nombre'].";"; // Por defecto Sede para cargar en la Grilla JqGrid
		}	
	}
	if ($Tipo=="MenuT"){  //Agrega Opcion adicional al Menu cuando se trata de Consultar Transacciones
	    $cadena= $cadena."<option value='4'>Todos</option>";
	}
	if ($Tipo=="SedeT"){  //Agrega Opcion adicional a la Sede cuando se trata de Consultar Transacciones
	    $cadena= $cadena."<option value='Todas'>Todas</option>";
	}
	if ($Tipo=="Hora" or $Tipo=="Menu" or $Tipo=="MenuT" or $Tipo=="TipoUsuario" or $Tipo=="Sede" or $Tipo=="Ubicacion" or $Tipo=="MesDesde" or $Tipo=="MesHasta" or $Tipo=="AnnoDesde" or $Tipo=="AnnoHasta" or $Tipo=="TipoPersona"){  
	    echo $cadena;
	}else{
	    echo $cadena=substr($cadena,0,strlen($cadena)-1); // Remueve el ; final de la cadena;
	}	
}	
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos		   
?>