$(document).ready(Inicio);

var obligatorio = "Este campo es obligatorio";
var imageRegex = /([^\s]+(?=\.(jpg|gif|png))\.\2)/gm;
var dniRegex = /^\d{8}[a-zA-Z]{1}$/;
var telRegx = /^[9|6]{1}([\d]{2}[-]*){3}[\d]{2}$/;
var ccRegx = /[a-zA-Z]{2}[0-9]{2}[a-zAZ0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,16}/;

function ValTel(telefono) {
	return telefono.match(telRegx);
}

function ValBanco(cc) {
	return cc.match(ccRegx);
}

function FotoCorrecta(foto) {
	return foto.match(imageRegex);
}

function DniCorrecto (dni, c) {

	var numeros = dni.substr(0, dni.length-1);

	var letras = "TRWAGMYFPDXBNJZSQVHLCKE";

	var modulo = numeros % 23;
	var l_correcta = letras.substr(modulo, 1);

    return this.optional(c) || dni.match(dniRegex) && (l_correcta == dni.substr(dni.length-1, 1).toUpperCase());

}

$.validator.addMethod("telefono",ValTel,"No es un teléfono válido, comprueba que empieza por 6 o 9");
$.validator.addMethod("cc",ValBanco,"No es un número de cuenta bancaria válido, comprueba que sea un IBAN correcto");
$.validator.addMethod("letraDNI", DniCorrecto, "Error, la letra del DNI no es correcta");
$.validator.addMethod("valfoto",FotoCorrecta,"Formato no válido, use .jpg .gif o .png");


function Inicio() {
	$("#validaTrabajador").validate({
		success:"verde",
		errorClass:"rojo",
		rules:{
			usuario:{
				required:true,
				minlength:5,
				maxlength: 20
			},
			pass:{
				required:true,
				minlength:10,
				maxlength: 20
			},
			nombre:{
				required:true,
				minlength:5,
				maxlength: 20
			},
			apellidos:{
				required:true,
				minlength:10,
				maxlength: 50
			},
			dni:{
				required:true,
				letraDNI:true
			},
			fecha:{
				date:true
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
			cc:{
				required:true,
				cc:true
			},
			ss:{
				required:true,
				maxlength:12,
				minlength:12
			}
		},
		messages:{
			usuario:{
				required:obligatorio,
				minlength:"El nombre de usuario debe tener 5 caracteres como mínimo",
				maxlength:"El nombre de usuario puede tener 20 caracteres como máximo"
			},
			pass:{
				required:obligatorio,
				minlength:"La contraseña debe tener 10 caracteres como mínimo",
				maxlength:"La contraseña puede tener 20 caracteres como máximo"
			},
			nombre:{
				required:obligatorio,
				minlength:"El nombre debe tener 5 caracteres como mínimo",
				maxlength:"El nombre puede tener 20 caracteres como máximo"
			},
			apellidos:{
				required:obligatorio,
				minlength:"Los apellidos deben tener 10 caracteres como mínimo",
				maxlength:"Los apellidos pueden tener 50 caracteres como máximo"
			},
			dni:{
				required:obligatorio
			},
			fecha:{
				date:"Fecha no válida, ej: 03/29/1995"
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
			cc:{
				required:obligatorio
			},
			ss:{
				required:obligatorio,
				maxlength:"El número de la seguridad social no puede tener más de 12 caracteres",
				minlength:"El número de la seguridad social debe tener 12 caracteres"
			}
		}
	});
}