<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'FichaApoderado.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			
			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>

<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$alumno 		=$cmb_alumno;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;

	

	if($alumno==0){

		//----------------------------------------------------------------------------
		// DATOS INSTITUCION
		//----------------------------------------------------------------------------		
		$ob_membrete = new Membrete();
		$ob_membrete->institucion=$institucion;
		$ob_membrete->institucion($conn);
		
		$ob_reporte = new Reporte();
		$ob_reporte->ano=$ano;
		$ob_reporte->curso=$curso;
		$result_Alu=$ob_reporte->TraeTodosAlumnos($conn);
		$ob_reporte->ProfeJefe($conn);
		$profe_jefe = $ob_reporte->profe_jefe;
		$Curso_pal = CursoPalabra($curso, 0, $conn);


	}else{
		$SQL_Apoderado = "SELECT rut_apo FROM tiene2 WHERE rut_alumno=".$alumno."";
		$result_Apoderado =@pg_exec($conn,$SQL_Apoderado);
		$fila_rut = @pg_fetch_array($result_Apoderado,0);
		$Rut_Apo = $fila_rut["rut_apo"];
		echo "<script>window.location = '../curso/alumno/apoderado/apoderado.php3?apoderado=".$Rut_Apo."&frmModo=reporte&institucion=".$institucion."&ano=".$ano."&curso=".$curso."&alumno=".$alumno."' </script>";
		 
	}
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
header("Content-Disposition:inline; filename=Informe_apoderados_$fecha_actual.xls"); 	 
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
//-->
</script>
<script> 
function cerrar(){ 
window.close() 
} 

			
function exportar(){
			window.location='printFichaApoderado_C.php?cmb_curso=<?=$curso?>&xls=1';
			return false;
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
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($curso != 0){
 ?>
<form name="form" method="post" action="printFichaApoderado_C.php" target="_blank">
<center>
<table width="600" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<table width="600" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><div id="capa0">
					<table width="100%">
					  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
						<td align="right">
		<input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onClick="javascript:imprimir()">
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR"></td>
					  </tr></table>
							
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table width="600" border="0" cellspacing="0" cellpadding="0">
			  <tr> 
				<td width="119" rowspan="6"><div align="center"><? echo "<img src='../../../../tmp/".$institucion."insignia". "' >";	?></div></td>
				
				<td width="404"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?=$ob_membrete->ins_pal;?></strong></font></td>
			  </tr>
			  <tr>
				<td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?=$ob_membrete->direccion;?></strong></font></td>
			  </tr>
			  <tr>
				<td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?=$ob_membrete->telefono;?></strong></font></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
	    <td  width="600" class="tableindex"><div align="center">LISTA DE APODERADOS</div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td>
			<table width="600" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="132" class="item"><strong>Curso</strong></td>
					<td width="10"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="1">:</font></strong></td>
					<td width="462" class="subitem"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $Curso_pal;?></font></td>
				</tr>
				<tr>
				  <td class="item"><strong>Profesor Jefe</strong> </td>
				  <td><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="1">:</font></strong></td>
				  <td class="subitem"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><?=$ob_reporte->tildeM($profe_jefe);?></font></td>
			  </tr>
			</table>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td>
			<table width="600" border="1" cellspacing="0" cellpadding="0">
				<tr>
					<td class="item"><center><strong>RUT</strong></center></td>
					<td class="item"><strong>Apoderado</strong></td>
					<td class="item"><strong>E-mail</strong></td>
					<td class="item"><strong>Telef&oacute;no<br>
				    Particular</strong></td>
					<td class="item"><strong>Telef&oacute;no<br>
				    Celular</strong></td>
					<td class="item"><center><strong>Alumno</strong></center></td>
				</tr>
				
				<?
				for($i=0;$i<@pg_numrows($result_Alu);$i++){	
					$fila_alu = @pg_fetch_array($result_Alu,$i);
					/*$SQL_Apo = "SELECT apo.nombre_apo, apo.ape_pat as ape_pat_apo, apo.ape_mat as ape_mat_apo ";
					$SQL_Apo = $SQL_Apo ."FROM tiene2 INNER JOIN apoderado as apo ON tiene2.rut_apo=apo.rut_apo ";
					$SQL_Apo = $SQL_Apo ."WHERE rut_alumno=".$fila_alu["rut_alumno"]."";*/
					$ob_reporte->alumno=$fila_alu["rut_alumno"];
					$result_Apo=$ob_reporte->Apoderado($conn);
					$fila_apo = @pg_fetch_array($result_Apo,0);
					$ob_reporte->CambiaDatoApo($fila_apo);
					
				?>
					<tr>
						<td class="subitem"><div align="right">
					      <?=$ob_reporte->rut_apo;?>
					    </div></td>
						<td class="subitem">&nbsp;&nbsp;<? echo $ob_reporte->tilde($ob_reporte->nombre);?></td>
						<td class="subitem">&nbsp;<?=$ob_reporte->email_apo;?></td>
						<td class="subitem">&nbsp;<?=$ob_reporte->telefono_apo;?></td>
						<td class="subitem">&nbsp;<?=$ob_reporte->celular;?></td>
						<td class="subitem">&nbsp;&nbsp;<? $nombre_alu=ucwords(strtolower($fila_alu["nombre_alu"])) ." ". ucwords(strtolower($fila_alu["ape_pat"])) ." ".  ucwords(strtolower($fila_alu["ape_mat"])) ; 
														echo $ob_reporte->tilde($nombre_alu);?></td>
					</tr>
				<?
				}
				?>
			</table>
		</td>
	</tr>		
</table>
<br>
</center>
  <?
}
?> 
<table width="100%" border="0">
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
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>