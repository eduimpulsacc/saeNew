<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP           = 3;
	
	
	
	
	if(pg_dbname($conn)=='coi_antofagasta'){
		$sql_emp="SELECT trabaja.rut_emp, empleado.nombre_emp ||' '|| empleado.ape_pat ||' '|| empleado.ape_mat as nombre_empleado 
		FROM trabaja 
		INNER JOIN empleado ON (trabaja.rut_emp = empleado.rut_emp) 
		WHERE trabaja.rdb = ".$institucion." ";
		$rs_emp=pg_exec($conn,$sql_emp);
		
		for($x=0;$x<pg_numrows($rs_emp);$x++){
			
			$fila_emp=pg_fetch_array($rs_emp,$x);
			
			$rut_emp=$fila_emp['rut_emp'].','.$rut_emp;
			
			}
		
		 $rut_empleado =	substr($rut_emp, 0, strlen($rut_emp) - 1);
		 $rut_empleado;
		
		
		 $sql_sinp="SELECT nombre_usuario FROM usuario INNER JOIN accede ON usuario.id_usuario=accede.id_usuario WHERE rdb=".$institucion."
		            and nombre_usuario not in('$rut_empleado')";
				
	//	$res_sinp =@pg_Exec($conn,$sql_sinp) or die( "PRIMERA : ".pg_last_error($conn));
		}else{
		
		$sql_sinp = " 	SELECT trabaja.rut_emp, empleado.nombre_emp ||' '|| empleado.ape_pat ||' '|| empleado.ape_mat as nombre_empleado 
				FROM trabaja 
				INNER JOIN empleado ON (trabaja.rut_emp = empleado.rut_emp) 
				WHERE trabaja.rdb = ".$institucion;
		
	
 /* $sql_sinp = "SELECT trabaja.rut_emp, empleado.nombre_emp ||' '|| empleado.ape_pat ||' '|| empleado.ape_mat as nombre_empleado 
				FROM trabaja 
				INNER JOIN empleado ON (trabaja.rut_emp = empleado.rut_emp) 
				WHERE trabaja.rdb = ".$institucion." and CAST(trabaja.rut_emp AS VARCHAR) not in (SELECT nombre_usuario 
				FROM dblink('dbname=coi_usuario port=5432 host=200.29.21.125 user=postgres password=cole#newaccess', 
				'SELECT nombre_usuario FROM usuario INNER JOIN accede ON usuario.id_usuario=accede.id_usuario WHERE rdb='||".$institucion.") 
				AS accesos (nombre_usuario text))";*/
	/*echo "<pre>";		
	echo $sql_sinp;
	echo "</pre>";*/
		}
	
	$res_sinp =@pg_Exec($conn,$sql_sinp) or die( "PRIMERA : ".pg_last_error($conn));
	

	
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

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
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
                      <td width="27%" height="363" align="left" valign="top"> 
                      <? include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                          <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde" style="border-collapse:collapse">
                                <tr> 
                                  <td>
								 <!--codigo antiguo -->
								 <form name="form1" method="post" action="genera_claves.php">
								 <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                                    <tr class="tableindex">
                                      <td>GENERACI&Oacute;N DE CLAVES PARA EL PERSONAL </td>
                                    </tr>
                                    <tr class="cuadro01">
                                      <td>Deje el campo de password en blanco para no generar un usuario para ese trabajador </td>
                                    </tr>
                                    
                                    <tr>
                                    	<table width="100%" border="1" style="border-collapse:collapse">
                                        	<tr>
                                            	<td colspan="3" align="center"><b><font style="font-size:16px">LISTA DE TRABAJADORES SIN USUARIO</font></b></td>
                                            </tr>
                                        	<tr>
                                                <td width="40%"><b><font style="font-size:13px">NOMBRE</font></b></td>
                                                <td width="40%"><b><font style="font-size:13px">USUARIO</font></b></td>
                                                <td width="20%"><b><font style="font-size:13px">NUEVA PASSWORD</font></b></td>
                                            </tr>
                                        	<? 
											
											if(pg_dbname($conn)=='coi_antofagasta'){
												
												for($i=0;$i<pg_numrows($rs_emp);$i++){
													$arr_sinp = pg_fetch_array($rs_emp,$i);
											//while ($arr_sinp = pg_fetch_array($res_sinp)) {?>
                                            <input type="hidden" name="rut<?=$i;?>" value="<?=$arr_sinp['rut_emp'];?>">
                                    		<tr>
        <td width="40%"><font style="font-size:13px"><?=strtoupper($arr_sinp['nombre_empleado']);?></font></td>
                                                <td width="40%"><font style="font-size:13px"><?=$arr_sinp['rut_emp']?></font></td>
                                                <td width="20%"><input name="pw<?=$i;?>" type="text" value="12345"></td>
                                            </tr>
                                            
                                            <? 
											  }
											}else{
											
											
												for($i=0;$i<pg_numrows($res_sinp);$i++){
													$arr_sinp = pg_fetch_array($res_sinp,$i);
													if($arr_sinp['rut_emp']!=''){
														//continue;
														}
											//while ($arr_sinp = pg_fetch_array($res_sinp)) {?>
                                            <input type="hidden" name="rut<?=$i;?>" value="<?=$arr_sinp['rut_emp'];?>">
                                    		<tr>
        <td width="40%"><font style="font-size:13px"><?=strtoupper($arr_sinp['nombre_empleado']);?></font></td>
                                                <td width="40%"><font style="font-size:13px"><?=$arr_sinp['rut_emp']?></font></td>
                                                <td width="20%"><input name="pw<?=$i;?>" type="text" value="12345"></td>
                                            </tr>
                                            
                                            <? }
											  }
											?>
												<input type="hidden" name="contador" value="<?=$i;?>">
                                        
                                    	</table>
                                    </tr>
                                    
                                    <tr>
                                      <td>
									  <div align="center">
                                        <label>
                                        <input type="submit" name="Submit" value="SI, GENERAR CLAVES" class="botonXX">
                                        </label>
                                        <label>
                                        <input name="Submit2" type="button" onClick="MM_callJS('history.go(-1)')" value="VOLVER" class="botonXX">
                                        </label>
                                      </div>
									  </td>
                                    </tr>
                                  </table>
								  </form>
								  <!-- codigo antiguo -->
								   </td>
                                </tr>
                              </table></td>
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
