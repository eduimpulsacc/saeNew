<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

$_POSP = 4;
$_bot = 8;

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	//$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	
	
	
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	
	

	

	
	//$ob_reporte ->ProfeJefe($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	//$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	/*if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=printInformeRendimientoCursosAnios$Fecha.xls"); 
	}	*/
	
	//nombre asignatura
	$sql_asig = "select nombre from subsector where cod_subsector=$cmbramo";
	$rs_asig = pg_exec($conn,$sql_asig);
	$nom_asig= pg_result($rs_asig,0);
	
	//lista_cursos
	/* $sql_cur = "select ramo.id_curso,ramo.id_ramo,
 (curso.grado_curso ||'-'||curso.letra_curso||' '||tipo_ensenanza.nombre_tipo) 
 as nom_curso from ramo inner join curso on ramo.id_curso = curso.id_curso 
 inner join subsector on ramo.cod_subsector = subsector.cod_subsector 
 inner join tipo_ensenanza on curso.ensenanza = tipo_ensenanza.cod_tipo 
 where curso.ensenanza = $cmbENS and curso.id_ano = $ano and ramo.cod_subsector = $cmbramo
  order by curso.grado_curso, curso.letra_curso";*/
  
 $sql_cur = "select 
(curso.grado_curso ||'-'||curso.letra_curso||' '||tipo_ensenanza.nombre_tipo)
as nom_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza  from ramo inner join curso on ramo.id_curso = curso.id_curso 
inner join subsector on ramo.cod_subsector = subsector.cod_subsector 
inner join tipo_ensenanza on curso.ensenanza = tipo_ensenanza.cod_tipo 
inner join ano_escolar
on curso.id_ano = ano_escolar.id_ano
where
ano_escolar.id_institucion = $institucion 
and ano_escolar.id_ano between $anodesde and $anohasta
and curso.ensenanza = $cmbENS
and ramo.cod_subsector = $cmbramo 
group by curso.grado_curso, curso.letra_curso,tipo_ensenanza.nombre_tipo,curso.ensenanza  
order by curso.grado_curso, curso.letra_curso
";
  
  $rs_cur = pg_exec($conn,$sql_cur);
  $curso = pg_num_rows($rs_cur);
   
   //carga anos
     $sql_aa ="select * from ano_escolar where id_institucion=$institucion
and id_ano between $anodesde and $anohasta and situacion =0 order by nro_ano ";
$rs_aa = pg_exec($conn,$sql_aa);

$con_aa = pg_num_rows($rs_aa);
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

<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeAsistenciaPeriodo.php?institucion=$institucion';
				form.submit(true);
	
				}	
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
//-->
</script>

<script> 
function exportar(){
			//form.target="_blank";
			window.location='printInformeAsistenciaPeriodo_C.php?cmb_curso=<?=$curso?>&cmb_periodos=<?=$periodo?>&c_reporte=<?=$reporte?>';
			//document.form.submit(true);
		return false;
}
function cerrar(){ 
window.close() 
} 
</script>


</head>
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
   
<center>
  <table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
    <td><div id="capa0">
		<table width="100%">
		  <tr>
		<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
		<td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR"></td>
		  
		  <? if($_PERFIL == 0){?>
		  <td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar()"  value="EXPORTAR"></td>
		  <? }?>
		  </tr>
        </table>
      </div></td>
   </tr>
  </table>
  <?
}

	
	
?>


<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br>";
  }
  
 ?>

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
      
	
   <? if ($institucion=="770"){ 
		  
     }else{  ?>  
	  
		  <table width="125" border="0" cellpadding="0" cellspacing="0">
			<tr valign="top">
			  <td width="125" align="center"> 
				<?
				if($institucion!=""){
				    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
			    }else{
				    echo "<img src='".$d."menu/imag/logo.gif' >";
			    } ?>
		  </td>
			</tr>
		  </table>
  <? } ?>	  
	  
	  
	  
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
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" class="tableindex">INFORME DE PROMEDIO POR CURSOS Y A&Ntilde;OS</td>
    </tr>
  <tr>
    <td><div align="center"></div></td>
    </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="118"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Asignatura</strong></font></div></td>
    <td width="10"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
    <td width="522"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?php echo $nom_asig ?></strong></font></div></td>
  </tr>
</table>
<br>
<?php  if(pg_num_rows($rs_cur)>0){?>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td rowspan="2">Curso</td>
    <td align="center" colspan="<?php echo $con_aa ?>">A&ntilde;os</td>
    </tr>
  <tr class="tableindex">
  <?php for($x=0;$x<$con_aa;$x++){ 
  $fil_ano = pg_fetch_array($rs_aa,$x);
  ?>
    <td align="center"><?php echo $fil_ano['nro_ano'] ?></td>
    <?php }?>
    </tr>
    <?php for($i=0;$i<pg_num_rows($rs_cur);$i++){
		$file_cur = pg_fetch_array($rs_cur,$i);
		
		
		?>
  <tr class="textosimple">
    <td><?php echo $file_cur['nom_curso'] ?></td>
   <?php for($x=0;$x<$con_aa;$x++){
	   $fil_ano = pg_fetch_array($rs_aa,$x); 
    
	//id_curso
	$sql_idc = "select id_curso from curso where id_ano=".$fil_ano['id_ano']." and grado_curso=".$file_cur['grado_curso']." and letra_curso='".$file_cur['letra_curso']."' and ensenanza =".$file_cur['ensenanza'];
	$res_idc = pg_exec($conn,$sql_idc);
	$id_cur = pg_result($res_idc,0);
	
	//id_ramo
	$sql_idr ="select id_ramo from ramo where id_curso=".$id_cur." and cod_subsector=".$cmbramo;
	
	$res_idr = pg_exec($conn,$sql_idr);
	$id_ramo = pg_result($res_idr,0);
	
	//promedio
	
	
   ?>
    <td align="center">
    <?php if($id_cur!=""){
	 $sql_prom = "select round(avg(cast(promedio as INTEGER))) from promedio_sub_alumno p
inner join matricula m
on m.rut_alumno = p.rut_alumno
where id_ramo = $id_ramo 
and m.bool_ar =0;";
	$res_prom = pg_exec($conn,$sql_prom);
	echo $prom = pg_result($res_prom,0);
	
	}?>
    
    </td>
    <?php }?>
    </tr>
  <?php   }?>
 
</table>

 <?php }?>
<?php 
/*echo "<pre>";
var_dump($arr_notas);
echo "</pre>";*/
?>

<!--<table width="650" border="0" align="center">
  <tr>
    <?  
			/*if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				//$ob_reporte->curso=$curso;
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
				}else{*/
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?//=$ob_reporte->nombre_emp;?> </span><br>
		    <?//=$ob_reporte->nombre_cargo;?></div></td>
			<? //}} ?>
			<? //if($ob_config->firma2!=0){
				//$ob_reporte->cargo=$ob_config->firma2;
				//$ob_reporte->curso=$curso;
				//$ob_reporte->rdb=$institucion;
				//$ob_reporte->Firmas($conn);
				//$rut_emp=$ob_reporte->rut_emp;
	 // if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	// $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		   //  "Archivo Firma 2 encontrado";
	       //      }else{
	         //      "Archivo Firma 2 no existe"; 
		   //     }
			//	if(isset($firmadig2)){
			//	echo $firmadig2;
			///	}else{
				?>
		    <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?//=$ob_reporte->nombre_emp;?><br>
	        <?//=$ob_reporte->nombre_cargo;?></div></td>
			<? //}} ?>
			 <? //if($ob_config->firma3!=0){
		  		//$ob_reporte->cargo=$ob_config->firma3;
				//$ob_reporte->curso=$curso;
				//$ob_reporte->rdb=$institucion;
				//$ob_reporte->Firmas($conn);
				//$rut_emp=$ob_reporte->rut_emp;
	  //if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	// $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		    // "Archivo Firma 3 encontrado";
	        //     }else{
	        //       "Archivo Firma 3 no existe"; //
		   //     }
			//	if(isset($firmadig3)){
			//	echo $firmadig3;
			//	}else{
				
				?>
			<td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?//=$ob_reporte->nombre_emp;?><br>
		    <?//=$ob_reporte->nombre_cargo;?></div></td>
			<?// }} ?>
			 <? //if($ob_config->firma4!=0){
				//$ob_reporte->cargo=$ob_config->firma4;
				//$ob_reporte->curso=$curso;
				//$ob_reporte->rdb=$institucion;
				//$ob_reporte->Firmas($conn);
				//$rut_emp=$ob_reporte->rut_emp;
				
	 // if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	// $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		    // "Archivo Firma 4 encontrado";
	        //     }else{
	        //       "Archivo Firma 4 no existe"; 
		    //    }
			//	if(isset($firmadig4)){
			//	echo $firmadig4;
			//	}else{
		?>
		  <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?//=$ob_reporte->nombre_emp;?><br>
	        <?//=$ob_reporte->nombre_cargo;?> </div></td>
			<? //}}?>
    </tr>
  </table>-->
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
 
</center>
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>