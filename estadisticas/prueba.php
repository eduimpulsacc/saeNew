<? 
$archivo=$_GET['ar'];
	include_once "ofc/php-ofc-library/open_flash_chart_object.php";
 open_flash_chart_object( 500, 500, "http://intranet.colegiointeractivo.cl/sae3.0/estadisticas/".$archivo,false, "ofc/" );
 echo "<br><input type='button' name='imprimir' value='Imprimir' onclick='window.print();'>";?>