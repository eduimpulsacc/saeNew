<?php require('../../util/header.inc');?>

<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 2;
	$_bot = 0;
	$_MDINAMICO = 1;
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	
    
/************ PERMISOS DEL PERFIL *************************/
if($nw==1){
	$_MENU =$menu;
	session_register('_MENU');
	$_CATEGORIA = $categoria;
	session_register('_CATEGORIA');
}
$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." ";
//AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
$ingreso = @pg_result($rs_permiso,0);
$modifica =@pg_result($rs_permiso,1);
$elimina =@pg_result($rs_permiso,2);
$ver =@pg_result($rs_permiso,3);
	

    if ($ano == ""){
       if ($_PERFIL == 0){
	      echo "paso 1";
          echo $sqlDiario = "select * from diario_mural order by fecha_publi,id_diario desc";
          $rsDiario  = @pg_Exec($conn,$sqlDiario);
	   }else{
	       if ($_PERFIL == 17 AND $ano == NULL){
               $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
               //$qry="SELECT * FROM ano_escolar WHERE RDB=".$_INSTIT." AND SITUACION = 1";
               $result = @pg_Exec($conn,$qry);
               $fila = @pg_fetch_array($result,0);	
               $_ANO=$fila["id_ano"];
               $ano = $_ANO;
		       
			   echo $sqlDiario = "select * from diario_mural where id_ano = $ano order by fecha_publi,id_diario desc";
               $rsDiario  = @pg_Exec($conn,$sqlDiario);
		  
		   }
	   }	   	   
   }else{
	
       $sqlDiario = "select * from diario_mural where id_ano = $ano order by fecha_publi,id_diario ASC";
       $rsDiario  = @pg_Exec($conn,$sqlDiario);
    }

	
	//$sqlDiario = "select * from diario_mural where id_ano = $ano order by fecha_publi desc";
	//$rsDiario  = @pg_Exec($conn,$sqlDiario);
	
	
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="700" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=5;
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
                                  <td align="right"><br>

								   <!-- INSERTAMOS CODIGO NUEVO -->
							 
							 
							      <center>
							        <table width="" border="0" cellspacing="1" cellpadding="3">
							          <tr>
    <td align="right">
	<? 


	if ($situacion !=0 AND $_PERFIL!=15){ 
	if($ingreso==1 || $_PERFIL==0|| $_PERFIL==14|| $_PERFIL==28|| $_PERFIL==25){?>
		       <INPUT class="botonXX"  TYPE="button" value="AGREGAR" name=btnCancelar onClick=document.location="IngresaDiario.php?diario=0">
	    <? } 
	}// cierre if año escolar?>
	
	</td>
    <td align="right"><img src="images/icono_diario_mural.png" width="64" height="46" align="right"></td> 
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <TR height=20>
		<TD align=center colspan=2 class="tableindex">
			Diario Mural</TD>
	</TR>
</table>
<?	if(@pg_numrows($rsDiario)!=0){
	for($i=0 ; $i < @pg_numrows($rsDiario) ; $i++)
	{
		$fDiario = @pg_fetch_array($rsDiario,$i);	

?>
<br>
<table width="" border="0" cellspacing="1" cellpadding="3">
  <tr onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' <? if($_PERFIL==14 OR $_PERFIL==2 OR $_PERFIL==0) {?> onClick=document.location="IngresaDiario.php?diario=<? echo $fDiario['id_diario'] ?>"<? } ?>>
    <td>
		<table width="" border="0" cellspacing="1" cellpadding="3">
		  <tr>
		  
			<td width="200" align="center" valign="top"><img src=images/<?php echo $fDiario['nom_foto'] ?> ALT="FOTO DIARIO MURAL"  width=200 onClick="MM_openBrWindow('foto_diarioMural.php?dmural=<?php echo $fDiario['nom_foto'] ?>','','scrollbars=yes,resizable=yes,width=800,height=600')"></td>
			<td width="435" align="left" valign="top">
			  <font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo $fDiario['titulo']?></strong></font><br>
			  <font face="Arial, Helvetica, sans-serif" size="2"><? echo $fDiario['detalle']?></font><br>			</td>
		  </tr>
		</table>	  </td>
  </tr>
</table>
<? 	}
	}else{?>
<table width="" border="0" cellpadding="1" cellspacing="1">
	<tr>
		<td><font face="arial, geneva, helvetica" size="1">NO EXISTEN INFORMACIÓN DISPONIBLE</font></td>
	</tr>
</table>
<? } ?>
</center>
							 
										
									 
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
									
									
									</td>
								 </tr>
							 </table>	  
								  
							 <!-- FIN CODIGO NUEVO -->
								  
								  
								  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php");?></td>
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
