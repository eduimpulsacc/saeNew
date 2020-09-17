<?php 	require('../../../../../util/header.inc');?>
<HTML>
<HEAD>
<TITLE>MOVER ENC. prueba 02</TITLE>
<script language= "JavaScript">
var ancho , alto , cCeldas , celdas , pasoH , pasoV;

function iniciar(){
celdas0 = document.getElementById("encCol").getElementsByTagName("td").length;
celdas1 = document.getElementById("contenido").getElementsByTagName("td").length;

for (i=0; i<celdas0;i++){
cCeldas = document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML;
document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML = cCeldas+"<img class=\"rell\">";
}

for (j=0; j<celdas1;j++){
cCeldas = document.getElementById("contenido").getElementsByTagName("td").item(j).innerHTML;
document.getElementById("contenido").getElementsByTagName("td").item(j).innerHTML = cCeldas+"<img class=\"rell\">";
}

}

function desplaza(){
pasoH = document.getElementById("contenedor").scrollLeft;
pasoV = document.getElementById("contenedor").scrollTop;
document.getElementById("contEncCol").scrollLeft = pasoH;
document.getElementById("contEncFil").scrollTop = pasoV;
}

</script>
<style>
table{border-collapse:collapse}
table td{font:12px monospace; border:0px solid; text-align:center; height:1.5em}
#contEncCol{overflow:hidden; overflow-y:scroll; background:#ccc; width:45em}
#contEncFil{overflow:hidden; overflow-x:scroll; background:#ccc; height:8em}
#contenedor{overflow:auto; width:45em; height:8em}
#contenido{}
.tabla td{border:1px solid; width:3em}
.rell{width:3em; height:0; position:relative; top:-1em; z-index:0; bor der:1px solid red}
</style>
</HEAD>
<BODY onload=iniciar()>
<h2>Tabla que desplaza encabezados con el contenido.</h2>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../periodo/listarPeriodo.php3"><img src="../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../feriado/listaFeriado.php3"><img src="../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../atributos/listarTiposEnsenanza.php3"><img src="../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../../matricula/listarMatricula.php3"><img src="../../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../../ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="#"><img src="../../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<br><p>
<?
	//ALUMNOS DEL CURSO
	$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) ORDER BY ape_pat,ape_mat,nombre_alu asc";
	$result =@pg_exec($conn,$qry);

?>

<table>
<tr>
<td>Alumnos</td>
<td>
<div id="contEncCol">
 <table class="tabla" id="encCol">
 <tr>
 
<?		for($count=1 ; $count<=$diaFinal ; $count++){
			if ($count<10){ ?>
				<TD><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000>0<? echo $count; ?></FONT></TD>
<?			}else{ ?>
				<TD><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><? echo $count; ?></FONT></TD>
<?			}
		}
?>
		<TD>&nbsp;</TD>
		<TD><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000>I.M.</FONT></TD>
 
<!-- <td> A </td><td> B </td><td> C </td><td> D </td>  -->
 
 
 
 
 </tr>
 </table>
</div>
</td>
</tr>

<tr>
<td><div id="contEncFil">
 <table Id="encFil">
<?	$X=0;
	for($i=0 ; $i < @pg_numrows($result) ; $i++){
		$X++;
		$Y=0;
		$fila1 = @pg_fetch_array($result,$i);
?>						
		<TR bgcolor=#ffffff>
			<TD align=left><div align="left"><FONT face="arial, geneva, helvetica" size=1 color=#000000><strong>
<?			echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);	?>
			</strong></FONT></div>
			</TD>
		</TR>
<?	}	?>
 </table>
</div>
</td>
<td>
<div id="contenedor" onscroll="desplaza()">
<table class="tabla" id= "contenido">
 
<?
	$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) ORDER BY ape_pat,ape_mat,nombre_alu asc";
	$result =@pg_exec($conn,$qry);

	$X=0;
	for($i=0 ; $i < @pg_numrows($result) ; $i++){
		$X++;
		$Y=0;
		$fila1 = @pg_fetch_array($result,$i);

		$qry9="select count (rut_alumno) as cantidad from asistencia where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_alumno=".trim($fila1["rut_alumno"]);
		$result9 =@pg_Exec($conn,$qry9);
		$fila9 = @pg_fetch_array($result9,0);
		$cant=$fila9["cantidad"];
		if (!$result9) {
			error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry9);
		}
			
		/******** QRY PARA TRAER DIAS FERIADOS Y COLOREAR LA COLUMNA QUE CORRESPONDE********/
		
		$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
		$resultFer=@pg_Exec($conn,$sqlFer);
		if (!$resultFer) {
			error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
		}
			
		/******** QRY PARA TRAER DIAS INASISTENCIA********/	
		$qry2="select rut_alumno, ano, id_curso, date_part('day',asistencia.fecha) AS day, date_part('month',asistencia.fecha), date_part('year',asistencia.fecha) AS year from asistencia where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_alumno=".trim($fila1["rut_alumno"]);
		$result2 =@pg_Exec($conn,$qry2);

?>		<TR bgcolor=#ffffff>
<?			
		$m=0;
		$ñ=0;
		$cDias=$diaFinal+2;
		//for($c=1;$c<=33;$c++){
		for($c=1;$c<=$cDias;$c++){
			$fila2 = @pg_fetch_array($result2,$ñ);
			$filaFer=@pg_fetch_array($resultFer,$m);

		
			//if ($c<33)	{
			if ($c<$cDias)	{
			
				if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){   ?>
					<TD align=center bgcolor='#FFE6E6' width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
					</strong></font></TD>
<?									$m++;
				}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
					for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
						<TD align=center bgcolor='#FFE6E6' width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
						</strong></font></TD>
<?									}
					$c=$c-1;
					$m++;
					
				}else{
					//if ($c==32){
					if ($c==($cDias-1)){
						if($diaFinal==29){ ?>
							<TD align="left" size=14>&nbsp;&nbsp;&nbsp;</TD>
<?						}	?>
						<TD align="center" width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?						echo $cant;	?>
						</strong></font></TD>
<?						$flag=1;
					}else{
						if ($c==$fila2["day"]){
							$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
							if($dia==6){///SABADO	?>
								<TD align=center bgcolor=#EAEAEA width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?								echo $c;	?>
								</strong></font></TD>
<?							}else///
							if($dia==0){///DOMINGO	?>
								<TD align=center bgcolor=#EAEAEA width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?								echo $c;	?>
								</strong></font></TD>
<?							}else///
							if(($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
								<TD align=center bgcolor=#FFFFD7 width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?								echo $c;	?>
								</strong></font></TD>
<?							}else{ ?>
								<TD align=center bgcolor=#E1EFFF width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?								echo $c;	?>
								</strong></font></TD>
<?							}
							$ñ++;
						}else{
							$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
							if($dia==6){///SABADO	?>
								<TD align=center bgcolor=#EAEAEA width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
								</strong></font></TD>
<?							}else///
							if($dia==0){///DOMINGO	?>
								<TD align=center bgcolor=#EAEAEA width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
								</strong></font></TD>
<?							}else///
							if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
								<TD align=center bgcolor=#FFFFD7 width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
								</strong></font></TD>
<?							}else{	?>
								<TD align=center width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
								</strong></font></TD>
<?							}
						}
					}
				}
			}//fin if $c<32
			 //if (($c==32) and ($flag!=1)){
			 if (($c==($cDias-1)) and ($flag!=1)){	?>
				<TD align=center width=14><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?				echo $cant;	?>
				</strong></font></TD>
<?			}
		}//fin for($c=1;$c<32;$c++)
?>		</TR>
<?
	}
?> 
 <!--
 <tr>
 <td> alfa</td><td> bravo</td><td> charly</td><td> delta</td>
 </tr>
 <tr>
 <td> eco</td><td> foxtrot</td><td> golf</td><td> hotel</td>
 </tr>
 <tr>
 <td> indio</td><td> julieta</td><td> kilo</td><td> lima</td>
 </tr>
 <tr>
 <td> mike</td><td> noviembre</td><td> oscar</td><td> papa</td>
 </tr>
 <tr>
 <td> quebec</td><td> romeo</td><td> sierra</td><td> tango</td>
 </tr>
 <tr>
 <td> uniforme</td><td> victor</td><td> whisky</td><td> x-ray</td>
 </tr>
-->
 </table>
</div>
</td>
</tr>
</table>
</BODY>
</HTML>
