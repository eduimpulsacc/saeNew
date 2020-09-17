<script>
//Volvemos a incluir la función, ya que solo esta en el archivo padre.
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
//Este es el destino que se pasa de la funcion cargarPagina de _script.js
<?php $destino = $_GET["destino"]; ?>
//Buscamos el div que contiene el pulldown hijo
var contenedor = MM_findObj( 'divContenido' );
var contenido = contenedor.innerHTML;
//Ahora buscamos el destino. Fijense en el window.parent.document.
var LayerDestino = MM_findObj( '<?php echo $destino;?>', window.parent.document );

//Para saber que esta pasando podemos descomentar el siguiente alert.
//Otra es poner el tamaño del iframe de index.php en tamaños visibles (ej, 400px) y ver en él, el error php.
//porque sepamos que si ocurre un error en php, este cortara el proceso y no llegara a esta parte, quedando siempre en un preload infinito.
//alert( contenido ); 

//Por ultimo nos resta mandar el contenido que reemplazara al preload.
LayerDestino.innerHTML = contenido;
</script>
