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

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$periodo;
	$_POSP = 4;
	$_bot = 8;
	
	if ($periodo==0){
	   ## nada
	}else{
		 
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle']))." ".$fila_institu['nro']." - ".strtoupper($fila_institu['nom_com']);
	$telefono = $fila_institu['telefono'];
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	//----------------------------------------------------------------------------
	// DATOS PERIODO
	//----------------------------------------------------------------------------
	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'] . " DEL " . $nro_ano;
	//----------------------------------------------------------------------------
	// DATOS CURSO
	//----------------------------------------------------------------------------	
	if ($curso == 0){
		$sql_curso = "select * from curso where id_ano= ".$ano ." order by ensenanza, grado_curso, letra_curso";
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
	
}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//-->
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($periodo==0){
   ## nada
}else{
   ?>   
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
        </div>
      </div></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <table width="650" border="0" cellspacing="0" cellpadding="0">
	   <tr>
		<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia'])){ 
	       if($institucion!=""){
		       echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	       }else{
		       echo "<img src='".$d."menu/imag/logo.gif' >";
	       } 
		   ?>
		   </td>
		   <td width="50">&nbsp;</td>
		   <td>
	
		   <table>
			 <tr>
			   <td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $nombre_institu;?></strong></font></div></td>
			 </tr>
		   </table>
		   <table>
		     <tr>
				<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $direccion;?></strong></font></div></td>
			 </tr>
		   </table>
		   <table>
		     <tr>
				<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $telefono;?></strong></font></div></td>
			 </tr>
		   </table>
		   </td>

	<? }else{?>
		    <td>
			<table width="100%">
			  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $nombre_institu;?></strong></font></div></td>
				</tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $direccion;?></strong></font></div></td>
				</tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $telefono;?></strong></font></div></td>
				</tr>
			</table>
		    </td>
	<? }  ?>
	</tr>
</table>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr><td colspan=3>&nbsp;</td></tr>
  <tr>
    <td colspan=3 class="tableindex"><div align="center">RENDIMIENTO GRÁFICO POR TIPO DE ENSEÑANZA</div></td>
    </tr>
  <tr>
    <td colspan=3><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $periodo_pal;?></strong></font></div></td>
  </tr>  
</table>

<table width="650" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
      <td bgcolor="#ffffff" rowspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><b>TIPOS DE ENSEÑANZA</b></font></td>
	  <td colspan="7" align="center" bgcolor="#ffffff"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">Rango de notas</font></td>
	  <td width="40" bgcolor="#c8d6fb" align="center" rowspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Promedio</font></td>
  </tr>
  <tr>
      
	  <td width="40" bgcolor="#FFFFFF" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0-10</font></td>
	  <td width="40" bgcolor="#FFFFFF" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">11-20</font></td>
	  <td width="40" bgcolor="#FFFFFF" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">21-30</font></td>
	  <td width="40" bgcolor="#FFFFFF" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">31-40</font></td>
	  <td width="40" bgcolor="#FFFFFF" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">41-50</font></td>
	  <td width="40" bgcolor="#FFFFFF" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">51-60</font></td>
	  <td width="40" bgcolor="#FFFFFF" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">61-70</font></td>
	  
  </tr>
  <?
  $institucion	=$_INSTIT;
  $ano			=$_ANO;
  // aqui muestro todos los curso de la institución
  $sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
  $sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
  $sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
  $sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
  $resultado_query_cue = pg_exec($conn,$sql_curso);
  
  $suma_promedio = 0; $contador = 0; $anchotabla = 0;
  
  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
     $fila = @pg_fetch_array($resultado_query_cue,$i); 
	 $filanex = @pg_fetch_array($resultado_query_cue,$i+1); 
	 $id_curso = $fila['id_curso'];
	 $tipo_ensenanza = $fila['ensenanza'];
	 $tipo_ensenanzanex = $filanex['ensenanza'];
     $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
	 
	 // aqui tomo todos los promedios de este curso
	 $sql_prom = "select promedio from notas$nro_ano where id_ramo in (select id_ramo from ramo where id_curso = '$id_curso') and id_periodo = '$periodo'";
	 $res_prom = pg_Exec($conn,$sql_prom);
	 $num_prom = pg_numrows($res_prom); 
	 
	 for ($j=0; $j<$num_prom; $j++){
	     $fila_prom = pg_fetch_array($res_prom,$j);
		 $promedio = $fila_prom['promedio'];
		 if ($promedio>0){
		    $suma_promedio = ($suma_promedio + $promedio);
			$contador++;
		 }	
	 }
	 $promedio_curso = @round($suma_promedio / $contador);
	 $anchotabla = ($promedio_curso * 4) + 1;
	 
	 if ($tipo_ensenanza==$tipo_ensenanzanex){
	     // no muestro aun el promedio
		 // y sigo acumulando
	 }else{
	     // muestro el promedio y luego limpio las variables
		 // busco el nombre de tipo de ensenanza
		 $sql_te = "select * from tipo_ensenanza where cod_tipo = '$tipo_ensenanza'";
		 $res_te = @pg_Exec($conn,$sql_te);
		 $fila_te = pg_fetch_array($res_te,0);
		 
		 $nombre_tipo_ensenanza = $fila_te['nombre_tipo'];	
	   
	     ?>
	      <tr>
		  <td bgcolor="#FFFFFF" height="20"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo "$nombre_tipo_ensenanza"; ?></font></td>
		  <td colspan="7" width="280" bgcolor="#FFFFFF">
		  <? if ($promedio_curso==0){ 
		         ?>&nbsp; <? 
			 } else{ ?>
			      <table border="2" cellpadding="0" cellspacing="0" height="13">
				      <tr>
					      <td  width="<?=$anchotabla ?>"></td>
						  <td  width="9"></td>
					  </tr>
				  </table>
			<? } ?>
			</td>
		  <td bgcolor="#c8d6fb" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? if ($promedio_curso==0){ ?> &nbsp; <? }else{ ?><? echo "$promedio_curso"; ?><? } ?></font></td>
	      </tr>
	     <?
	     // limpio las variables
		 $suma_promedio = 0; $contador = 0; $anchotabla = 0;	 
	 }	 
  }
?>
</table>
<hr width="100%" color=#003b85>
</tr>
</table>  
<? if  (($cantidad_cursos - $i)<>1) 
    	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
?>
</center>
<?
}
?>
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>