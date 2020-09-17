<? require('../../../../util/header.inc');
setlocale(LC_ALL,"es_ES");
session_start(); 
	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$mes 			= $cmb_meses;	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
function NuevoAjax(){
var xmlhttp=false;
try{
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
}catch(e){
	try{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 	}catch(E){
		xmlhttp = false;
	}
}

if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
	xmlhttp = new XMLHttpRequest();
}
return xmlhttp;
}
function Cargar(){
var contenido, preloader;
contenido = document.getElementById('contenido');
preloader = document.getElementById('preloader');
ajax=NuevoAjax();
ajax.open("POST", "Subvencion_detalle.php",true);
ajax.onreadystatechange=function(){
	if(ajax.readyState==1){
		preloader.innerHTML = "Cargando...";
		//preloader.style.background = "url('loading.gif') no-repeat";
	}else if(ajax.readyState==4){
		if(ajax.status==200){
			contenido.innerHTML = ajax.responseText;
			preloader.innerHTML = "Cargado.";
			//preloader.style.background = "url('loaded.gif') no-repeat";
		}else if(ajax.status==404){
			preloader.innerHTML = "La página no existe";
		}else{
			preloader.innerHTML = "Error:".ajax.status;
		}
	}
}
ajax.send(null);
}

	function atras() {
  		history.back();
}

</script>
<script language="JavaScript" type="text/JavaScript">
<!--




function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<?php 
	if (($mes != 0) or ($mes != NULL)){ 
		if ($mes < 10){
		   $mes = "0".$mes;
		}
	
	$_POSP = 4;
	$_bot = 8;

	if (empty($mes)){
	 //exit;
	}else{ 
		if ($mes == 1) $mes_pal = "Enero";
	    if ($mes == 2) $mes_pal = "Febrero";
	    if ($mes == 3) $mes_pal = "Marzo";
	    if ($mes == 4) $mes_pal = "Abril";
	    if ($mes == 5) $mes_pal = "Mayo";
	    if ($mes == 6) $mes_pal = "Junio";
	    if ($mes == 7) $mes_pal = "Julio";
	    if ($mes == 8) $mes_pal = "Agosto";
	    if ($mes == 9) $mes_pal = "Septiembre";
	    if ($mes == 10) $mes_pal = "Octubre";
	    if ($mes == 11) $mes_pal = "Noviembre";
	    if ($mes == 12) $mes_pal = "Diciembre";
	    $dia_1 = "01"; 	$dia_2 = "02"; 	$dia_3 = "03";  $dia_4 = "04";	
	    $dia_5 = "05";	$dia_6 = "06";	$dia_7 = "07";	$dia_8 = "08";	
	    $dia_9 = "09";	$dia_10 = "10";	$dia_11 = "11";	$dia_12 = "12";	
	    $dia_13 = "13";	$dia_14 = "14";	$dia_15 = "15";	$dia_16 = "16";	
	    $dia_17 = "17";	$dia_18 = "18";	$dia_19 = "19";	$dia_20 = "20";	
	    $dia_21 = "21";	$dia_22 = "22";	$dia_23 = "23";	$dia_24 = "24";	
	    $dia_25 = "25";	$dia_26 = "26";	$dia_27 = "27";	$dia_28 = "28";	
	    $dia_29 = "29";	$dia_30 = "30";	$dia_31 = "31";	
	
	    //-------------- INSTITUCION -------------------------------------------------------------
	    $sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
		$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
		$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
		$result_ins =@pg_Exec($conn,$sql_ins);
		$fila_ins = @pg_fetch_array($result_ins,0);	
		$ins_pal = $fila_ins['nombre_instit'];
		$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
		$telefono = $fila_ins['telefono'];

		$sql01 = "select nro_ano from ano_escolar where id_ano = " . $ano;
		$result01 =pg_Exec($conn,$sql01);
		if (!$result01) 
		{
		     error('<B> ERROR :</b>Error al acceder a la BD. (ANO ESCOLAR)</B>');
	    }
		else
		{
			if (pg_numrows($result01)!=0)
			{//En caso de estar el arreglo vacio.
				$fila01 = @pg_fetch_array($result01,0);	
				if (!$fila01)
					{
					error('<B> ERROR :</b>Error al acceder a la BD. (ANO ESCOLAR)</B>');
					exit();
				}
			}
		}
		$nro_ano = $fila01['nro_ano'];
	}
?><table border="1">
	 <tr bgcolor="#999999">
	 	<td><font color="#FFFFFF">Cursos</font></td>	
              <? if (($mes==2) and ($ano%4==0)){
						 $diaFinal=29;
					}else{
						 $diaFinal=28;
					}
					if ($mes==1) $diaFinal=31;
					if ($mes==3) $diaFinal=31;
					if ($mes==4) $diaFinal=30;
					if ($mes==5) $diaFinal=31;
					if ($mes==6) $diaFinal=30;
					if ($mes==7) $diaFinal=31;
					if ($mes==8) $diaFinal=31;
					if ($mes==9) $diaFinal=30;
					if ($mes==10) $diaFinal=31;
					if ($mes==11) $diaFinal=30;
					if ($mes==12) $diaFinal=31;
					
					  for($count=1 ; $count<=$diaFinal ; $count++){
								if($diaFinal==29 || $diaFinal==28){
									if ($count<10){ 
									
					}
					}
					}				for($count=1 ; $count<=$diaFinal ; $count++){
								if($diaFinal==29 || $diaFinal==28){
									if ($count<10){ ?>
          <td width="21"><font color="#FFFFFF">0<? echo $count;?></font></td>
          <? }else{  ?>
          <td width="21"><font color="#FFFFFF"><? echo $count; ?></font></td>
          <?	}
								}
								else{
									if ($count<10){ ?>
          <td width="21"><font color="#FFFFFF">0<? echo $count; ?></font></td>
          <? }else{ ?>
          <td width="21"><font color="#FFFFFF"><? echo $count; ?></font></td>
          <? }
								}
							} // fin for $count?>
		<td><font color="#FFFFFF">Total curso</font></td>
		<td><font color="#FFFFFF">Dias Habiles</font></td>
		<td><font color="#FFFFFF">Total Asistencia</font></td>
		<td><font color="#FFFFFF">Promedio Asistencia</font></td>
		<td><font color="#FFFFFF">% Asistencia</font></td>
        </tr>
      <? 				
	//$qry_fer="select * from feriados_nac where descripcion not in (select descripcion from feriado where id_ano=".$ano.") order by id_feriado"; 
	$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('month',feriado.fecha_inicio)=".$mes." and id_ano=".$ano." order by dia_ini";
	$resultFer =@pg_Exec($conn,$qry_fer);
	/*****************************AÑO******************************/
						$qry_ano="select nro_ano from ano_escolar where id_ano=".$ano;
	  					$result_ano=@pg_Exec($conn,$qry_ano);
						$ano_r=pg_result($result_ano,0);
						
	/*****************************CURSO****************************/					
						$qry="SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, cod_tipo FROM tipo_ensenanza INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano.")) order by curso.grado_curso, curso.letra_curso asc"; 
						$result =@pg_Exec($conn,$qry);
						for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						?>
      <tr valign=top bgcolor=#ffffff onmouseover=this.style.background='#E4E1E1';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
        <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">
          <?= $fila["grado_curso"]." ".$fila["letra_curso"]." ".$fila["nombre_tipo"] ?>
        </font></td>
        <? 
				$k=0;
				$m=0;
				$Resultado2=0;
				$Resultado=0;
				for($count=1 ; $count<=$diaFinal ; $count++){
							if ($count<10){
								$count="0".$count;
							}
				
									if($diaFinal==29 || $diaFinal==28){ 
								$qry_total_curso="select count(id_curso)as total_curso,id_ano,id_curso,rdb from matricula where id_curso=".$fila["id_curso"]." group by id_ano,id_curso,rdb";
								$result2 =@pg_Exec($conn,$qry_total_curso);
								$qry_inasis="select count(id_curso) as alumn_inasis,fecha,id_curso from asistencia where id_curso=".$fila["id_curso"]." and ano=".$ano." and fecha='".$mes."-".$count."-".$ano_r."' group by id_curso,fecha order by id_curso desc";
								$result3 =@pg_Exec($conn,$qry_inasis);
							for($z=0 ; $z < @pg_numrows($result3) ; $z++){
									$fila2 = @pg_fetch_array($result3,$z);
									}
								?>
		
        <td width="19">&nbsp;<? echo $fila2["alumn_inasis"];?></td>
						<? }else{  
							$qry_inasis="select count(id_curso) as alumn_inasis,fecha,id_curso from asistencia where id_curso=".$fila["id_curso"]." and ano=".$ano." and fecha='".$mes."-".$count."-".$ano_r."' group by id_curso,fecha order by id_curso desc";
							$result3 =@pg_Exec($conn,$qry_inasis);
							// echo $qry_inasis;
							$qry_total_curso="select count(id_curso)as total_curso,id_ano,id_curso,rdb from matricula where id_curso=".$fila["id_curso"]." group by id_ano,id_curso,rdb";
							$result2 =@pg_Exec($conn,$qry_total_curso);
							$curso=@pg_result($result2,0);
							for($z=0 ; $z < @pg_numrows($result3) ; $z++){
									$fila2 = @pg_fetch_array($result3,$z);
							}
							if ($fila2["alumn_inasis"]==null){
								$fila2["alumn_inasis"]=0;
							}
							if ($curso==null){
								$curso=0;
							}
						$filaFer=@pg_fetch_array($resultFer,$m);
						$dia = (date("w", mktime(0,0,0,$mes,$count,$ano_r)));
						?>
						<? if($dia==6){///SABADO	?>
													<TD align=center bgcolor="#999999" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<? }elseif($dia==0){///DOMINGO	?>
							<TD align=center bgcolor="#999999" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
							
						<? }elseif($dia==$filaFer["dia_ini"]){//FERIADO	?>
							<TD align=center bgcolor="#999999" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<? }else{
							$k++;
						?>
								<td width="19"><? if($fila2["alumn_inasis"]!= $curso){
										$curso=$curso-$fila2["alumn_inasis"];
										echo $curso;
									}else{
										echo $curso;
										}
									if($dia==$count){
										$total_final=$total_final+$curso;
									}
									if($fila2["alumn_inasis"]==0){
										$Resultado2= $Resultado2+ $curso;
									}else{
										$Resultado= $Resultado+ $curso;
									}
									$total=$Resultado+$Resultado2;
									//$total_$count;
									?>&nbsp;</td>							
        <? 						}
								$fila2["alumn_inasis"]=0;
								$total_porc=$curso*$k;
								$total_dia[$count]=$total_dia[$count]+$curso;
								  }
								 //$total_dia[$count]=0;
								}//TOTAL CURSO
						echo "<td><b>".$curso."</b></td>";
						echo "<td><b><FONT color='#FF0000'>".$k."</FONT></b></td>";
						echo "<td><b><FONT color='#00CC33'>".$total." </FONT></b></td>";
						echo "<td><b><FONT color='#3366FF'>".substr($total/$k,0,4)." </FONT></b></td>";
						echo "<td><b><FONT color='#6633CC'>".substr($total/$total_porc*100,0,4)."% </FONT></b></td>";
						echo "</tr>";
						$total_curso=$total_curso+$curso;
						$total_asis=$total_asis+$total;
						
						}
						for($p=0 ; $p < @pg_numrows($result) ; $p++){
									
									$total_dias=$total_dias+$k;
								}
						echo "<tr>";
						echo "<td>Totales</td>";
						for($count2=1; $count2<=$diaFinal ; $count2++){
							if ($count2<10){
								$count2="0".$count2;
							}
							$dia = (date("w", mktime(0,0,0,$mes,$count2,$ano_r)));
							?>
							<? if($dia==6){///SABADO	?>
													<TD align=center bgcolor="#999999" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<? }elseif($dia==0){///DOMINGO	?>
							<TD align=center bgcolor="#999999" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
							
						<? }elseif($dia==$filaFer["dia_ini"]){//FERIADO	?>
							<TD align=center bgcolor="#999999" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<? }else{
							echo "<td>&nbsp;".$total_dia[$count2]."</td>";
						}
						}
						echo "<td>&nbsp;".$total_curso."</td>";
						echo "<td>&nbsp;".$total_dias."</td>";
						echo "<td>&nbsp;".$total_asis."</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "</tr>";
					?>
<button onclick="atras()" class="botonXX" >Atrás</button>  
    </table></td>
  </tr>
  <tr>
 <? }else{ ?> 
    <tr>
    <td><tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><form action="Subvencion_detalle.php" method="post">
                              <table border="1" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><table border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td width="758" class="tableindex"><div align="center">Buscador Avanzado</div></td>
                                      </tr>
                                      <tr>
                                        <td height="27"><table border="0" cellspacing="0" cellpadding="3">
                                            <tr>
                                              <td width="105"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><strong>Seleccione Mes</strong></font></td>
                                              <td width="420"><select name="cmb_meses" class="ddlb_9_x">
                                                  <?
		  if ($cmb_meses == 1){
		     ?>
                                                  <option value="1" selected>Enero</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="1">Enero</option>
                                                  <?
	      }
		  if ($cmb_meses == 2){
		     ?>
                                                  <option value="2" selected>Febrero</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="2">Febrero</option>
                                                  <?
	      }
		  if ($cmb_meses == 3){
		     ?>
                                                  <option value="3" selected>Marzo</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="3">Marzo</option>
                                                  <?
	      }
		  if ($cmb_meses == 4){
		     ?>
                                                  <option value="4" selected>Abril</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="4">Abril</option>
                                                  <?
	      }
		  if ($cmb_meses == 5){
		     ?>
                                                  <option value="5" selected>Mayo</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="5">Mayo</option>
                                                  <?
	      }
		  if ($cmb_meses == 6){
		     ?>
                                                  <option value="6" selected>Junio</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="6">Junio</option>
                                                  <?
	      }
		  if ($cmb_meses == 7){
		     ?>
                                                  <option value="7" selected>Julio</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="7">Julio</option>
                                                  <?
	      }
		  if ($cmb_meses == 8){
		     ?>
                                                  <option value="8" selected>Agosto</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="8">Agosto</option>
                                                  <?
	      }
		  if ($cmb_meses == 9){
		     ?>
                                                  <option value="9" selected>Septiembre</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="9">Septiembre</option>
                                                  <?
	      }
		  if ($cmb_meses == 10){
		     ?>
                                                  <option value="10" selected>Octubre</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="10">Octubre</option>
                                                  <?
	      }
		  if ($cmb_meses == 11){
		     ?>
                                                  <option value="11" selected>Noviembre</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="11">Noviembre</option>
                                                  <?
	      }
		  if ($cmb_meses == 12){
		     ?>
                                                  <option value="12" selected>Diciembre</option>
                                                  <?
		  }else{
		  	 ?>
                                                  <option value="12">Diciembre</option>
                                                  <?
	      }
		  
		  ?>
                                              </select></td>
                                              <td width="33">&nbsp;</td>
                                              <td width="33">&nbsp;</td>
                                              <td width="37">&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td>&nbsp;</td>
                                              <td><input name="cb_ok" type="submit" class="botonXX"  value="Consultar">
                                                  <br>
                                                  <br>
                                                  <span class="Estilo1">* Para Proyectar Correctamente la Subvenci&oacute;n debe tener ingresada la asistencia en el sistema, en su totalidad. </span></td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                  </table></td>
                                </tr>
                              </table>
                            </form>
                              </td>
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? }?>