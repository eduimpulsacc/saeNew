<?
$fecha=date("m-d-Y");
$sql="select count(*) from control_users WHERE rdb_users=".$_INSTIT." and fecha='".$fecha."'";
$rs_visitas = pg_Exec($connection,$sql);
$cant_visitas = pg_result($rs_visitas,0);


?>


<body>
<div id="arriba"  align="center" style="width:100%">
    <div id="arriba_1"  style="width:100%">
      <table width="100%" height="70" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <th width="2%" align="left" valign="top" style="background-image:url(../../cabecera_new/img/fo.jpg)"><img src="../../cabecera_new/img/p7.jpg"  ></th>
    <th width="8%" align="right" valign="top" style="background-image:url(../../cabecera_new/img/fo.jpg)" ><span ><a href="../../admin/institucion/institucion.php3"><img src="../../cabecera_new/img/bt3.png"  style="border:0;margin-top:4px;cursor:pointer"  ></a></span></th>
    <th width="36%" style="background-image:url(../../cabecera_new/img/fo.jpg)" align="center" valign="middle" ><img src="../../cabecera_new/img/m4.jpg"></th>
    <th width="40%" style="background-image:url(../../cabecera_new/img/fo.jpg)" align="right"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="../../cabecera_new/img/m7.jpg"></td>
    <td width="80" align="center"><?=$cant_visitas?></td>
    <td><img src="../../cabecera_new/img/m6.jpg"></td>
  </tr>
</table>
</th>
    <th width="2%" align="right" style="background-image:url(../../cabecera_new/img/fo.jpg)"><img src="../../cabecera_new/img/p8.jpg" ></th>
  
  </tr>
</table>
    </div>
    <div id="arriba_2" style="width:100%">
    <table width="100%" height="160" border="0">
  <tr>
    <th width="20%" height="155" scope="col" align="left" style="padding-left:10px"><img src="../../tmp/<?php echo $_INSTIT ?>insignia" height="149" /></th>
    <th width="80%" height="155" scope="col" align="left"><img src="../../cabecera_new/img/logo_sae.jpg" width="719" height="149" /></th>
  </tr>
</table>
    </div>   
	</div> 
<!--cierre head-->