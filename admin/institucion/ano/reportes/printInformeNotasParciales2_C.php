<div align="center">
<?
	require('../../../../util/header.inc');
	include('../../../clases/class_Reporte.php');
	include('../../../clases/class_Membrete.php');
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
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$reporte		=$c_reporte;
	$periodo		=$cmb_periodos;
	$taller			=$opc_Taller;
	$estadistica	=$opc_estadistica;
	$obs			=$opc_obs;
	$tipo_rep		=$tipo_rep;
	$anotacion		=$opc_Anotacion;
	$colilla		=$opc_Colilla;
	echo "muestra notas ".$muestra_notas	=$Mnotas;
	
	/*$sw				=0;
	$rdb = $institucion;
	$ramo_religion = 0;
	if ($curso==0) $sw = 1;
	if ($periodo==0) $sw = 1;
	if ($sw == 1) exit;*/
    
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** A�O ESCOLAR*****************/
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
 
<!-- CODIGO DE DISE�O NUEVO -->
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
							  
<form method="post" target="mainFrame">
<center>
<div id="capa0">

	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td>
		  <table width="650">
			<tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
			<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
			</td></tr></table>
	
	</td>
	  </tr>
	</table> 

</div>

<?
	if (empty($alumno)){
	
		$ob_reporte ->curso = $curso;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->retirado =0;
		$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->curso = $curso;
		$result_alu =$ob_reporte ->TraeUnAlumno($conn);
	}	
	$cont_alumnos = @pg_numrows($result_alu);
	
	
	
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos; $cont_paginas++)
{
	$prome_general_pro = 0;
	$cont_general_pro = 0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$bool_ed = $fila_alu['bool_ed'];
	
	/******************** CON ESTADISTICA ******************************/
	$ob_reporte ->alumno = $alumno;
	$ob_reporte ->ano = $ano;
	$ob_reporte ->fecha_inicio=$fecha_ini;
	$ob_reporte ->fecha_termino = $fecha_fin;
	$result13 = $ob_reporte ->Asistencia($conn);
	if (!$result13){
		  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
	}else{
		if (pg_numrows($result13)!=0){
		  $fila13 = @pg_fetch_array($result13,0);	
		  if (!$fila13){
			  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			  exit();
		  }
		}
	}
	$cantidad = @pg_numrows($result13);
	$inasistencia = @pg_numrows($result13);
	$dias_asistidos = $dias_habiles - $cantidad;
	

	//---------------------------
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	
	
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];
	
	
			
if (($fila['ensenanza']>109 and $fila['ensenanza']<310) or ($fila['ensenanza']>300 and $fila['grado_curso']<3)){  ?>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
      <tr>
            <td width="100%">
			
			
		<? if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br><br><br><br>";
			   
		  }
		
		    ?>
		<table width="650" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <? if ($institucion!="770"){ ?>
            <td width="114" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
            <td width="9" class="item"><strong>:</strong></td>
            <td width="361" class="item"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
            <td width="161" rowspan="7" align="center" valign="top" ><?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c�digo para tomar la insignia
			
				  if($institucion!=""){
					   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>            </td>
            <? } ?>
          <tr>
            <td class="item"><div align="left"><strong>A�O ESCOLAR</strong></div></td>
            <td class="item"><strong>:</strong></td>
            <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
          </tr>
          <tr>
            <td class="item"><div align="left"><strong>CURSO</strong></div></td>
            <td class="item"><strong>:</strong></td>
            <td class="item"><div align="left"><? echo $Curso_pal; ?></div></td>
          </tr>
          <tr>
            <td class="item"><div align="left"><strong>ALUMNO</strong></div></td>
            <td class="item"><strong>:</strong></td>
            <td class="item"><div align="left">
                <? if($institucion==8930){ Nombre($fila['ape_pat'],$fila['ape_mat'],$fila['nombre_alu']);}else{echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); }?>
            </div></td>
          </tr>
          <tr>
            <td class="item"><div align="left"><strong>PROFESOR JEFE</strong></div></td>
            <td class="item"><div align="left"><strong>:</strong></div></td>
            <td class="item"><div align="left">
                <?
				    if($institucion==770){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->profe_jefe;
					}				
					?>
            </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="4" rowspan="5" align="center">&nbsp;</td>
          </tr>
        </table></td>
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
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluaci�n N� : ".$decreto_eval?></strong></font></div></td>
          </tr>
          <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas N� : ".$planes?></strong></font></div></td>
          </tr>
   <? } ?>
      <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($periodo_pal))?></strong></font></div></td>
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
				    echo ('<b> DEBE INGRESAR FECHAS Y DIAS H�BILES PARA PER�ODOS </b> <br> Debe <a href="../../ano/periodo/listarPeriodo.php3" target="_parent">ir a Periodos</a>  e ingresar la informaci�n requerida...  <br>  <br> ');
				?>
							 	
				</div>	
				<?
				exit;
				}	
			$id_periodo = $fila1['id_periodo'];

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
                    <td width="231" align="left"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Subsector del Aprendizaje (Formaci&oacute;n General ) </strong></font></div></td>
                    <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></td>
                    <? 
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1�<? echo $tipo_per ?></strong></font></td>
            <?	if($tipo_rep==2){ ?>
				    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>Curso</strong></font></td>
			<? }	
			}	
			
			$tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			$tot_periodo = 2;
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2�<? echo $tipo_per ?></strong></font></td>
         <?	 if($tipo_rep==2){ ?>
				    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>Curso</strong></font></td>
			<? }	
		 }
			
			if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3�<? echo $tipo_per ?></strong></font></td>										            <? if($tipo_rep==2){ ?>
			   <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>Curso</strong></font></td>
			<? }
             } 
			
			}?>
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
		if($muestra_notas==1){
		  	$ob_reporte ->rut_alumno = $alumno;
			$ob_reporte ->ramo = $id_ramo;
			$ob_reporte ->periodo = $id_periodo;
			$result2 = $ob_reporte->Notas($conn);
		  	if (!$result2){
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
		}// FIN MUESTRA NOTAS			  
				$fila2 = @pg_fetch_array($result2,$f);
				$ob_reporte ->modo_eval =$modo_eval;
				$ob_reporte ->CambiaNota($fila2);

			?>
                    <td height="25" class="subitem"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? if((trim($fila['nombre'])=="RELIGION") && ($institucion==9239)){ echo $fila['nombre']."(optativo)"; }else{ echo $fila['nombre'];  }?>
                    </font></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?>
                      <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?><? } else { echo $ob_reporte->nota2; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?><? } else { echo $ob_reporte->nota3; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font><? } else { echo $ob_reporte->nota4; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font><? } else { echo $ob_reporte->nota5; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font><? } else { echo $ob_reporte->nota6; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font><? } else { echo $ob_reporte->nota7; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font><? } else { echo $ob_reporte->nota8; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font><? } else { echo $ob_reporte->nota9; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font><? } else { echo $ob_reporte->nota10; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font><? } else { echo $ob_reporte->nota11; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font><? } else { echo $ob_reporte->nota12; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font><? } else { echo $ob_reporte->nota13; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font><? } else { echo $ob_reporte->nota14; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font><? } else { echo $ob_reporte->nota15; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font><? } else { echo $ob_reporte->nota16; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font><? } else { echo $ob_reporte->nota17; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font><? } else { echo $ob_reporte->nota18; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font><? } else { echo $ob_reporte->nota19; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font><? } else { echo $ob_reporte->nota20; } ?></strong></div></td>
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
                    <td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? 
						if($prome_1<40 && $prome_1>0){ ?>
                      <strong><font color="#FF0000">
                        <? 
							echo $prome_1;?>
                        </font>
                        <? 
						} elseif($prome_1>=40) { 
							echo $prome_1; 
						}else{
							echo "&nbsp;";
						}?>
                      </strong></font></td>
					  <? if($tipo_rep==2){
					  		$ob_reporte ->periodo=$periodos;
							$ob_reporte	->ramo=$id_ramo;
							$ob_reporte ->PromedioRamoCurso($conn);
							$prom_curso = intval($ob_reporte->suma / $ob_reporte->contador);
							
							if($prom_curso==0){
								$prom_curso="&nbsp;";
							}
					   ?>
					  <td  align="center" class="subitem"><?=$prom_curso;?></td>
					  
                    <?	}
				} ?>
                  </tr>
                  <? } ?>
                  <tr>
                    <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio &nbsp;&nbsp;&nbsp;</font></strong></font></td>
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
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?>
                    </font></td>
                    <?
				if($tipo_rep==2){ ?>
					<td>&nbsp;</td>
			<? 	}
			}
			if ($prome_general_pro>0)// keo la caga... muy wuena la wuea
				$prome_general_pro = round($prome_general_pro/$cont_general_pro);

			?>
                  </tr>
                </table>
				<!--  taller -->
                <?		if($taller==1){
			$ob_reporte->alumno=$alumno;
			$ob_reporte->ano=$ano;
			$ob_reporte->AlumnoTaller($conn);
			$result = $ob_reporte->result;
			  	if (!$result){
				  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
    			}else{
	    			if (pg_numrows($result)!=0){
					  $fila = @pg_fetch_array($result,0);	
					  if (!$fila){
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
				  	  }
			  		}	
		  		}
		  $num_subsec = pg_numrows($result);

		if($num_subsec>0){
?>
                <br>
                <br>
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231" align="left">
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TALLERES / ACADEMIAS </strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></td>
			<? 
				$ob_reporte->ano=$ano;
				$result_p = $ob_reporte->TotalPeriodo($conn);

			$fila_p = pg_num_rows($result_p);
			$p1 = pg_fetch_array($result_p,0);
			$p1=$p1['id_periodo'];
			$p2 = pg_fetch_array($result_p,1);
			$p2 = $p2['id_periodo']; 
			if($fila_p > 2){
				$p3 = pg_fetch_array($result_p,2);
				$p3 = $p3['id_periodo'];			
			}						
			if($p1==$periodo){?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1�<? echo $tipo_per ?></strong></font></td>
			<? }			
			if($p2==$periodo){?>			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1�<? echo $tipo_per ?></strong></font></td>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2�<? echo $tipo_per ?></strong></font></td>
			<?	}		
			if($p3==$periodo){?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1�<? echo $tipo_per ?></strong></font></td>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2�<? echo $tipo_per ?></strong></font></td>						
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3�<? echo $tipo_per ?></strong></font></td>						
			<? }?>			         
            </tr>
		  <?
		  $cont_prom = 0;
		  $promedio = 0;


		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
				$fila_taller = @pg_fetch_array($result,$e);
				$id_taller = $fila_taller['id_taller'];
				$sql_taller = "select * from taller where id_taller=".$id_taller."";
				$result_taller =@pg_Exec($conn,$sql_taller);
				$fila = @pg_fetch_array($result_taller,0);		  

				$modo_eval = $fila['modo_eval'];
				$nom_taller = $fila['nombre_taller'];
			?>		
          <tr>
		  <?

// NOTAS TALLER
			$ob_reporte->alumno=$alumno;
			$ob_reporte->taller=$id_taller;
			$ob_reporte->periodo=$id_periodo;
			$result2 = $ob_reporte->NotasTaller($conn);
		  	if (!$result2){
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
				$ob_reporte->CambiaNota($fila2);
			?>
            <td height="25"><div align="left"><? echo $nom_taller; ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?></font></strong><? } else { echo $ob_reporte->nota2; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?></font></strong><? } else { echo $ob_reporte->nota3; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font></strong><? } else { echo $ob_reporte->nota4; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font></strong><? } else { echo $ob_reporte->nota5; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font></strong><? } else { echo $ob_reporte->nota6; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font></strong><? } else { echo $ob_reporte->nota7; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font></strong><? } else { echo $ob_reporte->nota8; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font></strong><? } else { echo $ob_reporte->nota9; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font></strong><? } else { echo $ob_reporte->nota10; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font></strong><? } else { echo $ob_reporte->nota11; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font></strong><? } else { echo $ob_reporte->nota12; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font></strong><? } else { echo $ob_reporte->nota13; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font></strong><? } else { echo $ob_reporte->nota14; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font></strong><? } else { echo $ob_reporte->nota15; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font></strong><? } else { echo $ob_reporte->nota16; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font></strong><? } else { echo $ob_reporte->nota17; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font></strong><? } else { echo $ob_reporte->nota18; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font></strong><? } else { echo $ob_reporte->nota19; } ?></div></td>
			<td width="17"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font></strong><? } else { echo $ob_reporte->nota20; } ?></div></td>
			<? 	$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					//-------
					$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->taller = $id_taller;
					$ob_reporte ->periodo = $periodos;
					$result_peri =$ob_reporte ->NotasTaller($conn);
				
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
			?>
		  </tr>
 <? } ?>		  
          <tr>
            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio &nbsp;&nbsp;&nbsp;</font></strong></font></td>
			<?
			$ob_reporte ->ano = $ano;
			$resultPer = $ob_reporte ->TotalPeriodo($conn);
			
			$prome_abajo = 0;
			$cont_abajo = 0;
	        for($per=0 ; $per < $tot_periodo ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];
				
				$ob_reporte ->periodo 	= $periodos;
				$ob_reporte ->alumno 	= $alumno;
				$ob_reporte ->PromedioAlumnoTaller($conn);
				
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

<?	}	
	} /**** FIN IF TALLER ****/
?>
<!-- fin taller -->
		        
		<? } //for?>
		<? } //if?> 
		<HR width="100%" color=#003b85>
		
		
		
<? if ($estadistica==1){ ?>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="133"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS PERIODO </strong></font></td>
				<td width="159"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $dias_habiles ?></font></td>
	   			<td width="202"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS INASISTENTES</strong></font></td>
				<td width="152"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></td>
				<td width="4">&nbsp;</td>
			</tr>
		  	<tr>
				<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIAS (%)</strong></font></td>
				<td><font size="1" face="Arial, Helvetica, sans-serif">
			     		   <? 
							if ($dias_habiles>0)
							{
								$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
								$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
								$prom_cont_asis = $prom_cont_asis + 1;
							}
							echo $promedio_asistencia . "%" ;
							?></font>				</td>
				<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATRASOS</strong></font></td>
				<td><font size="1" face="Arial, Helvetica, sans-serif">
					<?
					$ob_reporte ->alumno = $alumno;
					$ob_reporte ->tipo =2;
					$ob_reporte ->fecha_inicio = $fecha_ini;
					$ob_reporte ->fecha_termino = $fecha_fin;
					$result_atraso =$ob_reporte ->Anotaciones($conn);
					$fila_atraso = @pg_fetch_array($result_atraso,0);
					echo @pg_numrows($result_atraso);
					
					?></font>				</td>
		  </tr>
		</table>
  <? } ?>
  <? if($obs==1){ ?>	
		<table width="650"  border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td ><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></font></div></td>
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
			<td height="27"><div align="left">________________________________________________________________________________</div></td>
		  </tr>
		  <? } 
		  for($o=1; $o<=($txtOBS-1) ; $o++){
		  ?>
		  <tr>
		    <td height="27"><div align="left">________________________________________________________________________________</div></td>
		    </tr>
		  <tr>
		    <td height="27"><div align="left">________________________________________________________________________________</div></td>
		  </tr>
		  <? } ?>
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


 <? if ($_INSTIT==9239){
			    $gradio_curso = "select * from curso where id_curso = '".$curso."'";
				$result_gradio =@pg_Exec($conn,$gradio_curso);
				$fila_gradio = @pg_fetch_array($result_gradio);	
				$gradio =  ($fila_gradio['grado_curso']);
				$gradino = ($fila_gradio['ensenanza']);
				
				}
				 ?>		
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
              </div>		</td>
      </tr>
    </table>
	
	<?
	if ($_INSTIT!=770){ ?>
		<table width="650">
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
  <? if($institucion =="770"){	?>	
    <tr><td>&nbsp;</td></tr>
		<tr>	
		<td colspan="3" align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($fila_com['nom_com'])).", ".fecha_espanol($fecha);?></font></td> 
		</tr>
<? 	} ?>

 	<td><div align="justify"></div>

 
 		
  </table>

<? 
if($opc_Anotacion==1){?>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
       <td class="tableindex"><div align="center"><strong>INFORME DE ATRASOS, ANOTACIONES E INASISTENCIAS</strong></div></td>
      </tr>
      <tr>
  </table>
    <br>
    
    <?
	/******* CONSULTA NO FUNCIONA EN OBJETO **************/	
	$sql =" SELECT a.*, b.nombre_emp || CAST(' ' as varchar) || ape_pat || CAST(' ' as varchar) || ape_mat as nombre ";
	$sql.=" FROM anotacion a INNER JOIN empleado b ON a.rut_emp=b.rut_emp  WHERE rut_alumno=".$alumno." AND id_periodo=".$periodo." ";
	$sql.=" ORDER BY tipo desc, fecha ";
	$result_anota = @pg_exec($conn,$sql);
	
	
	if (pg_numrows($result_anota)==0) echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA ANOTACIONES NI ATRASOS</strong></font><br>";
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		if ($fila_anota['tipo_conducta']==1)
			$tipo_conducta = "POSITIVA";
		if ($fila_anota['tipo_conducta']==2)
			$tipo_conducta = "NEGATIVA";							
		if ($fila_anota['tipo']== 1)
			$tipo = $tipo_conducta;
		elseif($fila_anota['tipo']==2)
			$tipo = "ATRASO";
		elseif($fila_anota['tipo']==3)
			$tipo = "INASISTENCIA";
		elseif($fila_anota['tipo']==4)
			$tipo = "ENFERMERIA";
		elseif($fila_anota["codigo_tipo_anotacion"]!=""){
			$cod_ta = $fila_anota["codigo_tipo_anotacion"];
			$q1 = "select * from tipos_anotacion where id_tipo ='$cod_ta'";
			$r1 = @pg_Exec($conn,$q1);
			$f1 = @pg_fetch_array($r1,0);
			$codta  = $f1['codtipo'];
			$tipo	= $f1['descripcion'];
		}  
	
		$fecha   = $fila_anota['fecha'];
		$rut_emp = $fila_anota['rut_emp'];
		
		$profesor_res = strtoupper($fila_anota['nombre']);
		
		
		if (trim($fila_anota['observacion'])=="")
			$observacion = "&nbsp;";
		else
			$observacion = ucfirst($fila_anota['observacion']);
		
		$hora = $fila_anota['hora'];
		
		
?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr width="100%" color=#003b85></td>
      </tr>
    </table>
    <? if($fila_anota['tipo']!=2){?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="156"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Fecha</strong></font></td>
        <td width="7"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td width="258"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? impF($fecha)?></font></td>
        <td width="77"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Tipo</strong></font></td>
        <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td width="143"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $tipo?></font></td>
      </tr>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor Responsable </strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $profesor_res?></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Hora</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $hora?></font></td>
      </tr>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Observaci&oacute;n</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $observacion?></font></td>
      </tr>
      <?	if($fila_anota["sigla"]!=""){	?>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Subsector Aprendizaje</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
          <?
			// busco la sigla
			$ob_reporte ->sigla_aux = $fila_anota["sigla"];
			$ob_reporte ->SiglaSubsector($conn);
			echo $ob_reporte->sigla;?> - <? echo $ob_reporte->detalle_sigla; ?> 
			</font>
	    </td>
      </tr>
      <?	}	
   if($fila_anota["codigo_tipo_anotacion"]!=""){?>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Tipo de Anotaci&oacute;n</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
          <?php
			$ob_reporte ->institucion = $institucion;
			$ob_reporte ->tipo = $fila_anota["codigo_tipo_anotacion"];
		  	$r1 = $ob_reporte ->TipoAnotaciones($conn);
			$f1 = @pg_fetch_array($r1,0);
			$codta       = $f1['codtipo'];
			$descripcion	= $f1['descripcion'];
		
			echo "$codta - $descripcion";
		
  ?>
        </font> </td>
      </tr>
      <? }	
  if($fila_anota["codigo_anotacion"]!=""){?>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Sub - Tipo</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
          <?php 
		  
		  $ob_reporte ->codigo = $fila_anota["codigo_anotacion"];
		  $ob_reporte ->id_tipo = $cod_ta;
		  $r1 = $ob_reporte ->DetalleAnotaciones($conn);
		  $f1 = @pg_fetch_array($r1,0);
		  $detalle = $f1["detalle"];
			echo "$codigo_anotacion - $detalle";
		?>
        </font> </td>
      </tr>
      <?	}	?>
    </table>
    <? }else{ ?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Atraso el d&iacute;a </strong></font></td>
        <?	

		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);

	?>
        <td width="524"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha?></font></td>
      </tr>
    </table>
    <? } ?>
    <? } ?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr width="100%" color=#003b85></td>
      </tr>
    </table>
    <?
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano =$ano;
		$ob_reporte ->curso =$c_curso;
		$result_asis = $ob_reporte ->Asistencia($conn);
		
	if (@pg_numrows($result_asis)==0) 
		echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA INASISTENCIAS</strong></font><br>";
	for($cont=0 ; $cont < @pg_numrows($result_asis) ; $cont++)
	{
		$fila_asis = @pg_fetch_array($result_asis,$cont);
		$fecha = $fila_asis['fecha'];
		
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano =$ano;
		$ob_reporte ->fecha = $fecha;
		$res_justifica = $ob_reporte->JustificaAsistencia($conn);	
		
/*	$sql_justifica = "select * from justifica_inasistencia where rut_alumno = '$alumno' and ano = '$ano' and fecha = '$fecha'";
	@pg_Exec($conn,$sql_justifica);*/
	$fila_justifica = @pg_fetch_array($res_justifica,0);
	$justifica = $fila_justifica['fecha'];	
	 if($justifica == $fecha){
	 	$justificado = true;
	 }else{
	 	$justificado = false;
	 }
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);
?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Inasistencia el d&iacute;a </strong></font></td>
        <td width="524"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha;?><strong>
          <? if($justificado==true)echo "&nbsp;&nbsp;&nbsp;(Justificado)";?>
        </strong></font></td>
      </tr>
    </table>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr width="100%" color=#003b85></td>
      </tr>
    </table>
    <?
 }
 if($colilla==1){	?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><font face="Arial, Helvetica, sans-serif"><strong><img src="tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </strong></font></td>
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
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?> Total D&iacute;as Inasistente <? } ?></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==770){ ?>&nbsp; <? }else{ ?> <? echo $inasistencia ?> <? } ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Per�odo </font></div></td>
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
<? }  
}


  }
}


if ($fila['ensenanza']>300 and $fila['grado_curso']>2){ ?>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?
	if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br><br><br>";
			   
		  }
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
            <td width="100%"><table width="650" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			  <? if ($institucion!="770"){ ?>
			    <td width="115" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
			    <td width="10"><strong>:</strong></td>
			    <td width="359" class="subitem"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>	
                <td width="161" rowspan="7" align="center" valign="top" >
<?
		$result = @pg_Exec($conn,"select insignia, rdb from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c�digo para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>				</td>
	  <? } ?>
              <tr>
                <td class="item"><div align="left"><strong>A�O ESCOLAR</strong></div></td>
                <td><strong>:</strong></td>
                <td class="subitem"><div align="left"><? echo $ob_membrete->nro_ano; ?></div></td>
                </tr>
              <tr>
                <td class="item"><div align="left"><strong>CURSO</strong></div></td>
                <td><strong>:</strong></td>
                <td class="subitem"><div align="left">
				  <? 
				$Curso_pal = CursoPalabra($curso, 0, $conn);
				echo $Curso_pal; 
				?>
				</div></td>
                </tr>	
              <tr>
                <td class="item"><div align="left"><strong>ALUMNO</strong></div></td>
                <td><strong>:</strong></td>
                <? if($institucion==8930){?>
				<td class="subitem"><? Nombre($fila['ape_pat'],$fila['ape_mat'],$fila['nombre_alu'])?></td> 
				<? }else{?>
				<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));?></font></div></td> 
				<? } ?>
                </tr>
              <tr>
                <td class="item"><div align="left"><strong>PROFESOR JEFE</strong></div></td>
                <td><div align="left"><strong>:</strong></div></td>
                <td class="subitem"><div align="left">
				 <?
				    if($institucion==770){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->profe_jefe;
					}				
					?>
				</div></td>
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
        <td height="20"  class="tableindex"><div align="center">INFORME  DE NOTAS</div></td>
      </tr>
	   <?
	  if ($institucion==770){
	      ?>
		  <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluaci�n N� : ".$decreto_eval?></strong></font></div></td>
          </tr>
          <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas N� : ".$planes?></strong></font></div></td>
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
				    echo ('<b> DEBE INGRESAR FECHAS Y DIAS H�BILES PARA PER�ODOS </b> <br> Debe <a href="../../ano/periodo/listarPeriodo.php3" target="_parent">ir a Periodos</a>  e ingresar la informaci�n requerida...  <br>  <br> ');

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
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1�<? echo $tipo_per ?></strong></font></td>
			<?
				if($tipo_rep==2){ ?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom<br>Curso</strong></font></td>
			<? 	}
				}		
			$tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			
			$tot_periodo = 2;
			?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2�<? echo $tipo_per ?></strong></font></td>
			<?	if($tipo_rep==2){ ?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom<br>Curso</strong></font></td>
			<? 	}
			}
			if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3�<? echo $tipo_per ?></strong></font></td>						
			<? 
			if($tipo_rep==2){ ?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom<br>Curso</strong></font></td>
			<? 	}
			} }?>		         
			
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
            <td height="25" class="subitem"><div align="left"><? if((trim($fila['nombre'])=="RELIGION") && ($institucion==9239)){ echo $fila['nombre']."(optativo)"; }else{ echo $fila['nombre'];  } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota2 ?></font><? } else { echo $ob_reporte->nota2; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota3 ?></font><? } else { echo $ob_reporte->nota3; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font><? } else { echo $ob_reporte->nota4; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font><? } else { echo $ob_reporte->nota5; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font><? } else { echo $ob_reporte->nota6; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font><? } else { echo $ob_reporte->nota7; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font><? } else { echo $ob_reporte->nota8; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font><? } else { echo $ob_reporte->nota9; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font><? } else { echo $ob_reporte->nota10; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font><? } else { echo $ob_reporte->nota11; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font><? } else { echo $ob_reporte->nota12; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font><? } else { echo $ob_reporte->nota13; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font><? } else { echo $ob_reporte->nota14; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font><? } else { echo $ob_reporte->nota15; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font><? } else { echo $ob_reporte->nota16; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font><? } else { echo $ob_reporte->nota17; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font><? } else { echo $ob_reporte->nota18; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font><? } else { echo $ob_reporte->nota19; } ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font><? } else { echo $ob_reporte->nota20; } ?></div></td>
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
					<td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif"><? 
						if($prome_1<40 && $prome_1>0){ ?><strong><font color="#FF0000"><? 
							echo $prome_1;?></font><? 
						} elseif($prome_1 >=40) { 
							echo $prome_1; 
						}else{
							echo "&nbsp;";
						}?></font></td>								
					<?
					  if($tipo_rep==2){
					  		$ob_reporte ->periodo=$periodos;
							$ob_reporte	->ramo=$id_ramo;
							$ob_reporte ->PromedioRamoCurso($conn);
							$prom_curso = intval($ob_reporte->suma / $ob_reporte->contador);
							
							if($prom_curso==0){
								$prom_curso="&nbsp;";
							}
					   ?>
					  <td  align="center" class="subitem"><?=$prom_curso;?></td>
					  
                    <?	}
				}
			?>
		  </tr>
		  <? 
		  
		  }	  
		  
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
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Subsector del Aprendizaje (Formaci&oacute;n Diferenciada ) </strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></td>
			<?
		  	$sql_peri = "SELECT distinct id_periodo FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."')) order by id_periodo;";
			$result_peri =@pg_Exec($conn,$sql_peri);
			$cantidad_periodos = @pg_numrows($result_peri);	
			$tri = 0;
			$tri = 1;			
			if(($tot_periodo==1)OR($tot_periodo==2)OR($tot_periodo==3)){	?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1�<? echo $tipo_per ?></strong></font></td>
			<? if($tipo_rep==2){ ?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom<br>Curso</strong></font></td>
			<? 	}
			}			
			$tri = 2;
			if(($tot_periodo==2)OR($tot_periodo==3)){	?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2�<? echo $tipo_per ?></strong></font></td>
			<?	if($tipo_rep==2){ ?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom<br>Curso</strong></font></td>
			<? 	}
			}			
			if ($num_periodos==3){$tri = 3;
			if($tot_periodo==3){	?>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3�<? echo $tipo_per ?></strong></font></td>						
			<? if($tipo_rep==2){ ?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom<br>Curso</strong></font></td>
			<? 	}
			}	} ?>		         
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
            <td height="25" class="subitem"><div align="left"><? echo $fila['nombre']; ?></div></td>
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
					<td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif"><? 
						if($prome_1<40 && $prome_1>0){ ?><strong><font color="#FF0000"><? 
							echo $prome_1;?></font><? 
						} elseif($prome_1 >=40){  
							echo $prome_1; 
						}else {
							echo "&nbsp;";
						}?></font></td>								
					<?
					  if($tipo_rep==2){
					  		$ob_reporte ->periodo=$periodos;
							$ob_reporte	->ramo=$id_ramo;
							$ob_reporte ->PromedioRamoCurso($conn);
							$prom_curso = intval($ob_reporte->suma / $ob_reporte->contador);
							
							if($prom_curso==0){
								$prom_curso="&nbsp;";
							}
					   ?>
					  <td  align="center" class="subitem"><?=$prom_curso;?></td>
					  
                    <?	}
				}
			?>
		  </tr>
		  <? } ?>
		  <? } ?>	
          <tr>
            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio &nbsp;&nbsp;&nbsp;</font></strong></font></td>
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
				if($tipo_rep==2){ ?>
					<td>&nbsp;</td>
			<? 	}
			}
			if ($prome_general_pro>0)// keo la caga... muy wuena la wuea
				$prome_general_pro = round($prome_general_pro/$cont_general_pro);

			?>
          </tr>		  	  
        </table>
				<!--  taller -->
<?		if($taller==1){
			$ob_reporte->alumno=$alumno;
			$ob_reporte->ano=$ano;
			$ob_reporte->AlumnoTaller($conn);
			$result = $ob_reporte->result;
			  	if (!$result){
				  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
    			}else{
	    			if (pg_numrows($result)!=0){
					  $fila = @pg_fetch_array($result,0);	
					  if (!$fila){
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
				  	  }
			  		}	
		  		}
		  $num_subsec = pg_numrows($result);

		if($num_subsec>0){
?>
				<br><br>
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231" align="left">
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TALLERES / ACADEMIAS </strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></td>
			<? 
				$ob_reporte->ano=$ano;
				$result_p = $ob_reporte->TotalPeriodo($conn);

			$fila_p = pg_num_rows($result_p);
			$p1 = pg_fetch_array($result_p,0);
			$p1=$p1['id_periodo'];
			$p2 = pg_fetch_array($result_p,1);
			$p2 = $p2['id_periodo']; 
			if($fila_p > 2){
				$p3 = pg_fetch_array($result_p,2);
				$p3 = $p3['id_periodo'];			
			}						
			if($p1==$periodo){?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1�<? echo $tipo_per ?></strong></font></td>
			<? }			
			if($p2==$periodo){?>			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1�<? echo $tipo_per ?></strong></font></td>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2�<? echo $tipo_per ?></strong></font></td>
			<?	}		
			if($p3==$periodo){?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1�<? echo $tipo_per ?></strong></font></td>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2�<? echo $tipo_per ?></strong></font></td>						
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3�<? echo $tipo_per ?></strong></font></td>						
			<? }?>			         
            </tr>
		  <?
		  $cont_prom = 0;
		  $promedio = 0;


		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
				$fila_taller = @pg_fetch_array($result,$e);
				$id_taller = $fila_taller['id_taller'];
				$sql_taller = "select * from taller where id_taller=".$id_taller."";
				$result_taller =@pg_Exec($conn,$sql_taller);
				$fila = @pg_fetch_array($result_taller,0);		  

				$modo_eval = $fila['modo_eval'];
				$nom_taller = $fila['nombre_taller'];
			?>		
          <tr>
		  <?

// NOTAS TALLER
			$ob_reporte->alumno=$alumno;
			$ob_reporte->taller=$id_taller;
			$ob_reporte->periodo=$id_periodo;
			$result2 = $ob_reporte->NotasTaller($conn);
		  	if (!$result2){
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
				$ob_reporte->CambiaNota($fila2);
			?>
            <td height="25" class="subitem"><div align="left"><? echo $nom_taller; ?></div></td>
			<td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></div></td>
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
					$ob_reporte ->taller = $id_taller;
					$ob_reporte ->periodo = $periodos;
					$result_peri =$ob_reporte ->NotasTaller($conn);
				
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
          <tr>
            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio &nbsp;&nbsp;&nbsp;</font></strong></font></td>
			<?
			$ob_reporte ->ano = $ano;
			$resultPer = $ob_reporte ->TotalPeriodo($conn);
			
			$prome_abajo = 0;
			$cont_abajo = 0;
	        for($per=0 ; $per < $tot_periodo ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];
				
				$ob_reporte ->periodos 	= $periodos;
				$ob_reporte ->alumno 	= $alumno;
				$ob_reporte ->PromedioAlumnoTaller($conn);
				
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

<?	}	
	} /**** FIN IF TALLER ****/
?>
<!-- fin taller -->

		  <? } //for?>
          <? } 
		  
		  
		  if($estadistica==1){ ?>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="153"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS PERIODO </strong></font></td>
			<td width="237"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $dias_habiles ?></font></td>
			<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS INASISTENTES</strong></font></td>
			<td width="78"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></td>
		  </tr>
		  <tr>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIAS (%)</strong></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">
			  <? 
					if ($dias_habiles>0){
						$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
						$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
						$prom_cont_asis = $prom_cont_asis + 1;
					}
					echo $promedio_asistencia . "%" ;
			  ?>
				</font>
			</td>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATRASOS</strong></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif"><br>
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
		<? } 
		if($obs==1){?>		
		<table width="650"  border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td ><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></font></div></td>
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
			<td height="27"><div align="left">________________________________________________________________________________</div></td>
		  </tr>
		  <? } 
		  for($o=1; $o<=($txtOBS-1) ; $o++){
		  ?>
		  <tr>
		    <td height="27"><div align="left">________________________________________________________________________________</div></td>
		  </tr>
		  <? } ?>
	  </table>
		<? } ?>	  
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
		
		<?  } ?>	
    </table>
<? if($colilla==1){	?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </strong></font></div></td>
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
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Per�odo </font></div></td>
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
 if($anotacion==1){
 	?>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
       <td class="tableindex"><div align="center"><strong>INFORME DE ATRASOS, ANOTACIONES E INASISTENCIAS</strong></div></td>
      </tr>
      <tr>
    </table>
    <br>
    
    <?
	/******* CONSULTA NO FUNCIONA EN OBJETO **************/	
	$sql =" SELECT a.*, b.nombre_emp || CAST(' ' as varchar) || ape_pat || CAST(' ' as varchar) || ape_mat as nombre ";
	$sql.=" FROM anotacion a INNER JOIN empleado b ON a.rut_emp=b.rut_emp  WHERE rut_alumno=".$alumno." AND id_periodo=".$periodo." ";
	$sql.=" ORDER BY tipo desc, fecha ";
	$result_anota = @pg_exec($conn,$sql);
	
	
	if (pg_numrows($result_anota)==0) echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA ANOTACIONES NI ATRASOS</strong></font><br>";
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		if ($fila_anota['tipo_conducta']==1)
			$tipo_conducta = "POSITIVA";
		if ($fila_anota['tipo_conducta']==2)
			$tipo_conducta = "NEGATIVA";							
		if ($fila_anota['tipo']== 1)
			$tipo = $tipo_conducta;
		elseif($fila_anota['tipo']==2)
			$tipo = "ATRASO";
		elseif($fila_anota['tipo']==3)
			$tipo = "INASISTENCIA";
		elseif($fila_anota['tipo']==4)
			$tipo = "ENFERMERIA";
		elseif($fila_anota["codigo_tipo_anotacion"]!=""){
			$cod_ta = $fila_anota["codigo_tipo_anotacion"];
			$q1 = "select * from tipos_anotacion where id_tipo ='$cod_ta'";
			$r1 = @pg_Exec($conn,$q1);
			$f1 = @pg_fetch_array($r1,0);
			$codta  = $f1['codtipo'];
			$tipo	= $f1['descripcion'];
		}  
	
		$fecha   = $fila_anota['fecha'];
		$rut_emp = $fila_anota['rut_emp'];
		
		/*$sql_emp = "select * from empleado where rut_emp = '$rut_emp'";
		$res_emp = @pg_Exec($conn,$sql_emp);
		$fil_emp = @pg_fetch_array($res_emp);*/
		
		$profesor_res = strtoupper($fila_anota['nombre']);
		
		
		if (trim($fila_anota['observacion'])=="")
			$observacion = "&nbsp;";
		else
			$observacion = ucfirst($fila_anota['observacion']);
		
		$hora = $fila_anota['hora'];
		
		
?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr width="100%" color=#003b85></td>
      </tr>
    </table>
    <? if($fila_anota['tipo']!=2){?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="156"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Fecha</strong></font></td>
        <td width="7"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td width="258"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? impF($fecha)?></font></td>
        <td width="77"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Tipo</strong></font></td>
        <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td width="143"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $tipo?></font></td>
      </tr>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor Responsable </strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $profesor_res?></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Hora</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $hora?></font></td>
      </tr>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Observaci&oacute;n</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $observacion?></font></td>
      </tr>
      <?	if($fila_anota["sigla"]!=""){	?>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Subsector Aprendizaje</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
          <?
			// busco la sigla
			$ob_reporte ->sigla_aux = $fila_anota["sigla"];
			$ob_reporte ->SiglaSubsector($conn);
			echo $ob_reporte->sigla;?> - <? echo $ob_reporte->detalle_sigla; ?> 
			</font>
		 </td>
      </tr>
      <?	}	
   if($fila_anota["codigo_tipo_anotacion"]!=""){?>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Tipo de Anotaci&oacute;n</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
          <?php
			$ob_reporte ->institucion = $institucion;
			$ob_reporte ->tipo = $fila_anota["codigo_tipo_anotacion"];
		  	$r1 = $ob_reporte ->TipoAnotaciones($conn);
			$f1 = @pg_fetch_array($r1,0);
			$codta       = $f1['codtipo'];
			$descripcion	= $f1['descripcion'];
		
			echo "$codta - $descripcion";
		
  ?>
        </font> </td>
      </tr>
      <? }	
  if($fila_anota["codigo_anotacion"]!=""){?>
      <tr>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Sub - Tipo</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
          <?php 
		  
		  $ob_reporte ->codigo = $fila_anota["codigo_anotacion"];
		  $ob_reporte ->id_tipo = $cod_ta;
		  $r1 = $ob_reporte ->DetalleAnotaciones($conn);
		  $f1 = @pg_fetch_array($r1,0);
		  $detalle = $f1["detalle"];
			echo "$codigo_anotacion - $detalle";
		?>
        </font> </td>
      </tr>
      <?	}	?>
    </table>
    <? }else{ ?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Atraso el d&iacute;a </strong></font></td>
        <?	

		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);

	?>
        <td width="524"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha?></font></td>
      </tr>
    </table>
    <? } ?>
    <? } ?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr width="100%" color=#003b85></td>
      </tr>
    </table>
    <?
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano =$ano;
		$ob_reporte ->curso =$c_curso;
		$result_asis = $ob_reporte ->Asistencia($conn);
		
	if (@pg_numrows($result_asis)==0) 
		echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA INASISTENCIAS</strong></font><br>";
	for($cont=0 ; $cont < @pg_numrows($result_asis) ; $cont++)
	{
		$fila_asis = @pg_fetch_array($result_asis,$cont);
		$fecha = $fila_asis['fecha'];
		
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano =$ano;
		$ob_reporte ->fecha = $fecha;
		$res_justifica = $ob_reporte->JustificaAsistencia($conn);	
		
/*	$sql_justifica = "select * from justifica_inasistencia where rut_alumno = '$alumno' and ano = '$ano' and fecha = '$fecha'";
	@pg_Exec($conn,$sql_justifica);*/
	$fila_justifica = @pg_fetch_array($res_justifica,0);
	$justifica = $fila_justifica['fecha'];	
	 if($justifica == $fecha){
	 	$justificado = true;
	 }else{
	 	$justificado = false;
	 }
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);
?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Inasistencia el d&iacute;a </strong></font></td>
        <td width="524"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha;?><strong>
          <? if($justificado==true)echo "&nbsp;&nbsp;&nbsp;(Justificado)";?>
        </strong></font></td>
      </tr>
    </table>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr width="100%" color=#003b85></td>
      </tr>
    </table>
    <?
 }


 }
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


</div>
<? pg_close($conn);?>