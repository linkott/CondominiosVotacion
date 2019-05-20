<script type="text/javascript" src="js/Validar.js"></script>
<script type="text/javascript">
function LlenaOpcionCombo2(xTipo){ 
	$.post("LlenaCombo.php", { Tipo:xTipo }, function(data){          
		  $('#'+xTipo).html(data);				 
	});
}	

function LlenaContador(){ 
	$.post("ActualizaContador.php", function(data){          
		  $('#ccontador').html(data);				 
	});
}	
</script>
<form id="FBuscar" name="FBuscar" method="Post" action="ProcesaBusqueda.php">
    <fieldset class="ui-corner-all bordeForm">
	<legend>Datos Personales</legend>
	<table width='750' border=0>
	<tr><td colspan="5">&nbsp;</td></tr>
	<tr>
	<td width="20%"><label for="Cedula">C&eacute;dula</label></td>
	<td width="20%"><input id="Cedula" name="Cedula" maxlength="10">&nbsp;
	<button id="BotonBuscar" type="submit"> Buscar </button>
	</td>
	<td rowspan="8">&nbsp;</td>
	<td width="30%" rowspan="8" class="ui-corner-all bordeForm"><img src=""></td>
	<td rowspan="8">&nbsp;</td> 
    </tr>
	<tr>
	<td width="20%"><label for="Nombre">Nombre</label></td>
	<td width="20%"><input id="Nombre" name="Nombre" size="38"></td>
	</tr>
	<tr>
	<td><label for="Apellidos">Apellidos</label></td>
	<td><input id="Apellidos" name="Apellidos" size="38"></td>
	</tr>
	<tr>
	<td>
	<label for="Genero">G&eacute;nero</label>
	</td>
	<td>
		<select id="Sexo" name="Sexo" title="Seleccione una Opcion">
			<option value=""></option>
			<option value="F">Femenino</option>		
            <option value="M">Masculino</option>					
		</select>
	</td>
    </tr>	
	<tr>
	<td><label for="FechaIngreso">Fecha de Ingreso</label></td>
	<td><input id="FechaIngreso" name="FechaIng"></td>
	</tr>	
	<tr>	
	<td><label for="DirHab">Direcci&oacute;n de Habitaci&oacute;n</label></td>
	<td><textarea id="DirHab" name="DirHab" cols="40" rows="2"></textarea></td>
    </tr>
	<tr>
	<td><label for="Email">E-mail</label></td>
	<td><input id="Email" name="Email" size="40"></td>
	</tr>		
	<tr>
	    <td colspan="3">&nbsp;</td>
		<td><div id='ccontador'></div> </td>
		<td>&nbsp;</td>
	</tr>
	</table>	
	</fieldset>	
</form>
<script language='javascript'>
$(document).ready(function() {
  $("#Cedula").ForceNumericOnly(); // Valida Solo Numeros
  //LlenaOpcionCombo2("TipoPersona"); 
  LlenaContador();	
  $("#FBuscar :input:enabled:visible:first").focus();     
});  
</script>
