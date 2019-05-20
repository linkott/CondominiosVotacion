<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<title>Control de Registros - </title>
<link rel="stylesheet" type="text/css" media="screen" href="css/pepper-grinder/jquery-ui-1.8.11.custom.css">
<link rel="stylesheet" type="text/css" href="css/Estilos.css">	
<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css">
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="js/grid.locale-sp.js"></script>
<script type="text/javascript" src="js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jscroller-0.4.js"></script>
<script type="text/javascript" src="js/Funciones.js"></script>
</head>
<body>
<?php
  $FechaActual = date("d/m/Y");
?>
<div id="contenido" class="bordePrincipal" style="background-image:url(css/pepper-grinder/images/ui-bg_fine-grain_15_ffffff_60x60.png);">
   <table width="100%" border=0>
 	<tr>
    <td align="center"><div id="header2"></div></td>
   </tr>
	<tr>
    <td align="center"><div id="header"></div></td>
   </tr>
   </table>
   <table class="bordeInicio" width="100%" cellpadding="0" cellspacing="0" border=0>
   <tr>
    <td id="inicio">
	
	</td>
    <td><div id="usuario"></div></td>
	<td align='right'><span id="sugerencias" class="enlaces">Sugerencias y Reclamos</a></td>
	<td width='1%'>&nbsp;</td>
   </tr>
   </table>
   <div id="tabs">
       <ul>
          <li><a href="ProcesaPersona.php" title="Tab-Ingreso">Ingreso Institucion</a></li>
		  <li><a href="ProcesaConsultaRegistros.php" title="Tab-Consulta">Consultas</a></li>
          <li><a href="ProcesaConsultaTransaccion.php" title="Tab-Estadistica">Estad&iacute;sticas</a></li>
		  <li><a href="ProcesaMantenimiento.php" title="Tab-Mantenimiento">Mantenimiento</a></li>		 
		  <!-- <li><a href="GeneraEstadistica.php">M&oacute;dulo Estad&iacute;stico</a></li> -->			  
       </ul>	   
   </div> 
   <div id="dialog-message" title="Autorizaci&oacute;n">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<span id="mensaje"></span> 
	</p>	
   </div>
   <div id="dialog-confirm" title="Autorizaci&oacute;n">
	 <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
	   <span id="mensaje2"></span> 	   
	 </p>   
   </div> 
      
    <div id="dialog-sugerencia" title="Sugerencias y Reclamos">	
		<form id='camposSugerencia'> 
			<fieldset>	        
			<label for="Asunto">Comentar sobre</label>
			<select name="Tipo" id="Tipo"> 
				<option selected value='1'>Sitio Web</option> 
				<option value='2'>Atenci&oacute;n</option> 
				<option value='3'>Servicio</option> 
				<option value='4'>Horario</option> 				
			</select> 
			<label for="Comentario">Escriba su comentario</label> 
			<textarea name="Comentario" id="Comentario" cols="55" rows="5" maxlength="160" class="text ui-widget-content ui-corner-all" OnFocus="Selecciona(this);">M&aacute;ximo 160 Caracteres ....</textarea> 
			<label for="sCedula">N&uacute;mero de c&eacute;dula</label>
			<input name="sCedula" id="sCedula" type="text" size="12" maxlength="8" class="text ui-widget-content ui-corner-all";"> 
			<label for="Email">Correo electr&oacute;nico</label>
			<input name="Email" id='Email' type="text" size="30" maxlength="35" class="text ui-widget-content ui-corner-all";">					 
			</fieldset>  
		</form>
		<p class="validarAutorizacion">Todos los campos son requeridos.</p>
   </div>  
   
   <div id="principal"> 

        <div id="content_panel">
        	
            <div id="column_w610">
            
            	<div class="header_01">Sistema de Asistencia</div>
                
                
          <div class="section_01">
                	<div class="top"></div>
                          <table border="0" width="100%" height="100%" >
               <tr>
               	<td>
							<table border="0"align="center" class="table-bordered">
								<form name="Sesion" id="Sesion" method="POST" action="ValidaUsuario.php" >
									<tr>
										<td colspan="2" align="center">Inicio de sesion</td>
									</tr>							
									<tr>
										<td >Usuario: </td>
										<td ><input id="IdUsuario" name="IdUsuario" type="text" size="15"></td>
									</tr>	
										<tr>
										<td >Clave:</td>
										<td><input id="Password" name="Password" type="password" size="15"> 										
										</td>
									</tr>
									</tr>	
										<tr>
										<td colspan="2">	<button type="submit" name="btn_entrar" class="btn">Entrar</button></td>
										
									</tr>
								</form>					
								
							</table>
						</td>
					</tr>
					</table>
 
                    
                    <div class="bottom">

                    </div>                
                </div>

            </div> <!-- end of column w610 -->
 
        </div>
           
	</div>	     
	<div class="push"></div>
  </div> 	
  <div id="piepagina">
       <table class="bordeInicio" style="border-style:solid none none none;" width="100%">
       <tr>
       <td align="center"><span class="leyenda">Direcci&oacute;n Electr&oacute;nica: linkott@gmail.com</span></td>
       </tr>
       </table> 	   
	   <table class="borde" style="border-style:solid none none none;" width="100%">	   
		<tr>
		<td align="center"><span  class="leyenda"><img src='images/copyleft.png' width='8px' heigth='8px'> Copyleft 2019 por Richard Stiven Restrepo Guevara</span></td>
	   </tr>
	   </table>	
  </div>  
</body>
</html>
