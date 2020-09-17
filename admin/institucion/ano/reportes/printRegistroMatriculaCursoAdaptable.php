<?php

require_once("../../../../util/header.inc");

require_once('../../../clases/class_Reporte.php');
require_once('../../../clases/class_Membrete.php');


	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente
	//echo $ocupacion;
	if ($curso==0){
	  ##  no hace nada
	}else{
		$fecha1 		= $anoN."-04-30"; 

	
	
	$ob_reporte = new Reporte();
	$ob_reporte -> ano = $ano;
	$ob_reporte -> curso =$curso;
	$ob_reporte -> institucion = $institucion;
	$ob_reporte -> AnoEscolar($conn);
	if($institucion==769){
		$ob_reporte -> cargo =23;
		$result =$ob_reporte -> EmpleadoCargo($conn);
		$nombre_dire = pg_result($result,2);
	}else{
		$ob_reporte -> cargo =1;
		$result = $ob_reporte -> EmpleadoCargo($conn);
		$nombre_dire = pg_result($result,2);
	}
	$ob_reporte ->DecretoCurso($conn);
	
	$ob_membrete = new Membrete();
	$ob_membrete -> ano = $ano;
	$ob_membrete -> institucion = $institucion;
	$ob_membrete -> institucion($conn);
	
	
   }	
	$ob_reporte ->orden = $orden;
	$resultado_query= $ob_reporte->AlumnoCurso($conn);
	$total_filas= @pg_numrows($resultado_query);
 
 //-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	/*****************CURSO******************************************/
	 $nombre_curso= CursoPalabra($cmb_curso,0,$conn);


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
function enviapag2(form){
		form.target="_blank";
		form.action=='printRegistroMatriculaCurso_C.php?cmb_curso=<?=$curso?>&ocupacion=<?=$ocupacion?>';
		form.submit(true);
}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
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
</script></head>

</script>

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>
<body>
<form name="form" action="printRegistroMatriculaCurso_C.php?cmb_curso=<?=$curso?>&ocupacion=<?=$ocupacion?>" method="post">
<?
if ($curso != 0){
?>
<table width="1024" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="capa0">
		<div align="right"> <font face="Arial, Helvetica, sans-serif" size="-1">Imprimir Horizontal</font>
		  <input name="button3" TYPE="button" class="botonXX" onClick="imprimir()" value="IMPRIMIR">	
  		</div>
	</div>	</td>
    <td><input name="exp" TYPE="button" class="botonXX" onClick="enviapag2(this.form)" value="EXPORTAR"></td>
  </div>	
  </tr>
  
  <tr>
    <td colspan="2">
	
	
	<? if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br>";
       }
       ?>	
	
      <table width="100%" height="132" border="0" >
        <tr>
          <td width="184" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>DECRETO EVALUADOR </strong></font></td>
          <td width="185" align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_reporte->nombre_decreto; ?></font></td>
          <td colspan="11" align="left">&nbsp;</td>
          <td width="121" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>REGION</strong></font></td>
          <td width="252" align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->region;?></font></td>
        </tr>
        <tr>
          <td> <div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>DIRECTOR - RECTOR </strong></font></div></td>
          <td colspan="12"> <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<? echo $ob_reporte->tildeM(strtoupper($nombre_dire)); ?></font></div></td>
          <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>PROVINCIA</strong></font></div></td>
          <td>
            <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->provincia;?></font></div></td>
        </tr>
        <tr>
          <td ><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>ESTABLECIMIENTO EDUCACIONAL </strong></font></div></td>
          <td ><div align="left"> <font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->ins_pal; ?></font></div></td>
		            <td colspan="11" align="left">&nbsp;</td>
          <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>COMUNA</strong></font></div></td>
          <td>
            <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->comuna;?></font></div></td>
        </tr>
        <tr>
            <td><font face="Arial, Helvetica, sans-serif" size="1"><strong>ROL BASE 
              DE DATOS</strong></font></td>
            <td><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<? echo $institucion." - ".$ob_membrete->dig_rdb;?></font></td>
		            <td colspan="11" align="left">&nbsp;</td>
          <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>A&Ntilde;O ESCOLAR </strong></font></div></td>
          <td class="Estilo13 Estilo17"><div align="left"> <font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_reporte->nro_ano; ?></font></div></td>
        </tr>
        <tr>
          <td><font face="Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="1"><?=$nombre_curso?></font></td>
		            <td colspan="11" align="left">&nbsp;</td>
          <td class="Estilo12 Estilo18"><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"></font></div></td>
          <td class="Estilo13 Estilo17"><div align="left"></div></td>
        </tr>
        <tr>
          <td height="16" colspan="15" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><strong>LIBRO DE REGISTRO DE MATR&Iacute;CULA </strong></font></td>
        </tr>
      </table>
      <table width="100%" border="1" align=center cellpadding="0" cellspacing="1" bordercolor="#999999" style="border-collapse:collapse">
        <tr>
          <td colspan="9" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Datos del Alumno</strong></font> </td>
          <td align="center" bgcolor="#999999" >&nbsp;</td>
          <td colspan="22" align="center" bgcolor="#999999" ><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Datos del Tutor</strong></font> </td>
        </tr>
        <tr>
          <td width="19" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>N&ordm;</strong></font></td>
          <?
          	if($n_matricula==1){
		  ?>
          <td width="20" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>N&ordm;&nbsp;DE&nbsp;MAT &nbsp;</strong></font></td>
          <?
			}
		  ?>
          <td width="100" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>NOMBRE&nbsp;</strong></font></td>
          <?
          	if($sexo==1){
		  ?>
          <td width="25" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>SEXO&nbsp;</strong></font></td>
           <?
			}
		  ?>
           <?
          	if($rut_==1){
		  ?>
          <td width="65" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>RUN&nbsp;</strong></font></td>
          <?
			}
		  ?>
          <?
          	if($fecha_n_==1){
		  ?>
          <td width="44" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>FECHA&nbsp;NAC&nbsp;</strong></font></td>
          <?
			}
		  ?>
          
           <?
          if($comuna==1){
		  ?>
          <td width="93" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>COMUNA&nbsp;</strong></font></td>
          <?
			}
		  ?>
          
          <?
          if($domicilio==1){
		  ?>
          <td width="93" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>DOMICILIO&nbsp;</strong></font></td>
          <?
			}
		  ?>
           <?
          if($fecha_mat==1){
		  ?>
          <td width="57" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>FECHA&nbsp;INGRESO&nbsp; </strong></font></td>
          <?
		  }
		  ?>
           <?
          if($curso_rep==1){
		  ?>
          <td width="57" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>HA&nbsp;REPETIDO CURSO&nbsp;</strong></font></td>
          <?
		  }
		  ?>
          
          <?
          if($c_vive==1){
		  ?>
          <td width="57" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>VIVE&nbsp;CON&nbsp;</strong></font></td>
          <?
		  }
		  ?>
           <?
          if($inf_salud==1){
		  ?>
          <td width="57" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>INFO&nbsp;SALUD&nbsp;</strong></font></td>
          <?
		  }
		  ?>
          
          <?
          if($d_Interes==1){
		  ?>
          <td width="57" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>DATOS&nbsp;INTERES&nbsp;</strong></font></td>
          <?
		  }
		  ?>
          
          
          
          
          <td width="8" rowspan="<? echo $total_filas + 1?>" align="center" bgcolor="#999999">&nbsp;</td>
          <?
          	if($padre==1){
		  ?>
          <td width="114" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>PADRE&nbsp;</strong></font></td>
          <?
			}
		  ?>
           <?
          	if($madre==1){
		  ?>
          <td width="114" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>MADRE&nbsp;</strong></font></td>
          <?
			}
		  ?>
          <? if($tutor==1){ ?>
          <td width="114" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>TUTOR&nbsp;</strong></font></td>
          <? } ?>
          
          <? if($prof_tutor=="1"){?>
          <td width="88" align="center" bgcolor="#999999"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PROFESI&Oacute;N&nbsp;</font></strong></td>
		  <? }?>
		  
		  <? if($ocu_tutor=="1"){?>
          <td width="88" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>OCUPACI&Oacute;N&nbsp;</strong></font></td>
		  <? }?>
   		  <? if($email_apo=="1"){?>
          <td width="88" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>EMAIL</strong></font></td>
          <? }?>
  		  <? if($fono_recado=="1"){?>
          <td width="88" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>CELULAR</strong></font></td>
          <? }?>
            <? if($dir_tutor==1) { ?>
		  <td width="96" align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>DOMICILIO&nbsp;</strong></font></td>
          <? }?>
            <? if($fono_tutor==1) { ?>
          <td align="center" bgcolor="#999999"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>FONO&nbsp;</strong></font></td>
          <? }?>
        </tr>
        <?

		for ($j=0; $j < $total_filas; $j++){
			$fila = pg_fetch_array($resultado_query,$j);
			$ob_reporte->CambiaDato($fila);

			if (empty($NumMat)) $NumMat = 0;
			
			/*if (($ob_reporte->cod_decreto==771982) or ($ob_reporte->cod_decreto==461987) or ($ob_reporte->cod_decreto==121987) or ($ob_reporte->cod_decreto==1521989) or ($ob_reporte->cod_decreto==1000) or ($ob_reporte->cod_decreto==1000)){
				$ob_reporte->grado =$ob_reporte->grado_curso;
				$ob_reporte->decreto =$ob_reporte->cod_decreto;
				$ob_reporte->CambiaDatoCurso($conn);
				$Curso=$ob_reporte->sigla." - ".$ob_reporte->letra_curso." ".$ob_reporte->nombre_tipo;
				
			}else{*/
			//echo "curso".$ob_reporte->id_curso;
				if($ob_reporte->cod_tipo==10){
				$Curso = CursoPalabra($ob_reporte->id_curso,0,$conn);
			}else{
			    $Curso = CursoPalabra($ob_reporte->id_curso,2,$conn);
				//$Curso=$ob_reporte->grado_curso." - ".$ob_reporte->letra_curso." ".$ob_reporte->ensenanza;
			}
			//}

			
			//--------------------------------------------------
			$rut_alumno =$ob_reporte->alumno;
			$result = $ob_reporte ->Apoderado($conn);
			$fila = @pg_fetch_array($result,0);
			$ob_reporte->CambiaDatoApo($fila);
			
			if ($_INSTIT==14629){ //AGREGADO TEMPORALMENTE
			$OcuApo = $profeApo;
			}
		?>
        <tr>
          <td align="center" class="subitem"><?	echo ($j+1);?></td>
          <?
          if($n_matricula==1){
		  ?>
          <td align="center" class="subitem"><?	echo $ob_reporte->num_matricula;?></td>
          <?
		  }
		  ?>
          <td align="left" class="subitem"><?	echo $ob_reporte->tilde($ob_reporte->ape_nombre_alu);	?>          </td>
           <?
          	if($sexo==1){
		  ?>
          <td align="center" class="subitem"><?	echo $ob_reporte->letra_sexo;?></td>
          <?
			}
		  ?>
           <?
          	if($rut_==1){
		  ?>
          <td align="left" class="subitem"><?	echo $ob_reporte->rut_alumno;?></td>
          <?
			}
		  ?>
           <?
          	if($fecha_n_==1){
		  ?>
          <td align="center" class="subitem"><?	impF($ob_reporte->fecha_nacimiento);?></td>
          <?
			}
		  ?>
          
          <?
          if($comuna==1){
		  ?>
          <td align="left" class="subitem"><?	echo $ob_reporte->tilde($ob_reporte->comuna);?></td>
          <?
			}
		  ?>
          
          <?
          if($domicilio==1){
		  ?>
          <td align="left" class="subitem"><?	echo $ob_reporte->tilde($ob_reporte->direccion_alu);?></td>
          <?
			}
		  ?>
           <?
          if($fecha_mat==1){
		  ?>
          <td align="center" class="subitem"><?	impF($ob_reporte->fecha_matricula);?></td>
          <?
		  }
		  ?>
          
           <?
          if($curso_rep==1){
		  ?>
          <td align="center" class="subitem"><?	echo($ob_reporte->curso_rep);?></td>
          <?
		  }
		  ?>
          
          <?
          if($c_vive==1){
		  ?>
          <td align="center" class="subitem"><? echo 	($ob_reporte->con_quien_vive!='null' && $ob_reporte->con_quien_vive!='-' && strlen($ob_reporte->con_quien_vive)>0)?$ob_reporte->con_quien_vive:"-";?></td>
          <?
		  }
		  ?>
          
           <?
          if($inf_salud==1){
		  ?>
          <td align="center" class="subitem"><? echo ($ob_reporte->inf_salud!='null' && $ob_reporte->inf_salud!='-' && strlen($ob_reporte->inf_salud)>0 && $ob_reporte->inf_salud!='Null')?$ob_reporte->inf_salud:"-";?></td>
          <?
		  }
		  ?>
          
          <?
          if($d_Interes==1){
		  ?>
          <td align="center" class="subitem"><? echo ($ob_reporte->d_interes!='null' && $ob_reporte->d_interes!='-' && strlen($ob_reporte->d_interes)>0 && $ob_reporte->d_interes!='Null')?$ob_reporte->d_interes:"-";?></td>
          <?
		  }
		  ?>
          
          <? if($padre==1){
		  
		  ?>
          <td align="left" class="subitem"><?	
		  if($ob_reporte->rel_apo==1){
		  echo $ob_reporte->tilde($ob_reporte->ape_nombre_apo);
		  }else{
			echo" ";  
		  }
		  ?></td>
          <?
		   
		  }
		  ?>
          
           <? if($madre==1){
			  
		  ?>
          <td align="left" class="subitem"><?
		  	 if($ob_reporte->rel_apo==2){
		  	echo $ob_reporte->tilde($ob_reporte->ape_nombre_apo);
			}else{
			echo" ";	
			}
			?></td>
          
          <?
			 
		  }
		  ?>
          
          <? if($tutor==1){
			 
		  
		  ?>
          <td align="left" class="subitem">
		  <?	
		   if($ob_reporte->responsable==1){
		  echo $ob_reporte->tilde($ob_reporte->ape_nombre_apo);
		  }else{
			echo" ";  
		  }
		  ?>
          </td>
          <?
			  
		  }
		  ?>
          <? if($prof_tutor == 1){?>
          <td align="left" class="subitem"><? 
			if ($ob_reporte->profesion!=null){
			echo $ob_reporte->profesion ;} else { echo "&nbsp;";}?></td>
            <? }?>
            
          <? if($ocu_tutor == 1){?>
		  <td align="left" class="subitem"><? 
			if ($ob_reporte->ocupacion!=null){
			echo $ob_reporte->ocupacion;} else { echo "&nbsp;";}?>         
		  </td>
		  <? }?>
          
          <? if($email_apo==1) { ?>
          <td align="left" class="subitem">&nbsp;<?	echo $ob_reporte->email_apo;	?></td>
          <? }?>
          <? if($fono_recado==1) { ?>
          <td align="left" class="subitem">&nbsp;<?	echo $ob_reporte->celular;	?></td>
          <? }?>
          <? if($dir_tutor==1) { ?>
          <td align="left" class="subitem"><?	echo $ob_reporte->tilde($ob_reporte->direccion);?></td>
		  <? }?>
           <? if($fono_tutor==1) { ?>
          <td align="left" class="subitem"><?	echo $ob_reporte->telefono_apo;	?>&nbsp; </td>
          <? }?>
        </tr>
        <? }?>
      </table></td>
  </tr>
</table>
<? } ?>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
</form>
</body>
</html>
<? pg_close($conn);?>