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
	$result_home=$ob_reporte->FichaAlumnoUno($conn);
}
if(($alumno==0)&&($cmb_curso!=0)){
	$ob_reporte->ano =$ano;
	$ob_reporte->curso = $cmb_curso;
	$result_home=$ob_reporte->FichaAlumnoTodos($conn);
}

if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Ficha_Matricula_$Fecha.xls"); 
	
}
	
$resultado_socio = $ob_reporte->alu_socioeconomico($conn);
$fila_socio = @pg_fetch_array($resultado_socio,0);

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
-->
    </style>
	
<SCRIPT language="JavaScript">
			function enviapag2(form){
					form.target="_blank";
					alert("aki");
		   			form.action='printFichaMatriculaPostulacion_C.php?alumno=<?=$alumno?>&cmb_curso=<?=$curso?>';			
					
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
<form method="post" action="printFichaMatriculaPostulacion_C.php" name="form">
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
<div align="center">
 
  <? if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br><br><br>";
  }

  


	for ($i=0;$i<pg_numrows($result_home);$i++){
		$fila=pg_fetch_array($result_home);
		$ob_reporte->CambiaDato($fila);
?>
  <br>
  <br>
  <table width="590" border="0" align="center" cellpadding="0" cellspacing="0" >
                              <tr class="tableindex">
                                <td colspan="4"><div align="center">
                                    FICHA DE MATRICULA </div></td>
                                </tr>

                              <tr>
                                <td colspan="4">&nbsp;</td>
                                </tr>
                              <tr>
                                <td width="17%" class="texto"><strong>Establecimiento</strong></td>
                                <td colspan="3" class="texto"><?php echo $ob_membrete->ins_pal; ?></td>
                                </tr>
                              <tr>
                                <td class="texto"><strong>Curso</strong></td>
                                <td colspan="3"><?php $ob_membrete ->curso = $cmb_curso;
		  		$ob_membrete ->curso($conn);
				echo $ob_membrete->grado_curso." - ".$ob_membrete->letra_curso." ".$ob_membrete->ensenanza;		
		  ?></td>
                                </tr>
                              <tr>
                                <td><span class="texto"><strong>N&ordm; Matr&iacute;cula </strong></span></td>
                                <td width="43%"><?php echo $ob_reporte->num_matricula ?></td>
                                <td width="7%" ><span class="texto"><strong>Fecha</strong></span></td>
                                <td width="33%"><?php echo $ob_reporte->fecha_matricula ?></td>
                                </tr>
                            </table>
  <br>
  <br>
</div>
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" >
							<tr  class="tableindex">
                                <td colspan="2"><div align="center">DATOS DEL ALUMNO </div></td>
                                </tr>
                              <tr>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                              <tr>
                                <td width="18%" class="texto"><strong>RUT</strong></td>
                                <td><?=$ob_reporte->rut_alumno;?></td>
                                </tr>
                              <tr>
                                <td class="texto"><strong>Apellido Paterno </strong></td>
                                <td><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_pat))); ?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Apellido Materno</strong></td>
                                <td><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_mat)));?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Nombres</strong></td>
                                <td><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->nombre)));?></td>
                              </tr>
                              <tr>
                                <td class="texto">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Sexo</strong></td>
                                <td><?=$ob_reporte->sexo;?></td>
                              </tr>
                              <tr>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                              <tr>
                                <td class="texto"><strong>Fecha de Nac. </strong></td>
                                <td class="texto">
			    <?php impF($ob_reporte->fecha_nacimiento);?>
			 </td>
                                </tr>
                              <tr>
                                <td class="texto"><strong>Lugar</strong></td>
                                <td class="texto"><?=$ob_reporte->lugar;?></td>
                              </tr>
                              <tr>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                              <tr>
                                <td class="texto"><strong>Domicilio</strong></td>
                                <td><div align="left"> <?=$ob_reporte->direccion_alu;?>
		<? if (trim($ob_reporte->depto)!=""){
			echo "DPTO $ob_reporte->depto";
		}?>
		<? if (trim($ob_reporte->block)!=""){
			echo "&nbsp;BLOCK $ob_reporte->block";
		}?>
		<? if (trim($ob_reporte->villa)!=""){
			echo "&nbsp;VILLA $ob_reporte->villa";
		}?></div></td>
                                </tr>
                              <tr>
                                <td class="texto"><strong>Cerro</strong></td>
                                <td><? if (trim($ob_reporte->cerro)!=""){
			echo "&nbsp;Cerro $ob_reporte->cerro";
		}?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Fono</strong></td>
                                <td><?=$ob_reporte->telefono;?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Comuna</strong></td>
                                <td><?=$ob_reporte->comuna;?></td>
                              </tr>
                              <tr>
                                <td colspan="2">&nbsp;</td>
                                </tr>
							</table>
<br>
<br>
<br>
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr class="tableindex">
                                <td colspan="3"><div align="center">
                                  ANTECEDENTES ESCOLARES </div></td>
                                </tr>
                              <tr>
                                <td width="30%" class="texto">&nbsp;</td>
                                <td width="70%" class="texto">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Escuela de Prodedencia </strong></td>
                                <td class="texto"><?=$ob_reporte->colegioprocedencia;?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>&iquest;Repite Curso Actual? </strong></td>
                                <td colspan="2" class="texto">
								<?php 
								if(strlen($ob_reporte->cursosrep)>3)
								{
								echo "si";
								$cur=$ob_reporte->cursosrep;
								}
								else
								echo "no";
								?>					
								</td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Cursos que ha repetido                                  </strong></td>
                                <td colspan="2" class="texto"><?php echo $cur ?></td>
                              </tr>
                              <!--<tr>
                                <td class="texto">Causas de Cancelaci&oacute;n de Matr&iacute;cula </td>
                                <td class="texto"><textarea name="txt_canc_mat" cols="30"><? echo $fila_ret['detalle_retiro'] ?></textarea></td>
                                </tr>-->
                              <tr>
                                <td class="texto"><strong>&iquest;Religi&oacute;n?</strong></td>
                                <td colspan="2" class="texto">
								<?php 
								if(strlen($ob_reporte->religion)>3)
								{
								echo "si";
								$rel=$ob_reporte->religion;
								}
								else
								echo "no";
								?>		
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>&iquest;Cu&aacute;l? <?php echo $rel ?></strong></td>
                              </tr>
                            </table>
<br>
<br>
<?php //madre
		$sql_mad="SELECT * FROM public.apoderado INNER JOIN tiene2 ON (apoderado.rut_apo = tiene2.rut_apo) WHERE (apoderado.relacion = 2) and (tiene2.rut_alumno =".$alumno.")";
			$res_mad=@pg_exec($conn,$sql_mad);
			$fil_mad=@pg_fetch_array($res_mad,0);
			
			//padre
			$sql_pad="SELECT * FROM public.apoderado INNER JOIN tiene2 ON (apoderado.rut_apo = tiene2.rut_apo) WHERE (apoderado.relacion=1) and (tiene2.rut_alumno =".$alumno.")";
			$res_pad=@pg_exec($conn,$sql_pad);
			$fil_pad=@pg_fetch_array($res_pad,0); ?>
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr class="tableindex">
    <td colspan="6"><div align="center">ANTECEDENTES FAMILIARES </div></td>
    </tr>
  <tr>
    <td class="texto">&nbsp;</td>
    <td colspan="5" class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto"><strong>Rut del Padre </strong></td>
    <td colspan="5" class="texto"><?php echo $fil_pad['rut_apo'] ?> - <?php echo $fil_pad['dig_rut'] ?></td>
  </tr>
  <tr>
    <td width="24%" class="texto"><strong>Nombre </strong></td>
    <td colspan="5" class="texto"><?php echo $ob_reporte->tilde(ucfirst(strtolower($fil_pad['nombre_apo']))); ?></td>
  </tr>
	<td class="texto"><strong>Apellido Paterno </strong></td>
                                <td class="texto" colspan="5"><?php echo $ob_reporte->tilde(ucfirst(strtolower($fil_pad['ape_pat']))); ?></td>
	</tr>
                              <tr>
                                <td class="texto"><strong>Apellido Materno </strong></td>
                                <td class="texto" colspan="5"><?php echo $ob_reporte->tilde(ucfirst(strtolower($fil_pad['ape_mat']))); ?></td>
  <tr>
    <td class="texto"><strong>Profesi&oacute;n u oficio </strong></td>
    <td colspan="5" class="texto"><?php echo $ob_reporte->tilde(ucfirst(strtolower($fil_pad['profesion']))); ?></td>
  </tr>
  <tr>
    <td colspan="6" class="texto">&nbsp;</td>
    </tr>
  <tr>
    <td class="texto"><strong>Rut de la madre </strong></td>
    <td colspan="5" class="texto"><?php echo $fil_mad['rut_apo'] ?> - <?php echo $fil_mad['dig_rut'] ?></td>
  </tr>
  <tr>
    <td class="texto"><strong>Nombre </strong></td>
    <td colspan="5" class="texto"><?php echo $ob_reporte->tilde(ucfirst(strtolower($fil_mad['nombre_apo']))); ?></td>
  </tr>
	<td class="texto"><strong>Apellido Paterno </strong></td>
                                <td class="texto" colspan="5"><?php echo $ob_reporte->tilde(ucfirst(strtolower($fil_mad['ape_pat']))); ?></td>
	</tr>
                              <tr>
                                <td class="texto"><strong>Apellido Materno </strong></td>
                                <td class="texto" colspan="5"><?php echo $ob_reporte->tilde(ucfirst(strtolower($fil_mad['ape_mat']))); ?></td>
  <tr>
    <td class="texto"><strong>Profesi&oacute;n u oficio </strong></td>
    <td colspan="5" class="texto"><?php echo $ob_reporte->tilde(ucfirst(strtolower($fil_mad['profesion']))); ?></td>
  </tr>
  <tr>
    <td colspan="6" class="texto">&nbsp;</td>
    </tr>
  <tr>
    <td class="texto"><strong>Padres</strong></td>
    <td colspan="5" class="texto"><?php echo $fila_socio['estado_padres'] ?></td>
  </tr>
  <tr>
    <td class="texto"><strong>&iquest;Alumno(a) con qui&eacute;n vive?</strong></td>
    <td colspan="5" class="texto"><?php echo $fila_socio['alu_conquienvive'] ?></td>
  </tr>
  <tr>
    <td class="texto"><strong>Familia: Total de Hijos </strong></td>
    <td width="21%" class="texto"><?php echo $fila_socio['cant_hijos'] ?></td>
    <td colspan="3" class="texto"><strong>Lugar que ocupa entre ellos </strong></td>
    <td width="30%" class="texto"><?php echo $fila_socio['hijo_num'] ?></td>
  </tr>
</table>
<br>
<br>
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
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" >
                              <tr class="tableindex">
                                <td colspan="4"><div align="center">DATOS DEL APODERADO </div></td>
                                </tr>
                              <tr >
                                <td colspan="4" class="texto">&nbsp;</td>
                                </tr>
                              <tr >
                                <td width="24%" class="texto"><strong>Rut del Apoderado </strong></td>
                                <td colspan="3" class="texto"><?php echo $ob_reporte->rut_apo ?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Nombre Completo </strong></td>
                                <td colspan="3" class="texto"><?php echo $ob_reporte->tilde(ucfirst(strtolower($ob_reporte->nombre_apo))); ?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Apellido Paterno </strong></td>
                                <td colspan="3" class="texto"><?php echo $ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_pat))); ?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Apellido Materno </strong></td>
                                <td colspan="3" class="texto"><?php echo $ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_mat))); ?></td>
                              </tr>
                             <tr>
                                <td class="texto"><strong>Grado Parentezco </strong></td>
                                <td colspan="3" class="texto"><?php 
								if($ob_reporte->rel_apo==1)
								echo "Padre";
								elseif($ob_reporte->rel_apo==2)
								echo "Madre";
								else
								echo "Otro";
								
								  ?></td>
                             </tr>
                              <tr>
                                <td class="texto"><strong>Domicilio</strong></td>
                                <td colspan="3" class="texto"><?php echo $ob_reporte->direccion ?></td>
                                </tr>
                              <tr>
                                <td class="texto">&nbsp;</td>
                                <td colspan="3" class="texto">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Tel&eacute;fono</strong></td>
                                <td colspan="3" class="texto"><?php echo $ob_reporte->telefono_apo ?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Cerro</strong></td>
                                <td colspan="3" class="texto">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Comuna</strong></td>
                                <td colspan="3" class="texto"><?php echo $ob_reporte->comuna ?></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="texto">&nbsp;</td>
                                </tr>
                              <tr>
                                <td colspan="4" class="texto"><strong>Nivel Educacional </strong></td>
                                </tr>
                              <tr>
                                <td class="texto"><strong>Padre</strong></td>
                                <td colspan="3" class="texto"><?php echo $fil_pad['nivel_edu'] ?></td>
                                </tr>
                              <tr>
                                <td class="texto"><strong>Madre</strong></td>
                                <td colspan="3" class="texto"><?php echo $fil_mad['nivel_edu'] ?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Apoderado</strong></td>
                                <td colspan="3" class="texto"><?php echo $ob_reporte->educacion ?></td>
                                </tr>
                              <tr>
                                <td class="texto">&nbsp;</td>
                                <td colspan="3" class="texto">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>En caso de emergecia llamar a </strong></td>
                                <td colspan="3" class="texto"><?=$ob_reporte->contacto_emergencia;?></td>
                              </tr>
                              <tr>
                                <td class="texto"><strong>Fono</strong></td>
                                <td colspan="3" class="texto"><?=$ob_reporte->fono_contacto;?></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="texto">&nbsp;</td>
                                </tr>
                            </table>
<br>
<br>
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr class="tableindex">
    <td colspan="5" ><div align="center">ANTECEDENTES SOCIO-ECONOMICOS </div></td>
    </tr>
  <tr>
    <td width="23%" class="texto">&nbsp;</td>
    <td width="18%" class="texto">&nbsp;</td>
    <td width="17%" class="texto">&nbsp;</td>
    <td width="37%" class="texto">&nbsp;</td>
    <td width="5%" class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto"><strong>Vivienda</strong></td>
    <td colspan="3" class="texto"><?php echo $fila_socio['tipo_vivienda'] ?></td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto"><strong>N&ordm; personas que la habitan </strong></td>
    <td class="texto"><?php echo $fila_socio['num_habi_viv'] ?></td>
    <td class="texto"><strong>N&ordm; de piezas </strong></td>
    <td class="texto"><?php echo $fila_socio['num_piezas'] ?></td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="texto">&nbsp;</td>
    </tr>
  <tr>
    <td class="texto"><strong>Domicilio cuenta con: </strong></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto"><strong>Agua Potable </strong></td>
    <td class="texto"><?php echo $fila_socio['agua'] ?></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto"><strong>Luz el&eacute;ctrica </strong></td>
    <td class="texto"><?php echo $fila_socio['luz'] ?></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto"><strong>Ba&ntilde;o completo </strong></td>
    <td class="texto"><?php echo $fila_socio['bano'] ?></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto"><strong>S&oacute;lo WC </strong></td>
    <td class="texto"><?php echo $fila_socio['wc'] ?></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto"><strong>Alcantarillado</strong></td>
    <td class="texto"><?php echo $fila_socio['alcantarillado'] ?></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto"><strong>Pozo Negro </strong></td>
    <td class="texto"><?php echo $fila_socio['pozoseptico'] ?></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto"><strong>Total Entradas familiares $ </strong></td>
    <td class="texto"><?php echo $fila_socio['tot_ing_fam'] ?></td>
    <td class="texto"><strong>Unidad Vecinal N&ordm; </strong></td>
    <td class="texto"><?php echo $fila_socio['uni_vecinal'] ?></td>
    <td class="texto">&nbsp;</td>
  </tr>
</table>
<br>
<br>
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr class="tableindex">
                                <td colspan="5"><div align="center">OTROS</div></td>
                              </tr>
                              <tr>
                                <td width="84" class="texto">&nbsp;</td>
                                <td width="390" class="texto">&nbsp;</td>
                                <td width="38">&nbsp;</td>
                                <td width="38">&nbsp;</td>
                                <td width="40">&nbsp;</td>
                              </tr>
                              <tr class="texto">
                                <td colspan="5"><strong>Enfermedades anteriores, discapacidad, o utros antecedentes significativos que se pueden anotar </strong></td>
                              </tr>
                              <tr class="texto">
                                <td colspan="5">                                  </td></tr>
                              <tr>
                                <td colspan="5" class="texto"><?=$ob_reporte->salud;?></td>
                                </tr>
                              <tr>
                                <td colspan="5" class="texto">&nbsp;</td>
                              </tr>
                              <tr class="texto">
                                <td colspan="5"><strong>&iquest;Tiene uniforme? </strong></td>
                              </tr>
                              <tr class="texto">
                                <td colspan="5"><?php echo $fila_socio['tiene_unif'] ?></td>
                              </tr>
  </table>
<br>
<br>
<? 
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