<?php
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
include('class/class.ezpdf.php');
session_start();
if (isset($_SESSION['xcedula'])){
   $xcedula=$_SESSION['xcedula'];
   $Afiliado=$_SESSION['afiliado'];    	  
}else {
   $xcedula="";	
}
$titulo =utf8_decode($_POST['Titulo']);
$observaciones=utf8_decode($_POST['Observaciones']);
$desde=$_POST['desde'];
$hasta=$_POST['hasta'];
$genero=$_POST['genero'];
$idmenu=$_POST['TipoMenu'];

switch($_POST['TipoMenu']){
    case 1:
	   $tipomenu="Desayuno";
	   break;
	case 2:
	   $tipomenu="Almuerzo";
	   break;
	case 3:
	   $tipomenu="Cena";
	   break;
	case 4:
	   $tipomenu="Todos";
	   break;
}	
     
$Persona = new AdministradorBd();

$cnn = $Persona->conectaBd();

if($tipomenu=="Todos"){
	$SQL ="SELECT * FROM crosstab('SELECT tipopersona.descripcion::text AS descripcion, persona.sexo::text,
		   Count(transaccion.cedula)::text AS cantidad FROM (transaccion INNER JOIN persona ON transaccion.cedula=persona.cedula)
		   INNER JOIN tipopersona ON persona.tipopersona=tipopersona.idtipo WHERE (((transaccion.fechatransaccion)>='$desde' And (transaccion.fechatransaccion)<='$hasta'))
		   GROUP BY tipopersona.descripcion, tipopersona.idtipo, persona.sexo ORDER BY tipopersona.descripcion, tipopersona.idtipo, persona.sexo') AS ct(descripcion text, femenino text, masculino text);";	                    
}else{
	$SQL="SELECT * FROM crosstab('SELECT tipopersona.descripcion::text AS descripcion, persona.sexo::text,
  		  Count(transaccion.cedula)::text AS cantidad FROM (transaccion INNER JOIN persona ON transaccion.cedula=persona.cedula)
		  INNER JOIN tipopersona ON persona.tipopersona=tipopersona.idtipo WHERE (((transaccion.fechatransaccion)>='$desde' And (transaccion.fechatransaccion)<='$hasta' And (transaccion.idhora)=$idmenu))
		  GROUP BY tipopersona.descripcion, tipopersona.idtipo, persona.sexo ORDER BY tipopersona.descripcion, tipopersona.idtipo, persona.sexo') AS ct(descripcion text, femenino text, masculino text);";	 
}
	   
$result=$Persona->ejecutaQuery($SQL); //Ejecuta el Query en la Base de Datos	

$Formato = new Formato();

$pdf =& new Cezpdf('letter');
$pdf->selectFont('fonts/Helvetica.afm');
$pdf->ezSetMargins(30, 30, 50, 30); //Margenes de la Hoja
$datacreator = array (
					'Title'=>'Reporte de Resultados',
					'Author'=>'Francisco Montilla',
					'Subject'=>'Reporte de Resultados',
					'Creator'=>'franco01@hotmail.com',
					'Producer'=>''
					);
$pdf->addInfo($datacreator);

$TotalGeneral=0;
$TotalFemenino=0;
$TotalMasculino=0;
while($row = $Persona->obtieneRegistro($result)) {   
   // Si hay algun renglon vacio le asigna cero (0)
   if($genero=="Activado"){ // Si se selecciono el genero para el reporte
		if($row['femenino']==''){
		   $row['femenino']=0;
		}
		if($row['masculino']==''){
		  $row['masculino']=0;
		}
		$data[] = array('Descripcion'=>$row['descripcion'],'Femenino'=>$row['femenino'],'Masculino'=>$row['masculino'],'Total'=>$row['masculino'] + $row['femenino']);    
		$TotalFemenino+=$row['femenino'];
		$TotalMasculino+=$row['masculino']; 
   }else{
        $data[] = array('Descripcion'=>$row['descripcion'],'Total'=>$row['masculino'] + $row['femenino']);    
   }   
   $TotalGeneral+=$row['femenino']+$row['masculino'];
} 
// añade totales generales al arreglo

if($genero=="Activado"){ //Si se selecciono el genero para el reporte
	$data[] = array('Descripcion'=>'Total General','Femenino'=>$TotalFemenino,'Masculino'=>$TotalMasculino,'Total'=>$TotalGeneral);

	$options=array('shadeCol'=>array(0.9,0.9,0.9), 'shaded'=>1,
               'fontSize'=>9, 'showLines'=>2, 
               'cols'=>array('Descripcion'=>array('width'=>100),
							 'Femenino'=>array('width'=>100, 'justification'=>'center'),
							 'Masculino'=>array('width'=>100, 'justification'=>'center'),
							 'Total'=>array('width'=>100, 'justification'=>'center')));
	$titles = array('Descripcion'=>'<b>Descripción</b>', 'Femenino'=>'<b>Femenino</b>', 'Masculino'=>'<b>Masculino</b>', 'Total'=>'<b>Total</b>');
}else{
    $data[] = array('Descripcion'=>'Total General','Total'=>$TotalGeneral);

	$options=array('shadeCol'=>array(0.9,0.9,0.9), 'shaded'=>1,
               'fontSize'=>9, 'showLines'=>2, 
               'cols'=>array('Descripcion'=>array('width'=>100),							 
							 'Total'=>array('width'=>100, 'justification'=>'center')));
	$titles = array('Descripcion'=>'<b>Descripción</b>', 'Total'=>'<b>Total</b>');
}	
$pdf->ezImage('images/logocuc.jpg',0, 70, '70', 'left');
$pdf->ezSetY(770); //Posicion el Cursor en el margen superior requerido 760 Carta, 780 Oficio

$pdf->ezText("<b>Ministerio del Poder Popular para la Educación Universitaria</b>",12,array('justification'=>'center'));
$pdf->ezText("<b>Colegio Universitario de Caracas</b>",12,array('justification'=>'center'));
$pdf->ezText("<b>Comedor - Tipo de Menú: ".$tipomenu."</b>\n",10,array('justification'=>'center'));
$pdf->ezSetY(770);
$pdf->ezText('Fecha:'.date('d/m/Y'),9,array('justification'=>'right'));
$pdf->ezText('Hora:'.date('h:i:s a'),9,array('justification'=>'right'));
$pdf->ezSetY(700);
$pdf->ezText("<u><b>".$titulo."</b></u>\n",11,array('justification'=>'center'));
$pdf->ezText("");
$pdf->ezTable($data,$titles,'',$options ); // En las comillas se puede colocar el titulo de la tabla
$pdf->ezText("");
$pdf->ezText("");
$pdf->ezText("<u><b>Observaciones:</b></u>\n".$observaciones,11,array('justification'=>'full'));
$pdf->ezStartPageNumbers(570,28,8,'','Página: {PAGENUM} de {TOTALPAGENUM}',1); // numera las páginas
$pdf->line(20,40,578,40); // Crea Linea antes del pie de página
$pdf->ezStream();

$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos	
?>

