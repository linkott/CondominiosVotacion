<?php
session_start();
// Destruye todas las variables de sesión.		
$_SESSION = array();
// Destruye la Sesion
session_destroy();
// redirecciona a la pagina principal
echo('<script type="text/javascript"> window.location.href="index.php"; </script>');
?>	