<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
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
<BR />
<table width='90%' border='0' align='center'>
  <tr class='Estilo19'>
    <td>AVANCES PROYECTO</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
	  <table width="90%" border="1" align="center" style="border-collapse:collapse">
      <tr>
        <td class="cuadro02" width="23%">TIPO</td>
        <td class="cuadro01" width="77%">&nbsp;<input name="" type="radio" value="" />AREA &nbsp;<input name="" type="radio" value="" />AMBITO</td>
      </tr>
    </table>
<br />
      <table width="90%" align="center" style="border-collapse:collapse" border="1">
      <tr align="center">
      <td class="cuadro02">ESTRATEGIA<br />
        PRINCIPAL</td>
      <td class="cuadro02">ESTRATEGIA<br />
        SECUNDARIA</td>
      <td class="cuadro02">PORCENTAJE</td>
      <td class="cuadro02" colspan="2">OPCIONES</td>
      </tr>
      <tr>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
       <td align="center"><img src="img/PNG-48/Modify.png" width="30" height="30" border="0" onclick="" onmouseover=this.style.cursor='pointer' title="MODIFICAR"></td>
				<td align="center"><img src="img/PNG-48/Add.png" width="30" height="30" alt="Eliminar" border="0" onClick="otratabla()" onmouseover=this.style.cursor='pointer' title="AGREGAR" ></td>
      </tr>
      </table>
      

</div>


<div id="tabla_2">
<table width='90%' border='0' align='center'>
  <tr>
    <td align='right'>
&nbsp;<img src="img/PNG-48/Back.png" id="volver" width="30" height="30" onclick='atras()' onmouseover=this.style.cursor='pointer' title="VOLVER">
&nbsp;<img src="img/PNG-48/Save.png" id="agregar" width="30" height="30" onclick='otratabla()' onmouseover=this.style.cursor='pointer' title="MOSTRAR FORMULARIO">				  	   
<img src="img/PNG-48/Add.png" id="btn_agregar" width="30" height="30" onclick='guardar()' onmouseover=this.style.cursor='pointer' title="GUARDAR DATOS">		
  </td>
  </tr>
</table>

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
<br />

            
      <table width="90%" border="1" style="border-collapse:collapse"  align="center">
      <tr>
        <td width="23%" class="cuadro02">AREA</td>
        <td width="77%" class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
        <td class="cuadro02">ESTRATEGIA PRINCIPAL</td>
        <td width="77%" class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
        <td width="23%" class="cuadro02">ESTRATEGIA SECUNDARIA</td>
        <td width="77%" class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
      <td width="23%" class="cuadro02">FECHA</td>
      <td width="77%" class="cuadro01">&nbsp;</td>
      </tr>
      
      <tr>
      <td width="23%" class="cuadro02">AVANCE</td>
      <td width="77%" class="cuadro01"><textarea name="text_obj" id="text_obj" cols="40" rows="2" ></textarea></td>
      </tr>
      
      <tr>
      <td width="23%" class="cuadro02">PORCENTAJE</td>
      <td class="cuadro01"><input type="text" name="txt_nombre" id="txt_nombre" size="10" />
        %</td>
      </tr>
      </table>      
</div>            
      <BR />      
 </body>
</html>
