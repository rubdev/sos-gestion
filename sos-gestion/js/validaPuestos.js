$(document).ready(Inicio);

var obligatorio = "Este campo es obligatorio";

function Inicio() {
	$("#validaPuesto").validate({
		success:"verde",
		errorClass:"rojo",
		rules:{
			num:{
				required: true,
      			number: true
			}
		},
		messages:{
			num:{
				required: obligatorio,
      			number:"Debes indicar el número de trabajadores necesarios"
			}
		}
	});
}