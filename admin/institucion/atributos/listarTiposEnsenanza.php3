<?php 
	require('../../../util/header.inc');
	$institucion	=$_INSTIT;
    
	$largoPagina=40;
	$pagOffset=$largoPagina*($pag-1);
	$_POSP = 3;
	$_bot  = 4;
	
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
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      
              <td width="27%" height="363" align="left" valign="top"><? $menu_lateral=2; include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  
                      <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                  <td height="246" align="center" valign="top"><!-- tipos de enseñanza -->




	<!--form method="post" name="frm1" action="../../../Sea/listarInstituciones.php3?listar=A&pag=1">
					<center>
					<table  border="0" cellpadding="0" cellspacing="0" width=600>
						<tr valign="top">
							<td width=0 align="left">
								<table width="94%" align=center>
            <tr valign=bottom>
										<td width="8%">
											
										</td>
										<td width="13%">
                                             
										</td>
											
              <td width="65%"align=right> <input name="button" type="button" onClick=document.location="seteaTipoEnse.php3?caso=2&institucion1=<?php echo $institucion ?>" value="AGREGAR TIPO DE ENSEÑANZA" ></td>
									  <td width="14%" align=right>
											<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../ano/ano_escolar.php3"<? $_FRMMODO='mostrar' ?>>
					                  </td>
									</tr>
									
								</table>
							</td>
						</tr>
						<tr>
							
        <td align="center" colspan="2">&nbsp; </td>
						</tr>
					</table>
					</center>
				</form-->
<?php
           $qry = "SELECT * FROM tipo_ense_inst as TEI, tipo_ensenanza as TE WHERE tei.cod_tipo=te.cod_tipo and tei.rdb=".$institucion;
           $result =@pg_Exec($conn,$qry);                
                  if (@pg_numrows($result)!=0){ 
                         

	$filRBD=(trim($swrbd)=='1')?$filtroRBD:"";
	if ($filRBD!='')                
//		$qry = "SELECT * FROM tipo_ense_inst AS TEI INNER JOIN tipo_ensenanza AS TE ON TEI.cod_tipo=TE.cod_tipo WHERE TEI.rdb=$institucion ORDER BY cod_tipo LIMIT $largoPagina OFFSET $pagOffset";
//                $result =@pg_Exec($conn,$qry);                
//                 if (@pg_numrows($result)!=0){ 
                
                
	?>
	
	

	<table border="0" cellpadding="1" cellspacing="1" WIDTH=550 align=center>
		
		<tr height="20"> 
                            <td colspan="6" align="middle" class="tableindex"> LISTA DE TIPOS DE ENSEÑANZA</td>
		</tr>
		<tr class="tablatit2-1">
			
    <td WIDTH=69 ALIGN=CENTER class="tablatit2-1"> CODIGO </td>
			<td WIDTH=255 ALIGN=CENTER class="tablatit2-1">
				NOMBRE TIPO DE ENSEÑANZA			</td>
			<td width="143" ALIGN=CENTER class="tablatit2-1">
				FECHA DE RESOLUCION			</td>
			<td width="120" ALIGN=CENTER class="tablatit2-1">
				PLAN			</td>
			
		</tr>
		<?php
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
                 if($modifica==1){  
		?>
		<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='ffffff' onClick=go('seteaTipoEnse.php3?corre=<?php echo $fila["corre"];?>&ensenanza=<?php echo trim($fila["cod_tipo"]);?>&plan=<?php echo trim($fila["cod_decreto"]);?>&caso=1&institucion1=<?php echo $institucion ?>')>
		<? }else{ ?>
		<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='ffffff'>
		
		<? } ?>

				<td align="right" >
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong><?php echo $fila["cod_tipo"];?></strong>&nbsp;&nbsp;&nbsp;
					</font>
				</td>
				<td align="left" >
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong><?php echo $fila["nombre_tipo"];?></strong>
					</font>
				</td>
				<td align="center">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>
                          
						<?php 
							 impF($fila['fecha_res']) 
						?>
						</strong>					</font>				</td>
				<td align="left">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>
                          <? 
						if(($fila['cod_decreto']==5451996) || ($fila['cod_decreto']==5521997)){
									echo "6252003";
								}else{
									echo($fila['cod_decreto']); 
								}
						?>
						</strong>
					</font>
				</td>
				
			</tr>
		<?php 
              
}  ?>
		<tr>
			                <td colspan="6">&nbsp; </td>
		</tr>
		<tr height="50" bgcolor="white">
			<td align="middle" colspan="6">

				<?php 
                      
                      if($pag!=0){?>
					<a HREF="../../../Sea/listarTiposEnsenanza.php3?pag=<?php echo ($pag-1)?>&listar=<?php echo trim($listar)?>&tipoIns=<?php echo trim($tipoIns) ?>">
						<font face="arial, geneva, helvetica" size="2" color="black">
							<strong>Anteriores <?php echo $largoPagina?> ..</strong>
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
					<a HREF="../../../Sea/listarTiposEnsenanza.php3?pag=<?php echo ($pag+1)?>&listar=<?php echo trim($listar)?>&tipoIns=<?php echo trim($tipoIns) ?>">
						<font face="arial, geneva, helvetica" size="2" color="black">
							<strong>Siguientes <?php echo $largoPagina?> ..</strong>
						</font>
					</a>
				<?php }?>
			</td>
		</tr>
	</table>
	<?php }  ?>


<?php 
	//	echo "pag:".$pag."<BR>";
	//	echo "pagOffset:".$pagOffset."<BR>";
	//	echo "pg_numrows:".pg_numrows($result)."<BR>";
?>
</body>
</html>
								  <!-- fin tipos de enseñanaza -->
								  </td>
								  </tr>
								  </table>
                                  </td>
                                </tr>
                                <!-- <tr>
                                  <td height="103" align="center" valign="top"> 
                                    <table width="98%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                      <tr class="textolink"> 
                                        <td colspan="2">Tipo Instituci&oacute;n</td>
                                        <td width="38%">buscar por RBD (sin verificador)</td>
                                        <td width="31%">&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td width="20%" height="35"> <select name="select" size="1" class="cajatexto">
                                            <option>Colegios</option>
                                            <option>Universidades</option>
                                            <option>Escuelas</option>
                                            <option>Liceos</option>
                                          </select></td>
                                        <td width="11%" align="left"><img src="../../../Sea/cortes/b_listar.gif" width="56" height="18"></td>
                                        <td height="35"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td width="40%"><input name="textfield" type="text" class="cajatexto" size="15" maxlength="15"></td>
                                              <td width="60%"><img src="../../../Sea/cortes/b_buscar.gif" width="63" height="18"></td>
                                            </tr>
                                          </table></td>
                                        <td height="35">&nbsp;</td>
                                      </tr>
                                      <tr valign="middle"> 
                                        <td height="35" colspan="4"><div align="center" class="piepagina">- 
                                            Seleccionar presionando con el puntero 
                                            del mouse sobre el per&iacute;odo 
                                            que corresponda.</div></td>
                                      </tr>
                                    </table>
                                  </td>
                                --></tr>
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
