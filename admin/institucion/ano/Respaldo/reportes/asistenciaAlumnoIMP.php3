<?
require('../../../../util/header.inc');
//include ("calendario/calendario.php");


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
?>

<html>
<head>
	<title>Asistencia y Atrasos por Alumno</title>

		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT></head>

<body onLoad="javascript:window.print();history.back();">

<br>
<br>
<br>
  <table width="64%" border="0" align="center">
    <tr>
      
    <td height="786">
<table width="100%" border="0">
        <tr> 
          <td width="26%" rowspan="2">
			<?php 
			$output= "select lo_export(".$arr[insignia].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);
			?>
			<img src=../../../../../tmp/<?php echo $arr[rdb] ?> ALT="NO DISPONIBLE" width=75>
			</td>
          <td width="31%" height="22"><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></td>
          <td width="2%"><font face="arial, geneva, helvetica" size=2><strong>:</strong></font></td>
          <td width="41%"><FONT face="arial, geneva, helvetica" size=2><strong> 
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
          <td><FONT face="arial, geneva, helvetica" size=2><strong>AÑO ESCOLAR</strong></FONT></td>
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
								$hP1  =trim($fila['dias_habiles']);
								$fIni1 =trim($fila['fecha_inicio']);
								$fTer1 =trim($fila['fecha_termino']);
		  					
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
	  
	  		 $qry7="SELECT * FROM ALUMNO INNER JOIN MATRICULA ON ALUMNO.RUT_ALUMNO=MATRICULA.RUT_ALUMNO WHERE MATRICULA.ID_CURSO=".$curso." AND ALUMNO.RUT_ALUMNO=".$alumno;
				$result7=@pg_Exec($conn,$qry7);
				 $fila7 = @pg_fetch_array($result7,0);
				if (!$result7) {
					error('<b> ERROR :</b>Error al acceder a la BD. (7)'.$qry7);
				}
			$alu = 	$fila7["ape_pat"]." ".$fila7["ape_mat"]."  ".$fila7["nombre_alu"];	
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
          <td> <p> </p></td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"><font color="#333333">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><strong> 
            Alumno :&nbsp; <?php echo $alu ?></strong></font></font></td>
        </tr>
      </table>
       
      <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1">
        <tr align="center" bordercolor="#666666" bgcolor="#48d1cc"> 
          <td colspan="7" valign="middle"> <div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" size="1,5"><strong><font color="#000000">&nbsp;INFORME 
              DE INASISTENCIAS</font></strong></font><font color="#000000" size="1,5"><strong>&nbsp;&nbsp;</strong></font></font></div></td>
        </tr>
        <tr align="center" bordercolor="#666666" bgcolor="#48d1cc"> 
          <td width="16%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">CURSO</font></td>
          <td width="15%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">1º 
            TRIMESTRE</font></td>
          <td width="15%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">2º 
            TRIMESTRE</font></td>
          <td width="15%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">3º 
            TRIMESTRE</font></td>
          <td width="11%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DIAS 
            HABILES </font></td>
          <td width="13%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">TOTAL 
            INASISTENCIAS</font></td>
          <td width="14%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">% 
            INASIST.</font></td>
        </tr>
        <?php 
		//for($i=0 ; $i<pg_numrows($result7) ; $i++){
		 
		  
		       $qry8="SELECT COUNT(*)AS CUENTA1 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni1."' AND '".$fTer1."') AND RUT_ALUMNO=".$alumno;
					$result8=@pg_Exec($conn,$qry8);
					$fila8 = @pg_fetch_array($result8,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (8)'.$qry8);
						}
						
			$qry11="SELECT COUNT(*) AS CUENTASIS1 FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni1."' AND '".$fTer1."' AND RUT_ALUMNO=".$alumno;
					$result11=@pg_Exec($conn,$qry11);
					$fila11 = @pg_fetch_array($result11,0);
						if (!$result11) {
							error('<b> ERROR :</b>Error al acceder a la BD. (11)'.$qry11);
						}
						
			 $qry9="SELECT COUNT(*)AS CUENTA2 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni2."' AND '".$fTer2."') AND RUT_ALUMNO=".$alumno;
					$result9=@pg_Exec($conn,$qry9);
					$fila9 = @pg_fetch_array($result9,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (9)'.$qry9);
						}
						
			 $qry12="SELECT COUNT(*) AS CUENTASIS2 FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni2."' AND '".$fTer2."' AND RUT_ALUMNO=".$alumno;
					$result12=@pg_Exec($conn,$qry12);
					$fila12 = @pg_fetch_array($result12,0);
						if (!$result12) {
							error('<b> ERROR :</b>Error al acceder a la BD. (12)'.$qry12);
						}
		
			 $qry0="SELECT COUNT(*)AS CUENTA3 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni3."' AND '".$fTer3."') AND RUT_ALUMNO=".$alumno;
					$result0=@pg_Exec($conn,$qry0);
					$fila0 = @pg_fetch_array($result0,0);
						if (!$result0) {
							error('<b> ERROR :</b>Error al acceder a la BD. (0)'.$qry0);
						}
						
			 $qry13="SELECT COUNT(*) AS CUENTASIS3 FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni3."' AND '".$fTer3."' AND  RUT_ALUMNO=".$alumno;
					$result13=@pg_Exec($conn,$qry13);
					$fila13 = @pg_fetch_array($result13,0);
						if (!$result13) {
							error('<b> ERROR :</b>Error al acceder a la BD. (11)'.$qry13);
						}

		  
		  //$alumno= $fila7["ape_pat"]." ".$fila7["ape_mat"]."  ".$fila7["nombre_alu"];
		  $cuenta1 = $fila8["cuenta1"];
		  $cuenta2 = $fila9["cuenta2"];
		  $cuenta3 = $fila0["cuenta3"];
		  $asist1  = $fila11["cuentasis1"];
		  $asist2  = $fila12["cuentasis2"];
		  $asist3  = $fila13["cuentasis3"];
		  $dias_habiles = $hP1 + $hP2 + $hP3;
		  $total   = $cuenta1 + $cuenta2 + $cuenta3;
		  $totalatras= $asist1 + $asist2 + $asist3;
		  $porc	   = ($total * 100) / $dias_habiles;

		  
		   ?>
        <tr align="center" bordercolor="#666666" bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='transparent'> 
          <td> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
              <?php  echo trim($filaC['grado_curso']);?>
              º&nbsp;<?php echo $filaC['letra_curso'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $cuenta1;?></font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $cuenta2;?></font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $cuenta3;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $dias_habiles;?></font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $total;?></font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo number_format($porc,1,',','.');?>%</font></td>
        </tr>

      </table>
	  
      <table width="100%" border="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="1" cellpadding="0" cellspacing="1">
        <tr align="center" bordercolor="#666666" bgcolor="#48d1cc"> 
          <td colspan="7" valign="middle"> 
            <div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" size="1,5"><strong><font color="#000000">&nbsp;INFORME 
              DE ATRASOS</font></strong></font><font color="#000000" size="1,5"><strong>&nbsp;&nbsp;</strong></font></font></div></td>
        </tr>
        
        <tr align="center" bordercolor="#666666" bgcolor="#48d1cc"> 
          <td width="16%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">CURSO</font></td>
          <td width="15%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">1º 
            TRIMESTRE</font></td>
          <td width="16%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">2º 
            TRIMESTRE</font></td>
          <td width="15%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">3º 
            TRIMESTRE</font></td>
          <td width="19%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DIAS 
            HABILES </font></td>
          <td width="19%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">TOTAL 
            ATRASOS</font></td>
          
        </tr>
        <?php 
		//for($i=0 ; $i<pg_numrows($result7) ; $i++){
		  $fila7 = @pg_fetch_array($result7,0);
		  
		       $qry8="SELECT COUNT(*)AS CUENTA1 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni1."' AND '".$fTer1."') AND RUT_ALUMNO=".$alumno;
					$result8=@pg_Exec($conn,$qry8);
					$fila8 = @pg_fetch_array($result8,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (8)'.$qry8);
						}
						
			  $qry9="SELECT COUNT(*)AS CUENTA2 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni2."' AND '".$fTer2."') AND RUT_ALUMNO=".$alumno;
					$result9=@pg_Exec($conn,$qry9);
					$fila9 = @pg_fetch_array($result9,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (9)'.$qry9);
						}
		
			  $qry0="SELECT COUNT(*)AS CUENTA3 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni3."' AND '".$fTer3."') AND RUT_ALUMNO=".$alumno;
					$result0=@pg_Exec($conn,$qry0);
					$fila0 = @pg_fetch_array($result0,0);
						if (!$result0) {
							error('<b> ERROR :</b>Error al acceder a la BD. (0)'.$qry0);
						}

		  
		  //$alumno= $fila7["ape_pat"]." ".$fila7["ape_mat"]."  ".$fila7["nombre_alu"];
		  $cuenta1 = $fila8["cuenta1"];
		  $cuenta2 = $fila9["cuenta2"];
		  $cuenta3 = $fila0["cuenta3"];
		  $asist1  = $fila11["cuentasis1"];
		  $asist2  = $fila12["cuentasis2"];
		  $asist3  = $fila13["cuentasis3"];
		  $dias_habiles = $hP1 + $hP2 + $hP3;
		  $total   = $cuenta1 + $cuenta2 + $cuenta3;
		  $totalatras= $asist1 + $asist2 + $asist3;
		  $porc	   = ($total * 100) / $dias_habiles;

		  
		   ?>
        <tr align="center" bordercolor="#666666" bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='transparent'> 
          <td> 
            <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php  echo trim($filaC['grado_curso']);?>
            º&nbsp;<?php echo $filaC['letra_curso'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $asist1;?></font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $asist2;?></font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $asist3;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $dias_habiles;?></font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $totalatras;?></font></td>
        </tr>
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
            
         <td bgcolor="#0099CC">&nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong> 
            Alumno :&nbsp; 
            <?php echo $alu ?></strong></font></td>
          </tr>
        </table>
        
      <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1">
        <tr align="center" bordercolor="#666666" bgcolor="#48d1cc"> 
          <td colspan="7" valign="middle"> <div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" size="1,5"><strong><font color="#000000">&nbsp;INFORME 
              DE INASISTENCIAS</font></strong></font><font color="#000000" size="1,5"><strong>&nbsp;&nbsp;</strong></font></font></div></td>
        </tr>
        <tr align="center" bordercolor="#666666" bgcolor="#48d1cc"> 
          <td width="19%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">CURSO</font></td>
          <td width="18%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">1º 
            SEMESTRE</font></td>
          <td width="19%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">2º 
            SEMESTRE</font></td>
          <td width="19%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DIAS 
            HABILES </font></td>
          <td width="12%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">TOTAL 
            INASISTENCIAS</font></td>
          <td width="13%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">% 
            INASIST.</font></td>
        </tr>
        <?php 
		
		//for($i=0 ; $i<pg_numrows($result7) ; $i++){
		  $fila7 = pg_fetch_array($result7,0);
		  
		  
		    $qry8="SELECT COUNT(*)AS CUENTA1 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni1."' AND '".$fTer1."') AND RUT_ALUMNO=".$alumno;
					$result8=@pg_Exec($conn,$qry8);
					$fila8 = @pg_fetch_array($result8,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (8)'.$qry8);
						}
						
			  $qry9="SELECT COUNT(*)AS CUENTA2 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni2."' AND '".$fTer2."') AND RUT_ALUMNO=".$alumno;
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
        <tr align="center" bordercolor="#666666" bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'> 
          <td> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo trim($filaC['grado_curso']);?>º&nbsp; 
              <?php 
            echo $filaC['letra_curso'];?>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $cuenta1;?></font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $cuenta2;?></font></td>
          <td> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $dias_habiles;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $total;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo number_format($porc,1,',','.');?>%</font></td>
        </tr>

      </table>
		
        
      <table width="100%" border="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0">
          <tr>
            <td>      <table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#666666">
              <tr align="center" bordercolor="#666666" bgcolor="#48d1cc"> 
                <td colspan="7" valign="middle"> 
                  <div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" size="1,5"><strong><font color="#000000">&nbsp;INFORME 
              DE ATRASOS</font></strong></font><font color="#000000" size="1,5"><strong>&nbsp;&nbsp;</strong></font></font></div></td>
        </tr>
        
              <tr align="center" bordercolor="#666666" bgcolor="#48d1cc"> 
                <td width="19%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">CURSO</font></td>
                <td width="18%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">1º 
                  SEMESTRE</font></td>
                <td width="19%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">2º 
                  SEMESTRE</font></td>
         
                <td width="20%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DIAS 
                  HABILES </font></td>
                <td width="24%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">TOTAL 
                  ATRASOS</font></td>
          
        </tr>
        <?php 
		//for($i=0 ; $i<pg_numrows($result7) ; $i++){
		/*  $fila7 = @pg_fetch_array($result7,0);
		  
		       $qry8="SELECT COUNT(*)AS CUENTA1 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni1."' AND '".$fTer1."') AND RUT_ALUMNO=".$alumno;
					$result8=@pg_Exec($conn,$qry8);
					$fila8 = @pg_fetch_array($result8,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (8)'.$qry8);
						}
						
			  $qry9="SELECT COUNT(*)AS CUENTA2 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni2."' AND '".$fTer2."') AND RUT_ALUMNO=".$alumno;
					$result9=@pg_Exec($conn,$qry9);
					$fila9 = @pg_fetch_array($result9,0);
						if (!$result8) {
							error('<b> ERROR :</b>Error al acceder a la BD. (9)'.$qry9);
						}
		
			  $qry0="SELECT COUNT(*)AS CUENTA3 FROM ASISTENCIA WHERE (FECHA BETWEEN '".$fIni3."' AND '".$fTer3."') AND RUT_ALUMNO=".$alumno;
					$result0=@pg_Exec($conn,$qry0);
					$fila0 = @pg_fetch_array($result0,0);
						if (!$result0) {
							error('<b> ERROR :</b>Error al acceder a la BD. (0)'.$qry0);
						}
*/
		  
		  //$alumno= $fila7["ape_pat"]." ".$fila7["ape_mat"]."  ".$fila7["nombre_alu"];
		  $cuenta1 = $fila8["cuenta1"];
		  $cuenta2 = $fila9["cuenta2"];
		  $cuenta3 = $fila0["cuenta3"];
		  $asist1  = $fila11["cuentasis1"];
		  $asist2  = $fila12["cuentasis2"];
		  $asist3  = $fila13["cuentasis3"];
		  $dias_habiles = $hP1 + $hP2 + $hP3;
		  $total   = $cuenta1 + $cuenta2 + $cuenta3;
		  $totalatras= $asist1 + $asist2 + $asist3;
		  $porc	   = ($total * 100) / $dias_habiles;

		  
		   ?>
              <tr align="center" bordercolor="#666666" bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='transparent'> 
                <td> 
                  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php  echo trim($filaC['grado_curso']);?>
            º&nbsp;<?php echo $filaC['letra_curso'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
                <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $asist1;?></font></td>
                <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $asist2;?></font></td>
                <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $dias_habiles;?></font></td>
                <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $totalatras;?></font></td>
        </tr>
      </table>
	  <?php  } ?>
</td>
          </tr>
        </table>
        
      <table width="100%" border="0">
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr align="center"> 
          <td width="57%" valign="baseline">&nbsp;</td>
          <td width="43%" valign="baseline">_________________________</td>
        </tr>
        <tr align="center"> 
          <td valign="baseline">&nbsp;</td>
          <td valign="baseline"><font size="1" face="Arial, Helvetica, sans-serif">Firma 
            Profesor Jefe o Responsable</font></td>
        </tr>
      </table>
    </tr>
  </table>
  <br>
<br>

</body>
</html>
	<? pg_close($conn);?>