// Formulario Sin Recargar //
$(document).ready(function() {
    $().ajaxStart(function() { //Activa Mensaje Mientras se Carga la Página //	    
	    $('#loading').html('<img src="images/cargando.gif" align="middle">&nbsp;&nbsp;Cargando ...'); 
		$('#loading').show(); // Muestra mensaje en el Div //
		$('#result').hide();
    }).ajaxStop(function() {
        $('#loading').hide();
        $('#result').fadeIn('slow');
    });
    $('#fbusqueda').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
			    $('#result').css('border','1px solid #bfcddb'); // Asigna Borde al DIV cuando carga el Resultado
                $('#result').html(data);
            }
        })    
        return false;
    }); 
})  
// Fin Formulario Sin Recargar //