<?php require('../../../../util/header.inc');?>
<?
	//---------------
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$cmb_ano;
	$mes			=$cmb_mes;
	$_POSP = 4;
	$_bot = 0;
	//----------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	$dmes = dia_mes($mes,$ano);	
	$habi = hbl($nro_ano."-".$mes."-"."01",$nro_ano."-".$mes."-".$dmes);
	
$sql_ferx ="select * from feriado where id_ano=$ano and fecha_inicio>='".$nro_ano."-".$mes."-"."01' and fecha_fin<='".$nro_ano."-".$mes."-".$dmes."'"; 
	$rsFeriadox=pg_exec($conn,$sql_ferx);
	for($x=0 ; $x < @pg_numrows($rsFeriadox) ; ++$x)

	{

		$fFeriado= @pg_fetch_array($rsFeriado,$x);

		

		$fechax_inicio = $fFeriado['fecha_inicio'];

		$fechax_fin = $fFeriado['fecha_fin'];

		if (!empty($fechax_fin)){

			// DateDiff('d',$fecha_inicio, $fecha_fin);
			 $dias_entrex =ddiff($fecha_iniciox, $fecha_finx);

			$diasx = $diasx + $dias_entrex+1;

		}else{

			$diasx = $diasx + 1;

		}

	}
//echo "d".$diasx;
$habil_mes = $habi-$diasx;
	
	
	//----------------
	$ls_string 		= ""		;
	$salto 			= "\n"		;
	$ls_espacio		= chr(9)	;
 	//---------------
	$fichero = fopen("Archivos/ASISTENCIA".trim($nro_ano)."_".$institucion.".".$formato, "w"); 
	//---------------
	$ls_string = $ls_string . "rut"  . "$ls_espacio";
	$ls_string = $ls_string . "dv"  . "$ls_espacio";
	$ls_string = $ls_string . "nombre alumno"  . "$ls_espacio";
	$ls_string = $ls_string . "apellido paterno"  . "$ls_espacio";
	$ls_string = $ls_string . "apellido materno"  . "$ls_espacio";
	$ls_string = $ls_string . "rdb"  . "$ls_espacio";
	$ls_string = $ls_string . "nombre establecimiento"  . "$ls_espacio";
	$ls_string = $ls_string . "nivel"  . "$ls_espacio";
	$ls_string = $ls_string . "curso"  . "$ls_espacio";
	$ls_string = $ls_string . "letra"  . "$ls_espacio";
	$ls_string = $ls_string . "dias habiles del mes"  . "$ls_espacio";
	$ls_string = $ls_string . "dias de inasistencia"  . "$ls_espacio";
	$ls_string = $ls_string . "mes de información"  . "$salto";
	//---------------
	@ fwrite($fichero,"$ls_string"); 
	//---------------
	$sqlMatri = "select al.rut_alumno rut_alumno,al.dig_rut,al.ape_pat,al.ape_mat,al.nombre_alu,ins.rdb,ins.nombre_instit,
e.nombre_tipo,c.id_curso,c.grado_curso,c.letra_curso,
c.fecha_inicio,c.fecha_termino
from alumno al 
inner join matricula ma on al.rut_alumno = ma.rut_alumno
inner join curso c on c.id_curso = ma.id_curso
inner join institucion ins on ins.rdb = ma.rdb
inner join tipo_ensenanza e on e.cod_tipo =c.ensenanza
where ma.id_ano=$ano 
order by c.ensenanza,c.grado_curso,c.id_curso,al.ape_pat,al.ape_mat,al.nombre_alu";
$rsMatri =@pg_Exec($conn,$sqlMatri);

	
	/*$sqlMatri = "select alumno.*, matricula.* from alumno, matricula where matricula.id_ano =".$ano." and alumno.rut_alumno = matricula.rut_alumno order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu";
	$rsMatri =@pg_Exec($conn,$sqlMatri);*/
	//---------------
	for($e=0 ; $e < @pg_numrows($rsMatri) ; $e++)
	{	
		//---------------
		$fMatri = @pg_fetch_array($rsMatri,$e);
		
		 $sql_rasis="select count(*) from asistencia where rut_alumno=".trim($fMatri['rut_alumno'])." and ano=$ano and date_part('month',fecha)=$mes";
		$rs_as = pg_exec($conn,$sql_rasis);
		$asis = pg_result($rs_as,0);
		//---------------
		$ls_string = trim($fMatri['rut_alumno'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['dig_rut'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['nombre_alu'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['ape_pat'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['ape_mat'])  . "$ls_espacio";
		$ls_string = $ls_string . $_INSTIT  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['nombre_instit'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['nombre_tipo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['grado_curso'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['letra_curso'])  . "$ls_espacio";
		$ls_string = $ls_string . $habil_mes . "$ls_espacio";
		$ls_string = $ls_string . $asis  . "$ls_espacio";
		$ls_string = $ls_string . envia_mes($mes)  . "$salto";
		//$ls_string =  trim($fMatri['num_mat'])  . "$salto";
		//---------------
		@ fwrite($fichero,"$ls_string"); 
		//---------------
	}
	//---------------	
	fclose($fichero); 
	//---------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link  rel="shortcut icon" href="../../../../images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
								  
							
													  
							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>

								   <!-- INSERTAMOS CODIGO NUEVO -->
							 
							      <center>
  <table width="90%" height="172" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="71">
        <div align="right">
          <INPUT class = "botonXX" TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="../Menu_Respaldo.php">
      </div></td>
    </tr>
    <tr>
      <td>
         <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableindex">
          <tr> 
             
            <td>Respaldo de Informaci&oacute;n desde Colegio Interactivo </td>
           </tr>
          </table>
		 
		 
		 </td>
    </tr>
    <tr>
      <td>        <div align="center">
          <p>&nbsp;</p>
          <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo Asistencia del Colegio </font></strong></p>
          <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El archivo ha sido creado con el nombre de <a href='Archivos/ASISTENCIA<? echo $nro_ano?>_<? echo $institucion;?>.<?php echo $formato ?>' target="_blank"> &quot;ASISTENCIA<? echo $nro_ano?>.<?php echo $formato ?>&quot;</a> <br>
          </strong></font></p><br>
      </div></td>
    </tr>
    <tr>
      <td>
        <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para guardar el archivo en su PC Solo debe clickear con el boton derecho sobre el Link que esta en el nombre del archivo y elegir la opcion &quot;<strong>guardar destino como</strong>&quot; (Save Target As)</font></div></td>
    </tr>
  </table>
</center>
							 
							 	   <!-- FIN DE INGRESO DE CODIGO NUEVO --> 
								   </td>
								 </tr>
							 </table>	
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">
					  <?  include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close ($conn);?>
