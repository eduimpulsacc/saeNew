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

$( "#datepicker" ).datepicker();	
	
 muestra();	
 $( "#tabs" ).tabs();

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
				<td>REGISTRO FINANCIERO</td>
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
      <br />
 <table width="90%" border="1" style="border-collapse:collapse"  align="center">
      
      
      <tr>
      <td width="23%" class="cuadro02">PRESUPUESTO TOTAL</td>
      <td class="cuadro01">$500.000.000</td>
      </tr>
      <TR>
      <td class="cuadro02">PRESUPUESTO ANUAL</td>
      <td class="cuadro01">$125.000.000</td>
      </TR>
      <tr>
      <td class="cuadro02">PRESUPUESTO A LA FECHA</td>
      <td class="cuadro01">$100.000.000</td>
      </tr>
      <tr>
      <td class="cuadro02">PRESUPUESTO TOTAL</td>
      <td class="cuadro01">$0</td>
      </tr>
      </table>
	  <br />
      
   <div id="tabs" style="width:90%; float:inherit; margin-left:40px;" align="center" >
  <ul>
    <li><a href="#tabs-1">AREA</a></li>
    <li><a href="#tabs-2">AMBITO</a></li>
  </ul>
  <div id="tabs-1">
  <table width="90%" style="border-collapse:collapse" border="1">
  <tr class="cuadro02">
  <td >FECHA</td>
  <td>DESCRIPCION GASTO</td>
  <td>MONTO</td>
  </tr>
  <tr class="cuadro01">
  <td>01-03-2013</td>
  <td>Mejora Area Informatica</td>
  <td>$50.000.000</td>
  </tr>
  <tr class="cuadro01">
  <td>01-19-1013</td>
  <td>Aula Virtual </td>
  <td>$10.000.000</td>
  </tr>
  </table>
  
  </div>
  <div id="tabs-2">
  <table width="90%" style="border-collapse:collapse" border="1">
  <tr class="cuadro02">
  <td >FECHA</td>
  <td>DESCRIPCION GASTO</td>
  <td>MONTO</td>
  </tr>
  <tr class="cuadro01">
  <td>05-03-2013</td>
  <td>Equipos Computacionales </td>
  <td>$50.000.000</td>
  </tr>
  <tr class="cuadro01">
  <td>07-10-1013</td>
  <td>Matematicas</td>
  <td>$10.000.000</td>
  </tr>
  </table>
  </div>
</div>
</div>
<div id="tabla_2">
	  
		<br />
	            
      <table width="90%" border="1" style="border-collapse:collapse"  align="center">
       <tr>
      <td width="23%" class="cuadro02">NOMBRE</td>
      <td width="77%" class="cuadro01"><input type="text" /></td>
      </tr>
      <tr>
      <td class="cuadro02">A&Ntilde;O</td>
      <td class="cuadro01"><select>
							<option>2013</option>
                            <option>2012</option>
                            <option>2011</option>
                            <option>2010</option>				      
                           </select> 
      </td>
      </tr>
      <tr>
      <td class="cuadro02">TIPO</td>
      <td class="cuadro01">Area<input type="radio" name="tipo" id="tipo" value="0" />&nbsp;&nbsp;  &Aacute;mbito<input type="radio" name="tipo" id="tipo" value="1" /></td>
      </tr>
      
       <tr>
      <td class="cuadro02">NOMBRE</td>
      <td>
      <select name="SE1" id="SE1">
      <option selected="selected">Sellecione</option>
      <option value="1">Gestion Curricular</option>
      <option value="1">Liderazgo</option>
      <option value="2">Convivencia</option>
      <option value="3">Recursos</option>
      </select></td>
      </tr>
      
      <tr>
      <td class="cuadro02">ESTRATEGIA PRINCIPAL</td>
      <td>
      <select name="SE1" id="SE1">
      <option selected="selected">Sellecione</option>
      <option value="1">Gestion Curricular</option>
      <option value="1">Liderazgo</option>
      <option value="2">Convivencia</option>
      <option value="3">Recursos</option>
      </select></td>
      </tr>
      
      <tr>
      <td class="cuadro02">ESTRATEGIA SECUNDARIA</td>
      <td>
      <select name="SE1" id="SE1">
      <option selected="selected">Sellecione</option>
      <option value="1">Gestion Curricular</option>
      <option value="1">Liderazgo</option>
      <option value="2">Convivencia</option>
      <option value="3">Recursos</option>
      </select></td>
      </tr>
      
      <tr>
      <td class="cuadro02">META</td>
      <td>
      <select name="SE2" id="SE2">
      <option selected="selected">Seleccione</option>
      <option value="1">Primera Meta</option>
      <option value="2">segunda Meta</option>
      <option value="3">Tercera Meta</option>
      </select>
      </td>
      </tr>
      
      <tr>
      <td class="cuadro02">ESPECIFICACION DE GASTOS</td>
      <td class="cuadro01"><textarea name="text_obj" id="text_obj" cols="40" rows="2" ></textarea></td>
      </tr>
      
      <tr>
      <td class="cuadro02">FECHA</td>
      <td class="cuadro01"><input type="text" id="datepicker" /></td>
      </tr>
      <tr>
      <td class="cuadro02">MONTO</td>
      <td class="cuadro01"><input type="text" name="txt_nombre" id="txt_nombre"></td>
      </tr>
      </table>      
</div>


<br /><br /><br /><br /><br /><br /><br />
</body>
</html>
