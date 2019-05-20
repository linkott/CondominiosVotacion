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
$tipo = $_POST['Tipo'];
$orden = $_POST['OrdenarPor'];

if ($tipo == '-- Seleccione --' or $tipo == ''){ // Si no seleciona nada muestra todos
   ?>
     <script language='javascript'> 
        $("select#Tipo").val('1'); // Selecciona Sitio Web por Defecto
	 </script>	
   <?php
   $tipo="1";  //Sitio Web    
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

$Sql="select sugerencia.cedula, fecharegistro, sugerencia.email, comentario, nombre || ' ' || apellidos as nombrecompleto from sugerencia inner join persona on sugerencia.cedula = persona.cedula
      WHERE sugerencia.fecharegistro >= '$fechadesde' AND sugerencia.fecharegistro <= '$fechahasta' AND sugerencia.tipo='$tipo' order by $orden";
	  
$Consulta= $Persona->ejecutaQuery($Sql); //Ejecuta el Query en la Base de Datos	 	 
if (!$Consulta) {
   $Persona->controlError(2);   
   exit();
}
$NumReg = $Persona->cuentaRegistro($Consulta);
if ($NumReg == 0){ // Si no hay registros   
    echo "** No Existen Registros para la Fecha Seleccionada **";
	exit();
} 
?>
<?php
$tabla ="<fieldset class='ui-corner-all bordeForm'>
         <legend>Consulta Detallada de Registros</legend>
		 <table id='TablaDatos' width='95%' align='center' cellpadding='4' cellspacing='0'>
		 <tr class='encabezado'>
		    <td style='color:#B53706;'>N&#186;</td>	
			<td style='color:#B53706;'>C&eacute;dula</td>			
			<td style='color:#B53706;'>Nombre y Apellidos</td>
			<td style='color:#B53706;'>Comentario</td>
			<td style='color:#B53706;'>Email</td>
			<td style='color:#B53706;'>Fecha Registro</td>		
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
		         <td>".$Fila['nombrecompleto']."</td>	
                 <td>".$Fila['comentario']."</td>	
                 <td>".$Fila['email']."</td>					 
				 <td>".$Fila['fecharegistro']."</td></tr>"; 			
       	$Cont++;	        
   }	
   $tabla=$tabla."</table></fieldset>";   
   $tabla=$tabla.'<table width="15%" align="right" border=0>
	              <tr><td width="10%">
				        <img src="images/pdf.gif">
					  </td>
					  <td width="90%">
					  <span class="links">
					  <a href="ReporteSugerencias.php?fechadesde='.$fechadesde.'&fechahasta='.$fechahasta.'&tipo='.$tipo.'&orden='.$orden.'" target="_blank">Generar Reporte</a></span></td></tr>   	              
                  </table>';	
   echo $tabla;
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos	
?>