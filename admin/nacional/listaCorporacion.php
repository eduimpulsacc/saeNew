<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	//$_CORPORACION = $_REQUEST['corp'];
	//$_PERFIL;
	$menu = $_GET['menus'];
	if ($menu == ''){
        	$menu =0 ;
	       }
   $_MDINAMICO = 1;	

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

		<?php include('../../util/rpc.php3');?>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
 
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
        <tr> 
        <td>
		<!-- AQUI VA TODA LA PROGRAMACIÓN  -->
	    <center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
            <tr height="20">
            <td colspan="4" align="middle" class="tableindex">Corporación de <?= ($_NOMCORP) ?></td>
			</tr>
			<tr>
				<td align="center" width="50" class="tablatit2-1">
					<div align="center">Rbd</div></td>
				<td align="center" width="80" class="tablatit2-1">
					<div align="center">Institucion</div></td>
                <td align="center" width="50" class="tablatit2-1">
					<div align="center">Corporacion</div></td>   
			</tr>
<?

$qry_ins="SELECT ins.nombre_instit,ins.rdb,co.nombre_corp,co.num_corp,nac.id_nacional,nac.nombre  
FROM nacional as nac
INNER JOIN nacional_corp nc on nc.id_nacional = nac.id_nacional
INNER JOIN corp_instit ci on ci.num_corp = nc.num_corp
INNER JOIN corporacion co on co.num_corp = ci.num_corp
INNER JOIN institucion ins on ins.rdb = ci.rdb
WHERE nac.id_nacional = ".$_CORPORACION." ORDER BY 4";
$result_ins=@pg_Exec($conn,$qry_ins);

            for($i=0;$i<pg_numrows($result_ins);$i++)
				{	
					$fila_ins = pg_fetch_array($result_ins,$i);
				?>
				<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('../institucion/seteaInstitucion.php3?institucion=<?=$fila_ins['rdb']?>&caso=5&mdinamico=0&menu=4&categoria=61')>
					<td align="center" class="textosimple"><?=$fila_ins['rdb']?></td>
					<td class="textosimple">&nbsp;&nbsp;<?=$fila_ins['nombre_instit']?></td>
                    <td class="textosimple">&nbsp;&nbsp;<?=$fila_ins['nombre_corp']?></td>
				</tr>						
				
			<?	}	?>
	

		</table>
	</center>
	<?
	$ano =$_ANO;
	?>
									 
	<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
	 </td>
	</tr>
 </table>							  
								  
</tr>
 </table></td>
 </tr>
 <tr align="center" valign="middle"> 
 <td height="45" colspan="2" class="piepagina">SAE Sistema 
  de Administraci&oacute;n Escolar - 2005 </td>
  </tr>
  </table></td>
  </tr>
  </table>
  </td>
  <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
  </table></td>
  </tr>
</table>
</body>
</html>
