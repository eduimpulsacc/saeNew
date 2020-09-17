<? 
	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include('../../../../../clases/class_Membrete.php');
//setlocale("LC_ALL","es_ES");
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
	$curso			=$cmb_curso;
	$alumno		    =$cmb_alumno;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	$sw				=0;
	$rdb = $institucion;
	$ramo_religion = 0;
	if ($curso==0) $sw = 1;
	if ($periodo==0) $sw = 1;
	if ($sw == 1) exit;



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


	
if($cb_ok!="Search"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Report_card_$fecha_actual.xls"); 	 
}	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>&nbsp;</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }

</style> 

<!-- CODIGO DE DISEÑO NUEVO -->
 <script language="javascript" type="text/javascript">

		  
		function exportar(){
			window.location='printNotasParcialesIngles_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&cmb_periodos=<?=$periodo?>&xls=1';
			return false;
		  }		  
</script>

</head>
<body topmargin="0" leftmargin="0" rightmargin="0">

						  
<form method="post" target="mainFrame">
<center>
<div id="capa0">
  <table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	  <table width="100%">
	    <tr>
	      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CLOSE"></td>
	      <td align="right">
		<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="PRINT">
		<? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORT">
			<? }?>
				</td></tr></table>

</td>
  </tr>
</table> 
</div>

<?
	if (empty($alumno))
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno ='" . $alumno ."' and id_ano = " . $ano;
		
	$result_alu =@pg_Exec($conn,$sql_alu);
	$cont_alumnos = @pg_numrows($result_alu);

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
{
	$prome_general_pro = 0;
	$cont_general_pro = 0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$bool_ed = $fila_alu['bool_ed'];

	//---------------------------
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
			
if (($fila['ensenanza']>109 and $fila['ensenanza']<310) or ($fila['ensenanza']>300 and $fila['grado_curso']<3)){  ?>
<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
            <td width="100%">
			
			
			
		<? if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br><br><br>";
			   
		  }else{
		
		    ?>	
			
			
			<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
			  <tr>
                <td width="114" class="item"><div align="left"><strong>INSTITUTION</strong></div></td>
                <td width="9"><strong>:</strong></td>
                <td width="361" class="subitem"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
                <td width="161" rowspan="7" align="center" valign="top" >
				<?
					$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					## código para tomar la insignia
		
				  if($institucion!=""){
					   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>				
				  </td>
              <tr>
                <td class="item"><div align="left"><strong>YEAR</strong></div></td>
                <td><strong>:</strong></td>
                <td class="subitem"><div align="left"><? echo trim($nro_ano) ?></div></td>
                </tr>
              <tr>
                <td class="item"><div align="left"><strong>CLASS</strong></div></td>
                <td><strong>:</strong></td>
                <td class="subitem"><div align="left"><? echo $Curso_pal; ?></div></td>
                </tr>	
              <tr>
                <td class="item"><div align="left"><strong>NAME</strong></div></td>
                <td><strong>:</strong></td>
                <td class="subitem"><div align="left"><?  $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); echo $ob_reporte->tildeM($nombre_alumno);?></div></td>
                </tr>
              <tr>
                <td class="item"><div align="left"><strong>TEACHER</strong></div></td>
                <td><div align="left"><strong>:</strong></div></td>
                <td class="subitem"><div align="left"><? echo $ob_reporte->tildeM($ob_reporte->profe_jefe); ?></div></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="4" rowspan="5" align="center">&nbsp;</td>
              </tr>
			  
            </table>
			
		  <? } ?>		
			
			
      </td>
      </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" class="tableindex"><div align="center">REPORT CARD</div></td>
      </tr>
      <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
		<? 
			$periodo_nuevo= trim(strtoupper($fila1['nombre_periodo'])) ;
			if( !strcasecmp($periodo_nuevo,"PRIMER TRIMESTRE")  ){
				$periodo_nuevo="FIRST TRIMESTER"; }
			if( !strcasecmp($periodo_nuevo,"SEGUNDO TRIMESTRE")  ){
				$periodo_nuevo="SECOND TRIMESTER"; }
			if( !strcasecmp($periodo_nuevo,"TERCER TRIMESTRE")  ){
				$periodo_nuevo="THIRD TRIMESTER"; }
			if( !strcasecmp($periodo_nuevo,"PRIMER SEMESTRE")  ){
				$periodo_nuevo="FIRST SEMESTER"; }
			if( !strcasecmp($periodo_nuevo,"SEGUNDO SEMESTRE")  ){
				$periodo_nuevo="SECOND SEMESTER"; }

			echo ucwords($periodo_nuevo." ".$nro_ano);?>
		</strong></font></div></td>
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
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Subjects</strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Parcial Grades</font></strong></td>
			<? 
			$sql_p = "select  * from periodo where id_ano = ".$ano." order by fecha_inicio" ;
			$result_p = pg_Exec($conn,$sql_p);
			$fila_p = pg_num_rows($result_p);
			$p1 = pg_fetch_array($result_p,0);
			$p1=$p1['id_periodo'];
			$p2 = pg_fetch_array($result_p,1);
			$p2 = $p2['id_periodo']; 
			if($fila_p > 2){
				$p3 = pg_fetch_array($result_p,2);
				$p3 = $p3['id_periodo'];			
			}						
			if($p1==$periodo){
			$tot_periodo=1;?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
			<? }			
			if($p2==$periodo){
			$tot_periodo=2;?>			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
			<?	}		
			if($p3==$periodo){
			$tot_periodo=3;?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>						
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>						
			<? }?>			         
            </tr>
		  <?
		  $cont_prom = 0;

		  $promedio = 0;
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
			?>		
          <tr>
		  <?
			$ob_reporte ->rut_alumno = $alumno;
			$ob_reporte ->ramo = $id_ramo;
			$ob_reporte ->periodo = $id_periodo;
			$result2 = $ob_reporte->Notas($conn);
		  	if (!$result2) {
				  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
    		}else{
	    			if (pg_numrows($result2)!=0){
					  $fila2 = @pg_fetch_array($result2,0);	
					  if (!$fila2){
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
					  }
				  }
			  }
				$fila2 = @pg_fetch_array($result2,$f);
					$ob_reporte ->modo_eval =$modo_eval;
				$ob_reporte ->CambiaNota($fila2);
			?>
            <td height="25" class="subitem"><div align="left"><? echo $fila['nombre_ingles']; ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font></strong><? } else { echo $ob_reporte->nota1; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?></font></strong><? } else { echo $ob_reporte->nota2; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?></font></strong><? } else { echo $ob_reporte->nota3; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font></strong><? } else { echo $ob_reporte->nota4; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font></strong><? } else { echo $ob_reporte->nota5; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font></strong><? } else { echo $ob_reporte->nota6; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font></strong><? } else { echo $ob_reporte->nota7; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font></strong><? } else { echo $ob_reporte->nota8; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font></strong><? } else { echo $ob_reporte->nota9; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font></strong><? } else { echo $ob_reporte->nota10; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font></strong><? } else { echo $ob_reporte->nota11; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font></strong><? } else { echo $ob_reporte->nota12; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font></strong><? } else { echo $ob_reporte->nota13; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font></strong><? } else { echo $ob_reporte->nota14; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font></strong><? } else { echo $ob_reporte->nota15; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font></strong><? } else { echo $ob_reporte->nota16; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font></strong><? } else { echo $ob_reporte->nota17; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font></strong><? } else { echo $ob_reporte->nota18; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font></strong><? } else { echo $ob_reporte->nota19; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font></strong><? } else { echo $ob_reporte->nota20; } ?></div></td>
			 <? $ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
 
 					$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->periodo = $periodos;
					$result_peri =$ob_reporte ->Notas($conn);
				
					if (pg_numrows($result_peri)>0){ 
						$fila_peri = @pg_fetch_array($result_peri,0);
						if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio'])){
							$prome_1 = "&nbsp;";
						} else {
							if ($fila_peri['promedio']>0){
								$prome_1 = round($fila_peri['promedio'],0);					
							}else{
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
                    <td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? 
						if($prome_1<40 && $prome_1>0){ ?>
                      <strong><font color="#FF0000">
                        <? 
							echo $prome_1;?>
                        </font>
                        <? 
						} else { 
							echo $prome_1; 
						}?>
                      </strong></font></td>
					  
				<? } ?>
                  </tr>
 <? } ?>		  
          <tr>

            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Final Term Grade &nbsp;&nbsp;&nbsp;</font></strong></font></td>
			  <?
			$ob_reporte ->ano = $ano;
			$resultPer = $ob_reporte ->TotalPeriodo($conn);
			
			$prome_abajo = 0;
			$cont_abajo = 0;
	        for($per=0 ; $per < $tot_periodo ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];
				
				$ob_reporte ->nro_ano 	= $nro_ano;
				$ob_reporte ->periodos 	= $periodos;
				$ob_reporte ->alumno 	= $alumno;
				$ob_reporte ->PromedioAlumno($conn);
				
				if($truncado_per==0){
					$prome_abajo = intval($ob_reporte->suma / $ob_reporte->contador);
				}else{
					$prome_abajo = round($ob_reporte->suma / $ob_reporte->contador,0);
				}
				  $promedio_periodo_aux = $prome_abajo;
				?>
					<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?></font></td>								
					<?
				
			}
			if ($prome_general_pro>0)// keo la caga... muy wuena la wuea
				$prome_general_pro = round($prome_general_pro/$cont_general_pro);

			?>
          </tr>
		 

        </table>
		        
		<? } //for?>
		<? } //if?> 
		<HR width="100%" color=#003b85>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="153"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DAY PERIOD </strong></font></td>
			<td width="237"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $dias_habiles ?></font></td>
			<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL INASISTENTES DAY</strong></font></td>
			<td width="78"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></td>
		  </tr>
		  <tr>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATTENDANCES (%)</strong></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">
			  <? 
					if ($dias_habiles>0)
					{
						$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
						$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
						$prom_cont_asis = $prom_cont_asis + 1;
					}
					echo $promedio_asistencia . "%" ;
					?>
			</font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DELAYS</strong></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">
			<?
					$ob_reporte ->alumno = $alumno;
					$ob_reporte ->tipo =2;
					$ob_reporte ->fecha_inicio = $fecha_ini;
					$ob_reporte ->fecha_termino = $fecha_fin;
					$result_atraso =$ob_reporte ->Anotaciones($conn);
					$fila_atraso = @pg_fetch_array($result_atraso,0);
					echo @pg_numrows($result_atraso);
			?>
			</font></td>
		  </tr>
		  
		</table>
		<table width="650"  border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td ><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Teacher's Comments:</font></strong></font></div></td>
		  </tr>
		 
			
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
		    <td height="22"><div align="left"><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></div></td>
		    </tr>
		  
		</table>			  
		        <table width="100%" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    			<td width="25%" class="item" height="100"><div align="center">________________________________
				<br>       
				  <?=$ob_reporte->nombre_emp;?>
				  <br>
				  <?=$ob_reporte->nombre_cargo;?>
				</div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"> <div align="center">________________________________
       <br>
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><div align="center">________________________________
        <br>
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"> <div align="center">________________________________
       <br>
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
              </div>
		</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="../../tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - - - - - - - - </strong></font></div>
    </table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">To Give Back Signed</font> </div></td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td width="124"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Name</strong></font></div></td>
    <td width="245"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $ob_reporte->tildeM($nombre_alumno); ?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Class</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $ob_reporte->tilde(ucwords(strtolower($Curso_pal)))?></strong></font></div></td>
  </tr>
  <tr>

    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Final Term Grade</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
	  <?
	if ($promedio_periodo_aux>0)
		echo $promedio_periodo_aux;
	else
		echo "&nbsp;";
		
	?>
	  </strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Inasistentes Day</font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Day Period  </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo trim($dias_habiles) ?></font></div></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">Total Delays </font></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
      <?
	$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD'))";
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Empowered Signature</font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
 <? 
}


if ($fila['ensenanza']>300 and $fila['grado_curso']>2){
?>
<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
            <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			    <td width="115" class="item"><div align="left"><strong>INSTITUTION</strong></div></td>
			    <td width="10"><strong>:</strong></td>
			    <td width="359" class="subitem"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
                <td width="161" rowspan="7" align="center" valign="top" >
<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>				</td>
              <tr>
                <td class="item"><div align="left"><strong>YEAR</strong></div></td>
                <td><strong>:</strong></td>
                <td class="subitem"><div align="left"><? echo trim($nro_ano) ?></div></td>
                </tr>
              <tr>
                <td class="item"><div align="left"><strong>CLASS</strong></div></td>
                <td><strong>:</strong></td>
                <td class="subitem"><div align="left"><? echo $Curso_pal; ?></div></td>
                </tr>	
              <tr>
                <td class="item"><div align="left"><strong>NAME</strong></div></td>
                <td><strong>:</strong></td>
                <? if($institucion==8930){?>
				<td class="subitem"><font size="1">
				  <? Nombre($fila['ape_pat'],$fila['ape_mat'],$fila['nombre_alu'])?>
				</font></td> 
				<? }else{?>
				<td class="subitem"><div align="left"><?  $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); echo $ob_reporte->tildeM($nombre_alumno);?></div></td> 
				<? } ?>
                </tr>
              <tr>
                <td class="item"><div align="left"><strong>TEACHER</strong></div></td>
                <td><div align="left"><strong>:</strong></div></td>
                <td class="subitem"><div align="left"><font size="1"><? echo $ob_reporte->tildeM($ob_reporte->profe_jefe);?></font></div></td>
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
        <td height="20"  class="tableindex"><div align="center">REPORT CARD</div></td>
      </tr>
      <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
		<? 
			$periodo_nuevo= trim(strtoupper($fila1['nombre_periodo'])) ;
			if( !strcasecmp($periodo_nuevo,"PRIMER TRIMESTRE")  ){
				$periodo_nuevo="FIRST TRIMESTER"; }
			if( !strcasecmp($periodo_nuevo,"SEGUNDO TRIMESTRE")  ){
				$periodo_nuevo="SECOND TRIMESTER"; }
			if( !strcasecmp($periodo_nuevo,"TERCER TRIMESTRE")  ){
				$periodo_nuevo="THIRD TRIMESTER"; }
			if( !strcasecmp($periodo_nuevo,"PRIMER SEMESTRE")  ){
				$periodo_nuevo="FIRST SEMESTER"; }
			if( !strcasecmp($periodo_nuevo,"SEGUNDO SEMESTRE")  ){
				$periodo_nuevo="SECOND SEMESTER"; }

			echo ucwords($periodo_nuevo." ".$nro_ano);?>
		</strong></font></div></td>
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
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Subjects (General Formation) </strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Parcial Grades</font></strong></td>
			<?
		  	$sql_peri = "SELECT distinct id_periodo FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."')) order by id_periodo;";
			$result_peri =@pg_Exec($conn,$sql_peri);
			$cantidad_periodos = @pg_numrows($result_peri);	
			$tri = 0;
			$tot_periodo=1;
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
			<?			
			$tri = 2;
			$tot_periodo=2;
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
			<?
			if ($num_periodos==3){
			$tri = 3;
			$tot_periodo=3;
			?>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>						
			<? }?>			         
            </tr>         
		  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->RamoAlumnoGeneral($conn);
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
				$modo_eval = $fila['modo_eval '];
			?>		
          <tr>
		  <?
		  	$ob_reporte ->rut_alumno = $alumno;
			$ob_reporte ->ramo = $id_ramo;
			$ob_reporte ->periodo = $id_periodo;
			$result2 = $ob_reporte->Notas($conn);
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
				$ob_reporte ->CambiaNota($fila2);
			?>
            <td height="25" class="subitem"><div align="left"><? echo $fila['nombre_ingles']; ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font></strong><? } else { echo $ob_reporte->nota1; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?></font></strong><? } else { echo $ob_reporte->nota2; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?></font></strong><? } else { echo $ob_reporte->nota3; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font></strong><? } else { echo $ob_reporte->nota4; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font></strong><? } else { echo $ob_reporte->nota5; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font></strong><? } else { echo $ob_reporte->nota6; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font></strong><? } else { echo $ob_reporte->nota7; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font></strong><? } else { echo $ob_reporte->nota8; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font></strong><? } else { echo $ob_reporte->nota9; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font></strong><? } else { echo $ob_reporte->nota10; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font></strong><? } else { echo $ob_reporte->nota11; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font></strong><? } else { echo $ob_reporte->nota12; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font></strong><? } else { echo $ob_reporte->nota13; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font></strong><? } else { echo $ob_reporte->nota14; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font></strong><? } else { echo $ob_reporte->nota15; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font></strong><? } else { echo $ob_reporte->nota16; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font></strong><? } else { echo $ob_reporte->nota17; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font></strong><? } else { echo $ob_reporte->nota18; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font></strong><? } else { echo $ob_reporte->nota19; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font></strong><? } else { echo $ob_reporte->nota20; } ?></div></td>
			<? 	$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					//-------
					$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->periodo = $periodos;
					$result_peri =$ob_reporte ->Notas($conn);
				
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
	            <td align="center" class="subitem">
				<? 
					if($prome_1<40 && $prome_1>0){ ?><strong><font color="#FF0000"><? 
						 echo $prome_1; ?></font></strong><? 
					}
					else { 
						echo $prome_1; 
					}?></td>								
				<?
			}
?>
		  </tr>
		  <? } ?>
		  <?
		  $ob_reporte ->alumno =$alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->RamoAlumnoDiferenciada($conn);
		  $result = $ob_reporte->result;
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
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Subjects (Differentiated Formation) </strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Parcial Grades</font></strong></td>
			<?
		  	$sql_peri = "SELECT distinct id_periodo FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."')) order by id_periodo;";
			$result_peri =@pg_Exec($conn,$sql_peri);
			$cantidad_periodos = @pg_numrows($result_peri);	
			$tri = 0;
			$tri = 1;
			$tot_periodo=1;
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
			<?			
			$tri = 2;
			$tot_periodo=2
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
			<?			
			if ($num_periodos==3){
			$tri = 3;
			$tot_periodo=3;
			?>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>						
			<? }?>			         
            </tr>
<?
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];				
				
			?>		
          <tr>
		  <?
		  $ob_reporte ->alumno =$alumno;
		  $ob_reporte ->ramo = $id_ramo;
		  $ob_reporte ->periodo = $id_periodo;
		  $result2 = $ob_reporte ->Notas($conn);
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
				$ob_reporte ->CambiaNota($fila2);
			?>
            <td height="25" class="subitem"><div align="left"><? echo $fila['nombre_ingles']; ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font></strong><? } else { echo $ob_reporte->nota1; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?></font></strong><? } else { echo $ob_reporte->nota2; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?></font></strong><? } else { echo $ob_reporte->nota3; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font></strong><? } else { echo $ob_reporte->nota4; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font></strong><? } else { echo $ob_reporte->nota5; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font></strong><? } else { echo $ob_reporte->nota6; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font></strong><? } else { echo $ob_reporte->nota7; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font></strong><? } else { echo $ob_reporte->nota8; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font></strong><? } else { echo $ob_reporte->nota9; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font></strong><? } else { echo $ob_reporte->nota10; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font></strong><? } else { echo $ob_reporte->nota11; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font></strong><? } else { echo $ob_reporte->nota12; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font></strong><? } else { echo $ob_reporte->nota13; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font></strong><? } else { echo $ob_reporte->nota14; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font></strong><? } else { echo $ob_reporte->nota15; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font></strong><? } else { echo $ob_reporte->nota16; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font></strong><? } else { echo $ob_reporte->nota17; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font></strong><? } else { echo $ob_reporte->nota18; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font></strong><? } else { echo $ob_reporte->nota19; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font></strong><? } else { echo $ob_reporte->nota20; } ?></div></td>
			<? 			if(Trim($fila2['promedio'])=="0" or empty($fila2['nota20'])){
				$prom = "&nbsp;";
			}else{
				$prom = $fila2['promedio'];}  
				
			if (number_format($prom) > 0 and ($fila['nombre_ingles']<>"RELIGION")) 
			  {
				  $cont_prom=$cont_prom+1;
				  //echo "Contador ". $cont_prom. "<br>";
				  $promedio = ($promedio + $prom);
				  //echo "Suma" . $promedio ;
			} //else {
			if($fila['nombre_ingles']=="RELIGION"){
				$ramo_religion = $fila['id_ramo'];
			}
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by fecha_inicio";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
	        for($per=0 ; $per < @pg_numrows($resultPer) ; $per++)
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

				?>
	            <td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif"><? 
					if($prome_1<40 && $prome_1>0){ ?><strong><font color="#FF0000"><? 
						echo $prome_1;?></font><? 
					} else { 
						echo $prome_1; 
					}?></font></td>								
				<?
			}
?>
		  </tr>
		  <? } ?>
		  <? } ?>	
          <tr>
            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Final Term Grade &nbsp;&nbsp;&nbsp;</font></strong></font></td>
			<?
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by fecha_inicio";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
			$prome_abajo = 0;
			$cont_abajo = 0;
	        for($per=0 ; $per < @pg_numrows($resultPer) ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];

				//-------
			  	$sql_peri = "SELECT notas$nro_ano.promedio ";
				$sql_peri = $sql_peri . "FROM notas$nro_ano, tiene$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') and id_periodo = ".$periodos." ) and tiene$nro_ano.id_ramo <> ".$ramo_religion." and tiene$nro_ano.rut_alumno = notas$nro_ano.rut_alumno and tiene$nro_ano.id_ramo = notas$nro_ano.id_ramo order by id_periodo; ";
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
					if($institucion==11209){
						$prome_abajo = intval($prome_abajo/$cont_abajo);
					}else{
						$prome_abajo = round($prome_abajo/$cont_abajo,0);
					}
					$prome_general_pro = $prome_general_pro + $prome_abajo;
					$cont_general_pro = $cont_general_pro + 1;
				}

/*				if ($periodos<>$periodo)
					 $prome_abajo = 0;
				else
*/					 $promedio_periodo_aux = $prome_abajo;
				?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?></font></td>								
				<?
			}
			if ($prome_general_pro>0)// keo la caga... muy wuena la wuea
				$prome_general_pro = round($prome_general_pro/$cont_general_pro);

			?>
          </tr>		  	  
        </table>
		  <? } //for?>
          <? } //if?>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="153"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DAY PERIOD </strong></font></td>
			<td width="237"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $dias_habiles ?></font></td>
			<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL INASISTENTES DAY</strong></font></td>
			<td width="78"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></td>
		  </tr>
		  <tr>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATTENDANCES (%)</strong></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">
			  <? 
					if ($dias_habiles>0)
					{
						$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
						$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
						$prom_cont_asis = $prom_cont_asis + 1;
					}
					echo $promedio_asistencia . "%" ;
					?>
			</font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DELAYS</strong></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">
			<?
			$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD'))";
			$result_atraso =@pg_Exec($conn,$sql_atraso);
			$fila_atraso = @pg_fetch_array($result_atraso,0);
			if (empty($fila_atraso['cantidad']))
				echo "0";
			else
				echo $fila_atraso['cantidad'];
			?>
			</font></td>
		  </tr>
		</table>
		<table width="650"  border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Teacher's Comments:</font></strong></font></div></td>
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
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">
                        <!--Academias:-->
                        </font><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></strong></font></div></td>
		  </tr>
		  <tr>
		    <td height="22"><div align="left"><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></div></td>
		    </tr>
		  
		</table>			  
		        <table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    			<td width="25%" class="item" height="100"><div align="center">________________________________
				<br>       
				  <?=$ob_reporte->nombre_emp;?>
				  <br>
				  <?=$ob_reporte->nombre_cargo;?>
				</div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"> <div align="center">________________________________
       <br>
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><div align="center">________________________________
        <br>
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"> <div align="center">________________________________
       <br>
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
              </div>
		</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="../../tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - - - - - - - - - - </strong></font></div>
    </table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">To Give Back Signed</font> </div></td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td width="124"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Name</strong></font></div></td>
    <td width="245"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $nombre_alumno; ?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Class</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtolower($Curso_pal))?></strong></font></div></td>
  </tr>
  <tr>

    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Final Term Grade</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
	  <?
	if ($promedio_periodo_aux>0)
		echo $promedio_periodo_aux;
	else
		echo "&nbsp;";
		
	?>
	  </strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Inasistentes Day </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Day Period </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo trim($dias_habiles) ?></font></div></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">Total Delays </font></td>
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
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Attendances (%) </font></div></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Empowered Signature </font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
 <?
}

if  (($cont_alumnos - $cont_paginas)<>1){ 
	echo "<H1 class=SaltoDePagina></H1>";
}



} 

?>

</center>
</form>
</body>
</html>

<? pg_close($conn);?>
