<?

if (isset($_GET[arr_rdb]))
            
 
{
            
 
      $a=stripslashes ($_GET[arr_rdb]);
            
 
      $mi_array=unserialize($a);
            
 
      foreach ($mi_array AS $clave => $valor)
            
 
              echo "$clave ----> $valor <br>";
            
 
}


if (isset($_GET[arr_mat_mes]))
            
 
{
            
 
      $a=stripslashes ($_GET[arr_mat_mes]);
            
 
      $mi_array=unserialize($a);
            
 
      foreach ($mi_array AS $clave => $valor)
            
 
              echo "$clave ----> $valor <br>";
            
 
}       
 

?>
