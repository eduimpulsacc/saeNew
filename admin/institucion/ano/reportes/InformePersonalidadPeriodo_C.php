<SCRIPT language="JavaScript">
function enviapag(form){
	if (form.c_curso.value!=0){
		form.c_curso.target="self";
		form.target='_parent';
		form.action = 'InformeAnotaciones_C.php?institucion=$institucion';
		form.submit(true);
	}	
}
		
		function enviapagPDF(form){
	if (form.c_alumno.value!=0){
		form.target="_blank";
		form.action = 'printInformePersonalidadPeriodoPDF.php';
		form.submit(true);
	
		}	
	}
	
	
	function activaPDF(){
		if(form.c_alumno.value != 0)
		{
			document.getElementById("exp").style.display="block";}
		else
		document.getElementById("exp").style.display="none";
	}
									
</script>

<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno			=$c_alumno;
	$periodo		=$c_periodos;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;

$ob_institucion = new Membrete();
$ob_institucion ->ano = $ano;
$ob_institucion ->institucion = $institucion;
$ob_institucion ->institucion($conn);

if ($cmb_ano){
		$ano=$c_ano;
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){ 
			session_register('_ANO');
		}
		$curso=0;	
	}
	
	if ($c_curso){
		$curso=$c_curso;
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
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			  <?
			  include("../../../../cabecera/menu_superior.php");
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
						 include("../../../../menus/menu_lateral.php");
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
								  
								     <!-- COPIO LOS BOTONES PARA QUE NO EST�N SEPARADOS -->
								     <table width="" height="0" border="0" cellpadding="0" cellspacing="0">
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
$pag = 'printInformePersonalidadPeriodo_C.php';

?>
<form method="post" action="<?=$pag?>" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<center>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width=""><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  width="53%"class="tableindex"> <? echo $numero.".- Buscador ".$nombre;?></td>
        <td width="47%" class="tableindex"></td>
      </tr>
      <tr>
        <td class="cuadro01" width="53%"> A&ntilde;o Escolar<br>
            <input type="hidden" name="frmModo2" value="<?=$frmModo ?>">
            <select name="c_ano" class="ddlb_x" id="c_ano"  onChange="window.location='InformePersonalidadPeriodo_C.php?c_ano='+this.value;">
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
							if (($id_ano == $c_ano) or ($id_ano == $ano)){
								echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
							}else{	    
								echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
							}
							} ?>
            </select>        </td>
        <td rowspan="5" class="cuadro01" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="3" style="border-collapse:collapse">
          
          <!--<tr>
            <td  class="cuadro01">Incluye Retirados </td>
            <td  class="cuadro01"><input name="ckRETIRADO" type="radio" value="1" checked>
SI </td>
            <td  class="cuadro01"><input name="ckRETIRADO" type="radio" value="0">
NO</td>
          </tr>-->
          <tr>
            <td width="50%" rowspan="2"  class="cuadro01">Escala de evaluacion              </td>
            <td width="25%"  class="cuadro01"><input name="ckEVALUACION" type="radio" value="1" checked>
SI  </td>
            <td  class="cuadro01"><input name="ckEVALUACION" type="radio" value="0">
NO</td>
          </tr>
          <tr>
            <td  class="cuadro01"><input name="ckPOSICION" type="radio" value="1" checked>
              Arriba</td>
            <td  class="cuadro01"><input name="ckPOSICION" type="radio" value="0">
              Abajo</td>
          </tr>
        </table>
          <table width="100%" border="0" cellspacing="3" cellpadding="0">
            <tr>
              <td width="50%"  class="cuadro01">Observaciones                </td>
              <td width="25%"  class="cuadro01"><input name="ckOBS" type="radio" value="1" checked>
SI  </td>
              <td  class="cuadro01"><input name="ckOBS" type="radio" value="0">
NO</td>
            </tr>
            <tr>
              <td  class="cuadro01">Se destaca en </td>
              <td  class="cuadro01"><input name="ckDESTACA" type="radio" value="1" checked>
SI </td>
              <td  class="cuadro01"><input name="ckDESTACA" type="radio" value="0">
NO</td>
            </tr>
                  </table>          <table width="100%" border="0" cellspacing="3" cellpadding="0">
            <tr>
              <td width="50%" class="cuadro01">Evaluaci&oacute;n                </td>
              <td width="25%" class="cuadro01"><input name="ckCONCEPTO" type="radio" value="1" checked>
Concepto  </td>
              <td class="cuadro01"><input name="ckCONCEPTO" type="radio" value="0">
Sigla</td>
            </tr>
           
            <tr>
              <td width="50%"  class="cuadro01">Incluir<br>Autoevaluaci&oacute;n                </td>
              <td width="25%"  class="cuadro01"><input name="ckAUTO" type="radio" value="1">
SI  </td>
              <td  class="cuadro01"><input name="ckAUTO" type="radio" value="0" checked="CHECKED">
NO</td>
            </tr>
           
             <tr>
              <td width="50%"  class="cuadro01">Incluir<br>
              Colilla                </td>
              <td width="25%"  class="cuadro01"><input name="ckColilla" type="radio" value="1">
SI  </td>
              <td  class="cuadro01"><input name="ckColilla" type="radio" value="0" checked="CHECKED">
NO</td>
            </tr>
          
            <tr>
              <td class="cuadro01">Agregar RUT</td>
              <td colspan="2" class="cuadro01"><input name="chk_rut" type="checkbox" id="chk_rut" value="1">
                <label for="chk_rut"></label></td>
              </tr>
            <tr>
              <td class="cuadro01">Agregar Edad</td>
              <td colspan="2" class="cuadro01"><input name="chk_edad" type="checkbox" id="chk_edad" value="1">
                <label for="chk_edad"></label></td>
              </tr>
            <tr>
              <td class="cuadro01">% Asistencia</td>
              <td colspan="2" class="cuadro01"><input name="chk_pasis" type="checkbox" id="chk_pasis" value="1"></td>
            </tr>
            <tr>
              <td class="cuadro01">Agregar Portada (s&oacute;lo Ens. P&aacute;rvulos)</td>
              <td colspan="2" class="cuadro01"><input name="chk_portada" type="checkbox" id="chk_portada" value="1"></td>
            </tr>
            <tr>
              <td class="cuadro01">Espacio entre firma                </td>
              <td colspan="2" class="cuadro01"><input name="txtFIRMA" type="text" id="txtFIRMA" value="0" size="5" maxlength="1"></td>
            </tr>
            <tr>
              <td class="cuadro01">Espacio Filas                </td>
              <td class="cuadro01"><input name="txtFILAS" type="text" id="txtFILAS" value="0" size="5" maxlength="1">                </td>
              <td class="cuadro01">&nbsp;</td>
            </tr>
            <tr>
              <td class="cuadro01">Salto de P&aacute;gina </td>
              <td class="cuadro01"><input name="txtSALTO" type="text" id="txtSALTO" value="32" size="5" maxlength="2"> 
                (l&iacute;neas) </td>
              <td class="cuadro01">&nbsp;</td>
            </tr>
            <tr>
              <td class="cuadro01">Orden de Listado</td>
              <td class="cuadro01"><input name="orden" type="radio" value="0" checked>
                Nro Lista                </td>
              <td class="cuadro01"><input name="orden" type="radio" value="1">
                Alfabetico</td>
            </tr>
                  </table>
                  <br>
				  <?
				  $fecha = date("d-m-Y");
				  if ($txtFECHA!=NULL){
				       $fecha = $txtFECHA;
				  }
				  
				  ?>
                  <table width="100%" border="0" cellspacing="3" cellpadding="0">
                    <tr>
                      <td width="50%" class="cuadro01">Fecha</td>
                      <td class="cuadro01"><input name="txtFECHA" type="text" size="10" value="<?=$fecha;?>">(dd-mm-aaaa)</td>
                    </tr>
                    <tr>
                      <td class ="cuadro01">Firma solo con cargo </td>
                      <td class="cuadro01"><input name="chcargo" type="checkbox" id="chcargo" value="1"></td>
                    </tr>
                    <tr>
                      <td class="cuadro01">Firma Apoderado </td>
                      <td class="cuadro01"><label>
                        <input name="chk_apo" type="checkbox" id="chk_apo" value="1">
                      </label></td>
                    </tr>
                    <tr>
                      <td class="cuadro01">Tipo de Informe</td>
                      <td class="cuadro01"><input name="tipo_planilla" type="radio" id="tipo_planilla0" value="0" checked="CHECKED"> Informe de Personalidad<br> <input name="tipo_planilla" type="radio" id="tipo_planilla1" value="1" >Informe Diagn&oacute;stico</td>
                    </tr>
                  </table></td>
      </tr>
      <tr>
        <td  class="cuadro01"><br>
          Curso<font size="1" face="arial, geneva, helvetica"><br>
          <? if($_PERFIL == 17){ ?>
          <select name="c_curso"  class="textosimple" id="c_curso" onChange="window.location='InformePersonalidadPeriodo_C.php?c_reporte=<?=$reporte;?>&c_curso='+this.value;">
            <option value=0 selected>(Seleccione Curso)</option>
            <? 
			for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i){
				$fila = @pg_fetch_array($resultado_query_cue,$i); 
				if($fila["id_curso"]==$_CURSO){
					if($fila["id_curso"]==$c_curso){
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
          <select name="c_curso"  class="textosimple" id="c_curso" onChange="window.location='InformePersonalidadPeriodo_C.php?c_reporte=<?=$reporte;?>&c_curso='+this.value;">
            <option value=0 selected>(Seleccione Curso)</option>
            <?	for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i){
					$fila = @pg_fetch_array($resultado_query_cue,$i); 
					if ($fila["id_curso"]==$c_curso){
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
          <select name="c_alumno" class="textosimple" id="c_alumno"  >
            <option value=0 selected>(Todos los alumnos)</option>
            <? 	if ($c_curso!=0){
			   	for($i=0 ; $i < @pg_numrows($rs_alumno) ; ++$i){
					$fila = @pg_fetch_array($rs_alumno,$i);
					if ($fila["rut_alumno"] == $c_alumno){ ?>
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
          <select name="c_periodos" class="textosimple" id="c_periodos">
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
        <td  class="cuadro01"><table width="100%" border="0">
          <tr class="cuadro01">
            <td>&nbsp;</td>
            <td align="center">Alineaci&oacute;n</td>
            <td align="center">Negrita</td>
            <td align="center">Cursiva</td>
          </tr>
          <tr class="cuadro01">
            <td>&Aacute;reas</td>
            <td align="center">
            	<select name="cbmAreaAlign">
                	<option value="left">Izquierda</option>
					<option value="center">Centrado</option>
                    <option value="right">Derecha</option>                    
                 </select>
            </td>
            <td align="center"><input name="CHKAREAN" type="checkbox" id="CHKAREAN" value="1"></td>
            <td align="center"><input name="CHKAREAC" type="checkbox" id="CHKAREAC" value="1"></td>
          </tr>
          <tr class="cuadro01">
            <td>Subareas</td>
            <td align="center">
	            <select name="cbmSubAreaAlign">
                	<option value="left">Izquierda</option>
					<option value="center">Centrado</option>
                    <option value="right">Derecha</option>                    
                 </select>
            </td>
            <td align="center"><input name="CHKSUBN" type="checkbox" id="CHKSUBN" value="1"></td>
            <td align="center"><input name="CHKSUBC" type="checkbox" id="CHKSUBC" value="1"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td  class="cuadro01"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
            <? if($_PERFIL==0){?>
            <input name="cb_exp" type="submit" class="botonXX"  id="cb_exp" value="Exportar">
            
            <?  }?>
		    <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'"></td>
        <td  class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
        <td  class="cuadro01"></td>
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
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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