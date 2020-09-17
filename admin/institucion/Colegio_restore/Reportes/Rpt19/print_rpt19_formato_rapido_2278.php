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
	
	if ($cb_ok){
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
<script>
			
function imprimir1() 
{
	document.getElementById("capa0").style.display='none';
	//document.getElementById("capa2").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
	//document.getElementById("capa2").style.display='block';
	
}
function imprimir2() 
{
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';
	
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
}


//onLoad="window.print();window.close();"
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print();window.close();">
<? if ($cb_ok){
 	if ($c_alumno==0)
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and bool_ar = '0' and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno ='" . $c_alumno ."' and bool_ar = '0' and id_ano = " . $ano;
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

		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

?>

<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="20%" rowspan="3" valign="top">
	<div align="center">
	   <?
	   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	   ?>
	</div></td>
    <td>&nbsp;</td>
    <td colspan="2" rowspan="3" valign="top">
	
	<table width="180" border="0" align="right" cellpadding="0" cellspacing="0">
 
	  <tr>
	     <td><div align="right"><font size="1" face="Arial, Helvetica, sans-serif">A&ntilde;o Escolar : </font></div></td>
		 <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; <?=$filaAno['nro_ano']; ?> </font></td>
	  </tr>
	  <tr>
		<td><div align="right"><font size="1" face="Arial, Helvetica, sans-serif">Periodo : </font></div></td>
		<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; <?=$filaPer['nombre_periodo']; ?> </font></td>
	  </tr>
	  <tr>
		<td><div align="right"><font size="1" face="Arial, Helvetica, sans-serif">RBD: </font></div></td>
		<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; <?=$filaInstit['rdb']; ?>-<?=$filaInstit['dig_rdb']; ?> </font></td>
	  </tr>  
	</table>
	
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">
	<font size="1" face="Arial, Helvetica, sans-serif">
	LICEO SAN JOS&Eacute;<br>
      Caupolic&aacute;n 109 -<br>
      Requ&iacute;noa	  </font>
	  </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><div align="center"><font size="3" face="Arial, Helvetica, sans-serif"><b><? echo $titulo2;;?></b></font><br>
      <br>
    </div></td>
  </tr>
  <tr>
    <td width="45%"><font size="2" face="Arial, Helvetica, sans-serif">Nombre Alumno(a) : </font></td>
    <td width="20%">&nbsp;</td>
    <td width="35%"><font size="2" face="Arial, Helvetica, sans-serif">
    <div align="center">Curso :</div>
    </font></td>
  </tr>
  <tr>
    <td><font size="2" face="Arial, Helvetica, sans-serif"><b><?php echo $filaAlumno['nombre_alu']." ".$filaAlumno['ape_pat']." ".$filaAlumno['ape_mat'];?></b> </font></td>
    <td>&nbsp;</td>
    <td>
	<font size="1" face="Arial, Helvetica, sans-serif">
	
			<?php if ( ($filaCurso['grado_curso']==1) and (($filaCurso['cod_decreto']==771982) or ($filaCurso['cod_decreto']==461987)) ){
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
													
				 ?>
	
	</font></td>
  </tr>
</table>


<!-- desde aki -->
<?	 if ($nuevo_sis==1){ ?>
					
			<table width="640" align="center" border="1" cellpadding="0" cellspacing="0">
<?							

			    if($periodo != 0){
				
				$nombre = $ano."-".$periodo."-".$alumno."-".$plantilla;
				//echo "<h1>$nombre</h1>";				
				
			
				if (file_exists("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt")) {
					$archivo=fopen("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt" , "r");	    
					
				
					if ($archivo) {
						while (!feof($archivo)) {
							$cadena = fgets($archivo, 500);
							$temp = split("[\t]",$cadena);
							//print_r($temp);
							
							$cont_car= count($temp);
							
							if($cont_car == 1){
								
								echo "
					              <tr>
					                <td colspan=2  ><font face='Verdana, Arial, Helvetica, sans-serif' style=font-size:9px>".$temp[0]."</font></td>
					              </tr>		";			
			
							}
							
							if($cont_car == 2){
								echo "
			                                  <tr >
			                                    <td colspan=2><font face='Verdana, Arial, Helvetica, sans-serif' style=font-size:9px><img src='../../../../../cortes/p.gif' width=10 height=1 border=0>".$temp[1]."</td>
														                                    
			                                  </tr>  
			                                    ";			
								
								
							}
							
							if($cont_car == 4){
								echo "				
			  						<tr >
			                        <td><font face='Verdana, Arial, Helvetica, sans-serif' style=font-size:9px><img src='../../../../../cortes/p.gif' border=0 height=8 width=20>".$temp[2]."</font></td>
			                        				
								";
								if($temp[3] == ""){
									echo "<td nowrap='nowrap' width='5%'><font face='Verdana, Arial, Helvetica, sans-serif' style=font-size:9px>".$temp[3]."</font></td>";
								}
								else{
									list($nombre_uno,$sigla) = split("#",$temp[3]);
									echo "<td nowrap='nowrap' width='5%' align='center'><font face='Verdana, Arial, Helvetica, sans-serif' style=font-size:9px>".$sigla."</font></td>";
								}
								echo "</tr>";
								
							}
							
							
						}
					}
					fclose ($archivo);
				}
				
				
			}	

?>	
</table>                
					 					
					
				
				
						
					<?   	} // fin if nuevo sistema  ?>

                           
						         <?php
								 $sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
								 $resultObs=@pg_Exec($conn, $sqlTraeObs);
								 
								 for($countObs=0; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
									  $filaObs=@pg_fetch_array($resultObs, $countObs);
									  $sedestaca = $filaObs['sedestaca'];
								 }	  
								 ?>
							    								
<!-- hasta aki -->					<table width="640" border="0" align="center" cellpadding="1" cellspacing="0">
									   <tr>
										<td width="20%" ><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Se destaca en: </font></td>
										<td width="80%" ><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">&nbsp;<?=$sedestaca ?></font></td>
									   </tr>
								    </table>	
					
									 <table width="640" border="0" align="center" cellpadding="1" cellspacing="0" >
									    <tr> 
									      <td colspan="2" ><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"> Observaciones:</font></td>
									    </tr>
									
										<?php 
										$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
										$resultObs=@pg_Exec($conn, $sqlTraeObs);
										?>
										<?php 
										for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										$filaObs=@pg_fetch_array($resultObs, $countObs);
											?>
											<tr>
											   <td width="20%"><font style="font-size:10px" face="Arial, Helvetica, sans-serif"><? echo $filaObs['nombre_periodo']; ?></td>
											   <td width="80%"><font style="font-size:10px" face="Arial, Helvetica, sans-serif"><? echo $filaObs['observaciones']; ?>&nbsp;</font></td>
											</tr>
									 <? } ?>
</table>		
										
										
										
										
										<table width="640" border="0" align="center" cellpadding="1" cellspacing="0">
										<tr>
											<td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif"><b>ESCALA DE EVALUACI&Oacute;N: </b></font></td>
										</tr>
										
						                <?
										$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$plantilla;
										$resultConc=@pg_Exec($conn, $sqlConc);
										for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
											$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
											<tr>
											<td width="10%"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaConc['sigla'];?></font></td>
											<td width="90%"><font size="1" face="Arial, Helvetica, sans-serif">: &nbsp;<? echo $filaConc['nombre'];?></font></td>
											</tr>
						            <?  } ?>
										
</table>
									  <br><br>
									  <table width="640" border="0" align="center">
											<tr align="center">
												<td width="50%"><font size="1" face="Arial, Helvetica, sans-serif">________________________</font></td>
												<td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">_________________________</font></td>
											</tr>
											<tr>
												<td width="50%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" ><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</font></strong></td>
												<td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>&nbsp;<?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat']?></strong></font></td>
											</tr>
</table>
									  
									  <table width="640" border="0" align="center">
											<tr align="center">
												<td width="50%"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR (A) JEFE</font></td>
												<td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTORA</font></td>
											</tr>
</table>


                                      <table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td><div align="center">_________________</div></td>
                                        </tr>
                                        <tr>
                                          <td><div align="center"><b><?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat']?></b></div></td>
                                        </tr>
                                        <tr>
                                          <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR (A)</font></div></td>
                                        </tr>
                                      </table>
										
										
									  <? $fecha = date("d-m-Y");?>
									   <table width="640"  border="0" align="center" cellpadding="0" cellspacing="0">
										  <tr> 
											 <td >
											   <font size="1" face="Arial, Helvetica, sans-serif">
											   Requínoa, &nbsp;
											   
											   <?php echo  fecha_espanol($fecha); ?> </font></td>
										  </tr> 
</table>
			<?
			if ($cont_alumnos > 1){ ?>
			   <H1 class=SaltoDePagina></H1>
			<? } ?>   



<?		}	?>
<?	}	?>
</p>
</body>
</html>
