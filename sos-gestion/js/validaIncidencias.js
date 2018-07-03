$(document).ready(Inicio);

var obligatorio = "Este campo es obligatorio";

function Inicio() {
	$("#validaIncidencia").validate({
		success:"verde",
		errorClass:"rojo",
		rules:{
			titulo:{
				required: true,
      			maxlength: 100
			},
			descripcion:{
				required:true,
				maxlength: 500
			}
		},
		messages:{
			titulo:{
				required: obligatorio,
      			maxlength: "El nombre no puede tener más de 100 caracteres"
			},
			descripcion:{
				required:obligatorio,
				maxlength: "La descripción no puede tener más de 500 caracteres"
			}
		}
	});
}