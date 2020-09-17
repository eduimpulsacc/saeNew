<?php header("Access-Control-Allow-Origin: *");?>
<script type="text/javascript" src="../../admin/clases/jquery/jquery.js"></script>
<script>


function pruebaEdugestorAtraso(){
var url = "https://www.comunicapp.cl/api_partners/reporteAtraso";
var token= "RWR1SW1wdWxzYQ==";
var rbd = 555;
var curso = [280];
var alumno = ["24764512_10:00:34", "23811987_x","24291446_10:30:50"];
var user = 13907900;
var fecha = "2019-06-03";
var hora = "10:00:00";
var modo = "Alumno Especifico";
var user_name = "Rodrigo Monte";
var user_type = "Admin"
var texto = "Prueba Mensaje Atraso";

var sendInfo = {
           token: token,
           rbd: rbd,
           curso: curso,
		   alumno: alumno,
		   user: user,
		   modo: modo,
		   fecha: fecha,
		   user_name: user_name,
		   user_type: user_type,
		   texto: texto
       };

      $.ajax({
    // En data puedes utilizar un objeto JSON, un array o un query string
    data: sendInfo,
    //Cambiar a type: POST si necesario
    type: "POST",
    // Formato de datos que se espera en la respuesta
    dataType: "json",
    // URL a la que se enviará la solicitud Ajax
    url: url,
})
 .done(function( data, textStatus, jqXHR ) {
     if ( console && console.log ) {
         console.log( "La solicitud se ha completado correctamente." );
     }
 })
 .fail(function( jqXHR, textStatus, errorThrown ) {
     if ( console && console.log ) {
         console.log( "La solicitud ha fallado: " +  textStatus);
     }
});
}	


$( document ).ready(function() {
   pruebaEdugestorAtraso();
});

</script>
<div id="resultado"></div>