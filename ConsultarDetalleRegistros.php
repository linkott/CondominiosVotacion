<?php
session_start();
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
if (isset($_SESSION['afiliado'])){
   $Personal=$_SESSION['afiliado'];
   $Cedula=$_SESSION['xcedula'];
}

$Persona = new AdministradorBd();

$fechadesde = $_POST['FechaDesdeR'];
$fechahasta = $_POST['FechaHastaR'];
$idmenu = $_POST['Menu'];
$orden = $_POST['OrdenarPor'];
$TipoConsulta = $_POST['Tipo']; //1:Detalle de Registros, 2:Autorizaciones

if ($idmenu == '-- Seleccione --' or $idmenu == ''){ // Si no seleciona nada muestra todos
   ?>
     <script language='javascript'> 
        $("select#Menu").val('1'); // Selecciona  por Defecto
	 </script>	
   <?php
   $idmenu="1";  //Desayuno    
}

if ($orden == '-- Seleccione --' or $orden == ''){ // Si no seleciona nada muestra todos
   ?>
     <script language='javascript'> 
	   $("#OrdenarPor").val('cedula'); // Selecciona Cedula por Defecto en el combo box
	 </script>	
   <?php
   $orden="cedula";  //Cedula   
}

$Formatear = new Formato();

$cnn=$Persona->conectaBd();

if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}
if ($TipoConsulta == 1) {
    $Sql="SELECT transaccion.cedula, fechatransaccion, horatransaccion, nombre, apellidos ,descripcion2,fechatransaccion2,horatransaccion2 
          FROM transaccion INNER JOIN persona ON transaccion.cedula = persona.cedula
	      WHERE transaccion.fechatransaccion >= '$fechadesde' AND transaccion.fechatransaccion <= '$fechahasta'
          AND transaccion.idhora=$idmenu ORDER BY $orden";
}else{
    $Sql="SELECT transaccion.cedula, fechatransaccion, horatransaccion, nombre, apellidos ,descripcion2 ,fechatransaccion2,horatransaccion2 
          FROM transaccion INNER JOIN persona ON transaccion.cedula = persona.cedula
	      WHERE transaccion.fechatransaccion >= '$fechadesde' AND transaccion.fechatransaccion <= '$fechahasta'
          AND transaccion.idhora=$idmenu AND autorizado=true ORDER BY $orden";  
}	  
	  
$Consulta= $Persona->ejecutaQuery($Sql); //Ejecuta el Query en la Base de Datos	 	 
if (!$Consulta) {
   $Persona->controlError(2);   
   exit();
}
$NumReg = $Persona->cuentaRegistro($Consulta);
if ($NumReg == 0){ // Si no hay registros   
    echo "<span class='mensajeError'>** No Existen Registros para la Fecha Seleccionada **</span>";
	exit();
} 
?>
<?php
$tabla ="<fieldset class='ui-corner-all bordeForm'>
         <legend>Consulta Detallada de Registros</legend>
		 <table id='TablaDatos' width='85%' align='center' cellpadding='4' cellspacing='0'>
		 <tr class='encabezado'>
		    <td style='color:#B53706;'>N&#186;</td>	
			<td style='color:#B53706;'>C&eacute;dula</td>			
			<td style='color:#B53706;'>Nombre y Apellidos</td>
			<td style='color:#B53706;'>Fecha Registro Entrada</td>
			<td style='color:#B53706;'>Hora Registro Entrada</td>
			<td style='color:#B53706;'>Fecha Registro Salida</td>
			<td style='color:#B53706;'>Hora Registro Salida</td>
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
                 <td>".$Fila['cedula']."</td>		
		         <td>".$Fila['nombre']." ".$Fila['apellidos']."</td>	
                 <td>".$Formatear->cambiaFecha($Fila['fechatransaccion'])."</td>				 
				 <td>".$Formatear->cambiaHora($Fila['horatransaccion'])."</td>
				<td>".$Formatear->cambiaFecha($Fila['fechatransaccion2'])."</td>
				<td>".$Fila['horatransaccion2']."</td>
								 
				 </tr>"; 			
       	$Cont++;	        
   }	
   $tabla=$tabla."</table></fieldset>";   
   $tabla=$tabla.'<table width="15%" align="right" border=0>
	              <tr><td width="10%">
				        <img src="images/pdf.gif">
					  </td>
					  <td width="90%">
					  <span class="links">
					  <a href="ReporteTransacciones.php?fechadesde='.$fechadesde.'&fechahasta='.$fechahasta.'&idmenu='.$idmenu.'&orden='.$orden.'&tipoconsulta='.$TipoConsulta.'" target="_blank">Generar Reporte</a></span></td></tr>   	              
                  </table>';	
   echo $tabla;
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos	
?>
