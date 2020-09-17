<?php 
require('../../../../../util/header.inc');
//include"../Coneccion/conexion.php";

$ano		= $_ANO;
$alumno		= $cmb_alumno;
$institucion= $_INSTIT;
$curso		= $cmb_curso;
$_POSP = 5;
$_bot = 8;

//if ($c_alumno==0)
 //exit;

	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	if(!$resultDIR){
	   echo "error".$qryDIR;
	   exit;
	   }
	$filaDIR=@pg_fetch_array($resultDIR);
/*
	//$sqlPeriodo="select nombre_periodo from periodo where id_ano=".$filaAno['id_ano']." order by nombre_periodo asc";
	$sqlPeriodo="select nombre_periodo, id_periodo from periodo where id_ano=".$ano." order by nombre_periodo asc";
	$resultPeriodo=@pg_exec($conn, $sqlPeriodo);
	$filaPeriodo=@pg_fetch_array($resultPeriodo,0);


	 //$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$filaAno['id_ano']." and matricula.id_curso=curso.id_curso";
	$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
	$resultMatri=@pg_exec($conn,$sqlMatri);
	$filaMatri=@pg_fetch_array($resultMatri,0);
			if($filaMatri['grado_curso']==1) $gr="pa";
			if($filaMatri['grado_curso']==2) $gr="sa";
			if($filaMatri['grado_curso']==3) $gr="ta";
			if($filaMatri['grado_curso']==4) $gr="cu";
			if($filaMatri['grado_curso']==5) $gr="qu";
			if($filaMatri['grado_curso']==6) $gr="sx";
			if($filaMatri['grado_curso']==7) $gr="sp";
			if($filaMatri['grado_curso']==8) $gr="oc";

	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	
	$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno='".$alumno."'";
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno,0);
*/	
	
/*	
	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$filaMatri['id_curso'];
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	$Curso = $filaCurso['grado_curso'];
	$letra = $filaCurso['letra_curso'];
	$ensenanza = $filaCurso['ensenanza'];
*/	
/*	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
*/	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
/*	
	$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$filaMatri['id_curso'];
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);
*/	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
/*	$sqlTraeApo_Alum="SELECT * FROM tiene2 WHERE rut_alumno='".$alumno."'";
	$resultApo_Alum=@pg_Exec($conn, $sqlTraeApo_Alum);
	$filaApo_Alum=@pg_fetch_array($resultApo_Alum,0);
	$rut_apo = $filaApo_Alum['rut_apo'];
*/	
	$sqlTraeApo="SELECT * FROM apoderado WHERE rut_apo='".$rut_apo."'";
	$resultApo=@pg_Exec($conn, $sqlTraeApo);
	$filaApo=@pg_fetch_array($resultApo,0);
	$nombre_apo = $filaApo['nombre_apo'];
	$ape_pat_apo = $filaApo['ape_pat'];
	$ape_mat_apo = $filaApo['ape_mat'];

/*	$sql = "select  * from periodo where id_ano = ".$ano." and id_periodo = ".$filaPeriodo['id_periodo']." order by id_periodo" ;
	$result1 =@pg_Exec($conn,$sql);
	if (!$result1) 
	{
	  error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
	}
	else
	{
		if (pg_numrows($result1)!=0)
		{
		  $fila1 = @pg_fetch_array($result1,0);	
		  if (!$fila1)
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
			  exit();
		  }
	  	}
	}


		   for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
			$fila1 = @pg_fetch_array($result1,$i);
				if (empty($fila1['fecha_inicio']) or empty($fila1['fecha_termino']))
				{
					?><div align="center"><?
				    echo ('<b> DEBE INGRESAR FECHAS Y DIAS HÁBILES PARA PERÍODOS </b> <br> Debe <a href="../../ano/periodo/listarPeriodo.php3" target="_parent">ir a Periodos</a>  e ingresar la información requerida...  <br>  <br> ');
				?>
							 	
				</div>	
				<?
				exit;
				}	
				$id_periodo = $fila1['id_periodo'];
				$dias_habiles = $fila1['dias_habiles'];
				$fecha_ini = $fila1['fecha_inicio'];
				$fecha_fin = $fila1['fecha_termino'];
				//--
				$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = '".$alumno."' and ano = ".$ano." and id_curso = ".$filaMatri['id_curso']." and fecha >= '" . $fecha_ini ."' and fecha <= '" . $fecha_fin . "'";
				$result13 =@pg_Exec($conn,$sql13);
				if (!$result13) 
				{
				  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
				}
				else
				{
					if (pg_numrows($result13)!=0)
					{
					  $fila13 = @pg_fetch_array($result13,0);	
					  if (!$fila13)
					  {
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
						}
					}
				}
				$inasistencia = $fila13['cantidad'];
				$dias_asistidos = $dias_habiles - $fila13['cantidad'];
}
*/





if($cb_ok!="Buscar"){
 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Personal_development_$fecha_actual.xls"); 	 
}	


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!-- <link href="../../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">  -->
<style type="text/css">
<!--
.Estilo2 {
	font-size: 9px;
	font-weight: bold;
}
.style4 {font-family: "Times New Roman", Times, serif}
-->
</style>
</head>

<body target="mainFrame">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'rpt18.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
		
		function exportar(){
			window.location='printrpt18.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			return false;
		  }
									
</script>



<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<div id="capa0">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
      <td> <div align="right">
          <input 		name="cmdimprimiroriginal" 		type="button" 		class="botonXX" 		id="cmdimprimiroriginal" 		onclick="imprimir1();" 		value="Imprimir"> 
		 <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
			<? }?>  
		  
		         </div></td>
  </tr>
</table>
</div>


<script>
//document.getElementById("capa4").style.display='none';

function imprimir1() 
{
	document.getElementById("capa0").style.display='none';
	//document.getElementById("capa2").style.display='none';
	//document.getElementById("capa4").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
	//document.getElementById("capa2").style.display='block';
	//document.getElementById("capa4").style.display='block';
	
}
function imprimir2() 
{
	document.getElementById("capa0").style.display='none';
	//document.getElementById("capa1").style.display='none';
	
	window.print();
	document.getElementById("capa0").style.display='block';
	//document.getElementById("capa1").style.display='block';
	//document.getElementById("capa4").style.display='none'; 
	//if
}
</script>
<?
 	if (empty($cmb_alumno))
			$sql_alu="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.id_curso='".$curso."' and matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
	else
			$sql_alu="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
		
	$result_alu =@pg_Exec($conn,$sql_alu);
	$cont_alumnos = @pg_numrows($result_alu);
	
	
	

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
{
	$filaMatri = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $filaMatri['rut_alumno'] ;
			
			if($filaMatri['grado_curso']==1) $gr="pa";
			if($filaMatri['grado_curso']==2) $gr="sa";
			if($filaMatri['grado_curso']==3) $gr="ta";
			if($filaMatri['grado_curso']==4) $gr="cu";
			if($filaMatri['grado_curso']==5) $gr="qu";
			if($filaMatri['grado_curso']==6) $gr="sx";
			if($filaMatri['grado_curso']==7) $gr="sp";
			if($filaMatri['grado_curso']==8) $gr="oc";
			
	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
		
	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$filaMatri['id_curso'];
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	$Curso = $filaCurso['grado_curso'];
	$letra = $filaCurso['letra_curso'];
	$ensenanza = $filaCurso['ensenanza'];
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$filaMatri['id_curso'];
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);
	
	$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno='".$alumno."'";
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno,0);
	
	$sqlPeriodo="select nombre_periodo, id_periodo from periodo where id_ano=".$ano." order by nombre_periodo asc";
	$resultPeriodo=@pg_exec($conn, $sqlPeriodo);
	$filaPeriodo=@pg_fetch_array($resultPeriodo,0);

	$sql = "select  * from periodo where id_ano = ".$ano." and id_periodo = ".$filaPeriodo['id_periodo']." order by id_periodo" ;
	$result1 =@pg_Exec($conn,$sql);
	if (!$result1) 
	{
	  error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
	}
	else
	{
		if (pg_numrows($result1)!=0)
		{
		  $fila1 = @pg_fetch_array($result1,0);	
		  if (!$fila1)
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
			  exit();
		  }
	  	}
	}


		   for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
			$fila1 = @pg_fetch_array($result1,$i);
				if (empty($fila1['fecha_inicio']) or empty($fila1['fecha_termino']))
				{
					?><div align="center"><?
				    echo ('<b> DEBE INGRESAR FECHAS Y DIAS HÁBILES PARA PERÍODOS </b> <br> Debe <a href="../../ano/periodo/listarPeriodo.php3" target="_parent">ir a Periodos</a>  e ingresar la información requerida...  <br>  <br> ');
				?>
							 	
				</div>	
				<?
				exit;
				}	
				$id_periodo = $fila1['id_periodo'];
				$dias_habiles = $fila1['dias_habiles'];
				$fecha_ini = $fila1['fecha_inicio'];
				$fecha_fin = $fila1['fecha_termino'];
				//--
				$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = '".$alumno."' and ano = ".$ano." and id_curso = ".$filaMatri['id_curso']." and fecha >= '" . $fecha_ini ."' and fecha <= '" . $fecha_fin . "'";
				$result13 =@pg_Exec($conn,$sql13);
				if (!$result13) 
				{
				  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
				}
				else
				{
					if (pg_numrows($result13)!=0)
					{
					  $fila13 = @pg_fetch_array($result13,0);	
					  if (!$fila13)
					  {
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
						}
					}
				}
				$inasistencia = $fila13['cantidad'];
				$dias_asistidos = $dias_habiles - $fila13['cantidad'];
}


	
?>
<form action="proceso_informe.php" method="post">
<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br>";
			   
  }  ?>


<table width="650" border="0" align="center">
  <tr> 
    <td>
	<table width="650" border="0">
        <tr> 
          <td colspan="4">
<!--div id="capa0">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> 
	<input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="botonZ" 
		id="cmdimprimiroriginal" 
		onclick="imprimir1();" 
		value="Imprimir parte1">
		 <input 
		name="cmdimprimiroriginal2" 
		type="button" 
		class="botonZ" 
		id="cmdimprimiroriginal2" 
		onclick="imprimir2();" 
		value="Imprimir parte2"> 
	</td>
  </tr>
</table>
</div-->
</td>
        </tr>
<!--        <tr align="center" bgcolor="#003b85"> 
            <td colspan="4"></td>
        </tr> -->
      </table>
<br>	  
	  <div id="capa1">
		<table width="649" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3" color="#000000">PERSONAL DEVELOPMENT</font></strong></div></td>
			  </tr>
              <tr>	
                <td>
<? 					if( trim($filaPeriodo['nombre_periodo'])=='PRIMER SEMESTRE' )
						$nom_periodo='First Semester'; 
					if( trim($filaPeriodo['nombre_periodo'])=='SEGUNDO SEMESTRE' )
						$nom_periodo='Second Semester'; 
					if( trim($filaPeriodo['nombre_periodo'])=='PRIMER TRIMESTRE' )
						$nom_periodo='First Trimester'; 
					if( trim($filaPeriodo['nombre_periodo'])=='SEGUNDO TRIMESTRE' )
						$nom_periodo='Second Trimester'; 
					if( trim($filaPeriodo['nombre_periodo'])=='TERCER TRIMESTRE' )
						$nom_periodo='Third Trimester'; 
					?>
					<div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000000"><? echo ucwords(strtoupper($nom_periodo.", ".$nro_ano))?></font></div>
				</td>
                </tr>
				<tr><td>&nbsp;</td></tr>
            </table>

		  
          <table width="630" border="0">
              <tr>
                <td width="60"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Name</strong></font></div></td>
                <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td width="300"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(trim($filaAlumno['nombre_alu']) . " " . trim($filaAlumno['ape_pat']) . " " . trim($filaAlumno['ape_mat'])); $nombre_alumno = ucwords(trim($filaAlumno['nombre_alu']) . " " . trim($filaAlumno['ape_pat']) . " " . trim($filaAlumno['ape_mat']));?></font></div></td>
                </tr>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Teacher</strong></font></div></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
<?					echo ucwords(trim($filaProfe['nombre_emp'])." ".trim($filaProfe['ape_pat'])." ".trim($filaProfe['ape_mat']));
					$nombre_profe = ucwords(trim($filaProfe['nombre_emp']) . " " . trim($filaProfe['ape_pat']) . " " . trim($filaProfe['ape_mat']));	?>
					</font></div></td>
				<td>&nbsp;</td>
				<td width="40"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Class</strong></font></div></td>
				<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
				<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					<? 
						if($Curso==5 and $ensenanza==10)	
							echo " Kinder";
						else if($Curso==4 and $ensenanza==10)	
							echo " Pre-Kinder";
						else if($Curso==3 and $ensenanza==10)	
							echo " Playgroup";
						else if($Curso==1)	
							echo " First";
						else if($Curso==2)	
							echo " Second";
						else if($Curso==3)	
							echo " Third";
						else if($Curso==4)	
							echo " Quarter";
						else if($Curso==5)	
							echo " Fifth";
						else if($Curso==6)	
							echo " Sixth";
						else if($Curso==7)	
							echo " Seventh";
						else if($Curso==8)	
							echo "Eighth";


						echo "&nbsp;Grade ".$letra." ";	
					?>
					</font></div></td>
                </tr>
            </table> 

<!-- asistencia -->
<br>
		<font size="1" face="Arial, Helvetica, sans-serif"><strong>ATTENDANCE</strong></font>
		<table width="630" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">
		  <tr>
			<td width="210"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Days Presents : &nbsp;<? echo $dias_asistidos ?></strong></font></td>
			<td width="210"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Days Absents : &nbsp;<? echo $inasistencia ?> </strong></font></td>
			<td width="210"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Average : &nbsp;
<!--			 </strong></font></td>
		  </tr>
		  <tr>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIAS (%)</strong></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">-->
			  <? 
					if ($dias_habiles>0)
					{
						$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
						$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
						$prom_cont_asis = $prom_cont_asis + 1;
					}
					echo $promedio_asistencia . "%" ;
					?>
			</font></td></tr>
<!--			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATRASOS</strong></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">
-->			<?
/*			$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= '" . $fecha_ini ."' and fecha <= '" . $fecha_fin . "')";
			$result_atraso =@pg_Exec($conn,$sql_atraso);
			$fila_atraso = @pg_fetch_array($result_atraso,0);
			if (empty($fila_atraso['cantidad']))
				echo "0";
			else
				echo $fila_atraso['cantidad'];
*/			?>
<!--			</font></td>
		  </tr>
-->		  
		</table>
<br>
<!-- hasta aca nuevo -->




          <table width="630" border="1" bordercolor="#000000" cellpadding="0" cellspacing="0">
  
  			<tr><td>&nbsp;</td>
        <?php 
//						echo "<tr><td></td>";
						for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE") $per="1 Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE") $per="3 Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE") $per="1 Sem.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE") $per="2 Sem.";		?>
							<td align="center"><font size=1 face=Arial, Helvetica, sans-serif><? echo $per; ?></font></td>
<?						} 	?>
						</tr>
<?	     		$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
	     			$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					
					


					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);	
						$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
						$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
						$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, 0);		
						
						if (($filaTraeArea['id_area'])==1712){
								echo "<H1 class=SaltoDePagina></H1>";
						   } ?>

						<tr>
<!--							<td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif><strong><? //echo $filaTraeArea['nombre'];?>&nbsp;/&nbsp;<? //echo $filaTraeSubarea['nombre'];?> </strong></font></td> -->
							<td valign=bottom><font size=2 face=Arial, Helvetica, sans-serif><strong><? echo $filaTraeArea['nombre'];?>&nbsp;</strong></font></td>
<!-- repetir la cantidad de periodos k existan -->	
<?						for($blanco=0 ; $blanco<@pg_numrows($resultPeriodo) ; $blanco++){	?>
							<td valign=bottom><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td>
<?						}	?>
						</tr>
<?						
							for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
								$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);	

									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
									$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea'];
									$resultTraeItem=@pg_Exec($conn, $sqlTraeItem);
									
									for($countItem=0 ; $countItem<@pg_numrows($resultTraeItem) ; $countItem++){
										$countI++;
										$filaTraeItem=@pg_fetch_array($resultTraeItem, $countItem);
										//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
										
										if($countItem%2==0){
											$color="#CDCDCD";
										}else{
											$color="#B5B5B5";
										}
?>									<tr>
										<td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif><? echo $filaTraeItem['glosa'];?></font></td>
<?												if($filaTraeItem['tipo']==0){
												   $sqlP="select * from periodo where id_ano=".$ano." order by id_periodo";
												   $resultP=@pg_Exec($conn, $sqlP);
	 											   for($countEval=0 ; $countEval<pg_numrows($resultP) ; $countEval++){
 													   $filaP=@pg_fetch_array($resultP,$countEval);
														$sqlTraeEval="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']."and periodo.id_periodo='".$filaP['id_periodo']."' and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo";
														$resultEval=@pg_Exec($conn, $sqlTraeEval);
														$filaEval=@pg_fetch_array($resultEval,0);
														$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
														$resultConc=@pg_Exec($conn, $sqlTraeConc);
														$filaConc=@pg_fetch_array($resultConc,0);
?>														<td valign=bottom>&nbsp;&nbsp;<font size=1 face=Arial, Helvetica, sans-serif><? echo $filaConc['sigla'];?></font></td>
<?
													}
												}else if($filaTraeItem['tipo']==2){
													$sqlTraeEvalu="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
													$resultEvalu=@pg_Exec($conn, $sqlTraeEvalu);
													for($countEvalu=0 ; $countEvalu<pg_numrows($resultEvalu) ; $countEvalu++){
														$filaEvalu=@pg_fetch_array($resultEvalu,$countEvalu);
?>
														<tr>
															<td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalu['nombre_periodo'];?>:&nbsp;&nbsp;<? echo $filaEvalu['text'];?></font></td>
														</tr>
														<tr>
															<td>&nbsp;</td>
														</tr> 
<?
													}
												}else if($filaTraeItem['tipo']==1){
													$sqlTraeEvalua="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
													$resultEvalua=@pg_Exec($conn, $sqlTraeEvalua);
													for($countEvalua=0 ; $countEvalua<pg_numrows($resultEvalua) ; $countEvalua++){
														$filaEvalua=@pg_fetch_array($resultEvalua,$countEvalua);
														if(($filaEvalua['radio']==0) and ($filaEvalua['radio']!="")){	?>
																<tr>
																	<td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;No</font></td>
																</tr>
																<tr><td>&nbsp;</td></tr>
<?														}else if($filaEvalua['radio']==1){	?>
															<tr><td valign=bottom>
															<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;Si</font></td></tr>
															<tr><td>&nbsp;</td></tr>
<?
														}
													}
												}
											
									}//fin for($countItem....
									
							}//fin for($countSubarea....
							
					}//fin for($countArea....
									
	
		  ?>
		  <input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
		  <input name="alumno" type="hidden" value="<?php echo $alumno?>">
      </table>

<!--/div-->
	  <!--/td>
	  </tr>
	  </table-->
        <table width="630" border="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>

<!--		</div> -->
          <?
	//echo "<H1 class=SaltoDePagina></H1>";
 			?>
		<!--div id="capa2"-->
        <table width="630" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="16"><div align="left"><strong><font size="1" face="Arial, Helvetica, sans-serif" color="#000000">Teacher's Comments and Action Plan:</font></strong></div></td>
		  </tr>
      </table>
        <table width="630" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<?php 
			$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
			$resultObs=@pg_Exec($conn, $sqlTraeObs);
			for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
  				$filaObs=@pg_fetch_array($resultObs, $countObs); ?>
				<tr>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaObs['observaciones'];?></font></td>
				</tr>
<?		}	?>
      </table>
        <table width="630" border="0">
        <tr> <td>&nbsp;</td> </tr>
        <tr> <td>&nbsp;</td> </tr>
        <tr> <td>&nbsp;</td> </tr>
        <tr>
          <td align="right"><font size="2" face="Arial, Helvetica, sans-serif">
            <input type="hidden" name="fecha">
			<input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
			<input type="hidden" name="grado" value="<?php echo $grado ?>">
			<!--input type="hidden" name="periodo" value="<?php //echo $periodo ?>"-->
            </font></td>
        </tr>
      </table>
<br>
      <table width="630" border="0">
        <tr align="center"> 
            <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">_____________________________________________</font></td>
	        <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">_____________________________________________</font></td>
        </tr>
        <tr align="center"> 
            <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">Teacher's Signature</font></td>
	        <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">Tutor's Signature</font></td>
        </tr>
      </table>
      <table width="630" border="0">
        <tr> 
          <td width="45%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</strong></font></td>
<!-- AKI DEBE IR EL APODERADO, NO EL DIRECTOR     -->
  		  <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $nombre_apo." ".$ape_pat_apo." ".$ape_mat_apo;?>&nbsp;</strong></font></td>
		</tr>
      </table>
<br>

	<table width="630" border="1" bordercolor="#000000" cellpadding="0" cellspacing="0">
        <?php 
			$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
			$resultConc=@pg_Exec($conn, $sqlConc);	?>
		<tr>		
<?			for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
				$filaConc=@pg_fetch_array($resultConc,$countConc);
				$glosa = split("/",$filaConc['glosa']);
 				$glosa_ingles = $glosa[0];
				$glosa_espanol = $glosa[1];	?>
				<td><strong><font size=1 face=Arial, Helvetica, sans-serif><? echo $filaConc['sigla'];?></font></strong></td>
								<td><font size=1 face=Arial, Helvetica, sans-serif><? echo "".$filaConc['nombre']?></font></td>
				<!--td><font size=1 face=Arial, Helvetica, sans-serif><? echo "".$filaConc['nombre'].", ".$glosa_ingles."";?><br><? echo $glosa_espanol;?></font></td-->
<?				if(($countConc%2)==1){	?>
					</tr><tr>
<?				}
			}	?>
		</tr>
	</table>
	  </div></td>
  </tr>
</table>


 <? 
	  if  (($cont_alumnos - $cont_paginas)<>1) 
		echo "<H1 class=SaltoDePagina></H1>";
  }

?>
</form>

<!-- FIN CUERPO DE LA PAGINA -->
<? unset($xls);?>
</body>
</html>
