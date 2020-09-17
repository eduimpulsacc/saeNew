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
</script>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeAnotacionesCurso.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
			
				
//			function exportar(form){
//		   			form.target="_blank";
//					var periodo_exp = document.form.cmb_periodos.value;
//					var curso_exp = document.form.cmb_curso.value;
//					var anual_exp = document.form.anual.value;
//					form.action='printInformeAnotacionesCurso_C.php?cmb_periodos='+curso_exp+'&cmb_curso='+periodo_exp+'&anual='+anual_exp+'&xls=1';
//					form.submit(true);
//		  }
		  
	function exportar(){
			window.location='printInformeAnotacionesCurso_C.php?cmb_periodos='+curso_exp+'&cmb_curso='+periodo_exp+'&anual='+anual_exp+'&xls=1';
			return false;
		  }
						  
				
									
</script>

<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');



	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	$total          =$anual;
	
	$_POSP = 4;
	$_bot = 8;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	$ob_reporte ->curso = $curso;
	$ob_reporte ->ProfeJefe($conn);	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);	


if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Anotaciones_curso_$fecha_actual.xls"); 	 
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



function exportar(){
		window.location='printInformeAnotacionesCurso_C.php?cmb_periodos=<?=$periodo?>&cmb_curso=<?=$curso?>&anual=<?=$total?>&xls=1';
			return false;
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INSERTO CUERPO DE LA PÁGINA -->
	   
<?
if ($curso != 0){
   
   ?>
<form method "post" name="form" action="printInformeAnotacionesCurso_C.php" target="_blank">

    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td>
	   <div id="capa0">
	     <table width="100%">
	       <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
	       <td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
		   <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
		<!--<input name="cmb_periodos" type="hidden" value="<?=$periodo?>">
		<input name="cmb_curso" type="hidden" value="<?=$curso?>">
		<input name="anual" type="hidden" value="<?=$anual?>">-->
										<? }?>
	      </td></tr>
		 </table>
      </div>
	</td>
    </tr>
   </table>
 
<br>
<?
	$ob_membrete ->institucion =$institucion;
	$ob_membrete ->institucion($conn);

?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
			<?	
				if($institucion!=""){
					echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
				}else{
					echo "<img src='".$d."menu/imag/logo.gif' >";
				}
			?>
    </td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">CANTIDAD DE ANOTACIONES DEL CURSO</div></td>
  </tr>
  <tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal?></font></td>
        </tr>
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor Jefe</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $ob_reporte->tildeM($ob_reporte->profe_jefe);?></font></td>
        </tr>
</table>
	 <br>
	 <table width="650" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#DBDBDB">
          <tr>
	      <?
		 	$ob_reporte->institucion =$institucion;
			$r1 = $ob_reporte->TipoAnotaciones($conn);
			$n1 = pg_numrows($r1);
		  
		  if ($n1>0){ 
			 $i = 0;
			 while ($i < $n1){				
			    $f1 = pg_fetch_array($r1,$i);
				$id_tipo     = $f1['id_tipo'];
				$codtipo     = $f1['codtipo'];
				$descripcion = $f1['descripcion'];		  
		        ?>
                <td colspan="2" valign="top" width="130"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">&nbsp;<?=$codtipo ?><br><?=$descripcion ?></font></td>
				<?
				$i++;
			 }
		  }
		  ?>		  
		  </tr>
       
	      <?
		  for ($ii=0; $ii < 27; $ii++){ ?>
			   <tr>
			   <?
			   if ($n1>0){ 
				 $i = 0;
				 while ($i < $n1){				
					$f1 = pg_fetch_array($r1,$i);
					$id_tipo     = $f1['id_tipo'];
					$codtipo     = $f1['codtipo'];
					$descripcion = $f1['descripcion'];	
										
					
					$ob_reporte->id_tipo=$id_tipo;
					$r2 = $ob_reporte ->DetalleAnotaciones($conn);
					$n2 = @pg_numrows($r2);
					
					$f2 = @pg_fetch_array($r2,$ii);
			        $id_anotacion  = $f2['id_anotacion'];
					$codigo  = $f2['codigo'];
			        $detalle = $f2['detalle'];	
								
						 ?>
						 
						 <td width="9%" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">&nbsp;<?=$codigo ?></font></td>
						 
						 <?
						 
						 $sql_curso_alumnos = "select * from anotacion where rut_alumno in (select rut_alumno from matricula where id_curso = '$curso' and bool_ar = '0') and codigo_tipo_anotacion > 0 and codigo_anotacion = '$codigo'";
						 if($anual==1){
						  $sql_curso_alumnos = $sql_curso_alumnos."and id_periodo 
 in(select id_periodo from periodo where id_ano = '$ano')"; 
							 }else{  
						 $sql_curso_alumnos =  $sql_curso_alumnos."and id_periodo = '$periodo'";        
							 }    
						 $res_curso_alumnos = @pg_Exec($conn,$sql_curso_alumnos);
						 $num_curso_alumnos = @pg_numrows($res_curso_alumnos);
						 ?>
						 
						 <td width="9%" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">&nbsp; <? if ($num_curso_alumnos > 0){ ?> <?=$num_curso_alumnos ?> <? } ?></font></td>
						 
						 <?
						 
													 
					$i++;					 
				 }
			   }
			   ?>            
			   </tr>
			   <?
		   }
		   ?>
     </table>
	
<table width="650" border="0" align="center">
		   <tr>
		  	<?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
		    <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
			<td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
		?>
		  <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }}?>
		  </tr>
		</table>
</form>

	   </center>
<? } ?>   
       <!-- FIN CUERPO DE LA PAGINA -->					  
</p>
</body>
</html>
<? pg_close($conn);?>