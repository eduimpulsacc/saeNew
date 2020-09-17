<?php
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente

	$fecha1 		= $anoN."-04-30"; 

	
	
	$ob_reporte = new Reporte();
	$ob_reporte -> ano = $ano;
	
	$ob_reporte -> institucion = $institucion;
	$ob_reporte -> AnoEscolar($conn);
	
	$ob_membrete = new Membrete();
	$ob_membrete -> ano = $ano;
	$ob_membrete -> institucion = $institucion;
	$ob_membrete -> institucion($conn);
	
	
   	
	$ob_reporte ->orden = $orden;
	$total_filas= @pg_numrows($resultado_query);
 
 //-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$resultado_query= $ob_reporte ->NomCurso($conn);
	$total_filas= @pg_numrows($resultado_query);

	
	
	function mespal($mes){
	if($mes==1)$mes_pal="ENERO";
	if($mes==2)$mes_pal="FEBRERO";
	if($mes==3)$mes_pal="MARZO";
	if($mes==4)$mes_pal="ABRIL";
	if($mes==5)$mes_pal="MAYO";
	if($mes==6)$mes_pal="JUNIO";
	if($mes==7)$mes_pal="JULIO";
	if($mes==8)$mes_pal="AGOSTO";
	if($mes==9)$mes_pal="SEPTIEMBRE";
	if($mes==10)$mes_pal="OCTUBRE";
	if($mes==11)$mes_pal="NOVIEMBRE";
	if($mes==12)$mes_pal="DICIEMBRE";
		
		return $mes_pal;
	}
	
	$arr_hmes = array();
	$arr_mmes = array();
	$arr_hense = array();
	$arr_mense = array();
	
	
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
</script>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
</head>

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
 .txt_tabla {
 font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
}
 .txt_nro{
 font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight:normal;
}
</style>
<body>
<table width="1024" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="capa0">
		<div align="right"> <font face="Arial, Helvetica, sans-serif" size="-1">Imprimir Horizontal</font>
		  <input name="button3" TYPE="button" class="botonXX" onClick="imprimir()" value="IMPRIMIR">	
  		</div>
	</div>
	</div>	</td>
  </tr>
  <tr>
    <td>
	
	
	
	
      <table width="100%" height="132" border="0" >
        <tr>
          <td width="184" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>ESTABLECIMIENTO EDUCACIONAL </strong></font></td>
          <td width="338" align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;
            <?=$ob_membrete->ins_pal; ?>
          </font></td>
          <td width="172" align="left">&nbsp;</td>
          <td width="112" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>REGION</strong></font></td>
          <td width="196" align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->region;?></font></td>
        </tr>
        <tr>
          <td> <div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>ROL BASE 
          DE DATOS</strong></font></div></td>
          <td> <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;</font><font face="Arial, Helvetica, sans-serif" size="1"><? echo $institucion." - ".$ob_membrete->dig_rdb;?></font></div></td>
          <td align="left">&nbsp;</td>
          <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>PROVINCIA</strong></font></div></td>
          <td>
            <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->provincia;?></font></div></td>
        </tr>
        <tr>
          <td ><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>A&Ntilde;O ESCOLAR </strong></font></div></td>
          <td ><div align="left"> <font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;</font><font face="Arial, Helvetica, sans-serif" size="1">
            <?=$ob_reporte->nro_ano; ?>
          </font></div></td>
		            <td align="left">&nbsp;</td>
          <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>COMUNA</strong></font></div></td>
          <td>
            <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->comuna;?></font></div></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
		            <td align="left">&nbsp;</td>
          <td><div align="left"></div></td>
          <td class="Estilo13 Estilo17"><div align="left"></div></td>
        </tr>
        <tr>
          <td height="16" colspan="5" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><strong>MATR&Iacute;CULA ALUMNOS DURANTE EL A&Ntilde;O </strong></font></td>
        </tr>
      </table>
    </td>
  </tr>
</table> 

<?php 

$meses=array("","","","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
$dias=array("","","",31,30,31,30,31,31,30,31,30,31);
$sw=0;

for ($i=0;$i<$total_filas;$i++)
  {
  	$fila = pg_fetch_array($resultado_query,$i);
	$filaxxx = pg_fetch_array($resultado_query,$i+1);
	$ob_reporte->grado_c=$fila['grado_curso'];
	$ob_reporte->letra_c=$fila['letra_curso'];
	$ob_reporte->ensenanza=$fila['ensenanza'];
	$ob_reporte->idcurso=$fila['id_curso'];
	$ob_reporte->ensenanza2=$filaxxx['ensenanza'];
	
	$ensenanza=$fila['ensenanza'];
	$ensenanza2=$filaxxx['ensenanza'];	
	
	
	
  ?>
<table   border="1" cellpadding="0" cellspacing="0" class="txt_tabla">
  <?php if ($i==0)
{?>
  <tr>
    <td   bgcolor="#999999">CURSO</td>
    <?php  for ($j=3;$j<=12;$j++)
	{ ?>
    <td colspan="3" align="center"  bgcolor="#999999"><?php echo mespal($j) ?></td>
   <?php  }?>
  </tr>
  
  <tr>
    <td  >&nbsp;</td>
    <?php  for ($j=3;$j<=12;$j++)
	{ ?>
    <td width="33" align="center"  >H</td>
    <td width="33" align="center"  >M</td>
    <td width="33" align="center"  >TOT</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php $sql_tipo="select * from tipo_ensenanza where cod_tipo=".$ob_reporte->ensenanza;
   $res_tip=pg_exec($conn,$sql_tipo);
   $fila0 = @pg_fetch_array($res_tip,0);?>
  <tr>
    <td width="200" height="100%" ><? echo $ob_reporte->grado_c; ?> - <?php echo $ob_reporte->letra_c ?>
        <?php 
   // busco tipo enseñanza
  
   
  
   ?>
        <?php echo trim($fila0['nombre_tipo']); ?> </td>
        
       <?php  for ($j=3;$j<=12;$j++){
		   $hombres=0;
		   $mujeres=0;
		   $totalcurso=0;
		   
		    ?>
    <td width="33" align="center" >
    <?php //total matricula hombres
$qry1 = "select count(*) as total from matricula
LEFT join alumno
on alumno.rut_alumno = matricula.rut_alumno
where matricula.id_curso = ".$ob_reporte->idcurso."
and alumno.sexo = 2
and matricula.fecha <= '".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."'";

//total retirados hombres

$qry2 = "select count(*) as total from matricula
LEFT join alumno
on alumno.rut_alumno = matricula.rut_alumno
where matricula.id_curso = ".$ob_reporte->idcurso."
and alumno.sexo = 2
and matricula.fecha_retiro <= '".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."'
and matricula.bool_ar=1";
 
 	//if($_PERFIL==0) echo "<br>".$qry1."<br>".$qry2."<br>";
	$result1 =@pg_Exec($conn,$qry1);
	$total = pg_result($result1,0);
	
	$result2 =@pg_Exec($conn,$qry2);
	$retirados = pg_result($result2,0);
											
	echo $hombres=$total-$retirados;
	
	
	$arr_hmes[$j][$ob_reporte->ensenanza][$ob_reporte->idcurso]=$hombres;
?>
    </td>
    <td width="33" align="center" >
    <?php //total matricula mujeres
$qry1 = "select count(*) as total from matricula
LEFT join alumno
on alumno.rut_alumno = matricula.rut_alumno
where matricula.id_curso = ".$ob_reporte->idcurso."
and alumno.sexo = 1
and matricula.fecha <= '".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."'";

//total retirados mujeres

$qry2 = "select count(*) as total from matricula
LEFT join alumno
on alumno.rut_alumno = matricula.rut_alumno
where matricula.id_curso = ".$ob_reporte->idcurso."
and alumno.sexo = 1
and matricula.fecha_retiro <= '".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."'
and matricula.bool_ar=1";
 
 //	if($_PERFIL==0) echo "<br>".$qry2;
	$result1 =@pg_Exec($conn,$qry1);
	$total = pg_result($result1,0);
	
	$result2 =@pg_Exec($conn,$qry2);
	$retirados = pg_result($result2,0);
											
	echo $mujeres=$total-$retirados;
	
	
	$arr_mmes[$j][$ob_reporte->ensenanza][$ob_reporte->idcurso]=$mujeres;
?>
    
    
    </td>
    <td width="33" align="center" ><?php echo $totalcurso=$hombres+$mujeres ?></td>
       <?php }?> 
    
  </tr>
  <?  
  
  $filaxxx = pg_fetch_array($resultado_query,$i+1);
  $ensenanza=$fila['ensenanza'];
  $ensenanza2=$filaxxx['ensenanza']; 
   
   
  if($ensenanza!=$ensenanza2){ 
       $sw=1;   
  }    
  
  if ($sw==1){ 
  $sum_enseh=0;
  ?>
  <tr>
    <td width="200" height="100%"  bgcolor="#999999" >Subtotal <?php echo trim($fila0['nombre_tipo']); ?></td>
     <?php  for ($j=3;$j<=12;$j++)
	
	{ ?>
    <td width="33" align="center"  bgcolor="#999999" >
    <?php echo $thense=array_sum($arr_hmes[$j][$ob_reporte->ensenanza]); 
	$arr_hense[$j][$ob_reporte->ensenanza] = $thense;
	?>
    </td>
    <td width="33" align="center"  bgcolor="#999999" > <?php echo $tmense=array_sum($arr_mmes[$j][$ob_reporte->ensenanza]); 
	$arr_mense[$j][$ob_reporte->ensenanza] = $tmense;
	?></td>
    <td width="33" align="center"  bgcolor="#999999" > <?php echo array_sum($arr_hmes[$j][$ob_reporte->ensenanza])+array_sum($arr_mmes[$j][$ob_reporte->ensenanza]); ?></td>
    <?php }?>
   
  </tr>
  <?
	 $sw=0;
  }    
   
  
   
}
?>
  <tr>
    <td width="200">TOTAL</td>
     <?php  for ($j=3;$j<=12;$j++)
	{ ?>
    <td width="33" align="center"><?php echo array_sum($arr_hense[$j]) ?></td>
    <td width="33" align="center"><?php echo array_sum($arr_mense[$j]) ?></td>
    <td width="33" align="center"><?php echo array_sum($arr_mense[$j])+array_sum($arr_hense[$j]) ?></td>
   <?php }?>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
