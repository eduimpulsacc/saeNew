<?
require('../../../../util/header.inc');

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	if ($docente == 0){
	   $cmb_docente	  =$cmb_docente;
	   $cmb_subsector =$cmb_subsector;
	   $cmb_periodo	  =$cmb_periodo;
	}else{   
	   $cmb_docente	  =$docente;
	   $cmb_subsector =$subsector;
	   $cmb_periodo	  =$periodo;
	}
	   
	$_POSP = 4;
	$_bot = 8;
	
	
?>

<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
   if ($cmb_docente==0)
		//exit;


//----------------------------------------------------------------------------
// AÑO ESCOLAR
	$sql_ano = "SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano_act = @pg_fetch_array($result_ano,0);
	$ano_act = $fila_ano_act['nro_ano']; 

//----------------------------------------------------------------------------
// DATOS PERIODO
	$sql_periodo = "select * from periodo where id_periodo=".$cmb_periodo." ";
	$result_periodo = @pg_exec($conn, $sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'] . " DEL " . $ano_act;

//----------------------------------------------------------------------------
// DATOS INSTITUCION
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'])) . " " . $fila_institu['nro'] . " - " . ucwords(strtolower($fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];

//-----------------------------------------
// DATOS PROFESOR
	$sql_profesor = "SELECT nombre_emp, ape_pat, ape_mat FROM empleado WHERE rut_emp='".$cmb_docente."' ";
	$resultado_profesor = pg_exec($conn,$sql_profesor);
	$fila2 = @pg_fetch_array($resultado_profesor,0);

//---------------------------------------------------
// DATOS SUBSECTOR
	$sql_Subsector = "SELECT nombre FROM subsector as s where s.cod_subsector=".$cmb_subsector ."";
	$result_Subsector = @pg_exec($conn,$sql_Subsector);
	$fila3 = @pg_fetch_array($result_Subsector,0);
	$nombre_subsector = strtolower($fila3['nombre']);
	$nombre_subsector = ucwords($nombre_subsector);
//---------------------------------------------------
// DATOS CURSOS
	$sql_curso = "SELECT DISTINCT (c.id_curso),c.grado_curso, c.letra_curso, r.id_ramo FROM curso as c INNER JOIN dicta as d ON d.rut_emp='".$cmb_docente."' INNER JOIN ramo as r ON d.id_ramo=r.id_ramo WHERE r.id_curso=c.id_curso AND c.id_ano=".$ano." AND r.cod_subsector=".$cmb_subsector ." ";
	$resultado_curso = @pg_exec($conn,$sql_curso);
?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_docente.value!=0){
				form.cmb_docente.target="self";
				form.action = 'informe_estadistico.php?cmb_docente=<?=$docente ?>&cmb_periodo=<?=$periodo ?>&cmb_subsector=<?=$subsector ?>';
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
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
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
	  <tr>
    <td> <div align="right"><font color="#000099" size="2">*para volver presione 
        Reportes</font><font color="#000099"><strong> </strong></font></div></td>
		</tr> 
  
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->


<?
 if ($cmb_docente!=0 and $cmb_subsector != 0 and $cmb_periodo != 0){
		//exit;
		
 ?>		
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
		<div align="right">
		  <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printinforme_estadistico.php?docente=<?=$docente ?>&subsector=<?=$subsector ?>&periodo=<?=$periodo ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div>
      </div></td>
  </tr>
</table>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>

		<table width="650" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<?
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			if 	(!empty($fila_foto['insignia']))
			{
				$output= "select lo_export(".$arr['insignia'].",'/opt/www/coeint/tmp/".$arr[rdb]."');";
				$retrieve_result = @pg_exec($conn,$output);?>  
				<td width="119" rowspan="6"><div align="center"><img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE" height="100"></div></td>
				<td width="50">&nbsp;</td>
				<td>
					<table>
					  <tr>
						<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $nombre_institu;?></strong></font></div></td>
					  </tr>
					</table>
					<table>
					  <tr>
						<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $direccion;?></strong></font></div></td>
					  </tr>
					</table>
					<table>
					  <tr>
						<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Fono <? echo $telefono;?></strong></font></div></td>
					  </tr>
					</table>
				</td>
			<? }
				else{	?>
					<td>
						<table>
						  <tr>
							<td width="650"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $nombre_institu;?></strong></font></div></td>
						  </tr>
						</table>
						<table>
						  <tr>
							<td width="650"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $direccion;?></strong></font></div></td>
						  </tr>
						</table>
						<table>
						  <tr>
							<td width="650"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Fono <? echo $telefono;?></strong></font></div></td>
						  </tr>
						</table>
					</td>
			<? }	?>
			</tr>	
		</table>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr><td colspan="3">&nbsp;</td></tr>
  <tr>
    <td  colspan="3" class="tableindex"><div align="center">INFORME ESTAD&Iacute;STICO POR DOCENTE</div></td>
    </tr>
  <tr>
    <td colspan="3"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $periodo_pal; ?></strong></font></div></td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="72"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Profesor</strong></font></div></td>
    <td width="10"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td width="568"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><?php echo "".$fila2['nombre_emp']." ".$fila2['ape_pat']." ".$fila2['ape_mat']." "; ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Subsector</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><?php echo $nombre_subsector; ?></font></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="258"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Curso</strong></font></div></td>
    <td width="62"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nº Alumnos</strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><0 - 2></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><2.1 - 3></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><3.1 - 4></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><4.1 - 5></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><5.1 - 6></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><6.1 - 7.0></strong></font></div></td>
    </tr>

  
<? 
	$sum_total_alumno = 0;
	$rut = 0;
    $cont_gen1 = 0; $cont_gen2 = 0;
    $cont_gen3 = 0; $cont_gen4 = 0;
    $cont_gen5 = 0; $cont_gen6 = 0;

	for($i=0;$i<@pg_numrows($resultado_curso);$i++){
		$fila4 = @pg_fetch_array($resultado_curso,$i);
	    $Curso_pal = CursoPalabra($fila4['id_curso'], 1, $conn);
		$curso[$i] = $fila4['id_curso'];
		$ramo[$i] = $fila4['id_ramo'];
		
		$sql_alumno_curso = "select tiene$ano_act.rut_alumno from tiene$ano_act inner join matricula on tiene$ano_act.rut_alumno=matricula.rut_alumno where matricula.id_curso=".$curso[$i]." and id_ramo=".$ramo[$i]." ";
		$result_alumno_curso = @pg_exec($conn, $sql_alumno_curso);
		$rut = @pg_numrows($result_alumno_curso);
		
		for($a=0;$a<@pg_numrows($result_alumno_curso);$a++){
			$fila5 = @pg_fetch_array($result_alumno_curso,$a);
			$rut_alumno[$a] = trim($fila5['rut_alumno']);
		}

		$sum_total_alumno = $sum_total_alumno + $rut ;
		
		for($u=0;$u<@pg_numrows($result_alumno_curso);$u++){
			$sql_notas = "SELECT notas$ano_act.promedio, notas$ano_act.id_ramo, notas$ano_act.id_periodo FROM notas$ano_act WHERE notas$ano_act.id_ramo=".$ramo[$i]." AND notas$ano_act.id_periodo=".$cmb_periodo." AND notas$ano_act.rut_alumno='".$rut_alumno[$u]."'";
			$result_notas = @pg_Exec($conn, $sql_notas);

			$fila_notas = @pg_fetch_array($result_notas,0);
			$promedio[$u] = $fila_notas['promedio'];
			$Cuenta ++;
		}

		$con_gen  = 0;
		$con_1 = 0;		$con_2 = 0;
		$con_3 = 0;		$con_4 = 0;
		$con_5 = 0;		$con_6 = 0;
		$porcentaje1=0; $porcentaje2=0;						
		$porcentaje3=0; $porcentaje4=0;								
		$porcentaje5=0; $porcentaje6=0;								

		for($o=0 ; $o < @pg_numrows($result_alumno_curso) ; $o++)
		{
				if ($promedio[$o]>=0)
				{
					$con_gen = $con_gen +1;
					if ($promedio[$o] >= 0 and  $promedio[$o] <= 20)
						$con_1 = $con_1  + 1;
					if ($promedio[$o] > 20 and  $promedio[$o] <= 30)
						$con_2 = $con_2  + 1;
					if ($promedio[$o] > 30 and  $promedio[$o] <= 40)
						$con_3 = $con_3  + 1;
					if ($promedio[$o] > 40 and  $promedio[$o] <= 50)
						$con_4 = $con_4  + 1;
					if ($promedio[$o] > 50 and  $promedio[$o] <= 60)
						$con_5 = $con_5  + 1;										
					if ($promedio[$o] > 60 and  $promedio[$o] <= 70)
						$con_6 = $con_6  + 1;
				}
		}// fin for o
							
		if ($con_1>0)
			$porcentaje1 = round($con_1*100/$con_gen,0) ."";
		else
			$porcentaje1 = "0";
		if ($con_2>0)
			$porcentaje2 = round($con_2*100/$con_gen,0) ."";
		else
			$porcentaje2 = "0";			
		if ($con_3>0)
			$porcentaje3 = round($con_3*100/$con_gen,0) ."";
		else
			$porcentaje3 = "0";
		if ($con_4>0)
			$porcentaje4 = round($con_4*100/$con_gen,0) ."";
		else
			$porcentaje4 = "0";
		if ($con_5>0)
			$porcentaje5 = round($con_5*100/$con_gen,0) ."";
		else
			$porcentaje5 = "0";
		if ($con_6>0)
			$porcentaje6 = round($con_6*100/$con_gen,0) ."";
		else
			$porcentaje6 = "0";

	$cont_gen1 = $cont_gen1 + $con_1;
	$cont_por1 = $cont_por1 + $porcentaje1;
	$cont_gen2 = $cont_gen2 + $con_2;
	$cont_por2 = $cont_por2 + $porcentaje2;
	$cont_gen3 = $cont_gen3 + $con_3;
	$cont_por3 = $cont_por3 + $porcentaje3;
	$cont_gen4 = $cont_gen4 + $con_4;
	$cont_por4 = $cont_por4 + $porcentaje4;
	$cont_gen5 = $cont_gen5 + $con_5;
	$cont_por5 = $cont_por5 + $porcentaje5;
	$cont_gen6 = $cont_gen6 + $con_6;
	$cont_por6 = $cont_por6 + $porcentaje6;
	




?>
<tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $Curso_pal ; ?></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut;  ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_1; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje1."%"; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_2; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje2."%"; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_3; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje3."%"; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_4; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje4."%"; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_5; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje5."%"; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_6; ?></font></div></td>
    <td width="25"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje6."%"; ?></font></div></td>
 </tr>
 
<?
	$rut = 0;
	} // fin for i ?> 
 
  <? // } // FIN FOR E ?>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>SUMA DE TOTALES:</strong></font></div></td>
    <td width="65"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $sum_total_alumno; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cont_gen1;?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($con_gen>0)echo round($cont_por1/$i,0)."%"; else echo "0%" ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cont_gen2;?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($con_gen>0)echo round($cont_por2/$i,0)."%"; else echo "0%" ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cont_gen3;?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($con_gen>0)echo round($cont_por3/$i,0)."%"; else echo "0%" ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cont_gen4;?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($con_gen>0)echo round($cont_por4/$i,0)."%"; else echo "0%" ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cont_gen5;?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($con_gen>0)echo round($cont_por5/$i,0)."%"; else echo "0%" ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cont_gen6;?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($con_gen>0)echo round($cont_por6/$i,0)."%"; else echo "0%" ?></font></div></td>
  </tr>
</table>
<hr width="100%" color=#003b85>
    </tr>
</table>  
 <? if  (($cantidad_cursos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

?>
</center>

<?
}
?>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form  action="" method="post">
<?php 
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
$institucion	=$_INSTIT;
$ano			=$_ANO;
	
	
//------------------------------------------------
$sql_docente = "select rut_emp, nombre_emp, ape_pat, ape_mat from empleado where rut_emp in (SELECT DISTINCT (e.rut_emp) FROM empleado as e INNER JOIN dicta as d ON e.rut_emp=d.rut_emp INNER JOIN trabaja as t ON e.rut_emp=t.rut_emp WHERE rdb=".$institucion.") ORDER BY ape_pat, ape_mat, nombre_emp ";
$result_docente = @pg_exec($conn,$sql_docente);

?>
<center>
    <table width="800" height="60" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
    <td width="800" height="76" valign="top">
	<table width="800" height="60" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
    <td height="20" colspan="2" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27" colspan="2">
	<table width="800" border="0" cellspacing="0" cellpadding="0">
                  <tr>
    <td width="69" height="20" class="textosmediano">Docente</td>
    <td width="272" height="20">
	  <div align="left">	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_docente" class="ddlb_9_x" onChange="enviapag(this.form);">
          <option value=0 selected>(Seleccione Docente)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($result_docente) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_docente,$i); 
		  if(trim($fila['rut_emp'])==trim($cmb_docente)){
			echo  "<option  value=".$fila['rut_emp']." selected >".$fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_emp']."</option>";
			}else{
			echo  "<option value=".$fila['rut_emp']." >".$fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_emp']."</option>";
			}
		  ?>
          <? } ?>
        </select>
</font>	  </div>
	</td>
                    <td width="61" height="20" class="textosmediano">Subsector</td>
                    <td width="219" height="20"><font size="1" face="arial, geneva, helvetica">
                      <select name="cmb_subsector" class="ddlb_9_x">
                        <option value=0 selected>(Seleccione Subsector)</option>
                        <?
						//------------------------------------------------
						$sql_subsector = "SELECT DISTINCT s.nombre,s.cod_subsector FROM subsector AS s INNER JOIN ramo AS r ON r.cod_subsector=s.cod_subsector INNER JOIN dicta AS d ON d.id_ramo=r.id_ramo WHERE d.rut_emp='".$cmb_docente."' ";
						$result_subsector = @pg_exec($conn,$sql_subsector);
						//------------------------------------------------

						  for($k=0 ; $k < @pg_numrows($result_subsector) ; $k++)
						  {
						  	$fila2 = @pg_fetch_array($result_subsector,$k);
							if ($fila2['cod_subsector'] == $cmb_subsector){
								echo "<option  value=".$fila2['cod_subsector']." selected >".$fila2['nombre']."</option>";
							}else{
								echo "<option  value=".$fila2['cod_subsector'].">".$fila2['nombre']."</option>";
							}				
							
						  } ?>
                      </select>
                    </font></td>
    <td width="80" height="20"><div align="right">
	  <input name="cb_ok" type="button" class="botonXX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" onClick="MM_goToURL('parent','informe_estadistico.php?docente='+cmb_docente.options[cmb_docente.selectedIndex].value+'&subsector='+cmb_subsector.options[cmb_subsector.selectedIndex].value+'&periodo='+cmb_periodo.options[cmb_periodo.selectedIndex].value);return document.MM_returnValue" value="Buscar"> 
    </div></td>
  </tr>
</table>

	</td>
  </tr>
  <tr>
    <td width="78" height="20" class="textosmediano">Periodo</td>
    <td width="722" height="20" valign="top"><select name="cmb_periodo" class="ddlb_9_x">
      <option value=0 selected>(Seleccione Periodo)</option>
      <?
	  //------------------------------------------------
		$sql_periodo = "select * from periodo where id_ano = ".$ano;
		$result_periodo = @pg_exec($conn,$sql_periodo);
		//------------------------------------------------

		  for($j=0 ; $j < @pg_numrows($result_periodo) ; $j++)
		  {
			  $fila3 = @pg_fetch_array($result_periodo,$j);
			  if ($fila3["id_periodo"] == $cmb_periodo){ 
			     echo  "<option  value=".$fila3["id_periodo"]." selected>".$fila3['nombre_periodo']."</option>";
		      }else{
			     echo  "<option  value=".$fila3["id_periodo"].">".$fila3['nombre_periodo']."</option>";
			  }	 
		  
		  
		  } ?>
    </select></td>
  </tr>
</table>	</td>
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