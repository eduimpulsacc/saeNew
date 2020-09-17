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
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso   		=$cmb_curso;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
		$ob_membrete = new Membrete();
		$ob_membrete ->institucion = $institucion;
		$ob_membrete ->institucion($conn); 
		
		$ob_membrete ->ano = $ano;
		$ob_membrete ->AnoEscolar($conn);
	
		$ob_reporte = new Reporte();
		
		$Fecha=date("d-m-y");
		//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);

if(!$cb_ok=="Buscar"){
	$Fecha=date("d-m-Y_h:i");
 	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Atraso_Periodo_$Fecha.xls"); 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
	function enviapag2(form){
		   			form.target="_blank";
					form.action='printInformeAtrasoPeriodo_C.php?cmb_curso=<?=$curso?>&xls=1';
					form.submit(true);
		  }
	function enviapag(form){
		form.action = 'InformeAtrasoPeriodo_dav.php?institucion=$institucion';
		form.submit(true);
    }
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
 <form name="form" method="post" action="printInformeAtrasoPeriodo_C.php">
 <div id="capa0">
  <table width="700" align="center">
    <tr>
      <td width="302"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">      </td>
      <td width="316" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">      </td>
      <td width="66" align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form);"  value="EXPORTAR"> </td>
    </tr>
  </table>
</div>
                         
						 
						 <table width="700" align="center" border=0 cellpadding=1 cellspacing=1>
						  <tr> 
							<td width="20%" align=left class="item"> <strong> INSTITUCION						      </strong></td>
							<td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
							  </font> </td>
							<td width="80%" class="subitem"><font face="arial, geneva, helvetica" size="1"><strong><?=$ob_membrete->ins_pal;?></strong></font></td>
          </tr>
          <tr> 
            <td align=left class="item"> <strong> AÑO ESCOLAR  </strong></td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> <?=$ob_membrete->nro_ano?></strong> </font> </td>
          </tr>
		  <tr> 
            <td align=left class="item"> <strong> PERIODO  </strong></td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> 
                                <?php
								if ($cmb_periodos==0){
								    echo "ANUAL";
								
								}else{								
									$ob_membrete->periodo = $cmb_periodos;
									$ob_membrete->ano = $ano;
									$ob_membrete->Periodo($conn);
									echo $ob_membrete->nombre_periodo;
								}	 
								?>								
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left class="item"> <strong> CURSO              </strong></td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php	echo $Curso_pal = CursoPalabra($curso, 1, $conn);?>
              </strong> </font> </td>
          </tr>
		  
		  
		  <tr> 
            <td align=left class="item"><strong>  PROFESOR JEFE</strong></td>
            <td>&nbsp;  </td>
            <td class="subitem"> 
              	<? 	
			  		$ob_reporte ->curso = $curso;
			  		$ob_reporte->ProfeJefe($conn);
					echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
			  ?>
            </td>
          </tr>
        </table>
		
		
		
						 <br>
                         <table width="700" border="1" align="center" cellpadding="<?=$txtFILAS;?>" cellspacing="0">	
						   <tr> 
						     <td width="10%" align="center" bgcolor="#666666" class="item" >N&ordm;</td>
								  <td width="20%" align="center" bgcolor="#666666" class="item" >RUT</td>
						     <td width="60%" align="center" bgcolor="#666666" class="item" >NOMBRE</td>
								  <td width="10%" align="center" bgcolor="#666666" class="item" >ATRASOS</td>
						   </tr>
							<?php
						
							$ob_reporte ->curso = $curso;
							$ob_reporte ->ano = $ano;
							$ob_reporte ->orden =1;
							$ob_reporte ->retirado=0;
							$result_alu = $ob_reporte ->FichaAlumnoTodos($conn);
							

							for($i=0 ; $i < @pg_numrows($result_alu) ; $i++){
								$fila_alu = @pg_fetch_array($result_alu,$i);
								$ob_reporte ->CambiaDato($fila_alu);
								$rut_alumno = $fila_alu['rut_alumno'];
								
								
								/// Aqui determinar, los atrasos por periodo o anual
								if($rdOPCION==1){
									if ($cmb_periodos>0){
										 $sql_atraso = "select count(id_anotacion) as anotacion from anotacion where id_periodo = '$cmb_periodos' and rut_alumno = '$rut_alumno' AND tipo=2";
									}else{
										 $sql_atraso = "select count(id_anotacion) as anotacion from anotacion where id_periodo in (select id_periodo from periodo where id_ano = '$ano') and  rut_alumno = '$rut_alumno'  AND tipo=2";
									}
								}else{
									$sql = "select count(id_anotacion) as anotacion from anotacion where fecha = '$txtFecha' and rut_alumno = '$rut_alumno' AND tipo=2";
								}
								//if($_PERFIL==0) echo "<br>".$sql_atraso;
								
								$res_atraso = @pg_exec($conn,$sql_atraso);
								$fil_atraso = @pg_fetch_array($res_atraso,0);
								$num_atraso = $fil_atraso['anotacion'];
								?>
							 <tr>
							    <td align="left" class="subitem" ><font color="#000000">&nbsp;&nbsp;<? echo $i+1; ?></font> </td>
								<td align="left" class="subitem" ><font color="#000000">&nbsp;&nbsp;
						        <?=$ob_reporte->rut_alumno; ?>
								</font> </td>
							    <td align="left" class="subitem" ><font color="#000000">&nbsp;&nbsp;
					            <?=$ob_reporte->tilde(ucwords(strtolower($ob_reporte->ape_pat))); ?>  <?=$ob_reporte->tilde(ucwords(strtolower($ob_reporte->ape_mat))); ?>  <?=$ob_reporte->tilde(ucwords(strtolower($ob_reporte->nombre))); ?>
							    </font></td>
								<td align="left" class="subitem" ><div align="right"><font color="#000000">&nbsp;
			                    <?=$num_atraso ?>
							    </font></div></td>
						   </tr>
								<?
							}
							?>					
</table>	
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
</form>
<? pg_close($conn);
unset($xls);?>
</body>
</html>
