<?php require('../../../../util/header.inc');?>
<? function saca_dv($r)
{
	$r=$r."9";
	$r=strtoupper(ereg_replace('\.|,|-','',$r));
	$sub_rut=substr($r,0,strlen($r)-1);
 	$sub_dv=substr($r,-1);
	$x=2;
	$s=0;
	for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
	{
		if ( $x >7 )
		{
			$x=2;
		}
		$s += $sub_rut[$i]*$x;
		$x++;
	}
	$dv=11-($s%11);
	if ( $dv==10 )
	{
		$dv='K';
	}
	if ( $dv==11 )
	{
		$dv='0';
	}
	return $dv;
	
	}

?>
<? 

function genera_rut(){
global $conn;


	$rut=rand(50000000,99999999);
	//echo $rut."<br>";
	$dv=saca_dv($rut);
	$query_val="select * from alumno where rut_alumno='$rut'";
	$result_val=pg_exec($conn,$query_val);
	$num_val=pg_numrows($result_val);
	if ($num_val>0){
		echo "ya esta";
		$sw=1;
		genera_rut();
	}else{
		return $text=$rut."-".$dv;
	}
	
}
$nuevo=genera_rut();
$arr=explode("-",$nuevo);
$rut=$arr[0];
$dv=$arr[1];
?>
<script>
window.opener.document.frm.txtRUT.value='<? echo $rut;?>';
window.opener.document.frm.txtDIGRUT.value='<? echo $dv;?>';
//window.parent.frm.txtRUT.value='<? echo $rut;?>';
//window.parent.frm.txtDIGRUT.value='<? echo $dv;?>';
window.close();
</script>