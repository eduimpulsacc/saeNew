<?php 	require('../../../../util/header.inc');

	$institucion = $_INSTIT;
	$corporacion =$_CORPORACION;
	$_CURSO;
	
	/*if($_PERFIL==0){
	show($_SESSION)
	}

	*/
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
		if(strlen($menu)==0)$menu=10;
		if(strlen($categoria)==0)$categoria=53;
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
		
		
		
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
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
	
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =4;
	$_bot           =4;
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=19)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25) &&($_PERFIL!=19)){$whe_perfil_curso=" and curso.id_curso=$curso";}

if($frmModo=="")
{
$frmModo = mostrar;
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
				form.action = 'asistencia.php';
				form.submit(true);
	
				}				
			}
</SCRIPT>
<script language= "JavaScript">
var ancho , alto , cCeldas , celdas , pasoH , pasoV;

/*
function iniciar(){
	celdas0 = document.getElementById("encCol").getElementsByTagName("td").length;
	celdas1 = document.getElementById("contenido").getElementsByTagName("td").length;

	for (i=0; i<celdas0;i++){
		cCeldas = document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML;
		document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML = cCeldas+"<img class=\"rell\">";
	}

	for (j=0; j<celdas1;j++){
		cCeldas = document.getElementById("contenido").getElementsByTagName("td").item(j).innerHTML;
		document.getElementById("contenido").getElementsByTagName("td").item(j).innerHTML = cCeldas+"<img class=\"rell\">";
	}
}
*/


function iniciar(){
	celdas0 = document.getElementById("encCol").getElementsByTagName("td").length;
	
	for (i=0; i<celdas0;i++){
		cCeldas = document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML;
		document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML = cCeldas+"<img class=\"rell\">";

		cCeldas2 = document.getElementById("contenido").getElementsByTagName("td").item(i).innerHTML;
		document.getElementById("contenido").getElementsByTagName("td").item(i).innerHTML = cCeldas2+"<img class=\"rell\">";
	}
}


function desplaza(){
	pasoH = document.getElementById("contenedor").scrollLeft;
	pasoV = document.getElementById("contenedor").scrollTop;
	document.getElementById("contEncCol").scrollLeft = pasoH;
//	document.getElementById("contEncFil").scrollTop = pasoV;
}

function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="seteaAsistencia.php3?caso=11&p=15&curso="+curso2+"&frmModo="+frmModo
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
				pag="../seteaAno.php3?caso=10&pa=40&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}
					
		 }

</script>
<LINK REL="STYLESHEET" HREF="../../../util/td.css" TYPE="text/css">
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
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="compPeriodo();MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53"  align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
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
                            <td align="left" valign="top" colspan="50"><? include("../../../../cabecera/menu_superior.php"); ?></td>
                          </tr>
                          <tr> 
						  <td> 
						  <!-- inicio cuerpo de la pagina -->
<form name="form1" method="post" action="procesoAsistencia.php">

<input type="hidden" name="cmbMes2" value="<? echo $cmbMes; ?>" >
							 
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td width="30%"><div align="right">
  <label>
  <? if($fila1106['situacion']==0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR
  
  }else{

  if ($ingreso==1 || $modifica==1){ 
		
		if ($frmModo=="mostrar" ){	
		 
			                               		?>
  <input class="botonXX"  type="button" name="Button2" value="MODIFICAR" onClick=window.location="seteaAsistencia.php?caso=1&mes=<?php echo $cmbMes ?>">
    
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
	
	if (($_PERFIL == 19) OR ($_PERFIL == 0) OR ($_PERFIL == 14) OR ($_PERFIL == 17) OR ($_PERFIL == 31)OR ($_PERFIL == 35) OR ($_PERFIL == 1)){ ?>
        
  <input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="../../empleado/listarEmpleado.php3">
        
  <? } 

	}else{

if (($_PERFIL == 19) OR ($_PERFIL == 0) OR ($_PERFIL == 14) OR ($_PERFIL == 31) OR ($_PERFIL == 1)){ ?>
        
  <input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="seteaAsistencia.php?caso=2&mes=<?php echo $cmbMes ?>">
        <? }							
								}
								?>  	
        </label>
  
    </div></td>
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
                              <td width="30" bgcolor="#EAEAEA">&nbsp;</td>
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
                              <td class="Estilo1"><div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>A�O 
              ESCOLAR</strong> </FONT> </div></td>
                              <td>
                             <?php
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
                <input type="hidden" name="diaFinal" value="<?=$diaFinal?>">

						<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un A�o)</option> <?
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
				<? }	?> </td>
                            </tr>
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
								  <td height="25" bgcolor="#E2E2E2">&nbsp;</td>
								  <?
								  
								  $cDias=$diaFinal;
                                  for($count=1 ; $count<=$cDias; $count++){ ?>								  
								      <td bgcolor="#E2E2E2" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><? if ($count<10){ echo "0".$count; }else{ echo $count; } ?></font></td>
								
								<? } ?>	  
									  <td bgcolor="#E2E2E2" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">I.M.</font></td>
                                </tr>
								<?
								   //Nombres de los alumnos				
	$qry="SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp asc ";
	$result = pg_Exec($qry);	



								if (!$result){
									//error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
								}else{
								    
									
$X=0;
for($i=0 ; $i < @pg_numrows($result) ; $i++){

$X++;
$Y=0; 

$fila1 = @pg_fetch_array($result,$i);
		//$cmbMes= ($cmbMes<10)?(0$cmbMes:$cmbMes;
			
			$fecha_inicial =$nroAno."-".$mes."-01";
			$fecha_final = $nroAno."-".$mes."-".$diaFinal;
		 
		 
		
/*$qry9="select count(rut_alumno) as cantidad from asistencia 
where fecha between '".$fecha_inicial."' and '".$fecha_final."' 
and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;

 $result9 =@pg_Exec($conn,$qry9)or die("f9 ".$qry9);
 $fila9 = @pg_fetch_array($result9,0);
 $cant=$fila9["cantidad"];
 */
 //trae todas las anotaciones
					$qry_atraso = "select fecha, id_anotacion from anotacion_empleado where rut_emp = '$fila1[rut_emp]' and tipo = 2 and fecha >= '$fecha_inicial' and fecha <= '$fecha_final'";
					$res_atraso = @pg_Exec($qry_atraso);	
					$num_anota = @pg_numrows($res_atraso);
					//if($_PERFIL==0) echo "<br>".$qry_atraso;									
$result2 =@pg_Exec($conn,$qry_atraso);

if (!$result2){
	error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$qry_atraso);
			 }
										

										 

										 
/*$qry2="select rut_alumno, ano, id_curso, date_part('day',asistencia.fecha) AS day, date_part('month',asistencia.fecha) as mon, date_part('year',asistencia.fecha) AS year from asistencia where fecha between '".$fecha_inicial."' and '".$fecha_final."' and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;
	//if($_PERFIL==0) echo "<br>".$qry2;									
$result2 =@pg_Exec($conn,$qry2);

if (!$result2){
	error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$qry2);
			 }*/

	$qry_atraso3 = "select date_part('day',anotacion_empleado.fecha) AS day, date_part('month',anotacion_empleado.fecha) as mon, date_part('year',anotacion_empleado.fecha) AS year from anotacion_empleado where rut_emp = '$fila1[rut_emp]' and tipo = 2 and fecha >= '$fecha_inicial' and fecha <= '$fecha_final'";
					$res_atraso3 = @pg_Exec($qry_atraso3);	
					$num_anota3 = @pg_numrows($res_atraso3);
					//if($_PERFIL==0) echo "<br>".$qry_atraso3;									
$result3 =@pg_Exec($conn,$qry_atraso3);

if (!$result3){
	error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$qry_atraso3);
			 }					 
										 
if ($frmModo=="mostrar"){
								 
			 ?>

<tr onmouseover=this.style.background='yellow' onmouseout=this.style.background='transparent'>
										 
										 	<TD align="center" class="textosimple"><FONT face="arial, geneva, helvetica" size=1 color=#000000><?php echo $i+1 ?>
									
											</FONT>
											</TD>
										 
										 
									       <td class="textosimple"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo  substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_emp"]),0,13);	?></font></td>
									     <?
										 $sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('month',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$sqlFer);
						}
							             $m=0;
										 $�=0;
										 $cDias=$diaFinal+2;
										 for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result3,$�);
								$filaFer=@pg_fetch_array($resultFer,$m);
								
								//if ($c<33)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) && ($filaFer["dia_fin"]=="")){   ?>
										<TD align=center bgcolor='#FFE6E6' valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><img src="../../../../cortes/p.gif" width="20" height="1"><br>
										</strong></font></TD>
	<?									$m++;
									}else if (($c>=$filaFer["dia_ini"]) && ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6' valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><img src="../../../../cortes/p.gif" width="20" height="1"><br>
											</strong></font></TD>
	<?									}
										$c=$c-1;
										$m++;
									}else{ 
										//if ($c==32){
										if ($c==($cDias-1)){	?>
										
	<?										$flag=1;
										}else{
											//if($_PERFIL==0) echo $c."--".$fila2["day"];
											if ($c==$fila2["day"]){
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<img src="../../../../cortes/p.gif" width="20" height="9"><br>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><img src="../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}elseif(($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align=center bgcolor=#FFFFD7 valign="top"><img src="../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												//echo "3*".$c;	?>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else{ ?>
													<TD align=center bgcolor=#E1EFFF valign="top"><img src="../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												//echo "4*".$c;	?>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}
												$�++;
											}
											else{
												
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><img src="../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA valign="top">	<img src="../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>	                                                  <TD align=center bgcolor=#FFFFD7 valign="top">
												       <img src="../../../../cortes/p.gif" width="20" height="9"><br> 
													</TD>  
<?												}else{	
														if($_PERFIL==0){
/*															echo "<br>".$diaActual." ".$c;
															echo "<br>".$cmbMes." ".$fecha["mon"];
															echo "<br>".$nroAno." ".$fecha["year"];
	*/													}
?>
													<TD align=center valign="top"><img src="../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}
											}

										}
									}
								}//fin if $c<32
								 //if (($c==32) and ($flag!=1)){
								 if (($c==($cDias-1)) && ($flag!=1)){	?>
									<TD align=center valign="top"><img src="../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?									echo "-".$cant;	?>
									</strong></font></TD> 
<?								}
							}//fin for($c=1;$c<32;$c++)							     
							
										?>								 
										<TD align=center valign="top"><img src="../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;
		<? echo $num_anota;	?>
										</strong></font></TD>			 
																							
									</tr>
									<?
									
						}else{					
						

if($frmModo=="ingresar"){


$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";


$resultFer=@pg_Exec($conn,$sqlFer);
if (!$resultFer) {
	error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
	} ?>
	
<tr bgcolor=#ffffff onmouseover=this.style.background='red' this.style.cursor='hand' onmouseout=this.style.background='transparent'>
  <TD align="center" class="textosimple"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>

				
	</STRONG></FONT>
	<FONT face="arial, geneva, helvetica" size=1 color=#000000><?php echo $i+1 ?></FONT></TD>

<td class="textosimple"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo  substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_emp"]),0,13);	?></font></td>
<?						
	$m=0;
	$�=0;
	$cDias=$diaFinal+1;
							
	//for($c=1;$c<=32;$c++){
	
	for($c=1;$c<=$cDias;$c++){
		$fila2 = @pg_fetch_array($result3,$�);
		$filaFer=@pg_fetch_array($resultFer,$m);
		
		/*if($_PERFIL==0){
		echo "<br>".$filaFer["dia_ini"]."---".$filaFer["dia_fin"];
		}*/
		//if ($c<32)	{
	
	if ($c<$cDias)	{
		
if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){	?>
<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="alu_<? echo $X;?>_<? echo $c; ?>" disabled>		
</strong></font></TD>
<?	$m++;
	
	}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){

for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>

<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="alu_<? echo $X;?>_<? echo $c;?>" disabled>
</strong></font></TD>
<?	}
		$c=$c-1;
		$m++;
		
		}else{
			
			if ($c==$fila2["day"]){
			$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
			
			if($dia==6){///SABADO	?>

<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="alu_<? echo $X; ?>_<? echo $c; ?>" checked>
</strong></font></TD>
<?	}else///
		
	if($dia==0){///DOMINGO	?>
	
	<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<INPUT TYPE=checkbox NAME="alu_<? echo $X; ?>_<? echo $c; ?>" disabled>
	</strong></font></TD>
<?	}else///
	
	if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
	
	<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	
	<INPUT TYPE=checkbox NAME="alu_<? echo $X; ?>_<? echo $c; ?>" checked>
	
	</strong></font></TD>

<?	}else{	?>

<TD align=center bgcolor='#E1EFFF'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>

<INPUT TYPE=checkbox NAME="alu_<? echo $X; ?>_<? echo $c; ?>" checked>
	</strong></font></TD>
<?	}
	
	$�++;
	}else{
	$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
	if($dia==6){///SABADO	?>

<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="alu_<? echo $X; ?>_<? echo $c; ?>">
</strong></font></TD>
<?										}else///

if($dia==0){///DOMINGO	?>
<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="alu_<? echo $X; ?>_<? echo $c; ?>" disabled>
</strong></font></TD>
<? 	}else

if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="alu_<? echo $X; ?>_<? echo $c; ?>">
</strong></font></TD>
<? }else{	?>
<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="alu_<? echo $X; ?>_<? echo $c; ?>">
</strong></font></TD>
<?	
	      }
	   }
																	

     }
  															
   }//fin if $c<32

  }//fin for($c=1;$c<32;$c++)

 }//fin if $frmModo

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
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
			    </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</td></tr></table>
</body>
</html>
<? pg_close($conn);?>