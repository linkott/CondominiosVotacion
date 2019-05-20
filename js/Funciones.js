// Validacion de Formulario
// Se Ejecuta al Enviar el Formulario
$.validator.setDefaults({
	submitHandler: function(form){ // form:Formulario que lo invoco 		    
	    //var formulario=$(form).attr('name'); //Captura el Nombre del Formulario que disparo el submit		
      	$.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: $(form).serialize(),
            success: function(data) {			   
			   //if (formulario == 'Estadistico'){ // Si es el Formulario Estadistica pinta el borde de la respuesta
			    if (data.substr(0,6) =='Valido'){  // Si la validacion es exitosa muestra el div de opciones
				   tipousuario= data.substr(6,2); 
				   $('#inicio').html('<table align="left"><tr><td><img src="images/usuario.gif"></td>'+
				                     '<td class="user"><span class="etiqueta">USUARIO:</span> '+data.substr(8,data.length-8)+'</td>'+
									 '<td class="user"><span class="etiqueta"> | <span><span class="links"><a href="CerrarSesion.php"> CERRAR SESI&Oacute;N </a></span></td></table>'); // Incorpora el usuario activo
			       $('#usuario').text(''); // Blanquea usuario si mostro algun mensaje
				   $('#principal').hide(); // Oculta contenido pagina principal
				   if (tipousuario== '02'){ // Usuario Basico
				      $("#tabs").tabs( "remove" , 3 ); //Remueve los tabs 3,2 y 1
					  $("#tabs").tabs( "remove" , 2 );
					  $("#tabs").tabs( "remove" , 1 );
				   }
				   $('#tabs').show();	
                   $("#tabs").tabs("load", 0);					   
                }else{				   
				   $('#usuario').html(data);  // Muestra error de validacion
                }				
            }
        })    
        return false;
	},
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
}); 
// Fin

$(document).ready(function() {
  $("#tabs").tabs(); // Activa el Primer Tab
  //$("#tabs").tabs({ disabled: [2] }); // Deshabilita el Tabs 3
  //$("#tabs").tabs( "remove" , 2 ); // Remueve directamente el tab
  $('#tabs').bind('tabsselect', function(event, ui){
    if(ui.index == 0){
       $("#tabs").tabs("url", 0, "ProcesaPersona.php");
       $("#tabs").tabs('option', 'ajaxOptions', {data: {}, type:'POST'});
	   $("#result, #grafica, #resultado, #respuesta").empty();  // Blanquea Contenedor result y grafica
    }
	if(ui.index == 1){
      $("#tabs").tabs("url", 1, "ProcesaConsultaRegistros.php");
      $("#tabs").tabs('option', 'ajaxOptions', {data: {}, type:'POST'});	
      $('#result, #grafica, #resultado, , #respuesta').empty();  // Blanquea Contenedor result		  
    }
    if(ui.index == 2){
       $("#tabs").tabs("url", 2, "ProcesaConsultaTransaccion.php");
       $("#tabs").tabs('option', 'ajaxOptions', {data: {}, type:'POST'});	
       $('#result, #grafica, #resultado, #respuesta').empty();  // Blanquea Contenedor result	   
    }
    if(ui.index == 3){
      $("#tabs").tabs("url", 3, "ProcesaMantenimiento.php");
      $("#tabs").tabs('option', 'ajaxOptions', {data: {}, type:'POST'});	  
	  $("#result, #grafica, #resultado, #respuesta").empty();  // Blanquea Contenedor result y grafica
    }
	
	/*if(ui.index == 4){
      $("#tabs").tabs("url", 4, "GeneraEstadistica.php");
      $("#tabs").tabs('option', 'ajaxOptions', {data: {}, type:'POST'});	  
    } */
  });
  
  // Esconde el div tabs para ocultar las opciones del menu previo a la validacion de usuarios
  $("#tabs").hide();
  // Fin 
  
  // Set Focus en el input de nombre de usuario
  $('#inicio :input:enabled:visible:first').focus();  
  
  	// Hiperenlaces de sugerencias pagina principal
  $("#sugerencias").mouseover(function () {
        $(this).removeClass("enlaces").addClass("enlaces2");
  }); 
  $("#sugerencias").mouseout(function () {
       $(this).removeClass("enlaces2").addClass("enlaces");
  }); 
  $("#sugerencias").click(function () {
       $("#dialog-sugerencia").dialog('open'); 
  }); 
  
  $("#dialog").dialog("destroy");
	
  $("#dialog-message").dialog({
            resizable: false,
            autoOpen: false,
			//show: 'fade',
			//hide: 'puff',
			closeOnEscape: false,
			open: function(event, ui) { jQuery('.ui-dialog-titlebar-close').hide();}, //Quita la X del Cuadro de Dialogo
			buttons: {
			Ok: function() {
			    if (($(this).dialog( "option", "title" )=="Cambiar Contrase\361a") || 
				    ($(this).dialog( "option", "title" )=="Gestionar Horas del Comedor") || 
					($(this).dialog( "option", "title" )=="Gestionar Autorizaci\363n") || 
			        ($(this).dialog( "option", "title" )=="Gestionar Usuarios") ||
				    ($(this).dialog( "option", "title" )=="Gestionar Men\372s del Comedor")) { // Si lo invoco Cualquier opcion de mantenimiento Blanquea DIV
				    $('#contenedor').empty();
				}                				
                if (($(this).dialog( "option", "title" )=="Registrar Transacci\363n") || ($(this).dialog( "option", "title" )=="Ingreso al Comedor")) { // Si lo invoco Actualizar Personal o generar autorizacion Recarga			    
				    $('#result').load('BuscaPersona.php');	                    				
                    $('#tabs').tabs('load', 'Tab-Ingreso'); // Refresca Tab 1                    					
				}   				
				$(this).dialog('close');
				$('#loading').hide();
			}
		}
	});
	
    $("#dialog-confirm").dialog({
			resizable: false,
			autoOpen: false,
			modal:true,
			show: 'fade',
			hide: 'puff',
			closeOnEscape: false,
			open: function(event, ui) { jQuery('.ui-dialog-titlebar-close').hide();}, //Quita la X del Cuadro de Dialogo
			buttons: {
				' Si ': function() {
					$(this).dialog('close');
					$('#loading').hide();	
                    $('#camposValidar').find(':input').each(function() { //Busca todos los input del form y los blanquea
					    $(this).val('');
                    });					
					$("#dialog-form").dialog('open'); 
				},
				' No ': function() {                   			
				    $('#result').load('BuscaPersona.php'); //Cargar en el Div la Pagina con Cedula Capturada
					$(this).dialog('close');
					$('#loading').hide();					
					$('#tabs').tabs('load', 'Tab-Ingreso'); // Refresca Tab 1	
				}
			}			
	});	
	
	//$(function() {
		/*var nombre = $('#nombre'),
			apellidos = $('#apellidos'),
			procedencia = $('#procedencia'),		
			allFields = $( [] ).add( nombre ).add( apellidos ).add( procedencia ),
			tips = $( ".validarAutorizacion" );
		
		$("#dialog-form").dialog({
				autoOpen: false,
				resizable: false,
				show: 'fade',
				hide: 'puff',
				height: 350,
				width: 350,
				modal: true,
				closeOnEscape: false,
				open: function(event, ui) { jQuery('.ui-dialog-titlebar-close').hide();}, //Quita la X del Cuadro de Dialogo
				buttons: {
					'Guardar': function() {
						var bValid = true;
						allFields.removeClass( 'ui-state-error' );

						bValid = bValid && checkLength( nombre, 'nombre', 3, 50 );
						bValid = bValid && checkLength( apellidos, 'apellidos', 3, 50 );
						bValid = bValid && checkLength( procedencia, 'procedencia', 5, 50 );

						bValid = bValid && checkRegexp( nombre, /^([0-9a-zA-Z \-'_])+$/, 'S\u00f3lo se permite para el nombre : a-z 0-9' );
						bValid = bValid && checkRegexp( apellidos, /^([0-9a-zA-Z \-'_])+$/, 'S\u00f3lo se permite para el apellido : a-z 0-9' );
						bValid = bValid && checkRegexp( procedencia, /^([0-9a-zA-Z \-'_])+$/, 'S\u00f3lo se permite para la procedencia : a-z 0-9' );

						if ( bValid ) {	
							$( this ).dialog('close');	
							$.ajax({
								type: 'POST',
								url: 'RegistraAutorizacion.php',
								data:  { xnombre:nombre.val(), xapellidos:apellidos.val(), xprocedencia:procedencia.val() },
								async: false, //Espera a que el server devuelva respuesta
								success: function(data) {
									$('#result').load('ProcesaBusqueda.php'); 								                                							
								}
							})    
							return false;						                       						
						}
					},
					'Cancelar': function() {
						$( this ).dialog('close');
						$('#result').load('BuscaPersona.php');					
						$('#tabs').tabs('load', 'Tab-Ingreso'); // Refresca Tab 1	 
					}
				}
		});*/
	//});
	
	//$(function() {
		var Comentario = $('#Comentario'),
			sCedula = $('#sCedula'),	
			Tipo = $('#Tipo'),	
			Email = $('#Email'),			
			allFields = $( [] ).add( Comentario ).add( sCedula ).add( Tipo ).add( Email ),
			tips = $( ".validarAutorizacion" );
			
		$("#dialog-sugerencia").dialog({
				autoOpen: false,
				resizable: false,
				show: 'blind',
				hide: 'explode',
				height: 460,
				width: 350,
				modal: true,
				closeOnEscape: false,
				open: function(event, ui) { jQuery('.ui-dialog-titlebar-close').hide();}, //Quita la X del Cuadro de Dialogo
				buttons: {
					'Guardar': function() {
						var bValid = true;
						allFields.removeClass( 'ui-state-error' );

						bValid = bValid && checkLength( Comentario, 'Comentario', 3, 50 );
						bValid = bValid && checkLength( sCedula, 'Cedula', 6, 8 );
						bValid = bValid && checkLength( Email, 'Email', 3, 50 );

						bValid = bValid && checkRegexp( Comentario, /^([0-9a-zA-Z \-'_])+$/, 'S\u00f3lo se permite para Comentario : a-z 0-9' );
						bValid = bValid && checkRegexp( sCedula, /^([0-9])+$/, 'S\u00f3lo se permite para la C\u00e9dula : 0-9' );
						bValid = bValid && checkRegexp( Email, /\S+@\S+\.\S+/, 'S\u00f3lo se permite para el Email : a-z @ 0-9' );

						if ( bValid ) {	
							$( this ).dialog('close');	
							$.ajax({
								type: 'POST',
								url: 'RegistraSugerencia.php',
								data:  { xComentario:Comentario.val(), xTipo:Tipo.val(), xsCedula:sCedula.val(), xEmail:Email.val() },
								async: false, //Espera a que el server devuelva respuesta
								success: function(data) {
								    if (data.substring(data.length-13) == 'Error Persona'){
									   $( this ).dialog('close');
									   $("#mensaje").text(" Usuario No Registrado, No se proces\u00f3 la Sugerencia ! ");
									   $("#dialog-message").dialog( "option", "title", "Sugerencia y Reclamos" );
									   $("#dialog-message").dialog('open');      
									}else{
									   $( this ).dialog('close');
									   $("#mensaje").text(" La informaci\u00f3n fue enviada, gracias por participar ! ");
									   $("#dialog-message").dialog( "option", "title", "Sugerencia y Reclamos" );
									   $("#dialog-message").dialog('open'); 									  
									}
									//$('#result').load('ProcesaBusqueda.php'); 
                                    $('#camposSugerencia').find(':input').each(function() { //Busca todos los input del form y los blanquea
										$(this).val('');
									});									
								}
							})    
							return false;						                       						
						}
					},
					'Cancelar': function() {
						$( this ).dialog('close');
						$('#camposSugerencia').find(':input').each(function() { //Busca todos los input del form y los blanquea
							$(this).val('');
						});	
						//('#result').load('BuscaPersona.php');					
						//$('#tabs').tabs('load', 'Tab-Ingreso'); // Refresca Tab 1	 
					}
				}
		});
	//});	
	
    $('#Autenticar').button({
		icons: {
			primary: 'ui-icon-person'
		}		
	});	    
	
    var validator = $('#Sesion').validate({	
            rules: {
		    IdUsuario:'required',
            Password: 'required'			
			},
			messages: {
		    IdUsuario: 'Introduzca Usuario',
			Password: 'Introduzca Contrase&ntilde;a'
			},
             // Manejo Errores Validate	con imagen
			errorElement: 'div',
			wrapper: 'div',  // a wrapper around the error message
			errorPlacement: function(error, element) {			    
				offset = element.offset();
				error.insertBefore(element)
				error.addClass('message');  // add a class to the wrapper
				error.css('position', 'absolute');
				error.css('left', offset.left + element.outerWidth()+235);
                error.css('top', offset.top);					
			} 			
	});	
	
	// Asigna Contenido al Scroll
	$.post("LlenaScroll.php", function(data){  
	    $('#ContenidoScroll').html(data);				 
	});

    // Add Scroller Object
	$jScroller.add("#detalle","#scroller","up",3, true);

	// Start Autoscroller
	$jScroller.start();
	
	// Acordion para menú principal	
	
	$("#menu").accordion({
			fillSpace: true,  //Se Ajusta Verticalmente al tamaño de su contenedor
			autoHeight: true // Mantiene el tamaño segun el contenido
		});
	
	$('#Comentar').button({
		icons: {
			primary: 'ui-icon-contact'
		}		
	});	
  
   function checkLength( o, n, min, max ) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "La longitud de " + n + " debe estar entre " +
				min + " y " + max + "." );
			return false;
		} else {
			return true;
		}
   } 

   function checkRegexp( o, regexp, n ) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		} else {
			return true;
		}
   }

   function updateTips( t ) {
		tips
			.text( t )
			.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
   }
  
  
 
  jQuery.fn.ForceNumericOnly = function() {  // Valida Solo Numeros en el input box
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow enter, backspace, tab, delete, arrows, numbers and keypad numbers ONLY
            return (
			    key == 13 || 
                key == 8 || 
                key == 9 ||
                key == 46 ||
                (key >= 37 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
  };
  
 });
 function Mayuscula(objeto){
     objeto.value=objeto.value.toUpperCase();
 }
 function Selecciona(objeto){
     objeto.select();	 
 } 
