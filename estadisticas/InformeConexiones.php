<? 	require('../util/header.inc');
	
	/*$conn2=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");*/
	$conn2=$connection;

	function CambioFecha($fecha){
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$m."-".$d."-".$a;
	else
		$retorno="";
	return $retorno;
}
	
	

	if($rd_periodo==1){
		$year = date("Y");
		//$sql ="SELECT ip,sum(contador) as contador FROM contador_visita WHERE date_part('month',fecha)=".$cmbMES." AND date_part('year',fecha)=".$year." GROUP BY ip";
		
		$sql="select  p.nombre_perfil, count(*) cuenta from control_users cu 
inner join perfil p ON p.id_perfil=cu.id_perfil
where cu.rdb_users=".$_INSTIT." and cu.fecha date_part('year',fecha)=".$year."
group by 1";
		
	}elseif($rd_periodo==2){
		$fecha = CambioFecha($txtFECHA);
		$sql ="SELECT ip, contador FROM contador_visita WHERE fecha='".$fecha."' ";
	}elseif($rd_periodo==3){
		$desde = CambioFecha($txtDESDE);
		$hasta = CambioFecha($txtHASTA);
		$sql ="SELECT ip, contador FROM contador_visita WHERE fecha BETWEEN '".$desde."' AND '".$hasta."'";
	}	
	
	$rs_conexion = @pg_exec($conn2,$sql) or die ("SELECT FALLO: ".$sql);

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table width="650" border="0" align="center">
  <tr>
    <td colspan="4"  class="tableindex">LISTADO DE CONEXIONES </td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="textosimple">
		<? if($rd_periodo==2){
				echo "<B>FECHA : ".$txtFECHA."</B>";
			}else if($rd_periodo==1){
				echo "<B>MES : ".envia_mes($cmbMES)."</B>";
			}else if($rd_periodo==3){
				echo "<B>FECHA  DESDE : ".$txtDESDE." -- HASTA : ".$txtHASTA."</B>";
			}
		?>	</td>
  </tr>
  <tr>
    <td colspan="4" class="textosimple">
	<? 
		if($rd_periodo==2){
			$sql = "SELECT count(*)	FROM contador_visita WHERE fecha='".$fecha."' ";
			$rs_cantidad = @pg_exec($conn2,$sql);
			$cantidad = @pg_result($rs_cantidad,0);
			echo "<B>CANTIDAD DE CONEXIONES : ".$cantidad."</B>";
		}else if($rd_periodo==1){
			$year = date("Y");
			$sql = "SELECT count(*) FROM contador_visita WHERE date_part('month',fecha)=".$cmbMES." AND date_part('year',fecha)=".$year."";
			$rs_cantidad = @pg_exec($conn2,$sql);
			$cantidad = @pg_result($rs_cantidad,0);
			echo "<B>CANTIDAD DE CONEXIONES : ".$cantidad."</B>";
		}else if($rd_periodo==3){
			$desde = CambioFecha($txtDESDE);
			$hasta = CambioFecha($txtHASTA);
			$sql ="SELECT count(*) FROM contador_visita WHERE fecha BETWEEN '".$desde."' AND '".$hasta."'";
			$rs_cantidad = @pg_exec($conn2,$sql);
			$cantidad = @pg_result($rs_cantidad,0);
			echo "<B>CANTIDAD DE CONEXIONES : ".$cantidad."</B>";
		}
	?>
	</td>
  </tr>
  <tr>
    <td colspan="4" class="textosimple">
		<? 
		if($rd_periodo==2){
			$sql = "SELECT sum(contador) FROM contador_visita WHERE fecha='".$fecha."' ";
			$rs_cantidad = @pg_exec($conn2,$sql);
			$TOTAL = @pg_result($rs_cantidad,0);
			echo "<B>TOTAL DE CONEXIONES : ".$TOTAL."</B>";
		}else if($rd_periodo==1){
			$year = date("Y");
			$sql = "SELECT sum(contador) FROM contador_visita WHERE date_part('month',fecha)=".$cmbMES." AND date_part('year',fecha)=".$year."";
			$rs_cantidad = @pg_exec($conn2,$sql);
			$TOTAL = @pg_result($rs_cantidad,0);
			echo "<B>TOTAL DE CONEXIONES : ".$TOTAL."</B>";
		}else if($rd_periodo==3){
			$desde = CambioFecha($txtDESDE);
			$hasta = CambioFecha($txtHASTA);
			$sql ="SELECT sum(contador) FROM contador_visita WHERE fecha BETWEEN '".$desde."' AND '".$hasta."'";
			$rs_cantidad = @pg_exec($conn2,$sql);
			$TOTAL = @pg_result($rs_cantidad,0);
			echo "<B>TOTAL DE CONEXIONES : ".$TOTAL."</B>";
		}
	?>
	</td>
  </tr>
  <tr>
    <td width="95">&nbsp;</td>
    <td width="180" class="tableindex">IP</td>
    <td width="175" class="tableindex"><p>CANTIDAD</p>    </td>
    <td width="176">&nbsp;</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_conexion);$i++){
  		$fila = @pg_fetch_array($rs_conexion,$i);
  ?>  	
  <tr>
    <td>&nbsp;</td>
    <td class="textosimple"><?=$fila['ip'];?></td>
    <td class="textosimple"><?=$fila['contador'];?></td>
    <td>&nbsp;</td>
  </tr>
  <? } ?>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</body>
</html>
