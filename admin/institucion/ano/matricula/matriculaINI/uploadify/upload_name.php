<?php
//require('../../../../../clases/OpenConnect.php');
// JQuery File Upload Plugin v1.6.2 by RonnieSan - (C)2009 Ronnie Garcia
// Sample by Travis Nickels
session_start();
$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
	
	$sql_corp = "select num_corp from corp_instit where rdb = '".$_INSTIT."'";
		
	$res_corp = @pg_Exec($conn, $sql_corp);
	$num_corp = @pg_numrows($res_corp);
	
	if ($num_corp>0){  
	     $fil_corp = @pg_fetch_array($res_corp,0);
		 $corporacion = $fil_corp['num_corp'];
		 
		 if ($corporacion=="1" or $corporacion=="4" or $corporacion=="12"){
			$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");
		 }else{
			$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");	
		 }
	
	}
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';
	$targetPath = "../files/";
	//$newFileName = $_GET['name'].'_'.(($_GET['location'] != '')?$_GET['location'].'_':'').$_FILES['Filedata']['name'];
	$tiempo      = time();
	$newFileName = $tiempo.".xls";
	$targetFile =  str_replace('//','/',$targetPath) . $newFileName;
	//$nombre = $_GET['name'].'_'.$_FILES['Filedata']['name'];
	
	$sql = "INSERT INTO tmp_matricula (rdb,nombre) VALUES (".$_GET['name'].",'".trim($newFileName)."')";
	$rs_tmp = pg_exec($conn,$sql);
	
	// Uncomment the following line if you want to make the directory if it doesn't exist
	// mkdir(str_replace('//','/',$targetPath), 0755, true);
	
	move_uploaded_file($tempFile,$targetFile);
}

if ($newFileName)
	echo $newFileName;
else // Required to trigger onComplete function on Mac OSX
	echo '1';

?>