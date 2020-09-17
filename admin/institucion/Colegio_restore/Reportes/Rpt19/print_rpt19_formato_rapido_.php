<?php 
require('../../../../../util/header.inc');

	$c_alumno	= $cmb_alumno;
	$ano		= $_ANO;
	$curso		= $c_curso;
	$alumno		= $c_alumno;
	$institucion= $_INSTIT;
	$periodo	= $periodo;

	$fecha = strftime("%d %m %Y");
	$_POSP = 5;
	$_bot = 8;
	if ($cmb_ano){
		$ano=$cmb_ano;
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){ 
			session_register('_ANO');
		}
		$curso=0;	
	}
		
	if ($cmb_curso){
		$curso=$cmb_curso;
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		}
	}
	
	//if ($cb_ok){
		$sqlMatri="select * from curso where id_curso=$curso";
		$resultMatri=@pg_exec($conn,$sqlMatri);
		$filaMatri=@pg_fetch_array($resultMatri,0);

		if($filaMatri['grado_curso']==1) $gr="pa";
		if($filaMatri['grado_curso']==2) $gr="sa";
		if($filaMatri['grado_curso']==3) $gr="ta";
		if($filaMatri['grado_curso']==4) $gr="cu";
		if($filaMatri['grado_curso']==5) $gr="qu";
		if($filaMatri['grado_curso']==6) $gr="sx";
		if($filaMatri['grado_curso']==7) $gr="sp";
		if($filaMatri['grado_curso']==8) $gr="oc";
	
		$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
		$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
		$filaPlantilla=@pg_fetch_array($resultPlantilla);
		$plantilla=$filaPlantilla[id_plantilla];
		$nuevo_sis=$filaPlantilla[nuevo_sis];
		
		$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
		$resultDIR =@pg_Exec($conn,$qryDIR);
		$filaDIR=@pg_fetch_array($resultDIR);
	
		$qryORI="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=11)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
		$resultORI =@pg_Exec($conn,$qryORI);
		$filaORI=@pg_fetch_array($resultORI);
	
		$sqlPeriodo="select nombre_periodo from periodo where id_periodo=".$periodo;
		$resultPeriodo=@pg_exec($conn, $sqlPeriodo);
		$filaPer=@pg_fetch_array($resultPeriodo,0);		
	
		
		$sqlInstit="select * from institucion where rdb=".$institucion;
		$resultInstit=@pg_Exec($conn, $sqlInstit);
		$filaInstit=@pg_fetch_array($resultInstit);
		
		$sql_reg="select nom_reg from region where cod_reg =". $filaInstit['region'];
		$res_reg = pg_exec($conn, $sql_reg);
		$fila_reg = pg_fetch_array($res_reg);
		
		$sql_pro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro =".$filaInstit['ciudad'];
		$res_pro=pg_exec($conn, $sql_pro);
		$fila_pro = pg_fetch_array($res_pro);
		
		$sql_com="select nom_com from comuna where cod_reg=". $filaInstit['region'] ." and cor_pro =".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
		$res_com=pg_exec($conn, $sql_com);
		$fila_com = pg_fetch_array($res_com);
			
		$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
		$resultEmp =@pg_Exec($conn,$qryEmp);
		$filaEmp=@pg_fetch_array($resultEmp);
		
		$sql_ano="select nro_ano from ano_escolar where id_ano=".$_ANO;
		$res_ano =@pg_Exec($conn,$sql_ano);
		$filaAno=@pg_fetch_array($res_ano);
	//}
	

if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Desarrollo_personal_social_$fecha_actual.xls"); 	 
}	
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 Hidden
 {
 	visibility:hidden;
 }
 
</style>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
<!--
function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'rpt19.php?institucion=$institucion';
				form.submit(true);
	
				}	
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


// onLoad="window.print();window.close();"-->
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


<form name="form" method="post" action="print_rpt19_formato_rapido.php" target="_blank">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td height="589" align="left" valign="top">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td width="0%" height="722" align="left" valign="top" > 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" align="center">
              
              <tr align="left" valign="top"> 
                <td height="1038">
					<table width="100%"  border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr> 
                     
                      <td width="73%" align="center" valign="top">
					  <table>

<? //if ($cb_ok){?>
	<tr>
		<td>
			
			
			<script>
			
			
			function imprimir() 
			{
				document.getElementById("capa0").style.display='none';
				window.print();
				document.getElementById("capa0").style.display='block';
			}
			

		function exportar(){
			window.location='print_rpt19_formato_rapido.php?c_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&periodo=<?=$periodo?>&xls=1';
			return false;
		  }
			
			//function imprimir1() 
//			{
//				document.getElementById("capa0").style.display='none';
//				document.getElementById("capa2").style.display='none';
//				window.print();
//				document.getElementById("capa0").style.display='block';
//				document.getElementById("capa2").style.display='block';
//				
//			}
//			function imprimir2() 
//			{
//				document.getElementById("capa0").style.display='none';
//				document.getElementById("capa1").style.display='none';
//				
//				window.print();
//				document.getElementById("capa0").style.display='block';
//				document.getElementById("capa1").style.display='block';
//			}
			</script>
		</td>
	</tr>  
<? // }?>					
<? //if ($cb_ok){

 	if ($c_alumno==0)
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno and matricula.bool_ar = '0' order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno ='" . $c_alumno ."' and id_ano = " . $ano;
	$result_alu =pg_Exec($conn,$sql_alu);
	$cont_alumnos = pg_numrows($result_alu);

	for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
	{
		$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
		$alumno = $fila_alu['rut_alumno'] ;
		
		$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
		$resultMatri=@pg_exec($conn,$sqlMatri);
		$filaMatri=@pg_fetch_array($resultMatri,0);
	
		$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno='".$alumno."'";
		$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
		$filaAlumno=@pg_fetch_array($resultAlumno,0);
		
		$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$filaMatri['id_curso'];
		$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
		$filaCurso=@pg_fetch_array($resultCurso);
		
		$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
		$resultEns=@pg_Exec($conn, $sqlEns);
		$filaEns=@pg_fetch_array($resultEns);
		
		$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$filaMatri['id_curso'];
		$resultProfe=@pg_Exec($conn, $sqlProfe);
		$filaProfe=@pg_fetch_array($resultProfe);
		
		$titulo2 = $filaPlantilla['titulo_informe2'];

		$result = @pg_Exec($conn,"select insignia, rdb from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

?>

<tr><td>


<? 
if ($institucion==770){ 
	  // no muestro los datos de la institucion
	  // por que ellos tienen hojas pre-impresas
	  echo "<br><br><br><br><br><br><br>";
			   
}
?>
<? 
if ($institucion==1691){ 
	  // no muestro los datos de la institucion
	  // por que ellos tienen hojas pre-impresas
	  echo "<br><br><br><br><br>";
			   
}
?>
<div id="capa0">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	 <? if($_PERFIL==0){?>		  
	<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
			<? }?>
	</td>
  </tr>
</table>
</div>
<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
				<table width="190" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td><center><?
						if($institucion!="770"){
						   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
						}//else{
						   //echo "<img src='".$d."menu/imag/logo.gif' >";
						//}	?>
						</center></td>
					  </tr>
					
					<tr>
					   <td>
						   <table align="center">
							   <tr><td><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaInstit['nombre_instit'];?></font></td></tr>
								<tr><td><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaInstit['calle']." ".$filaInstit['nro'].", ".ucwords(strtolower($fila_com['nom_com']));?></font></td></tr>
								<tr><td><font size="1" face="Arial, Helvetica, sans-serif">Fono: <? echo $filaInstit['telefono'];?> - Fax: <? echo $filaInstit['fax'];?></font></td></tr>
						   </table>
						</td>
					</tr>
				</table>
			
		</td>
		<td>
		<td><? if ($_INSTIT!=2278){ ?><img src='linea_v.jpg' height="110"> <? } ?></td>
		<td>
			<table width="440" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr><td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif"><strong><center><? echo $titulo2;;?></center></strong></font></td></tr>
				<tr><td colspan="3"><? if ($_INSTIT!=2278){ ?> <hr color="#660000"> <? } ?></td></tr>
				<tr>
					<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<strong>A&ntilde;o Escolar</strong></font></td>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>Periodo</strong></font></td>	
					<? if($institucion != 25218) {	?>				
					<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>RBD</strong></font></td>										
					<? 	}	?>									
				</tr>
				<tr>
					<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<? echo $filaAno['nro_ano'];?></font></td>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($filaPer['nombre_periodo']));?></font></td>
					<? if($institucion != 25218) {	?>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $filaInstit['rdb']."-".$filaInstit['dig_rdb'];?></font></td>										
					<? 	}	?>					
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<strong>Nombre Alumno(a)</strong></font></td>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></td>
				</tr>												
				<tr>
					<td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $filaAlumno['nombre_alu']." ".$filaAlumno['ape_pat']." ".$filaAlumno['ape_mat'];?></font></td>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><?php if ( ($filaCurso['grado_curso']==1) and (($filaCurso['cod_decreto']==771982) or ($filaCurso['cod_decreto']==461987)) ){
															echo $grado="PRIMER NIVEL";
														}else if ( ($filaCurso['grado_curso']==1) and (($filaCurso['cod_decreto']==121987) or ($filaCurso['cod_decreto']==1521989)) ){
															echo $grado="PRIMER CICLO";
														}else if ( ($filaCurso['grado_curso']==1) and ($filaCurso['cod_decreto']==1000)){
															echo $grado="SALA CUNA";
														}else if ( ($filaCurso['grado_curso']==2) and (($filaCurso['cod_decreto']==771982) or ($filaCurso['cod_decreto']==461987)) ){
															echo $grado="SEGUNDO NIVEL";
														}else if ( ($filaCurso['grado_curso']==2) and ($filaCurso['cod_decreto']==121987) ){
															echo $grado="SEGUNDO CICLO";
														}else if ( ($filaCurso['grado_curso']==2) and ($filaCurso['cod_decreto']==1000)){
															echo $grado="NIVEL MEDIO MENOR";
														}else if ( ($filaCurso['grado_curso']==3) and (($filaCurso['cod_decreto']==771982) or ($filaCurso['cod_decreto']==461987)) ){
															echo $grado="TERCER NIVEL";
														}else if ( ($filaCurso['grado_curso']==3) and ($filaCurso['cod_decreto']==1000)){
															echo $grado="NIVEL MEDIO MAYOR";
														}else if ( ($filaCurso['grado_curso']==4) and ($filaCurso['cod_decreto']==1000)){
															echo $grado="TRANSICIÓN 1er NIVEL";
														}else if ( ($filaCurso['grado_curso']==5) and ($filaCurso['cod_decreto']==1000)){
															echo $grado="TRANSICIÓN 2do NIVEL";
														}else{
														imp($filaCurso['grado_curso']."-".$filaCurso["letra_curso"]." ".$filaEns["nombre_tipo"]);
															
				}
														
										
										 ?></font></td>										
				</tr>																
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="4">
			<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<? if ($_INSTIT!=12829) { ?>
					<td colspan="4"><font style="font-size:9px" face="Arial, Helvetica, sans-serif">ESCALA DE EVALUACI&Oacute;N: </font></td>
				</tr>
				<tr>
<?				$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
					<td><font style="font-size:9px" face="Arial, Helvetica, sans-serif"><strong><? echo $filaConc['sigla'];?></strong></font>:</td>
					<td align="left"><font style="font-size:9px" face="Arial, Helvetica, sans-serif"><? echo $filaConc['nombre'];?></font></td>
					<td></td>
<?				}	?>
				</tr>
			<? } ?></table>
		</td>
	</tr>
<!--	<tr>
		<td colspan="4"></td>
	</tr>-->
	<tr>
		<td colspan="4" valign="top">
			<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top">
<!-- desde aki -->
<?					if ($nuevo_sis==1){ ?>
					<table width="630" align="center" border = 0>
					<tr>
					<td valign="top">
					<table width="630" align="center" border="1" cellpadding="0" cellspacing="0">
<?							

			if($periodo != 0){
				
				$nombre = $ano."-".$periodo."-".$alumno."-".$plantilla;
				//echo "<h1>$nombre</h1>";				
				if ($institucion==9827){
					 $letra_informe = 11;
				}else{
				     if ($institucion==1961){
					     $letra_informe = 11;
					 }else{
					     $letra_informe = 9;
					 }	 
				}
			
				if (file_exists("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt")) {
					$archivo=fopen("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt" , "r");	    
					
				
					if ($archivo) {
					    $contador_items = 0;
					   
						while (!feof($archivo)) {
							$cadena = fgets($archivo, 500);
							if ($ano=='556' and $periodo=='1155'){
							    $cadena = str_replace("AUROAFIRMACIÓN","AUTOFORMACIÓN",$cadena);
							}
							if ($periodo=='1345'){
							    $cadena = str_replace("sal de clases","sala de clases",$cadena);
							}
							if ($periodo=='1307'){
							    $cadena = str_replace("parendizajes","aprendizajes",$cadena);
							}
							if($periodo=='1371'){
								$cadena = str_replace("RESPETA ASUS COMPAÑEROS","RESPETA A SUS COMPAÑEROS",$cadena);
								$cadena = str_replace("ESCOALRES","ESCOLARES",$cadena);
								$cadena = str_replace("SE PREOCUPA DE CUIDAD Y MEJORAR SU ENTORNO","SE PREOCUPA DE CUIDAR Y MEJORAR SU ENTORNO",$cadena);
							}
							$temp = split("[\t]",$cadena);
							//print_r($temp);
							
							$cont_car= count($temp);
							
							if($cont_car == 1){
							     $contador_items++;
								 if ($contador_items==6 and $_INSTIT==14629 and $filaMatri['ensenanza']==10){
							         echo "</table>";
									 echo "<H1 class=SaltoDePagina></H1> ";
									 echo "<table width='630' align='center' border='1' cellpadding='0' cellspacing='0'>";
								 }
								 //// 
								 if ($contador_items==4 and $_INSTIT==9071){
							         echo "</table>";
									 echo "<H1 class=SaltoDePagina></H1> ";
									 echo "<table width='630' align='center' border='1' cellpadding='0' cellspacing='0'>";
								 }
								 
								  							
								
								echo "
					              <tr>
					                <td colspan=2  ><font face='Verdana, Arial, Helvetica, sans-serif' style=font-size:".$letra_informe."px>".$temp[0]."</font></td>
					              </tr>		";			
			
							}
							
							if($cont_car == 2){
								echo "
			                                  <tr >
			                                    <td><font face='Verdana, Arial, Helvetica, sans-serif' style=font-size:".$letra_informe."px><img src='../../../../../cortes/p.gif' width=10 height=1 border=0>".$temp[1]."</td>
												
			                                    <td width=1% nowrap><img src='../../../../../cortes/p.gif' width=1 height=1 border=0></td>
			                                  </tr>  
			                                    ";			
								
								
							}
							
							if($cont_car == 4){
								
								
								echo "				
			  						<tr >
			                        <td><img src='../../../../../cortes/p.gif' border=0 height=8 width=20><font face='verdana' style='font-size:".$letra_informe."px'>".$temp[2]."</font></td>
			                        				
								";
								if($temp[3] == ""){
									echo "<td nowrap='nowrap' width='5%'>".$temp[3]."</td>";
								}
								else{
									$arr = split("#",$temp[3]);
									//print_r($arr);
									
									
									
									if(count($arr) == 1){
										echo "<td nowrap='nowrap' width='5%'><img src='../../../../../cortes/p.gif' width=1 height=1 border=0></td>";
									}
									
									else{
										if(count($arr) == 2){
											
											if($arr[1]!= " "){											
												echo "<td nowrap='nowrap' width='5%'><font face='verdana' style='font-size:".$letra_informe."px'>".$arr[0]."</font></td>";
											}
											else{
												echo "<td nowrap='nowrap' width='5%'><font face='verdana' style='font-size:".$letra_informe."px'>".$arr[1]."</font></td>";
											}										
										}									
									}
								}
								
								
							}
							
							
						}
					}
					fclose ($archivo);
				}
				
				
			}	

?>	
		             </table>
					 
					 
					 
					    <!------ NUEVO CODIGO ARCHIVO PERO SACA DE BASE DE DATOS -->
						<?
						if ($institucion==1693 or $institucion==25269){ 
						    
						$contador=0;
						$query_cat="select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0 order by id" ;
						$result_cat=pg_exec($conn,$query_cat);
						$num_cat=pg_numrows($result_cat);
						for ($i=0;$i<$num_cat;++$i){
							$row_cat=pg_fetch_array($result_cat);	?>
							<tr>
							  <td colspan="2"  class="tabla04"><? echo $row_cat['glosa'];?></td>
							</tr>
                        <? 	$query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_cat[id]";
							$result_sub=pg_exec($conn,$query_sub);
							$num_sub=pg_numrows($result_sub);
							for ($j=0;$j<$num_sub;$j++){
								$row_sub=pg_fetch_array($result_sub);	?>
								<tr class="tabla04">
									<td><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
										<? echo $row_sub['glosa'];?></td>
                                 <? if ($modificar){?>
										<td>
									<? 	if ($row_sub['con_concepto']==null){?>
												&nbsp;
<?										}else{	?>
											<input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_sub[id];?>">
									<?	}
										if ($row_sub[con_concepto]=="0"){
							    			$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												$valor=$row_respuesta[respuesta];
											}	?>
											<input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
									<? 		$contador++;	
										}
										if ($row_sub[con_concepto]=="1"){?>
							  <?  			$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												$valor=$row_respuesta[respuesta];
											}
											$query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla";
											$result_concep=pg_exec($conn,$query_concep);
											$num_concep=pg_numrows($result_concep);?>
											<select name="respuesta[<? echo $contador;?>]">
									<? 		for ($ii=0;$ii<$num_concep;$ii++){
												$row_concep=pg_fetch_array($result_concep);	?>
												<option  value="<? echo $row_concep[id_concepto];?>"
											<?	if ($valor==$row_concep[id_concepto]){
														echo "selected";
												}?>><? echo $row_concep[glosa];?></option>
									<? 		}?>
											</select>
									<? 		$contador++;
										}	?>                                              
										</td>
				<? 						}else{	?>
											<td width="1%" nowrap>
									<?		$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
													$result_con=pg_exec($conn,$query_con);
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);

														echo $row_con[sigla];
													}
												}else{
													echo $row_respuesta[respuesta];
												}
											}		?>
										<!--	&nbsp; -->
									<? 		if($i==0){	?>
												  
										<?	}else{	?> 
												&nbsp;
										<?	} 	?>								
											</td>
									<?	}  // fin else?>
										</tr>
									<?	$query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id]";
										$result_item=pg_exec($conn,$query_item);
										$num_item=pg_numrows($result_item);?>
									<?	for ($z=0;$z<$num_item;$z++){
											$row_item=pg_fetch_array($result_item);	?>
											<tr class="tablatit2-1">
												<td><img src="../../../../../cortes/p.gif" width="20" height="8" border="0"><? echo $row_item['glosa'];?></td>
											<?	if ($modificar){?>
													<td width="1%" nowrap><input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_item[id];?>">
												<? 	if ($row_item[con_concepto]=="0"){?>
												<?		$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
														$result_respuesta=pg_exec($conn,$query_respuesta);
														$num_respuesta=pg_numrows($result_respuesta);
														if ($num_respuesta>0){
															$row_respuesta=pg_fetch_array($result_respuesta);
															$valor=$row_respuesta[respuesta];
														}	?>
														<input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
													<?	$contador++;
													}
													if ($row_item[con_concepto]=="1"){
														$query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla";
														$result_concep=pg_exec($conn,$query_concep);
														$num_concep=pg_numrows($result_concep);?>
		
													<?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
														$result_respuesta=pg_exec($conn,$query_respuesta);
														$num_respuesta=pg_numrows($result_respuesta);
														if ($num_respuesta>0){
															$row_respuesta=pg_fetch_array($result_respuesta);
															$valor=$row_respuesta[respuesta];
														}	?>
														<select  name="respuesta[<? echo $contador;?>]">
			<?				 							for ($ii=0;$ii<$num_concep;$ii++){
															$row_concep=pg_fetch_array($result_concep);	?>
															<option value="<? echo $row_concep[id_concepto];?>" 
														<?	if ($valor==$row_concep[id_concepto]){
																echo "selected";}?>><? echo $row_concep[glosa];?></option>
														<?	}?>
															</select>
														<?	$contador++;
														}?>
													</td>
												<?	}else{?>
														<td width="1%" nowrap>
												<?		$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
														$result_respuesta=pg_exec($conn,$query_respuesta);
														$num_respuesta=pg_numrows($result_respuesta);
														if ($num_respuesta>0){
															$row_respuesta=pg_fetch_array($result_respuesta);
															if ($row_respuesta[concepto]==1){
																$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
																$result_con=pg_exec($conn,$query_con);
																$num_con=pg_numrows($result_con);
																if ($num_con>0){
																	$row_con=pg_fetch_array($result_con);
																	
																	
																	if ($institucion==25269){
																	    echo $row_con[nombre];
																	}else{
																	    echo $row_con[sigla];
																	}
																}
															}else{
																echo $row_respuesta[respuesta];
															}
														}	?>
														<!--&nbsp;-->
														</td>
												<?	}  // fin else?>
		                                            </tr>
<?												}// fin if modificar?>
<? 											} // fin for z=0?>
<? 										}	// fin for j=0?>
		                        							
							                                  
						<? } ?>
						<!-- ////////// FIN NUEVO CODIGO --> 
					 
					 
					 
					 
					 
					 
					 
					 
					 			
							
							
										
							</td>
								</tr>
															
								<?php
								 //$sqlTraeObs="select * from informe_observaciones where id_periodo=".$id_periodo." and id_ano=".$filaMatri['id_ano']." and id_plantilla=".$filaPlantilla['id_plantilla']." and rut_alumno='".$alumno."'";
								 $sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
								 //exit;
								 $resultObs=@pg_Exec($conn, $sqlTraeObs);
								 
								 for($countObs=0; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
									  $filaObs=@pg_fetch_array($resultObs, $countObs);
									  $sedestaca = $filaObs['sedestaca'];
								 }	  
								 ?>
							     <?php ?>								
								 <tr>
									<td colspan="3" valign="top">									
									<table width="100%" border="1" cellspacing="0" cellpadding="0">
									  <tr>
										<td width="20%" ><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Se destaca en:</font></td>
										<td width="80%" ><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$sedestaca ?></font></td>
									 </tr>
								   </table>									
								   </td>
								   </tr>	
								   
								   				
								 <tr>
									<td>
									<table width="100%" border="0" cellpadding="0" cellspacing="0" >
									   <tr> 
									      <td ><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;&nbsp; Observaciones:</font></td>
										</tr>
									</table>
										<table width="100%" border="1" align="left" cellpadding="1" cellspacing="0">
										<?php //$sqlTraeObs="select * from informe_observaciones where id_periodo=".$id_periodo." and id_ano=".$filaMatri['id_ano']." and id_plantilla=".$filaPlantilla['id_plantilla']." and rut_alumno='".$alumno."'";
													$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
													//exit;
													$resultObs=@pg_Exec($conn, $sqlTraeObs);
													?>
										  <?php 
										  for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										  $filaObs=@pg_fetch_array($resultObs, $countObs);
											echo "<tr>";
											echo "<td width='20%'><font style=\"font-size:10px\" face=\"Arial, Helvetica, sans-serif\">";
											echo $filaObs['nombre_periodo'];
											echo "</td>";
											echo "<td><font style=\"font-size:10px\" face=\"Arial, Helvetica, sans-serif\">";
											echo $filaObs['observaciones'];
											echo "&nbsp;</font></td>";
											echo "</tr>";
										}
										?>
									  </table><br>
<? if ($_INSTIT==12829) { ?> <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="4"><strong><font size="1" face="Arial, Helvetica, sans-serif">ESCALA DE EVALUACI&Oacute;N:<br><br>
					</font></strong></td>				
				</tr>
				<tr><td>&nbsp;</td></tr>
			
				<tr>
<?				 $sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'] ;
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
					<td valign="middle"><font size="1" face="Verdana, Helvetica, sans-serif"><strong><? echo $filaConc['sigla'];?></strong></font>:</td>
					<td valign="middle"><font size="1" face="Verdana, Helvetica, sans-serif"><? echo $filaConc['nombre'];?></font></td>
					<td>&nbsp;</td>
<?				}	?>
				</tr>
			</table>
			<? } ?>									
									<table width="100%" border="0">
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="right">
											    <font size="2" face="Arial, Helvetica, sans-serif">
												   <input type="hidden" name="fecha">
												   <input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
												   <input type="hidden" name="grado" value="<?php echo $grado ?>">
											    </font>
											</td>
										</tr>
									</table>
									
									<tr>
										<td>&nbsp;</td>
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
									
									
								<? if( $institucion != 0  and $institucion != 9276  and $institucion != 12838 and $institucion != 9071 && $institucion != 1959 && $institucion != 1962  && $institucion != 11209){ ?>								
											<table width="100%" border="0">
												<tr align="center">
													<td width="50%"><font size="1" face="Arial, Helvetica, sans-serif">________________________</font></td>
													<td width="55%"><font size="1" face="Arial, Helvetica, sans-serif"><? $imagen="27000.jpg"; if ($_INSTIT==14912) {?><img src="<? echo($imagen)?>" width="176" height="54"><? echo "<br>HNO. MARTIN CHILLA CRUZ csv"; }  else if ($_INSTIT!=14912 and $institucion!=9827){  ?>_________________________</font></td><? }?>
												</tr>
												<tr>
													<td width="50%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" ><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</font></strong></td>
													<td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>&nbsp; <? if ($institucion!=9827){ ?> <?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat']?><? } ?></strong></font></td>
												</tr>
											</table>
											<table width="100%" border="0">
												<tr align="center">
													<td width="50%"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR (A) JEFE</font></td>
													<td width="55%"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($institucion==24988 or $institucion ==14912){ ?>  RECTOR <? }else{ ?>
												             <? if ($institucion==9239){ ?> DIRECTORA SUBROGANTE ESTABLECIMIENTO <? }else{  if ($institucion!=9827){  ?> DIRECTOR(A) ESTABLECIMIENTO <? } } ?> 
											        <? } ?></font></td>
												</tr>
                                                
                                                <tr>
												<td colspan="3" align="left"><p>&nbsp;</p>
												  <p><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($fila_com['nom_com'])).", ".fecha_espanol($fecha);?></font></p>
												  </td> 
											</tr>
											</table>
											<? if ($_INSTIT==9179 or $institucion==11203  or $institucion==1598  or $institucion==1702  or $institucion==769 or $institucion==1685  or $institucion==14912){?><H1 class=SaltoDePagina></H1> <? } //SALTO DE PAGINA BASICA?>
											<? } ?>
                                            <?
											 if ($institucion==1959 or $institucion==1962){
											     /*
											
												if($institucion!=25218 && $institucion != 1702  && $institucion != 14912 && $institucion != 1598 && $institucion!=1593 && $institucion!=1685 && $institucion!=11203 &&  $institucion!=25478 && $institucion!=1989 && $institucion!=24977 && $institucion!=22380 && $institucion!=9071 && $institucion!=9276 && $institucion!=770 && $institucion!=9179 && $institucion!=11209 && $institucion!=2278  && $institucion!=227  && $institucion!=516 && $institucion!=516 && $institucion!=1756 && $institucion!=769 && $institucion!=24988 && $institucion!=1989 && $institucion!=9827&& $institucion!=1678&& $institucion!=25269 && $institucion!=1677&& $institucion!=1966&& $institucion!=1989){ */	?>
<table width="100%" border="0">
										<tr align="center">
											<td width="50%"><font size="1" face="Arial, Helvetica, sans-serif">________________________</font></td>
											<td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">_________________________</font></td>
										</tr>
										<tr>
											<td width="50%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" ><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</font></strong></td>
											<td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>&nbsp;<?php if($institucion==1959 or $institucion==1962){ echo "PAULA LEÓN MORAGA"; }else{echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat']; }?></strong></font></td>
										</tr>
									</table>
									<table width="100%" border="0">
										<tr align="center">
											<td width="50%"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR (A) JEFE</font></td>
											<td width="55%"><font size="1" face="Arial, Helvetica, sans-serif"><? if($institucion==1959 or $institucion==1962){ echo "JEFE UTP"; }else{ echo "ORIENTADOR (A)";} ?></font></td>
										</tr>
									</table>
									<table width="100%" border="0">
									  <?
							              if ($institucion!=1959 && $institucion!=1962 && $institucion!=11209){ ?>
											<tr>
												<td>&nbsp;</td>
												<td align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>____________________________ </strong></font></td>
												<td>&nbsp;</td>
											</tr>
									
										<tr>
											<td>&nbsp;</td>
											<td align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>
									<?		if($institucion == 24511){
												echo "Meza Gotor Marcelo";
											}
											else{
												echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'] ;
											}	?>
											</strong></font></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td height="22">&nbsp;</td>
											
											<? if ($institucion==770){ ?>
											       <td height="22" align="center"><font size="1" face="Arial, Helvetica, sans-serif">Director</font></td>
											<? }else{ ?>
											       <td height="22" align="center"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTOR (A) ESTABLECIMIENTO</font></td>
											       <? } ?>	   
											<td height="22">&nbsp;</td>
										</tr>	
										
										<? } ?>																	
										<tr>
											<td colspan="3" align="center">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="3" align="center">&nbsp;</td>
										</tr>
										<? if ($_INSTIT!=516){?><tr>
											<td colspan="3" align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($fila_com['nom_com'])).", "?> <?php @setlocale ("LC_TIME", "es_ES"); echo (strftime("%d de %B de %Y")); ?></font></td> 
										<? } ?></tr>
									</table>
									<? if($institucion==9179 or $institucion==516 or $institucion==1678 or $institucion==25269 or $institucion==1716){ ?>
                                    <br>
                                    <H1 class=SaltoDePagina></H1> 
									<? } ?>
									
                           <?		} // if institucion
									else if($institucion==25478 || $institucion==24977  || $institucion==1989){	?>
										<table width="630" border="0">
											<tr>
												<td width="210" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat'];?>&nbsp;</font></strong></td>
												<td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong>&nbsp;<?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat'];?></strong></font></td>
												<td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'];?></strong></font></td>
											</tr>
											<tr align="center">
												<td width="210"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR(A) JEFE</font></td>
												<td width="210"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR(A)</font></td>
												<td width="210"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTOR(A) ESTABLECIMIENTO 55</font></td>
												
											
											</tr>
											
											<tr>
												<td colspan="3" align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($fila_com['nom_com'])).", ".fecha_espanol($fecha);?></font>
												</td> 
											</tr>
										</table>
										
								<?	}
									if($institucion==22380 || $institucion==25218 || $institucion==9071 || $institucion==9276 || $institucion==770 || $institucion==11209 ){?>
									    <br><br><br>
										<table width="630" border="0">
											<tr>
												<td width="210" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat'];?>&nbsp;</font></strong></td>
												<td width="210" align="center"></td>
												<td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'];?></strong></font></td>
											</tr>
											<tr align="center">
												<td width="210"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR(A) JEFE</font></td>
												<td width="210"><font size="1" face="Arial, Helvetica, sans-serif"></font></td>
												
												<? if ($institucion==770){ ?>												
												       <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTOR(A)</font></td>
												       <? }else{ ?>
												       <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTOR(A) ESTABLECIMIENTO</font></td>
												       <? } ?>	   
											</tr>

											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td colspan="3" align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($fila_com['nom_com'])).", ".fecha_espanol($fecha);?></font></td> 
											</tr>
										</table>
			<?						} ?>
									</td>
								</tr>
							</table>
					
<?							} // fin if nuevo sistema
							if ($nuevo_sis!=1){	
							
							$cuenta_item = 0;
							?>
							<table width="630" border=0 cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<table width="630" border="1" cellpadding="0" cellspacing="0">
							<?				$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
											$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
												//trae areas
											$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla']." ORDER BY id_area";
											$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
											for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
												$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
												$nroA=$countArea+1;		?>
												<tr><td><font face=Arial, Helvetica, sans-serif></font></td></tr>
												<tr><td valign=bottom><font style="font-size:10px" face=Arial, Helvetica, sans-serif><strong><? echo $nroA.".-  ".$filaTraeArea['nombre'];?></strong></font></td>
<?												if($countArea==0){	?>												
													<td><font style="font-size:10px" face=Arial, Helvetica, sans-serif><strong>EVALUACI&Oacute;N</strong></font></td>												
					<?							}else{	?>
													<td>&nbsp;&nbsp;</td>
<?												}
												//trae subareas para cada area y las imprime
												$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
												$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
												for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
												$nroS=$countSubarea+1;
												$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);	?>
												<tr><td valign=bottom><font style="font-size:9px" face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong><? echo $nroA.".".$nroS.".-  ".$filaTraeSubarea['nombre'];?></strong></font></td></tr>
			<?									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
												$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea']." ORDER BY id_item";
												$resultTraeItem=@pg_Exec($conn, $sqlTraeItem);
												
												for($countItem=0 ; $countItem<@pg_numrows($resultTraeItem) ; $countItem++){
													$countI++;
													$filaTraeItem=@pg_fetch_array($resultTraeItem, $countItem);
													//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
													if($countItem%2==0){
														
													}else{
														
													}	?>
													<tr><td valign=bottom>
			<?										$nroI=$countItem+1;	
			                                         
													$cuenta_item++;
															
			                                     	?>
													<font style="font-size:9px" face=Arial, Helvetica, sans-serif>&nbsp;<? echo $nroA.".".$nroS.".".$nroI.".-  ".trim($filaTraeItem['glosa']);?></font>
													</td>
<?													if($filaTraeItem['tipo']==0){
														$sqlP="select * from periodo where id_periodo=".$periodo;
														$resultP=@pg_Exec($conn, $sqlP);
														for($countEval=0 ; $countEval<pg_numrows($resultP) ; $countEval++){
															$filaP=@pg_fetch_array($resultP,$countEval);
															$sqlTraeEval="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']."and periodo.id_periodo='".$filaP['id_periodo']."' and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo";
															$resultEval=@pg_Exec($conn, $sqlTraeEval);
															$filaEval=@pg_fetch_array($resultEval,0);
															$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
															$resultConc=@pg_Exec($conn, $sqlTraeConc);
															$filaConc=@pg_fetch_array($resultConc,0);
															if($institucion!=12086){	?>
																<td valign=bottom>&nbsp;&nbsp;
																<font style="font-size:9px" face=Arial, Helvetica, sans-serif><? echo trim($filaConc['sigla']);?></font></td>
	<?														}else{	?>
																<td valign=bottom>&nbsp;&nbsp;
																<font style="font-size:9px" face=Arial, Helvetica, sans-serif><? echo trim($filaConc['nombre']); ?></font></td>
<?															}
															if($institucion==9035 and $cuenta_item==29 and $institucion!=1679){
															     
														          ?>
																  </table>
																  <H1 class=SaltoDePagina></H1>5
																  <table width="630" border="1" cellpadding="0" cellspacing="0">
												         <? } 


														}
													}else if($filaTraeItem['tipo']==2){
														$sqlTraeEvalu="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
														$resultEvalu=@pg_Exec($conn, $sqlTraeEvalu);
														for($countEvalu=0 ; $countEvalu<pg_numrows($resultEvalu) ; $countEvalu++){
															$filaEvalu=pg_fetch_array($resultEvalu,$countEvalu);	?>
												             <tr><td valign=bottom>
															<font style="font-size:9px" face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalu['nombre_periodo'].":&nbsp;&nbsp".$filaEvalu['text'];?></td></tr>
															<tr><td ></td></tr>
<?														}
													}else if($filaTraeItem['tipo']==1){
														$sqlTraeEvalua="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
														$resultEvalua=@pg_Exec($conn, $sqlTraeEvalua);
														for($countEvalua=0 ; $countEvalua<pg_numrows($resultEvalua) ; $countEvalua++){
															$filaEvalua=@pg_fetch_array($resultEvalua,$countEvalua);
															if(($filaEvalua['radio']==0) and ($filaEvalua['radio']!="")){	?>
																	<tr><td valign=bottom>
																	<font style="font-size:9px" face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;No</font></td></tr>	
																	<tr><td ></td></tr>
<?															}else if($filaEvalua['radio']==1){	?>
																	<tr><td valign=bottom>
																	<font style="font-size:9px" face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;Si</font></td></tr>
																	<tr><td ></td></tr>
<?															}
														}						
																											
													}		
													
												}//fin for($countItem....
											}//fin for($countSubarea....
										}//fin for($countArea....			  ?>
										<input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
										<input name="alumno" type="hidden" value="<?php echo $alumno?>">
                                        </table>
<?										if($institucion!=25218  && $institucion!=14629  && $institucion!=1989 && $institucion!=24977 && $institucion!=25478 && $institucion!=12086 && $institucion!=24464 && $institucion!=22380 && $institucion!=25768 && $institucion !=9276 && $institucion != 9035 && $institucion != 12829 && $institucion!=1677 ){ 	?>
											<H1 class=SaltoDePagina></H1>
                                            <p></p>
                                              <?										} ?>
                                           <!-- <p>&nbsp;</p>-->
                                           
										
                                        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0">
					<?					$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_periodo=".$periodo." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
										$resultObs=@pg_Exec($conn, $sqlTraeObs);
										for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
											$filaObs=@pg_fetch_array($resultObs, $countObs);	?>
											<tr>
												<td width="19%"><font size="1" face="Arial, Helvetica, sans-serif">
	<? 												echo $filaObs['nombre_periodo'];	?>
												</td>
												<td><font style="font-size:9px" face="Arial, Helvetica, sans-serif">
	<?												echo $filaObs['glosa'];	?>&nbsp;</font>
												</td>
											</tr>
<?										}	?>
										</table>
										
										
                                        <table width="100%" border="0">
<?										if($institucion!=25218 && $institucion!=14629 && $institucion!=25478   && $institucion!=1989 && $institucion!=24977 && $institucion!=22380 && $institucion!=2278){?>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td></td>
											</tr>
                              <?		}	?>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td align="right"><font size="2" face="Arial, Helvetica, sans-serif">
												<input type="hidden" name="fecha">
												<input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
												<input type="hidden" name="grado" value="<?php echo $grado ?>">
												</font></td>
											</tr>
										</table>
<?										if($institucion!=25218 && $institucion!=25478 && $institucion!=12086 && $institucion!=24977 && $institucion!=22380 && $institucion!=9276 && $institucion!=2278&& $institucion!=1677&& $institucion!=1966&& $institucion!=1989){?>
										<table width="100%" border="0">
											<tr align="center">
												<td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">________________________</font></td>
												<td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">_________________________</font></td>
											</tr>
											<tr>
												<td width="45%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" ><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</font></strong></td>
												<td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>&nbsp;<?php if($institucion==1959){ echo "Paula León Moraga"; }else{echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat']; }?></strong></font></td>
											</tr>
										</table>
										<table width="100%" border="0">
											<tr align="center">
												<td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR (A) JEFE</font></td>
												<td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR (A)</font></td>
											</tr>
										</table>
										<table width="100%" border="0">
											<tr>
												<td>&nbsp;</td>
												<td align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>____________________________ </strong></font></td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>
									<?			if($institucion == 24511){
													echo "Meza Gotor Marcelo";
												}
												else{
													echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'] ;
												}
											  ?>
                                                    </strong></font></td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td height="22">&nbsp;</td>
												<td height="22" align="center"><font size="1" face="Arial, Helvetica, sans-serif"> <? if ($institucion==9239){ ?> DIRECTORA ESTABLECIMIENTO <? }else{ ?> DIRECTOR(A) ESTABLECIMIENTO 55 <? } ?></font></td>
												<td height="22">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="3" align="center">&nbsp;</td>
											</tr>
											
											<tr>
												<td colspan="3" align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($fila_com['nom_com'])).", ".fecha_espanol($fecha);?></font></td> 
											</tr>
										</table>
<?									}
									if($institucion==25478 || $institucion==24977){	?>
									<table width="630" border="0">
										<tr>
											<td width="210" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat'];?>&nbsp;</font></strong></td>
											<td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong>&nbsp;<?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat'];?></strong></font></td>
											<td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'];?></strong></font></td>
										</tr>
										<tr align="center">
											<td width="210"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR(A) JEFE</font></td>
											<td width="210"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR(A)</font></td>
											<td width="210"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTOR(A) ESTABLECIMIENTO </font></td>
										</tr>
										<tr>
											<td></td>
										</tr>
									</table>
									
									
								
<?									}
									if($institucion==22380 || $institucion==25218 || $institucion==9276 || $institucion==12086|| $institucion==1989){?>
									<table width="630" border="0">
										<tr>
											<td width="210" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat'];?></font></strong></td>
											<td width="210" align="center"></td>
											<td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'];?></strong></font></td>
										</tr>
										<tr align="center">
											<td width="210"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR(A) JEFE</font></td>
											<td width="210"><font size="1" face="Arial, Helvetica, sans-serif"></font></td>
											<td width="210"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTOR(A) ESTABLECIMIENTO  </font></td																					>
										</tr>
										<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td colspan="3" align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($fila_com['nom_com'])).", ".fecha_espanol($fecha);?></font></td> 
											</tr>

										<tr>
											<td></td>
										</tr>
									</table>
									<? if ($_INSTIT==12086){ ?>
										<!--<H1 class=SaltoDePagina></H1>-->
									<? } ?>

								<?	} ?>
																							
<?									if($institucion!=25218 && $institucion!=14912 && $institucion!=14629 && $institucion!=25478 && $institucion!=24977 && $institucion!=22380 && $institucion!=2278 && $institucion!=1989){	?>
										<tr>
											<td>&nbsp;</td>
										</tr>
							<?		}	?>
                                    </table>
							<? }?>
							
							<H1 class=SaltoDePagina></H1>
							<? 
							/*
							if (($institucion==24977) || ($institucion==25218) || ($institucion==14629) || ($institucion==9071) || ($institucion==1756) || ($institucion==9035)  ||($institucion==9276)  ||($institucion==1989) ||($institucion==25478) ||($institucion==1678)||($institucion==25269)||($institucion==1593)||($institucion==1677)||($institucion==1966)){  ?>
									<H1 class=SaltoDePagina></H1>
							<? } 
									
							*/	?>
									
									
<!-- hasta aki -->					
					</td>
				</tr>
			</table>		
		</td>
	</tr>
</table>
</td>
</tr>
<?		}	?>
<?	//}	?>

						
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
</body>
</html>
<? pg_close($conn); ?>