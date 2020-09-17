<?php 	require('../../../../../../util/header.inc');
//print_r($_POST);
//echo pg_dbname();
$fecha_cal=$txtFECHA;

$separar_fecha = explode('/',$fecha_cal);
 "ano->".$ano_cal=$separar_fecha[0];
 "mes->".$mes_cal=$separar_fecha[1];
 "dia->".$dia_cal=$separar_fecha[2];
 $cmbMes=$mes_cal;
	$institucion = $_INSTIT;
	$corporacion =$_CORPORACION;
	
	if($_PERFIL==0){
		$sql ="SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
		$rs_corp = @pg_exec($conn,$sql);
		$corporacion = @pg_result($rs_corp,0);
	}
	 

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

<link rel="stylesheet" type="text/css" href="../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">

<script type="text/javascript" src="../../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>

<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.widget.js"></script>




<script language="JavaScript" type="text/JavaScript">
<!--



function calendario(){
	
	 $("#txtFECHA").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'yy/mm/dd'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']	
	}
	
	
	


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
div.ui-datepicker{
font-size:12px;
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
	$_POSP          =6;
	$_bot           =5;
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=17)&&($_PERFIL!=19)) {$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=19)&&($_PERFIL!=30)&&($_PERFIL!=32)){$whe_perfil_curso=" and curso.id_curso=$curso";}


 $sql_fercur ="select * from feriado_curso where id_curso=".$_CURSO;
	 $rs_fercur = pg_exec($conn,$sql_fercur);

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
	}
	if($cmbMes==2){ 
		$mes="02";
	}
	if($cmbMes==3){ 
		$diaFinal=31; 
		$mes="03";
	}
	if($cmbMes==4){ 
		$diaFinal=30; 
		$mes="04";
	}
	if($cmbMes==5){ 
		$diaFinal=31; 
		$mes="05";
	}
	if($cmbMes==6){ 
		$diaFinal=30; 
		$mes="06";
	}
	if($cmbMes==7){ 
		$diaFinal=31; 
		$mes="07";
	}
	if($cmbMes==8){ 
		$diaFinal=31; 
		$mes="08";
	}
	if($cmbMes==9){ 
		$diaFinal=30; 
		$mes="09";
	}
	if($cmbMes==10){ 
		$diaFinal=31; 
		$mes="10";
	}
	if($cmbMes==11){ 
		$diaFinal=30; 
		$mes="11";
	}
	if($cmbMes==12){ 
		$diaFinal=31; 
		$mes="12";
	}
	//FIN AJUSTA
}	
	
?>
					

<SCRIPT language="JavaScript">

function enviapag3(form){
	
			
		 var fecha_de_hoy="<? echo date('Y/m/d')?>"
		// alert(fecha_de_hoy);
		if($('#txtFECHA').val()>fecha_de_hoy){
		alert("no pude ser mayor al dia de hoy")
		$('#txtFECHA').val("")
		$('#fecha_actual').val("")
		return false;
		}
			
			if ($('#txtFECHA').val()!=0){
				
				var cmbMes = <?=$cmbMes?>;
				//alert(cmbMes);
				//form.txtFECHA.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'asistencia_sige.php';
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
			pag="../../seteaCurso.php3?caso=11&p=21&curso="+curso2+"&frmModo="+frmModo
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
			pag="../../../seteaAno.php3?caso=10&pa=40&ano="+ano2+"&frmModo="+frmModo
			form.action = pag;
			form.submit(true);	
		}		
 }
 
 
 function envia_formulario(form1){
	 
	 if($('#fecha_actual').val()==""){
	 alert("ingrese fecha");
	 return false;
	 }
	        
			pag="asistencia_dia_sige.php";
			form1.action = pag;
			form1.target="self";
			form1.submit(true);	
	 
	 
 }

</script>
<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
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
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="calendario()">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53"  align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
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
                            <td align="left" valign="top" colspan="50"><? include("../../../../../../cabecera/menu_superior.php"); ?></td>
                          </tr>
                          <tr> 
						  <td> 

<!-- inicio cuerpo de la pagina -->

<form name="form1" method="post" action="asistencia_dia_sige.php">


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
<input class="botonXX" type="button" name="btn_asistencia_sige" value="COMPROBAR ASISTENCIA SIGE" onClick="window.location='ConsultaAsistenciaSige.php'">
<label>
<? if($fila1106['situacion']==0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR
  
  }else{

  if ($ingreso==1 || $modifica==1){ 
		
		if ($frmModo=="mostrar" and $curso>0){	  
			                               		?>



<input class="botonXX"  type="button" name="Button2" value="INGRESAR" onClick="envia_formulario(this.form)" >

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
	
	if (($_PERFIL == 19) OR ($_PERFIL == 0) OR ($_PERFIL == 14)){ ?>

<input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="../../listarCursos.php3">
	
<? } 

	}else{

if (($_PERFIL == 19) OR ($_PERFIL == 0) OR ($_PERFIL == 14)){ ?>

<input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="seteaAsistencia.php3?caso=2&mes=<?php echo $cmbMes ?>">
								  <? }							
								}
								
								?>  	
                                
                                </label>
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

					  
<table width="100%" border="0">
<tr>
                              <td><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Feriado:</font></strong></td>
                              <td width="30" bgcolor="#FFE6E6">&nbsp;</td>
							  <td width="50" >&nbsp;</td>
                              <td><strong><font size="1" face="Arial, Helvetica, sans-serif">Fin 
              de Semana:</font></strong></td>
                              <td width="30" bgcolor="#EAEAEA">&nbsp;</td>
							  <td width="50" >&nbsp;</td>
                              <td><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Actua:</font></strong></td>
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
                              <td width="20%" >INASISTENCIA</td>
                              <td width="80%">:
							  
<div id="fecha">
<label >Seleccionar Fecha:
 <input type="text" name="txtFECHA" id="txtFECHA" readonly onChange="enviapag3(this.form)" >
</label>
</div>
							  
							  
							  </td>
                            </tr>
                           <tr>
                              <td width="20%" >&nbsp;</td>
                              <td width="80%">:
							  
<div id="fecha">
<label >Fecha Escogida:&nbsp;&nbsp;&nbsp;
 <input type="text" name="fecha_actual" id="fecha_actual" readonly value="<?=$fecha_cal?>" >
</label>
</div>
							  
							  
							  </td>
                            </tr> 
                            
                          </table>
						
					<!--	  <table width="100%" height="300" border="1">-->
                            <tr>
                              <td valign="top">
							  
							  <table width="100%" border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td height="10" bgcolor="#E2E2E2"><span class="Estilo1">n.</span></td>
								  <td height="25" bgcolor="#E2E2E2"><span class="Estilo1">Alumnos / D&iacute;as </span></td>
								  <?
								  
								  $cDias=$diaFinal;
                                  for($count=1 ; $count<=$cDias; $count++){ ?>								  
								      <td bgcolor="#E2E2E2" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><? if ($count<10){ echo "0".$count; }else{ echo $count; } ?></font></td>
								
								<? } ?>	  
									  <td bgcolor="#E2E2E2" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">I.M.</font></td>
                                </tr>
								
								<?
								// sacamos la lista de alumnos
								$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista ";
								$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
								$qry = $qry . " WHERE ((matricula.id_curso=".$curso.") AND ((matricula.bool_ar=0)or(matricula.bool_ar isnull))) AND matricula.rdb='$institucion' ";
								$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
								$result =@pg_Exec($conn,$qry);

								if (!$result){
									//error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
								}else{
								    
									
$X=0;
for($i=0 ; $i < @pg_numrows($result) ; $i++){

$X++;
$Y=0; 

$fila1 = @pg_fetch_array($result,$i);
			
		 if($corporacion==13){
			$fecha_inicial =$cmbMes."-01-".$nroAno;
			$fecha_final = $cmbMes."-".$diaFinal."-".$nroAno;
	    	
		 }else{
			$fecha_inicial =$cmbMes."-01-".$nroAno;
			$fecha_final = $cmbMes."-".$diaFinal."-".$nroAno;
			/*$fecha_inicial ="01-".$cmbMes."-".$nroAno;
	    	$fecha_final = $diaFinal."-".$cmbMes."-".$nroAno;*/
		 }
		 
		if(pg_dbname()=="coi_final_vina"){
		$fecha_inicial=$nro_ano.'-'.$cmbMes.'-01';
		$fecha_final=$nro_ano.'-'.$cmbMes.'-'.$diaFinal;
		}
										 
		/*if($_PERFIL==0){
			 echo $corporacion;				 
			 exit;
			}*/
$qry9="select count(rut_alumno) as cantidad from asistencia 
where fecha between '".$fecha_inicial."' and '".$fecha_final."' 
and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;
										
 $result9 =@pg_Exec($conn,$qry9)or die("fallo ".$qry9);
 $fila9 = @pg_fetch_array($result9,0);
 $cant=$fila9["cantidad"];
										
									 
										 
$qry2="select rut_alumno, ano, id_curso, date_part('day',asistencia.fecha) AS day, date_part('month',asistencia.fecha), date_part('year',asistencia.fecha) AS year from asistencia where fecha between '".$fecha_inicial."' and '".$fecha_final."' and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;

$result2 =@pg_Exec($conn,$qry2)or die("fallo 77 ".$qry2);

										 
if ($frmModo=="mostrar"){
								 
			 ?>

<tr onmouseover=this.style.background='yellow' onmouseout=this.style.background='transparent'>
										 
										 	<TD align="left" valign="top">
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
										 
										 
									       <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo  substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_alu"]),0,13);	?></font></td>
									     <?
										// $sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('month',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
										
												 if(pg_numrows($rs_fercur)==0){ 
										 
										 $sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('month',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
										}
									else{
											 $sqlFer="select feriado.id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado inner join feriado_curso on feriado_curso.id_feriado=feriado.id_feriado where date_part('month',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano."  and id_curso =".$curso." order by dia_ini";	 
											 }
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$sqlFer);
						}
							             $m=0;
										 $ñ=0;
										 $cDias=$diaFinal+2;
										 for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								$filaFer=@pg_fetch_array($resultFer,$m);
								
								//if ($c<33)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){   ?>
										<TD align=center bgcolor='#FFE6E6' valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><img src="../../../../../../cortes/p.gif" width="20" height="1"><br>
										</strong></font></TD>
	<?									$m++;
									}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6' valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><img src="../../../../../../cortes/p.gif" width="20" height="1"><br>
											</strong></font></TD>
	<?									}
										$c=$c-1;
										$m++;
									}else{
										//if ($c==32){
										if ($c==($cDias-1)){	?>
											<!-- <TD align="center" valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<img src="../../../../../cortes/p.gif" width="20" height="9"><br>
<?											echo $cant;	?>
											</strong></font></TD> -->
	<?										$flag=1;
										}else{
											if ($c==$fila2["day"]){
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<img src="../../../../../../cortes/p.gif" width="20" height="9"><br>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><img src="../../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if(($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align=center bgcolor=#FFFFD7 valign="top"><img src="../../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												//echo "3*".$c;	?>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else{ ?>
													<TD align=center bgcolor=#E1EFFF valign="top"><img src="../../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												//echo "4*".$c;	?>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}
												$ñ++;
											}
											else{
												
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><img src="../../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA valign="top">	<img src="../../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>	                                                  <TD align=center bgcolor=#FFFFD7 valign="top">
												       <img src="../../../../../../cortes/p.gif" width="20" height="9"><br> 
													</TD>  
<?												}else{	?>
													<TD align=center valign="top"><img src="../../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}
											}

										}
									}
								}//fin if $c<32
								 //if (($c==32) and ($flag!=1)){
								 if (($c==($cDias-1)) and ($flag!=1)){	?>
									<TD align=center valign="top"><img src="../../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?									echo $cant;	?>
									</strong></font></TD> 
<?								}
							}//fin for($c=1;$c<32;$c++)							     
							
										?>								 
										<TD align=center valign="top"><img src="../../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;
		<?								echo $cant;	?>
										</strong></font></TD>			 
																							
									</tr>
									<?
									
						}else{					
						

//if($frmModo=="ingresar"){}//fin if $frmModo

	?>
<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;</strong></font></TD>
</tr>
								
<tr>
<td height="10" bgcolor="#E2E2E2"><span class="Estilo1">&nbsp;</span></td>
<td height="25" bgcolor="#E2E2E2"><span class="Estilo1">D&iacute;as </span></td>
<?								  
$cDias=$diaFinal;
for($count=1 ; $count<=$cDias; $count++){ ?>								  
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
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
			    </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</td></tr></table>
</body>
</html>
<? pg_close($conn);?>