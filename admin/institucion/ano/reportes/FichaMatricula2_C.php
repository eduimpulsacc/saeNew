<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

$ob_reporte = new Reporte;
$ob_membrete = new Membrete;





?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../cortes/8933/estilos.css >" rel="stylesheet" type="text/css">

	<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{
page-break-after:always;
}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px;}
-->
    </style>
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
	
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (document.form.cmb_curso.value!=0){				
				document.form.action = "ficha_matricula.php3";
				document.form.submit();
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
		function envia(){
			document.form.action="ficha_matricula.php3";
			document.form.ssww.value=1;
			document.form.submit();
		}	
									
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
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
//-->
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="610" height="160" border="0">
 <tr>
 <td height="28" colspan="2" align="right">
  <div id="capa0">
<table width="100%">
  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
<td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	    </td></tr></table>
     
      </div>
</td>

  </tr>
  <tr>
   
    <td width="589"><table width="600" border="0" cellspacing="0" cellpadding="0" class="salto">
      <tr>
        <td>&nbsp;</td>
        <td width="26%"><table width="100%" align="left">
            <tr>
              <td>CURSO</td>
              <td></td>
              <td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr>
              <td>NIVEL</td>
              <td></td>
            </tr>
            <tr>
              <td>AÑO </td>
              <td></td>
            </tr>
          </table>                 </td>
      </tr>
      <tr>
        <td colspan="2"><table align="center">
            <tr>
              <td><b>FICHA DE MATRICULA</b> </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table  width="100%">
            <tr>
              <td>                Nº de Matricula_________________________</td>
              <td align="right"><div align="left">
                  <table width="1%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap><div align="center">Fecha de Matr&iacute;cula</div></td>
                      <td rowspan="2">&nbsp;_____________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <div align="left"></div></td>
                    </tr>
                  </table>
              </div>              </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><b><br>
          DATOS ALUMNO
        </b></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td valign="bottom"><br>
                ___________________________________ <br>
                <b></b> Apellido paterno </td>
              <td valign="bottom"><br>
                ___________________________________ <br>
                <b></b> Apellido Materno </td>
              <td valign="bottom"><br>
                ___________________________________ <br>
                <b></b> Nombre</td>
            </tr>
            <tr>
              <td valign="bottom"><br>
                ___________________________________ <br>
                <b></b> Fecha de Nacimiento </td>
              <td valign="bottom"><br>
                ___________________________________ <br>
                <b></b> RUN</td>
              <td valign="bottom"><br>
                ___________________________________ <br>
                <b></b>Sistema Salud </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><br>
                ___________________________________ <br>
                <b></b>Direccion</td>
              <td><br>
                ___________________________________ <br>
                <b></b>Comuna</td>
              <td><br>
                ___________________________________ <br>
                <b></b>Ciudad</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><b><br>
          DATOS PADRES        </b></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><br>
                _______________________________ <br>
                Nombre Padre </td>
              <td><br>
                _________________ <br>
                RUT</td>
              <td><br>
                _________________________ <br>
                Profesion</td>
              <td><br>
                _______________________<br>
                Nivel Educacion </td>
              <td><br>
                _________________ <br>
                Renta</td>
            </tr>
            <tr>
              <td><br>
                _______________________________ <br>
                Nombre Madre </td>
              <td><br>
                _________________<br>
                RUT</td>
              <td><br>
                _________________________<br>
                Profesion</td>
              <td><br>
                ______________________<br>
                Nivel Educacion </td>
              <td><br>
                _________________ <br>
                Renta</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table width="40%" align="right">
            <tr>
              <td width="40%">Relacion padres</td>
              <td width="40%"><table width="1%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td nowrap>Vivienda propia </td>
                    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td nowrap>Vivienda Arrendada&nbsp;&nbsp; </td>
                    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td nowrap>Vivienda Cedida </td>
                    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><b>          DATOS APODERADOS
        </b></td>
      </tr>
      <tr>
        <td colspan="2"><table width="30%" border="0" cellpadding="1" cellspacing="0">
            <tr>
              <td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td>&nbsp;&nbsp;</td>
                  </tr>
              </table></td>
              <td><br>
                ___________________________________ <br>
                Padre</td>
              <td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td>&nbsp;&nbsp;</td>
                  </tr>
              </table></td>
              <td><br>
                ___________________________________ <br>
                Madre</td>
              <td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                  </tr>
              </table></td>
              <td><br>
                ______________________________________________<br>
                Apoderado Suplente </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%">
            <tr>
              <td><br>
                _____________________<br>
                Nombre</td>
              <td><br>
                ____________<br>
                RUT</td>
              <td><br>
                ___________________________________ <br>
                Direccion</td>
              <td><br>
                ________________ <br>
                Comuna</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="20%"><br>
                ____________ <br>
                Telefono</td>
              <td width="20%"><br>
                ____________ <br>
                Celular</td>
              <td width="20%"><br>
                ___________________<br>
                Telefono Recados </td>
              <td width="20%"><br>
                ____________<br>
                Fax</td>
              <td width="20%"><br>
                ________________________ <br>
                E-mail</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td ><b><br>
          OTROS<br>
        </b></td>
      </tr>
      <tr>
        <td width="74%" height="30" >Procedencia del Alumno _____________________________ _________________________________ </td>
      </tr>
      <tr>
        <td height="30" >Personas con quien vive el alumno: ____________________________________________________________ </td>
      </tr>
      <tr>
        <td height="30" cols&npan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><br>
          Tiene algun problema de salud significativo __________________________________________________________________________________<br></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%">
            <tr>
              <td valign="bottom"><br>
                ___________________________<br>
                N&ordm; Boleta C.G.P.A </td>
              <td valign="bottom"><br>
                __________________________<br>
                Monto Cancelado </td>
              <td valign="bottom"><br>
                ________________<br>
                Fecha Cancelacion </td>
            </tr>
          </table>
            <br>
            <br>        </td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><table width="70%">
            <tr>
              <td valign="top">Solicita</td>
              <td valign="top" nowrap>1.- Almuerzo Escolar</td>
              <td width="1%" valign="top"><table>
                  <tr>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>Si</td>
                    <td>No</td>
                  </tr>
              </table></td>
              <td valign="top" nowrap>2 Entrega Certificado de Nacimiento </td>
              <td width="1%" valign="top"><table>
                  <tr>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>Si</td>
                    <td>No</td>
                  </tr>
              </table></td>
              <td valign="top" nowrap>4 Alumno Puente</td>
              <td width="1%" valign="top"><table>
                  <tr>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>Si</td>
                    <td>No</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"> Observaciones:<br>
            <br>
          ___________________________________________________________________________________________________________________________<br>
          <br>
          ___________________________________________________________________________________________________________________________<br>
          <br>
          ___________________________________________________________________________________________________________________________<br>
          <br>
          <br>
          <br></td>
      <tr>
        <td colspan="2"> Nombre del funcionario que matriculo:_____________________________________________<br>
            <br>
          Declaro conocer todas las dispociciones del Reglamento Interno del Establecimiento y me comprometo a <br>
          asistir a reuniones mensuales de apoderados y a cualquier citaci&oacute;n que efect&uacute;e el colegio. <br>
          <br></td>
      <tr>
        <td colspan="2"><br>
          ________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
          <b>NOMBRE Y FIMA APODERADO</b> </td>
    </table></td>
  </tr>
</table>

</body>
</html>