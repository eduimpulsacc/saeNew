<?php 	require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$ano			=$_ANO;

//	$nroAno=2004;

	$fecha=getdate();
	$diaActual=$fecha["mday"];

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>


<form name="form1" method="post" action="procesoAsistencia.php3">
<input type="hidden" name="cmbMes" value="<? echo $cmbMes; ?>" >
        <table width="808" border="0" cellpadding="1" cellspacing="1">
		             <?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila1 = @pg_fetch_array($result,0);	
						if (!$fila1){
							error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
							exit();
						}
						$nroAno=trim($fila1['nro_ano']);
					}
				}
		
				if ($cmbMes!=""){
					//AJUSTA NRO DEL ULTIMO DIA SEGUN EL MES
					if (($cmbMes==2) and ($nroAno%4==0)){
						 $diaFinal=29;
					}else{
						 $diaFinal=28;
					}
					if ($cmbMes==1) $diaFinal=31;
					if ($cmbMes==3) $diaFinal=31;
					if ($cmbMes==4) $diaFinal=30;
					if ($cmbMes==5) $diaFinal=31;
					if ($cmbMes==6) $diaFinal=30;
					if ($cmbMes==7) $diaFinal=31;
					if ($cmbMes==8) $diaFinal=31;
					if ($cmbMes==9) $diaFinal=30;
					if ($cmbMes==10) $diaFinal=31;
					if ($cmbMes==11) $diaFinal=30;
					if ($cmbMes==12) $diaFinal=31;
					//FIN AJUSTA
				}
		
				//ALUMNOS DEL CURSO
				//$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) ORDER BY ape_pat,ape_mat,nombre_alu asc";
				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) AND matricula.nro_lista is not NULL ORDER BY matricula.nro_lista asc";
				$result =@pg_Exec($conn,$qry);

				if(!$result)
					$mmmmm=1;
//					error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
				else{
//					if($result)
					if(pg_numrows($result)!=0){ ?>
							<TR bgcolor=#FFFFFF>
<?												//62   size=51   ?>
							<TD align=center size=10><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG>ALUMNO</STRONG></FONT>
							</TD>
<?							for($count=1 ; $count<=$diaFinal ; $count++){
								if($diaFinal==29 || $diaFinal==28){
									if ($count<10){ ?>
										<TD align=center size=10><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG>0<? echo $count; ?></STRONG></FONT></TD>
<?									}else{  ?>
										<TD align=center size=10><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG><? echo $count; ?></STRONG></FONT></TD>
<?									}
								}
								else{
									if ($count<10){ ?>
										<TD align=center size=12><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG>0<? echo $count; ?></STRONG></FONT></TD>
<?									}else{ ?>
										<TD align=center size=12><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG><? echo $count; ?></STRONG></FONT></TD>
<?									}
								}
							} // fin for $count
							if ($frmModo=="ingresar" || $frmModo=="modificar"){
							if($diaFinal==30){ ?>
<? //bueno ?>
								<TD align=center size=12>&nbsp;</TD>
<?							}
							if($diaFinal==29){ ?>
<? //bueno ?>
								<TD align=center size=12>&nbsp;&nbsp;&nbsp;</TD>
<?							}  ?>												
							<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</STRONG></FONT></TD>
<?					}	// fin if
					if ($frmModo=="mostrar"){ ?>
						<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG>I.M.</STRONG></FONT></TD>
<?					} ?>
					</TD>
					</TR>


<?					$X=0;
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$X++;
						$Y=0;
						$fila1 = @pg_fetch_array($result,$i);
						if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
							if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
								?>
								<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
								<?php
							}else{  ?>
								<TR bgcolor=#ffffff>
<?							}
						}else{  ?>
							<TR bgcolor=#ffffff>
<?						}  ?>
<?												//width=15   ?>
						<TD align=left width=10><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?						echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);	?>
						</STRONG></FONT></TD>
<?
						$qry9="select count (rut_alumno) as cantidad from asistencia where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_alumno=".trim($fila1["rut_alumno"]);
						$result9 =@pg_Exec($conn,$qry9);
						$fila9 = @pg_fetch_array($result9,0);
						$cant=$fila9["cantidad"];
						if (!$result9) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry9);
						}
							
						/******** QRY PARA TRAER DIAS FERIADOS Y COLOREAR LA COLUMNA QUE CORRESPONDE********/
						
						$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
						}
							
						/******** QRY PARA TRAER DIAS INASISTENCIA********/	
						$qry2="select rut_alumno, ano, id_curso, date_part('day',asistencia.fecha) AS day, date_part('month',asistencia.fecha), date_part('year',asistencia.fecha) AS year from asistencia where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_alumno=".trim($fila1["rut_alumno"]);
						$result2 =@pg_Exec($conn,$qry2);
						if (!$result2)
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry2);
													
						if ($frmModo=="mostrar"){
						
							$m=0;
							$ñ=0;
							$cDias=$diaFinal+2;
							//for($c=1;$c<=33;$c++){
							for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								$filaFer=@pg_fetch_array($resultFer,$m);
								//if ($c<33)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){   ?>
										<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
										</strong></font></TD>
	<?									$m++;
									}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
											</strong></font></TD>
	<?									}
										$c=$c-1;
										$m++;
									}else{
									
										//if ($c==32){
										if ($c==($cDias-1)){
																	
											if($diaFinal==29){ ?>
<? //bueno ?>
												<TD align="left" size=15>&nbsp;&nbsp;&nbsp;</TD>
<?											}	?>
																							
											<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?											echo $cant;	?>
											</strong></font></TD>
	<?										$flag=1;
										}else{
											if ($c==$fila2["day"]){
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if(($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else{ ?>
													<TD align=center bgcolor=#E1EFFF><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}
												$ñ++;
											}else{
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else{	?>
													<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}
											}
										}
									}
																	
								}//fin if $c<32
								 //if (($c==32) and ($flag!=1)){
								 if (($c==($cDias-1)) and ($flag!=1)){	?>
									<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?									echo $cant;	?>
									</strong></font></TD>
<?								}
										
							}//fin for($c=1;$c<32;$c++)
															
						}else{
							if($frmModo=="ingresar"){
							$m=0;
							$ñ=0;
							$cDias=$diaFinal+1;
							
							//for($c=1;$c<=32;$c++){
							for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								$filaFer=@pg_fetch_array($resultFer,$m);
								//if ($c<32)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){	?>
										<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
										<INPUT TYPE=checkbox NAME="a[<? echo $X;?>][<? echo $c; ?>]" disabled>		
										</strong></font></TD>
<?										$m++;
									}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
											<INPUT TYPE=checkbox NAME="a[<? echo $X;?>][<? echo $c;?>]" disabled>
											</strong></font></TD>
<?										}
										$c=$c-1;
										$m++;
									}else{
										if ($c==$fila2["day"]){
											$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
											if($dia==6){///SABADO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" checked>
												</strong></font></TD>
<?											}else///
											if($dia==0){///DOMINGO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" disabled>
												</strong></font></TD>
<?											}else///
											if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
												<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" checked>
												</strong></font></TD>
<?											}else{	?>
												<TD align=center bgcolor='#E1EFFF'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" checked>
												</strong></font></TD>
<?											}
											$ñ++;
										}else{
										$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
										if($dia==6){///SABADO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]">
												</strong></font></TD>
<?										}else///
										if($dia==0){///DOMINGO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" disabled>
												</strong></font></TD>
<?										}else///
										if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
												<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]">
												</strong></font></TD>
<?										}else{	?>
												<TD align=center ><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]">
												</strong></font></TD>
<?										}
									}
																		
								}
																	
							}//fin if $c<32
																
						}//fin for($c=1;$c<32;$c++)

					}//fin if $frmModo
														
				}// fin else 
			}
		}
	}	

//*****************************************

				$consulta="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) AND matricula.nro_lista is NULL ORDER BY ape_pat,ape_mat,nombre_alu asc";
				$resultado =@pg_Exec($conn,$consulta);


				if(!$resultado)
					$mmmmm=1;
//					error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
				else{
//					if($result)
					if(pg_numrows($resultado)!=0){ ?>
							<TR bgcolor=#FFFFFF>
<?												//62   size=51   ?>
							<TD align=center size=10><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG>ALUMNO</STRONG></FONT>
							</TD>
<?							for($count=1 ; $count<=$diaFinal ; $count++){
								if($diaFinal==29 || $diaFinal==28){
									if ($count<10){ ?>
										<TD align=center size=10><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG>0<? echo $count; ?></STRONG></FONT></TD>
<?									}else{  ?>
										<TD align=center size=10><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG><? echo $count; ?></STRONG></FONT></TD>
<?									}
								}
								else{
									if ($count<10){ ?>
										<TD align=center size=12><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG>0<? echo $count; ?></STRONG></FONT></TD>
<?									}else{ ?>
										<TD align=center size=12><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG><? echo $count; ?></STRONG></FONT></TD>
<?									}
								}
							} // fin for $count
							if ($frmModo=="ingresar" || $frmModo=="modificar"){
							if($diaFinal==30){ ?>
<? //bueno ?>
								<TD align=center size=12>&nbsp;</TD>
<?							}
							if($diaFinal==29){ ?>
<? //bueno ?>
								<TD align=center size=12>&nbsp;&nbsp;&nbsp;</TD>
<?							}  ?>												
							<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</STRONG></FONT></TD>
<?					}	// fin if
					if ($frmModo=="mostrar"){ ?>
						<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#FFFFFF><STRONG>I.M.</STRONG></FONT></TD>
<?					} ?>
					</TD>
					</TR>


<?					$X=0;
					for($i=0 ; $i < @pg_numrows($resultado) ; $i++){
						$X++;
						$Y=0;
						$fila1 = @pg_fetch_array($resultado,$i);
						if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
							if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
								?>
								<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
								<?php
							}else{  ?>
								<TR bgcolor=#ffffff>
<?							}
						}else{  ?>
							<TR bgcolor=#ffffff>
<?						}  ?>
<?												//width=15   ?>
						<TD align=left width=5 ><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
						
<? 						echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);	?>

<? 
		$nombre=explode(" ",$fila1["nombre_alu"]);		
		?>
<?
/*		if(strlen($fila1["ape_pat"]) >8)
			echo  trim(substr($fila1["ape_pat"],0,8))." " ;
		else 
			echo  trim($fila1["ape_pat"])." " ;

		if(strlen($fila1["ape_mat"]) >8)
			echo  trim(substr($fila1["ape_mat"],0,8))."* " ;
		else 
			echo  trim($fila1["ape_mat"])."- " ;

		if(strlen($fila1["nombre_alu"]) >8)
			echo  trim(substr($fila1["nombre_alu"],0,8)) ;
		else 
			echo  trim($fila1["nombre_alu"]) ;						
*/		
 ?>
<? 			//			echo  trim(substr($fila1["ape_pat"],0,8))." ".trim(substr($fila1["ape_mat"],0,8)).", ".trim(substr($nombre[0],0,8));	?>
						</STRONG></FONT></TD>
<?
						$qry9="select count (rut_alumno) as cantidad from asistencia where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_alumno=".trim($fila1["rut_alumno"]);
						$result9 =@pg_Exec($conn,$qry9);
						$fila9 = @pg_fetch_array($result9,0);
						$cant=$fila9["cantidad"];
						if (!$result9) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry9);
						}
							
						/******** QRY PARA TRAER DIAS FERIADOS Y COLOREAR LA COLUMNA QUE CORRESPONDE********/
						
						$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
						}
							
						/******** QRY PARA TRAER DIAS INASISTENCIA********/	
						$qry2="select rut_alumno, ano, id_curso, date_part('day',asistencia.fecha) AS day, date_part('month',asistencia.fecha), date_part('year',asistencia.fecha) AS year from asistencia where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_alumno=".trim($fila1["rut_alumno"]);
						$result2 =@pg_Exec($conn,$qry2);
						if (!$result2)
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry2);
													
						if ($frmModo=="mostrar"){
						
							$m=0;
							$ñ=0;
							$cDias=$diaFinal+2;
							//for($c=1;$c<=33;$c++){
							for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								$filaFer=@pg_fetch_array($resultFer,$m);
								//if ($c<33)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){   ?>
										<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
										</strong></font></TD>
	<?									$m++;
									}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
											</strong></font></TD>
	<?									}
										$c=$c-1;
										$m++;
									}else{
									
										//if ($c==32){
										if ($c==($cDias-1)){
																	
											if($diaFinal==29){ ?>
<? //bueno ?>
												<TD align="left" size=15>&nbsp;&nbsp;&nbsp;</TD>
<?											}	?>
																							
											<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?											echo $cant;	?>
											</strong></font></TD>
	<?										$flag=1;
										}else{
											if ($c==$fila2["day"]){
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if(($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else{ ?>
													<TD align=center bgcolor=#E1EFFF><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}
												$ñ++;
											}else{
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else{	?>
													<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}
											}
										}
									}
																	
								}//fin if $c<32
								 //if (($c==32) and ($flag!=1)){
								 if (($c==($cDias-1)) and ($flag!=1)){	?>
									<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?									echo $cant;	?>
									</strong></font></TD>
<?								}
										
							}//fin for($c=1;$c<32;$c++)
															
						}else{
							if($frmModo=="ingresar"){
							$m=0;
							$ñ=0;
							$cDias=$diaFinal+1;
							
							//for($c=1;$c<=32;$c++){
							for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								$filaFer=@pg_fetch_array($resultFer,$m);
								//if ($c<32)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){	?>
										<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
										<INPUT TYPE=checkbox NAME="a[<? echo $X;?>][<? echo $c; ?>]" disabled>		
										</strong></font></TD>
<?										$m++;
									}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
											<INPUT TYPE=checkbox NAME="a[<? echo $X;?>][<? echo $c;?>]" disabled>
											</strong></font></TD>
<?										}
										$c=$c-1;
										$m++;
									}else{
										if ($c==$fila2["day"]){
											$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
											if($dia==6){///SABADO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" checked>
												</strong></font></TD>
<?											}else///
											if($dia==0){///DOMINGO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" disabled>
												</strong></font></TD>
<?											}else///
											if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
												<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" checked>
												</strong></font></TD>
<?											}else{	?>
												<TD align=center bgcolor='#E1EFFF'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" checked>
												</strong></font></TD>
<?											}
											$ñ++;
										}else{
										$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
										if($dia==6){///SABADO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]">
												</strong></font></TD>
<?										}else///
										if($dia==0){///DOMINGO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]" disabled>
												</strong></font></TD>
<?										}else///
										if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
												<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]">
												</strong></font></TD>
<?										}else{	?>
												<TD align=center ><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a[<? echo $X; ?>][<? echo $c; ?>]">
												</strong></font></TD>
<?										}
									}
																		
								}
																	
							}//fin if $c<32
																
						}//fin for($c=1;$c<32;$c++)

					}//fin if $frmModo
														
				}// fin else 
			}
		}
	}	




//*****************************************

												
								?>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>



      <table width=800 border="0" cellpadding="5" cellspacing="5">
          <tr> 
            <td height="33" align="right"> 
              <?php if (($frmModo=="ingresar") OR ($frmModo=="modificar")){?>
              <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="submit" name="Button" value="GUARDAR"> 
              <?php } ?>
              <?php if ($frmModo=="mostrar") {
			  			if(($_PERFIL!=6)&&($_PERFIL!=20)) {?>
              <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Button2" value="MODIFICAR" onClick=document.location="seteaAsistencia.php3?caso=1&mes=<?php echo $cmbMes ?>"> 
              		<? } ?>
               <?php } ?>
            </td>
          </tr>
        </table>

