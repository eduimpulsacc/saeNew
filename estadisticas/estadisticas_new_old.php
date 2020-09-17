<?php 	
		session_start(); 
		require('../util/header.inc');
		require_once("widgets/widgets_start.php"); 
		include_once "ofc/php-ofc-library/open_flash_chart_object.php";
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 4;
	$_bot = 8;
	$cmb_ins=$_POST["cmb_ins"];
	$cmb_perfil=$_POST["cmb_perfil"];
	$modo=$_GET["modo"];
	$txtFechahasta=$_POST["txtFechahasta"];
	$txtFechadesde=$_POST["txtFechadesde"];
	$chkfecha=$_POST["chkfecha"];
	if($chkfecha==NULL){
		$chkfecha=0;
	}
	//echo cmb_ins;
	?>

<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<LINK rel="stylesheet" href="css/moodalbox.css" type="text/css" media="screen">
<script language="JavaScript" src="widgets/calendar.js"></script>
<script language="JavaScript" src="widgets/calendar-setup.js"></script>
<script language="JavaScript" src="widgets/lang/calendar-es.js"></script>
<SCRIPT type="text/javascript" src="js/mootools.js"></SCRIPT>
<SCRIPT type="text/javascript" src="js/moodalbox.js"></SCRIPT>
<script>
function enviaform(f){
   f.action='estadisticas_new';
   f.submit();
}
</script>
<link rel="stylesheet" type="text/css" media="all" href="widgets/calendar-brown.css" title="green"/>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="0%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="4" height="722" align="left" valign="top" background="../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="617" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
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
                        <form action="estadisticas_new_old.php?modo=mostrar" method="post">
                          <tr>
                            <td align="left" valign="top" class="tableindex" colspan="4">Estadísticas de conección&nbsp;</td>
                          </tr>
						  <tr>
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
								 
								 ?>	 
							  </select>
                            </label>                              &nbsp;</td>
                          </tr>
                          <tr>
                            <td width="142" align="left" valign="top"><font size="2">&nbsp;Institucion</font>
                                <table>
                                  <tr>
                                    <td width="170"><?php				
				if ($corp>0){
				     $sql_corp = " where rdb in (select rdb from corp_instit where num_corp = '$corp') ";
				}else{
				     $sql_corp = " ";
				}   
				
				
											
				$qry="SELECT nombre_instit,rdb FROM institucion  $sql_corp order by nombre_instit asc";
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
						} ?>
                                        </select>
                                    </td>
                                  </tr>
                              </table></td>
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
													echo "<option value=0>".$nombre_perfil." </option>";
											//}
											 } ?>
                                        </select>
                                      </strong> </font></td>
                                  </tr>
                                </table>
                                <!-- termina tabla -->
                            </td>
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
                            </font></td>
                            <td width="61" height="65" align="left" valign="top"><br>
                                <input name="Enviar" type="submit" id="Enviar" value="Enviar">
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
				//INSTITUCION COMBO
				    
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica  WHERE rdb=".$cmb_ins." GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
					$_SESSION['cmb_ins'] =$cmb_ins;
					$_SESSION['cmb_perfil'] =$cmb_perfil;
					//institucion
					$_SESSION['qry2'] =5;
					//perfil
					$_SESSION['qry'] =2;
					}else{
					//TODAS LAS INSTITUCIONES
					$_SESSION['archivo']=$archivo;
					
					
					if ($corp>0){
					    $sql_corp = " where estadistica.rdb in (select rdb from corp_instit where num_corp = '$corp') ";
				    }else{
				        $sql_corp = " ";
				    }				
					
				    $sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica $sql_corp GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil   ORDER BY sum DESC";
					//institucion
					$_SESSION['qry2'] =2;
					// perfiles
					$_SESSION['qry'] =2;
				}
				break;
    case 1:
		if($cmb_ins>0){
					//INSTITUCIONES COMBO
					
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$cmb_ins."  AND fecha BETWEEN '".$txtFechadesde."' AND '".$txtFechahasta."' GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil  ORDER BY sum DESC";
					$_SESSION['cmb_ins'] =$cmb_ins;
					$_SESSION['cmb_perfil'] =$cmb_perfil;
					$_SESSION['txtFechadesde'] = $txtFechadesde;
					$_SESSION['txtFechahasta'] = $txtFechahasta;
					$_SESSION['qry'] =3;
					$_SESSION['qry2'] =3;
					}else{
					
					
										
					// TODAS LAS INSTITUCIONES 
					if ($corp>0){
					    $sql_corp = " AND estadistica.rdb in (select rdb from corp_instit where num_corp = '$corp') ";
				    }else{
				        $sql_corp = " ";
				    }
					
					
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE fecha BETWEEN '".$txtFechadesde."' AND '".$txtFechahasta."' $sql_corp GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil  ORDER BY sum DESC";
					$_SESSION['cmb_ins'] =$cmb_ins;
					$_SESSION['cmb_perfil'] =$cmb_perfil;
					//institucion
					$_SESSION['qry2'] =4;
					$_SESSION['txtFechadesde'] = $txtFechadesde;
					$_SESSION['txtFechahasta'] = $txtFechahasta;
				}
				/*if($cmb_perfil==0){
					$_SESSION['qry2'] =3;
					$_SESSION['txtFechadesde'] = $txtFechadesde;
					$_SESSION['txtFechahasta'] = $txtFechahasta;
					$archivo="Pie.php";
					$sql_adms="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$cmb_ins." AND fecha BETWEEN '".$txtFechadesde."' AND '".$txtFechahasta."' GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
				}*/
	break;
	}
	echo $sql_adms;
	echo "<A href='prueba.php?ar=Pie2_old.php' rel='moodalbox 700 500' title='Grafico'>Click para ver Grafico</A>";
	if($qry2!=2 && $qry2!=4){
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<A href='prueba.php?ar=Pie_old.php' rel='moodalbox 700 500' title='Grafico'>Click para ver Grafico</A>";
	}
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
          <td width="51" align="left" valign="top" background="../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? };
pg_close($conn);?>