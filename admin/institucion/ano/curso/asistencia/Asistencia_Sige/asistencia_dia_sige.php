<?php 	require('../../../../../../util/header.inc');

//	print_r($_POST);
	$institucion = $_INSTIT;
	$corporacion =$_CORPORACION;
	$_POSP          =6;
	$frmModo="ingresar";
	
	
	$fecha_ina=$fecha_actual;
	
	$separar_fecha = explode('/',$fecha_ina);
 "ano->".$ano_cal=$separar_fecha[0];
 "mes->".$mes_cal=$separar_fecha[1];
 "dia->".$dia_cal=$separar_fecha[2];
	
	
	if($_PERFIL==0){
		$sql ="SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
		$rs_corp = @pg_exec($conn,$sql);
		$corporacion = @pg_result($rs_corp,0);
	}
	
	
	$sql_ensenanza = "select c.ensenanza from curso c 
					  inner join tipo_ensenanza tn on c.ensenanza=tn.cod_tipo
					  where c.id_curso=$cmb_curso";
	$rs_ense = pg_exec($conn,$sql_ensenanza);
	$ensenanza = pg_result($rs_ense,0);				  
	 

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


$Curso_pal = CursoPalabra($cmb_curso, 1, $conn);
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
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
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
			if (form.cmbMes.value!=0){
				form.cmbMes.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'asistencia.php3';
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
			pag="../../seteaCurso.php3?caso=11&p=8&curso="+curso2+"&frmModo="+frmModo
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
			pag="../../../seteaAno.php3?caso=10&pa=6&ano="+ano2+"&frmModo="+frmModo
			form.action = pag;
			form.submit(true);	
		}		
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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

<form name="form1" method="post" action="proceso_asistencia_sige.php" target="self">

<input type="hidden" name="cmbMes2" value="<? echo $cmbMes; ?>" >
							 
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td width="20%" class="Estilo1">A&ntilde;o Escolar </td>
    <td width="50%" class="Estilo2">:<?=$nroAno;?> 
</td>
<td width="30%" rowspan="2"><div align="center">
<label>
<? if($fila1106['situacion']==0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR
  
  }else{

  if ($ingreso==1 || $modifica==1){ 
		
		if ($frmModo=="mostrar" and $curso>0){	  
			                               		?>
<input class="botonXX"  type="submit" name="Button2" value="INGRESAR"  >

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
	
 ?>

<input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="asistencia_sige.php">
	
	<?
	}
?>  	
                                </label>
                              </div></td>
                            </tr>
                            <tr>
                              <td class="Estilo1">Curso</td>
                              <td>: 
<input type="hidden" name="frmModo" value="<?=$frmModo ?>">

<?php
echo $Curso_pal;
?>

						    
</td>
</tr>
</table>

<input type="hidden" name="ensenanza" value="<?=$ensenanza; ?>">	
<input type="hidden" name="cmb_curso" value="<?=$cmb_curso; ?>">	
						  
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
                              <td width="20%" class="Estilo1">INASISTENCIA</td>
                              <td width="80%">:
							  <?=$fecha_actual;?>
							  </td>
                            </tr>
                          </table>
						
					<!--	  <table width="100%" height="300" border="1">-->
                            <tr>
                              <td valign="top">
							  
							  
				<?php
                


//if($_PERFIL==0){
		$qry_al = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, 
alumno.ape_mat, matricula.nro_lista,matricula.fecha ,matricula.fecha_retiro,matricula.bool_ar 
FROM alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno 
and matricula.fecha <='".$ano_cal."-".$mes_cal."-".$dia_cal."' 
 WHERE matricula.id_curso=".$curso."
  AND matricula.rdb='$institucion' 
  ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
//echo "and fecha <='".$ano_cal."-".$mes_cal."-".$dia_cal."'";
            //  echo $qry_al;
			  /*} else{
				  	$qry_al = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista
	FROM alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno and fecha <='".$ano_cal."-".$mes_cal."-".$dia_cal."' 
	WHERE matricula.id_curso=".$curso." AND matricula.bool_ar=0 or matricula.bool_ar isnull 
	AND matricula.rdb='$institucion'  
	ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
				  
				 }  */
     $result =@pg_Exec($conn,$qry_al);           
$X=0;
//inicio parte pruebas
//if($_PERFIL==0){
for($i=0 ; $i < @pg_numrows($result) ; $i++){
	
	$fila1 = @pg_fetch_array($result,$i);
	
	if($fila1["bool_ar"]==1 && strlen($fila1["fecha_retiro"]) && $fila1["fecha_retiro"]<=$ano_cal."-".$mes_cal."-".$dia_cal )
	{
	//echo $fila1["rut_alumno"]."--".$fila1["bool_ar"];
	}
	else{
$X++;
$Y=0; 


  
 	if($corporacion==13){
			echo $fecha_inicial =$cmbMes."-01-".$nroAno;
			$fecha_final = $cmbMes."-".$diaFinal."-".$nroAno;
	    	
		 }else{
			$fecha_inicial =$cmbMes."-01-".$nroAno;
			$fecha_final = $cmbMes."-".$diaFinal."-".$nroAno;
			/*$fecha_inicial ="01-".$cmbMes."-".$nroAno;
	    	$fecha_final = $diaFinal."-".$cmbMes."-".$nroAno;*/
		 } 
		 if(pg_dbname()=="coi_final_vina"){
			 $fecha_inicial=$nroAno.'-'.$cmbMes.'-01';
			 $fecha_final=$nroAno.'-'.$cmbMes.'-'.$diaFinal;
			 }
		 
		 $qry9="select count(rut_alumno) as cantidad from asistencia 
where fecha between '".$fecha_inicial."' and '".$fecha_final."' 
and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;
										
 $result9 =@pg_Exec($conn,$qry9)or die("fallo 2 ".$qry9 );
 $fila9 = @pg_fetch_array($result9,0);
 $cant=$fila9["cantidad"];
 
 if (!$result9) {
error('<B> ERROR :</b>Error al acceder a la BD. (776)</B>'.$qry9);
  }
  
  $qry2="select rut_alumno, ano, id_curso, date_part('day',asistencia.fecha) AS day, date_part('month',asistencia.fecha), date_part('year',asistencia.fecha) AS year from asistencia where fecha between '".$fecha_inicial."' and '".$fecha_final."' and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;

$result2 =@pg_Exec($conn,$qry2);

if (!$result2){
	error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$qry2);
			 }
			 
			 
			 if($frmModo=="mostrar"){


  $sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";


$resultFer=@pg_Exec($conn,$sqlFer)or die("Fallo 3");
if (!$resultFer) {
	echo('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
	} ?>
<table width="650" border="1" align="center" style="border-collapse:collapse">	
<tr bgcolor=#ffffff onmouseover=this.style.background='red' this.style.cursor='hand' onmouseout=this.style.background='transparent'>
  <TD width="79" align="left">
  
  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?	if($fila1["nro_lista"]!=NULL){
			if($fila1["nro_lista"]<10){
				echo  trim($fila1["nro_lista"])." &nbsp;&nbsp;";
				}else{
				echo  trim($fila1["nro_lista"])." &nbsp;";
				}
			}else{
				echo  "&nbsp; &nbsp; &nbsp;";
					}
				?>
	</STRONG>
    </FONT>
	</TD>
    
    <td width="555">
    <input type="hidden" name="fecha_del_dia" value="<?=$fecha_actual;?>">
    <font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo  substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_alu"]),0,13);?></font></td>
 
 
<TD align=center bgcolor='#FFE6E6'>
<?php 

$sql_at="select * from asistencia where fecha ='".$fecha_actual."' and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;
$result_at = @pg_Exec($conn,$sql_at)or die("fallo asis");



$hay_o_no = @pg_numrows($result_at);

if($hay_o_no==1){
	?>
	<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="check<?=$i?>" checked value="<?=$fila1['rut_alumno'];?>" >
</strong></font>
<?
	}else{
 
?>
<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="check<?=$i?>" value="<?=$fila1['rut_alumno'];?>" >
</strong></font></TD>
<?
	}
?>
 </tr>
 </table>
 
  <?
	}
	}//fin desaparece
}	
//if pruebas
/*}
else{
for($i=0 ; $i < @pg_numrows($result) ; $i++){
	
$X++;
$Y=0; 

$fila1 = @pg_fetch_array($result,$i);
  
 	if($corporacion==13){
			echo $fecha_inicial =$cmbMes."-01-".$nroAno;
			$fecha_final = $cmbMes."-".$diaFinal."-".$nroAno;
	    	
		 }else{
			$fecha_inicial =$cmbMes."-01-".$nroAno;
			$fecha_final = $cmbMes."-".$diaFinal."-".$nroAno;
			/*$fecha_inicial ="01-".$cmbMes."-".$nroAno;
	    	$fecha_final = $diaFinal."-".$cmbMes."-".$nroAno;*/
		 /*} 
		 if(pg_dbname()=="coi_final_vina"){
			 $fecha_inicial=$nroAno.'-'.$cmbMes.'-01';
			 $fecha_final=$nroAno.'-'.$cmbMes.'-'.$diaFinal;
			 }
		 
		 $qry9="select count(rut_alumno) as cantidad from asistencia 
where fecha between '".$fecha_inicial."' and '".$fecha_final."' 
and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;
										
 $result9 =@pg_Exec($conn,$qry9)or die("fallo 2 ".$qry9 );
 $fila9 = @pg_fetch_array($result9,0);
 $cant=$fila9["cantidad"];
 
 if (!$result9) {
error('<B> ERROR :</b>Error al acceder a la BD. (776)</B>'.$qry9);
  }
  
  $qry2="select rut_alumno, ano, id_curso, date_part('day',asistencia.fecha) AS day, date_part('month',asistencia.fecha), date_part('year',asistencia.fecha) AS year from asistencia where fecha between '".$fecha_inicial."' and '".$fecha_final."' and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;

$result2 =@pg_Exec($conn,$qry2);

if (!$result2){
	error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$qry2);
			 }
			 
			 
			 if($frmModo=="mostrar"){


  $sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";


$resultFer=@pg_Exec($conn,$sqlFer)or die("Fallo 3");
if (!$resultFer) {
	echo('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
	} ?>
<table width="650" border="1" align="center" style="border-collapse:collapse">	
<tr bgcolor=#ffffff onmouseover=this.style.background='red' this.style.cursor='hand' onmouseout=this.style.background='transparent'>
  <TD width="79" align="left">
  
  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?	if($fila1["nro_lista"]!=NULL){
			if($fila1["nro_lista"]<10){
				echo  trim($fila1["nro_lista"])." &nbsp;&nbsp;";
				}else{
				echo  trim($fila1["nro_lista"])." &nbsp;";
				}
			}else{
				echo  "&nbsp; &nbsp; &nbsp;";
					}
				?>
	</STRONG>
    </FONT>
	</TD>
    
    <td width="555">
    <input type="hidden" name="fecha_del_dia" value="<?=$fecha_actual;?>">
    <font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo  substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_alu"]),0,13);?></font></td>
 
 
<TD align=center bgcolor='#FFE6E6'>
<?php 

$sql_at="select * from asistencia where fecha ='".$fecha_actual."' and rut_alumno=".trim($fila1["rut_alumno"])." AND id_curso=".$curso;
$result_at = @pg_Exec($conn,$sql_at)or die("fallo asis");



$hay_o_no = @pg_numrows($result_at);

if($hay_o_no==1){
	?>
	<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="check<?=$i?>" checked value="<?=$fila1['rut_alumno'];?>" >
</strong></font>
<?
	}else{
 
?>
<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<INPUT TYPE=checkbox NAME="check<?=$i?>" value="<?=$fila1['rut_alumno'];?>" >
</strong></font></TD>
<?
	}
?>
 </tr>
 </table>
 
  <?
	}
}

*/
//}//fin fuera persil
?>						
							  
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
<div id="msgsige"></div>
</body>
</html>
<? pg_close($conn);?>