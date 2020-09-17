<?php 
$sql_bor02="delete from archivo_02";
$sql_bor06="delete from archivo_06";
$sql_bor21="delete from archivo_21";
$sql_bor22="delete from archivo_22";
$sql_bor01="delete from archivo_01";
$sql_bor24="delete from archivo_24";
$sql_bor03="delete from archivo_03";
$sql_bor04="delete from archivo_04";
$sql_bor05="delete from archivo_05";
$result_02= @pg_exec($conn,$sql_bor02);
$result_06= @pg_exec($conn,$sql_bor06);
$result_21= @pg_exec($conn,$sql_bor21);
$result_22= @pg_exec($conn,$sql_bor22);
$result_01= @pg_exec($conn,$sql_bor01);
$result_24= @pg_exec($conn,$sql_bor24);
$result_03= @pg_exec($conn,$sql_bor03);
$result_04= @pg_exec($conn,$sql_bor04);
$result_05= @pg_exec($conn,$sql_bor05); 
?>