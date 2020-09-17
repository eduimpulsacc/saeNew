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
	$frmModo		=$_FRMMODO;
	$alumno			=$alumno;	


if ($alumno){
$qry="SELECT matricula.*, alumno.*, date_part('day',matricula.fecha) AS day, date_part('month',matricula.fecha) AS month, date_part('year',matricula.fecha) AS year FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE (((matricula.id_ano)=".$ano.") AND ((alumno.rut_alumno)=".$alumno."))";
}
if((!$alumno)&&($cmb_curso)){
$qry="SELECT matricula.*, alumno.*, date_part('day',matricula.fecha) AS day, date_part('month',matricula.fecha) AS month, date_part('year',matricula.fecha) AS year FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE ((matricula.id_ano)=".$ano.") AND matricula.id_curso=$cmb_curso";
}
if ($qry){
	$result_home =@pg_Exec($conn,$qry);
	$num_fila=pg_numrows($result_home);
}
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

	window.print();

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

<? if (($num_fila>0) and ($ssww==1)){?>
<div id="layer2">
<table width="739"><tr><td align="right">
<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr></table>
</div>
<? for ($i=0;$i<$num_fila;$i++){
$fila=pg_fetch_array($result_home);
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
			  <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
			</strong></FONT></td>
			</tr>
			<tr>
			  <td><?php 
			$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." AND COR_COM=".$fila['comuna'];
			$resultCOM	=@pg_Exec($conn,$qryCOM);
			$filaCOM	= @pg_fetch_array($resultCOM,0);
			?><? echo ($filaCOM['nom_com']);?></td>
			</tr>
		</table>	</td>
	<td>
	<table align="right">
		<tr><td>CURSO</td><td>
		  <?php 
															    $qryC = "SELECT cod_decreto, grado_curso, letra_curso, nombre_tipo, ensenanza FROM ((curso INNER JOIN matricula ON curso.id_curso=matricula.id_curso) INNER JOIN tipo_ensenanza ON tipo_ensenanza.cod_tipo=curso.ensenanza) WHERE matricula.rut_alumno=".$fila["rut_alumno"]." and matricula.id_ano=".$ano; 
								  								$resultC =@pg_Exec($conn,$qryC);
								 							    $filaC = @pg_fetch_array($resultC,0); 
																$grado=$filaC['grado_curso'];
																if ($grado==9){
																	$grado=8;	
																}	
																if (trim($filaC[nombre_tipo])=="Educación Parvularia"){
																	$grado=1;
																}
																echo $grado;	?>
		</td><td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
		<tr><td>NIVEL</td>
		<td>
		
		<? if ($filaC['ensenanza']==110){
		       ?> B&aacute;sica <?
		   } ?>
		   
		   <? if ($filaC['ensenanza']==310){
		       ?> Medio <?
		   } ?>
		   
		   <? if ($filaC['ensenanza']==10){
		       ?> Parvularia <?
		   } ?>
		
		
		
			   </td>
		</tr>
		<tr><td>AÑO PROMOCION</td>
		<td>
		<?
		$sql_aux = "select * from ano_escolar where id_ano = '".$_ANO."'";
		$res_aux = @pg_Exec($conn,$sql_aux);
		$fil_aux = @pg_fetch_array($res_aux);
		$nro_ano = $fil_aux['nro_ano'];
		
		echo $nro_ano;
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
	  <table  width="100%"><tr><td><br>
	  Nº de Matricula</td><td align="right"><br>
	  <table width="1%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td nowrap>&nbsp;</td>
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
				<td valign="bottom"><b><? echo $fila['ape_pat'];?></b><br>
			    Apellido paterno </td>
				<td valign="bottom"><b><? echo $fila['ape_mat'];?></b><br>
			    Apellido Materno </td>
				<td valign="bottom"><b><? echo $fila['nombre_alu'];?></b><br>
			    Nombre</td>
			</tr>
			<tr>
			  <td valign="bottom">
			  
<b>			    <?php impF($fila['fecha_nac']);?>
</b><bR>
			  Fecha de Nacimiento </td>
			  <td valign="bottom"><b><? echo $fila['rut_alumno'];?>-<? echo $fila['dig_rut'];?></b><br>
		      RUN</td>
			  <td valign="bottom">Isapre</td>
		  </tr>
		</table>	  </td>
  </tr>
  <tr>
  	<td colspan="2"><table width="100%">
  	  <tr><td>
	  <b>
  	    <?php imp($fila['calle']);?>&nbsp;	<?php imp($fila['nro']);?>
		<? if (trim($fila['depto'])!=""){
			echo "DPTO $fila[depto]";
		}?>
		<? if (trim($fila['block'])!=""){
			echo "&nbsp;BLOCK $fila[block]";
		}?>
		<? if (trim($fila['villa'])!=""){
			echo "&nbsp;VILLA $fila[villa]";
		}?>
		</b>
<br>Direccion</td>
  	  <td>	<?php 
			$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." AND COR_COM=".$fila['comuna'];
			$resultCOM	=@pg_Exec($conn,$qryCOM);
			$filaCOM	= @pg_fetch_array($resultCOM,0);
			?>
  	    <b><? echo ($filaCOM['nom_com']);?></b>
			<br>Comuna</td>
  	  <td><? $qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad'];
										$resultPRO	=@pg_Exec($conn,$qryPRO);
										$filaPRO	= @pg_fetch_array($resultPRO,0);
										?>
  	    <b><? echo ($filaPRO['nom_pro']);?></b><br>Ciudad</td>
  	  </tr></table></td>
  </tr>
<tr><td colspan="2"><b><br>
  DATOS PADRES<br>
</b></td>
</tr>
<tr>
	<td colspan="2">
	<table width="100%">
	<?
	$rut_alumno =  $fila['rut_alumno'];
		
	$sql_1 = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno = '$rut_alumno')";
	$res_1 = @pg_Exec($conn, $sql_1);
	$num_1 = @pg_numrows($res_1);
	
	if ($num_1 > 0){
	
			for ($i = 0; $i < $num_1; $i++){
				 $fil_1 = @pg_fetch_array($res_1,$i);
				 $sexo_apo   = $fil_1['sexo'];
				 $nombre_apo  = $fil_1['nombre_apo'];
				 $paterno_apo = $fil_1['ape_pat'];
				 $materno_apo = $fil_1['ape_mat'];
				 $rut_apo_apo = $fil_1['rut_apo'];
				 $dig_rut_apo = $fil_1['dig_rut'];	
				 $profesion_apo = $fil_1['profesion'];	
				 $nivel_edu_apo = $fil_1['nivel_edu'];
				 $nivel_social_apo = $fil_1['nivel_social'];	
				 ?>
				<tr>
				<td><br>
				 <? if ($nombre_apo!=NULL){ echo "$paterno_apo $materno_apo $nombre_apo"; }else{ ?>  _____________________ <? } ?><br>
				  Nombre  </td>
				<td><br>
				 <? if ($rut_apo_apo!=NULL){ echo "$rut_apo_apo-$dig_rut_apo"; }else{ ?> ____________ <? } ?><br>
				  RUT</td>
				<td><br>
				 <? if ($profesion_apo!=NULL){ echo $profesion_apo; }else{ ?> _________________ <? } ?><br>
				  Profesion</td>
				<td><br>
				 <? if ($nivel_edu_apo!=NULL){ echo $nivel_edu_apo; }else{ ?> _________________ <? } ?><br>
				  Nivel Educacion </td>
				<td><br>
				 <? if ($nivel_social_apo!=NULL){ 
						 switch ($nivel_social_apo) {
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
				  RUT</td>
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
	$sql_1 = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno = '$rut_alumno' and responsable='1')";
	$res_1 = @pg_Exec($conn, $sql_1);
	$num_1 = @pg_numrows($res_1);
	$fil_1 = @pg_fetch_array($res_1);
		
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
                    <td><? if ($sexo_apo==2){ ?>&nbsp;*&nbsp;<? }else{ ?>&nbsp;&nbsp;&nbsp;<? } ?></td>
                  </tr>
                </table></td>
				<td>Padre</td>
				<td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td><? if ($sexo_apo==1){ ?>&nbsp;*&nbsp;<? }else{ ?>&nbsp;&nbsp;&nbsp;<? } ?></td>
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
      <? if ($nombre_apo!=NULL){ echo "$paterno_apo $materno_apo $nombre_apo"; }else{ ?> _____________________ <? } ?><br>
      Nombre</td>
    <td><br>
      <? if ($rut_apo!=NULL){ echo "$rut_apo-$dig_rut_apo"; }else{ ?> ____________ <? } ?><br>
      RUT</td>
    <td><br>
      <? if ($direccion_apo!=NULL){ echo $direccion_apo; }else{ ?> ___________________________________ <? } ?><br>
      Direccion</td>
    <td><br>
      <? if ($comuna_apo!=NULL){ echo $comuna_apo; }else{ ?>  ___________ <? } ?><br>
      Comuna</td>
   </tr>
   
</table></td></tr>
<tr><td colspan="2"><table width="100%">
  <tr>
    <td width="20%"><br>
      <? if ($telefono_apo!=NULL){ echo $telefono_apo; }else{ ?> ____________ <? } ?><br>
      Telefono</td>
    <td width="20%"><br>
      <? if ($celular_apo!=NULL){ echo $celular_apo; }else{ ?> ____________ <? } ?><br>
      Celular</td>
    <td width="20%"><br>
      ____________<br>
      Telefono Recados </td>
    <td width="20%"><br>
      ____________<br>
      Fax</td>
    <td width="20%"><br>
      <? if ($email_apo!=NULL){ echo $email_apo; }else{ ?> ____________ <? } ?><br>
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
	<? if ($num_fila>1){?> 
	<H1 class=SaltoDePagina></H1>
	<? }?>
<? }
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
</body>
</html>
<? pg_close($conn);?>