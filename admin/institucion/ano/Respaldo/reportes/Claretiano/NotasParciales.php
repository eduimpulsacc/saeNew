<? 
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
setlocale("LC_ALL","es_ES");
?>
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
				form.action = 'NotasParciales.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>	
	
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$periodo		=$c_periodos;
	$sw				=0;
	$_POSP = 5;
	$_bot = 8;

	if ($curso==0){
	   $sw = 1;
	}   
	if ($periodo==0){
	   $sw = 1;
	}   
	if ($sw == 1){;
	   ## no hace nada
	}else{
	   $sql = "select  * from periodo where id_ano = ".$ano." and id_periodo = ".$periodo." order by id_periodo" ;
	   $result1 =@pg_Exec($conn,$sql);
	   if (!$result1){
	      error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
	   }else{
		  if (pg_numrows($result1)!=0){
		     $fila1 = @pg_fetch_array($result1,0);	
		     if (!$fila1){
			     error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
			     //exit();
		     }
	      }
	   }
	}    
	//-----------------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano']
	//-----------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
<link href="../../../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
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
                                <tr> 
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

     <style type="text/css">
<!--
.Estilo2 {
	font-size: 9px;
	font-weight: bold;
}
-->
</style>
</head>

<body target="mainFrame">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<form method="post" target="mainFrame">
<center>
<?
if ($curso != 0){
   ?>
   <table width="650" border="0" cellpadding="0" cellspacing="0">
     <tr>
     <td><div align="right">
	  <div id="capa0">
	    <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  </div>
    </div></td>
    </tr>
   </table>
   <?
}
?>   
<?
	if (empty($alumno))
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno =" . $alumno ." and id_ano = " . $ano;
		
	$result_alu =@pg_Exec($conn,$sql_alu);
	$cont_alumnos = @pg_numrows($result_alu);

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
{
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;

?>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="125" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>
		<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="125">

							<img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE"  width=100 ></td>
			 </tr>
             </table>
			<? } ?>
			 </td>					
            <td width="503"><table width="517" border="0" cellpadding="0" cellspacing="0">
			<?
			//---------------------------
			$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza  ";
			$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
			$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";

			$result =@pg_Exec($conn,$sql);
			if (!$result) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (La chinga)</B>');
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
			?>
              <tr>
                <td width="133"><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
                <td width="7"><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td width="377"><div align="left"><font face="arial, geneva, helvetica" size="1"><strong><? echo strtoupper(trim($fila['nombre_instit'])) ?></strong></font></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>A�O ESCOLAR</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="1"><strong><? echo trim($fila['nro_ano']) ?></strong></font></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>CURSO</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="1"><strong>
				<? 
				$Curso_pal = CursoPalabra($curso, 0, $conn);
				echo $Curso_pal; 
				?>
				</strong></font></div></td>
              </tr>	
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>ALUMNO</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="1"><strong><? echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));?></strong></font></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>PROFESOR JEFE</strong></font></div></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></div></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="1"><strong>
				<?
				$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
				$result =@pg_Exec($conn,$sql4);
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
				echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				?>
				</strong></font></div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#003b85"><div align="center"><font face="arial, geneva, helvetica" size="2" color="#ffffff">
					    <strong>INFORME  DE NOTAS PARCIALES </strong></font></div></td>
      </tr>
      <tr>
        <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($fila1['nombre_periodo'] . "DEL " . $nro_ano))?></strong></font></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		<?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
		   for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
			$fila1 = @pg_fetch_array($result1,$i);
				if (empty($fila1['fecha_inicio']) or empty($fila1['fecha_termino']))
				{
					?><div align="center"><?
				    echo ('<b> DEBE INGRESAR FECHAS Y DIAS H�BILES PARA PER�ODOS </b> <br> Debe <a href="../../../../ano/periodo/listarPeriodo.php3" target="_parent">ir a Periodos</a>  e ingresar la informaci�n requerida...  <br>  <br> ');
				?>
							 	
				</div>	
				<?
				exit;
				}	
				$id_periodo = $fila1['id_periodo'];
				$dias_habiles = $fila1['dias_habiles'];
				$fecha_ini = $fila1['fecha_inicio'];
				$fecha_fin = $fila1['fecha_termino'];
				//--
				$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = " . $alumno . " and ano = ". $ano . " and id_curso = " . $curso . " and fecha >= '" . $fecha_ini ."' and fecha <= '" . $fecha_fin . "'";
				$result13 =@pg_Exec($conn,$sql13);
			    if (!$result13) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
			  	}
			    else
			  	{
				  	if (pg_numrows($result13)!=0)
				    {
				  	  $fila13 = @pg_fetch_array($result13,0);	
				  	  if (!$fila13)
				  	  {
					  	  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  	  exit();
					    }
				    }
			    }
				$inasistencia = $fila13['cantidad'];
				$dias_asistidos = $dias_habiles - $fila13['cantidad'];
				//--
				$sql8 = "select count(*) as contador from notas$nro_ano where id_periodo = ". $id_periodo . " and rut_alumno = " . $alumno;
			    $result18 =@pg_Exec($conn,$sql8);
			    if (!$result18) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			  	}
			    else
			  	{
				  	if (pg_numrows($result18)!=0)
				    {
				  	  $fila8 = @pg_fetch_array($result18,0);	
				  	  if (!$fila1)
				  	  {
					  	  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  	  exit();
					    }
				    }
			    }
				if ($fila8['contador']>0)
				{
				?>			
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231"><div align="left"></div>
              <strong>
              <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Subsector de Aprendizaje</font></div></td>
            <td colspan="20"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></div></td>
            <td width="33" ><strong><font size="1" face="Arial, Helvetica, sans-serif"><strong>PROM</font></strong></td>
			
            </tr>
         
		  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
		  $sql2 = $sql2 . "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) AND (ramo.id_ramo = tiene$nro_ano.id_ramo) ";
   		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)=".$alumno.")) order by ramo.id_orden";

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
		  $num_subsec = pg_numrows($result);
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];
			?>		
          <tr>
		  <?
		  	$sql3 = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17, notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio ";
			$sql3 = $sql3 . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') AND ((notas$nro_ano.id_ramo)=".$id_ramo.") AND ((notas$nro_ano.id_periodo)=".$id_periodo.")); ";

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
            <td><div align="left"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre']; ?></font></div></td>
			<td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota1 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota2 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota3 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota4 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota5 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota6 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota7 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota8 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota9 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota10 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota11 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota12 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota13 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota14 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota15 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota16 ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota17 ?></font></div></td>
			<td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota18 ?></font></div></td>
			<td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota19 ?></font></div></td>
			<td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? echo $nota20 ?></font></div></td>
			<? 
			if(Trim($fila2['promedio'])=="0" or empty($fila2['nota20'])){
				$prom = "&nbsp;";
			}else{
				$prom = $fila2['promedio'];}  
				
			if (number_format($prom) > 0 and ($fila['nombre']<>"RELIGION")) 
			  {
				  $cont_prom=$cont_prom+1;
				  //echo "Contador ". $cont_prom. "<br>";
				  $promedio = ($promedio + $prom);
				  //echo "Suma" . $promedio ;
			}
			?>
            <td><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if(Trim($fila2['promedio'])=="0" or empty($fila2['nota20'])){echo "&nbsp;";}else{echo $fila2['promedio'];}  ?></font></div></td>
          </tr>
		  <? } ?>
        </table>
		<table width="650" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="461">&nbsp;</td>
            <td width="153"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio Alumno </font></strong></font></div></td>
            <td width="36"><div align="center"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">
			<? 
			if ($promedio > 0) 
			{
				echo $promedio = round($promedio / $cont_prom,0);
				$promedio_gen = $promedio_gen + $promedio;
				$cont_promgen=$cont_promgen +1;
			}
			else
				echo "&nbsp;";
			
			?></font></strong></font></div></td>
          </tr>
        </table>
		<? } //for?>
		<? } //if?> 
		<HR width="100%" color=#003b85>
		<div id="capa1">
		<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="153"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS PERIODO </strong></font></td>
    <td width="237"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $dias_asistidos ?></font></td>
    <td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS INASISTENTES</strong></font></td>
    <td width="78"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></td>
  </tr>
  <tr>

    <td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIAS (%)</strong></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">
      <? 
			if ($dias_habiles>0)
			{
				$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
				$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
				$prom_cont_asis = $prom_cont_asis + 1;
			}
			echo $promedio_asistencia . "%" ;
			?>
    </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATRASOS</strong></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">
	<?
	$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= '" . $fecha_ini ."' and fecha <= '" . $fecha_fin . "')";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$fila_atraso = @pg_fetch_array($result_atraso,0);
	if (empty($fila_atraso['cantidad']))
		echo "0";
	else
		echo $fila_atraso['cantidad'];
	?>
	</font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
		<table width="650" height="119" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="27"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:______________________________________________________________________________</font></strong></font></div></td>
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
		        <table width="650" border="0" cellpadding="0" cellspacing="0">
				  <?
				  for($e=0 ; $e < 18-$num_subsec ; $e++)
				  {
				  ?>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				  <? }?>
                  <tr> 
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
                  </tr>
                  <tr> 
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Profesor(a) 
                        Jefe </font></div></td>
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Director(a) 
                        Establecimiento </font></div></td>
                  </tr>
                  <tr> 
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2"><? echo $nombre_profe; ?> 
                        </font></strong></div></td>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2"> 
                        <?
			$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
			$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
			$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";
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
			echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
			?>
                        </font></strong></div></td>
                  </tr>
                </table>
              </div>
		</td>
      </tr>
    </table>
	<tr>
	  <td>&nbsp;</td>
    </tr>
	</td>
  </tr>
  <tr>
    <td><div align="center"><strong>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</strong></div>
    </table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="124"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">Devolver colilla firmada</font> </div></td>
    <td width="245">&nbsp;</td>
    <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $nombre_alumno; ?></strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtolower($Curso_pal))?></strong></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Promedio Alumno</strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
	  <?
	if ($promedio>0)
		echo $promedio;
	else
		echo "&nbsp;";
		
	?>
	  </strong></font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total D&iacute;as Inasistente </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Per�odo </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo trim($dias_asistidos) ?></font></div></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">Total Atrasos </font></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
      <?
	$sql_atraso = "select * from anotacion where rut_alumno = ".$alumno." and tipo = 2 and (fecha >= '" . $fecha_ini ."' and fecha <= '" . $fecha_fin . "')";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$fila_atraso = @pg_fetch_array($result_atraso,0);
	if (empty($fila_atraso['cantidad']))
		echo "0";
	else
		echo trim($fila_atraso['cantidad']);
	?>
    </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Asistencias (%) </font></div></td>
    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
        <? 
			if ($dias_habiles>0)
			{
				$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
				$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
				$prom_cont_asis = $prom_cont_asis + 1;
			}
			echo $promedio_asistencia . "%" ;
			?>
    </font></div></td>
    <td><div align="left">&nbsp;</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">___________________________</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Firma Apoderado </font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
 <? if  (($cont_alumnos - $cont_paginas)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

} ?>
</center>
</form>

<!-- FIN CUERPO DE LA PAGINA -->

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
<center>
<table width="53%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%">
	<table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="53%" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="39" class="textosmediano">Curso</td>
    <td width="123">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
          <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
				if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987))){
					echo "<option selected value=".$fila['id_curso'].">"."PN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
					echo "<option selected value=".$fila['id_curso'].">"."PC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."SL - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option selected value=".$fila['id_curso'].">"."SN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
					echo "<option selected value=".$fila['id_curso'].">"."SC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."NMME - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option selected value=".$fila['id_curso'].">"."TN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."NMMA - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."T1N - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."T2N  - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else{
				echo "<option selected value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}		  
  		  }else{
		  		if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987))){
					echo "<option value=".$fila['id_curso'].">"."PN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
					echo "<option value=".$fila['id_curso'].">"."PC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."SL - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option value=".$fila['id_curso'].">"."SN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
					echo "<option value=".$fila['id_curso'].">"."SC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."NMME - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option value=".$fila['id_curso'].">"."TN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."NMMA - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."T1N - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."T2N  - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else{
				echo "<option value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}		
		  }
          } ?>
        </select>
</font>	  </div></td>
    <td width="51" class="textosmediano">Periodo</td>
    <td width="125"><select name="cmb_periodos" class="ddlb_9_x">
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
    <td width="199"><div align="right">
      <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','NotasParciales_3y4.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value+'&cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&cmb_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Buscar">
    </div></td>
  </tr>
  <tr>
    <td class="textosmediano">Alumno</td>
    <td>
	<div align="left">
	  		
      <select name="cmb_alumno" class="ddlb_9_x">
		<option value=0 selected>(Todos los Alumnos)</option>
		<?
		$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql);
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
			<option value="<? echo $fila["rut_alumno"]; ?>" <? if ($fila["rut_alumno"]==$c_alumno){ echo "selected";}?>><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
			<?
		}
		?>
      </select>
    </div>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>

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
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
