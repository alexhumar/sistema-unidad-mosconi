/**
 * Carga dinamica de localidades en base al partido seleccionado
 */

$('#registroDatosFiliatorios_partido').change(function(){
    $.ajax({
       type: "GET",
	   data: "data=" + $(this).val(),
       url:"{{ path('localidades_de_partido') }}",
       success: function(msg){
		  if(msg != '') {
		      $(#registroDatosFiliatorios_localidad).html(msg).show();
		      }
		      else {
	   	          $(#registroDatosFiliatorios_localidad).html('<em>Sin resultados</em>');
		      }
	      }
		});
    });

