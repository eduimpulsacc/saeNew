 <?php require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');


///////////////////
$institucion = $_INSTIT;
$ano			=$_ANO;

$rut_alumno = $cmb_alumno;
$curso      = $cmb_curso;
$checkbox1  =  $_POST[checkbox1] ;

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=ConcentracionNotas".$rut_alumno."_".date("d_m_y_h_m_s").".xls");
header("Pragma: no-cache");
header("Expires: 0");


if ($dia == ""){
	   ## si el campo esta vacío poner la fecha actual
	   $dia  = strftime("%d",time());
	   $mes  = strftime("%m",time());
	   $mes  = envia_mes($mes);
	   $ano2  = strftime("%Y",time()); 
	}       

	//if ($_PERFIL==0){
	  $sqlc="select ensenanza,es.nombre_esp,te.nombre_tipo,se.nombre_sector 
	        from curso c
			inner join especialidad es on es.cod_esp=c.cod_es
			inner join tipo_ensenanza te on te.cod_tipo=c.ensenanza  
			inner join sector_eco se on c.cod_sector=se.cod_sector
	 		where id_curso=".$curso;
			$rs_ensenanza=pg_Exec($conn,$sqlc);
			$filc=pg_fetch_array($rs_ensenanza,0);
			$ensenanza1=$filc['ensenanza'];
			$nombre_tipo=$filc['nombre_tipo'];
			$nombre_especialidad=$filc['nombre_esp'];
			$nombre_sector_eco=$filc['nombre_sector'];
	//}
	
	
	
	/************************TIPO ENSEÑANZA***************************************/		
			
		$sql_ense="select ensenanza from curso where id_curso=$curso";
		$rs_curso=pg_exec($conn,$sql_ense);
		$id_ensenanza=pg_fetch_array($rs_curso,0);
		//print_r($id_ensenanza);
		
		
		$sql_tipo_ense="select nombre_tipo from tipo_ensenanza where cod_tipo=".$id_ensenanza[0]."";
		$rs_tipo_ense=pg_exec($conn,$sql_tipo_ense);
		$nombre_tipo_ense=pg_fetch_array($rs_tipo_ense,0);
		 $nombre_tipo_ense[0];
		

///Sacar nro año actual
$sql_ano_actual = "select nro_ano from ano_escolar where id_ano = '$_ANO'";
$res_ano_actual = @pg_Exec($conn, $sql_ano_actual);
$fil_ano_actual = @pg_fetch_array($res_ano_actual);
$nro_ano = $fil_ano_actual['nro_ano'];

$sql="SELECT esp.nombre_esp FROM curso INNER JOIN especialidad esp ON curso.cod_es=esp.cod_esp WHERE id_curso=".$curso;
$rs_especialidad = @pg_exec($conn,$sql);
$especialidad = @pg_result($rs_especialidad,0);
	 
	 $whe_conceptos=	"and promedio not in ('I','S','B','MB')";
	
/*	 function imprime_arreglo($arreglo){
	    echo "<pre>";
	    print_r($arreglo);
	    echo "</pre>";
     }*/
     
	 $query_ins_ano="select rdb,dig_rdb, nombre_instit from institucion as ins, ano_escolar as ano where ins.rdb='$_INSTIT' and  ano.id_ano='$_ANO'"; //revisar
     $row_ano=pg_fetch_array(pg_exec($conn,$query_ins_ano));


     $q1 = "select cargo, rut_emp from trabaja where rdb = '".trim($institucion)."' and (cargo=1 OR cargo=23)";
     $r1 = @pg_Exec($conn,$q1);
     $n1 = @pg_numrows($r1);

	
	 $f1 = @pg_fetch_array($r1,0);
	 $cargo = $f1['cargo'];
		
	 if ($cargo==1){
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "DIRECTOR(a)";
	 }
	 if ($cargo==23){
		$cargo_dir  = "rector(a)";
		$cargo_dir2 = "RECTOR(a)";
	 }
	
	 if ($institucion==2278){
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "DIRECTOR(a)";
	 }
	 if ($institucion==9239){
		$cargo_dir  = "Director";
		$cargo_dir2 = "Director";
	 }
	 $ob_reporte =new Reporte();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

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
.textosimple {
	FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.textonegrita {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.titulo {
	FONT-WEIGHT: bold; FONT-SIZE: 9px; COLOR: #000000; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.tableindex {
	background-color:#003366;
	FONT-WEIGHT: bold; 
	FONT-SIZE: 12px; 
	COLOR: #FFFFFF; 
	TEXT-INDENT: 5px; 
	BACKGROUND-REPEAT: repeat-x; 
	FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; 
	HEIGHT: 39px; 
	TEXT-ALIGN: left; 
	TEXT-DECORATION: none
}
.medida{
	width:300px; 	display:inline-block;
}
-->
</style>
	


<body  >

 
							
		<?
	
	$sql_sub = "select orden_concentracion_notas.cod_subsector, orden_concentracion_notas.orden, subsector.nombre from orden_concentracion_notas inner join subsector on subsector.cod_subsector=orden_concentracion_notas.cod_subsector where id_curso = '$curso' order by orden";
	$res_sub = pg_Exec($conn, $sql_sub);
	$num_sub = pg_numrows($res_sub);
	
	//if($_PERFIL==0){ echo $sql_sub;}
	
	

/// Consulta para saber cuantas concentraciones de notas sacamos

if ($cmb_alumno>0){
    $filtro = " and matricula.rut_alumno = '$cmb_alumno' ";
}else{
	$filtro = " ";
}



//// consulta General //////

$sql_concentracion="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso." and matricula.rut_alumno = alumno.rut_alumno  $filtro  order by ape_pat, ape_mat, nombre_alu";
$result_concentracion= @pg_Exec($conn,$sql_concentracion);

for($iii=0 ; $iii < @pg_numrows($result_concentracion); $iii++){
	$fila_concentracion = @pg_fetch_array($result_concentracion,$iii);
	
	$rut_alumno = $fila_concentracion['rut_alumno'];

    $contador_acumulado = 0;
    $acumulo_promedio = 0;
	$ponderacion_rende = 0;
	
	
	
	$sql = "SELECT 
  inst.rdb as insti,
  pro.id_ano as id_ano,
  pro.rut_alumno as rut_alumno,
  inst.nombre_instit as nombreinstitucion,
  anes.nro_ano as numero_ano,
  cast(cu.grado_curso || '-' || cu.letra_curso as varchar(3)) as cursoletra
  FROM promocion pro
  inner join institucion inst on inst.rdb = pro.rdb
  inner join ano_escolar anes on anes.id_ano = pro.id_ano
  inner join matricula ma on ma.id_ano = pro.id_ano and ma.rut_alumno = $rut_alumno
  inner join curso cu on cu.id_ano = anes.id_ano and cu.ensenanza > 110 and cu.id_curso = ma.id_curso
  WHERE 
  pro.rut_alumno = $rut_alumno and pro.situacion_final = 1 and pro.promedio > 0 and pro.asistencia > 0
  UNION
  SELECT 
  0 as insti,
  0 as id_ano,
  conce.rut_alumno ,
  conce.institucion,
  conce.ano,
  cast(conce.curso || '-' || conce.letra as varchar(3)) as cursoletra
  FROM concentracion_notas conce where conce.rut_alumno = $rut_alumno  order by numero_ano DESC";

/*if($_PERFIL==0){
echo '<pre>'.$sql.'</pre>';
}
*/
$result= @pg_Exec($conn,$sql);
if(@pg_numrows($result)==4){
	$r=4; // desde cuarto medio. 
}else{
	$r=3; 
}
for($i=0;$i < @pg_numrows($result);$i++){
    $fila = @pg_fetch_array($result,$i);
   
 ${"ano_".$r} = $fila['id_ano'];
 ${"nro_ano".$r} = $fila['numero_ano'];
 
 $r--; // hasta primero medio.
  
   }
		
		
		//////// fin nuevo codigo para obtener los años de los alumnos que si cursaron y pasaron de curso.
	
	
	
	

if($rut_alumno>0){
            
            $sql_ins = "SELECT institucion.nombre_instit, institucion.nu_resolucion, institucion.fecha_resolucion, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
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


			$query_decreto="select plan.* from  curso , plan_estudio as plan  where curso.id_curso='$cmb_curso' and plan.cod_decreto=curso.cod_decreto";
			$result_decreto=pg_exec($conn,$query_decreto);
			$num_decreto=pg_numrows($result_decreto);
			if ($num_decreto>0){
				$row_decreto=pg_fetch_array($result_decreto);
				$arreglo=explode(" ",$row_decreto[nombre_decreto]);
				$decreto_numero=$arreglo[0];
				$decreto_ano=$arreglo[2];
			}
		
		   $query_alumno="select nombre_alu, ape_pat, ape_mat ,rut_alumno, dig_rut from alumno  where rut_alumno='$rut_alumno'";
		   $result_alumno=pg_exec($conn,$query_alumno);
		   $num_alumno=pg_numrows($result_alumno);
		   if ($num_alumno>0){
			   $row_alumno=pg_fetch_array($result_alumno);
		   }
		   $ramo_id=array();
		   $ramo_nombre=array();
		   $cod_subsector=array();

		   $query_matricula="select * from matricula as mat, ano_escolar as ano, curso as curso  where mat.rut_alumno='$rut_alumno' and mat.id_ano=ano.id_ano and curso.id_curso=mat.id_curso and mat.bool_ar = '0' and mat.id_ano in (select id_ano from promocion where rut_alumno = '$rut_alumno' and situacion_final <> '2') order by ano.nro_ano Desc";
		
		   $result_matricula=pg_exec($conn,$query_matricula);
		   $num_matricula=pg_numrows($result_matricula);
		   for ($i=0;$i<$num_matricula; ++$i){
			   $row_matricula=pg_fetch_array($result_matricula);
			   $curso_grado=$row_matricula[grado_curso];
			   $anos_id[$curso_grado]=$row_matricula[id_ano];
			   $grado_curso[$curso_grado]=$row_matricula[grado_curso];
			   $nro_ano[$curso_grado]=$row_matricula[nro_ano];
			   $aproxima[$curso_grado]=$row_matricula[truncado_per];
			   $curso_id[$curso_grado]=$row_matricula[id_curso];
			   $origen[$curso_grado]=1;
			
		       $query_tiene="select * from ramo r inner join tiene".$row_matricula[nro_ano]." t on t.id_ramo=r.id_ramo inner join subsector s on s.cod_subsector=r.cod_subsector inner join curso c on c.id_curso=r.id_curso where r.bool_ip = '1' and t.rut_alumno=".$rut_alumno." and (c.ensenanza=310 or c.ensenanza=410 or c.ensenanza=510 or c.ensenanza=610 or c.ensenanza=710 or c.ensenanza=810 or c.ensenanza=360 or c.ensenanza=460 or c.ensenanza=560 or c.ensenanza=660 or c.ensenanza=760 or c.ensenanza=860 or c.ensenanza=461 or c.ensenanza=561 or c.ensenanza=661 or c.ensenanza=761 or c.ensenanza=861 or c.ensenanza=361 )  order by r.id_orden ";
			   
			   /*if($_PERFIL==0){
			   		echo $query_tiene."<br>";
			   }*/
		       $result_tiene=pg_exec($conn,$query_tiene);
			   $num_tiene=pg_numrows($result_tiene);
			   for ($s=0;$s<$num_tiene; ++$s){
				   $row_tiene=pg_fetch_array($result_tiene);
				   if (!in_array($row_tiene[cod_subsector],$cod_subsector)){
					   $ramo_id[]=$row_tiene[id_ramo];
					   $ramo_nombre[]=$row_tiene[nombre];
					   $ramo_modo_eval[]=$row_tiene[modo_eval];
					   $cod_subsector[]=$row_tiene[cod_subsector];
					   $cod_subsector_new[]=$row_tiene[id_orden];
					   $ramo_subobli[]=$row_tiene[sub_obli];
				   }
			   }						
		   }
				
		 $query_mat2="select * from concentracion_notas where rut_alumno='$rut_alumno'";
         $result_mat2=pg_exec($conn,$query_mat2);
         $num_mat2=pg_numrows($result_mat2);
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
		
		
		 if ($institucion=="770"){ 
			   // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br><br><br><br>";
		 }	
		
		 ?>
		 			
		
		<table   align="center">
<? if($institucion!=770){ ?>
		<tr>
			<td valign="top" align="center" colspan="7">
<table  border="0" align="center" cellpadding="0" cellspacing="0" >
	  <tr>
      
	  

		<td  rowspan="5" align="left" valign="top">		
			<div align="center">
				<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>REP&Uacute;BLICA DE CHILE</strong></font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> MINISTERIO DE EDUCACI&Oacute;N</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> DIVISI&Oacute;N DE EDUCACI&Oacute;N </font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">SECRETAR&Iacute;A REGIONAL MINISTERIAL</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">DE EDUCACI&Oacute;N </font><BR>
	      </div></td>
 			
		<td style="width:100px" ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">REGIÓN</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>: <? echo $region?></strong></font></td>
		
		</tr>
	  <tr>
		<td><span class="medida"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROVINCIA</font><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
		  <?
		if ($institucion==12838){
		echo "CALAMA";
		}else{
		echo $provincia;
		}
		?></strong></font></span></td>
		</tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">COMUNA</font><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <? echo $comuna?></strong></font></td>
		</tr>
		<? 	$sql_ano = "select id_ano, nro_ano from ano_escolar where id_ano = ".$ano;
			$result_ano =@pg_Exec($conn,$sql_ano);
			$fila_ano = @pg_fetch_array($result_ano,0);	
			$nro_anooo = $fila_ano['nro_ano'];?>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">A&Ntilde;O ESCOLAR</font><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>&nbsp;&nbsp;&nbsp;&nbsp;: <? echo $nro_anooo?></strong></font></td>
		</tr>	 
	</table>		
		
			</td>
		</tr>
<? } ?>		
		<tr>
        <td valign="top" align="center" colspan="7">
		  <table width="100%" align="center">
			<tr> <td colspan="2"  align="center" class="textosimple"><h4><b>CERTIFICADO DE CONCENTRACI&Oacute;N DE NOTAS</b>
             <?
			 	if($institucion==9827 or $institucion==279 and $id_ensenanza[0]==310){
				
				echo "<BR>"."DE ".$nombre_tipo_ense['nombre_tipo']."<BR>";
				}
			
			
			
            	if($institucion==9827 or $institucion==279 and $id_ensenanza[0]==510){
			// "<>"."DE ".$ensenanza1."<BR>";
			echo "<BR>"."DE ".$nombre_tipo."<BR>";
			echo "SECTOR ECONOMICO ".$nombre_sector_eco ."- ESPECIALIDAD ".$nombre_especialidad;
			echo $nombre_especialidad;
			
					
					
					
				}
			
			?>
            
			<? if($institucion==1756){
				echo "<br>"; 
				echo "Colegio Claudio Matte";
				}
            	/*if(($institucion==9827 || $institucion==279) and $id_ensenanza[0]==310){
				
				echo "<BR>"."DE ".$nombre_tipo_ense['nombre_tipo']."<BR>";
				}
			
			
			
            	if($institucion==9827 and $id_ensenanza[0]==510){
			// "<>"."DE ".$ensenanza1."<BR>";
			echo "<BR>"."DE ".$nombre_tipo."<BR>";
			echo "SECTOR ECONOMICO ".$nombre_sector_eco ."- ESPECIALIDAD ".$nombre_especialidad;
			//echo $nombre_especialidad;
			
					
					
					
				}
			
			
			?>
			<? if($institucion==1756 || $institucion==9276){
					echo "<br>"; 
					echo $ins_pal;
			   }*/
			?>
			</h4>
			</td>
			</tr>
			<tr>
			  <td class="textosimple" align="center" colspan="2"> RECONOCIDO OFICIALMENTE POR EL MINISTERIO DE EDUCACI&Oacute;N DE LA REP&Uacute;BLICA DE CHILE<br />
			SEG&Uacute;N RESOLUCI&Oacute;N Nº			
			<?
			if ($_INSTIT==25182){  
				echo "150 DE 2007, MODIFICADA POR Nº 4142 DE 2009";			
			}elseif($_INSTIT==9940){
				echo " 03016 DE 1977 ";
			}else{ 			
			      echo $resolucion;?> DEL <? echo strtoupper($fecha_convertida);?>
		 <? } ?>			 
			 &nbsp;ROL DE BASE DE DATOS Nº<b> <? echo $row_ano['rdb'];?>-<? echo $row_ano['dig_rdb'];?></b><BR />
			OTORGA EL PRESENTE CERTIFICADO DE CONCENTRACI&Oacute;N DE CALIFICACIONES A <BR />
			DON(A) &nbsp;<b><? echo $ob_reporte->tildeM(strtoupper($row_alumno['ape_pat']));?>&nbsp;<? echo $ob_reporte->tildeM(strtoupper($row_alumno['ape_mat']));?>&nbsp;
			<? echo $ob_reporte->tildeM(strtoupper($row_alumno['nombre_alu']));?></b> RUN <b><? echo $row_alumno['rut_alumno'];?>- <? echo $row_alumno['dig_rut'];
			echo "</b>";
			if($institucion==10232){
				if($ensenanza1>310){
				echo ", ESPECIALIDAD DE ".$especialidad;
			}
			}
			?>
		
				</b></td>
			</tr>
            <tr><td colspan="2">&nbsp; </td>
		</table>
		</td></tr>
		<tr><td>
		<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td  rowspan="2" valign="top" nowrap="nowrap" class="textosimple">
			  <table width="100%" border="1" cellpadding="2" cellspacing="0">
                <tr>
                  <td rowspan="2">SUBSECTOR ASIGNATURA Y MODULO</td>
                  <td colspan="4">CURSO DE ENSE&Ntilde;ANZA MEDIA</td>
                </tr>
                <tr>
                  <td width="40" align="center">1</td>
                  <td width="40" align="center">2</td>
                  <td width="40" align="center">3</td>
                  <td width="40" align="center">4</td>
                </tr>
				<?
				$sql_sub = "select orden_concentracion_notas.cod_subsector, orden_concentracion_notas.orden, subsector.nombre from orden_concentracion_notas inner join subsector on subsector.cod_subsector=orden_concentracion_notas.cod_subsector where id_curso = '$curso' order by orden";
			    $res_sub = pg_Exec($conn, $sql_sub);
			    $num_sub = pg_numrows($res_sub);
					
				
				for ($i=0; $i < $num_sub; $i++){
					$fil_sub = pg_fetch_array($res_sub, $i);
					$nombre_subsector = $fil_sub['nombre'];
					$cod_subsector    = $fil_sub['cod_subsector'];
					$orden            = $fil_sub['orden'];
					
					
					////////////////////////////////////////////////////////////
					//////////// codigo para ver si hago linea o no   //////////
					////////////////////////////////////////////////////////////
					  $promedio_sub=0;
					  
					  $promedio_sub_aux1=0;
					  $promedio_sub_aux2=0;
					  $promedio_sub_aux3=0;
					  $promedio_sub_aux4=0;
					 
					
					
					  $sql_sub_curso = "select * from concentracion_detalle where rut_alumno = '$rut_alumno' and curso = '1' and subsector = '$cod_subsector'";
												
					  $res_sub_curso = @pg_Exec($conn,$sql_sub_curso);
					  $num_sub_curso = @pg_numrows($res_sub_curso);
					  if ($num_sub_curso>0){
						  /// existe, fue ingresado manualmente. Tomamos el promedio
						  $fil_sub_curso = @pg_fetch_array($res_sub_curso,0);
						  $promedio_sub = $fil_sub_curso['promedio'];
						  $subsector_sub = $fil_sub_curso['subsector'];
						  if ($subsector_sub=="13" or $subsector_sub==9863){
							     $promedio_sub = $fil_sub_curso['religion'];
						  }
					  }else{
						    // no existe el promedio se debe sacar de la tabla promedio_subsector
						  $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from promocion where id_ano = '$ano_1' and rut_alumno = '$rut_alumno' and situacion_final='1' )  and grado_curso=1) and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							//if($_PERFIL==0) echo "<br>".$sql_prom_sub;
							 						 
							$res_prom_sub = @pg_Exec($conn,$sql_prom_sub);
							$num_prom_sub = @pg_numrows($res_prom_sub);
							if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
								 
							}else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '1')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0' and id_ano not in (select id_ano from ano_escolar where id_institucion = '".$_INSTIT."')";
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
					   }
					   
					   $promedio_sub_aux1 = $promedio_sub;
					
					   /////////
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
							 if ($subsector_sub==13 or $subsector_sub==729){
							     $promedio_sub = $fil_sub_curso['religion'];
							 }
						}else{
						     // no existe el promedio se debe sacar de la tabla promedio_subsector
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from promocion where id_ano = '$ano_2' and rut_alumno = '$rut_alumno' and situacion_final='1' ) and grado_curso=2) and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							 $res_prom_sub = @pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = @pg_numrows($res_prom_sub);
							 					 
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '2')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0' and id_ano not in (select id_ano from ano_escolar where id_institucion = '".$_INSTIT."')";
								  
								  								  
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
						}
					    
						$promedio_sub_aux2 = $promedio_sub;
						
						///////////////
						
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
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from promocion where id_ano = '$ano_3' and rut_alumno = '$rut_alumno' and situacion_final='1' ) ) and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							 
							 $res_prom_sub = pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = pg_numrows($res_prom_sub);
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
								 
								 
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								 $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '3')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0' and id_ano not in (select id_ano from ano_escolar where id_institucion = '".$_INSTIT."')";
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
						}
						
						$promedio_sub_aux3 = $promedio_sub;
						
						
						
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
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from promocion where id_ano = '$ano_4' and rut_alumno = '$rut_alumno' and situacion_final='1' ) ) and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							 
							 $res_prom_sub = pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = pg_numrows($res_prom_sub);
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
								 
								
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '4')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0' and id_ano not in (select id_ano from ano_escolar where id_institucion = '".$_INSTIT."')";
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
						}
					
					    $promedio_sub_aux4 = $promedio_sub;
						
						
						//////////////******************** LINEA QUE SE DEBE ELIMINAR AL MOMENTO DEL PROCESO DE CIERRE 2012************************/////////////
						/*if($institucion==4655){
							$promedio_sub_aux4=1;	
						}*/
			  if ($promedio_sub_aux1>0 or $promedio_sub_aux2>0 or $promedio_sub_aux3>0 or $promedio_sub_aux4>0 or $promedio_sub_aux1!=NULL or $promedio_sub_aux2!=NULL or $promedio_sub_aux3!=NULL or $promedio_sub_aux4!=NULL){ 		
						
						
					?>			
				
					<tr>
					  <td height="27"><?=$nombre_subsector?></td>
					  <td width="30">&nbsp;
					  <?
					  $promedio_sub=0;
					  
					  $sql_sub_curso = "select * from concentracion_detalle where rut_alumno = '$rut_alumno' and curso = '1' and subsector = '$cod_subsector'";
												
					  $res_sub_curso = @pg_Exec($conn,$sql_sub_curso);
					  $num_sub_curso = @pg_numrows($res_sub_curso);
					  if ($num_sub_curso>0){
						  /// existe, fue ingresado manualmente. Tomamos el promedio
						  $fil_sub_curso = @pg_fetch_array($res_sub_curso,0);
						  $promedio_sub = $fil_sub_curso['promedio'];
						  $subsector_sub = $fil_sub_curso['subsector'];
						  if ($subsector_sub=="13" or $subsector_sub==9863){
							     $promedio_sub = $fil_sub_curso['religion'];
						  }
					  }else{
						    // no existe el promedio se debe sacar de la tabla promedio_subsector
						    $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from promocion where id_ano = '$ano_1' and rut_alumno = '$rut_alumno' and situacion_final='1' ) and grado_curso=1) and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							 						 
							$res_prom_sub = @pg_Exec($conn,$sql_prom_sub);
							$num_prom_sub = @pg_numrows($res_prom_sub);
							if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
								 
							}else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								 // $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '1')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0' and id_ano not in (select id_ano from ano_escolar where id_institucion = '".$_INSTIT."')";
								  
								    $sql_curso_1 = "select * from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from promocion where id_curso in ((select id_curso from curso where ensenanza > 300 and grado_curso = '1')) and situacion_final=1 and rut_alumno = '$rut_alumno')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0' and id_ano not in (select id_ano from ano_escolar where id_institucion = '".$_INSTIT."')";
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
					   }
					   
					  if($institucion==12829){
						   if($promedio_sub!=""){					   
							   echo $promedio_sub;
						   }else{
							   echo "-";
						   }
					   }else{
						   echo $promedio_sub;
					   }
					   
					   if ($promedio_sub>0 and $promedio_sub!=NULL){
						  
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}
					   						
					   ?>					  </td>
					  <td width="30">&nbsp;
					  
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
							 if ($subsector_sub==13 or $subsector_sub==729){
							     $promedio_sub = $fil_sub_curso['religion'];
							 }
						}else{
						     // no existe el promedio se debe sacar de la tabla promedio_subsector
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from promocion where id_ano = '$ano_2' and rut_alumno = '$rut_alumno' and situacion_final='1' ) and grado_curso=2) and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							 $res_prom_sub = @pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = @pg_numrows($res_prom_sub);
							 	//if($_PERFIL==0) echo $sql_prom_sub;
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '2')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0' and id_ano not in (select id_ano from ano_escolar where id_institucion = '".$_INSTIT."')";
								  
								  								  
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
						}
						
					  if($institucion==12829){
						   if($promedio_sub!=""){					   
							   echo $promedio_sub;
						   }else{
							   echo "-";
						   }
					   }else{
						   echo $promedio_sub;
					   }
						
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}
						
						 
						?>					  </td>
					  <td width="30">&nbsp;
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
							$sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from promocion where id_ano = '$ano_3' and rut_alumno = '$rut_alumno' and situacion_final='1' ) and grado_curso=3) and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							
							 $res_prom_sub = pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = pg_numrows($res_prom_sub);
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
								 
								 
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								 $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '3')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0' and id_ano not in (select id_ano from ano_escolar where id_institucion = '".$_INSTIT."') and (select id_ano from promocion where id_ano = '$ano_3' and rut_alumno = '$rut_alumno' and situacion_final='1')";
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
								 // if($_PERFIL==0) echo "<br>".$sql_curso_1;								 
							 }
						}
						
   					   if($institucion==12829){
						   if($promedio_sub!=""){					   
							   echo $promedio_sub;
						   }else{
							   echo "-";
						   }
					   }else{
						   echo $promedio_sub;
					   }
						 
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}
						?>					  </td>
					  <td width="30">&nbsp;
					  
					  <?
						/// limpio promedio_sub
						$promedio_sub="";
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
						     $sql_consulta_prom = "select * from promocion where id_ano = '$ano_4'";
							 $res_consulta_prom = @pg_Exec($conn, $sql_consulta_prom);
							 $num_consulta_prom = @pg_numrows($res_consulta_prom);
							 
							 if ($num_consulta_prom>0){						
						
								 // no existe el promedio se debe sacar de la tabla promedio_subsector
								 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from promocion where id_ano = '$ano_4' and rut_alumno = '$rut_alumno' and situacion_final='1' ) and grado_curso=4) and cod_subsector='$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0'";
								 
								 
								 
								 
								 $res_prom_sub = pg_Exec($conn,$sql_prom_sub);
								 $num_prom_sub = pg_numrows($res_prom_sub);
								 if ($num_prom_sub>0){
									 // existe, esta hecha la promocion
									 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
									 $promedio_sub = $fil_prom_sub['promedio'];
									 
									
								 }else{							 
									  /// es posible que esté en otro establecimiento dentro del sistema
									  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
									  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '4')) and cod_subsector = '$cod_subsector') and rut_alumno = '$rut_alumno' and promedio <> '0' and id_ano not in (select id_ano from ano_escolar where id_institucion = '".$_INSTIT."')";
									  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
									  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
									  $promedio_sub = $fil_curso_1['promedio'];							 						  
								 }
							 }
						}
						
						if($institucion==12829){
						   if($promedio_sub!=""){					   
							   echo $promedio_sub;
						   }else{
							   echo "-";
						   }
					   }else{
						   echo $promedio_sub;
					   }
						
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}
						?>					  </td>
					</tr>
					<?
					}
				}
				?>			
				
                <tr>
                  
				  
				  <td height="27">PROMEDIO GENERAL</td>
                  <td align="center"><? 
		
		    $query_promocion="select * from promocion where id_ano='$ano_1' and rut_alumno='$rut_alumno' and id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and id_ano = '$ano_1' and bool_ar <> '1') and situacion_final='1'";
			$result_promocion=pg_exec($conn,$query_promocion);
			$num_promocion=pg_numrows($result_promocion);
			$row_promocion=pg_fetch_array($result_promocion);
			if (!$row_promocion[promedio]){	
				$promedio="&nbsp;";
				
				// consultamos si el promedio se ingresó manualmente
				$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=1";
				$result_general=pg_exec($conn,$query_general);
				$num_general=pg_numrows($result_general);
				if ($num_general>0){
					$row_general=pg_fetch_array($result_general);
					$promedio=$row_general[promedio];
				}else{				    
					/// buscar el promedio en un curso de otro establecimiento
					$otro = "select * from promocion where id_curso in (select id_curso from curso where id_curso in (select id_curso from promocion where rut_alumno = '$rut_alumno' and rdb <> '$_INSTIT' and situacion_final = '1') and ensenanza > '300' and grado_curso = '1') and rut_alumno = '$rut_alumno'";
					$res_otro=pg_exec($conn,$otro);
					$num_otro=pg_numrows($res_otro);
					$row_otro=pg_fetch_array($res_otro);
					if (!$row_otro[promedio]){
					    $promedio="&nbsp;";
					}else{
					    $promedio=$row_otro[promedio];
					
					}				
				}
				
			}else{
				$promedio=$row_promocion[promedio];
			}	
			
			
			
			if (!$promedio){ $promedio="&nbsp;";}
						
			echo $promedio;
			$promedio=NULL;
			?>    </td>
                  <td align="center">
				  <? 
					
		    $query_promocion="select * from promocion where id_ano='$ano_2' and rut_alumno='$rut_alumno' and id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and id_ano = '$ano_2' and bool_ar <> '1') and situacion_final = '1'";
			$result_promocion=pg_exec($conn,$query_promocion);
			$num_promocion=pg_numrows($result_promocion);
			$row_promocion=pg_fetch_array($result_promocion);
			if (!$row_promocion[promedio]){	
				$promedio="&nbsp;";
				
				// consultamos si el promedio se ingresó manualmente
				$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=2";
				$result_general=pg_exec($conn,$query_general);
				$num_general=pg_numrows($result_general);
				if ($num_general>0){
					$row_general=pg_fetch_array($result_general);
					$promedio=$row_general[promedio];
				}else{				    
					/// buscar el promedio en un curso de otro establecimiento
					$otro = "select * from promocion where id_curso in (select id_curso from curso where id_curso in (select id_curso from promocion where rut_alumno = '$rut_alumno' and rdb <> '$_INSTIT' and situacion_final = '1') and ensenanza > '300' and grado_curso = '2') and rut_alumno = '$rut_alumno'";
					$res_otro=pg_exec($conn,$otro);
					$num_otro=pg_numrows($res_otro);
					$row_otro=pg_fetch_array($res_otro);
					if (!$row_otro[promedio]){
					    $promedio="&nbsp;";
					}else{
					    $promedio=$row_otro[promedio];
					
					}				
				}
				
				
			}else{
				$promedio=$row_promocion[promedio];
			}
				
			
			
			
			if (!$promedio){ $promedio="&nbsp;";}
						
			echo $promedio;
			$promedio=NULL;
			?> 
				  </td>
                  <td align="center">
				  <? 
	
		    $query_promocion="select * from promocion where id_ano='$ano_3' and rut_alumno='$rut_alumno' and id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and id_ano = '$ano_3' and bool_ar <> '1') and situacion_final = '1'";
			
			
			$result_promocion=pg_exec($conn,$query_promocion);
			$num_promocion=pg_numrows($result_promocion);
			$row_promocion=pg_fetch_array($result_promocion);
			if (!$row_promocion[promedio]){	
				$promedio="&nbsp;";
				
				// consultamos si el promedio se ingresó manualmente
				$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=3";
				$result_general=pg_exec($conn,$query_general);
				$num_general=pg_numrows($result_general);
				if ($num_general>0){
					$row_general=pg_fetch_array($result_general);
					$promedio=$row_general[promedio];
				}else{				    
					/// buscar el promedio en un curso de otro establecimiento
					$otro = "select * from promocion where id_curso in (select id_curso from curso where id_curso in (select id_curso from promocion where rut_alumno = '$rut_alumno' and rdb <> '$_INSTIT' and situacion_final = '1') and ensenanza > '300' and grado_curso = '3') and rut_alumno = '$rut_alumno'";
					$res_otro=pg_exec($conn,$otro);
					$num_otro=pg_numrows($res_otro);
					$row_otro=pg_fetch_array($res_otro);
					if (!$row_otro[promedio]){
					    $promedio="&nbsp;";
					}else{
					    $promedio=$row_otro[promedio];
					
					}				
				}
				
			}else{
				$promedio=$row_promocion[promedio];
			}
				
			
			
			
			if (!$promedio){ $promedio="&nbsp;";}
						
			echo $promedio;
			$promedio=NULL;
			?> 
				  </td>
                  <td align="center">
				  <? 
				
		   $query_promocion="select * from promocion where id_ano='$ano_4' and rut_alumno='$rut_alumno' and id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and id_ano = '$ano_4' and bool_ar <> '1') and situacion_final = '1'";
			$result_promocion=pg_exec($conn,$query_promocion);
			$num_promocion=pg_numrows($result_promocion);
			$row_promocion=pg_fetch_array($result_promocion);
			if (!$row_promocion[promedio]){	
				$promedio="&nbsp;";
				
				// consultamos si el promedio se ingresó manualmente
				$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=4";
				$result_general=pg_exec($conn,$query_general);
				$num_general=pg_numrows($result_general);
				if ($num_general>0){
					$row_general=pg_fetch_array($result_general);
					$promedio=$row_general[promedio];
				}else{				    
					/// buscar el promedio en un curso de otro establecimiento
					$otro = "select * from promocion where id_curso in (select id_curso from curso where id_curso in (select id_curso from promocion where rut_alumno = '$rut_alumno' and rdb <> '$_INSTIT' and situacion_final = '1') and ensenanza > '300' and grado_curso = '4') and rut_alumno = '$rut_alumno'";
					$res_otro=pg_exec($conn,$otro);
					$num_otro=pg_numrows($res_otro);
					$row_otro=pg_fetch_array($res_otro);
					if (!$row_otro[promedio]){
					    $promedio="&nbsp;";
					}else{
					    $promedio=$row_otro[promedio];
					
					}				
				}
				
			}else{
				$promedio=$row_promocion[promedio];
			}
				
			
			
			
			if (!$promedio){ $promedio="&nbsp;";}
						
			echo $promedio;
			$promedio=NULL;
			?> 
				  </td>
                </tr>
                <tr>
                  <td height="27">PROMEDIO ASISTENCIA</td>
                  <td align="center">
		    	<? 			
				$query_promocion="select * from promocion where id_ano='$ano_1' and rut_alumno='$rut_alumno' and id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and id_ano = '$ano_1' and bool_ar <> '1') and situacion_final = '1'";
				$result_promocion=pg_exec($conn,$query_promocion);
				$num_promocion=pg_numrows($result_promocion);
				$row_promocion=pg_fetch_array($result_promocion);
				$promedio=$row_promocion[asistencia];				
			
				$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=1";
				$result_general=pg_exec($conn,$query_general);
				$num_general=pg_numrows($result_general);
				if ($num_general>0){
					$row_general=pg_fetch_array($result_general);
					$promedio=trim($row_general[asistencia]);
				}
				
				if (!$promedio){
				
				        /// puede que el porcentaje de asistencia este en otro colegio
					    /// buscar el promedio en un curso de otro establecimiento
						$otro = "select * from promocion where id_curso in (select id_curso from curso where id_curso in (select id_curso from promocion where rut_alumno = '$rut_alumno' and rdb <> '$_INSTIT' and situacion_final = '1') and ensenanza > '300' and grado_curso = '1') and rut_alumno = '$rut_alumno'";
						$res_otro=pg_exec($conn,$otro);
						$num_otro=pg_numrows($res_otro);
						$row_otro=pg_fetch_array($res_otro);
						if ($row_otro>0){
							$promedio=$row_otro[asistencia];
							$promedio=$promedio."%";
						}				
				        
						if (!$promedio){
						
							if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
							   $promedio = "-";
							}else{
							   $promedio = "&nbsp;";
							}
						}	
						
						
				}else{
					  $promedio=$promedio."%";
				}
				echo $promedio;
				$promedio=NULL;
					?>  
				  </td>
                  <td align="center">
				  <? 			
				$query_promocion="select * from promocion where id_ano='$ano_2' and rut_alumno='$rut_alumno' and id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and id_ano = '$ano_2' and bool_ar <> '1') and situacion_final = '1'";
				$result_promocion=pg_exec($conn,$query_promocion);
				$num_promocion=pg_numrows($result_promocion);
				$row_promocion=pg_fetch_array($result_promocion);
				$promedio=$row_promocion[asistencia];				
			
				$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=2";
				$result_general=pg_exec($conn,$query_general);
				$num_general=pg_numrows($result_general);
				if ($num_general>0){
					$row_general=pg_fetch_array($result_general);
					$promedio=trim($row_general[asistencia]);
				}
				
				if (!$promedio){
					    /// puede que el porcentaje de asistencia este en otro colegio
					    /// buscar el promedio en un curso de otro establecimiento
						$otro = "select * from promocion where id_curso in (select id_curso from curso where id_curso in (select id_curso from promocion where rut_alumno = '$rut_alumno' and rdb <> '$_INSTIT' and situacion_final = '1') and ensenanza > '300' and grado_curso = '2') and rut_alumno = '$rut_alumno'";
						$res_otro=pg_exec($conn,$otro);
						$num_otro=pg_numrows($res_otro);
						$row_otro=pg_fetch_array($res_otro);
						if ($row_otro>0){
							$promedio=$row_otro[asistencia];
							$promedio=$promedio."%";
						}				
				        
						if (!$promedio){
						
							if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
							   $promedio = "-";
							}else{
							   $promedio = "&nbsp;";
							}
						}	
				}else{
					  $promedio=$promedio."%";
				}
				echo $promedio;
				$promedio=NULL;
					?>  
				  
				  </td>
                  <td align="center">
				  <? 			
				$query_promocion="select * from promocion where id_ano='$ano_3' and rut_alumno='$rut_alumno' and id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and id_ano = '$ano_3' and bool_ar <> '1') and situacion_final = '1'";
				$result_promocion=pg_exec($conn,$query_promocion);
				$num_promocion=pg_numrows($result_promocion);
				$row_promocion=pg_fetch_array($result_promocion);
				$promedio=$row_promocion[asistencia];				
			
				$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=3";
				$result_general=pg_exec($conn,$query_general);
				$num_general=pg_numrows($result_general);
				if ($num_general>0){
					$row_general=pg_fetch_array($result_general);
					$promedio=trim($row_general[asistencia]);
				}
				
				if (!$promedio){
					    /// puede que el porcentaje de asistencia este en otro colegio
					    /// buscar el promedio en un curso de otro establecimiento
						$otro = "select * from promocion where id_curso in (select id_curso from curso where id_curso in (select id_curso from promocion where rut_alumno = '$rut_alumno' and rdb <> '$_INSTIT' and situacion_final = '1') and ensenanza > '300' and grado_curso = '3') and rut_alumno = '$rut_alumno'";
						$res_otro=pg_exec($conn,$otro);
						$num_otro=pg_numrows($res_otro);
						$row_otro=pg_fetch_array($res_otro);
						if ($row_otro>0){
							$promedio=$row_otro[asistencia];
							$promedio=$promedio."%";
						}				
				        
						if (!$promedio){
						
							if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
							   $promedio = "-";
							}else{
							   $promedio = "&nbsp;";
							}
						}	
						
				}else{
					  $promedio=$promedio."%";
				}
				echo $promedio;
				$promedio=NULL;
					?>  
				  
				  </td>
                  <td align="center">
				  <? 			
				$query_promocion="select * from promocion where id_ano='$ano_4' and rut_alumno='$rut_alumno' and id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and id_ano = '$ano_4' and bool_ar <> '1') and situacion_final = '1'";
				$result_promocion=pg_exec($conn,$query_promocion);
				$num_promocion=pg_numrows($result_promocion);
				$row_promocion=pg_fetch_array($result_promocion);
				$promedio=$row_promocion[asistencia];				
			
				$query_general="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso=4";
				$result_general=pg_exec($conn,$query_general);
				$num_general=pg_numrows($result_general);
				if ($num_general>0){
					$row_general=pg_fetch_array($result_general);
					$promedio=trim($row_general[asistencia]);
				}
				
				if (!$promedio){
					    /// puede que el porcentaje de asistencia este en otro colegio
					    /// buscar el promedio en un curso de otro establecimiento
						$otro = "select * from promocion where id_curso in (select id_curso from curso where id_curso in (select id_curso from promocion where rut_alumno = '$rut_alumno' and rdb <> '$_INSTIT' and situacion_final = '1') and ensenanza > '300' and grado_curso = '4') and rut_alumno = '$rut_alumno'";
						$res_otro=pg_exec($conn,$otro);
						$num_otro=pg_numrows($res_otro);
						$row_otro=pg_fetch_array($res_otro);
						if ($row_otro>0){
							$promedio=$row_otro[asistencia];
							$promedio=$promedio."%";
						}				
				        
						if (!$promedio){
						
							if ($_INSTIT=='12829' OR $_INSTIT=='2278'){
							   $promedio = "-";
							}else{
							   $promedio = "&nbsp;";
							}
						}	
				}else{
					  $promedio=$promedio."%";
				}
				echo $promedio;
				$promedio=NULL;
					?>  
				  </td>
				  
				  
                </tr>
              </table></td>
			<td width="35%" align="center" nowrap="nowrap" class="textosimple" valign="top">
            <table>
            <tr>
            <td style="border:1px black solid"  >AÑO ESCOLAR Y ESTABLECIMIENTO<br> 
			  EDUCACIONAL</td></tr>
            <tr>
              <td>
              <table width="100%" class="textosimple">
					 <? 
				
				
					  for($j=1;$j<=4; ++$j){?>
					     <tr>
					       <td><b>
					     <?
					 	 $nombre_plan="";
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
							  $letra_curso = strtoupper($fil_2['letra_curso']);  // SE MUESTRA EN PANTALLA LA LETRA DEL CURSO
							  
							  /// rescato el año academico
							  $sql_3 = "select * from ano_escolar where id_ano = '$id_ano_temp'";
							  $res_3 = @pg_Exec($conn,$sql_3);
							  $fil_3 = @pg_fetch_array($res_3);
							  							  
							  $year  = $fil_3['nro_ano'];
							  
							  							  
							  $institucion_temp = $fil_3['id_institucion'];
							  
								  $sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, 
								  provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
							  $sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN 
							  provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna 
							  ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = 
							  comuna.cor_com) ";
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
							  
							  $query_primer="select * from plan_estudio where cod_decreto in (select cod_decreto from curso where id_curso = 
							  '$id_curso_temp')";
						     
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
						
						 }else{  // se ha ingresado la institución a "mano"
						 				     						
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
								  $letra_curso     = $row_gene['letra'];
							
						          $query_primer="select eva.*,plan.* 
										from curso,plan_estudio as plan ,evaluacion as eva
										where curso.id_ano='$row_ano[id_ano]'  and curso.grado_curso=$j and  curso.ensenanza>=310 and 
										plan.cod_decreto=curso.cod_decreto
										and eva.cod_eval=curso.cod_eval";
															
						          $result_primer=	@pg_exec($conn,$query_primer);
						          $num_primer=@pg_numrows($result_primer);
						          
								  //$letra_curso = strtoupper($query_primer['letra_curso']); // SE MUESTRA EN PANTALLA LA LETRA DEL CURSO
								  
								  
								  if ($num_primer>0){
							          $row_primer=pg_fetch_array($result_primer);	
							          $nombre_plan=$row_primer[nombre_decreto];
							          $nombre_eva=$row_primer[nombre_decreto_eval];
							          $arreglo_temp=explode(" ",trim($nombre_plan));
		            	              $ano_temp=$nro_ano[$j];
						          }						
						      
							     
								
								  								   
			                  }else{  // no existe en concetracion
							  
							       
							  }				  
							  
							     
				   
				            
					      }	/// fin IF
						  
						  
						      if ($j==1){ echo "PRIMER";}
							  if ($j==2){ echo "SEGUNDO";}
							  if ($j==3){ echo "TERCER";}
							  if ($j==4){ echo "CUARTO";}
					   
					   
					          ////////  DESPLIEGO LA INFORMACION DE LA TABLA  //////////
						  
						     ?>&nbsp;AÑO-<?=strtoupper($letra_curso); ?></b></td>
					          <? 
							  	if($j==1 &&  $rut_alumno=='21149044' && $institucion=='25269'){?>
									 <td class="textosimple"><b>2011</b><br />
						                Año Escolar </td>
                             <?	}elseif($j==1 &&  $rut_alumno=='18503598'  && $institucion=='304'){?>
							 <td class="textosimple"><b>2010</b><br />
						                Año Escolar </td>
							<?	}elseif($j==2 &&  $rut_alumno=='18503598'  && $institucion=='304'){?>
							 <td class="textosimple"><b>2010</b><br />
						                Año Escolar </td>
										<?	}elseif($j==3 &&  $rut_alumno=='18311135'  && $institucion=='304'){?>
							 <td class="textosimple"><b>2011</b><br />
						                Año Escolar </td>
							<?	}else{
							  if($year==""){ ?>
						              <td class="textosimple"><b><? echo $ano_temp;?></b><br />
						                Año Escolar </td>
						      <? }else{ ?>
	<td class="textosimple"><b><? if ($j==4){  echo "".$nro_anooo; }else{  echo "".$year;  }?></b><br />
						                   Año Escolar  </td>
					          <? } 
								}?>
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
							        <td colspan="2">ESTABLECIMIENTO:<b><? echo $establecimiento;?></b></td>
							      </tr>
						          <tr class="textosimple">
							        <td colspan="2">PROVINCIA:<b>
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
								   ?>
								   
								   
								   </b>&nbsp;&nbsp;COMUNA: <b>
								   <? 
								   if($establecimiento=="COLEGIO AMALIA ERRÁZURIZ")
								       echo Ovalle;
								   else
								       echo $comuna_real; 
								   ?> 
								  </b></td>
							      </tr>
							  <? if($j==1 and $rut_alumno==18392077){ ?>
							   <tr>
								    <td colspan="2" nowrap="nowrap">RECONOCIMIENTO DE ESTUDIOS <B>Nº05/2413 DE SEPTIEMBRE 2008</B></td>
							   </tr>
								  <? }elseif(($j==1 || $j==2) and $rut_alumno==17812691){?>
                              <tr>
								    <td colspan="2" nowrap="nowrap">RECONOCIMIENTO DE ESTUDIOS POR <BR><B>RESOLUCIÓN EXENTA Nº 1336, de 1983</B></td>
							   </tr>
                               <? }elseif(($j==1) and ($rut_alumno==18164192 || $rut_alumno==18463820 || $rut_alumno==22603870)){?>
                              <tr>
								    <td colspan="2" nowrap="nowrap">RECONOCIMIENTO DE ESTUDIOS POR <BR><B>RESOLUCIÓN EXENTA Nº 1336, de 1983</B></td>
							   </tr>
							  <? }else{?>
							  
								  <tr>
								    <td colspan="2" nowrap="nowrap">PLAN Y PROGRAMA DE ESTUDIO DECRETO EXENTO O RESOLUCI&Oacute;N</td>
								  </tr>
								  <tr class="textosimple">
								  <? if($plan==""){  ?>
										<td colspan="2">EXENTA DE EDUCACI&Oacute;N N&ordm; <b><? echo $nombre_plan;?></b></td>
								        <? }else{ ?>
										<td colspan="2">EXENTA DE EDUCACI&Oacute;N N&ordm;<b><? echo $plan;?></b></td>
								        <? } ?>
								  </tr>
								  <tr class="textosimple">
									 <td colspan="2">REGLAMENTO DE EVALUACI&Oacute;N Y PROMOCI&Oacute;N ESCOLAR DECRETO</td>
								  </tr>
								  <? if($decreto==""){ ?>
										   <tr class="textosimple">
										     <td colspan="2">EXENTA DE EDUCACI&Oacute;N N&ordm;&nbsp;<b><? echo $nombre_eva;?> </b></td>
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
			      <tr class="textosimple">
										      <td colspan="2">EXENTO DE EDUCACI&Oacute;N N&ordm;&nbsp;<b><? echo $decreto;?> </b></td>
								              <? } ?>
				  </tr><td colspan="2"><? 
												if($j==2 && $rut_alumno==19468514){
														echo "AUTORIZADO POR PROVIDENCIA N°A-377 12/10/2011<br> VALIDACIÓN DE ESTUDIOS ";
												}elseif($j==2 && $rut_alumno==19396601){
													echo "Autorizado por Providencia N°A-377 12/10/2011 <br> Validación de estudios ";
												}elseif($j==2 && $rut_alumno==18970954){
													echo "AUTORIZADO POR PROVIDENCIA NºA-377 FECHA: 12/10/2011 <br>VALIDACIÓN DE ESTUDIOS ";
												}?>
														
										</td>
							      <? }
							   }	  					  
						       
						     //////////////////////////////////////////////////////////
							 $establecimiento=NULL;
							 $year=NULL;
							 $ano_temp=NULL;
					  				   
					  }  ?>		
				  </table>
              
              </td>
            </tr>
            </table>
            </td>
		  
		  
				
		
		
		</table>
		</td>
		</tr>
		<? $fecha = date("d-m-Y");
			$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
			$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$cmb_curso.")); ";
			$result =@pg_Exec($conn,$sql4);
			$filaprofe = pg_fetch_array($result);			
			$profe_jefe =    trim($filaprofe['nombre_emp'])." ".trim($filaprofe['ape_pat'])." ".trim($filaprofe['ape_mat']);
			$profesor_jefe = trim($filaprofe['nombre_emp'])." ".trim($filaprofe['ape_pat'])." ".trim($filaprofe['ape_mat']);
		//----------------------------------
			$sql_dir = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
			$sql_dir = $sql_dir . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
			$sql_dir = $sql_dir . "WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23) ";
			$result =@pg_Exec($conn,$sql_dir);
			$filadire = pg_fetch_array($result);
			$director_est =	    trim($filadire['nombre_emp'])." ".trim($filadire['ape_pat'])." ".trim($filadire['ape_mat']);
			$director_estab =	trim($filadire['nombre_emp'])." ".trim($filadire['ape_pat'])." ".trim($filadire['ape_mat']);	
		?>
		<tr><td align="center" class="textosimple">
		<? if($_INSTIT!=770 and $_INSTIT!=14703 and $_INSTIT!=516 and $_INSTIT!=769){ 
		      echo $comuna; 
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
		
			?>,  <? echo ucwords(strtolower($ob_membrete->comuna))."". $dia." de ".$mes." del ".$ano2;  ?> 
			
		<?
		
		
		   //$acumulo_promedio = $acumulo_promedio + $promedio;
			//$contador_acumulado++;
			
						
			$contador_acumulado = ($contador_acumulado - $contador_religion);
			$acumulo_promedio = $acumulo_promedio/10;
					
			$ponderacion_rende = $acumulo_promedio/$contador_acumulado;
			$ponderacion_rende = substr($ponderacion_rende,0,4);
			//$ponderacion_rende = substr($acumulo_promedio/$contador_acumulado,0,2);
			
			$sql_act = "update matricula set total_notas = '$contador_acumulado', suma_pond = '$acumulo_promedio', pond_demre = '$ponderacion_rende' where rut_alumno = '$rut_alumno' and id_ano = '".$_ANO."'";
		    $res_act = @pg_Exec($conn,$sql_act);
			
		   ?>	
		  
	    	
			<?
			if ( $checkbox1 == 1 ){ 
						
			echo '<table border="1" cellspacing="0" cellpadding="0" align="left">';
			echo '<tr heigth="20">
				     <td><font style="font-size:9px">Total notas promediadas</font></td>
					 <td><font style="font-size:9px"> :'.$contador_acumulado.'</font></td>
				   </tr>
				   <tr>	 
					 <td><font style="font-size:9px">Suma Ponderación</font></td>
					 <td><font style="font-size:9px"> :'.$acumulo_promedio.'</font></td>
				    </tr>
					 <td><font style="font-size:9px">Ponderación Demre</font></td>
					 <td><font style="font-size:9px"> :'.$ponderacion_rende.'</font></td>
				   </tr>
				 </table>  	<br><br><br><br>';
				   
			
		 } 
			
 echo '<br /></td></tr>
	  <tr><td align="center">
	  <table width="100%">
	  <tr><td width="51%">';
		  
		  for($vv=0;$vv < $txtfirmas; $vv++){
				echo "<br>";
		   }
		?>
		<table width="68%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
			<tr>
			  <td align="center" width="100%"><strong><font face="Arial, Helvetica, sans-serif" size="1">__________________________<br />
			  PROFESOR(A) JEFE<br> 
			  <? if($institucion==770){
					echo $profesor_jefe;
				}else{
					echo $profe_jefe;
				}
			  ?>
			  </font></strong></td>
			</tr>
		  </table></td><td width="49%">
		   <? for($vv=0;$vv < $txtfirmas; $vv++){
				echo "<br>";
		   }
		?>
		  <table width="57%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
			<tr>
			  <td align="center" width="100%"><strong><font face="Arial, Helvetica, sans-serif" size="1">__________________________<br />
				<?=$cargo_dir2?> <br>
				<? if($institucion==770){
						echo $director_estab;
					}else{
					    if ($institucion==2278){
						     echo "ANA LORENA ALCOTA IRELAND";
						}else{
						     echo $director_est;
						}	 
					}?>
				</font></strong></td>
			</tr>
		  </table></td></tr></table> </td></tr>
		
		</table>

<? } ?>

    <?
	/// salto de página
	if (@pg_numrows($result_concentracion) >1){
	    ?>
	    <h1 class="salto"></h1>
	    <?
	}
		
	?>   
	
	
	

<? } ?>					  
			
				  
							  
							 
</body>
</html>
<?
pg_close($conn);
?>
