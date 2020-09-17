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

///Sacar nro año actual
$sql_ano_actual = "select nro_ano from ano_escolar where id_ano = '$_ANO'";
$res_ano_actual = @pg_Exec($conn, $sql_ano_actual);
$fil_ano_actual = @pg_fetch_array($res_ano_actual);
$nro_ano = $fil_ano_actual['nro_ano'];

/// sacar los anos anteriores
$sql_ano4 = "select id_ano from ano_escolar where id_institucion = '$_INSTIT' and nro_ano = '$nro_ano'";
$res_ano4 = @pg_Exec($conn, $sql_ano4);
$fil_ano4 = @pg_fetch_array($res_ano4);
$ano_4    = $fil_ano4['id_ano'];
$nro_ano--;

$sql_ano3 = "select id_ano from ano_escolar where id_institucion = '$_INSTIT' and nro_ano = '$nro_ano'";
$res_ano3 = @pg_Exec($conn, $sql_ano3);
$fil_ano3 = @pg_fetch_array($res_ano3);
$ano_3    = $fil_ano3['id_ano'];
$nro_ano--;

$sql_ano2 = "select id_ano from ano_escolar where id_institucion = '$_INSTIT' and nro_ano = '$nro_ano'";
$res_ano2 = @pg_Exec($conn, $sql_ano2);
$fil_ano2 = @pg_fetch_array($res_ano2);
$ano_2    = $fil_ano2['id_ano'];
$nro_ano--;

$sql_ano1 = "select id_ano from ano_escolar where id_institucion = '$_INSTIT' and nro_ano = '$nro_ano'";
$res_ano1 = @pg_Exec($conn, $sql_ano1);
$fil_ano1 = @pg_fetch_array($res_ano1);
$ano_1    = $fil_ano1['id_ano'];
$nro_ano--;




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
				form.action = 'concentracionnotas_dd.php';
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
<? 


   if ($rut_alumno==0){
        $txt_alumno = " ";
   }else{
        $txt_alumno = " and rut_alumno = '$rut_alumno'";   
   }
	
	
/// consulta para rescatar todos los alumnos
  $sql_alumnos = "select rut_alumno from matricula where id_ano = '".$_ANO."' and bool_ar = '0' and id_curso = '".$cmb_curso."' $txt_alumno";
  $res_alumnos = @pg_Exec($conn, $sql_alumnos);
  $num_alumnos = @pg_numrows($res_alumnos);
  
  for ($i_alum=0; $i_alum < $num_alumnos; $i_alum++){
	  $fil_alumnos = @pg_fetch_array($res_alumnos,$i_alum);
	  $rut_alumno = $fil_alumnos['rut_alumno'];	
	
	
	
	
	
	
		$sql_borra_orden = "delete from orden_concentracion where rut_alumno = '$rut_alumno'";
		$res_borra_orden = @pg_Exec($conn,$sql_borra_orden); 
		
	
		//// ciclo para guardar el orden de los subsectores  ////
		for ($ii_aux=0; $ii_aux < $contador_campos; $ii_aux++){
			$orden_campo = "orden_campo".$ii_aux;
			$orden_campo = $$orden_campo;
			
			$cso = "cso".$ii_aux;
			$cso = $$cso;
			
			if ($orden_campo>0){
			   
			}else{
				$orden_campo=0;
			}
			
			$sql_insert_orden = "insert into orden_concentracion (rdb, id_ano, cod_subsector, orden, rut_alumno) values ('$institucion','$ano','$cso','$orden_campo','$rut_alumno')";
			$res_insert_orden = pg_Exec($conn, $sql_insert_orden);
			
		}
		////

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


		
		
      
		 
		 
		     if ($institucion=="770"){ 
			      // no muestro los datos de la institucion
			      // por que ellos tienen hojas pre-impresas
			      echo "<br><br><br><br><br><br><br><br><br><br><br>";
		     }	 
		 
		     ?>
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
						} ?>
	  
	  	                </td>
						<td width="173" rowspan="5" align="left" valign="top">		
							<div align="center">
								<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>REP&Uacute;BLICA DE CHILE</strong></font><BR>
								<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> MINISTERIO DE EDUCACI&Oacute;N</font><BR>
								<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> DIVISI&Oacute;N DE EDUCACI&Oacute;N </font><BR>
								<font face="Verdana, Arial, Helvetica, sans-seri" size="-2">SECRETARIA REGIONAL MINISTERIAL</font><BR>
								<font face="Verdana, Arial, Helvetica, sans-seri" size="-2">DE EDUCACI&Oacute;N </font><BR>
						  </div></td>
                 <td width="85" rowspan="5"></td>			
				<td width="104"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">REGIÓN</font></td>
				<td width="10"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
				<td width="241"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $region?></strong></font></td>
	   

				  </tr>
				  <tr>
					<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROVINCIA</font></td>
					<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
					<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>
					<?
					if ($_INSTIT==516){
						echo "LA SERENA";
					}else{
					    if ($_INSTIT==12838){
						   echo "CALAMA";
					    }else{
						      if ($_INSTIT==12829){
						           echo "EL LOA";
						      }else{  	
							       echo $provincia;
						      }
						}	  	 
					}
					?>
		
					</strong></font></td>
					</tr>
				  <tr>
					<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">COMUNA</font></td>
					<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
					<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>
					<?
					if ($_INSTIT==12829){
					    echo "EL LOA";
					}else{  	
					    echo $comuna;
					}
					?></strong></font></td>
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
	
			<? } /// fin if de 770 ?>	

	        <tr><td>			
			<table align="center">			
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
			<tr><td>
			<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="70%" rowspan="2" valign="top" nowrap="nowrap" class="textosimple"><table width="100%" border="1" cellpadding="2" cellspacing="0">
                  <tr>
                    <td rowspan="2">SUBSECTOR ASIGNATURA Y MODULO </td>
                    <td colspan="4">CURSO DE ENSE&Ntilde;ANZA MEDIA </td>
                  </tr>
                  <tr>
                    <td width="40">1</td>
                    <td width="40">2</td>
                    <td width="40">3</td>
                    <td width="40">4</td>
                  </tr>
				  <!-- consulta para sacar los subsectores -->
				  <?
				  $acumulo_promedio = 0;
				  $contador_acumulado=0;
				
				  $sql_orden_sub = "select * from orden_concentracion inner join subsector on orden_concentracion.cod_subsector=subsector.cod_subsector  where orden_concentracion.rut_alumno = '$rut_alumno' order by orden_concentracion.orden";
				  $res_orden_sub = @pg_Exec($conn,$sql_orden_sub);
				  $num_orden_sub = @pg_numrows($res_orden_sub);
				  for ($i_sub=0; $i_sub < $num_orden_sub; $i_sub++){
				       $fil_sub = @pg_fetch_array($res_orden_sub,$i_sub);
					   $nombre_sub = $fil_sub['nombre'];
					   $cod_subsector = $fil_sub['cod_subsector'];
					   ?>					   
					   <tr>
						<td height="15"><?=$nombre_sub?></td>
						<!-- determinar si este año se ingresó a manoo no,
						para ello consultamos el id_ramo en la tabla concentración detalle,
						cón el código del subsector -->
						<?
						$sql_sub_curso = "select * from concentracion_detalle where rut_alumno = '$rut_alumno' and curso = '1' and subsector = '$cod_subsector'";
						$res_sub_curso = @pg_Exec($conn,$sql_sub_curso);
						$num_sub_curso = @pg_numrows($res_sub_curso);
						if ($num_sub_curso>0){
						     /// existe, fue ingresado manualmente. Tomamos el promedio
							 $fil_sub_curso = @pg_fetch_array($res_sub_curso,0);
							 $promedio_sub = $fil_sub_curso['promedio'];
							 $subsector_sub = $fil_sub_curso['subsector'];
							 if ($subsector_sub==13){
							     $promedio_sub = $fil_sub_curso['religion'];
							 }
						}else{
						     // no existe el promedio se debe sacar de la tabla promedio_subsector
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$ano_1') and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno'";
							 $res_prom_sub = @pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = @pg_numrows($res_prom_sub);
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '1')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno'";
								  
								  
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
						}
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}		 	 
							 	 
						?>							  
						<td>
						  <div align="center">
						    &nbsp;<? if ((trim($promedio_sub)>0)){ ?><?=$promedio_sub?><? }elseif (trim($promedio_sub)=="MB" or trim($promedio_sub)=="B" or trim($promedio_sub)=="S" or trim($promedio_sub)=="I"){ ?><?=$promedio_sub?><? } ?>
				         </div></td>
						
						<?
						/// limpio promedio_sub
						$promedio_sub=0;
						// hacemos lomismo cambiando solo el grado del curso
						$sql_sub_curso = "select * from concentracion_detalle where rut_alumno = '$rut_alumno' and curso = '2' and subsector = '$cod_subsector'";
						$res_sub_curso = @pg_Exec($conn,$sql_sub_curso);
						$num_sub_curso = @pg_numrows($res_sub_curso);
						if ($num_sub_curso>0){
						     /// existe, fue ingresado manualmente. Tomamos el promedio
							 $fil_sub_curso = @pg_fetch_array($res_sub_curso,0);
							 $promedio_sub = $fil_sub_curso['promedio'];
							 $subsector_sub = $fil_sub_curso['subsector'];
							 if ($subsector_sub==13){
							     $promedio_sub = $fil_sub_curso['religion'];
							 }
						}else{
						     // no existe el promedio se debe sacar de la tabla promedio_subsector
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$ano_2') and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno'";
							 $res_prom_sub = @pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = @pg_numrows($res_prom_sub);
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '2')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno'";
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
						}
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}
						?>							 
						<td>
						  <div align="center">
						    &nbsp;<? if ((trim($promedio_sub)>0)){ ?><?=$promedio_sub?><? }elseif (trim($promedio_sub)=="MB" or trim($promedio_sub)=="B" or trim($promedio_sub)=="S" or trim($promedio_sub)=="I"){ ?><?=$promedio_sub?><? } ?>
				         </div></td>
						
						<?
						/// limpio promedio_sub
						$promedio_sub=0;
						// hacemos lomismo cambiando solo el grado del curso
						$sql_sub_curso = "select * from concentracion_detalle where rut_alumno = '$rut_alumno' and curso = '3' and subsector = '$cod_subsector'";
						$res_sub_curso = @pg_Exec($conn,$sql_sub_curso);
						$num_sub_curso = @pg_numrows($res_sub_curso);
						if ($num_sub_curso>0){
						     /// existe, fue ingresado manualmente. Tomamos el promedio
							 $fil_sub_curso = @pg_fetch_array($res_sub_curso,0);
							 $promedio_sub = $fil_sub_curso['promedio'];
							 $subsector_sub = $fil_sub_curso['subsector'];
							 if ($subsector_sub==13){
							     $promedio_sub = $fil_sub_curso['religion'];
							 }
						}else{
						     // no existe el promedio se debe sacar de la tabla promedio_subsector
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$ano_3') and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno'";
							 $res_prom_sub = @pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = @pg_numrows($res_prom_sub);
							 if ($_PERFIL==0){
							     //echo "<br>$sql_prom_sub<br>";
							 }							 
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '3')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno'";
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
						}
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}
						?>						
						<td>
						  <div align="center">
						    &nbsp;<? if ((trim($promedio_sub)>0)){ ?><?=$promedio_sub?><? }elseif (trim($promedio_sub)=="MB" or trim($promedio_sub)=="B" or trim($promedio_sub)=="S" or trim($promedio_sub)=="I"){ ?><?=$promedio_sub?><? } ?>
				         </div></td>
						
						<?
						/// limpio promedio_sub
						$promedio_sub=0;
						// hacemos lomismo cambiando solo el grado del curso
						$sql_sub_curso = "select * from concentracion_detalle where rut_alumno = '$rut_alumno' and curso = '4' and subsector = '$cod_subsector'";
																		
						$res_sub_curso = @pg_Exec($conn,$sql_sub_curso);
						$num_sub_curso = @pg_numrows($res_sub_curso);
						if ($num_sub_curso>0){
						     /// existe, fue ingresado manualmente. Tomamos el promedio
							 $fil_sub_curso = @pg_fetch_array($res_sub_curso,0);
							 $promedio_sub = $fil_sub_curso['promedio'];
							 $subsector_sub = $fil_sub_curso['subsector'];
							 if ($subsector_sub==13){
							     $promedio_sub = $fil_sub_curso['religion'];
							 }
							 
						}else{
						     // no existe el promedio se debe sacar de la tabla promedio_subsector
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$ano_4') and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno'";
							 if ($_PERFIL==0){
							     //echo "<br>$sql_prom_sub<br>";
							 }							 
							 $res_prom_sub = pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = pg_numrows($res_prom_sub);
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
								 
								 if ($_PERFIL==0){
							          //echo "p: $promedio_sub  <br>";
							     }
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '4')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno'";
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
						}
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}
						?>
						<td>
						  <div align="center">
						    &nbsp;<? if ((trim($promedio_sub)>0)){ ?><?=$promedio_sub?><? }elseif (trim($promedio_sub)=="MB" or trim($promedio_sub)=="B" or trim($promedio_sub)=="S" or trim($promedio_sub)=="I"){ ?><?=$promedio_sub?><? } ?>
				         </div></td>
					   </tr>
					   <?
					   /// limpio promedio_sub
						$promedio_sub=0;
				  }	   
                  ?>
				  <tr>
                    <td height="15">PROMEDIO GENERAL </td>
					<?
					// consultas para sacar el promedio General del alumno //
					$sql_prom_gral="select promedio, asistencia from concentracion_notas where rut_alumno='$rut_alumno' and curso=1";
					$res_prom_gral= @pg_exec($conn,$sql_prom_gral);
					$num_prom_gral= @pg_numrows($res_prom_gral);
					if ($num_prom_gral>0){
					    /// existe, el promedio fué ingresado a mano
						$fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
						$promedio_gral= $fil_prom_gral['promedio'];
						$asistencia_1 = $fil_prom_gral['asistencia'];
					}else{
					    /// el promedio se saca de promocion
						$sql_prom_gral="select promedio, asistencia from promocion where id_ano in (select id_ano from ano_escolar where id_ano = '$ano_1') and rut_alumno='$rut_alumno'";
						$res_prom_gral= @pg_Exec($conn,$sql_prom_gral);
						$num_prom_gral= @pg_numrows($res_prom_gral);
						if ($num_prom_gral>0){
						     /// esta en promocion, se hizo la promocion
							 $fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
	               			 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_1 = $fil_prom_gral['asistencia'];
					    }else{
						     /// tomar la asistencia de la tabla promocion de otra institucion
							 $sql_prom_gral = "select promedio, asistencia from promocion where id_curso in  (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '1')) and rut_alumno = '$rut_alumno'";
							 
							 $res_prom_gral = @pg_Exec($conn,$sql_prom_gral);
							 $fil_prom_gral = @pg_fetch_array($res_prom_gral,0);
							 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_1 = $fil_prom_gral['asistencia'];						
						}
					}	     	
					?>
                    <td>&nbsp;
                      <div align="center">
                        <?=$promedio_gral?>
                    </div></td>
					
					<?
					// consultas para sacar el promedio General del alumno //
					$sql_prom_gral="select promedio, asistencia from concentracion_notas where rut_alumno='$rut_alumno' and curso=2";
					$res_prom_gral= @pg_exec($conn,$sql_prom_gral);
					$num_prom_gral= @pg_numrows($res_prom_gral);
					if ($num_prom_gral>0){
					    /// existe, el promedio fué ingresado a mano
						$fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
						$promedio_gral= $fil_prom_gral['promedio'];
						$asistencia_2 = $fil_prom_gral['asistencia'];
					}else{
					    /// el promedio se saca de promocion
						$sql_prom_gral="select promedio, asistencia from promocion where id_ano in (select id_ano from ano_escolar where id_ano = '$ano_2') and rut_alumno='$rut_alumno'";
						$res_prom_gral= @pg_Exec($conn,$sql_prom_gral);
						$num_prom_gral= @pg_numrows($res_prom_gral);
						if ($num_prom_gral>0){
						     /// esta en promocion, se hizo la promocion
							 $fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
	               			 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_2 = $fil_prom_gral['asistencia'];
					    }else{
						     /// tomar la asistencia de la tabla promocion de otra institucion
							 $sql_prom_gral = "select promedio, asistencia from promocion where id_curso in  (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '2')) and rut_alumno = '$rut_alumno'";
							 
							 $res_prom_gral = @pg_Exec($conn,$sql_prom_gral);
							 $fil_prom_gral = @pg_fetch_array($res_prom_gral,0);
							 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_2 = $fil_prom_gral['asistencia'];						
						}
					}
					?>
                    <td>&nbsp;
                      <div align="center">
                        <?=$promedio_gral?>
                    </div></td>
					
					<?
					// consultas para sacar el promedio General del alumno //
					$sql_prom_gral="select promedio, asistencia from concentracion_notas where rut_alumno='$rut_alumno' and curso=3";
					$res_prom_gral= @pg_exec($conn,$sql_prom_gral);
					$num_prom_gral= @pg_numrows($res_prom_gral);
					if ($num_prom_gral>0){
					    /// existe, el promedio fué ingresado a mano
						$fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
						$promedio_gral= $fil_prom_gral['promedio'];
						$asistencia_3 = $fil_prom_gral['asistencia'];
					}else{
					    /// el promedio se saca de promocion
						$sql_prom_gral="select promedio, asistencia from promocion where id_ano in (select id_ano from ano_escolar where id_ano = '$ano_3') and rut_alumno='$rut_alumno'";
						$res_prom_gral= @pg_Exec($conn,$sql_prom_gral);
						$num_prom_gral= @pg_numrows($res_prom_gral);
						if ($num_prom_gral>0){
						     /// esta en promocion, se hizo la promocion
							 $fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
	               			 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_3 = $fil_prom_gral['asistencia'];
					    }else{
						     /// tomar la asistencia de la tabla promocion de otra institucion
							 $sql_prom_gral = "select promedio, asistencia from promocion where id_curso in  (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '3')) and rut_alumno = '$rut_alumno'";
							 
							 $res_prom_gral = @pg_Exec($conn,$sql_prom_gral);
							 $fil_prom_gral = @pg_fetch_array($res_prom_gral,0);
							 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_3 = $fil_prom_gral['asistencia'];						
						}
					}
					?>
                    <td>&nbsp;
                      <div align="center">
                        <?=$promedio_gral?>
                    </div></td>
					
					<?
					// consultas para sacar el promedio General del alumno //
					$sql_prom_gral="select promedio, asistencia from concentracion_notas where rut_alumno='$rut_alumno' and curso=4";
					$res_prom_gral= @pg_exec($conn,$sql_prom_gral);
					$num_prom_gral= @pg_numrows($res_prom_gral);
					if ($num_prom_gral>0){
					    /// existe, el promedio fué ingresado a mano
						$fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
						$promedio_gral= $fil_prom_gral['promedio'];
						$asistencia_4 = $fil_prom_gral['asistencia'];
					}else{
					    /// el promedio se saca de promocion
						$sql_prom_gral="select promedio, asistencia from promocion where id_ano in (select id_ano from ano_escolar where id_ano = '$ano_4') and rut_alumno='$rut_alumno'";
						$res_prom_gral= @pg_Exec($conn,$sql_prom_gral);
						$num_prom_gral= @pg_numrows($res_prom_gral);
						if ($num_prom_gral>0){
						     /// esta en promocion, se hizo la promocion
							 $fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
	               			 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_4 = $fil_prom_gral['asistencia'];
					    }else{
						     /// tomar la asistencia de la tabla promocion de otra institucion
							 $sql_prom_gral = "select promedio, asistencia from promocion where id_curso in  (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '4')) and rut_alumno = '$rut_alumno'";
							 
							 $res_prom_gral = @pg_Exec($conn,$sql_prom_gral);
							 $fil_prom_gral = @pg_fetch_array($res_prom_gral,0);
							 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_4 = $fil_prom_gral['asistencia'];						
						}
					}
					?>
                    <td>&nbsp;
                      <div align="center">
                        <?=$promedio_gral?>
                    </div></td>
                  </tr>
                  <tr>
                    <td height="15">PROMEDIO ASISTENCIA </td>
                    <td>&nbsp;
                      <div align="center">
                        <?=$asistencia_1?>
                    %</div></td>
                    <td>&nbsp;
                      <div align="center">
                        <?=$asistencia_2?>
                    %</div></td>
                    <td>&nbsp;
                      <div align="center">
                        <?=$asistencia_3?>
                    %</div></td>
                    <td>&nbsp;
                      <div align="center">
                        <?=$asistencia_4?>
                    %</div></td>
                  </tr>
                </table></td>
				<td width="30%" align="center" nowrap="nowrap" class="textosimple">AÑO ESCOLAR Y ESTABLECIMIENTO <br />
			    EDUCACIONAL</td>
			  </tr>
			  
			 
			  <tr class="textosimple">				
				<? $colegio=$row_ano[nombre_instit];  ?>
				<td  valign="top" >
					<table width="50%" class="textosimple">
					
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
								   if ($_INSTIT!=770 and $_INSTIT!=769  and $_INSTIT!=12829 and $_INSTIT!=12838){
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
												}elseif($_INSTIT==12838 and trim($city)=="EL LOA"){
													echo "CALAMA";
												}else{	 
												     if($_INSTIT==12829 and trim($city)=="EL LOA"){
													     echo "CALAMA";
									                 }
												} 
										   }	 	
										  	   									   
									   }	   
							       }
								   ?>
								   
								   
								   </b>&nbsp;&nbsp;Comuna: <b>
								   <? 
								   if($establecimiento=="COLEGIO AMALIA ERRÁZURIZ"){
								       echo Ovalle;
								   }else{
								       if ($_INSTIT==12829 and trim($city)=="EL LOA"){
										    echo "EL LOA";
									   }else{	  			
								            echo $comuna_real;
									   }
								   }	    
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
				</td>				
			  </tr>
			
			</table>
			</td></tr><? $fecha = date("d-m-Y")?>
			<tr><td align="center" class="textosimple">
			<? if($_INSTIT!=770 and $_INSTIT!=14703 and $_INSTIT!=516 and $_INSTIT!=769 and $_INSTIT!=12838){ 
				    echo $ciudad; 
			   }else{
					if ($_INSTIT==770 or $_INSTIT==769) { 
						echo Ovalle; 
					}else{
						  if ($_INSTIT==516){
							   echo "LA SERENA";
						  }else{
						       if ($_INSTIT==12838){		 
							       echo "CALAMA";
							   }else{
							       echo $comuna;
							   }	   
						  }
					}	  	    
			   }	
			   
			?>
			  ,  <?php echo  fecha_espanol($fecha); ?> <br />
			  <?
			  if ($_INSTIT==9071){
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
			  </table></td></tr></table> </td></tr>
			
			</table>
<? 
 /// salto de página /////
		 if ($num_alumnos > 0){ 		 
			 ?>
			 <h1 class="salto"></h1>
			 <?
		 }	 
 
    
}

?>
</body>
</html>
<? pg_close($conn);?>