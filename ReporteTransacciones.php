<?php
session_start();
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
include('class/class.ezpdf.php');
function encabezadoPagina($xpdf, $xfechadesde, $xfechahasta, $xtipomenu, $xtipoconsulta){
    $xpdf->ezImage('images/logocuc.jpg',0, 70, '70', 'left'); 
    $xpdf->ezSetY(775); //Posicion el Cursor en el margen superior requerido 760 Carta, 780 Oficio
	$xpdf->ezText("<b>Sistema de registros</b>",12,array('justification'=>'center'));
	$xpdf->ezText("<b>Asistencia a Votación</b>",12,array('justification'=>'center'));
	if ($xtipoconsulta == 1){
	    $xpdf->ezText("<b>Reporte Detallado de Registros desde: ".$xfechadesde." "."hasta: ".$xfechahasta."</b>\n",11,array('justification'=>'center'));
	}else{
        $xpdf->ezText("<b>Reporte Detallado de Autorizaciones desde: ".$xfechadesde." "."hasta: ".$xfechahasta."</b>\n",11,array('justification'=>'center'));
	}	
	//$xpdf->ezText("<b>Tipo de Menú: ".$xtipomenu."</b>",11,array('justification'=>'center'));
	if ($xtipoconsulta == 1){
	    $xpdf->line(135,730,505,730);
	}else{
	    $xpdf->line(123,730,505,730);
    }	
	$xpdf->ezText("");
	$xpdf->ezSetY(775);
	$xpdf->ezText('Fecha:'.date('d/m/Y'),9,array('justification'=>'right'));
	$xpdf->ezText('Hora:'.date('h:i:s a'),9,array('justification'=>'right'));
	$xpdf->ezSetY(690);
}
function piePagina($xpdf){     
    $xpdf->line(20,40,578,40); // Crea Linea antes del pie de p�gina
}
$fechadesde = stripslashes($_GET['fechadesde']);
$fechahasta = stripslashes($_GET['fechahasta']);
$idmenu = $_GET['idmenu'];
$orden = $_GET['orden'];
$TipoConsulta = $_GET['tipoconsulta']; //1:Detalle de Registros, 2:Autorizaciones

switch($idmenu){
    case 1:
	   $tipomenu="SI";
	   break;
	case 2:
	   $tipomenu="NO";
	   break;
	case 4:
	   $tipomenu="Todos";
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
					'Title'=>'Reporte Detallado de Registros',
					'Author'=>'Richard Restrepo',
					'Subject'=>'Reporte de Transacciones',
					'Creator'=>'linkott@gmail.com',
					'Producer'=>''
					);
$pdf->addInfo($datacreator);

$options=array('shadeCol'=>array(0.9,0.9,0.9),
               'fontSize'=>9,
               'cols'=>array('Apellidos'=>array('width'=>110),
							 'Nombre'=>array('width'=>110),
							 'N'=>array('justification'=>'center'),
							 'FechaRegistro'=>array('justification'=>'center'),
							 'HoraRegistro'=>array('justification'=>'center'),
							'HoraRegistro2'=>array('justification'=>'center'),
							'eleccion'=>array('justification'=>'center')
							 ));
$titles = array('N'=>'<b>N</b>', 'Cedula'=>'<b>Cedula</b>', 'Apellidos'=>'<b>Apellidos</b>', 'Nombre'=>'<b>Nombre</b>', 'FechaRegistro'=>'<b>Fecha  Entrada</b>', 'HoraRegistro'=>'<b>Hora  Entrada</b>','Eleccion'=>'<b>Voto</b>');

$pdf->ezStartPageNumbers(570,28,8,'','Página: {PAGENUM} de {TOTALPAGENUM}'); // numera las páginas al final

if ($TipoConsulta == 1) {
	$Sql="SELECT transaccion.cedula, fechatransaccion, horatransaccion, nombre, apellidos ,fechatransaccion2, horatransaccion2,eleccion
		 FROM transaccion INNER JOIN persona ON transaccion.cedula = persona.cedula
	     WHERE transaccion.fechatransaccion >= '$fechadesde' AND transaccion.fechatransaccion <= '$fechahasta'
         AND transaccion.idhora=$idmenu order by $orden";
}else{
    $Sql="SELECT transaccion.cedula, fechatransaccion, horatransaccion, nombre, apellidos ,fechatransaccion2,horatransaccion2 ,eleccion	
		  FROM transaccion INNER JOIN persona ON transaccion.cedula = persona.cedula
	      WHERE transaccion.fechatransaccion >= '$fechadesde' AND transaccion.fechatransaccion <= '$fechahasta'
          AND transaccion.idhora=$idmenu AND autorizado=true order by $orden";  
}	  

$result=$Persona->ejecutaQuery($Sql); //Ejecuta el Query en la Base de Datos	

$count = $Persona->cuentaRegistro($result); //  Obtiene el numero total de registros para determinar el numero de p�ginas.

$limit = 40; // Registros por Pagina a Mostrar

if( $count > 0 ){ // calcula la cantidad de paginas por total registros
   $total_pages = ceil($count/$limit);
} else { 
   $total_pages = 0;
} 

//if ($page > $total_pages) $page=$total_pages;
$i=1; 
for($page=1;$page<=$total_pages;$page++){ //Ciclo con cantidad de paginas total del reporte
    
	encabezadoPagina($pdf, $fechadesde, $fechahasta, $tipomenu, $TipoConsulta);
		
	$start = $limit*$page - $limit;  // Numero de registro del cual comienza

    $SQL = $Sql." LIMIT $limit OFFSET $start";   		

    $result=$Persona->ejecutaQuery($SQL); //Ejecuta el Query en la Base de Datos	

    //$num=$page; //Paginador de EzPdf

    while($row = $Persona->obtieneRegistro($result)) {
         $data[] = array('N'=>$i,'Cedula'=>$row['cedula'],'Apellidos'=>utf8_decode($row['apellidos']),'Nombre'=>utf8_decode($row['nombre']),'FechaRegistro'=>$Formato->cambiaFecha($row['fechatransaccion']),'HoraRegistro'=>$Formato->cambiaHora($row['horatransaccion']),'Eleccion'=>$row['eleccion']);    
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

