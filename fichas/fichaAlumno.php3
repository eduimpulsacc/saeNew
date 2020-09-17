<?php 
require('../util/header.inc');
require('../util/funciones_new.php'); 

	session_start();
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
  	$_PERFIL;
	$_POSP          =1;
	

// REGISTRO DE HISTORIAL DE NAVEGACION
registrarnavegacion($_USUARIO,'FICHA ALUMNOS',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),
ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);

//******************************************************//
	
	
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];		 
	//----------------------------------------------------------------------------
	// CURSO
	//----------------------------------------------------------------------------	
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	$sql_curso = "SELECT truncado_per, truncado_final,bool_psemestral,fecha_inicio,fecha_termino FROM curso WHERE id_curso=".$curso;
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$truncado_per = $fila_curso['truncado_per'];
	$truncado_final = $fila_curso['truncado_final'];
	$bool_psemestral = $fila_curso['bool_psemestral'];
	
	
	//----------------------------------------------------------------------------
	// ALUMNO
	//----------------------------------------------------------------------------		
	$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
	$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
	$sql_alumno = $sql_alumno . "WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.id_ano)=".$ano.")); ";
	$result_alumno = @pg_Exec($conn, $sql_alumno);
	$fila_alumno = @pg_fetch_array($result_alumno,0);
	$rut_alumno = strtoupper($fila_alumno['rut_alumno'] . " - " . $fila_alumno['dig_rut']);
	$nombre = ucwords(strtolower($fila_alumno['ape_pat']))." ".ucwords(strtolower($fila_alumno['ape_mat']))." ".ucwords(strtolower($fila_alumno['nombre_alu']));
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------	
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano = @pg_Exec($conn, $sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = 	$fila_ano['nro_ano'];
	//-----------------------------------------	
	//------------------FECHAS DE PERIODOS -----------------------
	$sql="";
	if($periodo==0)
	{
		$sql_peri = "select * from periodo where id_ano = ".$ano." order by fecha_inicio";
		$result_peri = pg_exec($conn,$sql_peri);
		for($i=0;$i<pg_numrows($result_peri);$i++)
		{
			if($i==0) //primer semestre
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_inicio = $fila_per['fecha_inicio'];					
			}
			if($i==1) //segundo semestre
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_termino = $fila_per['fecha_termino'];
			}
			if($i==3)//tercer semestre en caso q haya
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_termino = $fila_per['fecha_termino'];
			}
		}	
	}else{
	
	$sql="SELECT fecha_inicio,fecha_termino FROM periodo WHERE id_periodo=".$periodo;
	$Rs_Periodo = @pg_exec($conn,$sql);
	$fila_Periodo=@pg_fetch_array($Rs_Periodo,0);
	$fecha_inicio=$fila_Periodo['fecha_inicio'];
	$fecha_termino=$fila_Periodo['fecha_termino'];
	}
	//-----------------------------------------------------------
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->							  
								  
								  
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="tableindex"><div align="center">FICHA DEL ALUMNO</div></td>
  </tr>
</table>
<div align="right">
  <label><br>
  <? if ($_INSTIT!=9827 and $_INSTIT!=14629) {  ?> <input name="Submit" class="botonXX" type="button" onClick="MM_openBrWindow('print_fichaAlumno.php','','scrollbars=yes,resizable=yes,width=700,height=600')" value="IMPRIMIR FICHA ALUMNO">  <? } else { ?>
  
<script language="Javascript">

document.oncontextmenu = function(){return false}

</script>

<? } ?>
  </label>
  <br>
</div>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="87">&nbsp;</td>
    <td width="8">&nbsp;</td>
    <td width="269">&nbsp;</td>
    <td width="40">&nbsp;</td>
		<?
		$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		$nombre_archivo = '../infousuario/images/'.$arr[rut_alumno];																																		 
		if (file_exists($nombre_archivo)) {?>
		       <?
				 if ($_INSTIT=="24988"){ ?>
			          <img src="../infousuario/images/<?php echo $arr[rut_alumno]?>" ALT="NO DISPONIBLE" width=100 height="110">
		       <? }else{ ?>
			   
			   		   <img src="../infousuario/images/<?php echo $arr[rut_alumno]?>" ALT="NO DISPONIBLE" width=150>	   
			   <? } ?>
		     
		
		<?	} else { ?>
		        
			           <img src="apoderado/imag/alumno555.png" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="237" height="255" id="ALUMNO">		   
			  
		
		<?	}
/*		if 	(!empty($fila_foto['foto']))
		{
			$output= "select lo_export(".$arr['foto'].",'/opt/www/tmp/".chop($arr[rut_alumno])."');";
			$retrieve_result = @pg_exec($conn,$output);?>  			
    <td rowspan="9"><div align="center"><img src="../infousuario/images/<? echo chop($alumno)?>" alt="FOTO" height="220"  border="5"></div></td>
	<? } else {?>
	<td rowspan="9"><div align="center"><img src="apoderado/imag/alumno.gif" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="180" height="220" border="5" id="ALUMNO"></div></td>
	<? }*/?>
    <td width="50">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Institución</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $nombre_institu?></font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Año Escolar</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $nro_ano?></font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $Curso_pal?></font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Alumno</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo strtoupper($nombre);?></font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <?php  if($_PERFIL==15){ ?>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Aprox. Prom. Periodo</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><?php echo ($bool_psemestral==1)?"SI":"NO"; ?></font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Aprox. Prom. Final</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><?php echo ($truncado_per==1)?"SI":"NO"; ?></font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Aprox. Prom. General</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><?php echo ($truncado_final==1)?"SI":"NO"; ?></font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
  <?php }?>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<br>
		<?
			$prom_app=0;
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
		  $sql = "select  * from periodo where id_ano = ".$ano." and mostrar_notas='1' order by fecha_inicio" ;
		  $result1 =@pg_Exec($conn,$sql);
		  if (!$result1) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
    		}
		  else
    		{
    			if (pg_numrows($result1)!=0)
			  {
				  $fila1 = @pg_fetch_array($result1,0);	
				  if (!$fila1)
				  {
					  error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
					  exit();
				  }
			  }
		  }
		  $cont_prom=0; 
		  for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
			$promedio_gen=0;
			$fila1 = @pg_fetch_array($result1,$i);

				$id_periodo = $fila1['id_periodo'];
			?>
          <table width="703" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td width="231" class="tableindex"><div align="left" ><? echo $fila1['nombre_periodo'] ?></div></td>
            <td colspan="20" class="tableindex"><div align="center">NOTAS</div></td>
            <td width="20" class="tableindex">PROM</td>
			
          <?php  if($institucion!=14629){?>
            <td width="20" class="tableindex">NOT.EXA</td>
            <?php }?>
            <td width="20" class="tableindex">NOT.FIN</td>
			<!-- MODULO PROMEDIOS DE APRECION-->
           <?php  if($institucion!=14629){?>
			<? 
				 $sql = "SELECT notaap FROM notas$nro_ano WHERE rut_alumno=".$alumno."  and id_periodo = $id_periodo";
				$rs_aprec = @pg_exec($conn,$sql)or die("Fallo app ".$sql );
				if(@pg_numrows($rs_aprec)>0){
				?>
				<td width="20" class="tableindex">APREC</td>
				<? } ?>
                
                <?php }?>
				<!---  MODULO DE EXAMENES NUEVO SISTEMA -->
				<?  $sql="SELECT max(cuenta) FROM (SELECT count(*) as cuenta FROM examen_semestral WHERE id_curso=".$curso." group by id_ramo) as contador";
					$rs_examen = @pg_exec($conn,$sql);
					$cuenta_examen = @pg_result($rs_examen,0);
					
					for($jj=0;$jj<$cuenta_examen;$jj++){
						?>		
						<td width="20" class="tableindex">Ex.<?=$jj+1;?></td>			         
				 <? } ?>
				 
				 <?
				 if(@pg_numrows($rs_aprec)>0){   /// si sitie otra configuracion aparece esta columna sino NO				 
			          ?>
				     <!-- <td width="20" class="tableindex">P.F.</td>-->
			  <? } ?>  
          </tr>
          <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $promedio_gen=0; 
		  $promedioe=0;
//		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,ramo.conexper ";
		  $sql2 = $sql2 . "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) AND (ramo.id_ramo = tiene$nro_ano.id_ramo) ";
   		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)=".$alumno.")) order by ramo.id_orden ";
          $result =@pg_Exec($conn,$sql2);
		  if (!$result) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
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
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$bool_ip = $fila['bool_ip'];
				$Prom_Sub=0;
				$nota_porc=0;
			?>
          <tr>
            <?
		
			
		  	$sql3 = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17, notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio,notas$nro_ano.notaap, situacion_periodo.nota_final,situacion_periodo.nota_examen, ramo.conexper 
	FROM notas$nro_ano inner join ramo on notas$nro_ano.id_ramo = ramo.id_ramo left join situacion_periodo on notas$nro_ano.rut_alumno = situacion_periodo.rut_alumno
	AND notas$nro_ano.id_ramo=situacion_periodo.id_ramo AND notas$nro_ano.id_periodo=situacion_periodo.id_periodo
AND ramo.conexper=1 
			WHERE notas$nro_ano.rut_alumno=".$alumno." AND notas$nro_ano.id_ramo=".$id_ramo." AND notas$nro_ano.id_periodo=".$id_periodo.";";
			

			$result2 = @pg_Exec($conn,$sql3);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
    			}
			  else
    			{
	    			if (pg_numrows($result2)!=0)
				  {
					  $fila2 = @pg_fetch_array($result2,0);	
					  
					  if (!$fila2)
					  {
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
					  }
				  }
			  }
				$fila2 = @pg_fetch_array($result2,$f);
			
			$cont=$cont+$f;
			
			if ($modo_eval==1){
					if ($fila2['nota1'] >0)  $nota1 = $fila2['nota1'];  else  $nota1 = "&nbsp;";
					if ($fila2['nota2'] >0)  $nota2 = $fila2['nota2'];  else  $nota2 = "&nbsp;";
					if ($fila2['nota3'] >0)  $nota3 = $fila2['nota3'];  else  $nota3 = "&nbsp;";
					if ($fila2['nota4'] >0)  $nota4 = $fila2['nota4'];  else  $nota4 = "&nbsp;";
					if ($fila2['nota5'] >0)  $nota5 = $fila2['nota5'];  else  $nota5 = "&nbsp;";
					if ($fila2['nota6'] >0)  $nota6 = $fila2['nota6'];  else  $nota6 = "&nbsp;";
					if ($fila2['nota7'] >0)  $nota7 = $fila2['nota7'];  else  $nota7 = "&nbsp;";
					if ($fila2['nota8'] >0)  $nota8 = $fila2['nota8'];  else  $nota8 = "&nbsp;";
					if ($fila2['nota9'] >0)  $nota9 = $fila2['nota9'];  else  $nota9 = "&nbsp;";
					if ($fila2['nota10']>0) $nota10 = $fila2['nota10']; else $nota10 = "&nbsp;";
					if ($fila2['nota11']>0) $nota11 = $fila2['nota11']; else $nota11 = "&nbsp;";
					if ($fila2['nota12']>0) $nota12 = $fila2['nota12']; else $nota12 = "&nbsp;";
					if ($fila2['nota13']>0) $nota13 = $fila2['nota13']; else $nota13 = "&nbsp;";
					if ($fila2['nota14']>0) $nota14 = $fila2['nota14']; else $nota14 = "&nbsp;";
					if ($fila2['nota15']>0) $nota15 = $fila2['nota15']; else $nota15 = "&nbsp;";
					if ($fila2['nota16']>0) $nota16 = $fila2['nota16']; else $nota16 = "&nbsp;";
					if ($fila2['nota17']>0) $nota17 = $fila2['nota17']; else $nota17 = "&nbsp;";
					if ($fila2['nota18']>0) $nota18 = $fila2['nota18']; else $nota18 = "&nbsp;";
					if ($fila2['nota19']>0) $nota19 = $fila2['nota19']; else $nota19 = "&nbsp;";
					if ($fila2['nota20']>0) $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";
				}else{
				   
				
					if (chop($fila2['nota1']) <>"0")  $nota1 = $fila2['nota1'];  else  $nota1 = "&nbsp;";
					if (chop($fila2['nota2']) <>"0")  $nota2 = $fila2['nota2'];  else  $nota2 = "&nbsp;";
					if (chop($fila2['nota3']) <>"0")  $nota3 = $fila2['nota3'];  else  $nota3 = "&nbsp;";
					if (chop($fila2['nota4']) <>"0")  $nota4 = $fila2['nota4'];  else  $nota4 = "&nbsp;";
					if (chop($fila2['nota5']) <>"0")  $nota5 = $fila2['nota5'];  else  $nota5 = "&nbsp;";
					if (chop($fila2['nota6']) <>"0")  $nota6 = $fila2['nota6'];  else  $nota6 = "&nbsp;";
					if (chop($fila2['nota7']) <>"0")  $nota7 = $fila2['nota7'];  else  $nota7 = "&nbsp;";
					if (chop($fila2['nota8']) <>"0")  $nota8 = $fila2['nota8'];  else  $nota8 = "&nbsp;";
					if (chop($fila2['nota9']) <>"0")  $nota9 = $fila2['nota9'];  else  $nota9 = "&nbsp;";
					if (chop($fila2['nota10']) <>"0") $nota10 = $fila2['nota10']; else $nota10 = "&nbsp;";
					if (chop($fila2['nota11']) <>"0") $nota11 = $fila2['nota11']; else $nota11 = "&nbsp;";
					if (chop($fila2['nota12']) <>"0") $nota12 = $fila2['nota12']; else $nota12 = "&nbsp;";
					if (chop($fila2['nota13']) <>"0") $nota13 = $fila2['nota13']; else $nota13 = "&nbsp;";
					if (chop($fila2['nota14']) <>"0") $nota14 = $fila2['nota14']; else $nota14 = "&nbsp;";
					if (chop($fila2['nota15']) <>"0") $nota15 = $fila2['nota15']; else $nota15 = "&nbsp;";
					if (chop($fila2['nota16']) <>"0") $nota16 = $fila2['nota16']; else $nota16 = "&nbsp;";
					if (chop($fila2['nota17']) <>"0") $nota17 = $fila2['nota17']; else $nota17 = "&nbsp;";
					if (chop($fila2['nota18']) <>"0") $nota18 = $fila2['nota18']; else $nota18 = "&nbsp;";
					if (chop($fila2['nota19']) <>"0") $nota19 = $fila2['nota19']; else $nota19 = "&nbsp;";
					if (chop($fila2['nota20']) <>"0") $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";	
					
				}
				
				
				$cont++;
				for($o=1;$o<20;$o++){	
		
				 	$sq1 = "SELECT * FROM lexionario as lex 
WHERE lex.id_ano=".$ano." AND lex.id_curso=".$curso." AND lex.id_ramo=".$id_ramo."  and id_periodo=".$id_periodo." and lex.nota=".$o;
					$rl = pg_Exec($conn,$sq1) or die ("Fallo ".$sq1);
					$ns = pg_numrows($rl);
						
					if ($ns > 0){
						$fila1 = pg_fetch_array($rl,0);
						$nombret[$o]=$fila1['descripcion'];
					  	$fecha[$o]=$fila1['fecha'];
					   	$fecha[$o]=Cfecha($fecha[$o]);
					 	$nombretipo[$o]= "Nota de : ".$nombret[$o]."\r\n    Fecha : ".$fecha[$o];
 					}else{
						$nombretipo[$o]="No Existe Descripci&oacute;n de la Nota";
					}
				}
			?>
            
            <td><div align="left"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre'];?></font></div></td>
            <td style="cursor:pointer" width="17"  title="<?=$nombretipo[1]?>">
<div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota1==0){echo "&nbsp;";} else echo $nota1;?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[2]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota2==0){echo "&nbsp;";} else echo $nota2; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[3]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota3==0){echo "&nbsp;";} else echo $nota3; ?></font></div></td>
            <td  style="cursor:pointer" width="17" title="<?=$nombretipo[4]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota4==0){echo "&nbsp;";} else echo $nota4; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[5]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota5==0){echo "&nbsp;";} else echo $nota5; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[6]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota6==0){echo "&nbsp;";} else echo $nota6; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[7]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota7==0){echo "&nbsp;";} else echo $nota7; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[8]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota8==0){echo "&nbsp;";} else echo $nota8; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[9]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota9==0){echo "&nbsp;";} else echo $nota9; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[10]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota10==0){echo "&nbsp;";} else echo $nota10; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[11]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota11==0){echo "&nbsp;";} else echo $nota11; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[12]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota12==0){echo "&nbsp;";} else echo $nota12; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[13]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota13==0){echo "&nbsp;";} else echo $nota13; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[14]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota14==0){echo "&nbsp;";} else echo $nota14; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[15]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota15==0){echo "&nbsp;";} else echo $nota15; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[16]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota16==0){echo "&nbsp;";} else echo $nota16; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[17]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota17==0){echo "&nbsp;";} else echo $nota17; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[18]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota18==0){echo "&nbsp;";} else echo $nota18; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[19]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota19==0){echo "&nbsp;";} else echo $nota19; ?></font></div></td>
            <td style="cursor:pointer" width="17" title="<?=$nombretipo[20]?>"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if ($nota20==0){echo "&nbsp;";} else echo $nota20; ?></font></div></td>
            <? 
			
			if(trim($fila2['promedio'])=="0" /*or empty($fila2['nota20'])*/){
				$prom = "&nbsp;";
			}else{
			 $prom = $fila2['promedio'];}  
			
			if ($prom > 0 ) 
			{
				if($bool_ip==1){
					  $cont_prom=$cont_prom+1;
					 $promedio = ($promedio + $prom);
				}
			}
			?>
            <td><div align="center"><font size="0" face="Arial, Helvetica, sans-serif">
                <? if(trim($fila2['promedio'])=="0" /*or empty($fila2['nota20'])*/){echo "&nbsp;";}else{echo $fila2['promedio'];} 
				
				if (empty($fila2['promedio']) /*or empty($fila2['nota20'])*/){echo "&nbsp;";}
					$Prom_Sub = $fila2['notaap'];
				 ?>
            </font></div></td>
            
            <!--CON EXAMEN PERIODO-->
             <?php if($institucion!=14629){?>
             <td><div align="center"><font size="0" face="Arial, Helvetica, sans-serif">
                <? if(trim($fila2['nota_examen'])==""){echo "&nbsp;";}else{echo $fila2['nota_examen'];} 
				
				
					
				 ?>
            </font></div></td>
            <?php }?>
  <!--********CON EXAMEN PERIODO NOTA FINAL**********-->
            <? 
			 $conexper=$fila2['conexper'];
			if($conexper!=1){
			 $prome = $fila2['promedio'];
			}else{
			 $prome = $fila2['nota_final'];
			}
			 
			
			if ($prome > 0 ) 
			{
				if($bool_ip==1){
					  $cont_prome=$cont_prome+1;
					  $promedioe = ($promedioe + $prome);
				}
			}
			?>
               
             <td><div align="center"><font size="0" face="Arial, Helvetica, sans-serif">
                <? if(trim($fila2['nota_final'])==""){echo $fila2['promedio'];}else{echo $fila2['nota_final'];} 
				
					
				 ?>
            </font></div></td>
			<?php if($institucion!=14629){?>
			<? 			
			$sql = "SELECT notaap FROM notas$nro_ano WHERE rut_alumno=".$alumno." and id_ramo = $id_ramo and id_periodo = $id_periodo";
			$rs_aprec = @pg_exec($conn,$sql);
			
			if(@pg_numrows($rs_aprec)>0){
				
				//$fila_app=pg_fetch_array($rs_aprec,0);
				  ?>			
				<td align="center"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(trim($fila2['notaap'])=="0"){echo "&nbsp;";}else{echo $fila2['notaap'];}?> </font></div></td>
		 <? } ?>		
			
			<?php }?>
			
			<?	
			/// CODIGO PARA MOSTRAR LAS NOTAS DEL EXAMEN
			$sql= "SELECT * FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND id_ano=".$ano." AND periodo=".$id_periodo." AND rut_alumno=".$alumno;
			$rs_nota = @pg_exec($conn,$sql);
				
			for($jj=0;$jj<$cuenta_examen;$jj++){
				$fils_nota = @pg_fetch_array($rs_nota,$jj);
				$nota_ex = $fils_nota['nota'];
				if(pg_numrows($rs_nota)==0){
					$nota_ex="&nbsp;";
				}
				$sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." LIMIT (".$jj."+1) OFFSET ".$jj;
				$rs_porc = @pg_exec($conn,$sql);
				$porc = @pg_result($rs_porc,0);
				$aprox_ex = @pg_result($rs_porc,1);
				$nota_porc = $nota_porc + (($nota_ex * $porc)/100);
					
			    ?>		
			    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
				 <?
				if($nota_ex < 40 && $nota_ex > 0){?> <font color="#FF0000">
				   <? echo $nota_ex; ?></font> 
			 <?	}else { 
				  	  echo $nota_ex;
				}
				?>
				</strong></font></td>         
		 <? } 
			
			$Prom_ex = ($fila2['promedio'] * (100 - $porc))/100;
					
			if($aprox_ex==1){
				$Prom_Sub = round($Prom_ex + $nota_porc);
			}else{
				$Prom_Sub = intval($Prom_ex + $nota_porc);
			}
			if(pg_numrows($rs_nota)==0){
				$Prom_Sub = $fila2['promedio'];
			}
				$Prom_Gral = $Prom_Gral + $Prom_Sub;
			if($Prom_Sub>0)
				$cuenta_ramo ++;
			
			if(@pg_numrows($rs_aprec)>0){
				$Prom_Sub = $fila2['notaap'];
			}
			if ($cuenta_examen>0){ ?>			
				<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? 
					if($Prom_Sub<40 && $Prom_Sub>0){ ?><font color="#FF0000"><? 
						 echo $Prom_Sub; ?></font><? 
					}else{
						if($Prom_Sub==0) 
							echo "&nbsp;"; 
						else
							echo $Prom_Sub; 
					}?></font></font>
				</td>			
		 <? } ?>
			
          </tr>
   <? } ?>
          <tr>
            <td colspan="21" align="right"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Promedio Periodo</strong></font></td>
            <?			
			  if ($cont_prom>0 and $fila['nombre']<>"RELIGION")
			  {
						if($truncado_final==1){
							$promedio_gen = round($promedio/$cont_prom,0);
						}
						else{
							$promedio_gen = intval($promedio/$cont_prom,0);
						}
				  
		//				  $promedio_gen = round($promedio/$cont_prom,0);
						  $promedio_anual = $promedio_anual + $promedio_gen;
						  $cont_prome_anual = $cont_prome_anual + 1;
			  }

			?>
            <td align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>
              <? if ($cont_prom>0) echo $promedio_gen; else echo "&nbsp;";?> 
            </strong></font></td>
             <?php if($institucion!=14629){?>
			<td align="center">&nbsp;</td>
            <?php }?>
             <?			
		/******************PROMEDIO NOTA FINAL**********************/
	if ($cont_prom>0 and $fila['nombre']<>"RELIGION")
	  {
	    if($truncado_final==1){
		 $promedio_gene = round($promedioe/$cont_prom,0);
	    }else{
		 $promedio_gene = intval($promedioe/$cont_prom,0);
	  }
		
	$promedio_anual = $promedio_anual + $promedio_gene;
	$cont_prome_anual = $cont_prome_anual + 1;
  }
		/****************FIN PROMEDIO NOTA FINAL*************************/
	
			?>
            <td align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>
              <? if ($cont_prom>0) echo $promedio_gene; else echo "&nbsp;";?> 
            </strong></font></td>
           <?php  if($institucion!=14629){?>
			<? 			
			
			$sql = "SELECT notaap FROM notas$nro_ano WHERE rut_alumno=".$alumno." and id_ramo = $id_ramo and id_periodo = $id_periodo";
			$rs_aprec2 = @pg_exec($conn,$sql);
					
			if(@pg_numrows($rs_aprec)>0){  
			
			for($j=0;$j<pg_numrows($rs_aprec2);$j++){
				$fila_prom_app=pg_fetch_array($rs_aprec2,$j);
			  $prom_app=$fila_prom_app['notaap'];
			   $promedio_app=$prom_app+$promedio_app;
							
			}
			$final_app=round($promedio_app/$cont_prom);
			?>			
			    <td align="center" class="textonegrita">
				
				<? if(trim($fila2['notaap'])!=""){echo $final_app;}else{echo "&nbsp;";}
					//echo $final_app;
				?></td>			
		 <? }
			}
		  ?>
			
			
			<?			
			for($jj=0;$jj<$cuenta_examen;$jj++){  ?>		
			     <td><font size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;</strong></font></td>			         
		<?  }
			
						
			$Prom_Gral = @round($Prom_Gral /$cuenta_ramo);
			?>
			
			<?			
			if ($cuenta_examen>0){ ?>
			    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">	<? 
					if($Prom_Gral<40 && $Prom_Gral>0){ ?><strong><font color="#FF0000"><? 
						 echo $Prom_Gral; ?></font><? 
					}else{ 
						 if($Prom_Gral==0){
							  echo "&nbsp;";
						 }else{
							  echo $Prom_Gral; 
						 }
					}
					
					$Prom_Gral="&nbsp;";		
					?></strong></font>
				 </td>
			<? } ?> 	
          </tr>
        </table>
           <br>
		   
		 <?
		 //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 /////////////         NUEVO PROCESO PARA MOSTRAR LAS NOTAS DE LOS TALLERES              //////////////////////
		 //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 
		
		 
			  ?>
			  <table width="650" border="1" cellpadding="0" cellspacing="0">
			    <tr>
				   <td width="231" class="tableindex"><div align="left" ><? echo $fila1['nombre_periodo'] ?></div></td>
				   <td colspan="20" class="tableindex"><div align="center">NOTAS (TALLERES)</div></td>
				   <td width="33" class="tableindex">PROM</td>
			    </tr>
				  <?
				  $cont_prom = 0;
				  $promedio = 0;
				  $promedio_gen=0; 
		
				  $sql2 = "SELECT taller.id_taller, taller.nombre_taller, taller.modo_eval FROM taller where rdb=".$institucion." AND id_ano=".$ano." AND id_taller in (select id_taller from tiene_taller where rut_alumno = '$alumno')";
				  
				  $result =pg_Exec($conn,$sql2);
				  if (!$result){
					  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
				  }else{
    			      if (pg_numrows($result)!=0){
				         $fila = @pg_fetch_array($result,0);	
				         if (!$fila){
					         error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					         exit();
				         }
			          }
		          }
		          for($e=0 ; $e < @pg_numrows($result) ; $e++){
			          $fila = @pg_fetch_array($result,$e);
				      $id_ramo   = $fila['id_taller'];
				      $bool_ip   = $fila['bool_ip'];
					  $modo_eval = $fila['modo_eval'];
			          ?>
                      <tr>
                      <?
					  $sql3 = "SELECT notas_taller.nota1, notas_taller.nota2, notas_taller.nota3, notas_taller.nota4, notas_taller.nota5, notas_taller.nota6, notas_taller.nota7, notas_taller.nota8, notas_taller.nota9, notas_taller.nota10, notas_taller.nota11, notas_taller.nota12, notas_taller.nota13, notas_taller.nota14, notas_taller.nota15, notas_taller.nota16, notas_taller.nota17, notas_taller.nota18, notas_taller.nota19, notas_taller.nota20, notas_taller.promedio ";
					  $sql3 = $sql3 . "FROM notas_taller WHERE notas_taller.rut_alumno=".$alumno." AND notas_taller.id_taller=".$id_ramo." AND notas_taller.id_periodo=".$id_periodo."";

			          $result2 =@pg_Exec($conn,$sql3);
		  	          if (!$result2){
				          error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
    			      }else{
	    			      if (pg_numrows($result2)!=0){
					          $fila2 = @pg_fetch_array($result2,0);	
					          if (!$fila2){
						          error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						          exit();
					          }
				          }
			          }
				      $fila2 = @pg_fetch_array($result2,$f);
			        
					
	
			         if ($modo_eval==1){
						  if ($fila2['nota1'] >0)  $nota1 = $fila2['nota1'];  else  $nota1 = "&nbsp;";
						  if ($fila2['nota2'] >0)  $nota2 = $fila2['nota2'];  else  $nota2 = "&nbsp;";
						  if ($fila2['nota3'] >0)  $nota3 = $fila2['nota3'];  else  $nota3 = "&nbsp;";
						  if ($fila2['nota4'] >0)  $nota4 = $fila2['nota4'];  else  $nota4 = "&nbsp;";
						  if ($fila2['nota5'] >0)  $nota5 = $fila2['nota5'];  else  $nota5 = "&nbsp;";
						  if ($fila2['nota6'] >0)  $nota6 = $fila2['nota6'];  else  $nota6 = "&nbsp;";
						  if ($fila2['nota7'] >0)  $nota7 = $fila2['nota7'];  else  $nota7 = "&nbsp;";
						  if ($fila2['nota8'] >0)  $nota8 = $fila2['nota8'];  else  $nota8 = "&nbsp;";
						  if ($fila2['nota9'] >0)  $nota9 = $fila2['nota9'];  else  $nota9 = "&nbsp;";
						  if ($fila2['nota10']>0) $nota10 = $fila2['nota10']; else $nota10 = "&nbsp;";
						  if ($fila2['nota11']>0) $nota11 = $fila2['nota11']; else $nota11 = "&nbsp;";
						  if ($fila2['nota12']>0) $nota12 = $fila2['nota12']; else $nota12 = "&nbsp;";
						  if ($fila2['nota13']>0) $nota13 = $fila2['nota13']; else $nota13 = "&nbsp;";
						  if ($fila2['nota14']>0) $nota14 = $fila2['nota14']; else $nota14 = "&nbsp;";
						  if ($fila2['nota15']>0) $nota15 = $fila2['nota15']; else $nota15 = "&nbsp;";
						  if ($fila2['nota16']>0) $nota16 = $fila2['nota16']; else $nota16 = "&nbsp;";
						  if ($fila2['nota17']>0) $nota17 = $fila2['nota17']; else $nota17 = "&nbsp;";
						  if ($fila2['nota18']>0) $nota18 = $fila2['nota18']; else $nota18 = "&nbsp;";
						  if ($fila2['nota19']>0) $nota19 = $fila2['nota19']; else $nota19 = "&nbsp;";
						  if ($fila2['nota20']>0) $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";
				     }else{
					      					 
						  if (chop($fila2['nota1']) <>"0")  $nota1 = $fila2['nota1'];  else  $nota1 = "&nbsp;";
						  if (chop($fila2['nota2']) <>"0")  $nota2 = $fila2['nota2'];  else  $nota2 = "&nbsp;";
						  if (chop($fila2['nota3']) <>"0")  $nota3 = $fila2['nota3'];  else  $nota3 = "&nbsp;";
						  if (chop($fila2['nota4']) <>"0")  $nota4 = $fila2['nota4'];  else  $nota4 = "&nbsp;";
						  if (chop($fila2['nota5']) <>"0")  $nota5 = $fila2['nota5'];  else  $nota5 = "&nbsp;";
						  if (chop($fila2['nota6']) <>"0")  $nota6 = $fila2['nota6'];  else  $nota6 = "&nbsp;";
						  if (chop($fila2['nota7']) <>"0")  $nota7 = $fila2['nota7'];  else  $nota7 = "&nbsp;";
						  if (chop($fila2['nota8']) <>"0")  $nota8 = $fila2['nota8'];  else  $nota8 = "&nbsp;";
						  if (chop($fila2['nota9']) <>"0")  $nota9 = $fila2['nota9'];  else  $nota9 = "&nbsp;";
						  if (chop($fila2['nota10']) <>"0") $nota10 = $fila2['nota10']; else $nota10 = "&nbsp;";
						  if (chop($fila2['nota11']) <>"0") $nota11 = $fila2['nota11']; else $nota11 = "&nbsp;";
						  if (chop($fila2['nota12']) <>"0") $nota12 = $fila2['nota12']; else $nota12 = "&nbsp;";
						  if (chop($fila2['nota13']) <>"0") $nota13 = $fila2['nota13']; else $nota13 = "&nbsp;";
						  if (chop($fila2['nota14']) <>"0") $nota14 = $fila2['nota14']; else $nota14 = "&nbsp;";
						  if (chop($fila2['nota15']) <>"0") $nota15 = $fila2['nota15']; else $nota15 = "&nbsp;";
						  if (chop($fila2['nota16']) <>"0") $nota16 = $fila2['nota16']; else $nota16 = "&nbsp;";
						  if (chop($fila2['nota17']) <>"0") $nota17 = $fila2['nota17']; else $nota17 = "&nbsp;";
						  if (chop($fila2['nota18']) <>"0") $nota18 = $fila2['nota18']; else $nota18 = "&nbsp;";
						  if (chop($fila2['nota19']) <>"0") $nota19 = $fila2['nota19']; else $nota19 = "&nbsp;";
						  if (chop($fila2['nota20']) <>"0") $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";				
				     }
				
					 ?>
					 <td><div align="left"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre_taller']; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota1;?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota2; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota3; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota4; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota5; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota6; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota7; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota8; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota9; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota10; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota11; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota12; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota13; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota14; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota15; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota16; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota17; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota18; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota19; ?></font></div></td>
					 <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><?  echo $nota20; ?></font></div></td>
					 <? 					
			
					 if(trim($fila2['promedio'])=="0" /*or empty($fila2['nota20'])*/){
						$prom = "&nbsp;";
					 }else{
						$prom = $fila2['promedio'];}  
						
					 if ($prom > 0 ){
						if($bool_ip==1){
							$cont_prom=$cont_prom+1;
							$promedio = ($promedio + $prom);
						}
					 }
					 ?>
					 <td><div align="center"><font size="0" face="Arial, Helvetica, sans-serif">
						<? 
											
						
						if(trim($fila2['promedio'])=="0" /*or empty($fila2['nota20'])*/){echo "&nbsp;";}else{echo $fila2['promedio'];} 
						   if (empty($fila2['promedio']) /*or empty($fila2['nota20'])*/){echo "&nbsp;";}
						?>
					 </font></div></td>
				     </tr>
			   <? } ?>
             <tr>
             <td colspan="21" align="right"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Promedio Periodo</strong></font></td>
             <?			
			  if ($cont_prom>0 and $fila['nombre']<>"RELIGION"){
				 if($truncado_per==1){
					  $promedio_gen = round($promedio/$cont_prom,0);
				 }else{
					  $promedio_gen = intval($promedio/$cont_prom,0);
				 }
				  
			     $promedio_anual = $promedio_anual + $promedio_gen;
				 $cont_prome_anual = $cont_prome_anual + 1;
			  }

			?>
            <td align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>
                <? if ($cont_prom>0) echo $promedio_gen; else echo "&nbsp;";?> 
            </strong></font></td>
          </tr>
        </table>
        <br>
		   
		   
	  <?
	  ////////////////////////// FIN PROCESO PARA MOSTRAR LAS NOTAS DE LOS TALLERES  ////////////////////////
	  ///////////////////////////////////////////////////////////////////////////////////////////////////////
	  ?>	   
		   
		   
		<? } //for?>
		  
	  
	<br>
	<table width="650" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td width="231" class="tableindex"><div align="left" >SITUACION FINAL </div></td>
            <td class="tableindex"><div align="center">PROMEDIO</div></td>
            <td width="128" class="tableindex"><div align="center">EXAMEN</div></td>
            <td width="33" class="tableindex">PROM</td>
          </tr>
          <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $promedio_gen=0; 
//		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip ";
		  $sql2 = $sql2 . "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) AND (ramo.id_ramo = tiene$nro_ano.id_ramo) ";
   		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)=".$alumno.")) AND conex=1 order by ramo.id_orden ";
          $result =@pg_Exec($conn,$sql2);
		  if (!$result) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
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
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$bool_ip = $fila['bool_ip'];
			?>
          <tr>
            <?
			$sql3="SELECT prom_gral,nota_examen,nota_final FROM situacion_final WHERE rut_alumno=".$alumno." AND id_ramo=".$id_ramo;
			
		  	/*$sql3 = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17, notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio ";
			$sql3 = $sql3 . "FROM notas$nro_ano WHERE notas$nro_ano.rut_alumno=".$alumno." AND notas$nro_ano.id_ramo=".$id_ramo." AND notas$nro_ano.id_periodo=".$id_periodo."";*/

			$result2 =@pg_Exec($conn,$sql3);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
    			}
			  else
    			{
	    			if (pg_numrows($result2)!=0)
				  {
					  $fila2 = @pg_fetch_array($result2,0);	
					  if (!$fila2)
					  {
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
					  }
				  }
			  }
				$fila2 = @pg_fetch_array($result2,$f);
			
	
			
				
			?>
            <td width="350"><div align="left"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre']; ?></font></div></td>
            <td width="100"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $fila2['prom_gral']; ?></font></div></td>
            <td width="100"><font size="0" face="Arial, Helvetica, sans-serif"><div align="center"><? echo $fila2['nota_examen']; ?></div></font></td>            
            <td width="100"><font size="0" face="Arial, Helvetica, sans-serif"><div align="center"><? echo $fila2['nota_final']; ?></div></font></td>
          </tr>
          <? } ?>
        </table>
	<br>
	<? 
	$qry_promocion = "select * from promocion where rut_alumno = '$alumno' and id_ano = '$ano'";
	$res_promocion = pg_Exec($conn, $qry_promocion);
	if(pg_numrows($res_promocion) != 0){
	$fila_promocion = pg_fetch_array($res_promocion);
?>	
	<br>
	<table width="650" border="1" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="tableindex" colspan="4"><div align="center">SITUACION FINAL</div></td>
	  </tr>
	  <tr>
	  	<td><strong>Promedio Final</strong></td><td><strong>Asistencia</strong></td><td><strong>Situación</strong></td>
	  </tr>
	  <tr>
	  	<td><?=$fila_promocion['promedio'];?></td><td><?=$fila_promocion['asistencia']."%";?></td><td><? if($fila_promocion['situacion_final'] == 1){echo "Aprobado"; }else if($fila_promocion['situacion_final'] == 3){ echo "Retirado";}else{ echo "Reprobado";}?></td>
	  </tr>
	</table>
	<br>
<? } ?>
		  
		  
<?
if ($_INSTIT!=516 && $_INSTIT!=19921){ ?>
		  
<table width="650" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
   <tr>
	<td class="tableindex"><div align="center">RESUMENES</div></td>
  </tr>
 </table>
 <p> 
   <br>
 
   <?
	$sql_periodo = "select * from periodo where id_ano = ".$ano . " order by fecha_inicio";
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$periodos = @pg_numrows($result_periodo);
	for($cont=0 ; $cont < @pg_numrows($result_periodo) ; $cont++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$cont);
		$fecha_ini = $fila_periodo['fecha_inicio'];
		$fecha_fin = $fila_periodo['fecha_termino'];
		$dias_habiles = $fila_periodo['dias_habiles'];
		if (trim($cadena_nombre_periodo==""))
			$cadena_nombre_periodo = $fila_periodo['nombre_periodo'];
		else
			$cadena_nombre_periodo = $cadena_nombre_periodo . ";" . $fila_periodo['nombre_periodo'];
			
		$sql_atrasos = "select count(*) as atrasos from anotacion where tipo = 2 and fecha > '".$fila_periodo['fecha_inicio']."' and fecha < '".$fila_periodo['fecha_termino']."' and rut_alumno = '".$alumno."'";
		$result_atrasos = @pg_Exec($conn, $sql_atrasos);		
		$fila_atrasos = @pg_fetch_array($result_atrasos,0);		
		if (trim($cadena_atrasos_periodo==""))
			$cadena_atrasos_periodo = $fila_atrasos['atrasos'];
		else
			$cadena_atrasos_periodo = $cadena_atrasos_periodo. ";" . $fila_atrasos['atrasos'];		
		
	 $sql_asis = "select count(*) as inasistencia from asistencia where fecha > '".$fila_periodo['fecha_inicio']."' and fecha < '".$fila_periodo['fecha_termino']."' and rut_alumno = ".$alumno." and id_curso = $curso";
		 $result_asis = @pg_Exec($conn, $sql_asis);		
		$fila_asis = @pg_fetch_array($result_asis,0);				
		if (trim($cadena_asis_periodo==""))
			$cadena_asis_periodo = $fila_asis['inasistencia'];
		else
			$cadena_asis_periodo = $cadena_asis_periodo. ";" . $fila_asis['inasistencia'];		
		
		if ($dias_habiles>0)
		{
			$asistencia =round((($dias_habiles-$fila_asis['inasistencia'])*100)/$dias_habiles,0);
			if (trim($cadena_asisten_periodo==""))
				$cadena_asisten_periodo = $asistencia;
			else
				$cadena_asisten_periodo = $cadena_asisten_periodo. ";" . $asistencia;
		}
		else
		{
		if (trim($cadena_asisten_periodo==""))
				$cadena_asisten_periodo = "100";
			else
				$cadena_asisten_periodo = $cadena_asisten_periodo. ";100";
		}
	}
	$array_nombre = explode(";",$cadena_nombre_periodo);
	$array_atraso = explode(";",$cadena_atrasos_periodo);	
	$array_asis = explode(";",$cadena_asis_periodo);		
	$array_porcen = explode(";",$cadena_asisten_periodo);			
 ?>
 
 
 </p>
 <? if ($_INSTIT !=14629 && $_INSTIT !=19921){?>
 <table width="650"  border="1" cellpadding="0" cellspacing="1">
   <tr>
     <td colspan="3" align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $array_nombre[0];?></strong></font></td>
     <td colspan="3" align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $array_nombre[1];?></strong></font></td>
     <? if ($periodos>2){?>
     <td colspan="3" align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $array_nombre[2];?></strong></font></td>
     <? }?>
   </tr>
   <tr>
     <td ><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Atrasos</strong></font></td>
      <? if($_INSTIT!=14629){?>
      <td ><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Inasistencias</strong></font></td>
        <? } ?>    
     <td ><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Asistencia</strong></font></td>
     <td ><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Atrasos</strong></font></td>
     <? if($_INSTIT!=14629){?>
     <td ><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Inasistencias</strong></font></td>
      <? } ?>
     <td ><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Asistencia</strong></font></td>
     <? if ($periodos>2){?>
     <td ><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Atrasos</strong></font></td>
    
     <td ><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Inasistencias</strong></font></td>
    
     <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Asistencia</strong></font></td>
     <? }?>
   </tr>
   <tr>
     <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $array_atraso[0];?></font></td>
       <? if($_INSTIT!=14629){?>
     <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $array_asis[0];?></font></td>
     <? } ?>
     <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $array_porcen[0]."%"?></font></td>
     <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $array_atraso[1];?></font></td>
       <? if($_INSTIT!=14629){?>
     <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $array_asis[1];?></font></td>
     <? } ?>
     <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $array_porcen[1]."%";?></font></td>
     <? if ($periodos>2){?>
     <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $array_atraso[2];?></font></td>
     <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $array_asis[2];?></font></td>
     <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $array_porcen[2]."%";?></font></td>
     <? }?>
   </tr>
 </table>
 <? } ?>
 <br>
 
 <? } ?>
 
  <? if ($_INSTIT!=770) { ?>
 
 <table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="tableindex"><div align="center">OBSERVACIONES</div></td>
  </tr>
</table> 	
<br>
<?
	$sql_anota = "select anotacion.*,b.ape_pat,b.nombre_emp from anotacion INNER JOIN empleado as b ON anotacion.rut_emp = b.rut_emp ";
	$sql_anota = $sql_anota . "where rut_alumno = ".$alumno." and (fecha>='".$fecha_inicio."' and fecha<='".$fecha_termino."')";
	$sql_anota = $sql_anota . "order by tipo desc, fecha ";
	$result_anota = @pg_Exec($conn, $sql_anota);

/*	$sql_anota = "select anotacion.*, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from anotacion, empleado ";
	$sql_anota = $sql_anota . "where rut_alumno = '".$alumno."' and date_part('Y',fecha) = ".$nro_ano." and anotacion.rut_emp = empleado.rut_emp ";
	$sql_anota = $sql_anota . "and (tipo = 1 or tipo = 2) order by tipo, fecha ";
//	echo $sql_anota;
	$result_anota = @pg_Exec($conn, $sql_anota);*/
	if (@pg_numrows($result_anota)==0) echo "<font face=Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA ANOTACIONES NI ATRASOS</strong></font>";
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		if ($fila_anota['tipo_conducta']==1)
			$tipo_conducta = "POSITIVA";
			
		if ($fila_anota['tipo_conducta']==2)
			$tipo_conducta = "NEGATIVA";							
		if ($fila_anota['tipo']== 1)
			$tipo = $tipo_conducta;
		elseif($fila_anota['tipo']==2)
			$tipo = "ATRASO";
		elseif($fila_anota['tipo']==4)
			$tipo = "INASISTENCIA";
		elseif($fila_anota['tipo']==3)
			$tipo = "RESPONSABILIDAD";
		elseif($fila_anota["codigo_tipo_anotacion"]!=""){
//			$tipo = "AVANZADO";
			$cod_ta = $fila_anota["codigo_tipo_anotacion"];
			$q1 = "select * from tipos_anotacion where id_tipo ='$cod_ta'";
			$r1 = @pg_Exec($conn,$q1);
			$f1 = @pg_fetch_array($r1,0);
			$codta  = $f1['codtipo'];
			$tipo	= $f1['descripcion'];
		}  

			
		$fecha = $fila_anota['fecha'];
		$profesor_res = strtoupper($fila_anota['ape_pat'] . " " . $fila_anota['ape_mat'] . " " . $fila_anota['nombre_emp']);
		if (trim($fila_anota['observacion'])=="")
			$observacion = "&nbsp;";
		else
			$observacion = ucfirst($fila_anota['observacion']);
		$hora = $fila_anota['hora'];
		
		
?>	

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<? if($fila_anota['tipo']!=2){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="156"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Fecha</strong></font></td>
		<td width="7"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
    <td width="258"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha?></font></td>
    <td width="77"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Tipo</strong></font></td>
    <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
    <td width="143"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $tipo?></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor Responsable </strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fila_anota["nombre_emp"]." ".$fila_anota["ape_pat"]?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Hora</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $hora?></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Observaci&oacute;n</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
    <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $observacion?></font></td>
  </tr>
	  <?	if($fila_anota["sigla"]!=""){	?>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Subsector Aprendizaje</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
	<td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?
		// busco la sigla
		$sigla_aux = $fila_anota["sigla"];	
		$q1 = "select * from sigla_subsectoraprendisaje where id_sigla = '$sigla_aux'";
		$r1 = @pg_Exec($conn,$q1);
		$f1 = @pg_fetch_array($r1,0);
		$detalle_sigla = $f1['detalle'];
		echo $f1["sigla"];?> - <? echo $detalle_sigla; ?> 
		</font> 
	</td>
  </tr> 
 <?	}	
   if($fila_anota["codigo_tipo_anotacion"]!=""){?>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Tipo de Anotación</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
	<td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php
		$cod_ta = $fila_anota["codigo_tipo_anotacion"];
		$q1 = "select * from tipos_anotacion where id_tipo = '$cod_ta'";
		$r1 = @pg_Exec($conn,$q1);
		$f1 = @pg_fetch_array($r1,0);
		$codta       = $f1['codtipo'];
		$descripcion	= $f1['descripcion'];
		if($institucion==9566){
			echo $descripcion;
		}else{
			echo "$codta - $descripcion";
		}
  ?> 
		</font> 
	</td>
  </tr>  
  <? }	
  if($fila_anota["codigo_anotacion"]!=""){?>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Sub - Tipo</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
	<td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php 
		$codigo_anotacion = $fila_anota["codigo_anotacion"];
		$q1 = "select * from detalle_anotaciones  where id_tipo = '$cod_ta' and codigo = '$codigo_anotacion'";
		$r1 = @pg_Exec($conn,$q1);
		$f1 = @pg_fetch_array($r1,0);
		$detalle = $f1["detalle"];
		if($institucion==9566){
			echo $detalle;
		}else{
			echo "$codigo_anotacion - $detalle";
		}
		?>
		</font> 
	</td>
  </tr> 
  <?	}	?>  
</table>
<? }else{ ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Atraso el d&iacute;a </strong></font></td>
	<?	

		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);

	?>
    <td width="524"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha?></font></td>
  </tr>
</table>
<? } ?>
<? } ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
 
 
<?

if ($_INSTIT!=14629 && $institucion!=14703){
	$sql_asis = "select * from asistencia where rut_alumno = ".$alumno." and ano = ".$ano." and (fecha>='".$fecha_inicio."' and fecha<='".$fecha_termino."') order by fecha";
	$result_asis = @pg_Exec($conn, $sql_asis);
	if (@pg_numrows($result_asis)==0 && $institucion!=19921) 
		echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA INASISTENCIAS</strong></font><br>";
	for($cont=0 ; $cont < @pg_numrows($result_asis) ; $cont++)
	{
		$fila_asis = @pg_fetch_array($result_asis,$cont);
		$fecha = $fila_asis['fecha'];
		
	$sql_justifica = "select * from justifica_inasistencia where rut_alumno = '$alumno' and ano = '$ano' and fecha = '$fecha'";
	$res_justifica = @pg_Exec($conn,$sql_justifica);
	$fila_justifica = @pg_fetch_array($res_justifica,0);
	$justifica = $fila_justifica['fecha'];	
	 if($justifica == $fecha){
	 	$justificado = true;
	 }else{
	 	$justificado = false;
	 }
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);

?>

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Inasistencia el d&iacute;a </strong></font></td>
    <td width="524"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha;?><strong><? if($justificado==true)echo "&nbsp;&nbsp;&nbsp;(Justificado)";?></strong></font></td>
  </tr>
</table>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<?
 } } }//asistencia
 ?>


 <table width="650" border="0" cellspacing="0" cellpadding="0">
 
</table>
 <br>
 <table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="650">&nbsp;</td>
  </tr>
</table>
 		
</center>

								  
								  
								  
								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2007 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);
   pg_close($connection);
?>