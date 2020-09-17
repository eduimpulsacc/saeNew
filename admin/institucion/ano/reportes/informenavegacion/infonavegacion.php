 <?php
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
include('../../../../clases/class_MotorBusqueda.php');
	
	echo $_ANO;
	
	$institucion	= $_INSTIT;
	$ano			=$_ANO;
	$curso			= $c_curso;
	$frmModo		=$_FRMMODO;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
    
	
	$sql="SELECT id_ano, nro_ano FROM ano_Escolar WHERE id_institucion=".$institucion." ORDER BY nro_ano ASC";
	$rs_ano = pg_exec($conn,$sql);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">




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
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

.mayuscula{text-transform:uppercase;}


div.ui-datepicker{
	font-size:12px;
	}
-->
    </style>
   
    <link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">
    <script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
    <script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
    <script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.core.js"></script>
    
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
	
<SCRIPT language="JavaScript">

$(function() {
   $("#fecha").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy'
	//buttonImage: 'img/Calendario.PNG',
	//$.datepicker.regional['es']
	});
  });

	function buscapag(form){
			if (form.fecha.value!=""){
				form.submit(true);
				}else{
					alert("Debe Seleccionar una fecha");
					return false;
					}	
			}
		
	
	function RecargaPagina(){
	location.reload();
		//$('#form')[0].reset();
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
//-->
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
				include("../../../../../cabecera/menu_superior.php");
				?>
</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <div id="layer2"></div>
<br>
<form name="form" id="form" method="post" action="printInfoNavegacion.php" target="_blank">
	<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
    <input name="nombre" type="hidden" value="<?=$nombre;?>">
    <input name="numero" type="hidden" value="<?=$numero;?>">
	
          
  <center>
    <table width="90%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td colspan="2" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
      </tr>
      <tr>
        <td width="15%">Fecha</td>
        <td width="85%">
          <input type="text" name="fecha" id="fecha" value="" readonly placeholder="Seleccione una fecha"></td>
      </tr>
    
    
    <tr>
      <td colspan="2">
        <br><br>
        <div align="center">
          <input name="cb_ok" type="button" class="botonXX" id="cb_ok" value="Buscar" onClick="buscapag(this.form)" >
          <? if($_PERFIL==0){?>
          <input name="cb_exp" type="submit" class="botonXX"  id="cb_exp" value="Exportar" >
          <? }?>	
          <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver" onClick="window.location='../Menu_Reportes_new2.php'">                 
          </div></td>
    </tr>
  </table>  
  <br><br>
  <div id="lista_alumnos">&nbsp;</div>
   
</center>
</form>
							 
<!-- FIN FORMULARIO DE BUSQUEDA -->
 
 								  								  
								  </td>
                                </tr>
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>

               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>