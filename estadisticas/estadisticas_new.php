<?php 	
		session_start(); 
		require('../util/header.inc');
		require_once("widgets/widgets_start.php"); 
		include_once "ofc/php-ofc-library/open_flash_chart_object.php";
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_CORP=$corp["num_corp"];;
	session_register('_CORP');
	$_POSP = 4;
	$_bot = 8;
	$_SESSION['cmb_ins']=$_POST["cmb_ins"];
	$cmb_perfil=$_POST["cmb_perfil"];
	$_cmb_ins=$_POST["cmb_ins"];
	session_register('_cmb_ins');
	
	$_chkfecha=$_POST["chkfecha"];
	session_register('_chkfecha');
	
	$modo=$_GET["modo"];
	$corp=$_POST["corp"];
	$txtFechahasta=$_POST["txtFechahasta"];
	$txtFechadesde=$_POST["txtFechadesde"];
	if($_chkfecha==NULL){
		$_chkfecha=0;
	}
	?>

<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<META http-equiv="Content-Type" content="text/html; charset=Latin-9">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
				f.action = 'mostrarexcel.php';
				//f.target="_blank";
				f.submit();
				}
function enviapag(f){
				f.action="estadisticas_new.php?modo=mostrar"
				f.submit();
	} 
</script>
<link rel="stylesheet" type="text/css" media="all" href="widgets/calendar-brown.css" title="green"/>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="50" height="722" align="left" valign="top" background="../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td  align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
				
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td width="585" height="75" valign="middle"> 
				<?
				include("../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="8%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="92%" align="left" valign="top">
					  <!-- empieza tabla -->					  <table border="0" cellpadding="0" cellspacing="0">
                        <form method="post" name="f">
                          <tr>
                            <td align="left" valign="top" class="tableindex" colspan="4">Estadísticas de Conexión </td>
                          </tr>
						  <tr>
                            <? if(($_PERFIL==0)){?>
							<td align="left" valign="top"  colspan="4"><font size="2">Corporaciones </font>
                              <label>
							  <?
							  
							  $qry_corp ="SELECT * FROM corporacion order by num_corp";
				              $result_corp =@pg_Exec($conn,$qry_corp);
							  
							  ?>
							  <select name="corp" id="corp" onChange="enviaform(this.form)">
							     <option value="0">Corporaciones</option>								 
								 <?
                                 for($i=0;$i < @pg_numrows($result_corp);$i++){
						             $filannn = @pg_fetch_array($result_corp,$i); 
							         $nombre_corp=$filannn['nombre_corp'];
									 $num_corp   =$filannn['num_corp'];
							         ?>
									 <option value="<?=$num_corp?>" <? if ($corp==$num_corp){ ?> selected="selected" <? } ?>><?=$nombre_corp?></option>
									 <?
								 }
								}
								 ?>	 
							  </select>
                            </label>                              &nbsp;<INPUT class="botonXX"  TYPE="button" value="GENERAR EXCEL" name="btn_excel" onClick="enviapag2(this.form)">
							</td>
                          </tr>
						  
                          <tr>
				<? if(($_PERFIL==0)||($_PERFIL==26)){?>
			  <td width="142" align="left" valign="top"><font size="2">&nbsp;Institucion</font>
						  <table>
                                  <tr>
                                    <td width="170"><?php				
				if ($corp>0){
				     $sql_corp = " where rdb in (select rdb from corp_instit where num_corp = '$corp') ";
				}else{
				     $sql_corp = " ";
				}   
				
				
				if ($_PERFIL==26){
					$qry_corp="select num_corp from corp_instit where rdb=".$institucion;
					$result =pg_Exec($conn,$qry_corp);
					$corp = @pg_fetch_array($result,0);
					$qry="SELECT nombre_instit,rdb FROM institucion  where rdb in (select rdb from corp_instit where num_corp = '".$corp["num_corp"]."' order by nombre_instit asc)";
				}else{
					$qry="SELECT nombre_instit,rdb FROM institucion  $sql_corp order by nombre_instit asc";
				}
				$result =pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						
					} 
					?>
                                        <select name="cmb_ins" class="ddlb_x">
                                          <?
								echo "<option value=0 selected>todas</option>";
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $nombre_instit=$filann['nombre_instit'];
		                       $rdb  = $filann['rdb'];
							   //if (($rdb == $cmb_ins)){
							/*echo  "<option selected value=".$rdb.">".$nombre_instit."</option>";
							}else{*/
								echo  "<option value=".$rdb.">".$nombre_instit."</option>";
							//}
						}//cierre for ?>
                                        </select>
                                    </td>
                                  </tr>
                              </table>
							  </td>
			<? 
			}
			}?>
							<td width="139" align="left" valign="top"><font size="2">Perfil</font>
                                <table>
                                  <tr>
                                    <td><input type="hidden" name="frmModo" value="<?=$frmModo ?>">
                                        <font face="arial, geneva, helvetica" size=2> <strong>
                                        <? $sql= "SELECT public.perfil.nombre_perfil,public.perfil.id_perfil FROM public.perfil ORDER BY public.perfil.nombre_perfil asc; ";
										$resultado_query_cue = pg_exec($conn,$sql);
                 ?>
                                        <select name="cmb_perfil" class="ddlb_x">
                                          <option value=0 selected>Todas</option>
                                          <?
											 for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
												{  
												$fila = @pg_fetch_array($resultado_query_cue,$i); 
												$Curso_pal = CursoPalabra($fila['id_perfil'], 1, $conn);
												$nombre_perfil=$fila['nombre_perfil'];
													/*if (($fila['id_perfil'] == $cmb_perfil)){
												   echo "<option selected value=".$fila['id_perfil'].">".$nombre_perfil." </option>";
												}else{*/
													echo "<option value=".$fila['id_perfil'].">".$nombre_perfil." </option>";
											//}
											 } ?>
                                        </select>
                                      </strong> </font></td>
                                  </tr>
                                </table>
                                <!-- termina tabla -->
                            
							</td>
							<!--
                            <td width="77" align="left" valign="top"><font size="2">Desde</font><br>
                                <input type="text" name="txtFechadesde" id="txtFechadesde" size="12" maxlength="10" readonly="true" class="ingreso" value="<?= date('Y-m-d')?>">
                                <input type="button" id="txtFecha_btn" class="botadd" value=" ... ">
                                <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "txtFechadesde",      // id of the input field
                        ifFormat       :    "%Y-%m-%d",  // format of the input field (even if hidden, this format will be honored)
                        button         :    "txtFecha_btn",  // trigger button (well, IMG in our case)
                        align          :    "Bl",           // alignment (defaults to "Bl")
                        singleClick    :    true,
						mondayFirst	   :    true
                    });
                        </script>
                            </td>
                            <td width="8">&nbsp;&nbsp;</td>
                            <td width="72" align="left" valign="top"><font size="2">Hasta</font><br>
                                <input type="text" name="txtFechahasta" id="txtFechahasta" size="12" maxlength="10" readonly="true" class="ingreso" value="<?= date('Y-m-d')?>"+>
                                <input type="button" id="txtFecha_btn2" class="botadd" value=" ... ">
                                <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "txtFechahasta",      // id of the input field
                        ifFormat       :    "%Y-%m-%d",  // format of the input field (even if hidden, this format will be honored)
                        button         :    "txtFecha_btn2",  // trigger button (well, IMG in our case)
                        align          :    "Bl",           // alignment (defaults to "Bl")
                        singleClick    :    true,
						mondayFirst	   :    true
                    });
                        </script>
                            </td>
                            <td width="4">&nbsp;</td>
                            <td width="57" valign="top"><font size="2">Activar fechas<br>
                                  <input name="chkfecha" type="checkbox" value="1">
                            </font></td>-->
                            <td width="61" height="65" align="left" valign="top"><br>
                                <input name="Enviar" type="button" value="Enviar" class="botonXX" onClick="enviapag(this.form)">
                                <!--DESPUES ESTE-->
                            </td>
                          </tr>
                          <tr>
                            <td height="198" align="left" valign="top" colspan="3"><!-- ADMINISTRADORES MAS CONECTADOS-->
							                                        <?
	
	if($modo=="mostrar"){
	switch ($chkfecha) {
	case 0:
				if($cmb_ins>0){
				$_CORP=$corp["num_corp"];
				session_register('_CORP');
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
						//IF PERFILES
						
						 if(($_PERFIL==0)||($_PERFIL==26)){
						    //$archivo="Pie3.php";
									$_CORP=$corp["num_corp"];
									session_register('_CORP');
									$archivo="Pie4.php";
									$archivo2="Pie5.php";
									if($_PERFIL==0){
										if($corp==0){
											$archivo="Pie9.php";
										}else{
											$archivo="Pie7.php";
										}
									}
									if ($corp>0){
										$sql_corp = " where estadistica.rdb in (select rdb from corp_instit where num_corp = '".$corp["num_corp"]."') ";
										$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica $sql_corp and estadistica.fecha  GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
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
					    $sql_corp = " AND estadistica.rdb in (select rdb from corp_instit where num_corp = '$corp')  ";
				    }else{
				        $sql_corp = " ";
				    }
					
					
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE fecha BETWEEN '".$txtFechadesde."' AND '".$txtFechahasta."' $sql_corp GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil  ORDER BY sum DESC";
					}
				if($cmb_perfil==0){
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$institucion." AND fecha BETWEEN '".$txtFechadesde."' AND '".$txtFechahasta."' GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
						
				}else{
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$institucion." AND fecha BETWEEN '".$txtFechadesde."' AND '".$txtFechahasta."' and perfil=".$cmb_perfil." GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
				}
	break;
	}
	$_SESSION['corp'] =$corp;
	echo $archivo2;	
	include_once "ofc/php-ofc-library/open_flash_chart_object.php";
	echo "<table><tr>";
 	echo "<td>";
	open_flash_chart_object( 350, 350, "http://intranet.colegiointeractivo.cl/sae3.0/estadisticas/".$archivo,false, "ofc/" );	
	echo "</td>";
	if(($_PERFIL==0)||($_PERFIL==26)){
	echo "<td>";
	open_flash_chart_object( 350, 350, "http://intranet.colegiointeractivo.cl/sae3.0/estadisticas/".$archivo2,false, "ofc/" );
	echo "</td>";
	}
	echo "</tr></table>";
	$res_adms = @pg_exec($conn,$sql_adms);
	}
?>
                                <table>
                                  <tr>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td><b>Administradores Mas Conectados</b></td>
                                  </tr>
                                  <br>
                                  <tr>
                                    <td><table width="350" border="1" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td align="center" width="30%" class="tablatit2-1">Nombre</td>
                                          <td align="center" width="50%" class="tablatit2-1">Institución</td>
                                          <td align="center" width="20%" class="tablatit2-1">Conexiones</td>
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
                            <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                          </tr>
                        </form>
				      </table></td>
              </tr>
			  
            </table>
          </td>
          <td width="40" align="left" valign="top" background="../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? //};
pg_close($conn);?>