<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
//setlocale("LC_ALL","es_ES");
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$cmb_periodo;
	$ensenanza		=$cmb_ensenanza;

	$_POSP = 4;
	$_bot = 8;

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
	$ob_membrete ->ano=$ano;
	$ob_membrete ->periodo=$periodo;
	$ob_membrete ->periodo($conn);
	$periodo_pal = $ob_membrete->nombre_periodo . " DEL " . $nro_ano;
	
	$ob_reporte ->ano = $ano;
	$ob_reporte ->ensenanza =$ensenanza; 
	$result_curso = $ob_reporte->ListadoCurso($conn);
	
	//-----------------------------------------
	// Cantidad de Subsectores
	//-----------------------------------------
	/*$sql_sub = "select count(*) as cantidad from ramo where id_curso = ".$curso." ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$fila_sub = @pg_fetch_array($result_sub,0);	
	$num_subsectores = $fila_sub['cantidad'];*/
	
	//-----------------------------------------
	// Subsectores
	//-----------------------------------------
	$ob_reporte ->ano = $ano;
	$ob_reporte ->ensenanza =$ensenanza; 
	$result_sub = $ob_reporte ->ListadoSubsectores($conn);
	$num_subsectores = @pg_numrows($result_sub);
	
	
	/*$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.sub_obli, ramo.cod_subsector ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) and bool_ip = '1' ORDER BY ramo.id_orden; ";
	$result_sub =@pg_Exec($conn,$sql_sub );*/
	//-----------------------------------------	
	
	
if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Registro_Matricula_Ensenanza_$Fecha.xls"); 
	
}	
	
		
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
&nbsp;
<form name="form" method="post" action="printInformePromedioCurso_C.php?cmb_ensenanza=<?=$ensenanza?>&cmb_periodo=<?=$periodo?>">
<!-- INICIO CUERPO DE LA PAGINA -->


   
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
		  </TD>
		  <? if($_PERFIL==0){?>
		    <TD  align="right"><input name="exp" type="submit" class="botonXX" value="EXPORTAR"></TD>
			<? }?>
		</TR></TABLE>
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
    	<td class="tableindex"><div align="center">PROMEDIOS POR CURSO </div></td>
	</tr>
	<tr>
		<td ><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><? echo $periodo_pal?></strong> </font></div></td>
	</tr>
</table>
<br>
	
	<br>	<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="2" width="20" class="tablatit2-1">Nº</td>
	<td width="170" rowspan="2" class="tablatit2-1">CURSO</td>
    <td colspan="<? echo $num_subsectores+1 ?>" class="tablatit2-1"><div align="center">SUBSECTORES</div></td>
    </tr>
  <tr>
    <?	 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso =$fila_sub['nombre'];
    ?>	
    <td ><div align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong><? InicialesSubsector($subsector_curso) ?></strong></font></div></td>
	<? }?>
            <td align="center" ><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Final</strong></font></td>
    </tr>
    <?	 
	$numero_alumnos = @pg_numrows($result_curso);	 
	for($i=0 ; $i < @pg_numrows($result_curso) ;++$i)
	{
	  $fila = @pg_fetch_array($result_curso,$i);
	  ?>	
  <tr>
    <td align="center"><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
    <td><font size="0" face="arial, geneva, helvetica"><? echo substr($Curso_pal = CursoPalabra($fila['id_curso'], 0, $conn),0,25); ?></font></td>
	<?	 
	$promedio_general = 0;
	$cont_prom_general = 0;
	$Prom_Curso =0;
	$cont_curso = 0;
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$promedio=0;
		if($fila_sub['cod_subsector']!=13){
			$ob_reporte ->nro_ano = $nro_ano;
			$ob_reporte ->subsector = $fila_sub['cod_subsector'];
			$ob_reporte ->periodo = $periodo;
			$ob_reporte ->curso = $fila['id_curso'];
			$ob_reporte ->PromedioCurso($conn);
			$promedio = $ob_reporte->promedio;
			if($promedio > 0){
				$Prom_Curso = $Prom_Curso + $promedio;
				$cont_curso++;
				$notas_arr[$i][$cont] = $promedio;
			}
		}		
    ?>	
    <td align="center"><font size="0" face="arial, geneva, helvetica">
		<? if($promedio > 0 && $promedio < 40){?><font color="#FF0000">
		<?		echo $promedio; ?></font>
		<? }elseif($promedio >=40){
				echo $promedio;
		   }else{
				echo "&nbsp;";
			}
		?>
	</font></td>
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
	?>
    <td ><div align="center"><font size="0" face="arial, geneva, helvetica"><? echo round($Prom_Curso/$cont_curso); ?></font></div></td>
    </tr>
  	<? } ?>	
  <tr>
    <td>&nbsp;</td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Nota Menor</strong></font></td>
	<? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
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
		?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? 
			if($indice[0]<40 && $indice[0]>0){ ?><font color="#FF0000"><? 
				echo $indice[0];?></font><? 
			}
			else if($indice[0]==''){
				echo "&nbsp;"; 
			}
			else{
				echo $indice[0]; 
			}?></strong></font></td>
    <? }
	$indice = explode(";",$cadena02);
	sort($indice);
	?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></strong></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Nota Mayor </strong></font></td>
	<? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
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
		?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></strong></font></td>
    <? }
	$indice = explode(";",$cadena02);
	rsort($indice);
	?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></strong></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Nota Media </strong></font></td>
	<? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		$prom_resu = 0;
		$cont_resu = 0;		
		for($i=0 ; $i < $numero_alumnos ;++$i)
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
		$indice = explode(";",$cadena02);
		for($cont=0 ; $cont < $num_subsectores; $cont++)
		{
			if ($indice[$cont]>0)
			{
				$prom_resu = $prom_resu + $indice[$cont];
				$cont_resu = $cont_resu + 1;
			}

		}
		if ($cont_resu>0) $prom_resu = round($prom_resu / $cont_resu,0)
	?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($prom_resu>0) echo $prom_resu; else echo "&nbsp;"; ?></strong></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Promedio Instituci&oacute;n </strong></font></td>
	<?
		$prom_gral_inst =0;
		for($i=0 ; $i < $num_subsectores ;$i++){
			$Promedio_Gral_Sub =0;
			$cont_gral = 0;
			for($cont=0 ; $cont < @pg_numrows($result_curso); $cont++){
				if($notas_arr[$cont][$i] > 0){
					$Promedio_Gral_Sub = $Promedio_Gral_Sub + $notas_arr[$cont][$i];
					$cont_gral++;
				}
			}
			if($Promedio_Gral_Sub > 0){
				$prom_gral_inst = $prom_gral_inst + intval($Promedio_Gral_Sub/$cont_gral);
				$contador_final++;
			}
		?>
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
		<? if($Promedio_Gral_Sub > 0 ){
				echo round($Promedio_Gral_Sub/$cont_gral);
			}else{
				echo "&nbsp;";
			}
		?></strong></font></td>
	<? 	}?>

	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong>
	<?
	$prom_final_final = @round($prom_gral_inst/$contador_final);
	echo $prom_final_final;
	?></strong></font>
	</td>	   
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

</form>
</body>
</html>
<? pg_close($conn);?>
