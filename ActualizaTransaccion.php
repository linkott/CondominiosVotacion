<?php
session_start();
if (isset($_SESSION['idusuario'])){ // Captura el Usuario Actual
   $idusuario=$_SESSION['idusuario']; 
}

include_once("class/ManejadorBD.class");

$cedula=$_POST['xCedula'];
if($_POST['xEleccionSI']){
	$eleccion="SI";
}elseif($_POST['xEleccionNO']){
	$eleccion="NO";	
}else{$eleccion=null;}

$fechatransaccion=date("Y-m-d"); //Captura Fecha Actual
$horatransaccion=date("H:i:s"); // Captura Hora Actual
$idsede=1;

$Persona = new AdministradorBd();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}
// Determina 
$Consulta=$Persona->ejecutaQuery("SELECT * FROM hora WHERE '$horatransaccion' BETWEEN horainicio AND horafin");
if ($Persona->cuentaRegistro($Consulta) > 0){
    $Fila = $Persona->obtieneRegistro($Consulta);
	$idhora = $Fila['idhora'];
	$tipoMenu = $Fila['descripcion'];
	$HoraInicio = $Fila['horainicio'];
	$HoraFin = $Fila['horafin'];
	if($idhora==2){
		?> 
		<script language='javascript'>
			   $("#mensaje").text("El Sistema esta en horario de mantenimiento !");
			   $("#dialog-message").dialog( "option", "title", "Registrar Transacci\363n" );
			   $("#dialog-message").dialog('open');          		  
		</script>
		<?php 
	}
}else{    
    ?> 
   <script language='javascript'>
          $("#mensaje").text("Actualmente no hay un periodo te atención, No puede Registrar !");
		  $("#dialog-message").dialog( "option", "title", "Registrar Transacci\363n" );
          $("#dialog-message").dialog('open');          		  
   </script>
   <?php 
   exit();   
}	

//Determina el Tipo de Persona para establecer el valor de autorizado true o false
$Consulta=$Persona->ejecutaQuery("SELECT tipopersona FROM persona WHERE cedula=$cedula");
$Fila = $Persona->obtieneRegistro($Consulta);
$TipoPersona = $Fila['tipopersona'];
if ($TipoPersona != '08'){ // Invitado
    $autorizado='true';
}else{
    $autorizado='false';
}

// Verifica si ya existe algun registro en transaccion
$Consulta=$Persona->ejecutaQuery("SELECT horatransaccion FROM transaccion WHERE cedula='$cedula' and fechatransaccion ='$fechatransaccion' order by fechatransaccion, horatransaccion desc "); // Obtiene el ultimo registro de la Persona en transaccion
	$total = $Persona->cuentaRegistro($Consulta);  
   if($total == 0)
    {
    	$desc = "Primera Entrada";
    }else 
    {
    	$desc = "Usuario Voto";
    }
if ($total > 0 ){
	$Consulta=$Persona->ejecutaQuery("SELECT horatransaccion2 FROM transaccion WHERE cedula='$cedula'  order by fechatransaccion2, horatransaccion2 desc "); // Obtiene el ultimo registro de la Persona en transaccion2
	$Fila = $Persona->obtieneRegistro($Consulta);
	//if ($Fila['horatransaccion'] >= $HoraInicio and $Fila['horatransaccion'] <= $HoraFin){
		if ($Fila['horatransaccion2'] !=""){
	?> 
     <script language='javascript'>
          //$("#mensaje").text("Ya existe un registro en " +'<?php echo $tipoMenu ?>'+ " para esta persona, No puede Ingresar !");
		  $("#mensaje").text("El usuario  ya voto !");
		  $("#dialog-message").dialog( "option", "title", "Registrar Transacci\363n" );
          $("#dialog-message").dialog('open');          		  
    </script>
    <?php 
	}else{
	   $Consulta= $Persona->ejecutaQuery("UPDATE transaccion SET fechatransaccion2 = '$fechatransaccion', horatransaccion2='$horatransaccion',descripcion2 = '$desc',eleccion='$eleccion',autorizado=$autorizado where cedula = $cedula  AND fechatransaccion = '$fechatransaccion'"); //Ejecuta el Query en la Base de Datos	 	 
	   if (!$Consulta){
          $Persona->controlError(2);
          exit();
       	}else {
          ?> 
			<script language='javascript'>
				$("#mensaje").text("Su votacion : "+'<?php echo $eleccion ?>');
				$("#dialog-message").dialog( "option", "title", "Registrar Transacci\363n" );
				$("#dialog-message").dialog('open');          		  
				//$('#result').load('BuscaPersona.php');	                    				
                //$('#tabs').tabs('load', 'Tab-Ingreso');
			</script>
		  <?php    
	   	}
	}
}else{
    $Consulta= $Persona->ejecutaQuery("INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora,autorizado) VALUES ($cedula,'$fechatransaccion','$horatransaccion', $idhora,$autorizado)"); //Ejecuta el Query en la Base de Datos	old : $autorizado, $idsede, '$idusuario','$desc' 	 
	if (!$Consulta){
       $Persona->controlError(2);
       exit();
    } else {
        ?> 
			<script language='javascript'>
			 $('#result').load('BuscaPersona.php');
			</script>
		<?php   
	}
}  
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
