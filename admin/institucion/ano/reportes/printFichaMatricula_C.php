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
	$curso			= $cmb_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		=$_FRMMODO;
	$alumno			=$alumno;
	$reporte		= $c_reporte;	


$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
$ob_membrete ->institucion = $institucion;
$ob_membrete ->institucion($conn);

if ($alumno!=0){
	$ob_reporte->ano = $ano; 
	$ob_reporte->alumno = $alumno;
	$result_home=$ob_reporte->FichaAlumnoUno_fichamat($conn);
}
if(($alumno==0)&&($cmb_curso!=0)){
	$ob_reporte->ano =$ano;
	$ob_reporte->curso = $cmb_curso;
	$ob_reporte->retirado= 0;
	$result_home=$ob_reporte->FichaAlumnoTodos($conn);
}

/*if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Ficha_Matricula_$Fecha.xls"); 
	
}*/	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
	<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{
page-break-after:always;
}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px;}
-->
    </style>
	
<SCRIPT language="JavaScript">
			function enviapag2(form){
					form.target="_blank";
					alert("aki");
		   			form.action='printFichaMatricula_C.php?alumno=<?=$alumno?>&cmb_curso=<?=$curso?>';
					form.submit(true);
		  	}
			function enviapag(form){
			if (document.form.cmb_curso.value!=0){				
				document.form.action = "ficha_matricula.php3";
				document.form.submit();
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
		function envia(){
			document.form.action="ficha_matricula.php3";
			document.form.ssww.value=1;
			document.form.submit();
		}	
									
	function imprimir() 
{
	document.getElementById("layer2").style.display='none';
	window.print();
	document.getElementById("layer2").style.display='block';


}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" action="printFichaMatricula_C.php" name="form">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="0%" height="1024" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="1024" valign="top"><table width="100%">
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 

                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr> 
                                  <td valign="top">
								  
								

<!-- INICIO CUERPO DE LA PAGINA -->

<? if ((pg_numrows($result_home)>0) ){?>
<div id="layer2">
<table width="739"><tr><td align="right">
<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td>
<? if($_PERFIL == 0){?>
    <td align="right"><input name="exp" TYPE="button" class="botonXX" onClick="enviapag2(this.form)" value="EXPORTAR"></td>
<? }?>
</tr></table>
</div>
<?
	if($op_opcion==1){
for ($i=0;$i<pg_numrows($result_home);$i++){
$fila=pg_fetch_array($result_home);
$ob_reporte->CambiaDato($fila);
?>
	
<? if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br><br><br>";
  }
?>	
	
<table width="640" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td>
		<table>
			<tr><td><FONT face="arial, geneva, helvetica" size=2><strong>
			  <?php echo $ob_membrete->ins_pal; ?>
			</strong></FONT></td>
			</tr>
			<tr>
			  <td><?php echo $ob_membrete->comuna;?></td>
			</tr>
		</table>	</td>
	<td>
	<table align="right">
		<tr><td>CURSO</td><td>
		  <?php $ob_membrete ->curso = $cmb_curso;
		  		$ob_membrete ->curso($conn);
				echo $ob_membrete->grado_curso."º".$ob_membrete->letra_curso;	
		  ?>
		</td><td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
		<tr><td>NIVEL</td>
		<td><? echo $ob_membrete->ensenanza;?></td>
		</tr>
		<tr><td>AÑO PROMOCION</td>
		<td>
		<?
			$ob_membrete->ano = $ano;
			$ob_membrete->AnoEscolar($conn);
			echo $ob_membrete->nro_ano;
		?>
		</td>
		</tr>		
	</table>	       </td>
  </tr>
  <tr><td colspan="2">
	  <table align="center"><tr>
	    <td><b>FICHA DE MATRICULA</b> </td>
	  </tr></table>
  </td></tr>
   <tr><td colspan="2">
	  <table  width="100%"><tr><td><?=$ob_reporte->num_matricula;?><br>
	  Nº de Matricula</td><td align="right"><br>
	  <table width="1%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td nowrap>&nbsp;<?=impF($ob_reporte->fecha_matricula);?></td>
		  <td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td nowrap class="Estilo4">Fecha de Matr&iacute;cula</td>
        </tr>
      </table>
	  </tr></table>
  </td></tr>
  <tr><td colspan="2"><b><br>
    DATOS ALUMNO<br>
    <br>
  </b></td>
  </tr>
  <tr>
	  <td colspan="2">
	  	<table width="100%">
			<tr>
				<td valign="bottom"><b><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_pat))); ?></b><br>
			    Apellido paterno </td>
				<td valign="bottom"><b><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_mat)));?></b><br>
			    Apellido Materno </td>
				<td valign="bottom"><b><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->nombre)));?></b><br>
			    Nombre</td>
			</tr>
			<tr>
			  <td valign="bottom">
			  
<b>			    <?php impF($ob_reporte->fecha_nacimiento);?>
</b><bR>
			  Fecha de Nacimiento </td>
			  <td valign="bottom"><b><?=$ob_reporte->rut_alumno;?></b><br>
		      RUN</td>
			  <td valign="bottom"><b><?=$ob_reporte->salud;?></b><br>Isapre</td>
		  </tr>
		</table>	  </td>
  </tr>
  <tr>
  	<td colspan="2"><table width="100%">
  	  <tr><td>
	  <b>
  	    <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->direccion_alu)));?>
		<? if (trim($ob_reporte->depto)!=""){
			echo "DPTO $ob_reporte->depto";
		}?>
		<? if (trim($ob_reporte->block)!=""){
			echo "&nbsp;BLOCK $ob_reporte->block";
		}?>
		<? if (trim($ob_reporte->villa)!=""){
			echo "&nbsp;VILLA $ob_reporte->villa";
		}?>
		</b>
<br>Direccion</td>
  	  <td><b><?=$ob_reporte->comuna;?></b>
			<br>Comuna</td>
  	  <td><b><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->provincia)));?></b><br>Ciudad</td>
  	  </tr>
      
      </table></td>
  </tr>
  
  <tr>
        <td colspan="2"><b><br>
          BECAS ALUMNO   </b></td>
      </tr>
      <tr>
        <td colspan="2">
			
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->bool_baj)));?><br>
				________________ <br>
                Alimentación Junaeb </td>
              <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_cpadre;?><br>
				___________<br>
                C. de Padres</td>
              <td><br>&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_seg;?><br>
				______<br>
                Seguro</td>
              <td><br>&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_otros?><br>
				&nbsp;&nbsp;_____<br>
                &nbsp;&nbsp;Otras </td>
              <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_bchs?><br>
				&nbsp;&nbsp;_____________<br>
                &nbsp;&nbsp;Chile Solidario </td>
                <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_mun?><br>
				_________<br>
                Municipal </td>
                <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->ben_sep?><br>
				_________<br>
                Alumno SEP </td>
                <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_fci?><br>
				_____________________________________<br>
                Financiamiento Compartido de la Intitución </td>
            </tr>
			
        </table></td>
      </tr>
  
<tr><td colspan="2"><b><br>
  DATOS PADRES<br>
</b></td>
</tr>
<tr>
	<td colspan="2">
	<table width="100%">
	<?
	$rut_alumno =$ob_reporte->alumno;
	$ob_reporte->alumno=$rut_alumno;
	$result_apo=$ob_reporte->Apoderado($conn);
		
		
	if ($result_apo > 0){
	
			for ($i = 0; $i < @pg_numrows($result_apo); $i++){
				 $fil_1 = @pg_fetch_array($result_apo,$i);
				 $ob_reporte->CambiaDatoApo($fil_1);
				 
				 /*$sexo_apo   = $fil_1['sexo'];
				 $nombre_apo  = $fil_1['nombre_apo'];
				 $paterno_apo = $fil_1['ape_pat'];
				 $materno_apo = $fil_1['ape_mat'];
				 $rut_apo_apo = $fil_1['rut_apo'];
				 $dig_rut_apo = $fil_1['dig_rut'];	
				 $profesion_apo = $fil_1['profesion'];	
				 $nivel_edu_apo = $fil_1['nivel_edu'];
				 $nivel_social_apo = $fil_1['nivel_social'];	*/
				 ?>
				<tr>
				<td><br>
				 <? if ($ob_reporte->nombre_apo!=NULL){ echo $ob_reporte->tilde(ucfirst(strtolower($ob_reporte->nombre))); }else{ ?>  _____________________ <? } ?><br>
				  Nombre  </td>
				<td><br>
				 <? if ($ob_reporte->rut_apo!=NULL){ echo $ob_reporte->rut_apo; }else{ ?> ____________ <? } ?><br>
				  RUN</td>
				<td><br>
				 <? if ($ob_reporte->profesion!=NULL){ echo$ob_reporte->profesion; }else{ ?> _________________ <? } ?><br>
				  Profesion</td>
				<td><br>
				 <? if ($ob_reporte->nivel_edu!=NULL){ echo $ob_reporte->nivel_edu; }else{ ?> _________________ <? } ?><br>
				  Nivel Educacion </td>
				<td><br>
				 <? if ($ob_reporte->nivel_social!=NULL){ 
						 switch ($ob_reporte->nivel_social) {
							 case 0:
								 imp('INDETERMINADO');
								 break;
							case 1:
								 imp('0-100.000');
								 break;
							case 2:
								 imp('100.000-200.000');
								 break;
							case 3:
								 imp('200.000-300.000');
								 break;
							case 4:
								 imp('300.000-400.000');
								 break;
							case 5:
								 imp('400.000-500.000');
								 break;
							case 6:
								 imp('500.000-600.000');
								 break;
							case 7:
								 imp('600.000-700.000');
								 break;	
							case 8:
								 imp('700.000-800.000');
								 break;
								 
							case 9:
								 imp('800.000-900.000');
								 break;	
							case 10:
								 imp('900.000-1.000.000');
								 break;	  	 
							case 11:
								imp('Mas de 1.000.000')	;
								break;	 	 	 
						 };
				  }else{ ?> _____________ <? } ?><br>
				  Renta</td>
				  </tr>
			<? }		  
	  }else{ ?>
	  
	  
			  <tr>
				<td><br>
				 <? if ($madre_nombre!=NULL){ echo "$madre_paterno $madre_nombre"; }else{ ?>  _____________________ <? } ?><br>
				  Nombre Madre </td>
				<td><br>
				 <? if ($madre_rut_apo!=NULL){ echo "$madre_rut_apo-$madre_dig_rut"; }else{ ?>  ____________ <? } ?><br>
				  RUN</td>
				<td><br>
				 <? if ($madre_profesion!=NULL){ echo $madre_profesion; }else{ ?> _________________ <? } ?><br>
				  Profesion</td>
				<td><br>
				 <? if ($madre_nivel_edu!=NULL){ echo $madre_nivel_edu; }else{ ?> _________________ <? } ?><br>
				  Nivel Educacion </td>
				<td><br>
				 <? if ($madre_nivel_social!=NULL){ 
						switch ($madre_nivel_social) {
							 case 0:
								 imp('INDETERMINADO');
								 break;
							case 1:
								 imp('0-100.000');
								 break;
							case 2:
								 imp('100.000-200.000');
								 break;
							case 3:
								 imp('200.000-300.000');
								 break;
							case 4:
								 imp('300.000-400.000');
								 break;
							case 5:
								 imp('400.000-500.000');
								 break;
							case 6:
								 imp('500.000-600.000');
								 break;
							case 7:
								 imp('600.000-700.000');
								 break;	
							case 8:
								 imp('700.000-800.000');
								 break;
								 
							case 9:
								 imp('800.000-900.000');
								 break;	
							case 10:
								 imp('900.000-1.000.000');
								 break;	  	 
							case 11:
								imp('Mas de 1.000.000')	;
								break;	 	 	 
						 };
				  }else{ ?> _____________ <? } ?><br>
				  Renta</td>
				</tr>
	<? } ?>
	
	
	
	
	
	</table></td>
</tr>
<tr><td colspan="2">
    <table width="40%" align="right">
		<tr>
			<td width="40%">Relacion padres</td>
			<td width="40%"><table width="1%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td nowrap>Vivienda propia </td>
                <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <tr><td>&nbsp;&nbsp;&nbsp;</td></tr></table></td>
              </tr>
              <tr>
                <td nowrap>Vivienda Arrendada&nbsp;&nbsp; </td>
                <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td nowrap>Vivienda Cedida </td>
                <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>

 </td>
</tr>
<tr><td colspan="2"><b><br>
  DATOS APODERADOS<br>
  <br> 
</b></td>
</tr>
<tr>
	<td colspan="2">
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
		
	?>
		<table width="30%" border="0" cellpadding="1" cellspacing="0">
			<tr>
				<td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td><? if ($ob_reporte->sexo==2){ ?>&nbsp;*&nbsp;<? }else{ ?>&nbsp;&nbsp;&nbsp;<? } ?></td>
                  </tr>
                </table></td>
				<td>Padre</td>
				<td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td><? if ($ob_reporte->sexo==1){ ?>&nbsp;*&nbsp;<? }else{ ?>&nbsp;&nbsp;&nbsp;<? } ?></td>
                  </tr>
                </table></td>
				<td>Madre</td>
				<td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                </table></td>
				<td>Otro</td>
			</tr>
	  </table>	</td>
</tr>
<tr><td colspan="2"><table width="100%">
  <tr>
    <td><br>
      <? if ($ob_reporte->nombre_apo!=NULL){ echo $ob_reporte->ape_nombre_apo; }else{ ?> _____________________ <? } ?><br>
      Nombre</td>
    <td><br>
      <? if ($ob_reporte->rut_apo!=NULL){ echo $ob_reporte->rut_apo; }else{ ?> ____________ <? } ?><br>
      RUN</td>
    <td><br>
      <? if ($ob_reporte->direccion!=NULL){ echo $ob_reporte->direccion; }else{ ?> ___________________________________ <? } ?><br>
      Direccion</td>
    <td><br>
      <? if ($ob_reporte->comuna!=NULL){ echo $ob_reporte->comuna; }else{ ?>  ___________ <? } ?><br>
      Comuna</td>
   </tr>
   
</table></td></tr>
<tr><td colspan="2"><table width="100%">
  <tr>
    <td width="20%"><br>
      <? if ($ob_reporte->telefono_apo!=NULL){ echo $ob_reporte->telefono_apo; }else{ ?> ____________ <? } ?><br>
      Telefono</td>
    <td width="20%"><br>
      <? if ($ob_reporte->celular!=NULL){ echo $ob_reporte->celular; }else{ ?> ____________ <? } ?><br>
      Celular</td>
    <td width="20%"><br>
      ____________<br>
      Telefono Recados </td>
    <td width="20%"><br>
      ____________<br>
      Fax</td>
    <td width="20%"><br>
      <? if ($ob_reporte->email_apo!=NULL){ echo $ob_reporte->email_apo; }else{ ?> ____________ <? } ?><br>
      E-mail</td>
  </tr>
</table></td></tr>
<tr><td cols&npan="2"><b><br>
  OTROS<br>
</b></td></tr>
<tr>
	<td colspan="2">
		<table>
			<tr>
				<td>Autoriza religion Catolica (anual)</td>
				<td>
					<table><tr><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td>
					<td>SI</td>
					<td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td>
					<td>NO</td>
					</tr></table>				</td>
			</tr>
		</table></td>
</tr>
<tr>
  <td colspan="2"><br>
    Tiene algun problema de salud significativo __________________________________________________________________________________<br></td></tr>
<tr><td colspan="2"><table width="100%">
    <tr>
      <td valign="bottom"><br>
        ___________________________<br>
        N&ordm; Boleta C.G.P.A </td>
      <td valign="bottom"><br>
        __________________________<br>
        Monto Cancelado </td>
      <td valign="bottom"><br>
        ______________<br>
        Fecha Cancelacion </td>
    </tr>

  </table></td></tr>
  <tr><td colspan="2">&nbsp;</td></tr>
<tr>
	<td colspan="2">
	<table width="70%">
		<tr>
			<td valign="top">Solicita</td>
			<td valign="top" nowrap>1.- Almuerzo Escolar</td>
			<td width="1%" valign="top">
				<table>
					<tr><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td></tr>
					<tr><td>Si</td><td>No</td></tr>
				</table>		  </td>
		  <td valign="top" nowrap>2 Pase Escolar</td>
			<td width="1%" valign="top">
				<table>
					<tr><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td></tr>
					<tr><td>Si</td><td>No</td></tr>
				</table>		  </td>
			<td valign="top" nowrap>3 Entrega de certificado de Nac. solicitud de juguete </td>
			<td width="1%" valign="top">
				<table>
					<tr><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td></tr>
					<tr><td>Si</td><td>No</td></tr>
				</table>		  </td>
		</tr>
	</table>	</td>
</tr>
<tr><td colspan="2"> Observaciones:<br>
    <br>
    ___________________________________________________________________________________________________________________________<br>
    <br>
    ___________________________________________________________________________________________________________________________<br>
    <br>
    ___________________________________________________________________________________________________________________________<bR>
<br><br>
<br></td>
<tr>
  <td colspan="2"> Nombre del funcionario que matriculo:_____________________________________________<br>
    <br>
    Declaro conocer todas las dispociciones del Reglamento Interno del Establecimiento y me comprometo a
    <bR>
    asistir a reuniones mensuales de apoderados y a cualquier citaci&oacute;n que efect&uacute;e el colegio. <br>
    <br></td>
<tr>
  <td colspan="2"><br>
    ________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
    <b>NOMBRE Y FIMA APODERADO</b> </td>
</table>
	<? if ($i<pg_numrows($result_home)){?> 
	<H1 class=SaltoDePagina></H1>
	<? }?>
<? }

}else{
	for ($i=0;$i<pg_numrows($result_home);$i++){
		$fila=pg_fetch_array($result_home);
		$ob_reporte->CambiaDato($fila);
?>
<table width="610" height="160" border="0">
 <tr>
 <td height="28" colspan="2" align="right">&nbsp;</td>

  </tr>
  <tr>
   
    <td width="589"><table width="600" border="0" cellspacing="0" cellpadding="0" class="salto">
      <tr>
        <td><table>
			<tr><td><FONT face="arial, geneva, helvetica" size=2><strong>
			  <?php echo $ob_membrete->ins_pal; ?>
			</strong></FONT></td>
			</tr>
			<tr>
			  <td><?php echo $ob_membrete->comuna;?></td>
			</tr>
		</table></td>
        <td width="32%"><table width="100%" align="left">
            <tr>
              <td width="20%">CURSO</td>
              <td width="57%">
			  <?php $ob_membrete ->curso = $cmb_curso;
		  		$ob_membrete ->curso($conn);
				echo $ob_membrete->grado_curso."º".$ob_membrete->letra_curso;	
		  		?>		  	 </td>
              <td width="23%" rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr>
              <td>NIVEL</td>
              <td><? echo $ob_membrete->ensenanza;?></td>
            </tr>
            <tr>
              <td>AÑO </td>
              <td>
			  <?
				$ob_membrete->ano = $ano;
				$ob_membrete->AnoEscolar($conn);
				echo $ob_membrete->nro_ano;
				?>
			  </td>
            </tr>
          </table>                 </td>
      </tr>
      <tr>
        <td colspan="2"><table align="center">
            <tr>
              <td><b>FICHA DE MATRICULA</b> </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table  width="100%">
            <tr>
              <td width="11%"><br>
                Nº de Matricula<br></td>
              <td width="36%"><?=$ob_reporte->num_matricula;?><br>
                _________________________</td>
              <td width="53%" align="right"><div align="left">
                  <table width="1%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td nowrap><div align="left"></div></td>
                      <td rowspan="3">&nbsp;<?=impF($ob_reporte->fecha_matricula);?><br>
_____________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <div align="left"></div></td>
                    </tr>
                    <tr>
                      <td nowrap class="Estilo4"><div align="center">Fecha de Matr&iacute;cula</div></td>
                    </tr>
                  </table>
              </div>              </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><b><br>
          DATOS ALUMNO
        </b></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="300" valign="bottom"><b>
                <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_pat))); ?>
              </b><br>
                ___________________________________ <br>
                <b></b> Apellido paterno </td>
              <td width="300" valign="bottom"><b>
                <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_mat)));?>
              </b><br>
                ___________________________________ <br>
                <b></b> Apellido Materno </td>
              <td width="300" valign="bottom"><b>
                <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->nombre)));?>
              </b><br>
                              ___________________________________ <br>
                <b></b> Nombre</td>
            </tr>
            <tr>
              <td valign="bottom"><br>
                <b>
                <?php impF($ob_reporte->fecha_nacimiento);?>
                <br>
                </b>___________________________________ <br>
                <b></b> Fecha de Nacimiento </td>
              <td valign="bottom"><br>
                <b>
                <?=$ob_reporte->rut_alumno;?>
                </b><br>
                __________________________________ <br>
                <b></b> RUN</td>
              <td valign="bottom"><b>
                <?=$ob_reporte->salud;?>
              </b><br>
                ___________________________________ <br>
                <b></b>Sistema Salud </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="246"><br>
                <b>
                <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->direccion_alu)));?>
                <? if (trim($ob_reporte->depto)!=""){
			echo "DPTO $ob_reporte->depto";
		}?>
                <? if (trim($ob_reporte->block)!=""){
			echo "&nbsp;BLOCK $ob_reporte->block";
		}?>
                <? if (trim($ob_reporte->villa)!=""){
				
			echo "&nbsp;VILLA $ob_reporte->villa";
		}?>
                </b>&nbsp;___________________________________ <br><br>
                <b></b>Direccion</td>
              <td width="254"><b><br>
                <?=$ob_reporte->comuna;?>
              </b><br><br>
                ___________________________________ <br><br>
                <b></b>Comuna</td>
              <td width="247"><b><br>
                <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->provincia)));?>
              </b><br><br>
                ___________________________________ <br><br>
                <b></b>Ciudad</td>
            </tr>
        </table></td>
      </tr>
      
      <tr>
        <td colspan="2"><b><br>
          BECAS ALUMNO   </b></td>
      </tr>
      <tr>
        <td colspan="2">
			
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->bool_baj)));?><br>
				________________ <br>
                Alimentación Junaeb </td>
              <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_cpadre;?><br>
				___________<br>
                C. de Padres</td>
              <td><br>&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_seg;?><br>
				______<br>
                Seguro</td>
              <td><br>&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_otros?><br>
				&nbsp;&nbsp;_____<br>
                &nbsp;&nbsp;Otras </td>
              <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_bchs?><br>
				&nbsp;&nbsp;_____________<br>
                &nbsp;&nbsp;Chile Solidario </td>
                <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_mun?><br>
				_________<br>
                Municipal </td>
                <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->ben_sep?><br>
				_________<br>
                Alumno SEP </td>
                <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?=$ob_reporte->bool_fci?><br>
				_____________________________________<br>
                Financiamiento Compartido de la Intitución </td>
            </tr>
			
        </table></td>
      </tr>
      
      
      <tr>
        <td colspan="2"><b><br>
          DATOS PADRES        </b></td>
      </tr>
      <tr>
        <td colspan="2">
		<? 	$ob_reporte ->rut_alumno =$ob_reporte->alumno;
			$ob_reporte ->sexo = 2;
			$ob_reporte ->Padres($conn);
		?>	
			
			
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><br>
                <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->nombre_padre)));?>
				_______________________________ <br>
                Nombre Padre </td>
              <td><br>
                <?=$ob_reporte->rut_padre;?>
				_________________ <br>
                RUN</td>
              <td><br>
                <?=$ob_reporte->profesion;?>
				_________________________ <br>
                Profesion</td>
              <td><br>
                <?=$ob_reporte->educacion?>
				_______________________<br>
                Nivel Educacion </td>
              <td><br>
                <? if ($ob_reporte->nivel_social!=NULL){ 
						 switch ($ob_reporte->nivel_social) {
							 case 0:
								 imp('INDETERMINADO');
								 break;
							case 1:
								 imp('0-100.000');
								 break;
							case 2:
								 imp('100.000-200.000');
								 break;
							case 3:
								 imp('200.000-300.000');
								 break;
							case 4:
								 imp('300.000-400.000');
								 break;
							case 5:
								 imp('400.000-500.000');
								 break;
							case 6:
								 imp('500.000-600.000');
								 break;
							case 7:
								 imp('600.000-700.000');
								 break;	
							case 8:
								 imp('700.000-800.000');
								 break;
								 
							case 9:
								 imp('800.000-900.000');
								 break;	
							case 10:
								 imp('900.000-1.000.000');
								 break;	  	 
							case 11:
								imp('Mas de 1.000.000')	;
								break;	 	 	 
						 };
				  }else{ ?> _________________<? } ?> <br>
                Renta</td>
            </tr>
			<? 	$ob_reporte ->rut_alumno =$ob_reporte->alumno;
			$ob_reporte ->sexo = 1;
			$ob_reporte ->Padres($conn);
		?>	
            <tr>
              <td><br>
                 <?=$ob_reporte->nombre_padre;?>
				_______________________________ <br>
                Nombre Madre </td>
              <td><br>
                 <?=$ob_reporte->rut_padre;?>
				_________________<br>
                RUN</td>
              <td><br>
                <?=$ob_reporte->profesion;?>
			    _________________________<br>
                Profesion</td>
              <td><br>
               <?=$ob_reporte->educacion?>
			    ______________________<br>
                Nivel Educacion </td>
              <td><br>
                <? if ($ob_reporte->nivel_social!=NULL){ 
						 switch ($ob_reporte->nivel_social) {
							 case 0:
								 imp('INDETERMINADO');
								 break;
							case 1:
								 imp('0-100.000');
								 break;
							case 2:
								 imp('100.000-200.000');
								 break;
							case 3:
								 imp('200.000-300.000');
								 break;
							case 4:
								 imp('300.000-400.000');
								 break;
							case 5:
								 imp('400.000-500.000');
								 break;
							case 6:
								 imp('500.000-600.000');
								 break;
							case 7:
								 imp('600.000-700.000');
								 break;	
							case 8:
								 imp('700.000-800.000');
								 break;
								 
							case 9:
								 imp('800.000-900.000');
								 break;	
							case 10:
								 imp('900.000-1.000.000');
								 break;	  	 
							case 11:
								imp('Mas de 1.000.000')	;
								break;	 	 	 
						 };
				  }else{ ?><br>
                _________________
                <? } ?> 
                 _________________
                Renta</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table width="40%" align="right">
            <tr>
              <td width="40%">Relacion padres</td>
              <td width="40%"><table width="1%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td nowrap>Vivienda propia </td>
                    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td nowrap>Vivienda Arrendada&nbsp;&nbsp; </td>
                    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td nowrap>Vivienda Cedida </td>
                    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><b>          DATOS APODERADOS
        </b></td>
      </tr>
      <tr>
        <td colspan="2">
		<?
	
		$ob_reporte ->responsable=1;
		$ob_reporte ->alumno=$ob_reporte->alumno;
		$resultado = $ob_reporte->Apoderado($conn);
		$fila_apo = @pg_fetch_array($resultado,0);
		$ob_reporte->CambiaDatoApo($fila_apo);
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
		
	?>
		<table width="30%" border="0" cellpadding="1" cellspacing="0">
            <tr>
              <td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td><? if ($ob_reporte->sexo==2){ ?>&nbsp;*&nbsp;<? }else{ ?>&nbsp;&nbsp;&nbsp;<? } ?></td>
                  </tr>
              </table></td>
              <td><br>
                ___________________________________ <br>
                Padre</td>
              <td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td><? if ($ob_reporte->sexo==1){ ?>&nbsp;*&nbsp;<? }else{ ?>&nbsp;&nbsp;&nbsp;<? } ?></td>
                  </tr>
              </table></td>
              <td><br>
                ___________________________________ <br>
                Madre</td>
              <td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                  </tr>
              </table></td>
              <td><br>
                ______________________________________________<br>
                Apoderado Suplente </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%">
            <tr>
              <td><br>
                <? if ($ob_reporte->nombre_apo!=NULL){ echo $ob_reporte->ape_nombre_apo; }else{ ?> _____________________ <? } ?><br>
                Nombre</td>
              <td><br>
                <? if ($ob_reporte->rut_apo!=NULL){ echo $ob_reporte->rut_apo; }else{ ?> ____________ <? } ?><br>
                RUN</td>
              <td><br>
                <? if ($ob_reporte->direccion!=NULL){ echo $ob_reporte->direccion; }else{ ?>
___________________________________
<? } ?>
<br>
                Direccion</td>
              <td><br>
                <? if ($ob_reporte->comuna!=NULL){ echo $ob_reporte->comuna; }else{ ?>
___________
<? } ?>
<br>
                Comuna</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="20%"><br>
                <? if ($ob_reporte->telefono_apo!=NULL){ echo $ob_reporte->telefono_apo; }else{ ?>
____________
<? } ?>
<br>
                Telefono</td>
              <td width="20%"><br>
                <? if ($ob_reporte->celular!=NULL){ echo $ob_reporte->celular; }else{ ?>
____________
<? } ?>
<br>
                Celular</td>
              <td width="20%"><br>
                ___________________<br>
                Telefono Recados </td>
              <td width="20%"><br>
                ____________<br>
                Fax</td>
              <td width="20%"><br>
                <? if ($ob_reporte->email_apo!=NULL){ echo $ob_reporte->email_apo; }else{ ?>
____________
<? } ?>
<br>
                E-mail</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td ><b><br>
          OTROS<br>
        </b></td>
      </tr>
      <tr>
      	
        <td width="68%" height="30" >Procedencia del Alumno: &nbsp;&nbsp;&nbsp; <?=$ob_reporte->proced_alumno;?><br> _____________________________ _________________________________ </td>
      </tr>
      <tr>
        <td height="30" >Personas con quien vive el alumno:&nbsp;&nbsp;&nbsp;<?=$ob_reporte->con_quien_vive;?> <br>____________________________________________________________ </td>
      </tr>
      <tr>
        <td height="30" cols&npan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><br>
          Tiene algun problema de salud significativo __________________________________________________________________________________<br></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%">
            <tr>
              <td valign="bottom"><br>
                ___________________________<br>
                N&ordm; Boleta C.G.P.A </td>
              <td valign="bottom"><br>
                __________________________<br>
                Monto Cancelado </td>
              <td valign="bottom"><br>
                ________________<br>
                Fecha Cancelacion </td>
            </tr>
          </table>
            <br>
            <br>        </td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><table width="70%">
            <tr>
              <td valign="top">Solicita</td>
              <td valign="top" nowrap>1.- Almuerzo Escolar</td>
              <td width="1%" valign="top"><table>
                  <tr>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>Si</td>
                    <td>No</td>
                  </tr>
              </table></td>
              <td valign="top" nowrap>2 Entrega Certificado de Nacimiento </td>
              <td width="1%" valign="top"><table>
                  <tr>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>Si</td>
                    <td>No</td>
                  </tr>
              </table></td>
              <td valign="top" nowrap>4 Alumno Puente</td>
              <td width="1%" valign="top"><table>
                  <tr>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>Si</td>
                    <td>No</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"> Observaciones:<br>
            <br>
          ___________________________________________________________________________________________________________________________<br>
          <br>
          ___________________________________________________________________________________________________________________________<br>
          <br>
          ___________________________________________________________________________________________________________________________<br>
          <br>
          <br>
          <br></td>
      <tr>
        <td colspan="2"> Nombre del funcionario que matriculo:_____________________________________________<br>
            <br>
          Declaro conocer todas las dispociciones del Reglamento Interno del Establecimiento y me comprometo a <br>
          asistir a reuniones mensuales de apoderados y a cualquier citaci&oacute;n que efect&uacute;e el colegio. <br>
          <br></td>
      <tr>
        <td colspan="2"><br>
          ________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
          <b>NOMBRE Y FIMA APODERADO</b> </td>
    </table></td>
  </tr>
</table>
<? }
}
}?>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<?
$institucion	= $_INSTIT;
$ano			= $_ANO;
$c_curso = 0;
?>


								 
<!-- FIN FORMULARIO DE BUSQUEDA --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
<? pg_close($conn);
unset($cb_ok)?>