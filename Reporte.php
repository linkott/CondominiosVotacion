<?php
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
include('class/class.ezpdf.php');
session_start();
if (isset($_SESSION['xcedula'])){
   $xcedula=$_SESSION['xcedula'];  	  
}else {
   $xcedula="";	
}
$titulo=utf8_decode($_POST['Titulo']);
$observaciones=utf8_decode($_POST['Observaciones']);
$desde=stripslashes($_POST['desde']);
$hasta=stripslashes($_POST['hasta']);
$tipoconsulta=$_POST['tipoconsulta'];
$sede=$_POST['sede'];
$idmenu=$_POST['tipomenu'];

switch($idmenu){
    case 1:
	   $tipomenu="Servicion de Votacion";
	   break;
	case 2:
	   $tipomenu="Servicio de condominio";
	   break;
	case 4:
	   $tipomenu="Todos";
	   break;
}	
     
$Persona = new AdministradorBd();

$cnn = $Persona->conectaBd();

if ($tipoconsulta == 'Genero'){	
	if($tipomenu=="Todos"){
		$SQL ="SELECT * FROM crosstab('SELECT hora.descripcion::text AS descripcion, persona.sexo::text,
			   Count(transaccion.cedula)::text AS cantidad FROM (transaccion INNER JOIN persona ON transaccion.cedula=persona.cedula)
			   INNER JOIN hora ON transaccion.idhora=hora.idhora WHERE (((transaccion.fechatransaccion)>='$desde' And (transaccion.fechatransaccion)<='$hasta'))
			   GROUP BY hora.descripcion, hora.idhora, persona.sexo ORDER BY  hora.idhora, hora.descripcion, persona.sexo') AS ct(descripcion text, femenino text, masculino text);";	                    
	}else{
		$SQL="SELECT * FROM crosstab('SELECT hora.descripcion::text AS descripcion, persona.sexo::text,
			  Count(transaccion.cedula)::text AS cantidad FROM (transaccion INNER JOIN persona ON transaccion.cedula=persona.cedula)
			  INNER JOIN hora ON hora.idhora=transaccion.idhora WHERE (((transaccion.fechatransaccion)>='$desde' And (transaccion.fechatransaccion)<='$hasta' And (transaccion.idhora)=$idmenu))
			  GROUP BY hora.descripcion, hora.idhora, persona.sexo ORDER BY  hora.idhora, hora.descripcion, persona.sexo') AS ct(descripcion text, femenino text, masculino text);";	 
	}
}else{
    if ($idmenu=="4"){ // Todos
	    $SQL="SELECT * FROM crosstab('SELECT to_char(transaccion.fechatransaccion,''D'')::text AS dia, hora.idhora::int AS descripcion, 
              count(transaccion.cedula)::int AS cantidad FROM transaccion INNER JOIN hora ON transaccion.idhora=hora.idhora WHERE (((transaccion.fechatransaccion)>='$desde' And (transaccion.fechatransaccion)<='$hasta'))
              GROUP BY to_char(transaccion.fechatransaccion,''D''), hora.idhora ORDER BY to_char(transaccion.fechatransaccion,''D''),hora.idhora', 'select m from generate_series(1,3) m') AS (dia text, desayuno int, almuerzo int, cena int);";	 
    }else{
		$SQL="SELECT * FROM crosstab('SELECT to_char(transaccion.fechatransaccion,''D'')::text AS dia, hora.idhora::int AS descripcion, 
              count(transaccion.cedula)::int AS cantidad FROM transaccion INNER JOIN hora ON transaccion.idhora=hora.idhora WHERE (((transaccion.fechatransaccion)>='$desde' And (transaccion.fechatransaccion)<='$hasta' And (transaccion.idhora)=$idmenu))
              GROUP BY to_char(transaccion.fechatransaccion,''D''), hora.idhora ORDER BY to_char(transaccion.fechatransaccion,''D''),hora.idhora', 'select m from generate_series(1,3) m') AS (dia text, desayuno int, almuerzo int, cena int);";	 
	}    
}		   
$result=$Persona->ejecutaQuery($SQL); //Ejecuta el Query en la Base de Datos	

if(!$result){
  echo "Error en el Query";
  exit();
}

$Formato = new Formato();

$pdf = new Cezpdf('letter');
$pdf->selectFont('fonts/Helvetica.afm');
$pdf->ezSetMargins(30, 30, 50, 30); //Margenes de la Hoja
$datacreator = array (
					'Title'=>'Reporte de Resultados',
					'Author'=>'Richard Rstrepo',
					'Subject'=>'Reporte de Resultados',
					'Creator'=>'linkott@gmail.com',
					'Producer'=>''
					);
$pdf->addInfo($datacreator);

if ($tipoconsulta == 'Genero'){	
	$TotalGeneral=0;
	$TotalFemenino=0;
	$TotalMasculino=0;
	while($row = $Persona->obtieneRegistro($result)) {   
	   // Si hay algun renglon vacio le asigna cero (0)   
			if($row['femenino']==''){
			   $row['femenino']=0;
			}
			if($row['masculino']==''){
			  $row['masculino']=0;
			}
			$data[] = array('Descripcion'=>$row['descripcion'],'Femenino'=>$row['femenino'],'Masculino'=>$row['masculino'],'Total'=>$row['masculino'] + $row['femenino']);    
			$TotalFemenino+=$row['femenino'];
			$TotalMasculino+=$row['masculino']; 
	   
	   $TotalGeneral+=$row['femenino']+$row['masculino'];
	} 
	// a�ade totales generales al arreglo

		$data[] = array('Descripcion'=>'Total General','Femenino'=>$TotalFemenino,'Masculino'=>$TotalMasculino,'Total'=>$TotalGeneral);

		$options=array('shadeCol'=>array(0.9,0.9,0.9), 'shaded'=>1,
				   'fontSize'=>9, 'showLines'=>2, 
				   'cols'=>array('Descripcion'=>array('width'=>100, 'justification'=>'center'),
								 'Femenino'=>array('width'=>100, 'justification'=>'center'),
								 'Masculino'=>array('width'=>100, 'justification'=>'center'),
								 'Total'=>array('width'=>100, 'justification'=>'center')));
		$titles = array('Descripcion'=>'<b>Descripci�n</b>', 'Femenino'=>'<b>Femenino</b>', 'Masculino'=>'<b>Masculino</b>', 'Total'=>'<b>Total</b>');
}else{
    $TotalGeneral=0;
    $TotalSI=0;
    $TotalNO=0;		
	$Cont=1;  
	while($row = $Persona->obtieneRegistro($result)) {   
	   // Si hay algun renglon vacio le asigna cero (0)   
			if (is_null($row['SI'])){
				$row['SI']=0;
			}
			if (is_null($row['NO'])){
				$row['NO']=0;
			}
			switch($row['dia']){ // Construye Data para el Grafico
				case "2": //Lunes				       
					$diasemana="Lunes";
					break;
				case "3": //Martes				       
					$diasemana="Martes";
					break;
				case "4": //Miercoles				       
					$diasemana="Mi�rcoles";
					break;
				case "5": //Jueves				       
					$diasemana="Jueves";
					break;				
				case "6": // Viernes				       
					$diasemana="Viernes";
					break;				  
			} 
			$data[] = array('Descripcion'=>$diasemana,'SI'=>$row['SI'],'NO'=>$row['NO'],'Total'=>$row['SI'] + $row['NO']);    
			$TotalSI+=$row['SI'];
			$TotalNO+=$row['NO']; 
			$TotalGeneral+=$row['SI']+$row['NO'];	   
	} 
	// a�ade totales generales al arreglo

		$data[] = array('Descripcion'=>'Total General','SI'=>$TotalSI,'Almuerzo'=>$TotalNO,'Total'=>$TotalGeneral);

		$options=array('shadeCol'=>array(0.9,0.9,0.9), 'shaded'=>1,		           
				   'fontSize'=>9, 'showLines'=>2, 
				   'cols'=>array('Descripcion'=>array('width'=>100, 'justification'=>'center'),
								 'SI'=>array('width'=>100, 'justification'=>'center'),
								 'NO'=>array('width'=>100, 'justification'=>'center'),
								 'Total'=>array('width'=>100, 'justification'=>'center')));
		$titles = array('Descripcion'=>'<b>Descripci�n</b>', 'SI'=>'<b>SI</b>', 'NO'=>'<b>NO</b>','Total'=>'<b>Total</b>');
}
$pdf->ezImage('images/logo.jpg',0, 70, '70', 'left');
$pdf->ezSetY(770); //Posicion el Cursor en el margen superior requerido 760 Carta, 780 Oficio

$pdf->ezText("<b>Sistema de Votacion</b>",12,array('justification'=>'center'));
$pdf->ezText("<b>Quorum</b>",12,array('justification'=>'center'));
$pdf->ezText("<b>Tipo de Servicio: ".$tipomenu."</b>\n",10,array('justification'=>'center'));
$pdf->ezSetY(770);
$pdf->ezText('Fecha:'.date('d/m/Y'),9,array('justification'=>'right'));
$pdf->ezText('Hora:'.date('h:i:s a'),9,array('justification'=>'right'));
$pdf->ezSetY(700);
$pdf->ezText("<u><b>".$titulo."</b></u>\n",11,array('justification'=>'center'));
$pdf->ezText("");
$pdf->ezTable($data,$titles,'',$options); // En las comillas se puede colocar el titulo de la tabla
$pdf->ezText("");
$pdf->ezText("");
if ($observaciones != ''){
    $pdf->ezText("<u><b>Observaciones:</b></u>\n".$observaciones,11,array('justification'=>'full'));
}	
$pdf->ezStartPageNumbers(570,28,8,'','P�gina: {PAGENUM} de {TOTALPAGENUM}',1); // numera las p�ginas
$pdf->line(20,40,578,40); // Crea Linea antes del pie de p�gina
$pdf->ezStream();

$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos	
?>

