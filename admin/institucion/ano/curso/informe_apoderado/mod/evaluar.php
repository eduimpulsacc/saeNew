<?php require('../../../../../../util/header.inc');

include('../../../../../clases/class_Membrete.php');
require "../class/plantilla.php";

//var_dump($_SESSION);
	$institucion	=$_INSTIT;
	$ano			=$cmb_ano;
	//$curso			=$_CURSO;
	//$periodo		=$_PERIODO;	
	$_POSP          = 6;
	$usuario = $_NOMBREUSUARIO;
	
	$_bot           = 5;
	if (trim($_url)=="") $_url=0;
	
	foreach($_GET as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
    eval($asignacion); 
	//echo "<br>".$asignacion;
}


$obj_plantilla = new Plantilla();
$ob_membrete = new Membrete();

$result_planilla = $obj_plantilla->getDatoPlantilla($conn,$planilla);
$num_planilla=pg_numrows($result_planilla);
if ($num_planilla>0){
	$row_planilla=pg_fetch_array($result_planilla);
}


	$rs_area = $obj_plantilla->getAreas($conn,$planilla);
	
/*******INSITUCION ********************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS PERIODO************/
	$ob_membrete ->periodo=$periodo;
	$ob_membrete ->Periodo($conn);
	$periodo_pal = $ob_membrete->nombre_periodo . " DEL " . $nro_ano;
	
	
	//*******datos evaluacion (si existiera)***************/
	$result_evaluacion = $obj_plantilla->traeEvaluacion($conn,$rut,$periodo,$planilla);
	if(pg_numrows($result_evaluacion)>0){
		$fila_evaluacion = pg_fetch_array($result_evaluacion,0);
		$ex=2;
		$id_v = $fila_evaluacion['id_evaluacion'];
	}
	else{
		$ex=1;
	}
	
	
?>

<?php 
	

if($tipo==1){
	$rs_ent = $obj_plantilla->traeApoderadoUno($conn,$rut);
}
elseif($tipo==2){
	$rs_ent = $obj_plantilla->traeAlumnoUno($conn,$rut);
}
elseif($tipo==3){
	$rs_ent = $obj_plantilla->traeEmpleadoUno($conn,$rut);
}


?>


 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../../index.php";
		 </script>

<? } ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar   </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
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

$( document ).ready(function() {
    cambioano();
});





</script>
		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>

	


</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><? $menu_lateral="3_1";?><?
					  
						 include("../../../../../../menus/menu_lateral.php");
						 
						 
						 ?>
						 
						 
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
                              <tr>
                                <td valign="top"><table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
                                  <TR height=15>
                                    <TD width="600">&nbsp;</TD>
                                  </TR>
								  
                                  <tr>
                                    <td>
                                    <form action="procesaEvaluacion.php" method="post">
                                   
                                    <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr class="tableindex"><td colspan="2"><div align="center" class="tt"><?php echo $row_planilla['titulo'] ?></div></td>
  </tr>
<tr>
  <td colspan="2" align="right">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" align="right"><input type="hidden" name="cmb_ano" id="cmb_ano" value="<?php echo $cmb_ano  ?>">
    <input type="hidden" name="evaluacion" id="evaluacion" value="<?php echo $id_v  ?>">
    <input type="hidden" name="entrevistador" id="entrevistador" value="<?php echo $usuario; ?>">
    <input type="hidden" name="ex" id="ex" value="<?php echo $ex ?>">
  <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo ?>">
    <input name="rut" type="hidden" id="rut" value="<?php echo $rut ?>"><input name="periodo" type="hidden" id="periodo" value="<?php echo $periodo ?>"><input name="plantilla" type="hidden" id="plantilla" value="<?php echo $planilla ?>"><input type="submit" name="button" id="button" value="Guardar"></td>
  </tr>
<tr class="tabla04">
  <td width="20%" class="te" >Nombre</td>
  <td width="80%" class="te" ><?php echo pg_result($rs_ent,2); ?></td>
  </tr>
<tr class="tabla04">
  <td class="te" >Rut</td>
  <td class="te" ><?php echo pg_result($rs_ent,0); ?>-<?php echo pg_result($rs_ent,1); ?></td>
</tr>
<tr class="tabla04">
  <td class="te" >Establecimiento</td>
  <td class="te" ><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></td>
</tr>
<tr class="tabla04">
  <td class="te" >Periodo</td>
  <td class="te" ><?php echo $periodo_pal ?></td>
</tr>
<tr>
  <td colspan="2" class="te" >&nbsp;</td>
</tr>
<tr>
  <td height="51" colspan="2" class="te" >
  <table width="650" border="1" cellpadding="0" cellspacing="0">
  <? for($i=0;$i<pg_numrows($rs_area);$i++){
				$fila_area = pg_Fetch_array($rs_area,$i);
			
		$fil_area = pg_fetch_array($rs_area,$a);
		$rs_item=$obj_plantilla->getConcepto($conn,$fila_area['id_plantilla'],$fila_area['id_area']);		
		?>
<tr class="tabla04">
  <td class="te" ><strong><?= utf8_decode($fila_area['nombre']);?></strong></td>
  <td height="21" align="center" class="te" >Evaluaci&oacute;n</td>
  </tr>
 <?php 
	  for($ii=0;$ii<pg_numrows($rs_item);$ii++){
			$fil_item = pg_fetch_array($rs_item,$ii);?>
<tr class="tablatit2-1">
  <td width="545" class="te" ><?php echo utf8_decode($fil_item['nombre']) ?></td>
  <td width="99" align="center" class="te" >&nbsp;
    <?php $rs_con = $obj_plantilla->ListaConcepto($conn,$planilla);?>
    <select name="item[]" id="item">
       <?php
		for($j=0;$j<pg_numrows($rs_con);$j++){
			$fila_con = pg_fetch_array($rs_con,$j);
			if($ex==2){
		$rs_valor = $obj_plantilla->selItemEvaluacion($conn,$id_v,$fila_area['id_area'],$fil_item['id_item'],$fila_con['id_concepto']);
		echo $valor=pg_result($rs_valor,1)."_".pg_result($rs_valor,2)."_".pg_result($rs_valor,3);
		
			}
	$compara=$fila_area['id_area']."_".$fil_item['id_item']."_".$fila_con['id_concepto'];
		?>
      <option value="<?php echo $fila_area['id_area']?>_<?php echo $fil_item['id_item'] ?>_<?php echo $fila_con['id_concepto'] ?>" <?php echo ($valor==$compara)?"selected":""; ?>><?php echo utf8_decode($fila_con['sigla']) ?></option>
      <?php }?>
      </select>&nbsp;
  </td>
  </tr>
<?php }?>
<?php }?>
  </table></td>
</tr>
 <tr>
   <td colspan="2" valign="top">&nbsp;</td>
   </tr>
 <tr class="tabla04">
    <td valign="top">Observaciones</td>
     <td valign="top"><textarea name="observacion" id="observacion" style="margin: 0px; width: 493px; height: 119px;"><?php echo $fila_evaluacion['observacion'] ?></textarea></td>
                              </tr>
</table>
</form>
</table>

</td>
                                  </tr>
                             
                              <tr>
                                <td valign="top">&nbsp;</td>
                              </tr>
                                  
                                  
                                  
 
                                </table></td>
                        </tr></table>                         </td>
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