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
$genero = $_POST['CheckGenero'];
$idmenu = $_POST['MenuT'];

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
if ($genero == "Activado"){ // Si se Selecciono Agregar Genero    
    // Para incorporar crosstab ejecutar el script tablefunc.sql que se encuenta dentro de la carpeta contrib
	// Windows : c:\Program Files\PostgreSQL\8.4\share\contrib\
	//Linux:$ cd /usr/share/postgresql/8.3/contrib
    //        $ psql test < tablefunc.sql
	
	if ($idmenu=="4"){ // Todos
	    $Sql="SELECT * FROM crosstab('SELECT tipopersona.descripcion::text AS descripcion, persona.sexo::text,
			Count(transaccion.cedula)::text AS cantidad FROM (transaccion INNER JOIN persona ON transaccion.cedula=persona.cedula)
			INNER JOIN tipopersona ON persona.tipopersona=tipopersona.idtipo WHERE (((transaccion.fechatransaccion)>=''$fechadesde'' And (transaccion.fechatransaccion)<=''$fechahasta''))
			GROUP BY tipopersona.descripcion, tipopersona.idtipo, persona.sexo ORDER BY tipopersona.descripcion, tipopersona.idtipo, persona.sexo') AS ct(descripcion text, femenino text, masculino text);";	 
    }else{
		$Sql="SELECT * FROM crosstab('SELECT tipopersona.descripcion::text AS descripcion, persona.sexo::text,
			Count(transaccion.cedula)::text AS cantidad FROM (transaccion INNER JOIN persona ON transaccion.cedula=persona.cedula)
			INNER JOIN tipopersona ON persona.tipopersona=tipopersona.idtipo WHERE (((transaccion.fechatransaccion)>=''$fechadesde'' And (transaccion.fechatransaccion)<=''$fechahasta'' And (transaccion.idhora)=$idmenu))
			GROUP BY tipopersona.descripcion, tipopersona.idtipo, persona.sexo ORDER BY tipopersona.descripcion, tipopersona.idtipo, persona.sexo') AS ct(descripcion text, femenino text, masculino text);";	 
	}		  
}else{

    if ($idmenu=="4"){ // Todos 
		$Sql="SELECT count( transaccion.cedula) AS cantidad, tipopersona.descripcion AS descripcion FROM (transaccion INNER JOIN persona ON transaccion.cedula = persona.cedula) INNER JOIN tipopersona ON persona.tipopersona = tipopersona.idtipo
			WHERE transaccion.fechatransaccion >= '$fechadesde' AND transaccion.fechatransaccion <= '$fechahasta' GROUP BY tipopersona.descripcion, tipopersona.idtipo ORDER BY tipopersona.descripcion;";	
	}else{	 
	    $Sql="SELECT count( transaccion.cedula) AS cantidad, tipopersona.descripcion AS descripcion FROM (transaccion INNER JOIN persona ON transaccion.cedula = persona.cedula) INNER JOIN tipopersona ON persona.tipopersona = tipopersona.idtipo
			WHERE transaccion.fechatransaccion >= '$fechadesde' AND transaccion.fechatransaccion <= '$fechahasta' AND transaccion.idhora=$idmenu GROUP BY tipopersona.descripcion, tipopersona.idtipo ORDER BY tipopersona.descripcion;";	
    }		 
}	  
$Consulta= $Persona->ejecutaQuery($Sql); //Ejecuta el Query en la Base de Datos	 	 
if (!$Consulta) {
   $Persona->controlError(2, $cnn);   
   exit();
}
if ($Persona->cuentaRegistro($Consulta)== 0){ // Si no hay registros   
    echo "** No Existen Registros para la Fecha Seleccionada **";
	exit();
}  
    if ($genero == "Activado"){
	   $tabla ="
	   <table id='TablaDatos' width='85%' align='center' cellpadding='4' cellspacing='0'>
		<tr class='encabezado'><td>&nbsp;</td><td colspan='2' style='color:#B53706; text-align=center'>G&eacute;nero</td><td>&nbsp;</td></tr>
		<tr class='encabezado'>
			<td style='color:#B53706;'>Descripci&oacute;n</td>			
			<td style='color:#B53706;'>Femenino</td>
			<td style='color:#B53706;'>Masculino</td>
			<td style='color:#B53706;'>Total</td>
		</tr>";  
	}else{
       $tabla ="
       <table id='TablaDatos' width='85%' align='center' cellpadding='4' cellspacing='0'>
		<tr class='encabezado'>
			<td style='color:#B53706;'>Descripci&oacute;n</td>			
			<td style='color:#B53706;'>Total</td>
		</tr>";
    }		
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
		if ($genero == "Activado"){	
		   if (is_null($Fila['femenino'])){
		      $Fila['femenino']=0;
		   }
		   if (is_null($Fila['masculino'])){
		      $Fila['masculino']=0;
		   }
           switch($Fila['descripcion']){ // Construye Data para el Grafico
			      case "Administrativo":				       
				       $dataadm="name:'Administrativos',data:[".$Fila['femenino'].",".$Fila['masculino']."]}, {"; 
					   break;
				  case "Docente":				       
				       $datadoc="name:'Docentes',data:[".$Fila['femenino'].",".$Fila['masculino']."]}, {"; 
					   break;
				  case "Obrero":				       
				       $dataobr="name:'Obreros',data:[".$Fila['femenino'].",".$Fila['masculino']."]}, {";
					   break;
				  case "Estudiante":				       
				       $dataest="name:'Estudiantes',data:[".$Fila['femenino'].",".$Fila['masculino']."]"; 
					   break;
			} 
            $tabla = $tabla."<td>".$Fila['descripcion']."s</td>        		
		     <td>".$Fila['femenino']."</td><td>".$Fila['masculino']."</td><td>".($Fila['femenino']+$Fila['masculino'])."</td></tr>"; 			
			$TotalFemenino+=$Fila['femenino'];
			$TotalMasculino+=$Fila['masculino']; 
			$TotalGeneral+=$Fila['femenino']+$Fila['masculino'];
		}else{
            $TotalGeneral=$TotalGeneral + $Fila['cantidad'];		
		    $tabla = $tabla."<td>".$Fila['descripcion']."s</td>        		
		    <td>".$Fila['cantidad']."</td></tr>"; 
		    $grafico=$grafico."['".$Fila['descripcion']."s',".$Fila['cantidad']."],"; // Captura los Datos del gráfico y los formatea			 
        }		
       	$Cont++;	        
    }	
	if ($genero == "Activado"){
       $tabla=$tabla."<tr class='encabezado'><td align='center' style='color:#B53706;'>Total General</td>
	   <td style='color:#B53706;'>".$TotalFemenino."</td>
	   <td style='color:#B53706;'>".$TotalMasculino."</td>
	   <td style='color:#B53706;'>".$TotalGeneral."</td>
	   </tr></table>";
       // si hay algun renglon faltante, le asigna cero(0)   
       if (!isset($dataadm)){
	      $dataadm="name:'Administrativos',data:[0,0]}, {"; 
       }
       if (!isset($datadoc)){
	      $datadoc="name:'Docentes',data:[0,0]}, {"; 
       }
       if (!isset($dataobr)){
	      $dataobr="name:'Obreros',data:[0,0]}, {"; 
       }
       if (!isset($dataest)){
	      $dataest="name:'Estudiantes',data:[0,0]"; 
       }	   
	   $grafico=$dataadm.$datadoc.$dataobr.$dataest;
	}else{
	   $tabla=$tabla."<tr class='encabezado'><td align='center' style='color:#B53706;'>Total General</td><td style='color:#B53706;'>".$TotalGeneral."</td></tr></table>";
	   $grafico=substr($grafico,0,strlen($grafico)-1); // Remueve la , final de la cadena;
	}      
	if ($genero == "Activado"){	// si esta activado el genero
	?>
	   	<script language='javascript' src='js/highcharts.js'></script>
	    <script type="text/javascript">
		
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
						text: 'Asistencia al Comedor del '+ desde +' hasta el ' + hasta
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories: [
							'Femenino',
							'Masculino'
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Cantidad de Personas'
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
								this.x  +': '+ this.y +' Personas';
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
		<?php
    }else{
	// Genera Grafica Torta
	?>
	<script language='javascript' src='js/highcharts.js'></script>
	<script type="text/javascript">
		
			var chart;
			var desde = "<?php echo $fechadesde; ?>";
			var hasta = "<?php echo $fechahasta; ?>";
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'grafica',  // Div Contenedor
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: 'Asistencia al Comedor del '+ desde +' hasta el ' + hasta
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +' Personas';
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ (this.y*100/<?php echo $TotalGeneral ?>).toFixed(2) +' %';
								}
							},
							showInLegend: true
						}						
					},
				    series: [{
						type: 'pie',
						name: 'Asistencia al Comedor',
						data: [ <?php echo $grafico; ?> ]
					}]
				});
			});
				
		</script>
	    <?php
	    }
		// Fin Grafica Torta  
	   ?>	
       <script language='javascript'> 
          $('#impresion').show();  // Si se muestra el grafico muestra boton de impresion
	   </script>	     	
	   <?php
	   echo $tabla;
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos	
?>