<? include_once '../lib/nusoap.php';
session_start();


$servicio = new soap_server();

$ns = "urn:miserviciowsdl";
$servicio->configureWSDL("valSemilla",$ns);

$servicio->schemaTargetNamespace = $ns;

$servicio->register("ValSemilla", array('rdb' => 'xsd:integer','url' => 'xsd:string','secret' => 'xsd:string'), array('return' => 'xsd:string'), $ns );


function ValSemilla($rdb,$url,$secret){
	$conn=pg_connect("dbname=coi_usuario host=190.196.143.171 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");
	
	$sql_ins="select * from institucion where rdb=$rdb and secret='$secret'";
	@$rs_ins = pg_exec($conn,$sql_ins);
	@$fil_ins = pg_fetch_array($rs_ins,0);

if(pg_numrows($rs_ins)>0){

	$semilla =  md5(rand(5, 15));
	//global $_SEMILLA;
	//$_SEMILLA=$semilla;
	$_SESSION['_SEMILLA']=$semilla;

	
	$re = $_SESSION['_SEMILLA'];//$semilla;
}else{
	$re=0;
}

return $re;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$servicio->service($HTTP_RAW_POST_DATA);
?>