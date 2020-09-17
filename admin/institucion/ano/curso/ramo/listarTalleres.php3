<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$_POSP          =5;
	$_bot           =5;
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion_ano=pg_result($result,0);
	
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
		$_ITEM = $item;
		session_register('_ITEM');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}
if (($_PERFIL!=0)&&($_PERFIL!=14)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)){$whe_perfil_curso=" and curso.id_curso=$curso";}
	
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

      function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=10&pa=3&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
</script>
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>


</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
                       <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo nuevo -->
								  
								  
								  
	<center>
		<table WIDTH="90%" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD colspan=2>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						
						<TR valign="top">
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
										<?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano  ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
			 <form name="form"   action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
					
						<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
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
							</select>
				<? }	?>
						</form>			
							</TD>
						</TR>
						<TR>
					</TABLE>
				</TD>
			</TR>
			<tr>
				<td colspan=3 align=right>
					<?php
					  if ($situacion_ano !=0){
					  if($ingreso==1){
							if (($plan!=461987) and ($plan!=1901975) and ($plan!=771982) and ($plan!=121987)){?>
								<INPUT  class="botonXX"  TYPE="button" value="AGREGAR" onClick=document.location="seteaTaller.php3?caso=2">
						<?php } 
					  }?>
						       <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../seteaCurso.php3?caso=4">
					<?php }?>
				</td>
			</tr>
			<tr height="20">
				<td align="middle" colspan="4" class="tableindex">Talleres</td>
			</tr>
			<tr class="tablatit2-1">
				<td align="center" width="300">
					NOMBRE
				</td>
				<td align="center" width="200">
					DOCENTE ACARGO
				</td>
                <td align="center" width="200">
					DOCENTE QUE IMPARTE
				</td>
				<td align="center" width="100">
					MODO EVALUACION
				</td>
			</tr>
			<?php
				if($_PERFIL==17 && $_TA==1){
					 $qry = "SELECT * FROM taller t INNER JOIN dicta_taller dt ON t.id_taller=dt.id_taller INNER JOIN ano_escolar a ON a.id_ano=t.id_ano INNER JOIN institucion i ON i.rdb=t.rdb WHERE t.rdb=".$institucion." AND t.id_ano=".$ano." AND dt.rut_emp=".$_NOMBREUSUARIO; 
				}
				else{
				    if ($_INSTIT==516){
					    $qry = "SELECT * FROM taller t INNER JOIN dicta_taller dt ON t.id_taller=dt.id_taller INNER JOIN ano_escolar a ON a.id_ano=t.id_ano INNER JOIN institucion i ON i.rdb=t.rdb WHERE t.rdb=".$institucion." AND t.id_ano=".$ano." AND dt.rut_emp=".$_NOMBREUSUARIO; 
					}else{
						
					   $qry="SELECT taller.id_taller, taller.nombre_taller, taller.modo_eval FROM taller WHERE taller.id_ano=".$ano." order by taller.nombre_taller";
				    }
				}			
				$result =pg_Exec($conn,$qry)or die("Fallo" .$qry);
				
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
			<?php
					for($q=0 ; $q < pg_numrows($result) ; $q++){
						$fila = pg_fetch_array($result,$q);
					
						//echo $fila['nombre_taller'];
						if($modifica==1){
			?>
						<tr  onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaTaller.php3?taller=<?php echo $fila["id_taller"];?>&caso=1&ano=<?php echo $ano; ?>')>
						<? }else{ ?>
						<tr  onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
						<? } ?>
							<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo  $fila["id_taller"]." ".$fila["nombre_taller"];?></strong>
								</font>
							</td>
                            
                            
                      <td align="left" >      
							<?php
							  $qry2="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat,dicta_taller.acargo FROM (dicta_taller INNER JOIN empleado ON dicta_taller.rut_emp = empleado.rut_emp) WHERE (((dicta_taller.id_taller)=".$fila["id_taller"].")) and dicta_taller.acargo=1";
								$result2 =@pg_Exec($conn,$qry2);
								for($i=0;$i<pg_numrows($result2);$i++){
								$fila2 = @pg_fetch_array($result2,$i);	
								$acargo=$fila2['acargo'];
								
								if($acargo==1){
							 ?>
							
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>&nbsp;
										<?php echo $fila2["ape_pat"]." ".$fila2["ape_mat"].", ".$fila2["nombre_emp"]?>
									</strong>
								</font>
							</td>
                           
                            <? }else{
							?>
                            <td >&nbsp;</td>
                            
                            <?
								}
							
							 }
							?>
							<td align="left" >
							<?
							  $qry3="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat,dicta_taller.acargo FROM (dicta_taller INNER JOIN empleado ON dicta_taller.rut_emp = empleado.rut_emp) WHERE (((dicta_taller.id_taller)=".$fila["id_taller"].")) and dicta_taller.acargo=0";
								$result3 =@pg_Exec($conn,$qry3);
								for($j=0;$j<pg_numrows($result3);$j++){
								$fila3 = @pg_fetch_array($result3,$j);	
								$acargo1=$fila3['acargo'];
							
						
							if($acargo1==0){ ?>
                            
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php echo $fila3["ape_pat"]." ".$fila3["ape_mat"].", ".$fila3["nombre_emp"]?>
                                        
									</strong>
								</font>
							</td>
                             <? 
							}else{
								?>
								<td align="left">&nbsp;</td>
								<?
                                }
							} ?>
                            
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
									<?php
										switch ($fila['modo_eval']) {
											 case 0:
												 imp('INDETERMINADO');
												 break;
											 case 1:
												 imp('Numérica');
												 break;
											 case 2:
												 imp('Conceptual');
												 break;
											 case 3:
											 imp('Numérico - Conceptual');
											 break;
										 };
									?>
									</strong>
								</font>
							</td>
						</tr>
			<?php
			
					}
				}
			?>
			
			
		</table>
	</center>

								  
								  
								  
								  
								  <!-- fin codigo nuevo --> </td>
                                  <td valign="top"><img src="icono_taller.png" width="152" height="106"></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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
<?
    pg_close($conn);
	pg_close($connection);
?>