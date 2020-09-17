<?php 

require('../../../../util/header.inc');


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$c_alumno;
?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?php
	if($frmModo!="ingresar"){
		 $qry="SELECT alumno.*, curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, matricula.num_mat FROM (tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ON curso.id_curso = matricula.id_curso WHERE (((matricula.id_ano)=".$ano.") AND ((alumno.rut_alumno)=".$alumno."))";

		$result =@pg_Exec($conn,$qry) or die($sql);
		if (!$result)
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		else
			if (pg_numrows($result)!=0)
				$fila = @pg_fetch_array($result,0);	
	};
?>

<?

$qryC = "SELECT cod_decreto, grado_curso, letra_curso, nombre_tipo, curso.id_curso FROM ((curso INNER JOIN matricula ON curso.id_curso=matricula.id_curso) INNER JOIN tipo_ensenanza ON tipo_ensenanza.cod_tipo=curso.ensenanza) WHERE matricula.rut_alumno=".$fila["rut_alumno"]." and matricula.id_ano=".$ano; 
$resultC =@pg_Exec($conn,$qryC);
$filaC = @pg_fetch_array($resultC,0); 
?>



<HTML>
	<HEAD>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
    <style type="text/css">
    .dd {
	text-align: center;
}
    </style>
	</HEAD>
<body >
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0  CELLPADDING=0 align=center>
			<TR>
				<TD>
					<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
						<TR height=15>
							<TD>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
									<TR height=20 bgcolor=#0099cc>
									  <TD colspan=2 align=middle bgcolor="#FFFFFF"><div align="right"><div id="capa0">
	    <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
        <INPUT name="button" TYPE="button" class="botonXX" onClick=document.location="matricula.php3"  value="VOLVER">
	  </div></div></TD>
								  </TR>
									<TR height=20 bgcolor=#0099cc>
									  <TD colspan=2 align=middle bgcolor="#FFFFFF"><table width="590" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td width="183"><?php
						$result = pg_Exec($conn,"select * from institucion where rdb=".$institucion);
	$arr=pg_fetch_array($result,0);

	$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."insignia');";
	$retrieve_result = @pg_exec($conn,$output);
	
						
					?><img src=../../../../tmp/<?php echo $institucion ?> ALT="NO DISPONIBLE"  width=100 ></td>
                                          <td width="391" class="textosimple"><div align="right"><?php
											$qry="SELECT * FROM institucion WHERE rdb=".$_INSTIT;
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												echo trim($fila1['nombre_instit']);
												echo "<br>";
											?>
											<FONT face="arial, geneva, helvetica" size=1>
												<strong>
											RBD: <?php 
											   echo trim($fila1['rdb']);
											?>- <?php 
											   echo trim($fila1['dig_rdb']);
												echo "<br>";
											?>
											</strong>
											<strong>
										  <?php
												echo trim($fila1['calle'])." ".trim($fila1['nro'])." ".trim($fila1['villa']);
												echo "<br>";
												$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila1['region']." AND COR_PRO=".$fila1['ciudad']." AND COR_COM=".$fila1['comuna'];
												$resultCOM	=@pg_Exec($conn,$qryCOM);
												$filaCOM = @pg_fetch_array($resultCOM,0);
												$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila1['region']." AND COR_PRO=".$fila1['ciudad'];
												$resultPRO	=@pg_Exec($conn,$qryPRO);
												$filaPRO = @pg_fetch_array($resultPRO,0);
												echo trim($filaCOM['nom_com']).", ".trim($filaPRO['nom_pro']);
												echo "<br>";
												echo "Fono:".trim($fila1['telefono']);
											}
										?></strong></FONT></div></td>
                                        </tr>
                                      </table></TD>
								  </TR>
									<TR height=20>
										<TD colspan=2 align=middle class="tableindex">
											<div align="center">CERTIFICADO DE MATR&Iacute;CULA</div></TD>
								  </TR>
							  </TABLE>
							</TD>
						</TR>
						<TR height=15>
							<TD>
								<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%" width=100%>
									<TR>
										<TD align=left>
											<FONT face="arial, geneva, helvetica" size=2>
												<strong>ALUMNO</strong>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=2>
												<strong>:</strong>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=2>
												<strong>
													<?php
														$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
														$result =@pg_Exec($conn,$qry);
														if (pg_numrows($result)!=0){
															$fila1 = @pg_fetch_array($result,0);	
															echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
														}
													?>
												</strong>
											</FONT>
										</TD>
										
									</TR>
									<TR>
										<TD align=left>
											<FONT face="arial, geneva, helvetica" size=2>
												<strong>RUT</strong>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=2>
												<strong>:</strong>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=2>
												<strong>
													<?php
															
															echo trim($fila1['rut_alumno'])." - ".trim($fila1['dig_rut']);
														
													?>
												</strong>
											</FONT>
							
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD align=center>
								<TABLE BORDER=0 CELLSPACING=15 CELLPADDING=15>
									<TR>
										<TD>
											<TABLE BORDER=1 CELLSPACING=0 CELLPADDING=15 width=550>
												<TR>
												  <TD colspan=3>
												    <FONT face="arial, geneva, helvetica" size=2 color=#000000>
															<?php
																$qry3="SELECT * from ano_escolar where id_ano=".$_ANO;
																$result3 =@pg_Exec($conn,$qry3);
																$fila3 = @pg_fetch_array($result3,0);	
															?>
															
															<?php
																$qry4="SELECT COUNT(*) from matricula where id_ano=".$_ANO;
																$result4 =@pg_Exec($conn,$qry4);
																$fila4 = @pg_fetch_array($result4,0);	
															?>
																								
															<BR>
															<BR>
															<STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;El presente documento certifica, que el alumno antes individualizado asiste regularmente a clases a este establecimiento educacional, cursando actualmente  
															<? if ( ($filaC['grado_curso']==1) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
															$grado="PRIMER NIVEL";
														}else if ( ($filaC['grado_curso']==1) and (($filaC['cod_decreto']==121987) or ($filaC['cod_decreto']==1521989)) ){
															$grado="PRIMER CICLO";
														}else if ( ($filaC['grado_curso']==1) and ($filaC['cod_decreto']==1000)){
															$grado="SALA CUNA";
														}else if ( ($filaC['grado_curso']==2) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
															$grado="SEGUNDO NIVEL";
														}else if ( ($filaC['grado_curso']==2) and ($filaC['cod_decreto']==121987) ){
															$grado="SEGUNDO CICLO";
														}else if ( ($filaC['grado_curso']==2) and ($filaC['cod_decreto']==1000)){
															$grado="NIVEL MEDIO MENOR";
														}else if ( ($filaC['grado_curso']==3) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
															$grado="TERCER NIVEL";
														}else if ( ($filaC['grado_curso']==3) and ($filaC['cod_decreto']==1000)){
															$grado="NIVEL MEDIO MAYOR";
														}else if ( ($fila1['grado_curso']==4) and ($filaC['cod_decreto']==1000)){
																  
														}else if ( ($filaC['grado_curso']==5) and ($filaC['cod_decreto']==1000)){
															 
														}else{
															$grado=$filaC['grado_curso'];
														}
														
																												
														if ($filaC['grado_curso']==4 and ($_INSTIT==1230 or $_INSTIT==1593) and ($filaC['cod_decreto']==1000)){
														   $grado = "PRE-KINDER";
														}
														
														if ($filaC['grado_curso']==5 and ($_INSTIT==1230 or $_INSTIT==1593) and ($filaC['cod_decreto']==1000)){
														    $grado = "KINDER";
														}
																											
														
														
										if ($_INSTIT==1230 or $_INSTIT==1593 and ($filaC['cod_decreto']==1000)){				
										     imp($grado." de ".$filaC["nombre_tipo"]);
										}else{
										     imp($grado."-".$filaC["letra_curso"]." ".$filaC["nombre_tipo"]);
										}	 
										echo "<input type=hidden name=curso value=".$filaC['id_curso'].">";
										?> del año <?php echo trim($fila3['nro_ano'])?> con el número de matrícula Nº <?php echo $fila['num_mat']; ?>. </STRONG>
															<BR>
															<BR>
															<BR>
															<STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Se extiende el presente certificado de matricula a petición del interesado para los fines que estime conveniente.</STRONG>
															<BR>
															<BR>
															<BR>
															<BR>
													    <BR>
															<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</FONT>
												    <table width="100%" border="0" cellpadding="0" cellspacing="0">
												      <tr>
												        <th scope="row"><font face="arial, geneva, helvetica" size=2 color=#000000>&nbsp;&nbsp;--------------------------------------------------------</font></th>
											          </tr>
												      <tr>
												        <th scope="row"><font face="arial, geneva, helvetica" size=2 color=#000000>
												          <? $qryEMP="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc"; 
	$rs_director=pg_exec($conn,$qryEMP);
	$fila_d=pg_fetch_array($rs_director,0);
	echo $fila_d["nombre_emp"]." ".$fila_d["ape_pat"]." ".$fila_d["ape_mat"];

?>
												        </font></th>
											          </tr>
												      <tr>
												        <th scope="row"><font face="arial, geneva, helvetica" size=2 color=#000000>&nbsp; Director </font></th>
											          </tr>
											        </table>
												    <FONT face="arial, geneva, helvetica" size=2 color=#000000><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</FONT>
													    <br>
												    <br>
													
													<?
													if ($_INSTIT==12086){ ?>
													
														<table width="400" border="0" cellspacing="0" cellpadding="0">
															<tr><?
															
															$comuna = "Las Condes";
															
															
															 $fecha = date("d-m-Y") ?>
															 <td width="%" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo ucwords(strtolower($comuna . ", " . fecha_espanol($fecha)))?></strong></font></td>
														  </tr>
														</table>
												<? } ?>		
													
													
												  </TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					</TABLE>
			</TD>
		</TR>
	</TABLE>
</BODY>
</HTML>