<? 
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;
	$curso          =$_CURSO;
	$_POSP          =5;
	$_FRMMODO="mostrar";
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=2)){$whe_perfil_curso=" and curso.id_curso=$curso";}	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>


<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<SCRIPT language="JavaScript">
		/*	function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'motor_informe_rendimiento.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			
			*/
			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
			
			
			
			function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&p=12&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=11&pa=11&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
									
</script>
<?
//require('../../../../../util/header.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	/*if ($curso = ""){
	$curso = $_get["curso"];}else{*/
	//$curso		    =$c_curso; //}
	$periodo		=$c_periodos;
	
		//exit;
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'])) . " " . $fila_institu['nro'] . " - " . strtoupper($fila_institu['nom_com']);
	$telefono = $fila_institu['telefono'];
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	//----------------------------------------------------------------------------
	// DATOS PERIODO
	//----------------------------------------------------------------------------

	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'] . "  DE " . $nro_ano;
	
	//----------------------------------------------------------------------------
	// DATOS CURSO
	//----------------------------------------------------------------------------	
	if ($curso == 0)
	{
		$sql_curso = "select * from curso where id_ano= ".$ano ." order by ensenanza, grado_curso, letra_curso";
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
	else
	{
		$sql_curso = "select * from curso where id_curso = ".$curso;
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
	
	
?>

</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include ("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- INICIO CODIGO ANTIGUO -->
								  
								  
								  
								  
								  
	<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<br>
 <table border=0 cellspacing=1 cellpadding=1>
          <tr valign="top"> 
            <td> <font face="arial, geneva, helvetica" size=2> <strong>AÑO ESCOLAR</strong></font></td>
            <td> <font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
            <td> <?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." $whe_perfil_ano ORDER BY NRO_ANO";
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
			 <form name="form"   action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
					
						<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
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
			 </form>
				<? }	?>		
              </td>
          </tr>
          <tr valign="top"> 
            <td align=left> <font face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> </font> </td>
            <td> <font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
		  
		     <td valign="top"> 
          <form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
                }
		     } ?>
          </select> </form>
		  </td>  
          </tr>
        </table>
		<br><br>
		
		
		
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="capa0"> 
		
        <div align="right">
         <? if ($curso){?> 
			 <!--input name="button3" type="button" class="botonXX" onClick="parent.location='../curso.php3'"  value="VOLVER"-->
			 <? if ($periodo!=0){ ?>
			 	<input name="button3" type="button" class="botonXX" onClick="window.location='main_informe_rendimiento.php'"  value="VOLVER">
          		<input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
			 <? } ?>
		 <? }?>
        </div>
    </div></td>
  </tr>
</table>							  
								  
<?
	$cantidad_cursos = @pg_numrows($result_curso);
	
		$fila_curso = @pg_fetch_array($result_curso,0);
		$curso = $fila_curso['id_curso'];
		$Curso_pal = CursoPalabra($curso, 0, $conn);
		//----------------------------------------------------
		// DATOS PROFESOR JEFE
		//----------------------------------------------------
		$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql_profe = $sql_profe . "FROM (curso INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql_profe = $sql_profe . "WHERE (((curso.id_curso)=".$curso.")); ";
		$result_profe = @pg_Exec($conn, $sql_profe);
		$fila_profe = @pg_fetch_array($result_profe ,0);
		$profesor = ucwords(strtoupper($fila_profe['nombre_emp'] . " " . $fila_profe['ape_pat'] . " " . $fila_profe['ape_mat']));

?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $nombre_institu;?></strong></font></div></td>
    </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $direccion;?></strong></font></div></td>
    </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $telefono;?></strong></font></div></td>
    </tr>
  <tr>
    <td  class="tableindex"><div align="center">INFORME RENDIMIENTO ESCOLAR POR CURSO</div></td>
    </tr>
  <tr>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $periodo_pal;?></strong></font></div></td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<? if ($periodo==0){
	?>
  <tr>
    <td width="63">&nbsp;</td>
    <td width="8">&nbsp;</td>
    <td width="571">&nbsp;</td>
  </tr>
  <!--<br><br><br>-->

    <table width="619" border="0">
      <tr>
        <td class = "tablatit2-1"><div align="center">Seleccione Periodo .</div></td>
      </tr>
    </table>
    <? }
	else
	{ ?>
  
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Profesor </strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $profesor;?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $Curso_pal;?></font></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
	
	
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Asignatura</strong></font></div></td>
    <td width="171"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Profesor</strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><1 - 3.9></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><4 - 4.9></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><5 - 5.9></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><6 - 7.0></strong></font></div></td>
    </tr>
	<?
	//----------------------------------------------------------------
	// SUBSECTORES
	//----------------------------------------------------------------
	$sql_sub = "SELECT subsector.cod_subsector, subsector.nombre, ramo.id_ramo, ramo.modo_eval ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) AND ramo.modo_eval<>2 ORDER BY subsector.cod_subsector; ";
	$result_sub = @pg_Exec($conn, $sql_sub);
    $cont_gen1 = 0; $cont_gen2 = 0;
    $cont_gen3 = 0; $cont_gen4 = 0;
	for($e=0 ; $e < @pg_numrows($result_sub) ; $e++)
	{
		// DATOS SUBSECTOR //
		$fila_sub = @pg_fetch_array($result_sub,$e);
		$ramo = $fila_sub['id_ramo'];
		$subsector_num = $fila_sub['cod_subsector'];
		$subsector_pal = ucwords(strtolower($fila_sub['nombre']));
		$modo_eval = $fila_sub['modo_eval'];
		
		// DATOS PROFESOR SUBSECTOR
		$sql_dicta = "SELECT dicta.id_ramo, empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql_dicta = $sql_dicta . "FROM dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp ";
		$sql_dicta = $sql_dicta . "WHERE (((dicta.id_ramo)=".$ramo.")); ";
		$result_dicta = @pg_Exec($conn, $sql_dicta);
		$fila_dicta = @pg_fetch_array($result_dicta,0);
		$profe_dicta = ucwords(strtolower($fila_dicta['nombre_emp'] . " " . $fila_dicta['ape_pat'] . " " . $fila_dicta['ape_mat']));
		
		$sql_tiene = "SELECT  rut_alumno FROM tiene$nro_ano WHERE id_ramo=" . $ramo;
		$result_tiene = @pg_exec($conn,$sql_tiene);
		$Cuenta = 0;
		$rut = 0;
		for($a=0;$a<@pg_numrows($result_tiene);$a++){
			$fila_tiene= @pg_fetch_array($result_tiene,$a);
			$rut_alumno[$a] = trim($fila_tiene['rut_alumno']);
			$rut++;
		}
		
		for($u=0;$u<$rut;$u++){
		// NOTAS //
			$sql_notas = "SELECT notas$nro_ano.promedio, notas$nro_ano.id_ramo, notas$nro_ano.id_periodo ";
			$sql_notas = $sql_notas . "FROM notas$nro_ano  ";
			$sql_notas = $sql_notas . "WHERE (((notas$nro_ano.id_ramo)=".$ramo.") AND ((notas$nro_ano.id_periodo)=".$periodo.")) AND (notas$nro_ano.rut_alumno='" . $rut_alumno[$u]."')";
			$result_notas = @pg_Exec($conn, $sql_notas);
			$fila_notas = @pg_fetch_array($result_notas,0);
			$promedio[$u] = $fila_notas['promedio'];
			$Cuenta ++;
		}
		$con_gen  = 0;
		$con_1 = 0;		$con_2 = 0;
		$con_3 = 0;		$con_4 = 0;
		$porcentaje1=0; $porcentaje2=0;						
		$porcentaje3=0; $porcentaje4=0;								
		
		for($o=0 ; $o < $Cuenta ; $o++)
		{
			
				if ($promedio[$o]>0)
				{
					$con_gen = $con_gen +1;
					if ($promedio[$o] > 0 and  $promedio[$o] < 40)
						$con_1 = $con_1  + 1;
					if ($promedio[$o] > 39 and  $promedio[$o] < 50)
						$con_2 = $con_2  + 1;
					if ($promedio[$o] > 49 and  $promedio[$o] < 60)
						$con_3 = $con_3  + 1;										
					if ($promedio[$o] > 59 and  $promedio[$o] < 71)
						$con_4 = $con_4  + 1;
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
	
	?>
  <tr>
    <td width="28"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $subsector_num;?></font></div></td>
    <td width="208"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $subsector_pal;?></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $profe_dicta;?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_1; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje1."%"; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_2; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje2."%"; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_3; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje3."%"; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_4; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje4."%"; ?></font></div></td>
  </tr>
  <? } // FIN FOR E ?>
</table>
<?  } //fin f periodo?>
<br>

<hr width="100%" color=#003b85>
  </tr>
  
</table>  
 <? if  (($cantidad_cursos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

?>



<!-- AQUÍ INGRESO EL CONTENIDO DE LA PÁGINA MotorBuscadorCalve.php, QUE AHORA VA SIN FRAME -->
					           
							   
							   
							   <br>
								<br>
<? $cursos = $_GET["cursos"];						    ?>

<form method "post" action="">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
<center>
<table width="95%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%">
	<table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="90%" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="10%">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="25%" class="textosimple"> 
						<input name="cmb_curso" type="hidden" value="<? echo $cursos;?>">
                       Período
                        
                      </td>
                    <td width="50%"><select name="cmb_periodos" class="ddlb_9_x">
                        <option value=0 selected>(Seleccione Periodo)</option>
                        <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); 
		  if ($fila['id_periodo']==$cmb_periodos)
   			echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  else
   			echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  ?>
                        <? } ?>
                      </select></td>
                    <!--<td width="80"><div align="left"> 
                        <input name="cb_ok" type="button" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" onClick="window.location='main_informe_rendimiento.php?c_curso='+cmb_curso.value+'&c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value;';" value="Buscar">-->
                      </div>
					  
					  <td width="25%"><div align="left"> 
                        <input name="cb_ok" type="button" class="botonXX" onClick="window.location='main_informe_rendimiento.php?c_curso='+cmb_curso.value+'&c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value;'';" value="Buscar">
                      </div>
					  </td>
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



								  
								  
								  
								  <!-- FI NCODIGO ANTIGUO --></td>
                                </tr>
                              </table>
							  </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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
<? pg_close($conn);?>