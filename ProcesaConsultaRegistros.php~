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
    $("#respuesta").load(url);
  }  
</script>
<div id="marco">
<fieldset class="ui-corner-all bordeForm">
<legend>Opciones de Consulta</legend>
<table id="Consultas" border=0 width="100%">
<tr>
<td  width="8%" align="right"><img src="images/usuario.gif"></td><td width="16%"><span class="enlaces" onclick="javascript:CargarUrl('ConsultarUsuarios.php');">Consultar Usuarios</span></td>
<!--  <td  width="10%" align="right"><img src="images/fork.png"></td><td width="14%"><span class="enlaces" onclick="javascript:CargarUrl('ConsultaMenus.php');">Consultar Men&uacute;s</span></td>-->
<td  width="8%" align="right"><img src="images/search.gif"></td><td width="17%"><span class="enlaces" onclick="javascript:CargarUrl('ProcesaRegistros.php?Tipo=1');">Detalle de Registros</span></td>
<td  width="8%" align="right"><img src="images/Checkmark.gif"></td><td width="14%"><span class="enlaces" onclick="javascript:CargarUrl('ProcesaRegistros.php?Tipo=2');">Autorizaciones</span></td>
<td  width="10%" align="right"><img src="images/buzon.png"></td><td width="14%"><span class="enlaces" onclick="javascript:CargarUrl('ConsultaSugerencias.php');">Sugerencias</span></td>
</tr>
</table>
</fieldset> 
</div>
<div id="respuesta"></div>
