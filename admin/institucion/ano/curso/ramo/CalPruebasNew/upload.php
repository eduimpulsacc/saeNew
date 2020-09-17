<?php 
foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
   echo "<br>".$asignacion;
   
}
echo "arc->".$_FILES['file']['name'];

echo "lhkj hkjh";
?>