<?php require('../../../../../../util/header.inc');
if ($id_ramo){
$_RAMO=$id_ramo;
if(!session_is_registered('_RAMO')){
session_register('_RAMO');
};
$_FRMMODO="mostrar";
}
if ($modificar){
$_FRMMODO="modificar";
}

if ($viene_de){
$_VIENEPAG=$viene_de;	
}


$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $_CURSO;	
	$ramo 			= $_RAMO;
	$caso			= $_CASO;
	$frmModo		= $_FRMMODO;
	
	$_POSP = 6;
	$_bot = 9;
	
	
	
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery-1.11.2.min.js"></script>

<style type="text/css">
<!--
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
-->
</style>
<script>

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
    window.open(theURL,winName,features);
    }

$(document).ready(function(){
	traeAno();
	traeRamo();
	traePeriodo();
});

function traeAno(){
var funcion=1;
var ano = $("#id_ano").val();

var funcion=1;
var parametros = "funcion="+funcion+"&ano="+ano

	$.ajax({
	  url:'cont_psintesis.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#ano").html(data);

		  }
	  })

}

function traeRamo(){
var funcion=2;
var id_ramo = $("#id_ramo").val();
var parametros = "funcion="+funcion+"&id_ramo="+id_ramo

	$.ajax({
	  url:'cont_psintesis.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#ramo").html(data);

		  }
	  })

}
function traePeriodo(){
var funcion=3;
var id_ano = $("#id_ano").val();
var parametros = "funcion="+funcion+"&id_ano="+id_ano

	$.ajax({
	  url:'cont_psintesis.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#periodo").html(data);

		  }
	  })	
	
}

function traeLista(){
var funcion=4;
var id_ano = $("#id_ano").val();
var id_ramo = $("#id_ramo").val();
var id_curso = $("#id_curso").val();
var id_periodo = $("#cmbPERIODO").val();
var nro_ano = $("#nro_ano").val();

var parametros = "funcion="+funcion+"&id_ano="+id_ano+"&id_ramo="+id_ramo+"&id_curso="+id_curso+"&id_periodo="+id_periodo+"&nro_ano="+nro_ano;

if(id_periodo!=0){
 $("#btng").html('<input name="modificar" type="button" id="modificar" value="MODIFICAR" class="botonXX"  onclick="modificaNota()"/>');

$.ajax({
	  url:'cont_psintesis.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#lista").html(data);

		  }
	  })
}else{
alert("DEBE SELECCIONAR UN PERIODO");
 $("#lista").html('');	
}
}

function modificaNota(){
var funcion=5;
var id_ano = $("#id_ano").val();
var id_ramo = $("#id_ramo").val();
var id_curso = $("#id_curso").val();
var id_periodo = $("#cmbPERIODO").val();
var nro_ano = $("#nro_ano").val();

var parametros = "funcion="+funcion+"&id_ano="+id_ano+"&id_ramo="+id_ramo+"&id_curso="+id_curso+"&id_periodo="+id_periodo+"&nro_ano="+nro_ano;

if(id_periodo!=0){
$("#btng").html('<input name="guardar" type="button" id="guardar" value="GUARDAR" class="botonXX"  onclick="guardaNota()"/>&nbsp;&nbsp;&nbsp;<input name="cancelar" type="button" id="cancelar" value="CANCELAR" class="botonXX" onclick="cancela()"/>');	
	
	
$.ajax({
	  url:'cont_psintesis.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
		
	    $("#lista").html(data);

		  }
	  })
	 }else{
alert("DEBE SELECCIONAR UN PERIODO");	
 $("#lista").html('');
} 
	 
}

function guardaNota(){
var funcion=6;
var form = $("#form").serialize();
var id_periodo = $("#cmbPERIODO").val();
var parametros = "funcion="+funcion+"&form="+form;
if(id_periodo!=0){
$.ajax({
	  url:'cont_psintesis.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	   // $("#lista").html(data);
	   alert("DATOS GUARDADOS");
		 traeLista();
		 $("#btng").html('<input name="modificar" type="button" id="modificar" value="MODIFICAR" class="botonXX"  onclick="modificaNota()"/>');
		  }
	  })
	}else{
	alert("DEBE SELECCIONAR UN PERIODO");
	$("#lista").html('');	
	} 	
}

function limpiar(){
var funcion=7;	
var id_ramo = $("#id_ramo").val();
var id_periodo = $("#cmbPERIODO").val();
var parametros = "funcion="+funcion+"&id_ramo="+id_ramo+"&id_periodo="+id_periodo;
if(id_periodo!=0){
	
	if(confirm("¿DESEA ELIMINAR LAS PRUEBAS SINTESIS DE ESTE CURSO?")){
		$.ajax({
	  url:'cont_psintesis.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
		// alert(data);
	   // $("#lista").html(data);
	     alert("NOTAS ELIMINADAS");
		 traeLista();
		 }
	  })
	}
	
		
}else{
	alert("DEBE SELECCIONAR UN PERIODO");
	$("#lista").html('');	
} 

}

function rango(valor){
var nota = $("#nota"+valor+"").val();

if(nota<10 || nota>70){
alert("VALOR INVALIDO");
$("#nota"+valor+"").val('');
}
}

function cancela(){
	traeLista();
}

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" class="cajaborde">
                  <tr>
                    <td><form name="form" id="form" method="post" action="">
                      <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr align="left" valign="top">
                        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" class="cajaborde">
                                  <tr>
                                    <td><table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr>
                                        <td width="%" class="textonegrita"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
                                            <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr align="left" valign="top">
                                                <td height="75" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                  <tr align="left" valign="top">
                                                    <td width="100%" height="75" valign="middle"><?   include("../../../../../../cabecera/menu_superior.php");?></td>
                                                  </tr>
                                                </table></td>
                                              </tr>
                                              <!-- FIN DE COPIA DE CABECERA -->
                                            </table></td>
                                          </tr>
                                          <tr align="left" valign="top">
                                            <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                                              <tr>
                                                <td width="27%" height="363" align="left" valign="top"><table>
                                                  <tr>
                                                    <td><? 
				  $menu_lateral="3_1";
				  include("../../../../../../menus/menu_lateral.php"); ?></td>
                                                  </tr>
                                                </table></td>
                                                <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                  <tr>
                                                    <td align="left" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" class="cajaborde">
                                                      <tr>
                                                        <td><input name="ff" type="hidden" id="ff" />
                                                          <input name="id_ramo" type="hidden" id="id_ramo" value="<?=$ramo;?>" />
                                                          <input name="id_ano" type="hidden" id="id_ano" value="<?=$ano;?>" />
                                                          <input name="id_curso" type="hidden" id="id_curso" value="<?=$curso;?>" />
                                                          <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
                                                            <tr>
                                                              <td width="%" class="textonegrita">A&Ntilde;O</td>
                                                              <td width="%" class="textonegrita">:</td>
                                                              <td width="%" class="Estilo12"><div id="ano"></div></td>
                                                            </tr>
                                                            <tr>
                                                              <td class="textonegrita">CURSO</td>
                                                              <td class="textonegrita">:</td>
                                                              <td class="Estilo12"><? echo CursoPalabra($curso,1,$conn);?></td>
                                                            </tr>
                                                            <tr>
                                                              <td class="textonegrita">ASIGNATURA</td>
                                                              <td class="textonegrita">:</td>
                                                              <td class="Estilo12"><div id="ramo"></div>
                                                                <?=$nombre_ramo;?></td>
                                                            </tr>
                                                            <tr>
                                                              <td class="textonegrita">PERIODO</td>
                                                              <td class="textonegrita">:</td>
                                                              <td class="Estilo12"><div id="periodo"></div></td>
                                                            </tr>
                                                          </table>
                                                          <br />
                                                          <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
                                                            <tr>
                                                              <td align="right">
                                                                
                                                                
                                                                <input name="volver" type="button" id="volver" value="VOLVER" class="botonXX" onclick="window.location='../listarRamos.php3'"/>
<input name="LIMPIAR" type="button" id="LIMPIAR" value="LIMPIAR" class="botonXX"  onclick="limpiar()"/>
                                                                <span id="btng">
                                                                  <!-- <input name="modificar" type="button" id="modificar" value="MODIFICAR" class="botonXX"  onclick="modificaNota()"/>-->
                                                                </span>
                                                               </td>
                                                            </tr>
                                                          </table>
                                                          <br />
                                                          <table width="80%" border="0" cellspacing="3" cellpadding="0" align="center">
                                                            <tr>
                                                              <td class="tablatit2-1"><div align="center">PRUEBA SINTESIS</div></td>
                                                            </tr>
                                                          </table>
                                                          <br />
                                                          <div id="lista"></div></td>
                                                      </tr>
                                                    </table></td>
                                                  </tr>
                                                </table></td>
                                              </tr>
                                              <tr align="center" valign="middle">
                                                <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                                              </tr>
                                            </table></td>
                                          </tr>
                                        </table></td>
                                        </tr>
                                    </table></td>
                                    </tr>
                                  </table></td>
                                </tr>
                            </table></td>
                            </tr>
                          </table></td>
                      </tr>
                      </table>
                    </form></td>
                    </tr>
                  </table></td>
                </tr>
            </table></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>
 <? pg_close($conn)?>
