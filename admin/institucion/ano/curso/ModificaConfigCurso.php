<? require('../../../../util/header.inc');


$institucion	=$_INSTIT;
$ano = $_ANO;
$frmModo =$_FRMMODO;


                          
   $qry="SELECT curso.id_curso, curso.cod_decreto, curso.grado_curso, curso.letra_curso, curso.acta, curso.bool_jor,tipo_ensenanza.nombre_tipo, cod_tipo FROM tipo_ensenanza INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano.")) order by tipo_ensenanza.nombre_tipo,curso.grado_curso, curso.letra_curso asc"; 
							$result =@pg_Exec($conn,$qry);
							$fila = @pg_fetch_array($result,0);
							

						?>           

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
body{
color: #333;
font-size: 11px;
font-family: verdana;
}
a{
color: #fff;
text-decoration: none;
}
a:hover{
color: #DFE44F;
}
p{
margin: 0;
padding: 5px;
line-height: 1.5em;
text-align: justify;
border: 1px solid #CCCCCC;
}
#wrapper{
width: 950px;
margin: 0 auto;
}
.box{
background: #fff;
vertical-align:top;
background-position:top;
font-size: 8px;
color:#000;

}
.boxholder{
clear: both;
padding: 3px;
background: #CCCCCC;
vertical-align:top;
}
.tab{
float: left;
height: 32px;
width: 150px;
margin: 0 1px 0 0;
text-align: center;
background: #CCCCCC url(images/greentab.jpg) no-repeat;
}
.tabtxt{
margin: 0;
color: #fff;
font-size: 12px;
font-weight: bold;
padding: 9px 0 0 0;
}

</style>

<script type="text/javascript" src="ramo/scripts/prototype.lite.js"></script>
<script type="text/javascript" src="ramo/scripts/moo.fx.js"></script>
<script type="text/javascript" src="ramo/scripts/moo.fx.pack.js"></script>
<script type="text/javascript">
function init(){
	var stretchers = document.getElementsByClassName('box');
	var toggles = document.getElementsByClassName('tab');
	var myAccordion = new fx.Accordion(
		toggles, stretchers, {opacity: false, height: true, duration: 600}
	);
	//hash functions
	var found = false;
	toggles.each(function(h3, i){
		var div = Element.find(h3, 'nextSibling');
			if (window.location.href.indexOf(h3.title) > 0) {
				myAccordion.showThisHideOpen(div);
				found = true;
			}
		});
		if (!found) myAccordion.showThisHideOpen(stretchers[0]);
}



/*function enviapag(form){
	if(document.form.cmb_curso.value!=0){
		form.action='seteaConfig.php3?caso=1&curso='+document.form.cmb_curso.value;
		form.submit(true);
	}
}



function limpia(form,nombre,posicion){
	if(document.form.elements[nombre].value==0){
		document.form.elements[nombre].value="";
	}
}
*/


function marcar(nombre)
{
	
var contador = document.getElementById('contador').value;

var i;
for(i=0;i<=contador;i++){;
//var nombre = radio+i;
//alert(nombre);
if (document.form.chk_tr_per.checked){ 
document.getElementById('truncado_per'+i+'').checked = true;
}else{
	document.getElementById('truncado_per'+i+'').checked = false;
	}
}
}

function marcar2(nombre)
{
var contador = document.getElementById('contador').value;

var i;
for(i=0;i<=contador;i++){;
//var nombre = radio+i;
//alert(nombre);
if (document.form.chk_tr_fn.checked){ 
document.getElementById('truncado_final'+i+'').checked = true;
}else{
document.getElementById('truncado_final'+i+'').checked = false;	
	}
}
}

function marcar3(nombre)
{
	
var contador = document.getElementById('contador').value;
var i;
for(i=0;i<=contador;i++){;
//var nombre = radio+i;
//alert(nombre);
if (document.form.chk_tr_sf.checked){ 
document.getElementById('truncado_sf'+i+'').checked = true;
}else{
document.getElementById('truncado_sf'+i+'').checked = false;
}
}
}





</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>"></td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
			  </tr>
			</table>
				
		  </td>
        </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                     
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
							<form action="procesaConfiguracion.php" name="form" method="post">
							<input type="hidden" name="contador" id="contador" value="<?=@pg_numrows($result);?>" />
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td valign="top">
								  <table width="100%" border="0">
									 
									  <tr>
										<td colspan="2">&nbsp;</td>
									  </tr>
									  <tr>
										<td colspan="2"><div align="right">
 <? if($frmModo=="mostrar"){ ?>										
<input type="button" name="modifica" value="MODIFICAR" class="botonXX" onclick="window.location='seteaConfig.php?caso=2'">
<input type="button" name="Submit2" value="VOLVER" class="botonXX" onClick="window.location='listarCursos.php3'">
<? }?>
  <?
 if($frmModo=="modificar"){ ?>
  <input type="submit" name="guardar" value="GUARDAR" class="botonXX">
  <input type="button" name="CANCELAR" value="CANCELAR" class="botonXX" onClick="window.location='seteaConfig.php?caso=1&ano=<?=$ano;?>'">							 
	 <? }?>
    </div></td>
  </tr>
</table>
<br>
                                 
				<!-- INCLUYO CODIGO DE LOS BOTONES -->

<div id="wrapper">
<div id="content">
<h3 class="tab" title="Configuración Básica"><div class="tabtxt"><a href="#">GENERAL</a></div></h3>
<div class="tab"><h3 class="tabtxt" title="MAS OPCIONES"><a href="#">MAS OPCIONES</a></h3></div>
<div class="boxholder">
<div class="box">
    <table width="100%" border="1" style="font-size:8px;">
      <tr align="center">
        <td width="%">CURSO</td>
        <td width="%">PROFESOR JEFE</td>
        <td width="%">APROX.PROM<br />
FINALES</td>
        <td width="%">APROX.PROM <br />
          GENERAL</td>
        <td width="%">APROX.PROM. <br />
          PERIODOS + EXAMEN</td>
        <td width="%">JORNADA&nbsp;DE&nbsp;ESTUDIO</td>
         <td width="%">PLANES DE ESTUDIO</td>
        <td width="%">PUNTAJE SIMCE</td>
        
      
    </tr>
<?
if ($frmModo=="modificar"){
?>    
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="center"><input name="chk_tr_per" type="checkbox" value="Marcar todos"onclick="marcar(this.name)"></td>
<td align="center"><input name="chk_tr_fn" type="checkbox" value="Marcar todos2"onclick="marcar2(this.name)"></td>
<td align="center"><input name="chk_tr_sf" type="checkbox" value="Marcar todos3"onclick="marcar3(this.name)"></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
	<? 
}
for($i=0 ; $i < @pg_numrows($result) ; $i++){
$fila_curso = @pg_fetch_array($result,$i);
 $Curso_pal = CursoPalabra($fila_curso['id_curso'], 1, $conn);
?>

<tr>
<td>
<?
    $qryD="select curso.*, plan_estudio.*, tipo_ensenanza.* from curso, plan_estudio, tipo_ensenanza where curso.id_curso = ".$fila_curso['id_curso']." and plan_estudio.cod_decreto = curso.cod_decreto and curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$resultD =@pg_Exec($conn,$qryD);
		$filaD = @pg_fetch_array($resultD,0);	
		?>
<input name="cod_curso<?=$i;?>" type="hidden" value="<?=$fila_curso['id_curso'];?>" />
  
    <?php
    if ($error_conf==1){
    echo "* ";
    }			
    echo $Curso_pal;
    ?>
   </td>
<td>
<?
	$qry55="select * from supervisa where id_curso=".$fila_curso['id_curso'];
			$result55 =@pg_Exec($conn,$qry55)or die("Fallo".$qry55);
			$fila55 = @pg_fetch_array($result55,0);
								
    $qry5="select empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat 
	       from empleado where rut_emp=".$fila55['rut_emp'];
			$result5 =@pg_Exec($conn,$qry5);
			$fila5 = @pg_fetch_array($result5,0);


 if($frmModo=="mostrar"){

if ($fila5['nombre_emp']==NULL){
	echo "<font face='verdana' size='1' color='FF0000'>¡Falta información!</font>";
	$cant_errores++;
	$tipo_error_1 = 1;
 }else{ ?>		 
 <?php echo trim($fila5["ape_pat"])." ".trim($fila5["ape_mat"]).", ".trim($fila5["nombre_emp"]);?>
								  
 <? } 
}
if($frmModo=="modificar"){ ?>
                    <select name="cmbPROF<?=$i?>" id="cmbPROF<?=$i?>" style="font-size:8px;">
                      <option value=0>Seleccione</option>
													
                      <?php
														//SUPERVISOR ACTUAL
													$qrysu="SELECT curso.id_curso, empleado.rut_emp FROM (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) INNER JOIN curso ON supervisa.id_curso = curso.id_curso WHERE (((curso.id_curso)=".$fila_curso['id_curso'].")) order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
														$result4 =@pg_Exec($conn,$qrysu);
														$fila4= @pg_fetch_array($result4,0);

														//DOCENTES DE LA INSTITUCION
														$qrysup="SELECT empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat,empleado.ape_mat, trabaja.rdb, trabaja.cargo FROM empleado INNER JOIN (institucion INNER JOIN trabaja ON institucion.rdb = trabaja.rdb) ON empleado.rut_emp = trabaja.rut_emp WHERE ((trabaja.rdb=".$_INSTIT.")) order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
														$resultins =@pg_Exec($conn,$qrysup);
														if (!$resultins) 
															error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
														else{
															if (pg_numrows($resultins)!=0){
																$fila1 = @pg_fetch_array($resultins,0);	
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
																	exit();
																};
																for($x=0 ; $x < @pg_numrows($resultins) ; $x++){
																	$fila1 = @pg_fetch_array($resultins,$x);
																	$NombreEmple=$fila1["nombre_emp"];
																	$NombreEmpleCortado=substr($NombreEmple,0,9); 
																	if($fila4["rut_emp"]!=$fila1["rut_emp"]){
																		echo "<option value=".$fila1["rut_emp"]."> ".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".$NombreEmpleCortado."</option>\n";
																	}else{
																		echo "<option value=".$fila1["rut_emp"]." selected> ".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".$NombreEmpleCortado."</option>\n";
																	}
																}
															}
														};
													?>
                    </select>
					
                    <?php };?>               
    </td>
    
    <td><div align="center">
    <? if($frmModo=="mostrar"){ 
	$filaD['truncado_per'];
    if ($filaD['truncado_per']==0){
    echo "NO";
    }else{
    echo "SI";
    }
    ?>						
    
    <? } 
    if($frmModo=="modificar"){ ?>
        <input type="checkbox" name="truncado_per<?=$i?>" id="truncado_per<?=$i?>" size="83" maxlength="50" value="1" <? if ($filaD['truncado_per']==1){ ?> checked="checked" <? } ?>>
    <? } ?>
    </div></td>
    <td><div align="center"> 
<? if($frmModo=="mostrar"){ ?>
   
    <?
    if ($filaD['truncado_final']==0){
         echo "NO";
    }else{
         echo "SI";
    }
    ?>						
  
<?   } 

 if($frmModo=="modificar"){ ?>
   <input type="checkbox" name="truncado_final<?=$i?>" id="truncado_final<?=$i?>" size="83" maxlength="50" value="1" <? if ($filaD['truncado_final']==1){ ?> checked="checked" <? } ?>>
                <? } ?>
    </div></td>
    <td><div align="center">
    <? if($frmModo=="mostrar"){ 
    if ($filaD['truncado_sf']==0){
     echo "NO";
    }else{
     echo "SI";
    }
  } 
    
    if($frmModo=="modificar"){ ?>
    <input type="checkbox" name="truncado_sf<?=$i?>" id="truncado_sf<?=$i?>" size="83" maxlength="50" value="1" <? if ($filaD['truncado_sf']==1){ ?> checked="checked" <? } ?>>
    <? } ?>
    </div></td>
    
    <td align="center" ><div align="center">
   <? if($frmModo=="mostrar"){
	  $filaD['bool_jor'];
    $jor = $filaD['bool_jor'];
    switch ($jor){
       case 1;
          echo "MAÑANA";
       break;	  
       case 2;
           echo "TARDE";
       break;
       case 3;
           echo "MAÑANA Y TARDE";	   
       break;
       case 4;
           echo "VESPERTINO";	   
       break;
       }    

 };
	if($frmModo=="modificar"){ 
   $jor = $filaD['bool_jor'];
   if($jor==1){
	   $jorn="Mañana";
	   }else if($jor==2){
	   $jorn="Tarde";
	   }else if ($jor==3){
		$jorn="Mañana y Tarde";   
		}else if($jor==4){
		$jorn="Vespertino";	
		}
		?>
        
<select name='Jornada<?=$i?>' id='Jornada<?=$i?>'>
<? 
	if($jor<=0){
		echo "<option value='0' selected='selected'>Seleccione</option>";
	}
	if($jor==1){
		echo "<option value='1' selected='selected'>Mañana</option>";
	}else{
		echo "<option value='1'>Mañana</option>";	
			}
	if($jor==2){
		echo "<option value='2' selected='selected'>tarde</option>";
	}else{
		echo "<option value='2'>tarde</option>";	
			}		
	if($jor==3){
		echo "<option value='3' selected='selected'>Mañana y Tarde</option>";
	}else{
		echo "<option value='3'>Mañana y Tarde</option>";	
			}		
	if($jor==4){
		echo "<option value='4' selected='selected'>Vespertino</option>";
	}else{
		echo "<option value='4'>Vespertino</option>";	
			}		
?>
 </select>
 
 <? };?> 
    </div></td>
     <td><div align="center">
    
    <? //$simce=$filaD['simce'];
	
	 if ($frmModo=="modificar" and $_PERFIL==0){ 
	 
	 $sql_ver_plan="select distinct pe.nombre_decreto,pe.cod_decreto from plan_inst pi 
							inner join plan_estudio pe on pi.cod_decreto=pe.cod_decreto
							inner join curso c on pi.cod_decreto= c.cod_decreto 
							where c.cod_decreto = ".$filaD['cod_decreto']." and c.id_curso=".$fila_curso['id_curso']."";
		$rs_ver_plan=pg_exec($conn,$sql_ver_plan);
		 $nombre_plan=pg_result($rs_ver_plan,0); 
		 $cod_dec=pg_result($rs_ver_plan,1);
	 
   $sql_plan="select pe.cod_decreto, pe.nombre_decreto from plan_inst pi 
		inner JOIN plan_estudio pe on pi.cod_decreto=pe.cod_decreto
		where pi.rdb=$institucion";
	$rs_plan=pg_exec($conn,$sql_plan);
	
	?>
    <select name="plan_ins<?=$i?>" id="plan_ins<?=$i?>">
     <option value="<?=$cod_dec;?>"><?=$nombre_plan;?></option>
     <?
     for($e=0; $e <pg_numrows($rs_plan);$e++){
		 $fila_plan=pg_fetch_array($rs_plan,$e);
		 
	echo "<option value=".$fila_plan['cod_decreto']."> ".$fila_plan['nombre_decreto']." </option>";	 
		 }
     ?>
    </select>
    <?	 	
     }
    
    if ($frmModo=="mostrar" and $_PERFIL==0){
		
		$sql_ver_plan="select pe.nombre_decreto from plan_inst pi 
							inner join plan_estudio pe on pi.cod_decreto=pe.cod_decreto
							inner join curso c on pi.cod_decreto= c.cod_decreto 
							where c.cod_decreto = ".$filaD['cod_decreto']." and c.id_curso=".$fila_curso['id_curso']."";
		$rs_ver_plan=pg_exec($conn,$sql_ver_plan);
		echo $nombre_plan=pg_result($rs_ver_plan,0); 
   
    }?>
    </div></td>
   
      
    <td><div align="center">
    
    <? $simce=$filaD['simce'];
	 if ($frmModo=="modificar"){ ?>
    <input name="simce<?=$i?>" id="simce<?=$i?>" type="text" size="5" maxlength="5" value="<?=$simce;?>">
    <? }
    
    if ($frmModo=="mostrar"){
    if ($simce==0){
    echo "-";
    }else{							
    echo $simce;
    }	
    }?>
    </div></td>
   
      <?	}  ?>
    
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
    
    
    </tr>
    </table>
    
    </div>
    
    <div class="box">
    <table width="100%" border="1" style="font-size:8px;">
      <tr align="center">
        <td width="130">CURSO</td>
        
        <td width="323">ENCARGADO&nbsp;CONFECCION ACTA</td>
       <td width="257">OBSERVACIONES&nbsp;DEL ACTA</td>
       <td width="110">MONTO MENSUAL&nbsp;DE <br />
         SUBVENCIÓN&nbsp;POR&nbsp;ALUMNO</td>
       
       <td width="90">CAPACIDAD MÁXIMA <br />
         DEL CURSO</td>
    </tr>
    <? if($frmModo!="mostrar"){?>
    <? } ?>
	<? 
	  
for($i=0 ; $i < @pg_numrows($result) ; $i++){
$fila_curso = @pg_fetch_array($result,$i);
 $Curso_pal = CursoPalabra($fila_curso['id_curso'], 1, $conn);
?>
<tr>
<td>
<?
    $qryD="select curso.*, plan_estudio.*, tipo_ensenanza.* from curso, plan_estudio, tipo_ensenanza where curso.id_curso = ".$fila_curso['id_curso']." and plan_estudio.cod_decreto = curso.cod_decreto and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$resultD =@pg_Exec($conn,$qryD);
	$filaD = @pg_fetch_array($resultD,0);	
		//$fCursoD = @pg_fetch_array($resultD,0);
		?>
<input name="cod_curso<?=$i;?>" type="hidden" value="<?=$fila_curso['id_curso'];?>" />
  
    <?php
    if ($error_conf==1){
    echo "* ";
    }			
    echo $Curso_pal;
    ?>
   </td>


    <td><div align="center">
   <? if($frmModo=="modificar"){
	
	    ?>
                    <select name="cmbACTA<?=$i?>" id="cmbACTA<?=$i?>" style="font-size:9px;" >
                      <option value=0></option>
													
                      <?php
	//SUPERVISOR ACTA
	$qrysu="SELECT curso.id_curso, curso.acta, empleado.rut_emp FROM (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) INNER JOIN curso ON supervisa.id_curso = curso.id_curso WHERE (((curso.id_curso)=".$fila_curso['id_curso'].")) order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
														$resultado2 =@pg_Exec($conn,$qrysu)or die("Fallo".$qry);
														$filac= @pg_fetch_array($resultado2,0);

														//DOCENTES DE LA INSTITUCION
														$qrysup="SELECT empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat,empleado.ape_mat, trabaja.rdb, trabaja.cargo FROM empleado INNER JOIN (institucion INNER JOIN trabaja ON institucion.rdb = trabaja.rdb) ON empleado.rut_emp = trabaja.rut_emp WHERE ((trabaja.rdb=".$_INSTIT.")) order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
														$resultado3 =@pg_Exec($conn,$qrysup);
														if (!$resultado3) 
															error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
														else{
															if (pg_numrows($resultado3)!=0){
																$fila11 = @pg_fetch_array($resultado3,0);	
																if (!$fila11){
																	error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
																	exit();
																};
																for($z=0 ; $z < @pg_numrows($resultado3) ; $z++){
																	$fila11 = @pg_fetch_array($resultado3,$z);
																	$nombreemp=$fila11["nombre_emp"];
																	$nombreEmpRes=substr($nombreemp,0,9);
																	
																	if($filac["acta"]!=$fila11["rut_emp"]){
																		echo "<option value=".$fila11["rut_emp"]."> ".trim($fila11["ape_pat"])." ".trim($fila11["ape_mat"]).", ".$nombreEmpRes."</option>\n";
																	}else{
																		echo "<option value=".$fila11["rut_emp"]." selected> ".trim($fila11["ape_pat"])." ".trim($fila11["ape_mat"]).", ".$nombreEmpRes."</option>\n";
																	}
																}
															}
														};
													?>
                    </select>
					
                    <?php };?>
					      <?php 
								if($frmModo=="mostrar"){ ?>
								    <?php

			 $qry55="select * from curso where id_curso=".$fila_curso['id_curso'];
			$result55 =@pg_Exec($conn,$qry55);
			$fila55 = @pg_fetch_array($result55,0);
									
		 $qry5="select empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado where rut_emp=".$fila55['acta'];
								
	$result5 =@pg_Exec($conn,$qry5);
	$fila5 = @pg_fetch_array($result5,0);

	if ($fila5["ape_pat"]==NULL){ ?>
		  ¡Falta Asignar Encargado de Confeccionar Acta!
		 <?    
	}else{  ?>
		
		 <?=$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]; ?>
		 <?php	}}?>
    </div>
      </td>
      
      <TD><div align="center">
<?php if($frmModo=="modificar"){ 
				 $qry_observacion="select * from curso where id_curso=".$fila_curso['id_curso'];
					$result_observacion =@pg_Exec($conn,$qry_observacion);
					$fila_observacion = @pg_fetch_array($result_observacion,0);?>
					<textarea name="observaciones<?=$i?>" id="observaciones<?=$i?>" cols="40" rows="3" ><?=$fila_observacion['observaciones']?></textarea>						
						<? } ?>	
						<?php 
if($frmModo=="mostrar"){ ?>
	<?php
	$qry_observacion="select * from curso where id_curso=".$fila_curso['id_curso'];
	$result_observacion =@pg_Exec($conn,$qry_observacion);
	$fila_observacion = @pg_fetch_array($result_observacion,0);
	echo $fila_observacion['observaciones'];							
		}?>
							     
		</div> </TD>
                                
        <td>
        <div align="center">
       					
	<?
    if ($frmModo=="mostrar"){ 
         echo $fila_observacion['val_sub'];
    }
    
    if ($frmModo=="modificar"){  ?>				
        $<input name="val_sub<?=$i?>" type="text" id="val_sub<?=$i?>" value="<?=$fila_observacion['val_sub']?>" size="10"><br> 
	<?  } ?>
        </div>
         </td>                  
               
       <td>
       <div align="center">
     <?
					if ($frmModo=="mostrar"){ 
					     echo $fila_observacion['cap_curso'];
					}
					
					if ($frmModo=="modificar"){  ?>				
				             <input name="cap_curso<?=$i?>" type="text" id="cap_curso<?=$i?>" value="<?=$fila_observacion['cap_curso']?>" size="5">
				         <?  } ?>
       </div>
       </td>         
                
                                
     <? }  ?>
    
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
    
    
    </tr>
    </table>
    
    </div>
     </div>
      </div>
       </div>
    <script type="text/javascript">
    Element.cleanWhitespace('content');
    init();
    </script>							  
    </td>
    </tr>
    </table>
    </form>
    </td>
    </tr>
    </table></td>
    </tr>
    <tr align="center" valign="middle"> 
    <td height="45" colspan="2" class="piepagina"> <? include("../../../../cabecera/menu_inferior.php"); ?></td>
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
<? pg_close($conn);?>