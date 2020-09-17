<?
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Documento sin t&iacute;tulo</title>
<script language="javascript" type="text/javascript">

function Cierre(){
	var usuario = <?=$_NOMBREUSUARIO;?>;
	var parametros = "funcion=1&usuario="+usuario;
	
	$.ajax({
	  url:'mod/cierre/cont_cierre.php',
	  data:parametros,
	  type:'POST',
		  success:function(data){
		 //alert(data);
			   if(data==0){
				   alert("Error de Sistema");
				   //cargartabla();
				}else{
					$('#proceso_cierre1').html(data);
				   	cierre_gral();
				}
		     }
      });
}

function cierre_gral(){
	var parametros = "funcion=2";
	
	$.ajax({
	  url:'mod/cierre/cont_cierre.php',
	  data:parametros,
	  type:'POST',
		  success:function(data){
			 // alert(data);
			   if(data==0){
				   alert("Error de Sistema2");
   				}else{
					$('#proceso_cierre').html(data);
				   	cierre_concepto(); 
				}
		     }
      });
	
}


function cierre_concepto(){
	var parametros = "funcion=3";
	
	$.ajax({
	  url:'mod/cierre/cont_cierre.php',
	  data:parametros,
	  type:'POST',
		  success:function(data){
			 // alert(data);
			   if(data==0){
				   alert("Error de Sistema3");
   				}else{
					$('#proceso_cierre').html(data);
				   	cierre_dimension();
				}
		     }
      });
	
}
function cierre_dimension(){
	var parametros = "funcion=4";
	//alert(parametros);
	$.ajax({
	  url:'mod/cierre/cont_cierre.php',
	  data:parametros,
	  type:'POST',
		  success:function(data){
			 // alert(data);
			   if(data==0){
				   alert("Error Proceso de Dimension");
   				}else{
					$('#proceso_cierre').html(data);
				   	cierre_funsion();
				}
		     }
      });
	
}
function cierre_funsion(){
	var parametros = "funcion=5";
	//alert(parametros);
	$.ajax({
	  url:'mod/cierre/cont_cierre.php',
	  data:parametros,
	  type:'POST',
		  success:function(data){
			 // alert(data);
			   if(data==0){
				   alert("Error Proceso de Funsion");
   				}else{
					$('#proceso_cierre').html(data);
				   	cierre_final();
				}
		     }
      });
	
}
function cierre_final(){
	var parametros = "funcion=6";
	//alert(parametros);
	$.ajax({
	  url:'mod/cierre/cont_cierre.php',
	  data:parametros,
	  type:'POST',
		  success:function(data){
			 // alert(data);
			   if(data==0){
				   alert("Error de Sistema6");
   			   }else{
					$('#proceso_cierre').html(data);
			   }
		   }
      });
	
}
function Elimina(){
	var usuario = <?=$_NOMBREUSUARIO;?>;
	var parametros = "funcion=10&usuario="+usuario;
	
	$.ajax({
	  url:'mod/cierre/cont_cierre.php',
	  data:parametros,
	  type:'POST',
		  success:function(data){
			   if(data==0){
				   alert("Error de Sistema7");
				   //cargartabla();
				}else{
					$('#proceso_cierre').html(data);
				    alert("DATOS ELIMINADOS");
				}
		     }
      });
}
</script>
</head>
<style>
#bloques{ margin:10px; margin-top:40px; margin-left:10%; text-align:left; width:80%; }
#proceso_cierre{  margin:10px; margin-top:25px; padding:15px;  }
#botton{ margin-top:10px; padding:15px; }
#nombre_bloque{ margin-top:15px; padding:3px; border:solid 1px; margin-bottom:5px; }
</style>
<body>

<div id="bloques" align="center"  class="textosimple"  >
<fieldset>
<legend>PROCESO DE CIERRE NIVEL NACIONAL</legend>

<br />
1.- El proceso consolidara todos los valores de cada concepto<br />
2.- Se debe tener cerrado el proceso para permitir  a los colegios generar sus procesos de cierre<br />

<div id="bottoncontrol" >
<br />
  <table width="37%" border="1" style="border-collapse:collapse" align="left">
    <tr>
      <td width="43%" class="textonegrita">A&ntilde;o Cierre</td>
      <td width="57%" class="textosimple"><?=date("Y");?>&nbsp;</td>
      </tr>
    <tr>
      <td class="textonegrita">Periodo Cierre</td>
      <td class="textosimple">&nbsp;</td>
      </tr>
    <tr>
      <td class="textonegrita">Fecha</td>
      <td class="textosimple"><?=date("d-m-Y");?>&nbsp;</td>
      </tr>
  </table>
  <br />
  <br />
  <br />
  <br />
<br>																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																
  <input name="creardoc" type="button" onClick="Cierre()" value="CERRAR PROCESO" class="botonXX"/>
<input name="creardoc" type="button" onClick="Elimina()" value="ELIMINAR PROCESO" class="botonXX"/>
</div>



<div id="proceso_cierre">
  <table width="90%" border="1" style="border-collapse:collapse" class="textonegrita">
    <tr>
      <td>PROCESO</td>
      <td>ESTADO</td>
    </tr>
    <tr>
      <td>Cierre de Proceso</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td> Cierre General</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Cierre de Conceptos</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Cierre de Dimensiones</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Cierre de Funciones</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>

<div id="botton" >
</div>

</fieldset>
</div>
</body>
</html>
