
<script type="text/javascript" src="../../admin/clases/jquery/jquery.js"></script>
<script>

$( document ).ready(function() {
	
   listaCol();
  // listaAno();
});

function listaCol(){
var funcion=1;
var parametros = "funcion="+funcion;
	  $.ajax({
			url:"con_armar.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
					if(data == 0){
					   alert("Error al cargar");
					}else{
					 $("#rr").html(data);
					}
		        }
		    })

}
function listaAno(){
var funcion=2;
var rdb = $('#rdb').val();
var parametros = "funcion="+funcion+"&rdb="+rdb;
	  $.ajax({
			url:"con_armar.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
					if(data == 0){
					   alert("Error al cargar");
					}else{
					 $("#aa").html(data);
					}
		        }
		    })

}



function listaEnse(){
var funcion=3;
var rdb = $('#rdb').val();
var ano = $('#ano').val();
var parametros = "funcion="+funcion+"&ano="+ano+"&rdb="+rdb;
	  $.ajax({
			url:"con_armar.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
					if(data == 0){
					   alert("Error al cargar");
					}else{
					 $("#ee").html(data);
					}
		        }
		    })

}

function listaGrado(){
var funcion=4;
var rdb = $('#rdb').val();
var ano = $('#ano').val();
var ense = $('#ensenanza').val();
var parametros = "funcion="+funcion+"&ano="+ano+"&rdb="+rdb+"&ense="+ense;

	  $.ajax({
			url:"con_armar.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
					if(data == 0){
					   alert("Error al cargar");
					}else{
					 $("#gg").html(data);
					}
		        }
		    })

}
function listaLetra(){
var funcion=5;
var rdb = $('#rdb').val();
var ano = $('#ano').val();
var ense = $('#ensenanza').val();
var grado = $('#grado').val();
var parametros = "funcion="+funcion+"&ano="+ano+"&rdb="+rdb+"&ense="+ense+"&grado="+grado;
	  $.ajax({
			url:"con_armar.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
					if(data == 0){
					   alert("Error al cargar");
					}else{
					 $("#ll").html(data);
					}
		        }
		    })

}

</script>
<form action="validar.php" method="post">
<table width="50%" border="0">
  <tr>
    <td width="17%">Instituci&oacute;n</td>
    <td width="83%"><div id="rr"></div></td>
  </tr>
  <tr>
    <td>A&ntilde;o</td>
    <td><div id="aa"></div></td>
  </tr>
  <tr>
    <td>Tipo Ense&ntilde;anza</td>
    <td><div id="ee"></div></td>
  </tr>
  <tr>
    <td>Grado</td>
    <td><div id="gg"></div></td>
  </tr>
  <tr>
    <td>Letra</td>
    <td><div id="ll"></div></td>
  </tr>
  <tr>
    <td>Mes</td>
    <td><select name="mes">
     <!-- <option value="01">Enero</option>
      <option value="02">Febrero</option>-->
      <option value="03">Marzo</option>
      <option value="04">Abril</option>
      <option value="05">Mayo</option>
      <option value="06">Junio</option>
      <option value="07">Julio</option>
      <option value="08">Agosto</option>
      <option value="09">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option>
      <option value="12">Diciembre</option>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="submit" value="enviar" /></td>
  </tr>
</table><br><br><br>
</form>