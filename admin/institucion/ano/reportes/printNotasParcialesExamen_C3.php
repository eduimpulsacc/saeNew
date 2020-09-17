<div align="center">
<?
 
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');


?>
<SCRIPT>
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
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->

function cerrar(){ 
	window.close() 
} 
</script>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	
	

	$sql = "select  * from periodo where id_ano = ".$ano." and id_periodo = ".$periodo." order by fecha_inicio" ;
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
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS PERIODO************/
	$ob_reporte ->ano=$ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	$fecha_ini = $ob_reporte->fecha_inicio;
	$fecha_fin = $ob_reporte->fecha_termino;
	
	$ob_reporte ->ano = $ano; 
	$resultPeri = $ob_reporte ->TotalPeriodo($conn);
	$num_periodos = @pg_numrows($resultPeri);
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";		
	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$ciudad = $fila_ins['nom_pro'];
	$fono = $fila_ins['telefono'];
	$direc = $fila_ins['calle'].$fila_ins['nro'];
	$region = $fila_ins['nom_reg'];
	$provincia = $fila_ins['nom_pro'];
	$comuna = $fila_ins['nom_com'];
	
	
		
	//-----------------------
	$sql = "select count(id_periodo) as num_periodos from periodo where id_ano = $ano";
	$resultPeri =@pg_Exec($conn,$sql);	
    $fila1Peri = @pg_fetch_array($resultPeri,0);		
	$num_periodos = $fila1Peri['num_periodos'];
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";	
	//-----------------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	//-----------------------

	function Nombre($paterno,$materno,$nombres){
		$Nombres = strtoupper($nombres." ".$paterno." ".$materno);
		echo $Nombres;
	}
	
	
	$q1 = "select * from trabaja where rdb = '".trim($institucion)."' and (cargo=1 OR cargo=23)";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	//echo "n1 es: $n1 <br>";
	
	$f1 = @pg_fetch_array($r1,0);
	$cargo = $f1['cargo'];
	//echo "c: $cargo <br>";
	
	if ($cargo==1){
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "Director(a)";
	}
	if ($cargo==23){
		$cargo_dir  = "rector(a)";
		$cargo_dir2 = "Rector(a)";
	}
	
	
	 
	
	
if($institucion == 770){		

		$sqlInstit="select * from institucion where rdb=".$institucion;
		$resultInstit=@pg_Exec($conn, $sqlInstit);
		$filaInstit=@pg_fetch_array($resultInstit);
		
		$sql_reg="select nom_reg from region where cod_reg =". $filaInstit['region'];
		$res_reg = pg_exec($conn, $sql_reg);
		$fila_reg = pg_fetch_array($res_reg);
		
		$sql_pro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro =".$filaInstit['ciudad'];
		$res_pro=pg_exec($conn, $sql_pro);
		$fila_pro = pg_fetch_array($res_pro);
		
		$sql_com="select nom_com from comuna where cod_reg=". $filaInstit['region'] ." and cor_pro =".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
		$res_com=pg_exec($conn, $sql_com);
		$fila_com = pg_fetch_array($res_com);	 

		$fecha = strftime("%d %m %Y");		
}				  


   if ($institucion==770){
	    // DATOS CURSO //
		//--------------------------------------------------------------------------	
		$sql_curso = "SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per ";
		$sql_curso = $sql_curso . "FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso."));";
		$result_curso = @pg_Exec($conn, $sql_curso);
		$fila_curso = @pg_fetch_array($result_curso ,0);
		$decreto_eval = $fila_curso['nombre_decreto_eval'];
		$planes = $fila_curso['nombre_decreto'];
		$truncado_per = $fila_curso['truncado_per'];
		//----------------------------------------------------------------------------
	}	

				  

if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Parciales_examen_alumno_$fecha_actual.xls"); 	 
}	 
				 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>&nbsp;</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 
</style>
 
<!-- CODIGO DE DISEÑO NUEVO -->
<script language="javascript" type="text/javascript">

		function exportar(){
			window.location='printNotasParcialesExamen_C.php?c_curso=<?=$curso?>&c_alumno=<?=$alumno?>&cmb_periodos=<?=$periodo?>&xls=1';
			return false;
		  }		  
		  
</script>

</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
							  
<form method="post" target="mainFrame" name="form">
<center>
<div id="capa0">

	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td>
		  <table width="650" align="center">
			<tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
			<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
			<? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
			<? }?>
			</td></tr></table>
	
	</td>
	  </tr>
	</table> 

</div>

<?
	if (empty($alumno))
		$sql_alu = "select * from matricula, alumno where id_curso =".$curso." and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno ='".$alumno."' and id_ano = ".$ano;
		
	$result_alu =@pg_Exec($conn,$sql_alu);
	$cont_alumnos = @pg_numrows($result_alu);
    
	
	//////// para sacar el profesor jefe /////////////
	
	$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result =@pg_Exec($conn,$sql4);
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
	if($institucion==770){
		$nombre_profe = ucwords(strtoupper(trim($fila['nombre_emp']) . " " . trim($fila['ape_pat']) . " " . trim($fila['ape_mat'])));
		$nombre_profesor = ucwords(strtoupper(trim($fila['nombre_emp']) . " " . trim($fila['ape_pat']) . " " . trim($fila['ape_mat'])));						
	}else{
		$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
		$nombre_profesor = ucwords(strtoupper(trim($fila['nombre_emp']) . " " . trim($fila['ape_pat']) . " " . trim($fila['ape_mat'])));				
	}					
	/////fin para sacar al profesor jefe /////////
	
	
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos; $cont_paginas++)
{
	$prome_general_pro = 0;
	$cont_general_pro = 0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$bool_ed = $fila_alu['bool_ed'];

	//---------------------------
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	
	
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];
	
	
			
if (($fila['ensenanza']>109 and $fila['ensenanza']<310) or ($fila['ensenanza']>300 and $fila['grado_curso']<3)){  
$cuenta_ramo=0;
$Prom_Gral=0; 
?>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
            <td width="100%">
			
			
		<? if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br><br><br><br>";
			   
		  }
		
		    ?>		
			
				<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
				  <? if ($institucion!="770"){ ?>
					<td width="114"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
					<td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
					<td width="361"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo strtoupper(trim($fila['nombre_instit'])) ?></font></div></td>			 
					<td width="161" rowspan="7" align="center" valign="top" >
					<?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					## código para tomar la insignia
			
				  if($institucion!=""){
					   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>		        </td>
			<? } ?>
				  <tr>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>AÑO ESCOLAR</strong></font></div></td>
					<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo trim($fila['nro_ano']) ?></font></div></td>
					</tr>
				  <tr>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>CURSO</strong></font></div></td>
					<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					<? 
					$Curso_pal = CursoPalabra($curso, 0, $conn);
					echo $Curso_pal; 
					?>
					</font></div></td>
					</tr>	
				  <tr>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>ALUMNO</strong></font></div></td>
					<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? if($institucion==8930){ Nombre($fila['ape_pat'],$fila['ape_mat'],$fila['nombre_alu']);}else{echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); }?></font></div></td>
					</tr>
				  <tr>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>PROFESOR JEFE</strong></font></div></td>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					<?
				    if($institucion==770){
		                 echo $nombre_profe;
					}else{
		                 echo $nombre_profe;
					}				
					?>
					</font></div></td>
					</tr>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td width="4" rowspan="5" align="center">&nbsp;</td>
				  </tr>		  
				</table>     </td>
      </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" class="tableindex"><div align="center">INFORME  DE NOTAS </div></td>
      </tr>
	   <?
	  if ($institucion==770){
	      ?>
		  <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluación Nº : ".$decreto_eval?></strong></font></div></td>
          </tr>
          <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas Nº : ".$planes?></strong></font></div></td>
          </tr>
   <? } ?>
      <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($fila1['nombre_periodo'] . "DEL " . $nro_ano))?></strong></font></div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td>
		<?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
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
				$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = '" . $alumno . "' and ano = ". $ano . " and id_curso = " . $curso . " and fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD')";
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
				//--
				$sql8 = "select count(*) as contador from notas$nro_ano where id_periodo = ". $id_periodo . " and rut_alumno = '" . $alumno."'";
			    $result18 =@pg_Exec($conn,$sql8);
			    if (!$result18) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			  	}
			    else
			  	{
				  	if (pg_numrows($result18)!=0)
				    {
				  	  $fila8 = @pg_fetch_array($result18,0);	
				  	  if (!$fila1)
				  	  {
					  	  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  	  exit();
					    }
				    }
			    }
				if ($fila8['contador']>0)
				{
				?>			
				<br>
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231" align="left">
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Subsector del Aprendizaje (Formaci&oacute;n General ) </strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></td>
			<? 
			$sql_p = "select  * from periodo where id_ano = ".$ano." order by fecha_inicio" ;
			$result_p = pg_Exec($conn,$sql_p);
			$fila_p = pg_num_rows($result_p);
			$p1 = pg_fetch_array($result_p,0);
			$p1=$p1['id_periodo'];
			$p2 = pg_fetch_array($result_p,1);
			$p2 = $p2['id_periodo']; 
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
			<?	}		
			$tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			$tot_periodo = 2;
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
			<?	}
			if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>						
			<? } }?>
			<!---  MODULO DE EXAMENES NUEVO SISTEMA -->
			<?  $sql="SELECT max(cuenta) FROM (SELECT count(*) as cuenta FROM examen_semestral WHERE id_curso=".$curso." group by id_ramo) as contador";
				$rs_examen = @pg_exec($conn,$sql);
				$cuenta_examen = @pg_result($rs_examen,0);
				
				for($jj=0;$jj<$cuenta_examen;$jj++){
					
			?>		
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>Ex.<?=$jj;?></strong></font></td>			         
			<? } ?>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>PROM</strong></font></td>			         
            </tr>
		  <?
		  $cont_prom = 0;

		  $promedio = 0;
		  $Prom_Gral=0;
		  $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->RamoAlumno($conn);
          $result =$ob_reporte ->result;
		  if (!$result) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
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
		  $num_subsec = pg_numrows($result);
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];
				$porc_ramo = $fila['porc_examen'];
				$Prom_Sub=0;
				$nota_porc=0; 
			?>		
          <tr>
		  <?
		  	$sql3 = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17, notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio ";
			$sql3 = $sql3 . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') AND ((notas$nro_ano.id_ramo)=".$id_ramo.") AND ((notas$nro_ano.id_periodo)=".$id_periodo.")); ";

           
            

			$result2 =@pg_Exec($conn,$sql3);
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
				$fila2 = @pg_fetch_array($result2,$f);
				if ($modo_eval == 1){
					if ($fila2['nota1']>0) $nota1 = $fila2['nota1']; else $nota1 = "&nbsp;";
					if ($fila2['nota2']>0) $nota2 = $fila2['nota2']; else $nota2 = "&nbsp;";
					if ($fila2['nota3']>0) $nota3 = $fila2['nota3']; else $nota3 = "&nbsp;";
					if ($fila2['nota4']>0) $nota4 = $fila2['nota4']; else $nota4 = "&nbsp;";
					if ($fila2['nota5']>0) $nota5 = $fila2['nota5']; else $nota5 = "&nbsp;";
					if ($fila2['nota6']>0) $nota6 = $fila2['nota6']; else $nota6 = "&nbsp;";
					if ($fila2['nota7']>0) $nota7 = $fila2['nota7']; else $nota7 = "&nbsp;";
					if ($fila2['nota8']>0) $nota8 = $fila2['nota8']; else $nota8 = "&nbsp;";
					if ($fila2['nota9']>0) $nota9 = $fila2['nota9']; else $nota9 = "&nbsp;";
					if ($fila2['nota10']>0) $nota10 = $fila2['nota10']; else $nota10 = "&nbsp;";
					if ($fila2['nota11']>0) $nota11 = $fila2['nota11']; else $nota11 = "&nbsp;";
					if ($fila2['nota12']>0) $nota12 = $fila2['nota12']; else $nota12 = "&nbsp;";
					if ($fila2['nota13']>0) $nota13 = $fila2['nota13']; else $nota13 = "&nbsp;";
					if ($fila2['nota14']>0) $nota14 = $fila2['nota14']; else $nota14 = "&nbsp;";
					if ($fila2['nota15']>0) $nota15 = $fila2['nota15']; else $nota15 = "&nbsp;";
					if ($fila2['nota16']>0) $nota16 = $fila2['nota16']; else $nota16 = "&nbsp;";
					if ($fila2['nota17']>0) $nota17 = $fila2['nota17']; else $nota17 = "&nbsp;";
					if ($fila2['nota18']>0) $nota18 = $fila2['nota18']; else $nota18 = "&nbsp;";
					if ($fila2['nota19']>0) $nota19 = $fila2['nota19']; else $nota19 = "&nbsp;";
					if ($fila2['nota20']>0) $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";																																																																																															
				} else {
					if (chop($fila2['nota1'])=="0" or chop($fila2['nota1'])=="") $nota1 = "&nbsp;";  else $nota1 = $fila2['nota1'];
					if (chop($fila2['nota2'])=="0" or chop($fila2['nota2'])=="")  $nota2 = "&nbsp;"; else $nota2 = $fila2['nota2'];
					if (chop($fila2['nota3'])=="0" or chop($fila2['nota3'])=="")  $nota3 = "&nbsp;"; else $nota3 = $fila2['nota3'];
					if (chop($fila2['nota4'])=="0" or chop($fila2['nota4'])=="")  $nota4 = "&nbsp;"; else $nota4 = $fila2['nota4'];
					if (chop($fila2['nota5'])=="0" or chop($fila2['nota5'])=="")  $nota5 = "&nbsp;"; else $nota5 = $fila2['nota5'];
					if (chop($fila2['nota6'])=="0" or chop($fila2['nota6'])=="")  $nota6 = "&nbsp;"; else $nota6 = $fila2['nota6'];
					if (chop($fila2['nota7'])=="0" or chop($fila2['nota7'])=="")  $nota7 = "&nbsp;"; else $nota7 = $fila2['nota7'];
					if (chop($fila2['nota8'])=="0" or chop($fila2['nota8'])=="")  $nota8 = "&nbsp;"; else $nota8 = $fila2['nota8'];
					if (chop($fila2['nota9'])=="0" or chop($fila2['nota9'])=="")  $nota9 = "&nbsp;"; else $nota9 = $fila2['nota9'];
					if (chop($fila2['nota10'])=="0" or chop($fila2['nota10'])=="")  $nota10 = "&nbsp;"; else $nota10 = $fila2['nota10'];
					if (chop($fila2['nota11'])=="0" or chop($fila2['nota11'])=="")  $nota11 = "&nbsp;"; else $nota11 = $fila2['nota11'];
					if (chop($fila2['nota12'])=="0" or chop($fila2['nota12'])=="")  $nota12 = "&nbsp;"; else $nota12 = $fila2['nota12'];
					if (chop($fila2['nota13'])=="0" or chop($fila2['nota13'])=="")  $nota13 = "&nbsp;"; else $nota13 = $fila2['nota13'];
					if (chop($fila2['nota14'])=="0" or chop($fila2['nota14'])=="")  $nota14 = "&nbsp;"; else $nota14 = $fila2['nota14'];
					if (chop($fila2['nota15'])=="0" or chop($fila2['nota15'])=="")  $nota15 = "&nbsp;"; else $nota15 = $fila2['nota15'];
					if (chop($fila2['nota16'])=="0" or chop($fila2['nota16'])=="")  $nota16 = "&nbsp;"; else $nota16 = $fila2['nota16'];
					if (chop($fila2['nota17'])=="0" or chop($fila2['nota17'])=="")  $nota17 = "&nbsp;"; else $nota17 = $fila2['nota17'];
					if (chop($fila2['nota18'])=="0" or chop($fila2['nota18'])=="")  $nota18 = "&nbsp;"; else $nota18 = $fila2['nota18'];
					if (chop($fila2['nota19'])=="0" or chop($fila2['nota19'])=="")  $nota19 = "&nbsp;"; else $nota19 = $fila2['nota19'];
					if (chop($fila2['nota20'])=="0" or chop($fila2['nota20'])=="")  $nota20 = "&nbsp;"; else $nota20 = $fila2['nota20'];
				}
			?>
            <td height="25"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre']; ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota1<40 && $nota1>0){ ?><strong><font color="#FF0000"><? echo $nota1 ?></font><? } else { echo $nota1; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota2<40 && $nota2>0){ ?><strong><font color="#FF0000"><? echo $nota2 ?></font><? } else { echo $nota2; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota3<40 && $nota3>0){ ?><strong><font color="#FF0000"><? echo $nota3 ?></font><? } else { echo $nota3; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota4<40 && $nota4>0){ ?><strong><font color="#FF0000"><? echo $nota4 ?></font><? } else { echo $nota4; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota5<40 && $nota5>0){ ?><strong><font color="#FF0000"><? echo $nota5 ?></font><? } else { echo $nota5; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota6<40 && $nota6>0){ ?><strong><font color="#FF0000"><? echo $nota6 ?></font><? } else { echo $nota6; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota7<40 && $nota7>0){ ?><strong><font color="#FF0000"><? echo $nota7 ?></font><? } else { echo $nota7; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota8<40 && $nota8>0){ ?><strong><font color="#FF0000"><? echo $nota8 ?></font><? } else { echo $nota8; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota9<40 && $nota9>0){ ?><strong><font color="#FF0000"><? echo $nota9 ?></font><? } else { echo $nota9; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota10<40 && $nota10>0){ ?><strong><font color="#FF0000"><? echo $nota10 ?></font><? } else { echo $nota10; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota11<40 && $nota11>0){ ?><strong><font color="#FF0000"><? echo $nota11 ?></font><? } else { echo $nota11; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota12<40 && $nota12>0){ ?><strong><font color="#FF0000"><? echo $nota12 ?></font><? } else { echo $nota12; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota13<40 && $nota13>0){ ?><strong><font color="#FF0000"><? echo $nota13 ?></font><? } else { echo $nota13; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota14<40 && $nota14>0){ ?><strong><font color="#FF0000"><? echo $nota14 ?></font><? } else { echo $nota14; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota15<40 && $nota15>0){ ?><strong><font color="#FF0000"><? echo $nota15 ?></font><? } else { echo $nota15; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota16<40 && $nota16>0){ ?><strong><font color="#FF0000"><? echo $nota16 ?></font><? } else { echo $nota16; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota17<40 && $nota17>0){ ?><strong><font color="#FF0000"><? echo $nota17 ?></font><? } else { echo $nota17; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota18<40 && $nota18>0){ ?><strong><font color="#FF0000"><? echo $nota18 ?></font><? } else { echo $nota18; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota19<40 && $nota19>0){ ?><strong><font color="#FF0000"><? echo $nota19 ?></font><? } else { echo $nota19; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota20<40 && $nota20>0){ ?><strong><font color="#FF0000"><? echo $nota20 ?></font><? } else { echo $nota20; } ?></font></div></td>
			<? 			if(Trim($fila2['promedio'])=="0" or empty($fila2['nota20'])){
				$prom = "&nbsp;";
			}else{
				$prom = $fila2['promedio'];}  
				
			if (number_format($prom) > 0 and ($fila['nombre']<>"RELIGION")) 
			  {
				  $cont_prom=$cont_prom+1;
				  //echo "Contador ". $cont_prom. "<br>";
				  $promedio = ($promedio + $prom);
				  //echo "Suma" . $promedio ;
			} //else {
			if($fila['nombre']=="RELIGION"){
				$ramo_religion = $fila['id_ramo'];
			}
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by fecha_inicio";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
	        for($per=0 ; $per < $tot_periodo ; $per++)
			{				
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];
				//-------
			  	$sql_peri = "SELECT notas$nro_ano.promedio ";
				$sql_peri = $sql_peri . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') and id_ramo = ".$id_ramo." and id_periodo = ".$periodos." ) order by id_periodo; ";
				$result_peri =@pg_Exec($conn,$sql_peri);
				if (pg_numrows($result_peri)>0){
					$fila_peri = @pg_fetch_array($result_peri,0);
					if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio'])){
						$prome_1 = "&nbsp;";
					} else {
						if ($fila_peri['promedio']>0){
							$prome_1 = round($fila_peri['promedio'],0);					
						} else {
							$prome_1 = $fila_peri['promedio'];					
						}
					}
				} else {
					$prome_1 = "&nbsp;";
				}
				///// acomulo promedio para mostrar al final ///
				if ($prome_1>0){
				    $prome_semestral = $prome_semestral + $prome_1;
					$cuenta_semestral = $cuenta_semestral + 1;
				}
				
				?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? 
					if($prome_1<40 && $prome_1>0){ ?><strong><font color="#FF0000"><? 
						echo $prome_1;?></font><? 
					} else { 
						echo $prome_1; 
					}?></font></td>								
				<?
			}
			
			

				$sql= "SELECT * FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND id_ano=".$ano." AND periodo=".$periodos." AND rut_alumno=".$alumno;
				$rs_nota = @pg_exec($conn,$sql);
				
				for($jj=0;$jj<$cuenta_examen;$jj++){
					$fils_nota = @pg_fetch_array($rs_nota,$jj);
					$nota_ex = $fils_nota['nota'];
					if(pg_numrows($rs_nota)==0){
						$nota_ex="&nbsp;";
					}
					$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." LIMIT (".$jj."+1) OFFSET ".$jj;
					$rs_porc = @pg_exec($conn,$sql);
					$porc = @pg_result($rs_porc,0);
					$aprox_ex = @pg_result($rs_porc,1);
					$nota_porc = $nota_porc + (($nota_ex * $porc)/100);
					
			?>		
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
				<? 	if($nota_ex < 40 && $nota_ex > 0){?> <font color="#FF0000">
				<? 		echo $nota_ex; ?></font> 
				<? 	}else { 
						echo $nota_ex;
					}
				?>
				</strong></font></td>         
			<? } 
					$Prom_ex = ($prome_1 * (100 - $porc))/100;
					
					if($aprox_ex==1){
						$Prom_Sub = round($Prom_ex + $nota_porc);
					}else{
						$Prom_Sub = intval($Prom_ex + $nota_porc);
					}
					if(pg_numrows($rs_nota)==0){
						$Prom_Sub =$prome_1;
					}
					$Prom_Gral = $Prom_Gral + $Prom_Sub;
					if($Prom_Sub>0)
						$cuenta_ramo ++;
			?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? 
					if($Prom_Sub<40 && $Prom_Sub>0){ ?><strong><font color="#FF0000"><? 
						 echo $Prom_Sub; ?></font><? 
					}else{
						if($Prom_Sub==0) 
							echo "&nbsp;"; 
						else
							echo $Prom_Sub; 
					}?></font></font></td>
		  </tr>
 <? } ?>		  
          <tr>
<!--            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio de <? //echo ucwords(strtolower($fila1['nombre_periodo']))?></font></strong></font></td> -->
            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio &nbsp;&nbsp;&nbsp;</font></strong></font></td>
			<?
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by fecha_inicio";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
			$prome_abajo = 0;
			$cont_abajo = 0;
	        for($per=0 ; $per < $tot_periodo ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];

				
				$sql_peri = "select promedio from notas$nro_ano where id_ramo in (select id_ramo from ramo where id_ramo in (select id_ramo from notas$nro_ano where id_periodo = '".trim($periodos)."' and rut_alumno = '".$alumno."') and cod_subsector < 50000 and bool_ip=1 and id_curso = '".$curso."') and rut_alumno = '".trim($alumno)."'";
				
				$result_peri =@pg_Exec($conn,$sql_peri);
				$prome_abajo = 0;
				$cont_abajo = 0;
				
$promedio_periodo_aux = 0;				
		        for($pm=0 ; $pm < @pg_numrows($result_peri) ; $pm++)
				{
					$filapm = @pg_fetch_array($result_peri,$pm);							
					if ($filapm['promedio']>0){
						$prome_abajo = $prome_abajo + $filapm['promedio'];
						$cont_abajo = $cont_abajo + 1;
					}
				}

				if ($prome_abajo>0){
					if(($institucion==11209 or $institucion==770 or $institucion==769 )OR($truncado_per==0)){
						$prome_abajo = intval($prome_abajo/$cont_abajo);
					}else{
						$prome_abajo = round($prome_abajo/$cont_abajo,0);
					}
					$prome_general_pro = $prome_general_pro + $prome_abajo;
					$cont_general_pro = $cont_general_pro + 1;
				}

					 $promedio_periodo_aux = $prome_abajo;


                //// nuevo codigo   ////
				if ($institucion == 2995){
				    $prome_abajo = round($prome_semestral / $cuenta_semestral);
					$promedio_periodo_aux = $prome_abajo;
				} 
				?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? 
					if($prome_abajo<40 && $prome_abajo>0){ ?><strong><font color="#FF0000"><? 
						 echo $prome_abajo; ?></font><? 
					}
					else { 
						if($prome_abajo==0){
							echo "&nbsp;";
						}else{
							echo $prome_abajo; 
						}
					}?></font></td>								
				<?
			}
			if ($prome_general_pro>0)// keo la caga... muy wuena la wuea
				$prome_general_pro = round($prome_general_pro/$cont_general_pro);
				
				for($jj=0;$jj<$cuenta_examen;$jj++){
					
			?>		
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;</strong></font></td>			         
			<? }
				//$Prom_Gral = @intval($Prom_Gral /$cuenta_ramo);
				$Prom_Gral = @round($Prom_Gral /$cuenta_ramo);
			 ?>
			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif">	<? 
					if($Prom_Gral<40 && $Prom_Gral>0){ ?><strong><font color="#FF0000"><? 
						 echo $Prom_Gral; ?></font><? 
					}
					else { 
						if($Prom_Gral==0){
							echo "&nbsp;";
						}else{
							echo $Prom_Gral; 
						}
					}?></strong></font></td>	
          </tr>
        </table>
		        
		<? } //for?>
		<? } //if?> 
		<HR width="100%" color=#003b85>
		
		
		
<? if ($_INSTIT!=14629){ ?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <? if ($_INSTIT!=12829){ ?>
    <td width="153"><font size="1" face="Arial, Helvetica, sans-serif">
      <? if ($_INSTIT==770){ ?>
      &nbsp;
      <? }else{ ?>
      <strong>TOTAL DIAS PERIODO </strong>
      <? } ?>
    </font></td>
    <td width="237"><font size="1" face="Arial, Helvetica, sans-serif">
      <? if ($_INSTIT==770){ ?>
      &nbsp;
      <? }else{ ?>
      <? echo $dias_habiles ?>
      <? } ?>
    </font></td>
    <? } ?>
    <? if ($_INSTIT==12829){ ?>
    <td width="153"><font size="1" face="Arial, Helvetica, sans-serif"> <strong>TOTAL HORAS A TRABAJAR </strong></font></td>
    <td width="237"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 1592 </font></td>
    <? } ?>
    <td width="172"><font size="1" face="Arial, Helvetica, sans-serif">
      <? if ($_INSTIT==770){ ?>
      &nbsp;
      <? }else{ ?>
      <strong>TOTAL DIAS INASISTENTES</strong>
      <? } ?>
    </font></td>
    <td width="78"><font size="1" face="Arial, Helvetica, sans-serif">
      <? if ($_INSTIT==770){ ?>
      &nbsp;
      <? }else{ ?>
      <? echo $inasistencia ?>
      <? } ?>
    </font></td>
  </tr>
  <tr>
    <td><font size="1" face="Arial, Helvetica, sans-serif">
      <? if ($_INSTIT==770){ ?>
      &nbsp;
      <? }else{ ?>
      <strong>TOTAL ASISTENCIAS (%)</strong>
      <? } ?>
    </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">
      <? if ($_INSTIT==770){ ?>
      &nbsp;
      <? }else{ ?>
      <? 
							if ($dias_habiles>0)
							{
								$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
								$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
								$prom_cont_asis = $prom_cont_asis + 1;
							}
							echo $promedio_asistencia . "%" ;
							?>
      <? } ?>
    </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">
      <? if ($_INSTIT==770){ ?>
      &nbsp;
      <? }else{ ?>
      <strong>TOTAL ATRASOS</strong>
      <? } ?>
    </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">
      <? if ($_INSTIT==770){ ?>
      &nbsp;
      <? }else{ ?>
      <?
					$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD'))";
					$result_atraso =@pg_Exec($conn,$sql_atraso);
					$fila_atraso = @pg_fetch_array($result_atraso,0);
					if (empty($fila_atraso['cantidad']))
						echo "0";
					else
						echo $fila_atraso['cantidad'];
					?>
      <? } ?>
    </font></td>
  </tr>
</table>
<? } ?>
<table width="650"  border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td ><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></font></div></td>
		  </tr>
		 
			<? 
				$sql_observa = "select * from observa_informe where rut_alumno = '".$alumno."'";
				$result_observa =@pg_Exec($conn,$sql_observa);
				$fila_observa = @pg_fetch_array($result_observa,0);	
				if (!empty($fila_observa['observacion']))
					echo $fila_observa['observacion'];
				else
					echo "&nbsp;";
			
			?>
		</table>
			
		<table width="650" height="72" border="0" cellpadding="0" cellspacing="0">
		 <? if ($bool_ed==1) { ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"><? echo "ALUMNO EVALUADO DIFERENCIADAMENTE ";?> 
               </font></strong></font></div></td>
		  </tr>
		  <? } ELSE{ ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"> 
                        <!--Academias:-->
                        </font><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></strong></font></div></td>
		  </tr>
		  <? } ?>
		  <tr>
		    <td height="27"><div align="left"><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></div></td>
		    </tr>
<? if($institucion==770){?>			
		  <tr>
		    <td height="27"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font></div></td>
		  </tr>
<? } ?>	

 <?
  if ($_INSTIT==770){ ?>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr> 
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>                  
  <? } ?>
   <?
	  if ($_INSTIT==2995){ ?>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <? } ?>	


 		
		</table>			  
		        <table width="650" border="0" cellpadding="0" cellspacing="0">
				  <?
				  for($e=0 ; $e < 4 ; $e++)
				  {
				  ?>			 
                  
				  <? } if ($_INSTIT==14912){// BLOQUEO BOTON DERECHO PARA EVITAR CAPTURA DE LA RUTA DE LA IMAGEN?> 
				 <script type="text/javascript" language="Javascript"> 
                  <!-- Begin 
                  document.oncontextmenu = function(){return false} --->
                   // End --> 
                 </script>
			<? } 
			
			$imagen="27000.jpg";
			
		
			
			?>	  
                  <tr>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">________________________________</font></strong></div></td>
                    
					<? 
					 if ($_INSTIT!=25269){ ?>
					
					<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1"><? if ($_INSTIT==14912) {?><img src="<? echo($imagen)?>" width="176" height="54"><? }  else if ($_INSTIT!=14912){?>________________________________</font></strong></div>
                      <? } ?></td>
					  
					  
				  <? } ?>	  
                  </tr>
				 			 
				  
				  <tr>
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="1">Profesor(a) Jefe. </font></div></td>
                   <? if ($_INSTIT!=25269){ ?> <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="1"><?=$cargo_dir2 ?> Establecimiento</font> </div></td>  <? } ?>
                  </tr>
                  <tr>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1"><? if(($institucion==8930)OR($institucion==770)){  echo $nombre_profesor; }else{ echo $nombre_profe;} ?></font></strong></div></td>
                   
				    <? if ($_INSTIT!=25269){ ?>				   
				    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">
                        <?
		if ($institucion == 9566){
			echo "PAVÉZ MENESES ROBERTO";
		} 
	
	
	
	
//TERMINA IF DE 9239
		
		else {						
			$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
			$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
			$sql = $sql . "WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23) ";
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
			if($institucion==770){
				echo ucwords(strtoupper(trim($fila['nombre_emp']) . " " . trim($fila['ape_pat']) . " " . trim($fila['ape_mat'])));
			}else{
				echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
			    $cargo_dir    = $fila['cargo'];	
		
		
				if ($cargo_dir==1){
					$cargo_dir  = "director(a)";
					$cargo_dir2 = "Director(a)";
				}
				if ($cargo_dir==23){
					$cargo_dir  = "rector(a)";
					$cargo_dir2 = "Rector(a)";
				}
			
			}
		}
			?>
                    </font></strong></div></td>
					
				<? } ?>	
                  </tr>
                </table>
              </div>		</td>
      </tr>
    </table>
	
	<?
	if ($_INSTIT!=770){ ?>
		<table width="100%">
		 <tr>
		  <td>
		  <? $fecha = date("d-m-Y");?>
		  <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtolower($comuna)).", ". fecha_espanol($fecha) ?></font>
		 </td>
		 </tr>
		</table>
	<? } ?>
	
	<?
	if ($_INSTIT==25269){ 	
	    if  (($cont_alumnos - $cont_paginas)<>1){ 
	        echo "<H1 class=SaltoDePagina></H1>";
        }
	}
	?>	
  
	</td>
  </tr>
  <tr>
  <? if($institucion =="770"){	?>	
	  <tr><td>&nbsp;</td></tr>
		<tr>	
		<td colspan="3" align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($fila_com['nom_com'])).", ".fecha_espanol($fecha);?></font></td> 
		</tr>
<? 	} ?>

<? if($ckCOLILLA==1){	?>  	
    	<td><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - - - - - - - - </strong></font></div>

 
 		
  </table>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">Devolver colilla firmada</font> </div></td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td width="124"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
    <td width="245"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $nombre_alumno; ?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtolower($Curso_pal))?></strong></font></div></td>
  </tr>
  <tr>

    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Promedio Alumno</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
	  <?
	if ($promedio_periodo_aux>0)
		echo $promedio_periodo_aux;
	else
		echo "&nbsp;";
		
	?>
	  </strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?> Total D&iacute;as Inasistente <? } ?></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?> <? echo $inasistencia ?> <? } ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Período </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo trim($dias_habiles) ?></font></div></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?>Total Atrasos <? } ?> </font></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
    <? if ($_INSTIT==770){ ?>
	       &nbsp;
	<? }else{ ?>	
			<?
			$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD'))";
			$result_atraso =@pg_Exec($conn,$sql_atraso);
			$fila_atraso = @pg_fetch_array($result_atraso,0);
			if (empty($fila_atraso['cantidad']))
				echo "0";
			else
				echo trim($fila_atraso['cantidad']);
			?>
	<? } ?>		
    </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Asistencias (%) </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
        <? 
			if ($dias_habiles>0)
			{
				$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
				$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
				$prom_cont_asis = $prom_cont_asis + 1;
			}
			echo $promedio_asistencia . "%" ;
			?>
    </font></div></td>
    <td><div align="left">&nbsp;</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">___________________________</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Firma Apoderado </font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?
if ($institucion==1593){ ?>
	<table width="700" border="0" cellspacing="0" cellpadding="0">
		<tr><? $fecha = date("d-m-Y") ?>
		 <td width="%" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><? echo ($comuna .", " . fecha_espanol($fecha))?></font></td>
	  </tr>
	</table>
<? } ?>

 <? }
}


if ($fila['ensenanza']>300 and $fila['grado_curso']>2){
$cuenta_ramo=0;
$Prom_Gral=0;  ?>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?
	if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br><br><br>";
			   
		  }
	?>
	<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
            <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			  <? if ($institucion!="770"){ ?>
			    <td width="115"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
			    <td width="10"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
			    <td width="359"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo strtoupper(trim($fila['nombre_instit'])) ?></font></div></td>	
                <td width="161" rowspan="7" align="center" valign="top" >
<?
		$result = @pg_Exec($conn,"select insignia, rdb from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>				</td>
	  <? } ?>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>AÑO ESCOLAR</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo trim($fila['nro_ano']) ?></font></div></td>
                </tr>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>CURSO</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
				<? 
				$Curso_pal = CursoPalabra($curso, 0, $conn);
				echo $Curso_pal; 
				?>
				</font></div></td>
                </tr>	
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>ALUMNO</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <? if($institucion==8930){?>
				<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? Nombre($fila['ape_pat'],$fila['ape_mat'],$fila['nombre_alu'])?></font></td> 
				<? }else{?>
				<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));?></font></div></td> 
				<? } ?>
                </tr>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>PROFESOR JEFE</strong></font></div></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
				<?
								
				if($institucion==770){
				    echo $nombre_profe; 
				}else{
				    echo $nombre_profe;
				}
				
				?>
				</font></div></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="4" rowspan="5" align="center">&nbsp;</td>
              </tr>
             
            </table>
            </td>
      </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20"  class="tableindex"><div align="center">INFORME  DE NOTAS  </div></td>
      </tr>
	   <?
	  if ($institucion==770){
	      ?>
		  <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluación Nº : ".$decreto_eval?></strong></font></div></td>
          </tr>
          <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas Nº : ".$planes?></strong></font></div></td>
          </tr>
   <? } ?>
      <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($fila1['nombre_periodo'] . "DEL " . $nro_ano))?></strong></font></div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td>
		<?
		
		
		
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
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
				$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = '" . $alumno . "' and ano = ". $ano . " and id_curso = " . $curso . " and fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD')";
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
				//--
				$sql8 = "select count(*) as contador from notas$nro_ano where id_periodo = ". $id_periodo . " and rut_alumno = '" . $alumno."'";
			    $result18 =@pg_Exec($conn,$sql8);
			    if (!$result18) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			  	}
			    else
			  	{
				  	if (pg_numrows($result18)!=0)
				    {
				  	  $fila8 = @pg_fetch_array($result18,0);	
				  	  if (!$fila1)
				  	  {
					  	  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  	  exit();
					    }
				    }
			    }
				if ($fila8['contador']>0)
				{
				
				 
				?>			
				<br>
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231" align="left">
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Subsector del Aprendizaje (Formaci&oacute;n General ) </strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></td>
			<?
		  	$sql_peri = "SELECT distinct id_periodo FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."')) order by id_periodo;";
			$result_peri =@pg_Exec($conn,$sql_peri);
			$cantidad_periodos = @pg_numrows($result_peri);	
			$tri = 0;
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
			<?	}		
			$tri = 2;
//			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE")){ 
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			
			$tot_periodo = 2;
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
			<?	}
			if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>						
			<? } }?>		         
            <!---  MODULO DE EXAMENES NUEVO SISTEMA -->
			<?  $sql="SELECT max(cuenta) FROM (SELECT count(*) as cuenta FROM examen_semestral WHERE id_curso=".$curso." group by id_ramo) as contador";
				$rs_examen = @pg_exec($conn,$sql);
				$cuenta_examen = @pg_result($rs_examen,0);
				
				for($jj=0;$jj<$cuenta_examen;$jj++){
					
			?>		
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>Ex.<?=$jj;?></strong></font></td>			         
			<? } ?>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>PROM</strong></font></td>			         
            </tr>      
		  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $Prom_Gral=0;
		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip, porc_examen ";
		  $sql2 = $sql2 . "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector and ramo.cod_subsector < 50000) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) AND (ramo.id_ramo = tiene$nro_ano.id_ramo) ";
   		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)='".$alumno."') and (ramo.cod_subsector<1000 and ramo.cod_subsector <> 250 and ramo.cod_subsector !=42 and ramo.cod_subsector !=742 and ramo.cod_subsector !=43 and ramo.cod_subsector !=395 and ramo.cod_subsector !=155 and ramo.cod_subsector !=136)) order by ramo.id_orden";
          $result =@pg_Exec($conn,$sql2);
		  if (!$result) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
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
		  
		  
		  
		  
		  $num_subsec = pg_numrows($result);
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval '];
				$porc_ramo = $fila['porc_examen'];
				$Prom_Sub=0;
				$nota_porc=0; 
			?>		
          <tr>
		  <?
		  	$sql3 = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17, notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio ";
			$sql3 = $sql3 . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') AND ((notas$nro_ano.id_ramo)=".$id_ramo.") AND ((notas$nro_ano.id_periodo)=".$id_periodo.")); ";
			$result2 =@pg_Exec($conn,$sql3);
			
				
						
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
				$fila2 = @pg_fetch_array($result2,$f);
				if ($modo_eval == 1){
					if ($fila2['nota1']>0) $nota1 = $fila2['nota1']; else $nota1 = "&nbsp;";
					if ($fila2['nota2']>0) $nota2 = $fila2['nota2']; else $nota2 = "&nbsp;";
					if ($fila2['nota3']>0) $nota3 = $fila2['nota3']; else $nota3 = "&nbsp;";
					if ($fila2['nota4']>0) $nota4 = $fila2['nota4']; else $nota4 = "&nbsp;";
					if ($fila2['nota5']>0) $nota5 = $fila2['nota5']; else $nota5 = "&nbsp;";
					if ($fila2['nota6']>0) $nota6 = $fila2['nota6']; else $nota6 = "&nbsp;";
					if ($fila2['nota7']>0) $nota7 = $fila2['nota7']; else $nota7 = "&nbsp;";
					if ($fila2['nota8']>0) $nota8 = $fila2['nota8']; else $nota8 = "&nbsp;";
					if ($fila2['nota9']>0) $nota9 = $fila2['nota9']; else $nota9 = "&nbsp;";
					if ($fila2['nota10']>0) $nota10 = $fila2['nota10']; else $nota10 = "&nbsp;";
					if ($fila2['nota11']>0) $nota11 = $fila2['nota11']; else $nota11 = "&nbsp;";
					if ($fila2['nota12']>0) $nota12 = $fila2['nota12']; else $nota12 = "&nbsp;";
					if ($fila2['nota13']>0) $nota13 = $fila2['nota13']; else $nota13 = "&nbsp;";
					if ($fila2['nota14']>0) $nota14 = $fila2['nota14']; else $nota14 = "&nbsp;";
					if ($fila2['nota15']>0) $nota15 = $fila2['nota15']; else $nota15 = "&nbsp;";
					if ($fila2['nota16']>0) $nota16 = $fila2['nota16']; else $nota16 = "&nbsp;";
					if ($fila2['nota17']>0) $nota17 = $fila2['nota17']; else $nota17 = "&nbsp;";
					if ($fila2['nota18']>0) $nota18 = $fila2['nota18']; else $nota18 = "&nbsp;";
					if ($fila2['nota19']>0) $nota19 = $fila2['nota19']; else $nota19 = "&nbsp;";
					if ($fila2['nota20']>0) $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";																																																																																															
				} else {
					if (chop($fila2['nota1'])=="0" or chop($fila2['nota1'])=="")  $nota1 = "&nbsp;"; else $nota1 = $fila2['nota1'];
					if (chop($fila2['nota2'])=="0" or chop($fila2['nota2'])=="")  $nota2 = "&nbsp;"; else $nota2 = $fila2['nota2'];
					if (chop($fila2['nota3'])=="0" or chop($fila2['nota3'])=="")  $nota3 = "&nbsp;"; else $nota3 = $fila2['nota3'];
					if (chop($fila2['nota4'])=="0" or chop($fila2['nota4'])=="")  $nota4 = "&nbsp;"; else $nota4 = $fila2['nota4'];
					if (chop($fila2['nota5'])=="0" or chop($fila2['nota5'])=="")  $nota5 = "&nbsp;"; else $nota5 = $fila2['nota5'];
					if (chop($fila2['nota6'])=="0" or chop($fila2['nota6'])=="")  $nota6 = "&nbsp;"; else $nota6 = $fila2['nota6'];
					if (chop($fila2['nota7'])=="0" or chop($fila2['nota7'])=="")  $nota7 = "&nbsp;"; else $nota7 = $fila2['nota7'];
					if (chop($fila2['nota8'])=="0" or chop($fila2['nota8'])=="")  $nota8 = "&nbsp;"; else $nota8 = $fila2['nota8'];
					if (chop($fila2['nota9'])=="0" or chop($fila2['nota9'])=="")  $nota9 = "&nbsp;"; else $nota9 = $fila2['nota9'];
					if (chop($fila2['nota10'])=="0" or chop($fila2['nota10'])=="")  $nota10 = "&nbsp;"; else $nota10 = $fila2['nota10'];
					if (chop($fila2['nota11'])=="0" or chop($fila2['nota11'])=="")  $nota11 = "&nbsp;"; else $nota11 = $fila2['nota11'];
					if (chop($fila2['nota12'])=="0" or chop($fila2['nota12'])=="")  $nota12 = "&nbsp;"; else $nota12 = $fila2['nota12'];
					if (chop($fila2['nota13'])=="0" or chop($fila2['nota13'])=="")  $nota13 = "&nbsp;"; else $nota13 = $fila2['nota13'];
					if (chop($fila2['nota14'])=="0" or chop($fila2['nota14'])=="")  $nota14 = "&nbsp;"; else $nota14 = $fila2['nota14'];
					if (chop($fila2['nota15'])=="0" or chop($fila2['nota15'])=="")  $nota15 = "&nbsp;"; else $nota15 = $fila2['nota15'];
					if (chop($fila2['nota16'])=="0" or chop($fila2['nota16'])=="")  $nota16 = "&nbsp;"; else $nota16 = $fila2['nota16'];
					if (chop($fila2['nota17'])=="0" or chop($fila2['nota17'])=="")  $nota17 = "&nbsp;"; else $nota17 = $fila2['nota17'];
					if (chop($fila2['nota18'])=="0" or chop($fila2['nota18'])=="")  $nota18 = "&nbsp;"; else $nota18 = $fila2['nota18'];
					if (chop($fila2['nota19'])=="0" or chop($fila2['nota19'])=="")  $nota19 = "&nbsp;"; else $nota19 = $fila2['nota19'];
					if (chop($fila2['nota20'])=="0" or chop($fila2['nota20'])=="")  $nota20 = "&nbsp;"; else $nota20 = $fila2['nota20'];
				}
			?>
            <td height="25"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre']; ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota1<40 && $nota1>0){ ?><strong><font color="#FF0000"><? echo $nota1 ?></font><? } else { echo $nota1; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota2<40 && $nota2>0){ ?><strong><font color="#FF0000"><? echo $nota2 ?></font><? } else { echo $nota2; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota3<40 && $nota3>0){ ?><strong><font color="#FF0000"><? echo $nota3 ?></font><? } else { echo $nota3; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota4<40 && $nota4>0){ ?><strong><font color="#FF0000"><? echo $nota4 ?></font><? } else { echo $nota4; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota5<40 && $nota5>0){ ?><strong><font color="#FF0000"><? echo $nota5 ?></font><? } else { echo $nota5; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota6<40 && $nota6>0){ ?><strong><font color="#FF0000"><? echo $nota6 ?></font><? } else { echo $nota6; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota7<40 && $nota7>0){ ?><strong><font color="#FF0000"><? echo $nota7 ?></font><? } else { echo $nota7; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota8<40 && $nota8>0){ ?><strong><font color="#FF0000"><? echo $nota8 ?></font><? } else { echo $nota8; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota9<40 && $nota9>0){ ?><strong><font color="#FF0000"><? echo $nota9 ?></font><? } else { echo $nota9; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota10<40 && $nota10>0){ ?><strong><font color="#FF0000"><? echo $nota10 ?></font><? } else { echo $nota10; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota11<40 && $nota11>0){ ?><strong><font color="#FF0000"><? echo $nota11 ?></font><? } else { echo $nota11; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota12<40 && $nota12>0){ ?><strong><font color="#FF0000"><? echo $nota12 ?></font><? } else { echo $nota12; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota13<40 && $nota13>0){ ?><strong><font color="#FF0000"><? echo $nota13 ?></font><? } else { echo $nota13; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota14<40 && $nota14>0){ ?><strong><font color="#FF0000"><? echo $nota14 ?></font><? } else { echo $nota14; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota15<40 && $nota15>0){ ?><strong><font color="#FF0000"><? echo $nota15 ?></font><? } else { echo $nota15; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota16<40 && $nota16>0){ ?><strong><font color="#FF0000"><? echo $nota16 ?></font><? } else { echo $nota16; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota17<40 && $nota17>0){ ?><strong><font color="#FF0000"><? echo $nota17 ?></font><? } else { echo $nota17; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota18<40 && $nota18>0){ ?><strong><font color="#FF0000"><? echo $nota18 ?></font><? } else { echo $nota18; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota19<40 && $nota19>0){ ?><strong><font color="#FF0000"><? echo $nota19 ?></font><? } else { echo $nota19; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota20<40 && $nota20>0){ ?><strong><font color="#FF0000"><? echo $nota20 ?></font><? } else { echo $nota20; } ?></font></div></td>
			<? 
			if(Trim($fila2['promedio'])=="0" or empty($fila2['nota20'])){
				$prom = "&nbsp;";
			}else{
				$prom = $fila2['promedio'];}  
				
			if (number_format($prom) > 0 and ($fila['nombre']<>"RELIGION")) 
			  {
				  $cont_prom=$cont_prom+1;
				  //echo "Contador ". $cont_prom. "<br>";
				  $promedio = ($promedio + $prom);
				  //echo "Suma" . $promedio ;
			} //else {
			if($fila['nombre']=="RELIGION"){
				$ramo_religion = $fila['id_ramo'];
			}
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by fecha_inicio";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
	        for($per=0 ; $per < $tot_periodo ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];
				//-------
			  	$sql_peri = "SELECT notas$nro_ano.promedio ";
				$sql_peri = $sql_peri . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') and id_ramo = ".$id_ramo." and id_periodo = ".$periodos." ) order by id_periodo; ";
				$result_peri =@pg_Exec($conn,$sql_peri);
/*				if (pg_numrows($result_peri)>0){
					$fila_peri = @pg_fetch_array($result_peri,0);
					$prome_1 = round($fila_peri['promedio'],0);
				} else {
					$prome_1 = 0;
				}*/
				if (pg_numrows($result_peri)>0){
					$fila_peri = @pg_fetch_array($result_peri,0);
					if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio'])){
						$prome_1 = "&nbsp;";
					} else {
						if ($fila_peri['promedio']>0){
							$prome_1 = round($fila_peri['promedio'],0);					
						} else {
							$prome_1 = $fila_peri['promedio'];					
						}
					}
				} else {
					$prome_1 = "&nbsp;";
				}
				?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? 
					if($prome_1<40 && $prome_1>0){ ?><strong><font color="#FF0000"><? 
						 echo $prome_1; ?></font><? 
					}
					else { 
						echo $prome_1; 
					}?></font></td>								
				<?
			}
				

				$sql= "SELECT * FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND id_ano=".$ano." AND periodo=".$periodos." AND rut_alumno=".$alumno;
				$rs_nota = @pg_exec($conn,$sql);
				
				for($jj=0;$jj<$cuenta_examen;$jj++){
					$fils_nota = @pg_fetch_array($rs_nota,$jj);
					$nota_ex = $fils_nota['nota'];
					if(pg_numrows($rs_nota)==0){
						$nota_ex="&nbsp;";
					}
					$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." LIMIT (".$jj."+1) OFFSET ".$jj;
					$rs_porc = @pg_exec($conn,$sql);
					$porc = @pg_result($rs_porc,0);
					$aprox_ex = @pg_result($rs_porc,1);
					$nota_porc = $nota_porc + (($nota_ex * $porc)/100);
					
			?>		
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
				<? 	if($nota_ex < 40 && $nota_ex > 0){?> <font color="#FF0000">
				<? 		echo $nota_ex; ?></font> 
				<? 	}else { 
						echo $nota_ex;
					}
				?>
				</strong></font></td>         
			<? } 
					$Prom_ex = ($prome_1 * $porc_ramo)/100;
										
					if($aprox_ex==1){
						$Prom_Sub = round($Prom_ex + $nota_porc);
					}else{
						$Prom_Sub = intval($Prom_ex + $nota_porc);
					}
					
					
					
					
					if(pg_numrows($rs_nota)==0){
						$Prom_Sub =$prome_1;
					}
					$Prom_Gral = $Prom_Gral + $Prom_Sub;
					if($Prom_Sub>0)
						$cuenta_ramo ++;
						
						
						
						
			?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
			
			<? 
					if($Prom_Sub<40 && $Prom_Sub>0){ ?><strong><font color="#FF0000"><? 
						 echo $Prom_Sub; ?></font><? 
					}
					else { 
						if($Prom_Sub==0){
							echo "&nbsp;";
						}else{
							echo $Prom_Sub; 
						}
					}?></font>
			
			</td>
			
			
		  </tr>
		  <? 
		  
		  }	  
		  
		  ?>
		  <?
		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip, porc_examen ";
		  $sql2 = $sql2 . "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector and ramo.cod_subsector < 50000) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) AND (ramo.id_ramo = tiene$nro_ano.id_ramo) ";
   		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)='".$alumno."') and (ramo.cod_subsector>999 or ramo.cod_subsector = 250 or ramo.cod_subsector = 42 or ramo.cod_subsector = 742 or ramo.cod_subsector = 43  or ramo.cod_subsector = 136  or ramo.cod_subsector = 395  or ramo.cod_subsector = 155)) order by ramo.id_orden";
          $result =@pg_Exec($conn,$sql2);
		  if (!$result) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
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
		  
		  $num_subsec = $num_subsec + pg_numrows($result);
		  if (pg_numrows($result)>0){
		  ?>
<tr>		  
            <td width="231" align="left">
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Subsector del Aprendizaje (Formaci&oacute;n Diferenciada ) </strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></td>
			<?
		  	$sql_peri = "SELECT distinct id_periodo FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."')) order by id_periodo;";
			$result_peri =@pg_Exec($conn,$sql_peri);
			$cantidad_periodos = @pg_numrows($result_peri);	
			$tri = 0;
			$tri = 1;			
			if(($tot_periodo==1)OR($tot_periodo==2)OR($tot_periodo==3)){	?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
			<? }			
			$tri = 2;
			if(($tot_periodo==2)OR($tot_periodo==3)){	?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
			<?	}			
			if ($num_periodos==3){$tri = 3;
			if($tot_periodo==3){	?>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>						
			<? }	} ?>		         
            <!---  MODULO DE EXAMENES NUEVO SISTEMA -->
			<?  $sql="SELECT max(cuenta) FROM (SELECT count(*) as cuenta FROM examen_semestral WHERE id_curso=".$curso." group by id_ramo) as contador";
				$rs_examen = @pg_exec($conn,$sql);
				$cuenta_examen = @pg_result($rs_examen,0);
				
				for($jj=0;$jj<$cuenta_examen;$jj++){
					
			?>		
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>Ex.<?=$jj;?></strong></font></td>			         
			<? } ?>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>PROM</strong></font></td>			         
            </tr>
<?
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];	
				$porc_ramo = $fila['porc_examen'];
				$Prom_Sub=0;
				$nota_porc=0; 			
				
			?>		
          <tr>
		  <?
		  	$sql3 = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17, notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio ";
			$sql3 = $sql3 . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') AND ((notas$nro_ano.id_ramo)=".$id_ramo.") AND ((notas$nro_ano.id_periodo)=".$id_periodo.")); ";

			$result2 =@pg_Exec($conn,$sql3);
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
				$fila2 = @pg_fetch_array($result2,$f);
				if ($modo_eval == 1){
					if ($fila2['nota1']>0) $nota1 = $fila2['nota1']; else $nota1 = "&nbsp;";
					if ($fila2['nota2']>0) $nota2 = $fila2['nota2']; else $nota2 = "&nbsp;";
					if ($fila2['nota3']>0) $nota3 = $fila2['nota3']; else $nota3 = "&nbsp;";
					if ($fila2['nota4']>0) $nota4 = $fila2['nota4']; else $nota4 = "&nbsp;";
					if ($fila2['nota5']>0) $nota5 = $fila2['nota5']; else $nota5 = "&nbsp;";
					if ($fila2['nota6']>0) $nota6 = $fila2['nota6']; else $nota6 = "&nbsp;";
					if ($fila2['nota7']>0) $nota7 = $fila2['nota7']; else $nota7 = "&nbsp;";
					if ($fila2['nota8']>0) $nota8 = $fila2['nota8']; else $nota8 = "&nbsp;";
					if ($fila2['nota9']>0) $nota9 = $fila2['nota9']; else $nota9 = "&nbsp;";
					if ($fila2['nota10']>0) $nota10 = $fila2['nota10']; else $nota10 = "&nbsp;";
					if ($fila2['nota11']>0) $nota11 = $fila2['nota11']; else $nota11 = "&nbsp;";
					if ($fila2['nota12']>0) $nota12 = $fila2['nota12']; else $nota12 = "&nbsp;";
					if ($fila2['nota13']>0) $nota13 = $fila2['nota13']; else $nota13 = "&nbsp;";
					if ($fila2['nota14']>0) $nota14 = $fila2['nota14']; else $nota14 = "&nbsp;";
					if ($fila2['nota15']>0) $nota15 = $fila2['nota15']; else $nota15 = "&nbsp;";
					if ($fila2['nota16']>0) $nota16 = $fila2['nota16']; else $nota16 = "&nbsp;";
					if ($fila2['nota17']>0) $nota17 = $fila2['nota17']; else $nota17 = "&nbsp;";
					if ($fila2['nota18']>0) $nota18 = $fila2['nota18']; else $nota18 = "&nbsp;";
					if ($fila2['nota19']>0) $nota19 = $fila2['nota19']; else $nota19 = "&nbsp;";
					if ($fila2['nota20']>0) $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";																																																																																															
				} else {
					if (chop($fila2['nota1'])=="0" or chop($fila2['nota1'])=="")  $nota1 = "&nbsp;"; else $nota1 = $fila2['nota1'];
					if (chop($fila2['nota2'])=="0" or chop($fila2['nota2'])=="")  $nota2 = "&nbsp;"; else $nota2 = $fila2['nota2'];
					if (chop($fila2['nota3'])=="0" or chop($fila2['nota3'])=="")  $nota3 = "&nbsp;"; else $nota3 = $fila2['nota3'];
					if (chop($fila2['nota4'])=="0" or chop($fila2['nota4'])=="")  $nota4 = "&nbsp;"; else $nota4 = $fila2['nota4'];
					if (chop($fila2['nota5'])=="0" or chop($fila2['nota5'])=="")  $nota5 = "&nbsp;"; else $nota5 = $fila2['nota5'];
					if (chop($fila2['nota6'])=="0" or chop($fila2['nota6'])=="")  $nota6 = "&nbsp;"; else $nota6 = $fila2['nota6'];
					if (chop($fila2['nota7'])=="0" or chop($fila2['nota7'])=="")  $nota7 = "&nbsp;"; else $nota7 = $fila2['nota7'];
					if (chop($fila2['nota8'])=="0" or chop($fila2['nota8'])=="")  $nota8 = "&nbsp;"; else $nota8 = $fila2['nota8'];
					if (chop($fila2['nota9'])=="0" or chop($fila2['nota9'])=="")  $nota9 = "&nbsp;"; else $nota9 = $fila2['nota9'];
					if (chop($fila2['nota10'])=="0" or chop($fila2['nota10'])=="")  $nota10 = "&nbsp;"; else $nota10 = $fila2['nota10'];
					if (chop($fila2['nota11'])=="0" or chop($fila2['nota11'])=="")  $nota11 = "&nbsp;"; else $nota11 = $fila2['nota11'];
					if (chop($fila2['nota12'])=="0" or chop($fila2['nota12'])=="")  $nota12 = "&nbsp;"; else $nota12 = $fila2['nota12'];
					if (chop($fila2['nota13'])=="0" or chop($fila2['nota13'])=="")  $nota13 = "&nbsp;"; else $nota13 = $fila2['nota13'];
					if (chop($fila2['nota14'])=="0" or chop($fila2['nota14'])=="")  $nota14 = "&nbsp;"; else $nota14 = $fila2['nota14'];
					if (chop($fila2['nota15'])=="0" or chop($fila2['nota15'])=="")  $nota15 = "&nbsp;"; else $nota15 = $fila2['nota15'];
					if (chop($fila2['nota16'])=="0" or chop($fila2['nota16'])=="")  $nota16 = "&nbsp;"; else $nota16 = $fila2['nota16'];
					if (chop($fila2['nota17'])=="0" or chop($fila2['nota17'])=="")  $nota17 = "&nbsp;"; else $nota17 = $fila2['nota17'];
					if (chop($fila2['nota18'])=="0" or chop($fila2['nota18'])=="")  $nota18 = "&nbsp;"; else $nota18 = $fila2['nota18'];
					if (chop($fila2['nota19'])=="0" or chop($fila2['nota19'])=="")  $nota19 = "&nbsp;"; else $nota19 = $fila2['nota19'];
					if (chop($fila2['nota20'])=="0" or chop($fila2['nota20'])=="")  $nota20 = "&nbsp;"; else $nota20 = $fila2['nota20'];
				}
			?>
            <td height="25"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre']; ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota1<40 && $nota1>0){ ?><strong><font color="#FF0000"><? echo $nota1 ?></font><? } else { echo $nota1; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota2<40 && $nota2>0){ ?><strong><font color="#FF0000"><? echo $nota2 ?></font><? } else { echo $nota2; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota3<40 && $nota3>0){ ?><strong><font color="#FF0000"><? echo $nota3 ?></font><? } else { echo $nota3; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota4<40 && $nota4>0){ ?><strong><font color="#FF0000"><? echo $nota4 ?></font><? } else { echo $nota4; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota5<40 && $nota5>0){ ?><strong><font color="#FF0000"><? echo $nota5 ?></font><? } else { echo $nota5; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota6<40 && $nota6>0){ ?><strong><font color="#FF0000"><? echo $nota6 ?></font><? } else { echo $nota6; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota7<40 && $nota7>0){ ?><strong><font color="#FF0000"><? echo $nota7 ?></font><? } else { echo $nota7; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota8<40 && $nota8>0){ ?><strong><font color="#FF0000"><? echo $nota8 ?></font><? } else { echo $nota8; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota9<40 && $nota9>0){ ?><strong><font color="#FF0000"><? echo $nota9 ?></font><? } else { echo $nota9; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota10<40 && $nota10>0){ ?><strong><font color="#FF0000"><? echo $nota10 ?></font><? } else { echo $nota10; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota11<40 && $nota11>0){ ?><strong><font color="#FF0000"><? echo $nota11 ?></font><? } else { echo $nota11; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota12<40 && $nota12>0){ ?><strong><font color="#FF0000"><? echo $nota12 ?></font><? } else { echo $nota12; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota13<40 && $nota13>0){ ?><strong><font color="#FF0000"><? echo $nota13 ?></font><? } else { echo $nota13; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota14<40 && $nota14>0){ ?><strong><font color="#FF0000"><? echo $nota14 ?></font><? } else { echo $nota14; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota15<40 && $nota15>0){ ?><strong><font color="#FF0000"><? echo $nota15 ?></font><? } else { echo $nota15; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota16<40 && $nota16>0){ ?><strong><font color="#FF0000"><? echo $nota16 ?></font><? } else { echo $nota16; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota17<40 && $nota17>0){ ?><strong><font color="#FF0000"><? echo $nota17 ?></font><? } else { echo $nota17; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota18<40 && $nota18>0){ ?><strong><font color="#FF0000"><? echo $nota18 ?></font><? } else { echo $nota18; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota19<40 && $nota19>0){ ?><strong><font color="#FF0000"><? echo $nota19 ?></font><? } else { echo $nota19; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota20<40 && $nota20>0){ ?><strong><font color="#FF0000"><? echo $nota20 ?></font><? } else { echo $nota20; } ?></font></div></td>
			<? 			if(Trim($fila2['promedio'])=="0" or empty($fila2['nota20'])){
				$prom = "&nbsp;";
			}else{
				$prom = $fila2['promedio'];}  
				
			if (number_format($prom) > 0 and ($fila['nombre']<>"RELIGION")) 
			  {
				  $cont_prom=$cont_prom+1;
				  //echo "Contador ". $cont_prom. "<br>";
				  $promedio = ($promedio + $prom);
				  //echo "Suma" . $promedio ;
			} //else {
			if($fila['nombre']=="RELIGION"){
				$ramo_religion = $fila['id_ramo'];
			}
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by fecha_inicio";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
	        
						
			for($per=0 ; $per < $tot_periodo ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];
				//-------			
				
				$sql_peri = "SELECT notas$nro_ano.promedio ";
				$sql_peri = $sql_peri . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') and id_ramo = ".$id_ramo." and id_periodo = ".$periodos." ) order by id_periodo; ";
								
				
				$result_peri =@pg_Exec($conn,$sql_peri);
				if (pg_numrows($result_peri)>0){
					$fila_peri = @pg_fetch_array($result_peri,0);
					if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio'])){
						$prome_1 = "&nbsp;";
					} else {
						if ($fila_peri['promedio']>1){
							$prome_1 = round($fila_peri['promedio'],0);					
						} else {
							$prome_1 = $fila_peri['promedio'];					
						}
					}
				} else {
					$prome_1 = "&nbsp;";
				}
/*				if (pg_numrows($result_peri)>0){
					$fila_peri = @pg_fetch_array($result_peri,0);
					$prome_1 = round($fila_peri['promedio'],0);
				} else {
					$prome_1 = 0;
				}*/
				?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? 
					if($prome_1<40 && $prome_1>0){ ?><font color="#FF0000"><? 
						echo $prome_1;?></font><? 
					} else { 
						echo $prome_1; 
					}?></font></td>								
				<?
			}
$Prom_ex = ($prome_1 * $porc_ramo)/100;

				$sql= "SELECT * FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND id_ano=".$ano." AND periodo=".$periodos." AND rut_alumno=".$alumno;
				$rs_nota = @pg_exec($conn,$sql);
				
				for($jj=0;$jj<$cuenta_examen;$jj++){
					$fils_nota = @pg_fetch_array($rs_nota,$jj);
					$nota_ex = $fils_nota['nota'];
					if(pg_numrows($rs_nota)==0){
						$nota_ex="&nbsp;";
					}
					$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." LIMIT (".$jj."+1) OFFSET ".$jj;
					$rs_porc = @pg_exec($conn,$sql);
					$porc = @pg_result($rs_porc,0);
					$aprox_ex = @pg_result($rs_porc,1);
					$nota_porc = $nota_porc + (($nota_ex * $porc)/100);
					
			?>		
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
				<? 	if($nota_ex < 40 && $nota_ex > 0){?> <font color="#FF0000">
				<? 		echo $nota_ex; ?></font> 
				<? 	}else { 
						echo $nota_ex;
					}
				?>
				</strong></font></td>         
			<? } 
					
					if($aprox_ex==1){
						$Prom_Sub = round($Prom_ex + $nota_porc);
					}else{
						$Prom_Sub = intval($Prom_ex + $nota_porc);
					}
					if(pg_numrows($rs_nota)==0){
						$Prom_Sub =$prome_1;
					}
					$Prom_Gral = $Prom_Gral + $Prom_Sub;
					if($Prom_Sub>0)
						$cuenta_ramo ++;
			?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
			<? 
					if($Prom_Sub<40 && $Prom_Sub>0){ ?><strong><font color="#FF0000"><? 
						 echo $Prom_Sub; ?></font><? 
					}
					else { 
						if($Prom_Sub==0){
							echo "&nbsp;";
						}else{
							echo $Prom_Sub; 
						}
					}?></font>
			
			
			</td>
			
			
		  </tr>
		  <? } ?>
		  <? } ?>	
          <tr>
<!--            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio de <? //echo ucwords(strtolower($fila1['nombre_periodo']))?></font></strong></font></td> -->
            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio &nbsp;&nbsp;&nbsp;</font></strong></font></td>
			<?				
			
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by fecha_inicio";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
			$prome_abajo = 0;
			$cont_abajo = 0;
	        for($per=0 ; $per < $tot_periodo ; $per++){
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];

                /*
				$sql_peri = "SELECT notas$nro_ano.promedio ";
				$sql_peri = $sql_peri . "FROM notas$nro_ano, tiene$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') and id_periodo = ".$periodos." ) and tiene$nro_ano.id_ramo <> ".$ramo_religion." and tiene$nro_ano.rut_alumno = notas$nro_ano.rut_alumno and tiene$nro_ano.id_ramo = notas$nro_ano.id_ramo order by id_periodo; ";
				*/
				$sql_peri = "select promedio from notas$nro_ano where rut_alumno = '".$alumno."' and id_periodo = '".$periodos."'";

				$result_peri =@pg_Exec($conn,$sql_peri);
				$prome_abajo = 0;
				$cont_abajo = 0;
								
                $promedio_periodo_aux = 0;				
		        for($pm=0 ; $pm < @pg_numrows($result_peri) ; $pm++)
				{
					$filapm = @pg_fetch_array($result_peri,$pm);							
					if ($filapm['promedio']>0){
						$prome_abajo = $prome_abajo + $filapm['promedio'];
						$cont_abajo = $cont_abajo + 1;
					}
				}
				if ($prome_abajo>0){
					if(($institucion==11209)OR($truncado_per==0)){
						$prome_abajo = intval($prome_abajo/$cont_abajo);
					}else{
						$prome_abajo = round($prome_abajo/$cont_abajo,0);
					}
					$prome_general_pro = $prome_general_pro + $prome_abajo;
					$cont_general_pro = $cont_general_pro + 1;
				}

			    $promedio_periodo_aux = $prome_abajo;
				?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? 
					if($prome_abajo<40 && $prome_abajo>0){ ?><strong><font color="#FF0000"><? 
						 echo $prome_abajo; ?></font><? 
					}
					else { 
						if($prome_abajo==0){
							echo "&nbsp;";
						}else{
							echo $prome_abajo; 
						}
					}?></font></td>								
				<?
			}
			
					
			
			if ($prome_general_pro>0)// keo la caga... muy wuena la wuea
				$prome_general_pro = round($prome_general_pro/$cont_general_pro);

			
				for($jj=0;$jj<$cuenta_examen;$jj++){
					
			?>		
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;</strong></font></td>			         
			<? }
				$Prom_Gral = @intval($Prom_Gral /$cuenta_ramo);
			 ?>
			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
			<? 
					if($Prom_Gral<40 && $Prom_Gral>0){ ?><strong><font color="#FF0000"><? 
						 echo $Prom_Gral; ?></font><? 
					}
					else { 
						if($Prom_Gral==0){
							echo "&nbsp;";
						}else{
							echo $Prom_Gral; 
						}
					}?></strong></font></td>	
          </tr>		  	  
        </table>
		  <? } //for?>
          <? } 
		  
		  
		  
		  //if?>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="153"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?><strong>TOTAL DIAS PERIODO </strong> <? } ?></font></td>
			<td width="237"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?><? echo $dias_habiles ?> <? } ?></font></td>
			<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?><strong>TOTAL DIAS INASISTENTES</strong><? } ?></font></td>
			<td width="78"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?> <? echo $inasistencia ?> <? } ?></font></td>
		  </tr>
		  <tr>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?><strong>TOTAL ASISTENCIAS (%)</strong> <? } ?></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">
			<? if ($_INSTIT==770){ ?>
				       &nbsp;
				 <? }else{ ?>			   
				   
			
			  <? 
					if ($dias_habiles>0)
					{
						$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
						$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
						$prom_cont_asis = $prom_cont_asis + 1;
					}
					echo $promedio_asistencia . "%" ;
					?>
					<? } ?>
			</font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?><strong>TOTAL ATRASOS</strong> <? } ?></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><br>
<? if ($_INSTIT==770){ ?>
				       &nbsp;
				 <? }else{ ?>			   
				   
			<?
			$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD'))";
			$result_atraso =@pg_Exec($conn,$sql_atraso);
			$fila_atraso = @pg_fetch_array($result_atraso,0);
			if (empty($fila_atraso['cantidad']))
				echo "0";
			else
				echo $fila_atraso['cantidad'];
			?>
			<? } ?>
			</font></td>
		  </tr>
		</table>
		<table width="650"  border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></font></div></td>
		  </tr>
		  <!--tr>
		    <td height="22"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
			<? 
				$sql_observa = "select * from observa_informe where rut_alumno = '".$alumno."'";
				$result_observa =@pg_Exec($conn,$sql_observa);
				$fila_observa = @pg_fetch_array($result_observa,0);	
				if (!empty($fila_observa['observacion']))
					echo $fila_observa['observacion'];
				else
					echo "&nbsp;";
			
			?></font></div></td>
		    </tr-->
		</table>
			  <!--div id="capa1">
				<input name="button4" TYPE="button" class="botonX" onClick=window.open("observacion_informe.php?id_curso=<? echo $curso ?>&rut_alumno=<? echo $alumno ?>&id_periodo=<? echo $periodo ?>&curso_aux=<? echo $c_curso?>&alumno_aux=<? echo $c_alumno?>","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=350,top=85,left=140") onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="EDITAR">			  
			  </div-->
		<table width="650" height="72" border="0" cellpadding="0" cellspacing="0">
		<? if ($bool_ed==1) { ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"><? echo "ALUMNO EVALUADO DIFERENCIADAMENTE ";?> 
               </font></strong></font></div></td>
		  </tr>
		  <? } ELSE{ ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"> 
                        <!--Academias:-->
                        </font><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></strong></font></div></td>
		  </tr>
		  <? } ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">
                        <!--Academias:-->
                        </font><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></strong></font></div></td>
		  </tr>
		  <tr>
		    <td height="22"><div align="left"><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></div></td>
	    </tr>
 
		</table>	  
		        <table width="650" border="0" cellpadding="0" cellspacing="0">
				  <?
				  for($e=0 ; $e < 12-$num_subsec ; $e++)
				  {
				  ?>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				   	
				  <? }?>
				  
				   <? 
				 
				  if ($_INSTIT==770){ ?>
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr> 
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>				                    
				  <? } ?>
				  
                  <tr>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">________________________________</font></strong></div></td>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">________________________________</font></strong></div></td>
                  </tr>
                  <tr>
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="1">Profesor(a) Jefe</font></div></td>
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="1"><?=$cargo_dir2 ?> Establecimiento  </font></div></td>
                  </tr>
                  <tr>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1"><? if(($institucion==8930)OR($institucion==770)){  echo $nombre_profesor; }else{ echo $nombre_profe;} ?></font></strong></div></td>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">
                        <?
						
							
					
			$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
			$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
			$sql = $sql . "WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23)";
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
			if($institucion==770){
				echo ucwords(strtoupper(trim($fila['nombre_emp']) . " " . trim($fila['ape_pat']) . " " . trim($fila['ape_mat'])));
			}else{
				echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp']))); 
			    $cargo_dir    = $fila['cargo'];	
		
		
				if ($cargo_dir==1){
					$cargo_dir  = "director(a)";
					$cargo_dir2 = "Director(a)";
				}
				if ($cargo_dir==23){
					$cargo_dir  = "rector(a)";
					$cargo_dir2 = "Rector(a)";
				}
			
			}
			?>
                    </font></strong></div></td>
                  </tr>
                </table>
              </div>
		</td>
      </tr>
    </table>
	
	<? if ($_INSTIT!=770){ ?>
		<table width="100%">
		<tr>
		<td>
	   <? $fecha = date("d-m-Y");?>
		  <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtolower($comuna)).", ". fecha_espanol($fecha) ?></font>
		</td>
		</tr>
		</table>
  <? } ?>
	</td>
  </tr>
  <tr>
   <? if(($institucion =="770") or ($institucion=="11209")){	?>	
	  <tr>
		  <td>&nbsp;</td>
	  </tr>
		<tr>	
		<td colspan="3" align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($fila_com['nom_com'])).", ".fecha_espanol($fecha);?></font></td> 
		</tr>
		<? 	}else{ ?>	
		
		<? if(($institucion!="770") and ($institucion!="11209" ) and ($institucion!="9239") and ($institucion!="25269")){	?> 
    	  <td><?} } ?>
    </table>
<? if($ckCOLILLA==1){	?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - - - - - - - - </strong></font></div></td>
    </tr>
  <tr>
    <td colspan="2"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">Devolver colilla firmada</font> </div></td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td width="124"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
    <td width="245"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $nombre_alumno; ?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtolower($Curso_pal))?></strong></font></div></td>
  </tr>
  <tr>

    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Promedio Alumno</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
	  <?
	if ($promedio_periodo_aux>0)
		echo $promedio_periodo_aux;
	else
		echo "&nbsp;";
		
	?>
	  </strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total D&iacute;as Inasistente </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Período </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo trim($dias_habiles) ?></font></div></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">Total Atrasos </font></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
      <?
	$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= to_date('" . $fecha_ini ."', 'YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD'))";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$fila_atraso = @pg_fetch_array($result_atraso,0);
	if (empty($fila_atraso['cantidad']))
		echo "0";
	else
		echo trim($fila_atraso['cantidad']);
	?>
    </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Asistencias (%) </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
        <? 
			if ($dias_habiles>0)
			{
				$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
				$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
				$prom_cont_asis = $prom_cont_asis + 1;
			}
			echo $promedio_asistencia . "%" ;
			?>
    </font></div></td>
    <td><div align="left">&nbsp;</div></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">___________________________</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Firma Apoderado </font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
 <?	}
}

if  (($cont_alumnos - $cont_paginas)<>1){ 
	echo "<H1 class=SaltoDePagina></H1>";
}



} 

?>

</center>
</form>

<!--                              </td>
							  </tr>
							  </table>
                               </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
        </tr>
      </table></td>
  </tr>
</table>-->
</body>
</html>


</div>
<? pg_close($conn);?>