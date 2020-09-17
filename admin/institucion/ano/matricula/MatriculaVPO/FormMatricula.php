<?php
require('../../../../../util/header.inc');
include ("Calendario/calendario.php");

function CambioFechaDisplay($fecha)   
// cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}

foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   } 	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente
	
	
	
	
   
  




//busco comunas
$sql_com="select * from comuna";
$res_com=pg_exec($conn,$sql_com);
$tipo=0;
		
if (isset($_POST['busca']))
{
//busco en postulaciones
$sql_pos="select * from formulario_postulacion where rut=$rut and id_estado=1";
$res_pos=pg_exec($conn,$sql_pos);
	 if(pg_numrows($res_pos)>0)
	{
		//echo "encontre en postulaciones<br>";
		//busco datod de postulaciones
		$fil_pos=@pg_fetch_array($res_pos,0);
		$proc=$fil_pos['rdb_origen'];
		$preferencia=$fil_pos['preferencia'];
		$grado_mat=$fil_pos['grado'];
		
		//busco datos del alumno
		$sql_alum="select * from alumno where rut_alumno=".$rut;
		$res_alumn=pg_exec($conn,$sql_alum);
		if(pg_numrows($res_alumn)>0)
		{
			//echo "encontre en alumno<br>";
			$fil_alum = @pg_fetch_array($res_alumn,0);
			$nombres=$fil_alum['nombre_alu'];
			$direccion=$fil_alum['calle'];
			$nro=$fil_alum['nro'];
			$fono=$fil_alum['telefono'];
			$rut_alu=$fil_alum['rut_alumno'];
			$dv_alu=$fil_alum['dig_rut'];
			$cerro=$fil_alum['cerro'];
			$lugar=$fil_alum['lugar'];
			$comuna=$fil_alum['comuna'];
			$tipo=1;
			
			if(strlen($fil_alum['cursosrep'])>3)
			{
				$reps="checked";
				$rep=$fil_alum['cursosrep'];
			}
			else
			$repn="checked";
			
			if(strlen($fil_alum['religion'])>3)
			{
				$rels="checked";
				$religion=$fil_alum['religion'];
			}
			else
			$reln="checked";
			
			
			//datos apoderado
			 $sql_apo="SELECT * FROM apoderado INNER JOIN tiene2 ON (apoderado.rut_apo = tiene2.rut_apo)
WHERE (tiene2.responsable = 1) AND (tiene2.rut_alumno =".$rut.")";
			$res_apo=@pg_exec($conn,$sql_apo);
			$fil_apo=@pg_fetch_array($res_apo,0);
			
			//madre
			$sql_mad="SELECT * FROM public.apoderado INNER JOIN tiene2 ON (apoderado.rut_apo = tiene2.rut_apo) WHERE (apoderado.relacion = 2) and (tiene2.rut_alumno =".$rut.")";
			$res_mad=@pg_exec($conn,$sql_mad);
			$fil_mad=@pg_fetch_array($res_mad,0);
			
			//padre
			$sql_pad="SELECT * FROM public.apoderado INNER JOIN tiene2 ON (apoderado.rut_apo = tiene2.rut_apo) WHERE (apoderado.relacion=1) and (tiene2.rut_alumno =".$rut.")";
			$res_pad=@pg_exec($conn,$sql_pad);
			$fil_pad=@pg_fetch_array($res_pad,0);
			
			
		}
		
		//colegio prodecencia
		 /* //nombre institucion
		$sql_inst = "SELECT * FROM institucion INNER JOIN formulario_postulacion ON (institucion.rdb = formulario_postulacion.rdb_origen) WHERE (formulario_postulacion.rdb_origen = 9566) AND (formulario_postulacion.preferencia = 1)";
		$res_inst = @pg_Exec($conn,$sql_inst);
		$fil_inst = @pg_fetch_array($res_inst,0);
		$nom_inst = $fil_inst['nombre_instit']; */
		
		//colegio matricula
		 $sql_cole="SELECT * FROM institucion INNER JOIN formulario_postulacion ON (institucion.rdb = formulario_postulacion.prefe_".$preferencia.") where formulario_postulacion.preferencia=".$preferencia." and rut=".$rut." and id_estado=1";
		$res_cole = @pg_Exec($conn,$sql_cole);
		$fil_cole = @pg_fetch_array($res_cole,0);
		$nom_cole = $fil_cole['nombre_instit'];
		$rdb_cole = $fil_cole['rdb'];
		
		//ano_escolar
		//año escolar
		$sql_ano = "select * from ano_escolar where id_institucion = ".$rdb_cole." order by nro_ano desc limit 1";
		$result_ano =@pg_Exec($conn,$sql_ano);
		$fila_ano = @pg_fetch_array($result_ano,0);
		$nro_ano = $fila_ano['nro_ano'];
		$id_ano = $fila_ano['id_ano'];
		
		//busco cursos
		 $sql_cur = "select * from curso where id_ano = ".$id_ano."  and ensenanza >300 and  grado_curso=$grado_mat order by ensenanza,grado_curso,letra_curso";
		$res_ano_actual = @pg_Exec($conn,$sql_cur);
		
	}
	
	
		if($institucion!=$rdb_cole)		
		{
		
		?>
	<script>
	  alert('Alumno no corresponde a institución');
	  window.open('FormMatricula.php','_self');
   </script>
	<?
		}
		
	
	
	//busco datos en matricula
	$sql_mat="select * from matricula where rut_alumno=$rut_alu";
	$res_mat=@pg_exec($conn,$sql_mat);
	$fila_mat=@pg_fetch_array($res_mat,0);
	
	/* //busco en alumno_retiro
	$sql_ret="select * from alumno_retiro where rut_alumno=$rut_alu and id_ano=$ano";
	$res_ret=@pg_exec($conn,$sql_ret);
	$fila_ret=@pg_fetch_array($res_ret,0); */


	//busco socioeconomico
	$sql_socio="select * from alumno_socioeconomico where rut_alumno=$rut_alu";
	$res_socio=@pg_exec($conn,$sql_socio);
	$fila_socio=@pg_fetch_array($res_socio,0);
	
	if ($fila_socio['agua']=="si")
	$check_agua="checked";
	if ($fila_socio['luz']=="si")
	$check_luz="checked";
	if ($fila_socio['bano']=="si")
	$check_bano="checked";
	if ($fila_socio['wc']=="si")
	$check_wc="checked";
	if ($fila_socio['alcantarillado']=="si")
	$check_alcan="checked";
	if ($fila_socio['pozoseptico']=="si")
	$check_pozo="checked";
	
	if ($fila_socio['tiene_unif']=="si")
	$check_unif="checked";
	else
	$check_unifn="checked";
	
	if ($fila_socio['tipo_vivienda']=="Propia")
	$t_p="selected";
	if ($fila_socio['tipo_vivienda']=="Arrendada")
	$t_a="selected";
	if ($fila_socio['tipo_vivienda']=="Cedida")
	$t_ce="selected";
	if ($fila_socio['tipo_vivienda']=="Canon")
	$t_ca="selected";
	
	
	//colegio procedencia
	$sql_proc="select rdb,nombre_instit from institucion where rdb=".$proc; 
	$res_proc=@pg_exec($conn,$sql_proc);
	$fila_proc=@pg_fetch_array($res_proc,0);
	
	$colegioprocedencia=$fila_proc['nombre_instit'];
}//fin busqueda
   
   
     
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" src="Calendario/javascripts.js"></script>
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	</script>
	
<SCRIPT language="JavaScript">
			
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<!--validar los rut -->
<script language="javascript" src="FUNCIONES.JS"> 

</script> 
<style>
.texto {
	font-family: Verdana;
	font-size: 10px;
}
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr><tr>
    <td>
    
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td valign="top"><table width="100%"><tr><td><table width="100%"><tr><td><?
				include("../../../../../cabecera/menu_superior.php");
				?></td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../../menus/menu_lateral.php");
						?>					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES --><!-- FIN CODIGO DE BOTONES -->
                                

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<center>
<table width="709" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<form action=""   method="post" name="form"  >
	<table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr class="tableindex">
      <td colspan="5"><div align="center">BUSQUEDA ALUMNO </div></td>
    </tr>
    <tr> <td width="14%">&nbsp;</td><td width="43%">&nbsp;</td><td width="14%">&nbsp;</td><td width="14%">&nbsp;</td><td width="15%">&nbsp;</td> </tr>
     <tr> <td class="texto">&nbsp;&nbsp;&nbsp;RUT</td><td colspan="4"><input type="text" name="rut" size="9" maxlength="8" value="<?php echo $rut ?>"> - <input type="text" name="dig" size="1" maxlength="1" value="<?php echo $dig ?>"></td> </tr>
  <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
<tr><td colspan="5"><div align="center">
  <input name="busca" type="submit" id="busca" value="Buscar Alumno" onClick="validar(this.form)" class="botonxx">
</div></td></tr>   </table>	
</form>
	<br>
	<?php if ((strlen($rut)!=0) and (strlen($dig)!=0))
	{?>
<form action="InsertoMatricula.php" name="form2" method="post" onSubmit="return comprobar(this)">
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" >
                              <tr class="tableindex">
                                <td colspan="4"><div align="center">
                                   <input name="institucion" type="hidden" value="<?php echo $rdb_cole ?>">
								  <input name="ano" type="hidden" value="<?php echo $id_ano ?>">
                                    FICHA DE MATRICULA </div></td>
                                </tr>

                              <tr>
                                <td colspan="4">&nbsp;</td>
                                </tr>
                              <tr>
                                <td width="17%" class="texto">Establecimiento</td>
                                <td colspan="3" class="texto"><?php echo $nom_cole ?></td>
                                </tr>
                              <tr>
                                <td class="texto">Curso</td>
                                <td colspan="3">
								<select name="curso" >
								<option value="">--Seleccione--</option>
								<?php for($i=0;$i<pg_numrows($res_ano_actual);$i++)
								{
									$fil_cur = @pg_fetch_array($res_ano_actual,$i);
									//tipo enseñanza
									$sql_ense="select * from tipo_ensenanza where cod_tipo= ".$fil_cur['ensenanza'];
									$res_ense=pg_exec($conn,$sql_ense);
									$fil_ense = @pg_fetch_array($res_ense,0);
									
									$nom_cur=$fil_cur['grado_curso'].$fil_cur['letra_curso'];
									$id_cur=$fil_cur['id_curso'];
									$nom_ese=$fil_ense['nombre_tipo'];
									
								?>
								<option value="<?php echo $id_cur ?>"><?php echo $nom_cur ?> - <?php echo $nom_ese ?></option>
								<?php }?>
                                </select></td>
                                </tr>
                              <tr>
                                <td><span class="texto">N&ordm; Matr&iacute;cula </span></td>
                                <td><input name="num_mat" type="text" id="num_mat" value="<?php echo $fila_mat['num_mat'] ?>"  size="12" /></td>
                                <td width="19%"><span class="texto">Fecha</span></td>
                                <td><input name="fecha_mat" type="text" id="fecha_mat" value="<?php echo strftime("%d/%m/%Y",time()) ?>"  size="12" />    
                                  <?php echo escribe_formulario_fecha_vacio("fecha_mat","form2"); ?></td>
                                </tr>
                            </table><br>
<br>
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" >
							<tr  class="tableindex">
                                <td colspan="2"><div align="center">DATOS DEL ALUMNO </div></td>
                                </tr>
                              <tr>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                              <tr>
                                <td width="18%" class="texto">RUT</td>
                                <td>
								
								<input type="text" name="rut_alu" size="9" maxlength="8" value="<?php echo $rut ?>" > 
                                        - 
                                          <input type="text" name="dig_alu" size="1" maxlength="8" value="<?php echo $dig ?>" onBlur="validar_alu(form2)"></td>
                                </tr>
                              <tr>
                                <td class="texto">Apellido Paterno </td>
                                <td><input name="ape_pat" type="text" id="ape_pat"  size="50" value="<?php echo $fil_alum['ape_pat'] ?>"></td>
                                </tr>
                              <tr>
                                <td class="texto">Apellido Materno</td>
                                <td><input name="ape_mat" type="text" id="ape_mat"  size="50" value="<?php echo $fil_alum['ape_mat'] ?>"></td>
                                </tr>
                              <tr>
                                <td class="texto">Nombres</td>
                                <td><input name="nombre_alu" type="text" id="nombre_alu"  size="50" value="<?php echo $nombres ?>"></td>
                                </tr>
                              <tr>
                                <td class="texto">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="texto">Sexo</td>
                                <td><select name="sexo" id="sexo" >
								
                                  <option value="0">--Seleccione--</option>
                                  <option value="2" <?php if ($fil_alum['sexo']== 2) echo "selected"?>>Masculino</option>
                                  <option value="1" <?php if ($fil_alum['sexo']== 1) echo "selected"?>>Femenino</option>
                                                                                                </select></td>
                              </tr>
                              <tr>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                              <tr>
                                <td class="texto">Fecha de Nac. </td>
                                <td class="texto"><input name="fecha_nacimiento" type="text" id="fecha_nac" value="<?php echo CambioFechaDisplay($fil_alum['fecha_nac']) ?>"  size="12" />    
                                  <?php echo escribe_formulario_fecha_vacio("fecha_nacimiento","form2"); ?></td>
                                </tr>
                              <tr>
                                <td class="texto">Lugar</td>
                                <td class="texto"><input name="lugar" type="text" id="lugar" value="<?php echo $lugar ?>"  size="30"></td>
                              </tr>
                              <tr>
                                <td colspan="2">&nbsp;</td>
                                </tr>
                              <tr>
                                <td class="texto">Domicilio</td>
                                <td><div align="left">
                                  <input name="calle" type="text" id="calle"  size="50" value="<?php echo $direccion ?>">
                                </div></td>
                                </tr>
                              <tr>
                                <td class="texto">N&ordm;</td>
                                <td><span class="texto">
                                  <input name="nro" type="text" id="nro" value="<?php echo $nro ?>"  size="12" />
                                </span></td>
                                </tr>
                              <tr>
                                <td class="texto">Cerro</td>
                                <td><input name="cerro" type="text" id="cerro" value="<?php echo $cerro ?>"  size="30"></td>
                                </tr>
                              <tr>
                                <td class="texto">Fono</td>
                                <td><input name="telefono" type="text" id="telefono"  size="12" value="<?php echo $fono ?>"></td>
                                </tr>
                              <tr>
                                <td class="texto">Comuna</td>
                                <td><select name="comuna" >
                                  <option value="0">--Seleccione--</option>
								 <?php  for($i=0;$i<pg_numrows($res_com);$i++)
								  {
								  	$fil_com = @pg_fetch_array($res_com,$i);
								  	
								  ?>
								  <option value="<?php echo $fil_com['nom_com'] ?>" <?php if ($comuna==$fil_com['cor_com']) echo "selected"?>><?php echo $fil_com['nom_com'] ?></option>
								  <?php }?>
                                </select></td>
                              </tr>
                              <tr>
                                <td colspan="2">&nbsp;</td>
                                </tr>
							</table>
<br>
<br>
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr class="tableindex">
                                <td colspan="3"><div align="center">
                                  <input type="hidden" name="ano" value="<?php echo $ano ?>">
								  
                                  ANTECEDENTES ESCOLARES </div></td>
                                </tr>
                              <tr>
                                <td width="30%" class="texto">&nbsp;</td>
                                <td width="70%" class="texto">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="texto">Escuela de Prodedencia </td>
                                <td class="texto"><input name="colegioprocedencia" type="text" id="colegioprocedencia"  size="50" value="<?php echo $colegioprocedencia ?>" ></td>
                              </tr>
                              <tr>
                                <td class="texto">&iquest;Repite Curso Actual?                                  </td>
                                <td colspan="2" class="texto"><input name="rep" type="radio" value="si" <?php echo $reps ?> />
                                  si 
                                    <input name="rep" type="radio" value="no" <?php echo $repn ?> />
                                    no</td>
                                </tr>
                              <tr>
                                <td class="texto">Cursos que ha repetido                                  </td>
                                <td colspan="2" class="texto"><input name="cursosrep" type="text" id="cursosrep"  value="<?php echo $rep ?>" size="20"></td>
                                </tr>
                              <!--<tr>
                                <td class="texto">Causas de Cancelaci&oacute;n de Matr&iacute;cula </td>
                                <td class="texto"><textarea name="txt_canc_mat" cols="30"><? echo $fila_ret['detalle_retiro'] ?></textarea></td>
                                </tr>-->
                              <tr>
                                <td class="texto">&iquest;Religi&oacute;n?</td>
                                <td colspan="2" class="texto"><input name="rel" type="radio" value="si" <?php echo $rels ?>/>
                                  si 
                                    <input name="rel" type="radio" value="no" <?php echo $reln ?> />
                                    no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&iquest;Cu&aacute;l?
                                    <input name="religion" type="text" id="religion"  size="20" value="<?php echo $religion ?>"></td>
                                </tr>
                            </table>
<br>
<br>
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr class="tableindex">
    <td colspan="6"><div align="center">ANTECEDENTES FAMILIARES </div></td>
    </tr>
  <tr>
    <td class="texto">&nbsp;</td>
    <td colspan="5" class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto">Rut del Padre </td>
    <td colspan="5" class="texto"><input type="text" name="rut_padre" size="9" maxlength="8" value="<?php echo $fil_pad['rut_apo'] ?>"  >
      
                                     - 
                                    <input type="text" name="dig_padre" size="1" maxlength="8" onBlur="validar_padre(form2)" value="<?php echo $fil_pad['dig_rut'] ?>"></td>
  </tr>
  <tr>
    <td width="24%" class="texto">Nombre </td>
    <td colspan="5" class="texto"><input name="nom_pad" type="text" id="nom_pad"  size="50"  value="<?php echo $fil_pad['nombre_apo'] ?>"></td>
    </tr>
	<td class="texto">Apellido Paterno </td>
                                <td class="texto" colspan="5"><input name="ape_pat_pad" type="text" id="ape_pat_apo"  size="50" value="<?php echo $fil_pad['ape_pat'] ?>"></td>
                              </tr>
                              <tr>
                                <td class="texto">Apellido Materno </td>
                                <td class="texto" colspan="5"><input name="ape_mat_pad" type="text" id="ape_mat_apo3"  size="50" value="<?php echo $fil_pad['ape_mat'] ?>"></td>
  
  <tr>
    <td class="texto">Profesi&oacute;n u oficio </td>
    <td colspan="5" class="texto"><input name="pad_prof" type="text" id="pad_prof"  size="50" value="<?php echo $fil_pad['profesion'] ?>"></td>
    </tr>
  <tr>
    <td colspan="6" class="texto">&nbsp;</td>
    </tr>
  <tr>
    <td class="texto">Rut de la madre </td>
    <td colspan="5" class="texto"><input type="text" name="rut_madre" size="9" maxlength="8" value="<?php echo $fil_mad['rut_apo'] ?>"  >
      
                                     - 
                                    <input type="text" name="dig_madre" size="1" maxlength="8" onBlur="validar_madre(form2)" value="<?php echo $fil_mad['dig_rut'] ?>"></td>
  </tr>
  <tr>
    <td class="texto">Nombre </td>
    <td colspan="5" class="texto"><input name="nom_mad" type="text" id="nom_mad"  size="50" value="<?php echo $fil_mad['nombre_apo'] ?>"></td>
    </tr>
	<td class="texto">Apellido Paterno </td>
                                <td class="texto" colspan="5"><input name="ape_pat_mad" type="text" id="ape_pat_apo"  size="50" value="<?php echo $fil_mad['ape_pat'] ?>"></td>
                              </tr>
                              <tr>
                                <td class="texto">Apellido Materno </td>
                                <td class="texto" colspan="5"><input name="ape_mat_mad" type="text" id="ape_mat_apo3"  size="50" value="<?php echo $fil_mad['ape_mat'] ?>"></td>
  
  <tr>
    <td class="texto">Profesi&oacute;n u oficio </td>
    <td colspan="5" class="texto"><input name="mad_prof" type="text" id="mad_prof"  size="50" value="<?php echo $fil_mad['profesion'] ?>"></td>
    </tr>
  <tr>
    <td colspan="6" class="texto">&nbsp;</td>
    </tr>
  <tr>
    <td class="texto">Padres</td>
    <td colspan="5" class="texto"><select name="p_viv_jun" >
      <option value="">--Seleccione--</option>
	  <option value="Viven Juntos" <?php if ($fila_socio['estado_padres']=="Viven Juntos") echo "selected" ?>>Viven juntos</option>
	  <option value="Separados" <?php if ($fila_socio['estado_padres']=="Separados") echo "selected" ?>>Separados</option>
    </select></td>
    </tr>
  <tr>
    <td class="texto">&iquest;Alumno(a) con qui&eacute;n vive?</td>
    <td colspan="5" class="texto"><input name="alu_cqv" type="text" id="alu_cqv"  size="50" value="<?php echo $fila_socio['alu_conquienvive'] ?>"></td>
  </tr>
  <tr>
    <td class="texto">Familia: Total de Hijos </td>
    <td width="21%" class="texto"><input name="cant_hijos" type="text" id="cant_hijos"  size="12" value="<?php echo $fila_socio['cant_hijos'] ?>"></td>
    <td colspan="3" class="texto">Lugar que ocupa entre ellos </td>
    <td width="30%" class="texto"><input name="nrohijo" type="text" id="nrohijo"  size="12" value="<?php echo $fila_socio['hijo_num'] ?>"></td>
  </tr>
</table>
<br>
<br>
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" >
                              <tr class="tableindex">
                                <td colspan="4"><div align="center">DATOS DEL APODERADO </div></td>
                                </tr>
                              <tr >
                                <td colspan="4" class="texto">&nbsp;</td>
                                </tr>
                              <tr >
                                <td width="24%" class="texto">Rut del Apoderado </td>
                                <td colspan="3" class="texto">
                                  <input type="text" name="rut_apoderado" size="9" maxlength="8" value="<?php echo $fil_apo['rut_apo'] ?>" >       
                                  - 
                                  <input type="text" name="dig_apoderado" size="1" maxlength="8" onBlur="validar_apoderado(form2)" value="<?php echo $fil_apo['dig_rut'] ?>"></td></tr>
                              <tr>
                                <td class="texto">Nombre Completo </td>
                                <td colspan="3" class="texto"><input name="nom_apo" type="text" id="nom_apo"  size="50" value="<?php echo $fil_apo['nombre_apo'] ?>"></td>
                                </tr>
                              <tr>
                                <td class="texto">Apellido Paterno </td>
                                <td colspan="3" class="texto"><input name="ape_pat_apo" type="text" id="ape_pat_apo"  size="50" value="<?php echo $fil_apo['ape_pat'] ?>"></td>
                              </tr>
                              <tr>
                                <td class="texto">Apellido Materno </td>
                                <td colspan="3" class="texto"><input name="ape_mat_apo" type="text" id="ape_mat_apo3"  size="50" value="<?php echo $fil_apo['ape_mat'] ?>"></td>
                              </tr>
                             <tr>
                                <td class="texto">Grado Parentezco </td>
                                <td colspan="3" class="texto"><select name="parent_apo" >
                                  <option value="0">--Seleccione--</option>
								  <option value="1" <?php if($fil_apo['relacion']==1) echo "selected"?>>Padre</option>
								  <option value="2" <?php if($fil_apo['relacion']==2) echo "selected"?>>Madre</option>
								  <option value="3" <?php if($fil_apo['relacion']==3) echo "selected"?>>Otro</option>
                                </select></td>
                                </tr>
                              <tr>
                                <td class="texto">Domicilio</td>
                                <td colspan="3" class="texto"><input name="dom_apo" type="text" id="dom_apo"  size="50" value="<?php echo $fil_apo['calle'] ?>">                                  &nbsp;&nbsp;&nbsp;</td>
                                </tr>
                              <tr>
                                <td class="texto">N&ordm;</td>
                                <td colspan="3" class="texto"><input name="nro_apo" type="text" id="nro_apo"  size="12" value="<?php echo $fil_apo['nro'] ?>"/></td>
                                </tr>
                              <tr>
                                <td class="texto">Tel&eacute;fono</td>
                                <td colspan="3" class="texto"><input name="fon_apo" type="text" id="fon_apo"  size="12" value="<?php echo $fil_apo['telefono'] ?>"></td>
                                </tr>
                              <tr>
                                <td class="texto">Cerro</td>
                                <td colspan="3" class="texto"><input name="cerro_apo" type="text" id="cerro2"  size="50" value="<?php echo $fil_apo['cerro'] ?>"></td>
                              </tr>
                              <tr>
                                <td class="texto">Comuna</td>
                                <td colspan="3" class="texto"><select name="comuna_apo" >
                                  <option value="0">--Seleccione--</option>
								 <?php  for($i=0;$i<pg_numrows($res_com);$i++)
								  {
								  	$fil_com = @pg_fetch_array($res_com,$i);
								  
								  ?>
								  <option value="<?php echo $fil_com['nom_com'] ?>" <?php if ($comuna==$fil_com['cor_com']) echo "selected"?>><?php echo $fil_com['nom_com'] ?></option>
								  <?php }?>
                                </select></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="texto">&nbsp;</td>
                                </tr>
                              <tr>
                                <td colspan="4" class="texto">Nivel Educacional </td>
                                </tr>
                              <tr>
                                <td class="texto">Padre</td>
                                <td colspan="3" class="texto"><input type="text" name="n_educ_padre" value="<?php echo $fil_pad['nivel_edu'] ?>" >
                                 </td>
                                </tr>
                              <tr>
                                <td class="texto">Madre</td>
                                <td colspan="3" class="texto"><input type="text" name="n_educ_madre" value="<?php echo $fil_mad['nivel_edu'] ?>">
                                  </td>
                              </tr>
                              <tr>
                                <td class="texto">Apoderado</td>
                                <td colspan="3" class="texto"><input type="text" name="n_educ_apo"  value="<?php echo $fil_apo['nivel_edu'] ?>">
                                  </td>
                                </tr>
                              <tr>
                                <td class="texto">&nbsp;</td>
                                <td colspan="3" class="texto">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="texto">En caso de emergecia llamar a </td>
                                <td colspan="3" class="texto"><input name="contacto_emer" type="text" id="contacto_emer" size="50" value="<?php echo $fil_alum['contacto_emergencia'] ?>"></td>
                              </tr>
                              <tr>
                                <td class="texto">Fono</td>
                                <td colspan="3" class="texto"><input name="fono_emer" type="text" id="fono_emer" value="<?php echo $fil_alum['fono_contacto'] ?>"></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="texto">&nbsp;</td>
                                </tr>
                            </table>
<br>
<br>
<?
//buscar socioeconomicos



?>
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr class="tableindex">
    <td colspan="5" ><div align="center">ANTECEDENTES SOCIO-ECONOMICOS </div></td>
    </tr>
  <tr>
    <td width="22%" class="texto">&nbsp;</td>
    <td width="19%" class="texto">&nbsp;</td>
    <td width="14%" class="texto">&nbsp;</td>
    <td width="40%" class="texto">&nbsp;</td>
    <td width="5%" class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto">Vivienda</td>
    <td colspan="3" class="texto"><select name="tipo_vivienda">
      <option value="">--seleccione--</option>
	  <option value="Propia" <?php echo $t_p ?>>Propia</option>
	  <option value="Arrendada" <?php echo $t_a ?>>Arrendada</option>
	  <option value="Cedida" <?php echo $t_ce ?>>Cedida</option>
	  <option value="Canon" <?php echo $t_ca ?>>Canon</option>
    </select></td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto">N&ordm; personas que la habitan </td>
    <td class="texto"><input type="text" name="n_hab"  size="12" Separados value="<?php echo $fila_socio['num_habi_viv'] ?>" /></td>
    <td class="texto">N&ordm; de piezas </td>
    <td class="texto"><input type="text" name="n_pie"  size="12" value="<?php echo $fila_socio['num_piezas'] ?>" /></td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="texto">&nbsp;</td>
    </tr>
  <tr>
    <td class="texto">Domicilio cuenta con: </td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto">Agua Potable </td>
    <td class="texto"><input type="checkbox" name="agua" value="si" <?php echo $check_agua ?>/></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto">Luz el&eacute;ctrica </td>
    <td class="texto"><input name="luz" type="checkbox" id="luz" value="si" <?php echo $check_luz ?> /></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto">Ba&ntilde;o completo </td>
    <td class="texto"><input name="bano" type="checkbox" id="bano" value="si" /></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto">S&oacute;lo WC </td>
    <td class="texto"><input name="wc" type="checkbox" id="wc" value="si" /></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto">Alcantarillado</td>
    <td class="texto"><input name="alcantarillado" type="checkbox" id="alcantarillado" value="si" /></td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
    <td class="texto">&nbsp;</td>
  </tr>
  <tr>
    <td class="texto">Pozo Negro </td>
    <td class="texto"><input name="pozo_negro" type="checkbox" id="pozo_negro" value="si" /></td>
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
    <td class="texto">Total Entradas familiares $ </td>
    <td class="texto"><input name="tot_entradas" type="text" id="tot_entradas"  size="12" value="<?php echo $fila_socio['tot_ing_fam'] ?>" /></td>
    <td class="texto">Unidad Vecinal N&ordm; </td>
    <td class="texto"><input name="uni_vecinal" type="text" id="uni_vecinal"  size="12" value="<?php echo $fila_socio['uni_vecinal'] ?>" /></td>
    <td class="texto">&nbsp;</td>
  </tr>
</table><br>
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
                                <td colspan="5">Enfermedades anteriores, discapacidad, o utros antecedentes significativos que se pueden anotar </td>
                              </tr>
                              <tr class="texto">
                                <td colspan="5">
                                  <div align="center">
                                    <textarea name="salud" cols="50" rows="6"><?php echo $fil_alum['salud']; ?></textarea>
                                    </div></td></tr>
                              <tr>
                                <td class="texto">&nbsp;</td>
                                <td class="texto">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr class="texto">
                                <td colspan="5">&iquest;Tiene uniforme?
                                  <input name="tie_unif" type="radio" value="si" <?php echo $check_unif ?> />
                                  si&nbsp;&nbsp; <input name="tie_unif" type="radio" value="no" <?php echo $check_unifn ?> />
                                  no</td>
                              </tr>
                              <tr class="texto">
                                <td colspan="5">&nbsp;</td>
                              </tr>
                              
                              
                              <tr class="texto">
                                <td colspan="5">&nbsp;</td>
                              </tr>
                              <tr class="texto">
                                <td colspan="5"><div align="center">
                                  <input name="submit" type="submit" value="Aceptar" class="botonxx">
                                </div></td>
                              </tr>
  </table>
<br>
<br>
</form>
<?php }?></td>
</tr>
</table>	</td>
  </tr>
</table>
<br>
<br>


								 
<!-- FIN FORMULARIO DE BUSQUEDA -->								  </td>
                                </tr>
                              </table>						    </td>
                          </tr>
                        </table>					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>    </td>
  </tr>
</table>
</body>
</html>
