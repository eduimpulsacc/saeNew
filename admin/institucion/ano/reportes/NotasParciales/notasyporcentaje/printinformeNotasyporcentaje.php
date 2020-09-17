<?
	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include('../../../../../clases/class_Membrete.php');
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$reporte		=$c_reporte;
	$periodo		=$c_periodos;
	$colilla		=$chkCOLILLA;
	$estadistica	=$opc_estadistica;
	$obs			=$opc_obs;
	$tipo_rep		=$tipo_rep;
	$anotacion		=$det_anot;
		
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
		/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	$iniano = $ob_membrete->fecha_inicio;
	$finano = $ob_membrete->fecha_termino;
	
	
	/****************DATOS PERIODO************/
	$ob_reporte ->ano=$ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->Periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	//if($_PERFIL==0){echo "1-".$dias_habiles;}
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
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	$cnmax_grupo = $ob_reporte->maxGrupoN($conn);
	$tabmax=pg_result($cnmax_grupo,2);
	
	
	//datos esscala 
	$rs_escala = getEscalaNotas($rbd,$conn);
	$fila_escala = pg_fetch_array($rs_escala,0);
	$exigencia = $fila_escala['exig']*100;
	
	
	$ob_reporte->idc = $curso;
	$ense = $ob_reporte->getEnsenanzabyCurso($conn);
	
	$grado = $ob_reporte->getGradobyCurso($conn);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INFORME DE NOTAS PARCIALES</title>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
  H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always;
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
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


function guardaImp(alu){
	var ano =<?php echo $_ANO ?>;
	var curso =<?php echo $c_curso ?>;
	var alumno =alu;
	var reporte =<?php echo $c_reporte ?>;
	var parametros ="ano="+ano+"&curso="+curso+"&alumno="+alumno+"&reporte="+reporte;
	var cuenta=2;
	var cad_cuenta="";
	for(i=0;i<cuenta;i++){
		cad_cuenta = cad_cuenta+"../";
	}
	
	$.ajax({
		url:cad_cuenta+'cuentaRepo/cuentaRepo.php',
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
		}
	})
}
</script>
</head>

<body>
<div id="capa0">
	<TABLE width="100%"><TR><TD>
	<table>
    <tr>
	  <td align="left"><input name="button4" type="button" class="botonXX" onClick="window.close()"   value="CERRAR">	  </td>
	</tr>
  </table>
  </TD><TD>
		<div align="right"> <font face="Arial, Helvetica, sans-serif" size="-1">Imprimir Horizontal</font>
		  <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	
          <!--INPUT name="button" TYPE="button" class="botonX" onClick=document.location="curso.php3" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER"-->
  		</div></TD>
		
  <TD>&nbsp;</TD>
	</TR></TABLE>
</div>

<?
	if (empty($alumno)){
	
		$ob_reporte ->curso = $curso;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->retirado =0;
		$ob_reporte ->orden =$ck_orden;
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
	$suma_prom_gral=0;
	$cont_prom_gral=0;
	$prome_general_pro = 0;
	$cont_general_pro = 0;
	$suma_prom_curso = 0;
	$cont_prom_curso = 0;
	$prome_semestral_coef=0;
	$cuenta_semestral_coef=0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$bool_ed = $fila_alu['bool_ed'];
	//$dias_habiles = $ob_reporte->dias_habiles;
	?>
<script>
	guardaImp(<?php echo $alumno ?>);
	</script>
    <?
	
	
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.truncado_final, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza,curso.fecha_inicio,curso.fecha_termino,curso.bool_psemestral  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];
	$truncado_final = $fila['truncado_final'];
	$truncado_semestre = $fila['bool_psemestral'];
	
	$finicio_curso = $fila['fecha_inicio'];
	$ftermino_curso = $fila['fecha_termino'];
	
	
	
	/******************** CON ESTADISTICA ******************************/
	
		
	$ob_reporte ->alumno = $alumno;
	$ob_reporte ->ano = $ano;
	$ob_reporte ->fecha_inicio=$fecha_ini;
	
	if($id_ulperiodo==$periodo){
		if($ftermino_curso!=''){
			$ob_reporte ->fecha_termino = $ftermino_curso;
		}else{
			$ob_reporte ->fecha_termino = $fecha_fin;
		}
		
	
	}else{
	$ob_reporte ->fecha_termino = $fecha_fin;
	}
	
	
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
	$sql = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$alumno." and ano = ".$ano." and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."') AND id_curso =".$curso." ORDER BY fecha ASC";
	$rs_justifica = @pg_exec($conn,$sql);
	//if($Just_Asis==1){
	$justifica = @pg_numrows($rs_justifica);
	//}else{
	//	$justifica=0;
	//}
	$cantidad = @pg_numrows($result13);
	if($Just_Asis==1 && $institucion==1914){
	  $inasistencia=	@pg_numrows($result13);
	}
	elseif($Just_Asis==1){
	$inasistencia = @pg_numrows($result13) - $justifica;
	}
	
	
	else{
	$inasistencia=	@pg_numrows($result13);
	}
	$dias_asistidos = $dias_habiles - ($cantidad - $justifica);
	//if($_PERFIL==0) echo "dias justif.--> ".$justifica."  dias habiles -->".$dias_habiles."  inasistencia-->".$cantidad."  dias asistidos -->".$dias_asistidos;

	//---------------------------
	
	
?>
    <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <? if ($institucion!="770"){ ?>
        <td width="114" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
        <td width="9" class="item"><strong>:</strong></td>
        <td width="361" class="item"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
        <td width="161" rowspan="7" align="center" valign="top" ><?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c&oacute;digo para tomar la insignia
			
				  if($institucion!=""){
					  $rt = ($xls==1)?"http://".$_SERVER['HTTP_HOST']."/sae3.0/tmp/":"../../../../../../tmp/";
					  
					  echo "<img src='".$rt.$fila_foto['rdb']."insignia". "' >";
					 // echo "<img src='"."http://".$_SERVER['HTTP_HOST']."/sae3.0/tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?></td>
        <? } ?>
      </tr>
      <tr>
        <td class="item"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
        <td class="item"><strong>:</strong></td>
        <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
      </tr>
      <tr>
        <td class="item"><div align="left"><strong>CURSO</strong></div></td>
        <td class="item"><strong>:</strong></td>
        <td class="item"><div align="left"><? echo $Curso_pal; ?></div></td>
      </tr>
      <tr>
        <td class="item"><div align="left"><strong>ALUMNO/A</strong></div></td>
        <td class="item"><strong>:</strong></td>
        <td class="item"><div align="left">
          <? $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));
	  echo $ob_reporte->tildeM($nombre_alumno);  ?>
        </div></td>
      </tr>
      <tr>
        <td class="item"><div align="left"><strong>PROFESOR(A) JEFE</strong></div></td>
        <td class="item"><div align="left"><strong>:</strong></div></td>
        <td class="item"><div align="left">
          <?
				    if($institucion==14490){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
					}				
					?>
        </div></td>
      </tr>
    </table>
    <table width="850" border="0" align="center">
  <tr>
    <td class=""><div align="center"><strong>INFORME DE NOTAS</strong> </div></td>
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
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($periodo_pal))?></strong></font></div></td>
      </tr>
  
 
</table><br />
<br />
<?if(strlen($c_periodos)==0){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	   <tr>
		 <td><hr width="100%" color=#003b85><b>DATOS INCOMPLETOS, DEBE AVISAR AL ESTABLECIMIENTO.</b></td>
	   </tr>
	 </table>
<? } else{?>
<table  border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr bgcolor="#ccc">
    <td colspan="<?php echo 39 ?>" class="item" width="350"><strong>Asignaturas<BR>
    </strong></td>
    <?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
		  $prome_semestral_ap=0;
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
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
		?>	
    <td width="17" class="subitem"><strong><font size="1" face="Arial, Helvetica, sans-serif">1&ordm;<? echo $tipo_per ?></font></strong></td>
  <?php  } 
  $tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			$tot_periodo = 2;
		
			?>
                    <td align="center" width="17"><strong><font size="1" face="Arial, Helvetica, sans-serif">2&ordm;<? echo $tipo_per ?></font></strong></td>
  <? }}
  if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>
               <td align="center" width="17"><strong><font size="1" face="Arial, Helvetica, sans-serif">3&ordm;<? echo $tipo_per ?></font></strong></td>
       <?php }} 
	   //promedio anual
       if($tipo_rep==5){ ?>
				          <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br />
				            Anual</strong></font></td>
				          <? }
						  ?>  
                         <? if($institucion !=22743){?>
                        <!--  <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>% Avance</strong></font></td> -->
						 <? } ?>
                           <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>% <br />
				            Logro</strong></font></td>
                              <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Concepto</strong></font></td>
  </tr>
  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $rdASIGNATURA;
		  $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->subsector=$rb_subsector; 
		  $ob_reporte ->formacion=1;
		  $ob_reporte ->todos = $rdASIGNATURA;
		  $ob_reporte ->incide = $rdASIGNATURA;
		  if($ck_alumnos==1){
			  $ob_reporte ->RamoAlumnoEximido($conn);
		  }else{
			  $ob_reporte ->RamoFormacion($conn);
		  }
		  
          $result =$ob_reporte ->result;
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
		  $prome_semestral = 0;
		  $cuenta_semestral =0;	
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];
				$incide_promo = $fila['bool_ip'];
				$artistico = $fila['bool_artis'];
				$bool_pgeneral=$fila['bool_pgeneral'];
				$truncado =$fila['truncado']; 
				$bool_tiene =$fila['bool_tiene'];
				$sub_obli =$fila['sub_obli'];
				$cuentapuestas=0;
				$cuentagr=0; 
				$subs = $fila['cod_subsector'];
				//$puestas =0; 
//if($_PERFIL==0){echo "tiene->".$bool_tiene;}
				
				/////////////////////////PORCENTAJES//////////////
				$sql_pocentaje = "SELECT pos21 FROM nota_porcentaje$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$fila['id_ramo'];
			    $resp = @pg_exec($conn,$sql_pocentaje);
			    $pos21=@pg_result($resp,0);
			    ////////////////////////FIN PORCENTAJES///////////
				
				//traigo el grupo
				$ob_reporte->ramo=$fila['id_ramo'];
				$ob_reporte ->periodo = $id_periodo;
				$rs_grupo=$ob_reporte->TraeGrupoNotaPer($conn);
				
			?>
             <?
		  	$ob_reporte ->rut_alumno = $alumno;
			$ob_reporte ->ramo = $id_ramo;
			$ob_reporte ->periodo = $id_periodo;
			$result2 = $ob_reporte->Notas($conn);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (99)</B>');
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
				$ob_reporte ->modo_eval =$modo_eval;
				$ob_reporte ->CambiaNota($fila2);
				$suesp=0;
				$cuentaGrupos=0;
				
				$formula_p = $ob_reporte->formulaPadre($conn);
				if(pg_numrows($formula_p)>0){
				$padref[$alumno]['id_ramo'][]=$fila['id_ramo'];
				$padref[$alumno]['formula'][]=pg_result($formula_p,0);
				}
				
				
				$ob_reporte->ramo_hijo = $fila['id_ramo'];
				$vijo =$ob_reporte->formulaSoyHijo($conn);
				$vista = (pg_numrows($vijo)>0)?'style="display:none"':""; 
				
			?>
  <tr <?php echo $vista ?>>
    <td rowspan="3" class="subitem" valign="middle" nowrap="nowrap" width="350" ><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
                      <?  echo $fila['nombre']; if($fila['bool_ip']==0) echo "(no incide en promoci&oacute;n)"; ?>
                       <?php echo (pg_numrows($formula_p)>0)?"(PROMEDIO)":""; ?>
                    
                     
                    </font></div></td>
   <?php if(pg_numrows($rs_grupo)==0){ ?> <td colspan="<?php echo 38 ?>" bgcolor="#ccc"><font size="1" face="Arial, Helvetica, sans-serif">100% Notas no agrupadas </font></td><?php } ?>
   <?php if(pg_numrows($rs_grupo)>0){
	  
	    ?>
   <?php for($g=0;$g<pg_numrows($rs_grupo);$g++){
	   $cuentacols=0;
	    $cuentaGrupos++;
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   
	   $cuentacols = ($fila_grupo['nota1']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota2']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota3']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota4']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota5']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota6']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota7']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota8']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota9']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota10']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota11']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota12']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota13']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota14']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota15']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota16']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota17']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota18']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota19']==1)?$cuentacols+1:$cuentacols;
	  // $cuentacols = ($fila_grupo['nota20']==1)?$cuentacols+1:$cuentacols;
	   
	   
	 $suesp=$suesp+$cuentacols;
	 $rpos = 19- $suesp;
	 
	 $clpp = 6-$cuentacols;
	 
	 $cuentagr = $cuentagr+$cuentacols;
	
	 
	 //$cuentacols=($_PERFIL==0)?$cuentacols+$clpp:$cuentacols;
	 // $cuentacols=$cuentacols+$clpp;
	   
	   ?>
    <td colspan="<?php echo ($cuentacols*2) ?>" bgcolor="#ccc" ><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $fila_grupo['porcentaje'] ?>% - <?php echo ucfirst(strtolower($fila_grupo['nombre'])) ?>&nbsp;</font> </td><?php ?>
   
	<?php } 
	?>
    <?php if((38-($suesp*2))>0){?>
    <td colspan="<?php echo (38-($suesp*2)) ?>" bgcolor="#CCCCCC">&nbsp;</td>
    <?php }?>
    <?
	
    
	 } ?> 
    
   <?
				////aucmulo promedio////
				$prom_pos = $pos1+$pos2+$pos3+$pos4+$pos5+$pos6+$pos7+$pos8+$pos9+$pos10+$pos11+$pos12+$pos13+$pos14+$pos15+$pos16+$pos17+$pos18+$pos19;					
				/////fin//////	
				
				
				$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				//$prome_semestral_ap=0;
				
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					//if($_PERFIL==0) echo "<br>".$periodos;
					$prome_ap=0;	
					$prome_abajo_ap=0;	
																																																				//-------			
																																																						
					/*$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->ano=$ano;
					$ob_reporte ->institucion=$institucion;
					$ob_reporte ->bool_ar=0; 
					$result_tiene = $ob_reporte->AlumnosTiene($conn);*/
					
					$rs_notas =0;
					$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->periodo = $periodos;								 																																					
					$XUXA =$ob_reporte->Notas($conn);
					pg_dbname($conn);
					if (pg_numrows($XUXA)>0){ 
						$fila_peri = @pg_fetch_array($XUXA,0);
						$fila_peri['promedio'];
						if($tipo_eval==2){
							if($fila_peri['notaap']=="0" or trim($fila_peri['notaap'])==""){
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])==""){
									$prome_1 = "&nbsp;";
									$prome_ap="&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);
										$prome_ap = round($fila_peri['notaap'],0);										
									} else {
										$prome_1 = $fila_peri['promedio'];
										$prome_ap = $fila_peri['notaap'];										
									}
								}
							}else{
								$prome_1=$fila_peri['promedio'];
								$prome_ap = $fila_peri['notaap'];										
							}
						}else{
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])=="" or ($fila['bool_ip']==0 and $chk_prom_taller==1)){
									$prome_1 = "&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);					
									} else {
										$prome_1 = $fila_peri['promedio'];					
									}
								}
								
						}
					} else { 
						$ob_reporte->nro_ano=$nro_ano;
						$ob_reporte ->alumno =$alumno;
						$ob_reporte ->ramo = $id_ramo;
						$rs_eximido = $ob_reporte->AlumnoEximido1($conn);
						@pg_numrows($rs_eximido);
						if(@pg_numrows($rs_eximido)==0 and $artistico!=1){
							//$prome_1="EX";
							if($sub_obli==1){
							  $prome_1= "EX";
							 }
							else{
							  $prome_1= "NO";
							 }
						}else{
							$prome_1 = "&nbsp;";
						}
						
						
						//$prome_1="&nbsp;";
						
					}
					
					if($tipo_eval==1){
					  	if($pos21=="100"){
					  		$prome_1 = $prom_pos;
					  	}
					}					
					 ///// acomulo promedio para mostrar al final ///
					if ($prome_1>0){
						
						$prome_semestral = $prome_semestral + $prome_1;
						$cuenta_semestral = $cuenta_semestral + 1;
						$prome_semestral_ap = $prome_semestral_ap + $prome_ap;
						
					}	
							
					
					if($_PERFIL==0){
						//echo "<br> promedios Apreciacion-->".$prome_semestral_ap;
						//echo "contador -->".$cuenta_semestral;
						//echo pg_numrows($XUXA);
					}
					?>
					<td align="center" class="subitem" rowspan="3"><strong><font color="<?php echo ($prome_1<40 && $prome_1>0 )?"#FF0000":"#000000" ?>" face="Arial, Helvetica, sans-serif" size="1">
<?php if($periodo == $periodos){
	if($opc_mprom==1){
		 if($prome_1<40 && $prome_1>0 ){ ?><? 
echo $prome_1 ?><? } else { echo $prome_1; }
	}
?>

<?php }

 else{?>
<? if($prome_1<40 && $prome_1>0 ){ ?><? 
echo $prome_1 ?><? } else { echo $prome_1; } ?> 
<?php }?>
</font></strong>

</td>
 <td  align="center" class="subitem" rowspan="3" >
  <font color="<?php echo ($prom_anual>0 && $prom_anual<40)?'#FF0000':"#000000" ?>" face="Arial, Helvetica, sans-serif" size="1"><b>
  <?php 
 
 
   $promporc = $ob_reporte->PromedioRamoAlumnoPeriodoGPond($conn); 
  echo $promporc = trim($promporc);
  $conc="";
  
 if($promporc>0){
  $promprc[$alumno][]=trim($promporc);
  	$ob_reporte->pminimo = $promporc;
	$ob_reporte->pmaximo = $promporc;
	$ob_reporte->tensenanza = $promporc;
	$ob_reporte->ense = $ense;
	$ob_reporte->nivel = $grado;
	$ob_reporte->subs = $subs;
	$ob_reporte->idp = $periodo;
	
	 $conc= $ob_reporte->getConcEscalaPorcentaje($conn);
 }
  ?>

				  
      </font><b></td>
                      <td  align="center" class="subitem" rowspan="3" ><b><font face="Arial, Helvetica, sans-serif" size="1"><?php 
					 echo $conc ;
					  ?>
				
				     </font><b></td>
<?php }?>
  <?
                if($tipo_rep==5){
					if($fila['coef2']==0){
						$sql="SELECT promedio,id_periodo, notaap FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND rut_alumno=".$alumno;
					}else{
						$sql="SELECT promedio,id_periodo FROM notacoef WHERE id_ramo=".$id_ramo." AND rut_alumno=".$alumno;
					
					}
						
						$rs_prom_anual = pg_exec($conn,$sql);
						$suma_anual = 0;
						$suma_anual1 = 0;
						$cont_anual = 0;
						$cont_conceptual=0;
						for($xx=0;$xx<pg_numrows($rs_prom_anual);$xx++){		
							$fila_anual =pg_fetch_array($rs_prom_anual,$xx);
							
							if($fila_anual['notaap']!=""){
								$prome_anual = $fila_anual['notaap'];
							}else{
								$prome_anual = $fila_anual['promedio'];
							}
							if($fila_anual['id_periodo'] <= $periodo){
								$suma_anual = $suma_anual + $prome_anual;
								if(intval($prome_anual)>0){
								$cont_anual++;
								}
								if($modo_eval==2 || $modo_eval==3){
									$suma_anual1=$suma_anual1 + Conceptual($fila_anual['promedio'],2);
									$cont_conceptual++;
									
								}
							}
							if($modo_eval==2 || $modo_eval==3){
									$prom_anual = Conceptual((round($suma_anual1 / $cont_conceptual)),1);
							}
							else{
								
								if($truncado_per==1){
								$prom_anual = round($suma_anual / $cont_anual);
								}else{
									$prom_anual = intval($suma_anual / $cont_anual);
								}
								//subir 1 punto cuando es 39 o 69
								if($prom_anual==69){
								$prom_anual =70;
								}
								if($prom_anual==39){
								$prom_anual =40;
								}
							}
						}
							if($bool_pgeneral==1 && intval($prom_anual)>0 && $modo_eval==1){ 
								$suma_prom_gral = $suma_prom_gral + $prom_anual;
							
							//if($modo_eval==1)
							 $cont_prom_gral++;
							}
							
						?>
				      <td  align="center" class="subitem" rowspan="3" ><font color="<?php echo ($prom_anual>0 && $prom_anual<40)?'#FF0000':"#000000" ?>"><b>
				        <? 
							echo ($cont_anual>0 || $cont_conceptual>0)?$prom_anual:"";?>
				      </font><b></td>
				      <? } ?>
					  <? if($institucion !=22743){/* ?>
                          <td align="center" width="17" rowspan="2"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
                          <?php if(pg_numrows($rs_grupo)==0){
                          echo "N/A";
                          }
						  else{
							  for($nog=1;$nog<=19;$nog++){
			   $sqlmp="select nota".$nog." from notas".$nro_ano." 
where rut_alumno=".$alumno." and id_ramo=".$id_ramo." and id_periodo=".$id_periodo." and nota".$nog." not in('','0')";
	$rnp = @pg_exec($conn,$sqlmp) or die("error asunto: ".$sqlmp);
	if(pg_numrows($rnp)>0){$cuentapuestas++;};
				}
							//echo $cuentagr."...".$cuentapuestas;
							echo $avance=round(($cuentapuestas*100)/ $cuentagr)."%";
							}
						  ?>
                          </strong></font></td> 
                       <? */} ?>
   
  </tr>
  <tr <?php echo $vista ?>>
   <?php if(pg_numrows($rs_grupo)==0){ ?>
    <?php  for($nog=1;$nog<=19;$nog++){ ?>
    <td colspan="" align="center" bgcolor="#ccc" ><font size="1" face="Arial, Helvetica, sans-serif">Nota</font></td>
    <td colspan="" align="center" bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif">%</font></td>
	<?php }
    }else{?>
     <?php  for($g=0;$g<pg_numrows($rs_grupo);$g++){
	   $cuentacols3=0;
	   
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   for($nog=1;$nog<=19;$nog++){
	   $ob_reporte->posicion=$nog;
	   $ob_reporte ->periodo=$periodo;
	   if($fila_grupo['nota'.$nog]==1){
	   $rs_pos = $ob_reporte->TraeNotaG($conn);
	   $cuentacols3++;?>
	   <td colspan="" align="center" bgcolor="#ccc" ><font size="1" face="Arial, Helvetica, sans-serif">Nota</font></td>
    <td colspan="" align="center" bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif">%</font></td>
    <?
      }
	   } }
	  ?>
       <?php if((38-($suesp*2))>0){?>
    <td colspan="<?php echo (38-($suesp*2)) ?>" bgcolor="#CCCCCC">&nbsp;</td>
    <?php }?>
   <?php  }?>
  
                      
  </tr>
  <?php if(pg_numrows($rs_grupo)==0){?>
  <tr class="subitem" <?php echo $vista ?>>
   <?php  for($nog=1;$nog<=19;$nog++){
	   $ob_reporte->posicion=$nog;
	   $ob_reporte ->periodo=$periodo;
	     $rs_pos = $ob_reporte->TraeNotaG($conn);
		 $rs_posG = $ob_reporte->TraeNotaGPond($conn);
		 $ng++;
		 
		 
       ?>
         <td width="17" class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_pos,0)<40 && pg_result($rs_pos,0)>0)?"#FF0000":"#000000" ?>" style="font-weight:bold"><?php echo (pg_result($rs_pos,0)!='0')?pg_result($rs_pos,0):"&nbsp;";
		
		  ?></font></td>
           <td width="17"  class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_posG,0)<$exigencia)?"#FF0000":"#999999" ?>" style="font-weight:bold"><b><?php echo (pg_result($rs_posG,0)!='101')?pg_result($rs_posG,0):"&nbsp;"; ?></b></font></td>
      <?php  }?>
      
  </tr>
  <?php }?>
  <tr <?php echo $vista ?>>
	  <?php if(pg_numrows($rs_grupo)>0){
      for($g=0;$g<pg_numrows($rs_grupo);$g++){
	   $cuentacols2=0;
	   
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   for($nog=1;$nog<=19;$nog++){
	   $ob_reporte->posicion=$nog;
	   $ob_reporte ->periodo=$periodo;
	   if($fila_grupo['nota'.$nog]==1){
	   $rs_pos = $ob_reporte->TraeNotaG($conn);
	   $rs_posG = $ob_reporte->TraeNotaGPond($conn);
	   $cuentacols2++;
	  
	   
	   ?>
      <td width="17" class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_pos,0)<40 && pg_result($rs_pos,0)>0)?"#FF0000":"#000000" ?>" > 
        <strong><font color="<?php echo (pg_result($rs_pos,0)<40 && pg_result($rs_pos,0)>0)?"#FF0000":"#000000" ?>" face="Arial, Helvetica, sans-serif" size="1" style="font-weight:bold">&nbsp;
        <?php //show($not[$alumno][$id_ramo]) 
		 if(pg_result($rs_pos,0)!='0'){
		 echo pg_result($rs_pos,0);
		
	}else{
		echo "&nbsp;";
		}
		?>
      </font></strong></font>
     
      </td>
	 
     
       <td width="17"  class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_posG,0)<$exigencia)?"#FF0000":"#000000" ?>" style="font-weight:bold"><b><?php echo (pg_result($rs_posG,0)!='101')?pg_result($rs_posG,0):"&nbsp;"; ?></b></font></td>
     
	 <?php
	  }?> 
     
     
     <?php }?>
     
      <?php }?>
     
	 
      <?php }?>
  <?php }
  
  //electivos
  ?>
  
   
  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $rdASIGNATURA;
		  $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->subsector=$rb_subsector; 
		  $ob_reporte ->formacion=2;
		  $ob_reporte ->todos = $rdASIGNATURA;
		  $ob_reporte ->incide = $rdASIGNATURA;
		  if($ck_alumnos==1){
			  $ob_reporte ->RamoAlumnoEximido($conn);
		  }else{
			  $ob_reporte ->RamoFormacion($conn);
		  }
		  
          $result =$ob_reporte ->result;
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
  <tr bgcolor="#ccc">
    <td colspan="<?php echo 39 ?>" class="item"><strong>Asignaturas (Formaci&oacute;n Diferenciada)<BR>
    </strong></td>
    <?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
		  $prome_semestral_ap=0;
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
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
		?>	
    <td width="17" class="subitem"><strong><font size="1" face="Arial, Helvetica, sans-serif">1&ordm;<? echo $tipo_per ?></font></strong></td>
  <?php  } 
  $tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			$tot_periodo = 2;
		
			?>
                    <td align="center" width="17"><strong><font size="1" face="Arial, Helvetica, sans-serif">2&ordm;<? echo $tipo_per ?></font></strong></td>
  <? }}
  if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>
               <td align="center" width="17"><strong><font size="1" face="Arial, Helvetica, sans-serif">3&ordm;<? echo $tipo_per ?></font></strong></td>
       <?php }}
        if($tipo_rep==5){ ?>
				          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br />
				            Anual</strong></font></td>
				          <? }
						  ?> 
                         <?php if($institucion !=22743){?>
                         <!-- <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>% Avance</strong></font></td> -->
          <?php }?>  
           <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>% <br />
				            Logro</strong></font></td>
                              <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Concepto</strong></font></td>                      
  </tr>
          <?
		  $prome_semestral = 0;
		  $cuenta_semestral =0;	
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];
				$incide_promo = $fila['bool_ip'];
				$artistico = $fila['bool_artis'];
				$bool_pgeneral=$fila['bool_pgeneral'];
				$truncado =$fila['truncado']; 
				$bool_tiene =$fila['bool_tiene'];
				$sub_obli =$fila['sub_obli']; 
				$cuentapuestas=0;
				$cuentagdr=0;  
//if($_PERFIL==0){echo "tiene->".$bool_tiene;}

				
				/////////////////////////PORCENTAJES//////////////
				$sql_pocentaje = "SELECT pos21 FROM nota_porcentaje$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$fila['id_ramo'];
			    $resp = @pg_exec($conn,$sql_pocentaje);
			    $pos21=@pg_result($resp,0);
			    ////////////////////////FIN PORCENTAJES///////////
				
				//traigo el grupo
				$ob_reporte->ramo=$fila['id_ramo'];
				$rs_grupo=$ob_reporte->TraeGrupoNotaPer($conn);
				
			?>
             <?
		  	$ob_reporte ->rut_alumno = $alumno;
			$ob_reporte ->ramo = $id_ramo;
			$ob_reporte ->periodo = $id_periodo;
			$result2 = $ob_reporte->Notas($conn);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (99)</B>');
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
				$ob_reporte ->modo_eval =$modo_eval;
				$ob_reporte ->CambiaNota($fila2);
				 $suesp=0;
				  $cuentaGrupos=0;
				  
				  $formula_p = $ob_reporte->formulaPadre($conn);
				if(pg_numrows($formula_p)>0){
				$padref[$alumno]['id_ramo'][]=$fila['id_ramo'];
				$padref[$alumno]['formula'][]=pg_result($formula_p,0);
				}
				
				$ob_reporte->ramo_hijo = $fila['id_ramo'];
				$vijo =$ob_reporte->formulaSoyHijo($conn);
				$vista = (pg_numrows($vijo)>a0)?'style="display:none"':"";
			?>
  <tr  <?php echo $vista ?>>
    <td rowspan="3" class="subitem" valign="middle" nowrap="nowrap" width="350" ><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
                      <?  echo $fila['nombre']; if($fila['bool_ip']==0) echo "(no incide en promoci&oacute;n)"; ?>
                      <?php echo (pg_numrows($formula_p)>0)?"(PROMEDIO)":""; ?>
                    
                     
                    </font></div></td>
   <?php if(pg_numrows($rs_grupo)==0){ ?> <td colspan="<?php echo 38 ?>" bgcolor="#ccc"><font size="1" face="Arial, Helvetica, sans-serif">100% Notas no agrupadas </font></td><?php } ?>
   <?php if(pg_numrows($rs_grupo)>0){
	  
	    ?>
   <?php for($g=0;$g<pg_numrows($rs_grupo);$g++){
	   $cuentacols=0;
	    $cuentaGrupos++;
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   
	   $cuentacols = ($fila_grupo['nota1']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota2']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota3']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota4']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota5']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota6']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota7']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota8']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota9']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota10']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota11']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota12']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota13']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota14']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota15']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota16']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota17']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota18']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota19']==1)?$cuentacols+1:$cuentacols;
	  // $cuentacols = ($fila_grupo['nota20']==1)?$cuentacols+1:$cuentacols;
	     $cuentagdr = $cuentagdr+$cuentacols;
	   
	 $suesp=$suesp+$cuentacols;
	 $rpos = 19- $suesp;
	 
	 $clpp = 6-$cuentacols;
	 
	 
	 //$cuentacols=($_PERFIL==0)?$cuentacols+$clpp:$cuentacols;
	 // $cuentacols=$cuentacols+$clpp;
	  
	
	   
	   ?>
    <td colspan="<?php echo ($cuentacols*2) ?>" bgcolor="#ccc"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $fila_grupo['porcentaje'] ?>% - <?php echo strtoupper($fila_grupo['nombre']) ?>&nbsp;</font> </td><?php ?>
    <?php //si me queda espacio?>
	<?php } ?> 
    <?php if((19-$suesp)>0){?>
    <td colspan="<?php echo (30-($suesp*2)) ?>" bgcolor="#CCCCCC">&nbsp;</td>
    <?php }?>
	<? } ?> 
    
   <?
				////aucmulo promedio////
				$prom_pos = $pos1+$pos2+$pos3+$pos4+$pos5+$pos6+$pos7+$pos8+$pos9+$pos10+$pos11+$pos12+$pos13+$pos14+$pos15+$pos16+$pos17+$pos18+$pos19;					
				/////fin//////	
				
				
				$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				//$prome_semestral_ap=0;
				
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					//if($_PERFIL==0) echo "<br>".$periodos;
					$prome_ap=0;	
					$prome_abajo_ap=0;	
																																																				//-------			
																																																						
					/*$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->ano=$ano;
					$ob_reporte ->institucion=$institucion;
					$ob_reporte ->bool_ar=0; 
					$result_tiene = $ob_reporte->AlumnosTiene($conn);*/
					
					$rs_notas =0;
					$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->periodo = $periodos;								 																																					
					$XUXA =$ob_reporte->Notas($conn);
					pg_dbname($conn);
					if (pg_numrows($XUXA)>0){ 
						$fila_peri = @pg_fetch_array($XUXA,0);
						$fila_peri['promedio'];
						if($tipo_eval==2){
							if($fila_peri['notaap']=="0" or trim($fila_peri['notaap'])==""){
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])==""){
									$prome_1 = "&nbsp;";
									$prome_ap="&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);
										$prome_ap = round($fila_peri['notaap'],0);										
									} else {
										$prome_1 = $fila_peri['promedio'];
										$prome_ap = $fila_peri['notaap'];										
									}
								}
							}else{
								$prome_1=$fila_peri['promedio'];
								$prome_ap = $fila_peri['notaap'];										
							}
						}else{
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])=="" or ($fila['bool_ip']==0 and $chk_prom_taller==1)){
									$prome_1 = "&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);					
									} else {
										$prome_1 = $fila_peri['promedio'];					
									}
								}
								
						}
					} else { 
						$ob_reporte->nro_ano=$nro_ano;
						$ob_reporte ->alumno =$alumno;
						$ob_reporte ->ramo = $id_ramo;
						$rs_eximido = $ob_reporte->AlumnoEximido1($conn);
						@pg_numrows($rs_eximido);
						if(@pg_numrows($rs_eximido)==0 and $artistico!=1){
							//$prome_1="EX";
							if($sub_obli==1){
							  $prome_1= "EX";
							 }
							else{
							  $prome_1= "NO";
							 }
						}else{
							$prome_1 = "&nbsp;";
						}
						
						
						//$prome_1="&nbsp;";
						
					}
					
					if($tipo_eval==1){
					  	if($pos21=="100"){
					  		$prome_1 = $prom_pos;
					  	}
					}					
					 ///// acomulo promedio para mostrar al final ///
					if ($prome_1>0){
						
						$prome_semestral = $prome_semestral + $prome_1;
						$cuenta_semestral = $cuenta_semestral + 1;
						$prome_semestral_ap = $prome_semestral_ap + $prome_ap;
						
					}	
							
					
					/*if($_PERFIL==0){
						echo "<br> promedios Apreciacion-->".$prome_semestral_ap;
						echo "contador -->".$cuenta_semestral;
					}*/
					?>
					<td align="center" class="subitem" rowspan="3"><strong><font color="<?php echo ($prome_1<40 && $prome_1>0 )?"#FF0000":"#000000" ?>" face="Arial, Helvetica, sans-serif" size="1">
		<?php if($periodo == $periodos){
	if($opc_mprom==1){
		 if($prome_1<40 && $prome_1>0 ){ ?><? 
echo $prome_1 ?><? } else { echo $prome_1; }
	}
?>

<?php }

 else{?>
<? if($prome_1<40 && $prome_1>0 ){ ?><? 
echo $prome_1 ?><? } else { echo $prome_1; } ?> 
<?php }?>
        
        </font></strong></td>
        
         <td  align="center" class="subitem" rowspan="3" ><font color="<?php echo ($prom_anual>0 && $prom_anual<40)?'#FF0000':"#000000" ?>"><b>
				   <?php 
 
 $promporc = $ob_reporte->PromedioRamoAlumnoPeriodoGPond($conn); 
  echo $promporc = trim($promporc);
  
  
 if($promporc>0){
	 $ob_reporte->pminimo = $promporc;
	$ob_reporte->pmaximo = $promporc;
	$ob_reporte->tensenanza = $promporc;
	$ob_reporte->ense = $ense;
	$ob_reporte->nivel = $grado;
	$ob_reporte->subs = $subs;
	$ob_reporte->idp = $periodo;
	
	 $conc= $ob_reporte->getConcEscalaPorcentaje($conn);
  $promprc[$alumno][]=trim($promporc);
 }?>
				      </font><b></td>
                      <td  align="center" class="subitem" rowspan="3" ><font color="<?php echo ($prom_anual>0 && $prom_anual<40)?'#FF0000':"#000000" ?>"><b>
				 <?php 
					 echo $conc ;
					  ?>
				      </font><b></td>
<?php }?>
  <?
                if($tipo_rep==5){
					if($fila['coef2']==0){
						$sql="SELECT promedio,id_periodo, notaap FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND rut_alumno=".$alumno;
					}else{
						$sql="SELECT promedio,id_periodo FROM notacoef WHERE id_ramo=".$id_ramo." AND rut_alumno=".$alumno;
					
					}
						
						$rs_prom_anual = pg_exec($conn,$sql);
						$suma_anual = 0;
						$suma_anual1 = 0;
						$cont_anual = 0;
						$cont_conceptual=0;
						for($xx=0;$xx<pg_numrows($rs_prom_anual);$xx++){		
							$fila_anual =pg_fetch_array($rs_prom_anual,$xx);
							
							if($fila_anual['notaap']!=""){
								$prome_anual = $fila_anual['notaap'];
							}else{
								$prome_anual = $fila_anual['promedio'];
							}
							if($fila_anual['id_periodo'] <= $periodo){
								$suma_anual = $suma_anual + $prome_anual;
								if(intval($prome_anual)>0){
								$cont_anual++;
								}
								if($modo_eval==2 || $modo_eval==3){
									$suma_anual1=$suma_anual1 + Conceptual($fila_anual['promedio'],2);
									$cont_conceptual++;
									
								}
							}
							if($modo_eval==2 || $modo_eval==3){
									$prom_anual = Conceptual((round($suma_anual1 / $cont_conceptual)),1);
							}
							else{
								
								if($truncado_per==1){
								$prom_anual = round($suma_anual / $cont_anual);
								}else{
									$prom_anual = intval($suma_anual / $cont_anual);
								}
							}
						}
						
						if($prom_anual==69){
								$prom_anual =70;
								}
								if($prom_anual==39){
								$prom_anual =40;
								}
						
							if($bool_pgeneral==1 && intval($prom_anual)>0 && $modo_eval==1){ 
								$suma_prom_gral = $suma_prom_gral + $prom_anual;
							
							//if($modo_eval==1)
							 $cont_prom_gral++;
							}
							
						?>
				      <td  align="center" class="subitem" rowspan="3" ><font color="<?php echo ($prom_anual>0 && $prom_anual<40)?'#FF0000':"#000000" ?>" style="font-weight:bold"><b>
				        <? 
							echo ($cont_anual>0 || $cont_conceptual>0)?$prom_anual:"";?><b>
				      </font></td>
				      <? } ?>
                     <?php if($institucion !=22743){/*?>
                          <td align="center" width="17" rowspan="2"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
                            <?php if(pg_numrows($rs_grupo)==0){
                          echo "N/A";
                          }
						  else{
							  for($nog=1;$nog<=19;$nog++){
			   $sqlmp="select nota".$nog." from notas".$nro_ano." 
where rut_alumno=".$alumno." and id_ramo=".$id_ramo." and id_periodo=".$id_periodo." and nota".$nog." not in('','0')";
	$rnp = @pg_exec($conn,$sqlmp) or die("error asunto: ".$sqlmp);
	if(pg_numrows($rnp)>0){$cuentapuestas++;};
				}
							//echo $cuentagdr."...".$cuentapuestas;
							echo $avance=round(($cuentapuestas*100)/ $cuentagdr)."%";
							}
						  ?>
                          </strong></font></td> 
                     <?php */}?>   
   
  </tr>
  <tr  <?php echo $vista ?>>
  
   <?php if(pg_numrows($rs_grupo)==0){ ?>
    <?php  for($nog=1;$nog<=19;$nog++){ ?>
    <td colspan="" align="center" bgcolor="#ccc" ><font size="1" face="Arial, Helvetica, sans-serif">Nota</font></td>
    <td colspan="" align="center" bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif">%</font></td>
	<?php }
    }else{?>
     <?php  for($g=0;$g<pg_numrows($rs_grupo);$g++){
	   $cuentacols3=0;
	   
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   for($nog=1;$nog<=19;$nog++){
	   $ob_reporte->posicion=$nog;
	   $ob_reporte ->periodo=$periodo;
	   if($fila_grupo['nota'.$nog]==1){
	   $rs_pos = $ob_reporte->TraeNotaG($conn);
	   $cuentacols3++;?>
	   <td colspan="" align="center" bgcolor="#ccc" ><font size="1" face="Arial, Helvetica, sans-serif">Nota</font></td>
    <td colspan="" align="center" bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif">%</font></td>
    <?
      }
	   } }
	  ?>
       <?php if((38-($suesp*2))>0){?>
    <td colspan="<?php echo (38-($suesp*2)) ?>" bgcolor="#CCCCCC">&nbsp;</td>
    <?php }?>
   <?php  }?>
   

  <?php if(pg_numrows($rs_grupo)==0){?>
  <tr class="subitem" <?php echo $vista ?>>
  
   <?php  for($nog=1;$nog<=19;$nog++){
	   $ob_reporte->posicion=$nog;
	   $ob_reporte ->periodo=$periodo;
	     $rs_pos = $ob_reporte->TraeNotaG($conn);
		 $rs_posG = $ob_reporte->TraeNotaGPond($conn);
		 
		 $ng++;
       ?>
         <td width="17"  class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_pos,0)<40 && pg_result($rs_pos,0)>0)?"#FF0000":"#000000" ?>" style="font-weight:bold"><b><?php echo (pg_result($rs_pos,0)!='0')?pg_result($rs_pos,0):"&nbsp;"; ?></b></font></td>
          <td width="17"  class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_posG,0)<$exigencia)?"#FF0000":"#000000" ?>" style="font-weight:bold"><b><?php echo (pg_result($rs_posG,0)!='101')?pg_result($rs_posG,0):"&nbsp;"; ?></b></font></td>
      <?php  }?>
      
      
  </tr>
  <?php }?>
  <tr <?php echo $vista ?>>
	  <?php if(pg_numrows($rs_grupo)>0){
      for($g=0;$g<pg_numrows($rs_grupo);$g++){
	   $cuentacols2=0;
	   
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   for($nog=1;$nog<=19;$nog++){
	   $ob_reporte->posicion=$nog;
	   $ob_reporte ->periodo=$periodo;
	   if($fila_grupo['nota'.$nog]==1){
	   $rs_pos = $ob_reporte->TraeNotaG($conn);
	    $rs_posG = $ob_reporte->TraeNotaGPond($conn);
	   $cuentacols2++;
	   
	   ?>
    <td width="350" class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_pos,0)<40 && pg_result($rs_pos,0)>0)?"#FF0000":"#000000" ?>" style="font-weight:bold" ><b><?php echo (pg_result($rs_pos,0)!='0')?pg_result($rs_pos,0):"&nbsp;"; ?></b></font>
    </td>
	 <td width="17"  class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_posG,0)<$exigencia)?"#FF0000":"#000000" ?>" style="font-weight:bold"><b><?php echo (pg_result($rs_posG,0)!='101')?pg_result($rs_posG,0):"&nbsp;"; ?></b></font></td>
	 <?php
	  }?> 
     
     
     <?php }?>
     
      <?php }?>
     
	  
      <?php }?>
  <?php } //fin electivos?>
	
    <?php }?>
	
     
     
  
  <tr bgcolor="#ccc" >
    <td colspan="<?php echo 39 ?>" class="item"><strong>Promedio General</strong></td>
    <? 
	$ob_reporte ->ano =$ano;
	$resultPer =$ob_reporte ->TotalPeriodo($conn);
	for($per=0 ; $per < $tot_periodo ; $per++){	
		$prome_abajo_ap=0;			
		$filaperi = @pg_fetch_array($resultPer,$per);	
		$periodos = $filaperi['id_periodo'];
		$ob_reporte ->nro_ano 	= $nro_ano;
		$ob_reporte ->periodos 	= $filaperi['id_periodo'];
		$ob_reporte ->alumno 	= $alumno;
		if($rb_subsector==0){
			$ob_reporte ->PromedioAlumno($conn);
		}else{
			$ob_reporte ->PromedioAlumnoSubNoValido($conn);
		}
		//if($_PERFIL==0) echo "<br>".$ob_reporte->sql;
		if($truncado_semestre==0){
			$prome_abajo = @intval($ob_reporte->suma / $ob_reporte->contador);
			//$prome_abajo = intval($prome_semestral / $cuenta_semestral);
			@$prome_abajo_ap = intval($ob_reporte->sumaAP / $cuenta_semestral_ap);
		}else{
			$prome_abajo = @round($ob_reporte->suma / $ob_reporte->contador,0);
			//$prome_abajo = round($prome_semestral / $cuenta_semestral);
			$prome_abajo_ap = @round($ob_reporte->sumaAP / $cuenta_semestral_ap);
		}
		if($_PERFIL==0) {
			
			echo $ob_reporte->suma;
			echo "<br>".$ob_reporte->contador;
			//echo "<br>".$ob_reporte->sql;
			}
		/*$ob_reporte->curso=$curso;
		$ob_reporte->suma=$ob_reporte->suma;
		$ob_reporte->contador=$ob_reporte->contador;
		$ob_reporte->tipo=2;
		$ob_reporte->ConfigPromedios($conn);
		$prome_abajo = $ob_reporte->promedio;*/
		$prome_colilla = $prome_abajo;
	
	if($institucion==1914 OR $institucion==40251){
		if($periodos==$periodo){?>
			<td align="center" bgcolor="#ccc"><strong><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo ($prome_abajo<40 && $prome_abajo>0 )?"#FF0000":"#000000" ?>">
            <?php if($periodo == $periodos){
	if($opc_mprom==1){?>
		    <? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?>
            <?php }
			else{echo "";}
			}?>
			</font></strong></td>
	<? }
	}else{ ?>
	<td align="center" bgcolor="#ccc"><strong><font size="1" face="Arial, Helvetica, sans-serif"  color="<?php echo ($prome_abajo<40 && $prome_abajo>0 )?"#FF0000":"#000000" ?>">
	 <?php if($periodo == $periodos){
	if($opc_mprom==1){?>
		    <? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?>
            <?php }
			else{echo "&nbsp;";}
			}else{?>
            <? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?>
            <?php }?>
	</font></strong></td>	
     
	<? }
	
		
	
	}
	
    if($tipo_rep==5){ 
	
	$trc = ($truncado_final==1)?round:intval;
	
			$prom_gral_anual = $trc($suma_prom_gral / $cont_prom_gral);?>
				          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><b><? echo $prom_gral_anual;?> </b>
                          <?php // if($_PERFIL==0){echo $suma_prom_gral."--".$cont_prom_gral;} ?>
                          </font></td>
				          <? 	}
	// FIN FOR PERIODO DE PROMEDIOS ?>
     <?php if($institucion !=22743){?>
                        <!--  <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong></strong></font></td> -->
                   <?php }?>   
                    <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
                           <?php  
						   
						   $trcPorc = ($truncado_final==1)?round:intval;
						   echo $trcPorc(array_sum($promprc[$alumno])/count($promprc[$alumno]));?>
                           </strong></font>
    </td>
                              <td align="center" width="17">&nbsp;</td>  
  </tr>
  <?php if(count($padref[$alumno])>0){
	 // $scol=($tipo_rep==5)?($tabmax*6)+2+$num_periodos:($tabmax*6)+1+$num_periodos;
	  $scol=23+19;
	  ?>
  <tr  >
    <td colspan="<?php echo $scol ?>"  class="item" height="30">&nbsp;</td>
  </tr>
<?php   
  for($fp=0;$fp<count($padref[$alumno]);$fp++){ 

$ob_reporte->ramo = $padref[$alumno]['id_ramo'][$fp];
$nomram = $ob_reporte->ramoUNO($conn);

$ob_reporte->formula =$padref[$alumno]['formula'][$fp]; 
$result =  $ob_reporte->formulahijo($conn);

$cuentapuestas=0;
$cuentagr=0;
?>
<tr bgcolor="#ccc">
    <td colspan="<?php echo 39 ?>" class="item" width="350"><strong>Promedio de notas a <?php echo pg_result($nomram,1); ?>
    </strong></td>
     <?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
		  $prome_semestral_ap=0;
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
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
		?>	
    <td width="17" class="subitem"><strong><font size="1" face="Arial, Helvetica, sans-serif">1&ordm;<? echo $tipo_per ?></font></strong></td>
  <?php  } 
  $tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			$tot_periodo = 2;
		
			?>
                    <td align="center" width="17"><strong><font size="1" face="Arial, Helvetica, sans-serif">2&ordm;<? echo $tipo_per ?></font></strong></td>
  <? }}
  if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>
               <td align="center" width="17"><strong><font size="1" face="Arial, Helvetica, sans-serif">3&ordm;<? echo $tipo_per ?></font></strong></td>
       <?php }}
        if($tipo_rep==5){ ?>
				          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br />
				            Anual</strong></font></td>
				          <? }
						  ?>  
                          <? if($institucion !=22743){ ?>
                        <!--  <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>% Avance</strong></font></td> -->
						  <? } ?>
                           <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>% <br />
				            Logro</strong></font></td>
                              <td align="center" width="17"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Concepto</strong></font></td>
  </tr>
  <?
		  $prome_semestral = 0;
		  $cuenta_semestral =0;	
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];
				$incide_promo = $fila['bool_ip'];
				$artistico = $fila['bool_artis'];
				$bool_pgeneral=$fila['bool_pgeneral'];
				$truncado =$fila['truncado']; 
				$bool_tiene =$fila['bool_tiene'];
				$sub_obli =$fila['sub_obli'];  
//if($_PERFIL==0){echo "tiene->".$bool_tiene;}
				
				/////////////////////////PORCENTAJES//////////////
				$sql_pocentaje = "SELECT pos21 FROM nota_porcentaje$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$fila['id_ramo'];
			    $resp = @pg_exec($conn,$sql_pocentaje);
			    $pos21=@pg_result($resp,0);
			    ////////////////////////FIN PORCENTAJES///////////
				
				//traigo el grupo
				$ob_reporte->ramo=$fila['id_ramo'];
				$rs_grupo=$ob_reporte->TraeGrupoNotaPer($conn);
				
			?>
             <?
		  	$ob_reporte ->rut_alumno = $alumno;
			$ob_reporte ->ramo = $id_ramo;
			$ob_reporte ->periodo = $id_periodo;
			$result2 = $ob_reporte->Notas($conn);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (99)</B>');
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
				$ob_reporte ->modo_eval =$modo_eval;
				$ob_reporte ->CambiaNota($fila2);
				 $suesp=0;
				  $cuentaGrupos=0;
				 
			?>
  <tr>
    <td rowspan="3" class="subitem" valign="middle" nowrap="nowrap" width="200" ><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
                      <?  echo $fila['nombre'];  ?>
                    
                     
                    </font></div></td>
   <?php if(pg_numrows($rs_grupo)==0){ ?> <td colspan="<?php echo 38 ?>" bgcolor="#ccc"><font size="1" face="Arial, Helvetica, sans-serif">100% Notas no agrupadas </font></td><?php } ?>
   <?php if(pg_numrows($rs_grupo)>0){
	  
	    ?>
   <?php for($g=0;$g<pg_numrows($rs_grupo);$g++){
	   $cuentacols=0;
	    $cuentaGrupos++;
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   
	   $cuentacols = ($fila_grupo['nota1']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota2']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota3']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota4']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota5']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota6']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota7']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota8']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota9']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota10']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota11']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota12']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota13']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota14']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota15']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota16']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota17']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota18']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota19']==1)?$cuentacols+1:$cuentacols;
	  // $cuentacols = ($fila_grupo['nota20']==1)?$cuentacols+1:$cuentacols;
	   
	   
	 $suesp=$suesp+$cuentacols;
	 $rpos = 19- $suesp;
	 
	 $clpp = 6-$cuentacols;
	  $cuentagr = $cuentagr+$cuentacols;
	 
	 
	 //$cuentacols=($_PERFIL==0)?$cuentacols+$clpp:$cuentacols;
	//  $cuentacols=$cuentacols+$clpp;
	   
	   ?>
    <td colspan="<?php echo $cuentacols ?>" bgcolor="#ccc"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $fila_grupo['porcentaje'] ?>% - <?php echo strtoupper($fila_grupo['nombre']) ?>&nbsp;</font> </td><?php ?>
    <?php //si me queda espacio?>
	<?php } 
     if((19-$suesp)>0){?>
    <td colspan="<?php echo (19-$suesp) ?>" bgcolor="#CCCCCC">&nbsp;</td>
    <?php }?>
	<? } ?> 
    
   <?
				////aucmulo promedio////
				$prom_pos = $pos1+$pos2+$pos3+$pos4+$pos5+$pos6+$pos7+$pos8+$pos9+$pos10+$pos11+$pos12+$pos13+$pos14+$pos15+$pos16+$pos17+$pos18+$pos19;					
				/////fin//////	
				
				
				$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				//$prome_semestral_ap=0;
				
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					//if($_PERFIL==0) echo "<br>".$periodos;
					$prome_ap=0;	
					$prome_abajo_ap=0;	
																																																				//-------			
																																																						
					/*$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->ano=$ano;
					$ob_reporte ->institucion=$institucion;
					$ob_reporte ->bool_ar=0; 
					$result_tiene = $ob_reporte->AlumnosTiene($conn);*/
					
					$rs_notas =0;
					$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->periodo = $periodos;								 																																					
					$XUXA =$ob_reporte->Notas($conn);
					pg_dbname($conn);
					if (pg_numrows($XUXA)>0){ 
						$fila_peri = @pg_fetch_array($XUXA,0);
						$fila_peri['promedio'];
						if($tipo_eval==2){
							if($fila_peri['notaap']=="0" or trim($fila_peri['notaap'])==""){
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])==""){
									$prome_1 = "&nbsp;";
									$prome_ap="&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);
										$prome_ap = round($fila_peri['notaap'],0);										
									} else {
										$prome_1 = $fila_peri['promedio'];
										$prome_ap = $fila_peri['notaap'];										
									}
								}
							}else{
								$prome_1=$fila_peri['promedio'];
								$prome_ap = $fila_peri['notaap'];										
							}
						}else{
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])=="" or ($fila['bool_ip']==0 and $chk_prom_taller==1)){
									$prome_1 = "&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);					
									} else {
										$prome_1 = $fila_peri['promedio'];					
									}
								}
								
						}
					} else { 
						$ob_reporte->nro_ano=$nro_ano;
						$ob_reporte ->alumno =$alumno;
						$ob_reporte ->ramo = $id_ramo;
						$rs_eximido = $ob_reporte->AlumnoEximido1($conn);
						@pg_numrows($rs_eximido);
						if(@pg_numrows($rs_eximido)==0 and $artistico!=1){
							//$prome_1="EX";
							if($sub_obli==1){
							  $prome_1= "EX";
							 }
							else{
							  $prome_1= "NO";
							 }
						}else{
							$prome_1 = "&nbsp;";
						}
						
						
						//$prome_1="&nbsp;";
						
					}
					
					if($tipo_eval==1){
					  	if($pos21=="100"){
					  		$prome_1 = $prom_pos;
					  	}
					}					
					 ///// acomulo promedio para mostrar al final ///
					if ($prome_1>0){
						
						$prome_semestral = $prome_semestral + $prome_1;
						$cuenta_semestral = $cuenta_semestral + 1;
						$prome_semestral_ap = $prome_semestral_ap + $prome_ap;
						
					}	
							
					
					/*if($_PERFIL==0){
						echo "<br> promedios Apreciacion-->".$prome_semestral_ap;
						echo "contador -->".$cuenta_semestral;
					}*/
					?>
					<td align="center" class="subitem" rowspan="3"><strong><font color="<?php echo ($prome_1<40 && $prome_1>0 )?"#FF0000":"#000000" ?>" face="Arial, Helvetica, sans-serif" size="1">
		<?php if($periodo == $periodos){
	if($opc_mprom==1){
		 if($prome_1<40 && $prome_1>0 ){ ?><? 
echo $prome_1 ?><? } else { echo $prome_1; }
	}
?>

<?php }

 else{?>
<? if($prome_1<40 && $prome_1>0 ){ ?><? 
echo $prome_1 ?><? } else { echo $prome_1; } ?> 
<?php }?>
        
        </font></strong></td>
        
       <td  align="center" class="subitem" rowspan="3" ><font color="<?php echo ($prom_anual>0 && $prom_anual<40)?'#FF0000':"#000000" ?>"><b></font><font color="<?php echo ($prom_anual>0 && $prom_anual<40)?'#FF0000':"#000000" ?>">
         <?php 
 
 $promporc = $ob_reporte->PromedioRamoAlumnoPeriodoGPond($conn); 
  echo $promporc = trim($promporc);
  
  
 if($promporc>0){
	 $ob_reporte->pminimo = $promporc;
	$ob_reporte->pmaximo = $promporc;
	$ob_reporte->tensenanza = $promporc;
	$ob_reporte->ense = $ense;
	$ob_reporte->nivel = $grado;
	$ob_reporte->subs = $subs;
	$ob_reporte->idp = $periodo;
	
	 $conc= $ob_reporte->getConcEscalaPorcentaje($conn);
 
 }?>
       </font><b></td>
                      <td  align="center" class="subitem" rowspan="3" ><font color="<?php echo ($prom_anual>0 && $prom_anual<40)?'#FF0000':"#000000" ?>"><b></font><font color="<?php echo ($prom_anual>0 && $prom_anual<40)?'#FF0000':"#000000" ?>">
                        <?php 
					 echo $conc ;
					  ?>
                      </font><b></td>
<?php }?>
  <?
                if($tipo_rep==5){
					if($fila['coef2']==0){
						$sql="SELECT promedio,id_periodo, notaap FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND rut_alumno=".$alumno;
					}else{
						$sql="SELECT promedio,id_periodo FROM notacoef WHERE id_ramo=".$id_ramo." AND rut_alumno=".$alumno;
					
					}
						
						$rs_prom_anual = pg_exec($conn,$sql);
						$suma_anual = 0;
						$suma_anual1 = 0;
						$cont_anual = 0;
						$cont_conceptual=0;
						for($xx=0;$xx<pg_numrows($rs_prom_anual);$xx++){		
							$fila_anual =pg_fetch_array($rs_prom_anual,$xx);
							
							if($fila_anual['notaap']!=""){
								$prome_anual = $fila_anual['notaap'];
							}else{
								$prome_anual = $fila_anual['promedio'];
							}
							if($fila_anual['id_periodo'] <= $periodo){
								$suma_anual = $suma_anual + $prome_anual;
								if(intval($prome_anual)>0){
								$cont_anual++;
								}
								if($modo_eval==2 || $modo_eval==3){
									$suma_anual1=$suma_anual1 + Conceptual($fila_anual['promedio'],2);
									$cont_conceptual++;
									
								}
							}
							if($modo_eval==2 || $modo_eval==3){
									$prom_anual = Conceptual((round($suma_anual1 / $cont_conceptual)),1);
							}
							else{
								
								if($truncado_per==1){
								$prom_anual = round($suma_anual / $cont_anual);
								}else{
									$prom_anual = intval($suma_anual / $cont_anual);
								}
							}
						}
							if($bool_pgeneral==1 && intval($prom_anual)>0 && $modo_eval==1){ 
								$suma_prom_gral = $suma_prom_gral + $prom_anual;
							
							//if($modo_eval==1)
							 $cont_prom_gral++;
							}
							
						?>
				      <td  align="center" class="subitem" rowspan="3" ><font color="<?php echo ($prom_anual>0 && $prom_anual<40)?'#FF0000':"#000000" ?>"><b>
				        <? 
							echo ($cont_anual>0 || $cont_conceptual>0)?$prom_anual:"";?><b>
				      </font></td>
				      <? } ?>
                     <?php if($institucion !=22743){/*?>
                          <td align="center" width="17" rowspan="2"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
                            <?php if(pg_numrows($rs_grupo)==0){
                          echo "N/A";
                          }
						  else{
							  for($nog=1;$nog<=19;$nog++){
			   $sqlmp="select nota".$nog." from notas".$nro_ano." 
where rut_alumno=".$alumno." and id_ramo=".$id_ramo." and id_periodo=".$id_periodo." and nota".$nog." not in('','0')";
	$rnp = @pg_exec($conn,$sqlmp) or die("error asunto: ".$sqlmp);
	if(pg_numrows($rnp)>0){$cuentapuestas++;};
				}
							//echo $cuentagr."...".$cuentapuestas;
							echo $avance=round(($cuentapuestas*100)/ $cuentagr)."%";
							}
						  ?>
                          </strong></font></td> 
                     <?php */}?>   
   
  </tr>
  <tr>
  <?php if(pg_numrows($rs_grupo)==0){ ?>
    <?php  for($nog=1;$nog<=19;$nog++){ ?>
    <td colspan="" align="center" bgcolor="#ccc" ><font size="1" face="Arial, Helvetica, sans-serif">Nota</font></td>
    <td colspan="" align="center" bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif">%</font></td>
	<?php }
    }else{?>
     <?php  for($g=0;$g<pg_numrows($rs_grupo);$g++){
	   $cuentacols3=0;
	   
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   for($nog=1;$nog<=19;$nog++){
	   $ob_reporte->posicion=$nog;
	   $ob_reporte ->periodo=$periodo;
	   if($fila_grupo['nota'.$nog]==1){
	   $rs_pos = $ob_reporte->TraeNotaG($conn);
	   $cuentacols3++;?>
	   <td colspan="" align="center" bgcolor="#ccc" ><font size="1" face="Arial, Helvetica, sans-serif">Nota</font></td>
    <td colspan="" align="center" bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif">%</font></td>
    <?
      }
	   } }
	  ?>
       <?php if((38-($suesp*2))>0){?>
    <td colspan="<?php echo (38-($suesp*2)) ?>" bgcolor="#CCCCCC">&nbsp;</td>
    <?php }?>
   <?php  }?>
   
    
  </tr>
  <?php if(pg_numrows($rs_grupo)==0){?>
  <tr class="subitem">
   <?php  for($nog=1;$nog<=19;$nog++){
	   $ob_reporte->posicion=$nog;
	   $ob_reporte ->periodo=$periodo;
	     $rs_pos = $ob_reporte->TraeNotaG($conn);
		  $rs_posG = $ob_reporte->TraeNotaGPond($conn);
		 $ng++;
       ?>
         <td width="17"  class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_pos,0)<40 && pg_result($rs_pos,0)>0)?"#FF0000":"#000000" ?>" style="font-weight:bold"><?php echo (pg_result($rs_pos,0)!='0')?pg_result($rs_pos,0):"&nbsp;"; ?></font>&nbsp;</td>
          <td width="17"  class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_posG,0)<$exigencia)?"#FF0000":"#000000" ?>" style="font-weight:bold"><b><?php echo (pg_result($rs_posG,0)!='101')?pg_result($rs_posG,0):"&nbsp;"; ?></b></font></td>
      <?php  }?>
      
      
  </tr>
  <?php }?>
  <tr>
	  <?php if(pg_numrows($rs_grupo)>0){
      for($g=0;$g<pg_numrows($rs_grupo);$g++){
	   $cuentacols2=0;
	   
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   for($nog=1;$nog<=19;$nog++){
	   $ob_reporte->posicion=$nog;
	   $ob_reporte ->periodo=$periodo;
	   if($fila_grupo['nota'.$nog]==1){
	   $rs_pos = $ob_reporte->TraeNotaG($conn);
	    $rs_posG = $ob_reporte->TraeNotaGPond($conn);
	   $cuentacols2++;
	   
	   ?>
    <td width="17" class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_pos,0)<40 && pg_result($rs_pos,0)>0)?"#FF0000":"#000000" ?>" ><b><?php echo (pg_result($rs_pos,0)!='0')?pg_result($rs_pos,0):"&nbsp;"; ?></b></font>
    </td>
	  <td width="17"  class="subitem" align="center" valign="middle" style="width:30px !important"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_posG,0)<$exigencia)?"#FF0000":"#000000" ?>" style="font-weight:bold"><b><?php echo (pg_result($rs_posG,0)!='101')?pg_result($rs_posG,0):"&nbsp;"; ?></b></font></td>
	 <?php
	  }?> 
     
     
     <?php }?>
     
      <?php }?>
     
	  <?php
	   if((19-$suesp)>0){?>
    <td colspan="<?php echo (19-$suesp) ?>" style="width:30px !important">&nbsp;</td>
    <?php }?>
      
      <?php }?>
<?
  }
  }
  ?>
  
  <?php }?>
  
</table>

<br />
<br />
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
    
		<td width="175"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS PERIODO </strong></font></td>
		<td width="206"><font size="1" face="Arial, Helvetica, sans-serif">
		 <? // if($_PERFIL==0){
			
			 
				if($fila_alu['fecha'] <= $fecha_ini)
				{$finip= $fecha_ini;
					$dias_habiles = $ob_reporte->dias_habiles;
					
				}
				else
				{
					
					$finip= $fila_alu['fecha'];
					
					
					$ob_reporte->fecha_ini2 = $finip;
					$ob_reporte->fecha2 = $fecha_fin;
					$rs_feriadosem = $ob_reporte->DiaHabil3($conn);
					$fers=0;
					
					for($ff=0;$ff<pg_numrows($rs_feriadosem);$ff++){
					$fila_feriadosem =pg_fetch_array($rs_feriadosem,$ff);
					
					$inciof= $fila_feriadosem['fecha_inicio'];
					
				
					
					if($fila_feriadosem['fecha_fin']==NULL)
					{
						 $finf=$inciof ;
						
					}else{
					
						$finf= $fila_feriadosem['fecha_fin'];
					}
					
					 $fers=$fers+$dif_dias =ddiff($inciof, $finf);
					
					}
					
					$feriados_sem=$fers;
					
				
					$dias_entre = hbl($fila_alu['fecha'],$fecha_fin);
					$dias_habiles=$dias_entre-$feriados_sem;
					
				}
					
					
					
				//} 
				
		  ?>
		
		<? echo $dias_habiles ?> </font></td>
       
         <?php  if($chk_totdinas==1){?>
		<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS INASISTENTES</strong></font></td>
		<td width="97"><font size="1" face="Arial, Helvetica, sans-serif"><?=$inasistencia ?></font></td>
        <?php }?>
	  </tr>
	  <tr>
        <?php  if($chk_prcas==1){?>
		<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIA PERIODO (%)</strong></font></td>
		<td><font size="1" face="Arial, Helvetica, sans-serif">
		  <? 
				/*if($fila_alu['fecha'] <= $fecha_ini)
				{$finip= $fecha_ini;
					$dias_habiles = $ob_reporte->dias_habiles;
					$dias_entre = hbl($fecha_ini,$fila_alu['fecha']);
				}
				else
				{
					$finip= $fila_alu['fecha'];
					$dias_entre = hbl($fila_alu['fecha'],$fecha_fin);
					$dias_habiles=$dias_entre;
				}*/
					
				
				if ($dias_habiles>0){
					//if($fila_alu['fecha']>$fecha_ini){
						/*$dias_entre = hbl($fecha_ini,$fila_alu['fecha']);
						$dias_habiles = $dias_habiles - $dias_entre;*/
						$dias_asistidos = $dias_habiles - $inasistencia;
					//}
					$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
					$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
					$prom_cont_asis = $prom_cont_asis + 1;
				}
				echo $promedio_asistencia . "%" ;
				
		  ?>
			</font>
		</td>
        <?php }?>
         <?php  if($chk_totdat==1){?>
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
		?>
		</font></td>
        <?php }?>
	  </tr>
      <tr>
       <?php  if($chk_anp==1){?>
      <td><font size="1" face="Arial, Helvetica, sans-serif"><strong>
        <? if($det_anot==1) { echo "ANOTACIONES POSITIVAS"; ?>
      </strong></font></td>
      <td><font size="1" face="Arial, Helvetica, sans-serif">
      <?
		 
		 $sql_an="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=1 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_an =pg_exec($conn,$sql_an);
		 $tot_sql_an = @pg_numrows($rs_an);
		 

		 /* $sql_an1="select * from anotacion an
					inner join tipos_anotacion ta on CAST(an.codigo_tipo_anotacion as INTEGER)=ta.id_tipo
					where rut_alumno = $alumno and ta.tipo='1'
					and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
					$rs_an1=pg_exec($conn,$sql_an1)or die("fallo sql");*/
					$tot_sql_an1 = @pg_numrows($rs_an1);
		 echo $tot_pos = $tot_sql_an+$tot_sql_an1;	
		 
}?>
      </font>
      </td>
      <?php }?>
      <? if($Just_Asis==1){?>
     	<td><div align="left"><strong><font size="1" face="Arial, Helvetica, sans-serif">INASISTENCIAS JUSTIFICADAS</font></strong></div></td>
    	<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $justifica ?></font></div></td>
     <? }?>
      
      </tr>
      <tr>
       <?php  if($chk_ann==1){?>
        <td><strong><font size="1" face="Arial, Helvetica, sans-serif"><? if($det_anot==1) { ECHO "ANOTACIONES NEGATIVAS"; ?></font></strong></td>
        <td><font size="1" face="Arial, Helvetica, sans-serif">
          <?
		 $sql_anotneg="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=2 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_anotneg =pg_exec($conn,$sql_anotneg);
		 $tot_sql_anotneg = @pg_numrows($rs_anotneg);
		 
		  /*$sql_anotneg2="select * from anotacion an
					inner join tipos_anotacion ta on CAST(an.codigo_tipo_anotacion as INTEGER)=ta.id_tipo
					where rut_alumno = $alumno and ta.tipo='2' and tipo_conducta=2
					and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
					$rs_anotnet2=pg_exec($conn,$sql_anotneg2)or die("fallo sql");
					$tot_sql_anotneg2 = @pg_numrows($rs_anotnet2);*/
		 echo $tot_neg = $tot_sql_anotneg+$tot_sql_anotneg2;	
		 }
	  ?>
        </font>
        </td>
        <?php }?>
        <td><?php  if($chk_pasisano==1){?>
        <font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIA ANUAL (%)</strong></font><?php }?></td>
        <td><?php  if($chk_pasisano==1){?>
		<?php 
		
		$habil_real_ano=0;
		$feriados_ano=0;
		$fera=0;

		//fecha inicio -> matricule despues de incio de año, indicar fecha, si no, marcar inicio de año academico
		if($fila_alu['fecha'] <= $iniano)
		{$fini= $iniano;}
		else
		{$fini= $fila_alu['fecha'];}
		
		//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
		if($fila_alu['bool_ar']==1){
		 $fter = $fila_alu['fecha_retiro'];
		}else{
		 //$fter = $finano;
		 if($ftermino_curso!=''){
			 $fter =($ftermino_curso>date("Y-m-d"))?date("Y-m-d"):$ftermino_curso;
		 }
		 else{
			 $fter = ($finano>date("Y-m-d"))?date("Y-m-d"):$finano;
		}
		}
		
		//if($_PERFIL==0){echo "fini->".$fini."---"."fter->".$fter."-mat->".$fecha_matricula;}
		
		//conteo dias habiles año (sin feriados)
		 $habiles_ano=hbl($fini,$fter)."-";
		
		//feriados año
		$ob_reporte->fecha_ini2 = $fini;
		$ob_reporte->fecha2 = $fter;
		$rs_feriadosano = $ob_reporte->DiaHabil3($conn);
		//echo "---".pg_numrows($rs_feriadosano);
		for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']==NULL)
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =ddiff($inciof, $finf);
		
		}
		
		$feriados_ano=$fera;
		
		//dias reales año
		
		$habil_real_ano = $habiles_ano-$feriados_ano;
		
		
		//inasistencias
		$ob_reporte->fecha_inicio = $fini;
		$ob_reporte->fecha_termino = $fter;
		$r_asisano= $ob_reporte->Asistencia($conn);
		$c_inasistenciaAno = pg_numrows($r_asisano);
		
		
		
		//justificaciones
		$ob_reporte->fecha1 = $fini;
		$ob_reporte->fecha2 = $fter;
		$r_justificaano= $ob_reporte->JustificaAsistencia($conn);
		$justificaano = pg_numrows($r_justificaano);
		
		//resta final
		// $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
		if($just==1){
		 $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
		}
		else{
		 $con_total_inano = $habil_real_ano-($c_inasistenciaAno);
		}
		 
		/*if($_PERFIL==0){
		 echo "hab->".$habiles_ano;
		}*/
		
		//porcentaje anual
		$prc_base = (100* $con_total_inano)/$habil_real_ano;
		
		
		 ?>
        
        
        <font size="1" face="Arial, Helvetica, sans-serif"><?php echo round($prc_base,1) ?></font><?php }?></td>
      </tr>
      <?php if($chk_anr==1){?>
  <tr>
    <td><font size="1" face="Arial, Helvetica, sans-serif"><strong>ANOTACIONES<br>RESPONSABILIDAD</strong></font></td>
    <td align="left"> <?
		 
		$sql_ar="select count(*) from anotacion where rut_alumno=$alumno and tipo=3 and tipo_conducta=0 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
		$rs_ar = pg_exec($conn,$sql_ar);
		
	 
?><font size="1" face="Arial, Helvetica, sans-serif"><?php echo pg_result($rs_ar,0);?> </font></td>
  </tr>
 <?php }?>
	</table>
   <? if($obs==1){?>		
		<table width="850"  border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
			<td ><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></font></div></td>
		  </tr>
		</table><br />

		<table width="850" height="72" border="0" cellpadding="0" cellspacing="0" align="center">
		 <? if ($bool_ed==1) { ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"><? echo "ALUMNO EVALUADO DIFERENCIADAMENTE ";?> 
               </font></strong></font></div></td>
		  </tr>
		  <? } else{ ?>
		  <tr>
			<td height="27"><font size="1" face="Arial, Helvetica, sans-serif"><div align="left"><? echo $fila_alu['obs_reporte'];?></div></font></td>
		  </tr>
		  <? } 
		  for($o=1; $o<=($txtOBS-1) ; $o++){
		  ?>
		  <tr>
		    <td height="27"><div align="left">________________________________________________________________________________</div></td>
		  </tr>
		  <? } ?>
	  </table>
		<? }
?>
<br />
 <?php 

	$ob_reporte->tensenanza = $promporc;
	$ob_reporte->ense = $ense;
	$ob_reporte->nivel = $grado;
	$ob_reporte->subs = $subs; 
	$ob_reporte->idp = $periodo;
	
	 $Lcon= $ob_reporte->getEscalaPorcentaje($conn);?>
<table align="center" border="1" cellpadding="0" cellspacing="0" width="800" style="border-collapse:collapse">
<tr class="textonegrita" bgcolor="#CCCCCC">
  <td colspan="3" align="center">Escala de Conceptos</td>
  </tr>
  <tr class="textosimple" bgcolor="#CCCCCC">
	<td width="143" align="center">Concepto</td>
	<td width="409" align="center">Rango Logro (%)</td>
	<td width="240" align="center">Descripci&oacute;n</td>
</tr>
 <?php  for($le=0;$le<pg_numrows($Lcon);$le++){
	 $fel = pg_fetch_array($Lcon,$le);
	 ?>
<tr class="textosimple">
	<td align="center"> <?php echo $fel['concepto'] ?></td>
	<td align="center"><?php echo $fel['minimo'] ?>-<?php echo $fel['maximo'] ?></td>
	<td align="center"><?php echo $fel['descripcion'] ?></td>
</tr>
<?php }?>
</table>
<br />
<?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
         <? if ($_INSTIT!=770){ ?>
	<table width="850" align="center">
	<tr>
	<td>
   <? $fecha = $txtFECHA;?>
	  <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtoupper($ob_membrete->comuna)).", ". fecha_espanol($fecha) ?></font>
	</td>
	</tr>
	</table>
<? } ?>

         
<? if(!$colilla){	?>
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="4"><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="../../tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </strong></font></div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">Devolver colilla firmada</font> </div></td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td width="124"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
    <td width="245"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $ob_reporte->tildeM($nombre_alumno); ?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $Curso_pal?></strong></font></div></td>
  </tr>
  <tr>

    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Promedio Alumno</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
	  <?
	if ($prome_colilla>0)
		echo $prome_colilla;
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
 <?php  if($_INSTIT!= 9105){?>
 
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
    <?php } ?></tr></table><? }
	?>
    <?php 
	 if($anotacion==1){
 	?>
<br>
<table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
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
	
	
	if (pg_numrows($result_anota)==0) echo "<div align='center'><font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA ANOTACIONES NI ATRASOS</strong></font></div><br>";
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
			$tipo = "RESPONSABILIDAD";
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
    <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr width="100%" color=#003b85></td>
      </tr>
    </table>
    <? if($fila_anota['tipo']!=2){?>
    <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
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
			//echo $ob_reporte->sigla;?>  <? echo $ob_reporte->detalle_sigla; ?> 
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
			$codta       = $f1['id_tipo'];
			$descripcion	= $f1['descripcion'];
		/*$codta - */
			echo "$descripcion";
		
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
		  $ob_reporte ->id_tipo = $codta;
		  $r1 = $ob_reporte ->DetalleAnotaciones($conn);
		  $f1 = @pg_fetch_array($r1,0);
		  $detalle = $f1["detalle"];
		  /*$codigo_anotacion - */
			echo "$detalle";
		?>
        </font> </td>
      </tr>
      <?	}	?>
    </table>
    <? }else{ ?>
    <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
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
    <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
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
		echo "<div align='center'><font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA INASISTENCIAS</strong></font></div><br>";
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
    <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
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
	
 } // FIN ANOTACIONES
	?>
  
    
<? if ($cont_alumnos>1){ 
		?><H1 class=SaltoDePagina></H1><?
	}?>
<?php }?>


</body>
</html>