<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

//setlocale("LC_ALL","es_ES");

function imprime_arreglo($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";
}
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$id_periodo	    =$cmb_periodos;
	$reporte		=$c_reporte;
	$fin_ano		=$check_ano;
	$_POSP = 4;
	$_bot = 8;
	//echo $curso;
	//if (empty($curso)) //exit;
  
    if (($curso != 0) or ($curso != NULL)){	
	    $query_curso="select * from curso where id_curso='$curso'";
	    $row_curso=pg_fetch_array(pg_exec($conn,$query_curso));
	}
	
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	//imprime_arreglo($row_curso);
	//------------------------
	// Año Escolar
	//------------------------
	$ob_reporte ->ano=$ano;
	$ob_reporte ->AnoEscolar($conn);
	$ano_escolar = $ob_reporte->nro_ano;

	//-------------- INSTITUCION -------------------------------------------------------------
	$ob_reporte ->institucion = $institucion;
	$ob_reporte ->institucion($conn);
	
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
<script> 
function cerrar(){ 
window.close() 
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

<table width="770" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
	<div id="capa0">
	  <table width="650">
		<tr>
		  <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
		  </td>
		  <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </td>
		</tr>
	  </table>
    </div>
	
	
	
	</td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_reporte->ins_pal));?></strong></font></td>
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
	  }?>
	  		</td>
		 </tr>
     </table>
	</td>
  </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_reporte->direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_reporte->telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>
<table width="770" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td class="tableindex"><div align="center">CANTIDAD DE NOTAS POR SUBSECTOR EN CURSOS</div></td>
	</tr>
	<tr>
		<td ><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>AÑO 
                <? echo $ob_reporte->nro_ano;?></strong> </font></div></td>
	</tr>
</table>
<?

/// para determinar cuantos tipos de enseñanza son:
$sql_1 = "SELECT DISTINCT cod_tipo from tipo_ense_inst where rdb = '".$_INSTIT."' and cod_tipo > '100'";
$res_1 = @pg_Exec($conn,$sql_1);
$num_1 = @pg_numrows($res_1);


/// para calcular cuantos cursos son en total de la institucion
$sql_2 = "select count(id_curso) from curso where id_ano = '".$_ANO."'";
$res_2 = @pg_Exec($conn,$sql_2);
$num_2 = @pg_numrows($res_2);



/// para calcular cuantos cursos son en total en la institucion
$sql_5 = "select id_curso from curso where id_ano = '".$_ANO."'  and ensenanza > '100'";
$res_5 = @pg_Exec($conn,$sql_5);
$num_5 = @pg_numrows($res_5);

?>

<table width="770" border="0" cellpadding="2" cellspacing="1" bgcolor="#006699">
  <tr>
    <td width="30%" rowspan="3" align="center" bgcolor="#FFFFFF"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Subsectores</b></font></td>
    <td colspan="<?=$num_5 ?>" bgcolor="#FFFFFF" height="30"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Cursos</b></font></div></td>
    </tr>
  <tr>
    <?
	for ($x=0; $x < $num_1; $x++){
	    $fil_1 = @pg_fetch_array($res_1,$x); 
	    $cod_tipo = $fil_1['cod_tipo'];
		
		/// para calcular cuantos cursos son por tipo de enseñanza
		$sql_3 = "select id_curso from curso where id_ano = '".$_ANO."' and ensenanza = '$cod_tipo'";
        $res_3 = @pg_Exec($conn,$sql_3);
        $num_3 = @pg_numrows($res_3);
		
		/// para tomar el nombre de tipo de ensenanza
		$sql_9 = "select nombre_tipo from tipo_ensenanza where cod_tipo = '$cod_tipo'";
		$res_9 = @pg_Exec($conn,$sql_9);
		$fil_9 = @pg_fetch_array($res_9,0);
		
		$nombre_tipo = $fil_9['nombre_tipo'];	
		
		?>
        <td colspan="<?=$num_3 ?>" align="center" bgcolor="#FFFFFF"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><? echo $nombre_tipo; ?> </b></font></td>
    <?
	} 
	?>		
  </tr>
  <tr>
    <?
	
	/// para desplegar todos los cursos de la insticuón
	$sql_4 = "select grado_curso, letra_curso, id_curso from curso where id_ano = '".$_ANO."'  and ensenanza > '100' order by ensenanza, grado_curso, letra_curso";
	$res_4 = @pg_Exec($conn,$sql_4);
	$num_4 = @pg_numrows($res_4);
	
	for ($i=0; $i < $num_4; $i++){
	    $fil_4 = @pg_fetch_array($res_4,$i);
	    $grado_curso = $fil_4['grado_curso'];
		$letra_curso = $fil_4['letra_curso'];
		
		?>	
        <td bgcolor="#FFFFFF"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo "$grado_curso - $letra_curso"; ?></font></td>
		<?
	}	
    ?>
  </tr>
  <?
  /// para determinar cuantos subsectores tiene la institucion
  $sql_6 = "select * from subsector where cod_subsector in (select DISTINCT cod_subsector from ramo where id_curso in (select id_curso from curso where id_ano = '".$_ANO."' order by ensenanza, grado_curso, letra_curso)) order by cod_subsector";
  $res_6 = @pg_Exec($conn,$sql_6);
  $num_6 = @pg_numrows($res_6);
  
  for ($j=0; $j < $num_6; $j++){
       $fil_6 = @pg_fetch_array($res_6,$j);
	   $cod_subsector    = $fil_6['cod_subsector'];
	   $nombre_subsector = $fil_6['nombre'];
	   ?>  
	  <tr>
		<td height="10" bgcolor="#FFFFFF"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo "$cod_subsector - $nombre_subsector"; ?></font></td>
		<?
		
		for ($i=0; $i < $num_4; $i++){ 
		    $fil_4 = @pg_fetch_array($res_4,$i);
	        $id_curso = $fil_4['id_curso'];
			
			/// detectar cuantas notas se han ingresado en este curso, del ramo en curso
			$sql_7 = "select * from notas$ano_escolar where id_ramo in (select id_ramo from ramo where id_curso = '$id_curso' and cod_subsector = '$cod_subsector') and id_periodo = '$id_periodo'"; 
			$res_7 = @pg_Exec($conn,$sql_7);
			$num_7 = @pg_numrows($res_7);
			
						
			$max_nota = 0;
			for ($y=0; $y < $num_7; $y++){
			    $fil_7    = @pg_fetch_array($res_7,$y);
			    $nota1  = $fil_7['nota1'];
				$nota2  = $fil_7['nota2'];
				$nota3  = $fil_7['nota3'];
				$nota4  = $fil_7['nota4'];
				$nota5  = $fil_7['nota5'];
				$nota6  = $fil_7['nota6'];
				$nota7  = $fil_7['nota7'];
				$nota8  = $fil_7['nota8'];
				$nota9  = $fil_7['nota9'];
				$nota10 = $fil_7['nota10'];
				$nota11 = $fil_7['nota11'];
				$nota12 = $fil_7['nota12'];
				$nota13 = $fil_7['nota13'];
				$nota14 = $fil_7['nota14'];
				$nota15 = $fil_7['nota15'];
				$nota16 = $fil_7['nota16'];
				$nota17 = $fil_7['nota17'];
				$nota18 = $fil_7['nota18'];
				$nota19 = $fil_7['nota19'];
				
				if ($nota1 > 0){
				    $pos1 = 1;
					if ($pos1 >= $max_nota){
					    $max_nota = $pos1;
					}
				}
				if ($nota2 > 0){
				    $pos2 = 2;
					if ($pos2 >= $max_nota){
					    $max_nota = $pos2;
					}
				}
				if ($nota3 > 0){
				    $pos3 = 3;
					if ($pos3 >= $max_nota){
					    $max_nota = $pos3;
					}
				}
				if ($nota4 > 0){
				    $pos4 = 4;
					if ($pos4 >= $max_nota){
					    $max_nota = $pos4;
					}
				}
				if ($nota5 > 0){
				    $pos5 = 5;
					if ($pos5 >= $max_nota){
					    $max_nota = $pos5;
					}
				}
				if ($nota6 > 0){
				    $pos6 = 6;
					if ($pos6 >= $max_nota){
					    $max_nota = $pos6;
					}
				}
				if ($nota7 > 0){
				    $pos7 = 7;
					if ($pos7 >= $max_nota){
					    $max_nota = $pos7;
					}
				}
				if ($nota8 > 0){
				    $pos8 = 8;
					if ($pos8 >= $max_nota){
					    $max_nota = $pos8;
					}
				}
				if ($nota9 > 0){
				    $pos9 = 9;
					if ($pos9 >= $max_nota){
					    $max_nota = $pos9;
					}
				}
				if ($nota10 > 0){
				    $pos10 = 10;
					if ($pos10 >= $max_nota){
					    $max_nota = $pos10;
					}
				}
				if ($nota11 > 0){
				    $pos11 = 11;
					if ($pos11 >= $max_nota){
					    $max_nota = $pos11;
					}
				}
				if ($nota12 > 0){
				    $pos12 = 12;
					if ($pos12 >= $max_nota){
					    $max_nota = $pos12;
					}
				}
				if ($nota13 > 0){
				    $pos13 = 13;
					if ($pos13 >= $max_nota){
					    $max_nota = $pos13;
					}
				}
				if ($nota14 > 0){
				    $pos14 = 14;
					if ($pos14 >= $max_nota){
					    $max_nota = $pos14;
					}
				}
				if ($nota15 > 0){
				    $pos15 = 15;
					if ($pos15 >= $max_nota){
					    $max_nota = $pos15;
					}
				}
				if ($nota16 > 0){
				    $pos16 = 16;
					if ($pos16 >= $max_nota){
					    $max_nota = $pos16;
					}
				}
				if ($nota17 > 0){
				    $pos17 = 17;
					if ($pos17 >= $max_nota){
					    $max_nota = $pos17;
					}
				}
				if ($nota18 > 0){
				    $pos18 = 18;
					if ($pos18 >= $max_nota){
					    $max_nota = $pos18;
					}
				}
				if ($nota19 > 0){
				    $pos19 = 19;
					if ($pos19 >= $max_nota){
					    $max_nota = $pos19;
					}
				}			
			}		
		    ?>			
			<td align="center" bgcolor="#FFFFFF"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$max_nota ?></font></td>
			<?
		}
		?>
			
	  </tr>
	  <?
   }
   
   ?>	  
</table>
<br>
<br></td>
  </tr>
</table>

<br>
<table width="770" border="0" cellspacing="0" cellpadding="0">
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

 
 	<? pg_close($conn);?>							 
</body>
</html>
