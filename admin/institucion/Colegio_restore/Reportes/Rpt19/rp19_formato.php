<?php 
require('../../../../../util/header.inc');

	$c_alumno	= $cmb_alumno;
	$ano		= $_ANO;
	$curso		= $c_curso;
	$alumno		= $c_alumno;
	$institucion= $_INSTIT;
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


//-->
</script>
<body>
<? if ($cb_ok){?>
	<tr>
		<td>
			<div id="capa0">
			<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				  <td> <div align="right">
					  <input 		name="cmdimprimiroriginal" 		type="button" 		class="botonXX" 		id="cmdimprimiroriginal" 		onclick="MM_openBrWindow('print_rpt19_nuevo_sis.php?c_curso=<?=$c_curso ?>&cmb_alumno=<?=$alumno ?>&cb_ok=1&periodo=<? echo $periodo;?>','','scrollbars=yes,resizable=yes,width=770,height=500')" 		value="Imprimir">
					</div></td>
			  </tr>
			</table>
			</div>
			
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
			</script>
		</td>
	</tr>  
	
<? }?>					
<? if ($cb_ok){
 	if ($c_alumno==0)
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
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

		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

?>


<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="250" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td><?
						if($institucion!=""){
						   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr><td>nom</td></tr>
							<tr><td>dir</td></tr>
							<tr><td>fono</td></tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr height="100"><td colspan="3" >INFORME DE DESARROLLO PERSONAL Y SOCIAL</td></tr>
				<tr>
					<td>A&ntilde;o Escolar</td>
					<td>Periodo</td>					
					<td>RDB</td>										
				</tr>
				<tr>
					<td>2006</td>
					<td>1º Sem</td>
					<td>12565</td>										
				</tr>
				<tr>
					<td colspan="2">Nombre Alumno(a)</td>
					<td>Curso</td>
				</tr>												
				<tr>
					<td colspan="2">Diego Pla</td>
					<td>3ºB</td>										
				</tr>																
			</table>
		</td>		
	</tr>
</table>
<?	}	?>

	
	<form method "post" action="">
	<? 

		$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
		echo $sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
		$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
		$resultado_query_cue = @pg_exec($conn,$sql_curso);
		
		//------------------
		$sql_peri = "select * from periodo where id_ano = ".$ano;
		$result_peri = pg_exec($conn,$sql_peri);
		
		//------------------
		?>			

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100%" class="tableindex">Buscador Avanzado</td>
			</tr>
			<tr>
				<td class="cuadro01"> A&ntilde;o Escolar<br>
    	<?
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
					<input type="hidden" name="frmModo2" value="<?=$frmModo ?>">
					<select name="cmb_ano" class="ddlb_x" id="cmb_ano"  onChange="window.location='rpt19_nuevo_sis.php?cmb_ano='+this.value;">
						  <option value=0 selected>(Seleccione un A&ntilde;o)</option>
					<?		for($i=0;$i < @pg_numrows($result);$i++){
								  $filann = @pg_fetch_array($result,$i); 
								  $id_ano  = $filann['id_ano'];  
								  $nro_ano = $filann['nro_ano'];
								  $situacion = $filann['situacion'];
								  if ($situacion == 0){
									 $estado = "Cerrado";
								  }
								  if ($situacion == 1){
									 $estado = "Abierto";
								  }	 	 
								  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
									  echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
								  }else{	    
									  echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
								  }
							} ?>
                      </select>
				<? }	?>
				</td>
			  </tr>
			  <tr>
				<td  class="cuadro01"><br>
					Curso<font size="1" face="arial, geneva, helvetica"><br>
					<select name="cmb_curso"  class="textosimple" id="cmb_curso" onChange="window.location='rpt19_nuevo_sis.php?cmb_curso='+this.value;">
						<option value=0 selected>(Seleccione Curso)</option>
				<?		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
						  {
							  $fila = @pg_fetch_array($resultado_query_cue,$i); 
							  if ($fila["id_curso"]==$cmb_curso){
									$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
									echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
							  }else{
									$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
									echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
							  }
						  } ?>
						</select>
                                </font>
                                <div align="left"></div>
                              <div align="right"></div></td>
			  </tr>
			  <tr>
				<td  class="cuadro01"><br>
					Alumno<br>
					<select name="cmb_alumno" class="textosimple" id="cmb_alumno">
					  <option value=0 selected>(Todos los alumnos)</option>
			<?		 $sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
					$result= @pg_Exec($conn,$sql);
					if ($cmb_curso!=0){
						for($i=0 ; $i < @pg_numrows($result) ; $i++){
							$fila = @pg_fetch_array($result,$i);
							if ($fila["rut_alumno"] == $cmb_alumno){
						   ?>
                                  <option value="<? echo $fila["rut_alumno"]; ?>" selected><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
                  <?	    }else{	    ?>
                                  <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
            <?  		    }
						}
					 }?>
                     </select></td>
			  </tr>
			  <tr>
				<td  class="cuadro01"><br>
				  Per&iacute;odo<br>
				  <select name="periodo" class="textosimple" id="periodo">
					<option value=0 selected>(Seleccione Periodo)</option>
					<?
					  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
					  {
						  $filaP = @pg_fetch_array($result_peri,$i); 
						  if ($filaP["id_periodo"]==$periodo){
								echo "<option selected value=".$filaP['id_periodo'].">".$filaP['nombre_periodo']."</option>";
						  }else{
								echo "<option value=".$filaP['id_periodo'].">".$filaP['nombre_periodo']."</option>";
						  }
					  } ?>
                    </select></td>
			  </tr>
			  <tr>
				<td  class="cuadro01"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','rpt19_nuevo_sis.php?periodo='+periodo.options[periodo.selectedIndex].value+'&amp;c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;periodo='+periodo.options[periodo.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cb_ok=1');return document.MM_returnValue" value="Buscar"></td>
			  </tr>
		  </table> 
		</form>
</body>
</html>
