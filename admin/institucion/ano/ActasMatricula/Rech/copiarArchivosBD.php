<?
	require('../../../../../util/header.inc');


/*echo	$qry= "copy archivo_01 from '/opt/www/coeint/admin/institucion/ano/ActasMatricula/Rech/Archivos/a25131_1.txt' USING DELIMITERS '\t'";
	$result= pg_exec($conn,$qry);

echo "<br>";
echo	$qry2= "copy archivo_05 from '/opt/www/coeint/admin/institucion/ano/ActasMatricula/Rech/Archivos/a25131_5.txt' USING DELIMITERS '\t'";
	$result2= pg_exec($conn,$qry2);
*/

	$fd = fopen ("Archivos/prueba7_1.txt", "r");
	while (!feof($fd)) {
		$buffer = fgets($fd,4096);
		echo "<br>bufer=".$buffer;

		$p = explode("\t", $buffer);
		echo "<br>trozo0 = ".$p[0];
		echo "<br>trozo1 = ".$p[1];
		echo "<br>trozo2 = ".$p[2];
		echo "<br>trozo3 = ".$p[3];
		echo "<br>trozo4 = ".$p[4];
		echo "<br>trozo5 = ".$p[5];
		echo "<br>trozo6 = ".$p[6];
		echo "<br>trozo7 = ".$p[7];
		echo "<br>trozo8 = ".$p[8];
		echo "<br>trozo9 = ".$p[9];
		echo "<br>trozo10 = ".$p[10];

echo	$qry= "INSERT INTO archivo_01 VALUES (".$p[0].",".$p[1].",'".trim($p[2])."',".$p[3].",'".trim($p[4])."','".trim($p[5])."','".trim($p[6])."','".trim($p[7])."',".$p[8].",to_date('".$p[9]."','DD MM YYYY'),".$p[10].") ";
	$result= pg_exec($conn,$qry);

	}
	fclose ($fd);
	pg_close($conn);
	



?>