<?php require('../../../util/header.inc');?>
<?php

$frmModo = $_FRMMODO;


if ($frmModo == "ingresar"){
    $qry="INSERT INTO LIBRO (rbd,isbn,titulo,subtitulo,ano,nro_pag,notas,cod_edit,autor,edicion)
    VALUES ('$_INSTIT','$ISBN','$TITULO','$SUBTITULO','$ANO','0','$NOTA','$COD_EDIT','$AUTOR','$EDICION')";

    $result =pg_Exec($conn,$qry);

    if (!$result){
	   error('<b> ERROR :</b>Error al acceder a la BD. (3)');
    }
}




if ($frmModo == "modificar"){
  $qry="UPDATE LIBRO SET rbd='$_INSTIT', isbn = '$ISBN', titulo = '$TITULO', subtitulo = '$SUBTITULO', ano = '$ANO', nro_pag = '0', notas = '$NOTA', cod_edit = '$COD_EDIT', autor='$AUTOR', edicion = '$EDICION' where id = '$id_libro'";
   $result = pg_Exec($conn,$qry);
   
   if (!$result){
       error('<b>ERROR: </b>Error al acceder a la BD. (4)');
   }
}



echo "<script>window.location = 'listarLibros.php'</script>";
?>  