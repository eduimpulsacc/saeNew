<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$bot = 7;

	function NombreSede($sede,$rbd,$conect){
		$qry = "SELECT NOMBRE FROM SEDE WHERE ID_SEDE=".$sede." AND ID_INSTITUCION=".$rbd;
		$result =pg_Exec($conect,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
		}else{
			if (@pg_numrows($result)!=0){
				$fila2 = @pg_fetch_array($result,0);	
				if (!$fila2){
					error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
					exit();
				};
				 return $fila2['nombre'];
			}else{
				 return "CASA MATRIZ";
			};
		};
	};


$_POSP = 3;

/************ PERMISOS DEL PERFIL *************************/
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
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=4;
						 include("../../../menus/menu_lateral.php");
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
					            	<br>

						
								    
									<!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
									<table width="" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      
	  <?
						 include("../../../cabecera/menu_inferiorinstitucion.php");
						 ?>
	  
	  
	  
	   </td>
  </tr>
</table>

	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<tr>
				<td colspan=4 align=right>
					<?php if($ingreso==1){ ?>
						<INPUT class="botonXX"  TYPE="button" value="AGREGAR" onClick=document.location="seteaEstancia.php?caso=2">
					<?php } ?>
					<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../sede/listarSede.php?caso=1">
				</td>
			</tr>
			<tr height="20">
				<td align="middle" colspan="4" class="tableindex">
					TOTAL DE SALAS DE CLASE
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="270" class="tablatit2-1">
					NOMBRE
				</td>
				<td align="center" width="60" class="tablatit2-1">
					CAPACIDAD
				</td>
				<td align="center" width="270" class="tablatit2-1">
					SEDE-SECTOR
				</td>
			</tr>
			<?php
				$qry="SELECT * FROM ESTANCIA WHERE ID_INSTITUCION=" . $institucion . "";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0;$i < @pg_numrows($result);$i++){
						$fila = @pg_fetch_array($result,$i);
			?>
				<!--MODIFICAR Y DIRECCIONARLO A HISTORICO-->
						<? if($modifica==1){?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaEstancia.php?estancia=<?php echo $fila["id_estancia"];?>&caso=1')>
						<? }else{?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
						<? } ?>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["nombre"];?></strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php echo($fila["capacidad"]);?>
									</strong>
								</font>
							</td>
							<td align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
										<?php imp(NombreSede($fila["id_sede"],$institucion,$conn)); ?>
								</font>
							</td>
						</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="4">
				<hr width="100%" color="#003b85">
				</td>
			</tr>
			<tr>
				<td colspan=4 align=center>&nbsp;</td>
			</tr>
		</table>
	</center>
									
									
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
									
									
									</td>
								 </tr>
							 </table>							  
								  
								  
								  
								  
		
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
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
