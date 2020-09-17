<?

require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php'); 
include('../../../clases/class_Membrete.php');

$institucion= $_INSTIT;
$ano 		= $_ANO;
$curso		= $cmb_curso;
$alumno		= $alumno;

$ob_reporte = new Reporte();
$ob_reporte->curso = $curso;
$ob_reporte->ano = $ano;
$ob_reporte->retirado =0;
if($alumno==0){
	$rs_alumno = $ob_reporte->FichaAlumnoTodos($conn);
}else{
	$ob_reporte->alumno = $alumno;
	$rs_alumno = $ob_reporte->FichaAlumnoUno($conn);
}

$ob_membrete = new Membrete();
$ob_membrete->ano = $ano;
$ob_membrete->AnoEscolar($conn);




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
function exportar(){
	window.location='printFichaMatriculaBasica_C.php?cmb_curso=<?=$curso?>&xls=1';
	return false;
}	
</script>
<STYLE>
body{
	font-size:11px}
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 } 
.item strong {
	font-style: italic;
}
.c {
	text-align: center;
}
</STYLE>

<body>
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
<? for($i=0;$i<@pg_numrows($rs_alumno);$i++){
		$fila_alu = pg_fetch_array($rs_alumno,$i);
		$ob_reporte->CambiaDato($fila_alu);
		$sql = "SELECT grado_curso,ensenanza,letra_curso FROM curso a INNER JOIN matricula b ON a.id_curso=b.id_curso WHERE rut_alumno=".$fila_alu['rut_alumno']." AND a.id_ano=".$ano;
		$rs_curso =@pg_exec($conn,$sql);
		$grado = @pg_result($rs_curso,0);
		$ensenanza = @pg_result($rs_curso,1);
		$letra = @pg_result($rs_curso,2);
		if($grado < 8 and $ensenanza==110){
			$grado_new  = $grado + 1 ;
			$nivel = "Básico";
		}elseif($grado==8){
			$grado_new = 1;
			$nivel = "Medio ";
		}elseif($grado < 4 and $ensenanza > 110){
			$grado_new = $grado + 1;
			$nivel = "Medio ";
		}elseif($ensenanza==10 and $grado==4){
			$grado_new = "Kinder ";
			$nivel = "Parvulo ";
		}elseif($ensenanza==10 and $grado==5){
			$grado_new = "1 ";
			$nivel = "Básico";
		}
	if($institucion==1914 OR $institucion==40251 ) {
?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="c">
    <th width="216" align="center" scope="col"><img src="../../../../images/logo_fodec.png" width="62" height="57" /></th>
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
    <th width="137" align="center" valign="middle"><p align="center"><br />
      Rev. 2<br />
    PC.01<br />
    Anexo 5<br />
    P&aacute;gina 1  de 1<strong> </strong></p>
<p align="center">&nbsp; </p></th>
  </tr>
</table>
<? } ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" rowspan="3">
	<?
		if($institucion==1914 OR $institucion==40251 ){
			echo "&nbsp;";	
		}else if($institucion!=""){
			echo "<img src='../../../../tmp/".$institucion."insignia". "' alt='90' width='90' >";
		}else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
		}	?>	</td>
    <td width="63%" class="textosimple">&nbsp;</td>
    <td width="17%" class="textosimple">A&ntilde;o Escolar :</td>
    <td width="10%" class="textosimple">&nbsp;
    <?=($ob_membrete->nro_ano + 1);?></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td class="textosimple">N&ordm; Matricula :</td>
    <td class="textosimple"><? if ($institucion!=1914)if ($institucion!=40251){?>;<?=$ob_reporte->num_matricula;?><? } ?></td>
  </tr>
  
  <tr>
    <td><div align="center"><strong>FICHA DE MATRICULA </strong></div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>
<br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td colspan="4" class="textonegrita" bgcolor="#CCCCCC"><div align="center">DATOS DEL ALUMNO  </div></td>
  </tr>
  <tr>
    <td width="8%" class="textosimple">RUN</td>
    <td colspan="3" class="textosimple">&nbsp;<?=$ob_reporte->rut_alumno;?></td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE</td>
    <td colspan="3" class="textosimple">&nbsp;<?=$ob_reporte->ape_nombre_alu;?></td>
  </tr>
  <tr>
    <td class="textosimple">CURSO</td>
    <td colspan="3" class="textosimple">&nbsp;<?=$grado_new."º ".$letra." ".$nivel;?></td>
  </tr>
  <tr>
    <td class="textosimple">SEXO</td>
    <td colspan="3" class="textosimple">&nbsp;<?=$ob_reporte->sexo;?></td>
  </tr>
  <tr>
    <td class="textosimple">FECHA</td>
    <td colspan="3" class="textosimple">&nbsp;<? impF($ob_reporte->fecha_nacimiento);?></td>
  </tr>
  <tr>
    <td class="textosimple">DOMICILIO</td>
    <td colspan="" class="textosimple">&nbsp;<?=$ob_reporte->direccion_alu;?></td>
    <td width="9%" class="textosimple">SISTEMA&nbsp;SALUD</td>
    <td width="43%" class="textosimple">&nbsp;<?=$ob_reporte->salud;?></td>
  </tr>
  <tr>
    <td class="textosimple">COMUNA</td>
    <td width="40%" class="textosimple">&nbsp;<?=$ob_reporte->comuna;?></td>
    <td width="9%" class="textosimple">TELEFONO</td>
    <td width="43%" class="textosimple">&nbsp;<?=$ob_reporte->telefono_alu;?></td>
    
  </tr>
</table>
<br />

<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="562" colspan="5" valign="top" bgcolor="#CCCCCC" class="textonegrita">ATENCI&Oacute;N DE    PROFESIONALES&nbsp; (Marcar con x)</td>
  </tr>
  <tr>
    <td width="71" valign="top">&nbsp;</td>
    <td width="94" valign="top">&nbsp;</td>
    <td width="95" valign="top">&nbsp;</td>
    <td width="85" valign="top">&nbsp;</td>
    <td width="217" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="71" align="center" valign="bottom" class="textosimple">Psic&oacute;logo</td>
    <td width="94" align="center" valign="bottom" class="textosimple">Fonoaudi&oacute;logo</td>
    <td width="95" align="center" valign="bottom" class="textosimple">Grupo diferencial</td>
    <td width="85" align="center" valign="top" class="textosimple">Otros</td>
    <td width="217" align="center" valign="top" class="textosimple">(mencionar)</td>
  </tr>
</table>
<?php if ($institucion==1914 OR $institucion==40251){?>
<br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" >
        <tr>
          <td width="232" align="left" bgcolor="#CCCCCC" class="textonegrita" >RELIGION</td>
          <td colspan="3" align="left"  bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <tr>
          <td width="50%" align="left" >SACRAMENTOS RECIBIDOS<br />
            (marcar con una X)            </td>
          <td width="16%" align="left" >&nbsp;</td>
          <td width="16%" align="left" >&nbsp;</td>
          <td width="16%" align="left" >&nbsp;</td>
  </tr>
        <tr>
          <td align="left" >&nbsp;</td>
          <td align="left" class="textosimple" >Bautismo</td>
          <td align="left" class="textosimple" >Primera Comuni&oacute;n</td>
          <td align="left" class="textosimple" >Confirmaci&oacute;n</td>
        </tr>
</table>
       <br />
      <br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="657" colspan="8" valign="top" class="textonegrita" bgcolor="#CCCCCC"><p>PERTENECE&nbsp; A: (Marque con&nbsp; una&nbsp;    &ldquo;X&rdquo; lo que corresponda)</p></td>
        </tr>
        <tr>
          <td height="19" valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td width="47" valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="102" align="center" valign="top" class="textosimple">Programa Puente o Chile Solidario</td>
          <td width="73" align="center" valign="top" class="textosimple">JUNAEB</td>
          <td width="94" align="center" valign="top" class="textosimple">Subsidio<br />&Uacute;nico Familiar</td>
          <td width="85" align="center" valign="top" class="textosimple">Descendencia Ind&iacute;gena</td>
          <td width="66" align="center" valign="top" class="textosimple">Isapre</td>
          <td width="66" align="center" valign="top" class="textosimple">Fonasa</td>
          <td width="47" align="center" valign="top" class="textosimple">Grupo</td>
          <td width="123" align="center" valign="top" class="textosimple">Otro&nbsp; (especificar)</td>
        </tr>
      </table>
      

      <?php }?>
<br />
<table border="1" cellspacing="0" cellpadding="0" align="center" width="653">
  <tr>
    <td width="170" valign="top" class="textonegrita" bgcolor="#CCCCCC">CURSO REPETIDO:&nbsp;</td>
    <td width="483" valign="top" class="textonegrita" bgcolor="#CCCCCC">DATOS   BIOL&Oacute;GICOS &ndash; INFORMACI&Oacute;N DE SALUD</td>
  </tr>
  <tr>
    <td width="170" height="39" valign="top"><h3><strong>&nbsp;</strong></h3></td>
    <td width="483" valign="top"><h3>&nbsp;</h3></td>
  </tr>
</table>
<br />
<? 	$ob_reporte->alumno = $ob_reporte->alumno;
	$ob_reporte->responsable = 0;
	$rs_madre = $ob_reporte->Madre($conn);
	$fila_madre = pg_fetch_array($rs_madre,0);
	
?>
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td colspan="2" class="textonegrita" bgcolor="#CCCCCC"><div align="center">DATOS MADRE </div></td>
  </tr>
  <tr>
    <td width="160" class="textosimple">RUN MADRE </td>
    <td width="464" class="textosimple">&nbsp;<?=$fila_madre['rut_apo']."-".$fila_madre['dig_rut'];?></td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE MADRE </td>
    <td class="textosimple">&nbsp;<?=$fila_madre['nombre_apo']." ".$fila_madre['ape_pat']." ".$fila_madre['ape_mat'];?></td>
  </tr>
  <tr>
    <td class="textosimple">TELEFONO MADRE </td>
    <td class="textosimple">&nbsp;<?=$fila_madre['telefono'];?></td>
  </tr>
  <tr>
    <td class="textosimple">ESTUDIOS </td>
    <td class="textosimple">&nbsp;<?=$fila_madre['nivel_edu'];?></td>
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
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" >
  <tr>
    <td colspan="4" class="textonegrita" bgcolor="#CCCCCC"><div align="center" >DATOS DEL APODERADO </div></td>
  </tr>
  <tr>
    <td width="162" class="textosimple">RUN</td>
    <td colspan="3" class="textosimple">&nbsp;<?=$ob_reporte->rut_apo;?></td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE</td>
    <td colspan="3" class="textosimple">&nbsp;<?=$ob_reporte->ape_nombre_apo;?></td>
  </tr>
  <tr>
    <td class="textosimple">PROFESION U OFICIO </td>
    <td colspan="3" class="textosimple">&nbsp;<?=$ob_reporte->profesion;?></td>
  </tr>
  <tr>
    <td class="textosimple">PARENTEZCO - RELACION</td>
    <td colspan="3" class="textosimple">&nbsp;<?=$ob_reporte->relacion;?></td>
  </tr>
  <tr>
    <td class="textosimple">DOMICILIO</td>
    <td colspan="3" class="textosimple">&nbsp;<?=$ob_reporte->direccion;?></td>
  </tr>
  <tr>
    <td class="textosimple">EMAIL</td>
    <td colspan="3" class="textosimple">&nbsp;<?=$ob_reporte->email_apo;?></td>
  </tr>
  <tr>
    <td class="textosimple">COMUNA</td>
    <td width="149" class="textosimple">&nbsp;<?=$ob_reporte->comuna_apo;?></td>
    <td width="81" class="textosimple">TELEFONO</td>
    <td width="218" class="textosimple">&nbsp;<?=$ob_reporte->telefono_apo;?></td>
  </tr>
  <tr>
    <td class="textosimple">FECHA NAC.</td>
    <td class="textosimple">&nbsp;<?=$ob_reporte->fecha_nac_apo;?></td>
    <td class="textosimple">CELULAR</td>
    <td class="textosimple">&nbsp;<?=$ob_reporte->celular;?></td>
  </tr>
</table>
<br />
	<?
		$ob_reporte->suplente =1;
		$ob_reporte->responsable=0;
		$rs_suplente = $ob_reporte->Apoderado($conn);
		$fila_suplente = pg_fetch_array($rs_suplente,0);
		$ob_reporte->CambiaDatoApo($fila_suplente);
	?>
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" >
  <tr>
    <td colspan="4" class="textonegrita" bgcolor="#CCCCCC"><div align="center" >DATOS DEL APODERADO SUPLENTE</div></td>
  </tr>
  <tr>
    <td width="162" class="textosimple">RUN</td>
    <td colspan="3" class="textosimple">&nbsp;
      <?=$ob_reporte->rut_apo;?></td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE</td>
    <td colspan="3" class="textosimple">&nbsp;
      <?=$ob_reporte->ape_nombre_apo;?></td>
  </tr>
  <tr>
    <td class="textosimple">PROFESION U OFICIO </td>
    <td colspan="3" class="textosimple">&nbsp;
      <?=$ob_reporte->profesion;?></td>
  </tr>
  <tr>
    <td class="textosimple">DOMICILIO</td>
    <td colspan="3" class="textosimple">&nbsp;
      <?=$ob_reporte->direccion;?></td>
  </tr>
  <tr>
    <td class="textosimple">COMUNA</td>
    <td width="149" class="textosimple">&nbsp;
      <?=$ob_reporte->comuna_apo;?></td>
    <td width="81" class="textosimple">TELEFONO</td>
    <td width="218" class="textosimple">&nbsp;
      <?=$ob_reporte->telefono_apo;?></td>
  </tr>
  <tr>
    <td class="textosimple">PARENTEZCO - RELACION</td>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">CELULAR</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">EMAIL</td>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
</table>
<br />

<br /><? if ($institucion==1756) if ($institucion==1914){?>  
  <table width="650" border="0" align="center" cellpadding="1">
   <tr>
     <td colspan="3"><div align="center">&quot;Problema de salud significativo&quot; </div></td>
   </tr>
   <tr>
     <td colspan="3">Declaro conocer todas las disposiciones   del Reglamento Interno del   Establecimiento y me comprometo a asistir a   reuniones mensuales y a   cualquier citaci&oacute;n que efect&uacute;e el colegio&quot; </td>
   </tr>
   <tr>
     <td width="159">Autoriza   Relig&iacute;on</td>
     <td width="65">SI</td>
     <td width="420">NO</td>
   </tr>
</table>
 <? }else{?>
 
 <?php }?>
 <br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla04">
  <tr>
    <td><div align="right">______________________________</div></td>
  </tr>
  <tr>
    <td><div align="right">FIRMA APODERADO </div></td>
  </tr>
</table>
<br />

<table width="650" border="0" align="center" cellpadding="2" cellspacing="0" class="tabla04">
  <tr>
    <td width="154">FECHA MATRICULA </td>
    <td width="496"><? if ($institucion!=1914)if ($institucion!=40251){?><?=impF($ob_reporte->fecha_matricula);?><? } ?><br />
_______________________________</td>

  </tr>
  <tr>
    <td>FECHA RETIRO </td>
    <td>_______________________________</td>
  </tr>
  <tr>
    <td>MOTIVO RETIRO </td>
    <td>_____________________________________________________________</td>
  </tr>
  
</table>
<? if($institucion==1914 || $institucion==40251){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th width="112" scope="col">&nbsp;</th>
    <th width="404" scope="col"><p align="center"><strong>FUNDACI&Oacute;N OFICIO DIOCESANO DE EDUCACI&Oacute;N CAT&Oacute;LICA</strong><br />
    <strong><em>&ldquo;Constructores del Reino y Promotores de la Paz&rdquo;</em></strong></p></th>
    <th width="112" scope="col">&nbsp;</th>
  </tr>
</table>
<? } ?>
<br />
<?
echo "<H1 class=SaltoDePagina></H1>";

 } ?>
</body>
</html>
