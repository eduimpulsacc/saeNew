<?php require('../../../../../util/header.inc');?>
			<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
			
			<SCRIPT LANGUAGE="JavaScript">
			<!--
				function valida(form){
					/*for (x=0;x<=form.length-1;x++){
						if (form[x].name.substr(0,15)=="situacion_final"){
							if(!chkSelect(form[x],'Seleccionar la Situación Final del Alumno.')){
								return false;
							};
						};
					};
					return true;*/
				};
			</SCRIPT>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO; 

	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	//----------------------------------------------------------------------------
	// DIAS HÁBILES
	//----------------------------------------------------------------------------		
	$sql_periodo = "select sum(dias_habiles) as habiles from periodo where periodo.id_ano = ".$ano;
	$result_periodo =@pg_Exec($conn,$sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);	
	$habiles = $fila_periodo['habiles'];	
	//----------------------------------------------------------------------------	
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN comuna ON (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) AND (institucion.region = comuna.cod_reg)) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];
	$region = ucwords(strtolower($fila_institu['nom_reg']));
	$provincia = ucwords(strtolower($fila_institu['nom_pro']));
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	//----------------------------------------------------------------------------
	// CURSO
	//----------------------------------------------------------------------------	
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	$sqlCurso = "select * from curso where id_curso = $curso";
	$rsCurso =@pg_Exec($conn,$sqlCurso);
	$flCurso = @pg_fetch_array($rsCurso ,0);	
	$truncado_per = $flCurso['truncado_per'];
	$ensenanza = $flCurso['ensenanza'];
	//----------------------------------------------------------------------------
	// ALUMNOS
	//----------------------------------------------------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso, matricula.bool_ar ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
//	echo $sql_alu."<br>";
	$result_alu =@pg_Exec($conn,$sql_alu);	
	//----------------------------------------------------------------------------	
?>

<? function promedia_aleman($suma_promedios,$total_promedios){

	  $prom_temp=($suma_promedios/$total_promedios);
		$prom_temp=number_format($prom_temp,1);
		
		$decimal=substr($prom_temp,strlen($prom_temp)-1,1);
//		echo "<br>".$decimal;
		$prom_temp=substr($prom_temp,0,2);
		
		if ($prom_temp>=40){
			if ($decimal>=5){ $prom_temp++;}
		}
//		echo "<br>".$prom_temp;
		$prom_temp=substr($prom_temp,0,1)."".substr($prom_temp,1,1);
//		echo "<br>".$prom_temp;
		if ($prom_temp=="39"){$prom_temp=="40";}
		return $prom_temp;
				
}	

/*function promedia_1517($suma_promedios,$total_promedios){

	echo   $prom_temp=($suma_promedios/$total_promedios);
		$prom_temp=number_format($prom_temp,1);
		
		$centesima=substr($prom_temp,strlen($prom_temp)-1,1);
		$prom_temp=substr($prom_temp,0,2);
		
		$decima=substr($prom_temp,1,1);
		$entero=substr($prom_temp,0,1);

		if ($decima==9){$entero++;$centesima=0;}
		
		if ($centesima>=5){ $decima++;}

		$prom_temp=$entero.".".$decima;

//		if ($prom_temp=="3.9"){$prom_temp=="4.0";}
		return $prom_temp;

}*/

function sube_punto_nuevo($prom){
//	echo $prom;
		$decima=substr($prom,1,1);
		$entero=substr($prom,0,1);

		if ($decima==9){$entero++;$decima=0;}
		
		
		$prom_temp=$entero."".$decima;

//		if ($prom_temp=="3.9"){$prom_temp=="4.0";}
		return $prom_temp;

}

?>
<html>
<head>
<title>.</title>
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<center>
<FORM method=post name="frm" action="procesoPromocion_pro.php">
<table width="750" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="113" align="left"><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></td>
    <td width="8" align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td width="521" align="left"><FONT face="arial, geneva, helvetica" size=2><? echo strtoupper($nombre_institu)?></FONT></td>
  </tr>
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>A&Ntilde;O ESCOLAR </strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><? echo $nro_ano?></FONT></td>
  </tr>
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><? echo $Curso_pal?></FONT></td>
  </tr>
</table>
<table width="750" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="right">
	  <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;  
      <INPUT name="button2" TYPE="button" class="botonX" onClick=document.location="promocion_pro.php" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="CANCELAR"></td>
  </tr>
  <tr bgcolor="#003b85" align="center">
    <td ><FONT face="arial, geneva, helvetica" size=2 color="#FFFFFF"><strong>PROMOCION DE ALUMNOS </strong></FONT></td>
  </tr>
</table>
<table width="750" border="0" cellspacing="1" cellpadding="1">
  <tr bgcolor="#48d1cc">
    <td height="24" align="center"><FONT face="arial, geneva, helvetica" size=1><strong>RUT ALUMNO </strong></FONT></td>
    <td align="center"><FONT face="arial, geneva, helvetica" size=1><strong>NOMBRE ALUMNO </strong></FONT></td>
    <td align="center"><FONT face="arial, geneva, helvetica" size=1><strong>PROMEDIO</strong></FONT></td>
    <td align="center"><FONT face="arial, geneva, helvetica" size=1><strong>ASISTENCIA (%) </strong></FONT></td>
    <td align="center"><FONT face="arial, geneva, helvetica" size=1><strong>SITUACION</strong></FONT></td>
    <td align="center"><FONT face="arial, geneva, helvetica" size=1><strong>OBSERVACIÓN</strong></FONT></td>
  </tr>
 <?
$cont_alumnos = @pg_numrows($result_alu);
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos  ; $cont_paginas++)
{
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'];
	$rut_alumno = $fila_alu['rut_alumno'] . " - " . strtoupper($fila_alu['dig_rut']);
	$nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']))); 
	$curso = $fila_alu['id_curso'];
	$Retirado = $fila_alu['bool_ar'];
	//------------------------------------------------------------------------------
	// CONSULTA EN TABLA PROMOCION
	//------------------------------------------------------------------------------
	$sql_promo = "select * from promocion where rut_alumno = ".$alumno." and id_ano = ".$ano." and id_curso = ".$curso;
	$result_promo =@pg_Exec($conn,$sql_promo);
	$fila_promo = @pg_fetch_array($result_promo,0);		
	//------------------------------------------------------------------------------
	$sql_ramos = "select ramo.id_ramo, ramo.conex, ramo.modo_eval, ramo.cod_subsector from ramo, tiene$nro_ano ";
	$sql_ramos = $sql_ramos . "where ramo.id_curso = ".$curso." and tiene$nro_ano.rut_alumno = ".$alumno." ";
	$sql_ramos = $sql_ramos . "and tiene$nro_ano.id_ramo = ramo.id_ramo and ramo.bool_ip = 1 ";
	//zecho $sql_ramos."<br>";
	$result_ramos =@pg_Exec($conn,$sql_ramos);
	$cont_ramos = @pg_numrows($result_alu);
	//------------------------------------------------------------------------------	
	$promedio_general = 0;
	$contador_general = 0;
	for($cont_sub=0 ; $cont_sub < $cont_ramos ; $cont_sub++)
	{
		$fila_ramos = @pg_fetch_array($result_ramos,$cont_sub);
		$ramo = $fila_ramos['id_ramo'];
		$examen = $fila_ramos['conex']; // 1 SI 2 NO
		$modo_eval = $fila_ramos['modo_eval'];
		$subsector = $fila_ramos['cod_subsector'];
		if ($examen == 2){
			$sql_notas = "select promedio from notas$nro_ano where rut_alumno = ".$alumno." and id_ramo = ".$ramo;
			$result_notas =@pg_Exec($conn,$sql_notas);
			$cont_notas = @pg_numrows($result_notas);
			//------------------------------------------------------------------------------	
			$promedio_general_par = 0;
			$contador_general_par = 0;
			for($cont_pro=0 ; $cont_pro < $cont_notas ; $cont_pro++)
			{
				$fila_notas = @pg_fetch_array($result_notas,$cont_pro);
				if ($modo_eval ==1 and $subsector <> 13){
					if ($fila_notas['promedio']>0){
						$promedio_general_par = $promedio_general_par + $fila_notas['promedio'];
						$contador_general_par = $contador_general_par + 1;
					}
				} 
			}
			if ($promedio_general_par>0){
				$promedio_general = $promedio_general + Promediar($promedio_general_par, $contador_general_par,$truncado_per);
				$contador_general = $contador_general + 1;
			}else{
				$promedio_general_par = "&nbsp;";			
			}
		}else{
			$sql_notas = "select nota_final as promedio from situacion_final where rut_alumno = ".$alumno." and id_ramo = ".$ramo;
			$result_notas =@pg_Exec($conn,$sql_notas);
			$cont_notas = @pg_numrows($result_notas);
			//------------------------------------------------------------------------------	
			for($cont_pro=0 ; $cont_pro < $cont_notas ; $cont_pro++)
			{
				$fila_notas = @pg_fetch_array($result_notas,$cont_pro);
				if ($modo_eval ==1 and $subsector <> 13){
					if ($fila_notas['promedio']>0){
						$promedio_general = $promedio_general + $fila_notas['promedio'];
						$contador_general = $contador_general + 1;
					}
				} 
			}			
		}
	}
	
//	echo $promedio_general."<br>";
//	echo $contador_general."<br>";

	
	if ($promedio_general>0)

		if ($_INSTIT=="1989"){
			$promedio_general2 = Promediar($promedio_general, $contador_general,1);
			$promedio_general=promedia_aleman($promedio_general, $contador_general);

			
		}else{
	
				$promedio_general2=Promediar($promedio_general, $contador_general,1);
		 		$promedio_general = Promediar($promedio_general, $contador_general,1);
			if ($_INSTIT=="1517"){
				$promedio_general=sube_punto_nuevo($promedio_general);
			}
		}
	else
		$promedio_general = "&nbsp;";
	//------------------------------------------------------------------------------
	// ASISTENCIA
	//------------------------------------------------------------------------------	
	$sql_asis = "select count(*) as cantidad from asistencia where asistencia.rut_alumno = ".$alumno." and ano = ".$ano;
	$result_asis = @pg_Exec($conn,$sql_asis);
	$fila_asis = @pg_fetch_array($result_asis,0);	
	$asistencia = $habiles - $fila_asis['cantidad'];	
	/*if ($promedio_general>0)
		$asistencia = round(($asistencia * 100)/$habiles,0);
	else
		$asistencia = "&nbsp;";*/
	//------------- CAMBIO PARA ASIETNCIA EN PROMOCION DE LA PREBASICA --------------
	if ($promedio_general>0){
		$asistencia = round(($asistencia * 100)/$habiles,0);
	}else{
		if($ensenanza==10)
			$asistencia = round(($asistencia * 100)/$habiles,0);	
		else
			$asistencia = "&nbsp;";
	}
	//------------------------------------------------------------------------------		
?>  
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=1><strong><? echo $rut_alumno?></strong></FONT><font face="arial, geneva, helvetica" size="2" color="#ffffff"><strong><b>
      <INPUT TYPE="hidden" name="rut_alumno[<?php echo $cont_paginas; ?>]" value="<?php echo $alumno; ?>">
    </b></strong></font></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=1><strong><? echo substr($nombre_alu,0,25)?></strong></FONT><font face="arial, geneva, helvetica" size="2" color="#ffffff"><strong><b>
    </b></strong></font></td>
    <td align="center"><input type="text" name="nota_final[<?php echo $cont_paginas; ?>]" size="3" maxlength="2" value="<? echo trim($promedio_general)?>"> </td>
    <td align="center"><FONT face="arial, geneva, helvetica" size=1>
      <input type="text" name="asistencia[<?php echo $cont_paginas; ?>]" size="3" maxlength="3" value="<? echo trim($asistencia)?>">
      <strong>%</strong> </FONT></td>
    <td align="left">
	<select name="situacion_final[<?php echo $cont_paginas; ?>]" >
		 <? if(empty($fila_promo['situacion_final'])){?>
				 	<option value="1" selected>Aprobado</option>
		<? 	 }else{?>
		<option value="1" <? if($fila_promo['situacion_final']==1){?>selected <? } ?> >Aprobado</option>
		<? } ?>
		<option value="2" <? if($fila_promo['situacion_final']==2){?>selected <? } ?> >Reprobado</option>
		<? if($Retirado==1){ ?>
				<option value="3" selected>Retirado</option>
		<? }else{ ?>
		<option value="3" <? if($fila_promo['situacion_final']==3){?>selected <? } ?> >Retirado </option>	
		<? } ?>					
	</select>        
    <td align="left"><FONT face="arial, geneva, helvetica" size=1>
    <input type="text" name="observacion[<?php echo $cont_paginas; ?>]" size="25" maxlength="50" value="<? echo trim($fila_promo['observacion'])?>">
    </FONT>    
  </tr>
 <? }?>
</table>
<font face="arial, geneva, helvetica" size="2" color="#ffffff"><strong><b>
<INPUT TYPE="hidden" name="contalum" value="<?php echo $cont_alumnos; ?>">
</b></strong></font>
</form>
</center>
</body>
</html>
