<?php
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');

	
	$_POSP = 6;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		=$_FRMMODO;
	$alumno			=$alumno;	
	$reporte		= $c_reporte;

	




$ob_motor = new MotorBusqueda();
$ob_motor ->ano = $ano;
$ob_motor->perfil=$_PERFIL;
$ob_motor->curso=$_CURSO;
$ob_motor->usuario=$_NOMBREUSUARIO;
$ob_motor->rdb=$institucion;
$rs_nanos = $ob_motor->ano_escolar($conn);
/*$rs_nano = $ob_motor->ano_12($conn);
 $nro_ano = pg_result($rs_nano,1);*/

//------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
				document.form.target='_parent';		
				document.form.action = "fichaFamiliar.php";
				document.form.submit();
	
				}	
			}
			
			
		
									
</script>

<script language="JavaScript" type="text/JavaScript">
<!--


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
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script>
function cambano(ano){
//alert(ano);
 $("#txt_ano").val("");	
 $("#txt_fecha").datepicker("destroy");
if(ano!=0){ 
  var cad = ano.split("_");
	   //alert(cad[0]);
	   $("#txt_ano").val(cad[0]);
		$("#txt_fecha").datepicker({
			showOn: 'both',
			changeYear:false,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			minDate: new Date('01/01/'+cad[1]+''),
			maxDate: new Date('12/31/'+cad[1]+''),
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mi�','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
  
}
}

$(document).ready(function(){
	//cambano(<?php echo $_ANO ?>);
	
	/*$("#txt_fecha").datepicker({
			showOn: 'both',
			changeYear:false,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			minDate: new Date('01/01/'+<?php echo $nro_ano ?>+''),
			maxDate: new Date('12/31/'+<?php echo $nro_ano ?>+''),
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mi�','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});*/
		
		
         
        

  });
  </script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
				include("../../../../../../cabecera/menu_superior.php");
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
						include("../../../../../../menus/menu_lateral.php");
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
								  <!-- FIN CODIGO DE BOTONES -->
								 
								  <!-- INICIO FORMULARIO DE BUSQUEDA -->
<form name="form" method="post" action="printmatriculaGenero.php" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">

<center>
<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701" class="cuadro02"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27" class="cuadro01">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="cuadro01">A&ntilde;o acad&eacute;mico</td>
    <td class="cuadro01"><select name="cmb_ano" id="cmb_ano" onChange="cambano(this.value)">
    <option value="0">Seleccione</option>
    <?php for($i=0;$i<pg_numrows($rs_nanos);$i++){
		$fila_anos = pg_fetch_array($rs_nanos,$i);
		?>
    <option value="<?php echo $fila_anos['id_ano'] ?>_<?php echo $fila_anos['nro_ano'] ?>"><?php echo $fila_anos['nro_ano'] ?></option>
    <?php }?>
    </select></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td width="78" class="cuadro01">Matr&iacute;cula Hasta</td>
    <td width="263" class="cuadro01">
	  <div align="left">
	    <input type="text" name="txt_fecha" id="txt_fecha">
	  </div></td>
    <td width="61" class="cuadro01">&nbsp;</td>
    <td width="219" class="cuadro01">&nbsp;</td>
    <td width="80" class="cuadro01">
      <div align="center"></div></td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01"><input type="hidden" name="txt_ano" id="txt_ano"></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01" align="right">&nbsp;</td>
   
	<td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01" align="right">
      <div align="center"></div></td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
</table>

	<table width="600" border="0" align="right" cellpadding="1" cellspacing="0">
      <tr>
        <th width="446" scope="col"><div align="right"></div></th>
        <th width="94" align="center" scope="col"><div align="center">
          <input name="cb_ok" type="submit" class="botonXX" id="cb_ok"  >
        </div></th>
        <th width="54" scope="col"><div align="right">
          <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2"  value="Volver"onClick="window.location='../../Menu_Reportes_new2.php'">
        </div></th>
      </tr>
    </table></td>
  </tr>
</table>

	</td>
  </tr>
</table>
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
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>