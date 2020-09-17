<? 

require('../../../../util/header.inc');	

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

 
if($frmModo=="ingresar"){
$sql="INSERT into lexionario(id_ano,id_curso,id_ramo,fecha,descripcion,tipo,nota) values(".$ano.",".$curso.",".$ramo.",'".$fecha."','".$obser."',".$tipo.",".$nota.")";

}
if($frmModo=="modificar"){
	$sql="UPDATE lexionario SET  id_ano='".$ano."', fecha='".$fecha."', descripcion='".$obser."', tipo='".$tipo."', nota='".$nota."' WHERE id_lexionario=$id_lex";
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