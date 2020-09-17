<?php
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');


	
	$_POSP = 4;
	$_bot = 8;	
	"<br>".$institucion	= $_INSTIT;
	"<br>".$ano			= $_ANO;
	"<br>".$curso			= $cmb_curso;
	"<br>".$ciclo			= $cmbCICLO;
	"<br>".$nivel			= $cmbNIVEL;
	$reporte		= $c_reporte;
	
	$ob_reporte = new Reporte();
	
	"año=".$cmb_ano;
	"<br>curso=".$cmb_curso;
	"<br>alumno=".$cmb_alumno;
	"<br>beca=".$cmb_beca;
	"<br>radio=".$r_ordena;
	"<br>radio1=".$r_ordena1;
	"<br>radio2=".$r_ordena2;
	"<br>radio2=".$r_ordena3;

	


	
if($cb_ok2 =="Exportar"){
	$fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_becas_beneficios_$fecha.xls"); 
	
}	
	?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="../../../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">
<script>
function exportar(form){
		form.target="_blank";
		form.action='print_informe_becas_beneficio.php?cmb_ano=<?=$cmb_ano?>&cmb_curso=<?=$cmb_curso?>&cmb_alumno=<?=$cmb_alumno?>&cmb_beca=<?=$cmb_beca?>&r_ordena=<?=$r_ordena?>&r_ordena1=<?=$r_ordena1?>&cb_ok2=Exportar';
		form.submit(true);
}

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

</script>

<STYLE>
.Estilo24 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000; }
.Estilo25 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000; font-weight: bold; }
</style>
<body>


<form method="post" name="form" action="print_informe_becas_beneficio.php">

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div id="capa0">
      <table width="100%">
        <tr>
          <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
          <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
          </td>
          <td align="right"><input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" onClick="exportar(this.form);"  value="EXPORTAR"></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <?
		$sql_inst="select * from institucion where rdb=".$institucion;
		$result = @pg_Exec($conn,$sql_inst);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{ ?>
    <td width="119" rowspan="6"><?
	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
    </td>
    <td width="50">&nbsp;</td>
    <td><table>
      <tr>
        <td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>
          <?=$arr['nombre_instit']?>
        </strong></font></div></td>
      </tr>
    </table>
        <table>
          <tr>
            <td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>
              <?=$arr['calle'].$arr['nro'];?>
            </strong></font></div></td>
          </tr>
        </table>
      <table>
          <tr>
            <td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>
              <?=$arr['telefono'];?>
            </strong></font></div></td>
          </tr>
      </table></td>
    <? }
		else{?>
    <td><table width="100%">
      <tr>
        <td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>
          <?=$ob_membrete->ins_pal?>
        </strong></font></div></td>
      </tr>
    </table>
        <table>
          <tr>
            <td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>
              <?=$ob_membrete->direccion;?>
            </strong></font></div></td>
          </tr>
        </table>
      <table>
          <tr>
            <td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>
              <?=$ob_membrete->telefono;?>
            </strong></font></div></td>
          </tr>
      </table></td>
    <? }  ?>
  </tr>
</table>



<? if($r_ordena1==2){


	if($cmb_alumno!=0){?>
<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
 <? 
 	$sql_curso="SELECT a.letra_curso,a.grado_curso,a.ensenanza,b.nombre_tipo FROM curso a ";
	$sql_curso.="INNER JOIN tipo_ensenanza b ON (a.ensenanza=b.cod_tipo)  where a.id_curso=".$cmb_curso."";
	$res_curso=@pg_exec($conn,$sql_curso);
	$curso=pg_fetch_array($res_curso,0);
 
 ?>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="Estilo24"><strong>Curso:</strong>&nbsp;&nbsp;<?=$curso['grado_curso']."-".$curso['letra_curso']." ".$curso['nombre_tipo']?></td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
     <? $sql_alumno="SELECT * FROM becas_benef WHERE rut_alumno=".$cmb_alumno." and id_ano=".$cmb_ano." ";
  	  $res_alumno=@pg_exec($conn,$sql_alumno);
	  $conteo=pg_numrows($res_alumno);
	   
  	if($conteo!=0){
	
		$sql="select * from alumno where rut_alumno=".$cmb_alumno;
		$result= @pg_Exec($conn,$sql);
		$alumno=pg_fetch_array($result,0);
	?>
  <tr>
    <td width="40%" class="Estilo24 cajamenu"><div align="left"><strong>Alumno:</strong>&nbsp;&nbsp;
          <?=$ob_reporte->tilde(ucwords(strtolower($alumno['ape_pat']." ".$alumno['ape_mat'].",".$alumno['nombre_alu'])));?>
    </div></td>
    <td width="30%" class="Estilo24 cajamenu"><div align="center"><strong>Beca</strong></div></td>
    <td width="30%" class="Estilo24 cajamenu"><div align="center"><strong>Fecha Postulación</strong></div></td>
  </tr>
   <? for($i=0;$i<$conteo;$i++){
	  	$becas=pg_fetch_array($res_alumno,$i);
		
		$sql_beca="SELECT nomb_beca FROM becas_conf WHERE id_beca=".$becas['id_beca'];
		$res_beca=@pg_exec($conn,$sql_beca);
		$nombre=pg_result($res_beca,0);
		?>
   <tr>
          <td width="40%" class="Estilo24">
      <div align="center"></div></td>
		  <td width="30%" class="Estilo24">
		    <div align="center">
		      <?=$ob_reporte->tilde(ucwords(strtolower($nombre)));?>
            </div></td><td width="30%" class="Estilo24"><div align="center">
	              <?
		  
		  		$FECHAC= $becas['fecha_postul'];
				$AA = substr ("$FECHAC;", 0, -7); 
				$mm = substr ("$FECHAC;", 5, -4);
				$dd = substr ("$FECHAC;", 8, -1);
				$dia2 = getdate(mktime(0,0,0,$mm,$dd,$AA));
				$dia = $dia2["mday"];
				if($dia<10){
					$dia = "0".$dia;
				}else{
					$dia;
					}
				$mes = $dia2["mon"];
				if($mes<10){
					$mes = "0".$mes;
				}else{
					$mes;
				}
				$fecha_mes = $dia."-".$mes;
				echo "(".$FECHA_CREA = $fecha_mes."-".$dia2["year"].")";
		  
		  ?>
	              </div></td>
   </tr> 
		<? }?>
    <tr>
    <td width="40%"><div align="center"></div></td>
    <td width="30%" class="Estilo24"><div align="center"></div></td>
    <td width="30%" class="Estilo24">&nbsp;</td>
    </tr>
  <? 
  }?>
  </table>
<? }

if($cmb_alumno==0){?> 

 <? 
 	$sql_curso="SELECT a.letra_curso,a.grado_curso,a.ensenanza,b.nombre_tipo FROM curso a ";
	$sql_curso.="INNER JOIN tipo_ensenanza b ON (a.ensenanza=b.cod_tipo)  where a.id_curso=".$cmb_curso."";
	$res_curso=@pg_exec($conn,$sql_curso);
	$curso=pg_fetch_array($res_curso,0);
 
 ?>
<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td colspan="3" class="Estilo24">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="Estilo24"><strong>Curso:</strong>&nbsp;&nbsp;<?=$curso['grado_curso']."-".$curso['letra_curso']." ".$curso['nombre_tipo']?></td>
	<?  $sql_alumno="SELECT DISTINCT a.rut_alumno,c.ape_pat,c.ape_mat,c.nombre_alu FROM matricula a INNER JOIN becas_benef b ";
  	  $sql_alumno.="ON (a.rut_alumno=b.rut_alumno) INNER JOIN alumno c ON (b.rut_alumno=c.rut_alumno)";
  	  $sql_alumno.="WHERE  a.id_curso=".$cmb_curso." ORDER BY ape_pat ASC ";
	  $rs_alumno=@pg_exec($conn,$sql_alumno);
	  $cantidad=pg_numrows($rs_alumno);
	  
	  
	for($i=0;$i<$cantidad;$i++){  
		$alumnos_cantidad=$i+1;
	}
  ?>
    <td width="34%" class="Estilo25">Cantidad Alumnos: <?=$alumnos_cantidad?></td>
  </tr>
</table>


<br/>

<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
  <?  $sql_alumno="SELECT DISTINCT a.rut_alumno,c.ape_pat,c.ape_mat,c.nombre_alu FROM matricula a INNER JOIN becas_benef b ";
  	  $sql_alumno.="ON (a.rut_alumno=b.rut_alumno) INNER JOIN alumno c ON (b.rut_alumno=c.rut_alumno)";
  	  $sql_alumno.="WHERE  a.id_curso=".$cmb_curso." ORDER BY ape_pat ASC ";
	  $rs_alumno=@pg_exec($conn,$sql_alumno);
	  $cantidad=pg_numrows($rs_alumno);
	  
	  
	for($i=0;$i<$cantidad;$i++){  
		$alumno=pg_fetch_array($rs_alumno,$i);
  ?>
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>

  <tr>
    <td width="40%" class="Estilo24 cajamenu"><div align="left"><strong>Alumno:</strong>&nbsp;&nbsp;
      <?=$ob_reporte->tilde(ucwords(strtolower($alumno['ape_pat']." ".$alumno['ape_pat'].", ".$alumno['nombre_alu'])))?>    
    </div></td>
    <td width="30%" class="Estilo24 cajamenu"><div align="center"><strong>Becas</strong></div></td>
    <td width="30%" class="Estilo25 cajamenu"><div align="center">Fecha postulaci&oacute;n </div></td>
  </tr>
   
   <? 
   		$sql_becas="SELECT * FROM becas_benef WHERE rut_alumno=".$alumno['rut_alumno']." and id_ano=".$cmb_ano;
		$rs_becas=@pg_exec($conn,$sql_becas);
		$cant_becas=pg_numrows($rs_becas);
		
		for($j=0;$j<$cant_becas;$j++){
			$beca=pg_fetch_array($rs_becas,$j);
			
		$sql_info="SELECT nomb_beca FROM becas_conf WHERE id_beca=".$beca['id_beca'];
		$rs_info=@pg_exec($conn,$sql_info);
		$nombre_beca=pg_result($rs_info,0);	
		
   
   ?>
   
   <tr>
          <td width="40%" class="Estilo24">
      <div align="center"></div></td>
		  <td width="30%" class="Estilo24">
		    <div align="center">
		      <?=ucfirst($nombre_beca)?>
            </div></td><td width="30%" class="Estilo24"><div align="center">
	              <? $beca['fecha_postul'];
				  
				$FECHAC= $beca['fecha_postul'];
				$AA = substr ("$FECHAC;", 0, -7); 
				$mm = substr ("$FECHAC;", 5, -4);
				$dd = substr ("$FECHAC;", 8, -1);
				$dia2 = getdate(mktime(0,0,0,$mm,$dd,$AA));
				$dia = $dia2["mday"];
				if($dia<10){
					$dia = "0".$dia;
				}else{
					$dia;
					}
				$mes = $dia2["mon"];
				if($mes<10){
					$mes = "0".$mes;
				}else{
					$mes;
				}
				$fecha_mes = $dia."-".$mes;
				echo "(".$FECHA_CREA = $fecha_mes."-".$dia2["year"].")";
				  
				  
				  
				  
				  ?>
	              </div></td>
   </tr> 

	<? }?>


    <tr>
    <td width="40%"><div align="center"></div></td>
    <td width="30%" class="Estilo24"><div align="center"></div></td>
    <td width="30%" class="Estilo24">&nbsp;</td>
    </tr>
	<? }?>
  </table>

<? }

}





if($r_ordena==1){


	if($cmb_beca!=0){?>

<br/>
<br/>
<?
	$sql_beca="SELECT nomb_beca FROM becas_conf WHERE id_beca=".$cmb_beca." ORDER BY nomb_beca ASC";
	$rs_beca=@pg_exec($conn,$sql_beca);
	$beca=pg_result($rs_beca,0);
?>
<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center" class="Estilo24">
  <tr>
    <td width="50%"><strong>Beca:&nbsp;&nbsp;<?=$ob_reporte->tilde(ucwords(strtolower($beca)));?></strong></td>
	<? $sql_alumnos="SELECT * FROM becas_benef WHERE id_beca=".$cmb_beca;
	$rs_alumnos=@pg_exec($conn,$sql_alumnos);
	$cantidad=pg_numrows($rs_alumnos);
	
	for($i=0;$i<$cantidad;$i++){
		$cantidad_alumnos=$i+1;
	}?>
    <td width="50%"><strong>Cantidad Alumnos: <?=$cantidad_alumnos?></strong></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" class="cajamenu"><div align="center"><strong>Nombre alumno </strong></div></td>
    <td width="50%" class="cajamenu"><div align="center"><strong>Curso</strong></div></td>
  </tr>
  <? 
  	$sql_alumnos="SELECT * FROM becas_benef WHERE id_beca=".$cmb_beca;
	$rs_alumnos=@pg_exec($conn,$sql_alumnos);
	$cantidad=pg_numrows($rs_alumnos);
	
	for($i=0;$i<$cantidad;$i++){
		$alumno=pg_fetch_array($rs_alumnos,$i);
		
	$sql_info="SELECT nombre_alu,ape_pat,ape_mat FROM alumno WHERE rut_alumno=".$alumno['rut_alumno'];
	$rs_info=@pg_exec($conn,$sql_info);
	$info=pg_fetch_array($rs_info,0);
	
	$sql_matri="SELECT id_curso FROM matricula WHERE rut_alumno=".$alumno['rut_alumno']." and id_ano=".$cmb_ano;
	$rs_matri=@pg_exec($conn,$sql_matri);
	$id_curso=pg_result($rs_matri,0);
	
	$sql_curso="SELECT * FROM curso a INNER JOIN tipo_ensenanza b ON (a.ensenanza=b.cod_tipo) WHERE id_curso=".$id_curso;
	$rs_curso=@pg_exec($conn,$sql_curso);
	$curso=pg_fetch_array($rs_curso,0);

  
  ?>  
   <tr>
    <td width="50%"><div align="center">
      <?=$ob_reporte->tilde(ucwords(strtolower($info['ape_pat']." ".$info['ape_mat'].", ".$info['nombre_alu'])))?>
    </div></td>
    <td width="50%"><div align="center"><?=$curso['grado_curso']." - ".$curso['letra_curso']."  ".$curso['nombre_tipo']?></div></td>
  </tr>
  <? }?>
</table>

<? }

if($cmb_beca==0){?>

<? 
	$sql="select a.* from becas_conf a inner join ano_escolar b on(a.id_ano=b.id_ano) ";
	$sql.=" where b.id_institucion=$_INSTIT ORDER BY nomb_beca ASC";
	$rs_sql=@pg_exec($conn,$sql);
	$conteo=pg_numrows($rs_sql);
	for($k=0;$k<$conteo;$k++){
	$conf=pg_fetch_array($rs_sql,$k);
	

?>
<br/>
<br/>
<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center" class="Estilo24">
  <tr>
    <td width="50%"><strong>Beca:&nbsp;&nbsp;
          <?=ucfirst($conf['nomb_beca'])?>
    </strong></td>
	 <?	$sql_alumnos="SELECT * FROM becas_benef WHERE id_beca=".$conf['id_beca'];
	$rs_alumnos=@pg_exec($conn,$sql_alumnos);
	$cantidad=pg_numrows($rs_alumnos);
	
	for($i=0;$i<$cantidad;$i++){
		$cant_alumnos=$i+1;
	}?>
    <td width="50%"><strong>Cantidad Alumnos: <?=$cant_alumnos?></strong></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" class="cajamenu"><div align="center"><strong>Nombre alumno </strong></div></td>
    <td width="50%" class="cajamenu"><div align="center"><strong>Curso</strong></div></td>
  </tr>
  <? 
  	$sql_alumnos="SELECT * FROM becas_benef WHERE id_beca=".$conf['id_beca'];
	$rs_alumnos=@pg_exec($conn,$sql_alumnos);
	$cantidad=pg_numrows($rs_alumnos);
	
	for($i=0;$i<$cantidad;$i++){
		$alumno=pg_fetch_array($rs_alumnos,$i);
		
	$sql_info="SELECT nombre_alu,ape_pat,ape_mat FROM alumno WHERE rut_alumno=".$alumno['rut_alumno'];
	$rs_info=@pg_exec($conn,$sql_info);
	$info=pg_fetch_array($rs_info,0);
	
	$sql_matri="SELECT id_curso FROM matricula WHERE rut_alumno=".$alumno['rut_alumno']." and id_ano=".$cmb_ano;
	$rs_matri=@pg_exec($conn,$sql_matri);
	$id_curso=pg_result($rs_matri,0);
	
	$sql_curso="SELECT * FROM curso a INNER JOIN tipo_ensenanza b ON (a.ensenanza=b.cod_tipo) WHERE id_curso=".$id_curso;
	$rs_curso=@pg_exec($conn,$sql_curso);
	$curso=pg_fetch_array($rs_curso,0);

  
  ?>
  <tr>
    <td width="50%"><div align="center">
      <?=$ob_reporte->tilde(ucwords(strtolower($info['ape_pat']." ".$info['ape_mat'].", ".$info['nombre_alu'])));?>
    </div></td>
    <td width="50%"><div align="center">
      <?=$curso['grado_curso']." - ".$curso['letra_curso']."  ".$curso['nombre_tipo']?>
    </div></td>
  </tr>
  <? }?>
</table>
<? 		}
	}

}?>




<? if($r_ordena2==3){

		$qry="SELECT nro_ano FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." AND id_ano=".$ano;
		$result =@pg_Exec($conn,$qry);
		$ano2 = pg_result($result,0);

	if($cmbCICLO!=0){?>

<br/>
<br/>
<?
	$sql_ciclos="SELECT DISTINCT a.id_curso,c.nomb_ciclo FROM ciclos a INNER JOIN matricula b ON ";
	$sql_ciclos.="(a.id_curso=b.id_curso) INNER JOIN ciclo_conf c ON (a.id_ciclo=c.id_ciclo) where a.id_ciclo=".$ciclo." ORDER BY id_curso DESC";
	$rs_ciclos=@pg_exec($conn,$sql_ciclos);
	$ciclos=pg_fetch_array($rs_ciclos,0);

?>
<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center" class="Estilo24">
  <tr>
    <td width="50%"><strong>Ciclo:&nbsp;&nbsp;<?=ucfirst($ciclos['nomb_ciclo'])?></strong></td>
	<? for($j=0;$j<pg_numrows($rs_ciclos);$j++){
	$ciclos=pg_fetch_array($rs_ciclos,$j);
  
  	$sql_alumnos="SELECT DISTINCT a.rut_alumno FROM matricula a INNER JOIN becas_benef b ON (a.rut_alumno=b.rut_alumno) ";
	$sql_alumnos.="WHERE a.id_curso=".$ciclos['id_curso']."";
	$rs_alumnos=@pg_exec($conn,$sql_alumnos);
	 
	for($i=0;$i<pg_numrows($rs_alumnos);$i++){
	$cantidad=$i+1;
	}
	}?>
    <td width="50%"><strong>Cantidad Alumnos:</strong> 
      <?=$cantidad?>&nbsp;</td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" class="cajamenu"><div align="center"><strong>Nombre alumno </strong></div></td>
    <td width="50%" class="cajamenu"><div align="center"><strong>Curso</strong></div></td>
  </tr>
  <? 
	for($j=0;$j<pg_numrows($rs_ciclos);$j++){
	$ciclos=pg_fetch_array($rs_ciclos,$j);
  
  	$sql_alumnos="SELECT DISTINCT a.rut_alumno FROM matricula a INNER JOIN becas_benef b ON (a.rut_alumno=b.rut_alumno) ";
	$sql_alumnos.="WHERE a.id_curso=".$ciclos['id_curso']."";
	$rs_alumnos=@pg_exec($conn,$sql_alumnos);
	 
	for($i=0;$i<pg_numrows($rs_alumnos);$i++){
	$total=pg_fetch_array($rs_alumnos,$i);
	
	$sql_info="SELECT nombre_alu,ape_pat,ape_mat FROM alumno WHERE rut_alumno=".$total['rut_alumno']."";
	$rs_info=@pg_exec($conn,$sql_info);
	$info=pg_fetch_array($rs_info,0);
	
	$sql_matri="SELECT id_curso FROM matricula WHERE rut_alumno=".$total['rut_alumno']." and id_ano=".$ano;
	$rs_matri=@pg_exec($conn,$sql_matri);
	$id_curso=pg_result($rs_matri,0);
	
	$sql_curso="SELECT * FROM curso a INNER JOIN tipo_ensenanza b ON (a.ensenanza=b.cod_tipo) WHERE id_curso=".$id_curso;
	$rs_curso=@pg_exec($conn,$sql_curso);
	$curso=pg_fetch_array($rs_curso,0);

  
  ?>  
   <tr>
    <td width="50%"><div align="center">
      <?=$ob_reporte->tilde(ucwords(strtolower($info['ape_pat']." ".$info['ape_mat'].", ".$info['nombre_alu'])))?>
    </div></td>
    <td width="50%"><div align="center"><?=$curso['grado_curso']." - ".$curso['letra_curso']."  ".$curso['nombre_tipo']?></div></td>
  </tr>
  <? }
  }?>
</table>

<? }
}?>




<? if($r_ordena3==4){

		$qry="SELECT nro_ano FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." AND id_ano=".$ano;
		$result =@pg_Exec($conn,$qry);
		$ano2 = pg_result($result,0);

	if($cmbNIVEL!=0){?>

<br/>
<br/>
<?
	$sql_niveles="SELECT DISTINCT a.id_curso,c.nombre FROM nivel_curso a INNER JOIN matricula b ON ";
	$sql_niveles.="(a.id_curso=b.id_curso) INNER JOIN niveles c ON (a.id_nivel=c.id_nivel) where a.id_nivel=".$nivel." ";
	$sql_niveles.="ORDER BY id_curso DESC";
	$rs_niveles=@pg_exec($conn,$sql_niveles);
	$niveles=pg_fetch_array($rs_niveles,0);

?>
<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center" class="Estilo24">
  <tr>
    <td width="50%"><strong>Nivel:&nbsp;&nbsp;<?=ucfirst($niveles['nombre'])?></strong></td>
	<? for($j=0;$j<pg_numrows($rs_niveles);$j++){
	$niveles=pg_fetch_array($rs_niveles,$j);
  
  	$sql_alumnos="SELECT DISTINCT a.rut_alumno FROM matricula a INNER JOIN becas_benef b ON (a.rut_alumno=b.rut_alumno) ";
	$sql_alumnos.="WHERE a.id_curso=".$niveles['id_curso']."";
	$rs_alumnos=@pg_exec($conn,$sql_alumnos);
	 
	for($i=0;$i<pg_numrows($rs_alumnos);$i++){
	$cantidad_alu=$i+1;
	}
	}?>
    <td width="50%"><strong>Cantidad Alumnos:</strong> <?=$cantidad_alu?></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" class="cajamenu"><div align="center"><strong>Nombre alumno </strong></div></td>
    <td width="50%" class="cajamenu"><div align="center"><strong>Curso</strong></div></td>
  </tr>
  <? 
	for($j=0;$j<pg_numrows($rs_niveles);$j++){
	$niveles=pg_fetch_array($rs_niveles,$j);
  
  	$sql_alumnos="SELECT DISTINCT a.rut_alumno FROM matricula a INNER JOIN becas_benef b ON (a.rut_alumno=b.rut_alumno) ";
	$sql_alumnos.="WHERE a.id_curso=".$niveles['id_curso']."";
	$rs_alumnos=@pg_exec($conn,$sql_alumnos);
	 
	for($i=0;$i<pg_numrows($rs_alumnos);$i++){
	$total=pg_fetch_array($rs_alumnos,$i);
		
	$sql_info="SELECT nombre_alu,ape_pat,ape_mat FROM alumno WHERE rut_alumno=".$total['rut_alumno']."";
	$rs_info=@pg_exec($conn,$sql_info);
	$info=pg_fetch_array($rs_info,0);
	
	$sql_matri="SELECT id_curso FROM matricula WHERE rut_alumno=".$total['rut_alumno']." and id_ano=".$ano;
	$rs_matri=@pg_exec($conn,$sql_matri);
	$id_curso=pg_result($rs_matri,0);
	
	$sql_curso="SELECT * FROM curso a INNER JOIN tipo_ensenanza b ON (a.ensenanza=b.cod_tipo) WHERE id_curso=".$id_curso;
	$rs_curso=@pg_exec($conn,$sql_curso);
	$curso=pg_fetch_array($rs_curso,0);

  
  ?>  
   <tr>
    <td width="50%"><div align="center">
      <?=$ob_reporte->tilde(ucwords(strtolower($info['ape_pat']." ".$info['ape_mat'].", ".$info['nombre_alu'])));?>
    </div></td>
    <td width="50%"><div align="center"><?=$curso['grado_curso']." - ".$curso['letra_curso']."  ".$curso['nombre_tipo']?></div></td>
  </tr>
  <? }
  }?>
</table>

<? }
}?>




</form>

