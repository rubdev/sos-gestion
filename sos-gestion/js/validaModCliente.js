$(document).ready(Inicio);

var obligatorio = "Este campo es obligatorio";

var telRegx = /^[9|6]{1}([\d]{2}[-]*){3}[\d]{2}$/;


function ValTel(telefono) {
	return telefono.match(telRegx);
}

$.validator.addMethod("telefono",ValTel,"No es un teléfono válido, comprueba que empieza por 6 o 9");

function Inicio() {
	$("#validaCliente").validate({
		success:"verde",
		errorClass:"rojo",
		rules:{
			usuario:{
				required:true,
				minlength:5,
				maxlength: 20
			},
			nombre:{
				required:true,
				minlength:5,
				maxlength: 20
			},
			ds:{
				required:true,
				maxlength:60
			},
			cif:{
				required:true
			},
			direccion:{
				required:true,
				minlength:10,
				maxlength: 60
			},
			email:{
				required:true,
				email:true
			},
			telefono:{
				required:true,
				telefono:true
			},
		},
		messages:{
			usuario:{
				required:obligatorio,
				minlength:"El nombre de usuario debe tener 5 caracteres como mínimo",
				maxlength:"El nombre de usuario puede tener 20 caracteres como máximo"
			},
			nombre:{
				required:obligatorio,
				minlength:"El nombre debe tener 5 caracteres como mínimo",
				maxlength:"El nombre puede tener 20 caracteres como máximo"
			},
			ds:{
				required:obligatorio,
				maxlength:"La denominación social puede tener 60 caracteres como máximo"
			},
			cif:{
				required:obligatorio,
			},
			direccion:{
				required:obligatorio,
				minlength:"La dirección debe tener 10 caracteres como mínimo",
				maxlength:"La dirección puede tener 60 caracteres como máximo"
			},
			email:{
				required:obligatorio,
				email:"No has introducido un email válido"
			},
			telefono:{
				required:obligatorio
			},
		}
	});
}