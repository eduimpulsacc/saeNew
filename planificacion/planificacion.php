<?php 
require("../util/header.php");
session_start();

if(!session_is_registered('_CURSO')){
  session_register('_CURSO');
};	

if(!session_is_registered('_ANO')){
  session_register('_ANO');
};	

if(!session_is_registered('_MENU')){
  session_register('_MENU');
};

if(!session_is_registered('_CATEGORIA')){
  session_register('_CATEGORIA');
};

if(!session_is_registered('_IDR')){
  session_register('_IDR');
};

if(!session_is_registered('_DOCRAMO')){
  session_register('_DOCRAMO');
};

if(!session_is_registered('_SUBRAMO')){
  session_register('_SUBRAMO');
};

if(!session_is_registered('_RAMO')){
  session_register('_RAMO');
};	

 $sql_ramo ="select r.id_ramo,r.cod_subsector,d.rut_emp from ramo r inner join dicta d on d.id_ramo = r.id_ramo  where r.id_ramo = $id_ramo";
$rs_ramo = pg_exec($conn,$sql_ramo);
$fila_ramo = pg_fetch_array($rs_ramo,0);



$_IDR=$fila_ramo['id_ramo'];
$_DOCRAMO=$fila_ramo['rut_emp'];
$_SUBRAMO=$fila_ramo['cod_subsector'];
//echo "--". 
$_RAMO=$fila_ramo['id_ramo'];		
//exit;
?>
<script language="javascript">window.location="unidad/unidad.php"</script>