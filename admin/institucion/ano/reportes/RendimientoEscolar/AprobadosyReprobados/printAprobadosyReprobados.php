<script>

</script>
<?
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$com 			= explode("_",$cmb_grado); 
	$curso			=1;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	$sw				=0;
	 $finalp=$finalp;
	
		
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	

	
	//------------------- CURSO -----------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	if($cmb_grado>0){
		$grado = $com[1];
		$ensenanza = $com[0];
		$ob_reporte ->ano = $ano;
		$ob_reporte ->ensenanza = $ensenanza;
		$ob_reporte ->grado = $grado;
		
		$rs_listado =$ob_reporte->ListadoCursoGrado($conn);
		
		$rs_ramo = $ob_reporte-> ListadoSubsectoresGrado($conn);
		
		$ob_reporte ->cod_tipo =$ensenanza;
		$ob_reporte->TipoEnsenanza($conn);
	}
	
	function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($Subsector,0,3)));
	else
		echo trim($cadena);
}
$cuenta=array();		
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<SCRIPT language="JavaScript">
			function enviapag2(form){
					form.target="_blank";
					document.form.action='printInformePrimerosAlumnos.php?&cmb_ano=<?=$ano?>';
					document.form.submit(true);
			}
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'notas_por_asignatura.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
 .texto-vertical-1 {
	transform: rotate(90deg);
	
 
 
}
    
	.sdiv{
  position:absolute;
  text-transform: uppercase;
  font-size:10px;
  left:50%;
  
}

</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

  <form method="post" name="form" action="../../printInformeNotasporAsignaturaEnOrden.php" target="mainFrame">
    <center>
<div id="capa0">
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
	<table width="100%">
	  <tr>
	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
	<td align="right">
      <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	  </td>
	 
	<td align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form)" value="EXPORTAR"></td>
	 
	  </tr></table>

    </td>
  </tr>
</table>
</div>
<br><br><br>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">

	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" class="item"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?> </strong></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		
				   

		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
			  <?
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
		
			  if($institucion!=""){
				   echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }?>			</td>
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


	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="23" class="textonegrita">AÑO: <?=$nro_ano;?></td>
        </tr>
      <tr>
        <td colspan="23" class="textonegrita">TIPO DE ENSE&Ntilde;ANZA: <?php echo $ob_reporte ->nombre ?> </td>
      </tr>
      <tr>
        <td colspan="23" class="textonegrita">GRADO: <?php echo $grado ?>&ordm; A&Ntilde;O</td>
      </tr>
      <tr>
        <td colspan="23" class="textonegrita">FECHA: <?php $fecha=date("d-m-Y"); echo fecha_espanol($fecha)?></td>
      </tr>
      <tr>
        <td colspan="23" class="textonegrita">&nbsp;</td>
      </tr>
    </table>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr bgcolor="#003b85">
        <td colspan="23" class="tableindex"><div align="center">INFORME APROBADOS Y REPROBADOS</div></td>
        </tr>
      <tr >
        <td colspan="23" >&nbsp;</td>
      </tr>
      <tr >
        <td colspan="23" >&nbsp;</td>
      </tr>
      <tr >
        <td colspan="23"><div align="center">
          <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
            <tr class="tableindex" style="TEXT-INDENT: 0;">
              <td width="8%" rowspan="2" align="center">
                <div align="center" class="texto-vertical-1"><strong>
                CURSO</strong></div></td>
              <td width="10%" rowspan="2" align="center"><div align="center" class="texto-vertical-1"><strong>N&Uacute;MERO</strong></div></td>
             <?php  for($r=0;$r<pg_numrows($rs_ramo);$r++){
				 $fila_ramo1 = pg_fetch_array($rs_ramo,$r);
				 ?>
              <td colspan="2" align="center" width="30" ><strong><?php echo  InicialesSubsector($fila_ramo1['nombre']) ?></strong></td>
             <?php  }?>
              </tr>
               
            <tr class="tableindex">
             <?php  for($r=0;$r<pg_numrows($rs_ramo);$r++){?> <td  align="center"><strong>A</strong></td>
              <td  align="center"><strong>R</strong></td><?php }?>
              </tr>
              
             <?php  for($i=0;$i<pg_numrows($rs_listado);$i++){
				 $fila_curso = pg_fetch_array($rs_listado,$i);
				 $ob_reporte->id_curso=$fila_curso['id_curso'];
				  $ob_reporte->curso=$fila_curso['id_curso'];
				 $con_mat = $ob_reporte->MatriculadosGrado($conn);
				
				 ?>
            <tr>
              <td align="center"><strong><?php echo $fila_curso['grado_curso'] ?>&ordm; <?php echo $fila_curso['letra_curso'] ?></strong></td>
              <td align="center"><strong><?php echo pg_numrows($con_mat); ?></strong></td>
              
			   <?php  for($s=0;$s<pg_numrows($rs_ramo);$s++){
				   $fila_sub = pg_fetch_array($rs_ramo,$s);
				   $ob_reporte->cdsub=$fila_sub['cod_subsector'];
					$r = $ob_reporte->SubsectorRamo3($conn);
					
					 
					if($finalp==1){
						
							
							$rs_promedio = $ob_reporte->cuentaPromedioSubAlumno($conn);
							for($p=0;$p<pg_numrows($rs_promedio);$p++){
								$filp =pg_fetch_array($rs_promedio,$p);
								
								if($filp['promedio']>=40){
									$cuenta_aprobados[$fila_curso['id_curso']][$ob_reporte->id_ramo][] = $filp['promedio'];
									$cuenta[$fila_sub['cod_subsector']]['aprobados'][]=$filp['promedio'];;
									
								}else{
									$cuenta_reprobados[$fila_curso['id_curso']][$ob_reporte->id_ramo][] = $filp['promedio'];
									$cuenta[$fila_sub['cod_subsector']]['reprobados'][]=$cuenta_reprobados;
								}
							}		
						
					}
					else{
						
						
						
							   $sqlc = "select round(AVG(cast(p.promedio as INT))) as promedio,p.rut_alumno 
from notas$nro_ano p inner join matricula on matricula.rut_alumno = p.rut_alumno
 where matricula.id_ano=$ano and  p.id_ramo = ".$ob_reporte->id_ramo." 
 and p.promedio not in(' ','0','-','EX') and matricula.bool_ar=0 
 group by p.rut_alumno order by promedio desc";
							$rs_promedio = pg_exec($conn,$sqlc);
							
							for($p=0;$p<pg_numrows($rs_promedio);$p++){
								$filp =pg_fetch_array($rs_promedio,$p);
								
								
								if($filp['promedio']>=40){
									$cuenta_aprobados[$fila_curso['id_curso']][$ob_reporte->id_ramo][] = $filp['promedio'];
									$cuenta[$fila_sub['cod_subsector']]['aprobados'][]=$filp['promedio'];;
									
								}else{
									$cuenta_reprobados[$fila_curso['id_curso']][$ob_reporte->id_ramo][] = $filp['promedio'];
									$cuenta[$fila_sub['cod_subsector']]['reprobados'][]=$cuenta_reprobados;
								}
							}				
						
						
						}
				 
				   
				   ?>
              <td align="center">
			  <?php echo count($cuenta_aprobados[$fila_curso['id_curso']][$ob_reporte->id_ramo]) ?></td>
              <td align="center">
			 <?php echo count($cuenta_reprobados[$fila_curso['id_curso']][$ob_reporte->id_ramo]) ?></td>
              <?php }?>
              </tr>
            
              <?php }?>
              <tr>
              <td colspan="2" align="center"><strong>TOTAL</strong></td>
              <?php  for($t=0;$t<pg_numrows($rs_ramo);$t++){
				   $fila_sub = pg_fetch_array($rs_ramo,$t);
				  
				  ?>
              <td align="center"><strong><?php echo count($cuenta[$fila_sub['cod_subsector']]['aprobados']) ?></strong></td>
              <td align="center"><strong><?php echo count($cuenta[$fila_sub['cod_subsector']]['reprobados']) ?></strong></td>
              <?php }?>
            </tr>
          </table>
        </div></td>
        </tr>
     
     
     
    </table></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85>	</td>
  </tr>
</table>
<br>
<br>

</center>
</form>



<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>