<script>

</script>
<?
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$cmb_ano;
	$curso			=$cmb_curso;
	$subsector		=$cmb_subsector;
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
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Primeros_Alumnos_$Fecha.xls"); 
	}	
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

<? 
	//------------------- CURSOS ---------------------------------------------------------------------
	
		$ob_reporte->ano=$ano;
		$ob_reporte->tense=10;
		$result_sub = $ob_reporte->NomCurso($conn);
		$registros = @pg_numrows($result_sub);
	

	
	
	
	
?>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="23" class="textonegrita">AÑO: <?=$nro_ano;?></td>
        </tr>
    </table>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr bgcolor="#003b85">
        <td colspan="23" class="tableindex"><div align="center">ALUMNOS CON MEJOR PROMEDIO</div></td>
        </tr>
      <tr>
        <td colspan="23"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo $periodo_pal;?> </strong></font></div></td>
        </tr>
     
     
     
    </table>
   <?php  if($finalp==1){?>
	      <table width="650" border="1" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="302"  class="tablatit2-1">CURSO</td>
              <td  class="tablatit2-1">Nombre del Alumno</td>
              <td class="tablatit2-1"><div align="center">P</div></td>
            </tr>
            <?
for($i=0 ; $i < $registros ; $i++)
{
	
	$fila_sub = @pg_fetch_array($result_sub,$i);	
	$id_curso = $fila_sub['id_curso'];
	
	$sql="SELECT promedio, a.ape_pat ||' '|| a.ape_mat ||' '|| a.nombre_alu as nombre, 
			grado_curso,letra_curso ,te.nombre_tipo 
			FROM promocion p
			INNER JOIN alumno a ON p.rut_alumno=a.rut_alumno
			INNER JOIN curso c ON c.id_curso=p.id_curso
			INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza
			WHERE c.id_curso=".$id_curso." AND ensenanza>10 and p.situacion_final=1 and promedio in (select  MAX(promedio) FROM promocion WHERE id_curso=".$id_curso.")";
			
			
	$rs_promedio = pg_exec($conn,$sql);
	for($j=0;$j<pg_numrows($rs_promedio);$j++){
	 $fila =pg_fetch_array($rs_promedio,$j);
	  
	  //----------
		
  ?>
            <tr> 
              <td height="17" class="item"><div align="left">&nbsp;<? echo $fila['grado_curso']."-".$fila['letra_curso']." ".$ob_reporte->tilde($fila['nombre_tipo']."");?></div></td>
              <td width="294" class="item"><div align="left">&nbsp;<?=$ob_reporte->tilde($fila['nombre']);?></div></td>
              
              <td width="46" align="center" class="item"> <div align="center">
			  <?php
              echo $fila['promedio'];
			 
			  ?>
              
              </div></td>
		</tr>
        
 <? }
	
  } 
  ?>
          </table>
          <?php }else{
			  //sin promocion
			   ?>
                <table width="650" border="1" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="302"  class="tablatit2-1">CURSO</td>
              <td  class="tablatit2-1">Nombre del Alumno</td>
              <td class="tablatit2-1"><div align="center">P</div></td> </tr>
  <?php  for($i=0 ; $i < $registros ; $i++)
{
	
	$fila_sub = @pg_fetch_array($result_sub,$i);	
	$id_curso = $fila_sub['id_curso'];
	//me paseo por tooooodo el curso para ver los alumnos
	 $sqla = "select rut_alumno from matricula where id_curso = $id_curso and bool_ar=0";
	$rs_a = pg_exec($conn,$sqla);
	
	for($al=0;$al<pg_numrows($rs_a);$al++){
		$fal = pg_fetch_array($rs_a,$al);
		$rut_alumno  = $fal['rut_alumno'];
		$con_palc=0;
		$sum_palc=0;
		
		$arp[$id_curso]['rut'][]=$rut_alumno;
		
		//pa buscar los promedios
		$sql_palc="select p.id_periodo,round(AVG(cast(p.promedio as INT))) as promedio,
p.rut_alumno from notas$nro_ano p 
where id_ramo IN(select id_ramo from ramo 
where id_curso=$id_curso and modo_eval=1 and bool_pgeneral=1) 
and p.rut_alumno = $rut_alumno
and p.promedio not in(' ','0') group by 1,3 order by 3";
	$rs_palc = pg_exec($conn,$sql_palc);
	for($prm=0;$prm<pg_numrows($rs_palc);$prm++){
		$fil_prm = pg_fetch_array($rs_palc,$prm);
		$con_palc++;
		$sum_palc= $sum_palc+$fil_prm['promedio'];
	}

	$arp[$id_curso]['promedio'][]= round($sum_palc/$con_palc);
	
	}

	
	
	/*$sqlcp="select p.id_periodo,round(AVG(cast(p.promedio as INT))) as promedio,p.rut_alumno from notas2018 p 
where id_ramo IN(select id_ramo from ramo 
where id_curso=$id_curso and modo_eval=1 and bool_pgeneral=1) 
and p.promedio not in(' ','0') group by 1,3 order by 3"	;
	
	$rs_prf = pg_exec($conn,$sqlcp);
	$dprom=array();
	
	for($pr=0;$pr<pg_numrows($rs_prf);$pr++){
	$fila_pr =pg_fetch_array($rs_prf,$pr);
	
	$dprom[$id_curso][$fila_pr['rut_alumno']]['alumno']=$fila_pr['rut_alumno'];
	$dprom[$id_curso][$fila_pr['rut_alumno']]['promedio'][]=$fila_pr['promedio'];
	
	$rut = $fila_pr['rut_alumno'];
	
	
	$promedio = round(array_sum($dprom[$id_curso][$fila_pr['rut_alumno']]['promedio'])/count($dprom[$id_curso][$fila_pr['rut_alumno']]['promedio']));


}
	
	
	*/
 $promax = max($arp[$id_curso]['promedio']);
 
 if($_PERFIL==0){
 	//show($arp);
 }
for($q=0;$q<count($arp[$id_curso]['promedio']);$q++){
	
	if($arp[$id_curso]['promedio'][$q]==$promax){
	$sql_alu = "select a.ape_pat ||' '|| a.ape_mat ||' '|| a.nombre_alu as nombre from alumno a where rut_alumno=".$arp[$id_curso]['rut'][$q];
	$rs_a = pg_exec($conn,$sql_alu);
	?>
      <tr><td  class="item"><?php echo CursoPalabra($id_curso,1,$conn) ?></td><td  class="item"><? echo strtoupper(pg_result($rs_a,0));?></td><td align="center"  class="item"><?php echo $arp[$id_curso]['promedio'][$q] ?></td></tr>
    <?
	}
	
}
	
	?>
  
    <?php }?>
           
            </table>
          <?php }?>
	</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85>	</td>
  </tr>
</table>

</center>
</form>



<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>