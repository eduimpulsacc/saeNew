<div align="center">

<? 
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
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
	$reporte		=$c_reporte;
	$sw				=0;
	$rdb = $institucion;
	$ramo_religion = 0;
	if ($curso==0) $sw = 1;
	if ($sw == 1) exit;
	
	$sql_ano = "SELECT nro_ano FROM ano_escolar WHERE id_ano = ".$ano;
	$res_ano = @pg_Exec($conn,$sql_ano);
	$arr_ano = pg_fetch_array($res_ano);
	
	$nro_ano = $arr_ano['nro_ano'];
	
	$sql = "select  * from periodo where id_ano = ".$ano." order by fecha_inicio" ;
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

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
				  
				 
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
 
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
</style>
 
<!-- CODIGO DE DISEÑO NUEVO -->
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
								  
<form method="post" target="mainFrame">
<center>
<div id="capa0">

	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td>
		  <table width="100%">
			<tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
			<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
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
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];		
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
                <td width="114"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
                <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td width="361"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo strtoupper(trim($fila['nombre_instit'])) ?></font></div></td>
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
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); echo $ob_reporte->tildeM($nombre_alumno);?></font></div></td>
                </tr>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>PROFESOR JEFE</strong></font></div></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
				<?
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
					echo ucwords(strtoupper(trim($fila['nombre_emp']) . " " . trim($fila['ape_pat']) . " " . trim($fila['ape_mat'])));
					$nombre_profe = ucwords(strtoupper(trim($fila['nombre_emp']) . " " . trim($fila['ape_pat']) . " " . trim($fila['ape_mat'])));
				
				}else{
					echo $ob_reporte->tildeM(ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp']))));
					$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				}
				?>
				</font></div></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="4" rowspan="6" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
			  
            </table>
            </td>
      </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" class="tableindex"><div align="center">INFORME  DE PROMEDIOS SEMESTRALES</div></td>
      </tr>
     
	 
	  <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo "A&Ntilde;O ".$nro_ano?></strong></font></div></td>
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
				
				
				
				
				
								
				$sql8 = "select count(*) as contador from notas$nro_ano where rut_alumno = '" . $alumno."'";
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
				<br><br>
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231" align="left">
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Subsector del Aprendizaje (Formaci&oacute;n General ) </strong></font></div></td>
            <? 
			$sql_p = "select  * from periodo where id_ano = ".$ano." order by fecha_inicio" ;
			$result_p = pg_Exec($conn,$sql_p);
			$fila_p = pg_numrows($result_p);
			
			for ($i=1; $i<=$fila_p; $i++) { ?>
				<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?=$i?>º<? echo $tipo_per ?></strong></font></td>
			<? }?>
            	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom. Final</strong></font></td>  
            </tr>  
           
           				
		  <?
		  
		  $sql_lista = "SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector,porc_examen, modo_eval FROM ramo INNER JOIN subsector ON (ramo.cod_subsector = subsector.cod_subsector) WHERE ramo.id_curso = ".$curso." AND ramo.id_ramo NOT IN (SELECT formula_hijo.id_hijo FROM formula_hijo) order by ramo.id_orden";
		  $res_lista = pg_Exec($conn,$sql_lista);
		  
		  $final_total = 0;
		  $no_ramos = 0;
		  $prom=0;
		  $promedio_nota=0;
		  while ($arr_lista = pg_fetch_array($res_lista)) {?>
		  		<tr>
          			<td><font size="1" face="Arial, Helvetica, sans-serif"><?=$arr_lista['nombre']?></font></td><?
                    
                $sql_promedios="SELECT promedio, id_periodo FROM notas".$nro_ano." WHERE rut_alumno = ".$alumno." AND id_ramo = ".$arr_lista['id_ramo']." ORDER BY id_periodo";
				$res_promedios = pg_Exec($conn,$sql_promedios);
                
				$prom_final = 0;
				$con_prom = 0;
				$j = $fila_p;
				
				for ($i=1; $i<=$fila_p; $i++){
				$promedio_nota=0;
				$prom_ex=0;
					if ($arr_promedios=pg_fetch_array($res_promedios)) { 
					

					/****** MODULO DE EXAMENES **************/
							$sql = "SELECT id_examen,nota FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$arr_lista['id_ramo']." AND rut_alumno=".$alumno." AND id_ano=".$ano." AND periodo=".$arr_promedios['id_periodo'];
							$rs_examen = @pg_exec($conn,$sql);
							$nota_ex=0;
							for($x=0;$x<pg_numrows($rs_examen);$x++){
								$promedio_nota=0;
								$fila_ex = @pg_fetch_array($rs_examen,$x);
								$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_examen=".$fila_ex['id_examen'];
								$result_ex = @pg_Exec($conn,$sql);
								$porc_ex = pg_result($result_ex,0);
								$bool = pg_result($result_ex,1);
								
								$nota_ex = ($fila_ex['nota'] * $porc_ex)/100;
								$prom_ex = $prom_ex + $nota_ex;
								
							}
								$promedio_nota = ($arr_promedios['promedio'] * $arr_lista['porc_examen'])/100;
								
								if($bool==1){
									$prom = round($promedio_nota + $prom_ex);
								}else{
									$prom = abs($promedio_nota + $prom_ex);
								}
															
						 
						 /************ FIN MODULO EXAMENES ************/  
						//$prom = $arr_promedios['promedio'];
						$prom_final = $prom_final + $prom;
						if ($prom<40) {
							$color='color="#FF0000"';
						} else {
							$color = 'color="#000000"';
						}
						
						if ($arr_lista['modo_eval']==2 or $arr_lista['modo_eval']==3){
							$con_prom = conceptual($arr_promedios['promedio'],2)+$con_prom;
							$prom = $arr_promedios['promedio'];
							$color = 'color="#000000"';
						}
						/*if ($arr_lista['cod_subsector']==13 or $arr_lista['cod_subsector']==413) {
							$con_prom = conceptual($arr_promedios['promedio'],2)+$con_prom;
							$prom = $arr_promedios['promedio'];
							$color = 'color="#000000"';
						}*/
						
					} else {
					
						if ($arr_lista['cod_subsector']==13 or $arr_lista['cod_subsector']==413) {
							$prom = "-";
							$j--;
							$color = 'color="#000000"';
						} else {
							$prom = 0;
							$j--;
							$color = 'color="#000000"';
						}
					}?>
					
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" <?=$color?>><?=$prom?></font></td>
					
<?				}

				/*if ($arr_lista['cod_subsector']==13 or $arr_lista['cod_subsector']==413) {*/
				if ($arr_lista['modo_eval']==2 or $arr_lista['modo_eval']==3){
					if($con_prom>0)
						$final = $con_prom/$j;
					else
						$final=0;
					if ($final<40) {
						$color='color="#FF0000"';
					} else {
						$color = 'color="#000000"';
					}
					$final = conceptual($final,1);
				} else {
					if ($prom_final == 0 || $j == 0) {
						$final = 0;
						$color = 'color="#000000"';
					} else {
						$final = round($prom_final/$j);
						if ($final<40) {
							$color='color="#FF0000"';
						} else {
							$color = 'color="#000000"';
						}
					}
				}
				
						
				
				?>
				
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" <?=$color?>><?=$final?></font></td>
          	</tr>
          <?	if ($arr_lista['cod_subsector']!=13 and $arr_lista['cod_subsector']!=413) {
		  			$final_total = $final_total + $final;
					if ($final > 0) {
		  				$no_ramos++;
					}
				}
		  		
		  }
		  
		  
		  
		  
		  $cont_prom = 0;
		  $promedio = 0;

		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip ";
		  $sql2 = $sql2 . "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector and ramo.cod_subsector < 50000) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) AND (ramo.id_ramo = tiene$nro_ano.id_ramo) ";
   		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)='".$alumno."')) order by ramo.id_orden; ";



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
				$modo_eval = $fila['modo_eval'];
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
						echo $prome_1;?></font><? 
					} else { 
						echo $prome_1; 
					}?></font></td>								
				<?
			}
?>
		  </tr>
 <? } ?>		  
          <tr>

            <td height="25" colspan="<?=$fila_p+1?>" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio &nbsp;&nbsp;&nbsp;</font></strong></font></td>
			<? ?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?=round($final_total/$no_ramos);?></font></td>								
				<?
			/*}*/
			if ($prome_general_pro>0)// ordinarios
				$prome_general_pro = round($fina_total/$no_ramos);

			?>
          </tr>
		 

        </table>
		        
		<? } //for?>
		<? } //if?> 
		
		<!-- ASISTENCIA Y ATRASOS -->
		<table width="650" border="0" cellspacing="0" cellpadding="0">
			<tr>
		<? if ($_INSTIT!=12829){ ?>	<td width="153"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?> <strong>TOTAL DIAS PERIODO </strong><? } ?></font></td>
			<td width="237"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?> <? echo $dias_habiles ?> <? } ?></font></td><? } ?>
	   <? if ($_INSTIT==12829){ ?>	<td width="153"><font size="1" face="Arial, Helvetica, sans-serif"> <strong>TOTAL HORAS A TRABAJAR </strong></font></td>
			<td width="237"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 1592 </font></td><? } ?>
			<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?><strong>TOTAL DIAS INASISTENTES</strong><? } ?></font></td>
			<td width="78"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?> <? echo $inasistencia ?><? } ?> </font></td>
		  </tr>
		  <tr>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?><strong>TOTAL ASISTENCIAS (%)</strong><? } ?></font></td>
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
			<td><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?><strong>TOTAL ATRASOS</strong><? } ?></font></td>
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
		<!-- FIN ASISTENCIA Y ATRASOS -->
		
		
		<HR width="100%" color=#003b85>
		
		
		<table width="650" height="38" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="16"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></font></div></td>
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
		 <? if($bool_ed==1) { ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"><? echo "ALUMNO EVALUADO DIFERENCIADAMENTE ";?> 
               </font></strong></font></div></td>
		  </tr>
		  <? }else{ ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"> 
                        <!--Academias:-->
                        </font><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></strong></font></div></td>
		  </tr>
		  <? } ?>
		  <tr>
		    <td height="22"><div align="left"><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></div></td>
		    </tr>
		  <tr>
		    <td height="23"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font></div></td>
		    </tr>
		</table>
		
		<table width="650" border="0" align="center">
              <tr>
                <?  
			
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
	            <td width="25%" class="item" height="100"><div align="center">________________________________ <br>
                        <?=$ob_reporte->nombre_emp;?>
                        <br>
                        <?=$ob_reporte->nombre_cargo;?>
                </div></td>
                <? 		
				} ?>
                <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
                <td width="25%" class="item"><div align="center">________________________________ <br>
                        <?=$ob_reporte->nombre_emp;?>
                        <br>
                        <?=$ob_reporte->nombre_cargo;?>
                </div></td>
                <? } ?>
                <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
                <td width="25%" class="item"><div align="center">________________________________ <br>
                        <?=$ob_reporte->nombre_emp;?>
                        <br>
                        <?=$ob_reporte->nombre_cargo;?>
                </div></td>
                <? } ?>
                <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
                <td width="25%" class="item"><div align="center">________________________________ <br>
                        <?=$ob_reporte->nombre_emp;?>
                        <br>
                        <?=$ob_reporte->nombre_cargo;?>
                </div></td>
                <? }?>
              </tr>
            </table>			  
		        <table width="100%">
  <tr>
   <td>
   <? $fecha = date("d-m-Y");?>
      <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtolower($comuna)).", ". fecha_espanol($fecha) ?></font>
	</td>
  </tr>
  </table>
            <br><br>
            		</td>
      </tr>
    </table>
	</td>
  </tr>
	  <tr>
		  <td>&nbsp;</td>
	  </tr>
		
    </table>
<? if(($institucion!="770") and ($institucion!="11209" ) and ($institucion!="9239")){	?>
<?	}

	if  (($cont_alumnos - $cont_paginas)<>1){ 
		echo "<H1 class=SaltoDePagina></H1>";
	}


}


?>
</center>
</form>

</body>
</html>


</div>
<? pg_close($conn);?>