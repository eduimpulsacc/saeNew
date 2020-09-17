<?
require('../../../../util/header.inc');
//include ("calendario/calendario.php");


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
?>

<html>
<head>
	<title>Asistencia por Curso</title>

		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT></head>

<body onLoad="javascript:window.print();history.back();">
<table width="64%" border="0" align="center">
    <tr>
      <td><table width="100%" border="0">
        <tr> 
          <td width="21%" rowspan="2">
		  <?php 
			$output= "select lo_export(".$arr[insignia].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);
			?>
			<img src=../../../../../tmp/<?php echo $arr[rdb] ?> ALT="NO DISPONIBLE" width=75>
		  </td>
          <td width="28%"><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></td>
          <td width="2%"><font face="arial, geneva, helvetica" size=2><strong>:</strong></font></td>
          <td width="49%"><FONT face="arial, geneva, helvetica" size=2><strong> 
            <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												//if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												//}
 											}
										?>
            </strong></FONT></td>
        </tr>
        <tr> 
          <td><FONT face="arial, geneva, helvetica" size=2><strong>AÑO ESCOLAR</strong> 
            </FONT></td>
          <td><font face="arial, geneva, helvetica" size=2><strong>:</strong></font></td>
          <td><FONT face="arial, geneva, helvetica" size=2><strong> 
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
													echo trim($fila1['nro_ano']);
													$nroAno=trim($fila1['nro_ano']);
												}
											}
											
								$qryC="SELECT * FROM CURSO WHERE ID_CURSO=".$curso;
											$resultC =@pg_Exec($conn,$qryC);
											if (!$resultC) {
												error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>'.$qryC);
											}else{
												if (pg_numrows($resultC)!=0){
													$filaC = @pg_fetch_array($resultC,0);	
													if (!$filaC){
														error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
														exit();
													}
												}
											}
											
											
								$qryE="SELECT * FROM TIPO_ENSENANZA WHERE COD_TIPO=".$filaC['ensenanza'];
											$resultE =@pg_Exec($conn,$qryE);
											if (!$resultE) {
												error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>'.$qryE);
											}else{
												if (pg_numrows($resultE)!=0){
													$filaE = @pg_fetch_array($resultE,0);	
													if (!$filaE){
														error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
														exit();
													}
												}
											}			
											
											
										?>
            </strong></FONT></td>
        </tr>
      </table>
        <table width="100%" border="0">
          <tr>
            
          <td align="right">&nbsp; </td>
          </tr>
        </table>

		<?php  
		  $qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
													$result6 =@pg_Exec($conn,$qry6);
													if (!$result6) {
														error('<B> ERROR :</b>Error al acceder a la BD. (31)</B>');
													}else{
														if (pg_numrows($result6)!=0){
											
             										$fila6 = @pg_fetch_array($result6,0);
																	$idPer1=$fila6['id_periodo'];
					
																	$fila6 = @pg_fetch_array($result6,1);
																	$idPer2=$fila6['id_periodo'];
															
																	$fila6 = @pg_fetch_array($result6,2);
																	$idPer3=$fila6['id_periodo'];
																	
														}
													}				
																?>
		  
		  
		  <?php
		  
		  			$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer1;
						$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (32)</B>');
							}else{
								if (pg_numrows($result)!=0){
									$fila = @pg_fetch_array($result,0);	
								   if (!$fila){
										error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
										exit();
									}
								$hP1  =$fila['dias_habiles'];
								$fIni1 =$fila['fecha_inicio'];
								$fTer1 =$fila['fecha_termino'];
								
								if(($fIni1=="") or ($fTer1=="") or ($hP1=="")){?>
											<script> window.location='aviso.php3';</script>
							<?php exit; }
		  	
		  
				  }
			}
			
						$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer2;
						$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (32)</B>');
							}else{
								if (pg_numrows($result)!=0){
									$fila = @pg_fetch_array($result,0);	
								   if (!$fila){
										error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
										exit();
									}
								$hP2  =$fila['dias_habiles'];
								$fIni2 =$fila['fecha_inicio'];
								$fTer2 =$fila['fecha_termino'];
								
								if(($fIni2=="") or ($fTer2=="") or ($hP2=="")){?>
											<script> window.location='aviso.php3';</script>
							<?php exit; }
		  	
		  
				  }
			}
			
					  if($_TIPOREGIMEN==2){//TRIMESTRAL
						$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer3;
						$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (32)</B>');
							}else{
								if (pg_numrows($result)!=0){
									$fila = @pg_fetch_array($result,0);	
								   if (!$fila){
										error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
										exit();
									}
								$hP3  =$fila['dias_habiles'];
								$fIni3 =$fila['fecha_inicio'];
								$fTer3 =$fila['fecha_termino'];
								
								if(($fIni3=="") or ($fTer3=="") or ($hP3=="")){?>
											<script> window.location='aviso.php3';</script>
							<?php exit; }
		  	
		  
				  }
			}
	  }
	  
	  		 $qry7="SELECT * FROM ALUMNO INNER JOIN MATRICULA ON ALUMNO.RUT_ALUMNO=MATRICULA.RUT_ALUMNO WHERE MATRICULA.ID_CURSO=".$curso." ORDER BY ALUMNO.APE_PAT, ALUMNO.APE_MAT, ALUMNO.NOMBRE_ALU";
				$result7=@pg_Exec($conn,$qry7);
				if (!$result7) {
					error('<b> ERROR :</b>Error al acceder a la BD. (7)'.$qry7);
				}		
	  ?>
        <table width="100%" border="0">
          <tr> 
          <td>
		  </td>
          </tr>
        </table>
		<?php if($_TIPOREGIMEN==2){//TRIMESTRAL ?>
		<table width="100%" border="0" bordercolor="#0099CC">
          <tr>
          <td bgcolor="#0099CC">&nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>ASISTENCIA 
            CURSO :&nbsp;<?php  echo trim($filaC['grado_curso']);?>º&nbsp;<?php echo $filaC['letra_curso'];?>&nbsp;&nbsp;<?php echo $filaE['nombre_tipo'];?></strong></font></td>
			</tr>
        </table>
       
      <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1">
        <tr align="center" bordercolor="#999999" bgcolor="#48d1cc"> 
          <td width="32%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td colspan="3" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">CANTIDAD 
            DE INASISTENCIAS</font></td>
          <td colspan="3" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
        <tr align="center" bordercolor="#999999" bgcolor="#48d1cc"> 
          <td width="32%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">ALUMNO</font></td>
          <td width="9%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">1º 
            TRIM</font></td>
          <td width="9%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">2º 
            TRIM</font></td>
          <td width="9%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">3º 
            TRIM</font></td>
          <td width="10%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DIAS 
            HABILES </font></td>
          <td width="10%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">TOTAL 
            INASISTENCIAS</font></td>
          <td width="10%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">% 
            INASIST.</font></td>
        </tr>
        <?php 
		for($i=0 ; $i<pg_numrows($result7) ; $i++){
		  $fila7 = @pg_fetch_array($result7,$i);
		  
		       $qry8="SELECT COUNT(*)AS CUENTA1 FROM ASISTENCIA WHERE ((FECHA BETWEEN '".$fIni1."' AND '".$fTer1."') AND RUT_ALUMNO=".$fila7['rut_alumno'].")";
					$result8=@pg_Exec($conn,$qry8);
					$fila8 = @pg_fetch_array($result8,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (8)'.$qry8);
						}
						
			  $qry9="SELECT COUNT(*)AS CUENTA2 FROM ASISTENCIA WHERE ((FECHA BETWEEN '".$fIni2."' AND '".$fTer2."') AND RUT_ALUMNO=".$fila7['rut_alumno'].")";
					$result9=@pg_Exec($conn,$qry9);
					$fila9 = @pg_fetch_array($result9,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (9)'.$qry9);
						}
		
			  $qry0="SELECT COUNT(*)AS CUENTA3 FROM ASISTENCIA WHERE ((FECHA BETWEEN '".$fIni3."' AND '".$fTer3."') AND RUT_ALUMNO=".$fila7['rut_alumno'].")";
					$result0=@pg_Exec($conn,$qry0);
					$fila0 = @pg_fetch_array($result0,0);
						if (!$result0) {
							error('<b> ERROR :</b>Error al acceder a la BD. (0)'.$qry0);
						}

		  
		  $alumno= $fila7["ape_pat"]." ".$fila7["ape_mat"]."  ".$fila7["nombre_alu"];
		  $cuenta1 = $fila8["cuenta1"];
		  $cuenta2 = $fila9["cuenta2"];
		  $cuenta3 = $fila0["cuenta3"];
		  $dias_habiles = $hP1 + $hP2 + $hP3;
		  $total   = $cuenta1 + $cuenta2 + $cuenta3;
		  $porc	   = ($total * 100) / $dias_habiles;

		  
		   ?>
        <tr align="center" bordercolor="#999999" bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='transparent'> 
          <td> 
            <div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $alumno;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $cuenta1;?></font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $cuenta2;?></font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $cuenta3;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $dias_habiles;?></font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $total;?></font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo number_format($porc,1,',','.');?>%</font></td>
        </tr>
        <?php } ?>
      </table>
	  <?php } ?>
      <table width="100%" border="0">
        <tr>
          <td>
            <?php if($_TIPOREGIMEN==3){//SEMESTRAL?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" bordercolor="#0099CC">
          <tr>
          </tr>
        </table>
        <table width="100%" border="0" bordercolor="#0099CC">
          <tr>
            
          <td bgcolor="#0099CC">&nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>ASISTENCIA 
            CURSO :&nbsp;<?php echo trim($filaC['grado_curso']);?>º&nbsp;<?php 
            echo $filaC['letra_curso'];?>&nbsp;<?php echo 
            $filaE['nombre_tipo'];?></strong></font></td>
          </tr>
        </table>
        
      <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="#999999">
        <tr align="left" bgcolor="#48d1cc"> 
          <td width="29%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td colspan="2" valign="middle"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CANTIDAD 
              DE INASISTENCIAS</font><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
        <td colspan="3" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
		</tr>
        <tr align="center" bgcolor="#48d1cc"> 
          <td width="29%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">ALUMNO</font></td>
          <td width="17%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">1º 
            SEM</font></td>
          <td width="17%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">2º 
            SEM</font></td>
          <td width="12%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DIAS 
            HABILES .</font></td>
			
          <td width="12%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">TOTAL 
            INASISTENCIAS</font></td>
          <td width="13%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">% 
            INASIST.</font></td>
        </tr>
        <?php 
		
		for($i=0 ; $i<pg_numrows($result7) ; $i++){
		  $fila7 = pg_fetch_array($result7,$i);
		  
		  
		    $qry8="SELECT COUNT(*)AS CUENTA1 FROM ASISTENCIA WHERE ((FECHA BETWEEN '".$fIni1."' AND '".$fTer1."') AND RUT_ALUMNO=".$fila7['rut_alumno'].")";
					$result8=@pg_Exec($conn,$qry8);
					$fila8 = @pg_fetch_array($result8,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (8)'.$qry8);
						}
						
			  $qry9="SELECT COUNT(*)AS CUENTA2 FROM ASISTENCIA WHERE ((FECHA BETWEEN '".$fIni2."' AND '".$fTer2."') AND RUT_ALUMNO=".$fila7['rut_alumno'].")";
					$result9=@pg_Exec($conn,$qry9);
					$fila9 = @pg_fetch_array($result9,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (9)'.$qry9);
						}
		

		  
		  $alumno= $fila7["ape_pat"]." ".$fila7["ape_mat"]."  ".$fila7["nombre_alu"];
		  $cuenta1 = $fila8["cuenta1"];
		  $cuenta2 = $fila9["cuenta2"];
		  $dias_habiles = $hP1 + $hP2;
		  $total   = $cuenta1 + $cuenta2;
		  $porc	   = ($total * 100) / $dias_habiles;
		  
		 
		  
		  
		   ?>
        <tr align="center" bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'> 
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $alumno;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $cuenta1;?></font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $cuenta2;?></font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $dias_habiles;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $total;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
		  <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo number_format($porc,1,',','.');?>%</font></td>
        </tr>
        <?php }?>
      </table>
		<?php } ?>
		<table width="100%" border="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        
      <table width="100%" border="0">
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table>
        
      <table width="100%" border="0">
        <tr> 
          <td>&nbsp;</td>
          <td width="43%" align="center" valign="baseline">________________________</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center" valign="baseline"><font size="1" face="Arial, Helvetica, sans-serif">Firma 
            Profesor Jefe o Responsable</font></td>
        </tr>
      </table>
      <table width="100%" border="0">
      </table></td>
    </tr>
  </table>
  <br>
<br>

</body>
</html>
	<? pg_close($conn);?>