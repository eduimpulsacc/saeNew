<?
	require('../../../../../util/header.inc');
	$institucion = $_INSTIT;
	$fecha=getdate();
	
	$cmbMes=$_POST['cmbMes'];
	$ano=$_POST['ano'];
	$cmb_curso=$_POST['cmb_curso'];
	$nroAno=$_POST['nroAno'];
	
    if ($cmbMes==NULL){
	    $cmbMes= $fecha["mon"];
		
	}	
	$diaActual=$fecha["mday"];	
	
	
	if ($cmbMes!=""){
	//AJUSTA NRO DEL ULTIMO DIA SEGUN EL MES
	if(($cmbMes==2) and ($nroAno%4==0)){
		 $diaFinal=29;
		 $mes="02"; 
	}else{
		 $diaFinal=28;
		 $mes="02";
		 
	}
	if($cmbMes==1){ 
		$diaFinal=31; 
		$mes="01";
	}
	if($cmbMes==2){ 
		$mes="02";
	}
	if($cmbMes==3){ 
		$diaFinal=31; 
		$mes="03";
	}
	if($cmbMes==4){ 
		$diaFinal=30; 
		$mes="04";
	}
	if($cmbMes==5){ 
		$diaFinal=31; 
		$mes="05";
	}
	if($cmbMes==6){ 
		$diaFinal=30; 
		$mes="06";
	}
	if($cmbMes==7){ 
		$diaFinal=31; 
		$mes="07";
	}
	if($cmbMes==8){ 
		$diaFinal=31; 
		$mes="08";
	}
	if($cmbMes==9){ 
		$diaFinal=30; 
		$mes="09";
	}
	if($cmbMes==10){ 
		$diaFinal=31; 
		$mes="10";
	}
	if($cmbMes==11){ 
		$diaFinal=30; 
		$mes="11";
	}
	if($cmbMes==12){ 
		$diaFinal=31; 
		$mes="12";
	}
	//FIN AJUSTA
}	
	
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>

<table width="100%" border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td height="10" bgcolor="#E2E2E2"><em><span class="Estilo1">n.</span></em></td>
								  <td height="25" bgcolor="#E2E2E2"><em><span class="Estilo1">Alumnos / D&iacute;as </span></em></td>
								  <?
								  
								  $cDias=$diaFinal;
                                  for($count=1 ; $count<=$cDias; $count++){ ?>								  
								      <td bgcolor="#E2E2E2" align="center"><em><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">
							          <? if ($count<10){ echo "0".$count; }else{ echo $count; } ?>
								      </font></em></td>
								
								<? } ?>	  
									  <td bgcolor="#E2E2E2" align="center"><em><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">A.M.</font></em></td>
                                </tr>
								
								<?
								// sacamos la lista de alumnos
  		$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista 
		 FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) 
		 WHERE matricula.rdb='$institucion' AND ((matricula.id_curso=".$curso.") AND ((matricula.bool_ar=0)or(matricula.bool_ar isnull))) ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
								$result =@pg_Exec($conn,$qry)or die("Fallo select alumno");
	
								if (!$result){
									//error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
								}else{
								    
									
$X=0;
for($i=0 ; $i < @pg_numrows($result) ; $i++){

$X++;
$Y=0; 

$fila1 = @pg_fetch_array($result,$i);
			
		 if($corporacion!=13){
			$fecha_inicial =$cmbMes."-01-".$nroAno;
			$fecha_final = $cmbMes."-".$diaFinal."-".$nroAno;
	    	
		 }else{
			/*$fecha_inicial =$cmbMes."-01-".$nroAno;
			$fecha_final = $cmbMes."-".$diaFinal."-".$nroAno;*/
			$fecha_inicial ="01-".$cmbMes."-".$nroAno;
	    	$fecha_final = $diaFinal."-".$cmbMes."-".$nroAno;
		 }
		 
		 /*if(pg_dbname()=="coi_final"){
			 $fecha_inicial ="01-".$cmbMes."-".$nroAno;
	    	$fecha_final = $diaFinal."-".$cmbMes."-".$nroAno;
			 }*/
										 
		/*if($_PERFIL==0){
			 echo $corporacion;				 
			 exit;
			}*/
$qry9="select count(rut_alumno) as cantidad from asistencia_mensual 
where id_curso=".$curso." AND fecha between '".$fecha_inicial."' and '".$fecha_final."' 
and rut_alumno=".trim($fila1["rut_alumno"])." ";
										
 $result9 =@pg_Exec($conn,$qry9)or die("fallo x9 ".$qry9);
 $fila9 = @pg_fetch_array($result9,0);
 $cant=$fila9["cantidad"];

										 
										 
 $qry2="select rut_alumno, ano, id_curso,hora, date_part('day',asistencia_mensual.fecha) AS day, date_part('month',asistencia_mensual.fecha), date_part('year',asistencia_mensual.fecha) AS year from asistencia_mensual where  id_curso=".$curso." AND fecha between '".$fecha_inicial."' and '".$fecha_final."' and rut_alumno=".trim($fila1["rut_alumno"])."";

$result2 =@pg_Exec($conn,$qry2);

if (!$result2){
	error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$qry2);
			 }
										 
										 
if ($frmModo=="mostrar"){
								 
			 ?>

<tr onmouseover=this.style.background='yellow' onmouseout=this.style.background='transparent'>
										 
										 	<TD height="24" align="left" valign="top">
											  <em><img src="trans.gif" width="0" height="18">
											  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
									<?			if($fila1["nro_lista"]!=NULL){
													if($fila1["nro_lista"]<10){
														echo  trim($fila1["nro_lista"])." &nbsp;&nbsp;";
													}else{
														echo  trim($fila1["nro_lista"])." &nbsp;";
													}
												}else{
													echo  " &nbsp; &nbsp; &nbsp;";
												}
												?>
											  </STRONG></FONT>
									        </em></TD>
										 
										 
      <td><em><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo  substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_alu"]),0,13);	?></font></em></td>
									     <?
										 $sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('month',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$sqlFer);
						}
							             $m=0;
										 $ñ=0;
										 $cDias=$diaFinal+2;
										 for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								 $hora=$fila2['hora'];
								$hora= substr( $hora, 0, 5 );
									
								$filaFer=@pg_fetch_array($resultFer,$m);
								
								//if ($c<33)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){   ?></tr></table>
<table width="100%" border="1" cellpadding="0" cellspacing="0"><tr onmouseover=this.style.background='yellow' onmouseout=this.style.background='transparent'>
										<TD align=center bgcolor='#FFE6E6' valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										</strong></font></TD>
	<?									$m++;
									}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6' valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
											</strong></font></TD>
	<?									}
										$c=$c-1;
										$m++;
									}else{
										//if ($c==32){
										if ($c==($cDias-1)){	?>
											<!-- <TD align="center" valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<img src="../../../../../cortes/p.gif" width="20" height="9"><br>
<?											echo $cant;	?>
											</strong></font></TD> -->
	<?										$flag=1;
										}else{
											if ($c==$fila2["day"]){
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<img src="../../../../../cortes/p.gif" width="20" height="9"><br>
	<?												echo $hora;	?>
													</strong></font></TD>
	<?											}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $hora;	?>
													</strong></font></TD>
	<?											}else///
												if(($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align=center bgcolor=#FFFFD7 valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												//echo "3*".$c;	?>
	<?												echo $hora;	?>
													</strong></font></TD>
	<?											}else{ ?>
													<TD align=center bgcolor=#E1EFFF valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?	
	
	echo $hora;	?>
													</strong></font></TD>
	<?											}
												$ñ++;
											}
											else{
												
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA valign="top">	<img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>	                                                  <TD align=center bgcolor=#FFFFD7 valign="top">
												       <img src="../../../../../cortes/p.gif" width="20" height="9"><br> 
													</TD>  
<?												}else{	?>
													<TD align=center valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}
											}

										}
									}
								}//fin if $c<32
								 //if (($c==32) and ($flag!=1)){
								 if (($c==($cDias-1)) and ($flag!=1)){	?>
									<TD align=center valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?									echo $cant;	?>
									</strong></font></TD> 
<?								}
							}//fin for($c=1;$c<32;$c++)							     
							
										?>								 
										<TD align=center valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;
		<?								echo $cant;	?>
										</strong></font></TD>			 
																							
									</tr>
									<?
									
								}}}?>
</table> 



</body>
</html>