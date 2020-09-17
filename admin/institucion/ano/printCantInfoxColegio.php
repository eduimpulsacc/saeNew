<?php 

include_once("../../../util/header.inc");

echo "-->".$corporacion."<br>";

print_r($_GET);
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
  
    
  /*if ($corporacion==1 or $corporacion==4)
  {
 	$conn=pg_connect("dbname=coi_final_vina host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion.");	
  }
  else
  {
 $conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
  }*/
  
		/* $_ESTILO="../../../estilos/estilos.css";
		$_IMAGEN_IZQUIERDA="../../../cortes/fondo_01.jpg";
		$_IMAGEN_DERECHA="../../../cortes/fomdo_02.jpg";		 */


?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 

function enviapag2(form){
					form.target="_blank";
					document.form.action='printCantInfoxColegio.php?rdb=<?php echo $rdb ?>&nomcolegio=<?php echo $nomcolegio ?>&opc=<?php echo $opc ?>&corporacion=<?php echo $corporacion ?>&nro_ano=<?php echo $nro_an ?>o';
					document.form.submit(true);
			}
</script>
<?php
   
   		/* $Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=printCantInfoxColegio_$Fecha.xls");  */
	 $ano		   = $_ANO;
	 
	 
	 
	 if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_CantInfoxColegio_$Fecha.xls"); 
	}
	else
	{
	$_ESTILO="../../../estilos/estilos.css";
		$_IMAGEN_IZQUIERDA="../../../cortes/fondo_01.jpg";
		$_IMAGEN_DERECHA="../../../cortes/fomdo_02.jpg";
		?>
		<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">	
		<?
	}	
	
	//busco año 	
		//año escolar 
		if (strlen($ano)>0)
		{
		$sql_ano="select * from ano_escolar where id_ano=$ano";
		$res_ano=@pg_exec($conn,$sql_ano)or die ('no conecto');
		$fil_ano=@pg_fetch_array($res_ano,0);
		$nro_ano=$fil_ano['nro_ano'];
		}
		else
		$nro_ano=$nro_ano;
		
		 $Fecha= date("m-d-$nro_ano");
		
		//rangos de notas primer periodo
		if ($Fecha>=date("03-02-$nro_ano") && $Fecha<=date("03-14-$nro_ano"))
		{
			 $rangonota=1;
			 $rangoasistencia=20;
			
		}
		if ($Fecha>=date("03-16-$nro_ano") && $Fecha<=date("03-28-$nro_ano"))
		{
			 $rangonota=2;
			 $rangoasistencia=40;
			
		}
		if ($Fecha>=date("03-30-$nro_ano") && $Fecha<=date("04-11-$nro_ano"))
		{
			 $rangonota=3;
			 $rangoasistencia=60;
			
		}
		if ($Fecha>=date("04-13-$nro_ano") && $Fecha<=date("04-25-$nro_ano"))
		{
			 $rangonota=4;
			 $rangoasistencia=80;
			
		}
		if ($Fecha>=date("04-27-$nro_ano") && $Fecha<=date("05-09-$nro_ano"))
		{
			 $rangonota=5;
			 $rangoasistencia=100;
			
		}
		if ($Fecha>=date("05-11-$nro_ano") && $Fecha<=date("05-23-$nro_ano"))
		{
			 $rangonota=6;
			 $rangoasistencia=120;
			
		}
		if ($Fecha>=date("05-25-$nro_ano") && $Fecha<=date("06-05-$nro_ano"))
		{
			 $rangonota=7;
			 $rangoasistencia=140;
			
		}
		
		if ($Fecha>=date("06-08-$nro_ano") && $Fecha<=date("06-19-$nro_ano"))
		{
			 $rangonota=8;
			 $rangoasistencia=160;
			
		}
		
		if ($Fecha>=date("06-22-$nro_ano") && $Fecha<=date("07-03-$nro_ano"))
		{
			 $rangonota=9;
			 $rangoasistencia=180;
			
		}
		
		if ($Fecha>=date("07-06-$nro_ano") && $Fecha<=date("07-17-$nro_ano"))
		{
			 $rangonota=10;
			 $rangoasistencia=200;
			
		}
		if ($Fecha>=date("07-20-$nro_ano") && $Fecha<=date("07-31-$nro_ano"))
		{
			 $rangonota=11;
			 $rangoasistencia=220;
			
		}
		
		///segundo semestre
		if ($Fecha>=date("08-03-$nro_ano") && $Fecha<=date("08-14-$nro_ano"))
		{
			 $rangonota=1;
			 $rangoasistencia=20;
			
		}
		if ($Fecha>=date("08-17-$nro_ano") && $Fecha<=date("08-28-$nro_ano"))
		{
			 $rangonota=2;
			 $rangoasistencia=40;
			
		}
		if ($Fecha>=date("08-31-$nro_ano") && $Fecha<=date("0-11-$nro_ano"))
		{
			 $rangonota=3;
			 $rangoasistencia=60;
			
		}
		if ($Fecha>=date("09-14-$nro_ano") && $Fecha<=date("09-25-$nro_ano"))
		{
			 $rangonota=4;
			 $rangoasistencia=80;
			
		}
		if ($Fecha>=date("09-28-$nro_ano") && $Fecha<=date("10-09-$nro_ano"))
		{
			 $rangonota=5;
			 $rangoasistencia=100;
			
		}
		if ($Fecha>=date("10-13-$nro_ano") && $Fecha<=date("10-23-$nro_ano"))
		{
			 $rangonota=6;
			 $rangoasistencia=120;
			
		}
		if ($Fecha>=date("10-26-$nro_ano") && $Fecha<=date("11-07-$nro_ano"))
		{
			 $rangonota=7;
			 $rangoasistencia=140;
			
		}
		
		if ($Fecha>=date("11-09-$nro_ano") && $Fecha<=date("11-20-$nro_ano"))
		{
			 $rangonota=8;
			 $rangoasistencia=160;
			
		}
		
		if ($Fecha>=date("11-23-$nro_ano") && $Fecha<=date("12-04-$nro_ano"))
		{
			 $rangonota=9;
			 $rangoasistencia=180;
			
		}
		
		if ($Fecha>=date("12-07-$nro_ano") && $Fecha<=date("12-18-$nro_ano"))
		{
			 $rangonota=10;
			 $rangoasistencia=200;
			
		}
		
		//buscar x colegio
		if($opc==1)
		{
			
			if((strlen($rdb)<1) and (strlen($nomcolegio)<1))
			{;}
			else
			{
			if(strlen($rdb)>0)
			$where="where rdb=$rdb";
			elseif(strlen($nomcolegio)>0)
			$where="where nombre_instit ilike '%$nomcolegio%'";
			
			 $sql1="select * from institucion ".$where." order by rdb";
			$res=pg_exec($conn,$sql1);
			
			}	
			
			
		}
		//select por coorporacion
		elseif($opc==2)
		{
			if($corporacion>0)
			{
			 $sql0="select * from corporacion where num_corp=$corporacion";
			$res0=pg_exec($conn,$sql0);
			$fila_corpo=@pg_fetch_array($res0,0);
			
			$nom_corp=$fila_corpo['nombre_corp'];
				$sql1="select * from institucion where rdb in (select rdb from corp_instit where num_corp=$corporacion) order by rdb";
				$res=pg_exec($conn,$sql1);
			}
			if($corporacion==0)
			{
				;
			}
			if($corporacion==-1)
			{
				$sql1="select * from institucion where rdb not in (select rdb from corp_instit) order by rdb";
				$res=pg_exec($conn,$sql1);
			
			}
		
		
			
			//busco colegios
			
			
			
		}
		
		
		
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cantidad de Informaci&oacute;n por Colegio</title>
<style type="text/css">
<!--
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>

<style type="text/css">
<!--
.Estilo10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo11 {font-size: 10px}
.Estilo12 {font-size: 12px}
-->
</style>
</head>

<body>
<form action="printCantInfoxColegio.php" method="get" name="form">
<div id="capa0">
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
	<table width="100%">
	  <tr>
	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
	<td align="right">
      <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	  </td>
	  <? if($_PERFIL == 0){?>
	<td align="right"><input  type="button" class="botonXX" onClick="enviapag2(this.form)"  name="cb_ok" value="EXPORTAR"></td>
	  <? }?>
	  </tr></table>    </td>
  </tr>
</table>
</div>

<table width="2000"  border="1" cellpadding="0" cellspacing="0">
  <tr class="tableindex">
 
    <td colspan="20">   <div align="center" >
      <input type="hidden" name="nro_ano" value="<?php echo $nro_ano ?>" />
      <input type="hidden" name="rdb" value="<?php echo $rdb ?>" />
      <input type="hidden" name="nomcolegio" value="<?php echo $nomcolegio ?>"/>
      <input type="hidden" name="opc" value="<?php echo $opc ?>"/>
      <input type="hidden" name="corporacion" value="<?php echo $corporacion ?>"/>
      Cantidad de Informaci&oacute;n por Colegio(s)
        <?php  if ($opc==2) {?>
        Corporación de <? echo $nom_corp ?> 
        <?php }?>
      A&ntilde;o <?php echo $nro_ano ?></div></td>
  </tr>
  <tr height="10" class="tableindex">
    
    <td colspan="6"><div align="center" >Datos Instituci&oacute;n </div></td>
    <td colspan="9"><div align="center"  >Cantidad de Informaci&oacute;n seg&uacute;n Estimaci&oacute;n </div></td>
    <td colspan="4"><div align="center"  >Configuraci&oacute;n Cursos </div></td>
    <td ><div align="center" >Soporte</div></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo12" ><strong>Instituci&oacute;n</strong></div></td>
   
    <td colspan="3" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo12" ><strong>Conexiones (a&ntilde;o) </strong></div></td>
    <td colspan="3" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo12" ><strong>Ingreso de Notas </strong></div></td>
    <td colspan="3" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo12" ><strong>Ingreso de Asistencia </strong></div></td>
    <td colspan="3" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo12" ><strong>Informe de Personalidad </strong></div></td>
    <td colspan="2" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo12" ><strong>Cursos con Profesor Jefe </strong></div></td>
    <td colspan="2" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo12" ><strong>Subsectores con Profesor Asignado </strong></div></td>
    <td width="222" rowspan="2" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo12" ><strong>&nbsp;Total Solicitudes </strong></div></td>
  </tr>
  <tr>
    <td width="30" bgcolor="#CCCCCC"><div align="center" class="Estilo10 Estilo9">N&ordm;</div></td>
    <td width="64" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">RDB</div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">Nombre</div></td>
    
    <td width="95" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Administrador Web </div>
    </div></td>
    <td width="86" bgcolor="#CCCCCC"><p align="center" class="Estilo9 Estilo11 Estilo9">Docente</p>    </td>
    <td width="81" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Total</div>
    </div></td>
    <td width="87" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Estimado</div>
    </div></td>
    <td width="89" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Ingresado</div>
    </div></td>
    <td width="82" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Total % </div>
    </div></td>
    <td width="87" bgcolor="#CCCCCC"><p align="center" class="Estilo9 Estilo11 Estilo9">Estimado</p>    </td>
    <td width="89" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Ingresado</div>
    </div></td>
    <td width="82" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Total % </div>
    </div></td>
    <td width="87" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Estimado</div>
    </div></td>
    <td width="89" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Ingresado</div>
    </div></td>
    <td width="82" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Total % </div>
    </div></td>
    <td width="87" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Cantidad</div>
    </div></td>
    <td width="82" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">DE</div>
    </div></td>
    <td width="100" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">Cantidad</div>
    </div></td>
    <td width="97" bgcolor="#CCCCCC"><div align="center" class="Estilo9 Estilo11 Estilo9">
      <div align="center">DE</div>
    </div></td>
    </tr>
	<?php if(($corporacion==0) and (strlen($rdb)<1) and (strlen($nomcolegio)<1))
	{?>
	<tr>
    <td colspan="20"><div align="center" class="Estilo9 Estilo11">No se registraron par&aacute;metros de b&uacute;squeda </div></td>
    </tr>
  <?php }
  else
  {
  ?>
  <? 
  for ($i=0;$i<pg_numrows($res);$i++)
  {
  		$fil_cole=@pg_fetch_array($res,$i);
		$nom_inst=$fil_cole['nombre_instit'];
		$rdb=$fil_cole['rdb'];
		$dig_rdb=$fil_cole['dig_rdb'];
		$num=pg_numrows($res);
		
		$ing=0;
		//ano por institucion
		$sql_ano2="select * from ano_escolar where id_institucion=$rdb and nro_ano=$nro_ano";
			$res_ano2=@pg_exec($conn,$sql_ano2);
			
			for ($b=0;$b<pg_numrows($res_ano2);$b++)
			{
			$fil_ano2=@pg_fetch_array($res_ano2,$b);
 			$nro_ano2=$fil_ano2['nro_ano'];
			
			$id_ano=$fil_ano2['id_ano'];
			
			
			//saco todos los alumnos que hay en el colegio
			 $sql_alus="select count(*) as notas from tiene$nro_ano2 where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = $id_ano))";
			 $res_alus=@pg_exec($conn,$sql_alus);
			
			for ($h=0;$h<pg_numrows($res_alus);$h++)
			{
			 $fil_alus=@pg_fetch_array($res_alus,$h);
			 $alus=$fil_alus['notas']; 
				
			}
			
			
			
  
  $sql_per="select id_periodo,fecha_inicio,fecha_termino from periodo where id_ano=$id_ano and nombre_periodo ilike '%primer%' ";
		$res_per=@pg_exec($conn,$sql_per);
			for ($k=0;$k<pg_numrows($res_per);$k++)
			{
				$fil_per=@pg_fetch_array($res_per,$k);
				$per=$fil_per['id_periodo']; 
				$fini=$fil_per['fecha_inicio']; 
				$fter=$fil_per['fecha_termino']; 
			
			
			
			//calculo notas puestas por turno
			
			//asistencia ingresada
	  $sql_asis="select count (*) as asist from asistencia where ano=$id_ano and fecha >='$fini' and fecha<='$fter' ";
	$res_asi=@pg_exec($conn,$sql_asis);
		if (pg_numrows($res_asi)==0 or (!$res_asi))
		$asis=0;
		else
		{
		
			for ($l=0;$l<pg_numrows($res_asi);$l++)
			{
			$fil_asis=@pg_fetch_array($res_asi,$l);
			$asis=$fil_asis['asist'];
			}
		
		}
	
	//notas ingresadas
	for ($q=1;$q<=$rangonota;$q++)
	{
		 $sql_ing="select count(*) as not_ing from notas$nro_ano where  nota$q <> '0 ' and nota$q <> '' and id_periodo = $per and id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = $id_ano)) group by id_periodo order by id_periodo";
	
		$res_ing=@pg_exec($conn,$sql_ing);
		$fil_ing=@pg_fetch_array($res_ing,0);
		$not_ing=$fil_ing['not_ing'];
		$ing=$ing+$not_ing;
			
			
		
	}
	
	//select informes
	$sql_inf="select distinct (rut_alumno) from informe_evaluacion2 where id_periodo=$per";
	$res_inf=@pg_exec($conn,$sql_inf);
	if (pg_numrows($res_inf)==0 or !$res_inf)
	$enc=0;
	else
	 $enc=pg_numrows($res_inf);
	
	
			
	}
	
	
	?>
  
  <tr>
    <td width="30">      <span class="Estilo9 Estilo11">
      <?php 
	 $sql_ano3="select count (*)as ano3 from ano_escolar where id_institucion=$rdb and nro_ano=$nro_ano";
			$res_ano3=@pg_exec($conn,$sql_ano3)or die("Fallo ".$sql_ano3);
			for ($s=0;$s<pg_numrows($res_ano3);$s++)
			{
				$fil_a3=@pg_fetch_array($res_ano3,$s);
				$ano3=$fil_a3['ano3'];
				echo $a3=$a3+$ano3;
			} 
	 ?>
    </span> </td>
    <td width="64"><span class="Estilo9 Estilo11"><?php echo $rdb." - ".$dig_rdb ?></span></td>
   
    <td width="240"><div align="left" class="Estilo9 Estilo11"><?php echo $nom_inst ?></div></td>
    <td><div align="center" class="Estilo9 Estilo11">
	  <?php 
	//conexiones admweb
	$sql_conex="select sum(cant_conex) as conexiones_adm from estadistica where rdb=$rdb and perfil=14 and fecha>='$nro_ano-1-1' and fecha<='$nro_ano-12-31'";
	$res_conex=@pg_exec($conn,$sql_conex);
	for ($c=0;$c<pg_numrows($res_conex);$c++)
			{
			$fil_conex=@pg_fetch_array($res_conex,$c);
			echo $conex_adm=$fil_conex['conexiones_adm'];
				if ($conex_adm==0)
				echo "0";
			}
	
	?>
	</div></td>
    <td><div align="center" class="Estilo9 Estilo11">
	  <?php 
	//conexiones docente
	$sql_conex="select sum(cant_conex) as conexiones_doc from estadistica where rdb=$rdb and perfil=17 and fecha>='$nro_ano-1-1' and fecha<='$nro_ano-12-31'";
	$res_conex=@pg_exec($conn,$sql_conex);
	for ($c=0;$c<pg_numrows($res_conex);$c++)
			{
			$fil_conex=@pg_fetch_array($res_conex,$c);
			echo $conex_doc=$fil_conex['conexiones_doc'];
			if ($conex_doc==0)
				echo "0";
			}
	
	?>
	 
	</div></td>
    <td><div align="center" class="Estilo9 Estilo11"><?php echo $conex_adm+$conex_doc ?></div></td>
   
	
	<td><div align="center" class="Estilo9 Estilo11">
	  <?php 
	
	//calculo notas estimadas
 $sql_est="select count(*)as esti from tiene$nro_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = $id_ano))";
	$res_est=@pg_exec($conn,$sql_est);
	for ($p=0;$p<pg_numrows($res_est);$p++)
	{
		$fil_est=@pg_fetch_array($res_est,$p);
		  $esti=$fil_est['esti'];
	 echo $estimados=$esti*$rangonota;
	}
	
	?>
	</div></td>
    <td><div align="center" class="Estilo9 Estilo11"><?php echo $ing ?></div></td>
    <td><div align="center" class="Estilo9 Estilo11">
      <?php 
	$tot_notas=($ing*100)/$estimados;
	echo number_format($tot_notas, 2, ',', '');

	
	?>
    </div></td>
    <td><div align="center" class="Estilo9 Estilo11">
	  <?
		
		//matricula
		$sql_cur="select count(rut_alumno) as alu from matricula where id_ano=$id_ano and bool_ar<>1";
		$res_cur=@pg_exec($conn,$sql_cur);
		for($j=0;$j<pg_numrows($res_cur);$j++)
			{
				$fil_cur=@pg_fetch_array($res_cur,$j);
				echo $cur=$fil_cur['alu']*$rangoasistencia;
				
				
			}
			//asitencia
			
	
	
	?>
	
	</div></td>
    <td><div align="center" class="Estilo9 Estilo11"><?php echo $asis?></div></td>
    <td><div align="center" class="Estilo9 Estilo11">
	  <?php 
	$tot_asis=($asis*100)/$cur;
	echo number_format($tot_asis, 2, ',', '');

	
	?>
	
	</div></td>
    <td><div align="center" class="Estilo9 Estilo11">
	  <?
		//matricula
		$sql_cur="select count(rut_alumno) as alu from matricula where id_ano=$id_ano and bool_ar<>1";
		$res_cur=@pg_exec($conn,$sql_cur);
		for($j=0;$j<pg_numrows($res_cur);$j++)
			{
				$fil_cur=@pg_fetch_array($res_cur,$j);
				echo $cur=$fil_cur['alu'];
	
			}
	
	
	?>
	</div></td>
    <td><div align="center" class="Estilo9 Estilo11">
	 
	  <?php //que haya por lo menos un informe ingresado por alumno
	 echo $enc ?>
	
	</div></td>
    <td><div align="center" class="Estilo9 Estilo11">
      <?php 
	$tot_inf=($enc*100)/$cur;
	echo number_format($tot_inf, 2, ',', '');

	
	?>
    </div></td>
    <td><div align="center" class="Estilo9 Estilo11">
	  <?
	//cursos
	 $sql_cur="select count(id_curso) as curso from curso where id_ano=$id_ano";
	$res_cur=@pg_exec($conn,$sql_cur);
	for($e=0;$e<pg_numrows($res_cur);$e++)
	{
		$fil_cur=@pg_fetch_array($res_cur,$e);
		echo $cur=$fil_cur['curso'];
	
	}
	
	?>
	
	
	</div></td>
    <td><div align="center" class="Estilo9 Estilo11">
	  <?
	//cursos con profesor
	$sql_sup="SELECT count(supervisa.id_curso) AS supervisa FROM supervisa INNER JOIN curso ON (supervisa.id_curso = curso.id_curso) WHERE (curso.id_ano = $id_ano) AND (public.supervisa.rut_emp > 0)";
	$res_sup=@pg_exec($conn,$sql_sup);
	for ($g=0;$g<pg_numrows($res_sup);$g++)
	{
		$fil_sup=@pg_fetch_array($res_sup,$g);
		echo $ram=$fil_sup['supervisa'];
	}
	
	?>
	
	</div></td>
    <td><div align="center" class="Estilo9 Estilo11">
      <?
	
	//subsectores
 $sql_ram="select count(id_ramo) as ramo from ramo where id_curso in(select id_curso from curso where id_ano=$id_ano )";
	$res_ram=@pg_exec($conn,$sql_ram);
	for ($f=0;$f<pg_numrows($res_ram);$f++)
	{
		$fil_sol=@pg_fetch_array($res_ram,$f);
		echo $ram=$fil_sol['ramo'];
	}
	
	
	
	?>
    </div></td>
    <td><div align="center" class="Estilo9 Estilo11">
	  <?
	//ramos con profesor
	$sql_dic="SELECT count(dicta.id_ramo) AS id_ramo FROM dicta INNER JOIN ramo ON (dicta.id_ramo = ramo.id_ramo) INNER JOIN public.curso ON (ramo.id_curso = curso.id_curso) WHERE (curso.id_ano = $id_ano and dicta.rut_emp>0)";
	$res_dic=@pg_exec($conn,$sql_dic);
	for ($g=0;$g<pg_numrows($res_dic);$g++)
	{
		$fil_dic=@pg_fetch_array($res_dic,$g);
		echo $ram=$fil_dic['id_ramo'];
	}
	?>
	</div></td>
	<td><div align="center" class="Estilo9 Estilo11">
	  <?php 
	
	 $sql="select count (*) as conteo from solicitud_ot2 where rdb=$rdb and fecha_sol>='$nro_ano-1-1' and fecha_sol<='$nro_ano-12-31'";
	$res_sol=@pg_exec($conn,$sql);
	for ($d=0;$d<pg_numrows($res_sol);$d++)
	{
		$fil_sol=@pg_fetch_array($res_sol,$d);
		echo $soli=$fil_sol['conteo'];
	}
	?>
	
	</div></td>
  </tr>
  <?php }}}?>
</table>
</form>
</body>
</html>
