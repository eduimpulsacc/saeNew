<? 
session_start();
$ano =$_ANO;

var_dump($_INSTIT);
require "../../class/Membrete.class.php";	
$ob_membrete = new Membrete($_IPDB,$_ID_BASE);

$nro_ano = $ob_membrete->nro_ano($ano);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script language="javascript" type="text/javascript">


	carga();


function Modifica_Anio(ano,estado){
	var parametros="funcion=2&ano="+ano+"&estado="+estado;
	//alert(parametros);
	$.ajax({
		url:'mod/ano/cont_ano.php',
		data:parametros,
		type:'POST',
			success: function(data){
				//alert(data)
				console.log(data);
				//if(data==1){
				//	carga();	
				//}
				
				location.reload();
			}
	})
}

function carga(){
	
	var parametros="funcion=1";
	
	$.ajax({
		url:'mod/ano/cont_ano.php',
		data:parametros,
		type:'POST',
		 success: function(data){
			
			if(data!=0){
				$("#tabla").html(data);
			}
		 }
	})
}

function traeAno(){
	var parametros="funcion=3";
	//alert(parametros);
	$.ajax({
		url:'mod/ano/cont_ano.php',
		data:parametros,
		type:'POST',
			success: function(data){
				//alert(data)
				console.log(data);
				//if(data==1){
					carga();	
				//}
			}
	})
}

</script>
</head>

<body>

<div id="tabla">&nbsp;


</div>
</body>
</html>
