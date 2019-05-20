<?php
session_start();
if (isset($_SESSION['idusuario'])){ // Captura el Usuario Actual
   $idusuario=$_SESSION['idusuario']; 
}

include_once("class/ManejadorBD.class");

$cedula=$_POST['xCedula'];
$fechatransaccion=date("Y-m-d"); //Captura Fecha Actual
$horatransaccion=date("H:i:s"); // Captura Hora Actual

//Captura la Sede
/*if (file_exists("sede.txt")){  // Si existe el archivo 
    // Linux
	//$archivo=fopen("~/.sede.txt","r");
	// Windows
	//$archivo=fopen("sede.txt","r");
	//$idsede=fgets($archivo);
	//fclose($archivo);
	//echo "La Sede: ".$idsede;
}*/
$idsede=1;

$Persona = new AdministradorBd();

$cnn=$Persona->conectaBd();
if (!$cnn) { // Si la Conexion  Falla
   $Persona->controlError(1);
   exit();
}
// Determina en que menu del dia se esta actualmente, desayuno, almuerzo o cena
$Consulta=$Persona->ejecutaQuery("select * from hora where '$horatransaccion' between horainicio and horafin");
if ($Persona->cuentaRegistro($Consulta) > 0){
    $Fila = $Persona->obtieneRegistro($Consulta);
	$idhora = $Fila['idhora'];
	$tipoMenu = $Fila['descripcion'];
	$HoraInicio = $Fila['horainicio'];
	$HoraFin = $Fila['horafin'];
}else{    
    ?> 
   <script language='javascript'>
          $("#mensaje").text("Actualmente no hay un periodo abierto, No puede Registrar !");
		  $("#dialog-message").dialog( "option", "title", "Registrar Transacci\363n" );
          $("#dialog-message").dialog('open');          		  
   </script>
   <?php 
   exit();   
}	

//Determina el Tipo de Persona para establecer el valor de autorizado true o false
$Consulta=$Persona->ejecutaQuery("select tipopersona from persona where cedula=$cedula");
$Fila = $Persona->obtieneRegistro($Consulta);
$TipoPersona = $Fila['tipopersona'];
if ($TipoPersona == '08'){ // Invitado
    $autorizado='true';
}else{
    $autorizado='false';
}

// Verifica si ya existe algun registro en transaccion
$Consulta=$Persona->ejecutaQuery("select horatransaccion from transaccion where cedula='$cedula' and fechatransaccion ='$fechatransaccion' order by fechatransaccion, horatransaccion desc "); // Obtiene el ultimo registro de la Persona en transaccion
    $total = $Persona->cuentaRegistro($Consulta);  
   if($total == 0)
    {
    	$desc = "Entrada";
    }else 
    {
    	$desc = "Salida";
    }
if ($Persona->cuentaRegistro($Consulta) > 0){
    $Fila = $Persona->obtieneRegistro($Consulta);

 
	//if ($Fila['horatransaccion'] >= $HoraInicio and $Fila['horatransaccion'] <= $HoraFin){
		if ($total >= 2){
	?> 
     <script language='javascript'>
          //$("#mensaje").text("Ya existe un registro en " +'<?php echo $tipoMenu ?>'+ " para esta persona, No puede Ingresar !");
		  $("#mensaje").text("El usuario ya posee los dos registro entrada/salida  !");
		  $("#dialog-message").dialog( "option", "title", "Registrar Transacci\363n" );
          $("#dialog-message").dialog('open');          		  
    </script>
    <?php 
	exit();
	}else{
	   $Consulta= $Persona->ejecutaQuery("insert into transaccion (cedula, fechatransaccion, horatransaccion, idhora, autorizado, idsede, idusuario,descripcion) values($cedula,'$fechatransaccion','$horatransaccion', $idhora, $autorizado, $idsede, '$idusuario','$desc')"); //Ejecuta el Query en la Base de Datos	 	 
	   if (!$Consulta){
          $Persona->controlError(2);
          exit();
       } else {
          ?> 
			<script language='javascript'>
			    $("#ccontador").html("<span>Total Procesados: "+<?php echo $TotalRegistros+1 ?>+"</span>");
				/*$("#mensaje").text("Los datos fueron ingresados correctamente !");
				$("#dialog-message").dialog( "option", "title", "Registrar Transacci\363n" );
				$("#dialog-message").dialog('open');          		  */
				$('#result').load('BuscaPersona.php');	                    				
                $('#tabs').tabs('load', 'Tab-Ingreso');
			</script>
		  <?php    
	   }
	}
}else{
    $Consulta= $Persona->ejecutaQuery("insert into transaccion (cedula, fechatransaccion, horatransaccion, idhora, autorizado, idsede, idusuario,descripcion) values($cedula,'$fechatransaccion','$horatransaccion', $idhora, $autorizado, $idsede, '$idusuario','$desc')"); //Ejecuta el Query en la Base de Datos	 	 
	if (!$Consulta){
       $Persona->controlError(2);
       exit();
    } else {
        ?> 
			<script language='javascript'>
			    $("#ccontador").html("<span>Total Procesados: "+<?php echo $TotalRegistros+1 ?>+"</span>");
				/*$("#mensaje").text("Los datos fueron ingresados correctamente !");
				$("#dialog-message").dialog( "option", "title", "Registrar Transacci\363n" );
				$("#dialog-message").dialog('open');          		  */
				$('#result').load('BuscaPersona.php');	                    				
                $('#tabs').tabs('load', 'Tab-Ingreso');
			</script>
		<?php    
	}
}  
$Persona->cierraConexionBd($cnn); //Cierra la conexion con la Base de Datos
?>
