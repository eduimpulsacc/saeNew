<?php 	
		session_start(); 
		require('../util/header.inc');
		require_once("widgets/widgets_start.php"); 
		$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 4;
	$_bot = 8;
	$cmb_ins=$_POST["cmb_ins"];
	/*if($cmb_ins==NULL){
		$cmb_ins=0;
	}*/
	
	$cmb_perfil=$_cmb_perfil;
	$cmb_ins =$_cmb_ins;
	
	$modo=$_GET["modo"];
	$corp=$_POST["corp"];
	$fecha = time();
	$dd = date(d);
	$mm = date(m);
	$aa = date(Y);
	$fechahoy = "$dd-$mm-$aa";
	$fechahoy.="_";
	$hora= date ( "h:i:s" , $fecha );
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$fechahoy."Estadisticas.xls"); 
	$hh = substr($hora,0,2);
	$mm = substr($hora,3,2);
	$ss = substr($hora,6,2);
	if($_CMBPERFIL==NULL){
		$_CMBPERFIL=0;
	}
	$chkfecha=$_chkfecha;
	//echo $chkfecha;
	?>

<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK rel="stylesheet" href="css/moodalbox.css" type="text/css" media="screen">
<script language="JavaScript" src="widgets/calendar.js"></script>
<script language="JavaScript" src="widgets/calendar-setup.js"></script>
<script language="JavaScript" src="widgets/lang/calendar-es.js"></script>
<SCRIPT type="text/javascript" src="js/mootools.js"></SCRIPT>
<SCRIPT type="text/javascript" src="js/moodalbox.js"></SCRIPT>
<script>
function enviaform(f){
   f.action='estadisticas_new.php';
   f.submit();
}
function enviapag2(f){
				
				//f.action = 'mostrarexcel.php?cmb_ins='+<?echo $cmb_ins?>'&chkfecha='<? echo $chkfecha ?>;
				f.action = 'mostrarexcel.php?chkfecha='+<? echo $chkfecha ?>;
				//f.target="_blank";
				f.submit();
				}
function enviapag(f){
				f.action="estadisticas_new.php?modo=mostrar"
				f.submit();
	} 
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" cellpadding="0" cellspacing="0">
                        <form method="post" name="f">
                          <tr>
                            <td height="198" align="left" valign="top" colspan="2"><!-- ADMINISTRADORES MAS CONECTADOS-->
                              <?
	echo $cmb_ins;
	switch ($chkfecha) {
	
	case 0:	
				if($cmb_ins>0){
				
				//INSTITUCION COMBO
					$archivo="Pie4.php";
					if($_PERFIL==0){
						$archivo="Pie8.php";
						$_cmb_ins=$cmb_ins;
						session_register('_cmb_ins');
					}
					$archivo2="Pie6.php";
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica  WHERE rdb=".$_SESSION['cmb_ins']." GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
					}else{
					if ($corp>0){
					    $sql_corp = " where estadistica.rdb in (select rdb from corp_instit where num_corp = '$corp') ";
				    }else{
						$sql_corp = " ";
				    }				
					
				    //$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica $sql_corp GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil   ORDER BY sum DESC";
				if($cmb_perfil==0){
						//LISTO
						//IF PERFILES
						 if(($_PERFIL==0)||($_PERFIL==26)){
						 //------------------------------------------------ LISTO-----------------------------------------------/
								    $archivo="Pie3.php";
									$archivo="Pie4.php";
									$archivo2="Pie5.php";
									if($_PERFIL==0){
										$archivo="Pie7.php";
									}
									if ($corp>0){
										$sql_corp = " where estadistica.rdb in (select rdb from corp_instit where num_corp = '".$corp["num_corp"]."') ";
										$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica $sql_corp GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil   ORDER BY sum DESC";
									}else{
										$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil   ORDER BY sum DESC";
									}
						}else{
								$archivo="Pie.php";
								$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$institucion." GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
								
						}
						//FIN IF PERFILES
				}else{
						//LISTO
						$_CMBPERFIL=$cmb_perfil;
						session_register('_CMBPERFIL');
						$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$institucion." and perfil=".$cmb_perfil." GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
				}
			}
				break;
    case 1:
		if($cmb_ins>0){
					//INSTITUCIONES COMBO
					
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$cmb_ins."  AND fecha BETWEEN '".$txtFechadesde."' AND '".$txtFechahasta."' GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil  ORDER BY sum DESC";
					}else{
					
					
										
					// TODAS LAS INSTITUCIONES 
					if ($corp>0){
					    $sql_corp = " AND estadistica.rdb in (select rdb from corp_instit where num_corp = '$corp') ";
				    }else{
				        $sql_corp = " ";
				    }
					
					
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE fecha BETWEEN '".$txtFechadesde."' AND '".$txtFechahasta."' $sql_corp GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil  ORDER BY sum DESC";
					}
				if($cmb_perfil==0){
					//$archivo="Pie.php";
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$institucion." AND fecha BETWEEN '".$txtFechadesde."' AND '".$txtFechahasta."' GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
						
				}else{
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$institucion." AND fecha BETWEEN '".$txtFechadesde."' AND '".$txtFechahasta."' and perfil=".$cmb_perfil." GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
				}
	break;
	}
	$_SESSION['corp'] =$corp;
	$res_adms = @pg_exec($conn,$sql_adms);
?>                                
                              <table>
                                  <tr>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td bgcolor="#666666"><b><font color="#FFFFFF">Administradores Mas Conectados</font></b></td>
                                  </tr>
                                  <br>
                                  <tr>
                                    <td><table width="350" border="1" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td align="center" width="30%" bgcolor="#666666"><font color="#FFFFFF">Nombre</font></td>
                                          <td align="center" width="50%" bgcolor="#666666"><font color="#FFFFFF">Institución</font></td>
                                          <td align="center" width="20%" bgcolor="#666666"><font color="#FFFFFF">Conexiones</font></td>
                                        </tr>

                                        <? while ($arr_adms = @pg_fetch_array($res_adms)) {
	?>
                                        <tr>
                                          <?	$sql_nombre = "SELECT nombre_perfil FROM perfil WHERE id_perfil = ".$arr_adms['perfil'];
			$res_nombre = @pg_exec($conn,$sql_nombre);
			$arr_nombre = @pg_fetch_array($res_nombre);
		?>
                                          <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000">
                                            <?=$arr_nombre['nombre_perfil']?>
                                          </font> </td>
                                          <? 	
										  
										  
										  $sql_institucion = "SELECT nombre_instit FROM institucion WHERE rdb = ".$arr_adms['rdb'];
			$res_institucion = @pg_exec($conn,$sql_institucion);
			$arr_institucion = @pg_fetch_array($res_institucion);
		?>
                                          <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000">
                                            <?=$arr_institucion['nombre_instit']?>
                                          </font> </td>
                                          <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000">
                                            <?=$arr_adms['sum']?>
                                          </font></td>
                                        </tr>
                                        <? }?>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;
									</td>
                                  </tr>
                            </table></td>
                          </tr>
                          <tr align="center" valign="middle">
                            <td width="281" height="45" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2008</td>
                          </tr>
                        </form>
				      </table>
				
</body>
</html>
<? //};
pg_close($conn);?>