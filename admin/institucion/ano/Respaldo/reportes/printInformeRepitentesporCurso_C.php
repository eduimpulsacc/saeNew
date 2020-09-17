<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
//setlocale("LC_ALL","es_ES");


	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$curso;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	//echo $curso;
	//if (empty($curso)) //exit;
  
    if (($curso != 0) or ($curso != NULL)){	
	    $query_curso="select * from curso where id_curso='$curso'";
	    $row_curso=pg_fetch_array(pg_exec($conn,$query_curso));
	}
		
	//imprime_arreglo($row_curso);
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/******** AÑO ESCOLAR *******/
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);	
	$ano_escolar = $ob_membrete->nro_ano;
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
	/******** CURSO *************************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);

if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Repitentes_por_Curso_$Fecha.xls"); 
	
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
function enviapag2(form){
			form.target="_blank";
			document.form.action='printInformeRepitentesporCurso_C.php?curso=<?=$curso?>&c_reporte=<?=$reporte?>';
			document.form.submit(true);
}
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
<center>
<form name="form" method="post" action="printInformeRepitentesporCurso_C.php?curso=<?=$curso?>">
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
     <div id="capa0">
		 <table width="100%">
		    <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
				<td align="right">				
			    <input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onClick="imprimir();">
				</td>
				<? if($_PERFIL==0){?>
			    <td align="right"><input name="exp" type="button" class="botonXX" onClick="enviapag2(this.form)"  value="EXPORTAR"></td>
				<? }?>
		    </tr>
		 </table>
	 </div>		
	</td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" class="item"><strong>
      <?=$ob_membrete->ins_pal;?>
    </strong></td>
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
			?>	  	</td>
		 </tr>
     </table>	</td>
  </tr>
  <tr>
    <td class="item">      <?=$ob_membrete->direccion;?>    </td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td class="item">Fono:&nbsp;        <?=$ob_membrete->telefono;?>    </td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>
<?
// muestro el promedio y luego limpio las variables
// busco el nombre de tipo de ensenanza

$ob_reporte ->ano =$ano;
$ob_reporte ->curso =$curso;
$ob_reporte ->institucion=$institucion;
$ob_reporte ->situacion=2;
$res_al  = $ob_reporte ->Promocion($conn);
$num_al  = @pg_numrows($res_al);
/// 
?>
&nbsp;
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td class="tableindex"><div align="center">INFORME DE ALUMNOS REPITENTES DEL CURSO<br>
    	<?
		$Curso_pal2 = CursoPalabra($curso, 1, $conn);
		echo "$Curso_pal2";
		?>	
		</div></td>
	</tr>
	
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  
  <tr>
    <td width="5%" bgcolor="#999999" class="item">Nro.</td>
    <td width="15%" bgcolor="#999999" class="item">Rut</td>
    <td width="40%" bgcolor="#999999" class="item">Nombre</td>
    <td width="20%" bgcolor="#999999" class="item">Reprobado por:</td>
    <td width="10%" bgcolor="#999999" class="item">Prom. Gral. </td>
    <td width="10%" bgcolor="#999999" class="item">% Asist. </td>
  </tr>
  <?
  for ($i=0; $i < $num_al; $i++){
       $fil_al = @pg_fetch_array($res_al,$i);
       $rut_alumno      = $fil_al['rut_alumno'];
	   $promedio        = $fil_al['promedio'];
	   $asistencia      = $fil_al['asistencia'];
	   $situacion_final = $fil_al['situacion_final'];
	   $tipo_reprova    = $fil_al['tipo_reprova'];
	   
	  
	   
	   $ob_reporte ->alumno = $rut_alumno;
	   $ob_reporte ->ano = $ano;
	   $ob_reporte ->curso = $curso;
	   $res_alu  = $ob_reporte ->TraeUnAlumno($conn);
	   $fil_alu  = @pg_fetch_array($res_alu,0);
	   $ob_reporte ->CambiaDato($fil_alu);
	   
	   ?>
       <tr>
         <td class="subitem"><font color="#000000">&nbsp;
            <?=$i + 1 ?>
         </font></td>
         <td class="subitem"><font color="#000000">&nbsp;
            <?=$ob_reporte->rut_alumno;?>
         </font></td>
         <td class="subitem"><font color="#000000">&nbsp;
            <?=$ob_reporte->tilde($ob_reporte->nombres);?>
         </font></td>
         <td class="subitem"><font color="#000000">&nbsp;
            <?
		 if ($tipo_reprova==1){
		     echo "Notas";
		 }
		 if ($tipo_reprova==2){
		     echo "Asistencia";
		 }
		 ?>	 	 
		 </font></td>
         <td class="subitem"><div align="center"><font color="#000000">&nbsp;
              <?=$promedio ?>
         </font></div></td>
         <td class="subitem"><div align="center"><font color="#000000">&nbsp;
              <?=$asistencia ?>
              %
         </font></div></td>
       </tr>
	   <?
  }
  ?>	   
</table>
<br>
<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>


<!-- FIN CUERPO DE LA PAGINA -->
</td>
</tr>
</table>
</form>
</body>
</html>
<? pg_close($conn);?>