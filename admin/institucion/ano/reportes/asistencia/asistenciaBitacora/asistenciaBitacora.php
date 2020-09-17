<?
require('../../../../../../util/header.inc');
include('../../../../../clases/class_MotorBusqueda.php');
	//setlocale("LC_ALL","es_ES")	;
	//---------------------------
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	;
	$reporte		=$c_reporte;
	$publica        =$_GET["publica"];
	$_POSP = 6;
	$_bot = 8;
	

?>
<? 
$ob_motor = new MotorBusqueda();
$ob_motor ->ano = $ano;
$ob_motor->perfil=$_PERFIL;
$ob_motor->curso=$_CURSO;
$ob_motor->usuario = $_NOMBREUSUARIO;
$ob_motor->rdb = $institucion;
$resultado_query_cue = $ob_motor ->curso2($conn);

if($cmb_curso!=0){
	$ob_motor ->cmb_curso  =$cmb_curso;
	$result= $ob_motor ->alumno($conn);	
}
$rs_ano = $ob_motor->Ano($conn);
$nro_ano = pg_result($rs_ano,5);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<style>
	  div.ui-datepicker{
 font-size:12px;
}

	  </style>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				window.location= 'justificaInasistenciaDetalle.php?cmb_curso='+ document.form.cmb_curso.value +'&c_reporte=<?=$reporte;?>';
				
	
				}	
			}
			
			function checkea(x){
				if(x==0){
				document.form.txtTIPO.disabled = true;
				document.form.txtTIPO.value="";
				}else{
					document.form.txtTIPO.disabled = false;
					
					
				}				
				
				
				}
			
//			
//			function enviapag2(form){
//      		  if( form.cmb_curso.value!=0 || form.cmb_alumno.value!=0){
//                form.target="_blank";
//                document.form.action = 'printCertificadoAlumnoRegular_C.php?xls=1';
//                document.form.submit(true);
//					}
//			}
//			
			
			
			
			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
//-->
</script>
<script>
$( document ).ready(function() {
    

      $("#desde,#hasta").datepicker({
	showOn: 'both',
	changeYear:false,
	changeMonth:false,
	dateFormat: 'dd/mm/yy',
	minDate: new Date('01/01/'+<?php echo $nro_ano?>+''),
	maxDate: new Date('12/31/'+<?php echo $nro_ano?>+''),
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
  firstDay: 1
	//buttonImage: 'img/Calendario.PNG',
	});
	
})
      </script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
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
								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="30" align="center" valign="top"> 
      
	 
	  
	  
	  <tr>
		</tr> 
  
  
</table>

<form method="post" action="printasistenciaBitacora.php" target="_blank" name="form" id="form">
<input type="hidden" name="c_reporte" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
                                

<center>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  
    <tr>
      <td class="cuadro01">Curso <br>        
        <div align="left"><br>
              </div></td>
      <td class="cuadro01"><select name="cmb_curso"  class="ddlb_9_x" >
        <option value=0 selected>(Seleccione Curso)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
      </select></td>
    </tr>
  
 
  <tr>
    <td class="cuadro01">Fechas</td>
    <td class="cuadro01"><label for="desde"></label>
      <input name="desde" type="text" id="desde" size="12"> 
      a 
      <label for="hasta"></label>
      <input name="hasta" type="text" id="hasta" size="12"></td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2" class="cuadro01"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Buscar">
      <input name="cb_exp" type="submit" class="botonXX"  id="cb_exp" value="Exportar">
      <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2"  value="Volver"onClick="window.location='../../Menu_Reportes_new2.php'">
      </td>
    </tr>
</table>

	</td>
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
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>