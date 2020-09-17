<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../../util/header.inc');

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$cadena01		="";	
	$_POSP = 5;
	$_bot = 8;
	//if (empty($curso)) //exit;
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//------------------------
	// Periodo
	//------------------------
	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo =@pg_Exec($conn,$sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'];
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-----------------------------------------
	// Institución
	//-----------------------------------------
	$sql_insti = "Select * from institucion where rdb = " . $institucion;
	$result_insti =@pg_Exec($conn,$sql_insti);
	$fila_insti = @pg_fetch_array($result_insti,0);	
	$nombre_insti = $fila_insti['nombre_instit'];
	//-----------------------------------------
	// Curso y Profesor Jefe
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//-----------------------------------------
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
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
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
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
<link href="../../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../css/objeto.css" rel="stylesheet" type="text/css">

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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg','<? echo $c; ?>botones/periodo_roll.gif','<? echo $c; ?>botones/feriados_roll.gif','<? echo $c; ?>botones/planes_roll.gif','<? echo $c; ?>botones/tipos_roll.gif','<? echo $c; ?>botones/cursos_roll.gif','<? echo $c; ?>botones/matricula_roll.gif','<? echo $c; ?>botones/informe_roll.gif','<? echo $c; ?>botones/reportes_roll.gif','<? echo $c; ?>botones/actas_roll.gif','<? echo $c; ?>botones/generar_roll.gif')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" height="1" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="1038"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%"  align="left" valign="top"> 
                        <?
						include("../../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr valign="top"> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="731" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="731" height="30" align="center" valign="top"> 
       <?
	   include("../../../../../cabecera/menu_inferior.php");
	   ?>
	  <tr>
    <td> <div align="right"><font color="#000099" size="2">*para volver presione 
        Reportes</font><font color="#000099"><strong> </strong></font></div></td>
		</tr> 
  
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<?
if (empty($curso)){
   // exit;
}else{
   ?>   

<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonX" onClick="MM_openBrWindow('printPlanillaNotasGeneralesPeriodo.php?cmb_curso=<?=$cmb_curso ?>&cmb_periodos=<?=$cmb_periodos ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div>
        </div>
		</td>
      </tr>
    </table>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($direccion));?></font><font face="Verdana, Arial, Helvetica, sans-serif" size="+1">&nbsp;</font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">

							<img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE"  height="100"></td>
			 </tr>
             </table>
			<? } ?>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>
	</td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="tableindex">PROMEDIOS GENERALES</td>
      </tr>
      <tr>
        <td align="center"><font size="2" face="arial, geneva, helvetica"><? echo $periodo_pal?> DEL <? echo $ano_escolar?> </font></td>
      </tr>
</table>
    <?	 
for($cont=0 ; $cont < $num_subsectores; $cont++)
{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$subsector_array[$cont] = $subsector_curso ;
		$id_ramo = $fila_sub['id_ramo'];
		$modo_eval = $fila_sub['modo_eval'];
		$examen = $fila_sub['conex']; // 1 SI 2 NO
		
		$numero_alumnos = @pg_numrows($result_alu);	 
		for($i=0 ; $i < @pg_numrows($result_alu) ; $i++)
		{
			$fila_alu = @pg_fetch_array($result_alu,$i);
			$nombre_alu = trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']);
			$nombre_alu_array[$i] = $nombre_alu;
			$rut_alumno = $fila_alu['rut_alumno'];
			$promedio_general = 0;
			$cont_prom_general = 0;
			$promedio = 0;
			$cont_prom = 0;
			for($cont=0 ; $cont < $num_subsectores; $cont++)
			{
				$fila_sub = @pg_fetch_array($result_sub,$cont);	
				$subsector_curso = $fila_sub['nombre'];
				$subsector_array[$cont] = $subsector_curso ;
				$id_ramo = $fila_sub['id_ramo'];
				//---------------------------------------
				// Notas
				//---------------------------------------
				$sql_notas = "SELECT notas$ano_escolar.promedio ";
				$sql_notas = $sql_notas . "FROM notas$ano_escolar ";
				$sql_notas = $sql_notas . "WHERE (((notas$ano_escolar.rut_alumno)='".$rut_alumno."') AND ((notas$ano_escolar.id_ramo)=".$id_ramo.") and id_periodo = ".$periodo.") ; ";
			
				//echo $sql_notas;
				//exit;
				$result_notas =@pg_Exec($conn,$sql_notas);
				$cont_prom = 0;
				for($e=0 ; $e < @pg_numrows($result_notas) ; $e++)
				{
				  $fila_notas = @pg_fetch_array($result_notas,$e);
				  $promedio = $fila_notas['promedio'];
				  if ($promedio>0) 
					$cont_prom = $cont_prom + 1;
				}  
				//-------------------------------------
				// Eximidos
				//-------------------------------------
				$sql_inscri = "select count(*) as cantidad ";
				$sql_inscri = $sql_inscri . "from   tiene$ano_escolar ";
				$sql_inscri = $sql_inscri . "where rut_alumno = '".$rut_alumno."' and id_ramo = ".$id_ramo." and id_curso = ".$curso;
				$result_inscri =@pg_Exec($conn,$sql_inscri);
				$fila_inscri= @pg_fetch_array($result_inscri,0);
				if ($fila_inscri['cantidad'] == 0)
				{
					$promedio = "EX";
					$cont_prom = 1;
				}	
				else
				{
					if ($modo_eval <> 1)
					{
						 if (trim($promedio)<>"0")
							$cont_prom = 1;
						else
							$cont_prom = 0;
					}
				}
				if ($promedio > 0)
				{
					$promedio_general = $promedio_general + $promedio;
					$cont_prom_general = $cont_prom_general + 1;
					$notas_arr[$i][$cont] = $promedio;
				}else{
					$notas_arr[$i][$cont] = "&nbsp;";
				}
			}
			if ($promedio_general>0){
				$promedio_general= round($promedio_general/$cont_prom_general,0);
				$promedio_general_array[$i] = $promedio_general;
			} else {
				$promedio_general= "&nbsp;";
				$promedio_general_array[$i] = "&nbsp;";
			}	
			if ($promedio_general>0) 
			{
				if ($cadena01=="")
					$cadena01 = $promedio_general;
				else
					$cadena01 = $cadena01 . ";" . $promedio_general;
				$prom_prom = prom_prom + $promedio_general;
				$cont_cont = cont_cont + 1;
			}		
		}
	}
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		for($i=0 ; $i < $numero_alumnos ; $i++)
		{
			if ($notas_arr[$i][$cont]>0)
			{
			if ($cadena=="")
				$cadena = $notas_arr[$i][$cont];
			else
				$cadena = $cadena . ";" . $notas_arr[$i][$cont];
			}	
		}
		$indice = explode(";",$cadena);
		sort($indice);
		$nota_menor[$cont]=$indice[0];
		rsort($indice);
		$nota_mayor[$cont] = $indice[0];
	}
	$indice = explode(";",$cadena01);
	sort($indice);
	$promedio_menor = $indice[0];
	rsort($indice);
	$promedio_mayor = $indice[0];
	?>
<br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="107"><font size="2" face="arial, geneva, helvetica"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="2" face="arial, geneva, helvetica"><strong>:</strong></font></div></td>
        <td width="533"><font size="2" face="arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
        <td><font size="2" face="arial, geneva, helvetica"><strong>Profesor(a) Jefe</strong></font></td>
        <td></div><font size="2" face="arial, geneva, helvetica"><strong>:</strong></font></td>
        <td><font size="2" face="arial, geneva, helvetica"><? echo $profe_jefe;?></font></td>
      </tr>
    </table>
	<br>
	<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="2" width="20" class="tablatit2-1">Nº</td>
	<td rowspan="2" width="170" class="tablatit2-1">NOMBRE DEL ALUMNO</td>
    <td colspan="<? echo $num_subsectores+1 ?>" class="tablatit2-1"><div align="center">SUBSECTORES</div></td>
    </tr>
  <tr>
  	<? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{?>	
    <td align="center"><font size="2" face="arial, geneva, helvetica"><strong>
    <? InicialesSubsector($subsector_array[$cont],2) ;
	$siglas = $siglas . $subsector_array[$cont]." = <strong>".InicialesSubsector($subsector_array[$cont],1)."</strong> | ";
	?>
    </strong></font></td>
	<? } ?>
    <td align="center" ><font size="2" face="arial, geneva, helvetica"><strong>Final</strong></font></td>
    </tr>
	<?
	for($i=0 ; $i < $numero_alumnos ; $i++)
	{?>	
  <tr>
    <td><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
    <td><font size="0" face="arial, geneva, helvetica"><? echo substr(ucwords(strtolower($nombre_alu_array[$i])),0,25); ?></font></td>
	<?
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
	?>
    <td align="center"><font size="0" face="arial, geneva, helvetica">
      <? if ($nota_menor[$cont]==$notas_arr[$i][$cont] or $nota_mayor[$cont]==$notas_arr[$i][$cont]){ echo "<strong>".$notas_arr[$i][$cont]."</strong>"; } else {echo $notas_arr[$i][$cont];}?>
    </font></td>
	<? } ?>
    <td align="center"><font size="0" face="arial, geneva, helvetica">
      <? if ($promedio_menor==$promedio_general_array[$i] or $promedio_mayor==$promedio_general_array[$i]){ echo "<strong>".$promedio_general_array[$i]."</strong>"; } else {echo $promedio_general_array[$i];}?>
    </font></td>
  	</tr>
	<? } ?>
	<tr>
    <td colspan= <? echo $num_subsectores+3?> height="20"></td>
    </tr>
  <tr>
    <td colspan="2"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Nota Menor</strong></font></td>
    <? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		for($i=0 ; $i < $numero_alumnos ; $i++)
		{
			if ($notas_arr[$i][$cont]>0)
			{
			if ($cadena=="")
				$cadena = $notas_arr[$i][$cont];
			else
				$cadena = $cadena . ";" . $notas_arr[$i][$cont];
			}	
		}
		$indice = explode(";",$cadena);
		sort($indice);
		?>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></font></td>
    <? }
	$indice = explode(";",$cadena01);
	sort($indice);
	?>
	<td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></font></td>
  </tr>
  <tr>
    <td colspan="2"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Nota Mayor </strong></font></td>
    <? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		for($i=0 ; $i < $numero_alumnos ; $i++)
		{
			if ($notas_arr[$i][$cont]>0)
			{
			if ($cadena=="")
				$cadena = $notas_arr[$i][$cont];
			else
				$cadena = $cadena . ";" . $notas_arr[$i][$cont];
			}	
		}
		$indice = explode(";",$cadena);
		rsort($indice);
		?>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></font></td>
    <? }
	$indice = explode(";",$cadena01);
	rsort($indice);
	?>
	<td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></font></td>
  </tr>
  <tr>
    <td colspan="2"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Nota Media </strong></font></td>
    <? 	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$cadena = "";
		$indice = "";
		$prom_resu = 0;
		$cont_resu = 0;		
		for($i=0 ; $i < $numero_alumnos ; $i++)
		{
			if ($notas_arr[$i][$cont]>0)
			{
				$prom_resu = $prom_resu + $notas_arr[$i][$cont];
				$cont_resu = $cont_resu + 1;
			}
		}
		if ($cont_resu>0) $prom_resu = round($prom_resu / $cont_resu,0)
		?>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><? if($prom_resu>0) echo $prom_resu; else echo "&nbsp;"; ?></font></td>
    <? }?>

	<?
		$prom_resu = 0;
		$cont_resu = 0;
		$indice = explode(";",$cadena01);
		for($cont=0 ; $cont < $num_subsectores; $cont++)
		{
			if ($indice[$cont]>0)
			{
				$prom_resu = $prom_resu + $indice[$cont];
				$cont_resu = $cont_resu + 1;
			}

		}
		if ($cont_resu>0) $prom_resu = round($prom_resu / $cont_resu,0)
	?>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><? if($prom_resu>0) echo $prom_resu; else echo "&nbsp;"; ?></font></td>
  </tr>
	</table>	
	</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $siglas?></font></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
<table width="650" height="119" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="27"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:_______________________________________________________________<font size="2"><strong>__________<font size="2"><strong>_____</strong></font></strong></font></font></strong></font></div></td>
  </tr>
  <tr>
    <td height="22"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
  </tr>
  <tr>
    <td height="23"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
  </tr>
  <tr>
    <td height="23"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
  </tr>
</table>
</center>
  <?
}

?>  
<?
function InicialesSubsector($Subsector,$tipo)
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
		if (strlen($cadena)==5 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		$x = trim(strtoupper(substr($Subsector,0,3)));
	else
		$x = trim($cadena);
	if ($tipo==1)
		return $x;
	else
		echo $x;
}
?>
  
<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'PlanillaNotasGeneralesPeriodo.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}			
</script>

<form method "post" action="PlanillaNotasGeneralesPeriodo.php">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
<center>
<table width="709" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701"  class="tableindex">Buscador Avanzado</td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="69" class="textosmediano">Curso</td>
    <td width="272">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso" class="ddlb_x">
		  <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  	$fila = @pg_fetch_array($resultado_query_cue,$i); 
			$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
			if ($fila['id_curso'] == $cmb_curso){
			   echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
			}else{
			   echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
			}
			      
		  } ?>
        </select>
	    </font>	  </div></td>
    <td width="61" class="textosmediano">Periodo</span></td>
    <td width="219"><select name="cmb_periodos">
			<option value=0 selected>(Seleccione Periodo)</option>
       <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); ?>
		  <?
		  if ($fila['id_periodo'] == $cmb_periodos){
		      ?>
              <option value="<? echo $fila['id_periodo']?>" selected><? echo $fila['nombre_periodo']?></option>
	          <?
		  }else{
		      ?>
              <option value="<? echo $fila['id_periodo']?>"><? echo $fila['nombre_periodo']?></option>
	          <?
		   }	  	  
	   
	   
	   } ?>
    </select></td>
    <td width="80"><div align="right">
      <input name="cb_ok" class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' type= "submit"  value="Buscar">
    </div></td>
  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>

<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="12" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
