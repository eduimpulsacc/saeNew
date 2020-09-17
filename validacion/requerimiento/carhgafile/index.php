<?php session_start();

$_SESSION['_ICLS']=$icls;

//var_dump($_SESSION);
 ?>
<link href="../../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
   <script type="text/javascript" src="../../../admin/clases/jquery/jquery.js"></script>
    <script type="text/javascript" src="functions.js"></script>
 
<style type="text/css">
    .messages{
        /*float: left;*/
        font-family: sans-serif;
       /* display: none;*/
		width:auto;
		text-align:center;
		
    }
    .info{
        padding: 10px;
        border-radius: 10px;
        background: orange;
        color: #fff;
        font-size: 14px;
        text-align: center;
		
		line-height: 300%;
    }
    .before{
        padding: 10px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 14px;
        text-align: center;
		width:100%;
    }
    .success{
        padding: 10px;
        border-radius: 10px;
        background: green;
        color: #fff;
        font-size: 14px;
        text-align: center;
		line-height: 300%;
		
		
    }
    .error{
        padding: 10px;
        border-radius: 10px;
        background: red;
        color: #fff;
        font-size: 14px;
        text-align: center;
		
    }




</style>


    <!--el enctype debe soportar subida de archivos con multipart/form-data-->
    <form enctype="multipart/form-data" class="formulario">
    <table width="85%" border="0" align="center" cellspacing="0">
  <tr class="cuadro02">
    <td colspan="2" align="center">CARGA ARCHIVOS EVALUACI&Oacute;N</td>
    </tr>
  <tr>
    <td width="24%">&nbsp;</td>
    <td width="76%">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">Subir un archivo</td>
    <td class="cuadro01"><input name="archivo" type="file" id="imagen" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" value="Subir Archivo" id="car" disabled="disabled" class="botonXX" /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">  <!--div para visualizar mensajes-->
    <div class="messages" align="center" >
    <span class='info'>&nbsp;</span><br>
    <span class='info'>&nbsp;</span>
    </div>
    <!--div para visualizar en el caso de imagen-->
    <div class="showImage" align="center"></div></td>
    </tr>
    </table>

     
    </form>
  
    