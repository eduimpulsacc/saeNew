<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	if ($c_curso==0){
	  ##  no hace nada
	  
	   
	}else{
	    
		$fecha1 		= $anoN."-04-30"; 

	    //------------------------------------
	    // Encabezado Izquierdo
	    //------------------------------------
    $sql = "SELECT curso.cod_decreto, plan_estudio.nombre_decreto, empleado.ape_pat, empleado.ape_mat,          empleado.nombre_emp,  institucion.nombre_instit ";
	$sql = $sql . "FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto, institucion INNER JOIN (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) ON institucion.rdb = trabaja.rdb ";
	$sql = $sql . "WHERE (((curso.id_curso)=".$curso.") AND ((trabaja.cargo)=1) AND ((institucion.rdb)=".$institucion.")); ";
//	echo $sql;
	$resultado_query2= pg_exec($conn,$sql);
	$total_filas2= pg_numrows($resultado_query2);	
//	$Decreto =  "---";
	$NombreDirector = "---";
//	$NombreColegio = "---";

   // Acá la consulta dió CERO 0
   
	if ($total_filas2>0){
	 	$row_temp=pg_fetch_array($resultado_query2);
	//	imprime_array($row_temp);
		//$Decreto =  trim($row_temp[nombre_decreto]);
		//$NombreDirector = trim($row_temp[ape_pat]) . " " . trim($row_temp[ape_mat]) . " " . trim($row_temp[nombre_emp]);
//		$NombreColegio = trim($row_temp[nombre_instit]);
	}   
	
	//------------------------------------
	// Encabezado Derecho
	//------------------------------------
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, institucion.telefono, institucion.calle, institucion.nro, institucion.villa, institucion.nombre_instit, region.nom_reg, provincia.nom_pro, comuna.nom_com, ano_escolar.nro_ano, ano_escolar.id_ano " ;
	$sql = $sql . "FROM ano_escolar, ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (region.cod_reg = provincia.cod_reg)) INNER JOIN comuna ON (institucion.comuna = comuna.cor_com) AND (provincia.cor_pro = comuna.cor_pro) AND (provincia.cod_reg = comuna.cod_reg) ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.")); ";

	$resultado_query1= pg_exec($conn,$sql);
	$total_filas1= pg_numrows($resultado_query1);	
	
	for ($jj=0; $jj < $total_filas1; $jj++)
	{
		$Rbd = trim(pg_result($resultado_query1, $jj, 0)) . " - " . trim(pg_result($resultado_query1, $jj, 1));
		//$Region = trim(pg_result($resultado_query1, $jj, 2));
		//$Ciudad = trim(pg_result($resultado_query1, $jj, 3));
		$Comuna = trim(pg_result($resultado_query1, $jj, 9));
		//$AnoEscolar =  trim(pg_result($resultado_query1, $jj, 5));
		$Telefono = trim(pg_result($resultado_query1,$jj, 2));
		$Calle = trim(pg_result($resultado_query1,$jj, 3));
		$Numero = trim(pg_result($resultado_query1,$jj, 4));
		$Villa = trim(pg_result($resultado_query1,$jj, 5));
		$NombreColegio = trim(pg_result($resultado_query1,$jj, 6));
	}
	
   }
		
	//------------------------------------
	//$sql = "SELECT distinct matricula.num_mat, curso.grado_curso, curso.letra_curso, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.rut_alumno, alumno.dig_rut, alumno.fecha_nac, alumno.calle, alumno.nro, alumno.depto, alumno.block, alumno.villa, matricula.fecha, apoderado.ape_pat, apoderado.ape_mat, apoderado.nombre_apo, apoderado.calle, apoderado.nro, apoderado.depto, apoderado.block, apoderado.villa, matricula.fecha_retiro ";
	//$sql = $sql . "FROM (((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN tiene2 ON alumno.rut_alumno = tiene2.rut_alumno) INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
	//$sql = $sql . "WHERE (((matricula.rdb)=".$institucion.") AND ((curso.id_curso)=".$curso.") AND ((tiene2.responsable)=1) AND ((matricula.id_ano)=".$ano.")) and ";
	//$sql = $sql . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) ";
	//$sql = $sql . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	
	$sql = "SELECT matricula.num_mat, curso.grado_curso, curso.letra_curso, matricula.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.calle, alumno.nro, comuna.nom_com, matricula.fecha, matricula.fecha_retiro, alumno.fecha_nac, curso.cod_decreto, alumno.villa ";
	$sql = $sql . "FROM (((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
	$sql = $sql . "WHERE (((tipo_ensenanza.cod_tipo)=$cmb_curso) AND ((matricula.rdb)=".$institucion.")) AND ((curso.id_ano = ".$ano.")) ";
	
	if ($_INSTIT==12838){
	     $sql = $sql . "ORDER BY matricula.num_mat; ";
	}else{
	     $sql = $sql . "ORDER BY curso.grado_curso, curso.letra_curso, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
    }

	

	    $resultado_query= @pg_exec($conn,$sql);
	    $total_filas= @pg_numrows($resultado_query);
     
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
	
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'RegistroMatricula.php?institucion=$institucion';
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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
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
<table width="731" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="731" height="0" align="center" valign="top"> 
      
	                    <?
						include("../../../../cabecera/menu_inferior.php");
						?>
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

  <STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<center>
<?
if ($curso != 0){
?>
<table width="1050" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="capa0">
		<div align="right"> <font face="Arial, Helvetica, sans-serif" size="-1">Imprimir Horizontal</font>
		  <input name="button3" TYPE="button" class="botonXX" onClick="MM_openBrWindow('printRegistroMatricula.php?c_curso=<?=$c_curso ?>&cmb_curso=<?=$cmb_curso?>','','scrollbars=yes,resizable=yes,width=950,height=500')" value="IMPRIMIR">	
          <!--INPUT name="button" TYPE="button" class="botonX" onClick=document.location="curso.php3" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER"-->
  		</div>
	</div>
	</div>
	</td>
  </tr>
  <tr>
    <td>
	<?	$qry_ense = "select tipo_ensenanza.nombre_tipo from tipo_ensenanza where cod_tipo = ".$cmb_curso."";
		$resul_qry_ense= pg_exec($conn,$qry_ense);
		$fila_qry_ense = pg_fetch_array($resul_qry_ense);
	?>
      <table width="1050" height="" border="0" >
        <tr>
          <td width="138" align="left" class="cuadro02">ESTABLECIMENTO</td>
          <td width="200" align="left" class="textonegrita">:&nbsp;<? echo strtoupper($NombreColegio) ?></td>    
          <td width="50" align="left" class="cuadro02">RBD</td>
          <td width="77" align="left" class="textonegrita">:&nbsp;<? echo strtoupper($Rbd) ?></td>
		  <td width="166" align="left" class="cuadro02">TIPO DE ENSEÑANZA</td>
		  <td width="243" align="left" class="textonegrita">:&nbsp;<? echo strtoupper($fila_qry_ense['nombre_tipo']) ?></td>
        </tr>
        <tr>
          <td class="cuadro02">DIRECCION</td>
          <td class="textonegrita">:&nbsp;<? echo strtoupper($Calle)." ".strtoupper($Numero)." ".strtoupper($Villa);?></td>
          <td class="cuadro02">FONO</td>
          <td class="textonegrita">:&nbsp;<? echo strtoupper($Telefono) ?></td>
		  <td width="166" align="left" class="cuadro02">COMUNA</td>
		  <td width="243" align="left" class="textonegrita">:&nbsp;<? echo strtoupper($Comuna) ?></td>
        </tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
        <tr>
          <td height="16" colspan="15"><div align="center" class="Estilo4 Estilo19"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>LIBRO DE REGISTRO DE MATR&Iacute;CULA </strong></font></div></td>
        </tr>
      </table>
	    <table width="1100" border="1" align=center cellpadding="0" cellspacing="0" bordercolor="#999999">
          <tr>
            <td colspan="10" class="tableindex"><center>Datos del Alumno</center></td>
            <td align="center" class="tableindex">&nbsp;</td>
            <td colspan="8" class="tableindex"><center>Apoderado</center></td>
	
          </tr>
          <tr> 
            <td width="19" align="center" class="detalle">N&ordm;</td>
			<td width="50" align="center" class="detalle">Nº Matrícula</td>
			<td width="200" align="center" class="detalle">ALUMNOS</td>
			<td width="60" align="center" class="detalle">RUT</td>
			<td width="100" align="center" class="detalle">COMUNA</td>
            <td width="34" align="center" class="detalle">CURSO</td>                                   
            <td width="44" align="center" class="detalle">FECHA NAC</td>            
            <td width="57" align="center" class="detalle">FECHA INGRESO</td>
            <td width="57" align="center" class="detalle">FECHA EGRESO</td>			
			<td width="93" align="center" class="detalle">DOMICILIO</td>
            <td width="8"  class="detalle">&nbsp;</td>
            <td width="114" align="center" class="detalle">NOMBRE</td>
            <td width="96" align="center" class="detalle">RUT</td>
            <td width="47" align="center" class="detalle">TELEFONO</td>
			<td width="50" align="center" class="detalle">DOMICILIO</td>
			<td width="50" align="center" class="detalle"><div align="center">PROFESI&Oacute;N</div></td>
			<td width="50" align="center" class="detalle"><div align="center">OCUPACI&Oacute;N</div></td>
            <td width="20" align="center" class="detalle">EDUCACI&Oacute;N</td>
          
          </tr>
          <?

		for ($j=0; $j < $total_filas; $j++)
		{
			//------------------------------------------
			$NumMat= trim(pg_result($resultado_query, $j, 0));
			if (empty($NumMat)) $NumMat = 0;
			if ((pg_result($resultado_query,$j,1)==1) and ((pg_result($resultado_query,$j,15)==771982) or (pg_result($resultado_query,$j,15)==461987))){
				$Curso = "PRIMER NIVEL"." - " . trim(pg_result($resultado_query, $j, 2));
			}else if ((pg_result($resultado_query,$j,1)==1) and ((pg_result($resultado_query,$j,15)==121987) or (pg_result($resultado_query,$j,15)==1521989)) ){
				$Curso = "PRIMER CICLO"." - ". trim(pg_result($resultado_query, $j, 2));
			}else if ( (pg_result($resultado_query,$j,1)==1) and (pg_result($resultado_query,$j,15)==1000)){
				$Curso ="SALA CUNA"." - ". trim(pg_result($resultado_query, $j, 2));
			}else if ( (pg_result($resultado_query,$j,1)==2) and ((pg_result($resultado_query,$j,15)==771982) or (pg_result($resultado_query,$j,15)==461987)) ){
				$Curso = "SEGUNDO NIVEL"." - ". trim(pg_result($resultado_query, $j, 2));
			}else if ( (pg_result($resultado_query,$j,1)==2) and (pg_result($resultado_query,$j,15)==121987) ){
				$Curso = "SEGUNDO CICLO";
			}else if ( (pg_result($resultado_query,$j,1)==2) and (pg_result($resultado_query,$j,15)==1000)){
				$Curso = "NIVEL MEDIO MENOR"." - ". trim(pg_result($resultado_query, $j, 2));
			}else if ( (pg_result($resultado_query,$j,1)==3) and ((pg_result($resultado_query,$j,15)==771982) or (pg_result($resultado_query,$j,15)==461987)) ){
				$Curso = "TERCER NIVEL"." - ". trim(pg_result($resultado_query, $j, 2));
			}else if ( (pg_result($resultado_query,$j,1)==3) and (pg_result($resultado_query,$j,15)==1000)){
				$Curso = "NIVEL MEDIO MAYOR"." - ". trim(pg_result($resultado_query, $j, 2));
			}else if ( (pg_result($resultado_query,$j,1)==4) and (pg_result($resultado_query,$j,15)==1000)){
				$Curso = "TRANSICIÓN 1er NIVEL"." - ". trim(pg_result($resultado_query, $j, 2));
			}else if ( (pg_result($resultado_query,$j,1)==5) and (pg_result($resultado_query,$j,15)==1000)){
				$Curso = "TRANSICIÓN 2do NIVEL"." - " . trim(pg_result($resultado_query, $j, 2));
			}else{
				$Curso = trim(pg_result($resultado_query, $j, 1)) . "-" . trim(pg_result($resultado_query, $j, 2));
			}
			//$Curso = trim(pg_result($resultado_query, $j, 1)) . "-" . trim(pg_result($resultado_query, $j, 2)) ;
			$NombreAlu = trim(pg_result($resultado_query, $j, 5)) . " " . trim(pg_result($resultado_query, $j, 6)) . " " . trim(pg_result($resultado_query, $j, 7));
			if (trim(pg_result($resultado_query, $j, 8)) == "2")
				$Sexo = "M";
			else
				$Sexo = "F";
			$RutAlumno = trim(pg_result($resultado_query, $j, 3)) . "-" . trim(pg_result($resultado_query, $j, 4));
			$RutAlumno2 = trim(pg_result($resultado_query, $j, 3));
			$FechaRetiro = Cfecha2(trim(pg_result($resultado_query, $j, 13)));
			$FechaNacimiento = Cfecha2(trim(pg_result($resultado_query, $j, 14)));
			$DomicilioAlumno = trim(pg_result($resultado_query, $j, 9)) . " " . trim(pg_result($resultado_query, $j, 10)) . " " . trim(pg_result($resultado_query,$j,'villa'));
			$ComunaAlumno = trim(pg_result($resultado_query, $j, 11)) ;
			$FechaMatricula = Cfecha2(trim(pg_result($resultado_query, $j, 12)));
			//$NombreApo = trim(pg_result($resultado_query, $j, 16)) . " " . trim(pg_result($resultado_query, $j, 17)) . " " . trim(pg_result($resultado_query, $j, 18)) ;
			//$DomicilioApo = trim(pg_result($resultado_query, $j, 19)) . " " . trim(pg_result($resultado_query, $j, 20)) . " " . trim(pg_result($resultado_query, $j, 21)) . " " . trim(pg_result($resultado_query, $j, 22)) . " " . trim(pg_result($resultado_query, $j, 23)) ;
			$FechaRetiro = cfecha2(trim(pg_result($resultado_query, $j, 13))) ;
			if ($FechaRetiro == "//") $FechaRetiro = "&nbsp;";
			//--------------------------------------------------
			$sql = "SELECT tiene2.rut_alumno, apoderado.ape_pat, apoderado.ape_mat, apoderado.nombre_apo, apoderado.calle, apoderado.nro, apoderado.rut_apo, apoderado.dig_rut, apoderado.telefono, apoderado.cargo,apoderado.ocupacion, apoderado.villa,apoderado.profesion,apoderado.nivel_edu, comuna.nom_com ";
			$sql = $sql . "FROM (tiene2 INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo) INNER JOIN comuna ON (apoderado.comuna = comuna.cor_com) AND (apoderado.region = comuna.cod_reg) AND (apoderado.ciudad = comuna.cor_pro) ";
			$sql = $sql . "WHERE (((tiene2.rut_alumno)=".$RutAlumno2.")); ";

			$result =@pg_Exec($conn,$sql);
			if (!$result) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			}
			else
			{
				if (pg_numrows($result)!=0)
				{
					$fila = @pg_fetch_array($result,0);	
					if (!$fila)
					{
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						exit();
					}
				}
			}
			//--------------------------------------------------
			$NombreApo = trim($fila['ape_pat'])	 . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_apo']);
			$RutApo = trim($fila['rut_apo'])." - ".trim($fila['dig_rut']);
			$TelefonoApo = trim($fila['telefono']);
			$DomiApo = trim($fila['calle']) . " " . trim($fila['nro']) . " " . trim($fila['villa']);
			$CargoApo = trim($fila['profesion']);
			$OcuApo = trim($fila['ocupacion']);
			$Nivel_edu= trim($fila['nivel_edu']);
			if ($_INSTIT==14629){
			$OcuApo = $CargoApo;
			}
			
			if (pg_numrows($result)==0)
			{
				$NombreApo = "&nbsp;" ;
				$RutApo = "&nbsp;";
				$TelefonoApo = "&nbsp;";
				$DomiApo="&nbsp;";
				$Nivel_edu="&nbsp;";
				$CargoApo="&nbsp;";
		        $OcuApo="&nbsp;";
			//$DomiApo = "&nbsp;" ;
			}
			
		?>
          <tr> 
            <td align="center" class="detalle"><? echo ($j+1);?></td>
			<td align="center" class="detalle"><? echo $NumMat;?></td>
            <td align="left" class="detalle"><?	echo $NombreAlu;?></td>
			<td align="left" class="detalle"><?	echo $RutAlumno;?></td>
			<td align="left" class="detalle"><?	echo $ComunaAlumno;?></td>			
			<td align="center" class="detalle"><? echo $Curso;?></td>            
			<td align="center" class="detalle"><? echo $FechaNacimiento;?></td>            
            <td align="center" class="detalle"><? echo $FechaMatricula;?></td>
			<td align="center" class="detalle">&nbsp; <? echo $FechaRetiro; ?></td>
			<td align="left" class="detalle">&nbsp;<? echo $DomicilioAlumno;?></td>
            <td align="left" class="detalle">&nbsp;</td>
            <td><span class="detalle"><? echo $NombreApo;?></td>
            <td align="left" class="detalle"><?	echo $RutApo;?></td>
            <td align="center" class="detalle"><? echo $TelefonoApo;?></td>
            <td class="detalle">&nbsp;<?=$DomiApo ?></td>
			<td class="detalle">&nbsp;<?=$CargoApo ?></td>
			<td class="detalle">&nbsp;<?=$OcuApo ?></td>
			<td class="detalle">&nbsp;<?=$Nivel_edu;?></td>
            <td>&nbsp;</td>
          </tr>
          <?
		  $DomiApo="";
		  $Nivel_edu="";
		  $CargoApo="";
		  $OcuApo="";
		  
		  
		   }?>
        </table>
      <?
	
	//pg_close($conn);
	?>
    </td>
  </tr>
</table>
<?
}
?>
</center>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<?
$institucion	= $_INSTIT;
$ano			= $_ANO;
$c_curso = 0;
?>
<form method "post" action="">
<? 
$sql_curso= "SELECT tipo_ensenanza.nombre_tipo, curso.ensenanza ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "GROUP BY tipo_ensenanza.nombre_tipo, curso.ensenanza ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza;";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------

?>
<center>
<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="120" class="cuadro01">Tipo de Ense&ntilde;anza</td>
    <td width="200">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x" >
          <option value=0 selected>(Seleccione Tipo de Ensenanza)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["ensenanza"]==$cmb_curso){
  				//$Curso_pal = CursoPalabra($fila['ensenanza'], 1, $conn);
				echo "<option selected value=".$fila['ensenanza'].">".$fila['nombre_tipo']."</option>";
  		  }else{
  				//$Curso_pal = CursoPalabra($fila['id_c	urso'], 1, $conn);
				echo "<option value=".$fila['ensenanza'].">".$fila['nombre_tipo']."</option>";
		  }
          } ?>
        </select>
</font>	  </div></td>
    <td width="80"><div align="right">
      <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','RegistroMatricula.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value);return document.MM_returnValue" value="Buscar">
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
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
