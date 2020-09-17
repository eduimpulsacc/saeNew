<style type="text/css">
<!--
body,td,th {
	color: #00FF00;
}
body {
	background-color: #000000;
}
-->
</style>
<script language="JavaScript" src="admin/clases/ajax.js"></script>
<script type="text/JavaScript">

function enviodatos() {  // INICIO

alert('Enviando Datos');

	    ajax = nuevoAjax();
		
		var divimg = document.getElementById('respuesta'); 
		var rbd  = document.getElementById('rbd').value; 
	    var periodo  = document.getElementById('periodo').value; 
		var ramo  = document.getElementById('ramo').value; 

		ajax.open("POST","/proceso_rutina_notas77.php",true);

		  divimg.innerHTML=""
		  divimg.innerHTML='<img src="admin/clases/img_jquery/loading.gif">';
					
		  ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
				
					divimg.innerHTML=ajax.responseText; // Muestra resultados
				 
			         }else  { divimg.innerHTML='<img src="admin/clases/img_jquery/loading.gif">'; }
														  
		  } 
		
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("rbd="+rbd+"&periodo="+periodo+"&ramo="+ramo)
		
		} // TERMINA CREAR SELECT
		
		
		
</script>
<br><br>
<table align="center" id="formulario" border="1" style="border-collapse:collapse" >
<tr>
<th colspan="2">Rutina para Cargar Respaldo</th>
</tr>
<tr><td >
  <form name="form1" onSubmit="">
    <label>RBD:
      <input name="rbd" type="text" tabindex="1" maxlength="10">
    </label>
    <p>
      <label>ID PERIODO:
        <input name="periodo" type="text" tabindex="2" maxlength="10">
      </label>
    </p>
    <p>
      <label>ID RAMO:
        <input name="ramo" type="text" tabindex="3" maxlength="10">
      </label>
    </p>
    <p>
      <label>Generar Consulta:
        <input type="button" name="Submit" value="OK" tabindex="4" onClick="enviodatos()">
      </label>
    </p>
  </form>
<td></tr>  
</table>
<br>
<div id="respuesta" align="center"> &nbsp;</div>