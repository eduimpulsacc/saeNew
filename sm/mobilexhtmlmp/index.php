<!DOCTYPE html PUBLIC "_//WAPFORUM//DTD XHTML Mobile 1.2//EN"    "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=utf-8" />
<title>Sae Mobile 1.0</title>

<!--<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SAE</title>--> 

<!--<html>
<head>-->

<style type="text/css">

  body{
   margin:0px; 
  }
	
  #cabezara {
   background-color: #FFFFCC;
   background-image: url(Fondo_Header_Movil.png);
   height:50px;	   
  }

  #footer {
	background-color: #FFFFCC;
    background-image: url(Fondo_Footer_Movil.png);
	padding:10px;
	color:#FF6600;
	margin-top:5px;
	height:120px;
   }

   form{ margin:5px; }

   .enlace {
	 background-color: #CCC;
	 display: inline-block; 
 	 padding:10px;
	 margin:5px; 
	 color: #fff; 
	 text-decoration: none;
	 font-size:14px;
	 font-family:Arial, Helvetica, sans-serif;
	 
	 -moz-border-radius: 5px; 
	 -webkit-border-radius: 5px;
	
	 -moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	 -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	 
	 text-shadow: 0 -1px 1px rgba(0,0,0,0.25);
	 border-bottom: 1px solid rgba(0,0,0,0.25);
	
	}

   .enlace:link { color: #fff; text-decoration:none;}
   .enlace:hover { background-color:#F60; color: #fff; }
   .enlace:active { top: 1px; }      
	
</style>
</head>
<body>

  <div id="cabezara" align="justify" >

  </div>
   
<div id="contenido" align="center" >

    <div align="center" style="margin:0px; margin-top:15px;" >
    <!--style="margin:1px"-->
    <img src="logosaemovil.png" width="283" height="73" />
    </div>
    
<form action="../inicio/chkuser.php" method="post" name="frm" id="frm" >

<table> 
<tr>
<td><strong><label for="nombre_usuario">Usuario : </label></strong></td>
<td>
<input name="nombre_usuario" id="nombre_usuario" type="text" value="" maxlength="8"  />
</td>
</tr>    
<tr>
<td><strong><label for="password">Contrase&ntilde;a : </label></strong></td>
<td>
<input name="password" id="password" type="password" value="" maxlength="8"  />
</td>
</tr>
<tr>
<td colspan="2">    
<input class="enlace" type="submit" name="Enviar" id="Enviar" value="        Conectar        " >
</td>
</tr>    
<!--<a class="enlace" href="#" onclick="javascript: document.forms['frm'].submit();" >Conectar</a>-->
</table>    

</form>
    
   </div>
   
   <div align="center" id="footer" >
   <br/>
   <p style="font-size:10px"> 
   <a href="mailto:info@colegiointeractivo.com?subject=Consulta%20desde%20SaeMovil">contacto@eduimpulsa.com</a>
   </p>
   <p style="font-size:10px">
   <a href="tel:28293350">Fono : ( 56-2 ) 32411860</a>
   </p>
   <p style="font-size:10px"><a href="http://www.colegiointeractivo.com/">www.colegiointeractivo.cl</a></p>
   <p style="font-size:10px">Copyright Todos los Derechos Reservados</p>
   <br/>
   </div>

</body>
</html>