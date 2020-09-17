<?
require('../../../../util/header.inc'); 
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
$institucion= $_INSTIT;
 $ano			= $_ANO;

$rut_alumno=$alumno;
$id_curso=$cmb_curso;

$curso=$cmb_curso;

$ob_reporte = new Reporte();
$ob_institucion = new Membrete();
	$ob_institucion -> ano =$ano;
	$ob_institucion -> institucion =$institucion;
	$ob_institucion -> institucion($conn);

$ob_reporte->ano = $ano; 
$ob_reporte->curso = $id_curso;

$ob_institucion->AnoEscolar($conn);	
$nro_ano=$ob_institucion->nro_ano;	
$sql_ense="select ensenanza from curso where id_curso=$id_curso";	

$rs_ense=pg_exec($conn,$sql_ense);
$ense = pg_result($rs_ense,0);

$Curso_pal = CursoPalabra($id_curso, 0, $conn);

if ($rut_alumno!=0){
	$ob_reporte->ano = $ano; 
	$ob_reporte->alumno = $rut_alumno;
	$result_home=$ob_reporte->FichaAlumnoUno_fichamat($conn);
	//$fila = pg_fetch_array($result_home,0);
}else{
	$ob_reporte->ano = $ano; 
	$ob_reporte->curso = $id_curso;
	$ob_reporte->retirado = 0;
	$ob_reporte->orden=1;
	$result_home=$ob_reporte->FichaAlumnoTodos($conn);
}
//echo pg_numrows($result_home);

$d_curso = $ob_reporte->ensCu($conn);
$fila_curso = pg_fetch_array($d_curso,0);

$grado = $fila_curso['grado_curso'];
$ensenanza = $fila_curso['ensenanza'];
$letra = $fila_curso['letra_curso'];


		
function subeGrado($gr,$ens,$lte,$conn){
	if($ens==10 && $gr ==4){
	
		$te= 10;
		$nuevogrado = "KINDER";
	
	}
	
	elseif($ens==10 && $gr ==5){
	
	$te= 110;
	$nuevogrado = 1;
	
	}
	
	elseif($ens==110 && $gr ==8){
	
	 $te= 310;
	  $nuevogrado = 1;
	
	}
	else
	{
	
	 $te= $ens;
	 $nuevogrado = ($gr+1);
	
	}
			
	$sql_nense = "select nombre_tipo from tipo_ensenanza where cod_tipo = $te";
	
	$result_ense = pg_exec($conn,$sql_nense);
	
	$tipo_e =pg_result($result_ense,0);
	
	
	$tipo_e = ($te==10)?"EDUCACI&Oacute;N PARVULARIA":$tipo_e;
	
	$nuevocurso =  $nuevogrado."-".$lte. " ".$tipo_e ;
		
		
		return ($nuevocurso); 
}

 

 
$institucion= $_INSTIT;
 $sci  = "select num_corp from corp_instit where rdb = $institucion";
 $rci= pg_exec($connection,$sci);
  $corp = pg_result($rci,0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
<script language="javascript1.1" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
</STYLE>

<body>
<?php  if ((pg_numrows($result_home)>0) ){
	 ?>
<div id="capa0">
<table width="650" align="center">
  <tr>
    <td><input name="button4" type="button" class="botonXX" onclick="window.close()"   value="CERRAR" /></td>
    <td align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onclick="javascript:imprimir()" />
        <? if($_PERFIL==0){?>
        <input name="cb_exp" type="button" onclick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" />
        <? }?>
    </td>
  </tr>
</table>
</div>
<?php for($i=0;$i<pg_numrows($result_home);$i++){
	$fila=pg_fetch_array($result_home,$i);
$ob_reporte->CambiaDato($fila);
	
    if($corp!=9){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
  <tr>
    <td width="10%" rowspan="4"><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></td>
    <td width="67%" class="textonegrita" align="center">&nbsp;
    <? $sql="SELECT nombre_instit FROM institucion WHERE rdb=".$institucion;
		$rs_instit = pg_exec($conn,$sql);
		echo pg_result($rs_instit,0);
	?>
    </td>
    <td width="13%" class="textosimple">A&ntilde;o Escolar </td>
    <td width="10%"><?php echo ($nro_ano+1) ?></td>
  </tr>
  <tr>
    <td valign="baseline">&nbsp;
    </td>
    <td class="textosimple">N&ordm; Matricula </td>
    <td><span class="textosimple">
      <?=$ob_reporte->num_matricula;?>
    </span></td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="center">FICHA DE MATRICULA </div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php }else{?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
  <tr class="c">
    <th width="216" align="center" scope="col"><img src="../../../../images/fodec.png" width="120" /></th>
    <th width="367" align="center"><table width="100%" border="0">
                          <tr>
                            <td class="item" align="center"><strong>ADMISI&Oacute;N Y MATRICULA</strong></td>
                          </tr>
                        </table>
      <p align="center"><strong>Optimizar el proceso de matr&iacute;cula del establecimiento, a fin de captar nuevos estudiantes por medio de acciones transparantes, sistem&aacute;ticas y objetivas, dentro de un clima de fraternidad</strong></p></th>
    <th width="137" align="center"><?
		if($institucion!=""){
			echo "<img src='../../../../tmp/".$institucion."insignia". "' alt='70' width='75' >";
		}else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
		}	?></th>
    <th width="137" align="center" valign="middle"><p align="center" style="font-size:9px">Rev. 3<br />
        PC.01<br />
    Anexo 9<br />P&aacute;gina 1  de 3<br />
     </p>
</th>
  </tr>
</table><br />
<table width="650" height="170" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
  <tr>
    <td width="78%" align="center"><strong style="font-size:24px">FICHA DE MATRICULA <?php echo ($nro_ano+1) ?>&nbsp;</strong></td>
    <td width="22%" rowspan="4"  class="textonegrita" valign="top" align="right">
      <p style="border:black double; height:150px;width:90%" >&nbsp;</p>
    </td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
  </tr>
  
  <tr align="center">
    <td valign="top" >
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p align="center"><? $sql="SELECT nombre_instit FROM institucion WHERE rdb=".$institucion;
		$rs_instit = pg_exec($conn,$sql);
		echo pg_result($rs_instit,0);
	?></p></td>
  </tr>
<tr>
  <td colspan="7" valign="top"  class="textonegrita">&nbsp;</td>
</tr>
<tr>
  <td colspan="7" valign="top"  class="textsimple"><div style="width:95%">Sr. Apoderado: Recuerde que su responsabilidad es mantener actualizada la informaci&oacute;n de su pupilo(a)</div></td>
</tr>
    </table>
	</td>
  </tr>
</table>


<?php }?>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>&nbsp;I.- DATOS DEL ESTUDIANTE</p></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
  
  <tr>
    <td width="95" valign="top" class="textosimple" bgcolor="#CCCCCC">&nbsp;NOMBRE</td>
    <td colspan="2" valign="top"><span class="textosimple">
      <?=$fila['nombre_alu'];?>
      <?=$fila['ape_pat'];?>
    </span><span class="textosimple">
    <?=$fila['ape_mat'];?></span></td>
    <td width="88" valign="top" bgcolor="#CCCCCC"><span class="textosimple">CURSO</span></td>
    <td valign="top"><?php echo subeGrado($grado,$ensenanza,$letra,$conn) ?></td>
  </tr>
  <tr>
    <td width="95" valign="top" bgcolor="#CCCCCC"  class="textosimple">&nbsp;RUT</td>
    <td valign="top"><span class="textosimple">
      <?=$fila['rut_alumno']."-".$fila['dig_rut'];?>
    </span></td>
    <td  valign="top" bgcolor="#CCCCCC"  class="textosimple">F. NAC</td>
    <td colspan="2"  valign="top" class="textosimple">
      <?php impF($ob_reporte->fecha_nacimiento);?>
    </td>
  </tr>
  <tr>
    <td width="95" valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;DOMICILIO</td>
    <td colspan="6" valign="top"><?=utf8_decode($ob_reporte->tilde(ucfirst(strtolower($ob_reporte->direccion_alu))));?>
      <? if (trim($ob_reporte->depto)!=""){
			echo "DPTO $ob_reporte->depto";
		}?>
      <? if (trim($ob_reporte->block)!=""){
			echo "&nbsp;BLOCK $ob_reporte->block";
		}?>
    <? if (trim($ob_reporte->villa)!=""){
			echo "&nbsp;VILLA $ob_reporte->villa";
		}?></td>
  </tr>
  <tr>
    <td width="95" valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;COMUNA</td>
    <td width="222"  valign="top"><?=$ob_reporte->comuna;?></td>
    <td width="85" valign="top" bgcolor="#CCCCCC" class="textosimple">COLEGIO PROCEDENCIA</td>
    <td colspan="2" valign="top"><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->proced_alumno)));?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;CURSOS REPETIDOS</td>
    <td colspan="4"  valign="top"><?=$fila['txt_anosrepetidos'];?></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" style="border-collapse:collapse" class="textosimple" >
        <tr>
          <td width="232" align="left" bgcolor="#CCCCCC" class="textonegrita" >&nbsp;RELIGION</td>
          <td colspan="3" align="left"  class="textonegrita" >&nbsp;</td>
        </tr>
        <tr>
          <td align="left" bgcolor="#CCCCCC" class="textosimple">&nbsp;SACRAMENTOS RECIBIDOS</td>
          <td align="left" valign="top" class="textosimple" >Bautismo</td>
          <td align="left" valign="top" class="textosimple">Primera Comuni&oacute;n</td>
          <td align="left" valign="top" class="textosimple" >Confirmaci&oacute;n</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>&nbsp;II.- DATOS FAMILIARES</p></td>
  </tr>
</table>
<? 	$ob_reporte->alumno = $ob_reporte->alumno;
	$ob_reporte->responsable = 0;
	$rs_padre = $ob_reporte->Padre($conn);
	$fila_padre = pg_fetch_array($rs_padre,0);
	
	$ob_reporte->id_sistema_salud= $fila_padre['sistema_salud'];
		$rs_sisaludp = $ob_reporte->sistema_salud($conn);
		$fi_sisaludp = pg_fetch_array($rs_sisaludp,0);
		$sissalud_padre = $fi_sisaludp['sistema_salud'];
		
		$ultimo_ano_padre    = $fila_padre['ultimo_ano_aprobado'];
		
		$ocupacion_padre     = $fila_padre['ocupacion'];
		
		
	
?>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
       
  <tr>
          <td valign="top" class="textosimple" bgcolor="#CCCCCC">&nbsp;NOMBRE PADRE</td>
          <td colspan="3"  valign="top"><?=$fila_padre['nombre_apo']." ".$fila_padre['ape_pat']." ".$fila_padre['ape_mat'];?></td>
          <td width="88"  valign="top" bgcolor="#CCCCCC">RUT</td>
          <td width="133"  valign="top"><?=$fila_padre['rut_apo']."-".$fila_padre['dig_rut'];?></td>
        </tr>
        <tr>
          <td width="94" valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;F. NAC</td>
          <td width="126"  valign="top"><?=CambioFD($fila_padre['fecha_nac']);?></td>
          <td width="102"  valign="top" bgcolor="#CCCCCC">CELULAR</td>
          <td width="93"  valign="top"><?=$fila_padre['celular'];?></td>
          <td  valign="top" bgcolor="#CCCCCC">TEL.FIJO</td>
          <td  valign="top"><?=$fila_padre['telefono'];?></td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;PREVISION</td>
          <td colspan="5" valign="top"><?php echo $sissalud_padre ?></td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;ESTUDIOS</td>
          <td colspan="2" valign="top"><?=$fila_padre['nivel_edu'];?></td>
          <td valign="top" bgcolor="#CCCCCC">OCUPACI&Oacute;N</td>
          <td colspan="2" valign="top"><?php echo $ocupacion_padre ?></td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;MAIL</td>
          <td colspan="5" valign="top"><?php echo $fila_padre['email'] ?></td>
        </tr>
      </table>
<BR />
<? 	$ob_reporte->alumno = $ob_reporte->alumno;
	$ob_reporte->responsable = 0;
	$rs_madre = $ob_reporte->Madre($conn);
	$fila_madre = pg_fetch_array($rs_madre,0);
	
	$ob_reporte->id_sistema_salud= $fila_madre['sistema_salud'];
		$rs_sisaludm = $ob_reporte->sistema_salud($conn);
		$fi_sisaludm = pg_fetch_array($rs_sisaludm,0);
		$sissalud_madre = $fi_sisaludm['sistema_salud'];
		
		$ultimo_ano_madre    = $fila_padre['ultimo_ano_aprobado'];
		
		$ocupacion_padre     = $fila_madre['ocupacion'];
		
		
	
?>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
       
        <tr>
          <td valign="top" class="textosimple" bgcolor="#CCCCCC">&nbsp;NOMBRE MADRE</td>
          <td colspan="3"  valign="top"><?=$fila_madre['nombre_apo']." ".$fila_madre['ape_pat']." ".$fila_madre['ape_mat'];?></td>
          <td width="88"  valign="top" bgcolor="#CCCCCC">RUT</td>
          <td width="133"  valign="top"><?=$fila_madre['rut_apo']."-".$fila_madre['dig_rut'];?></td>
        </tr>
        <tr>
          <td width="94" valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;F. NAC</td>
          <td width="126"  valign="top"><?=CambioFD($fila_madre['fecha_nac']);?></td>
          <td width="102"  valign="top" bgcolor="#CCCCCC">CELULAR</td>
          <td width="93"  valign="top"><?=$fila_madre['celular'];?></td>
          <td  valign="top" bgcolor="#CCCCCC">TEL.FIJO</td>
          <td  valign="top"><?=$fila_madre['telefono'];?></td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;PREVISION</td>
          <td colspan="5" valign="top"><?php echo $sissalud_madre ?></td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;ESTUDIOS</td>
          <td colspan="2" valign="top"><?=$fila_madre['nivel_edu'];?></td>
          <td valign="top" bgcolor="#CCCCCC">OCUPACI&Oacute;N</td>
          <td colspan="2" valign="top"><?php echo $ocupacion_madre ?></td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;MAIL</td>
          <td colspan="5" valign="top"><?php echo $fila_madre['email'] ?></td>
        </tr>
      </table>

<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
       
        <tr>
          <td valign="top" class="textosimple" bgcolor="#CCCCCC">&nbsp;NRO DE HERMANOS EN EL COLEGIO</td>
          <td width="290"  valign="top"><?php 
	$rs_hermano=$ob_reporte->hermanos($conn);
	if(pg_numrows($rs_hermano)==0){
	echo "SIN HERMANOS";	
	}else{
		 echo $fil_hermano['ape_pat'] ?> <?php echo $fil_hermano['ape_mat'] ?>, <?php echo $fil_hermano['nombre_hermano'] ?> 
	<?php }?>
	</td>
          <td width="84"  valign="top" bgcolor="#CCCCCC">CURSOS</td>
          <td width="117"  valign="top"><?php 
	$rs_hermano=$ob_reporte->hermanos($conn);
	if(pg_numrows($rs_hermano)==0){
	echo "-";	
	}else{
		  echo CursoPalabra($fil_hermano['id_curso'], 0, $conn)."<br>" ;
	}
	?></td>
        </tr>
        <tr>
          <td width="149" valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;EL ESTUDIANTE VIVE CON</td>
          <td colspan="3"  valign="top"><?=$ob_reporte->cq_vive;?></td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;PREVISION ESTUDIANTE</td>
          <td colspan="3" valign="top"><span class="textosimple">
            <?=$ob_reporte->salud;?>
          </span></td>
        </tr>
      </table>
<H1 class="SaltoDePagina"></H1>

 
 <?php if($corp==9){?>
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
  <tr class="c">
    <th width="216" align="center" scope="col"><img src="../../../../images/fodec.png" width="120" /></th>
    <th width="367" align="center"><table width="100%" border="0">
                          <tr>
                            <td class="item" align="center"><strong>ADMISI&Oacute;N Y MATRICULA</strong></td>
                          </tr>
                        </table>
      <p align="center"><strong>Optimizar el proceso de matr&iacute;cula del establecimiento, a fin de captar nuevos estudiantes por medio de acciones transparantes, sistem&aacute;ticas y objetivas, dentro de un clima de fraternidad</strong></p></th>
    <th width="137" align="center"><?
		if($institucion!=""){
			echo "<img src='../../../../tmp/".$institucion."insignia". "' alt='70' width='75' >";
		}else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
		}	?></th>
    <th width="137" align="center" valign="middle"><p align="center" style="font-size:9px">Rev. 3<br />
        PC.01<br />
    Anexo 9<br />
    P&aacute;gina 2  de 3<br />
     </p></th>
  </tr>
</table>
 <?php }?>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>&nbsp;INDIQUE SI PARTICIPA DE UN BENEFICIO DE UN PROGRAMA DE GOBIERNO</p></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
  <tr>
         <td width="148" height="32" valign="top">CHILE SOLIDARIO</td>
         <td width="29" valign="top"><? if($fila['bool_bchs']==1) echo "SI"; else echo "NO";?></td>
         <td width="214" valign="top">PUENTE</td>
         <td width="28" valign="top"><? if($fila['ben_puente']==1) echo "SI"; else echo "NO";?></td>
         <td width="186" valign="top">PRIORITARIO</td>
         <td width="31" valign="top"><? if($fila['ben_sep']==1) echo "SI"; else echo "NO";?></td>
       </tr>
  <tr>
    <td height="32" valign="top">SUBSIDIO &Uacute;NICO FAMILIAR</td>
    <td valign="top"><?php echo (strlen($fila['txt_subsidio'])>0)?$fila['txt_fichaps']:"N/A" ?></td>
    <td valign="top">ASCENDENCIA IND&Iacute;GENA</td>
    <td valign="top"><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->bool_aoi)));?></td>
    <td valign="top">JUNAEB</td>
    <td valign="top"><? if($fila['bool_juaneb']==1) echo "SI"; else echo "NO";?></td>
  </tr>
  <tr>
    <td height="32" valign="top">OTROS</td>
    <td colspan="5" valign="top">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>III.- ANTECEDENTES DE SALUD</p></td>
  </tr>
</table><br />
<table width="650" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>
<table width="382" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
  <tr>
         <td width="225" height="32" valign="top">PROBLEMAS DE VISI&Oacute;N</td>
         <td width="38" align="center" valign="top"><?php echo (strlen($fila['bool_pvision'])==1)?"X":""; ?></td>
         <td width="33" align="center" valign="top">SI</td>
         <td width="38" align="center" valign="top"><?php echo (strlen($fila['bool_pvision'])==0)?"X":"NO"; ?></td>
         <td width="42" align="center" valign="top">NO</td>
       </tr>
  <tr>
    <td height="32" valign="top">PROBLEMAS DE AUDICI&Oacute;N</td>
    <td align="center" valign="top"><?php echo (strlen($fila['bool_audicion'])==1)?"X":""; ?></td>
    <td align="center" valign="top">SI</td>
    <td align="center" valign="top"><?php echo (strlen($fila['bool_audicion'])==0)?"X":""; ?></td>
    <td align="center" valign="top">NO</td>
  </tr>
  <tr>
    <td height="32" valign="top">PROBLEMAS DE COLUMNA</td>
    <td align="center" valign="top"><?php echo (strlen($fila['bool_columna'])==1)?"X":""; ?></td>
    <td align="center" valign="top">SI</td>
    <td align="center" valign="top"><?php echo (strlen($fila['bool_columna'])==0)?"X":""; ?></td>
    <td align="center" valign="top">NO</td>
  </tr>
  <tr>
    <td height="32" valign="top">PROBLEMAS DENTALES</td>
    <td align="center" valign="top"><?php echo (strlen($fila['bool_pdentales'])==1)?"X":""; ?></td>
    <td align="center" valign="top">SI</td>
    <td align="center" valign="top"><?php echo (strlen($fila['bool_pdentales'])==0)?"X":""; ?></td>
    <td align="center" valign="top">NO</td>
  </tr>
</table>
</td></tr></table>
<BR />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td width="562" colspan="6" valign="top" bgcolor="#CCCCCC" class="textonegrita">TRATAMIENTOS QUE HA TENIDO EL ESTUDIANTE (A&Ntilde;OS)</td>
  </tr>
  <tr class="textosimple">
    <td width="562" valign="top">GRUPO DIFERENCIAL</td>
    <td width="94" valign="top">&nbsp;</td>
    <td width="95" valign="top">NEUR&Oacute;LOGO</td>
    <td width="85" valign="top">&nbsp;</td>
    <td width="217" valign="top">PSIC&Oacute;LOGO</td>
    <td width="217" valign="top">&nbsp;</td>
  </tr>
  <tr class="textosimple">
    <td valign="top">FONOAUDI&Oacute;LOGO</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">PSIQUI&Aacute;TRICO</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">OTROS</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table><br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td width="562" valign="top" bgcolor="#CCCCCC" class="textonegrita">INDIQUE SI SU HIJO(A) HA TENIDO O SUFRE DEL ALGUNA ENFERMEDAD CR&Oacute;NICA</td>
  </tr>
  <tr>
    <td valign="top"><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->inf_salud)));?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>IV.- DATOS DEL APODERADO</p></td>
  </tr>
</table>
<br />
<? 	$ob_reporte->responsable=0;
	$ob_reporte->suplente=0;
	$ob_reporte->alumno = $ob_reporte->alumno;
	$ob_reporte->responsable=1;
	$rs_apoderado = $ob_reporte->Apoderado($conn);
	$fila_apo = pg_fetch_array($rs_apoderado,0);
	$ob_reporte->CambiaDatoApo($fila_apo);
?>
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0"  class="textosimple" style="border-collapse:collapse">
  
  <tr>
    <td width="101" bgcolor="#CCCCCC" class="textosimple">NOMBRE APODERADO</td>
    <td colspan="3" class="textosimple"><?=$ob_reporte->ape_nombre_apo;?></td>
    <td width="108" bgcolor="#CCCCCC" class="textosimple">RUT</td>
    <td width="81" class="textosimple"><?=$ob_reporte->rut_apo;?></td>
  
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">DIRECCI&Oacute;N</td>
    <td colspan="5" class="textosimple"><?=$ob_reporte->direccion;?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">PARENTESCO</td>
    <td width="143" class="textosimple"><?=$ob_reporte->relacion;?></td>
    <td width="86" bgcolor="#CCCCCC" class="textosimple">CELULAR</td>
    <td width="105" class="textosimple"><?=$ob_reporte->celular;?></td>
    <td bgcolor="#CCCCCC" class="textosimple">TEL.FIJO</td>
    <td class="textosimple"><?=$ob_reporte->telefono_apo;?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">MAIL</td>
    <td colspan="5" class="textosimple"><?=$ob_reporte->email_apo;?></td>
  </tr>
</table><br />
<?
		$ob_reporte->suplente =1;
		$ob_reporte->responsable=0;
		$rs_suplente = $ob_reporte->Apoderado($conn);
		$fila_suplente = pg_fetch_array($rs_suplente,0);
		$ob_reporte->CambiaDatoApo($fila_suplente);
	?>
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0"  class="textosimple" style="border-collapse:collapse">
  
  <tr>
    <td width="101" bgcolor="#CCCCCC" class="textosimple">NOMBRE APOD. SUPLENTE</td>
    <td colspan="3" class="textosimple"><?=$ob_reporte->ape_nombre_apo;?></td>
    <td width="108" bgcolor="#CCCCCC" class="textosimple">RUT</td>
    <td width="81" class="textosimple"><?=$ob_reporte->rut_apo;?></td>
  
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">DIRECCI&Oacute;N</td>
    <td colspan="5" class="textosimple"><?=$ob_reporte->direccion;?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">PARENTESCO</td>
    <td width="143" class="textosimple"><?=$ob_reporte->relacion;?></td>
    <td width="86" bgcolor="#CCCCCC" class="textosimple">CELULAR</td>
    <td width="105" class="textosimple"><?=$ob_reporte->celular;?></td>
    <td bgcolor="#CCCCCC" class="textosimple">TEL.FIJO</td>
    <td class="textosimple"><?=$ob_reporte->telefono_apo;?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">MAIL</td>
    <td colspan="5" class="textosimple"><?=$ob_reporte->email_apo;?></td>
  </tr>
</table>
<br />

 <H1 class="SaltoDePagina"></H1>
<?php if($corp==9){?>
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
  <tr class="c">
    <th width="216" align="center" scope="col"><img src="../../../../images/fodec.png" width="120" /></th>
    <th width="367" align="center"><table width="100%" border="0">
                          <tr>
                            <td class="item" align="center"><strong>ADMISI&Oacute;N Y MATRICULA</strong></td>
                          </tr>
                        </table>
      <p align="center"><strong>Optimizar el proceso de matr&iacute;cula del establecimiento, a fin de captar nuevos estudiantes por medio de acciones transparantes, sistem&aacute;ticas y objetivas, dentro de un clima de fraternidad</strong></p></th>
    <th width="137" align="center"><?
		if($institucion!=""){
			echo "<img src='../../../../tmp/".$institucion."insignia". "' alt='70' width='75' >";
		}else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
		}	?></th>
    <th width="137" align="center" valign="middle"><p align="center" style="font-size:9px">Rev. 3<br />
        PC.01<br />
    Anexo 9<br />P&aacute;gina 1  de 3<br />
     </p></th>
  </tr>
</table>
 <?php }?><br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>V.- EN CASO DE EMERGENCIA INDIQUE A QUIEN DIRIGIRNOS</p></td>
  </tr>
</table>
<br />
<?
	
		$ob_reporte ->responsable=1;
		$resultado = $ob_reporte->Apoderado($conn);
		$fila_apo = @pg_fetch_array($resultado,0);
		$ob_reporte->CambiaDatoApo($fila_apo);
/*	$sql_1 = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno = '$rut_alumno' and responsable='1')";
	$res_1 = @pg_Exec($conn, $sql_1);
	$num_1 = @pg_numrows($res_1);
	$fil_1 = @pg_fetch_array($res_1);
	*/	
	$sexo_apo      = $fil_1['sexo'];
	
	$nombre_apo    = $fil_1['nombre_apo'];
	$paterno_apo   = $fil_1['ape_pat'];
	$materno_apo   = $fil_1['ape_mat'];
	$rut_apo       = $fil_1['rut_apo'];
	$dig_rut_apo   = $fil_1['dig_rut'];
	$direccion_apo = $fil_1['direccion'];
	$nro_apo       = $fil_1['nro'];
	$telefono_apo  = $fil_1['telefono'];
	$celular_apo   = $fil_1['celular'];
	$email_apo     = $fil_1['email'];
	$email_apo     = $fil_1['email'];
		
	?>
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" style="border-collapse:collapse" class="textosimple">
  
  <tr>
    <td width="102" class="textosimple">NOMBRE </td>
    <td width="273" class="textosimple"><?=$nombre_apo;?></td>
    <td width="109" class="textosimple">PARENTESCO</td>
    <td width="148" class="textosimple"><?=$fila['relacion'];?></td>
  
  </tr>
  <tr>
    <td class="textosimple">TEL&Eacute;FONO RED FIJA</td>
    <td class="textosimple"><?=$telefono_apo;?></td>
    <td class="textosimple">CELULAR</td>
    <td class="textosimple"><?=$celular_apo;?></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>VI.- ACTIVIDADES PROGRAMADAS QUE NECESITAN AUTORIZACI&Oacute;N MEDIANTE LA FIRMA DEL APODERADO</p></td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">Salidas a Parroquia para las actividades de car&aacute;cter pastoral: Misas, Celebraciones lit&uacute;rgicas, etc</td>
    <td width="339" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple"><p>Actividades deportivas fuera del establecimiento</p>
    <p>&nbsp;</p></td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">Estudiantes JEC; 3&deg; a 6&deg; B&aacute;sico, salir a almorzar fuera del establecimiento: al hogar, a menos de 1&deg; cuadras del establecimiento y regresar a tiempo para el inicio de la jornada de la tarde</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>VII.- PROGRAMA DE SALUD ESCOLAR, AUTORIZACI&Oacute;N MEDIANTE LA FIRMA DEL APODERADO</p></td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">Programa de vacunaci&oacute;n del Ministerio de Salud de acuerdo a la edad y nivel que le corresponde</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple"><p>Control de ni&ntilde;o sano, que realiza el Ministerio de Salud</p>
    <p>&nbsp;</p></td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple"><p>Prevenci&oacute;n dental a cargo de SAMU</p>
    <p>&nbsp;</p></td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>VIII.- RETIRO DEL ESTUDIANTE EN CASO DE EMERGENCIA: TERREMOTO/INCENDIO, ETC.</p></td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">INDICAR PERSONAS AUTORIZADAS PARA RETIRAR A ALUMNO(A) DEL ESTABLECIMIENTO</td>
    <td class="textosimple">INDICAR PARENTESCO / RELACI&Oacute;N CON ALUMNO(A)</td>
  </tr>
  <tr>
    <td width="10" class="textosimple">1</td>
    <td colspan="2" class="textosimple"><?php echo $fila['nombre_retira'] ?></td>
    <td class="textosimple"><?php echo $fila['parentesco_retira'] ?></td>
  </tr>
  <tr>
    <td class="textosimple">2</td>
    <td colspan="2" class="textosimple"><?php echo $fila['nombre_retira2'] ?></td>
    <td class="textosimple"><?php echo $fila['parentesco_retira2'] ?></td>
  </tr>
  <tr>
    <td class="textosimple">3</td>
    <td colspan="2" class="textosimple"><?php echo $fila['nombre_retira3'] ?></td>
    <td class="textosimple"><?php echo $fila['parentesco_retira3'] ?></td>
  </tr>
</table>
<br />


<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla04">
  <tr>
    <td align="center"><div align="center">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>_______________________</p>
    </div></td>
  </tr>
  <tr>
    <td align="center"><div align="center">FIRMA APODERADO </div></td>
  </tr>
</table>
<br />
<br />
<?php if(pg_numrows($result_home)>1){?>
<H1 class="SaltoDePagina"></H1>
<? }
} //fin for
 } //fin if hay alumnos?></td>  
</body>
</html>
