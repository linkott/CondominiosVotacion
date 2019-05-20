<?php
session_start();
$Accion=$_GET['Accion'];
if (isset($_SESSION['xcedula'])){ // Si esta iniciada la Sesion Destruye las Variables para recibir otras   
    if ($Accion =='Destruir'){ // Recibe el Parametro del Boton Cancelar de Actualizacion de Personal
        // Destruye todas las variables de sesión.		
        $_SESSION = array();
	    // Destruye la Sesion
        //session_destroy();
	}	
	echo('<div id="loading"></div><div id="result"></div>');
	echo('<script type="text/javascript">		       
	       $("#result").load("BuscaPersona.php");                		   
		  </script>');	
    
}else{ // Si es 1era vez que se carga la página mustra buscar persona
	echo('<div id="loading"></div><div id="result"></div>');
	echo('<script type="text/javascript">
		   $("#result").load("BuscaPersona.php");			  
	     </script>');
}
?>	