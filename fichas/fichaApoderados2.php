<?php 

require('../util/header.inc');
require('../util/funciones_new.php'); 

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$frmModo		="mostrar";
	$_POPS=2;
	

// REGISTRO DE HISTORIAL DE NAVEGACION

registrarnavegacion($_USUARIO,'FICHA APODERADOS',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);

//******************************************************//
	
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano." AND RUT_ALUMNO=".$alumno;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../menu_new/css/styles.css">
<link rel="stylesheet" type="text/css" href="../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css">
<script type="text/javascript" src="../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar AÑO.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
<?php }?>
<script language="javascript">

	function modifica(rut){
			
	}

 </script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" width="50" height="" rowspan="3" background="../cortes/<?=$institucion;?>/fondo_01_reca.jpg"></td>
    <td colspan="2" height="50" valign="top"><? include("../cabecera_new/head_sae.php"); ?></td>
    <td width="50" rowspan="3" background="../cortes/<?=$institucion;?>/fomdo_02_reca.jpg">&nbsp;</td>
  </tr>
  <tr>
  	<td valign="top" height="50%" width="287"> <? include("../menu_new/menu_alu_apo.php"); ?></td>
    <td valign="top"><br>

    <table width="95%" border="0" align="center" class="cajaborde">
      <tr>
        <td>&nbsp;
        <table width="95%" border="0" align="center">
  <tr>
    <td width="16%" class="titulo_new">INSTITUCI&Oacute;N</td>
    <td width="59%" class="textosimple">&nbsp;
	<?php
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
					exit();
				}
				echo trim($fila1['nombre_instit']);
			}
		}
	?></td>
    <td width="25%" rowspan="6">&nbsp;
    <?php
		$sql_arr = "select * from alumno where rut_alumno= '$alumno'";
		$result = pg_Exec($conn,$sql_arr);												
		$arr=pg_fetch_array($result);
														/*
		$output= "select lo_export('/opt/www/newsae/infousuario/images/".$arr[rut_alumno]."');";
		$retrieve_result = @pg_exec($conn,$output);
		$retrieve_result;
	if (!$retrieve_result){ */												
		$nombre_archivo = '../infousuario/images/'.$arr[rut_alumno];																																		 
	
		if (file_exists($nombre_archivo)) {?>
		   <img src="../infousuario/images/<?php echo $arr[rut_alumno]?>" ALT="NO DISPONIBLE" width=150></p>
	<?	} else { ?>
		   <img src="apoderado/imag/alumno222.jpg" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="150" height="150" id="ALUMNO">
	<?	}?>
    </td>
  </tr>
  <tr>
    <td class="titulo_new">A&Ntilde;O ESCOLAR</td>
    <td class="textosimple">&nbsp;
    <?php
		$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
					exit();
				}
				echo trim($fila1['nro_ano']);
			}
		}
	?>
    </td>
    </tr>
  <tr>
    <td class="titulo_new">CURSO</td>
    <td class="textosimple">&nbsp;
    <?php
// --- se agrego al query "tipo_ensenanza.cod_tipo" (pmeza) -----------
		$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo,tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
// ---------------------------------------------------------------------
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				}
				echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
				$tipo=$fila1['cod_tipo'];
			}
		}
	?>
    </td>
    </tr>
  <tr>
    <td class="titulo_new">ALUMNO</td>
    <td class="textosimple">&nbsp;
    <?php
		$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				}
				echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat'])." ".trim($fila1['nombre_alu']);
				
			}
		}
	?>
    </td>
    </tr>
  <tr>
    <td class="titulo_new">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    </tr>
  <tr>
    <td class="titulo_new">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    </tr>
    </table><br>
    <table width="650" border="0" cellpadding="1" cellspacing="1" align="center">
   	 	<TR height=20>
    		<TD class="tableindexredondo" align="center">FICHA APODERADOS</TD>
	    </TR>
    </table>
    <br>
    <?
	
		$sqlApoderado="select apoderado.*, tiene2.*, region.nom_reg, provincia.nom_pro, comuna.nom_com from apoderado, tiene2, region, comuna,
					   provincia where tiene2.rut_alumno = '".$alumno."' and apoderado.rut_apo = tiene2.rut_apo
					   and comuna.cod_reg = apoderado.region and comuna.cor_com = apoderado.comuna and comuna.cor_pro = apoderado.ciudad 
					   and region.cod_reg = apoderado.region and provincia.cod_reg = apoderado.region and provincia.cor_pro = apoderado.ciudad ";

					$rsApoderado = @pg_Exec($conn,$sqlApoderado);
					for($i=0 ; $i < @pg_numrows($rsApoderado) ; $i++){
						$fApoderado = @pg_fetch_array($rsApoderado,$i);
						$sqlFoto= "select lo_export(".$fApoderado[foto].",'/opt/www/coeint/tmp/".chop($fApoderado['rut_apo'])."');";
						$rsFoto = @pg_exec($conn,$sqlFoto);
						//-------
						$nombres = strtoupper($fApoderado['nombre_apo']);
						$apellidos = trim(strtoupper($fApoderado['ape_pat']))." ".trim(strtoupper($fApoderado['ape_mat']));
						$rut_apo = strtoupper($fApoderado['rut_apo'])."-".strtoupper($fApoderado['dig_rut']);
						$direccion = trim(strtoupper($fApoderado['calle']))." ".trim(strtoupper($fApoderado['nro']));
						$comuna = trim(strtoupper($fApoderado['nom_com']));
						$region = trim(strtoupper($fApoderado['nom_reg']));
						$ciudad = trim(strtoupper($fApoderado['nom_pro']));						
						$email = trim(strtoupper($fApoderado['email']));
						$telefono = trim(strtoupper($fApoderado['telefono']));
						$celular = trim(strtoupper($fApoderado['celular']));
						$nivel_edu = trim(strtoupper($fApoderado['nivel_edu']));
						$profesion = trim(strtoupper($fApoderado['profesion']));
						$lugar_trabajo = trim(strtoupper($fApoderado['lugar_trabajo']));
						$cargo= trim(strtoupper($fApoderado['cargo']));
						if ($fApoderado['relacion']==1) $relacion = "PADRE";
						if ($fApoderado['relacion']==2) $relacion = "MADRE";
						if ($fApoderado['relacion']==3) $relacion = "OTROS";
						if ($fApoderado['sostenedor']>0) $sostenedor = "SI"; else 	$sostenedor = "NO";
						if ($fApoderado['responsable']>0) $responsable = "Y RESPONSABLE"; else $responsable  = "";
						//-------
						if (empty($nombres))  $nombres = "&nbsp;";
						if (empty($apellidos))  $apellidos = "&nbsp;";
						if (empty($direccion))  $direccion = "&nbsp;";
						if (empty($comuna))  $comuna = "&nbsp;";
						if (empty($region))  $region = "&nbsp;";																								
						if (empty($ciudad))  $ciudad = "&nbsp;";																														
						if (empty($email))  $email = "&nbsp;";																														
						if (empty($telefono))  $telefono= "&nbsp;";
						if (empty($celular))  $celular = "&nbsp;";												
						if (empty($nivel_edu))  $nivel_edu = "&nbsp;";												
						if (empty($profesion))  $profesion = "&nbsp;";												
						if (empty($lugar_trabajo))  $lugar_trabajo = "&nbsp;";												
						if (empty($cargo))  $cargo = "&nbsp;";																																				
					?>
                   
			<table width="650" border="0" cellpadding="1" cellspacing="3" align="center">
					  <tr>
						<td colspan="4" align="center" class="tableindexredondo">DATOS - <? echo $relacion." ".$responsable ?>
       
                        </td>
					  </tr>
					  <tr><td>
                       <form method="post" name="frm" id="frm" action="mod_ficha_apoderado.php">
					  <table width="100%" border="0" cellspacing="3" cellpadding="0" class="cajaborde">
					  <tr>
						<td  rowspan="14" align="left" valign="top">
						<? if ($rsFoto){ ?>
                        <img src="../../../../../../../tmp/<? echo chop($fApoderado['rut_apo'])?>" alt="NO DISPONIBLE"  width=110>                        
						<? } ?>
						</td>
                        
						<td class="detalleon">Nombres</td>							
						<td class="detalleoff">&nbsp;<? echo $nombres?></td>
					    <td class="detalleon">Nivel Educacional</td>
					    <td align="left" valign="top" class="detalleoff">&nbsp;<? echo $nivel_edu?></td>
					  </tr>
					  <tr>
						<td class="detalleon">Apellidos</td>
						<td class="detalleoff">&nbsp;<? echo $apellidos?></td>
						<td class="detalleon">E-mail</td>
						<td class="detalleoff">&nbsp;<? echo $email?></td>
					  </tr>
					  <tr>
						<td class="detalleon">Tel&eacute;fono</td>
						<td class="detalleoff">&nbsp;<? echo $telefono?></td>
						<td class="detalleon">Celular</td>
						<td class="detalleoff">&nbsp;<? echo $celular?></td>
					  </tr>
					  <tr>
						<td class="detalleon">Direcci&oacute;n</td>
						<td class="detalleoff">&nbsp;<? echo $direccion?></td>
						<td class="detalleon">Relaci&oacute;n</td>
						<td class="detalleoff">&nbsp;<? echo $relacion?></td>
					  </tr>
					  <tr>
						<td class="detalleon">Comuna</td>
						<td class="detalleoff">&nbsp;<? echo $comuna?></td>
					    <td class="detalleon">Sostenedor</td>
					    <td class="detalleoff">&nbsp;<? echo $sostenedor?></td>
					  </tr>
					  <tr>
					    <td class="detalleon">Ciudad</td>
					    <td class="detalleoff">&nbsp;<? echo $ciudad?></td>
					    <td class="detalleon">Profesi&oacute;n</td>
					    <td align="left" valign="top" class="detalleoff">&nbsp;<? echo $profesion?></td>
				      </tr>
					  <tr>
						<td class="detalleon">Reg&iacute;on</td>
						<td class="detalleoff">&nbsp;<? echo $region?></td>
					    <td class="detalleon">Cargo</td>
					    <td align="left" valign="top" class="detalleoff">&nbsp;<? echo $cargo?></td>
					  </tr>
					  <tr>
					    <td class="detalleon">Lugar de Trabajo </td>
					    <td align="left" valign="top" class="detalleoff">&nbsp;<? echo $lugar_trabajo?></td>
                      </tr>
                      <tr><td></td><td></td><td></td>
                      <? $fecha=date("d-m-Y");
					  if(($_PERFIL==15 && $institucion!=24988) || ($_PERFIL==15 && $institucion==24988 && $fecha<'26-03-2015')){?>
                      <td>
                       <input align="right" class="botonXX"  name="button1" type="button" value="MODIFICAR"  onClick="window.location='mod_ficha_apoderado.php?rut_apo=<?=$fApoderado['rut_apo'];?>'"></td>
                      <? }?>
                      </tr> 
					  </table>
                      </form>
					</td></tr>
					</table>
                         <img src="../cortes/24907/sombra.png" width="885" height="32"> 
					<br>
					
								
				<? } ?>	
                <?
				 //$sql_hermanos = "select hermanos.* from hermanos, relacion_hermanos where relacion_hermanos.rut_alumno = '$alumno' and hermanos.rut_hermano = hermanos.rut_hermano";
				$sql_hermanos = "select hermanos.* from hermanos INNER JOIN relacion_hermanos ON  hermanos.rut_hermano=relacion_hermanos.rut_hermano
 where relacion_hermanos.rut_alumno = '$alumno'";
				$rsHermanos = @pg_Exec($conn,$sql_hermanos);
				if (@pg_numrows($rsHermanos)>0){
				?>
					<table width="650" border="0" cellpadding="1" cellspacing="1">
 					 	<TR height=20 bgcolor=#0099cc >
							<TD class="tableindex" align="center">
							HERMANOS
							</TD>
 						</TR>
					</table>		
				<? } ?>
					<br>
				<?
					for($i=0 ; $i < @pg_numrows($rsHermanos) ; $i++){
						$fHemanos = @pg_fetch_array($rsHermanos,$i);				
						$rut_hermano = trim($fHemanos['rut_hermano'])."-".trim($fHemanos['dig_rut']);
						$nombre_hermano = ucwords(strtolower(trim($fHemanos['nombre_hermano'])));
						$apellidos = ucwords(strtolower(trim($fHemanos['ape_pat'])))." ".ucwords(strtolower(trim($fHemanos['ape_mat'])));
						$fecha_nac = Cfecha(trim($fHemanos['fecha_nac']));
						$estudios = ucwords(strtolower(trim($fHemanos['estudios'])));
				?>							
					<table width="650" border="1" cellspacing="0" cellpadding="1" align="center">
					  <tr>
					  </tr>
					  <tr>  
						<td class="detalleon">Nombres</td>
						<td class="detalleoff">&nbsp;<? echo $nombre_hermano?></td>
						<td class="detalleon">Apellidos</td>
						<td class="detalleoff">&nbsp;<? echo $apellidos?></td>
					  </tr>
					  <tr>
						<td class="detalleon">Fecha Nacimiento</td>
						<td class="detalleoff">&nbsp;<? echo $fecha_nac?></td>
                        <td class="detalleon">Estudios</td>
                        <td colspan="3" class="detalleoff">&nbsp;<? echo $estudios?></td>
				      </tr>
			  </table>
			     <img src="../cortes/24907/sombra.png" width="885" height="32"> 
			  <? } ?>
             
        </td>
      </tr>
    </table>
<br>

    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="89">&nbsp;<img src="../cabecera_new/img/abajo.jpg" width="1140" height="89" border="0" /></td>
  </tr>
</table>
</body>
</html>
