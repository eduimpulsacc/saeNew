<?
require('../../../../util/header.inc');
//setlocale("LC_ALL","es_ES");

function imprime_arreglo($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";
}
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$curso;
	$_POSP = 4;
	$_bot = 8;
	//echo $curso;
	//if (empty($curso)) //exit;
  
    if (($curso != 0) or ($curso != NULL)){	
	    $query_curso="select * from curso where id_curso='$curso'";
	    $row_curso=pg_fetch_array(pg_exec($conn,$query_curso));
	}
		
	//imprime_arreglo($row_curso);
	//------------------------
	// Año Escolar
	//------------------------
	
	
	$sql_ano = "select nro_ano from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];

	// Curso y Profesor Jefe
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//----------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-----------------------------------------
	// Cantidad de Subsectores
	//-----------------------------------------
	$sql_sub = "select count(*) as cantidad from ramo where id_curso = ".$curso." ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$fila_sub = @pg_fetch_array($result_sub,0);	
	$num_subsectores = $fila_sub['cantidad'];
	
	//-----------------------------------------
	// Subsectores
	//-----------------------------------------
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.sub_obli, ramo.bool_ip ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) ORDER BY ramo.id_orden; ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	//-----------------------------------------			
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
<style type="text/css">
<!--
.Estilo1 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
     <div id="capa0">
		 <table width="100%">
		    <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
				<td align="right">
			    <input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onClick="imprimir();"></td>
			</tr>
		 </table>
	 </div>		
	</td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
			<?
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## código para tomar la insignia
	
			if($institucion!=""){
				echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			}else{
				echo "<img src='".$d."menu/imag/logo.gif' >";
			}
			?>
	  	</td>
		 </tr>
     </table>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>
<?
// muestro el promedio y luego limpio las variables
// busco el nombre de tipo de ensenanza

$sql_al  = "select * from promocion where id_curso = '$curso' and situacion_final=2";
$res_al  = @pg_Exec($conn,$sql_al);
$num_al  = @pg_numrows($res_al);
/// 
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td class="tableindex"><div align="center">INFORME DE ALUMNOS REPITENTES DEL CURSO<br>
    	<?
		$Curso_pal2 = CursoPalabra($curso, 1, $conn);
		echo "$Curso_pal2";
		?>	
		</div></td>
	</tr>
	
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  
  <tr>
    <td width="5%" class="tablatit2-1">Nro.</td>
    <td width="15%" class="tablatit2-1">Rut</td>
    <td width="40%" class="tablatit2-1">Nombre</td>
    <td width="20%" class="tablatit2-1">Reprobado por:</td>
    <td width="10%" class="tablatit2-1">Prom. Gral. </td>
    <td width="10%" class="tablatit2-1">% Asist. </td>
  </tr>
  <?
  for ($i=0; $i < $num_al; $i++){
       $fil_al = @pg_fetch_array($res_al,$i);
       $rut_alumno      = $fil_al['rut_alumno'];
	   $promedio        = $fil_al['promedio'];
	   $asistencia      = $fil_al['asistencia'];
	   $situacion_final = $fil_al['situacion_final'];
	   $tipo_reprova    = $fil_al['tipo_reprova'];
	   
	   $sql_alu  = "select rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat from alumno where rut_alumno = '".trim($rut_alumno)."'";
	   $res_alu  = @pg_Exec($conn,$sql_alu);
	   $fil_alu  = @pg_fetch_array($res_alu,0);
	   
	   $nombre_alu = $fil_alu['nombre_alu'];
	   $ape_pat    = $fil_alu['ape_pat'];
	   $ape_mat    = $fil_alu['ape_mat'];
	   $dig_rut    = $fil_alu['dig_rut'];	   
	   
	   ?>
       <tr>
         <td><font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;<?=$i + 1 ?></font></td>
         <td><font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;<?=$rut_alumno ?>-<?=$dig_rut ?></font></td>
         <td><font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;<? echo "$nombre_alu $ape_pat $ape_mat"; ?></font></td>
         <td><font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;
		 <?
		 if ($tipo_reprova==1){
		     echo "Notas";
		 }
		 if ($tipo_reprova==2){
		     echo "Asistencia";
		 }
		 ?>	 	 
		 </font></td>
         <td><div align="center"><font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;
           <?=$promedio ?>
         </font></div></td>
         <td><div align="center"><font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;
           <?=$asistencia ?>%
         </font></div></td>
       </tr>
	   <?
  }
  ?>	   
</table>
<br>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>

<?
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
?>
<!-- FIN CUERPO DE LA PAGINA -->
</td>
</tr>
</table>
</body>
</html>
<? pg_close($conn);?>