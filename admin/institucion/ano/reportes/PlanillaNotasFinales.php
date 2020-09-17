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
	$curso			=$cmb_curso;
	$fin_ano		=$check_ano;
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
	// A�o Escolar
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="731" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="731" height="30" align="center" valign="top"> 
     <?
	include("../../../../cabecera/menu_inferior.php");
	 ?>  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

<?

if (empty($curso)){
     //exit;
}else{
   ?>	 

<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr align="right">
        <td>
		<div id="capa0">
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printPlanillaNotasFinales.php?cmb_curso=<?=$cmb_curso ?>&check_ano=<?=$check_ano ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
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
	    ## c�digo para tomar la insignia

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
<table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td class="tableindex"><div align="center">PLANILLA DE NOTAS FINALES</div></td>
	</tr>
	<tr>
		<td ><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>A�O 
                <? echo $ano_escolar?></strong> </font></div></td>
	</tr>
</table>
<br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">

            <td width="120"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></div></td>
        <td width="526"><font size="1" face="arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
            <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><? echo $profe_jefe;?></font></td>
      </tr>
    </table>
	<br>	<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="2" width="20" class="tablatit2-1">N�</td>
	<td width="170" rowspan="2" class="tablatit2-1">NOMBRE DEL ALUMNO</td>
    <td colspan="<? echo $num_subsectores+1 ?>" class="tablatit2-1"><div align="center">SUBSECTORES</div></td>
    </tr>
  <tr>
    <?	 
	$contador_hijo= 0;
	
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$modo_eval = $fila_sub['modo_eval'];
		$examen = $fila_sub['conex']; // 1 SI 2 NO
		
		/// ver si este ramo pertecene a alguna formula con hijos
		$qry_formula = "select * from formula_hijo where id_hijo = '".trim($id_ramo)."'";
		$res_formula = @pg_Exec($conn,$qry_formula);
		$num_formula = @pg_numrows($res_formula);
		
		if ($num_formula==0){
		    
			?>	
			<td ><div align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong>
			<? InicialesSubsector($subsector_curso) ?>
		    </strong></font></div></td>
	 <? }else{
	        $contador_hijo++;
	 
	    } ?>
		
  <? }
  
  $num_subsectores = $num_subsectores - $contador_hijo; 
  
  ?>
     
	 
	 <td align="center" ><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Final</strong></font></td>
    </tr>
    <?	 
	$numero_alumnos = @pg_numrows($result_alu);	 
	for($i=0 ; $i < @pg_numrows($result_alu) ; $i++)
	{
	  $fila_alu = @pg_fetch_array($result_alu,$i);
	  $nombre_alu = ucwords(strtolower(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu'])));
	  $rut_alumno = $fila_alu['rut_alumno'];
	  ?>	
  <tr>
    <td align="center"><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
    <td><font size="0" face="arial, geneva, helvetica"><? echo substr($nombre_alu,0,25); ?></font></td>
	<?	 
	$promedio_general = 0;
	$cont_prom_general = 0;
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$modo_eval = $fila_sub['modo_eval'];
		$examen = $fila_sub['conex']; // 1 SI 2 NO
		$obliga = $fila_sub['sub_obli'];
		
		/// ver si este ramo pertecene a alguna formula con hijos
		$qry_formula = "select * from formula_hijo where id_hijo = '".trim($id_ramo)."'";
		$res_formula = @pg_Exec($conn,$qry_formula);
		$num_formula = @pg_numrows($res_formula);
		
		if ($num_formula==0){
		
		
		//---------------------------------------
		// Notas
		//-------------------------------------
		// Eximidos
		//-------------------------------------
		$sql_inscri = "select count(*) as cantidad ";
		$sql_inscri = $sql_inscri . "from   tiene$ano_escolar ";
		$sql_inscri = $sql_inscri . "where rut_alumno = ".$rut_alumno."and id_ramo = ".$id_ramo." and id_curso = ".$curso;

		$result_inscri =@pg_Exec($conn,$sql_inscri);
		$fila_inscri= @pg_fetch_array($result_inscri,0);
		if (($fila_inscri['cantidad'] == 0)&&($obliga==1))
		{
			$promedio = "EX";
			$cont_prom=1;
		}
		else
		{
		//-----------------------------------
			if ($examen==1 and $fin_ano == 1)
			{
				$sql_notas = "SELECT situacion_final.nota_final ";
				$sql_notas = $sql_notas . "FROM situacion_final ";
				$sql_notas = $sql_notas . "WHERE (((situacion_final.rut_alumno)=".$rut_alumno.") AND ((situacion_final.id_ramo)=".$id_ramo.")); ";
				$result_notas =@pg_Exec($conn,$sql_notas);
				$promedio = 0;
				$cont_prom = 0;			
				if (@pg_numrows($result_notas)>0)
				{
					$fila_notas = @pg_fetch_array($result_notas,0);
					if ($modo_eval==1)
					{
						if ($fila_notas['nota_final']>0)
						{
							$promedio = $fila_notas['nota_final'];
							$cont_prom = 1;
						}
						else
						{
							$promedio = "&nbsp;";
						}
					}
					else
					{
						if (trim($fila_notas['nota_final'])<>"0"){
							$promedio = $fila_notas['nota_final'];
							$cont_prom = 0;
						}else{ $promedio = "&nbsp;";
						}
					}  
				}
				else
				{
					$promedio = "&nbsp;";
					$cont_prom = 0;
					$e = @pg_numrows($result_notas);
				}
		}
		else
		{
			$prom_se=0;
			$cont_se=0;
			$prom_se1=0;
			$cont_se1=0;
			$result_notas=0;
			$sql_notas = "select promedio from notas$ano_escolar where rut_alumno = ".$rut_alumno." and id_ramo = ".$id_ramo;
			$result_notas =@pg_Exec($conn,$sql_notas);
			
			$sql_ip = "SELECT * FROM ramo WHERE id_ramo=".$id_ramo;
			$result_ip =@pg_Exec($conn,$sql_ip);	
			$fila_ip = pg_fetch_array($result_ip,0);
			
			for($cc=0 ; $cc < pg_numrows($result_notas) ; $cc++)
			{
				$fila_notas = pg_fetch_array($result_notas,$cc);
				if ($modo_eval == 1)
				{
					
					if ((trim($fila_notas['promedio'])>'0')&&(trim($fila_notas['promedio'])!='0'))
					{	//echo "<br> otra cosa que na que ver";
						//echo "<br> promedio ".$fila_notas['promedio'];
							$prom_se = $prom_se + $fila_notas['promedio'];
							$cont_se = $cont_se + 1;
					}
				}
				else
				{
					//echo "<br> else";
					if ((trim($fila_notas['promedio'])!="0") and (trim($fila_notas['promedio'])!=""))
					{
						$prom_se = $prom_se + Conceptual($fila_notas['promedio'],2);
						$cont_se = $cont_se + 1;
					}
					
				}
			}
			if ($modo_eval == 1)
			{
				if ($prom_se>0){
					if ($row_curso[truncado_per]==1){
						$prom_se = round($prom_se/$cont_se,0);
					}
					if ($row_curso[truncado_per]==0){
						$prom_se = floor($prom_se/$cont_se);
					}
				}else
					$prom_se="&nbsp;";
			}
			else
			{
				if ($prom_se>0)
				{
					$prom_se = round($prom_se/$cont_se,0);
					$prom_se  = Conceptual($prom_se,1);
				}
				else
					$prom_se="&nbsp;";
			}
			
			$promedio = $prom_se;
		}
		//-----------------------------------
		}
		if ($promedio > 0 and $modo_eval == 1)
		{
			if($fila_ip['bool_ip']==1){		
				$promedio_general = $promedio_general + $promedio;
				$cont_prom_general = $cont_prom_general + 1;
				$cont_prom_fin = $cont_prom_fin + 1;
				$nota_media = $nota_media + $promedio;
			}			
		}
		$notas_arr[$i][$cont] = $promedio;
       ?>	
        <td align="center"><font size="0" face="arial, geneva, helvetica"><?
			if($promedio<40 && $promedio>0){ ?><font color="#FF0000"><?
				echo $promedio; ?></font><? 
			}
			else if($promedio=='') { 
				echo "&nbsp;";
			}
			else{
				echo $promedio;
			} ?></font></td>
	  <? 
	   }    // fin if de subsector_hijo
	
	
	}
	if ($promedio_general>0){ 
	    if ($row_curso[truncado_per]==1){
		    
		    $promedio_general= round($promedio_general/$cont_prom_general,0);
		} else { 	
		    
		    $promedio_general= floor($promedio_general/$cont_prom_general);
		}
		
  	} else {
		$promedio_general= "&nbsp;";
	}
	?>
    <td ><div align="center"><font size="0" face="arial, geneva, helvetica">
	<? 
	echo $promedio_general; 
	if (empty($cadena02))
	{ 
		if ($promedio_general>0) 
		{
			$cadena02 = $promedio_general; 
			$prom_general_ind = $prom_general_ind + $promedio_general;
			$cont_general_ind = $cont_general_ind + 1;
		}
	}
	else
	{ 
		if ($promedio_general>0) 
		{
			$cadena02 = $cadena02 . ";" . $promedio_general;
			$prom_general_ind = $prom_general_ind + $promedio_general;
			$cont_general_ind = $cont_general_ind + 1;
		}
	}
	?>
	</font></div></td>
    </tr>
  	<?
		
	 } 
	?>	
  <tr>
    <td>&nbsp;</td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Nota Menor</strong></font></td>
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
		   <td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? 
			  if($indice[0]<40 && $indice[0]>0){ ?><font color="#FF0000"><? 
				 echo $indice[0];?></font><? 
			  }
			   else if($indice[0]==''){
				  echo "&nbsp;"; 
				 
			  }
			  else{
				echo $indice[0]; 
			}?></strong></font></td>
			
	 
			
			
    <? }
	$indice = explode(";",$cadena02);
	sort($indice);
	?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[1]>0) echo $indice[1]; else echo "&nbsp;"; ?></strong></font></td>
  </tr>
  
  
  <tr>
    <td>&nbsp;</td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Nota Mayor </strong></font></td>
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
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></strong></font></td>
    <? }
	$indice = explode(";",$cadena02);
	rsort($indice);
	?>
	<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($indice[0]>0) echo $indice[0]; else echo "&nbsp;"; ?></strong></font></td>
  </tr>
  
  
  <tr>
    <td>&nbsp;</td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Nota Media </strong></font></td>
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
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($prom_resu>0) echo $prom_resu; else echo "&nbsp;"; ?></strong></font></td>
    <? }?>

	<?
		$prom_resu = 0;
		$cont_resu = 0;
		$indice = explode(";",$cadena02);
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
		<td align="center"><font face="verdana,Arial, Helvetica, sans-serif" size="1"><strong><? if($prom_resu>0) echo $prom_resu; else echo "&nbsp;"; ?></strong></font></td>
  </tr>
	</table>	
	</td>
  </tr>
</table>

<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
</center>
  <?
}
?>  

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

<!-- INICIO FORMULARIO DE BUSQUEDA -->

 <form action="PlanillaNotasFinales_m.php" method="post">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
?>
<center>
<table width="686" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="674">
	<table width="684" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="680" class="tableindex">Buscador Avanzado </span></td>
  </tr>
  <tr>
    <td height="27">
	<table width="684" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="" class="cuadro01">Buscar por Curso
      <select name="cmb_curso" class="ddlb_x">
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
		  }?>
      </select>
    </td>
    
    <td width="">
	     <?
		 if ($check_ano == 1){
		    ?>
	        <input type="checkbox" name="check_ano" value="1" checked="checked">
			<?
		 }else{
		    ?>
			<input type="checkbox" name="check_ano" value="1">
			<?
	     }
		 ?>			 
      <span class="cuadro01">Fin de A�o</span></td>
    <td width="84">
            <div align="center">
			  <input name="cb_ok" class="botonXX"  type="submit" value="Buscar">        
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>