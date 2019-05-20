<?php
session_start();
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
include('class/class.ezpdf.php');
function encabezadoPagina($xpdf, $xfechadesde, $xfechahasta, $xtipo){
    $xpdf->ezImage('images/logocuc.jpg',0, 70, '70', 'left'); 
    $xpdf->ezSetY(765); //Posicion el Cursor en el margen superior requerido 760 Carta, 780 Oficio
	$xpdf->ezText("<b>Colegio Universitario de Caracas</b>",12,array('justification'=>'center'));
	$xpdf->ezText("<b>Control de Comedor</b>",12,array('justification'=>'center'));
	$xpdf->ezText("<b>Reporte de Sugerencias y Reclamos sobre ".$xtipo."</b>",11,array('justification'=>'center'));
	$xpdf->ezText("<b>desde: ".$xfechadesde." "."hasta: ".$xfechahasta."</b>\n",11,array('justification'=>'center'));
	$xpdf->line(123,700,505,700);
    $xpdf->ezText("");
	$xpdf->ezSetY(765);
	$xpdf->ezText('Fecha:'.date('d/m/Y'),9,array('justification'=>'right'));
	$xpdf->ezText('Hora:'.date('h:i:s a'),9,array('justification'=>'right'));
	$xpdf->ezSetY(690);
}
function piePagina($xpdf){     
    $xpdf->line(20,40,578,40); // Crea Linea antes del pie de página
}
$fechadesde = stripslashes($_GET['fechadesde']);
$fechahasta = stripslashes($_GET['fechahasta']);
$tipo = $_GET['tipo'];
$orden = $_GET['orden'];

switch($tipo){
    case '1':
	   $xtipo="Sitio Web";
	   break;
	case '2':
	   $xtipo="Atenci&oacute;n";
	   break;
	case '3':
	   $xtipo="Servicio";
	   break;
	case '4':
	   $xtipo="Horario";
	   break;
}	
	
$Persona = new AdministradorBd();
$Formato = new Formato();

$cnn = $Persona->conectaBd();

//$Formato = new Formato();

$pdf = new Cezpdf('letter', 'portrait'); // Tipo Carta vertical
$pdf->selectFont('fonts/Helvetica.afm');
$pdf->ezSetMargins(30, 30, 50, 30); //Margenes de la Hoja
$datacreator = array (
					'Title'=>'Reporte de Sugerencias y Reclamos',
					'Author'=>'Francisco Montilla',
					'Subject'=>'Reporte de Sugerencias y Reclamos',
					'Creator'=>'franco01@hotmail.com',
					'Producer'=>''
					);
$pdf->addInfo($datacreator);

$options=array('shadeCol'=>array(0.9,0.9,0.9),
               'fontSize'=>9,
               'cols'=>array('Nombre'=>array('width'=>180,'justification'=>'center'),
							 'Nº'=>array('justification'=>'center'),
							 'Comentario'=>array('justification'=>'center','width'=>150),
							 'Email'=>array('justification'=>'center'),
							 'Fecha'=>array('justification'=>'center')
							 ));
$titles = array('Nº'=>'<b>Nº</b>', 'Cedula'=>'<b>Cédula</b>', 'Nombre'=>'<b>Nombre y Apellidos</b>', 'Comentario'=>'<b>Comentario</b>', 'Email'=>'<b>Email</b>', 'Fecha'=>'<b>Fecha Registro</b>');

$pdf->ezStartPageNumbers(570,28,8,'','Página: {PAGENUM} de {TOTALPAGENUM}'); // numera las páginas al final

$Sql="select sugerencia.cedula, fecharegistro, sugerencia.email, comentario, nombre || ' ' || apellidos as nombrecompleto from sugerencia inner join persona on sugerencia.cedula = persona.cedula
      WHERE sugerencia.fecharegistro >= '$fechadesde' AND sugerencia.fecharegistro <= '$fechahasta' AND sugerencia.tipo='$tipo' order by $orden"; 

$result=$Persona->ejecutaQuery($Sql); //Ejecuta el Query en la Base de Datos	

$count = $Persona->cuentaRegistro($result); //  Obtiene el numero total de registros para determinar el numero de páginas.

//$pdf->ezText($fechadesde." ".$fechahasta." ".$tipo." ".$orden);

$limit = 40; // Registros por Pagina a Mostrar

if( $count > 0 ){ // calcula la cantidad de paginas por total registros
   $total_pages = ceil($count/$limit);
} else { 
   $total_pages = 0;
} 

//if ($page > $total_pages) $page=$total_pages;
$i=1; 
for($page=1;$page<=$total_pages;$page++){ //Ciclo con cantidad de paginas total del reporte
    
	encabezadoPagina($pdf, $fechadesde, $fechahasta, $xtipo);
		
	$start = $limit*$page - $limit;  // Numero de registro del cual comienza

    $SQL = $Sql." LIMIT $limit OFFSET $start";   		

    $result=$Persona->ejecutaQuery($SQL); //Ejecuta el Query en la Base de Datos	

    //$num=$page; //Paginador de EzPdf

    while($row = $Persona->obtieneRegistro($result)) {
         $data[] = array('Nº'=>$i,'Cedula'=>$row['cedula'],'Nombre'=>utf8_decode($row['nombrecompleto']),'Comentario'=>utf8_decode($row['comentario']),'Email'=>$row['email'],'Fecha'=>$Formato->cambiaFecha($row['fecharegistro']));    
         $i++;
    } 
    
   	$pdf->ezTable($data,$titles,'',$options ); // En las comillas se puede colocar el titulo de la tabla
	
	$data=array(); // blanquea el arreglo luego de mostarlo
	
	piePagina($pdf);	
	
	if ($total_pages != $page){ // si ya genero la ultima pagina no crea una nueva
	   $pdf->ezNewPage();
	}	
}

$pdf->ezStream();

$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos	
?>

