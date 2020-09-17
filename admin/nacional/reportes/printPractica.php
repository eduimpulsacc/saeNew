<?

include("../controlador/controlador_1.php");


$corporacion	= $_NACIONAL;
$ano			= $cmbANO;
$estados		= $cmb_estados;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte Sostenedor Corporativo</title>
<link href="../estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	  
		  
</script>
<link href="../../../../../admin/corporacion/estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {font-weight: bold; background-color: #CCCCCC; text-align: center;}
.Estilo3 {font-family:Verdana, Arial, Helvetica, sans-serif; text-align:center; font-weight: bold; background-color: #CCCCCC;}
-->
</style>
</head>
<body>
<div id="capa0">
  <table width="650" border="0" align="center">
    <tr>
      <td><input type="button" name="Submit" value="VOLVER" onClick="javascript:history.back(1) " class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div></td>
	  
    </tr>
  </table>
</div>
<br />
<table width="750" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../images/linea2.jpg" width="730" height="4" /></td>
        </tr>
        <tr>
          <td rowspan="5"> <?  echo "<img src='../images/".$corporacion."_logo.jpg' >"; ?></td>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$nombre;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$direc;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$fono;?></div></td>
        </tr>
        <tr>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><img src="../images/linea.jpg" width="730" height="4" /></td>
        </tr>
      </table>
      <br />
      <br />
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">INFORME GENERAL PRACTICA PROFESIONAL  POR INSTITUCI&Oacute;N <br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
    <table width="98%" border="1" align="center" cellpadding="3" cellspacing="0" class="tabla2">
      <tr>
        <td class="celdas1">RDB</td>
        <td class="celdas1">ESTABLECIMIENTO</td>
		<? if($cmb_estados==100){?>
        <td class="celdas1">PRACTICA<br />
          REPROBADA</td>
		<td class="celdas1">EN <br />
		  PRACTICA</td>
        <td class="celdas1">EN PROCESO<br />
          DE TITULACI&Oacute;N </td>
        <td class="celdas1">TITULADO</td>
        <td class="celdas1">VARIOS<br />
          (ESTUDIOS<br />
          UNIVERSITARIOS)</td>
        <td class="celdas1"><p>PRACTICA<br />
        APROBADA</p>          </td>
        <td class="celdas1">VARIOS<br />
          (DESCICI&Oacute;N<br />
          PERSONAL)</td>
		 <? }else{
		 		if($cmb_estados==1){?>
				        <td class="celdas1">PRACTICA<br />
          REPROBADA</td>				
		<? }
			
				if($cmb_estados==2){?>
		<td class="celdas1">EN <br />
		  PRACTICA</td>				
		<? }
		
				if($cmb_estados==4){?>
		<td class="celdas1">EN PROCESO<br />
          DE TITULACI&Oacute;N </td>
			
		<? }
		
				if($cmb_estados==5){?>
			<td class="celdas1">TITULADO</td>	
		<? }
				if($cmb_estados==6){?>
			<td class="celdas1">VARIOS<br />
          (ESTUDIOS<br />
          UNIVERSITARIOS)</td>	
				
		<? }
				if($cmb_estados==3){?>
			<td class="celdas1"><p>PRACTICA<br />
        APROBADA</p>          </td>	
		<? }
				if($cmb_estados==7){?>
			
			<td class="celdas1">VARIOS<br />
          (DESCICI&Oacute;N<br />
          PERSONAL)</td>
		<? }?> 
		 
		 
		 
		 
		 <? }?>
      </tr>
      
	  <?
	  $tot_instit=0;
	  $tot_1 = 0;
	  
	  
	  $arr_rdb1= array();
	  $arr_mat_mes1= array();
	  
	 
	  
	  
	  
	   foreach ($instituciones as $institucion): 
	       
		   $arr_mes    = array();
		   $arr_cant   = array();
	      
		   ?>
		  <tr>
		    <td class="text2"><?=$institucion['rdb']?>&nbsp;</td>
			<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><?=$institucion['nombre_instit']?></font></td>
			<?
			$id_ano = ano_escolar_por_institucion($institucion['rdb'],$ano,$conn);
	
			// consulta cuando se selecciona solo un estado en el buscador.
			$sql="select DISTINCT count(a.*) from practicas a inner join matricula b on (a.rut_alu=b.rut_alumno) ";
			$sql.="where a.estado=".$cmb_estados." and b.rdb=".$institucion['rdb']." and a.id_ano=".$id_ano;
			$resp=pg_exec($conn,$sql);		
			$result = pg_result($resp,0);											
			
			
			
			// seleccionan de todos los estados //
			if($cmb_estados==100){
			
				$sql_1="select DISTINCT count(a.*) from practicas a inner join matricula b on (a.rut_alu=b.rut_alumno) ";
				$sql_1.="where a.estado=1 and b.rdb=".$institucion['rdb']." and a.id_ano=".$id_ano;
				$resp_1=pg_exec($conn,$sql_1);		
				$result_1 = pg_result($resp_1,0);
			?>
			<td align="right" class="text2"><div align="center"><?=$result_1;?></div></td>
			<?
				$sql_2="select DISTINCT count(a.*) from practicas a inner join matricula b on (a.rut_alu=b.rut_alumno) ";
				$sql_2.="where a.estado=2 and b.rdb=".$institucion['rdb']." and a.id_ano=".$id_ano;
				$resp_2=pg_exec($conn,$sql_2);		
				$result_2 = pg_result($resp_2,0);
			?>
			<td align="right" class="text2"><div align="center"><?=$result_2;?></div></td>
			<?
				$sql_3="select DISTINCT count(a.*) from practicas a inner join matricula b on (a.rut_alu=b.rut_alumno) ";
				$sql_3.="where a.estado=4 and b.rdb=".$institucion['rdb']." and a.id_ano=".$id_ano;
				$resp_3=pg_exec($conn,$sql_3);		
				$result_3 = pg_result($resp_3,0);
			?>
			<td align="right" class="text2"><div align="center"><?=$result_3;?></div></td>
			<? 
				$sql_4="select DISTINCT count(a.*) from practicas a inner join matricula b on (a.rut_alu=b.rut_alumno) ";
				$sql_4.="where a.estado=5 and b.rdb=".$institucion['rdb']." and a.id_ano=".$id_ano;
				$resp_4=pg_exec($conn,$sql_4);		
				$result_4 = pg_result($resp_4,0);
			?>
			<td align="right" class="text2"><div align="center"><?=$result_4?></div></td>
			<? 
				$sql_5="select DISTINCT count(a.*) from practicas a inner join matricula b on (a.rut_alu=b.rut_alumno) ";
				$sql_5.="where a.estado=6 and b.rdb=".$institucion['rdb']." and a.id_ano=".$id_ano;
				$resp_5=pg_exec($conn,$sql_5);		
				$result_5 = pg_result($resp_5,0);
			?>
			<td align="right" class="text2"><div align="center"><?=$result_5;?></div></td>
			<? 
				$sql_6="select DISTINCT count(a.*) from practicas a inner join matricula b on (a.rut_alu=b.rut_alumno) ";
				$sql_6.="where a.estado=3 and b.rdb=".$institucion['rdb']." and a.id_ano=".$id_ano;
				$resp_6=pg_exec($conn,$sql_6);		
				$result_6 = pg_result($resp_6,0);
			?>
			<td align="right" class="text2"><div align="center"><?=$result_6;?></div></td>
			<? 
				$sql_7="select DISTINCT count(a.*) from practicas a inner join matricula b on (a.rut_alu=b.rut_alumno) ";
				$sql_7.="where a.estado=7 and b.rdb=".$institucion['rdb']." and a.id_ano=".$id_ano;
				$resp_7=pg_exec($conn,$sql_7);		
				$result_7 = pg_result($resp_7,0);
			?>
			<td align="right" class="text2"><div align="center"><?=$result_7;?></div></td>
			<? }else{
					if($cmb_estados==1){?>
				<td align="right" class="text2"><div align="center">
				  <?=$result;?>
			    </div></td>	
			<? }
					if($cmb_estados==2){?>
				<td align="right" class="text2"><div align="center">
				  <?=$result;?>
			    </div></td>
			<? }
					if($cmb_estados==4){?>
				<td align="right" class="text2"><div align="center">
				  <?=$result;?>
			    </div></td>	
			<? }
					if($cmb_estados==5){?>
				<td align="right" class="text2"><div align="center">
				  <?=$result;?>
			    </div></td>
			<? }
					if($cmb_estados==6){?>
				<td align="right" class="text2"><div align="center">
				  <?=$result;?>
			    </div></td>
			<? }
					if($cmb_estados==3){?>
				<td align="right" class="text2"><div align="center">
				  <?=$result;?>
			    </div></td>
			<? }
					if($cmb_estados==7){?>
				<td align="right" class="text2"><div align="center">
				  <?=$result;?>
			    </div></td>	
			<? }
			
			}
			
			// total de cuando se selecciona solo un estado en el buscador.
			$total_cada_estado = $total_cada_estado + $result;
			//------------------------------------------------------------//
			
			
			// total de todos los estados seleccionados
			$total_1 = $total_1 + $result_1;
			$total_2 = $total_2 + $result_2;
			$total_3 = $total_3 + $result_3;
			$total_4 = $total_4 + $result_4;
			$total_5 = $total_5 + $result_5;
			$total_6 = $total_6 + $result_6;
			$total_7 = $total_7 + $result_7;
			//------------------------------------------//
			
			$arr1=serialize($arr_rdb1);
			$arr1=urlencode($arr1);
			
			
			$mat1=serialize($arr_mat_mes1);
			$mat1=urlencode($mat1);
			
			
			?>
	      </tr>
		  <?
		  $tot_instit=0;
		  ?>
		  
	<? endforeach ?>	  
      
	  <tr>
	    <td colspan="2" class="celdas2">TOTALES</td>
        <? if($cmb_estados==100){
			?>
			<td align="right" class="celdas1"><div align="center"><?=$total_1;?></div></td>
			<td align="right" class="celdas1"><div align="center"><?=$total_2;?></div></td>
			<td align="right" class="celdas1"><div align="center"><?=$total_3;?></div></td>
			<td align="right" class="celdas1"><div align="center"><?=$total_4;?></div></td>
			<td align="right" class="celdas1"><div align="center"><?=$total_5;?></div></td>
			<td align="right" class="celdas1"><div align="center"><?=$total_6;?></div></td>
			<td align="right" class="celdas1"><div align="center"><?=$total_7;?></div></td>
			<? }else{
					if($cmb_estados==1){?>
				<td align="right" class="celdas1"><div align="center">
				  <?=$total_cada_estado;?>
			    </div></td>	
			<? }
					if($cmb_estados==2){?>
				<td align="right" class="celdas1"><div align="center">
				  <?=$total_cada_estado;?>
			    </div></td>
			<? }
					if($cmb_estados==4){?>
				<td align="right" class="celdas1"><div align="center">
				  <?=$total_cada_estado;?>
			    </div></td>	
			<? }
					if($cmb_estados==5){?>
				<td align="right" class="celdas1"><div align="center">
				  <?=$total_cada_estado;?>
			    </div></td>
			<? }
					if($cmb_estados==6){?>
				<td align="right" class="celdas1"><div align="center">
				  <?=$total_cada_estado;?>
			    </div></td>
			<? }
					if($cmb_estados==3){?>
				<td align="right" class="celdas1"><div align="center">
				  <?=$total_cada_estado;?>
			    </div></td>
			<? }
					if($cmb_estados==7){?>
				<td align="right" class="celdas1"><div align="center">
				  <?=$total_cada_estado;?>
			    </div></td>	
			<? }
			
			}?>
	  </tr>
    </table>
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td valign="baseline"><HR />
        <? $fecha=date("d-m-Y");
		$sql="SELECT comuna FROM nacional n INNER JOIN macional_corp nc ON n.id_nacional=nc.id_nacional WHERE num_corp=".$_CORPORACION;
		$rs_nacional = pg_exec($connection,$sql);
		$comuna=pg_result($rs_nacional,0);?>
       <?php switch($_CORPORACION){
			case 6:
				$nom_com="Pe&ntilde;alol&eacute;n,";
			break;
			case 1:
				$nom_com="Santiago,";
			break;
			case 2:
				$nom_com="Vi&ntilde;a del Mar,";
			break;
		}?>
       <div align="right" class="fecha"><?php echo $nom_com ?> <? echo fecha_espanol($fecha);?></div></td>
  </tr>
</table>
</body>
</html>