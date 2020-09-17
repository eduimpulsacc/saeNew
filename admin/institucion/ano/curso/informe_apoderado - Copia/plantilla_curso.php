<?php 
require('../../../../../util/header.inc');
$institucion =$_INSTIT;
$ano		 =$_ANO;
$_POSP       =5;
$_bot        =5;

?>
<html>
<head><title></title>

</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><!-- Aqui nuevo codigo -->
        <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
         <tr class="tablatit2-1">
            <td width="20%">&nbsp;&nbsp;ALUMNO&nbsp;&nbsp; </td>
            <td width="80%" valign="top">
			
			    <div id="contEncCol">
                  <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                </div>
			
		   </td>
          </tr>
          <tr>
            <td width="300" valign="top" valing=top>
			<div id="contEncFil">
			    <?
				$q1 = "select * from alumno where rut_alumno in (select rut_alumno from matricula where rdb = '".trim($_INSTIT)."' and id_ano = '".trim($_ANO)."' and id_curso = '".trim($_CURSO)."') order by ape_pat";
			    $r1 = pg_Exec($conn,$q1);
				$n1 = pg_numrows($r1);
				
				$i = 0;
				while ($i < $n1){ 
				    $f1 = pg_fetch_array($r1,$i);
				    $nombre = $f1['ape_pat'];
					$nombre.= $f1['ape_mat'];
					$nombre.= $f1['nombre_alu'];					
					?>
                    <table width="100%" border="1">
				      <tr>
				      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$nombre ?> </font></td></tr>
			 	    </table>	
					<?
					$i++;
				}
				?>	
            </div>
			</td>
            <td valign="top"><div id="contenedor" onscroll="desplaza()">
              <table width="100%" border="1" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </div></td>
          
          </tr>
        </table>
      <!-- fin codigo -->
    </td>
  </tr>
  <tr>
    <td>Aqu&iacute; informe </td>
  </tr>
</table>
</body>
</html>