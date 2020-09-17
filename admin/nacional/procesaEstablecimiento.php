<?
	require('../../util/header.inc');
	
	if(trim($_FRMMODO)=='mostrar')
	{
		$_FRMMODO=modificar;?>
		<script language="javascript">window.location="establecimientos.php"</script>	
	<?	exit();
	}
	
	if(trim($_FRMMODO)=='modificar')
	{
		$qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
		$result_ins=pg_Exec($conn,$qry_ins);
	
		for($i=0;$i<pg_numrows($result_ins);$i++)
		{
			$fila_ins = pg_fetch_array($result_ins,$i);
				
			$estado = $fila_ins['rdb'];
	
			if($_POST[$estado]=="on")
			{
				$sql =	"update corp_instit set estado = true where rdb = '$estado'";
				$res = pg_Exec($conn,$sql);		
			}else{
				$sql =	"update corp_instit set estado = false where rdb = '$estado'";
				$res = pg_Exec($conn,$sql);			
			}
		}
		$_FRMMODO=mostrar;
	}		
	
?>
<script language="javascript">window.location="establecimientos.php"</script>