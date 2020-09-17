<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script> 
<?
/*if($_PERFIL==0){
	print_r($_POST);
	}*/
require('../../../../util/header.inc'); 
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	= $_INSTIT;
    $ano			= $_POST['cmbANO'];
	$curso			= $cmb_curso;
	$alumno 		= $cmb_alumno;
	$reporte		= $c_reporte;
	$tipo_examen	=$conexamen;
	$_POSP = 4;
	$_bot = 8;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano=$ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS CURSO************/
	$ob_reporte ->ano=$ano;
	$result_curso=$ob_reporte->CursoEnsenanza_fin_ano($conn);
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	@$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
if($cb_ok!="Buscar"){
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_notas_finales_$fecha_actual.xls"); 	 
}	
	
  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">
			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
			
	function exportar(){
		   	//form.target="_blank";
			window.location='printInformeSituacionFinalAnual.php?cmbANO=<?=$ano?>&xls=1';
			//form.submit(true);
			return false;
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
 
 #ensepre{
	float:center;
	overflow:auto;
	text-align:center;
	font-family:Arial;
	font-size:0.8em;
	border:0px solid #808080;

}
#tablas { border-collapse:collapse;
 }
 
#izquierda {
float:left;
margin-left:175px;
}

#derecha {
float:right;
margin-right:175px;
border: 1px solid #000;
width:130px
}
#fecha{
margin-right:10px;

}

 
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
		<table width="100%">
		  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   
		  value="CERRAR">
          
		  </td>
		<td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" 
		value="EXPORTAR">
			<? }?>
		  </td></tr></table>
      </div>
    </td>
  </tr>
</table>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" class="item"><strong><? echo strtoupper(trim($ob_membrete->ins_pal));?></strong></td>
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
	  }?>		  </td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<BR>
<table width="650"  border="0" cellpadding="2" cellspacing="1">
<tr>
   <td class=""><div align="center" class="subitem"><u>SITUACION FINAL PERIODO ACADEMICO AÑO <?=$nro_ano?></u></div></td>
	</tr>
    <tr><td>
    <br><br>

</div>
</td>
</tr>
</table>
<?
for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
	{
		$fila_curso = @pg_fetch_array($result_curso,$i);
		$id_curso = $fila_curso['id_curso'];
	$ensenanza = $fila_curso['ensenanza'];
	
	$sql_grado="select * from tipo_ensenanza where tipo_ensenanza.cod_tipo=".$ensenanza;
		$result_grado = @pg_Exec($conn,$sql_grado);
		$fila_grado = @pg_fetch_array($result_grado,0);
		$nombre_grado=$fila_grado['nombre_tipo'];
	?>
   <br>
<div id="ensepre">
<u><?=$nombre_grado;?></u>
<BR><BR>
<table  id="tablas" width="650"  border="1" align="center"  cellpadding="1" cellspacing="1">
<tr class="item" id="td_tablas">
<th>Cursos</th>
<th>Matricula</th>
<th>Nº Cursos</th>
<th>Aprobados</th>
<th>Reprobados</th>
<th>Retirados</th>
<th>% Aprobados</th>
</tr>
<?
	 $sql_cursos="select DISTINCT grado_curso from promocion
    inner join curso on promocion.id_curso=curso.id_curso
    where promocion.id_ano=$ano and curso.ensenanza=$ensenanza";
	$result_cursos =@pg_exec($conn,$sql_cursos) or die ("SELECT FALLÓ:".$sql_cursos);
	for($j=0 ; $j < @pg_numrows($result_cursos) ; $j++)
	{
	$fila_cursos = @pg_fetch_array($result_cursos,$j);
	 $grado_curso=$fila_cursos['grado_curso'];
	 
	 $sql="select count(*)  as total from curso
	inner join matricula on curso.id_curso=matricula.id_curso
	where curso.ensenanza=$ensenanza and curso.grado_curso=$grado_curso and curso.id_ano=".$ano;
	$result_cant =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
	$fila_cant = @pg_fetch_array($result_cant,0);
	$totalal2=$fila_cant['total'];
	
	 $sql_cant_curso="select curso.grado_curso from curso
    where curso.ensenanza=$ensenanza and curso.grado_curso=$grado_curso and curso.id_ano=".$ano;
	$result_cant_curso =@pg_exec($conn,$sql_cant_curso) or die ("SELECT FALLÓ:".$sql_cant_curso);
	$fila_cant_curso = @pg_numrows($result_cant_curso);
	
 $sql_prom1="select  pr.situacion_final from promocion as pr 
               inner join curso on pr.id_curso=curso.id_curso
               where curso.grado_curso=$grado_curso and pr.id_ano=$ano and curso.ensenanza=$ensenanza and situacion_final=1";
	 		   $result_cant_ap =@pg_exec($conn,$sql_prom1) or die ("SELECT FALLÓ:".$sql_prom1);
	           $fila_cant_ap = @pg_numrows($result_cant_ap);	
	
 $sql_prom2="select  pr.situacion_final from promocion as pr 
               inner join curso on pr.id_curso=curso.id_curso
               where curso.grado_curso=$grado_curso and pr.id_ano=$ano and curso.ensenanza=$ensenanza and situacion_final=2";
	 		   $result_cant_rep =@pg_exec($conn,$sql_prom2) or die ("SELECT FALLÓ:".$sql_prom2);
	           $fila_cant_rep = @pg_numrows($result_cant_rep);	

 $sql_prom3="select  pr.situacion_final from promocion as pr 
               inner join curso on pr.id_curso=curso.id_curso
               where curso.grado_curso=$grado_curso and pr.id_ano=$ano and curso.ensenanza=$ensenanza and situacion_final=3";
	 		   $result_cant_ret =@pg_exec($conn,$sql_prom3) or die ("SELECT FALLÓ:".$sql_prom3);
	           $fila_cant_ret = @pg_numrows($result_cant_ret);			   
			   
	
	
				
			   $porcen2=round(($fila_cant_ap*100)/$totalal2);
			   
			  if($ensenanza==10 and $grado_curso=5){
				  $grado_curso="T2N";
				  }else if($ensenanza==10 and $grado_curso=4){
					  $grado_curso="T1N";
					  }else{
						  $grado_curso=$grado_curso."º";
						  }
	                    
			   
    ?> 
     <tr align="center" border="1" class="item" id="td_tablas">
     <td><?=$grado_curso?></td>
     <td><?=$totalal2;?></td> 
     <td><?=$fila_cant_curso;?></td> 
     <td><?=$fila_cant_ap;?></td>
     <td><?=$fila_cant_rep;?></td>
     <td><?=$fila_cant_ret;?></td>
     <td><?=$porcen2."%";?></td>
     <?
   // echo "total-->".$totalal;
     ?>
	<? }
	
?>
</table>
<br>
<div id="ensepre">
<table  id="tablas" width="650" border="1" align="center"   cellpadding="1" cellspacing="1">
<tr align="center" class="item" id="td_tablas">
     <td width="61">Total</td>
     
     <? 
	 $sql_t="select count(*)  as total from curso
	inner join matricula on curso.id_curso=matricula.id_curso
	where curso.ensenanza=$ensenanza  and curso.id_ano=".$ano;
	$result_cant_t=@pg_exec($conn,$sql_t) or die ("SELECT FALLÓ:".$sql_t);
	$fila_cant_t = @pg_fetch_array($result_cant_t,0);
	$totalal_t=$fila_cant_t['total'];
	
	 $sql_cant_curso="select count(*) as total_curso from curso where curso.ensenanza=$ensenanza 
      and curso.id_ano=$ano";
	$result_cant_curso =@pg_exec($conn,$sql_cant_curso) or die ("SELECT FALLÓ:".$sql_cant_curso);
	$fila_cant_curso = @pg_fetch_array($result_cant_curso,0);
	$total_curso=$fila_cant_curso['total_curso'];
	
	$sql_total_aprob="select count(*) as total_prom
	 from promocion as pr inner join curso on pr.id_curso=curso.id_curso 
	 where  pr.id_ano=$ano and curso.ensenanza=$ensenanza 
	 and situacion_final=1";
	 $result_total_prom =@pg_exec($conn,$sql_total_aprob) or die ("SELECT FALLÓ:".$sql_total_aprob);
	$fila_total_prom = @pg_fetch_array($result_total_prom,0);
	$total_prom=$fila_total_prom['total_prom'];
	
	 $sql_total_rep="select count(*) as total_prom
	 from promocion as pr inner join curso on pr.id_curso=curso.id_curso 
	 where  pr.id_ano=$ano and curso.ensenanza=$ensenanza 
	 and situacion_final=2";
	$result_total_rep =@pg_exec($conn,$sql_total_rep) or die ("SELECT FALLÓ:".$sql_total_rep);
	$fila_total_rep = @pg_fetch_array($result_total_rep,0);
	$total_rep=$fila_total_rep['total_prom'];
	
	
	$sql_total_ret="select count(*) as total_prom
	 from promocion as pr inner join curso on pr.id_curso=curso.id_curso 
	 where  pr.id_ano=$ano and curso.ensenanza=$ensenanza 
	 and situacion_final=3";
	$result_total_ret =@pg_exec($conn,$sql_total_ret) or die ("SELECT FALLÓ:".$sql_total_ret);
	$fila_total_ret = @pg_fetch_array($result_total_ret,0);
	$total_ret=$fila_total_ret['total_prom'];
	
	
	$total_repitentes=($totalal_t-$total_prom);
	
	$porcen_total=round(($total_prom*100)/$totalal_t);
	 
	 ?>
     
     <td width="76"><?=$totalal_t?></td>
     <td width="85"><?=$total_curso?></td>
     <td width="92"><?=$total_prom?></td>
     <td width="103"><?=$total_rep?></td>
     <td width="83"><?=$total_ret?></td>
     <td width="112"><?=$porcen_total.'%'?></td>
     </tr>
</table>
</div>
<br>
</div>
<? }?>
<br>

<?
		
	 $sql_t_g="select count(*)  as total from curso
	inner join matricula on curso.id_curso=matricula.id_curso
	where curso.id_ano=".$ano;
	$result_cant_t_g=@pg_exec($conn,$sql_t_g) or die ("SELECT FALLÓ:".$sql_t_g);
	$fila_cant_t_g = @pg_fetch_array($result_cant_t_g,0);
	$totalal_t_g=$fila_cant_t_g['total'];
	
	//aprobados por institucion
	$sql_total_aprob_tot="select count(*) as total_prom
	 from promocion as pr inner join curso on pr.id_curso=curso.id_curso 
	 where  pr.id_ano=$ano 
	 and situacion_final=1";
	 $result_total_prom_tot =@pg_exec($conn,$sql_total_aprob_tot) or die ("SELECT FALLÓ:".$sql_total_aprob_tot);
	$fila_total_prom_tot = @pg_fetch_array($result_total_prom_tot,0);
	$total_prom_total=$fila_total_prom_tot['total_prom'];
	
	$porcen_total_total=round(($total_prom_total*100)/$totalal_t_g);
	
?>

<table  width="650" id="tablas" class="item" border="1" align="center"  cellpadding="1" cellspacing="1">
<tr align="left" >
<td width="509">
<label>TOTAL MATRICULA GENERAL:</label>
</td>
<td width="128" align="center" >
	<?=$totalal_t_g;?>
</td>
</tr>
</table>
<BR>
<table id="tablas" class="item" width="650" border="1" align="center" cellpadding="1" cellspacing="1">
<tr align="left" >
<td width="509">
<label>TOTAL PORCENTAJE GENERAL APROBADOS:</label>
</td>
<td width="128" align="center" >
	<?=$porcen_total_total.'%';?>
</td>
</tr>
</table>
<BR><br>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
<br><br>
<table class="item" width="650" border="0" align="center"   cellpadding="1" cellspacing="1">
<tr align="right">
<td>
<div id="fecha">
	<? 
	$fecha=$ob_reporte->fecha_actual();
	echo $fecha;
    
	?>
</div>
</td>

</tr>
</table>
</body>
</html>