<?php
echo "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ambito Y Gesti&aocute;n</title>
<script type="text/javascript" language="javascript">


$(document).ready(function(){
	
 muestra();	

})

function muestra()
{
	$('#tabla_2').hide();	
	$('#volver').hide();
	$('#btn_agregar').hide();
	
	
}

function otratabla()
{
		$('#btn_agregar').show();
		$('#volver').show();
		$('#tabla_2').show();
		$('#tabla_1').hide();
		$('#agregar').hide();
		
}

function atras()
{
	$('#tabla_2').hide();
	$('#tabla_1').show();	
	$('#volver').hide();
	$('#btn_agregar').hide();
	$('#agregar').show();
}


function guardar()
{
	if($('#txt_nombre').val()=="")
	{
		alert("Llenar todos los Datos");
		$('#txt_nombre').focus();
		return false;
	}	
}

</script>
</head>
<body>
<br />
<table width='90%' border='0' align='center'>
			  <tr class='Estilo19'>
				<td>&Aacute;MBITO Y GESTI&Oacute;N</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td align='right'>
       &nbsp;<img src="img/PNG-48/Back.png" id="volver" width="30" height="30" onclick='atras()' onmouseover=this.style.cursor='pointer' title="VOLVER">
       &nbsp;<img src="img/PNG-48/Save.png" id="agregar" width="30" height="30" onclick='otratabla()' onmouseover=this.style.cursor='pointer' title="MOSTRAR FORMULARIO">				  	   
       <img src="img/PNG-48/Add.png" id="btn_agregar" width="30" height="30" onclick='guardar()' onmouseover=this.style.cursor='pointer' title="GUARDAR DATOS">		
              </td>
			  </tr>
			</table>

<div id="tabla_1">
 <table width="90%" border="1" style="border-collapse:collapse"  align="center">
      <tr>
      <td width="23%" class="cuadro02">NOMBRE</td>
      <td width="77%" class="cuadro01">PRIMER PROYECTO</td>
      </tr>
      <tr>
      <td class="cuadro02">A&Ntilde;O</td>
      <td class="cuadro01">2013</td>
      </tr>
      </table>
      
      <br /><br /><br />
	  
      <table width="90%" align="center" style="border-collapse:collapse" border="1">
      <tr align="center">
      <td class="cuadro02">TIPO</td>
      <td class="cuadro02">NOMBRE</td>
      <td class="cuadro02">OBJETIVO</td>
      <td class="cuadro02" colspan="2">OPCIONES</td>
      </tr>
      <tr>
      <td class="cuadro01">Mejora</td>
      <td class="cuadro01">Mejora SIMCE</td>
      <td class="cuadro01">Mejorar el rendimiento de todos los cursos que lo rinden</td>
       <td align="center"><img src="img/PNG-48/Modify.png" width="30" height="30" border="0" onclick="" onmouseover=this.style.cursor='pointer' title="MODIFICAR"></td>
				<td align="center"><img src="img/PNG-48/Delete.png" width="30" height="30" alt="Eliminar" border="0" onClick="" onmouseover=this.style.cursor='pointer' title="ELIMINAR"></td>
      </tr>
      </table>
      

</div>


<div id="tabla_2">

            
      <table width="90%" border="1" style="border-collapse:collapse"  align="center">
      <tr>
      <td class="cuadro02">TIPO</td>
      <td class="cuadro01">&Aacute;mbito<input type="radio" name="tipo" id="tipo" value="0" />&nbsp;&nbsp;  Gesti&oacute;n&nbsp;<input type="radio" name="tipo" id="tipo" value="1" /></td>
      </tr>
      
      <tr>
      <td class="cuadro02">NOMBRE</td>
      <td class="cuadro01"><input type="text" name="txt_nombre" id="txt_nombre" size="63"></td>
      </tr>
      
      <tr>
      <td class="cuadro02">OBJETIVO</td>
      <td class="cuadro01"><textarea name="text_obj" id="text_obj" cols="40" rows="2" ></textarea></td>
      </tr>
      </table>      
</div>



<br /><br /><br /><br /><br /><br /><br />
</body>
</html>
