<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= 1;
    $tipolibro      = $_POST['tipolibro'];
   	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente

	
	$fecha1 	 = $anoN."-04-30"; 
	$ob_membrete = new Membrete();
	$ob_membrete -> ano = $ano;
	$ob_membrete -> institucion = $institucion;
	$ob_membrete -> institucion($conn);
	
	
	$ob_membrete -> AnoEscolar($conn);
	
	
	$ob_reporte = new Reporte();
	$ob_reporte ->cod_tipo = $cmb_curso;
	$ob_reporte ->TipoEnsenanza($conn);
	
	
	

	$ob_reporte_apo = new Reporte();
	
	$ob_reporte ->institucion = $institucion;
	$ob_reporte ->ano =$ano;
	$ob_reporte ->cmb_curso = $cmb_curso;
	$ob_reporte ->orden =$orden;
	$ob_reporte ->SEXO = $SEXO;
	
	
	if($SEXO==1 or $SEXO==2){
		
		$resultado_query= $ob_reporte ->AlumnoEnsenanzaMasculino($conn);
		$total_filas= @pg_numrows($resultado_query);
	}
	
	if($SEXO==3){
		$resultado_query= $ob_reporte ->AlumnoEnsenanza($conn);
		$total_filas= @pg_numrows($resultado_query);
	}
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Registro_Matricula_Ensenanza_$Fecha.xls"); 
	
}	

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
<!-- 
	   function enviapag2(form){
	   form.target="_blank";
       form.action=='printRegistroMatricula_Ensenanza_C.php?cmb_curso=<?=$curso?>&orden=<?=$orden?>';
	   form.submit(true);
		  	}

       function enviapag(form){
	   if (form.cmb_curso.value!=0){
	   form.cmb_curso.target="self";
	   form.action = 'RegistroMatricula.php?institucion=$institucion';
	   form.submit(true);
			}	
		}
//-->
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
//-->
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<style type="text/css">
<!--
.Estilo1 {font-size: 9px}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">



 <form name="form" action="printRegistroMatricula_Ensenanza_C.php?cmb_curso=<?=$curso?>" method="post">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								 

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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td>
  	<div id="capa0">
	<TABLE width="100%"><TR><TD>
	<table>
    <tr>
	  <td align="left"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">	  </td>
	</tr>
  </table>
  </TD><TD>
		<div align="right"> <font face="Arial, Helvetica, sans-serif" size="-1">Imprimir Horizontal</font>
		  <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	
          <!--INPUT name="button" TYPE="button" class="botonX" onClick=document.location="curso.php3" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER"-->
  		</div></TD>
		
  <TD>&nbsp;</TD>
	</TR></TABLE>
	</div>
	</td>
  </tr>
  <tr>
    <td>
	 <table width="100%" height="" border="0" >
        <tr>
          <td align="left" class="textonegrita">RBD</td>
          <td align="left" class="textonegrita">:&nbsp;<? echo $institucion."-".$ob_membrete->dig_rdb;; ?></td>
          <td align="left" class="textonegrita">&nbsp;</td>
          <td colspan="2" rowspan="5" align="right" class="textonegrita">
          <?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c&oacute;digo para tomar la insignia
			
				  if($institucion!=""){
					  $rt = "../../../../tmp/";
					  
					  echo "<img src='".$rt.$fila_foto['rdb']."insignia". "' >";
					 // echo "<img src='"."http://".$_SERVER['HTTP_HOST']."/sae3.0/tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>
       
          </td>
          <td align="left" class="textonegrita">&nbsp;</td>
        </tr>
        <tr>
          <td width="138" align="left" class="textonegrita">ESTABLECIMENTO</td>
          <td width="200" align="left" class="textonegrita">:&nbsp;<?=$ob_membrete->ins_pal; ?></td>    
          <td width="50" align="left" class="textonegrita">&nbsp;</td>
          <td width="243" align="left" class="textonegrita">&nbsp;</td>
        </tr>
        <tr>
          <td class="textonegrita">DIRECCION</td>
          <td class="textonegrita">:&nbsp;<? echo $ob_reporte->tildeM(strtoupper($ob_membrete->direccion));?></td>
          <td class="textonegrita">&nbsp;</td>
          <td width="243" align="left" class="textonegrita">&nbsp;</td>
        </tr>
        <tr>
          <td class="textonegrita">FONO</td>
          <td class="textonegrita">:&nbsp;<? echo strtoupper($ob_membrete->telefono) ?></td>
          <td class="textonegrita">&nbsp;</td>
          <td align="left" class="textonegrita">&nbsp;</td>
        </tr>
        <tr>
          <td class="textonegrita">COMUNA</td>
          <td class="textonegrita">:&nbsp;<? echo strtoupper($ob_membrete->comuna) ?></td>
          <td class="textonegrita">&nbsp;</td>
          <td align="left" class="textonegrita">&nbsp;</td>
        </tr>
        <tr>
          <td class="textonegrita">TIPO DE ENSEÑANZA</td>
          <td class="textonegrita">:&nbsp;<? echo strtoupper($ob_reporte->nombre) ?></td>
          <td class="textonegrita">&nbsp;</td>
          <td class="textonegrita">&nbsp;</td>
          <td align="left" class="textonegrita">&nbsp;</td>
          <td align="left" class="textonegrita">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
            <td></td>
		</tr>
        <tr>
          <td height="16" colspan="15"><div align="center" class="textonegrita"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>LIBRO DE REGISTRO DE MATR&Iacute;CULA <?php echo $ob_membrete ->nro_ano; ?></strong></font></div></td>
        </tr>
      </table>

<!--TABLA MUESTRA DATOS -->

<? if($tipolibro==1){?>

<table width="100%" border="1" align=center cellpadding="0" cellspacing="0" bordercolor="#999999">
          <tr>
            <td colspan="11" class="textonegrita"><center>
            Datos del Alumno
            </center></td>
            <td align="center" class="textonegrita">&nbsp;</td>
            <td colspan="8" class="textonegrita"><center>Apoderado</center></td>
          </tr>
          <tr> 
            <td width="18" align="center" class="detalle">N&ordm;</td>
			<td width="57" align="center" class="detalle">Nº Matrícula</td>
			<td width="78" align="center" class="detalle">ALUMNOS</td>
			<td width="30" align="center" class="detalle">RUT</td>
			<td width="71"  align="center" class="detalle">COMUNA</td>
            <td width="40" align="center" class="detalle">CURSO</td>                                   
            <td width="0"  align="center" class="detalle">SEXO</td>
			<td width="55" align="center" class="detalle">FECHA<br>
NAC</td>
			<td width="55" align="center" class="detalle">EDAD<br> 31 MARZO</td>            
            <td width="55" align="center" class="detalle">FECHA <br>
              INGRESO</td>
            <td width="60" align="center" class="detalle">FECHA<br>
EGRESO</td>			
			<td width="84" align="center" class="detalle">DOMICILIO</td>
            <td width="67" align="center" class="detalle">NOMBRE</td>
            <td width="30" align="center" class="detalle">RUT</td>
            <td width="81" align="center" class="detalle">TELEFONO</td>
			<td width="84" align="center" class="detalle">DOMICILIO</td>
		<td width="87" align="center" class="detalle">PROFESI&Oacute;N</td>
			<? //if ($_INSTIT==14629){ ?>
			<td width="81" align="center" class="detalle">OCUPACIÓN</td>
			<? //} ?>
            
            <td width="80" align="center" class="detalle">EDUCACI&Oacute;N</td>
          </tr>
          <?

		for ($j=0; $j < $total_filas; $j++){
			$fila_alu = @pg_fetch_array($resultado_query,$j);
			$ob_reporte ->CambiaDato($fila_alu);
		
			if (empty($NumMat)) $NumMat = 0;
			//if (($ob_reporte->cod_decreto==771982) or ($ob_reporte->cod_decreto==461987) or ($ob_reporte->cod_decreto==121987) or ($ob_reporte->cod_decreto==1521989) or ($ob_reporte->cod_decreto==1000) or ($ob_reporte->cod_decreto==1000)){
				/*$ob_reporte->grado =$ob_reporte->grado_curso;
				$ob_reporte->decreto =$ob_reporte->cod_decreto;
				$ob_reporte->CambiaDatoCurso($conn);*/ 
				//$Curso=$ob_reporte->sigla." - ".$ob_reporte->letra_curso." ".$ob_reporte->nombre_tipo;
				/* 	$Curso = CursoPalabra($fila_alu['id_curso'], 1, $conn);
			}else{*/
			
			if($ob_reporte->cod_tipo==10){
				$Curso = CursoPalabra($ob_reporte->id_curso,2,$conn);
			}else{
				$Curso=$ob_reporte->grado_curso." - ".$ob_reporte->letra_curso." ".$ob_reporte->ensenanza;
			}
			//}

			
			//--------------------------------------------------
			$ob_reporte_apo->alumno = $ob_reporte->alumno;
			$ob_reporte_apo->responsable = 1;
			$result = $ob_reporte_apo ->Apoderado($conn);
			$fila = @pg_fetch_array($result,0);
			$ob_reporte->CambiaDatoApo($fila);
					
			
			if ($_INSTIT==14629){
				$OcuApo = $ob_reporte->profesion;
			}else{
				$OcuApo = $ob_reporte->ocupacion;
			}
			
			if ($_INSTIT==9074){
				$ProfApo = $ob_reporte->ocupacion;
			}else{
				$ProfApo = $ob_reporte->profesion;
			}
			
		?>
          <tr> 
            <td align="center"><span class="Estilo1"><? echo ($j+1);?></span></td>
			<td align="center"><span class="Estilo1">
			  <?=$ob_reporte->num_matricula;?>
			</span></td>
            <td align="left"><span class="Estilo1">
              <?=//$fila_alu['nombre_alu'];
			  $ob_reporte->tilde($ob_reporte->ape_nombre_alu);?>
            </span></td>
			<td align="left"><span class="Estilo1">
			  <?=$ob_reporte->rut_alumno;?>
			</span></td>
			<td align="left"><span class="Estilo1">
			  <?=$ob_reporte->comuna;?>
			</span></td>			
			<td align="center"><span class="Estilo1"><? echo $Curso;?></span></td> 
			<td align="center"><span class="Estilo1"><span style="font:status-bar">
              <?=$ob_reporte->letra_sexo;?>
            </span></span></td>           
			<td align="center"><span class="Estilo1">
			<? impF($ob_reporte->fecha_nacimiento);?>
			</span></td>
			<td align="center"><span class="Estilo1"><?php echo edadAnoMes($ob_reporte->fecha_nacimiento,$ob_membrete ->nro_ano."-03-31") ?></span></td>            
            <td align="center"><span class="Estilo1">
            <? impF($ob_reporte->fecha_matricula);?>
            </span></td>
			<td align="center"><span class="Estilo1">&nbsp;
    		<? impF($ob_reporte->fecha_retiro); ?>
			</span></td>
			<td align="left"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->direccion_alu);?>
			</span></td>
            <td><span class="Estilo1">&nbsp;
              <?=$ob_reporte->tilde($ob_reporte->ape_nombre_apo);?>
            </span></td>
            <td align="left"><span class="Estilo1">&nbsp;
              <?=$ob_reporte->rut_apo;?>
            </span></td>
            <td align="center"><span class="Estilo1">&nbsp;
              <?=$fila['telefono'];?>&nbsp;<?=$fila['celular'];?>  
            </span></td>
			<td align="center"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->direccion);?>
			</span></td>
			<td align="center"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ProfApo);?>
			</span></td>
			<?// if ($_INSTIT==14629){ ?>
			<td align="center"><span class="Estilo1">&nbsp;<? echo $OcuApo;?></span></td>
			<? //} ?>
            
		    <td><span class="Estilo1">
		      <?=$ob_reporte->nivel_edu;?>
		    </span></td>
            
          </tr>
          <? }?>
 </table>
 

<? }elseif($tipolibro==2){ ?>


<table width="1150" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" style="border-collapse:collapse">
  <tr align="center"  style="font-size:10px">
    <td width="26">N&ordm;</td>
    <td>N&ordm; Matr&iacute;cula</td>
    <td width="171">IDENTIFICACI&Oacute;N DEL ALUMNO </td>
    <td width="85">FECHA NACIM. </td>
    <td width="79">RUN ALUMNO </td>
    <td width="85">CURSO<br>
      Grado,Niv,Jor,Esp</td>
    <td width="49">SEXO<br></td>
    <td width="99">FECHA<br>
      -MATRICULA</td>
    <td width="89">FECHA<br>
      RETIRO</td>
    <td width="89">MOTIVO<br>
      RETIRO</td>
    <td width="87">DOMICILIO<br>Avda./Calle y Nro </td>
    <td width="50">COMUNA</td>
    <td width="88">NOMBRE<br>APODERADO<br>Apellido-Nombre</td>
    
    <td width="59">TELEFONO</td>
    <?
    	if($institucion==4655){
			?>
            <td width="95">OBSERVACI&Oacute;N</td>
            <?
			}else{
	?>
    <td width="95">NIVEL EDUC.<br>Padre Madre </td>
    
    <?
			}
	?>
  </tr>
  <?

		for ($j=0; $j < $total_filas; $j++){
			$fila_alu = @pg_fetch_array($resultado_query,$j);
			$ob_reporte ->CambiaDato($fila_alu);
		
			if (empty($NumMat)) $NumMat = 0;
			
			if($ob_reporte->cod_tipo==10){
			$Curso = CursoPalabra($ob_reporte->id_curso,2,$conn);
			}else{
			$Curso=$ob_reporte->grado_curso." - ".$ob_reporte->letra_curso." ".$ob_reporte->ensenanza;
			}
			//}

			
			//--------------------------------------------------
			$ob_reporte_apo->alumno = $ob_reporte->alumno;
			$ob_reporte_apo->responsable = 1;
			$result = $ob_reporte_apo ->Apoderado($conn);
			$fila = @pg_fetch_array($result,0);
			$ob_reporte_apo->CambiaDatoApo($fila);
			
			
			
			
			
			if ($_INSTIT==14629){
			$OcuApo = $ob_reporte_apo->profesion;
			}
			
			
		?>
  <tr style="font-size:10px" >
    <td>&nbsp;<? echo ($j+1);?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte->num_matricula;?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte->tilde($ob_reporte->ape_nombre_alu);?>&nbsp;<span class="Estilo1">
      <?=$ob_reporte->c_procedencia;?>
    </span></td>
    <td align="center">&nbsp;<? impF($ob_reporte->fecha_nacimiento);?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte->rut_alumno;?>&nbsp;</td>
    <td align="center">&nbsp;<?=$Curso."-".$ob_reporte->nombre_tipo?>&nbsp;</td>
    <td style="font:status-bar" align="center">&nbsp;
    <? /*if($ob_reporte->letra_sexo==2){ echo "H"; }elseif($ob_reporte->sexo==1){ echo "M";} */ echo $ob_reporte->letra_sexo;?>&nbsp;</td>
    <td align="center">&nbsp;<? impF($ob_reporte->fecha_matricula);?>&nbsp;</td>
    <td align="center">&nbsp;<? impF($ob_reporte->fecha_retiro); ?>&nbsp;</td>
    <td align="center"><?=$ob_reporte->motivo_retiro ?></td>
    <td>&nbsp;<?=$ob_reporte->tilde($ob_reporte->direccion_alu);?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte->comuna;?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte->tilde($ob_reporte_apo->ape_nombre_apo);?>&nbsp;</td>
   
    <td>
      <?php echo $fila['telefono'] ?>&nbsp;<?php echo $fila['celular'] ?>
      
    </td>
    <?
    	if($institucion==4655){
			?>
			<td>&nbsp;<?=$ob_reporte_apo->observacion;?>&nbsp;</td>
			<?
		}else{
	?>
    
    <td>&nbsp;<?=$ob_reporte_apo->nivel_edu;?>&nbsp;</td>
	<?
		}
	?>
  </tr>
  <? }?>
</table>
<? }elseif($tipolibro==3){ ?>
<table width="1150" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" style="border-collapse:collapse">
  <tr align="center"  style="font-size:10px">
    <td width="26">N&ordm;</td>
    <td width="58">N&ordm; Matr&iacute;cula</td>
    <td width="171">IDENTIFICACI&Oacute;N DEL ALUMNO </td>
    <td width="60">FECHA<br>
NACIM. </td>
    <td width="79">RUN ALUMNO </td>
    <td width="85">CURSO<br>
      Grado,Niv,Jor,Esp</td>
    <td>SEXO<br></td>
    <td width="60">FECHA-INGRESO</td>
    <td width="60">FECHA <br>
      EGRESO </td>
    <td width="87">DOMICILIO<br>Avda./Calle y Nro </td>
    <td width="70">COMUNA</td>
    <td width="88">RUT <br>
APODERADO</td>
    <td width="88">NOMBRE<br>APODERADO<br>Apellido-Nombre</td>
    
    <td width="59">TELEFONO</td>
    <td width="59">CELULAR</td>
    <td width="59">EMAIL</td>
    
  </tr>
  <?

		for ($j=0; $j < $total_filas; $j++){
			$fila_alu = @pg_fetch_array($resultado_query,$j);
			$ob_reporte ->CambiaDato($fila_alu);
		
			if (empty($NumMat)) $NumMat = 0;
			
			if($ob_reporte->cod_tipo==10){
			$Curso = CursoPalabra($ob_reporte->id_curso,2,$conn);
			}else{
			$Curso=$ob_reporte->grado_curso." - ".$ob_reporte->letra_curso." ".$ob_reporte->ensenanza;
			}
			//}

			
			//--------------------------------------------------
			$ob_reporte_apo->alumno = $ob_reporte->alumno;
			$ob_reporte_apo->responsable = 1;
			$result = $ob_reporte_apo ->Apoderado($conn);
			$fila = @pg_fetch_array($result,0);
			$ob_reporte_apo->CambiaDatoApo($fila);
					
			
			if ($_INSTIT==14629){
			$OcuApo = $ob_reporte_apo->profesion;
			}
			
			
		?>
  <tr style="font-size:10px" >
    <td>&nbsp;<? echo ($j+1);?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte->num_matricula;?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte->tilde($ob_reporte->ape_nombre_alu);?>&nbsp;</td>
    <td align="center">&nbsp;<? impF($ob_reporte->fecha_nacimiento);?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte->rut_alumno;?>&nbsp;</td>
    <td align="center">&nbsp;<?=$Curso."-".$ob_reporte->nombre_tipo?>&nbsp;</td>
    <td style="font:status-bar" align="center">&nbsp;
    <? /*if($ob_reporte->letra_sexo==2){ echo "H"; }elseif($ob_reporte->sexo==1){ echo "M";} */ echo $ob_reporte->letra_sexo;?>&nbsp;</td>
    <td align="center">&nbsp;<? impF($ob_reporte->fecha_matricula);?>&nbsp;</td>
    <td align="center">&nbsp;<? impF($ob_reporte->fecha_retiro); ?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte->tilde($ob_reporte->direccion_alu);?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte->comuna;?>&nbsp;</td>
    <td>&nbsp;<?=$ob_reporte_apo->rut_apo;?></td>
    <td>&nbsp;<?=$ob_reporte->tilde($ob_reporte_apo->ape_nombre_apo);?>&nbsp;</td>
   
    <td>&nbsp;<?=$fila_alu['telefono'];?>&nbsp;</td>
    <td>&nbsp;<?=$fila_alu['celular'];?></td>
    <td><?=$ob_reporte_apo->email_apo;?></td>
   
	
  </tr>
  <? }?>
</table>

<? }elseif($tipolibro==4){
	?> 
    <table width="100%" border="1" align=center cellpadding="0" cellspacing="0" bordercolor="#999999">
          <tr>
            <td colspan="14" class="textonegrita"><center>
              Datos del Alumno
            </center></td>
            <td colspan="10" class="textonegrita"><center>Apoderado</center></td>
          </tr>
          <tr> 
            <td width="18" align="center" class="detalle">N&ordm;</td>
			<td width="57" align="center" class="detalle">Nº Matrícula</td>
			<td width="78" align="center" class="detalle">ALUMNOS</td>
			<td width="30" align="center" class="detalle">RUN</td>
			<td width="71"  align="center" class="detalle">COMUNA</td>
            <td width="40" align="center" class="detalle">CURSO</td>                                   
            <td width="0"  align="center" class="detalle">SEXO</td>
			<td width="55" align="center" class="detalle">FECHA<br>
NAC</td>            
            <td width="55" align="center" class="detalle">FECHA <br>
              INGRESO</td>
            <td width="60" align="center" class="detalle">FECHA<br>
EGRESO</td>
            <td width="60" align="center" class="detalle">PROCEDENCIA</td>
            <td width="60" align="center" class="detalle">CON QUIEN VIVE</td>
            <td width="60" align="center" class="detalle">OBSERVACIONES</td>			
			<td width="84" align="center" class="detalle">DOMICILIO</td>
            <td width="67" align="center" class="detalle">NOMBRE</td>
            <td width="30" align="center" class="detalle">RUT</td>
            <td width="81" align="center" class="detalle">TELEFONO</td>
			<td width="84" align="center" class="detalle">DOMICILIO</td>
		<td width="87" align="center" class="detalle">PROFESI&Oacute;N</td>
			<? if ($_INSTIT==14629){ ?>
			<td width="81" align="center" class="detalle">OCUPACIÓN</td>
			<? } ?>
            <td width="80" align="center" class="detalle">EDUCACI&Oacute;N</td>
            <td width="80" align="center" class="detalle">NIVEL EDUCACIONAL PADRE</td>
            <td width="80" align="center" class="detalle">NIVEL EDUCACIONAL MADRE</td>
          </tr>
          <?
		for ($j=0; $j < $total_filas; $j++){
			$fila_alu = @pg_fetch_array($resultado_query,$j);
			$ob_reporte ->CambiaDato($fila_alu);
		
			if (empty($NumMat)) $NumMat = 0;
			//if (($ob_reporte->cod_decreto==771982) or ($ob_reporte->cod_decreto==461987) or ($ob_reporte->cod_decreto==121987) or ($ob_reporte->cod_decreto==1521989) or ($ob_reporte->cod_decreto==1000) or ($ob_reporte->cod_decreto==1000)){
				/*$ob_reporte->grado =$ob_reporte->grado_curso;
				$ob_reporte->decreto =$ob_reporte->cod_decreto;
				$ob_reporte->CambiaDatoCurso($conn);*/ 
				//$Curso=$ob_reporte->sigla." - ".$ob_reporte->letra_curso." ".$ob_reporte->nombre_tipo;
				/* 	$Curso = CursoPalabra($fila_alu['id_curso'], 1, $conn);
			}else{*/
			
			if($ob_reporte->cod_tipo==10){
				$Curso = CursoPalabra($ob_reporte->id_curso,2,$conn);
			}else{
				$Curso=$ob_reporte->grado_curso." - ".$ob_reporte->letra_curso." ".$ob_reporte->ensenanza;
			}
			//}

			
			//--------------------------------------------------
			$ob_reporte_apo->alumno = $ob_reporte->alumno;
			$result = $ob_reporte_apo ->Apoderado($conn);
			$fila = @pg_fetch_array($result,0);
			$ob_reporte->CambiaDatoApo($fila);
					
					
			if($fila)
			{
				$result_apos = $ob_reporte_apo->Apoderado_all($conn);
					$fila1 = @pg_fetch_array($result_apos,0);
				if($fila1['relacion']==1)
				{
					$edu_padre = $fila1['nivel_edu'];
				}
				elseif($fila1['relacion']==2)
				{
					$edu_madre = $fila1['nivel_edu'];
				}
				
				
				$fila2 = @pg_fetch_array($result_apos,1);
				if($fila2['relacion']==1)
				{
					$edu_padre = $fila2['nivel_edu'];
				}
				elseif($fila2['relacion']==2)
				{
					$edu_madre = $fila2['nivel_edu'];
				}
			
			}else{
				$edu_padre ="-";
				$edu_madre ="-";
				}
			
			
			if ($_INSTIT==14629){
			$OcuApo = $ob_reporte_apo->profesion;
			}
			
			
		?>
          <tr> 
            <td align="center"><span class="Estilo1"><? echo ($j+1);?></span></td>
			<td align="center"><span class="Estilo1">
			  <?=$ob_reporte->num_matricula;?>
			</span></td>
            <td align="left"><span class="Estilo1">
              <?=//$fila_alu['nombre_alu'];
			  $ob_reporte->tilde($ob_reporte->ape_nombre_alu);?>
            </span></td>
			<td align="left"><span class="Estilo1">
			  <?=$ob_reporte->rut_alumno;?>
			</span></td>
			<td align="left"><span class="Estilo1">
			  <?=$ob_reporte->comuna;?>
			</span></td>			
			<td align="center"><span class="Estilo1"><? echo $Curso;?></span></td> 
			<td align="center"><span class="Estilo1"><span style="font:status-bar">
              <?=$ob_reporte->letra_sexo;?>
            </span></span></td>           
			<td align="center"><span class="Estilo1">
			<? impF($ob_reporte->fecha_nacimiento);?>
			</span></td>            
            <td align="center"><span class="Estilo1">
            <? impF($ob_reporte->fecha_matricula);?>
            </span></td>
			<td align="center"><span class="Estilo1">&nbsp;
    		<? impF($ob_reporte->fecha_retiro); ?>
			</span></td>
			<td align="center" class="Estilo1"><?=$ob_reporte->proced_alumno;?>&nbsp; </td>
			<td align="center" class="Estilo1"><?=$ob_reporte->con_quien_vive;?>&nbsp;</td>
			<td align="center" class="Estilo1"><?=$ob_reporte->a_observacion;?>&nbsp;</td>
			<td align="left"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->direccion_alu);?>
			</span></td>
            <td><span class="Estilo1">&nbsp;
              <?=$ob_reporte->tilde($ob_reporte->ape_nombre_apo);?>
            </span></td>
            <td align="left"><span class="Estilo1">&nbsp;
              <?=$ob_reporte->rut_apo;?>
            </span></td>
            <td align="center"><span class="Estilo1">&nbsp;
              <?=$fila['telefono'];?>&nbsp;<?=$fila['celular'];?>
            </span></td>
			<td align="center"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->direccion);?>
			</span></td>
			<td align="center"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->profesion);?>
			</span></td>
			<? if ($_INSTIT==14629){ ?>
			<td align="center"><span class="Estilo1">&nbsp;<? echo $OcuApo;?></span></td>
			<? } ?>
		    <td><span class="Estilo1">
		      <?=$ob_reporte->nivel_edu;?>
		    </span></td>
		    <td> <span class="Estilo1">
		      <?=$edu_padre;?>
		    </span></td>
		    <td> <span class="Estilo1">
		      <?=$edu_madre;?>
		    </span></td>
            
          </tr>
          <? }?>
 </table>
    <?php }?>   </td>
  </tr>
</table>
<? //pg_close($conn);
}

if($tipolibro==5){?>
<table width="100%" border="1" align=center cellpadding="0" cellspacing="0" bordercolor="#999999">
          <tr>
            <td colspan="13" class="textonegrita"><center>
              Datos del Alumno
            </center></td>
            <td colspan="13" class="textonegrita"><center>Apoderado</center></td>
          </tr>
          <tr> 
            <td width="18" align="center" class="detalle">N&ordm;</td>
			<td width="57" align="center" class="detalle">Nº Matrícula</td>
			<td width="30" align="center" class="detalle">RUN</td>
            <td width="78" align="center" class="detalle">ALUMNOS</td>
            <td width="0"  align="center" class="detalle">SEXO</td>	
            <td width="55" align="center" class="detalle">FECHA<br>NAC</td>    		
			<td width="40" align="center" class="detalle">CURSO</td> 
            <td width="55" align="center" class="detalle">FECHA <br>INGRESO</td>
            <td width="84" align="center" class="detalle">DOMICILIO</td>
            <td width="71" align="center" class="detalle">COMUNA</td>
            <td width="60" align="center" class="detalle">FECHA<br>RETIRO</td>
            <td width="60" align="center" class="detalle">MOTIVO RETIRO</td>
            <td width="60" align="center" class="detalle">PROCEDENCIA</td>
            <td width="67" align="center" class="detalle">NOMBRE</td>
            <td width="30" align="center" class="detalle">RUT</td>
            <td width="81" align="center" class="detalle">TELEFONO</td>
			
		<td width="87" align="center" class="detalle">EMAIL</td>
			<? if ($_INSTIT==14629){ ?>
			<td width="81" align="center" class="detalle">OCUPACIÓN</td>
			<? } ?>
            <td width="80" align="center" class="detalle">EDUCACI&Oacute;N</td>
            <td width="80" align="center" class="detalle">NIVEL EDUCACIONAL PADRE</td>
            <td width="80" align="center" class="detalle">NIVEL EDUCACIONAL MADRE</td>
          </tr>
          <?
		for ($j=0; $j < $total_filas; $j++){
			$fila_alu = @pg_fetch_array($resultado_query,$j);
			$ob_reporte ->CambiaDato($fila_alu);
			$retiro="";
		
			if (empty($NumMat)) $NumMat = 0;
			//if (($ob_reporte->cod_decreto==771982) or ($ob_reporte->cod_decreto==461987) or ($ob_reporte->cod_decreto==121987) or ($ob_reporte->cod_decreto==1521989) or ($ob_reporte->cod_decreto==1000) or ($ob_reporte->cod_decreto==1000)){
				/*$ob_reporte->grado =$ob_reporte->grado_curso;
				$ob_reporte->decreto =$ob_reporte->cod_decreto;
				$ob_reporte->CambiaDatoCurso($conn);*/ 
				//$Curso=$ob_reporte->sigla." - ".$ob_reporte->letra_curso." ".$ob_reporte->nombre_tipo;
				/* 	$Curso = CursoPalabra($fila_alu['id_curso'], 1, $conn);
			}else{*/
			
			if($ob_reporte->cod_tipo==10){
				$Curso = CursoPalabra($ob_reporte->id_curso,2,$conn);
			}else{
				$Curso=$ob_reporte->grado_curso." - ".$ob_reporte->letra_curso." ".$ob_reporte->ensenanza;
			}
			//}

			
			//--------------------------------------------------
			$ob_reporte_apo->alumno = $ob_reporte->alumno;
			$result = $ob_reporte_apo ->Apoderado($conn);
			$fila = @pg_fetch_array($result,0);
			$ob_reporte->CambiaDatoApo($fila);
					
					
			if($fila)
			{
				$result_apos = $ob_reporte_apo->Apoderado_all($conn);
					$fila1 = @pg_fetch_array($result_apos,0);
				if($fila1['relacion']==1)
				{
					$edu_padre = $fila1['nivel_edu'];
				}
				elseif($fila1['relacion']==2)
				{
					$edu_madre = $fila1['nivel_edu'];
				}
				
				
				$fila2 = @pg_fetch_array($result_apos,1);
				if($fila2['relacion']==1)
				{
					$edu_padre = $fila2['nivel_edu'];
				}
				elseif($fila2['relacion']==2)
				{
					$edu_madre = $fila2['nivel_edu'];
				}
			
			}else{
				$edu_padre ="-";
				$edu_madre ="-";
				}
			
			
			if ($_INSTIT==14629){
			$OcuApo = $ob_reporte_apo->profesion;
			}
			switch ($ob_reporte->tipo_retiro){
				case 1:
					$retiro = "Cambio de dominicilio";
					break;
				case 2:
					$retiro = "Traslado de establecimiento";
					break;
				case 3:
					$retiro = "Deserción";
					break;
				case 4:
					$retiro = "Motivos de Salud";
					break;
				case 5:
					$retiro = "Otros";
					break;
					
			}
				
			
			
			
		?>
          <tr> 
            <td align="center"><span class="Estilo1"><? echo ($j+1);?></span></td>
			<td align="center"><span class="Estilo1">
			  <?=$ob_reporte->num_matricula;?>
			</span></td>
            <td align="left"><span class="Estilo1">
			  <?=$ob_reporte->rut_alumno;?>
			</span></td>
            <td align="left"><span class="Estilo1">
              <?=//$fila_alu['nombre_alu'];
			  $ob_reporte->tilde($ob_reporte->ape_nombre_alu);?>
            </span></td>
			<td align="center"><span class="Estilo1"><span style="font:status-bar">
              <?=$ob_reporte->letra_sexo;?>
            </span></span></td>
            <td align="center"><span class="Estilo1">
			<? impF($ob_reporte->fecha_nacimiento);?>
			</span></td> 
            <td align="center"><span class="Estilo1"><? echo $Curso;?></span></td>
            <td align="center"><span class="Estilo1">
            <? impF($ob_reporte->fecha_matricula);?>
            </span></td>
            <td align="left"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->direccion_alu);?>
			</span></td>
			<td align="left"><span class="Estilo1">
			  <?=$ob_reporte->comuna;?>
			</span></td>			
			
			           
			           
          
			<td align="center"><span class="Estilo1">&nbsp;
    		<? impF($ob_reporte->fecha_retiro); ?>
			</span></td>
			<td align="center" class="Estilo1"><?=$retiro;?>&nbsp; </td>
			<td align="center" class="Estilo1"><?=$ob_reporte->a_con_quien_vive;?>&nbsp;</td>
			
			
            <td><span class="Estilo1">&nbsp;
              <?=$ob_reporte->tilde($ob_reporte->ape_nombre_apo);?>
            </span></td>
            <td align="left"><span class="Estilo1">&nbsp;
              <?=$ob_reporte->rut_apo;?>
            </span></td>
            <td align="center"><span class="Estilo1">&nbsp;
              <?=$fila['telefono'];?>&nbsp;<?=$fila['celular'];?>
            </span></td>
			<td align="center"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->email_apo);?>
			</span></td>
			<td align="center"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->profesion);?>
			</span></td>
			<td><span class="Estilo1">
		      <?=$ob_reporte->nivel_edu;?>
		    </span></td>
		    <td> <span class="Estilo1">
		      <?=$edu_padre;?>
		    </span></td>
		   
            
          </tr>
          <? }?>
 </table>
<?
}
?>
<? if($tipolibro==6){?>

<table width="100%" border="1" align=center cellpadding="0" cellspacing="0" bordercolor="#999999">
<tr>
<td align="center" class="detalle">Nº Registro</td>
<td align="center" class="detalle">Desc. Grado</td>
<td align="center" class="detalle">Letra</td>
<td align="center" class="detalle">Run</td>
<td align="center" class="detalle">DV</td>
<td align="center" class="detalle">G&eacute;nero</td>
<td align="center" class="detalle">Nombres</td>
<td align="center" class="detalle">Apellido Paterno</td>
<td align="center" class="detalle">Apellido Materno</td>
<td align="center" class="detalle">Dirección</td>
<td align="center" class="detalle">Comuna</td>
<td align="center" class="detalle">Teléfono</td>
<td align="center" class="detalle">Fecha Nacimiento</td>
<td align="center" class="detalle">Fecha Incorporaci&oacute;n</td>
<td align="center" class="detalle">Fecha Retiro</td>
<td align="center" class="detalle">Motivo Retiro</td>

</tr>
<?php for ($j=0; $j < $total_filas; $j++){
			$fila_alu = @pg_fetch_array($resultado_query,$j);
			$ob_reporte ->CambiaDato($fila_alu);
			$ob_reporte->responsable=1;
			$ob_reporte->alumno=$fila_alu['rut_alumno'];
			$rs_apoderado = $ob_reporte->Apoderado($conn);
			$celular =pg_result($rs_apoderado,16);
			$fonoapo =pg_result($rs_apoderado,5);
			
			if($ob_reporte->cod_tipo==10 && $ob_reporte->grado_curso==5){
				$Curso = "KINDER";
			}
			elseif($ob_reporte->cod_tipo==10 && $ob_reporte->grado_curso==4){
				$Curso = "PREKINDER";
			}
			else{
				//$Curso=$ob_reporte->grado_curso." - ".$ob_reporte->letra_curso." ".$ob_reporte->ensenanza;
				$Curso=$ob_reporte->grado_curso;
			}
			
			switch ($ob_reporte->tipo_retiro){
				case 1:
					$retiro = "Cambio de dominicilio";
					break;
				case 2:
					$retiro = "Traslado de establecimiento";
					break;
				case 3:
					$retiro = "Deserción";
					break;
				case 4:
					$retiro = "Motivos de Salud";
					break;
				case 5:
					$retiro = "Otros";
					break;
				default:
					$retiro = "";
					break;
					
			}
			
			?>
<tr>
  <td align="center" class="detalle" height="15"><?=$ob_reporte->num_matricula;?></td>
  <td align="center" class="detalle"><?php echo $Curso ?></td>
  <td align="center" class="detalle"><?php echo strtoupper($ob_reporte->letra_curso) ?></td>
  <td align="center" class="detalle"> <?=$ob_reporte->alumno;?></td>
  <td align="center" class="detalle"><?php echo strtoupper($ob_reporte->ddv) ?></td>
  <td align="center" class="detalle"><?=$ob_reporte->letra_sexo;?></td>
  <td align="left" class="detalle">&nbsp; <?php echo strtoupper($ob_reporte->nombre) ?></td>
  <td align="left" class="detalle">&nbsp;<?php echo strtoupper($ob_reporte->ape_pat) ?></td>
  <td align="left" class="detalle">&nbsp;<?php echo strtoupper($ob_reporte->ape_mat) ?></td>
  <td align="left" class="detalle">&nbsp;<?php echo strtoupper($ob_reporte->direccion_alu) ?></td>
  <td align="center" class="detalle"><?php echo strtoupper($ob_reporte->comuna) ?></td>
  <td align="center" class="detalle"><span class="Estilo1">
   <?=$fila_alu['telefono'];?>&nbsp;<?=$fila_alu['celular'];?>
  </span></td>
  <td align="center" class="detalle"><?=CambioFD($ob_reporte->fecha_nacimiento);?></td>
  <td align="center" class="detalle"><?=CambioFD($ob_reporte->fecha_matricula);?></td>
  <td align="center" class="detalle"><?=CambioFD($ob_reporte->fecha_retiro);?></td>
  <td align="center" class="detalle"><?php echo $retiro ?></td>
</tr>
<?php }?>
</table>
<?php }?>
<? if($tipolibro==7){?>
<table width="100%" border="1" align=center cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr class="detalle">
    <td>N&deg; MAT.</td>
    <td>RUN</td>
    <td>ALUMNO</td>
    <td>SEXO</td>
    <td>FECHA NAC.</td>
    <td>CURSO</td>
    <td>LOCAL</td>
    <td>FECHA MAT.</td>
    <td>DIRECCI&Oacute;N</td>
    <td>NOMBRE APODERADO</td>
    <td>TEL&Eacute;FONO APODERADO</td>
    <td>EMAIL APODERADO</td>
    <td>FECHA RETIRO</td>
    <td>MOTIVO RETIRO</td>
    <td>OBSERVACIONES</td>
  </tr>
  <?php for ($j=0; $j < $total_filas; $j++){
			$fila_alu = @pg_fetch_array($resultado_query,$j);
			$ob_reporte ->CambiaDato($fila_alu);
			
			
			$ob_reporte_apo->alumno = $ob_reporte->alumno;
			$ob_reporte_apo->responsable = 1;
			$result = $ob_reporte_apo ->Apoderado($conn);
			$fila = @pg_fetch_array($result,0);
			$ob_reporte_apo->CambiaDatoApo($fila);
			
			$celular = pg_result($rs_apoderado,5);
			
			if($ob_reporte->cod_tipo==10 && $ob_reporte->grado_curso==5){
				$Curso = "KINDER";
			}
			elseif($ob_reporte->cod_tipo==10 && $ob_reporte->grado_curso==4){
				$Curso = "PREKINDER";
			}
			else{
				$Curso=$ob_reporte->grado_curso." - ".$ob_reporte->letra_curso." ".$ob_reporte->ensenanza;
				
			}
			
			switch ($ob_reporte->tipo_retiro){
				case 1:
					$retiro = "Cambio de domicilio";
					break;
				case 2:
					$retiro = "Traslado de establecimiento";
					break;
				case 3:
					$retiro = "Deserción";
					break;
				case 4:
					$retiro = "Motivos de Salud";
					break;
				case 5:
					$retiro = "Otros";
					break;
				default:
					$retiro = "";
					break;
					
			}
			
			//--------------------------------------------------
			$ob_reporte_apo->alumno = $ob_reporte->alumno;
			$ob_reporte_apo->sostenedor = 1;
			$result = $ob_reporte_apo ->Apoderado($conn);
			$fila = @pg_fetch_array($result,0);
			$ob_reporte->CambiaDatoApo($fila);
					
			
			if ($_INSTIT==14629){
				$OcuApo = $ob_reporte->profesion;
			}else{
				$OcuApo = $ob_reporte->ocupacion;
			}
			
			if ($_INSTIT==9074){
				$ProfApo = $ob_reporte->ocupacion;
			}else{
				$ProfApo = $ob_reporte->profesion;
			}
			
			?>
  <tr style="font:status-bar">
    <td align="center"><span class="Estilo1">
      <?=$ob_reporte->num_matricula;?>
    </span></td>
    <td align="center"><span class="Estilo1">
      <?=$ob_reporte->rut_alumno;?>
    </span></td>
    <td><span class="Estilo1">
      <?=//$fila_alu['nombre_alu'];
			  $ob_reporte->tilde($ob_reporte->ape_nombre_alu);?>
    </span></td>
    <td align="center"><span class="Estilo1">
      <?=$ob_reporte->letra_sexo;?>
    </span></td>
    <td align="center"><span class="Estilo1">
      <? impF($ob_reporte->fecha_nacimiento);?>
    </span></td>
    <td align="center"><span class="Estilo1"><? echo $Curso;?></span></td>
    <td align="center"><span class="Estilo1">
      <?=$ob_reporte->sede;?>
    </span></td>
    <td align="center"><span class="Estilo1">
      <?=CambioFD($ob_reporte->fecha_matricula);?>
    </span></td>
    <td><span class="Estilo1">
      <?=$ob_reporte->tilde($ob_reporte->direccion_alu);?>
    </span></td>
    <td><span class="Estilo1"><?=$ob_reporte->tilde($ob_reporte_apo->ape_nombre_apo);?></span></td>
    <td><span class="Estilo1">
  <?php echo  $ob_reporte->telefono_apo ?>
    &nbsp;<?php echo  $ob_reporte->celular ?>
    </span></td>
    <td><span class="Estilo1">
      <?=$ob_reporte_apo->email_apo;?>
    </span></td>
    <td align="center"><span class="Estilo1">
      <?=CambioFD($ob_reporte->fecha_retiro);?>
    </span></td>
    <td align="center"><span class="Estilo1"><?php echo $retiro ?></span></td>
    <td><span class="Estilo1">
      <?=(strlen($ob_reporte->d_interes)>0 && $ob_reporte->d_interes!="-" && $ob_reporte->d_interes!="Null" && $ob_reporte->d_interes!= "null")?$ob_reporte->d_interes:"";?>
    </span></td>
  </tr>
  <?php }?>
</table>

<?php }
 elseif($tipolibro==8){ ?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999" class="detalle">
  <tr>
    <td>N&deg;</td>
    <td>N&deg; MAT.</td>
    <td>APELLIDO PATERNO</td>
    <td>APELLIDO MATERNO</td>
    <td>NOMBRE</td>
    <td>SEXO</td>
    <td>FECHA DE NACIMIENTO</td>
    <td>EDAD</td>
    <td>RUT</td>
    <td>CURSO</td>
    <td>DOMICILIO</td>
    <td>COMUNA</td>
    <td>COLEGIO DE PROCEDENCIA</td>
    <td>FECHA DE INCORPORACI&Oacute;N</td>
    <td>ESCOLARIDAD PADRE</td>
    <td>ESCOLARIDAD MADRE</td>
    <td>EL ALUMNO VIVE CON</td>
    <td>NOMBRE APODERADO</td>
    <td>DIRECCION APODERADO</td>
    <td>TELEFONO APODERADO</td>
   
  </tr>
   <?
		for ($j=0; $j < $total_filas; $j++){
			$fila_alu = @pg_fetch_array($resultado_query,$j);
			$ob_reporte ->CambiaDato($fila_alu);
			$retiro="";
		
			if (empty($NumMat)) $NumMat = 0;
			//if (($ob_reporte->cod_decreto==771982) or ($ob_reporte->cod_decreto==461987) or ($ob_reporte->cod_decreto==121987) or ($ob_reporte->cod_decreto==1521989) or ($ob_reporte->cod_decreto==1000) or ($ob_reporte->cod_decreto==1000)){
				/*$ob_reporte->grado =$ob_reporte->grado_curso;
				$ob_reporte->decreto =$ob_reporte->cod_decreto;
				$ob_reporte->CambiaDatoCurso($conn);*/ 
				//$Curso=$ob_reporte->sigla." - ".$ob_reporte->letra_curso." ".$ob_reporte->nombre_tipo;
				/* 	$Curso = CursoPalabra($fila_alu['id_curso'], 1, $conn);
			}else{*/
			
			if($ob_reporte->cod_tipo==10){
				$Curso = CursoPalabra($ob_reporte->id_curso,2,$conn);
			}else{
				$Curso=$ob_reporte->grado_curso." - ".$ob_reporte->letra_curso." ".$ob_reporte->ensenanza;
			}
			//}

			
			//--------------------------------------------------
			$ob_reporte_apo->alumno = $ob_reporte->alumno;
			$result = $ob_reporte_apo ->Apoderado($conn);
			$fila = @pg_fetch_array($result,0);
			$ob_reporte->CambiaDatoApo($fila);
					
					
			if($fila)
			{
				$result_apos = $ob_reporte_apo->Apoderado_all($conn);
					$fila1 = @pg_fetch_array($result_apos,0);
				if($fila1['relacion']==1)
				{
					$edu_padre = $fila1['nivel_edu'];
				}
				elseif($fila1['relacion']==2)
				{
					$edu_madre = $fila1['nivel_edu'];
				}
				
				
				$fila2 = @pg_fetch_array($result_apos,1);
				if($fila2['relacion']==1)
				{
					$edu_padre = $fila2['nivel_edu'];
				}
				elseif($fila2['relacion']==2)
				{
					$edu_madre = $fila2['nivel_edu'];
				}
			
			}else{
				$edu_padre ="-";
				$edu_madre ="-";
				}
			
			
			if ($_INSTIT==14629){
			$OcuApo = $ob_reporte_apo->profesion;
			}
			switch ($ob_reporte->tipo_retiro){
				case 1:
					$retiro = "Cambio de dominicilio";
					break;
				case 2:
					$retiro = "Traslado de establecimiento";
					break;
				case 3:
					$retiro = "Deserción";
					break;
				case 4:
					$retiro = "Motivos de Salud";
					break;
				case 5:
					$retiro = "Otros";
					break;
					
			}
				
			
			
			
		?>
  <tr>
    <td><span class="Estilo1"><? echo ($j+1);?></span></td>
    <td><span class="Estilo1">
      <?=$ob_reporte->num_matricula;?>
    </span></td>
    <td><?php echo strtoupper($fila_alu['ape_pat']) ?></td>
    <td><?php echo strtoupper($fila_alu['ape_mat']) ?></td>
    <td><?php echo strtoupper($fila_alu['nombre_alu']) ?></td>
    <td><span class="Estilo1">
      <?=$ob_reporte->letra_sexo;?>
    </span></td>
    <td><span class="Estilo1">
      <? impF($ob_reporte->fecha_nacimiento);?>
    </span></td>
    <td><?php echo edad($ob_reporte->fecha_nacimiento,$ob_membrete ->nro_ano."-03-31") ?></td>
    <td><span class="Estilo1">
      <?=$ob_reporte->rut_alumno;?>
    </span></td>
    <td><span class="Estilo1"><? echo $Curso;?></span></td>
    <td><span class="Estilo1">
      <?=$ob_reporte->tilde($ob_reporte->direccion_alu);?>
    </span></td>
    <td><span class="Estilo1">
      <?=$ob_reporte->comuna;?>
    </span></td>
    <td><?php echo strtoupper($fila_alu['c_procedencia']) ?></td>
    <td><span class="Estilo1">
      <? impF($ob_reporte->fecha_matricula);?>
    </span></td>
    <td><span class="Estilo1">
      <?=$edu_padre;?>
    </span></td>
    <td><span class="Estilo1">
      <?=$edu_madre;?>
    </span></td>
    <td><?php echo strtoupper($fila_alu['cq_vive']) ?></td>
    <td>
      <?=$ob_reporte->tilde($ob_reporte->ape_nombre_apo);?>
   </td>
    <td><span class="Estilo1">
      <?=$ob_reporte->tilde($ob_reporte->direccion);?>
    </span></td>
    <td><span class="Estilo1">
     
      <?=$ob_reporte->telefono_apo?>
    &nbsp;<?=$ob_reporte->celular?>
    </span></td>
  </tr>
  <?php }?>
</table>

<?php  } ?>
</center>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 $concur=0;
		 include("firmas/firmas.php");?>

 <!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->
								 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

       
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</body>
</html>
<? pg_close($conn);?>