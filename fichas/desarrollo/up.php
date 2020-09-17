<?php require('../../util/header.inc');?>

<?php 

	$institucion	=$_INSTIT;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<title>Documento sin t&iacute;tulo</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript" type="text/JavaScript">
<!--




function MM_preloadImages() { //v3.0

  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();

    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)

    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}

}
//-->
</script>

</head>



<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('imag/proyecto2.gif')">

<table width="780" height="118" border="0" cellpadding="0" cellspacing="0">

  <tr> 

   <?php						

						$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);

						$arr=@pg_fetch_array($result,0);



						$output= "select lo_export(".$arr[insignia].",'/var/www/html/tmp/".$arr[rdb]."');";

						$retrieve_result = @pg_exec($conn,$output);

					?>

    <td width="161" height="75"><div align="center"><img src=../../../../tmp/<?php echo $arr[rdb] ?> ALT="NO DISPONIBLE"width="60"></div></td>

    <td width="619" height="75"><table width="739" height="75" border="0" cellpadding="0" cellspacing="0">

        <tr> 

          <td width="739" height="48" align="right" valign="top"> <blockquote> 

              <blockquote> 

                <blockquote>

                  <p><font color="#999999" size="1" face="Geneva, Arial, Helvetica, sans-serif">Resoluci&oacute;n 

                    &oacute;ptima 1024 x 768 p&iacute;xeles</font></p>

                </blockquote>

              </blockquote>

            </blockquote></td>

        </tr>

            <tr> 

          <td width="619" height="27"><table width="21" height="27" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="21" height="27">&nbsp;</td>
              </tr>
            </table></td>

        </tr>

      </table></td>

  </tr>

  <tr> 

    <td width="161" height="43"><img src="imag/fondobandera.gif" width="161" height="43"></td>

    <td width="619" height="43"><img src="imag/up_desarrollo.jpg" width="739" height="43"></td>

  </tr>

</table>

</body>

</html>

