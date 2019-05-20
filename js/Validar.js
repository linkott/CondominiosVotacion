// Validacion de Formulario

// Se Ejecuta al Enviar el Formulario
$.validator.setDefaults({
	submitHandler: function(form){ // form:Formulario que lo invoco 		    
	    var formulario=$(form).attr('name'); //Captura el Nombre del Formulario que disparo el submit       	
      	$.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: $(form).serialize(),
            success: function(data) { 
			    $('#result, #resultado').html(data);                 				
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

// Cuando se carga el Formulario	
$(document).ready(function() {

    $(document).ajaxStart(function() { //Activa Mensaje Mientras se Carga la P�gina //        
		$('#loading, #cargando').html('<img src="images/ajax-loader.gif" alt="Cargando ....">'); 
		$('#loading, #cargando').show(); // Muestra mensaje en el Div //
		$('#result, #resultado').hide();		
    }).ajaxStop(function() {	    
        $('#loading, #cargando').hide();
        $('#result, #resultado').fadeIn('slow');          
    }); 

    // Obtiene el A�o actual del Sistema	
	var fecha=new Date();
	var annoActual=fecha.getFullYear();
	// fin
	
    $.datepicker.setDefaults({ // Setea Valores por Defecto para el DatePicker               
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		yearRange: '2012:'+annoActual,
		currentText: 'Hoy', currentStatus: '',
	  	monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	  	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	   	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
	  	'Jul','Ago','Sep','Oct','Nov','Dic'],
	   	monthStatus: '', yearStatus: '',
	  	weekHeader: 'Sm', weekStatus: '',
	  	dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;dabo'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
	  	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
	 	dayStatus: 'DD', dateStatus: 'D, M d'
	});
	
	$.timepicker.setDefaults({ // Setea Valores por Defecto para el Timepicker   		
		timeOnlyTitle: 'Elija Hora',
	    timeText: 'Tiempo',
        hourText: 'Hora',
        minuteText: 'Minutos',
        secondText: 'Segundos',
        currentText: 'Actual',
        closeText: 'Listo',
		ampm: false
    });
    	
	$("#FechaNac, #FechaIngreso, #FechaDesde, #FechaHasta, #FechaDesdeR, #FechaHastaR, #FechaMenu, #MenuFecha").datepicker({
			showOn: 'button',
			buttonImage: 'images/calendar.gif'
	});
	
	$('#HoraInicio, #HoraFin').timepicker({
		ampm: true,
		hourMin: 6,
		hourMax: 21
	});
	// Hiperenlaces del men� de mantenimiento y consultas
	$("#Mantenimiento span, #Consultas span").mouseover(function () {
        $(this).removeClass("enlaces").addClass("enlaces2");
    }); 
    $("#Mantenimiento span, #Consultas span").mouseout(function () {
        $(this).removeClass("enlaces2").addClass("enlaces");
    }); 
    
    // validate al transcribir datos en el campo y al enviar
	var validator = $('#Registro').validate({				
	        rules: {
		    Cedula: {
			    required: true,
				minlength: 7,
                digits: true    // Valida que se permitan solo numeros
			},
			Nombre: 'required',
			Apellidos: 'required',
			Sexo: 'required',	
			EdoCivil: 'required' ,
			//LugarNac: 'required',
			DirHab: 'required',			
			/*TelfHab: {
			    required: true,
				minlength: 11,
                digits: true    // Valida que se permitan solo numeros
			},   
			TelfCel: {
			    required: true,
				minlength: 11,
                digits: true    // Valida que se permitan solo numeros
			},*/ 
			Email: {
				required: true,
				email: true
			}//,	
			//Nacionalidad:'required'
		},
		messages: {
		    Cedula: "Por favor ingrese solo n&uacute;meros",
			Nombre: "Por favor ingrese Nombre",
			Apellidos: "Por favor ingrese Apellido",
  		    Sexo: "Por favor seleccione Genero",
			EdoCivil: "Por favor selecione Estado Civil" ,
			//LugarNac: "Por favor ingrese Lugar de Nacimiento" ,
			DirHab: "Por favor ingrese Direcci&oacute;n" ,	
			/*TelfHab: {
				digits: "Por favor ingrese solo n&uacute;meros",
			    required: "Por favor ingrese Tel&eacute;fono de Habitaci&oacute;n",
				minlength: jQuery.format("M&iacute;nima {0} digitos, sin caracteres")
			},	
			TelfCel: {
				digits: "Por favor ingrese solo n&uacute;meros",
				required: "Por favor ingrese Tel&eacute;fono Celular",
				minlength: jQuery.format("M&iacute;nimo {0} digitos, sin caracteres")				
			},*/	
			Email: "Por favor ingrese un Email v&aacute;lido"//,
			//Nacionalidad: "Por favor seleccione Nacionalidad"           
		},
             // Manejo Errores Validate	con imagen
			errorElement: 'div',
			wrapper: 'div',  // a wrapper around the error message
			errorPlacement: function(error, element) {			    
				offset = element.offset();
				error.insertBefore(element)
				error.addClass('message');  // add a class to the wrapper
				error.css('position', 'absolute');
				error.css('left', offset.left + element.outerWidth());               				
			} 		
	});
	
	$("#Limpiar").click(function (){ 
	   validator.resetForm();	   
	});
		
	$('#ActualizaUbicacion, #RegistroUbicacion').validate({				
	        rules: {
		    TelfOficina: {
			    required: true,
				minlength: 11,
                digits: true    // Valida que se permitan solo numeros
			}
			},
			messages: {
		    TelfOficina: "Por favor ingrese solo n&uacute;meros"			
			},
             // Manejo Errores Validate	con imagen
			errorElement: 'div',
			wrapper: 'div',  // a wrapper around the error message
			errorPlacement: function(error, element) {			    
				offset = element.offset();
				error.insertBefore(element)
				error.addClass('message');  // add a class to the wrapper
				error.css('position', 'absolute');
				error.css('left', offset.left + element.outerWidth());				
			} 					
	});	
	
	var validator = $('#Estadistico').validate({	
            rules: {
		    TipoGrafico:'required',
            TituloGrafico: 'required'			
			},
			messages: {
		    TipoGrafico: 'Por favor seleccione Tipo de Gr&aacute;fico',
			TituloGrafico: 'Por favor introduzca Titulo del Gr&aacute;fico'
			},
             // Manejo Errores Validate	con imagen
			errorElement: 'div',
			wrapper: 'div',  // a wrapper around the error message
			errorPlacement: function(error, element) {			    
				offset = element.offset();
				error.insertBefore(element)
				error.addClass('message');  // add a class to the wrapper
				error.css('position', 'absolute');
				error.css('left', offset.left + element.outerWidth());				
			} 			
	});	
	
	var validator = $('#ActualizarPassword').validate({	
            rules: {
			Password: 'required',
		    PasswordNew: 'required',
            PasswordConf: {required:true,
                           equalTo: "#PasswordNew"} 			
			},
			messages: {
			Password: 'Por favor introduzca Contrase&ntilde;a Actual',
		    PasswordNew: 'Por favor introduzca Contrase&ntilde;a Nueva',
			PasswordConf: {required:'Por favor repita la Contrase&ntilde;a',
			                equalTo:'Por favor introduzca la misma Contrase&ntilde;a de arriba'}  
			},
             // Manejo Errores Validate	con imagen
			errorElement: 'div',
			wrapper: 'div',  // a wrapper around the error message
			errorPlacement: function(error, element) {			    
				offset = element.offset();
				error.insertBefore(element)
				error.addClass('message');  // add a class to the wrapper
				error.css('position', 'absolute');
				error.css('left', offset.left + element.outerWidth() -80);				
			} 			
	});	
	
	var validator = $('#GestionarHoras').validate({	
            rules: {
			Hora: 'required',
		    HoraInicio: 'required',
            HoraFin:'required' 			
			},
			messages: {
			Hora: 'Debe Seleccionar un tipo de Men&uacute;',
		    HoraInicio: 'Por favor introduzca Hora de Inicio',
			HoraFin: {required:'Por favor introduzca Hora de Cierre'}  
			},
             // Manejo Errores Validate	con imagen
			errorElement: 'div',
			wrapper: 'div',  // a wrapper around the error message
			errorPlacement: function(error, element) {			    
				offset = element.offset();
				error.insertBefore(element)
				error.addClass('message');  // add a class to the wrapper
				error.css('position', 'absolute');
				error.css('left', offset.left + element.outerWidth() -80);				
			} 			
	});	
	
	var validator = $('#GestionarMenus').validate({	
            rules: {
			Menu: 'required',
		    FechaMenu: 'required',
            Descripcion:'required' 			
			},
			messages: {
			Menu: 'Debe Seleccionar un tipo de Men&uacute;',
		    FechaMenu: 'Por favor introduzca Fecha del Men&uacute',
			Descripcion: 'Por favor introduzca Descripci&oacute;n del Men&uacute'  
			},
             // Manejo Errores Validate	con imagen
			errorElement: 'div',
			wrapper: 'div',  // a wrapper around the error message
			errorPlacement: function(error, element) {			    
				offset = element.offset();
				error.insertBefore(element)
				error.addClass('message');  // add a class to the wrapper
				error.css('position', 'absolute');
				error.css('left', offset.left + element.outerWidth() -100);				
			} 			
	});	
	
	var validator = $('#FBuscar').validate({				
	        rules: {
		    Cedula: {
			    required: true,
				minlength: 6,
                digits: true    // Valida que se permitan solo numeros
			}
			},
			messages: {
		    Cedula: "Por favor ingrese solo n&uacute;meros"
			},
             // Manejo Errores Validate	con imagen
			errorElement: 'div',
			wrapper: 'div',  // a wrapper around the error message
			errorPlacement: function(error, element) {			    
				offset = element.offset();
				error.insertBefore(element)
				error.addClass('message');  // add a class to the wrapper
				error.css('position', 'absolute');
				error.css('left', offset.left + element.outerWidth() + 85);	// Se agregaron 85px para pasar el boton			
			} 			
	});	
	
	var validator = $('#GestionarUsuarios').validate({	
            rules: {
		    usuarioid: 'required',
            password:'required',
 			nombreusuario:'required',
			preguntasecreta:'required',
			respuestasecreta:'required',
			TipoUsuario:'required'
			},
			messages: {
		    usuarioid: 'Por favor introduzca el Nombre de Usuario',
			password: 'Por favor introduzca la Contrase&ntilde;a',
            nombreusuario:'Por favor introduzca Nombre y Apellido',
			preguntasecreta:'Por favor introduzca Pregunta Secreta',
			respuestasecreta:'Por favor introduzca Respuesta Secreta',
			TipoUsuario:'Por favor introduzca Tipo de Usuario'			
			},
             // Manejo Errores Validate	con imagen
			errorElement: 'div',
			wrapper: 'div',  // a wrapper around the error message
			errorPlacement: function(error, element) {			    
				offset = element.offset();
				error.insertBefore(element)
				error.addClass('message');  // add a class to the wrapper
				error.css('position', 'absolute');
				error.css('left', offset.left + element.outerWidth() -80);				
			} 			
	});	
	
	var validator = $('#GestionarAutorizacion').validate({	
            rules: {
		    Cedula: 'required',
            Nombre:'required',
 			Apellidos:'required',
			Direccion:'required',
			Sede:'required'
			},
			messages: {
		    Cedula: "Por favor ingrese solo n&uacute;meros",
			Nombre: "Por favor ingrese Nombre",
			Apellidos: "Por favor ingrese Apellido",
			Direccion:'Por favor introduzca Procedencia',
			Sede:'Por favor seleccione Sede'			
			},
             // Manejo Errores Validate	con imagen
			errorElement: 'div',
			wrapper: 'div',  // a wrapper around the error message
			errorPlacement: function(error, element) {			    
				offset = element.offset();
				error.insertBefore(element)
				error.addClass('message');  // add a class to the wrapper
				error.css('position', 'absolute');
				error.css('left', offset.left + element.outerWidth() - 90);				
			} 			
	});	
	
	var validator = $('#ConsultaTransaccion').validate();
	var validator = $('#ConsultaSugerencias').validate();
	var validator = $('#OpcionesImpresion').validate();
	var validator = $('#ConsultaRegistros').validate();
	var validator = $('#Actualizar').validate();
	
	// Eejecuta una validacion de la c�dula en Gestionar Autorizacion
	$('#CedulaA').blur(function() {  
        if ($(this).val() != ""){	
			$.post("VerificaPersona.php", { cedula:$(this).val() }, function(data){	
                if(data == "Disponible"){			
				   $("#etiqueta").html("<img src='images/ok-icon.png'>");
				}else{				  	 
				   $("#etiqueta").html(data).addClass("mensajeError");  
				   $('#CedulaA').val('');  //Blanquea el Campo de Texto				  
				}					
			});		
		}	
	});
	
	$('#CedulaA').focus(function() {  
	    $('#etiqueta').text("");  // Blanquea etiqueta 
	});
	
	$('#Limpiar').button({
		icons: {
			primary: 'ui-icon-trash'
		}
	});
	
	$('#BotonBuscar, #Mostrar').button({
		icons: {
			primary: 'ui-icon-search'
		}        
	});		
			
    $('#RegistroUbicacion').load(function(){  // Llena Combo Cargo
		$.post("LlenaCombo.php", { Tipo:"Cargo" }, function(data){
		$('#Cargo').html(data);				 
	    });   
        $.post("LlenaCombo.php", { Tipo:"Sede" }, function(data){
		  $('#Sede').html(data);				 
	    });       		
	});         
    $('#RegistroUbicacion').triggerHandler('load');  //Dispara el Evento Load para Cargar los Combo Box del Formulario    
	
    $("#Hora").change(function(){ // Cuando se selecciona tipo de menu se carga la hor de inicio y fin
   		$("#Hora option:selected").each(function(){			
			elegido=$(this).val(); // Captura Opcion Elegida
			$.post("CargaDatos.php", { Tipo:"Hora", Opcion:elegido }, function(data){
			  horainicio=data.substr(0,5);
			  horafin=data.substr(8,5);
			  if (horainicio.substr(0,2) > 12){
			     hora=(horainicio.substr(0,2)-12);
				 if(hora < 10){
				   hora="0"+hora;				   
				 }
				 horainicio=hora+horainicio.substr(2,3)+" pm";
			  }else{
			     horainicio=horainicio+" am";
			  }
			  if (horafin.substr(0,2) > 12){
			     hora=(horafin.substr(0,2)-12);
				 if(hora < 10){
				   hora="0"+hora;		   
				 }
				 horafin=hora+horafin.substr(2,3)+" pm";
			  }else{
			     horafin=horafin+" am";
			  }
			  $('#HoraInicio').val(horainicio); // Captura HoraInicio			
			  $('#HoraFin').val(horafin);	// Captura HoraFin			  		  
			});			
        });  
	});
		 	
	$("#FechaMenu").change(function(){ // Cuando se selecciona una fecha   			
		valor=$(this).val(); // Captura Valor del Text
		idmenu=$("#Menu option:selected").val();
        if (idmenu != '-- Seleccione --') {	// Si hay una opcion Seleccionada	
			$.post("CargaDatos.php", { Tipo:"Menu", Valor:valor, Opcion:idmenu }, function(data){  
			   if (data == ''){ // Si no devuelve nada asigna ingresar al campo oculto
				  $("input[name=TipoGestion]").val("Ingresar");   		
			   }else{
				  $("input[name=TipoGestion]").val("Modificar");  
			   }		   
			   $("#Descripcion").html(data);			   
			});			         
		}	
	});	
	
	$("#MenuFecha").change(function(){ // Cuando se selecciona piso se carga unidad   			
		valor=$(this).val(); // Captura Valor del Text
		idmenu=$("#Menu option:selected").val();		
		$.post("CargaDatos.php", { Tipo:"Menu", Valor:valor, Opcion:idmenu }, function(data){               		
		   $("#DescripcionMenu").html(data);			   
		});			         
	});	
	
	$('#Guardar, #GuardarU, #GuardarI, #GuardarM,#GuardarO').button({
		icons: {
			primary: 'ui-icon-disk'
		}		
	});
	
	$('#Cancelar, #CancelarU, #CancelarI, #CancelarM, #CancelarA').button({
		icons: {
			primary: 'ui-icon-cancel'
		}		
	});	
	
	$('#BGenerar').button({
		icons: {
			primary: 'ui-icon-image'
		}		
	});	
	
	$('#Imprimir').button({
		icons: {
			primary: 'ui-icon-print'
		}		
	});		

    $("#CancelarI").click(function (){      //Boton de Impresion
       $('#grafica, #result, #impresion').empty();  // Blanquea Contenedores
        // Reconstruye boton imprimir resultados	   
       $('#impresion').html("<table align='left'><tr><td><button id='Imprimir' onClick=$('#impresion').load('OpcionesImpresion.php?desde='+document.ConsultaTransaccion.FechaDesde.value+'&hasta='+document.ConsultaTransaccion.FechaHasta.value+'&tipomenu='+document.ConsultaTransaccion.MenuT.value+'&tipoconsulta='+document.ConsultaTransaccion.TipoC.value);>Imprimir Resultados</button></td></tr></table>");	   
	   $('#impresion, #grafica').hide();	           
	   $('#Imprimir').button({
		icons: {
			primary: 'ui-icon-print'
		}		
	   });	
	});		
		
	$("#Cancelar, #CancelarU").click(function (){      
       $('#usuario').text("");	  //Deja de Mostrar usuario
	   $('#contenedor').empty();  // Blanquea Contenedor
	   $('#result').load('ProcesaPersona.php?Accion=Destruir'); // Borra variables de Session	
       $('#tabs').tabs('load', 'Tab-Ingreso'); // Refresca Tab 1	   
	});
	
	$("#CancelarM").click(function (){             
	   $('#resultado').empty();  // Blanquea Contenedor	          
	});
	
	$("#FBuscar").submit(function() {	    
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),	            		
            success: function(data) {                		
			    $('#result').html(data);                 		
            }
        })    
        return false;
    });    
    
});

function VerificaCheck(){
	if(document.ConsultaTransaccion.CheckGenero.checked == true){
	   xgenero="Activado";
	}else{
	   xgenero="Desactivado";
	}
    return xgenero;
}	
// Fin Validacion de Formulario