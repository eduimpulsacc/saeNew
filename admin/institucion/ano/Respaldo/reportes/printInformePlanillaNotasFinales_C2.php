<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

//setlocale("LC_ALL","es_ES");

function imprime_arreglo($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";
}

	//$institucion	=$_INSTIT;
	//$ano			=$_ANO;
	//$curso			=$cmb_curso;
	//$reporte		=$c_reporte;
	//$fin_ano		=$check_ano;
		
	$institucion	=12086;
	$ano			=576;
	$curso			=9698;
	$reporte		=32;
	$fin_ano		=1;
	
	$_POSP = 4;
	$_bot = 8;
		
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/***************** INSTITUCION *****************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
	
	/************* AÑO ESCOLAR ****************/
	$ob_reporte ->ano =$ano;
	$ob_reporte ->AnoEscolar($conn);
	$nro_ano = $ob_reporte->nro_ano;
	
	/********* CURSO *******************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	/************* PROFE JEFE *************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************* SUBSECTOR ****************/
	$ob_reporte ->curso = $curso;
	$ob_reporte ->SubsectorRamo($conn);
	$result_sub = $ob_reporte ->result;
	$num_subsectores = @pg_numrows($result_sub);
	
	
	/******* ALUMNOS ************************/
	$ob_reporte ->ano =$ano;
	$ob_reporte ->curso = $curso;
	$ob_reporte ->orden = $orden;
	$ob_reporte ->retirado=0;
	$result_alu = $ob_reporte ->FichaAlumnoTodos($conn);
	
	//echo $curso;
	//if (empty($curso)) //exit;
  
    if (($curso != 0) or ($curso != NULL)){	
	    $query_curso="select * from curso where id_curso='$curso'";
	    $row_curso=pg_fetch_array(pg_exec($conn,$query_curso));
	}
	
	
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	/*$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.bool_ar ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) AND matricula.bool_ar = 0 ";
	if ($_INSTIT==14912 or $_INSTIT == 769){
	     $sql_alu = $sql_alu . "ORDER BY matricula.nro_lista";
	}else{	
	     $sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
    }
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-----------------------------------------
	// Cantidad de Subsectores
	//-----------------------------------------
	/*$sql_sub = "select count(*) as cantidad from ramo where id_curso = ".$curso." ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$fila_sub = @pg_fetch_array($result_sub,0);	
	echo $num_subsectores = $fila_sub['cantidad'];
	
	//-----------------------------------------
	// Subsectores
	//-----------------------------------------
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.sub_obli, ramo.cod_subsector ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	echo "<br>".$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) and bool_ip = '1' ORDER BY ramo.id_orden; ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	//-----------------------------------------	
	*/
	
	
	
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

<!-- INICIO CUERPO DE LA PAGINA -->

<?

if (empty($curso)){
     //exit;
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
      <tr align="right">
        <td>
		<div id="capa0">
		<TABLE width="100%"><TR><TD><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></TD><TD  align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </TD></TR></TABLE>
        </div>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	
	
	
	
	
<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>	
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
		<?
		$result = @pg_Exec($conn,"select insignia, rdb from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

		  if($institucion!=""){
			   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
		  }else{
			   echo "<img src='".$d."menu/imag/logo.gif' >";
		  }?>
	  		</td>
		</tr>
    </table>
	</td>
  </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>

<? } ?>



<table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td class="tableindex"><div align="center">PLANILLA DE NOTAS FINALES</div></td>
	</tr>
	<tr>
		<td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>AÑO <? echo $nro_ano?></strong> </font></div></td>
	</tr>
</table>
<br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">

            <td width="120"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></div></td>
        <td width="526"><font size="1" face="arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
            <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><? echo $ob_reporte->profe_jefe;?></font></td>
      </tr>
    </table>
	<br>	<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="2" width="20" class="tablatit2-1">Nº</td>
	<td width="170" rowspan="2" class="tablatit2-1">NOMBRE DEL ALUMNO</td>
    <td colspan="<? echo $num_subsectores+1 ?>" class="tablatit2-1"><div align="center">SUBSECTORES</div></td>
    </tr>
  <tr>
    <?	 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$cod_subsector = $fila_sub['cod_subsector'];
		$modo_eval = $fila_sub['modo_eval'];
		$examen = $fila_sub['conex']; // 1 SI 2 NO
    ?>	
    <td ><div align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong>
    <? InicialesSubsector($subsector_curso) ?>
</strong></font></div></td>
	<? }?>
            <td align="center" ><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Final</strong></font></td>
    </tr>
    <?	 
	$numero_alumnos = @pg_numrows($result_alu);	 
	for($i=0 ; $i < @pg_numrows($result_alu) ;$i++)
	{
	  $fila_alu = @pg_fetch_array($result_alu,$i);
	  $nombre_alu = ucwords(strtolower(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu'])));
	  $rut_alumno = $fila_alu['rut_alumno'];
	  ?>	
  <tr>
    <td align="center"><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
    <td><font size="0" face="arial, geneva, helvetica"><? echo substr($nombre_alu,0,25); ?></font></td>
	<?	 
	$promedio_general = 0;
	$cont_prom_general = 0;
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$modo_eval = $fila_sub['modo_eval'];
		$cod_subsector = $fila_sub['cod_subsector'];
		$examen = $fila_sub['conex']; // 1 SI 2 NO
		$obliga = $fila_sub['sub_obli'];
		//---------------------------------------
		// Notas
		//-------------------------------------
		// Eximidos
		//-------------------------------------
		$sql_inscri = "select count(*) as cantidad ";
		$sql_inscri = $sql_inscri . "from   tiene$nro_ano ";
		$sql_inscri = $sql_inscri . "where rut_alumno = ".$rut_alumno."and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$result_inscri =@pg_Exec($conn,$sql_inscri);
		$fila_inscri= @pg_fetch_array($result_inscri,0);
		if (($fila_inscri['cantidad'] == 0)&&($obliga==1))
		{
			$promedio = "EX";
			$cont_prom=1;
		}
		else
		{
		//-----------------------------------
			if ($examen==1 and $fin_ano == 1)
			{
				/*$sql_notas = "SELECT situacion_final.nota_final ";
				$sql_notas = $sql_notas . "FROM situacion_final ";
				$sql_notas = $sql_notas . "WHERE (((situacion_final.rut_alumno)=".$rut_alumno.") AND ((situacion_final.id_ramo)=".$id_ramo.")); ";*/
				
				$sql_notas = "SELECT promedio FROM promedio_sub_alumno WHERE rut_alumno=".$rut_alumno." AND id_ramo=".$id_ramo;
				$result_notas =@pg_Exec($conn,$sql_notas);
				$promedio = 0;
				$cont_prom = 0;			
				if (@pg_numrows($result_notas)>0)
				{
					$fila_notas = @pg_fetch_array($result_notas,0);
					if ($modo_eval==1)
					{
						if ($fila_notas['nota_final']>0)
						{
							$promedio = $fila_notas['nota_final'];
							$cont_prom = 1;
						}
						else
						{
							$promedio = "&nbsp;";
						}
					}
					else
					{
						if (trim($fila_notas['nota_final'])<>"0"){
							$promedio = $fila_notas['nota_final'];
							$cont_prom = 0;
						}else{ $promedio = "&nbsp;";
						}
					}  
				}
				else
				{
					$promedio = "&nbsp;";
					$cont_prom = 0;
					$e = @pg_numrows($result_notas);
				}
		}
		else
		{
			$prom_se=0;
			$cont_se=0;
			$result_notas=0;
			$sql_notas = "select promedio from notas$nro_ano where rut_alumno = '$rut_alumno' and id_ramo in (select id_ramo from tiene$nro_ano where rut_alumno = '$rut_alumno' and id_ramo = '$id_ramo')";
			$result_notas =@pg_Exec($conn,$sql_notas);
			for($cc=0 ; $cc < @pg_numrows($result_notas) ; $cc++)
			{
				$fila_notas = pg_fetch_array($result_notas,$cc);
				if ($modo_eval == 1)
				{
					
					if ((trim($fila_notas['promedio'])>'0')&&(trim($fila_notas['promedio'])!='0'))
					{	//echo "<br> otra cosa que na que ver";
						//echo "<br> promedio ".$fila_notas['promedio'];
						$prom_se = $prom_se + $fila_notas['promedio'];
						$cont_se = $cont_se + 1;
					}
				}
				else
				{
					//echo "<br> else";
					if ((trim($fila_notas['promedio'])!="0") and (trim($fila_notas['promedio'])!=""))
					{
						$prom_se = $prom_se + Conceptual($fila_notas['promedio'],2);
						$cont_se = $cont_se + 1;
					}
					
				}
			}
			if ($modo_eval == 1)
			{
				if ($prom_se>0){
					if ($row_curso[truncado_per]==1){
						$prom_se = round($prom_se/$cont_se,0);
					}
					if ($row_curso[truncado_per]==0){
						$prom_se = floor($prom_se/$cont_se	);
					}
				}else
					$prom_se="&nbsp;";
			}
			else
			{
				if ($prom_se>0)
				{
					$prom_se = round($prom_se/$cont_se,0);
					$prom_se  = Conceptual($prom_se,1);
				}
				else
					$prom_se="&nbsp;";
			}
			
			$promedio = $prom_se;
		}
		//-----------------------------------
		}
		if ($promedio > 0 and $modo_eval == 1)
		
		{
		
	if (($id_ramo!=16080) and ($id_ramo!=16072) and ($id_ramo!=16064) and ($id_ramo!=16056))   {
			$promedio_general = $promedio_general + $promedio;
			$cont_prom_general = $cont_prom_general + 1;
			$cont_prom_fin = $cont_prom_fin + 1;
			$nota_media = $nota_media + $promedio;
			
		}}
		$notas_arr[$i][$cont] = $promedio;
    ?>	
    <td align="center"><font size="0" face="arial, geneva, helvetica"><?
	        //////// NUEVO CÓDIGO ESPECIAL PARA SAN VIATOR  ////////
		     if ($_INSTIT==769 and $cod_subsector==13){
		     ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
				 
				    $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano where rut_alumno = ".$rut_alumno." and id_ramo = '$id_ramo'";
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
						
					$promedio_ramo = @intval($prom / $con_notas);
					
					/////////////// como es modo de evaluacion 3 debo convertir el promedio a conceptual //////////////////
					if ($promedio_ramo > 0 and $promedio_ramo < 40){
						$promedio_nota = "I";
					}
					if ($promedio_ramo > 39 and $promedio_ramo < 50){
						$promedio_nota = "S";
					}
					if ($promedio_ramo > 49 and $promedio_ramo < 60){
						$promedio_nota = "B";
					}
					if ($promedio_ramo > 59 ){
						$promedio_nota = "MB";
					}
					////////////////////////////////////////////////////////////////////////
					$promedio = $promedio_nota;
		
		    }
	
			if($fin_ano==1){
				$sql = "SELECT promedio FROM promedio_sub_alumno WHERE id_ramo=".$id_ramo." AND rut_alumno=".$rut_alumno;
				$rs_promedio = @pg_exec($conn,$sql);
				$promedio = @pg_result($rs_promedio,0);
			}
	
	
			if($promedio<40 && $promedio>0){ ?><font color="#FF0000"><?
				 if ($_INSTIT==9566 and $cod_subsector==13){
					if($promedio > 0){
						$promedio_conceptual = Conceptual($promedio,1);
						echo $promedio_conceptual;
					}else{
						echo $promedio;
					}
				}else{		
				    echo $promedio;
				}	 ?></font><? 
			}
			else if($promedio=='') { 
				echo "EX";
			}
			else{
				 if ($_INSTIT==9566 and $cod_subsector==13){
					if($promedio > 0){
						$promedio_conceptual = Conceptual($promedio,1);
						echo $promedio_conceptual;
					}else{
						echo $promedio;
					}
				}else{		
				    echo $promedio;
				}	
			} ?></font></td>
	<? }
	if ($promedio_general>0){ 
	    if ($row_curso[truncado_per]==1 and $_INSTIT!=770){
		
		    if (($_INSTIT==769) and ($row_curso[truncado_final]==0)){		
		          $promedio_general = intval($promedio_general/$cont_prom_general,0);
		    }else{
			      $promedio_general= round($promedio_general/$cont_prom_general,0);
			
			}
		} else { 	
		    $promedio_general= floor($promedio_general/$cont_prom_general);
		}
		
  	} else {
		$promedio_general= "&nbsp;";
	}
	if($fin_ano==1){
		$sql = "SELECT promedio FROM promocion WHERE id_curso =".$curso." AND rut_alumno=".$rut_alumno;
		$rs_promediogral = @pg_exec($conn,$sql);
		$promedio_general = @pg_result($rs_promediogral,0);
	}
	?>
    <td ><div align="center"><font size="0" face="arial, geneva, helvetica">
	<? 
	echo $promedio_general; 
	if (empty($cadena02))
	{ 
		if ($promedio_general>0) 
		{
			$cadena02 = $promedio_general; 
			$prom_general_ind = $prom_general_ind + $promedio_general;
			$cont_general_ind = $cont_general_ind + 1;
		}
	}
	else
	{ 
		if ($promedio_general>0) 
		{
			$cadena02 = $cadena02 . ";" . $promedio_general;
			$prom_general_ind = $prom_general_ind + $promedio_general;
			$cont_general_ind = $cont_general_ind + 1;
		}
	}
	?>
	</font></div></td>
    </tr>
  	<? } 
	?>	
  <tr>
    <td>&nbsp;</td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Nota Menor</strong></font></td>
	<? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++){
	 
	 if($fin_ano==1){
			//echo "anño".$fin_ano;       
			$fila_sub1 = @pg_fetch_array($result_sub,$cont);	
			$id_ramo1 = $fila_sub1['id_ramo'];
			$modo_eval1 = $fila_sub1['modo_eval'];
	  if($modo_eval1==2){
		
			$min_valor="-";
		}else{
			//echo "año=".$fin_ano;
			$ob_min=new Reporte();
			$ob_min->institucion=$institucion;
			$ob_min->curso=$curso;
			$ob_min->ramo=$id_ramo1;
			$ob_min->ano=$ano;
			$res=$ob_min->Minimo($conn);
			$min_valor=pg_result($res,0);
	// if($min_valor==0){
	 
	// }else{
			//echo $min_valor;
			
		//	$sql="SELECT min(promedio) FROM promedio_sub_alumno WHERE rdb=".$institucion." and id_curso=".$curso." ";
		//	$sql.="and id_ramo=".$id_ramo1."  and id_ano=".$ano." and rut_alumno in (SELECT rut_alumno FROM ";
		//	$sql.="matricula WHERE bool_ar=0) ";	
		//	$res=pg_exec($conn,$sql);
		//	$min_valor=pg_result($res,0);
			
		if($min_valor==NULL or $min_valor=="-" or $min_valor=="MB" or $min_valor=="B"){
			
			}else{
			
		  $prom_min=$prom_min+$min_valor;
			
		}
			if($min_valor==NULL or $min_valor=="-" or $min_valor==0 or $min_valor=="MB" or $min_valor=="B"){
			
				}else{
			
				$contador_final_min++;
			
				}
		 
	 }
		 }else{
	
		$cadena = "";
		$indice = "";
		for($i=0 ; $i < $numero_alumnos ;++$i)
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
		}
	
		?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
		<?	if ($fin_ano==1){
		if($min_valor<40 && $min_valor>0){ ?><font color="#FF0000"><? echo $min_valor;?></font><? 
			}
			else if($min_valor==''){
				echo "-"; 
			}else{
				echo $min_valor; 
							
			}?></strong></font>
		
		<?
			}else{
		
		   if($indice[0]<40 && $indice[0]>0){ ?><font color="#FF0000"><? 
				echo $indice[0];?></font><? 
			}
			else if($indice[0]==''){
				echo "&nbsp;"; 
			}
			else{
				echo $indice[0]; 
			}
		   }
		 }
		 ?></strong></font></td>
    <? 
	if($fin_ano==1){
		$prom_min_final = intval($prom_min/$contador_final_min);
	}else{
		$indice = explode(";",$cadena02);
		sort($indice);
	}
	?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
	<? if($fin_ano==1){ if($prom_min_final>0)  echo round($prom_min_final); else echo "-"; }else{ if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; }?></strong></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Nota Mayor </strong></font></td>
	<? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++){
	if($fin_ano==1){
	
				$fila_sub2 = @pg_fetch_array($result_sub,$cont);	
				$id_ramo2 = $fila_sub2['id_ramo'];
				$modo_eval2 = $fila_sub2['modo_eval'];
		if($modo_eval2==2){
		
			$max_valor="-";
		}else{		
				
				$ob_max=new Reporte();
				$ob_max->institucion=$institucion;
				$ob_max->curso=$curso;
				$ob_max->ramo=$id_ramo2;
				$ob_max->ano=$ano;
				$resp=$ob_max->Maximo($conn);
				$max_valor=pg_result($resp,0);
					
			//	$sql="SELECT max(promedio) FROM promedio_sub_alumno WHERE rdb=".$institucion." and id_curso=".$curso." ";
			//	$sql.="and id_ramo=".$id_ramo2."  and id_ano=".$ano." and rut_alumno in (SELECT rut_alumno FROM ";
			//	$sql.="matricula WHERE bool_ar=0) ";	
			//	$res=pg_exec($conn,$sql);
			//	$max_valor=pg_result($res,0);
				
			if($max_valor==NULL or $max_valor=="-" or $max_valor=="MB" or $max_valor=="B"){
			
				}else{	
						
				$prom_max=$prom_max+$max_valor;
				}
			
					if($max_valor==NULL or $max_valor=="-" or $max_valor==0 or $max_valor=="MB" or $max_valor=="B"){
			
						}else{
			
						$contador_final_max++;
						}
	}
	}else{	

		$cadena = "";
		$indice = "";
		for($i=0 ; $i < $numero_alumnos ;++$i)
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
		
		}
		?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
		<? if($fin_ano==1){ if($max_valor!==NULL){ echo $max_valor ;}else{ echo "-"; }
		}else{ if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; }?></strong></font></td>
    <? }
	  if($fin_ano==1){
	  
	 	$prom_max_final = intval($prom_max/$contador_final_max);
	  }else{
		$indice = explode(";",$cadena02);
		rsort($indice);
		}
	?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
	<? if($fin_ano==1){ if($prom_max_final>0)  echo round($prom_max_final); else echo "-";  }else{ if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; } ?></strong></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Promedio del Curso</strong></font></td>
	<?
	for($contxx=0 ; $contxx < $num_subsectores; $contxx++){
		if($fin_ano==1){
		
			$fila_sub3 = @pg_fetch_array($result_sub,$contxx);	
			$id_ramo3 = $fila_sub3['id_ramo'];
			$modo_eval3 = $fila_sub3['modo_eval'];
     if($modo_eval3==2){
	 
	 	$promedio="-";
		
	  }else{	
			$ob_promedio=new Reporte();
			$ob_promedio->institucion=$institucion;
			$ob_promedio->curso=$curso;
			$ob_promedio->ramo=$id_ramo3;
			$ob_promedio->ano=$ano;
			$respu=$ob_promedio->Promedio($conn);
	
			$promedio=pg_result($respu,0);
	
	//$sql="SELECT avg(cast(promedio as integer)) FROM promedio_sub_alumno WHERE rdb=".$institucion." and id_curso=".$curso." ";
	//$sql.="and id_ramo=".$id_ramo3."  and id_ano=".$ano." and rut_alumno in (SELECT rut_alumno FROM ";
	//$sql.="matricula WHERE bool_ar=0) ";	
	//$res=pg_exec($conn,$sql);
	//$promedio=pg_result($res,0);
				
		if($promedio==NULL or $promedio=="-" or $promedio=="MB" or $promedio=="B" ){
			
			}else{	
			$suma_promedio=$suma_promedio+$promedio;
			}
			
			  if($promedio==NULL or $promedio=="-" or $promedio==0 or $promedio=="MB" or $promedio=="B" ){
			
				}else{
			
				$contador_pro++;
			
				}
	  }
	
		}else{
		$fila_sub = @pg_fetch_array($result_sub,$contxx);	
		$id_ramo = $fila_sub['id_ramo'];
		
		/*$ob_reporte ->ramo = $id_ramo;
		$ob_reporte ->nro_ano = $nro_ano;
		$ob_reporte ->PromedioRamoCurso($conn);*/
		
	
	    // consulta para sacar el numero de promedios a promediar
	    $sql_prom_cu = "select count(promedio) as cantidad from notas$nro_ano where id_ramo = '$id_ramo' and promedio > 0 and rut_alumno in (select rut_alumno from matricula where id_curso = '$curso' and bool_ar = '0') and rut_alumno in (select rut_alumno from tiene$nro_ano where id_ramo = '$id_ramo')";
	    $res_prom_cu = pg_Exec($conn,$sql_prom_cu);
	    $fil_prom_cu = pg_fetch_array($res_prom_cu);
	    $cantidad_notas = $fil_prom_cu['cantidad'];
		
		/// consulta para sacar la sumatoria de los promedios
		$sql_sum_cu = "select promedio from notas$nro_ano where id_ramo = '$id_ramo' and promedio > 0 and rut_alumno in (select rut_alumno from matricula where id_curso = '$curso' and bool_ar = '0') and rut_alumno in (select rut_alumno from tiene$nro_ano where id_ramo = '$id_ramo')";
	    $res_sum_cu = pg_Exec($conn,$sql_sum_cu);
	    $num_sum_cu = pg_numrows($res_sum_cu);
		$sum_promedios=0;
		
		for ($xx=0; $xx < $num_sum_cu; $xx++){
	        $fil_sum_cu = pg_fetch_array($res_sum_cu,$xx);
			$promedio_cu = $fil_sum_cu['promedio'];
			$sum_promedios=$sum_promedios+$promedio_cu;
		}		
		
		$promedio_curso_actual = @round($sum_promedios/$cantidad_notas);
	}
 	
	    ?>	
        <td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
		 <?
		if($fin_ano==1){
		 if ($promedio>0){
		      echo intval($promedio,0);
		  }else{
		      echo "-";
		 }
		
		}else{
		 if ($promedio_curso_actual>0){
		      echo $promedio_curso_actual;
			  $prom_final_curso=$prom_final_curso+$promedio_curso_actual;
			  $contador_final++;
		 }else{
		      echo "&nbsp;";
		 }
		}
		 ?></strong></font></td><?
	 }	
	 	if($fin_ano==1){
		$promedio_final_final = intval($suma_promedio/$contador_pro);
		}else{
		$prom_final_final = intval($prom_final_curso/$contador_final);
		}
		
	?>	
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
	<?
	if($fin_ano==1){
	 	echo $promedio_final_final;
	}else{
		echo $prom_final_final;
	}
	?></strong></font>	</td>	   
  </tr>
	</table>	
	</td>
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
?>  

<?
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
