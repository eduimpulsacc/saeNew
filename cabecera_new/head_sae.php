<?
$fecha=date("m-d-Y");
$sql="select count(*) from control_users WHERE rdb_users=".$_INSTIT." and fecha='".$fecha."'";
$rs_visitas = pg_Exec($connection,$sql);
$cant_visitas = pg_result($rs_visitas,0);

for($i=0;$i<$_POSP;$i++){
	$url.="../";	
}

?>


<body>
<div id="arriba">
    <div id="arriba_1">
      <table width="1151" height="70" border="0">
  <tr>
    <th width="230" scope="col"><img src="<?=$url;?>cabecera_new/img/bot_home.jpg" width="207" height="63" border="0" align="left" usemap="#Map" /></th>
    <th width="637" scope="col">&nbsp;</th>
    <th width="270" scope="col"><?=$cant_visitas;?></th>
  </tr>
</table>
    </div>
    <div id="arriba_2">
    <table width="1151" height="160" border="0">
  <tr>
    <th width="415" height="155" scope="col"><img src="<?=$url;?>/cabecera_new/img/grenoble.jpg" width="415" height="147" /></th>
    <th width="719" height="155" scope="col"><img src="<?=$url;?>cabecera_new/img/logo_sae.jpg" width="719" height="149" /></th>
  </tr>
</table>
    </div>   
	</div> 
		<!--cierre head-->



<map name="Map" id="Map">
  <area shape="rect" coords="34,-1,189,53" href="../../admin/institucion/institucion.php3" />
</map>
