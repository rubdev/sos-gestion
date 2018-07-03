$(document).ready(Inicio);

var obligatorio = "Este campo es obligatorio";

function Inicio() {
	$("#validaProducto").validate({
		success:"verde",
		errorClass:"rojo",
		rules:{
			nombre:{
				required: true,
      			maxlength: 100
			},
			uso:{
				required:true,
				maxlength: 500
			}
		},
		messages:{
			nombre:{
				required: obligatorio,
      			maxlength: "El nombre no puede tener más de 100 caracteres"
			},
			uso:{
				required:obligatorio,
				maxlength: "El uso no puede tener más de 500 caracteres"
			}
		}
	});
}