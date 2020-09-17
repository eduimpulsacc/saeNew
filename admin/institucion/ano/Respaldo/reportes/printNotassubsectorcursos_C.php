<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	
$institucion	=$_INSTIT;
$ano			=$_ANO;
$id_periodo		=$cmb_periodos;
$reporte		=$c_reporte;
$_POSP = 4;
$_bot = 8;

$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
//------------------------
// Año Escolar
//------------------------
$ob_membrete ->ano=$ano;
$ob_membrete ->AnoEscolar($conn);
$ano_escolar = $ob_membrete->nro_ano;

//-------------- INSTITUCION -------------------------------------------------------------
$ob_membrete ->institucion = $institucion;
$ob_membrete ->institucion($conn);

 //-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Cantidad_notas_subsector_$fecha_actual.xls"); 	 
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
<script> 
function cerrar(){ 
window.close() 
} 


		function exportar(){
			window.location='printNotassubsectorcursos_C.php?cmb_periodos=<?=$id_periodo?>&xls=1';
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

<form name="form" method="post" action="printNotassubsectorcursos_C.php" target="_blank">

<table width="770" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
	<div id="capa0">
	  <table width="650">
		<tr>
		  <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
		  </td>
		  <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		   <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
			<? }?>
		  </td>
		</tr>
	  </table>
    </div>
	
	
	
	</td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" class="item"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></td>
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
			  }
		?>	  		</td>
		 </tr>
     </table>	</td>
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
<table width="770" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td class="tableindex"><div align="center">CANTIDAD DE NOTAS POR SUBSECTOR EN CURSOS</div></td>
	</tr>
	<tr>
		<td ><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>AÑO 
                <? echo $ob_membrete->nro_ano;?></strong> </font></div></td>
	</tr>
</table>
<?

/// para determinar cuantos tipos de enseñanza son:
$ob_reporte ->institucion=$institucion;
$ob_reporte ->mayor=10;
$res_1 = $ob_reporte ->Ensenanza($conn);
$num_1 = @pg_numrows($res_1);

/// para calcular cuantos cursos son en total de la institucion
$sql_2 = "select count(id_curso) from curso where id_ano = '".$_ANO."'";
$res_2 = @pg_Exec($conn,$sql_2);
$num_2 = @pg_numrows($res_2);



/// para calcular cuantos cursos son en total en la institucion
$sql_5 = "select id_curso from curso where id_ano = '".$_ANO."'  and ensenanza > '100'";
$res_5 = @pg_Exec($conn,$sql_5);
$num_5 = @pg_numrows($res_5);

?>

<table width="770" border="0" cellpadding="2" cellspacing="1" bgcolor="#006699">
  <tr>
    <td width="30%" rowspan="3" align="center" bgcolor="#FFFFFF"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Subsectores</b></font></td>
    <td colspan="<?=$num_5 ?>" bgcolor="#FFFFFF" height="30"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Cursos</b></font></div></td>
    </tr>
  <tr>
    <?
	for ($x=0; $x < $num_1; $x++){
	    $fil_1 = @pg_fetch_array($res_1,$x); 
	    $cod_tipo = $fil_1['cod_tipo'];
		
		/// para calcular cuantos cursos son por tipo de enseñanza
		$ob_reporte->ano =$ano;
		$ob_reporte->tipo_ensenanza = $cod_tipo;
		$res_3 = $ob_reporte->CursoEnsenanza($conn);
		$num_3 = @pg_numrows($res_3);
		        
		$nombre_tipo = $fil_1['nombre_tipo'];	
		
		?>
        <td colspan="<?=$num_3 ?>" align="center" bgcolor="#FFFFFF"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><? echo $nombre_tipo; ?> </b></font></td>
    <?
	} 
	?>		
  </tr>
  <tr>
    <?
	
	/// para desplegar todos los cursos de la insticuón
	$sql_4 = "select grado_curso, letra_curso, id_curso from curso where id_ano = '".$_ANO."'  and ensenanza > '100' order by ensenanza, grado_curso, letra_curso";
	$res_4 = @pg_Exec($conn,$sql_4);
	$num_4 = @pg_numrows($res_4);
	
	for ($i=0; $i < $num_4; $i++){
	    $fil_4 = @pg_fetch_array($res_4,$i);
	    $grado_curso = $fil_4['grado_curso'];
		$letra_curso = $fil_4['letra_curso'];
		
		?>	
        <td bgcolor="#FFFFFF" class="item"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo "$grado_curso - $letra_curso"; ?></font></td>
		<?
	}	
    ?>
  </tr>
  <?
  /// para determinar cuantos subsectores tiene la institucion
  $sql_6 = "select * from subsector where cod_subsector in (select DISTINCT cod_subsector from ramo where id_curso in (select id_curso from curso where id_ano = '".$_ANO."' order by ensenanza, grado_curso, letra_curso)) order by cod_subsector";
  $res_6 = @pg_Exec($conn,$sql_6);
  $num_6 = @pg_numrows($res_6);
  
  for ($j=0; $j < $num_6; $j++){
       $fil_6 = @pg_fetch_array($res_6,$j);
	   $cod_subsector    = $fil_6['cod_subsector'];
	   $nombre_subsector = $fil_6['nombre'];
	   ?>  
	  <tr>
		<td height="10" bgcolor="#FFFFFF" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo "$cod_subsector - $nombre_subsector"; ?></font></td>
		<?
		
		for ($i=0; $i < $num_4; $i++){ 
		    $fil_4 = @pg_fetch_array($res_4,$i);
	        $id_curso = $fil_4['id_curso'];
			
			/// detectar cuantas notas se han ingresado en este curso, del ramo en curso
			$sql_7 = "select * from notas$ano_escolar where id_periodo = '$id_periodo' and id_ramo in (select id_ramo from ramo where id_curso = '$id_curso' and cod_subsector = '$cod_subsector') "; 
			$res_7 = @pg_Exec($conn,$sql_7);
			$num_7 = @pg_numrows($res_7);
			
			$max_nota = 0;
			if($num_7!=0){
				for ($y=0; $y < $num_7; $y++){
					$fil_7  = @pg_fetch_array($res_7,$y);
					$nota1  = $fil_7['nota1'];
					$nota2  = $fil_7['nota2'];
					$nota3  = $fil_7['nota3'];
					$nota4  = $fil_7['nota4'];
					$nota5  = $fil_7['nota5'];
					$nota6  = $fil_7['nota6'];
					$nota7  = $fil_7['nota7'];
					$nota8  = $fil_7['nota8'];
					$nota9  = $fil_7['nota9'];
					$nota10 = $fil_7['nota10'];
					$nota11 = $fil_7['nota11'];
					$nota12 = $fil_7['nota12'];
					$nota13 = $fil_7['nota13'];
					$nota14 = $fil_7['nota14'];
					$nota15 = $fil_7['nota15'];
					$nota16 = $fil_7['nota16'];
					$nota17 = $fil_7['nota17'];
					$nota18 = $fil_7['nota18'];
					$nota19 = $fil_7['nota19'];
					
					if ($nota1 > 0 || trim($nota1)=="I" || trim($nota1)=="S" || trim($nota1)=="B" || trim($nota1)=="MB"){
						$pos1 = 1;
						if ($pos1 >= $max_nota){
							$max_nota = $pos1;
						}
					}
					if ($nota2 > 0 || trim($nota2)=="I" || trim($nota2)=="S" || trim($nota2)=="B" || trim($nota2)=="MB"){
						$pos2 = 2;
						if ($pos2 >= $max_nota){
							$max_nota = $pos2;
						}
					}
					if ($nota3 > 0 || trim($nota3)=="I" || trim($nota3)=="S" || trim($nota3)=="B" || trim($nota3)=="MB"){
						$pos3 = 3;
						if ($pos3 >= $max_nota){
							$max_nota = $pos3;
						}
					}
					if ($nota4 > 0 || trim($nota4)=="I" || trim($nota4)=="S" || trim($nota4)=="B" || trim($nota4)=="MB"){
						$pos4 = 4;
						if ($pos4 >= $max_nota){
							$max_nota = $pos4;
						}
					}
					if ($nota5 > 0 || trim($nota5)=="I" || trim($nota5)=="S" || trim($nota5)=="B" || trim($nota5)=="MB"){
						$pos5 = 5;
						if ($pos5 >= $max_nota){
							$max_nota = $pos5;
						}
					}
					if ($nota6 > 0 || trim($nota6)=="I" || trim($nota6)=="S" || trim($nota6)=="B" || trim($nota6)=="MB"){
						$pos6 = 6;
						if ($pos6 >= $max_nota){
							$max_nota = $pos6;
						}
					}
					if ($nota7 > 0 || trim($nota7)=="I" || trim($nota7)=="S" || trim($nota7)=="B" || trim($nota7)=="MB"){
						$pos7 = 7;
						if ($pos7 >= $max_nota){
							$max_nota = $pos7;
						}
					}
					if ($nota8 > 0 || trim($nota8)=="I" || trim($nota8)=="S" || trim($nota8)=="B" || trim($nota8)=="MB"){
						$pos8 = 8;
						if ($pos8 >= $max_nota){
							$max_nota = $pos8;
						}
					}
					if ($nota9 > 0 || trim($nota9)=="I" || trim($nota9)=="S" || trim($nota9)=="B" || trim($nota9)=="MB"){
						$pos9 = 9;
						if ($pos9 >= $max_nota){
							$max_nota = $pos9;
						}
					}
					if ($nota10 > 0 || trim($nota10)=="I" || trim($nota10)=="S" || trim($nota10)=="B" || trim($nota10)=="MB"){
						$pos10 = 10;
						if ($pos10 >= $max_nota){
							$max_nota = $pos10;
						}
					}
					if ($nota11 > 0  || trim($nota11)=="I" || trim($nota11)=="S" || trim($nota11)=="B" || trim($nota11)=="MB"){
						$pos11 = 11;
						if ($pos11 >= $max_nota){
							$max_nota = $pos11;
						}
					}
					if ($nota12 > 0 || trim($nota12)=="I" || trim($nota12)=="S" || trim($nota12)=="B" || trim($nota12)=="MB"){
						$pos12 = 12;
						if ($pos12 >= $max_nota){
							$max_nota = $pos12;
						}
					}
					if ($nota13 > 0 || trim($nota13)=="I" || trim($nota13)=="S" || trim($nota13)=="B" || trim($nota13)=="MB"){
						$pos13 = 13;
						if ($pos13 >= $max_nota){
							$max_nota = $pos13;
						}
					}
					if ($nota14 > 0 || trim($nota14)=="I" || trim($nota14)=="S" || trim($nota14)=="B" || trim($nota14)=="MB"){
						$pos14 = 14;
						if ($pos14 >= $max_nota){
							$max_nota = $pos14;
						}
					}
					if ($nota15 > 0 || $nota15=="I" || $nota15=="S" || $nota15=="B" || $nota15=="MB"){
						$pos15 = 15;
						if ($pos15 >= $max_nota){
							$max_nota = $pos15;
						}
					}
					if ($nota16 > 0 || $nota16=="I" || $nota16=="S" || $nota16=="B" || $nota16=="MB"){
						$pos16 = 16;
						if ($pos16 >= $max_nota){
							$max_nota = $pos16;
						}
					}
					if ($nota17 > 0 || $nota17=="I" || $nota17=="S" || $nota17=="B" || $nota17=="MB"){
						$pos17 = 17;
						if ($pos17 >= $max_nota){
							$max_nota = $pos17;
						}
					}
					if ($nota18 > 0 || $nota18=="I" || $nota18=="S" || $nota18=="B" || $nota18=="MB"){
						$pos18 = 18;
						if ($pos18 >= $max_nota){
							$max_nota = $pos18;
						}
					}
					if ($nota19 > 0 || $nota19=="I" || $nota19=="S" || $nota19=="B" || $nota19=="MB"){
						$pos19 = 19;
						if ($pos19 >= $max_nota){
							$max_nota = $pos19;
						}
					}			
				}		
			}
		    ?>			
			<td align="center" bgcolor="#FFFFFF" class="subitem"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$max_nota ?></font></td>
			<?
		}
		?>
			
	  </tr>
	  <?
   }
   
   ?>	  
</table>
<br>
<br></td>
  </tr>
</table>

<br>
<table width="770" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="subitem" height="100"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=1;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="subitem"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=1;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="subitem"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=1;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="subitem"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
</form>



<!-- FIN CUERPO DE LA PAGINA -->

 
 	<? pg_close($conn);?>							 
</body>
</html>
