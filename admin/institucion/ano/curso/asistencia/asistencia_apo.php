<?php 	require('../../../../../util/header.inc');

$institucion	= $_INSTIT;

	/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
		$_ITEM = $item;
		session_register('_ITEM');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}	

$tpv=(!$_GET['tpv'])?1:$_GET['tpv'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
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
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25) &&($_PERFIL!=19)) {$whe_perfil_ano=" and id_ano=$ano";}
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=32)&&($_PERFIL!=19)&&($_PERFIL!=29)&&($_PERFIL!=2)){$whe_perfil_curso=" and curso.id_curso=$curso";}
		}
	$fecha=getdate();
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
	
?>
					

<SCRIPT language="JavaScript">

function enviapag3(form){
			if (form.cmbMes.value!=0){
				form.cmbMes.target="self";
				var tipo = $("input:radio[name=vlista]:checked").val(); 
//				form.action = form.cmbPERIODO.value;
				form.action = 'asistencia_apo.php?tpv='+tipo;
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
	document.getElementById("contEncFil").scrollTop = pasoV;
}

        function enviapag(form){
		    var curso2, frmModo; 
			var tipo = $("input:radio[name=vlista]:checked").val(); 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
				var tipo = $("input:radio[name=vlista]:checked").val(); 
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&p=18&curso="+curso2+"&frmModo="+frmModo+"&tpv="+tipo;
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		 function enviapag2(form){
			 var tipo = $("input:radio[name=vlista]:checked").val(); 
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=10&pa=16&ano="+ano2+"&frmModo="+frmModo+"&tpv="+tipo;
				form.action = pag;
				form.submit(true);	
			}		
		 }


function cambiaLista(){
	var tipo = $("input:radio[name=vlista]:checked").val();
	document.getElementById("tipov").value=tipo;
	window.location ="asistencia_apo.php?tpv="+tipo;
}

$( document ).ready(function() {
	<?php if($_GET['tpv']==""){?>
		$("#tipov").val(1);
		$("#tipoy").val(1);
		$("#vlista1").attr('checked',true);
	<?php } else{?>
		$("#tipov").val(<?php echo $_GET['tpv'] ?>);
		$("#vlista<?php echo $_GET['tpv'] ?>").attr('checked',true);
	<?php }?>
	
});
</script><!--
<style>
table{border-collapse:collapse}
table td{font:12px monospace; border:0px solid; text-align:center; height:1.5em}
#contEncCol{overflow:hidden; overflow-y:scroll; background:#99CCFF; width:40em}
#contEncFil{overflow:hidden; overflow-x:scroll; background:#FFFFFF; height:20em}
#contenedor{overflow:auto; width:40em; height:20em}
#contenido{}
.tabla td{border:1px solid; width:2em}
.rell{width:2em; height:0; position:relative; top:-1em; z-index:0; bor der:1px solid red}
</style>
-->
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
<!--
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
-->
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
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
					
                      <td width="85%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top" colspan="50"><? include("../../../../../cabecera/menu_superior.php"); ?></td>
                          </tr>
                          <tr> 
						  <td> 
						  <table><tr><td  valign="top" width="1%">
						 <?  $menu_lateral="3_1";?> <? include("../../../../../menus/menu_lateral.php"); ?>
						 </td>
						 <td valign="top" width="100%"  class="cajaborde">
						  <!--- AQUI ENPIEMZA-->
						 <!-- inicio codigo nuevo -->
								  
								  				  
								  
								   


<?php //echo tope("../../../../../util/");?>
<input type="hidden" name="tipov" id="tipov" value="<?php echo $tpv ?>">


	  	<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1  width="90%">
	  	  <TR> 
            <TD> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>AÑO 
              ESCOLAR</strong> </FONT> </div></TD>
            <TD> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </div></TD>
            <TD> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong> 
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
			 <form name="form"   action="" method="post">
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
				<? }	?>
              </strong> </FONT> </div></TD></form>
          </TR>
          <TR>
            <TD><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CURSO
              </strong></font></div></TD>
            <TD><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">:</font></strong></div></TD>
            <TD><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">
		    <form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
//echo $sql_curso;
$resultado_query_cue = @pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $filan = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($filan['id_curso'], 1, $conn);
		  
		        if (($filan['id_curso'] == $cmb_curso) or ($filan['id_curso'] == $curso)){
		           echo "<option value=".$filan['id_curso']." selected>".$Curso_pal."</option>";
		        }else{	    
		           echo "<option value=".$filan['id_curso'].">".$Curso_pal."</option>";
                }
		     } ?>
          </select>
						  

			&nbsp;</font></strong></div></TD></form>
          </TR>
           <TR>
            <TD><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>VISTA</strong></font></div></TD>
            <TD><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>:</strong></font></div></TD>
            <td colspan="8"><div align="left">
            <FONT face="arial, geneva, helvetica" size=2> <strong>
              <input type="radio" name="vlista" id="vlista1"  value="1" onChange="cambiaLista()">
             Apoderado <input type="radio" name="vlista" id="vlista2" value="2" onChange="cambiaLista()">Alumno
           </strong></FONT> </div></td>         
            </TR>
      </TABLE>
		
<?
if (($curso != 0) or ($curso != NULL)){ ?>		
<form name="form1" method="post" action="procesoAsistencia_apo.php">
        <input type="hidden" name="cmbMes2" value="<? echo $cmbMes; ?>" >
		<input type="hidden" name="ensenanza" value="<?=$filan['ensenanza']; ?>">
		<input type="hidden" name="tipoy" id="tipoy" value="<?php echo $tpv ?>">
        <table  width="740" cellpadding="5" cellspacing="5" align="center" border="0">
          <tr> 
            <td height="33"><div align="right">
              <?php if (($frmModo=="ingresar") OR ($frmModo=="modificar")){		  		    
			    		if($ingreso==1){?>
                    <input class="botonXX"  type="submit" name="Button" value="GUARDAR">
					<input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="seteaAsistencia.php3?caso=13&tpv=<?php echo $tpv ?>"> 
                <?php 	}
					} ?>
                <?php if ($frmModo=="mostrar") {
						   if($fila1106['situacion']==0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR
								 
							}else{
								 if ($modifica==1){  ?>
								   <input class="botonXX"  type="button" name="Button2" value="MODIFICAR"onClick=window.location="seteaAsistencia.php3?caso=12&mes=<?php echo $cmbMes ?>&tpv=<?php echo $tpv ?>"> 
							 <? }	
							 }
							/*else{
								  if (($_PERFIL==17) AND ($_INSTIT==9566 || $_INSTIT==516)){ 
									   // no muestro
								  }else{									  
									  if (($_PERFIL!=2) and ($_PERFIL!=20)){
										 ?>
										 <input class="botonXX"  type="button" name="Button2" value="MODIFICAR" onClick=window.location="seteaAsistencia.php3?caso=12&mes=<?php echo $cmbMes ?>">
									<? } 
							   
								  } ?>	  
								  
								
								<?
								 if (($_PERFIL == 19) AND ($_PERFIL == 0) AND ($_PERFIL == 14)){ ?>
									<input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="../curso.php3">
							  <? } ?>		
									  
								  <?
							}*/?>								
							
								  
								  
                             <?php } ?>
              </div></td>
          </tr>
</table>
        <table width="740" border="0" align="center">
          <tr> 
            <td width="48"><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Feriado:</font></strong></td>
            <td width="21" bgcolor="#FFE6E6">&nbsp;</td>
            <td width="33">&nbsp;</td>
            <td width="47"><strong><font size="1" face="Arial, Helvetica, sans-serif">Fin 
              de Semana:</font></strong></td>
            <td width="21" bgcolor="#EAEAEA">&nbsp;</td>
			<td width="33">&nbsp;</td>
            <td width="33"><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Actua:</font></strong></td>
            <td width="21" bgcolor="#FFFFD7">&nbsp;</td>
			<td width="33">&nbsp;</td>
            <td width="57" ><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Inasistencia:</font></td>
            <td width="21" bgcolor="#E1EFFF" ><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
			<td width="33">&nbsp;</td>
            <td width="58" ><font size="1" face="Arial, Helvetica, sans-serif">Inasistencias del Mes:</font></td>
            <td width="114"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;I.M.</font></td>           
          </tr>
        </table>
<br>
        <table width="740" border="0" cellpadding="1" cellspacing="1" align="center">
          <tr> 
            <td width="17%" height="20" align="left" class="tableindex">INASISTENCIA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
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

<br>

<form name="form1" method="post" action="../../../../../procesoAsistencia.php3">
  <table border="0" cellpadding="0" cellspacing="0" align="center" >
		             <?php

						$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
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
					if (($cmbMes==2) and ($nroAno%4==0)){
						 $diaFinal=29;
					}else{
						 $diaFinal=28;
					}
					if ($cmbMes==1) $diaFinal=31;
					if ($cmbMes==3) $diaFinal=31;
					if ($cmbMes==4) $diaFinal=30;
					if ($cmbMes==5) $diaFinal=31;
					if ($cmbMes==6) $diaFinal=30;
					if ($cmbMes==7) $diaFinal=31;
					if ($cmbMes==8) $diaFinal=31;
					if ($cmbMes==9) $diaFinal=30;
					if ($cmbMes==10) $diaFinal=31;
					if ($cmbMes==11) $diaFinal=30;
					if ($cmbMes==12) $diaFinal=31;
					//FIN AJUSTA
				}

				//APODERADOS  DEL CURSO
               // $qry = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where id_curso = '$curso')) order by ape_pat, ape_mat";
			   
			  $orden = ($tpv==2)?"al.ape_pat,al.ape_mat,al.nombre_alu":"a.ape_pat,a.ape_mat,a.nombre_apo";
			   
			     $qry = "select 
a.rut_apo,a.nombre_apo,a.ape_pat,a.ape_mat,
al.rut_alumno,al.nombre_alu,al.ape_pat ape_palu,al.ape_mat ape_malu
from apoderado a
left join tiene2 t on t.rut_apo = a.rut_apo
left join alumno al on al.rut_alumno = t.rut_alumno
where t.rut_alumno in (select rut_alumno from matricula where id_curso = $curso ) and t.responsable=1
group by a.rut_apo,a.ape_pat,a.ape_mat,a.nombre_apo,al.rut_alumno,al.nombre_alu,al.ape_pat,al.ape_mat
order by $orden";



				
				$result =@pg_Exec($conn,$qry);

				if(!$result){
					error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
				}else{
					if(pg_numrows($result)!=0){ ?>

							<TR class="tablatit2-1">
							<TD>&nbsp;&nbsp;<?php echo ($tpv==1)?"APODERADO":"ALUMNO"; ?>&nbsp;&nbsp;
							</TD>

							<td valign="top">
							
							
														
							<table class="tabla" id="encCol" style="width:100% "> 
								<tr>

<?							for($count=1 ; $count<=$diaFinal ; $count++){
								if($diaFinal==29 || $diaFinal==28){
									if ($count<10){ ?>
										<TD width="50" align="center" ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG> 0<? echo $count; ?> </STRONG></FONT></TD>
                                        <?									}else{  ?>
										<TD align="center" ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;<? echo $count; ?></STRONG></FONT></TD>
                                        <?									}
								}
								else{
									if ($count<10){ ?>
										<TD align="center"  ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>0<? echo $count; ?></STRONG></FONT></TD>
                                        <?									}else{ ?>
										<TD align="center" ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><? echo $count; ?></STRONG></FONT></TD>
                                        <?									}
								}
							} // fin for $count
					}	// fin if
					if ($frmModo=="mostrar"){ ?>
						<TD align="center" ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
						  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>I.M.</STRONG></FONT></TD>
                        <?					} ?>

							
						</tr>
						</table>
								
						</td>
					</tr>


					<tr>
					<td width="250" valign="top" >
					
					
					
					
					<table width="250" Id="encFil" border="0" cellpadding="0" cellspacing="" >	

<?					


					$X=0;
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$X++;
						$Y=0;
						$fila1 = @pg_fetch_array($result,$i);
						if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
							if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
								   ?>								
									<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='white'> <?
							}else{  ?>
								<TR bgcolor=#ffffff>
<?							}
						}else{  ?>
							<TR bgcolor=#ffffff>
<?						}  ?>
<?												//width=15   ?>

						<!--<TD align=left  class="td_temp2" align="left"> -->
<? if ($frmModo=="mostrar"){ ?>
						<TD align="left" valign="top">
						<img src="trans.gif" width="0" height="19">
						<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>				
						&nbsp;
						<?	
						$nlist="";
						if($tpv==2){
						$snl="select nro_lista from matricula where rut_alumno = ".$fila1["rut_alumno"]." and id_curso=$curso and bool_ar=0"; 
						$rs_num = pg_exec($conn,$snl);
						$nlist = pg_result($rs_num,0).") ";
						}
											
						
$nombre = ($tpv==1)?substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_apo"]),0,13):substr(trim($fila1["ape_palu"]),0,15)." ".substr(trim($fila1["ape_malu"]),0,15).", ".substr(trim($fila1["nombre_alu"]),0,13);



						
						//echo  substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_apo"]),0,13);	
						echo $nlist.$nombre;
                    	?>
						</STRONG></FONT>
						</TD>
<? } ?>	
<? if ($frmModo=="ingresar"){ ?>
						<TD align="left" valign="top">
						<img src="trans.gif" width="0" height="18">
						<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?						if($fila1["nro_lista"]!=NULL){
							if($fila1["nro_lista"]<10){
								echo  trim($fila1["nro_lista"])." &nbsp;&nbsp;";
							}
							else{
								echo  trim($fila1["nro_lista"])." &nbsp;";
							}
						}
						else{
							echo  " &nbsp; &nbsp; &nbsp;";
						}
						
						$nlist="";
						if($tpv==2){
						$snl="select nro_lista from matricula where rut_alumno = ".$fila1["rut_alumno"]." and id_curso=$curso and bool_ar=0"; 
						$rs_num = pg_exec($conn,$snl);
						$nlist = pg_result($rs_num,0).") ";
						}
						
						$nombre = ($tpv==1)?substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_apo"]),0,13):substr(trim($fila1["ape_palu"]),0,15)." ".substr(trim($fila1["ape_malu"]),0,15).", ".substr(trim($fila1["nombre_alu"]),0,13);
						
						echo $nlist.$nombre;
						//echo  substr(trim($fila1["ape_pat"]),0,15)." ".substr(trim($fila1["ape_mat"]),0,15).", ".substr(trim($fila1["nombre_alu"]),0,13);	
//						echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);	?>
						</STRONG></FONT>
						</TD>
<? } ?>						
						
						</tr>
<? 					}	?>
					</table>
					
					</td>
					
					<td valign="top">
					  
					
					  <table width="100%" class="tabla" id="contenido" border="0" cellpadding="1" cellspacing="1" >	


<?
					//ALUMNOS DEL CURSO
/*					$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista  ";
					$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
					$qry = $qry . " WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) ";
					$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
					$result =@pg_Exec($conn,$qry);
*/

/*
echo "<br>";
echo						$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
						}
*/

                  // $qry = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where id_curso = '$curso')) order by ape_pat, ape_mat";
	$orden = ($tpv==2)?"al.ape_pat,al.ape_mat,al.nombre_alu":"a.ape_pat,a.ape_mat,a.nombre_apo";
				  
				   $qry = "select 
a.rut_apo,a.nombre_apo,a.ape_pat,a.ape_mat,
al.rut_alumno,al.nombre_alu,al.ape_pat ape_palu,al.ape_mat ape_malu
from apoderado a
left join tiene2 t on t.rut_apo = a.rut_apo
left join alumno al on al.rut_alumno = t.rut_alumno
where t.rut_alumno in (select rut_alumno from matricula where id_curso = $curso ) and t.responsable=1
group by a.rut_apo,a.ape_pat,a.ape_mat,a.nombre_apo,al.rut_alumno,al.nombre_alu,al.ape_pat,al.ape_mat
order by $orden";
				   $result =@pg_Exec($conn,$qry);
				   
				   

					$X=0;
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$X++;
						$Y=0;
						$fila1 = @pg_fetch_array($result,$i);

 						$qry9="select count (rut_apo) as cantidad from asistencia_apo where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_apo=".trim($fila1["rut_apo"])." AND id_curso=".$curso;
						$result9 =@pg_Exec($conn,$qry9);
						$fila9 = @pg_fetch_array($result9,0);
						$cant=$fila9["cantidad"];
						if (!$result9) {
							//error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry9);
						}
							
						/******** QRY PARA TRAER DIAS FERIADOS Y COLOREAR LA COLUMNA QUE CORRESPONDE********/
/*echo "<br>";
echo						$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
						}
*/							
						/******** QRY PARA TRAER DIAS INASISTENCIA********/	
						
						$qry2="select rut_apo, ano, id_curso, date_part('day',asistencia_apo.fecha) AS day, date_part('month',asistencia_apo.fecha), date_part('year',asistencia_apo.fecha) AS year from asistencia_apo where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_apo='".trim($fila1["rut_apo"])."' AND id_curso='".$curso."' ";
						$result2 =@pg_Exec($conn,$qry2);
						if (!$result2){
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry2);
						}	
							
													
						if ($frmModo=="mostrar"){

							?>							
							<tr bgcolor="ffffff" valign="top">
							<?						
							$m=0;
							$ñ=0;
							$cDias=$diaFinal+2;
							//for($c=1;$c<=33;$c++){
							for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								$filaFer=@pg_fetch_array($resultFer,$m);
								
								//if ($c<33)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){   ?>
										<TD align=center bgcolor='#FFE6E6' valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										</strong></font></TD>
	<?									$m++;
									}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6' valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
											</strong></font></TD>
	<?									}
										$c=$c-1;
										$m++;
									}else{
										//if ($c==32){
										if ($c==($cDias-1)){	?>
											<TD align="center" valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<img src="../../../../../cortes/p.gif" width="20" height="9"><br>
<?											echo $cant;	?>
											</strong></font></TD>
	<?										$flag=1;
										}else{
											if ($c==$fila2["day"]){
												$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
												if($dia==6){///SABADO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<img src="../../../../../cortes/p.gif" width="20" height="9"><br>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else///
												if(($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
													<TD align=center bgcolor=#FFFFD7 valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
	<?												//echo "3*".$c;	?>
	<?												echo $c;	?>
													</strong></font></TD>
	<?											}else{ ?>
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
													<TD align=center bgcolor=#EAEAEA valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if($dia==0){///DOMINGO	?>
													<TD align=center bgcolor=#EAEAEA valign="top">	<img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}else///
												if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>	                                                  <TD align=center bgcolor=#FFFFD7 valign="top">
												       <img src="../../../../../cortes/p.gif" width="20" height="9"><br> 
													</TD>  
<?												}else{	?>
													<TD align=center valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
													</strong></font></TD>
<?												}
											}

										}
									}
								}//fin if $c<32
								 //if (($c==32) and ($flag!=1)){
								 if (($c==($cDias-1)) and ($flag!=1)){	?>
									<TD align=center valign="top"><img src="../../../../../cortes/p.gif" width="20" height="9"><br><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
<?									echo $cant;	?>
									</strong></font></TD> 
<?								}
							}//fin for($c=1;$c<32;$c++)
?>
						    
<?															
						}else{
							if($frmModo=="ingresar"){

?>							<tr bgcolor="ffffff">
<?						
							$m=0;
							$ñ=0;
							$cDias=$diaFinal+1;
							
							//for($c=1;$c<=32;$c++){
							for($c=1;$c<=$cDias;$c++){
								$fila2 = @pg_fetch_array($result2,$ñ);
								$filaFer=@pg_fetch_array($resultFer,$m);
								//if ($c<32)	{
								if ($c<$cDias)	{
									if (($c==$filaFer["dia_ini"]) and ($filaFer["dia_fin"]=="")){	?>
										<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
										<INPUT TYPE=checkbox NAME="a_<? echo $X;?>_<? echo $c; ?>" disabled>		
										</strong></font></TD>
<?										$m++;
									}else if (($c>=$filaFer["dia_ini"]) and ($c<=$filaFer["dia_fin"])){
										for ($c==$filaFer["dia_ini"] ; $c<=$filaFer["dia_fin"] ; $c++){	?>
											<TD align=center bgcolor='#FFE6E6'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
											<INPUT TYPE=checkbox NAME="a_<? echo $X;?>_<? echo $c;?>" disabled>
											</strong></font></TD>
<?										}
										$c=$c-1;
										$m++;
									}else{
										if ($c==$fila2["day"]){
											$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
											if($dia==6){///SABADO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" checked>
												</strong></font></TD>
<?											}else///
											if($dia==0){///DOMINGO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" disabled>
												</strong></font></TD>
<?											}else///
											if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
												<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" checked>
												</strong></font></TD>
<?											}else{	?>
												<TD align=center bgcolor='#E1EFFF'><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" checked>
												</strong></font></TD>
<?											}
											$ñ++;
										}else{
										$dia = (date("w", mktime(0,0,0,$cmbMes,$c,$nroAno)));////
										if($dia==6){///SABADO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>">
												</strong></font></TD>
<?										}else///
										if($dia==0){///DOMINGO	?>
												<TD align=center bgcolor=#EAEAEA><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>" disabled>
												</strong></font></TD>
<?										}else///
										if( ($diaActual==$c) and ($cmbMes==$fecha["mon"]) and ($nroAno==$fecha["year"]) ){	?>
												<TD align=center bgcolor=#FFFFD7><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>">
												</strong></font></TD>
<?										}else{	?>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>
												<INPUT TYPE=checkbox NAME="a_<? echo $X; ?>_<? echo $c; ?>">
							  </strong></font></TD>
<?										}
									}
																		
								}
																	
							}//fin if $c<32

						}//fin for($c=1;$c<32;$c++)

					}//fin if $frmModo
?>
								
							</tr>
<?															
				}// fin else 
			}
?>
					  </table>
					  
					  </td>
<?

		}
?>

			</tr>
  </table>
</form>

		<? }else{ ?>
		      </td>
			  </tr>
			  </table>
		<? } ?>	  					
					  
								  
								  
						 <!--AQUI TERMINA -->
						 
						 
						 </td>
						 
						 </tr></table>
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
