<?php require('../../../../../util/header.inc');
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$alumno			=$_ALUMNO;
	$apoderado		=$_NOMBREUSUARIO;
	$_POSP          =5;

	if($empleado==NULL){
		$empleado = $_NOMBREUSUARIO;
	}

?>
<script language="JavaScript" type="text/JavaScript" src="../../../../../util/chkform.js">

</script>
<?
/*if(($_PERFIL==0)||($_PERFIL==17)){
	$qry = "SELECT a.*, b.nombre_emp,b.ape_pat,b.ape_mat FROM comunicacion a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=" . $institucion;
}else*/
if(($_PERFIL==0) || ($_PERFIL==17) || ($_PERFIL==14) ){
	$qry = "SELECT a.*, b.nombre_emp,b.ape_pat,b.ape_mat FROM comunicacion a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=" . $institucion ." AND a.rut_emp=" . $empleado . " AND a.rut_apo is NULL  ORDER BY fecha ASC";
}
if((($_PERFIL==15) || ($_PERFIL==16))&& ($institucion!=25452)){
	 $qry= "SELECT distinct a.*, b.nombre_emp,b.ape_pat,b.ape_mat FROM comun_alumno c INNER JOIN comunicacion a ON c.id_comun=a.id_comun INNER JOIN empleado b ON a.rut_emp=b.rut_emp  ";
	 $qry = $qry. " WHERE c.rut_alum=".$alumno . " and rdb=". $institucion ." ORDER BY fecha ASC";
}
if((($_PERFIL==15) || ($_PERFIL==16))&& ($institucion==25452)){
	 $qry= "SELECT distinct a.*, b.nombre_emp,b.ape_pat,b.ape_mat FROM comun_alumno c INNER JOIN comunicacion a ON c.id_comun=a.id_comun INNER JOIN empleado b ON a.rut_emp=b.rut_emp  ";
	 $qry = $qry. " WHERE c.rut_alum=".$alumno . " and rdb=". $institucion ."  and a.autorizacion=2 ORDER BY fecha ASC";
}
$Rs_Comunic =@pg_exec($conn,$qry);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
</head>
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                       <? include("../../../../../menus/menu_lateral.php"); ?> </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
								  <!-- inicio codigo nuevo -->
								  
								  
								  
								  
<? if(($_PERFIL==0) OR ($_PERFIL==8) OR ($_PERFIL==17) OR ($_PERFIL==14) OR ($_PERFIL==15)){  ?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
      <td align="right">
      <? if($_PERFIL!=0){?>
		  <INPUT class="botonXX"  TYPE="submit" value="AGREGAR" name=btnGuardar onClick=document.location="seteaComunicacion.php?caso=2">
	  <? } ?>
      <? if($_PERFIL!=15 && $_PERFIL!=16){?>
		<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../../curso/seteaCurso.php3?caso=1&curso=<? echo $curso; ?>"> </td>
	  <? } ?>
  </tr>
</table>
<? } ?>
<table width="600" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr height=20>
		  <TD align=middle colspan="7" class="tableindex">COMUNICACIONES <? if(($_PERFIL==15) || ($_PERFIL==16)) echo "RECIBIDAS"; else echo "ENVIADAS";?> </TD>
	</tr>
        <tr class="tablatit2-1"> 
          <td>FECHA</td>
          <td>TITULO</td>
          <td>DOCENTE</td>
        </tr>
		<? 	if (@pg_numrows($Rs_Comunic)!=0){
			for ($i=0; $i<@pg_numrows($Rs_Comunic);$i++){
				$fila = @pg_fetch_array($Rs_Comunic,$i); ?>
			<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaComunicacion.php?comunicacion=<?php echo $fila['id_comun'];?>&caso=1')>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><? impF($fila['fecha']);?></font></td>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><? echo strtoupper($fila['titulo']);?></font></td>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><?php echo $fila["ape_pat"]."  ".$fila["ape_mat"].", ".$fila["nombre_emp"];?></font></td>
			</tr>
				
			<? }
			}else{?>
			<tr>
				<td colspan="4"><font size="2" face="Arial, Helvetica, sans-serif">No existen registros</font></td>
			</tr>
			<? } ?>
      </table></td>
  </tr>
</table>
<BR>
<? 
	if(($_PERFIL==0) || ($_PERFIL==17) || ($_PERFIL==14) ){
		$sql= "SELECT distinct a.*, b.nombre_apo,b.ape_pat,b.ape_mat FROM comunicacion a INNER JOIN apoderado b ON a.rut_apo=b.rut_apo WHERE rdb=" . $institucion ." ORDER BY fecha ASC";
	}
	if(($_PERFIL==15) || ($_PERFIL==16)){
		$sql= "SELECT distinct a.*, b.nombre_emp,b.ape_pat,b.ape_mat FROM comunicacion a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE a.rut_apo=" . $apoderado ." and rdb=" . $institucion ." ORDER BY fecha ASC";
	}
	$Rs_Apo = @pg_exec($conn,$sql);
	
	?>
		<table width="600" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr height=20>
		  <TD align=middle colspan="7" class="tableindex">COMUNICACIONES <? if(($_PERFIL==15) || ($_PERFIL==16)) echo "ENVIADAS"; else echo "RECIBIDAS";?></TD>
		</tr>
        <tr class="tablatit2-1"> 
          <td>FECHA</td>
          <td>TITULO</font></td>
		  <? if(($_PERFIL==15) || ($_PERFIL==16)){ ?>
          <td>DOCENTE</td>
		  <? } ?>
		  <? if(($_PERFIL==0) || ($_PERFIL==17) || ($_PERFIL==14)){?>
	      <td>APODERADO</td>
		  <? } ?>
        </tr>
		<? 	if (@pg_numrows($Rs_Apo)!=0){
			for ($i=0; $i<@pg_numrows($Rs_Apo);$i++){
				$fila = @pg_fetch_array($Rs_Apo,$i); ?>
			<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaComunicacion.php?comunicacion=<?php echo $fila['id_comun'];?>&caso=1')>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><? impF($fila['fecha']);?></font></td>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><? echo strtoupper($fila['titulo']);?></font></td>
				<? if(($_PERFIL==15) || ($_PERFIL==16)){ ?>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><?php echo $fila["ape_pat"]."  ".$fila["ape_mat"].", ".$fila["nombre_emp"];?></font></td>
				<? } ?>
				<? if(($_PERFIL==0) || ($_PERFIL==17) || ($_PERFIL==14) ){ ?>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><?php echo $fila["ape_pat"]."  ".$fila["ape_mat"].", ".$fila["nombre_apo"];?></font></td>
				<? } ?>
			</tr>
				
			<? }
			}else{?>
			<tr>
				<td colspan="4"><font size="2" face="Arial, Helvetica, sans-serif">No existen registros</font></td>
			</tr>
			<? } ?>
      </table></td>
  </tr>
</table>

								  
								  
								  
								  
								  <!-- fin codigo nuevo -->
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
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
