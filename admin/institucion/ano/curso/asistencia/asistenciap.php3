<?php 	require('../../../../../util/header.inc');

	$institucion = $_INSTIT;
	$corporacion =$_CORPORACION;
	$_CURSO;
	
	
	//if($_PERFIL==0){
		$sql ="SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
		$rs_corp = @pg_exec($conn,$sql);
		$corporacion = @pg_result($rs_corp,0);
		
		$sql="SELECT clienteid,convenioid,token FROM institucion WHERE rdb=".$_INSTIT;
		$rs_convenio = pg_exec($connection,$sql);
		$cliente = pg_result($rs_convenio,0);
		$convenio = pg_result($rs_convenio,1);
		$token = pg_result($rs_convenio,2);
		
		$_CLIENTEID = $cliente;
		session_register('_CLIENTEID');
		
		$_CONVENIOID = $convenio;
		session_register('_CONVENIOID');
		
		$_TOKEN = $token;
		session_register('_TOKEN');
		

	//}
	 

	/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}	
//echo $frmModo;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">


<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
-->
</style>
<head>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =5;
	$_bot           =5;

$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL."";
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		//curso.ensenanza=".pg_result($rs_acceso,3)." AND
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			$whe_perfil_curso=" AND  id_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['id_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['id_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}else{
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=1)&&($_PERFIL!=25)&&($_PERFIL!=17)&&($_PERFIL!=19)) {$whe_perfil_ano=" and id_ano=$ano";}

if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL==17)&&($_PERFIL!=31)&&($_PERFIL!=35)&&($_PERFIL!=19)&&($_PERFIL!=30)&&($_PERFIL!=29)&&($_PERFIL!=28)&&($_PERFIL!=32)&&($_PERFIL!=1)){$whe_perfil_curso=" and curso.id_curso=$curso";}
		}
	$fecha=getdate();
	
    if ($cmbMes==NULL){
	    $cmbMes= $fecha["mon"];
		
	}	
	$diaActual=$fecha["mday"];	
		
	$qry1106="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO = '$ano' AND ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
	$result1106 =@pg_Exec($conn,$qry1106);
	
	if (!$result1106){
		error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
	}else{
		if (pg_numrows($result1106)!=0){
			$fila1106 = @pg_fetch_array($result1106,0);	
			if (!$fila1106){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}else{
			  $fila1106 = @pg_fetch_array($result1106,0);
			}	  
		}
								
	}
	
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
			$nroAno=trim($fila1['nro_ano']);
				
		}
	}
	
	
	//fechas curso 
	if($_CURSO>0){
	
	 $sqlfecur ="select fecha_inicio,fecha_termino from curso where id_curso=$curso";
	$rs_fecur = pg_exec($conn,$sqlfecur);
	$filaccc=pg_fetch_array($rs_fecur,0);
	$dia_i = $filaccc['fecha_inicio'];
	$dia_t = $filaccc['fecha_termino'];
	$fiano = explode("-",$dia_i);
	$teano = explode("-",$dia_t);
	
	if((strlen($dia_i)==0 || $dia_i=='1111-11-11') && (strlen($dia_t)==0 || $dia_t=='1111-11-11')){
	?>
    <script>
	alert("DEBE INGRESAR FECHA DE INICIO Y TERMINO DEL AÑO ESCOLAR DEL CURSO");
	location.href='../listarCursos.php3';
	</script>
    <?
	}
	
	}

if ($cmbMes!=""){
	//AJUSTA NRO DEL ULTIMO DIA SEGUN EL MES
	if(($cmbMes==2) and ($nroAno%4==0)){
		 $diaFinal=29;
		 $mes="02"; 
		}else{
		 $diaFinal=28;
		 $mes="02";
		 
	}
	if($cmbMes==1){ 
		$diaFinal=31; 
		$mes="01";
		$parte = 1;
		
		
	}
	if($cmbMes==2){ 
		$mes="02";
		$parte = ($fiano[1]==02)?(($fiano[2]<10)?str_replace("0","",$fiano[2]):$fiano[2]):1;
		
		if($fiano[1]==02){
		}
		
	}
	if($cmbMes==3){ 
		$diaFinal=31; 
		$mes="03";
		//$parte= ($fiano[2]<10)?str_replace("0","",$fiano[2]):$fiano[2];
		$parte = ($fiano[1]==03)?(($fiano[2]<10)?str_replace("0","",$fiano[2]):$fiano[2]):1;
	}
	if($cmbMes==4){ 
		$diaFinal=30; 
		$mes="04";
		$parte = 1;
	}
	if($cmbMes==5){ 
		$diaFinal=31; 
		$mes="05";
		$parte = 1;
	}
	if($cmbMes==6){ 
		$diaFinal=30; 
		$mes="06";
		$parte = 1;
	}
	if($cmbMes==7){ 
		$diaFinal=31; 
		$mes="07";
		$parte = 1;
	}
	if($cmbMes==8){ 
		$diaFinal=31; 
		$mes="08";
		$parte = 1;
	}
	if($cmbMes==9){ 
		$diaFinal=30; 
		$mes="09";
		$parte = 1;
	}
	if($cmbMes==10){ 
		$diaFinal=31; 
		$mes="10";
		$parte = 1;
	}
	if($cmbMes==11){ 
		$diaFinal=30; 
		$mes="11";
		$parte = 1;
	}
	if($cmbMes==12){ 
	    $termina= ($teano[2]<10)?str_replace("0","",$teano[2]):$teano[2];
		$diaFinal= $termina; 
		$mes="12";
		$parte = 1;
		
	}
	//FIN AJUSTA
}	
		
	//revisar periodos
	$qry_rp="select * from periodo where id_ano=$ano and (fecha_inicio is null or fecha_termino is null)";
	$result =@pg_Exec($conn,$qry_rp);
	if(pg_num_rows($result)>0)
	{$err = 1;}
	else {$err=0;}


	
?>
					

<SCRIPT language="JavaScript">

function enviapag3(form){
			if (form.cmbMes.value!=0){
				form.cmbMes.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'asistenciap.php3';
				form.submit(true);
	
				}	
			}
</SCRIPT>
<script language= "JavaScript">

function enviapag(form){
		var curso2, frmModo; 
		curso2=form.cmb_curso.value;
		frmModo = form.frmModo.value;
		
		if (form.cmb_curso.value!=0){
			form.cmb_curso.target="self";
			pag="../seteaCurso.php3?caso=11&p=8&curso="+curso2+"&frmModo="+frmModo
			form.action = pag;
			form.submit(true);	
		}		
 }
		 
 function enviapag2(form){
		var ano, frmModo; 
		ano2=form.cmb_ano.value;
		frmModo = form.frmModo.value;
		
		if (form.cmb_ano.value!=0){
			form.cmb_ano.target="self";
			pag="../../seteaAno.php3?caso=10&pa=6&ano="+ano2+"&frmModo="+frmModo
			form.action = pag;
			form.submit(true);	
		}		
 }

function compPeriodo(){
var cont = <?php echo $err ?>;
//alert (cont);
if(cont>0){
	alert ("Faltan datos de periodo para configurar.\nSerá redirigido a la configuración de periodo para solucionar el problema");
	location.href="../../periodo/listarPeriodo.php3";
	}

}

</script>
<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<style>
.td_temp{font:12px monospace; border:3px solid; text-align:center; height:1.5em; width:50px; vertical-align:top}
.td_temp2{font:12px monospace; border:0px solid; text-align:center; height:1.5em; vertical-align:top }
#contEncCol{overflow:hidden; overflow-y:scroll; background:#99CCFF; width:40em; vertical-align:top}
#encCol{}
#contEncFil{overflow:hidden; overflow-x:scroll; background:#FFFFFF; height:20em; vertical-align:top}
#contenedor{overflow:auto; width:40em; height:20em; vertical-align:top; vertical-align:top}
#contenido{}
.tabla td{border:1px solid; width:6em; vertical-align:top}
.rell{width:2em; height:0; position:relative; top:-1em; z-index:0; bor der:1px solid red; vertical-align:top}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="compPeriodo();MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53"  align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%">
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="1%" height="363" align="left" valign="top">
					  <table>
					  <tr> 
					  <td>&nbsp;
						</td>
						</tr>
						</table>
					  </td>
					
                      <td width="100%" align="left" valign="top">
					  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top" colspan="50"><? include("../../../../../cabecera/menu_superior.php"); ?></td>
                          </tr>
                          <tr> 
						  <td> 
						  <!-- inicio cuerpo de la pagina -->
<form name="form1" method="post" action="procesoAsistencia.php3">

<input type="hidden" name="cmbMes2" value="<? echo $cmbMes; ?>" >
							 
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td width="20%" class="Estilo1">A&ntilde;o Escolar </td>
    <td width="50%">: 
	

<?	

 $qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
$result =@pg_Exec($conn,$qry);

if (!$result) {
   error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
	}else{

if (pg_numrows($result)!=0){
	$filann = @pg_fetch_array($result,0);
	
	
   if (!$filann){
	error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
	exit();

			}

	} ?>

<input type="hidden" name="frmModo" value="<?=$frmModo ?>">
<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
<option value=0 selected>(Seleccione un Año)</option> <?

 for($i=0;$i < @pg_numrows($result);$i++){
    
	 $filann = @pg_fetch_array($result,$i); 
	
	 $id_ano  = $filann['id_ano'];  
	 $nro_ano = $filann['nro_ano'];
	 $situacion = $filann['situacion'];
	 
	 if ($situacion == 0){
		$estado = "Cerrado";
		}
	
	if ($situacion == 1){
		$estado = "Abierto";
		}	 	 
	
	if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
	
	echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
	
	  }else{	    
	
	echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
											  }
									       } ?>
								    </select>			                   
						 <? } ?>					  
							  
							  
</td>
<td width="30%" rowspan="2"><div align="center">
<label>
<? if($fila1106['situacion']==0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR
  
  }else{

  if ($ingreso==1 || $modifica==1){ 
		
		if ($frmModo=="mostrar" and $curso>0){	
		 
			                               		?>
<input class="botonXX"  type="button" name="Button2" value="MODIFICAR" onClick=window.location="seteaAsistencia.php3?caso=1&mes=<?php echo $cmbMes ?>">

<? }else{
										        
if ($frmModo=="ingresar"){ ?>

<input class="botonXX"  type="submit" name="Button" value="GUARDAR">
												    <?
												
												}								
										
										   } ?>			
								  
								   <? } ?>  
									  <?
								} ?>	
								</label>
								
                                <label>
								
								
<? if ($frmModo=="mostrar"){								
	
	if (($_PERFIL == 19) OR ($_PERFIL == 0) OR ($_PERFIL == 14) OR ($_PERFIL == 17) OR ($_PERFIL == 31)OR ($_PERFIL == 35) OR ($_PERFIL == 1) ){ ?>

<input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="../listarCursos.php3">
	
<? }else if($_PERFIL == 32) {?>

	<input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="../../../../../index.php">
<?
}

	}else{

if (($_PERFIL == 19) OR ($_PERFIL == 0) OR ($_PERFIL == 14) OR ($_PERFIL == 31) OR ($_PERFIL == 32) OR ($_PERFIL == 1)){ ?>

<input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="seteaAsistencia.php3?caso=2&mes=<?php echo $cmbMes ?>">
								  <? }							
								}
								?>  	
                                </label>
       <? if($_CONVENIOID!=""){?>
		   <input class="botonXX" type="button" name="botton3" value="INGRESO SIGE" onClick=window.location="Asistencia_Sige/asistencia_sige.php">
	    <? }?>
                              </div></td>
                            </tr>
                            <tr>
                              <td class="Estilo1">Curso</td>
                              <td>: 
<input type="hidden" name="frmModo" value="<?=$frmModo ?>">

<? // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS // 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
//echo $sql_curso;
$resultado_query_cue = @pg_exec($conn,$sql_curso); ?>
				 
<select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
<option value=0 selected>(Seleccione un Curso)</option><?
  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){  
	$filan = @pg_fetch_array($resultado_query_cue,$i); 
   		        				$Curso_pal = CursoPalabra($filan['id_curso'], 1, $conn);
	if (($filan['id_curso'] == $cmb_curso) or ($filan['id_curso'] == $curso)){
	echo "<option value=".$filan['id_curso']." selected>".$Curso_pal."</option>";
		        				}else{	    
	echo "<option value=".$filan['id_curso'].">".$Curso_pal."</option>";
     }
   } ?>
</select>
						    
</td>
</tr>
</table>

<input type="hidden" name="ensenanza" value="<?=$filan['ensenanza']; ?>">	
						  
<table width="100%" border="0">
<tr>
                              <td><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Feriado:</font></strong></td>
                              <td width="30" bgcolor="#FFE6E6">&nbsp;</td>
							  <td width="50" >&nbsp;</td>
                              <td><strong><font size="1" face="Arial, Helvetica, sans-serif">Fin 
              de Semana:</font></strong></td>
                              <td width="30" bgcolor="#c1bbbb">&nbsp;</td>
							  <td width="50" >&nbsp;</td>
                              <td><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Actual:</font></strong></td>
                              <td width="30" bgcolor="#FFFFD7">&nbsp;</td>
							  <td width="50" >&nbsp;</td>
                              <td><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Inasistencia:</font></td>
                              <td width="30" bgcolor="#E1EFFF">&nbsp;</td>
							  <td width="50" >&nbsp;</td>
                              <td><font size="1" face="Arial, Helvetica, sans-serif">Inasistencias del Mes:</font></td>
                              <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;I.M.</font></td>
                            </tr>
                          </table>
						  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="20%" class="Estilo1">INASISTENCIA</td>
                              <td width="80%">:
							  
							  <select name="cmbMes" onChange="enviapag3(this.form);">
							   <option value="0" selected>Selecciones Mes</option>
								<?php 
								if($cmbMes==""){
								   $fecha=getdate();
								   $cmbMes=$fecha["mon"];
								}
								if ($cmbMes=="01"){
									 echo "<option value=01 selected>ENERO</option>";
								}else	 
									echo "<option value=01>ENERO</option>";
								if ($cmbMes=="02"){
									echo "<option value=02 selected>FEBRERO</option>";
								}else 
									echo "<option value=02>FEBRERO</option>";
								 if ($cmbMes=="03"){
								echo "	<option value=03 selected>MARZO</option>";
								 }else 
									echo "<option value=03>MARZO</option>";
								 if ($cmbMes=="04"){
									echo "<option value=04 selected>ABRIL</option>";
								 }else 
									echo "<option value=04>ABRIL</option>";
								 if ($cmbMes=="05"){
									echo "<option value=05 selected>MAYO</option>";
								 }else
									echo "<option value=05>MAYO</option>";
								 if ($cmbMes=="06"){
									echo "<option value=06 selected>JUNIO</option>";
								 }else
									echo "<option value=06>JUNIO</option>";
								
								 if ($cmbMes=="07"){
								echo "	<option value=07 selected>JULIO</option>";
								 }else
									echo "<option value=07>JULIO</option>";
								 if ($cmbMes=="08"){
								echo "	<option value=08 selected>AGOSTO</option>";
								 }else
									echo "<option value=08>AGOSTO</option>";
								 if ($cmbMes=="09"){
									echo "<option value=09 selected>SEPTIEMBRE</option>";
								 }else
									echo "<option value=09>SEPTIEMBRE</option>";
								 if ($cmbMes=="10"){
									echo "<option value=10 selected>OCTUBRE</option>";
								 }else
									echo "<option value=10>OCTUBRE</option>";
								 if ($cmbMes=="11"){
								echo "<option value=11 selected>NOVIEMBRE</option>";
								 }else
									echo "<option value=11>NOVIEMBRE</option>";
								 if ($cmbMes=="12"){
								echo "<option value=12 selected>DICIEMBRE</option>";
								 }else	echo "<option value=12>DICIEMBRE</option>";
								 ?>
							  </select>
							  
							  
							  </td>
                            </tr>
                          </table>
						
						  <table width="100%" height="300" border="1">
                            <tr>
                              <td valign="top">
							  
							  
							  
							  <table width="100%" border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td height="10" bgcolor="#E2E2E2"><span class="Estilo1">n.</span></td>
								  <td height="25" bgcolor="#E2E2E2"><span class="Estilo1">Alumnos / D&iacute;as </span></td>
								  <?
								  
								  $cDias=$diaFinal;
                                  for($count=$parte ; $count<=$cDias; $count++){ ?>								  
								      <td bgcolor="#E2E2E2" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><? if ($count<10){ echo "0".$count; }else{ echo $count; } ?></font></td>
								
								<? } ?>	  
									  <td bgcolor="#E2E2E2" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">I.M.</font></td>
                                </tr>
								
								<?
								// sacamos la lista de alumnos
								$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista, matricula.bool_ar,matricula.fecha,matricula.fecha_retiro";
								$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
								$qry = $qry . " WHERE ((matricula.id_curso=".$curso.")) AND matricula.rdb='$institucion' ";
								
								//$qry = $qry . " AND bool_ar=0 ";
							/*	$qry = $qry . " AND matricula.fecha<='$nro_ano"."-".$mes."-".$diaFinal."' ";
								$qry = $qry . " AND (matricula.bool_ar=0 or matricula.fecha_retiro<='$nro_ano"."-".$mes."-".$diaFinal."') ";*/
								
								$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
								//echo $qry;
								$result =@pg_Exec($conn,$qry);

								if (!$result){
									//error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
								}else{
								    
									
$X=0;
for($i=0 ; $i < @pg_numrows($result) ; $i++){

$X++;
$Y=0; 

$fila1 = @pg_fetch_array($result,$i);
	//	 if(pg_dbname($conn)!="coi_antofagasta"){
//			/*$fecha_inicial =$cmbMes."-01-".$nroAno;
//			$fecha_final = $cmbMes."-".$diaFinal."-".$nroAno;*/
//			
//			$fecha_inicial =$nroAno."-".$cmbMes."-01";
//			$fecha_final = $nroAno."-".$cmbMes."-".$diaFinal;
//	    	
//		 }else{
//			/*$fecha_inicial =$cmbMes."-01-".$nroAno;
//			$fecha_final = $cmbMes."-".$diaFinal."-".$nroAno;*/
//			/*$fecha_inicial ="01-".$cmbMes."-".$nroAno;
//	    	$fecha_final = $diaFinal."-".$cmbMes."-".$nroAno;*/
//			$fecha_inicial =$nroAno."-".$cmbMes."-01";
//			$fecha_final = $nroAno."-".$cmbMes."-".$diaFinal;
//		 }
//		 
			$fecha_inicial =$nroAno."-".$cmbMes."-01";
			$fecha_final = $nroAno."-".$cmbMes."-".$diaFinal;
		 /*if(pg_dbname()=="coi_final"){
			 $fecha_inicial ="01-".$cmbMes."-".$nroAno;
	    	$fecha_final = $diaFinal."-".$cmbMes."-".$nroAno;
			 }*/
										 
		/*if($_PERFIL==0){
			 echo $corporacion;				 
			 exit;
			}*/
$qry9="select count(rut_alumno) as cantidad from asistencia 
where fecha between '".$fecha_inicial."' and '".$fecha_final."' 
and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;

 $result9 =@pg_Exec($conn,$qry9)or die("f9 ".$qry9);
 $fila9 = @pg_fetch_array($result9,0);
 $cant=$fila9["cantidad"];
										

										 
										 
$qry2="select rut_alumno, ano, id_curso, date_part('day',asistencia.fecha) AS day, date_part('month',asistencia.fecha) as mon, date_part('year',asistencia.fecha) AS year from asistencia where fecha between '".$fecha_inicial."' and '".$fecha_final."' and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;
	//if($_PERFIL==0) echo "<br>".$qry2;									
$result2 =@pg_Exec($conn,$qry2);

if (!$result2){
	error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$qry2);
			 }
										 
										 
if ($frmModo=="mostrar"){
				$fialu = explode("-",$fila1['fecha']);//echo $fila1['fecha'];
				$final= explode("-",$fecha_final);//echo $final[1];
				$fiter= ($fila1['fecha_retiro']!="")?explode("-",$fila1['fecha_retiro']):""; 				// echo $fila1['ape_pat']."-".$fiter[1];
			 ?>

<tr onmouseover="this.style.background='yellow'" onmouseout="this.style.background='transparent'" <?php echo (($fila1['bool_ar']==0 && $final[1]<$fialu[1]) || ($fila1['bool_ar']==1 && $final[1]>intval($fiter[1]) ) || ($fila1['bool_ar']==1 && $final[1]<intval($fialu[1]) ) )?'style="display:none"':'' ?> >
										 
										 	<TD align="left" valign="top" <? if ($fila1['bool_ar'] == 1){?>class="tachado2"<? }else{?>class="textosimple"<? }?> >
											<img src="trans.gif" width="0" height="18">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
									<?			if($fila1["nro_lista"]!=NULL){
													if($fila1["nro_lista"]<10){
														echo  trim($fila1["nro_lista"])." &nbsp;&nbsp;";
													}else{
														echo  trim($fila1["nro_lista"])." &nbsp;";
													}
												}else{
													echo  " &nbsp; &nbsp; &nbsp;";
												}
												?>
											</STRONG></FONT>
											</TD>
										 
										 
									       <td <? if ($fila1['bool_ar'] == 1){?>class="tachado2"<? }else{?>class="textosimple"<? }?>><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo  substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_alu"]),0,13);	?></font></td>
									     <?
										 $sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('month',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$sqlFer);
						}
							             $m=0;
										 $ñ=0;
										 $cDias=$diaFinal+2;
										 for($c=$parte;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								$filaFer=@pg_fetch_array($resultFer,$m);
								
								//if ($c<33)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){   ?>
										<TD align=center bgcolor='#FFE6E6' valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										</strong></font></TD>
	<?									$m++;
									}
									
									else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center  bgcolor='#FFE6E6' valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
											</strong></font></TD>
	<?									}
										$c=$c-1;
										$m++;
									}
									
									else{ 
										//if ($c==32){
										
										if ($c==($cDias-1)){	?>
											<!-- <TD align="center" valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<img src="../../../../../cortes/p.gif" width="20" height="9"><br>
<?											echo $cant;	?>
											</strong></font></TD> -->
	<?										$flag=1;
										}else{
											//if($_PERFIL==0) echo $c."--".$fila2["day"];
											if ($c==$fila2["day"]){
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#c1bbbb valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<img src="../../../../../cortes/p.gif" width="20" height="9"><br>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#c1bbbb valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}elseif(($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align="center" bgcolor="#FFFFD7" valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												//echo "3*".$c;	?>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}
	                                  
	
												else{ ?>
													<TD align=center bgcolor=#E1EFFF valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												//echo "4*".$c;	?>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}
												$ñ++;
											}
											else{
												
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#c1bbbb valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#c1bbbb valign="top">	<img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												
}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#c1bbbb valign="top">	<img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}
												else///
												if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>	                                                  <TD align=center  bgcolor='<?php echo ($fila1['bool_ar']==0)?"#FFFFD7":"#c1bbbb"; ?>' valign="top">
												       <img src="../../../../../cortes/p.gif" width="20" height="9"><br> 
													</TD>  
<?												}
												else{	
														/*if($_PERFIL==0){
/*															echo "<br>".$diaActual." ".$c;
															echo "<br>".$cmbMes." ".$fecha["mon"];
															echo "<br>".$nroAno." ".$fecha["year"];
													}*/
													if($fila1['bool_ar']==0){
														$diz=($c<10)?"0".$c:$c;
														$fpa=$nroAno."-".$cmbMes."-".$diz;
													
													if($fpa<$fila1['fecha']){
?>

													<TD align=center valign="top" bgcolor="#c1bbbb"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
                                                    <?
													}else{
														?>
                                                        <TD align=center valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
                                                        <?
														} // matricula posterior
                                                    } // asistencia
													//retiro antes
													if($fila1['bool_ar']==1){
														$diz=($c<10)?"0".$c:$c;
														$fpa=$nroAno."-".$cmbMes."-".$diz;
													
													//if($fpa>$fila1['fecha_retiro']){
														if($fpa<$fila1['fecha'] || $fpa>$fila1['fecha_retiro']){
?>

													<TD align=center valign="top" bgcolor="#c1bbbb"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
                                                    <?
													}else{
														?>
                                                        <TD align=center valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
                                                        <?
														} // matricula posterior
                                                    } // asistencia
													?>
<?												}
											}

										}
									}
								}//fin if $c<32
								 //if (($c==32) and ($flag!=1)){
								 if (($c==($cDias-1)) && ($flag!=1)){	?>
									<TD align=center valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?									echo "-".$cant;	?>
									</strong></font></TD> 
<?								}
							}//fin for($c=1;$c<32;$c++)							     
							
										?>								 
										<TD align=center valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;
		<? echo $cant;	?>
										</strong></font></TD>			 
																							
									</tr>
									<?
									
						}else{					
						

if($frmModo=="ingresar"){


$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";

$fialu = explode("-",$fila1['fecha']);//echo $fila1['fecha'];
				$final= explode("-",$fecha_final);//echo $final[1];
				$fiter= ($fila1['fecha_retiro']!="")?explode("-",$fila1['fecha_retiro']):""; 


$resultFer=@pg_Exec($conn,$sqlFer);
if (!$resultFer) {
	error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
	} ?>
	
<tr bgcolor=#ffffff onmouseover=this.style.background='red' this.style.cursor='hand' onmouseout=this.style.background='transparent' <?php echo (($fila1['bool_ar']==0 && $final[1]<$fialu[1]) || ($fila1['bool_ar']==1 && $final[1]>intval($fiter[1])) || ($fila1['bool_ar']==1 && $final[1]<intval($fialu[1]) ))?'style="display:none"':'' ?>>
  <TD align="left" valign="top"<? if ($fila1['bool_ar'] == 1){?>class="tachado2"<? }else{?>class="textosimple"<? }?>>
  <img src="trans.gif" width="0" height="18">
  
  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?	if($fila1["nro_lista"]!=NULL){
			if($fila1["nro_lista"]<10){
				echo  trim($fila1["nro_lista"])." &nbsp;&nbsp;";
				}else{
				echo  trim($fila1["nro_lista"])." &nbsp;";
				}
			}else{
				echo  " &nbsp; &nbsp; &nbsp;";
					}
				?>
	</STRONG></FONT>
	</TD>

<td <? if ($fila1['bool_ar'] == 1){?>class="tachado2"<? }else{?>class="textosimple"<? }?>><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo  substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_alu"]),0,13);	?></font></td>
<?						
	$m=0;
	$ñ=0;
	$cDias=$diaFinal+1;
							
	//for($c=1;$c<=32;$c++){
	
	for($c=$parte;$c<=$cDias;$c++){
		$fila2 = @pg_fetch_array($result2,$ñ);
		$filaFer=@pg_fetch_array($resultFer,$m);
		
		/*if($_PERFIL==0){
		echo "<br>".$filaFer["dia_ini"]."---".$filaFer["dia_fin"];
		}*/
		//if ($c<32)	{
	
	if ($c<$cDias)	{
		
if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){	?>
<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X;?>_<? echo $c; ?>" disabled>		
</strong></font></TD>
<?	$m++;
	
	}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){

for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>

<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X;?>_<? echo $c;?>" disabled>
</strong></font></TD>
<?	}
		$c=$c-1;
		$m++;
		
		}else{
			
			if ($c==$fila2["day"]){
			$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
			
			if($dia==6){///SABADO	?>

<TD align=center bgcolor=#c1bbbb><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" checked>
</strong></font></TD>
<?	}else///
		
	if($dia==0){///DOMINGO	?>
	
	<TD align=center bgcolor=#c1bbbb><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" disabled>
	</strong></font></TD>
<?	}else///
	
	if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"])  ){	?>
	
	<TD align=center  bgcolor='<?php echo ($fila1['bool_ar']==1)?"#FFE6E6":"#c1bbbb"; ?>'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	
	<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" checked>
	
	</strong></font></TD>

<?	}else{	?>

<TD align=center bgcolor='#E1EFFF'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>

<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" checked>
	</strong></font></TD>
<?	}
	
	$ñ++;
	}else{
	$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
	if($dia==6){///SABADO	
	$diz=($c<10)?"0".$c:$c;
		$fpa=$nroAno."-".$cmbMes."-".$diz;
		$diax = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
		
		if($fila1['bool_ar']==1 && $fpa>$fila1['fecha_retiro']){
		$marca="disabled";	
		}
		elseif($fila1['bool_ar']==1 && $fpa<$fila1['fecha']){
		$marca="disabled";	
		}
		elseif($fila1['bool_ar']==0 && $fpa<$fila1['fecha']){
		$marca="disabled";
		}
		else{
		$marca="";	
		}
		
	?>

<TD align=center bgcolor=#c1bbbb><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" <?php echo $marca; ?>>
</strong></font></TD>
<?										}else///

if($dia==0){///DOMINGO	?>
<TD align=center bgcolor=#c1bbbb><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" disabled>
</strong></font></TD>
<? 	}else

if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
<TD align=center  bgcolor='<?php echo ($fila1['bool_ar']==0)?"#FFFFD7":"#c1bbbb"; ?>'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" <?php echo ($fila1['bool_ar']==1)?"disabled":""; ?>>
</strong></font></TD>
<? }
elseif($fila1['bool_ar']==0){
		$diz=($c<10)?"0".$c:$c;
		$fpa=$nroAno."-".$cmbMes."-".$diz;
		$diax = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
	
	if($fpa<$fila1['fecha'] ){
		?>
        <TD align=center bgcolor=#c1bbbb><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" disabled>
</strong></font></TD>
        <?
	}
	else{	?>
<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>">
</strong></font></TD>
<?	
	      }
	}
	
elseif($fila1['bool_ar']==1){
		$diz=($c<10)?"0".$c:$c;
		$fpa=$nroAno."-".$cmbMes."-".$diz;
		$diax = (date("N", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
	
	if(($fpa>$fila1['fecha'] && $fpa>$fila1['fecha_retiro']) || $diax==6){
		if(trim(strtoupper($fila1['ape_pat']))=="RODRIGUEZ"){
		//echo "uno <br>".$fpa."---".$fila1['fecha'];
		}
		?>
        <TD align=center bgcolor=#c1bbbb><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" disabled>
        </strong></font></TD>

        <?
	}else if($fpa<$fila1['fecha'] && $fpa<=$fila1['fecha_retiro'] || $diax==6){
		
		if(trim(strtoupper($fila1['ape_pat']))=="RODRIGUEZ"){
		//echo "dos<br>".$fpa."---".$fila1['fecha'];
		}
		?>
        <TD align=center bgcolor=#c1bbbb><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" disabled>
        </strong></font></TD>
<?
	}
	else{	
	if(trim(strtoupper($fila1['ape_pat']))=="RODRIGUEZ"){
		//echo "tres<br>".$fpa."---".$fila1['fecha'];
		}
	?>
<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>">
</strong></font></TD>
<?	
	      }
	}  

	   }
																	
     }
  															
   }//fin if $c<32

  }//fin for($c=1;$c<32;$c++)

 }//fin if $frmModo

	?>
<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;</strong></font></TD>
</tr>
								
<tr <?php echo (($fila1['bool_ar']==0 && $final[1]<$fialu[1]) || ($fila1['bool_ar']==1 && $final[1]>intval($fiter[1]))|| ($fila1['bool_ar']==1 && $final[1]<intval($fialu[1]) ))?'style="display:none"':'' ?>>
<td height="10" bgcolor="#E2E2E2"><span class="Estilo1">&nbsp;</span></td>
<td height="25" bgcolor="#E2E2E2"><span class="Estilo1">D&iacute;as </span></td>
<?								  
$cDias=$diaFinal;
for($count=$parte ; $count<=$cDias; $count++){ ?>								  
<td bgcolor="#E2E2E2" align="center">
<font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">
<? if ($count<10){ echo "0".$count; }else{ echo $count; } ?></font></td>
<? } ?>	  
 <td bgcolor="#E2E2E2" align="center">
 <font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">I.M.</font></td>
</tr>
<?		
	 }	 /// fin if de modo mostrar e ingresar			
   } // fin for de alumnos
 } ?>

</table>
</form>	

   
   </td>
    </tr>
       </table></td>						 
						 </tr>
					   </table>
						  </td>
                            <td height="395" align="left" valign="top"> 
                     
						    </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
			    </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</td></tr></table>
</body>
</html>
<? pg_close($conn);?>