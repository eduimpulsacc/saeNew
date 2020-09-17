<?
require('../../../../util/header.inc');
include('../../../clases/class_MotorBusqueda.php');
//setlocale("LC_ALL","es_ES");


	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$fin_ano		=$check_ano;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
function enviapag2(form){
			form.target="_blank";
			var ensenanza= document.form.cmb_ensenanza.value;
			var periodo = document.form.cmb_periodo.value;
			document.form.action='printInformePromedioCurso_C.php?ensenanza='+ensenanza+'&periodo='+periodo;
			document.form.submit(true);
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

function Abrir_ventana () {
	pagina = "OrdenSubsector.php?cmb_ensenanza="+document.form.cmb_ensenanza.value;
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=600, height=600, top=85, left=140";
window.open(pagina,"",opciones);
}

function Activa(x){
	
	 if(x==2){
		form.cmbCICLO.disabled=false;
		form.cmbNIVEL.disabled=true;
	
		
	}else{
		form.cmbCICLO.disabled=true;
		form.cmbNIVEL.disabled=false;
		
	}
}

function enviapag(){
	form.target="_self";
	form.action='InformePromedioGralHC_C.php';
	form.submit(true);
}
//-->
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="Activa(<?=$opcion;?>)">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
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
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top" onfocus="MM_openBrWindow('../../../../../admin/institucion/ano/reportes/InformeNotasFinales_C.php','','scrollbars=yes,resizable=yes,width=500,height=500')"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								 

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA --><center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
<!-- FIN CUERPO DE LA PAGINA -->
<!-- INICIO FORMULARIO DE BUSQUEDA -->
<form action="printInformePromedioGralHC_C.php" method="post" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">

<? 

$institucion	=$_INSTIT;
$ano			=$_ANO;

$ob_motor = new MotorBusqueda();
$ob_motor ->ano = $ano;
$resultado_query_cue = $ob_motor ->Ensenanza($conn);

$ob_motor ->rdb =$institucion;
$rs_ciclo = $ob_motor->Ciclos($conn);

$rs_nivel = $ob_motor ->Nivel($conn);

$rs_sector = $ob_motor ->Sector($conn);

$ob_motor ->ano = $ano;
$result_periodo = $ob_motor ->periodo($conn);
?>
<center>
<table width="686" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="674">
	<table width="684" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="680" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></span></td>
  </tr>
  <tr>
    <td height="27"  class="cuadro01">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="27" class="cuadro01">&nbsp;</td>
    <td width="139" class="cuadro01">Periodo </td>
    
    <td width="377" class="cuadro01"><select name="cmb_periodo">
      <option value="0">SELECCIONE PERIODO</option>
      <? for($j=0; $j < @pg_numrows($result_periodo); $j++){
				$fils = @pg_fetch_array($result_periodo,$j);
				
				if($fils['id_periodo']==$cmb_periodo){
		?>
      <option value="<?=$fils['id_periodo'];?>" selected><?=$fils['nombre_periodo'];?></option>
      <? 		}else{ ?>
      <option value="<?=$fils['id_periodo'];?>"><?=$fils['nombre_periodo'];?></option>
      <? 		}
	  }
	  ?>
    </select></td>
    <td width="6" class="cuadro01">&nbsp;</td>
    <td width="63" class="cuadro01">
      <div align="center"></div></td>
  </tr>
  <tr>
    <td class="cuadro01"><input type="radio" name="opcion" id="opcion" value="2"  onClick="Activa(this.value);" <? if($opcion==2){ echo "checked";}?>></td>
    <td class="cuadro01">Ciclos</td>
    <td class="cuadro01">
    <select name="cmbCICLO" id="cmbCICLO" onChange="enviapag()">
      <option value="0" selected>SELECCIONE CICLOS</option>
      
        <? for($i=0;$i<pg_numrows($rs_ciclo);$i++){
				$fila =pg_fetch_array($rs_ciclo,$i);
				
				if($fila['id_ciclo']==$cmbCICLO){
		?>
        <option value="<?=$fila['id_ciclo'];?>" selected><?=$fila['nomb_ciclo'];?></option>
        <?		}else{?>
        <option value="<?=$fila['id_ciclo'];?>"><?=$fila['nomb_ciclo'];?></option>
        <?
				}
		}
		?>
    </select>
    </td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01"><input type="radio" name="opcion" id="opcion" value="3" onClick="Activa(this.value);" <? if($opcion==3){ echo "checked";}?>></td>
    <td class="cuadro01">Niveles</td>
    <td class="cuadro01">
    <select name="cmbNIVEL" id="cmbNIVEL" onChange="enviapag()">
      <option value="0" selected>SELECCIONE NIVEL</option>
      
        <? for($i=0;$i<pg_numrows($rs_nivel);$i++){
				$fila =pg_fetch_array($rs_nivel,$i);
				
				if($fila['id_nivel']==$cmbNIVEL){
		?>
        <option value="<?=$fila['id_nivel'];?>" selected><?=$fila['nombre'];?></option>
        <?		}else{ ?>
        <option value="<?=$fila['id_nivel'];?>"><?=$fila['nombre'];?></option>
        <? 		}
		}
		?>
    </select>
    </td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">Subsectores</td>
    <td colspan="3" class="cuadro01"><table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
      
      <? 
		if($opcion==3){
			$ob_motor->nivel =$cmbNIVEL;
			$rs_subsector = $ob_motor->SubsectorNivel($conn);
		}else if($opcion==2){
			$ob_motor->ciclo =$cmbCICLO;
			$rs_subsector = $ob_motor->SubsectorCiclo($conn);
		}
		
		
		for($i=0;$i<pg_numrows($rs_subsector);$i++){
			$fila = pg_fetch_array($rs_subsector,$i);
		?>
      <tr>
        <td class="cuadro01"><input type="checkbox" name="subsector<?=$i;?>" id="subsector<?=$i;?>" value="<?=$fila['cod_subsector'];?>">
          <label for="subsector"></label></td>
        <td class="cuadro01"><?=$fila['nombre']."--".$fila['cod_subsector'];?></td>
        <? }
		$contador = $i;
		 ?>
         <input name="contador" type="hidden" value="<?=$contador;?>">
        </tr>
    </table>	</td>
    </tr>
  <tr>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>

	<table width="600" border="0" align="right" cellpadding="1" cellspacing="0">
      <tr>
        <th width="405" scope="col"><div align="right"></div>
        </th>
        <th width="66" scope="col">
        <div align="right">
          
          <input name="cb_ok" class="botonXX"  type="submit" value=" Buscar  ">
        </div></th>
        <th width="64" scope="col"><div align="right">
          <input name="cb_exp" class="botonXX"  type="button" onClick="enviapag2(this.form)" value="Exportar">
        </div></th>
        <th width="57" scope="col"><div align="right">
          <input name="cb_ok2" class="botonXX"  type="button" value="Volver "onClick="window.location='Menu_Reportes_new2.php'">
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