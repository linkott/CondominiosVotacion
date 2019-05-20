<?php


//mysql
$datahost    = "172.16.0.249";
$datauser    = "jesus";
$datapass    = "jesus123";
$data        = "cuc";


//postgres
$user = 'postgres';
$clave='postgres';
$servidor = 'localhost';
$db = 'comedor';
$port = 5432;
$conex='';

/*

cedula integer NOT NULL, -- Número de Cédula
  apellidos character varying(50), -- Apellidos
  nombre character varying(50), -- Nombres
  fechanacimiento date, -- Fecha de Nacimiento
  fechaingreso date, -- Fecha de Ingreso al CUC
  sexo character varying(1), -- Sexo (F:Femenino, M:Masculino)
  estadocivil character varying(1), -- Estado Civil (S:Soltero, C:Casado, D:Divorciado, V:Viudo, O:Otro)
  direccion character varying(250), -- Dirección de Habitación o Procedencia si tipopersona es Invitado
  telhabitacion character varying(15), -- Teléfono de Habitación
  telcelular character varying(15), -- Teléfono Celular
  unidadadscripcion character varying(50), -- Unidad de Adscripción [ Carrera para Estudiante]
  email character varying(50), -- Dirección Email
  tipopersona character varying(2), -- Tipo de Persona (Relacionado con Tabla TipoPersona)
  idsede integer, -- Identificación de la Sede [Relacionado con la Tabla Sede]
  estatus integer, -- Estatus de la Persona [1:Activo, 0:Inactivo]


CREATE TABLE  `upc`.`alumno` (
  `cedula` int(10) NOT NULL,
  `codigo_estatus_alumno` tinyint(2) NOT NULL default '0',
  `cod_etnia` tinyint(2) NOT NULL default '0',
  `cod_estado` tinyint(4) default '0',
  `cod_municipio` tinyint(4) default '0',
  `cod_parroquia` tinyint(4) default '0',
  `direccion_hab` varchar(250) default NULL,
  `apellidos` varchar(60) default NULL,
  `nombres` varchar(60) NOT NULL default '',
  `sexo` char(1) NOT NULL default '',
  `fecha_nacimiento` date NOT NULL default '0000-00-00',
  `cod_pais` int(3) NOT NULL default '0',
  `lugar_nac` tinyint(3) NOT NULL,
  `nivel_academico` varchar(10) NOT NULL,
  `cod_estado_civil` tinyint(2) default '2',
  `email` varchar(50) default NULL,
  `telef_hab` varchar(11) default '0',
  `telef_celular` varchar(12) default '0',
  `privado_libertad` char(2) NOT NULL default '0',
  `condicion_residencia` char(1) default NULL,
  `discapacidad` char(2) default NULL,
  PRIMARY KEY  (`cedula`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1

*/

$mysql = mysql_connect("$datahost","$datauser","$datapass");
$mysql_select_db = mysql_select_db($data, $mysql);
$consulta= mysql_query("SELECT alumno.cedula,alumno.apellidos,alumno.nombres,alumno.fecha_nacimiento,alumno_ingreso.fecha_ingreso,alumno.sexo,alumno.cod_estado_civil,alumno.direccion_hab,alumno.telef_hab,alumno_trabajo.telefono1,alumno.telef_celular, alumno.email,alumno_detalle_inscripcion.cod_seccion,1 FROM cuc.alumno left join alumno_ingreso on alumno_ingreso.cedula=alumno.cedula left join alumno_trabajo on alumno_trabajo.cedula=alumno.cedula left join alumno_detalle_inscripcion on alumno_detalle_inscripcion.cedula=alumno.cedula left join alumno_inscripcion on alumno_inscripcion.cedula=alumno.cedula where alumno_inscripcion.periodo_inscripcion='2013-I' group by cedula");



$postgres = pg_connect("host=".$servidor." port=".$port." password=".$clave." user=".$user." dbname=".$db." ") or die("ERROR DE CONEXION");


while ($fila=mysql_fetch_array($consulta)){
	$struni = $fila['cod_seccion'];
	if($struni =='42' || $struni =='82' || $struni =='92'){
		$carrera = "TRABAJO SOCIAL";
	}else if($struni =='50' || $struni =='51' ){
		$carrera = "EDUCACIÓN DOC EN EDUC. PREESCOLAR";
	}else{
		$carrera = "No hay";
	}	
	
	if($fila['fecha_nacimiento']=="0000-00-00"){
		$fechana = "1111-11-11";
	}else{
		$fechana = $fila['fecha_nacimiento'];
	}

	if($fila['fecha_ingreso']=="0000-00-00"){
		$fechain = "1111-11-11";
	}else{
		$fechain = $fila['fecha_ingreso'];
	}

	$cedula=$fila['cedula'];
	$apellidos=  utf8_encode($fila['apellidos']);
	$nombre= utf8_encode($fila['nombres']);
	$fechanacimiento=$fechana;
	$fechaingreso=$fechain;
	$sexo=$fila['sexo'];
	$estadocivil=$fila['cod_estado_civil'];
	$direccion=utf8_encode($fila['direccion_hab']);
	$telhabitacion=$fila['telef_hab'];
	//$teltrabajo=$fila['telefono1'];
	$telcelular=$fila['telef_celular'];
	$unidadadscripcion=$carrera;
	$email=$fila['email'];
	$tipopersona="07";
	$idsede="1";
	$estatus ="1";

	//echo "INSERT INTO persona (cedula,apellidos,nombre,fechanacimiento,fechaingreso,sexo, estadocivil,direccion,telhabitacion,telcelular,unidadadscripcion,email,tipopersona,idsede,estatus) values ($cedula,'$apellidos','$nombre','$fechanacimiento','$fechaingreso','$sexo','$estadocivil','$direccion','$telhabitacion','$telcelular','$unidadadscripcion','$email','$tipopersona','$idsede','$activo');";

	echo "INSERT INTO persona (cedula,apellidos,nombre,fechanacimiento,fechaingreso,sexo, estadocivil,direccion,telhabitacion,telcelular,unidadadscripcion,email,tipopersona,idsede,estatus) values ($cedula,'$apellidos','$nombre','$fechanacimiento','$fechaingreso','$sexo','$estadocivil','$direccion','$telhabitacion','$telcelular','$unidadadscripcion','$email','$tipopersona','$idsede','$estatus');";
	
	pg_query("INSERT INTO persona (cedula,apellidos,nombre,fechanacimiento,fechaingreso,sexo, estadocivil,direccion,telhabitacion,telcelular,unidadadscripcion,email,tipopersona,idsede,estatus) values ($cedula,'$apellidos','$nombre','$fechanacimiento','$fechaingreso','$sexo','$estadocivil','$direccion','$telhabitacion','$telcelular','$unidadadscripcion','$email','$tipopersona','$idsede','$estatus');");

}
?>
