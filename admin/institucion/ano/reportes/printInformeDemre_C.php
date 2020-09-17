 <?php 
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');


$institucion = $_INSTIT;
$ano		 = $_ANO;
$curso		 = $cmb_curso;
$reporte	 = $c_reporte;

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
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_reporte->nro_ano= $ob_membrete->nro_ano;
	$ob_reporte->ano = $ano;
	
	
		
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Demre_$Fecha.xls"); 
	}	

	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
.Estilo1 {font-weight: bold}
</style>
	
<SCRIPT language="JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function window_open(url,ancho,alto){
var opciones="left=100,top=100,width="+ancho+",height="+alto+",scrollbars=yes,resizable=yes,status=yes", i= 0;
 window.open(url,"aa",opciones); 
 }

//-->
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
			//form.target="_blank";
			window.location='printInformeDemre_C.php?cmb_curso=<?=$curso?>&c_reporte=<?=$reporte?>';
			//document.form.submit(true);
		return false;
}
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')"  >

 
								
								   <table width="700" border="0"  cellpadding="0" cellspacing="0" align="center">
									  <tr>
										<td><div id="capa0">
										<table width="100%" align="center">
										  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
										<td align="right">
											  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">										</td>
										<? if($_PERFIL == 0){?>
										<td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar();" value="EXPORTAR"></td>
										 <? }?>
										  </tr></table>
										  </div></td>
									  </tr>
</table>
									<?
									$Curso_pal = CursoPalabra($curso, 1, $conn);
									?>
									<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td width="487" height="20" class="item"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></td>
                                        <td width="11">&nbsp;</td>
                                        <td width="152" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
                                            <tr valign="top" >
                                              <td width="125" align="center"><?
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## c&oacute;digo para tomar la insignia
	
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }
		?>
                                              </td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                      <tr>
                                        <td height="20" class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="20" class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="41">&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                    </table>
									<table width="700" border="0" align="center" cellpadding="3" cellspacing="0">
                                      <tr>
                                        <td colspan="5" class="titulo"><div align="center"><strong>INFORME DEMRE </strong></div></td>
                                      </tr>
                                      <tr>
                                        <td colspan="5">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td colspan="5"><div align="center" class="item">
                                          <div align="left">Curso: 
                                            <?=$Curso_pal ?>
                                          </div>
                                          </div></td>
                                      </tr>
									  </table>
									  <table width="700" border="1" align="center" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td width="15%" class="item"><div align="left">Rut</div></td>
                                        <td width="40%" class="item"><div align="left">Nombre</div></td>
                                        <td width="10%" class="item"><div align="center">Suma</div></td>
                                        <td width="10%" class="item"><div align="center">Cantidad</div></td>
                                        <td width="10%" class="item"><div align="center">Ponderaci&oacute;n</div></td>
                                      </tr>
									  <?
									  	$ob_reporte ->ano = $ano;
										$ob_reporte ->curso = $curso;
										$ob_reporte ->retirado = 0;
										$result = $ob_reporte ->FichaAlumnoTodos($conn);
									 
									  $num_res = @pg_numrows($result);
									  for ($j = 0; $j < $num_res; $j++){								  
											$fil_res = pg_fetch_array($result,$j);
											$nombre_alu = $fil_res['nombre_alu'];
											$ape_pat    = $fil_res['ape_pat'];
											$ape_mat    = $fil_res['ape_mat'];
											$rut_alumno = $fil_res['rut_alumno'];
											$dig_rut    = $fil_res['dig_rut'];
											
											$ob_reporte->alumno= $rut_alumno;
											
											$rs_noy = $ob_reporte->notDemre($conn);
											$total_notas = pg_result($rs_noy,1);
											$suma_pond   = pg_result($rs_noy,0);
											
											//estos datos vienen desde concentracion de notas
											$datosConc = $ob_reporte->proConcentracion($conn);
											$cuentaConc = pg_numrows($datosConc);
											if($cuentaConc>0){
												$fila_conc = pg_fetch_array($datosConc,0);
											$total_notas=$total_notas+$fila_conc['cuenta'];
											$suma_pond= $suma_pond+$fila_conc['promedio'];
											}


//fin datos concentracion
											
											
											
											
											/*$total_notas  = $fil_res['total_notas'];
											$suma_pond    = $fil_res['suma_pond'];*/
											
											
											if ($_PERFIL==0){
											    //echo "total_notas: $total_notas  suma_pond: $suma_pond  <br>";
											}
											
											//$suma_pond = $suma_pond / 10;
											
											$pond_demre = $suma_pond / $total_notas;
																
											
											$pond_demre = substr($pond_demre,0,4);											  
											
																	    ?>											  
                                               
										    <tr>
											<td class="subitem"><? echo "$rut_alumno-$dig_rut"; ?></td>
											<td class="subitem"><? echo $ob_reporte->tilde($ape_pat)." ".$ob_reporte->tilde($ape_mat)." ".$ob_reporte->tilde($nombre_alu); ?></td>
											<td class="subitem"><div align="right"><? echo "$suma_pond"; ?></div></td>
											<td class="subitem"><div align="right"><? echo "$total_notas"; ?></div></td>
										    <td class="subitem"><div align="right"><?=$pond_demre ?>&nbsp;</div></td>
										    </tr>
										    <?
									   
									   
									    }  /// fin for contador de alumnos							
									
									?>								  
</table><br>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
</body>
</html><? pg_close($conn);?>