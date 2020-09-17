<? 
session_start();
$ano =$_ANO;

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


function Modifica_Periodo(periodo,estado){
	
	var parametros="funcion=modifica&periodo="+periodo+"&estado="+estado;
	//alert(parametros);
	$.ajax({
		url:'mod/periodo/cont_periodo.php',
		data:parametros,
		type:'POST',
			success: function(data){
				//console.log(data)
				if(data==1){
					//carga();	
					location.reload();
				}
			}
	})
}

function carga(){
	
	var parametros="funcion=inicio";
	
	$.ajax({
		url:'mod/periodo/cont_periodo.php',
		data:parametros,
		type:'POST',
		 success: function(data){
			if(data!=0){
				$("#tabla").html(data);
			}
		 }
	})
}

function cambiaPer(iano){
	var parametros="funcion=cambia&iano="+iano;
	
	$.ajax({
		url:'mod/periodo/cont_periodo.php',
		data:parametros,
		type:'POST',
		 success: function(data){
			
			if(data!=0){
				$("#tabla").html(data);
			}
		 }
	})
}
</script>
</head>

<body>
<table width="90%" border="0" align="center">
  <tr>
    <td width="16%" class="textonegrita"><strong><? echo htmlentities( "AÑO ESCOLAR",ENT_QUOTES,'UTF-8');?></strong></td>
    <td width="1%"><strong>:</strong></td>
    <td width="83%" class="textosimple">&nbsp;<?=$nro_ano;?></td>
  </tr>
</table>
<br />
<div id="tabla">&nbsp;


</div>
</body>
</html>
