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
	$curso   		=$select_cursos;
	$ramo 			=$select_ramos;
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
	
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);


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
  <table width="650" align="center">
    <tr>
      <td width="302"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">      </td>
      <td width="316" align="right">&nbsp;</td>
      <td width="66" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR"></td>
    </tr>
  </table>
</div>
                         
						 
					    <table width="650" align="center" border=0 cellpadding=1 cellspacing=1>
						  <tr> 
							<td width="20%" align=left class="textonegrita"> <strong> INSTITUCION						      </strong></td>
							<td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
							  </font> </td>
							<td width="80%" class="subitem"><font face="arial, geneva, helvetica" size="1"><strong><?=$ob_membrete->ins_pal;?></strong></font></td>
							<td width="80%" rowspan="4" class="subitem">
                            <table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="125" align="center">
		<?	if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
          </td>
        </tr>
      </table>
                            </td>
                          </tr>
          <tr> 
            <td align=left class="textonegrita"> <strong> AÑO ESCOLAR  </strong></td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> <?=$ob_membrete->nro_ano?></strong> </font> </td>
            </tr>
          <tr> 
            <td align=left class="textonegrita"> <strong> CURSO              </strong></td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php	echo $Curso_pal = CursoPalabra($curso, 1, $conn);?>
              </strong> </font> </td>
            </tr>
		  
		  
		  <tr> 
            <td align=left class="textonegrita"><strong>  PROFESOR JEFE</strong></td>
            <td>: </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> 
              	<? 	
			  		$ob_reporte ->curso = $curso;
			  		$ob_reporte->ProfeJefe($conn);
					echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
			  ?></strong></font>
            </td>
            </tr>
       </table>
  <table width="650" border="0" align="center" >
  <tr>
    <td class="tableindex" align="center">&nbsp;<div align="center">INFORME ENSAYOS PSU</div>&nbsp;</td>
  </tr>
  
</table>

<table width="292" border="1" cellspacing="0" align="center" cellpadding="0">
      <tr>
        <td width="24" class="tableindex">Nº</td>
	    <td width="191" class="tableindex">NOMBRE DEL ALUMNO</td>
        <?php  $sql="select distinct fecha from ensayos_psu eps where eps.id_curso=".$curso." and eps.id_ramo=".$ramo." order by fecha";
		  $regis_2=pg_Exec($conn,$sql);?>
        
	    <?
              	
				for($x=0;$x<@pg_numrows($regis_2);$x++){
					
					$fila_fecha=pg_fetch_array($regis_2,$x);
					
					$fecha=$fila_fecha['fecha'];
					
					$fecha_separ=explode('-',$fecha);
					
					 $fecha_ano=$fecha_separ[0];
					 $fecha_mes=$fecha_separ[1];
					 $fecha_dia=$fecha_separ[2];
					 $fecha_nueva=$fecha_dia.'/'.$fecha_mes.'/'.$fecha_ano;

$fecha_del=$fecha_ano.'-'.$fecha_mes.'-'.$fecha_dia;
					 
					 
					?>
		<td width="69" align="center" class="tableindex"><?=$fecha_nueva;?>
		  <label for="fecha_$x"></label></td>
					
					<?
										
					}
			  
			  ?>
      </tr>

       <?
	  $numero_alumnos = @pg_numrows($result_alu);	 
	  
	  
	  for($i=0 ; $i < @pg_numrows($result_alu) ; $i++){
	     $fila_alu = @pg_fetch_array($result_alu,$i);
	     $nombre_alu = trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']);
	     $rut_alumno = $fila_alu['rut_alumno'];
	     ?>	
         <tr>
         <td align="center"><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
         <td nowrap><font size="0" face="arial, geneva, helvetica"><? echo $ob_reporte->tilde(substr(ucwords(strtolower($nombre_alu)),0,25)); ?></font></td>
        
        	<?
              	
				for($x=0;$x<@pg_numrows($regis_2);$x++){
					
					$fila_fecha=pg_fetch_array($regis_2,$x);
					
					$fecha=$fila_fecha['fecha'];
					
					$fecha_separ=explode('-',$fecha);
					
					 $fecha_ano=$fecha_separ[0];
					 $fecha_mes=$fecha_separ[1];
					 $fecha_dia=$fecha_separ[2];
					 $fecha_nueva=$fecha_dia.'/'.$fecha_mes.'/'.$fecha_ano;

$fecha_del=$fecha_ano.'-'.$fecha_mes.'-'.$fecha_dia;
					 
				$fila_fecha=pg_fetch_array($regis_2,$i);
		 $sql="select * from ensayos_psu eps where eps.id_curso=".$curso." and eps.id_ramo=".$ramo." and rut_alumno=".$rut_alumno."
		AND fecha='".$fecha_del."' order by fecha";	
		$regis_3=pg_Exec($conn,$sql);
		$fila_3 = pg_fetch_array($regis_3,0);
		$puntaje=$fila_3['puntaje'];	 
					?>
		<td align="center" ><font size="0" face="arial, geneva, helvetica"><?=$puntaje?></font></td>
					
					<?
										
					}
			  
			  ?>
              
			
		      
         </tr>
  	     <?  } ?>
	</table><br>

     <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
</form>
<? pg_close($conn);
unset($xls);?>
</body>
</html>
