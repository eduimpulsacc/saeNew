<?php 	require('../../../../../../util/header.inc');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<head>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =5;
	$_bot           =5;
	
	
?>
					

<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<style>
.td_temp{font:12px monospace; border:3px solid; text-align:center; height:1.5em; vertical-align:top}
.td_temp2{font:12px monospace; border:0px solid; text-align:center; height:1.5em; vertical-align:top }
#contEncCol{overflow:hidden; overflow-y:scroll; background:#99CCFF; vertical-align:top}
#encCol{}
#contEncFil{overflow:hidden; overflow-x:scroll; background:#FFFFFF; height:20em; vertical-align:top}
#contenedor{overflow:auto; height:20em; vertical-align:top; vertical-align:top}
#contenido{}
.tabla td{border:1px solid;  vertical-align:top}
.rell{ height:0; position:relative; top:-1em; z-index:0; bor der:1px solid red; vertical-align:top}
</style>
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
<link rel="stylesheet" type="text/css" href="../../../../../clases/jquery-ui-1.9.2.custom/css/smoothness/jquery-ui-1.9.2.custom.css">
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.tooltip.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/ui/jquery.ui.dialog.js"></script>

<script type="text/javascript">
$( document ).ready(function() {
   cargaCurso(<?php echo $ano ?>);
   cargaAno();
});

function cargaAno(ano){

var funcion=1;
var parametros = "funcion="+funcion;

	$.ajax({
	  url:'cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   $("#an").html(data);
	  }
	  })	
}
function cargaCurso(ano){

var funcion=2;
var parametros = "funcion="+funcion+"&ano="+ano;

	$.ajax({
	  url:'cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   $("#cc").html(data);
	  }
	  })	
}

function cargames(cur){

var ano = $("#cmb_ano").val();
var funcion=3;
var parametros = "funcion="+funcion+"&cur="+cur+"&ano="+ano;

	$.ajax({
	  url:'cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   $("#mm").html(data);
	  }
	  })	
}

function cargames(cur){

var ano = $("#cmb_ano").val();
var funcion=3;
var parametros = "funcion="+funcion+"&cur="+cur+"&ano="+ano;

	$.ajax({
	  url:'cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   $("#mm").html(data);
	  }
	  })	
}

function lista(){

var ano = $("#cmb_ano").text();
var str = $("#cmb_ano option:selected").text();
numano = str.split(" ");
numano = numano[0];
var curso = $("#cmb_curso").val();
var mes = $("#cmb_mes").val();
var iano = $("#cmb_ano").val();
var funcion=4;
var parametros = "funcion="+funcion+"&curso="+curso+"&ano="+ano+"&mes="+mes+"&numano="+numano+"&iano="+iano;

if(mes>0){
	
	$.ajax({
	  url:'cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   $("#tabla").html(data);
	  }
	  })
	}
	else{
		 $("#tabla").html("");
	}
}

function justifica(rut,fecha,tipo){
var funcion=5;
var anio =$("#cmb_ano").val();
var curso = $("#cmb_curso").val();

var parametros = "funcion="+funcion+"&rut="+rut+"&fecha="+fecha+"&anio="+anio+"&curso="+curso;

		if(tipo==1){	
		$.ajax({
			  url:'cont_justifica.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
			
		   $("#anota").html(data);
			 $("#anota").dialog({ 
		   closeOnEscape: false,
		   modal:true,
		   resizable: false,
		   Width: 450,
		   Height: 300,
		   minWidth: 450,
		   minHeight: 300,
		   maxWidth: 450,
		   maxHeight: 300,
		   show: "fold",
		   hide: "scale",
		   stack: true,
		   sticky: true,
		   position:"fixed",
		   position: "absolute",
			buttons: {
			 "Guardar Datos": function(){
				  guardaAtraso();
				   $(this).dialog("close");
				 } ,
			 "Cerrar": function(){
				$(this).dialog("close");
			  }
			}     
		  })
			   
			  
				
				  }
			  })
		
}//fin tipo 1
else{
 elimina(rut,fecha,anio,curso);
}//fin tipo 2

}
function elimina(rut,fecha,anio,curso){
var funcion=6;

var parametros = "funcion="+funcion+"&rut="+rut+"&fecha="+fecha+"&anio="+anio+"&curso="+curso;
	
	if(confirm("Seguro que quiere eliminar la justificacion de este atraso?")){
		$.ajax({
	  url:'cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  alert("Dato Eliminado");
		  lista();
	  }
	  })
	}
}


function  guardaAtraso(){
var funcion = 7;
var ano = $("#ano").val();	
var curso = $("#cmb_curso").val();
var fecha = $("#fecha").val();
var rut = $("#rut").val();
var text = $("#motivo").val();
var chk =($('#adj').is(':checked'))?1:0;


var parametros = "funcion="+funcion+"&ano="+ano+"&curso="+curso+"&fecha="+fecha+"&rut="+rut+"&text="+text+"&chk="+chk;
//alert (parametros);
		$.ajax({
	  url:'cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		  alert("Dato Guardado");
		  lista();
	  }
	  })



}

</script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53"  align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%">
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="1%" height="363" align="left" valign="top">
					  <table>
					  <tr> 
					  <td>&nbsp;
						</td>
						</tr>
						</table>
					  </td>
					
                      <td width="85%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top" colspan="50"><? include("../../../../../../cabecera/menu_superior.php"); ?></td>
                          </tr>
                          <tr> 
						  <td valign="top"> 
						  <table width="100%"><tr><td  valign="top" >
						 <?  $menu_lateral="3_1";?> <? include("../../../../../../menus/menu_lateral.php"); ?>
						 </td>
						 <td valign="top" width="100%"  class="cajaborde">
						 
<br>



 	<table width="650" border="0" cellspacing="0">
  <tr class="textonegrita">
    <td width="150">A&Ntilde;O ESCOLAR</td>
    <td width="8" align="center">:</td>
    <td width="76%"><div id="an">
    <select name="cmb_ano" class="ddlb_x">
    <option value="0">Seleccione...</option>
    </select>
    </div></td>
  </tr>
  <tr class="textonegrita">
    <td width="150">CURSO</td>
    <td width="8" align="center">:</td>
    <td><div id="cc"><select name="cmb_curso" class="ddlb_x">
    <option value="0">Seleccione...</option>
    </select></div></td>
  </tr>
  <tr class="textonegrita">
    <td width="150">MES</td>
    <td width="8" align="center">:</td>
    <td><div id="mm"><select name="cmb_mes" class="ddlb_x">
    <option value="0">Seleccione...</option>
    </select></div></td>
  </tr>
  <tr>
    <td width="150">&nbsp;</td>
    <td width="8">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right" class="cajamenu2"><input class="botonXX"  type="button" name="Button" value="VOLVER" onClick="location.href='../atrasos.php'" ></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="cajamenu2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="cajamenu2"><div align="center">NOTA: Para justificar un atraso, debe hacer clic sobre el día que requiera</div><br></td>
    </tr>
  <tr>
    <td colspan="3" align="center" ><table><tr><td class="textosesion"><img src="vb.gif"> JUSTIFICADOS</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="textosesion" valign="top"><img src="b_drop.png"> NO JUSTIFICADOS</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td class="tabla03" align="center" width="30">N&deg;</td><td class="textosesion">DIA DEL ATRASO</td></tr></table></td>
  </tr>
    </table>
 	<br>
<br>
<br>
<div id="tabla" style="padding-left:20px"></div>
<div id="anota" title="Justificaci&oacute;n Atraso" ></div>


							  
						 </td>
						 
						 </tr></table>
						  </td>
                            <td height="395" align="left" valign="top"> 
                     
						    </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
			    </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</td></tr></table>
</body>
</html>
