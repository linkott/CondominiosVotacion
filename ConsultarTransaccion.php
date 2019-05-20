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

$fechadesde = $_POST['FechaDesde'];
$fechahasta = $_POST['FechaHasta'];
$idmenu = $_POST['MenuT'];
//$idsede = $_POST['SedeT'];
$tipoconsulta = $_POST['TipoC'];

if ($idmenu == '-- Seleccione --' or $idmenu == ''){ // Si no seleciona nada muestra todos
   ?>
     <script language='javascript'> 
        $("select#MenuT").val('4'); // Selecciona Todos en el combo box
	 </script>	
   <?php
   $idmenu="4";  //Todos    
}
if ($fechadesde == ""){
   $fechadesde = "01"+substr(date("d/m/Y"),2,8);
}
if ($fechahasta == ""){ 
   $fechahasta = date("d/m/Y");
}

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1, $cnn);
   exit();
}
   
    // Para incorporar crosstab ejecutar el script tablefunc.sql que se encuenta dentro de la carpeta contrib
	// Windows : c:\Program Files\PostgreSQL\8.4\share\contrib\
	//Linux:$ cd /usr/share/postgresql/8.3/contrib
    //        $ psql test < tablefunc.sql

if ($tipoconsulta == 'Voto'){	
	if ($idmenu=="1"){ // Todos
	    $Sql="SELECT * FROM crosstab(
			'SELECT transaccion.eleccion::text AS eleccion, persona.sexo::text,Count(transaccion.cedula)::text AS cantidad 
			 FROM (transaccion INNER JOIN persona ON transaccion.cedula=persona.cedula) INNER JOIN hora ON hora.idhora=transaccion.idhora 
			 WHERE (((transaccion.fechatransaccion)>=''$fechadesde'' And (transaccion.fechatransaccion)<=''$fechahasta''))
			 GROUP BY transaccion.eleccion, transaccion.idhora, persona.sexo 
			 ORDER BY transaccion.eleccion, transaccion.idhora, persona.sexo') AS ct(eleccion text,masculino text,femenino text);";	 
    }else{
		$Sql="SELECT * FROM crosstab(
			 'SELECT transaccion.eleccion::text AS eleccion, persona.sexo::text,Count(transaccion.cedula)::text AS cantidad 
			  FROM (transaccion INNER JOIN persona ON transaccion.cedula=persona.cedula) INNER JOIN hora ON hora.idhora=transaccion.idhora
			  WHERE (((transaccion.fechatransaccion)>=''$fechadesde'' And (transaccion.fechatransaccion)<=''$fechahasta'' And (transaccion.idhora)=$idmenu))
		      GROUP BY transaccion.eleccion,transaccion.idhora, persona.sexo 
			  ORDER BY transaccion.eleccion,transaccion.idhora, persona.sexo') AS ct(eleccion text, masculino text ,femenino text);";	 
	}
}else{
    if ($idmenu=="4"){ // Todos
	    $Sql="SELECT * FROM crosstab('SELECT to_char(transaccion.fechatransaccion,''D'')::text AS dia, hora.idhora::int AS descripcion, 
              count(transaccion.cedula)::int AS cantidad FROM transaccion INNER JOIN hora ON transaccion.idhora=hora.idhora WHERE (((transaccion.fechatransaccion)>=''$fechadesde'' And (transaccion.fechatransaccion)<=''$fechahasta''))
              GROUP BY to_char(transaccion.fechatransaccion,''D''), hora.idhora ORDER BY to_char(transaccion.fechatransaccion,''D''),hora.idhora', 'select m from generate_series(1,3) m') AS (dia text, desayuno int, almuerzo int, cena int);";	 
    }else{
		$Sql="SELECT * FROM crosstab('SELECT to_char(transaccion.fechatransaccion,''D'')::text AS dia, hora.idhora::int AS descripcion, 
              count(transaccion.cedula)::int AS cantidad FROM transaccion INNER JOIN hora ON transaccion.idhora=hora.idhora WHERE (((transaccion.fechatransaccion)>=''$fechadesde'' And (transaccion.fechatransaccion)<=''$fechahasta'' And (transaccion.idhora)=$idmenu))
              GROUP BY to_char(transaccion.fechatransaccion,''D''), hora.idhora ORDER BY to_char(transaccion.fechatransaccion,''D''),hora.idhora', 'select m from generate_series(1,3) m') AS (dia text, desayuno int, almuerzo int, cena int);";	 
	}    
}	
$Consulta= $Persona->ejecutaQuery($Sql); //Ejecuta el Query en la Base de Datos	 	 
if (!$Consulta) {
   $Persona->controlError(2, $cnn);   
   exit();
}
if ($Persona->cuentaRegistro($Consulta)== 0){ // Si no hay registros   
    echo "<span class='mensajeError'>** No Existen Registros para la Fecha Seleccionada **</span>";
	exit();
}  

if ($tipoconsulta == 'Voto'){	
       $tabla ="
	   <table id='TablaDatos' width='85%' align='center' cellpadding='4' cellspacing='0'>		
		<tr class='encabezado'>
			<td style='color:#B53706;'>Descripci&oacute;n</td>			
			<td style='color:#B53706;'>Femenino</td>
			<td style='color:#B53706;'>Masculino</td>
			<td style='color:#B53706;'>Total</td>
		</tr>";  
			
	$TotalGeneral=0;
    $TotalFemenino=0;
    $TotalMasculino=0;	
	$Cont=1;    
    while($Fila = $Persona->obtieneRegistro($Consulta)) { //Ciclo Repetitivo mientras no sea fin de Archivo, cuando se acaban los datos devuelve Falso   
		
		if ($Cont % 2 == 0){ // Es Par
			   $tabla = $tabla."<tr class='par'>";
        }else{
		   $tabla = $tabla."<tr class='impar'>";
		}
		if (is_null($Fila['femenino'])){
		    $Fila['femenino']=0;
		}
		if (is_null($Fila['masculino'])){
		    $Fila['masculino']=0;
		}
        switch($Fila['eleccion']){ // Construye Data para el Grafico
		    case "SI":				       
		        $datasi="name:'SI',data:[".$Fila['femenino'].",".$Fila['masculino']."]}, {"; 
		   	    break;
			case "NO":				       
			    $datano="name:'NO',data:[".$Fila['femenino'].",".$Fila['masculino']."]}, {"; 
			    break;
			case "Ninguno":				       
			    $dataninguno="name:'Niguno',data:[".$Fila['femenino'].",".$Fila['masculino']."]";
			     break;				  
		} 
        $tabla = $tabla."<td>".$Fila['eleccion']."</td>        		
		<td>".$Fila['femenino']."</td><td>".$Fila['masculino']."</td><td>".($Fila['femenino']+$Fila['masculino'])."</td></tr>"; 			
		$TotalFemenino+=$Fila['femenino'];
		$TotalMasculino+=$Fila['masculino']; 
		$TotalGeneral+=$Fila['femenino']+$Fila['masculino'];
		$Cont++;	        
    }	
	$tabla=$tabla."<tr class='encabezado'><td align='center' style='color:#B53706;'>Total General</td>
	   <td style='color:#B53706;'>".$TotalFemenino."</td>
	   <td style='color:#B53706;'>".$TotalMasculino."</td>
	   <td style='color:#B53706;'>".$TotalGeneral."</td>
	   </tr></table>";
       // si hay algun renglon faltante, le asigna cero(0)   
       if (!isset($datasi)){
	      $datasi="name:'SI',data:[0,0]}, {"; 
       }
       if (!isset($datano)){
	      $datano="name:'NO',data:[0,0]}, {"; 
       }
       if (!isset($dataniguno)){
	      $dataninguno="name:'Ninguno',data:[0,0]"; 
       }          
	   $grafico=$datasi.$datano;		
	   $categoria="'Femenino','Masculino'";
}else{
      $tabla ="
	   <table id='TablaDatos' width='85%' align='center' cellpadding='4' cellspacing='0'>		
		<tr class='encabezado'>
			<td style='color:#B53706;'>Descripci&oacute;n</td>			
			<td style='color:#B53706;'>SI</td>
			<td style='color:#B53706;'>NO</td>
			<td style='color:#B53706;'>Total</td>
		</tr>";  
			
	$TotalGeneral=0;
    $TotalSi=0;
    $TotalNo=0;		
	$Cont=1;    
    while($Fila = $Persona->obtieneRegistro($Consulta)) { //Ciclo Repetitivo mientras no sea fin de Archivo, cuando se acaban los datos devuelve Falso   
		
		if ($Cont % 2 == 0){ // Es Par
			   $tabla = $tabla."<tr class='par'>";
        }else{
		   $tabla = $tabla."<tr class='impar'>";
		}
		if (is_null($Fila['SI'])){
		    $Fila['SI']=0;
		}
		if (is_null($Fila['NO'])){
		    $Fila['NO']=0;
		}
        switch($Fila['dia']){ // Construye Data para el Grafico oldd - ,".$Fila['cena']."
		    case "2": //Lunes				       
		        $datalunes="name:'Lunes',data:[".$Fila['SI'].",".$Fila['NO']."]}, {"; 
				$diasemana="Lunes";
		   	    break;
			case "3": //Martes				       
			    $datamartes="name:'Martes',data:[".$Fila['SI'].",".$Fila['NO']."]}, {"; 
			    $diasemana="Martes";
				break;
			case "4": //Miercoles				       
			    $datamiercoles="name:'Mi\u00e9rcoles',data:[".$Fila['SI'].",".$Fila['NO']."]}, {"; 
			    $diasemana="Mi&eacute;rcoles";
				break;
            case "5": //Jueves				       
			    $datajueves="name:'Jueves',data:[".$Fila['SI'].",".$Fila['NO']."]}, {"; 
			    $diasemana="Jueves";
				break;				
			case "6": // Viernes				       
			    $dataviernes="name:'Viernes',data:[".$Fila['SI'].",".$Fila['NO']."]";
			    $diasemana="Viernes";
				break;				  
		} 
        $tabla = $tabla."<td>".$diasemana."</td>        		
		<td>".$Fila['SI']."</td><td>".$Fila['NO']."</td><td>".($Fila['SI']+$Fila['NO'])."</td></tr>"; 			
		$TotalSi+=$Fila['SI'];
		$TotalNo+=$Fila['NO']; 
		$TotalGeneral+=$Fila['SI']+$Fila['NO'];
		$Cont++;	        
    }	
	$tabla=$tabla."<tr class='encabezado'><td align='center' style='color:#B53706;'>Total General</td>
	   <td style='color:#B53706;'>".$TotalSi."</td>
	   <td style='color:#B53706;'>".$TotalNo."</td>
	   <td style='color:#B53706;'>".$TotalGeneral."</td>
	   </tr></table>";
       // si hay algun renglon faltante, le asigna cero(0)   
       if (!isset($datalunes)){
	      $datalunes="name:'Lunes',data:[0,0]}, {"; 
       }
       if (!isset($datamartes)){
	      $datamartes="name:'Martes',data:[0,0]}, {"; 
       }
       if (!isset($datamiercoles)){
	      $datamiercoles="name:'Miercoles',data:[0,0]}, {"; 
       }   
       if (!isset($datajueves)){
	      $datajueves="name:'Jueves',data:[0,0]}, {"; 
       }
       if (!isset($dataviernes)){
	      $dataviernes="name:'Viernes',data:[0,0]"; 
       }       
	   $grafico=$datalunes.$datamartes.$datamiercoles.$datajueves.$dataviernes;
	   $categoria="'SI','NO'";
} 
	?>
	<script language='javascript' src='js/highcharts.js'></script>
	<script type="text/javascript">
		    $('#grafica').show(); // Muestra div para generar la grafica 
			var chart;
			var desde = "<?php echo $fechadesde; ?>";
			var hasta = "<?php echo $fechahasta; ?>";			
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'grafica',
						defaultSeriesType: 'column'
					},
					title: {
						text: 'Resultados de votacion  '+ desde +' hasta el ' + hasta
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories: [
							 <?php echo $categoria; ?>
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Cantidad de Votantes'
						}
					},
					/*legend: {
						layout: 'vertical',
						backgroundColor: '#FFFFFF',
						align: 'left',
						verticalAlign: 'top',
						x: 100,
						y: 70,
						floating: true,
						shadow: true
					}, */
					tooltip: {
						formatter: function() {
							return ''+
								this.series.name +', '+ this.x  +': '+ this.y +' Votantes';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
				        series: [{ <?php echo $grafico; ?>  }]
				});				
				
			});
				
		</script>		
       <script language='javascript'> 
          $('#impresion').show();  // Si se muestra el grafico muestra boton de impresion
	   </script>	     	
	   <?php
	   echo $tabla;
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos	
?>