<? include"../../../Coneccion/conexion.php"?>
<?

	$li_id_colegio    = Trim($_POST["hf_id_colegio"]);
	$li_id_cuenta     = Trim($_POST["hf_id_cuenta"]);
	$li_id_categoria  = Trim($_POST["hf_id_categoria"]);
	$li_total		  = Trim($_POST["hf_total"]);

	$sql = "delete From con_categoria_cuenta_periodo where rdb = $li_id_colegio and id_categoria = $li_id_categoria and id_cuenta = $li_id_cuenta ;";
	$resultado_query = pg_exec($conexion,$sql);

	

	For ($j=0; $j<$li_total; $j++)
	{

		if(Trim($_POST["cbx_mes_".$j] != ''))
		{
					
		$li_mes  = $_POST["cbx_mes_".$j];
			
				
		$sql_insert = "INSERT INTO con_categoria_cuenta_periodo VALUES ($li_id_colegio, $li_id_categoria, $li_id_cuenta, $li_mes); ";
		//echo("<BR> SQL INSERT : $sql_insert <BR>");
		$res_insert = pg_exec($conexion,$sql_insert);
		}
	
	}

?>
		<Script>
		window.location.href="fechas.php?ai_colegio=<?=($li_id_colegio)?>&ai_cuenta=<?=($li_id_cuenta)?>&ai_categoria=<?=($li_id_categoria)?>";
		</Script>		
