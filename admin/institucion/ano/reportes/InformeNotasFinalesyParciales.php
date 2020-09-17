<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?
require('../../../../util/header.inc'); 
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$alumno 		= $c_alumno;
	$periodo		= $cmb_periodos;
	$_POSP = 4;
	$_bot = 8;
	
	
	if ($dia == ""){
	   ## si el campo esta vacío poner la fecha actual
	   $dia  = strftime("%d",time());
	   $mes  = strftime("%m",time());
	   $mes = envia_mes($mes);	   
	   $ano2  = strftime("%Y",time()); 
	}
	
	
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.insignia, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN comuna ON (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) AND (institucion.region = comuna.cod_reg)) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";

	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];
	$region = ucwords(strtolower($fila_institu['nom_reg']));
	$provincia = ucwords(strtolower($fila_institu['nom_pro']));
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	//--------------------------------------------------------------------------
	// DATOS CURSO //
	//--------------------------------------------------------------------------	
	$sql_curso = "SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per ";
	$sql_curso = $sql_curso . "FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso."));";
	$result_curso = @pg_Exec($conn, $sql_curso);
	$fila_curso = @pg_fetch_array($result_curso ,0);
	$decreto_eval = $fila_curso['nombre_decreto_eval'];
	$planes = $fila_curso['nombre_decreto'];
	$truncado_per = $fila_curso['truncado_per'];
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
	
    <?
  	
	// Periodo
	//------------------------
	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo =@pg_Exec($conn,$sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal  = $fila_periodo['nombre_periodo'];	
	
	
	
	
	
	$sql_subsector = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.nota_exim, ramo.cod_subsector ";
	$sql_subsector = $sql_subsector . "FROM (curso INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_subsector = $sql_subsector . "WHERE (((curso.id_curso)=".$curso.")) order by ramo.id_orden; ";
	$result_subsector = @pg_Exec($conn, $sql_subsector);
			
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	/// ----------------------------------------------------------------------------
	///// DATOS DE LOS ALUMNOS   
	/// ----------------------------------------------------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) AND matricula.bool_ar = 0";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-----------------------------------------
	
  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeNotasFinalesyParciales.php?institucion=$institucion';
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>

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
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								 
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($curso > 0){ ?>



<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printInformeNotasFinalesyParciales.php?c_curso=<?=$curso ?>&c_alumno=<?=$c_alumno ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano2=<?=$ano2 ?>&periodo=<?=$periodo ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div>
      </div>
    </td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">

      <table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top" >
          <td width="125" align="center"> 	  

	<?
		$result = @pg_Exec($conn,"select insignia, rdb from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia
	 if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?></td>
        </tr>
      </table>

    </td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion)); echo "Nombre"?></font></td>
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
    	<td class="tableindex"><div align="center">INFORME DE NOTAS PARCIALES Y PROMEDIO POR CURSO</div></td>
	</tr>
  <tr>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluación Nº : ".$decreto_eval?></strong></font></div></td>
  </tr>
  <tr>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas Nº : ".$planes?></strong></font></div></td>
  </tr>
  <tr>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Correspondiente al Año Lectivo : ".$nro_ano?></strong></font></div></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="91"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CURSO</strong></font></div></td>
    <td width="8"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td width="543"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $Curso_pal?></font></div></td>
  </tr>
 
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROFESOR JEFE</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $profesor?></font></div></td>
  </tr>
</table>
<br>

<table width="1080" border="1" cellspacing="0" cellpadding="1">
  <tr>
    <td width="120">&nbsp;</td>
	<?
	/// consulta para determinar los subsectores ////
	// Subsectores
	//-----------------------------------------
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.sub_obli, ramo.cod_subsector ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) and ramo.id_ramo in (select id_ramo from notas$nro_ano where id_periodo = '$periodo') and ramo.cod_subsector < 50000 ORDER BY ramo.id_orden; ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$num_subsectores2 = @pg_numrows($result_sub);
	$num_subsectores = 5;
	
	
	for($cont=0 ; $cont < $num_subsectores2; $cont++){
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$cod_subsector = $fila_sub['cod_subsector'];
		
		$sql = "SELECT nombre_emp, ape_pat FROM empleado a INNER JOIN dicta b ON a.rut_emp=b.rut_emp WHERE id_ramo=".$fila_sub['id_ramo']."";
		$result_empleado = @pg_exec($conn,$sql);
		$fila_emp = @pg_fetch_array($result_empleado,0);
		$Nombre_emp = substr($fila_emp['nombre_emp'],0,1);
		$Apellido_emp = $fila_emp['ape_pat'];
		$Docente = $Apellido_emp.".".$Nombre_emp;
		
		?>
			<td width="1">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px"><?=$cod_subsector ?>&nbsp;(<?=$Docente?>)</font></td>
			<td width="1">&nbsp;</td>
			<?
			if ($periodo=="638"){  // nueva columna ?>
			     <td width="1">&nbsp;</td>
			<?
			}
		
		
		
	}	
	 ?> 	
		<td width="1">&nbsp;</td>
        <td width="1"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px">&nbsp;&nbsp;&nbsp; </font></td>
  </tr>
  
 
  
  <tr>
    <td>&nbsp;</td>
	      
				<?
				for($cont=0 ; $cont < $num_subsectores2; $cont++)
				{
					$fila_sub = @pg_fetch_array($result_sub,$cont);	
					$subsector_curso = $fila_sub['nombre'];
					$id_ramo = $fila_sub['id_ramo'];
					$cod_subsector = $fila_sub['cod_subsector'];
					
							
										
						?>
						<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:6px"><?=$subsector_curso ?></font></td>
						<?
						if ($periodo=="638"){ ?>
						      <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">P1</font></td>						
					  <? } ?>
					    <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">PM</font></td>
					  <?
					
				}		
				
				
		     ?>	
    
        <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? if ($periodo=="638"){ echo "Prom. 1º"; }else{ ?>&nbsp;<? } ?></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">Pom. Per.</font></td>
  </tr>
  <?
  /// AQUI LISTO LOS ALUKMNOS DEL CURSO
  $numero_alumnos = @pg_numrows($result_alu);
  	 
  for($i=0 ; $i < $numero_alumnos; $i++){
	  $fila_alu = @pg_fetch_array($result_alu,$i);
	  $nombre_alu = ucwords(strtolower(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu'])));
	  $rut_alumno = $fila_alu['rut_alumno'];
	  $nombre_alu = substr($nombre_alu,0,26);
	  ?>  
  
      <tr>
        <td ><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><?=$nombre_alu ?> </font></td>
		    <?
			
			for($cont=0 ; $cont < $num_subsectores2; $cont++){
			   $fila_sub = @pg_fetch_array($result_sub,$cont);	
			   $subsector_curso = $fila_sub['nombre'];
			   $id_ramo = $fila_sub['id_ramo'];
			   $cod_subsector = $fila_sub['cod_subsector'];
			   
			   
			  
			   		?>	
				   <td>
					 <table  border="0" cellspacing="0" cellpadding="0">
					   <tr>
					   <?
						/// aqui tomo las notas del alumno en este subsector
						$sql_nota = "select nota1,nota2,nota3,nota4,nota5,nota6,nota7,nota8,nota9,nota10,nota11,nota12,nota13,nota14,nota15,nota16,nota17,nota18,nota19,nota20,promedio from notas$nro_ano where rut_alumno = '$rut_alumno' and id_ramo = '$id_ramo' and id_periodo = '$periodo'";
						
						$res_nota = pg_Exec($conn,$sql_nota);
						$fil_nota = pg_fetch_array($res_nota);
						$promedio = $fil_nota['promedio'];
						for ($j = 1; $j < 22; $j++){
							$nota = $fil_nota['nota'.$j];					
							if ($nota > 0){					
								?>		   
								<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><?=$nota ?>.</font></td>
								<?
								$nota=0;
							}
							
						}			
						
						?>				
					   </tr>
					</table>				   </td>
				
				   <?
			       if ($periodo=="638"){ 
				        $sql_p1 = "select promedio from notas$nro_ano where rut_alumno = '$rut_alumno' and id_ramo = '$id_ramo' and id_periodo = '637'";
						$res_p1 = pg_Exec($conn,$sql_p1);
						$fil_p1 = pg_fetch_array($res_p1);
						$prom_1 = $fil_p1['promedio'];
						
						if ($prom_1 > 0){
						    $acomulo_prom_1 = $acomulo_prom_1 + $prom_1;
							$contador_prom_1++;						
						}										   
				         ?>
				         <td valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><?=$prom_1 ?></font></td>						
		        <? } ?>
				   
				   <td>
					  <font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">	   
							 <? if ($promedio > 0){
							 	    echo $promedio;
									
									$acomulo_promedio = $acomulo_promedio + $promedio;
									$contador_promedio++;
									
							    }else{
								    ?> &nbsp; <?
							    } ?>
					  </font>				   </td>
			       <?
			    
		  }
		  
		  //// calculo el promedio a mostrar
		  $promedio_periodo  = @round($acomulo_promedio / $contador_promedio);
		  $promedio_periodo1 = @round($acomulo_prom_1 / $contador_prom_1); 
		  
		?>	
		
           <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? if ($periodo=="638"){ echo $promedio_periodo1; }else{ ?>.<? } ?></font></td>	   
           <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><?=$promedio_periodo ?></font></td>
     </tr>
      
	  
	 
     <?
	 $acomulo_promedio = 0;
	 $contador_promedio = 0;
	 $acomulo_prom_1 = 0;
	 $contador_prom_1 = 0;

	 
	 ///// para controlar el salto de página  /////
	 if ($i==45){
	       echo "</table>";
		   
		   //// salto de página   ///
		   echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
		   
		   
		   
		   /// abro nuevamente cabecera de listado  ////
		   echo "<table width=1080 border=1 cellspacing=0 cellpadding=1>
                 <tr>
                 <td width=120>&nbsp;</td>";
	             
	             /// consulta para determinar los subsectores ////
	             // Subsectores
	             //-----------------------------------------
				 $sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.sub_obli, ramo.cod_subsector ";
				 $sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
				 $sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) and ramo.id_ramo in (select id_ramo from notas$nro_ano where id_periodo = '$periodo') ORDER BY ramo.id_orden; ";
				 $result_sub =@pg_Exec($conn,$sql_sub );
				 $num_subsectores2 = @pg_numrows($result_sub);
				 $num_subsectores = 5;
	
	
	             for($cont=0 ; $cont < $num_subsectores2; $cont++){
		             $fila_sub = @pg_fetch_array($result_sub,$cont);	
					 $subsector_curso = $fila_sub['nombre'];
					 $id_ramo = $fila_sub['id_ramo'];
					 $cod_subsector = $fila_sub['cod_subsector'];
					
					
		
						 echo "<td width=1 >&nbsp;&nbsp;<font face=Verdana, Arial, Helvetica, sans-serif style=font-size:9px>$cod_subsector</font></td>";
						 
						 if ($periodo=="638"){ 
						      echo "<td><font face='Verdana, Arial, Helvetica, sans-serif' style='font-size:8px'>&nbsp;</font></td>";						
					    }
						 
						 echo "<td width=1>&nbsp;</td>";
						 
		             
		         }       
		          echo "<td width=1>&nbsp;</td>";					
				  echo "<td width=1><font face=Verdana, Arial, Helvetica, sans-serif style=font-size:7px>&nbsp;&nbsp;&nbsp;</font></td>
		                </tr>  
                        <tr>
                        <td>&nbsp;</td>";
	      
				 for($cont=0 ; $cont < $num_subsectores2; $cont++){
					$fila_sub = @pg_fetch_array($result_sub,$cont);	
					$subsector_curso = $fila_sub['nombre'];
					$id_ramo = $fila_sub['id_ramo'];
					$cod_subsector = $fila_sub['cod_subsector'];					
					
						echo "<td><font face=Verdana, Arial, Helvetica, sans-serif style=font-size:6px>$subsector_curso</font></td>";	
						
						if ($periodo=="638"){ 
					         echo "<td><font face='Verdana, Arial, Helvetica, sans-serif' style='font-size:8px'>P1</font></td>";						
				        }
											
						echo "<td><font face=Verdana, Arial, Helvetica, sans-serif style=font-size:8px>PM</font></td>";
						
				 } 
		         echo "<td><font face=Verdana, Arial, Helvetica, sans-serif style=font-size:8px>";
				 
				 if ($periodo=="638"){ 
				      echo "Prom. 1º";
				 }else{ 
				      echo ".";
				 }
				 
				 echo "</font></td>";	  
				 				
				 echo "<td><font face=Verdana, Arial, Helvetica, sans-serif style=font-size:8px>Prom. Per.</font></td>
		         </tr>";
			    	
		   
	 } 
	 
  }
 ?>
  
  	 <tr>
        <td><span style="font-weight: bold"><font face="Arial, Helvetica, sans-serif" style="font-size:8px">PROMEDIO</font></span></td>
		
	<? 
	$sql_ramo = "SELECT ramo.id_ramo FROM ramo  WHERE (((ramo.id_curso)=".$curso.")) AND ramo.id_ramo in (SELECT id_ramo FROM ";
		$sql_ramo = $sql_ramo." notas$nro_ano WHERE id_periodo = '$periodo') AND ramo.cod_subsector < 50000 ORDER BY ramo.id_orden ";
		$result_ramo = @pg_exec($conn,$sql_ramo);

	for($ii=0;$ii<@pg_numrows($result_ramo);$ii++){
		$fila_ramo = @pg_fetch_array($result_ramo,$ii);

		?>
		<td>
		<table  border="0" cellspacing="0" cellpadding="0">
			<tr>	
			<?
		 
		 for($xx=1;$xx<21;$xx++){
			 $sql_nota = "SELECT nota$xx as nota FROM notas$nro_ano WHERE id_ramo = ".$fila_ramo['id_ramo']." AND id_periodo = '$periodo'";
			 $result_nota = @pg_exec($conn,$sql_nota);
			 $conta=0;
			 $Promedio_Nota=0;
			 $Prom_Nota =0;
			 for($zz=0;$zz<@pg_numrows($result_nota);$zz++){
				$fila_nota = @pg_fetch_array($result_nota,$zz);
				if($fila_nota['nota'] > 0){
					$Promedio_Nota = $Promedio_Nota + $fila_nota['nota'];
					$conta++;
				}else{
					next;
				}
			}
			if($conta > 0){
				$Prom_Nota = round($Promedio_Nota / $conta);
			}
			
			if($Prom_Nota!=0){
				echo "<td ><b><font face=Verdana, Arial, Helvetica, sans-serif style=font-size:8px>".$Prom_Nota." .</font></b></td>";		
			}else{
				
			}
			
		}
?>
			</tr>
			</table>
	
        </td>
<? 
		if ($periodo=="638"){ 
	         echo "<td><font face='Verdana, Arial, Helvetica, sans-serif' style='font-size:8px'>P1</font></td>";						
	    }
       
	// SE OBTINE PROMEDIO GENERAL DE LA ASIGNATURA
	/*for($aa=0;$aa<@pg_numrows($result_ramo);$aa++){
		$fila_ramo = @pg_fetch_array($result_ramo,$aa);*/
		$sql_prom = "SELECT promedio FROM notas$nro_ano WHERE id_ramo = ".$fila_ramo['id_ramo']." AND id_periodo = '$periodo'";
		$result_prom = @pg_exec($conn,$sql_prom);
		
		$PGN = 0;
		$contPGN = 0;
		$PM = 0;
		for($cc=0;$cc<@pg_numrows($result_prom);$cc++){
			$fila_promedio = @pg_fetch_array($result_prom,$cc);
			if($fila_promedio['promedio'] > 0){
				$PGN = $PGN + $fila_promedio['promedio'];
				$contPGN++;
			}else{
				next;
			}
		}
		$PM = round($PGN / $contPGN);
		$PMG = $PMG + $PM;
	//}
		?>
        <td><font face="Arial, Helvetica, sans-serif" style="font-size:8px"><?=$PM?></font></td>
<? 

 } // FIN FOR RAMO
		$Final = round($PMG / @pg_numrows($result_ramo));
?>
        <td align="center">.</td>
        <td align="center"><font face="Arial, Helvetica, sans-serif" style="font-size:8px"><?=$Final;?></font></td>
      </tr>
</table>

<br>
<? if($_PERFIL==0){ 
	/******** SE EXTRAE SUBSECTORES *******************/
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.sub_obli, ramo.cod_subsector ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) and ramo.id_ramo in (select id_ramo from notas$nro_ano where id_periodo = '$periodo') and ramo.cod_subsector < 50000 ORDER BY ramo.id_orden; ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$num_subsectores2 = @pg_numrows($result_sub);
?>
<table width="%" border="1" cellspacing="0" cellpadding="0" align="left">
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px">Subsector</font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px">1.0 --3.9 </font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px">4.0 -- 5.9 </font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px">6.0 -- 7.0 </font></td>
  </tr>

<? 	
	
	for($i=0;$i<@pg_numrows($result_sub);$i++){
		$fila_sub = @pg_fetch_array($result_sub,$i);
	/***************** SE EXTRAEN PROMEDIO ***************/ 
 	$sql_inf = "SELECT count(*) as promedio FROM notas$nro_ano WHERE id_ramo = ".$fila_sub['id_ramo']." AND id_periodo = '$periodo' AND promedio between 0 and 39";
	$result_inf = @pg_exec($conn,$sql_inf);
	$prom_inf = pg_result($result_inf,0);
	

	$sql_media = "SELECT count(*) FROM notas$nro_ano WHERE id_ramo = ".$fila_sub['id_ramo']." AND id_periodo = '$periodo' AND promedio between 40	and 59";
	$result_media = @pg_exec($conn,$sql_media);
	$prom_media = @pg_result($result_media,0);

	$sql_mayor = "SELECT count(*) FROM notas$nro_ano WHERE id_ramo = ".$fila_sub['id_ramo']." AND id_periodo = '$periodo' AND promedio between 60 and 70";
	$result_mayor = @pg_exec($conn,$sql_mayor);
	$prom_mayor = @pg_result($result_mayor,0);
	
	
	
	 
	
	 ?>

  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px"><?=$fila_sub['nombre'];?></font></td>
    <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px"><?=$prom_inf;?></font></td>
    <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px"><?=$prom_media;?></font></td>
    <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px"><?=$prom_mayor;?></font></td>
  </tr>
  <? } ?>
</table>
<? } ?>
</center>
 
<!-- FIN CUERPO DE LA PAGINA -->


<? } ?>



<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method "post" action="">
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

<br>
<br>
<br><br>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="textosimple">Curso</td>
    <td width="263">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x">
          <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
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
</font>	  </div></td>
    <td width="61" class="textosimple">Periodo</td>
    <td width="219">
	
	<select name="cmb_periodos">
			<option value=0 selected>(Seleccione Periodo)</option>
       <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); 
		  
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
    </select>
	
	</td>
    <td width="80"><div align="right">
      <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Buscar">
    </div></td>
  </tr>
  <!--
   <tr>
     <td colspan="3">
	 
	 
	    <table width="320" border="0" cellspacing="2" cellpadding="0" align="center">
          <tr>
            <td class="textosimple">Fecha del Informe</td> 
            <td><div align="center">
              <input name="dia" type="text" id="dia" size="2" value="<?=$dia ?>">
            </div></td>		
           <td><div align="center">
           <input name="mes" type="text" id="mes" size="11" value="<?=$mes ?>">
           </div></td>
           <td><div align="center">
           <input name="ano2" type="text" id="ano2" size="4" value="<?=$ano2 ?>">
           </div></td>
          </tr>
         </table>
	 
	 
	 </td>   
   </tr>
   -->
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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
<? pg_close($conn);?>
</body>
</html>
