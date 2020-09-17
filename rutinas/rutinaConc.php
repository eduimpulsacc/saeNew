<?php $conn=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
$mes=7;
$rdb=24907;

if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 ||$mes==10 || $mes==12){
$fin=31;
}
elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
$fin=30;
}
elseif($mes==2){
$fin=(date("Y")%4==0)?29:28;
}

$qr_perfil="select p.id_perfil,p.nombre_perfil
from control_users cu inner join perfil p ON p.id_perfil=cu.id_perfil 
where cu.rdb_users=$rdb and date_part('year',cu.fecha)=".date("Y")." and date_part('month',cu.fecha)  between 3 and 7 group by 1,2 order by 2";

$rs_perfil=pg_exec($conn,$qr_perfil);
?>
<table border="1" cellpadding="0" style="font-family:calibri">
  <tr>
    <td>PERFIL</td>
   <?php for($f=1;$f<=$fin;$f++){ ?>
     <td><?php echo "$f/$mes/".date("Y") ?></td>
    <?php }?>
  </tr>
 <?php for($p=0;$p<pg_numrows($rs_perfil);$p++){
	 $fp = pg_fetch_array($rs_perfil,$p);
	 ?>
  <tr>
    <td><?php echo $fp['nombre_perfil'] ?></td>
   <?php for($f=1;$f<=$fin;$f++){?>
    <td>
    <?
		 $qr_calfecha="select count(*) cuenta 
from control_users cu inner join perfil p ON p.id_perfil=cu.id_perfil 
where cu.rdb_users=$rdb and date_part('year',cu.fecha)=".date("Y")." and date_part('month',cu.fecha)=$mes
and date_part('day',cu.fecha)=$f and p.id_perfil=".$fp['id_perfil'];
$rs_calfecha = pg_exec($conn,$qr_calfecha);
echo pg_result($rs_calfecha,0);
		 ?>
     </td>
    <?php }?>
  </tr>
 <?php  }?>
</table>


