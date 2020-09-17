<?php require('../../../../../util/header.inc');?>
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>


<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO; 
	$_POSP          =5;
	
//imprime_array($_SESSION);

function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($Subsector,0,3)));
	else
		echo trim($cadena);
}

	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	//----------------------------------------------------------------------------
	// DIAS HÁBILES
	//----------------------------------------------------------------------------		
	$sql_periodo = "select sum(dias_habiles) as habiles from periodo where periodo.id_ano = ".$ano;
	$result_periodo =@pg_Exec($conn,$sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);	
	$habiles = $fila_periodo['habiles'];
	
	if ($habiles==0){
		?>
		<script>alert('Atención: Falta información en Periodos. Revise fecha de inicio, fecha de término y dias hábiles');</script>
		<?	
    }	
	//------------------------------------------------------------------------------
	// PERIODOS
	// -----------------------------------------------------------------------------
	$sql = "SELECT * FROM periodo WHERE id_ano=".$ano." ORDER BY id_periodo ASC";
	$rs_periodo = pg_exec($conn,$sql);
	$cuenta_periodo = pg_numrows($rs_periodo);
	if($cuenta_periodo==2){
		$per ="SEM";
	}else{
		$per="TRI";
	}
	
	
	
	//----------------------------------------------------------------------------
	// CURSO
	//----------------------------------------------------------------------------	
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	$sqlCurso = "select * from curso where id_curso = $curso";
	$rsCurso =@pg_Exec($conn,$sqlCurso);
	$flCurso = @pg_fetch_array($rsCurso ,0);	
	$truncado_final = $flCurso['truncado_final'];
	$truncado_per   = $flCurso['truncado_per'];
	
	
	//----------------------------------------------------------------------------
	// ALUMNOS
	//----------------------------------------------------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso,matricula.bool_ar, matricula.fecha_retiro ";
	
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
//	echo $sql_alu."<br>";
	$result_alu =@pg_Exec($conn,$sql_alu);	
	//----------------------------------------------------------------------------	
?>

<? function promedia_aleman($suma_promedios,$total_promedios){

	  $prom_temp=($suma_promedios/$total_promedios);
		$prom_temp=number_format($prom_temp,1);
		
		$decimal=substr($prom_temp,strlen($prom_temp)-1,1);
//		echo "<br>".$decimal;
		$prom_temp=substr($prom_temp,0,2);
		
		if ($prom_temp>=40){
			if ($decimal>=5){ $prom_temp++;}
		}
//		echo "<br>".$prom_temp;
		$prom_temp=substr($prom_temp,0,1)."".substr($prom_temp,1,1);
//		echo "<br>".$prom_temp;
		if ($prom_temp=="39"){$prom_temp=="40";}
		return $prom_temp;
				
}	


function sube_punto_nuevo($prom){
	$decima=substr($prom,1,1);
	$entero=substr($prom,0,1);

	if ($decima==9){$entero++;$decima=0;}
		$prom_temp=$entero."".$decima;

	return $prom_temp;

}
function Concepto($nota, $tipo){
	//$tipo = 1 --- $nota viene con valor numérico devuelve conceptual
	//$tipo = 2 --- $nota viene con valor conceptual devuelve numérico
	$nota_res=0;
	$concepto="";		
	if ($tipo == 1){
		if ($nota >= 60 and $nota<=70)
			$concepto = "MB";
		if ($nota >= 50 and $nota<=59)
			$concepto = "B";
		if ($nota >= 40 and $nota<=49)
			$concepto = "S";
		if ($nota >= 0 and $nota<=39)
			$concepto = "I";
		if($nota==0)
			$concepto = "-";
		return $concepto ;
	}else{
		if (trim($nota) == "MB")
			$nota_res = 65;
		if (trim($nota) == "B")
			$nota_res = 55;			
		if (trim($nota) == "S")
			$nota_res = 45;
		if (trim($nota) == "I")
			$nota_res = 35;						
		return $nota_res;
	}
}
function Notas($ramo,$alumno,$periodo,$nro_ano,$conn){
	$sql = "SELECT promedio, notaap FROM notas$nro_ano WHERE id_ramo=".$ramo." AND rut_alumno=".$alumno." AND id_periodo=".$periodo;
	$rs_notas = @pg_exec($conn,$sql);
	return $rs_notas;
}
function Examen_Periodo($ramo,$rut_alumno,$periodo,$conn){
	$sql ="SELECT nota_final as promedio FROM situacion_periodo WHERE id_ramo=".$ramo." AND rut_alumno=".$rut_alumno." AND id_periodo=".$periodo."";
	$rs_examen_periodo = pg_exec($conn,$sql) or die(pg_last_error($conn));	
	$promedio = pg_Result($rs_examen_periodo,0);
	return $rs_examen_periodo;
}

function Examen_final($ramo,$alumno,$conn,$modo_eval){
	$datos[] = array(4);
	$sql = "SELECT * FROM situacion_final WHERE rut_alumno=".$alumno." AND id_ramo=".$ramo;
	$rs_examen = @pg_exec($conn,$sql);
	$fila_ex = @pg_fetch_array($rs_examen,0);
	if($fila_ex['nota_examen']>0 && $fila_ex['nota_exam_esc']==0){
		$datos[examen] =  $fila_ex['nota_examen'];
		if($modo_eval==1){
			$datos[promedio] = $fila_ex['nota_final'];
		}else{
			$datos[promedio] = Concepto($fila_ex['nota_final'],1);
		}
	}else{
		$datos[escrito] = $fila_ex['nota_exam_esc'];
		$datos[oral] = $fila_ex['nota_exam_oral'];
		if($modo_eval==1){
			$datos[promedio] = $fila_ex['nota_final'];
		}else{
			$datos[promedio] = Concepto($fila_ex['nota_final'],1);
		}
	}	
	return  $datos;
}

function PromedioBonificado($id_ramo,$promedio,$conn){
	$sql = "SELECT bonifica1, minima1, maxima1,	bonifica2, minima2, maxima2, bonifica3, minima3, maxima3,bonifica4, minima4, maxima4 FROM ramo WHERE id_ramo=".$id_ramo;
	$rs_ramo = @pg_exec($conn,$sql) or die(pg_last_error($conn));
	$fila = @pg_fetch_array($rs_ramo,0);
	
	if(trim($fila['minima1'])<=trim($promedio) and trim($fila['maxima1'])>=trim($promedio)){
		$promedio = $promedio + $fila['bonifica1'];			
	}elseif(trim($fila['minima2'])<=trim($promedio)  and trim($fila['maxima2'])>=trim($promedio)){
		$promedio = $promedio + $fila['bonifica2'];			
	}elseif((trim($fila['minima3'])<=trim($promedio)) and (trim($fila['maxima3'])>=trim($promedio))){
		$promedio = $promedio + $fila['bonifica3'];			
	}elseif((trim($fila['minima4'])<=trim($promedio)) and (trim($fila['maxima4'])>=trim($promedio))){
		$promedio = $promedio + $fila['bonifica4'];			
	}
	if($promedio > 70){
		$promedio=70;	
	}
	return $promedio;	
}
function PromedioExamenSemestral($ramo,$periodo,$alumno,$porcentaje_ramo,$conn,$promedio){
	$sql = "SELECT nota,porc,bool_ap FROM notas_examen a INNER JOIN examen_semestral b ON a.id_examen=b.id_examen WHERE a.id_ramo=".$ramo." AND rut_alumno=".$alumno." AND periodo=".$periodo;
	$rs_examen_sem = @pg_exec($conn,$sql) or die (pg_last_error($conn));
	
	if(@pg_numrows($rs_examen_sem) > 0 ){
		$nota_examen = $promedio;
		$porc_nota  = (($promedio * $porcentaje_ramo)/100);
		if(@pg_result($rs_examen_sem,2)==1){
			$porc_examen = ((@pg_result($rs_examen_sem,0) * @pg_result($rs_examen_sem,1))/100);
		}else{
			$porc_examen = ((@pg_result($rs_examen_sem,0) * @pg_result($rs_examen_sem,1))/100);
		}
		$promedio_sub = round($porc_nota + $porc_examen); 
	}
	return $promedio_sub;
}
function PromedioFinal($promedio,$contador,$truncado,$modo_eval){
	
	if($modo_eval==1){
		if($truncado==1){
			$promedio_final = @round($promedio/$contador);
		}elseif($truncado==0){
			$promedio_final = @intval($promedio/$contador);		
		}
	}elseif($modo_eval==2){
		echo "promedio-->".$promedio; 
		$promedio_final = Concepto($promedio,2);	 
		echo "promedio conceptual-->".$promedio_final;
	}
	return $promedio_final;
}
function Promedio_Parcial($promedio,$contador,$truncado,$modo_eval){
	if($modo_eval==1){
		if($truncado==1){
			$prom = round($promedio / $contador);
		}else{
			$prom = intval($promedio / $contador);			
		}
	}elseif($modo_eval==2 || $modo_eval==3){
		if($truncado==1){
			$prom = @round($promedio / $contador);
		}else{
			$prom = @intval($promedio / $contador);			
		}
		$prom = Concepto($prom,1);	 
	}
	return $prom;
}
function Promedio_General($promedio,$truncado,$contador){
	if($truncado==1){
		$prom = @round($promedio / $contador);
	}else{
		$prom = @intval($promedio / $contador);			
	}
	return $prom;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

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

function funcion_dav(ini, fin, rut, aproxima){    
	var i;
	var acum=0; var prom = 0;
	var contador=0; var prom_alum; var elemento;
	inicio=ini;    // antes estos 2 no estaban
	final=fin-1;   //
	for (i=inicio; i <= (final); i++){  //antes for (i=ini; i < (fin); i++) 
	    elemento = "prom_sub"+i;
		prom = parseInt(document.form.elements[elemento].value);
		
		if (parseInt(prom)>0){
		    acum = acum + prom;
		    contador = contador + 1;		
		}		 	
	}
	
	elemento = "campo_"+rut;
	if (parseInt(aproxima)==1){
	     prom_alum = Math.round(acum/contador);
	}else{
	     prom_alum = parseInt(acum/contador);
	}
	document.form.elements[elemento].value=prom_alum;	
	
}
</script>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="10%" height="363" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="600" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo antiguo -->
								  
								  
								  
<center>
<FORM method=post name="form" action="../promocion/procesoPromocion_pro.php">

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="155" height="22" align="left"><FONT face="arial, geneva, helvetica" size=2><strong>A&Ntilde;O ESCOLAR </strong></FONT></td>
    <td width="10" align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td width="873" align="left"><FONT face="arial, geneva, helvetica" size=2><? echo $nro_ano?></FONT></td>
  </tr>
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><? echo $Curso_pal?></FONT></td>
  </tr>
  
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="right">
	  <INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;  
      <INPUT name="button2" TYPE="button" class="botonXX" onClick=document.location="promocion_pro.php"  value="CANCELAR"></td>
  </tr>
  <tr  align="center">
    <td class="tableindex">Promoci&oacute;n de Alumnos </td>
  </tr>
</table>
<?
$cont_alumnos = @pg_numrows($result_alu);
$contador=0;
$var_ini = 0;
$var_fin = 0;
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos  ; $cont_paginas++){
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'];
	$fecha_retiro = $fila_alu['fecha_retiro'];
	$rut_alumno = $fila_alu['rut_alumno'] . " - " . strtoupper($fila_alu['dig_rut']);
	$nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']))); 
	$curso = $fila_alu['id_curso'];
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr class="cuadro02">
    <td width="15" rowspan="2" align="center"><strong>RUT ALUMNO</strong></td>
    <td width="20" rowspan="2" align="center"><strong>NOMBRE ALUMNO</strong></td>
    <td colspan="2" rowspan="2" align="left">
		<table width="50%" border="0" align="left" cellpadding="1" cellspacing="1" class="cuadro02">
      <tr> 
        <td width="25%" rowspan="2"><strong>SUBSECTOR</strong></td>
        <td colspan="<? if($cuenta_periodo==2) echo "3"; else echo "4";?>"><div align="center"><strong>PROMEDIOS <br>
          PERIODOS</strong></div></td>
        <td colspan="2"><div align="center"><strong>EXAM&Eacute;N</strong></div></td>
        <td width="25%">&nbsp;</td>
      </tr>
      <tr>
        <td width="8%"><div align="right"><strong>1 
          <?=$per;?> 
        </strong></div></td>
        <td width="8%"><div align="right"><strong>2 
          <?=$per;?>
        </strong></div></td>
		<? if($cuenta_periodo==3){ ?>
        <td width="8%"><div align="right"><strong>3 
          <?=$per;?>
        </strong></div></td>
		<? } ?>	
        <td width="8%"><div align="right"><strong>PROM</strong></div></td>
        <td width="8%"><div align="right"><strong>ESC</strong></div></td>
        <td width="8%"><div align="right"><strong>ORAL</strong></div></td>
        <td><div align="right"><strong>PROMEDIO</strong></div></td>
      </tr>
    </table></td>
    <td colspan="3" align="center"><strong>INFORMACI&Oacute;N FINAL </strong></td>
    </tr>
  <tr class="cuadro02">
    <td width="30" align="center"><strong>ASISTENCIA (%)</strong></td>
    <td width="20" align="center"><strong>SITUACION</strong></td>
    <td width="30" align="center"><strong>OBSERVACIÓN</strong></td>
  </tr>

 <? 
 	//------------------------------------------------------------------------------
	// CONSULTA EN TABLA PROMOCION
	//------------------------------------------------------------------------------
	$sql_promo= "SELECT psa.id_ramo,s.nombre, psa.promedio, p.promedio AS prom_gral, p.asistencia, p.situacion_final,p.tipo_reprova , p.observacion, r.modo_eval, r.apreciacion, r.porc_examen, r.conexper  
FROM promocion p INNER JOIN promedio_sub_alumno psa ON p.rdb=psa.rdb AND p.id_ano=psa.id_ano AND p.id_curso=psa.id_curso AND p.rut_alumno=psa.rut_alumno
INNER JOIN ramo r ON psa.id_curso=r.id_curso AND psa.id_ramo=r.id_ramo
INNER JOIN subsector s ON s.cod_subsector=r.cod_subsector
WHERE p.rdb=".$institucion." AND p.id_ano = ".$ano." and psa.id_curso = ".$curso." AND p.rut_alumno='".$alumno."'
ORDER BY r.id_orden ASC";
	$result_promo =@pg_Exec($conn,$sql_promo) or die(pg_last_error($conn));
	$fila_promo = @pg_fetch_array($result_promo,0);		
	//------------------------------------------------------------------------------
	
	if(pg_numrows($result_promo)==0){
		$sql_ramos ="SELECT ramo.id_ramo, ramo.conex, ramo.modo_eval, ramo.cod_subsector, subsector.nombre,porc_examen, ramo.nota_exim,ramo.porc_examen, ramo.apreciacion, ramo.bonifica1, ramo.conexper, ramo.porc_examen, ";
		$sql_ramos.=" ramo.minima1,ramo.maxima1, ramo.bonifica2,ramo.minima2,ramo.maxima2,ramo.bonifica3,ramo.minima3,ramo.maxima3, ramo.bonifica4,ramo.minima4,ramo.maxima4 FROM ramo, tiene$nro_ano,subsector ";
		$sql_ramos.=" WHERE ramo.id_curso = ".$curso." AND tiene$nro_ano.rut_alumno =".$alumno." and tiene$nro_ano.id_ramo = ramo.id_ramo and ramo.bool_ip = 1 ";
	 	$sql_ramos.=" AND ramo.cod_subsector=subsector.cod_subsector ORDER BY id_orden ASC ";
		$result_promo =@pg_Exec($conn,$sql_ramos) or die(pg_last_error($conn));
	}
	$cont_ramos = @pg_numrows($result_promo);
	//------------------------------------------------------------------------------	
	$promedio_general = 0;
	$promedio_general_d = 0;
	$contador_general = 0;
	$contador_general_d = 0;
	$contador_ramos2 = 0;
	
?>  
  <tr class="cuadro01" >
    <td width="15" ><? echo $rut_alumno?>
      <INPUT TYPE="hidden" name="rut_alumno[<?=$cont_paginas; ?>]" value="<?=$alumno; ?>"></td>
    <td width="20" ><? echo substr($nombre_alu,0,25)?></td>
	
	<td colspan="2" valign="top" ><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="cuadro01">
<?   
    
	
	$var_fin = $var_fin + $cont_ramos;
	$promedio_general=0;
    for($cont_sub=0 ; $cont_sub < $cont_ramos ; $cont_sub++){
		$apreciacion=0;
		$fila_ramos = @pg_fetch_array($result_promo,$cont_sub);
		$ramo = $fila_ramos['id_ramo'];
		$examen = $fila_ramos['conex']; // 1 SI 2 NO
		$modo_eval = $fila_ramos['modo_eval'];
		$nota_exim = $fila_ramos['nota_exim'];
		$subsector = $fila_ramos['cod_subsector'];
		$examen_periodo = $fila_ramos['conexper'];
		$porcentaje_ramo = $fila_ramos['porc_examen'];

		if($fila_ramos['apreciacion']>0){
			$apreciacion=1;
		}
		
		if($modo_eval==0) $modo_eval=1;
		
		$prom_gral =0;
		$cont_subsector=0;
		$prom_xx =0;
		$cont=0;
		for($b=0; $b<$cuenta_periodo; $b++){
			$fila_per = @pg_fetch_array($rs_periodo,$b);
			
			if($examen_periodo==0 or $examen_periodo==NULL){
				$rs_notas = Notas($ramo,$alumno,$fila_per['id_periodo'],$nro_ano,$conn);	
				if($apreciacion==1){
					$promedio_sub[$b] = @pg_result($rs_notas,1);
				}else{
					$promedio_sub[$b] = @pg_result($rs_notas,0);
				}				
			}else{
				$rs_notas = Examen_Periodo($ramo,$alumno,$fila_per['id_periodo'],$conn);	
				$promedio_sub[$b] = @pg_result($rs_notas,0);				
			}
			if($porcentaje_ramo!=100){
				$promedio_sub[$b] = PromedioExamenSemestral($ramo,$fila_per['id_periodo'],$alumno,$porcentaje_ramo,$conn,$promedio_sub[$b]);
			}
			
			if($modo_eval==1){
				$prom_xx = $prom_xx + $promedio_sub[$b]; 
				if($promedio_sub[$b]>0) $cont++;
			}elseif($modo_eval==2 or $modo_eval==3){
				if($promedio_sub[$b]>0 || $promedio_sub[$b]!="") $cont++;
				$prom_xx = $prom_xx + Concepto($promedio_sub[$b],2); 
			}
		
		}// fin for periodos
		$prom_parcial = Promedio_Parcial($prom_xx,$cont,$truncado_per,$modo_eval);
		
		
		if($examen==1){
			$datos=Examen_final($ramo,$alumno,$conn,$modo_eval);
			if($datos[examen]>0){
				$escrito=$datos[examen];
				$prom_final = $datos[promedio];
			}else{
				$escrito=$datos[escrito];
				$oral = $datos[oral];
				$prom_final = $datos[promedio];
			}
			$promedio_general = $promedio_general + $prom_final;
		}else{
			$prom_final = PromedioBonificado($ramo,$prom_parcial,$conn);
			if($prom_final==""){
				$prom_final = $prom_parcial;
			}
			$escrito=0;
			$oral =0;
			$promedio_general = $promedio_general + $prom_final;	
		}
	//------------------------------------------------------------------------------
	// ASISTENCIA
	//------------------------------------------------------------------------------	
	
	$sql_asis = "select count(*) as cantidad from asistencia where asistencia.rut_alumno = ".trim($alumno)."  and ano = ".$ano;
	$result_asis = @pg_Exec($conn,$sql_asis);
	$fila_asis = @pg_fetch_array($result_asis,0);	
    
	$sql_justifica = "select count(*) as justificado from justifica_inasistencia where rut_alumno = '".trim($alumno)."'  and ano = '".trim($ano)."'";
	$res_justifica = @pg_Exec($conn,$sql_justifica);
	$fila_justifica = @pg_fetch_array($res_justifica,0);
	$inasistencia = $fila_asis['cantidad'] - $fila_justifica['justificado'];
	
	$asistencia = $habiles - $inasistencia;	
		
	if ($promedio_general>0)
	    if ($_PERFIL==0){
			
    		/*echo "asistencia-->".$asistencia."-- habiles-->".$habiles."----inasistencia-->".$inasistencia;   
			echo "<br>".$sql_justifica;
			echo "<br>".$sql_asis;
			echo "<br> curso -->".$curso;*/
			$asistencia = @round(($asistencia * 100)/$habiles,0);
		}else{
		    $asistencia = @round(($asistencia * 100)/$habiles,0);		
		}
		
	else
		$asistencia = " ";	
		
			
?>
	
	<tr>
	<td width="24%" ><? InicialesSubsector($fila_ramos['nombre']);?></td>
    <td width="10%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[0];?></div></td>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[1];?></div></td>
	<? if($cuenta_periodo==3){ ?>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[2];?></div></td>
	<? } ?>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$prom_parcial;?></div></td>
    <td width="8%" align="center" ><div align="right"><?=$escrito;?></div></td>
    <td width="8%" align="center" ><div align="right"><?=$oral;?></div></td>
    <td width="26%" align="center" ><div align="right"><?
	/// variables para el javascript
	?>
	<input name="prom_sub<?=$contador?>" id="prom_sub<?=$contador?>" type="text" size="3" maxlength="2" value="<?=$prom_final;?>"  onClick="funcion_dav('<?=$var_ini?>','<?=$var_fin?>','<?=trim($alumno)?>','<?=$truncado_final?>');" onBlur="funcion_dav('<?=$var_ini?>','<?=$var_fin?>','<?=trim($alumno)?>','<?=$truncado_final?>');"></div></td>
	</tr>
	<input name="id_ramo[<?php echo $contador;?>]" type="hidden" value="<?=$ramo;?>">
	<input name="cont_ramos<?php echo $cont_paginas; ?>" value="<?=$cont_ramos;?>" type="hidden">
	<input name="prom_sin_aprox[<?php echo $contador;?>]" type="hidden" value="<?=$prom_sin_aprox;?>">
<? 

   if($prom_final > 0){
		$contador_general++;   
   }
	$contador++;
}
$promedio_general = Promedio_General($promedio_general,$truncado_final,$contador_general);
 //$promedio_general  = Promediar($promedio_general, $contador_general,$truncado_final);
 ?>
	</table>	</td>
	<td colspan="3" class="cuadro01">&nbsp;</td>
    </tr>
  <tr class="cuadro01" >
    <td colspan="3" ><div align="right"><strong>PROMEDIO FINAL ALUMNO </strong></div></td>
    <td width="%" align="right" ><div align="right">
            <input type="text" name="campo_<?=trim($alumno)?>" id="campo_<?=trim($alumno)?>" size="3" maxlength="2" value="<? echo ($promedio_general)?>">    
    </div></td>
    <td align="center" ><?
		// aqui saco la nueva asistencia
		if(($fila_promo['asistencia']!=NULL) && ($fila_promo['asistencia']!=0)){
			$asistencia = $fila_promo['asistencia'];	
		}		  
		// fin nuevo código
			
		
		?>
      <input type="text" name="asistencia[<?php echo $cont_paginas; ?>]" size="3" maxlength="3" value="<? echo trim($asistencia)?>">
%</td>
    <td width="20" align="left"><select name="situacion_final[<?php echo $cont_paginas; ?>]" >
      <? if(empty($fila_promo['situacion_final'])){ ?>
             <option value="1" selected>Aprobado</option>
      <? }else{?>
             <option value="1" <? if($fila_promo['situacion_final']==1){?>selected <? } ?> >Aprobado</option>
      <? } ?>
      <option value="2" <? if(($fila_promo['situacion_final']==2)||((empty($fila_promo['situacion_final']))&&($promedio_general<40)))	{?>selected <? } ?> >Reprobado</option>
      <option value="3" <? if(($fila_promo['situacion_final']==3)||($fila_alu[bool_ar]=="1")){?>selected <? } ?> >Retirado </option>
    </select>  
    <td width="30" align="left" class="<? if ($cont_paginas%2==0){?>tabla04<? }else{?>tabla04<? }?>"><input type="text" name="observacion[<?php echo $cont_paginas; ?>]" size="25" maxlength="100" value="<? echo /*$fecha_retiro.*/trim($fila_promo['observacion'])?>">  </tr>
 
 
 
 <? 
  $var_ini = $contador;
 
 
 }?>
 <tr><td colspan="7"><table width="327" border="0" cellpadding="0" cellspacing="0" class="boton02" align="center">
   <tr align="center" valign="middle">
     <td height="23"><a href="../promocion/promocion_pro.php" class="boton02" > <img src="../../../../../cortes/atras.gif" width="11" height="11" border="0"> Volver</a></td>
     <td><a href="#arriba" class="boton02"><img src="../../../../../cortes/subir.gif" width="11" height="11" border="0">Subir</a> </td>
     <td><a href="javascript:;" onClick="window.print();" class="boton02"><img src="../../../../../cortes/print.gif" width="11" height="11" border="0"> Imprimir</a></td>
   </tr>
 </table></td></tr>
</table>

<INPUT TYPE="hidden" name="contalum" value="<?php echo $cont_alumnos; ?>">

</form>
</center>
								  <!-- fin codigo antiguo --> </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2008</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>