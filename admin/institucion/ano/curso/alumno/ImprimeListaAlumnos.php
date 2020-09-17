<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	if (trim($_url)=="") $_url=0;
?>

<script>
	function Imprime(){
		window.print();
		window.close();
	}
	
</script>
<html>
	<head>
	</head>
	<title>Reportes Web</title>
	<body>
	<?
	//------------------------------------------
	// 				DATOS CABECERA
	//------------------------------------------	
	$sql = "SELECT institucion.nombre_instit, ano_escolar.nro_ano, curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo ";
	$sql = $sql . "FROM institucion, ano_escolar, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.")); ";
	
	$result =@pg_Exec($conn,$sql);
	if (!$result) 
	{
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}
	else
	{
		if (pg_numrows($result)!=0)
		{
			$fila = @pg_fetch_array($result,0);	
			if (!$fila)
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}
		}
	}
	//------------------------------------------------------
	// 				DETALLE REPORTE CON NUMERO DE LISTA
	//------------------------------------------------------
	$sql = "SELECT alumno.telefono,alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.fecha_nac, alumno.calle, alumno.nro, alumno.depto, alumno.block, alumno.villa, comuna.nom_com, provincia.nom_pro, region.nom_reg, matricula.fecha, matricula.nro_lista ";
	$sql = $sql . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg)) INNER JOIN region ON alumno.region = region.cod_reg ";
	$sql = $sql . "WHERE (((matricula.rdb)=".$institucion.") AND ((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) AND nro_lista is not NULL ";
	$sql = $sql . "ORDER BY nro_lista asc; " ;
	$result1 =@pg_Exec($conn,$sql);
	if (!$result1) 
	{
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}
	else
	{
		if (pg_numrows($result1)!=0)
		{
			$fila1 = @pg_fetch_array($result1,0);	
			if (!$fila1)
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}
		}
	}

	//----------------------------------------------------
	// 				DETALLE REPORTE SIN NUMERO DE LISTA
	//----------------------------------------------------
	$sql2 = "SELECT alumno.telefono,alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.fecha_nac, alumno.calle, alumno.nro, alumno.depto, alumno.block, alumno.villa, comuna.nom_com, provincia.nom_pro, region.nom_reg, matricula.fecha, matricula.nro_lista ";
	$sql2 = $sql2 . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg)) INNER JOIN region ON alumno.region = region.cod_reg ";
	$sql2 = $sql2 . "WHERE (((matricula.rdb)=".$institucion.") AND ((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) AND nro_lista is NULL ";
	$sql2 = $sql2 . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu asc " ;
		
	$result2 =@pg_Exec($conn,$sql2);
	if (!$result2) 
	{
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}
	else
	{
		if (pg_numrows($result2)!=0)
		{
			$fila2 = @pg_fetch_array($result2,0);	
			if (!$fila2)
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}
		}
	}



	?>
    <center>
      <table width="643" border="0">
        <tr>
          <td width="681" height="121"><table width="637" border="0">
		  	<tr>
              <td width="154" height="21"><?php
						$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
						$arr=@pg_fetch_array($result,0);

						$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
						$retrieve_result = @pg_exec($conn,$output);
						
					?><img src=../../../../../../../tmp/<?php echo $institucion ?> ALT="NO DISPONIBLE"  width=131 height="144"></td>
              <td width="18"></td>
              <td width="451"><table width="443" border="0">
     			<tr>
				  <td width="143" ><font face="arial, geneva, helvetica" size="3"><strong>INSTITUCI&Oacute;N</strong></font></td>
				  <td width="8" ><font face="arial, geneva, helvetica" size="3"><strong>:</strong></font></td>
				  <td width="270" ><font face="arial, geneva, helvetica" size="3"><? echo trim($fila['nombre_instit']) ?></font></td>
				</tr>
				<tr>
				  <td><font face="arial, geneva, helvetica" size="3"><strong>A&Ntilde;O ESCOLAR</strong></font></td>
				  <td><font face="arial, geneva, helvetica" size="3"><strong>:</strong></font></td>
				  <td ><font face="arial, geneva, helvetica" size="3"><? echo trim($fila['nro_ano']) ?> </font></td>
				</tr>
				<tr>
				  <td><font face="arial, geneva, helvetica" size="3"><strong>CURSO</strong></font></td>
				  <td><font face="arial, geneva, helvetica" size="3"><strong>:</strong></font></td>
				  <td ><font face="arial, geneva, helvetica" size="3"><? 
				   if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "PRIMER NIVEL"." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
							}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
								echo "PRIMER CICLO"." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
							}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
								echo "SALA CUNA"." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
							}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "SEGUNDO NIVEL"." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
								echo "SEGUNDO CICLO";
							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
								echo "NIVEL MEDIO MENOR"." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
							}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "TERCER NIVEL"." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
							}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
								echo "NIVEL MEDIO MAYOR"." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
								echo "TRANSICIÓN 1er NIVEL"." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
							}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
								echo "TRANSICIÓN 2do NIVEL"." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
							}else{
								echo $fila['grado_curso']." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
							}?></font></td>
				</tr>
              </table>
			  
			  </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="637" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="7"><div align="center"><font face="arial, geneva, helvetica" size="4" > <strong>N&oacute;mina de Alumnos</strong></font></div></td>
            </tr>
            <tr>
              <td width="26"><font face="arial, geneva, helvetica" size="2"><strong>NºLista</strong></font></td>
              <td width="65"><font face="arial, geneva, helvetica" size="2"><strong>Rut</strong></font></td>
              <td width="200"><font face="arial, geneva, helvetica" size="2"><strong>Nombre Alumno</strong></font></td>
              <td width="72"><font face="arial, geneva, helvetica" size="2"><strong>Fecha Nacimiento</strong></font></td>
              <td width="200"><font face="arial, geneva, helvetica" size="2"><strong>Direcci&oacute;n</strong></font></td>
              <td width="65"><font face="arial, geneva, helvetica" size="2"><strong>Fecha Matrícula</strong></font></td>
			   <td width="65"><font face="arial, geneva, helvetica" size="2"><strong>Teléfono</strong></font></td>
            </tr>
            <tr>
              <?
			for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
			$fila1 = @pg_fetch_array($result1,$i);
			?>
              <td><center><font face="arial, geneva, helvetica" size="1"><? echo $fila1['nro_lista']; ?></font></center></td>
              <td><font face="arial, geneva, helvetica" size="1"><? echo $fila1['rut_alumno'] . "-" . $fila1['dig_rut']; ?></font></td>
              <td><font face="arial, geneva, helvetica" size="1"><? echo strtoupper(trim($fila1['ape_pat']) . " " . trim($fila1['ape_mat'] . " " . trim($fila1['nombre_alu']))); ?></font></td>
              <td><font face="arial, geneva, helvetica" size="1"><? echo trim(Cfecha2($fila1['fecha_nac'])) ?></font></td>
              <td><font face="arial, geneva, helvetica" size="1"><? 
			  	if($fila1['depto']!=''){
					  echo strtoupper(trim($fila1['calle']) . " " . trim($fila1['nro']) . " depto" . " ".  trim($fila1['depto']) . " ". trim($fila1['nom_com']));
				}else{
				  	  echo strtoupper(trim($fila1['calle']) . " " . trim($fila1['nro']) . " ". trim($fila1['nom_com']));
					 
				}	
					 ?>
					  
					  </font></td>
					  
              <td><font face="arial, geneva, helvetica" size="1"><? echo trim(Cfecha2($fila1['fecha'])) ?></font></td>
			  <td><font face="arial, geneva, helvetica" size="1"><? echo trim($fila1['telefono']) ?></font></td>
            </tr>
            <? } ?>


              <?
			for($i=0 ; $i < @pg_numrows($result2) ; $i++)
			{
			$fila2 = @pg_fetch_array($result2,$i);
			?>
              <td><center><font face="arial, geneva, helvetica" size="1"><? echo $fila2['nro_lista']; ?></font></center></td>
              <td><font face="arial, geneva, helvetica" size="1"><? echo $fila2['rut_alumno'] . "-" . $fila2['dig_rut']; ?></font></td>
              <td><font face="arial, geneva, helvetica" size="1"><? echo strtoupper(trim($fila2['ape_pat']) . " " . trim($fila2['ape_mat'] . " " . trim($fila2['nombre_alu']))); ?></font></td>
              <td><font face="arial, geneva, helvetica" size="1"><? echo trim(Cfecha2($fila2['fecha_nac'])) ?></font></td>
              <td><font face="arial, geneva, helvetica" size="1"><? 
			  	if($fila2['depto']!=""){
					  echo strtoupper(trim($fila2['calle']) . " " . trim($fila2['nro']) . " depto" . " ".  trim($fila2['depto']) . " ". trim($fila2['nom_com']));
				}else{
				  	  echo strtoupper(trim($fila2['calle']) . " " . trim($fila2['nro']) . " ". trim($fila2['nom_com']));
					 
				}	
					 ?>
					  
					  </font></td>
					  
              <td><font face="arial, geneva, helvetica" size="1"><? echo trim(Cfecha2($fila2['fecha'])) ?></font></td>
			  <td><font face="arial, geneva, helvetica" size="1"><? echo trim($fila2['telefono']) ?></font></td>
            </tr>
            <? } ?>





          </table></td>
        </tr>
      </table>
	  <script>
	  	Imprime()
	  </script>
    </center>
	<? pg_close($conn); ?>
	</body>	
</html>