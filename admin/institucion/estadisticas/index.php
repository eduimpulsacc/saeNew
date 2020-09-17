<?php 
//session_start();
require('../../../util/header.php');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;

	echo "dentro de pagina ";
	exit;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>


</head>
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%"><tr><td>&nbsp;</td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>                       
                      <td width="100%" align="center" valign="top">
					  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" width="100%" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo nuevo -->
								  <br><br>
								  <?	$sql="select id_usuario, ruta, perfil, ip from usuarios_online";
								  		$res=pg_Exec($sql);
										for($i=0;$i<pg_numrows($res);$i++){
										$fila=pg_fetch_array($res,$i);
								  ?>	<center>
										<table border="1" width="100%">
								<?			$sql_p1 = "select nombre_perfil from perfil where '$fila[perfil]' = id_perfil";
											$res_p1 = pg_Exec($sql_p1);
											$fila_usuario = pg_fetch_array($res_p1);
											$perfil = $fila_usuario['nombre_perfil'];
											
											if($fila['perfil']=="99999"){
												$perfil = "SELECCIONANDO PERFIL";
											}
											
											$sql_accede = "select i.nombre_instit, u.nombre_usuario from accede a, institucion i, usuario u where a.id_usuario = '$fila[id_usuario]' and a.rdb = i.rdb and u.id_usuario = a.id_usuario limit 1";
											$res_accede = pg_Exec($sql_accede);	
											$fila_instit = pg_fetch_array($res_accede);											
																				
										/*	$qry="select u.nombre_usuario, p.nombre_perfil, i.nombre_instit
											from usuario u, perfil p, accede a, institucion i
											where u.id_usuario='$fila[id_usuario]' and p.id_perfil = '$fila[perfil]' and a.id_usuario = '$fila[id_usuario]' and a.rdb = i.rdb";
											$result = pg_Exec($qry);
											$fila_usuario = pg_fetch_array($result);																						
										*/
										?>
											<tr class="textosesion">
												<!--td width="%%"><?=$fila_instit['nombre_usuario']?></td-->
												<td width="100"><?=$fila['ip']?></td>												
												<td width="180"><?=$perfil?></td>
												<td width="180"><?=$fila_instit['nombre_instit'];?></td>
												<td width="%%"><?=$fila['ruta']?></td>
											</tr>
										</table>
										</center>
									<? } ?>
								  <!-- fin codigo nuevo --> </td>
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
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
