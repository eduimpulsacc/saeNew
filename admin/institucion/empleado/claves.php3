<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP           = 3;
	
	//show($_SESSION);	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}}

</script>
<script language=javascript>
function ventanaSecundaria (URL){
   window.open(URL,"Excel")
}
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
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--codigo antiguo -->
	<?php //echo tope("../../../util/");?>
	<? if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../index.php";
		 </script>
		 <? } ?>
	<center>
		<table WIDTH="700" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<tr>
				<td colspan=5 align=right>
				<? if ($institucion==9071){?>
					<INPUT class="botonXX"  TYPE="button" value="GENERAR EXCEL" onClick="ventanaSecundaria('personal_excel.php3')">
				<? }?>	
					<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarEmpleado.php3">				</td>
			</tr>
			<tr height="20" class="tableindex">
				<td align="middle" colspan="5">
					PERSONAL TOTAL DE LA INSTITUCION = 
						<?php
											$qry="SELECT COUNT(*) AS SUMA FROM TRABAJA WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila7 = @pg_fetch_array($result,0);	
													if (!$fila7){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila7['suma']);
												}
											}
										?>				</td>
			</tr>
			<tr class="tablatit2-1">
				
      <td align="center" width="268"> <div align="center">NOMBRE </div></td>
				
      <td align="center" width="150"> <div align="center">USUARIO </div></td>
				
      <td align="center" width="160"> <div align="center">CLAVE </div></td>
	  
	  <td align="center" width="160"> <div align="center">TIPOS DE ACCESO </div></td>
	  
			</tr>
			<?php
					
			  $qry="SELECT 
			  DISTINCT empleado.rut_emp,
			  empleado.dig_rut,
			  empleado.nombre_emp,
			  empleado.ape_pat,
			  empleado.ape_mat 
			  FROM trabaja 
			  INNER JOIN empleado ON 
			  trabaja.rut_emp=empleado.rut_emp 
			  WHERE (((rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp";
			  //echo $qry;
				$result =@pg_Exec($conn,$qry);
				
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
						$fila1 = @pg_fetch_array($result,0);	
						if (!$fila1){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							exit();
						}
					}

					
					
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila1 = @pg_fetch_array($result,$i);
						
						
				$qry2="SELECT usuario.*, accede.* 
				FROM usuario INNER JOIN accede ON usuario.id_usuario=accede.id_usuario 
				WHERE nombre_usuario='".$fila1['rut_emp']."' AND accede.estado=1 AND accede.rdb='".$_INSTIT."'" ;
//			echo "<br>".$qry2;
				$result2 =@pg_Exec($connection,$qry2);

				if (!$result2) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($result2)!=0){//En caso de estar el arreglo vacio.
						$fila2 = @pg_fetch_array($result2,0);	
						if (!$fila2){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							exit();
						}


if($fila1['rut_emp'] != $_NOMBREUSUARIO || $_PERFIL!=0){
$sql_dis = "SELECT  count(accede.*) FROM usuario
INNER JOIN accede ON usuario.id_usuario=accede.id_usuario 
WHERE nombre_usuario='".$fila1['rut_emp']."' AND accede.estado=1 AND accede.rdb='$institucion'
and accede.id_perfil=14";
$rd_dis = pg_exec($connection,$sql_dis);
$cuenta = pg_result($rd_dis,0);
}else{
$cuenta=0;
}


			?>

						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' >
					      <? if ($_PERFIL!=0 and $institucion==8933 or $institucion==25218 or $institucion==8566){ 
						  ?>
						  <td align="left">
                          <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      					  <strong>
						  <?php echo $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"];?>
                          <br>
                          </strong>
                          </font> </td>
							<? } else {?>
						  <td align="left" onClick=go('usuario/claveAcceso.php3?empleados=<?php echo trim($fila1["rut_emp"]);?>&caso=1')> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      					  <strong><?php echo $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"];?></strong> </font> </td>
							<? }?>
      <td align="left" onClick=go('usuario/claveAcceso.php3?empleados=<?php echo trim($fila1["rut_emp"]);?>&caso=1')> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong>
		<? if ($_PERFIL==14 or $_PERFIL==0 ) { ?>
	   <?php echo $fila2["nombre_usuario"];?>  
	   <? } else  echo "******************" ?></strong> </font></td>
							<td align="left" onClick=go('usuario/claveAcceso.php3?empleados=<?php echo trim($fila1["rut_emp"]);?>&caso=1')>
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
			<?php 
            if($_PERFIL==0){
            $cuenta=0;
            }
			elseif($_PERFIL==14 && $fila1["rut_emp"] == $_NOMBREUSUARIO){
            $cuenta=0;
            }
			
            
            echo ($cuenta == 0)?$fila2["pw"]:"******************";
            ?>
            
                                    
									</strong>								</font></td>
							<td align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><? 
						$id_usuario = $fila2['id_usuario'];
						$qry3 = "select id_perfil from accede where id_usuario = '$id_usuario'";
						$res3 = pg_Exec($connection,$qry3);
						for($x=0;$x<pg_numrows($res3);$x++)
						{
							$id_fila = pg_fetch_array($res3,$x);
							
	
							$id_perfil = $id_fila['id_perfil'];										
							$qry4 = "select nombre_perfil from perfil where id_perfil = '$id_perfil'";
							
							
							$res4=pg_Exec($connection,$qry4);
							$nombre_p = @pg_fetch_array($res4,0);
									
							$nombre_perfil = $nombre_p['nombre_perfil'];
							$tot_nombre[$i] = "<option disabled='disabled'>".$nombre_perfil.$tot_nombre[$i]."</option>";						
						}	
							if(pg_numrows($res3)==1)
							{	?>
								<label><?=$nombre_perfil?></label>
						<?	}else{?>
							
							<select>	
								<? echo $tot_nombre[$i];?>
							</select>						 									
						<?	}	?>									
									</strong>
								</font>							
							</td>
										
						</tr>
			<?php
			
			}
		
		}
	 }
  }
	
	?>
		<tr>
		<td colspan="5">
		<hr width="100%" color="#0099cc">
        </td>
		</tr>
		</table>
	</center>
	  <!-- codigo antiguo -->
	  &nbsp;</td>
      </tr>
      </table>
      </td>
      </tr>
      </table>
      </td>
      </tr>
      <tr align="center" valign="middle"> 
      <td height="45" colspan="2" class="piepagina">
      SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
      </tr>
      </table>
      </td>
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
<? pg_close($conn);?>