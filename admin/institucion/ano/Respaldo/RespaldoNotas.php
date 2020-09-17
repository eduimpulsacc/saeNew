<?php require('../../../../util/header.inc');?>
<?
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$sw 			= 0;
	
	
	//if($_PERFIL==0){
	//	print_r($_GET);
	//	}
	
	
	
	//------------
//	echo $id_curso."<br>";
//	echo $id_periodo."<br>";
//	echo $id_ramo."<br>";
//	exit;
	//------------	
	$ls_string 		= ""		;
	$salto 			= "\n"		;
	$ls_espacio		= chr(9)	;
	//----------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];	
	//----------------
	$sqlPeri = "select * from periodo where id_ano = $ano and id_periodo = $id_periodo";
	$rsPeri =@pg_Exec($conn,$sqlPeri);
	$fPeri = @pg_fetch_array($rsPeri,0);
	$periodo = 	$fPeri['id_periodo'];
	$periodo_pal = $fPeri['nombre_periodo'];	
	//----------------
	$sqlCurso = "select * from curso where ensenanza > 109 and id_ano = $ano and id_curso = $id_curso";
	$rsCurso =@pg_Exec($conn,$sqlCurso);
	$fCurso = @pg_fetch_array($rsCurso,0);
	$curso = $fCurso['id_curso'];
	$curso_pal = CursoPalabra($curso, 0, $conn);	
	//----------------	

	if($id_ramo==0){
		
		 $sqlSub_todos = "select *
			from ramo 
			inner join subsector on ramo.cod_subsector=subsector.cod_subsector
			where id_curso = $curso";
		$rsSub_todos = @pg_Exec($conn,$sqlSub_todos);
		
		$fichero = fopen("Archivos/NOTAS".$nro_ano."-".$id_ramo."-".$id_periodo."-".$id_curso.".xls", "w"); 
		 $sw = 1;
	
	}
	else{
		
		$sqlSub = "select * from ramo 
		inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso = $curso and id_ramo = $id_ramo";
		$rsSub = @pg_Exec($conn,$sqlSub);
		$fSub = @pg_fetch_array($rsSub,0);
		$ramo = $fSub['id_ramo'];
		$subsector = $fSub['nombre'];
		
		
$fichero = fopen("Archivos/NOTAS".$nro_ano."-".$id_ramo."-".$id_periodo."-".$id_curso.".xls", "w"); 
	}

	//----------------					
	if($sw==1){
		$ls_string = $ls_string . "CURSO"  . "$ls_espacio";
		$ls_string = $ls_string . "RUT ALUMNO"  . "$ls_espacio";
		$ls_string = $ls_string . "NOMBRE ALUMNO"  . "$ls_espacio";
		$ls_string = $ls_string . "PERIODO" . "$ls_espacio";
		$ls_string = $ls_string . "SUBSECTOR" . "$ls_espacio";
		$ls_string = $ls_string . "DOCENTE" . "$ls_espacio";	
		$ls_string = $ls_string . "NOTA1"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA2"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA3"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA4"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA5"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA6"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA7"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA8"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA9"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA10"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA11"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA12"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA13"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA14"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA15"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA16"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA17"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA18"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA19"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA20"  . "$ls_espacio";
		$ls_string = $ls_string . "PROMEDIO"  ."$salto";
		
		@ fwrite($fichero,"$ls_string"); 

		for($k=0;$k<@pg_numrows($rsSub_todos);$k++){
			
			$fSub_todos = @pg_fetch_array($rsSub_todos,$k);
			$ramo_todos = $fSub_todos['id_ramo'];

			$sqlSub = "select ramo.id_ramo, subsector.nombre,e.nombre_emp ||' '||e.ape_pat ||' '|| e.ape_mat as nombre_emp from ramo 
		inner join subsector on ramo.cod_subsector=subsector.cod_subsector INNER JOIN dicta d ON d.id_ramo=ramo.id_ramo
			INNER JOIN empleado e ON e.rut_emp=d.rut_emp where id_curso =".$curso." and ramo.id_ramo = ".$ramo_todos;
			$rsSub = @pg_Exec($conn,$sqlSub);
			$fSub = @pg_fetch_array($rsSub,0);
			$ramo = $fSub['id_ramo'];
			$subsector = $fSub['nombre'];
			$docente = $fSub['nombre_emp'];

	 $sqlNotas = "select al.ape_pat ||' '|| al.ape_mat ||' '|| al.nombre_alu as nombre_al,su.nombre as nomsub,nt.* from notas".$nro_ano." nt
			inner join alumno al on nt.rut_alumno=al.rut_alumno
			inner join ramo r on nt.id_ramo=r.id_ramo
			inner join subsector su on r.cod_subsector=su.cod_subsector
			where nt.id_periodo=".$periodo." and nt.id_ramo=".$ramo;
			$rsNotas = @pg_Exec($conn,$sqlNotas);
			
			for($u=0 ; $u < @pg_numrows($rsNotas) ; $u++)
			{	
				$fNotas = @pg_fetch_array($rsNotas,$u);				
				$ls_string = trim($curso_pal)  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['rut_alumno'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nombre_al'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($periodo_pal) . "$ls_espacio";
				$ls_string = $ls_string . trim($subsector) . "$ls_espacio";	
				$ls_string = $ls_string . trim($docente) . "$ls_espacio";					
				$ls_string = $ls_string . trim($fNotas['nota1'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota2'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota3'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota4'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota5'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota6'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota7'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota8'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota9'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota10'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota11'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota12'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota13'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota14'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota15'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota16'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota17'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota18'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota19'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['nota20'])  . "$ls_espacio";
				$ls_string = $ls_string . trim($fNotas['promedio']). "$salto";					
				@ fwrite($fichero,"$ls_string"); 
			}
		}		// fin for k=0
	}
	else{
		$ls_string = $ls_string . "CURSO"  . "$ls_espacio";
		$ls_string = $ls_string . "PERIODO" . "$ls_espacio";
		$ls_string = $ls_string . "SUBSECTOR" . "$ls_espacio";	
		$ls_string = $ls_string . "RUT ALUMNO"  . "$ls_espacio";
		$ls_string = $ls_string . "NOMBRE ALUMNO"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA1"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA2"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA3"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA4"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA5"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA6"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA7"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA8"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA9"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA10"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA11"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA12"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA13"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA14"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA15"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA16"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA17"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA18"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA19"  . "$ls_espacio";
		$ls_string = $ls_string . "NOTA20"  . "$ls_espacio";
		$ls_string = $ls_string . "PROMEDIO"  ."$salto";
		
		@ fwrite($fichero,"$ls_string"); 
		
 $sqlNotas = "select al.ape_pat ||' '|| al.ape_mat ||' '|| al.nombre_alu as nombre_al,su.nombre as nomsub,nt.* from notas".$nro_ano." nt
inner join alumno al on nt.rut_alumno=al.rut_alumno
inner join ramo r on nt.id_ramo=r.id_ramo
inner join subsector su on r.cod_subsector=su.cod_subsector
where nt.id_periodo=".$periodo." and nt.id_ramo=".$id_ramo;
		$rsNotas = @pg_Exec($conn,$sqlNotas);
		for($u=0 ; $u < @pg_numrows($rsNotas) ; $u++)
		{	
			
			$fNotas = @pg_fetch_array($rsNotas,$u);				
			
			$ls_string = trim($curso_pal)  . "$ls_espacio";
			$ls_string = $ls_string . trim($periodo_pal) . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nomsub'])  . "$ls_espacio";	
			$ls_string = $ls_string . trim($fNotas['rut_alumno'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nombre_al'])  . "$ls_espacio";			
			$ls_string = $ls_string . trim($fNotas['nota1'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota2'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota3'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota4'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota5'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota6'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota7'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota8'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota9'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota10'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota11'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota12'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota13'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota14'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota15'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota16'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota17'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota18'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota19'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['nota20'])  . "$ls_espacio";
			$ls_string = $ls_string . trim($fNotas['promedio']). "$salto";					
			
			//echo $ls_string;
			
			@ fwrite($fichero,"$ls_string"); 
			
		}

	}	// fin else
	fclose($fichero); 
	
?>
<html>
<head>
<title>RESPALDO DE NOTAS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body >
<center>
  <table width="90%" height="172" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="71">
        <div align="right">
          <INPUT class = "botonXX"  TYPE="button" value="CERRAR" name=btnModificar  onClick=window.close()>
      </div></td>
    </tr>
    <tr height=30>
      <td height="25" class="tableindex">
        <div align="center">Respaldo de Notas desde Colegio Interactivo</div></td>
    </tr>
    <tr>
      <td>        <div align="center">
          <p>&nbsp;</p>
          <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo Notas del Colegio </font></strong></p>
          <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El archivo ha sido creado con el nombre de <a href='Archivos/NOTAS<? echo $nro_ano."-".$id_ramo."-".$id_periodo."-".$id_curso ?>.xls'> &quot;NOTAS<? echo $nro_ano."-".$id_ramo."-".$id_periodo."-".$id_curso ?>.xls&quot;</a> <br>
          </strong></font></p><br>
      </div></td>
    </tr>
    <tr>
      <td>
        <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para guardar el archivo en su PC Solo debe clickear con el boton derecho sobre el Link que esta en el nombre del archivo y elegir la opcion &quot;<strong>guardar destino como</strong>&quot; (Save Target As)</font></div></td>
    </tr>
  </table>
</center>
</body>
</html>
<? pg_close ($conn);?>