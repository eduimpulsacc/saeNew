<?php
require('../../../../util/header.inc');	
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');

	$_POSP = 4;
	$_bot = 8;
	$cmb_alumnos=$_POST['cmb_alumnos'];
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	//echo $cmb_estados;
	$fecha_hoy=date("d-m-Y");
	$count = 0;
	for($i=1;$i<7;$i++){
		if(${"ck_".$i} == 1){
		$count = $count+1;
		}
	}


//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
if($valor == "1"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Acta_$Fecha.xls"); 
	
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
function enviapag2(form){ //-------------------para exportar
		form.target="_blank";
		form.action='PrintInformeActas.php?valor=1&cmb_estados=<?=$cmb_estados?>&cmb_alumnos=<?=$cmb_alumnos?>&r_ordena=<?=$r_ordena?>&cmb_ano=<?=$ANO?>&ck_1=<?=$ck_1?>&ck_2=<?=$ck_2?>&ck_3=<?=$ck_3?>&ck_4=<?=$ck_4?>&ck_5=<?=$ck_5?>&ck_6=<?=$ck_6?>&ck_7=<?=$ck_7?>&r_puntaje=<?=$r_puntaje?>';
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
<script src="../../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>
<body>

<form name="form" action="PrintInformeActas.php" method="post">
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div id="capa0">
	<table width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </td>
	    <td align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form)"  value="EXPORTAR"></td>
	  </tr></table>
      
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
			<td width="119" rowspan="6">
						<?
	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
			</td>
			<td width="50">&nbsp;</td>
			<td>
	
				<table>
				  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['nombre_instit']?></strong></font></div></td>
				  </tr>
				</table>
				<table>  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['calle'].$arr['nro'];?></strong></font></div></td>
					</tr>
				</table>
				<table>  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['telefono'];?></strong></font></div></td>
					</tr>
				</table>
			</td>

	<? }
		else{?>
		<td>
			<table width="100%">
			  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->ins_pal?></strong></font></div></td>
			  </tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->direccion;?></strong></font></div></td>
				</tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->telefono;?></strong></font></div></td>
				</tr>
			</table>
		</td>
	<? }  ?>
	</tr>
</table>
<br/>
<?
//-----------------------------obtener alumno-----------------------------------

 	$sql="select distinct a.nombre_alu,a.fecha_nac,a.rut_alumno,a.dig_rut,a.ape_pat,a.ape_mat,b.*, ";
	$sql.=" c.cod_estado,nombre_estado,d.*,e.id_curso from alumno a INNER JOIN practicas b  ON (a.rut_alumno=b.rut_alu) ";
	$sql.=" INNER JOIN estado_practica c ON (b.estado=c.cod_estado) INNER JOIN titulacion d on ";
	$sql.=" (b.rut_alu=d.rut_alu) INNER JOIN matricula e ON (b.rut_alu=e.rut_alumno) ";
	$sql.=" where c.cod_estado=5 and d.rut_alu=$cmb_alumnos and e.id_ano=$_ANO";
	  	
	//echo $sql;
	$rs_sql= pg_exec($conn,$sql);
	$fila_alu=pg_fetch_array($rs_sql,0);
	$id_curso=$fila_alu['id_curso'];
//------------------------------------------------------------------------------
?>
<table align="center" width="650">
	<tr>
	  <td>
		
		<table align="left" width="200" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="89" class="item">N&ordm; TITULO</td>
			<td width="95" class="subitem"><?=$fila_alu['numero_titulo'];?>&nbsp;</td>
		  </tr>
		  <tr>
			<td class="item">FECHA</td>
			<td class="subitem"><?=$fecha_hoy;?>&nbsp;</td>
		  </tr>
		</table>
		<br/>
		<br/>
		<br/>
		<br/>
		<table width="703" border="1">
		  <tr>
			<td align="center" class="titulo">ACTA CALIFICACI&Oacute;N PROCESO FINAL DE TITULACION</td>
		  </tr>
		</table>
		
		<p class="titulo">1. ANTECEDENTED DEL ALUMNO:</p>
		<table width="703" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="158" class="item">NOMBRE ALUMNO</td>
			<td colspan="3" align="center" class="subitem"><?=$fila_alu['nombre_alu']." ".$fila_alu['ape_pat']." ".$fila_alu['ape_mat'];?>&nbsp;</td>
		  </tr>
		  <tr>
		  <?
				$sqlesp="select nombre_esp,cod_esp from especialidad a inner join curso b on ";
				$sqlesp.="(a.cod_esp=b.cod_es) where b.id_curso=$id_curso";
				$respes=pg_exec($conn,$sqlesp);
				$fila_esp=pg_fetch_array($respes,0);
		  
		  ?>
			<td class="item">ESPECIALIDAD</td>
			<td colspan="3" align="center" class="subitem"><? if($fila_esp['nombre_esp']==NULL){ echo "NO TIENE ESPECIALIDAD";}else{ echo $fila_esp['nombre_esp'];} ?>&nbsp;</td>
		  </tr>
		  <tr>
		  <?
		  //////////////////////////////////////////////////
			$FECHAC1= $fila_alu['fecha_nac'];
			$AA1 = substr ("$FECHAC1;", 0, -7); 
			$mm1 = substr ("$FECHAC1;", 5, -4);
			$dd1 = substr ("$FECHAC1;", 8, -1);
			$dia11 = getdate(mktime(0,0,0,$mm1,$dd1,$AA1));
			$dia1 = $dia11["mday"];
			if($dia1<10){
				$dia1 = "0".$dia1;
			}else{
				$dia1;
				}
			$mes1 = $dia11["mon"];
			if($mes1<10){
				$mes1 = "0".$mes1;
			}else{
				$mes1;
			}
			$fecha_mes1 = $dia1."-".$mes1;
			$FECHAC1 = $fecha_mes1."-".$dia11["year"];
			////////////////////////////////////////////////
		  
		  
		  
		  
		  ?>
			<td class="item">RUT</td>
			<td width="131" align="center" class="subitem"><?=$fila_alu['rut_alu']."-".$fila_alu['dig_rut'];?>&nbsp;</td>
			<td width="167" class="item">FECHA NACIMIENTO</td>
			<td width="150" align="center" class="subitem"><?=$FECHAC1;?>&nbsp;</td>
		  </tr>
		</table>
		<p class="titulo">2.ANTECEDENTES DE LA PR&Aacute;CTICA:</p>
		<table width="703" border="1" cellpadding="0" cellspacing="0">
		  <tr>
		  <?
			$sql4="select max(a.id_ano),c.nro_ano,b.bool_jor from promocion a inner join curso b on (a.id_curso=b.id_curso) ";
			$sql4.=" inner join ano_escolar c on (a.id_ano=c.id_ano) where b.grado_curso=4 and b.ensenanza>=310 ";
			$sql4.=" and  a.rut_alumno=$cmb_alumnos and a.situacion_final=1 group by c.nro_ano,b.bool_jor";
			$resp4=pg_exec($conn,$sql4);
			$fila_egreso=pg_fetch_array($resp4,0);
			$ano_egreso=$fila_egreso['max'];
		  
		  //////////////////////////////////////////////////
			$FECHAC2= $fila_alu['fecha_ini'];
			$AA2 = substr ("$FECHAC2;", 0, -7); 
			$mm2 = substr ("$FECHAC2;", 5, -4);
			$dd2 = substr ("$FECHAC2;", 8, -1);
			$dia22 = getdate(mktime(0,0,0,$mm2,$dd2,$AA2));
			$dia2 = $dia22["mday"];
			if($dia2<10){
				$dia2 = "0".$dia2;
			}else{
				$dia2;
				}
			$mes2 = $dia22["mon"];
			if($mes2<10){
				$mes2 = "0".$mes2;
			}else{
				$mes2;
			}
			$fecha_mes2 = $dia2."-".$mes2;
			$FECHAC2 = $fecha_mes2."-".$dia22["year"];
			////////////////////////////////////////////////
		  
			//////////////////////////////////////////////////
			$FECHAC3= $fila_alu['fecha_ter'];
			$AA3 = substr ("$FECHAC3;", 0, -7); 
			$mm3 = substr ("$FECHAC3;", 5, -4);
			$dd3 = substr ("$FECHAC3;", 8, -1);
			$dia33 = getdate(mktime(0,0,0,$mm3,$dd3,$AA3));
			$dia3 = $dia33["mday"];
			if($dia3<10){
				$dia3 = "0".$dia3;
			}else{
				$dia3;
				}
			$mes3 = $dia33["mon"];
			if($mes3<10){
				$mes3 = "0".$mes3;
			}else{
				$mes3;
			}
			$fecha_mes3 = $dia3."-".$mes3;
			$FECHAC3 = $fecha_mes3."-".$dia33["year"];
			////////////////////////////////////////////////
		  ?>
		  
			<td width="112" rowspan="2" class="item">EGRESO</td>
			<td width="201" rowspan="2" align="center" class="subitem"><?=$fila_egreso['nro_ano'];?>&nbsp;</td>
			<td width="153" rowspan="2" class="item">PERIODO PRACTICA</td>
			<td width="112" align="center" class="subitem"><?=$FECHAC2;?>&nbsp;</td>
			<td width="113" align="center" class="subitem"><?=$FECHAC3;?>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" class="item">INICIO</td>
			<td width="113" align="center" class="item">TERMINO</td>
		  </tr>
		  <tr>
			<td class="item">JORNADA</td>
			<td align="center" class="subitem"><?
								$jor = $fila_egreso['bool_jor'];
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
								   } ?>	 &nbsp;</td>
			<td class="item">NUMERO DE HORAS</td>
			<td colspan="2" align="center" class="subitem"><?=$fila_alu['cantidad_horas'];?>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2" class="item">LUGAR DE REALIZAC&Oacute;N DE LA PR&Aacute;CTICA</td>
			<td colspan="3" align="center" class="item"><?=$fila_alu['nombre_emp'];?>&nbsp;</td>
		  </tr>
		</table>
		<p class="titulo">3.EVALUACION:</p>
		<table width="703" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="272" class="item">EVALUACIONES</td>
			<td width="214" align="center" class="item">NOTA PARCIAL</td>
			<td width="209" align="center" class="item">PONDERACION</td>
		  </tr>
		  <tr>
		  <?
				$sql2="select avg(a.promedio) as promedio from promedio_alumno a ";
				$sql2.=" inner join curso b on (a.id_curso=b.id_curso) where a.rut_alumno=$cmb_alumnos and b.ensenanza>=310 ";
				$resp2=pg_exec($conn,$sql2);
				$promedio=pg_result($resp2,0);
		  
		  
		  ?>
			<td class="item">NOTAS DE 1&ordm; a 4&ordm; MEDIO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 70%</td>
			<td align="center" class="subitem"><?=round($promedio);?>&nbsp;</td>
			<td align="center" class="subitem"><?=$ponderacion=($promedio*0.7);?>&nbsp;</td>
		  </tr>
		  <tr>
		  <?	
				$id=$fila_alu['id_practica'];
				$sql3="select calificacion from eval_practicas where id_practica=$id";
				$resp3=pg_exec($conn,$sql3);
				$promedio_prac=pg_result($resp3,0);
		  
		  
		  ?>
			<td class="item">PRACTICA PROFESIONAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 30%</td>
			<td align="center" class="subitem"><?=round($promedio_prac);?>&nbsp;</td>
			<td align="center" class="subitem"><?=$ponderacion_prac=($promedio_prac*0.3);?>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2" align="right" class="item">NOTA FINAL</td>
			<td align="center"><?=$tolal=($ponderacion_prac+$ponderacion);?>&nbsp;</td>
		  </tr>
		</table>
		<p class="titulo">4.ANTECEDENTES DEL TITULO:</p>
		<table width="703" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<td colspan="4" class="item">ESPECIALIDAD DE ESTUDIO</td>
			<td colspan="4" class="item">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="4" align="center" class="item">RES. PLAN DE ESTUDIO</td>
			<td colspan="4"  align="center" class="item">DECRETO EVALUACION</td>
		  </tr>
		  <tr align="center"> 
		  <?
			$sql5="select b.cod_decreto,grado_curso,d.cod_eval,c.nombre_decreto,d.nombre_decreto_eval ";
			$sql5.=" from matricula a inner join curso b on (a.id_curso=b.id_curso) ";
			$sql5.=" inner join plan_estudio c on (b.cod_decreto=c.cod_decreto) inner join ";
			$sql5.=" evaluacion d on (b.cod_eval=d.cod_eval) where a.rut_alumno=$cmb_alumnos and b.ensenanza>=310 ";
			$sql5.=" order by b.grado_curso asc";
			$resp5=pg_exec($conn,$sql5);
			
		  
		  ?>
		  <?  	
				for($y=0;$y<4;$y++){
				$fila=pg_fetch_array($resp5,$y);
				
		  ?>
			<td width="83" class="item"><?=$fila['grado_curso'];?>&ordm;</td>
			<? } ?>
			 <?  	
				for($x=0;$x<4;$x++){
				$fila=pg_fetch_array($resp5,$x);
				
		  ?>
			<td width="83" class="item"><?=$fila['grado_curso'];?>&ordm;</td>
			<? } ?>
		  </tr>
		 
		  <tr>
		  <?  	
				for($i=0;$i<4;$i++){
				$fila=pg_fetch_array($resp5,$i);
		   ?>
			
				 <td class="subitem"><?=$fila['nombre_decreto_eval'];?>&nbsp;</td>
				<? }?>
			
			
		  <?   for($j=0;$j<4;$j++){
			   $fila=pg_fetch_array($resp5,$j);
			   
		  ?>
			
				<td class="subitem"><?=$fila['nombre_decreto'];?>&nbsp;</td>
				
			   
			<? }?>
		  </tr>
		  <tr>
			<td colspan="3" class="item">DECRETO PROCESO TITULACI&Oacute;N</td>
			<td class="subitem"><?=$fila_alu['decreto_proceso_titulo'];?>&nbsp;</td>
			<td colspan="3" class="item">DADO EN VI&Ntilde;A DEL MAR</td>
			<td class="subitem">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="3" class="item">RECIBIDO DE SECREDUC</td>
			<td class="subitem">&nbsp;</td>
			<td colspan="3" class="item">RETIRADO DE INSUCO</td>
			<td class="subitem">&nbsp;</td>
		  </tr>
		</table>
		
		
		<br>
		<table width="300" border="0">
		  <tr>
			<td class="subitem"><? 
		function FechaFormateada2($FechaStamp)
		{ 
		  $ano = date('Y',$FechaStamp);
		  $mes = date('n',$FechaStamp);
		  $dia = date('d',$FechaStamp);
		  $diasemana = date('w',$FechaStamp);
		
		  $diassemanaN= array("Domingo","Lunes","Martes","Miércoles",
							  "Jueves","Viernes","Sábado"); $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
						 "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		  return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." del $ano";
		}
		
		 $fecha = time();
		 echo FechaFormateada2($fecha);
			
			?>&nbsp;</td>
		  </tr>
		</table>
	    <br></td>
</tr>
</table>
&nbsp;</p>
</form>
</body>
</html>
<? pg_close($conn);?>