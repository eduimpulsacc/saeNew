<?
require_once('php-local-browscap.php');
$navegador=get_browser_local(); 

echo "<pre>";
print_r($navegador);
echo "</pre>";

/*while (list($key, $val) = each($navegador)) {
    echo "<br>$key => $val\n";
   } */

	$conectores = array();
	$conectores[] = array("coi_final","192.168.1.10","5432","postgres","f4g5h6.j");
	$conectores[] = array("coi_corporaciones","192.168.1.12","5432","postgres","f4g5h6.j");
	$conectores[] = array("coi_final_vina","192.168.1.12","5432","postgres","f4g5h6.j");
	$conectores[] = array("coi_antofagasta","192.168.1.11","5432","postgres","f4g5h6.j");
	
	echo "<pre>";
	print_r($conectores);
	echo "</pre>";

	?>
	