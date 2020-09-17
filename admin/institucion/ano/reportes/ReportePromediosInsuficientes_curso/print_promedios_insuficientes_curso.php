<?php

require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
include('../../../../clases/class_Membrete.php');
include('../../../../clases/class_Reporte.php');


//print_r($_POST);




	$_POSP = 4;
	$_bot = 8;
	
	 $institucion	= $_INSTIT;
	 $ano			= $_ANO;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	$reporte		= $c_reporte;
	$curso=1;
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	$fecha=$ob_reporte->fecha_actual();

	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
   $sql_per="select * from  periodo where periodo.id_periodo=".$select_periodos;
		$result_p =pg_Exec($conn,$sql_per);
		$fila_p = pg_fetch_array($result_p,$sql_per);
		 $nombre_per=$fila_p['nombre_periodo'];


$sql_nro_ano="select an.nro_ano from ano_escolar an where an.id_ano=".$ano;
			$result_a =pg_Exec($conn,$sql_nro_ano);
			$fila_nro_ano = pg_fetch_array($result_a,$sql_nro_ano);
			$nro_ano=$fila_nro_ano['nro_ano'];
	
$sq_emp="select em.rut_emp,em.nombre_emp||' '|| em.ape_pat ||' '|| em.ape_mat as nombre_emp
			from supervisa su 
			inner join empleado em ON em.rut_emp=su.rut_emp
			where id_curso=".$select_cursos;
			
			$rs_emp=pg_exec($conn,$sq_emp);
			$fila_emp=pg_fetch_array($rs_emp,$sq_emp);
			$nombre_emp=$fila_emp['nombre_emp'];			 
			 
			 
			  $sq_sub="select su.nombre from ramo ra 
						inner join subsector su on ra.cod_subsector=su.cod_subsector
						where ra.id_ramo=".$select_asignatura;
			
				$rs_sub=pg_exec($conn,$sq_sub);
				$fila_sub=pg_fetch_array($rs_sub,$sq_sub);
				$nombre_sub=$fila_sub['nombre'];	
				
				
				 $sq_sub_niv="SELECT DISTINCT su.nombre FROM ramo r
								inner join subsector su on r.cod_subsector=su.cod_subsector
								inner join curso cu on r.id_curso=cu.id_curso
								inner join niveles ni on cu.id_nivel=ni.id_nivel
								where ni.id_nivel=".$select_niveles." and r.cod_subsector=".$select_ramos_niveles;
											
				$rs_sub_niv=pg_exec($conn,$sq_sub_niv);
				$fila_sub_niv=pg_fetch_array($rs_sub_niv,$sq_sub_niv);
				$nombre_sub_niv=$fila_sub_niv['nombre'];
				
				
				
			 
			 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<SCRIPT language="JavaScript">
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
									
</script>


<script language="JavaScript" type="text/JavaScript">
<!--

function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
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
//-->
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function exportar(){
		//	window.location='printCartaApoderado_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			return false;
		  }		  
		  
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
 
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 
<!-- INICIO CUERPO DE LA PAGINA -->

<form name="form" method="post" action="print_promedios_insuficientes_curso.php" target="_blank">
<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  <? if($_PERFIL==0){?>		  
		<!--<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">-->
	<? }?>
      </td>
    </tr>
  </table>
</div>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
		    <td width="487" class="item"><strong><? echo strtoupper(trim($ob_membrete->ins_pal));?></strong></td>
		    <td width="11">&nbsp;</td>
		    <td width="152" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
		      <tr valign="top" >
		        <td width="125" align="center"><?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c&oacute;digo para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."../menu/imag/logo.gif' >";
	  }?></td>
	          </tr>
		      </table></td>
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
		<br>
  <table width="650" align="center">
	<tr><td class="tableindex" align="center"><div align="center">

<u>RESULTADOS DEL <?=$nombre_per.' '.$nro_ano?></u> </div>

</td></tr>
</table>
<br><br><br>


<br>
<?

	if($select_cursos!=0){

?>

<table width="650" align="center">
<tr>
<td>
<div  class="titulo">Curso :
<? echo $Curso_pal = CursoPalabra($select_cursos, 1, $conn);?>
</div>
<br>
<div  class="titulo">Asignatura :
<?=$nombre_sub;?>
</div>

<br>


<div  class="titulo">Profesor :
<?=$nombre_emp?></div>
<br>
<div class="titulo">

<?
if($orden==0){
		
		$orden="Menor a";
		}else{
			$orden="Mayor a";
			}
?>
Nota&nbsp;<span> <?=$orden.' '.$txt_nota?></span>
</div>
</td>
</tr>
</table>
<br>
<table width="650" border="1"  align="center" style="border-collapse:collapse" cellpadding="1" cellspacing="2">
<tr class="tableindex" >
<td width="22%" class="item">Rut Alumno</td>
<td width="61%" class="item">Nombre Alumno</td>
<td width="17%" class="item">Promedios</td>
</tr>
<?
	$mom=$_POST['orden']; 
	if($mom !=0){
		$mom = ">";
		}else{
			$mom="<";
			}
	
	 $sql_al="select al.ape_pat ||' ' || al.ape_mat ||' '|| al.nombre_alu as nombre_alumno,
				al.rut_alumno ||'-'|| al.dig_rut as rut_al, nta.promedio	
				from alumno al 
				INNER JOIN matricula ma ON al.rut_alumno=ma.rut_alumno
				INNER JOIN notas$nro_ano nta ON ma.rut_alumno=nta.rut_alumno
				where ma.id_curso=".$select_cursos." and nta.id_periodo=".$select_periodos." and nta.id_ramo=".$select_asignatura." and promedio $mom '".$txt_nota."' order by al.ape_pat";

				$result_al = @pg_exec($conn,$sql_al)or die("Fallo 1-".$sql_al);

				if(@pg_numrows($result_al)==0){
					
				echo '<script>alert("No Registra Notas '.$orden.' '.$txt_nota.' ")
					   	
				window.close();
				</script>';	
				}
				
				for($e=0 ; $e < @pg_numrows($result_al) ; $e++)
	{
		
		
		$fila_al = @pg_fetch_array($result_al,$e);
		
		$nombre_tipo=$fila_nivel['nombre_tipo'];
		
?>
<tr>
<td width="22%" class="subitem"><?=$fila_al['rut_al']?></td>
<td width="61%" class="subitem"><?=$fila_al['nombre_alumno']?></td>
<td width="17%" class="subitem"><?=$fila_al['promedio']?></td>
<? } 
?>
</tr>
</table>

<? }else{
	?>
    <table width="650" border="0"  align="center" style="border-collapse:collapse" cellpadding="1" cellspacing="2">
    <tr class="titulo">
    <td>
    <div>Asignatura:
  <?=$nombre_sub_niv;?>
    </div>
    <br>
	<div>
    <?
    if($orden==0){
		
	$orden="Menor a";
	}else{
		$orden="Mayor a";
	}
?>
Nota&nbsp;<span> <?=$orden.' '.$txt_nota?></span>
</div>
</td>
</tr>
</table>
<br>
<table width="650" border="1"  align="center" style="border-collapse:collapse" cellpadding="1" cellspacing="2">
<tr class="tableindex" >
<td width="22%" class="item">Curso</td>

<td width="17%" class="item">Promedios</td>
</tr>
<?
	$mom=$_POST['orden']; 
	if($mom !=0){
		$mom = ">";
		}else{
			$mom="<";
			}
	
	 $sql_ni="select DISTINCT c.grado_curso ||'-'|| c.letra_curso ||' '|| ti.nombre_tipo as nom_curso, su.nombre as ramo, round(avg(cast(nt.promedio as INT))) as                nota_final  
				from curso c
				inner join niveles n ON c.id_nivel=n.id_nivel
				inner join tipo_ensenanza ti ON c.ensenanza=ti.cod_tipo
				inner join ramo ra on c.id_curso=ra.id_curso
				inner JOIN notas$nro_ano nt on ra.id_ramo=nt.id_ramo 
				inner join subsector su on ra.cod_subsector=su.cod_subsector
				WHERE c.id_ano=".$ano." and n.id_nivel=".$select_niveles." and nt.id_periodo=".$select_periodos." and ra.cod_subsector=".$select_ramos_niveles." and                nt.promedio $mom '".$txt_nota."'
				GROUP by c.grado_curso, c.letra_curso,ti.nombre_tipo, su.nombre";

				$result_ni = @pg_exec($conn,$sql_ni)or die("Fallo 1-".$sql_ni);

				if(@pg_numrows($result_ni)==0){
					
				echo '<script>alert("No Registra Notas '.$orden.' '.$txt_nota.' ")
					   	
				window.close();
				</script>';	
				}
				
				for($j=0 ; $j < @pg_numrows($result_ni) ; $j++)
	{
		
		
		$fila_ni = @pg_fetch_array($result_ni,$j);
		
		//$nombre_tipo=$fila_ni['nombre_tipo'];
		
?>
<tr>
<td width="22%" class="subitem"><?=$fila_ni['nom_curso']?></td>

<td width="17%" class="subitem"><?=$fila_ni['nota_final']?></td>
<? } 
?>
</tr>
</table>



<?

}
	 ?>
<br><br><br> <?php  
		 $ruta_timbre =5;
		 $ruta_firma =3;
		 include("../firmas/firmas.php");?>
<table width="75%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<div style="margin-left:65%" class="subitem"><?=$fecha;?></div>
</form>
	<?
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	?>
   
</body>
</html>
<? pg_close($conn);?>