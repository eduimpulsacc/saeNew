<?php require('../../../../../util/header.inc');
session_start();
$institucion=$_INSTIT;
$_POSP = 4;
$_bot = 7;
$plantilla	=$plantilla;
$ano			=$_ANO;

require "../../Class/mod_plantillas.php";
require ("../../../../clases/class_Membrete.php");


$obj_informe = new informeApo();

$result_planilla = $obj_informe->getDatoPlantilla($conn,$plantilla);
$num_planilla=pg_numrows($result_planilla);
if ($num_planilla>0){
	$row_planilla=pg_fetch_array($result_planilla);
}


if(session_is_registered('_PLANTILLA_APO')){
		session_unregister('_PLANTILLA_APO');
	};
	
	session_register('_PLANTILLA_APO');
	
	$_PLANTILLA_APO=$plantilla;


	$rs_area = $obj_informe->getAreas($conn,$plantilla);
	

	$result_ins =$obj_informe->institucion ($conn,$institucion);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$ciudad = $fila_ins['nom_pro'];
	$fono = $fila_ins['telefono'];
	$direc = $fila_ins['calle'].$fila_ins['nro'];
	$region = $fila_ins['nom_reg'];
	$provincia = $fila_ins['nom_pro'];
	$comuna = $fila_ins['nom_com'];

//-----------------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.tt{
	font-family:Arial, Helvetica, sans-serif;
	font-size:24px;
	font-weight:bold;
	text-transform:uppercase;
	font-style:italic;

}
.te{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	text-align:justify;
	
}
.te2{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	text-align:center;
	
}
</style>
 <script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script language="JavaScript" type="text/JavaScript">

/*$(document).ready(function() {
	 cargaConcepto();
	  });*/


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

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>

          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
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
					<?   include("../../../../../cabecera/menu_superior.php");?>
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
					  <table><tr><td><?
						 include("../../../../../menus/menu_lateral.php");
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
                                <td valign="top">
								<table width="650" border="0">
  <tr>
    <td width="650"><div id="previa"><table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
                <td width="114"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
                <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td width="361"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo strtoupper(trim($ins_pal)) ?></font></div></td>
                <td width="161" rowspan="7" align="center" valign="top" >
				<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
				</td>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>AÑO ESCOLAR</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo $nro_ano ?></font></div></td>
                </tr>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>CURSO</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
				[CURSO]
				</font></div></td>
                </tr>	
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>ALUMNO</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">[ALUMNO]</font></div></td>
                </tr>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>PROFESOR JEFE</strong></font></div></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
                <td><div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">[PROFESOR JEFE]</font></div></td>
                </tr>
                
                <tr>
            
                <td class="textonegrita"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>FECHA</strong></font></td>
                <td class="textonegrita">:</td>
                <td class="textosimple"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo date("d-m-Y") ?></font></td>
                <td width="4" rowspan="6" align="center">&nbsp;</td>
              </tr> 
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="4" rowspan="6" align="center">&nbsp;</td>
              </tr>
             
			  
            </table>
      <br>
<br>
</div>
<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr><td colspan="3"><div align="center" class="tt"><?php echo $row_planilla['titulo'] ?></div></td>
  </tr>
<tr>
  <td colspan="3">&nbsp;  </td>
  </tr>
<tr>
  <td colspan="3" class="te" ><?php echo espacio($row_planilla['descripcion']) ?></td>
  </tr>
<tr>
  <td colspan="3" class="te" >&nbsp;</td>
</tr>
<tr>
  <td class="te" >&nbsp;</td>
  <td class="te2" ><strong>Periodo 1</strong></td>
  <td class="te2" ><strong>Periodo N</strong></td>
</tr>
<? for($i=0;$i<pg_numrows($rs_area);$i++){
				$fila_area = pg_Fetch_array($rs_area,$i);
			
		$fil_area = pg_fetch_array($rs_area,$a);
		$rs_item=$obj_informe->getConcepto($conn,$fila_area['id_plantilla'],$fila_area['id_area']);		
		?>
<tr>
  <td height="30" class="te" ><strong><?= utf8_decode($fila_area['nombre']);?></strong></td>
  <td class="te" >&nbsp;</td>
  <td class="te" >&nbsp;</td>
</tr>
 <?php 
	  for($ii=0;$ii<pg_numrows($rs_item);$ii++){
			$fil_item = pg_fetch_array($rs_item,$ii);?>
<tr>
  <td height="30" class="te" ><?php echo utf8_decode($fil_item['nombre']) ?></td>
  <td class="te" >&nbsp;
  <?php $rs_con = $obj_informe->ListaConcepto($conn,$plantilla);?>
  <select name="">
  <option value="">Seleccione</option>
  <?php
		for($j=0;$j<pg_numrows($rs_con);$j++){
			$fila_con = pg_fetch_array($rs_con,$j);
		?>
         <option value="<?php echo $fila_con['id_item'] ?>"><?php echo utf8_decode($fila_con['nombre']) ?></option>
		<?php }?>
  </select>&nbsp;
  </td>
  <td class="te" >&nbsp;<?php $rs_con = $obj_informe->ListaConcepto($conn,$plantilla);?>
    <select name="select">
      <option value="">Seleccione</option>
      <?php
		for($j=0;$j<pg_numrows($rs_con);$j++){
			$fila_con = pg_fetch_array($rs_con,$j);
		?>
      <option value="<?php echo $fila_con['id_item'] ?>"><?php echo utf8_decode($fila_con['nombre']) ?></option>
      <?php }?>
    </select>&nbsp;</td>
</tr>
<?php }?>
<?php }?>
</table><br>
<br>
<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr><td colspan="3"><div align="center" class="tt">METODOS DE EVALUACION</div></td>
  </tr>
<tr>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr class="te2">
  <td><strong>NOMBRE</strong></td>
  <td><strong>SIGLA</strong></td>
  <td><strong>GLOSA</strong></td>
  </tr>
  <?php $rs_con = $obj_informe->ListaConcepto($conn,$plantilla);
  ?>
    <?php
		for($j=0;$j<pg_numrows($rs_con);$j++){
			$fila_con = pg_fetch_array($rs_con,$j);
		?>
<tr >
  <td align="center" class="te2"><?php echo utf8_decode($fila_con['nombre']) ?></td>
  <td align="center" class="te2"><?php echo utf8_decode($fila_con['sigla']) ?></td>
  <td class="te">&nbsp;<?php echo utf8_decode($fila_con['glosa']) ?></td>
</tr>
<?php }?>
</table>
</td>
  </tr>
                                </table>
								<br>
								<input name="nuevo2" type="button" value="Paso Anterior" class="botonXX" onClick="window.location.href = '../paso3/paso3.php?plantilla=<?php echo $plantilla ?>'">
<input name="nuevo" type="button" value="Finalizar" class="botonXX" onClick="window.location.href = '../../listaPlantillas.php'"></td>
                              </tr></table>                         </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
