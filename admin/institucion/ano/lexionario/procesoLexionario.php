<? 

require('../../../../util/header.inc');	

  /*echo "<pre>";
  print_r($_POST);
  echo "</pre>";*/


 $ano		=$_ANO;
 $curso		=$_REQUEST['curso'];
 $ramo		=$_REQUEST['ramo'];
 $fecha		=$_REQUEST['theDate'];
 $obser		=$_REQUEST['txt_obser'];
 $tipo		=$_REQUEST['cmb_tipo'];
 $nota		=$_REQUEST['cmb_nota'];
 $frmModo	=$_REQUEST['frmModo'];
 $id_lex	=$_REQUEST['idlex'];
 $nombre	=$_REQUEST['txt_tipo'];
 $id_periodo	=$_REQUEST['id_periodo'];

$fecha=fEs2En($fecha);
 
if($frmModo=="ingresar"){
	
$sql="INSERT into lexionario(id_ano,id_curso,id_ramo,fecha,descripcion,tipo,nota,id_periodo) values(".$ano.",".$curso.",".$ramo.",'".$fecha."','".utf8_decode($obser)."',".$tipo.",".$nota.",".$id_periodo.")";

}
if($frmModo=="modificar"){
	$sql="UPDATE lexionario SET  id_ano='".$ano."', fecha='".$fecha."', descripcion='".utf8_decode($obser)."', tipo='".$tipo."', nota='".$nota."',id_periodo=".$id_periodo." WHERE id_lexionario=$id_lex";
}
if($frmModo=="eliminar"){
	$sql="DELETE FROM lexionario WHERE id_lexionario = $_GET[id_lexi]";
}

if($frmModo=="ingresatipo"){
	$sql="INSERT into tipo_lexionario(id_curso,id_ramo,id_ano,nombre) values(".$curso.",".$ramo.",".$ano.",'".$nombre."')";
}

$rs_lexionario =pg_Exec($conn,$sql) or die ("fallo:".$sql);


if(!$rs_lexionario){
	echo "Error Base de Datos";
}else{
	echo 1;
}
/*echo "<script>window.location='listarlexionario.php'</script>";*/
pg_close($conn);


?>