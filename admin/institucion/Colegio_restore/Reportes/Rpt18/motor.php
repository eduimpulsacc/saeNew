    <? include"../Coneccion/conexion.php" ;
	require('../../../../../util/LlenarCombo.php3');
	require('../../../../../util/SeleccionaCombo.inc');

	$li_institucion	= $_INSTIT;
	
 $qryAno = "select * from ano_escolar where id_institucion=".$li_institucion;
    $resultA = pg_exec($conexion,$qryAno);
	$filaA = @pg_fetch_array($resultA,i);
	$ano = $fila['id_ano'];
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
.Estilo2 {
	color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
-->
</style>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_ano.value!=0){
				form.cmb_ano.target="self";
				form.action = 'motor.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			
			function MM_goToURL() { //v3.0
  				var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
 			    for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
			
</script>

<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>

<form method "post" action="">
<? 
?>
<center>
<table width="53%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="" height="12" bgcolor="#003b85">
<div align="center" class="titulosMotores"><span>Buscador 
                  Avanzado </span></div></td>
  </tr>
  <tr>
    <td height="22">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="30"><font size="1" face="arial, geneva, helvetica"><span>AÑO</span></font></td>
                    <td width="144"> <div align="left"> <font size="1" face="arial, geneva, helvetica"> 
                        <select name="cmb_ano" class="ddlb_9_x"onChange="enviapag(this.form);">
                          <option value=0 selected>(Año)</option>
                          <?
		   $qryAno = "select * from ano_escolar where id_institucion=".$li_institucion." order by nro_ano asc";
   			 $resultA = pg_exec($conexion,$qryAno);

		  for($i=0 ; $i < @pg_numrows($resultA) ; $i++)
		  {
		  $filaA = @pg_fetch_array($resultA,$i); 
		  if ($filaA["id_ano"]==$cmb_ano){
			echo  "<option selected value=".$filaA["id_ano"]." >".$filaA['nro_ano'] ."</option>";
  		  }else{
			echo  "<option  value=".$filaA["id_ano"]." >".$filaA['nro_ano'] ."</option>";
		  }

          } ?>
                        </select>
                        </font> </div></td>
						                    <td width="54"><font size="1" face="arial, geneva, helvetica"><span>ALUMNO</span></font></td>
                    <td width="172"> <div align="left"> 
                        <select name="cmb_alumno" class="ddlb_9_x">
                          <!--option value=0 selected>(Alumnos)</option-->
                          <?
$sql= " select alumno.rut_alumno as rut, alumno.dig_rut, alumno.nombre_alu, ";
$sql = $sql . " alumno.ape_pat, alumno.ape_mat";
$sql = $sql . " from alumno, matricula";
$sql = $sql . " where alumno.rut_alumno = matricula.rut_alumno ";
$sql = $sql . " and matricula.rdb = $li_institucion ";
$sql = $sql . " and matricula.id_ano =".$cmb_ano."";
$sql = $sql . " order by alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat"; 

$resultado_query_cue = pg_exec($conexion,$sql);
		for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
			$filaC = pg_fetch_array($resultado_query_cue,$i);?>
                          <option value="<? echo $filaC["rut"]; ?>"><? echo $filaC["nombre_alu"], " ",$filaC["ape_pat"]," ",$filaC["ape_mat"];?></option>
                          <?
		}
		?>
                        </select>
                        <?php //echo $sql; ?>
                      </div>
                    </td>

                    <td width="295"><div align="center"> 
                        <input name="cb_ok" class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' type= "button" onClick="MM_goToURL('parent.frames[\'result\']','rpt18.php?as_institucion=<?=($li_institucion)?>&as_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&ai_ano='+cmb_ano.options[cmb_ano.selectedIndex].value);return document.MM_returnValue" value="Buscar">
						                        <!--input name="cb_ok" class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' type= "button" onClick="MM_goToURL('parent.frames[\'result\']','Rpt14_pro.php?as_institucion=<? echo $li_institucion;?>&as_alumno=<?php echo //$cmb_alumno;?>&ai_ano=<?php echo //$cmb_ano;?>);return document.MM_returnValue"  value="Buscar"-->
                      </div></td>
                  </tr>
                  <tr> 
                  </tr>
                </table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>
</body>
</html>

