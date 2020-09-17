<?php

//print_r($_GET);

function mensaje($mensaje){


	echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"{$mensaje}\");
						</script>";	
	echo"<script>window.location = \"planificacion.php?id_ramo=".$id_ramo."\"</script>";
	exit;
}




if (!isset($archivo) || empty($archivo)) {
    exit();
}
$root = "archivos/";
$file = basename($archivo);
echo $path = $root.$file;
$type = '';
 
if (is_file($path)) {
    $size = filesize($path);
    if (function_exists('mime_content_type')) {
        $type = mime_content_type($path);
    } else if (function_exists('finfo_file')) {
        $info = finfo_open(FILEINFO_MIME);
        $type = finfo_file($info, $path);
        finfo_close($info); 
    }
    if ($type == '') {
        $type = "application/force-download";
    }
    // Set Headers
    header("Content-Type: $type");
    header("Content-Disposition: attachment; filename=$file");
  //  header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . $size);
    // Download File
    readfile($path);
} else {
    die("File not exist !!");
}
			
		?>

