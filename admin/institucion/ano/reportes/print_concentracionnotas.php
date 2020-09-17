<?php require('../../../../util/header.inc');
//setlocale(LC_ALL,"es_ES");
$rut_alumno=$cmb_alumno;
$whe_conceptos=	"and promedio not in ('I','S','B','MB')";

function imprime_arreglo($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";
}



$query_ins_ano="select * from institucion as ins, ano_escolar as ano where ins.rdb='$_INSTIT' and  ano.id_ano='$_ANO'";
$row_ano=pg_fetch_array(pg_exec($conn,$query_ins_ano));


///////////////////
$institucion = $_INSTIT;
$ano			=$_ANO;
$checkbox1  =  $_POST[checkbox1] ;

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





			$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nu_resolucion, institucion.fecha_resolucion, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
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
			$resolucion = $fila_ins['nu_resolucion'];
			$fecha_resolucion = $fila_ins['fecha_resolucion'];
			$separa_fecha = explode("-",$fecha_resolucion);
			$separa_ano = $separa_fecha[0];
			$separa_mes = $separa_fecha[1];
			$separa_dia = $separa_fecha[2];
			$fecha_resolucion = $separa_dia."-".$separa_mes."-".$separa_ano;
			$fecha_convertida = fecha_espanol($fecha_resolucion);	
			
if ($institucion==2278){
	$cargo_dir  = "director(a)";
	$cargo_dir2 = "Director(a)";
}
if ($institucion==9239){
    $cargo_dir  = "Directora";
	$cargo_dir2 = "Directora";
}					


if($cb_ok!="Buscar" & $cb_exp=="EXPORTAR"){
 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Concentracion_notas_$fecha_actual.xls"); 	 
	}	



//$query_anos=$
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Concentraciones de Notas</title>
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">

	<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
td{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	font-style: normal;
	font-weight: normal;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{

     PAGE-BREAK-AFTER: always; height:0;line-height:0
}
-->
    </style>
<SCRIPT language="JavaScript">
<!--



function imprimir(){
Element = document.getElementById("botones");
Element.style.display='none';
Element = document.getElementById("motor");
Element.style.display='none';
Element = document.getElementById("menu");
Element.style.display='none';
window.print();
Element = document.getElementById("botones");
Element.style.display='';
Element = document.getElementById("motor");
Element.style.display='';
Element = document.getElementById("menu");
Element.style.display='';

}
function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'concentracionnotas.php';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}


//-->
</script>
</head>
<body onload="window.print();">
<div id="menu"></div>
<? if ($rut_alumno){?>
<? 

$query_decreto="select plan.* from  curso , plan_estudio as plan  where curso.id_curso='$cmb_curso' and plan.cod_decreto=curso.cod_decreto";
$result_decreto=pg_exec($conn,$query_decreto);
$num_decreto=pg_numrows($result_decreto);
if ($num_decreto>0){
	$row_decreto=pg_fetch_array($result_decreto);
	$arreglo=explode(" ",$row_decreto[nombre_decreto]);
	$decreto_numero=$arreglo[0];
	$decreto_ano=$arreglo[2];
}

$query_alumno="select * from alumno  where rut_alumno='$rut_alumno'";
$result_alumno=@pg_exec($conn,$query_alumno);
$num_alumno=@pg_numrows($result_alumno);
if ($num_alumno>0){
	$row_alumno=pg_fetch_array($result_alumno);
}
$ramo_id=array();
$ramo_nombre=array();
$cod_subsector=array();

$query_matricula="select * from matricula as mat, ano_escolar as ano, curso as curso where mat.rut_alumno='$rut_alumno' and mat.id_ano=ano.id_ano and curso.id_curso=mat.id_curso and bool_ar = '0'  and mat.id_ano in (select id_ano from promocion where rut_alumno = '$rut_alumno' and situacion_final <> '2') order by nro_ano Desc ;";
$result_matricula=@pg_exec($conn,$query_matricula);
$num_matricula=@pg_numrows($result_matricula);
for ($i=0;$i<$num_matricula; ++$i){
	$row_matricula=pg_fetch_array($result_matricula);
	$curso_grado=$row_matricula[grado_curso];
	//imprime_arreglo($row_matricula);
	$anos_id[$curso_grado]=$row_matricula[id_ano];
	$grado_curso[$curso_grado]=$row_matricula[grado_curso];
	$nro_ano[$curso_grado]=$row_matricula[nro_ano];
	$aproxima[$curso_grado]=$row_matricula[truncado_per];
	$curso_id[$curso_grado]=$row_matricula[id_curso];
	$origen[$curso_grado]=1;
	
//	 $query_tiene="select ramo.id_ramo,sub.nombre ,ramo.modo_eval ,ramo.cod_subsector from tiene$row_matricula[nro_ano] as tiene, ramo as ramo, subsector as sub where tiene.rut_alumno='$rut_alumno' and tiene.id_ramo=ramo.id_ramo and ramo.cod_subsector=sub.cod_subsector";
//	$query_tiene="select * from ramo r inner join tiene".$row_matricula[nro_ano]." t on t.id_ramo=r.id_ramo inner join subsector s on s.cod_subsector=r.cod_subsector where t.rut_alumno=".$rut_alumno;
	$query_tiene="select * from ramo r inner join tiene".$row_matricula[nro_ano]." t on t.id_ramo=r.id_ramo inner join subsector s on s.cod_subsector=r.cod_subsector inner join curso c on c.id_curso=r.id_curso where r.bool_ip = '1' and t.rut_alumno=".$rut_alumno." and (c.ensenanza=310 or c.ensenanza=410 or c.ensenanza=510 or c.ensenanza=610 or c.ensenanza=710 or c.ensenanza=810 or c.ensenanza=360 or c.ensenanza=460 or c.ensenanza=560 or c.ensenanza=660 or c.ensenanza=760 or c.ensenanza=860 or c.ensenanza=461 or c.ensenanza=561 or c.ensenanza=661 or c.ensenanza=761 or c.ensenanza=861 or c.ensenanza=361 ) order by r.id_orden";
	$result_tiene=@pg_exec($conn,$query_tiene);
	$num_tiene=@pg_numrows($result_tiene);
	for ($j=0;$j<$num_tiene; ++$j){
		$row_tiene=pg_fetch_array($result_tiene);
		if (!in_array($row_tiene[cod_subsector],$cod_subsector)){
			$ramo_id[]=$row_tiene[id_ramo];
			$ramo_nombre[]=$row_tiene[nombre];
			$ramo_modo_eval[]=$row_tiene[modo_eval];
			$cod_subsector[]=$row_tiene[cod_subsector];
		}
	}
	
}

///consulta_por datos ingresados en la tabla_concentracion_notas
$query_mat2="select * from concentracion_notas where rut_alumno='$rut_alumno'";
$result_mat2=@pg_exec($conn,$query_mat2);
$num_mat2=@pg_numrows($result_mat2);
for ($i=0;$i<$num_mat2; ++$i){
	$row_mat2=pg_fetch_array($result_mat2);
	$curso_grado=$row_mat2[curso];
	$anos_id[$curso_grado]=$row_mat2[id_ano];
	$grado_curso[$curso_grado]=$row_mat2[curso];
	$origen[$curso_grado]=2;
	
	////////////////////////////////
	$contador_acumulado = 0;
	$contador_religion = 0;
	$acumulo_promedio = 0;		
	////////////////////////////////
 $query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso='$row_mat2[curso]'";
	$result_detalle=@pg_exec($conn,$query_detalle);
	$num_detalle=@pg_numrows($result_detalle);
	for ($ff=0;$ff<$num_detalle; ++$ff){
		$row_detalle=pg_fetch_array($result_detalle);
		if (!in_array($row_detalle[subsector],$cod_subsector)){
			 $cod_subsector[]=$row_detalle[subsector];
			$query_ram="select * from subsector where cod_subsector='$row_detalle[subsector]'";
			$result_ram=pg_exec($conn,$query_ram);
			$num_ram=pg_numrows($result_ram);
			if ($num_ram>0){			
				$row_ram=pg_fetch_array($result_ram);
				$ramo_nombre[]=$row_ram[nombre];
			}			
		}
	}
}



?>
<?

 if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br><br>";
			   
 }
		
if($rut_alumno){?>

			<table  width="640" align="center">
<? if($institucion != 770){ ?>			
			<tr><td>

	<table width="700" border="0" cellspacing="0" cellpadding="0">

	  <tr>
	    <td width="87" rowspan="5" align="left" valign="top">
	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia
		if($institucion != 770){
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				  echo "<img src='".$d."menu/imag/logo.gif' >";
			  }		
	  } ?>	  </td>
		<td width="173" rowspan="5" align="left" valign="top">		
			<div align="center">
				<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>REP&Uacute;BLICA DE CHILE</strong></font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> MINISTERIO DE EDUCACI&Oacute;N</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> DIVISI&Oacute;N DE EDUCACI&Oacute;N </font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">SECRETARIA REGIONAL MINISTERIAL</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">DE EDUCACI&Oacute;N </font><BR>
	      </div></td>
 <td width="85" rowspan="5"><? //} ?>
   <?
		//$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		//$arr=@pg_fetch_array($result,0);
		//$fila_foto = @pg_fetch_array($result,0);
		//if 	(!empty($fila_foto['insignia']))
		//{
		//	$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
		//	$retrieve_result = @pg_exec($conn,$output);?></td>			
		<td width="104"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">REGIÓN</font></td>
		<td width="10"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td width="241"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $region?></strong></font></td>
	   

	  </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROVINCIA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>
		<?
		
		echo $provincia;
		
		?>
		
		</strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">COMUNA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $comuna?></strong></font></td>
	    </tr>
		<? 	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
			$result_ano =pg_Exec($conn,$sql_ano);
			$fila_ano = pg_fetch_array($result_ano,0);	
			$nro_anooo = $fila_ano['nro_ano'];?>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">A&Ntilde;O ESCOLAR</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $nro_anooo?></strong></font></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	</table></td></tr>
	
<? } ?>	

	<tr><td>
			<? /*if($institucion != 770){ ?>
			<table align="left"><tr><td valign="top">
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
			</td></tr></table>
			<? } */?>
			
			
			<table <? /*if($institucion == 770){ */?>align="center"<? /*}else{ ?>align="right"<? } */?>>
			
				<tr><td align="center" class="textosimple"><h4><b>CERTIFICADO DE CONCENTRACION DE NOTAS</b>
						<? if($institucion==1756){
							echo "<br>"; 
							echo "Colegio Claudio Matte";
							}?>
						</h4></td>
				</tr>
				<tr><td class="textosimple">RECONOCIDO OFICIALMENTE POR EL MINISTERIO DE EDUCACION DE LA REPUBLICA DE CHILE<br />
				SEGUN RESOLUCION Nº <? echo $resolucion;?> DEL <? echo strtoupper($fecha_convertida);?>&nbsp;ROL DE BASE DE DATOS Nº<b> <? echo $row_ano['rdb'];?>-<? echo $row_ano['dig_rdb'];?></b><BR />
				OTORGA EL PRESENTE CERTIFICADO DE CONCENTRACION DE CALIFICACIONES A <BR />
				DON(A) &nbsp;<b><? echo strtoupper($row_alumno['ape_pat']);?>&nbsp;<? echo strtoupper($row_alumno['ape_mat']);?>&nbsp;
				<? echo strtoupper($row_alumno['nombre_alu']);?></b> RUN <b><? echo $row_alumno['rut_alumno'];?>- <? echo $row_alumno['dig_rut'];?>
				
			
					</b></td>
				</tr>
			</table>
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>
			<table width="1%" border="1" cellpadding="0" cellspacing="0">
			  <tr>
				<td rowspan="2" nowrap="nowrap" class="textosimple">SUBSECTOR ASIGNATURA Y MODULO</td>
				<td colspan="4" nowrap="nowrap" class="textosimple">CURSO DE ENSEÑANZA MEDIA</td>
				<td rowspan="2" align="center" nowrap="nowrap" class="textosimple">AÑO ESCOLAR Y ESTABLECIMIENTO <br />
				  EDUCACIONAL</td>
			  </tr>
			  <tr>
				<td width="1%" align="center" class="textosimple">1</td>
				<td width="1%" align="center" class="textosimple">2</td>
				<td width="1%" align="center" class="textosimple">3</td>
				<td width="1%" align="center" class="textosimple">4</td>
			  </tr>
			  <?
			  for ($i=0;$i<count($cod_subsector); ++$i){
			  
			      /// verificar curso
				  $sql_verif = "select id_curso from matricula where id_curso in (select id_curso from ramo where id_ramo = '$ramo_id[$i]') and rut_alumno = '$rut_alumno' and bool_ar = '0'";
				  $res_verif = @pg_Exec($conn, $sql_verif);
				  $num_verif = @pg_numrows($res_verif);
				  
				  $sql_verif2 = "select subsector from concentracion_detalle where  subsector = '$cod_subsector[$i]'";
				  $res_verif2 = @pg_Exec($conn, $sql_verif2);
				  $num_verif2 = @pg_numrows($res_verif2);
				  
				  $num_verif = $num_verif + $num_verif2;
						 
				  
				  if ($num_verif>0){
					   
					 /// entra y mustra la informacion
			  
			  
			  ?>
			  <tr class="textosimple">
				<td><? echo $ramo_nombre[$i];?>
								
				</td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			if ($curso_id[1]){
			if ($origen[1]==1){
				 $query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza > 300 and $curso_id[1]=curso.id_curso" ;
				$result_saca_ramo=pg_exec($conn,$query_saca_ramo);
				 $num_saca_num=pg_numrows($result_saca_ramo);
				if ($num_saca_num>0){
					$row_saca_ramo=pg_fetch_array($result_saca_ramo);
			//		imprime_array($row_saca_ramo);
					if ($row_saca_ramo[conex]==2){
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[1] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
								$result_prom=@pg_exec($conn,$query_prom);
								$num_prom=@pg_numrows($result_prom);
								if ($num_prom>0){
									$row_prom=pg_fetch_array($result_prom);
									$promedio=$row_prom[suma]/$row_prom[cantidad];
									$promedio=intval(aproximar_promedio($promedio,$aproxima[1]));
								}
					}else{
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[3] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
						 $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
						// echo "<br>$query_situacion<br>";
						$result_situacion=pg_exec($conn,$query_situacion);
						$num_situacion=pg_numrows($result_situacion);
						if ($num_situacion>0){
							$row_situacion=pg_fetch_array($result_situacion);
							$promedio=$row_situacion[nota_final];
						}
					}
				}
			}
			
			
			//if (($row_saca_ramo[modo_eval]==2)&&($origen[1]==1)){
			if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[1]==1)){
				 
				  if ($row_saca_ramo[modo_eval]==3){			
			
			       ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
				 
				    $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[1] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$con_notas = 0;
					$prom=0;
					$promedio_nota=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; ++$g){
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$prom = $prom + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_20;
						}						
							
					}		
							
					    /// nuevo código para sacar el promedio correcto de religion 
						$sql_1 = "select promedio from notas$nro_ano[1] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
						$res_1 = @pg_Exec($conn,$sql_1);
						$num_1 = @pg_numrows($res_1);
						$contador_promedios = 0;
						$promedio_num=0;
											
						for ($ii=0; $ii < $num_1; ++$ii){
						    $fil_1 = @pg_fetch_array($res_1,$ii);
							$prom_per = $fil_1['promedio'];
							
							if (trim($prom_per)=="0"){
							    /// nada								 
							}else{
							     // aumento contador
								 $contador_promedios++;
							}										
							$prom_per = Conceptual($prom_per,2);							
							$promedio_num = $promedio_num + $prom_per;									
						}										
												
						$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);							    
												
				  
						/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
						if ($promedio_ramo > 0 and $promedio_ramo < 40){
							$promedio = "I";
						}
						if ($promedio_ramo > 39 and $promedio_ramo < 50){
							$promedio = "S";
						}
						if ($promedio_ramo > 49 and $promedio_ramo < 60){
							$promedio = "B";
						}
						if ($promedio_ramo > 59 ){
							$promedio = "MB";
						}
												
					    $promedio_ramo = NULL;
					 ////////////  fin nuevo código ///////////////////	
					 
					 
			}else{	
				 		$arreglo_concep=NULL;
						$query_concep="select * from notas$nro_ano[1] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
						$result_concep=pg_exec($conn,$query_concep);
						$num_concep=pg_numrows($result_concep);
						for ($c=0;$c<$num_concep; ++$c){
							$row_concep=pg_fetch_array($result_concep);
							$arreglo_concep[]=$row_concep[promedio]	;
						}
						$promedio=promediar_conceptos($arreglo_concep);
				  }		
			}
			}
			?>
					<? 
			if ($origen[1]==2){
				$query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=1 and subsector=$cod_subsector[$i]";
				$result_detalle=pg_exec($conn,$query_detalle);
				$num_detalle=pg_numrows($result_detalle);
				if ($num_detalle){
					$row_detalle=pg_fetch_array($result_detalle);
					$promedio=$row_detalle[promedio];
					$religion=$row_detalle[religion];
				}
			}
			?>
					<? 
			if (!$promedio){
				if(!$religion){
					if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					     echo "-";
					}else{
					     if ($_INSTIT==516){
						     						    
							 if ($cod_subsector[$i]=="11"){
								  echo "EX";
							 }else{
								  echo "&nbsp;";
							 }
						 }else{
						     echo "&nbsp;";
						 }
					}
				}else{
					echo $religion;
					$religion=NULL;
				}
			}
			if ($promedio!=NULL and $religion==NULL){
			    $acumulo_promedio = $acumulo_promedio + $promedio;
				
				if ($promedio!=NULL and $promedio!=0){
			        $contador_acumulado++;
				}	
			}
		    if ($promedio==0 and $promedio!="I" and $promedio!="S" and $promedio!="B" and $promedio!="MB"){
			     $promedio="&nbsp;";
			}
			echo $promedio;
			$promedio=NULL;
			$row_saca_ramo[modo_eval]=NULL;
			?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			if ($curso_id[2]){
			if ($origen[2]==1){
				$query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza>300 and $curso_id[2]=curso.id_curso" ;
				$result_saca_ramo=pg_exec($conn,$query_saca_ramo);
				 $num_saca_num=pg_numrows($result_saca_ramo);
				if ($num_saca_num>0){
					$row_saca_ramo=pg_fetch_array($result_saca_ramo);
			//		imprime_array($row_saca_ramo);
					if ($row_saca_ramo[conex]==2){
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[2] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
								$result_prom=pg_exec($conn,$query_prom);
								$num_prom=pg_numrows($result_prom);
								if ($num_prom>0){
									$row_prom=pg_fetch_array($result_prom);
									$promedio=$row_prom[suma]/$row_prom[cantidad];
									$promedio=intval(aproximar_promedio($promedio,$aproxima[2]));
								}
					}else{
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[2] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
						 $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
						// echo "<br>$query_situacion<br>";
						$result_situacion=pg_exec($conn,$query_situacion);
						$num_situacion=pg_numrows($result_situacion);
						if ($num_situacion>0){
							$row_situacion=pg_fetch_array($result_situacion);
							$promedio=$row_situacion[nota_final];
						}
					}
				}
			}
			
			}
			
			//if (($row_saca_ramo[modo_eval]==2)&&($origen[2]==1)){
			if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[2]==1)){
					
					if ($row_saca_ramo[modo_eval]==3){			
			
			       ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
				 
				    $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[2] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$con_notas = 0;
					$prom=0;
					$promedio_nota=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; ++$g){
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$prom = $prom + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_20;
						}						
							
					}		
							
					    /// nuevo código para sacar el promedio correcto de religion 
						$sql_1 = "select promedio from notas$nro_ano[2] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
						$res_1 = @pg_Exec($conn,$sql_1);
						$num_1 = @pg_numrows($res_1);
						$contador_promedios = 0;
						$promedio_num=0;
											
						for ($ii=0; $ii < $num_1; ++$ii){
						    $fil_1 = @pg_fetch_array($res_1,$ii);
							$prom_per = $fil_1['promedio'];
							
							if (trim($prom_per)=="0"){
							    /// nada								 
							}else{
							     // aumento contador
								 $contador_promedios++;
							}										
							$prom_per = Conceptual($prom_per,2);							
							$promedio_num = $promedio_num + $prom_per;									
						}										
												
						$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);							    
												
				  
						/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
						if ($promedio_ramo > 0 and $promedio_ramo < 40){
							$promedio = "I";
						}
						if ($promedio_ramo > 39 and $promedio_ramo < 50){
							$promedio = "S";
						}
						if ($promedio_ramo > 49 and $promedio_ramo < 60){
							$promedio = "B";
						}
						if ($promedio_ramo > 59 ){
							$promedio = "MB";
						}
												
					    $promedio_ramo = NULL;
					 ////////////  fin nuevo código ///////////////////	
					 
					 
			}else{	
						$arreglo_concep=NULL;
						$query_concep="select * from notas$nro_ano[2] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
						$result_concep=pg_exec($conn,$query_concep);
						$num_concep=pg_numrows($result_concep);
						for ($c=0;$c<$num_concep; ++$c){
							$row_concep=pg_fetch_array($result_concep);
							$arreglo_concep[]=$row_concep[promedio]	;
						}
						$promedio=promediar_conceptos($arreglo_concep);
				   }		
			}
			?>
					<? 
			if ($origen[2]==2){
				$query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=2 and subsector=$cod_subsector[$i]";
				$result_detalle=pg_exec($conn,$query_detalle);
				$num_detalle=pg_numrows($result_detalle);
				if ($num_detalle){
					$row_detalle=pg_fetch_array($result_detalle);
					$promedio=$row_detalle[promedio];
					$religion=$row_detalle[religion];
				}
			}
			?>
					<? 
			if (!$promedio){
				if(!$religion){
					if ($_INSTIT=='12829'OR $_INSTIT=='2278'){
					     echo "-";
					}else{
					    if ($_INSTIT==516){
						     						    
							 if ($cod_subsector[$i]=="11"){
								  echo "EX";
							 }else{
								  echo "&nbsp;";
							 }
						 }else{
						     echo "&nbsp;";
						 }
					}
				}else{
					echo $religion;
					$religion=NULL;
				}
			}
			if ($promedio!=NULL and $religion==NULL){
			    $acumulo_promedio = $acumulo_promedio + $promedio;
				
				if ($promedio!=NULL and $promedio!=0){
			        $contador_acumulado++;
				}	
			}
			if ($promedio==0 and $promedio!="I" and $promedio!="S" and $promedio!="B" and $promedio!="MB"){
			     $promedio="&nbsp;";
			}
			echo $promedio;
			$promedio=NULL;
			$row_saca_ramo[modo_eval]=NULL;
			?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			if ($curso_id[3]){
			if ($origen[3]==1){
				 $query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza>300 and $curso_id[3]=curso.id_curso" ;
				$result_saca_ramo=pg_exec($conn,$query_saca_ramo);
				 $num_saca_num=pg_numrows($result_saca_ramo);
				if ($num_saca_num>0){
					$row_saca_ramo=pg_fetch_array($result_saca_ramo);
			//		imprime_array($row_saca_ramo);
					if ($row_saca_ramo[conex]==2){
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[3] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
								$result_prom=@pg_exec($conn,$query_prom);
								$num_prom=@pg_numrows($result_prom);
								if ($num_prom>0){
									$row_prom=pg_fetch_array($result_prom);
									$promedio=$row_prom[suma]/$row_prom[cantidad];
			//						$promedio=aproximar_promedio($promedio,$aproxima[3]);
									$promedio=intval(aproximar_promedio($promedio,$aproxima[3]));
								}
					}else{
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[3] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
						 $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
						// echo "<br>$query_situacion<br>";
						$result_situacion=pg_exec($conn,$query_situacion);
						$num_situacion=pg_numrows($result_situacion);
						if ($num_situacion>0){
							$row_situacion=pg_fetch_array($result_situacion);
							$promedio=$row_situacion[nota_final];
						}
					}
				}
			}
			}
			//if (($row_saca_ramo[modo_eval]==2)&&($origen[3]==1)){
			if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[3]==1)){
			     if ($row_saca_ramo[modo_eval]==3){			
			
			       ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
				 
				    $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[3] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$con_notas = 0;
					$prom=0;
					$promedio_nota=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; ++$g){
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$prom = $prom + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_20;
						}						
							
					}		
							
					    /// nuevo código para sacar el promedio correcto de religion 
						$sql_1 = "select promedio from notas$nro_ano[3] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
						$res_1 = @pg_Exec($conn,$sql_1);
						$num_1 = @pg_numrows($res_1);
						$contador_promedios = 0;
						$promedio_num=0;
											
						for ($ii=0; $ii < $num_1; ++$ii){
						    $fil_1 = @pg_fetch_array($res_1,$ii);
							$prom_per = $fil_1['promedio'];
							
							if (trim($prom_per)=="0"){
							    /// nada								 
							}else{
							     // aumento contador
								 $contador_promedios++;
							}										
							$prom_per = Conceptual($prom_per,2);							
							$promedio_num = $promedio_num + $prom_per;									
						}										
												
						$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);							    
												
				  
						/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
						if ($promedio_ramo > 0 and $promedio_ramo < 40){
							$promedio = "I";
						}
						if ($promedio_ramo > 39 and $promedio_ramo < 50){
							$promedio = "S";
						}
						if ($promedio_ramo > 49 and $promedio_ramo < 60){
							$promedio = "B";
						}
						if ($promedio_ramo > 59 ){
							$promedio = "MB";
						}
												
					    $promedio_ramo = NULL;
					 ////////////  fin nuevo código ///////////////////	
					 
					 
			}else{	
						$arreglo_concep=NULL;
						$query_concep="select * from notas$nro_ano[3] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
						$result_concep=pg_exec($conn,$query_concep);
						$num_concep=pg_numrows($result_concep);
						for ($c=0;$c<$num_concep; ++$c){
							$row_concep=pg_fetch_array($result_concep);
							$arreglo_concep[]=$row_concep[promedio]	;
						}
						$promedio=promediar_conceptos($arreglo_concep);
				  }		
			}
			
			?>
					<? 
			if ($origen[3]==2){
				$query_detalle="select * from concentracion_detalle where rut_alumno='".trim($rut_alumno)."' and  curso=3 and subsector='".trim($cod_subsector[$i])."'";
				$result_detalle=pg_exec($conn,$query_detalle);
				$num_detalle=pg_numrows($result_detalle);
				if ($num_detalle){
					$row_detalle=pg_fetch_array($result_detalle);
					$promedio=$row_detalle[promedio];
					$religion=$row_detalle[religion];
				}
			}
			?>
					<? 
			if (!$promedio){
				if(!$religion){
					if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					     echo "-";
					}else{
					     if ($_INSTIT==516){
						     						    
							 if ($cod_subsector[$i]=="11"){
								  echo "EX";
							 }else{
								  echo "&nbsp;";
							 }
						 }else{
						     echo "&nbsp;";
						 }
					}
				}else{
					echo $religion;
					$religion=NULL;
				}
			}
			if ($promedio!=NULL and $religion==NULL){
			    $acumulo_promedio = $acumulo_promedio + $promedio;
				
				if ($promedio!=NULL and $promedio!=0){
			        $contador_acumulado++;
				}	
			}
			if ($promedio==0 and $promedio!="I" and $promedio!="S" and $promedio!="B" and $promedio!="MB"){
			     $promedio="&nbsp;";
			}
			echo $promedio;
			$promedio=NULL;
			$row_saca_ramo[modo_eval]=NULL;
			?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			if ($curso_id[4]){
			if ($origen[4]==1){
				$query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza>300 and $curso_id[4]=curso.id_curso" ;
				$result_saca_ramo=pg_exec($conn,$query_saca_ramo);
				 $num_saca_num=pg_numrows($result_saca_ramo);
				if ($num_saca_num>0){
					$row_saca_ramo=pg_fetch_array($result_saca_ramo);
			//		imprime_array($row_saca_ramo);
					if ($row_saca_ramo[conex]==2){
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[4] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
								$result_prom=@pg_exec($conn,$query_prom);
								$num_prom=@pg_numrows($result_prom);
								if ($num_prom>0){
									$row_prom=pg_fetch_array($result_prom);
									$promedio=$row_prom[suma]/$row_prom[cantidad];
									$promedio=intval(aproximar_promedio($promedio,$aproxima[4]));
								}
							if ($promedio == "0"){ $promedio ="&nbsp;"; }	
					}else{
						 $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
						// echo "<br>$query_situacion<br>";
						$result_situacion=@pg_exec($conn,$query_situacion);
						$num_situacion=@pg_numrows($result_situacion);
						if ($num_situacion>0){
							$row_situacion=pg_fetch_array($result_situacion);
							$promedio=$row_situacion[nota_final];
							
							if ($_INSTIT==9566){
						        if ($cod_subsector[$i]==13){
							       $promedio = Conceptual($promedio , 1);					 
			                       //echo "aqui3";
							       //exit();
							    }	  
						    }
						}
					}
				}
			}
			}
			
			//if (($row_saca_ramo[modo_eval]==2)&&($origen[4]==1)){
		if($num_saca_num!=""){			
			if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[4]==1)){
			     
				 if ($row_saca_ramo[modo_eval]==3){			
			
			       ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
				 
				    $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[4] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$con_notas = 0;
					$prom=0;
					$promedio_nota=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; ++$g){
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$prom = $prom + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_20;
						}						
							
					}		
						
						if ($_INSTIT==769){										
							$promedio_ramo = intval($prom / $con_notas);
							
						}else{	
							
							/// nuevo código para sacar el promedio correcto de religion 
							$sql_1 = "select promedio from notas$nro_ano[4] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
							$res_1 = @pg_Exec($conn,$sql_1);
							$num_1 = @pg_numrows($res_1);
							$contador_promedios = 0;
							$promedio_num=0;
												
							for ($ii=0; $ii < $num_1; ++$ii){
								$fil_1 = @pg_fetch_array($res_1,$ii);
								$prom_per = $fil_1['promedio'];
								
								if (trim($prom_per)=="0"){
									/// nada								 
								}else{
									 // aumento contador
									 $contador_promedios++;
								}										
								$prom_per = Conceptual($prom_per,2);							
								$promedio_num = $promedio_num + $prom_per;									
							}										
													
							$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);	
						}							    
												
				  
						/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
						if ($promedio_ramo > 0 and $promedio_ramo < 40){
							$promedio = "I";
						}
						if ($promedio_ramo > 39 and $promedio_ramo < 50){
							$promedio = "S";
						}
						if ($promedio_ramo > 49 and $promedio_ramo < 60){
							$promedio = "B";
						}
						if ($promedio_ramo > 59 ){
							$promedio = "MB";
						}
												
					    $promedio_ramo = NULL;
					 ////////////  fin nuevo código ///////////////////	
					 
					 
			}else{	
						$arreglo_concep=NULL;
						$query_concep="select * from notas$nro_ano[4] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
						$result_concep=pg_exec($conn,$query_concep);
						$num_concep=pg_numrows($result_concep);
						for ($c=0;$c<$num_concep; ++$c){
							$row_concep=pg_fetch_array($result_concep);
							$arreglo_concep[]=$row_concep[promedio]	;
						}
						$promedio=promediar_conceptos($arreglo_concep);
				  }		
			}
		}
			
			
			
			?>
					<? 
			if ($origen[4]==2){
				$query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=4 and subsector=$cod_subsector[$i]";
				$result_detalle=pg_exec($conn,$query_detalle);
				$num_detalle=pg_numrows($result_detalle);
				if ($num_detalle){
					$row_detalle=pg_fetch_array($result_detalle);
					$promedio=$row_detalle[promedio];
					$religion=$row_detalle[religion];
				}
			}
			?>
					<? 
			if (!$promedio){
				if(!$religion){
					if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					     echo "-";
					}else{
					    if ($_INSTIT==516){
						     						    
							 if ($cod_subsector[$i]=="11"){
								  echo "EX";
							 }else{
								  echo "&nbsp;";
							 }
						 }else{
						     echo "&nbsp;";
						 }
					}
				}else{
					echo $religion;
					$religion=NULL;
				}
			}
			if ($promedio!=NULL and $religion==NULL){
			    $acumulo_promedio = $acumulo_promedio + $promedio;
				
				if ($promedio!=NULL and $promedio!=0){
			        $contador_acumulado++;
				}	
			}
			if ($promedio==0 and $promedio!="I" and $promedio!="S" and $promedio!="B" and $promedio!="MB"){
			     $promedio="&nbsp;";
			}
			//// codigo nuevo ///
			 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo=$row_saca_ramo[id_ramo]  and rut_alumno = '$rut_alumno' and id_ano='".$_ANO."' and id_ramo <> '$id_ramo_anterior'";
			 $res_prom_sub = pg_Exec($conn,$sql_prom_sub);
			 $num_prom_sub = pg_numrows($res_prom_sub);
			 if ($num_prom_sub>0){
			      $fil_prom_sub = pg_fetch_array($res_prom_sub,0);
				  $promedio = $fil_prom_sub['promedio'];
			 }
			  $id_ramo_anterior = $row_saca_ramo[id_ramo];
			 /////////////////////////	
			echo $promedio;
			$promedio=NULL;
			$row_saca_ramo[modo_eval]=NULL;
			?></td>
			
				<? 
				
				}
				
				
				if ($i==0){?>
				<? $colegio=$row_ano[nombre_instit];			
					
				?>
				<td rowspan="50" valign="top" >
					<table width="100%" class="textosimple">
					
					<? for ($j=1;$j<=4; ++$j){?>
						<tr><td><b>
						<? 	$nombre_plan="";
							$nombre_eva="";
							$ano_temp="";
							$arreglo_temp="";
							
							///// determinar si el alumno ha cursado según el grado en alguna institución del sistema.
						    $sql_2 = "select * from curso where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar='0') and grado_curso = '$j' and ensenanza > 300 and id_ano in (select id_ano from promocion where rut_alumno = '$rut_alumno' and situacion_final <> '2') order by id_curso Desc";		 	
						    $res_2 = @pg_Exec($conn,$sql_2);
						    $num_2 = @pg_numrows($res_2);	
							
							 if ($num_2 > 0){  // existe, tomar los datos de la institucion a que corresponde el curso.
							 						 
								  $fil_2 = @pg_fetch_array($res_2,0);
								  $id_curso_temp = $fil_2['id_curso'];
								  $id_ano_temp   = $fil_2['id_ano'];
								  $decreto       = $fil_2['cod_eval'];
								  $cod_ensenanza = $fil_2['ensenanza'];
								  $letra_curso = $fil_2['letra_curso'];  // SE MUESTRA EN PANTALLA LA LETRA DEL CURSO
								  
								  /// rescato el año academico
								  $sql_3 = "select * from ano_escolar where id_ano = '$id_ano_temp'";
								  $res_3 = @pg_Exec($conn,$sql_3);
								  $fil_3 = @pg_fetch_array($res_3);	
								  
								  $year  = $fil_3['nro_ano'];
							      $institucion_temp = $fil_3['id_institucion'];
								  
								  $sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
								  $sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
								  $sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion_temp.")); ";	
								  
								  $result_ins =@pg_Exec($conn,$sql_ins);
								  $fila_ins = @pg_fetch_array($result_ins,0);	
								  $ins_pal         = $fila_ins['nombre_instit'];
								  $establecimiento = $fila_ins['nombre_instit'];
								  $ciudad          = $fila_ins['nom_pro'];
								  $fono            = $fila_ins['telefono'];
								  $direc           = $fila_ins['calle'].$fila_ins['nro'];
								  $region          = $fila_ins['nom_reg'];
								  $provincia       = $fila_ins['nom_pro'];
								  $city            = $fila_ins['nom_pro'];
								  $comuna          = $fila_ins['nom_com'];
								  $comuna_real     = $fila_ins['nom_com'];	
								  
								  //// determinar el plan de estudio
								  
								  $query_primer="select * from plan_estudio where cod_decreto in (select cod_decreto from curso where id_curso = '$id_curso_temp')";
						     
								  $result_primer=	pg_Exec($conn,$query_primer);
								  $num_primer=pg_numrows($result_primer);
								  if ($num_primer>0){
									  $row_primer=pg_fetch_array($result_primer);	
									  $nombre_plan=$row_primer['nombre_decreto'];
									  $plan=$row_primer['nombre_decreto'];
									  $nombre_eva=$row_primer['nombre_decreto_eval'];
									  $arreglo_temp=explode(" ",trim($nombre_plan));
									  $ano_temp=$nro_ano[$j];
								  }
							}else{     // se ha insgresado la institución a "mano"			
			
							      $query_gene="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso= '$j'";
							      $result_gene=pg_exec($conn,$query_gene);
							  
								  if (@pg_numrows($result_gene) > 0){     /// está en concentracion de notas para ese grado
								  
									  $row_gene = pg_fetch_array($result_gene);
									  $year            = $row_gene['ano'];
									  $establecimiento = $row_gene['institucion'];
									  $city            = $row_gene['ciudad'];									
									  $plan            = $row_gene['plan'];
									  $decreto         = $row_gene['decreto'];
									  $comuna_real     = $row_gene['comuna'];
								
									  $query_primer="select eva.*,plan.* 
											from curso,plan_estudio as plan ,evaluacion as eva
											where curso.id_ano='$row_ano[id_ano]'  and curso.grado_curso=$j and  curso.ensenanza>=310 and 
											plan.cod_decreto=curso.cod_decreto
											and eva.cod_eval=curso.cod_eval";
											
									  $letra_curso = $query_primer['letra_curso']; // SE MUESTRA EN PANTALLA LA LETRA DEL CURSO
									   		
									  $result_primer=	pg_exec($conn,$query_primer);
									  $num_primer=pg_numrows($result_primer);
									  if ($num_primer>0){
										  $row_primer=pg_fetch_array($result_primer);	
										  $nombre_plan=$row_primer[nombre_decreto];
										  $nombre_eva=$row_primer[nombre_decreto_eval];
										  $arreglo_temp=explode(" ",trim($nombre_plan));
										  $ano_temp=$nro_ano[$j];
									  }
									
									  /*  
									  $nini_es = $row_alumno['rut_alumno'];
							
									  if (($nini_es=16945793)AND($j==3)){
											$year="2006";
									  }
									  */
																	   
								   }else{  // no existe en concetracion
								  
									   
								   }
							 }	/// fin IF
						  
						  
						      if ($j==1){ echo "PRIMER";}
							  if ($j==2){ echo "SEGUNDO";}
							  if ($j==3){ echo "TERCER";}
							  if ($j==4){ echo "CUARTO";}
							  
							  
							  	   
						       ////////  DESPLIEGO LA INFORMACION DE LA TABLA  //////////
						  
						      ?>&nbsp;AÑO-<?=$letra_curso;?></b></td>
					          <? if($year==""){ ?>
						              <td class="textosimple"><b><? echo $ano_temp;?></b><br />Año Escolar </td>
						      <? }else{ ?>
						                 <td class="textosimple"><b><? if ($j==4){  echo $nro_anooo; }else{  echo $year;  }?></b><br />Año Escolar</td>
					          <? } ?>
						      </tr>
							  <?
							  if ($establecimiento==NULL){
							      ?>
							      <tr class="textosimple">
							         <td colspan="2">Sin información. <br><br><br><br><br><br></td>
							      </tr>    
							      <?
							  }else{ ?>	  
							  
					 	          <tr class="textosimple">
							        <td colspan="2">Establecimiento:<b><? echo $establecimiento;?></b></td>
							      </tr>
						          <tr class="textosimple">
							        <td colspan="2">Ciudad:<b>
									<?	
								   if (trim($comuna_real)=="VINA DEL MAR"){
								        $city="VIÑA DEL MAR";
										$comuna_real="VIÑA DEL MAR";
								   
								   } ?>
									
									
									
									
								    <? 
								   if ($_INSTIT!=770 and $_INSTIT!=769 and $_INSTIT!=516 and $_INSTIT!=12838){
								       echo $city; 
								   }else{
								       if ($establecimiento=="COLEGIO AMALIA ERRÁZURIZ"){
								           echo "Ovalle";
									   }else{
									       if ($_INSTIT==770 and trim($city)=="LIMARI"){
										        echo "OVALLE";
										   }else{
										        if ($_INSTIT==769 and trim($city)=="LIMARI"){
										             echo "OVALLE";
									            }else{
												     if ($_INSTIT==516 and trim($city)=="ELQUI"){
													      echo "LA SERENA";													 
													 }else{												          
														  if ($_INSTIT==12838 and trim($city)=="EL LOA"){
													          echo "CALAMA";
														  }else{
									                          echo $city;
														  }													  
													 }	  
												}	 
										   }	 	
										  	   									   
									   }	   
							       }
								   ?>
								   
								   
								   </b>&nbsp;&nbsp;Comuna: <b>
								   <? 
								   if($establecimiento=="COLEGIO AMALIA ERRÁZURIZ")
								       echo Ovalle;
								   else
								       echo $comuna_real; 
								   ?> 
								   
								   
								  </b></td>
							      </tr>
							  
							  
								  <tr><td colspan="2" nowrap="nowrap">Plan y Programa de Estudio Decreto Exento o Resolución</td></tr>
								  <tr class="textosimple">
								  <? if($plan==""){  ?>
										<td colspan="2">Exenta de Educacion Nº <b><? echo $nombre_plan;?></b></td>
								  <? }else{ ?>
										<td colspan="2">Exenta de Educacion Nº <b><? echo $plan;?></b></td>
								  <? } ?>
								  </tr>
								  <tr class="textosimple">
									 <td colspan="2">Reglamento de evaluacion y promocion Escolar decreto </td>
								  </tr>
								  <? if($decreto==""){ ?>
										   <tr class="textosimple"><td colspan="2">Exenta de Educacion N&ordm;&nbsp;<b><? echo $nombre_eva;?></b></td>
								  <? }else{ 
								           //// nuevo código que separa el código de decreto
										   if (ereg("de",$decreto)){
										       /// encontrado se deja igual
										   }else{
										        /// no encontrado buscar de otra forma
												 if (ereg("De",$decreto)){
												    // encontrado se deja igual
												 }else{
												      // no encontrado buscar de otra forma
													  if (ereg("DE",$decreto)){
													      // encontrado, dejar igual
													  }else{
													       $lcadena = strlen($decreto);
														   $inicio_ano = $lcadena - 4;
														   $resto_decreto = $lcadena-4;
														   $ano_decreto = substr($decreto,$inicio_ano,4);
														   $nro_decreto = substr($decreto,0,$resto_decreto);
														   $decreto = "$nro_decreto DE $ano_decreto";
													  }
												 }
											}
										   ?>
										   <tr class="textosimple"><td colspan="2">Exenta de Educacion N&ordm;&nbsp;<b><? echo $decreto;?></b></td>
								  <? } ?>
								  </tr>
							      <?
							   }	  					  
						
						     //////////////////////////////////////////////////////////						
						
					 }
					
					
					?>		
				  </table>
				  
				<? } ?>  
				  
				</td>
			
			  </tr>
			  <? }?>
			  
			  
			  <tr class="textosimple">
				<td>PROMEDIO GENERAL</td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[1]){
					if ($origen[1]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[1]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								if (!$row_promocion[promedio]){	
									$promedio="&nbsp;";
								}else{
									$promedio=$row_promocion[promedio];
								}
						}
				}	
				if ($origen[1]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=1";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=$row_general[promedio];
					}
						
				}
							if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}
							echo $promedio;
							$promedio=NULL;
						?>    </td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[2]){
					if ($origen[2]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[2]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								if (!$row_promocion[promedio]){	
									$promedio="&nbsp;";
								}else{
									$promedio=$row_promocion[promedio];
								}
						}
				}	
				if ($origen[2]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=2";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=$row_general[promedio];
					}
						
				}
							if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}
							echo $promedio;
							$promedio=NULL;
						?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[3]){
					if ($origen[3]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[3]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								if (!$row_promocion[promedio]){	
									$promedio="&nbsp;";
								}else{
									$promedio=$row_promocion[promedio];
								}
						}
				}	
				if ($origen[3]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=3";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=$row_general[promedio];
					}
						
				}
				           if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}
							echo $promedio;
							$promedio=NULL;
						?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[4]){
					if ($origen[4]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[4]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								if (!$row_promocion[promedio]){	
									$promedio="&nbsp;";
								}else{
									$promedio=$row_promocion[promedio];
								}
						}
				}	
				if ($origen[4]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=4";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=$row_general[promedio];
					}
						
				}
							if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}	
							echo $promedio;
							$promedio=NULL;
						?></td>
			  </tr>
			  <tr class="textosimple">
				<td>PROMEDIO ASISTENCIA</td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[1]){
					if ($origen[1]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[1]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								$promedio=$row_promocion[asistencia];
								
						}
				}	
				if ($origen[1]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=1";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=trim($row_general[asistencia]);
					}
						
				}
							if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}else{
							     $promedio=$promedio."%";
							}
							echo $promedio;
							$promedio=NULL;
						?>    </td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[2]){
					if ($origen[2]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[2]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								$promedio=$row_promocion[asistencia];
								$promedio=$row_promocion[asistencia];
							
						}
				}	
				if ($origen[2]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=2";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=trim($row_general[asistencia]);
					}
						
				}
							if (!$promedio){
							      if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					              }else{
					                 $promedio = "&nbsp;";
					              }
							}else{
							      $promedio=$promedio."%";
							}	
							echo $promedio;
							$promedio=NULL;
						?>    </td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[3]){
					if ($origen[3]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[3]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								$promedio=$row_promocion[asistencia];
							
						}
				}	
				if ($origen[3]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=3";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=trim($row_general[asistencia]);
					}
						
				}
							if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                $promedio = "-";
					             }else{
					                $promedio = "&nbsp;";
					             }
							}else{
							     $promedio=$promedio."%";
							}	
							echo $promedio;
							$promedio=NULL;
						?>    </td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[4]){
					if ($origen[4]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[4]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								$promedio=$row_promocion[asistencia];
								
						}
				}	
				if ($origen[4]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=4";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=trim($row_general[asistencia]);
					}
						
				}
							if ($promedio==""){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}else{
							     $promedio=$promedio."%";
							}	
							echo $promedio;
							$promedio=NULL;
						?></td>
			  </tr>
			</table>
			</td></tr><? $fecha = date("d-m-Y")?>
			<tr><td align="center" class="textosimple">
			<? if($_INSTIT!=770 and $_INSTIT!=14703 and $_INSTIT!=516 and $_INSTIT!=769){ 
				    echo $ciudad; 
			   }else{
					if ($_INSTIT==770 or $_INSTIT==769) { 
						echo Ovalle; 
					}else{
						  if ($_INSTIT==516){
							   echo "LA SERENA";
						  }else{		 
							   echo $comuna;
						  }
					}	  	    
			   }	
			   
			?>
			  ,  <?php echo  fecha_espanol($fecha); ?> <br />
			  <?
			  //if ($_INSTIT==9071){
			  
			  if ( $_POST[checkbox1] == 1 ){
			  ///////////////////////
			  			
			    $contador_acumulado = ($contador_acumulado - $contador_religion);
				$ponderacion_rende = $acumulo_promedio/$contador_acumulado;
				//$ponderacion_rende = substr($acumulo_promedio/$contador_acumulado,0,2);
				
			   ?>	
			  <table width="100%" border="1" cellspacing="0" cellpadding="2" align="left">
				<tr>
				  <td class="textosimple" width="170">Total notas promediadas</td>
				  <td width="20"><?=$contador_acumulado ?></td>
				
				  <td class="textosimple" width="170">Suma Ponderación</td>
				  <td width="20"><?=$acumulo_promedio ?></td>
				
				  <td class="textosimple" width="170">Ponderación Demre</td>
				  <td width="20"><?=$ponderacion_rende ?></td>
				</tr>
			  </table>
			  <?
			  
			  }
			  
			  ////////////////////////
			  ?>
			  
			  <br />
			  <br />
			  <br />
			  <br /></td></tr>
			<tr><td align="center">
			<?	$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$cmb_curso.")); ";
				$result =@pg_Exec($conn,$sql4);
				$filaprofe = pg_fetch_array($result);			
				$profe_jefe = trim($filaprofe['ape_pat'])." ".trim($filaprofe['ape_mat']).", ".trim($filaprofe['nombre_emp']);
				$profesor_jefe = trim($filaprofe['nombre_emp'])." ".trim($filaprofe['ape_pat'])." ".trim($filaprofe['ape_mat']);
			//----------------------------------
				$sql_dir = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
				$sql_dir = $sql_dir . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
				$sql_dir = $sql_dir . "WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23) ";
				$result =@pg_Exec($conn,$sql_dir);
				$filadire = pg_fetch_array($result);
				$director_est =	trim($filadire['ape_pat'])." ".trim($filadire['ape_mat']).", ".trim($filadire['nombre_emp']);
				$director_estab =	trim($filadire['nombre_emp'])." ".trim($filadire['ape_pat'])." ".trim($filadire['ape_mat']);	
			?>
			<table width="100%">
				<? if($cb_ok!="Buscar"){?>
			<tr>&nbsp;</tr>
			<tr>&nbsp;</tr>
			<tr>&nbsp;</tr>
			<? }?>
			  <tr><td>
			  <table width="1%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
				<tr>
				  <td align="center" width="">__________________________________<br />
					   <? if($institucion==770){?>
						PROFESOR JEFE <br />
					   <? }else{ ?>
					   PROFESOR(A) JEFE <br />
					   <? } ?>
							  <? if($institucion==770){
						echo $profesor_jefe;
					}else{
						echo $profe_jefe;
					}
				  ?> </td>
				</tr>
			  </table></td><td><table width="1%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
				<tr>
				  <td align="center">__________________________________<br />
					   <? if($institucion==770){?>
								DIRECTOR<br />
						<? }else{ ?>
								<?=$cargo_dir2?> <br />
						 <? } ?>
						 
						 
					<? if($institucion==770){
							echo $director_estab;
						}else{
						     if ($institucion==2278){
							      echo "ANA LORENA ALCOTA IRELAND";
							 }else{
							     echo $director_est;
							 }	 
						}?></td>
				</tr>
			  </table></td></tr></table> </td></tr>
			
			</table>
<? }
} ?>

<? 
if($cmb_alumno == '0'){ ?>
<?
	$sql="select matricula.rut_alumno from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
	$result= @pg_Exec($conn,$sql);
	for($t=0 ; $t < @pg_numrows($result) ; ++$t){
 if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br><br>";
			   
 }	
	$fila = @pg_fetch_array($result,$t);
	$rut_alumno = $fila[rut_alumno]; ?>
<table  width="640" align="center">
<? if($institucion != 770){ ?>
<tr><td>
<table width="700" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="87" rowspan="5" align="left" valign="top">
	<?
		$result_insignia = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result_insiginia,0);
		$fila_foto = @pg_fetch_array($result_insignia,0);
	    ## código para tomar la insignia
		if($institucion != 770){
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				  echo "<img src='".$d."menu/imag/logo.gif' >";
			  }		
	  } ?>	  </td>
		<td width="173" rowspan="5" align="left" valign="top">		
			<div align="center">
				<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>REP&Uacute;BLICA DE CHILE</strong></font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> MINISTERIO DE EDUCACI&Oacute;N</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> DIVISI&Oacute;N DE EDUCACI&Oacute;N </font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">SECRETARIA REGIONAL MINISTERIAL</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">DE EDUCACI&Oacute;N </font><BR>
	      </div></td>
 <td width="85" rowspan="5"><? //} ?>
   <?
		//$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		//$arr=@pg_fetch_array($result,0);
		//$fila_foto = @pg_fetch_array($result,0);
		//if 	(!empty($fila_foto['insignia']))
		//{
		//	$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
		//	$retrieve_result = @pg_exec($conn,$output);?></td>			
		<td width="104"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">REGIÓN</font></td>
		<td width="10"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td width="241"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $region?></strong></font></td>
	   

	  </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROVINCIA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $provincia?></strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">COMUNA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $comuna?></strong></font></td>
	    </tr>
		<? 	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
			$result_ano =pg_Exec($conn,$sql_ano);
			$fila_ano = pg_fetch_array($result_ano,0);	
			$nro_anooo = $fila_ano['nro_ano'];?>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">A&Ntilde;O ESCOLAR</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $nro_anooo?></strong></font></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	</table>
	</td></tr>
<? } ?>	
	<tr><td>
			<? /*if($institucion != 770){ ?>
			<table align="left"><tr><td valign="top">
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
			</td></tr></table>
			<? } */?>
			
			<table <? /*if($institucion == 770){ */?>align="center"<? /*}else{ ?>align="right"<? } */?>>			
				<tr><td align="center" class="textosimple"><h4><b>CERTIFICADO DE CONCENTRACION DE NOTAS</b>
						<? if($institucion==1756){
							echo "<br>"; 
							echo "Colegio Claudio Matte";
							}?>
						</h4></td>
				</tr>
				<? 
					$query_alumno="select * from alumno  where rut_alumno='$rut_alumno'";
					$result_alumno=pg_exec($conn,$query_alumno);
					$num_alumno=pg_numrows($result_alumno);
					if ($num_alumno>0){
						$row_alumno=pg_fetch_array($result_alumno);
					}
					$ramo_id=array();
					$ramo_nombre=array();
					$cod_subsector=array();

$query_matricula="select * from matricula as mat,ano_escolar as ano,curso as curso where mat.rut_alumno='$rut_alumno' and mat.id_ano=ano.id_ano and curso.id_curso=mat.id_curso and mat.bool_ar='0' and mat.id_ano in (select id_ano from promocion where rut_alumno = '$rut_alumno' and situacion_final <> '2') order by nro_ano Desc;";
$result_matricula=pg_exec($conn,$query_matricula);
$num_matricula=pg_numrows($result_matricula);
for ($i=0;$i<$num_matricula; ++$i){
	$row_matricula=pg_fetch_array($result_matricula);
	$curso_grado=$row_matricula[grado_curso];
	//imprime_arreglo($row_matricula);
	$anos_id[$curso_grado]=$row_matricula[id_ano];
	$grado_curso[$curso_grado]=$row_matricula[grado_curso];
	$nro_ano[$curso_grado]=$row_matricula[nro_ano];
	$aproxima[$curso_grado]=$row_matricula[truncado_per];
	$curso_id[$curso_grado]=$row_matricula[id_curso];
	$origen[$curso_grado]=1;
	
//	 $query_tiene="select ramo.id_ramo,sub.nombre ,ramo.modo_eval ,ramo.cod_subsector from tiene$row_matricula[nro_ano] as tiene, ramo as ramo, subsector as sub where tiene.rut_alumno='$rut_alumno' and tiene.id_ramo=ramo.id_ramo and ramo.cod_subsector=sub.cod_subsector";
//	$query_tiene="select * from ramo r inner join tiene".$row_matricula[nro_ano]." t on t.id_ramo=r.id_ramo inner join subsector s on s.cod_subsector=r.cod_subsector where t.rut_alumno=".$rut_alumno;
	$query_tiene="select * from ramo r inner join tiene".$row_matricula[nro_ano]." t on t.id_ramo=r.id_ramo inner join subsector s on s.cod_subsector=r.cod_subsector inner join curso c on c.id_curso=r.id_curso where r.bool_ip = '1' and t.rut_alumno=".$rut_alumno." and (c.ensenanza=310 or c.ensenanza=410 or c.ensenanza=510 or c.ensenanza=610 or c.ensenanza=710 or c.ensenanza=810 or c.ensenanza=360 or c.ensenanza=460 or c.ensenanza=560 or c.ensenanza=660 or c.ensenanza=760 or c.ensenanza=860 or c.ensenanza=461 or c.ensenanza=561 or c.ensenanza=661 or c.ensenanza=761 or c.ensenanza=861 or c.ensenanza=361 ) order by r.id_orden";
	$result_tiene=pg_exec($conn,$query_tiene);
	$num_tiene=pg_numrows($result_tiene);
	for ($j=0;$j<$num_tiene; ++$j){
		$row_tiene=pg_fetch_array($result_tiene);
		if (!in_array($row_tiene[cod_subsector],$cod_subsector)){
			$ramo_id[]=$row_tiene[id_ramo];
			$ramo_nombre[]=$row_tiene[nombre];
			$ramo_modo_eval[]=$row_tiene[modo_eval];
			$cod_subsector[]=$row_tiene[cod_subsector];
		}
	}
			
		}
		
		///consulta_por datos ingresados en la tabla_concentracion_notas
		$query_mat2="select * from concentracion_notas where rut_alumno='$rut_alumno'";
		$result_mat2=pg_exec($conn,$query_mat2);
		$num_mat2=pg_numrows($result_mat2);
		for ($i=0;$i<$num_mat2; ++$i){
			$row_mat2=pg_fetch_array($result_mat2);
			$curso_grado=$row_mat2[curso];
			$anos_id[$curso_grado]=$row_mat2[id_ano];
			$grado_curso[$curso_grado]=$row_mat2[curso];
			$origen[$curso_grado]=2;
		 $query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=$row_mat2[curso]";
			$result_detalle=pg_exec($conn,$query_detalle);
			$num_detalle=pg_numrows($result_detalle);
			for ($ff=0;$ff<$num_detalle; ++$ff){
				$row_detalle=pg_fetch_array($result_detalle);
				if (!in_array($row_detalle[subsector],$cod_subsector)){
					 $cod_subsector[]=$row_detalle[subsector];
					$query_ram="select * from subsector where cod_subsector='$row_detalle[subsector]'";
					$result_ram=pg_exec($conn,$query_ram);
					$num_ram=pg_numrows($result_ram);
					if ($num_ram>0){			
						$row_ram=pg_fetch_array($result_ram);
						$ramo_nombre[]=$row_ram[nombre];
					}			
				}
			}
		}							
				?>
				<tr><td class="textosimple">RECONOCIDO OFICIALMENTE POR EL MINISTERIO DE EDUCACION DE LA REPUBLICA DE CHILE<br />
				SEGUN RESOLUCION Nº <? echo $resolucion;?> DEL <? echo strtoupper($fecha_convertida);?>&nbsp;ROL DE BASE DE DATOS Nº<b> <? echo $row_ano['rdb'];?>-<? echo $row_ano['dig_rdb'];?></b><BR />
				OTORGA EL PRESENTE CERTIFICADO DE CONCENTRACION DE CALIFICACIONES A <BR />
				DON(A) &nbsp;<b><? echo strtoupper($row_alumno['ape_pat']);?>&nbsp;<? echo strtoupper($row_alumno['ape_mat']);?>&nbsp;
				<? echo strtoupper($row_alumno['nombre_alu']);?></b> RUN <b><? echo $row_alumno['rut_alumno'];?>- <? echo $row_alumno['dig_rut'];?>
				
			
					</b></td>
				</tr>
			</table>		
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>
			<table width="1%" border="1" cellpadding="0" cellspacing="0">
			  <tr>
				<td rowspan="2" nowrap="nowrap" class="textosimple">SUBSECTOR ASIGNATURA Y MODULO</td>
				<td colspan="4" nowrap="nowrap" class="textosimple">CURSO DE ENSEÑANZA MEDIA</td>
				<td rowspan="2" align="center" nowrap="nowrap" class="textosimple">AÑO ESCOLAR Y ESTABLECIMIENTO <br />
				  EDUCACIONAL</td>
			  </tr>
			  <tr>
				<td width="1%" align="center" class="textosimple">1</td>
				<td width="1%" align="center" class="textosimple">2</td>
				<td width="1%" align="center" class="textosimple">3</td>
				<td width="1%" align="center" class="textosimple">4</td>
			  </tr>
			  <? for ($i=0;$i<count($cod_subsector); ++$i){?>
			  <tr class="textosimple">
				<td><? echo $ramo_nombre[$i];?> 
				
				 <?
				
				 if ($_PERFIL==0){
				     
					 $orden_sub = "orden_sub".$row_saca_ramo[id_ramo];
					 $orden_sub = $$orden_sub;				 
				 
				     echo " - $orden_sub"; 
				 }	 
					 
				 ?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			if ($curso_id[1]){
			if ($origen[1]==1){
				 $query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza>300 and $curso_id[1]=curso.id_curso" ;
				$result_saca_ramo=pg_exec($conn,$query_saca_ramo);
				 $num_saca_num=pg_numrows($result_saca_ramo);
				if ($num_saca_num>0){
					$row_saca_ramo=pg_fetch_array($result_saca_ramo);
			//		imprime_array($row_saca_ramo);
					if ($row_saca_ramo[conex]==2){
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[1] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
								$result_prom=pg_exec($conn,$query_prom);
								$num_prom=pg_numrows($result_prom);
								if ($num_prom>0){
									$row_prom=pg_fetch_array($result_prom);
									$promedio=$row_prom[suma]/$row_prom[cantidad];
									$promedio=intval(aproximar_promedio($promedio,$aproxima[1]));
								}
					}else{
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[3] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
						 $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
						// echo "<br>$query_situacion<br>";
						$result_situacion=pg_exec($conn,$query_situacion);
						$num_situacion=pg_numrows($result_situacion);
						if ($num_situacion>0){
							$row_situacion=pg_fetch_array($result_situacion);
							$promedio=$row_situacion[nota_final];
						}
					}
				}
			}
			
			
			//if (($row_saca_ramo[modo_eval]==2)&&($origen[1]==1)){
			if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[1]==1)){
			    if ($row_saca_ramo[modo_eval]==3){			
			
			       ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
				 
				    $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[1] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$con_notas = 0;
					$prom=0;
					$promedio_nota=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; ++$g){
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$prom = $prom + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_20;
						}						
							
					}		
							
					    /// nuevo código para sacar el promedio correcto de religion 
						$sql_1 = "select promedio from notas$nro_ano[1] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
						$res_1 = @pg_Exec($conn,$sql_1);
						$num_1 = @pg_numrows($res_1);
						$contador_promedios = 0;
						$promedio_num=0;
											
						for ($ii=0; $ii < $num_1; ++$ii){
						    $fil_1 = @pg_fetch_array($res_1,$ii);
							$prom_per = $fil_1['promedio'];
							
							if (trim($prom_per)=="0"){
							    /// nada								 
							}else{
							     // aumento contador
								 $contador_promedios++;
							}										
							$prom_per = Conceptual($prom_per,2);							
							$promedio_num = $promedio_num + $prom_per;									
						}										
												
						$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);							    
												
				  
						/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
						if ($promedio_ramo > 0 and $promedio_ramo < 40){
							$promedio = "I";
						}
						if ($promedio_ramo > 39 and $promedio_ramo < 50){
							$promedio = "S";
						}
						if ($promedio_ramo > 49 and $promedio_ramo < 60){
							$promedio = "B";
						}
						if ($promedio_ramo > 59 ){
							$promedio = "MB";
						}
												
					    $promedio_ramo = NULL;
					 ////////////  fin nuevo código ///////////////////	
					 
					 
			}else{	
						$arreglo_concep=NULL;
						$query_concep="select * from notas$nro_ano[1] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
						$result_concep=pg_exec($conn,$query_concep);
						$num_concep=pg_numrows($result_concep);
						for ($c=0;$c<$num_concep; ++$c){
							$row_concep=pg_fetch_array($result_concep);
							$arreglo_concep[]=$row_concep[promedio]	;
						}
						$promedio=promediar_conceptos($arreglo_concep);
				 }		
			}
			}
			?>
					<? 
			if ($origen[1]==2){
				$query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=1 and subsector=$cod_subsector[$i]";
				$result_detalle=pg_exec($conn,$query_detalle);
				$num_detalle=pg_numrows($result_detalle);
				if ($num_detalle){
					$row_detalle=pg_fetch_array($result_detalle);
					$promedio=$row_detalle[promedio];
					$religion=$row_detalle[religion];
				}
			}
			?>
					<? 
			if (!$promedio){
				if(!$religion){
					if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					     echo "-";
					}else{
					     if ($_INSTIT==516){
						     						    
							 if ($cod_subsector[$i]=="11"){
								  echo "EX";
							 }else{
								  echo "&nbsp;";
							 }
						 }else{
						     echo "&nbsp;";
						 }
					}
				}else{
					echo $religion;
					$religion=NULL;
				}
			}
			if ($promedio!=NULL and $religion==NULL){
			    $acumulo_promedio = $acumulo_promedio + $promedio;
				
				if ($promedio!=NULL and $promedio!=0){
			        $contador_acumulado++;
				}	
			}
			if ($promedio==0 and $promedio!="I" and $promedio!="S" and $promedio!="B" and $promedio!="MB"){
			     $promedio="&nbsp;";
			}
			echo $promedio;
			$promedio=NULL;
			$row_saca_ramo[modo_eval]=NULL;
			?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			
		if ($curso_id[2]){
		     
		if ($origen[2]==1){
			$query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza>300 and $curso_id[2]=curso.id_curso" ;
			$result_saca_ramo=pg_exec($conn,$query_saca_ramo);
			 $num_saca_num=pg_numrows($result_saca_ramo);
			if ($num_saca_num>0){
				$row_saca_ramo=pg_fetch_array($result_saca_ramo);
		
				if ($row_saca_ramo[conex]==2){
					$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
										from notas$nro_ano[2] as notas 
										where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
											$whe_conceptos
										group by rut_alumno";
							$result_prom=@pg_exec($conn,$query_prom);
							$num_prom=@pg_numrows($result_prom);
							if ($num_prom>0){
								$row_prom=pg_fetch_array($result_prom);
								$promedio=$row_prom[suma]/$row_prom[cantidad];
								$promedio=intval(aproximar_promedio($promedio,$aproxima[2]));
							}
				}else{
					$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
										from notas$nro_ano[2] as notas 
										where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
											$whe_conceptos
										group by rut_alumno";
					 $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
					$result_situacion=pg_exec($conn,$query_situacion);
					$num_situacion=pg_numrows($result_situacion);
					if ($num_situacion>0){
						$row_situacion=pg_fetch_array($result_situacion);
						$promedio=$row_situacion[nota_final];
					}
				}
			}
		}
		
		}
		
	if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[2]==1)){
			  if ($row_saca_ramo[modo_eval]==3){				      
							
					    /// nuevo código para sacar el promedio correcto de religion 
						$sql_1 = "select promedio, nota1 from notas$nro_ano[2] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
						$res_1 = @pg_Exec($conn,$sql_1);
						$num_1 = @pg_numrows($res_1);
						$contador_promedios = 0;
						$promedio_num=0;
											
						for ($ii=0; $ii < $num_1; ++$ii){
						    $fil_1 = @pg_fetch_array($res_1,$ii);
							$prom_per = $fil_1['promedio'];
							
							if (trim($prom_per)=="0"){
							    /// nada	
								 							 
							}else{
							     // aumento contador
								 
								 $contador_promedios++;
							}										
							$prom_per = Conceptual($prom_per,2);							
							$promedio_num = $promedio_num + $prom_per;									
						}										
												
						$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);							    
												
				  
						/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
						if ($promedio_ramo > 0 and $promedio_ramo < 40){
							$promedio = "I";
						}
						if ($promedio_ramo > 39 and $promedio_ramo < 50){
							$promedio = "S";
						}
						if ($promedio_ramo > 49 and $promedio_ramo < 60){
							$promedio = "B";
						}
						if ($promedio_ramo > 59 ){
							$promedio = "MB";
						}
												
					    $promedio_ramo = NULL;
					 ////////////  fin nuevo código ///////////////////	
					 
					 
			}else{	
			   		
							
					$arreglo_concep=NULL;
					$query_concep="select * from notas$nro_ano[2] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
					$result_concep=pg_exec($conn,$query_concep);
					$num_concep=pg_numrows($result_concep);
					for ($c=0;$c<$num_concep; ++$c){
						$row_concep=pg_fetch_array($result_concep);
						$arreglo_concep[]=$row_concep[promedio]	;
					}
					$promedio=promediar_conceptos($arreglo_concep);
			  }		
		}
		?>
				<? 
		if ($origen[2]==2){
			$query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=2 and subsector=$cod_subsector[$i]";
			$result_detalle=pg_exec($conn,$query_detalle);
			$num_detalle=pg_numrows($result_detalle);
			if ($num_detalle){
				$row_detalle=pg_fetch_array($result_detalle);
				$promedio=$row_detalle[promedio];
				$religion=$row_detalle[religion];
			}
		}
		?>
		 <? 
			if (!$promedio){
				if(!$religion){
					if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					     echo "-";
					}else{
					     if ($_INSTIT==516){
						     						    
							 if ($cod_subsector[$i]=="11"){
								  echo "EX";
							 }else{
								  echo "&nbsp;";
							 }
						 }else{
						     echo "&nbsp;";
						 }
					}
				}else{
				   
					echo "$religion";
					$religion=NULL;
				}
			}
			
			
			if ($promedio!=NULL and $religion==NULL){
			    $acumulo_promedio = $acumulo_promedio + $promedio;
			    if ($promedio!=NULL and $promedio!=0){
			        $contador_acumulado++;
				}
			}
			if ($promedio==0 and $promedio!="I" and $promedio!="S" and $promedio!="B" and $promedio!="MB"){
			     $promedio="&nbsp;";
			}
			echo $promedio;
			$promedio=NULL;
			$row_saca_ramo[modo_eval]=NULL;
			?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			if ($curso_id[3]){
			if ($origen[3]==1){
				 $query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza>300 and $curso_id[3]=curso.id_curso" ;
				$result_saca_ramo=pg_exec($conn,$query_saca_ramo);
				 $num_saca_num=pg_numrows($result_saca_ramo);
				if ($num_saca_num>0){
					$row_saca_ramo=pg_fetch_array($result_saca_ramo);
			//		imprime_array($row_saca_ramo);
					if ($row_saca_ramo[conex]==2){
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[3] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
								$result_prom=@pg_exec($conn,$query_prom);
								$num_prom=@pg_numrows($result_prom);
								if ($num_prom>0){
									$row_prom=pg_fetch_array($result_prom);
									$promedio=$row_prom[suma]/$row_prom[cantidad];
			//						$promedio=aproximar_promedio($promedio,$aproxima[3]);
									$promedio=intval(aproximar_promedio($promedio,$aproxima[3]));
								}
					}else{
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[3] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
						 $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
						// echo "<br>$query_situacion<br>";
						$result_situacion=pg_exec($conn,$query_situacion);
						$num_situacion=pg_numrows($result_situacion);
						if ($num_situacion>0){
							$row_situacion=pg_fetch_array($result_situacion);
							$promedio=$row_situacion[nota_final];
						}
					}
				}
			}
			}
			//if (($row_saca_ramo[modo_eval]==2)&&($origen[3]==1)){
			if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[3]==1)){
			     
				 if ($row_saca_ramo[modo_eval]==3){			
			
			       ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
				 
				    $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[3] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$con_notas = 0;
					$prom=0;
					$promedio_nota=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; ++$g){
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$prom = $prom + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_20;
						}						
							
					}		
							
					    /// nuevo código para sacar el promedio correcto de religion 
						$sql_1 = "select promedio from notas$nro_ano[3] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
						$res_1 = @pg_Exec($conn,$sql_1);
						$num_1 = @pg_numrows($res_1);
						$contador_promedios = 0;
						$promedio_num=0;
											
						for ($ii=0; $ii < $num_1; ++$ii){
						    $fil_1 = @pg_fetch_array($res_1,$ii);
							$prom_per = $fil_1['promedio'];
							
							if (trim($prom_per)=="0"){
							    /// nada								 
							}else{
							     // aumento contador
								 $contador_promedios++;
							}										
							$prom_per = Conceptual($prom_per,2);							
							$promedio_num = $promedio_num + $prom_per;									
						}										
												
						$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);							    
												
				  
						/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
						if ($promedio_ramo > 0 and $promedio_ramo < 40){
							$promedio = "I";
						}
						if ($promedio_ramo > 39 and $promedio_ramo < 50){
							$promedio = "S";
						}
						if ($promedio_ramo > 49 and $promedio_ramo < 60){
							$promedio = "B";
						}
						if ($promedio_ramo > 59 ){
							$promedio = "MB";
						}
												
					    $promedio_ramo = NULL;
					 ////////////  fin nuevo código ///////////////////	
					 
					 
			     }else{	
						$arreglo_concep=NULL;
						$query_concep="select * from notas$nro_ano[3] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
						$result_concep=pg_exec($conn,$query_concep);
						$num_concep=pg_numrows($result_concep);
						for ($c=0;$c<$num_concep; ++$c){
							$row_concep=pg_fetch_array($result_concep);
							$arreglo_concep[]=$row_concep[promedio]	;
						}
						$promedio=promediar_conceptos($arreglo_concep);
						
				  }		
			}
			
			?>
					<? 
			if ($origen[3]==2){
				$query_detalle="select * from concentracion_detalle where rut_alumno='".trim($rut_alumno)."' and  curso=3 and subsector='".trim($cod_subsector[$i])."'";
				$result_detalle=pg_exec($conn,$query_detalle);
				$num_detalle=pg_numrows($result_detalle);
				if ($num_detalle){
					$row_detalle=pg_fetch_array($result_detalle);
					$promedio=$row_detalle[promedio];
					$religion=$row_detalle[religion];				}

			}
			?>
					<? 
			if (!$promedio){
				if(!$religion){
					if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					     echo "-";
					}else{
					     if ($_INSTIT==516){
						     						    
							 if ($cod_subsector[$i]=="11"){
								  echo "EX";
							 }else{
								  echo "&nbsp;";
							 }
						 }else{
						     echo "&nbsp;";
						 }
					}
				}else{
					echo $religion;
					$religion=NULL;
				}
			}
			if ($promedio!=NULL and $religion==NULL){
			    $acumulo_promedio = $acumulo_promedio + $promedio;
				
				if ($promedio!=NULL and $promedio!=0){
			        $contador_acumulado++;
				}	
			}
			if ($promedio==0 and $promedio!="I" and $promedio!="S" and $promedio!="B" and $promedio!="MB"){
			     $promedio="&nbsp;";
			}
			echo $promedio;
			$promedio=NULL;
			$row_saca_ramo[modo_eval]=NULL;
			?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			if ($curso_id[4]){
			if ($origen[4]==1){
				$query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza>300 and $curso_id[4]=curso.id_curso" ;
				$result_saca_ramo=pg_exec($conn,$query_saca_ramo);
				 $num_saca_num=pg_numrows($result_saca_ramo);
				if ($num_saca_num>0){
					$row_saca_ramo=pg_fetch_array($result_saca_ramo);
			//		imprime_array($row_saca_ramo);
					if ($row_saca_ramo[conex]==2){
						$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											from notas$nro_ano[4] as notas 
											where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												$whe_conceptos
											group by rut_alumno";
								$result_prom=@pg_exec($conn,$query_prom);
								$num_prom=@pg_numrows($result_prom);
								if ($num_prom>0){
									$row_prom=pg_fetch_array($result_prom);
									$promedio=$row_prom[suma]/$row_prom[cantidad];
									$promedio=intval(aproximar_promedio($promedio,$aproxima[4]));
								}
								if ($promedio == "0"){ $promedio ="&nbsp;"; }
					}else{
						 $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
						// echo "<br>$query_situacion<br>";
						$result_situacion=pg_exec($conn,$query_situacion);
						$num_situacion=pg_numrows($result_situacion);
						if ($num_situacion>0){
							$row_situacion=pg_fetch_array($result_situacion);
							$promedio=$row_situacion[nota_final];
						}
					}
				}
			}
			}
			
			//if (($row_saca_ramo[modo_eval]==2)&&($origen[4]==1)){
	if($num_saca_num!=""){			
			if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[4]==1)){
				  if ($row_saca_ramo[modo_eval]==3){			
			
			       ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
				 
				    $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[4] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$con_notas = 0;
					$prom=0;
					$promedio_nota=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; ++$g){
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$prom = $prom + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_20;
						}						
							
					}		
						
						if ($_INSTIT==769){										
							$promedio_ramo = intval($prom / $con_notas);
							
						}else{	
							
							/// nuevo código para sacar el promedio correcto de religion 
							$sql_1 = "select promedio from notas$nro_ano[4] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
							$res_1 = @pg_Exec($conn,$sql_1);
							$num_1 = @pg_numrows($res_1);
							$contador_promedios = 0;
							$promedio_num=0;
												
							for ($ii=0; $ii < $num_1; ++$ii){
								$fil_1 = @pg_fetch_array($res_1,$ii);
								$prom_per = $fil_1['promedio'];
								
								if (trim($prom_per)=="0"){
									/// nada								 
								}else{
									 // aumento contador
									 $contador_promedios++;
								}										
								$prom_per = Conceptual($prom_per,2);							
								$promedio_num = $promedio_num + $prom_per;									
							}										
													
							$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);
						}								    
												
				  
						/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
						if ($promedio_ramo > 0 and $promedio_ramo < 40){
							$promedio = "I";
						}
						if ($promedio_ramo > 39 and $promedio_ramo < 50){
							$promedio = "S";
						}
						if ($promedio_ramo > 49 and $promedio_ramo < 60){
							$promedio = "B";
						}
						if ($promedio_ramo > 59 ){
							$promedio = "MB";
						}
												
					    $promedio_ramo = NULL;
					 ////////////  fin nuevo código ///////////////////	
					 
					 
			   }else{	
				
						$arreglo_concep=NULL;
						$query_concep="select * from notas$nro_ano[4] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
						$result_concep=pg_exec($conn,$query_concep);
						$num_concep=pg_numrows($result_concep);
						for ($c=0;$c<$num_concep; ++$c){
							$row_concep=pg_fetch_array($result_concep);
							$arreglo_concep[]=$row_concep[promedio]	;
						}
						$promedio=promediar_conceptos($arreglo_concep);
				  }		
					
			}
		}			
			
			
			
			?>
					<? 
			if ($origen[4]==2){
				$query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=4 and subsector=$cod_subsector[$i]";
				$result_detalle=pg_exec($conn,$query_detalle);
				$num_detalle=pg_numrows($result_detalle);
				if ($num_detalle){
					$row_detalle=pg_fetch_array($result_detalle);
					$promedio=$row_detalle[promedio];
					$religion=$row_detalle[religion];
					$religion=$row_detalle[religion];
				}
			}
			?>
					<? 
			if (!$promedio){
				if(!$religion){
					if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					     echo "-";
					}else{
					     if ($_INSTIT==516){
						     						    
							 if ($cod_subsector[$i]=="11"){
								  echo "EX";
							 }else{
								  echo "&nbsp;";
							 }
						 }else{
						     echo "&nbsp;";
						 }
					}
				}else{
					echo $religion;
					$religion=NULL;
				}
			}
			if ($promedio!=NULL and $religion==NULL){
			    $acumulo_promedio = $acumulo_promedio + $promedio;
				
				if ($promedio!=NULL and $promedio!=0){
			        $contador_acumulado++;
				}	
			}
			if ($promedio==0 and $promedio!="I" and $promedio!="S" and $promedio!="B" and $promedio!="MB"){
			     $promedio="&nbsp;";
			}
			echo $promedio;
			$promedio=NULL;
			$row_saca_ramo[modo_eval]=NULL;
			?></td>
			
				<? if ($i==0){?>
				<? $colegio=$row_ano[nombre_instit];	
					
				?>
				<td rowspan="50" valign="top" >
					<table width="100%" class="textosimple">
					
					<? for ($j=1;$j<=4; ++$j){?>
						<tr><td><b>
						<? 	$nombre_plan="";
							$nombre_eva="";
							$ano_temp="";
							$arreglo_temp="";
							
							///// determinar si el alumno ha cursado según el grado en alguna institución del sistema.
						    $sql_2 = "select * from curso where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' ) and grado_curso = '$j' and ensenanza > 300 and id_ano in (select id_ano from promocion where rut_alumno = '$rut_alumno' and situacion_final <> '2') order by id_curso Desc";		 	
						    $res_2 = @pg_Exec($conn,$sql_2);
						    $num_2 = @pg_numrows($res_2);	
							
							 if ($num_2 > 0){  // existe, tomar los datos de la institucion a que corresponde el curso.
							 						 
								  $fil_2 = @pg_fetch_array($res_2,0);
								  $id_curso_temp = $fil_2['id_curso'];
								  $id_ano_temp   = $fil_2['id_ano'];
								  $decreto       = $fil_2['cod_eval'];
								  $cod_ensenanza = $fil_2['ensenanza'];
								  
								  /// rescato el año academico
								  $sql_3 = "select * from ano_escolar where id_ano = '$id_ano_temp'";
								  $res_3 = @pg_Exec($conn,$sql_3);
								  $fil_3 = @pg_fetch_array($res_3);	
								  
								  $year  = $fil_3['nro_ano'];
							      $institucion_temp = $fil_3['id_institucion'];
								  
								  $sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
								  $sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
								  $sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion_temp.")); ";	
								  
								  $result_ins =@pg_Exec($conn,$sql_ins);
								  $fila_ins = @pg_fetch_array($result_ins,0);	
								  $ins_pal         = $fila_ins['nombre_instit'];
								  $establecimiento = $fila_ins['nombre_instit'];
								  $ciudad          = $fila_ins['nom_pro'];
								  $fono            = $fila_ins['telefono'];
								  $direc           = $fila_ins['calle'].$fila_ins['nro'];
								  $region          = $fila_ins['nom_reg'];
								  $provincia       = $fila_ins['nom_pro'];
								  $city            = $fila_ins['nom_pro'];
								  $comuna          = $fila_ins['nom_com'];
								  $comuna_real     = $fila_ins['nom_com'];	
								  
								  //// determinar el plan de estudio
								  
								  $query_primer="select * from plan_estudio where cod_decreto in (select cod_decreto from curso where id_curso = '$id_curso_temp')";
						     
								  $result_primer=	pg_Exec($conn,$query_primer);
								  $num_primer=pg_numrows($result_primer);
								  if ($num_primer>0){
									  $row_primer=pg_fetch_array($result_primer);	
									  $nombre_plan=$row_primer['nombre_decreto'];
									  $plan=$row_primer['nombre_decreto'];
									  $nombre_eva=$row_primer['nombre_decreto_eval'];
									  $arreglo_temp=explode(" ",trim($nombre_plan));
									  $ano_temp=$nro_ano[$j];
								  }
							}else{     // se ha insgresado la institución a "mano"			
			
							      $query_gene="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso= '$j'";
							      $result_gene=pg_exec($conn,$query_gene);
							  
								  if (@pg_numrows($result_gene) > 0){     /// está en concentracion de notas para ese grado
								  
									  $row_gene = pg_fetch_array($result_gene);
									  $year            = $row_gene['ano'];
									  $establecimiento = $row_gene['institucion'];
									  $city            = $row_gene['ciudad'];									
									  $plan            = $row_gene['plan'];
									  $decreto         = $row_gene['decreto'];
									  $comuna_real     = $row_gene['comuna'];
								
									  $query_primer="select eva.*,plan.* 
											from curso,plan_estudio as plan ,evaluacion as eva
											where curso.id_ano='$row_ano[id_ano]'  and curso.grado_curso=$j and  curso.ensenanza>=310 and plan.cod_decreto=curso.cod_decreto
											and eva.cod_eval=curso.cod_eval";
									  $result_primer=	pg_exec($conn,$query_primer);
									  $num_primer=pg_numrows($result_primer);
									  if ($num_primer>0){
										  $row_primer=pg_fetch_array($result_primer);	
										  $nombre_plan=$row_primer[nombre_decreto];
										  $nombre_eva=$row_primer[nombre_decreto_eval];
										  $arreglo_temp=explode(" ",trim($nombre_plan));
										  $ano_temp=$nro_ano[$j];
									  }
									  
										  $nini_es = $row_alumno['rut_alumno'];
							
									  if (($nini_es=16945793)AND($j==3)){
											$year="2006";
									  }
																	   
								   }else{  // no existe en concetracion
								  
									   
								   }
							 }	/// fin IF
						  
						  
						      if ($j==1){ echo "PRIMER";}
							  if ($j==2){ echo "SEGUNDO";}
							  if ($j==3){ echo "TERCER";}
							  if ($j==4){ echo "CUARTO";}
							  
							  
							  	   
						       ////////  DESPLIEGO LA INFORMACION DE LA TABLA  //////////
						  
						      ?>&nbsp;AÑO</b></td>
					          <? if($year==""){ ?>
						              <td class="textosimple"><b><? echo $ano_temp;?></b><br />Año Escolar </td>
						      <? }else{ ?>
						                 <td class="textosimple"><b><? echo $year;?></b><br />Año Escolar</td>
					          <? } ?>
						      </tr>
							  <?
							  if ($establecimiento==NULL){
							      ?>
							      <tr class="textosimple">
							         <td colspan="2">Sin información. <br><br><br><br><br><br></td>
							      </tr>    
							      <?
							  }else{ ?>	  
							  
					 	          <tr class="textosimple">
							        <td colspan="2">Establecimiento:<b><? echo $establecimiento;?></b></td>
							      </tr>
						          <tr class="textosimple">
							        <td colspan="2">Ciudad:<b>
									<?	
								   if (trim($comuna_real)=="VINA DEL MAR"){
								        $city="VIÑA DEL MAR";
										$comuna_real="VIÑA DEL MAR";
								   
								   } ?>
									
									
								   <? 
								   if ($_INSTIT!=770 and $_INSTIT!=769 and $_INSTIT!=516 and $_INSTIT!=12838){
								       echo $city; 
								   }else{
								       if ($establecimiento=="COLEGIO AMALIA ERRÁZURIZ"){
								           echo "Ovalle";
									   }else{
									       if ($_INSTIT==770 and trim($city)=="LIMARI"){
										        echo "OVALLE";
										   }else{
										        if ($_INSTIT==769 and trim($city)=="LIMARI"){
										             echo "OVALLE";
									            }else{
												     if ($_INSTIT==516 and trim($city)=="ELQUI"){
													      echo "LA SERENA";													 
													 }else{												          
														  if ($_INSTIT==12838 and trim($city)=="EL LOA"){
													          echo "CALAMA";
														  }else{
									                          echo $city;
														  }													  
													 }	  
												}	 
										   }	 	
										  	   									   
									   }	   
							       }
								   ?>
								   
								   
								   </b>&nbsp;&nbsp;Comuna: <b>
								   <? 
								   if($establecimiento=="COLEGIO AMALIA ERRÁZURIZ")
								       echo Ovalle;
								   else
								       echo $comuna_real; 
								   ?> 
								   
								  </b></td>
							      </tr>
							  
							  
								  <tr><td colspan="2" nowrap="nowrap">Plan y Programa de Estudio Decreto Exento o Resolución</td></tr>
								  <tr class="textosimple">
								  <? if($plan==""){  ?>
										<td colspan="2">Exenta de Educacion Nº <b><? echo $nombre_plan;?></b></td>
								  <? }else{ ?>
										<td colspan="2">Exenta de Educacion Nº <b><? echo $plan;?></b></td>
								  <? } ?>
								  </tr>
								  <tr class="textosimple">
									 <td colspan="2">Reglamento de evaluacion y promocion Escolar decreto </td>
								  </tr>
								  <? if($decreto==""){ ?>
										   <tr class="textosimple"><td colspan="2">Exenta de Educacion N&ordm;&nbsp;<b><? echo $nombre_eva;?></b></td>
								  <? }else{ 
								           //// nuevo código que separa el código de decreto
										   if (ereg("de",$decreto)){
										       /// encontrado se deja igual
										   }else{
										        /// no encontrado buscar de otra forma
												 if (ereg("De",$decreto)){
												    // encontrado se deja igual
												 }else{
												      // no encontrado buscar de otra forma
													  if (ereg("DE",$decreto)){
													      // encontrado, dejar igual
													  }else{
													       $lcadena = strlen($decreto);
														   $inicio_ano = $lcadena - 4;
														   $resto_decreto = $lcadena-4;
														   $ano_decreto = substr($decreto,$inicio_ano,4);
														   $nro_decreto = substr($decreto,0,$resto_decreto);
														   $decreto = "$nro_decreto DE $ano_decreto";
													  }
												 }
											}
								           ?>
										   <tr class="textosimple"><td colspan="2">Exenta de Educacion N&ordm;&nbsp;<b><? echo $decreto;?></b></td>
								  <? } ?>
								  </tr>
							      <?
							   }	  
							   
							   $establecimiento = NULL;					  
						
						     //////////////////////////////////////////////////////////						
						
					 }
					
					
					?>		
				  </table>
				  <? } ?> 
				</td>				
			  </tr>
			  <? }?>
			  <tr class="textosimple">
				<td>PROMEDIO GENERAL</td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[1]){
					if ($origen[1]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[1]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								if (!$row_promocion[promedio]){	
									$promedio="&nbsp;";
								}else{
									$promedio=$row_promocion[promedio];
								}
						}
				}	
				if ($origen[1]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=1";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=$row_general[promedio];
					}
						
				}
							if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}
							echo $promedio;
							$promedio=NULL;
						?>    </td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[2]){
					if ($origen[2]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[2]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								if (!$row_promocion[promedio]){	
									$promedio="&nbsp;";
								}else{
									$promedio=$row_promocion[promedio];
								}
						}
				}	
				if ($origen[2]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=2";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=$row_general[promedio];
					}
						
				}
							if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}
							echo $promedio;
							$promedio=NULL;
						?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[3]){
					if ($origen[3]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[3]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								if (!$row_promocion[promedio]){	
									$promedio="&nbsp;";
								}else{
									$promedio=$row_promocion[promedio];
								}
						}
				}	
				if ($origen[3]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=3";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=$row_general[promedio];
					}
						
				}
				            if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}
							echo $promedio;
							$promedio=NULL;
						?></td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[4]){
					if ($origen[4]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[4]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								if (!$row_promocion[promedio]){	
									$promedio="&nbsp;";
								}else{
									$promedio=$row_promocion[promedio];
								}
						}
				}	
				if ($origen[4]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=4";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=$row_general[promedio];
					}
						
				}
							if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}	
							echo $promedio;
							$promedio=NULL;
						?></td>
			  </tr>
			  <tr class="textosimple">
				<td>PROMEDIO ASISTENCIA</td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[1]){
					if ($origen[1]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[1]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								$promedio=$row_promocion[asistencia];
								
						}
				}	
				if ($origen[1]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=1";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=trim($row_general[asistencia]);
					}
						
				}
							if (!$promedio){
							     if ($_INSTIT=='12829' OR  $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}else{
							     $promedio=$promedio."%";
							}
							echo $promedio;
							$promedio=NULL;
						?>    </td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[2]){
					if ($origen[2]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[2]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								$promedio=$row_promocion[asistencia];
								$promedio=$row_promocion[asistencia];
							
						}
				}	
				if ($origen[2]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=2";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=trim($row_general[asistencia]);
					}
						
				}
							if (!$promedio){
							     if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					                 $promedio = "-";
					             }else{
					                 $promedio = "&nbsp;";
					             }
							}else{
							     $promedio=$promedio."%";
							}	
							echo $promedio;
							$promedio=NULL;
						?>    </td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[3]){
					if ($origen[3]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[3]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								$promedio=$row_promocion[asistencia];
							
						}
				}	
				if ($origen[3]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=3";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=trim($row_general[asistencia]);
					}
						
				}
							if (!$promedio){
							    if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					               $promedio = "-";
					            }else{
					               $promedio = "&nbsp;";
					            }
							}else{
							    $promedio=$promedio."%";
							}	
							echo $promedio;
							$promedio=NULL;
						?>    </td>
				<td width="1%" align="center" nowrap="nowrap"><? 
			//	imprime_array($grado_curso);
				if ($anos_id[4]){
					if ($origen[4]==1){
								$query_promocion="select * from promocion where id_ano='$anos_id[4]' and rut_alumno='$rut_alumno' order by id_curso";
								$result_promocion=pg_exec($conn,$query_promocion);
								$num_promocion=pg_numrows($result_promocion);
								$row_promocion=pg_fetch_array($result_promocion);
								$promedio=$row_promocion[asistencia];
								
						}
				}	
				if ($origen[4]==2){
					$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=4";
					$result_general=pg_exec($conn,$query_general);
					$num_general=pg_numrows($result_general);
					if ($num_general>0){
						$row_general=pg_fetch_array($result_general);
						$promedio=trim($row_general[asistencia]);
					}
						
				}
							if ($promedio==""){
							    if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
					               $promedio = "-";
					            }else{
					               $promedio = "&nbsp;";
					            }
							}else{
							    $promedio=$promedio."%";
							}	
							echo $promedio;
							$promedio=NULL;
						?></td>
			  </tr>
			</table>
			</td></tr>			
			<? $fecha = date("d-m-Y")?>
			<tr><td align="center" class="textosimple"><? if($_INSTIT!=770 and $_INSTIT!=14703 and $_INSTIT!=769){ 
				echo $ciudad; 
			}elseif ($_INSTIT==770 or $_INSTIT==769) { 
				echo Ovalle; 
			}else 
			   echo $comuna; 
			   
			?>
			  ,  <?php echo  fecha_espanol($fecha); ?> <br />
			  
			  
			  
			  <?
			  //if ($_INSTIT==9071){
			  ///////////////////////
			  if ( $_POST[checkbox1] == 1 ){
			  			
			    $contador_acumulado = ($contador_acumulado - $contador_religion);
				$ponderacion_rende = $acumulo_promedio/$contador_acumulado;
				//$ponderacion_rende = substr($acumulo_promedio/$contador_acumulado,0,2);
				
			   ?>	
			  <table width="100%" border="1" cellspacing="0" cellpadding="2" align="left">
				<tr>
				  <td class="textosimple" width="170">Total notas promediadas</td>
				  <td width="20"><?=$contador_acumulado ?></td>
				
				  <td class="textosimple" width="170">Suma Ponderación</td>
				  <td width="20"><?=$acumulo_promedio ?></td>
				
				  <td class="textosimple" width="170">Ponderación Demre</td>
				  <td width="20"><?=$ponderacion_rende ?></td>
				</tr>
			  </table>
			  <?
			  
			  }
			  ////////////////////////////////
				$contador_acumulado = 0;
				$contador_religion = 0;
				$acumulo_promedio = 0;		
				////////////////////////////////
			  
			  ////////////////////////
			  ?>
			  
			  
			  
			  <br />
			  <br />
			  <br />
			  <br /></td></tr>  				
			<tr><td align="center">
			<?	$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$cmb_curso.")); ";
				$result_sql4 =@pg_Exec($conn,$sql4);
				$filaprofe = pg_fetch_array($result_sql4);			
				$profe_jefe = trim($filaprofe['ape_pat'])." ".trim($filaprofe['ape_mat']).", ".trim($filaprofe['nombre_emp']);
				$profesor_jefe = trim($filaprofe['nombre_emp'])." ".trim($filaprofe['ape_pat'])." ".trim($filaprofe['ape_mat']);
			//----------------------------------
				$sql_dir = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
				$sql_dir = $sql_dir . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
				$sql_dir = $sql_dir . "WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23) ";
				$result_sql_dir =@pg_Exec($conn,$sql_dir);
				$filadire = pg_fetch_array($result_sql_dir);
				$director_est =	trim($filadire['ape_pat'])." ".trim($filadire['ape_mat']).", ".trim($filadire['nombre_emp']);
				$director_estab =	trim($filadire['nombre_emp'])." ".trim($filadire['ape_pat'])." ".trim($filadire['ape_mat']);	
			?>
			<table width="100%">
				<? if($cb_ok!="Buscar"){?>
					<tr>&nbsp;</tr>
					<tr>&nbsp;</tr>
					<tr>&nbsp;</tr>
					<? }?>
			  <tr><td><table width="1%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
				<tr>
				  <td align="center" width="">__________________________________<br />
					   <? if($institucion==770){?>
						PROFESOR JEFE <br />
					   <? }else{ ?>
					   PROFESOR(A) JEFE <br />
					   <? } ?>
							  <? if($institucion==770){
						echo $profesor_jefe;
					}else{
						echo $profe_jefe;
					}
				  ?> </td>
				</tr>
			  </table></td><td><table width="1%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
				<tr>
				  <td align="center">__________________________________<br />
					   <? if($institucion==770){?>
								DIRECTOR<br />
						<? }else{ ?>
								<?=$cargo_dir2?> <br />
						 <? } ?>
					<? if($institucion==770){
							echo $director_estab;
						}else{
						     if ($institucion==2278){
							      echo "ANA LORENA ALCOTA IRELAND";
							 }else{
							      echo $director_est;
							 }	  
						}?></td>
				</tr>
			  </table></td></tr></table> 
			  </td></tr>
			
			</table>
			
<h1 class="salto"></h1>
	
<?  
} 
?>
<!-- FIN VEL -->
<? }


pg_close();

 ?>
</body>
</html>
<? pg_close($conn);?>