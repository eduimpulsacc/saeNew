<SCRIPT language="JavaScript">
function enviapag(form){
	if (form.c_curso.value!=0){
		form.c_curso.target="self";
		form.target='_parent';
		form.action = 'InformeAnotaciones_C.php?institucion=$institucion';
		form.submit(true);
	}	
}
		
		
	
	
									
</script>

<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$alumno			=$cmb_alumno;
	$periodo		=$cmb_periodo;
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;

$ob_institucion = new Membrete();
$ob_institucion ->ano = $ano;
$ob_institucion ->institucion = $institucion;
$ob_institucion ->institucion($conn);

if ($cmb_ano){
		$ano=$cmb_ano;
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){ 
			session_register('_ANO');
		}
		$curso=0;	
	}
	
	if ($cmb_curso){
		$curso=$cmb_curso;
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		}
	}




?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background=".../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			  <?
			  include("../../../../../../cabecera/menu_superior.php");
			  ?>
			  
                        <!-- FIN DE COPIA DE CABECERA -->
                    
					
					</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <!-- AQUI VA EL MEN{U LATERAL -->
						 <?
						 $menu_lateral=3;
						 include("../../../../../../menus/menu_lateral.php");
						 ?>
						 
						 <!--  FIN MENU LATERAL -->
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								     <!-- COPIO LOS BOTONES PARA QUE NO ESTÉN SEPARADOS -->
								     <table width="100%" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="0" align="center" valign="top"> 
       					
<? 
	$ob_motor = new MotorBusqueda();
	$ob_motor->rdb=$institucion;
	$ob_motor->ano=$ano;
	$result = $ob_motor->Ano($conn);
	
	$ob_motor->perfil=$_PERFIL;
	$ob_motor->curso=$_CURSO;
	$ob_motor->usuario=$_NOMBREUSUARIO;
	$ob_motor->rdb=$institucion;
	$resultado_query_cue = $ob_motor->curso2($conn);
	$ob_motor->cmb_curso=$curso;
	$rs_alumno = $ob_motor->alumno($conn);
	
	$result_peri = $ob_motor->periodo($conn);


/*if($_PERFIL==0) $pag = 'printInformePersonalidadPeriodo_C_new.php';
else */
$pag = 'printPlanPaiPeriodo.php';

?>
<form method "post" action="<?=$pag?>" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<center>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width=""><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2"class="tableindex"> <? echo $numero.".- Buscador ".$nombre;?></td>
        </tr>
      <tr>
        <td class="cuadro01" width="53%"> A&ntilde;o Escolar<br>
            <input type="hidden" name="frmModo2" value="<?=$frmModo ?>">
            <select name="cmb_ano" class="ddlb_x" id="cmb_ano"  onChange="window.location='PlanPaiPeriodo.php?cmb_ano='+this.value;">
              <option value=0 selected>(Seleccione un A&ntilde;o)</option>
              <?		for($i=0;$i < @pg_numrows($result);++$i){
							$filann = @pg_fetch_array($result,$i); 
							$id_ano  = $filann['id_ano'];  
							$nro_ano = $filann['nro_ano'];
							$situacion = $filann['situacion'];
							if ($situacion == 0){
								$estado = "Cerrado";
							}
							if ($situacion == 1){
								$estado = "Abierto";
							}	 	 
							if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
								echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
							}else{	    
								echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
							}
							} ?>
            </select>        </td>
        <td width="47%" rowspan="5" valign="top" class="cuadro01"><br>
				 </td>
      </tr>
      <tr>
        <td  class="cuadro01"><br>
          Curso<font size="1" face="arial, geneva, helvetica"><br>
          <? if($_PERFIL == 17){ ?>
          <select name="cmb_curso"  class="textosimple" id="cmb_curso" onChange="window.location='PlanPaiPeriodo.php?c_reporte=<?=$reporte;?>&cmb_curso='+this.value;">
            <option value=0 selected>(Seleccione Curso)</option>
            <? 
			for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i){
				$fila = @pg_fetch_array($resultado_query_cue,$i); 
				if($fila["id_curso"]==$_CURSO){
					if($fila["id_curso"]==$cmb_curso){
						$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
						echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
					}else{
						$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
						echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
					}
				}	
			} ?>
          </select>
          <? }else{ ?>
          <select name="cmb_curso"  class="textosimple" id="cmb_curso" onChange="window.location='PlanPaiPeriodo.php?c_reporte=<?=$reporte;?>&cmb_curso='+this.value;">
            <option value=0 selected>(Seleccione Curso)</option>
            <?	for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i){
					$fila = @pg_fetch_array($resultado_query_cue,$i); 
					if ($fila["id_curso"]==$cmb_curso){
						$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
						echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
					}else{
						$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
						echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
					}
				} ?>
          </select>
          <? } ?>
        </font> </td>
        </tr>
      <tr>
        <td  class="cuadro01"><br>
          Alumno<br>
          <select name="cmb_alumno" class="textosimple" id="cmb_alumno"  <?php if($_PERFIL==0)echo "onchange='activaPDF();'"  ?>>
            <option value=0 selected>(Todos los alumnos)</option>
            <? 	if ($cmb_curso!=0){
			   	for($i=0 ; $i < @pg_numrows($rs_alumno) ; ++$i){
					$fila = @pg_fetch_array($rs_alumno,$i);
					if ($fila["rut_alumno"] == $cmb_alumno){ ?>
            			<option value="<? echo $fila["rut_alumno"]; ?>" selected><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
            	<? }else{ ?>
			            <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
            <?     }
				}
				}?>
        </select></td>
        </tr>
      <tr>
        <td  class="cuadro01"><br>
          Per&iacute;odo<br>
          <select name="periodo" class="textosimple" id="periodo">
            <option value=0 selected>(Seleccione Periodo)</option>
            <? for($i=0 ; $i < @pg_numrows($result_peri) ; ++$i){
				$filaP = @pg_fetch_array($result_peri,$i); 
				if ($filaP["id_periodo"]==$periodo){
					echo "<option selected value=".$filaP['id_periodo'].">".$filaP['nombre_periodo']."</option>";
				}else{
					echo "<option value=".$filaP['id_periodo'].">".$filaP['nombre_periodo']."</option>";
				}
			} ?> 
          </select> 
		  </td>
        </tr>
      <tr>
        <td  class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
        <td  class="cuadro01"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
           		    <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='../../Menu_Reportes_new2.php'"></td>
        <td  class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
        <td  class="cuadro01"><? if($_PERFIL == 0){?>
            <input type="button" value="PDF" onClick="enviapagPDF(this.form)" id="exp" style="display:none" class="botonXX">
             <?php }?></td>
        <td  class="cuadro01">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</center>
</form>                        
		  <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->								  
								  
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
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>