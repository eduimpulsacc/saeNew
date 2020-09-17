<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
include('../../../clases/class_Reporte.php');
require('../../../../util/SeleccionaCombo.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$retirados		=$retirados;
	$cadena01		="00";	
	$_POSP = 4;
	$_bot = 8;
	
	$ob_reporte = new Reporte();
	if (empty($curso)) //exit;
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//------------------------
	// Periodo
	//------------------------
	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo =@pg_Exec($conn,$sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'];

	$sql_periodo1 = "select * from periodo where id_ano=".$ano." and id_periodo<>".$periodo." ORDER BY id_periodo ASC";
	$Rs_Periodo = @pg_exec($conn,$sql_periodo1);
	$fils_periodo = @pg_fetch_array($Rs_Periodo,0);
	$otro_periodo = $fils_periodo['id_periodo'];
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-----------------------------------------
	// Institución
	//-----------------------------------------
	$sql_insti = "Select * from institucion where rdb = " . $institucion;
	$result_insti =@pg_Exec($conn,$sql_insti);
	$fila_insti = @pg_fetch_array($result_insti,0);	
	$nombre_insti = $fila_insti['nombre_instit'];
	//-----------------------------------------
	// Curso y Profesor Jefe
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);

	$sql_curso = "SELECT truncado_per FROM curso WHERE id_curso=".$curso;
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$truncado_per = $fila_curso['truncado_per'];
	
	//-----------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	if($retirados==1)
	$ret="and matricula.bool_ar<>1";
	
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ".$ret;
	if($orden==0){
		$sql_alu = $sql_alu . "ORDER BY nro_lista ASC ";
	}else{
		$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ASC";
	}
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-----------------------------------------
	// Cantidad de Subsectores
	//-----------------------------------------
	$sql_sub = "select count(*) as cantidad from ramo where id_curso = ".$curso." ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$fila_sub = @pg_fetch_array($result_sub,0);	
	$num_subsectores = $fila_sub['cantidad'];
	//-----------------------------------------
	// Subsectores
	//-----------------------------------------
//	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip, ramo.cod_subsector, ramo.porc_examen ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) ORDER BY ramo.id_orden; ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	//-----------------------------------------
	
	$sql = "SELECT truncado_per, truncado_final FROM curso WHERE id_curso=".$curso;
	$rs_curso = @pg_exec($conn,$sql);
	$truncado_per = @pg_result($rs_curso,0);
	$truncado_final = @pg_result($rs_curso,1);		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'PlanillaNotasGeneralesPeriodo.php?institucion=$institucion';
				form.submit(true);
	
				}	
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if (empty($curso)){
   // exit;
}else{
   ?>   

<table>
    <tr>
	  <td align="left">&nbsp;</td>
	</tr>
  </table>

  <center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<div id="capa0">
		<TABLE width="100%">
		  <TR><TD><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></TD><TD>
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
        </div>
		</TD></TR></TABLE>
        </div>		</td>
      </tr>
    </table>
	
	
	
	
<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>	
	
	
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>	  		</td>
		</tr>
     </table>	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>

    <? } ?></td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="tableindex"><div align="center">PROMEDIOS GENERALES </div></td>
      </tr>
      <tr>
            <td align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong><? echo $periodo_pal?> 
              de&nbsp;<? echo $ano_escolar?> </strong></font></td>
      </tr>
</table>
<br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
            <td width="115"><font size="1" face="verdana,arial, geneva, helvetica"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="verdana,arial, geneva, helvetica">:</font></div></td>
        <td width="531"><font size="1" face="verdana,arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
            <td><font size="1" face="verdana,arial, geneva, helvetica"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td></div><font size="1" face="verdana,arial, geneva, helvetica">:</font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica"><? echo $ob_reporte->tildeM($profe_jefe);?></font></td>
      </tr>
    </table>
	<br>
	
	<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr >
    <td rowspan="2" width="20" class="tablatit2-1">Nº</td>
	<td rowspan="2" width="170" class="tablatit2">NOMBRE DEL ALUMNO</td>
    <td colspan="<? echo $num_subsectores+2 ?>" class="tablatit2"><div align="center">SUBSECTORES</div></td>
    </tr>
  <tr>
    <?	 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso 	= $fila_sub['nombre'];
		$id_ramo 			= $fila_sub['id_ramo'];
		$cod_subsector 		= $fila_sub['cod_subsector'];
		$modo_eval 			= $fila_sub['modo_eval'];
		$examen 			= $fila_sub['conex']; // 1 SI 2 NO
		$porc_examen 		= $fila_sub['porc_examen'];
    ?>	
    <td align="center"><font size="1" face="verdana,arial, geneva, helvetica"><strong>
    <? InicialesSubsector($subsector_curso) ?>
	</strong></font></td>
	<? }?>
    <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Final</strong></font></td>
    <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Final Ant.</strong></font></td>
    </tr>

    <?
	$numero_alumnos = @pg_numrows($result_alu);	 
	for($i=0 ; $i < @pg_numrows($result_alu) ; $i++)
	{
	  $fila_alu = @pg_fetch_array($result_alu,$i);
	  $nombre_alu = trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']);
	  $rut_alumno = $fila_alu['rut_alumno'];
	  ?>	
  <tr>
    <td align="center"><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
    <td><font size="0" face="arial, geneva, helvetica"><? echo $ob_reporte->tilde(substr(ucwords(strtolower($nombre_alu)),0,25)); ?></font></td>
	<?	 
	$promedio_general = 0;
	$cont_prom_general = 0;
	$promedio = 0;
	$cont_prom = 0;
	$promedio_general1 = 0;
	$cont_prom_general1 = 0;
	$promedio1 = 0;
	$cont_prom1 = 0;
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$cod_subsector = $fila_sub['cod_subsector'];
		//---------------------------------------
		// Notas
		//---------------------------------------
		$sql_notas = "SELECT notas$ano_escolar.promedio,notaap ";
		$sql_notas = $sql_notas . "FROM notas$ano_escolar ";
		$sql_notas = $sql_notas . "WHERE (((notas$ano_escolar.rut_alumno)='".$rut_alumno."') AND ((notas$ano_escolar.id_ramo)=".$id_ramo.") and id_periodo = ".$periodo.") ; ";
		$result_notas =@pg_Exec($conn,$sql_notas);
		$cont_prom = 0;
        $fila_notas = @pg_fetch_array($result_notas,0);
		if($ck_opcion==1){
			$promedio = $fila_notas['promedio'];
		}else{		
			$promedio = $fila_notas['notaap'];
			if(!isset($promedio)){
				$promedio = $fila_notas['promedio'];
			}
		}
		
		$sql_notas1 = "SELECT notas$ano_escolar.promedio, notaap ";
		$sql_notas1 = $sql_notas1 . "FROM notas$ano_escolar ";
		$sql_notas1 = $sql_notas1 . "WHERE (((notas$ano_escolar.rut_alumno)='".$rut_alumno."') AND ((notas$ano_escolar.id_ramo)=".$id_ramo.") and id_periodo = ".$otro_periodo.") ; ";
		$cont_prom1 = 0;

		$result_notas1 =@pg_Exec($conn,$sql_notas1);
		$fila_notas1 = @pg_fetch_array($result_notas1,0);
		if($ck_opcion==1){
		//  NUEVO CODIGO DE EXAMEN SEMESTRAL
			$sql="SELECT max(cuenta) FROM (SELECT count(*) as cuenta FROM examen_semestral WHERE id_curso=".$curso." group by id_ramo) as contador";
			$rs_examen = @pg_exec($conn,$sql);
			$cuenta_examen = @pg_result($rs_examen,0);
			$sql= "SELECT * FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND id_ano=".$ano." AND periodo=".$otro_periodo." AND rut_alumno=".$rut_alumno;
			$rs_nota = @pg_exec($conn,$sql);
			$nota_porc = 0;
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
			}
			if($nota_porc==0){
				$promedio1 = $fila_notas1['promedio'];
			}else{
				if($truncado_per==1){
					//echo " ..... promedio -->".($fila_notas1['promedio'] * $porc_examen)/100;					
					$promedio = round($nota_porc + (($fila_notas1['promedio'] * $porc_examen)/100));
				}else{
					$promedio = intval($nota_porc + (($fila_notas1['promedio'] * $porc_examen)/100));
				}
				
			}
			
			// FIN EXAMEN SEMESTRAL
			//$promedio1 = $fila_notas1['promedio'];
		}else{
			$promedio1 = $fila_notas1['notaap'];
			if(!isset($promedio1)){
				$promedio1 = $fila_notas1['promedio'];
			}
		}
		
		if ($promedio>0) 
		  	$cont_prom = $cont_prom + 1;
		if ($promedio1>0) 
		  	$cont_prom1 = $cont_prom1 + 1;
		//-------------------------------------
		// Eximidos
		//-------------------------------------
		$sql_inscri = "select count(*) as cantidad ";
		$sql_inscri = $sql_inscri . "from   tiene$ano_escolar ";
		$sql_inscri = $sql_inscri . "where rut_alumno = '".$rut_alumno."' and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$result_inscri =@pg_Exec($conn,$sql_inscri);
		$fila_inscri= @pg_fetch_array($result_inscri,0);
		if ($fila_inscri['cantidad'] == 0)
		{
			$promedio = "EX";
			$cont_prom = 1;
		}	
		else
		{
			if ($modo_eval <> 1)
			{
				if (trim($promedio)<>"0")
					$cont_prom = 1;
				else
					$cont_prom = 0;
				if (trim($promedio1)<>"0")
					$cont_prom1 = 1;
				else
					$cont_prom1 = 0;
			}
		}
		if ($promedio > 0)
		{
			$promedio_general = $promedio_general + $promedio;
			$cont_prom_general = $cont_prom_general + 1;
			$notas_arr[$i][$cont] = $promedio;
		}
		if ($promedio1 > 0)
		{
			$promedio_general1 = $promedio_general1 + $promedio1;
			$cont_prom_general1 = $cont_prom_general1 + 1;
			$notas_arr1[$i][$cont] = $promedio1;
		}
		
		
		
    ?>	
<!--    <td align="center"><font size="0" face="verdana,arial, geneva, helvetica"><? //if ($cont_prom>0 ) echo $promedio; else echo "&nbsp;"?></font></td>	-->
    <td align="center"><font size="0" face="verdana,arial, geneva, helvetica"><? 
			if ($promedio<40 && $promedio>0 && $cont_prom>0 ) { ?><font color="#FF0000"><?
				if ($_INSTIT==95666666 and $cod_subsector==13){
				    $promedio_conceptual = Conceptual($promedio,1);
					echo $promedio_conceptual;
				}else{
				    echo $promedio;
				}	 ?></font><? 
			}else if($promedio=='') { 
				echo "&nbsp;";
			}
			else{
			    if ($_INSTIT==95666666 and $cod_subsector==13){
				    $promedio_conceptual = Conceptual($promedio,1);
					echo $promedio_conceptual;
				}else{
				    echo $promedio;
				}	
			}
			?></font></td>
	<? }
	if ($promedio_general>0)
		if($truncado_per==1){
			$promedio_general= round($promedio_general/$cont_prom_general,0);
		}else{
			$promedio_general= substr($promedio_general/$cont_prom_general,0,2);
		}	
		//$promedio_general= round($promedio_general/$cont_prom_general,0);
	else
		$promedio_general= "&nbsp;";
	if ($promedio_general1>0)
		if($truncado_per==1){
			$promedio_general1= round($promedio_general1/$cont_prom_general1,0);
		}else{
			$promedio_general1= substr($promedio_general1/$cont_prom_general1,0,2);
		}	 
		//$promedio_general1= round($promedio_general1/$cont_prom_general1,0);
	else
		$promedio_general1= "&nbsp;";
		
	?>
    <td><div align="center"><font size="0" face="arial, geneva, helvetica">
	<? 
	echo $promedio_general; 
	if ($promedio_general>0) 
	{
		$cadena01 = $cadena01 . ";" . $promedio_general;
		$prom_prom = $prom_prom + $promedio_general;
		$cont_cont = $cont_cont + 1;
	}
	?>
	</font></div></td>
	<td><div align="center"><font size="0" face="arial, geneva, helvetica"><? echo $promedio_general1;
	if ($promedio_general1>0) 
	{
		$cadena011 = $cadena011 . ";" . $promedio_general1;
		$prom_prom1 = $prom_prom1 + $promedio_general1;
		$cont_cont1 = $cont_cont1 + 1;
	}?></font></div></td>
  	</tr>
  	<? } 
	?>	
  <tr>
    <td>&nbsp;</td>
    <td><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>Nota Menor</strong></font></td>
	<? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		for($i=0 ; $i < $numero_alumnos ; $i++)
		{
			if ($notas_arr[$i][$cont]>0)
			{
			if ($cadena=="")
				$cadena = $notas_arr[$i][$cont];
			else
				$cadena = $cadena . ";" . $notas_arr[$i][$cont];
			}	
		}
		$indice = explode(";",$cadena);
		sort($indice);
		?>
<!--		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? //if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></strong></font></td>	-->
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? 
				if($indice[0]<40 && $indice[0]>0) { ?><font color="#FF0000"><?
					echo $indice[0]; ?></font><? 
				}
				else if($indice[0]==''){ 
					echo "&nbsp;"; 
				}
				else{
					echo $indice[0]; 				
				}?></strong></font></td>
    <? }
	$indice = explode(";",$cadena01);
	sort($indice);
	?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[1]>0) echo $indice[1]; else echo "&nbsp;"; ?></strong></font></td>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
	<!-- nota menor -->
	<?
	$prom_final_menor = explode(";",$cadena011);
	sort($prom_final_menor);
	if($prom_final_menor[0]==''){
	    echo $prom_final_menor[1];
	}else{
	    echo $prom_final_menor[0];
	}
	?></strong></font>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>Nota Mayor </strong></font></td>
	<? 	
	$cadena = "0";
	$indice = "0";
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		for($i=0 ; $i < $numero_alumnos ; $i++)
		{
			if ($notas_arr[$i][$cont]>0)
			{
			if ($cadena=="")
				$cadena = $notas_arr[$i][$cont];
			else
				$cadena = $cadena . ";" . $notas_arr[$i][$cont];
			}	
		}
		$indice = explode(";",$cadena);
		rsort($indice);
		?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></strong></font></td>
    <? }
	$indice = explode(";",$cadena01);
	rsort($indice);
	?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?><strong></font></td>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
	<!-- promedio final mayor -->
	<?
	rsort($prom_final_menor);
	if($prom_final_menor[0]==''){
	    echo $prom_final_menor[1];
	}else{
	    echo $prom_final_menor[0];
	}
	?></strong></font>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>Nota Media </strong></font></td>
	<? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		$prom_resu = 0;
		$cont_resu = 0;		
		for($i=0 ; $i < $numero_alumnos ; $i++)
		{
			if ($notas_arr[$i][$cont]>0)
			{
				$prom_resu = $prom_resu + $notas_arr[$i][$cont];
				$cont_resu = $cont_resu + 1;
			}
		}
		if ($cont_resu>0) $prom_resu = round($prom_resu / $cont_resu,0)
		?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($prom_resu>0) echo $prom_resu; else echo "&nbsp;"; ?></strong></font></td>
    <? }?>

	<?
		$prom_resu = 0;
		$cont_resu = 0;
		$indice = explode(";",$cadena01);
		for($cont=0 ; $cont < $numero_alumnos; $cont++)
		{
			if ($indice[$cont]>0)
			{
				$prom_resu = $prom_resu + $indice[$cont];
				$cont_resu = $cont_resu + 1;
			}

		}
		if ($cont_resu>0) $prom_resu = round($prom_resu / $cont_resu,0)
	?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($prom_resu>0) echo $prom_resu; else echo "&nbsp;"; ?><strong></font></td>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
		<!-- promedio final medio -->
		<?
		$prom_final_medio = round($prom_prom1 / $cont_cont1);
		echo $prom_final_medio;
		?>
		</strong></font>		</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>Promedio del Curso</strong></font> </td>
	<?
	for($contxx=0 ; $contxx < $num_subsectores; $contxx++){
		$fila_sub = @pg_fetch_array($result_sub,$contxx);	
		$id_ramo = $fila_sub['id_ramo'];
	
	    // consulta para sacar el numero de p`romedios a promediar
	    $sql_prom_cu = "select count(promedio) as cantidad from notas$ano_escolar where id_ramo = '$id_ramo' and id_periodo = '$periodo' and promedio > '0' and rut_alumno in (select rut_alumno from matricula where id_curso = '$curso' and bool_ar = '0') and rut_alumno in (select rut_alumno from tiene$ano_escolar where id_ramo = '$id_ramo')";
	    $res_prom_cu = pg_Exec($conn,$sql_prom_cu);
	    $fil_prom_cu = pg_fetch_array($res_prom_cu);
	    $cantidad_notas = $fil_prom_cu['cantidad'];
		
		/// consulta para sacar la sumatoria de los promedios
		$sql_sum_cu = "select promedio from notas$ano_escolar where id_ramo = '$id_ramo' and id_periodo = '$periodo' and promedio > '0' and rut_alumno in (select rut_alumno from matricula where id_curso = '$curso' and bool_ar = '0') and rut_alumno in (select rut_alumno from tiene$ano_escolar where id_ramo = '$id_ramo')";
	    $res_sum_cu = pg_Exec($conn,$sql_sum_cu);
	    $num_sum_cu = pg_numrows($res_sum_cu);
		$sum_promedios=0;
		
		for ($xx=0; $xx < $num_sum_cu; $xx++){
	        $fil_sum_cu = pg_fetch_array($res_sum_cu,$xx);
			$promedio_cu = $fil_sum_cu['promedio'];
			$sum_promedios=$sum_promedios+$promedio_cu;
		}		
		
		$promedio_curso_actual = @round($sum_promedios/$cantidad_notas);
				
	    ?>	
        <td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
		 <?
		 if ($promedio_curso_actual>0){
		      echo $promedio_curso_actual;
			  $prom_final_curso=$prom_final_curso+$promedio_curso_actual;
			  $contador_final++;
		 }else{
		      echo "&nbsp; ";
		 }
		 ?></strong></font></td><?		
		
	}
	?>	
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
	<?
	$prom_final_final = @round($prom_final_curso/$contador_final);
	echo $prom_final_final;
	?></strong></font>	</td>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
		<!-- promedio final medio -->
		<?
		$prom_final_medio = round($prom_prom1 / $cont_cont1);
		echo $prom_final_medio;
		?>
		</strong></font>	</td>	   
  </tr>  
  </table>   </td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
</center>

<?
}

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
?>

<!-- FIN CUERPO DE LA PAGINA -->

</body>
</html>
<? pg_close($conn);?>