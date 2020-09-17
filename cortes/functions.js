//intervalo tiempo cambio img slide, 5 segundos, se llama a la función "avanzaSlide()"

/*$(document).ready(function() {
    
	$('#boton').click(function(e) {
    event.preventDefault();
		if($('#txtNOMBRE').val()=="")
	{
		alert("ESCRIBE UN NOMBRE !!!"); 
		return false;	
	}
	 
	
	
    });
	
	
	
});*/

setInterval('avanzaSlide()',4000);
 
//array con las clases para las diferentes imagenes
var arrayImagenes = new Array(".img1",".img2",".img3",".img4");
 
//variable que nos permitirá saber qué imagen se está mostrando
var contador = 0;
 
//hace un efecto fadeIn para mostrar una imagen
function mostrar(img){
	$(img).ready(function(){				
  		$(arrayImagenes[contador]).fadeIn(1500);		
	});
}
 
//hace un efecto fadeOut para ocultar una imagen
function ocultar(img){
	$(img).ready(function(){				
  		$(arrayImagenes[contador]).fadeOut(1500);		
	});
}
 
//función principal
function avanzaSlide(){
        //se oculta la imagen actual
	ocultar(arrayImagenes[contador]);
        //aumentamos el contador en una unidad
	contador = (contador + 1) % 4;
        //mostramos la nueva imagen
	mostrar(arrayImagenes[contador]);
}