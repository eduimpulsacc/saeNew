<?php 
	require('../../../util/header.inc');
	$_POSP = 3;
	$_bot = 3;
	
	$NOMBREUSUARIO=$_USUARIO;
	$institucion	=$_INSTIT;
    
	$largoPagina=40;
	$pagOffset=$largoPagina*($pag-1);
	
	
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
	<head>
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

		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	

</head>

		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT></head>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../Sea/cortes/b_ayuda_r.jpg','../../../Sea/cortes/b_info_r.jpg','../../../Sea/cortes/b_mapa_r.jpg','../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superior.php") ;?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=2;	
						 include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="90%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="">
								  
								  
								  
								  <!-- nuevo-->
				<?php if($_PERFIL==0) {?>				  
					<form method="post" name="frm1" action="../../../atributos/listarInstituciones.php3?listar=A&pag=1"><center>
				<? }?>
				  <table  border="0" cellpadding="0" cellspacing="0" width=580>
      <tr>
							<td align="left" width=590>
								<table width="100%" align=center>
            <tr valign=bottom>
									    <tr>
										 
              <td width="62%"><font face="arial, geneva, helvetica" size="2" color="#000000">
					                       <strong>Plan de Estudios</strong>
				                         </font> </td>
              <td width="20%">&nbsp; </td>
										<td width="40%" align="center"> 										</td>
										</tr>
										<td width="22%">
										<? 
										if($ingreso==1){?>
										<INPUT class="botonXX"  TYPE="button" value="PROPIO" onClick=document.location="seteacreaPlanEstudio.php3?&caso=2&institucion1=<?php echo $institucion ?>" >
										<INPUT class="botonXX"  TYPE="button" value="INDICATIVO" onClick=document.location="seteaPlanIndica.php3?caso=2&institucion1=<?php echo $institucion ?>" >&nbsp;&nbsp;										
										<? }
										?>
										</td>
										
              <td width="20%"> </td>
										 <!------------------/filtro por RBD/-------------->
											<td width="70%" align=RIGHT>						                  </td>
								</tr>
								</table>							</td>
						</tr>
					</table>
					</center>
				</form>
<?php
  		$qry = "SELECT DISTINCT plan_estudio.* from plan_estudio, plan_inst where plan_estudio.cod_decreto = plan_inst.cod_decreto and plan_estudio.rdb=".$institucion;			
             $result =@pg_Exec($conn,$qry);            
			 
	            $filRBD=(trim($swrbd)=='1')?$filtroRBD:"";
	                if ($filRBD!='')                
	?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
	<tr>
		<td>

	<table border="0" cellpadding="1" cellspacing="1" WIDTH=100% align=center border="1">
		
		<tr height="20">			
          <td align="left" colspan="6" class="tableindex"> Planes de Estudio Propios </td>
		</tr>
		<tr class="tablatit2-1">
			<td WIDTH=50 ALIGN=left class="tablatit2-1">COD DECRETO</td>
			<td WIDTH=187 ALIGN=left class="tablatit2-1">RESOLUCION</td>
			<td width="231" ALIGN=left class="tablatit2-1">DESCRIPCION</td>
 		</tr>
		<?php
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
                   
				if($modifica==1){	
		?>
		<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('PlanEstudio.php3?plan=<?php echo trim($fila["cod_decreto"]);?>&caso=1&institucion1=<?php echo $institucion ?>')>
				<? }else{?>
						<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' >
				<? } ?>
				<td align="left" >
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong><?php echo $fila["cod_decreto"];?></strong>
					</font>
				</td>
				
				<td align="left" >
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong><?php echo $fila["nombre_decreto"];?></strong>
					</font>
				</td>
				<td align="left">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>
						<?php 
							 echo($fila['cursos']) 
						?>
						</strong>
					</font>
				</td>
			</tr>
		<?php 
		}  
	 ?>
<TR>
<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?php // } ?>
</TR>
	
		
	<tr height="20">
			<td align="left" colspan="6" class="tableindex"S>
				Planes de Estudio Indicativos
			</td>
		</tr>
		<tr class="tablatit2-1">
	<?php		
    $qry2="SELECT DISTINCT plan_estudio.* FROM (plan_estudio INNER JOIN plan_inst ON plan_estudio.cod_decreto = plan_inst.cod_decreto) WHERE (plan_inst.rdb=".$institucion." and plan_estudio.rdb=0) ORDER BY nombre_decreto";
	  $result2 =@pg_Exec($conn,$qry2);                
          if (@pg_numrows($result2)!=0){ 
	?>		
    <td WIDTH=50 ALIGN=left class="tablatit2-1"> COD DECRETO </td>
				
	<td WIDTH=187 ALIGN=left class="tablatit2-1"> RESOLUCION </td>
			<td width="231" ALIGN=left class="tablatit2-1">
				DESCRIPCION			</td>
 		</tr>
		<?php
			for($i=0 ; $i < @pg_numrows($result2) ; $i++){
				$fila2 = @pg_fetch_array($result2,$i);
                if($modifica==1){ 
		?>
		<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('PlanEstudio.php3?plan=<?php echo trim($fila2["cod_decreto"]);?>&caso=1&institucion1=<?php echo $institucion ?>')>
			<? }else{ ?>
		<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff'>
			<? } ?>
				
				<td align="left" >
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong><?php echo $fila2["cod_decreto"];?></strong>
					</font>
				</td>
				
				<td align="left" >
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong><?php echo $fila2["nombre_decreto"];?> <? echo " - "; echo $fila2["cod_decreto"]; ?></strong>
					</font>
				</td>
				<td align="left">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>
						<?php 
							 echo($fila2['cursos']) 
						?>
							</strong>
						</font>
					</td>
				</tr>
				<?php 
              
		} 
		} ?>
		<tr height="50" bgcolor="white">
			<td align="middle" colspan="6">

				<?php 
                      
                      if($pag!=0){?>
					<a HREF="../../../atributos/listarTiposEnsenanza.php3?pag=<?php echo ($pag-1)?>&listar=<?php echo trim($listar)?>&tipoIns=<?php echo trim($tipoIns) ?>">
						<font face="arial, geneva, helvetica" size="2" color="black">
							<strong>Anteriores <?php echo $largoPagina?> ...</strong>
						</font>
					</a>
					<?php if(pg_numrows($result)==$largoPagina){?>
						&nbsp;&nbsp;&nbsp;
						<font face="arial, geneva, helvetica" size="5" color="black">
							<strong>-</strong>
						</font>
						&nbsp;&nbsp;&nbsp;
					<?php }?>

				<?php }?>
				<?php if(pg_numrows($result)==$largoPagina){?>
					<a HREF="../../../atributos/listarTiposEnsenanza.php3?pag=<?php echo ($pag+1)?>&listar=<?php echo trim($listar)?>&tipoIns=<?php echo trim($tipoIns) ?>">
						<font face="arial, geneva, helvetica" size="2" color="black">
							<strong>Siguientes <?php echo $largoPagina?> ...</strong>
						</font>
					</a>
				<?php }?>
			</td>
		</tr>
	</table>
	
</td></tr></table>	


								  
								  
								  
								  <!-- fin nuevo -->
								  
								  
								  
								  
								  
								  
								  
								  
								  
								  
								  
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
