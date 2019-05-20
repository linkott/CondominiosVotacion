<?php
include_once("class/ManejadorBD.class");
include_once("class/Formato.class");
session_start();
if (isset($_SESSION['persona'])){
   $Persona=$_SESSION['persona'];
   $Cedula=$_SESSION['xcedula'];
} else {
  /* $Persona="An&oacute;nimo";
   $Cedula="";
?>
   <script language='javascript'>
          $("#mensaje").text(' Debe haber un personal activo, antes de consultar saldo !');
		  $("#dialog-message").dialog( "option", "title", 'Consulta de Saldo' );
          $("#dialog-message").dialog('open');
          $('#tabs').tabs('select', 0);  //Se coloca en el 1er tab		  	 
   </script>
<?php 
   exit();  */
}
?>
<script type="text/javascript" src="js/Validar.js"></script>
<script language='javascript'>
  function CargarUrl(url){    
    $("#resultado").load(url);
  }  
</script>
<div id="marco">
<fieldset class="ui-corner-all bordeForm">
<legend>Opciones de Mantenimiento</legend>
<table id="Mantenimiento" border=0 width=100%>
<tr>
<td  width="5%" align="right"><img src="images/seguridad.png"></td><td><span class="enlaces" onclick="javascript:CargarUrl('CambiarPassword.php');">Cambiar Contrase&ntilde;a</span></td>
<td  width="5%" align="right"><img src="images/reloj.gif"></td><td><span class="enlaces" onclick="javascript:CargarUrl('GestionaHoras.php');">Gestionar Horarios</span></td>
<td  width="5%" align="right"><img src="images/usuario.gif"></td><td><span class="enlaces" onclick="javascript:CargarUrl('GestionaUsuarios.php');">Gestionar Usuarios</span></td>
<td  width="5%" align="right"><img src="images/Checkmark.gif"></td><td width="14%"><span class="enlaces" onclick="javascript:CargarUrl('GestionaAutorizacion.php');">Gestionar Autorizaci&oacute;n</span></td>

</tr>
</table>
</fieldset> 
</div>
<div id="loading"></div>
<div id="resultado"></div>
