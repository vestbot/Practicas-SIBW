//Realizado por :Víctor Esteban Bota

//Fichero con el codigo javascript

// Para mostrar y esconder la barra de comentarios



function mostrar_comentarios(){
	var barra_com = document.getElementById("comentarios_producto");
	barra_com.classList.toggle("muestra_comentarios");  // con toggle lo que hacemos es cambiar entre dos clases, en este caso "seccion_comentarios" y "muestra_comentarios"
														// classList devuelve los nombres de clases CSS, podemos llamar tambn a add o remove a parte de toggle.

}

document.getElementById('comentarios').onclick = mostrar_comentarios;

// Envío del comentario del formulario y comprobación de los campos

function submit_comment(){
	var name = document.getElementById("nombre");
	var email = document.getElementById("email");
	var text = document.getElementById("texto-comentario");

	var campos_rellenados = true;
	var expr_mail = /^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
	

	if( nombre.value == ""){
		document.getElementById("error_modal").innerHTML = "El campo nombre está vacío";
		document.getElementById("myModal").style.display = "block";

		campos_rellenados = false;
	}

	if( text.value == ""){
		document.getElementById("error_modal").innerHTML = "El campo texto está vacío";
		document.getElementById("myModal").style.display = "block";

		campos_rellenados = false;
	}

	if( ! expr_mail.test(email.value)){
		document.getElementById("error_modal").innerHTML = "e-mail escrito con un formato incorrecto";
		document.getElementById("myModal").style.display = "block";

		campos_rellenados = false;
	}

	if(campos_rellenados){
		var d = new Date();
		var date = d.getDate() + "/" + d.getMonth() + "/" + d.getFullYear();
		var hour = d.getHours() + ":" + d.getMinutes();

		document.getElementById('parte_comentarios').insertAdjacentHTML("beforeend","<div class=\"comentario_pred\"" + "<p>" + nombre.value + " " + date + " " + hour + "</p>" + "<p>" + text.value + "</p>" + "</div>");
		document.getElementById("formulario").reset(); // para resetear el formulario una vez que añadimos un comentario
	}
}

//document.getElementById("enviar_comentario").onclick = submit_comment;



//Funcion para cambiar las palabras prohibidas

function cambiar_palabras(){
	
	var contador;
	var censuradas = [];

	//Creamos las palabras censuradas para el replace
	for(contador=0; contador < palabras_pro.length; contador++){
		censuradas.push('*'.repeat(palabras_pro[contador].length));
	}

	var comentario = document.getElementById("texto-comentario").value;

	var comentario_censurado = comentario;
	

	for(contador = 0; contador < palabras_pro.length ; contador++){
		comentario_censurado = comentario_censurado.replace(palabras_pro[contador],censuradas[contador]);		// reemplazamos cada palabra prohibida que encontremos por su censurada
	};

	document.getElementById("texto-comentario").value = comentario_censurado;
}

document.getElementById("texto-comentario").onkeypress = cambiar_palabras ;
document.getElementById("texto-comentario").onchange = cambiar_palabras;  // con estas dos llamadas cambiamos las palabras en tiempo de escritura


//Funciones del diálogo modal
// Cuando pulsamos en <span> (x), cerramos el modal
	document.getElementsByClassName("close")[0].onclick = function() {
	  document.getElementById("myModal").style.display = "none";
	}

	// Cuando pulsamos fuera del modal lo cerramos
	window.onclick = function(event) {
	  if (event.target == document.getElementById("myModal")) {
	    document.getElementById("myModal").style.display = "none";
	  }
	}

